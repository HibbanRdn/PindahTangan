<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimonialController;

Route::get('/', function () {
    return view('welcome');
});

// ROUTE TESTIMONI (sementara TANPA AUTH)
Route::get('/testimoni/{order_code}/create', [TestimonialController::class, 'create']);
Route::post('/testimoni/{order_code}', [TestimonialController::class, 'store']);