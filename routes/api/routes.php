<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::prefix('v1')->as('v1:')->group(static function (): void {
    Route::get('/', static fn() => response()->json(request()->route()))->middleware(['sunset:'. now()->subDays(3)->format('Y-m-d H:i:s')]);

    Route::middleware(['auth:sanctum', 'throttle:api'])->group(static function (): void {

        Route::get('/user', static function (Request $request) {
            return $request->user() ;
        })->name('user');

        Route::prefix('services')->as('services:')->group(base_path(
            path: 'routes/api/v1/services.php'
        ))->middleware(['throttle:100,1']);

        Route::prefix('credentials')->as('credentials:')->group(base_path(
            path: 'routes/api/v1/credentials.php'
        ));

        Route::prefix('checks')->as('checks:')->group(base_path(
            path: 'routes/api/v1/checks.php'
        ));
    });
});

Route::prefix('v2')->as('v2:')->group(static function (): void {
    Route::get('/', static fn() => response()->json(request()->route()));


});
