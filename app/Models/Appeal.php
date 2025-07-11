<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appeal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_id',
        'appellant_id',
        'appeal_reason',
        'appeal_date',
        'appeal_status',
        'review_result',
        'reviewed_by',
        'review_date'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function appellant()
    {
        return $this->belongsTo(User::class, 'appellant_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
