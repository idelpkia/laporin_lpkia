<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Investigation;
use App\Models\Appeal;
use App\Models\Penalty;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Handle global search from header
     */
    public function globalSearch(Request $request)
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'results' => [],
                'histories' => $this->getSearchHistories()
            ]);
        }

        $results = [
            'reports' => $this->searchReports($query),
            'users' => $this->searchUsers($query),
            'investigations' => $this->searchInvestigations($query),
            'appeals' => $this->searchAppeals($query),
            'penalties' => $this->searchPenalties($query)
        ];

        // Save to search history
        $this->saveSearchHistory($query);

        return response()->json([
            'results' => $results,
            'histories' => $this->getSearchHistories(),
            'query' => $query
        ]);
    }

    /**
     * Search Reports
     */
    private function searchReports($query)
    {
        $reports = Report::where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('incident_location', 'LIKE', "%{$query}%");
        })
            ->with(['reporter', 'reportedUser'])
            ->limit(5)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title ?: "Laporan #{$report->id}",
                    'description' => Str::limit($report->description, 60),
                    'url' => route('reports.show', $report->id),
                    'icon' => 'fas fa-file-alt',
                    'color' => 'primary',
                    'meta' => $report->created_at->format('d M Y'),
                    'status' => $report->status,
                    'reporter' => $report->reporter->name ?? 'Anonymous'
                ];
            });

        return $reports;
    }

    /**
     * Search Users (only for certain roles)
     */
    private function searchUsers($query)
    {
        // Only admin and kia_member can search users
        if (!in_array(Auth::user()->role, ['admin', 'kia_member'])) {
            return collect([]);
        }

        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('student_id', 'LIKE', "%{$query}%")
                ->orWhere('employee_id', 'LIKE', "%{$query}%");
        })
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'title' => $user->name,
                    'description' => $user->email,
                    'url' => '#', // route('users.show', $user->id) if exists
                    'icon' => 'fas fa-user',
                    'color' => 'info',
                    'meta' => ucfirst($user->role),
                    'avatar' => $user->avatar ?? asset('img/avatar/avatar-1.png')
                ];
            });

        return $users;
    }

    /**
     * Search Investigations
     */
    private function searchInvestigations($query)
    {
        $investigations = Investigation::whereHas('report', function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->orWhere('findings', 'LIKE', "%{$query}%")
            ->orWhere('recommendations', 'LIKE', "%{$query}%")
            ->with('report')
            ->limit(5)
            ->get()
            ->map(function ($investigation) {
                return [
                    'id' => $investigation->id,
                    'title' => "Investigasi: " . ($investigation->report->title ?? "Laporan #{$investigation->report_id}"),
                    'description' => Str::limit($investigation->findings, 60),
                    'url' => route('investigations.show', $investigation->id),
                    'icon' => 'fas fa-search',
                    'color' => 'warning',
                    'meta' => $investigation->created_at->format('d M Y'),
                    'status' => $investigation->status
                ];
            });

        return $investigations;
    }

    /**
     * Search Appeals
     */
    private function searchAppeals($query)
    {
        $appeals = Appeal::where('appeal_reason', 'LIKE', "%{$query}%")
            ->orWhere('review_result', 'LIKE', "%{$query}%")
            ->orWhereHas('report', function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%");
            })
            ->with(['report', 'appellant'])
            ->limit(5)
            ->get()
            ->map(function ($appeal) {
                return [
                    'id' => $appeal->id,
                    'title' => "Banding: " . ($appeal->report->title ?? "Laporan #{$appeal->report_id}"),
                    'description' => Str::limit($appeal->appeal_reason, 60),
                    'url' => route('appeals.show', $appeal->id),
                    'icon' => 'fas fa-gavel',
                    'color' => 'secondary',
                    'meta' => $appeal->created_at->format('d M Y'),
                    'status' => $appeal->appeal_status,
                    'appellant' => $appeal->appellant->name ?? 'Unknown'
                ];
            });

        return $appeals;
    }

    /**
     * Search Penalties
     */
    private function searchPenalties($query)
    {
        // Only certain roles can search penalties
        if (!in_array(Auth::user()->role, ['admin', 'kia_member'])) {
            return collect([]);
        }

        $penalties = Penalty::whereHas('user', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%");
        })
            ->orWhereHas('report', function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%");
            })
            ->with(['user', 'report', 'penaltyLevel'])
            ->limit(5)
            ->get()
            ->map(function ($penalty) {
                return [
                    'id' => $penalty->id,
                    'title' => "Sanksi: " . ($penalty->penaltyLevel->name ?? 'N/A'),
                    'description' => "Untuk: " . ($penalty->user->name ?? 'N/A'),
                    'url' => '#', // route('penalties.show', $penalty->id) if exists
                    'icon' => 'fas fa-exclamation-triangle',
                    'color' => 'danger',
                    'meta' => $penalty->created_at->format('d M Y'),
                    'status' => $penalty->status
                ];
            });

        return $penalties;
    }

    /**
     * Save search query to history (in session for simplicity)
     */
    private function saveSearchHistory($query)
    {
        $histories = session()->get('search_histories', []);

        // Remove if already exists
        $histories = array_filter($histories, function ($item) use ($query) {
            return $item !== $query;
        });

        // Add to beginning
        array_unshift($histories, $query);

        // Keep only last 5
        $histories = array_slice($histories, 0, 5);

        session()->put('search_histories', $histories);
    }

    /**
     * Get search histories
     */
    private function getSearchHistories()
    {
        return session()->get('search_histories', []);
    }

    /**
     * Clear search history
     */
    public function clearHistory()
    {
        session()->forget('search_histories');

        return response()->json(['success' => true]);
    }

    /**
     * Remove specific history item
     */
    public function removeHistory(Request $request)
    {
        $query = $request->get('query');
        $histories = session()->get('search_histories', []);

        $histories = array_filter($histories, function ($item) use ($query) {
            return $item !== $query;
        });

        session()->put('search_histories', array_values($histories));

        return response()->json(['success' => true]);
    }

    /**
     * Get quick access items based on user role
     */
    public function getQuickAccess()
    {
        $user = Auth::user();
        $quickAccess = [];

        switch ($user->role) {
            case 'admin':
                $quickAccess = [
                    ['title' => 'Dashboard Admin', 'url' => route('dashboard'), 'icon' => 'fas fa-tachometer-alt', 'color' => 'primary'],
                    ['title' => 'Semua Laporan', 'url' => route('reports.index'), 'icon' => 'fas fa-file-alt', 'color' => 'info'],
                    ['title' => 'Manajemen User', 'url' => '#', 'icon' => 'fas fa-users', 'color' => 'success'],
                    ['title' => 'Pengaturan Sistem', 'url' => '#', 'icon' => 'fas fa-cog', 'color' => 'warning']
                ];
                break;

            case 'kia_member':
                $quickAccess = [
                    ['title' => 'Review Laporan', 'url' => route('reports.index'), 'icon' => 'fas fa-clipboard-check', 'color' => 'primary'],
                    ['title' => 'Investigasi Aktif', 'url' => route('investigations.index'), 'icon' => 'fas fa-search', 'color' => 'warning'],
                    ['title' => 'Banding Pending', 'url' => route('appeals.index'), 'icon' => 'fas fa-gavel', 'color' => 'info']
                ];
                break;

            case 'investigator':
                $quickAccess = [
                    ['title' => 'Tugas Investigasi', 'url' => route('investigations.index'), 'icon' => 'fas fa-search', 'color' => 'warning'],
                    ['title' => 'Laporan Saya', 'url' => route('reports.index'), 'icon' => 'fas fa-file-alt', 'color' => 'info']
                ];
                break;

            default:
                $quickAccess = [
                    ['title' => 'Laporan Saya', 'url' => route('reports.index'), 'icon' => 'fas fa-file-alt', 'color' => 'primary'],
                    ['title' => 'Buat Laporan', 'url' => route('reports.create'), 'icon' => 'fas fa-plus', 'color' => 'success'],
                    ['title' => 'Status Banding', 'url' => route('appeals.index'), 'icon' => 'fas fa-gavel', 'color' => 'info']
                ];
                break;
        }

        return response()->json(['quick_access' => $quickAccess]);
    }
}
