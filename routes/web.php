<?php

use App\Http\Controllers\GrammarCheckController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Grammar Checker routes
Route::controller(GrammarCheckController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/check-grammar', 'store')->name('grammar-check.store');
    Route::get('/history', 'show')->name('grammar-check.history');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
