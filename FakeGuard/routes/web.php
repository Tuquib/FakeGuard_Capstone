<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FakeNewsDetectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/detection', function () {
    return view('detection');
})->name('detection');

Route::get('/detection/results', [FakeNewsDetectionController::class, 'showResults'])->name('detection.results');
Route::post('/detect', [FakeNewsDetectionController::class, 'detect'])->name('detect');
Route::post('/preview', [FakeNewsDetectionController::class, 'preview'])->name('preview');
Route::post('/store-detection', [FakeNewsDetectionController::class, 'store'])->name('store.detection');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
