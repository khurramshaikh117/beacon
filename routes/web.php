<?php

use Illuminate\Support\Facades\Route;
use App\Models\Device;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/devices', function () {
    $devices = Device::orderBy('last_seen_at', 'desc')->get();
    return view('devices', compact('devices'));
});