<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\Api\DeviceConfigController;

Route::post('/presence', [PresenceController::class, 'store']);
Route::get('/device-config/{uuid}', [DeviceConfigController::class, 'show']);