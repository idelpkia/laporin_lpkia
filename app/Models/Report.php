<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_number',
        'reporter_id',
        'reported_person_name',
        'reported_person_email',
        'reported_person_type',
        'violation_type_id',
        'title',
        'description',
        'incident_date',
        'submission_method',
        'status'
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function violationType()
    {
        return $this->belongsTo(ViolationType::class, 'violation_type_id');
    }

    public function reportDocuments()
    {
        return $this->hasMany(ReportDocument::class);
    }

    public function investigation()
    {
        return $this->hasOne(Investigation::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function workflowLogs()
    {
        return $this->hasMany(WorkflowLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
