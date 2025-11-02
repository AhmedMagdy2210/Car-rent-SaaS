<?php

use App\Http\Controllers\System\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd("hello");
});
// Route::get('/users', [AuthController::class, 'test']);
