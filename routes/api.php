<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */



 Route::apiResource('books',BookController::class);
