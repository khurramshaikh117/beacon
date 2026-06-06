<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_uuid',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function scopeTrackedMembers(Builder $query): Builder
    {
        return $query->whereNotNull('user_uuid')->where('user_uuid', '!=', '');
    }

    public function presenceLogs()
    {
        return $this->hasMany(PresenceLog::class, 'user_uuid', 'user_uuid');
    }

    public function latestPresence()
    {
        return $this->hasOne(PresenceLog::class, 'user_uuid', 'user_uuid')
                    ->latestOfMany();
    }
}
