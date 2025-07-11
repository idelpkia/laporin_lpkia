<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowLog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'report_id',
        'from_status',
        'to_status',
        'action_by',
        'notes',
        'created_at'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
