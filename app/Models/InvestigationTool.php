<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestigationTool extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'investigation_id',
        'tool_name',
        'result_file_path',
        'result_percentage',
        'notes'
    ];

    public function investigation()
    {
        return $this->belongsTo(Investigation::class);
    }
}
