<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceLog extends Model
{
    protected $fillable = [
        'device_uuid',
        'user_uuid',
        'zone',
        'rssi',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'user_uuid');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_uuid', 'uuid');
    }

    public function isIn(): bool
    {
        return $this->status === 1001;
    }
}