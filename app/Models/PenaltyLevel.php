<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyLevel extends Model
{
    use HasFactory;
    protected $fillable = ['level', 'description'];

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }
}
