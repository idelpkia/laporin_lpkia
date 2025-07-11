<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penalty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_id',
        'penalty_level_id',
        'penalty_type',
        'description',
        'recommendation_date',
        'decided_by',
        'sk_number',
        'sk_date',
        'status'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function penaltyLevel()
    {
        return $this->belongsTo(PenaltyLevel::class, 'penalty_level_id');
    }

    public function decider()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
