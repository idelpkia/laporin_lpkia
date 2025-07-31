<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Get notifications for authenticated user
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('report')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'notifications' => $notifications->items(),
                'unread_count' => $this->getUnreadCount()
            ]);
        }

        return view('pages.notifications.index', compact('notifications'));
    }

    /**
     * Get notifications for header dropdown (AJAX)
     */
    public function getHeaderNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('report')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'report_id' => $notification->report_id,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at,
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'icon' => $this->getNotificationIcon($notification->type),
                    'color' => $this->getNotificationColor($notification->type),
                    'url' => $this->getNotificationUrl($notification)
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $this->getUnreadCount()
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($notification && !$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'unread_count' => $this->getUnreadCount()
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        return Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }

    /**
     * Get notification icon based on type
     */
    private function getNotificationIcon($type)
    {
        $icons = [
            'new_report' => 'fas fa-file-alt',
            'report_updated' => 'fas fa-edit',
            'investigation_started' => 'fas fa-search',
            'investigation_completed' => 'fas fa-check-circle',
            'appeal_submitted' => 'fas fa-gavel',
            'appeal_reviewed' => 'fas fa-balance-scale',
            'penalty_assigned' => 'fas fa-exclamation-triangle',
            'system' => 'fas fa-bell',
            'email' => 'fas fa-envelope',
            'sms' => 'fas fa-sms'
        ];

        return $icons[$type] ?? 'fas fa-bell';
    }

    /**
     * Get notification color based on type
     */
    private function getNotificationColor($type)
    {
        $colors = [
            'new_report' => 'primary',
            'report_updated' => 'info',
            'investigation_started' => 'warning',
            'investigation_completed' => 'success',
            'appeal_submitted' => 'secondary',
            'appeal_reviewed' => 'info',
            'penalty_assigned' => 'danger',
            'system' => 'primary',
            'email' => 'info',
            'sms' => 'success'
        ];

        return $colors[$type] ?? 'primary';
    }

    /**
     * Get notification URL based on type and related data
     */
    private function getNotificationUrl($notification)
    {
        switch ($notification->type) {
            case 'new_report':
            case 'report_updated':
                return $notification->report_id ? route('reports.show', $notification->report_id) : '#';

            case 'investigation_started':
            case 'investigation_completed':
                return $notification->report_id ? route('investigations.show', $notification->report_id) : '#';

            case 'appeal_submitted':
            case 'appeal_reviewed':
                // Assuming you have appeals route
                return $notification->report_id ? route('appeals.index') : '#';

            case 'penalty_assigned':
                return $notification->report_id ? route('penalties.index') : '#';

            default:
                return '#';
        }
    }

    /**
     * Create notification helper method
     */
    public static function create($userId, $type, $title, $message, $reportId = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'report_id' => $reportId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'sent_at' => now()
        ]);
    }
}
