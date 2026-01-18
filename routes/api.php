<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresenceController;

Route::post('/presence', [PresenceController::class, 'store']);
