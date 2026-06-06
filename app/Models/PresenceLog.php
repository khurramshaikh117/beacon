<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceLog extends Model
{
    public const STATUS_IN = 1001;

    public const STATUS_OUT = 1002;

    protected $fillable = [
        'device_uuid',
        'user_uuid',
        'zone',
        'rssi',
        'status',
    ];

    protected $casts = [
        'status'     => 'integer',
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
        return $this->status === self::STATUS_IN;
    }
}
