<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'report_id',
        'document_type',
        'file_name',
        'file_path',
        'file_size',
        'mime_type'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
