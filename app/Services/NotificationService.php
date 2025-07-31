<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Send notification when new report is created
     */
    public function newReportNotification($report)
    {
        // Notify admins and KIA members
        $recipients = User::whereIn('role', ['admin', 'kia_member'])->get();

        foreach ($recipients as $user) {
            Notification::create([
                'user_id' => $user->id,
                'report_id' => $report->id,
                'type' => 'new_report',
                'title' => 'Laporan Baru',
                'message' => "Laporan baru telah diajukan: {$report->title}",
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Send notification when report status is updated
     */
    public function reportStatusUpdated($report, $oldStatus, $newStatus)
    {
        // Notify report creator
        if ($report->reporter_id) {
            Notification::create([
                'user_id' => $report->reporter_id,
                'report_id' => $report->id,
                'type' => 'report_updated',
                'title' => 'Status Laporan Diperbarui',
                'message' => "Status laporan Anda berubah dari '{$oldStatus}' menjadi '{$newStatus}'",
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Send notification when investigation is started
     */
    public function investigationStarted($investigation)
    {
        // Notify report creator
        if ($investigation->report && $investigation->report->reporter_id) {
            Notification::create([
                'user_id' => $investigation->report->reporter_id,
                'report_id' => $investigation->report_id,
                'type' => 'investigation_started',
                'title' => 'Investigasi Dimulai',
                'message' => "Investigasi telah dimulai untuk laporan: {$investigation->report->title}",
                'sent_at' => now()
            ]);
        }

        // Notify assigned investigators
        if ($investigation->investigationTeam) {
            foreach ($investigation->investigationTeam as $teamMember) {
                if ($teamMember->investigator_id) {
                    Notification::create([
                        'user_id' => $teamMember->investigator_id,
                        'report_id' => $investigation->report_id,
                        'type' => 'investigation_started',
                        'title' => 'Assignment Investigasi Baru',
                        'message' => "Anda ditugaskan untuk investigasi: {$investigation->report->title}",
                        'sent_at' => now()
                    ]);
                }
            }
        }
    }

    /**
     * Send notification when investigation is completed
     */
    public function investigationCompleted($investigation)
    {
        // Notify KIA members and admins
        $recipients = User::whereIn('role', ['admin', 'kia_member'])->get();

        foreach ($recipients as $user) {
            Notification::create([
                'user_id' => $user->id,
                'report_id' => $investigation->report_id,
                'type' => 'investigation_completed',
                'title' => 'Investigasi Selesai',
                'message' => "Investigasi telah selesai untuk: {$investigation->report->title}",
                'sent_at' => now()
            ]);
        }

        // Notify report creator
        if ($investigation->report && $investigation->report->reporter_id) {
            Notification::create([
                'user_id' => $investigation->report->reporter_id,
                'report_id' => $investigation->report_id,
                'type' => 'investigation_completed',
                'title' => 'Investigasi Selesai',
                'message' => "Investigasi untuk laporan Anda telah selesai",
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Send notification when appeal is submitted
     */
    public function appealSubmitted($appeal)
    {
        // Notify KIA members and admins
        $recipients = User::whereIn('role', ['admin', 'kia_member'])->get();

        foreach ($recipients as $user) {
            Notification::create([
                'user_id' => $user->id,
                'report_id' => $appeal->report_id,
                'type' => 'appeal_submitted',
                'title' => 'Banding Baru',
                'message' => "Banding baru telah diajukan oleh {$appeal->appellant->name}",
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Send notification when appeal is reviewed
     */
    public function appealReviewed($appeal)
    {
        // Notify appellant
        Notification::create([
            'user_id' => $appeal->appellant_id,
            'report_id' => $appeal->report_id,
            'type' => 'appeal_reviewed',
            'title' => 'Hasil Review Banding',
            'message' => "Banding Anda telah direview dengan status: {$appeal->appeal_status}",
            'sent_at' => now()
        ]);
    }

    /**
     * Send notification when penalty is assigned
     */
    public function penaltyAssigned($penalty)
    {
        // Notify the person who gets the penalty
        if ($penalty->user_id) {
            Notification::create([
                'user_id' => $penalty->user_id,
                'report_id' => $penalty->report_id,
                'type' => 'penalty_assigned',
                'title' => 'Sanksi Diberikan',
                'message' => "Anda telah diberikan sanksi: {$penalty->penaltyLevel->name}",
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Send system notification
     */
    public function systemNotification($userId, $title, $message, $reportId = null)
    {
        Notification::create([
            'user_id' => $userId,
            'report_id' => $reportId,
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'sent_at' => now()
        ]);
    }

    /**
     * Send notification to multiple users
     */
    public function sendToMultipleUsers($userIds, $type, $title, $message, $reportId = null)
    {
        foreach ($userIds as $userId) {
            Notification::create([
                'user_id' => $userId,
                'report_id' => $reportId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'sent_at' => now()
            ]);
        }
    }

    /**
     * Send notification to users by role
     */
    public function sendToRole($roles, $type, $title, $message, $reportId = null)
    {
        $users = User::whereIn('role', (array) $roles)->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'report_id' => $reportId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'sent_at' => now()
            ]);
        }
    }
}
