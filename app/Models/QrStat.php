<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrStat extends Model
{
    use HasFactory;

    // Disabled standard timestamps since we only have created_at
    public $timestamps = false;

    protected $fillable = [
        'qr_type',
        'size',
        'margin',
        'color',
        'bg_color',
        'error_correction',
        'logo_uploaded',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'size' => 'integer',
        'margin' => 'integer',
        'logo_uploaded' => 'boolean',
        'created_at' => 'datetime'
    ];
}
