<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investigation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_id',
        'team_leader_id',
        'status',
        'start_date',
        'end_date'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function teamLeader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    public function investigationTeams()
    {
        return $this->hasMany(InvestigationTeam::class);
    }

    public function investigationActivities()
    {
        return $this->hasMany(InvestigationActivity::class);
    }

    public function investigationTools()
    {
        return $this->hasMany(InvestigationTool::class);
    }
}
