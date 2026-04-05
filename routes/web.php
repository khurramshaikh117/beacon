<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/devices', function () {
    $devices = \App\Models\Presence::all();
    return view('devices', compact('devices'));
});