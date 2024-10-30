<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('services')->as('services:')->group(base_path(
    path: 'routes/api/services.php'
));

Route::prefix('credentials')->as('credentials:')->group(base_path(
    path: 'routes/api/credentials.php'
));

Route::prefix('checks')->as('checks:')->group(base_path(
    path: 'routes/api/checks.php'
));
