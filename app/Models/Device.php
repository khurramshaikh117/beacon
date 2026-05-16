<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'uuid',
        'label',
        'zone',
        'rssi',
        'wifi_username',
        'wifi_password',
        'status',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];
}