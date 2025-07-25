<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationType extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'category'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
