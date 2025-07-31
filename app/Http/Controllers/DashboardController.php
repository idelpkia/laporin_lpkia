<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\Investigation;
use App\Models\Notification;
use App\Models\Penalty;
use App\Models\Report;
use App\Models\User;
use App\Models\WorkflowLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Route to dashboard sesuai role
        switch ($user->role) {
            case 'admin':
                return $this->admin();
            case 'kia_member':
                return $this->kia();
            case 'investigator':
                return $this->investigator();
            default: // student, lecturer, staff, external, etc
                return $this->pelapor();
        }
    }

    // ========== Dashboard Admin ==========
    public function admin()
    {
        // Statistik
        $totalReports = Report::count();
        $activeInvestigations = Investigation::where('status', '!=', 'completed')->count();
        $totalUsers = User::count();
        $totalPenalties = Penalty::count();

        // Chart data
        $reportChartLabels = Report::selectRaw('DATE_FORMAT(created_at, "%b %Y") as bulan')
            ->groupBy('bulan')->orderByRaw('MIN(created_at)')->pluck('bulan');
        $reportChartData = Report::selectRaw('COUNT(*) as total, DATE_FORMAT(created_at, "%b %Y") as bulan')
            ->groupBy('bulan')->orderByRaw('MIN(created_at)')->pluck('total');

        $investigationStatusLabels = Investigation::select('status')->groupBy('status')->pluck('status');
        $investigationStatusData = $investigationStatusLabels->map(function ($status) {
            return Investigation::where('status', $status)->count();
        });

        $recentActivities = WorkflowLog::with('actionBy')->latest()->take(10)->get();

        return view('pages.dashboard.admin', compact(
            'totalReports',
            'activeInvestigations',
            'totalUsers',
            'totalPenalties',
            'reportChartLabels',
            'reportChartData',
            'investigationStatusLabels',
            'investigationStatusData',
            'recentActivities'
        ));
    }

    // ========== Dashboard KIA Member ==========
    public function kia()
    {
        $incomingReports = Report::where('status', 'submitted')->count();
        $pendingValidations = Report::where('status', 'submitted')->count();
        $activeInvestigations = Investigation::where('status', '!=', 'completed')->count();
        $penaltiesToSet = Penalty::where('status', 'recommended')->count();

        $recentReports = Report::with('reporter')->latest()->take(5)->get();
        $activeInvestigationsTable = Investigation::with('report', 'teamLeader')->where('status', '!=', 'completed')->latest()->take(5)->get();
        $notifications = Notification::where('user_id', auth()->id())->latest()->take(5)->get();

        return view('pages.dashboard.kia', compact(
            'incomingReports',
            'pendingValidations',
            'activeInvestigations',
            'penaltiesToSet',
            'recentReports',
            'activeInvestigationsTable',
            'notifications'
        ));
    }

    // ========== Dashboard Investigator ==========
    public function investigator()
    {
        $user = auth()->user();

        // Investigasi yang menjadi bagian tim/leader
        $myInvestigations = Investigation::with(['report', 'teamLeader'])
            ->whereHas('investigationTeams', function ($q) use ($user) {
                $q->where('member_id', $user->id);
            })
            ->orWhere('team_leader_id', $user->id)
            ->latest()->get();

        $totalInvestigations = $myInvestigations->count();
        $activeInvestigations = $myInvestigations->where('status', '!=', 'completed')->count();
        $completedInvestigations = $myInvestigations->where('status', 'completed')->count();

        $myActivities = $user->investigationActivities()->latest()->take(5)->get();
        // return $myActivities;
        $notifications = Notification::where('user_id', $user->id)->latest()->take(5)->get();

        return view('pages.dashboard.investigator', compact(
            'totalInvestigations',
            'activeInvestigations',
            'completedInvestigations',
            'myInvestigations',
            'myActivities',
            'notifications'
        ));
    }

    // ========== Dashboard Pelapor ==========
    public function pelapor()
    {
        $user = auth()->user();

        // Laporan milik user login
        $myReports = Report::with('appeals')->where('reporter_id', $user->id)->latest()->get();
        $myReportsCount = $myReports->count();
        $myInvestigationCount = $myReports->where('status', 'under_investigation')->count();
        $myCompletedCount = $myReports->where('status', 'completed')->count();

        // Banding yang diajukan
        $myAppeals = Appeal::where('appellant_id', $user->id)->with('report')->latest()->get();
        $notifications = Notification::where('user_id', $user->id)->latest()->take(5)->get();

        return view('pages.dashboard.pelapor', compact(
            'myReports',
            'myReportsCount',
            'myInvestigationCount',
            'myCompletedCount',
            'myAppeals',
            'notifications'
        ));
    }
}
