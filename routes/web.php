<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\InputSeederController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/set-input', [InputSeederController::class, 'input']);
