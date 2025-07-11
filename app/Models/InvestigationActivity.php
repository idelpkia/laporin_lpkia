<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestigationActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'investigation_id',
        'activity_type',
        'description',
        'activity_date',
        'performed_by',
        'notes'
    ];

    public function investigation()
    {
        return $this->belongsTo(Investigation::class);
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
