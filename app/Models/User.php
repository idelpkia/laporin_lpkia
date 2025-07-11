<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'department',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke report yang dilaporkan
    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function committeeMembers()
    {
        return $this->hasMany(CommitteeMember::class);
    }

    // Relasi ke investigasi sebagai ketua tim
    public function leadInvestigations()
    {
        return $this->hasMany(Investigation::class, 'team_leader_id');
    }

    // Relasi ke investigationTeams sebagai member
    public function investigationTeams()
    {
        return $this->hasMany(InvestigationTeam::class, 'member_id');
    }

    // Relasi ke investigationActivities sebagai pelaksana
    public function investigationActivities()
    {
        return $this->hasMany(InvestigationActivity::class, 'performed_by');
    }

    // Relasi ke penalty sebagai yang memutuskan
    public function decidedPenalties()
    {
        return $this->hasMany(Penalty::class, 'decided_by');
    }

    // Relasi ke appeals sebagai appellant dan reviewer
    public function appeals()
    {
        return $this->hasMany(Appeal::class, 'appellant_id');
    }

    public function reviewedAppeals()
    {
        return $this->hasMany(Appeal::class, 'reviewed_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function workflowLogs()
    {
        return $this->hasMany(WorkflowLog::class, 'action_by');
    }
}
