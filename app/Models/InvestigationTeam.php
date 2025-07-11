<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestigationTeam extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'investigation_id',
        'member_id',
        'role'
    ];

    public function investigation()
    {
        return $this->belongsTo(Investigation::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
