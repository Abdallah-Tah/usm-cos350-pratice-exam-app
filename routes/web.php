<?php

use App\Http\Controllers\CodePracticeController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/exam', [ExamController::class, 'index'])->name('exam.index');
Route::post('/exam/submit', [ExamController::class, 'submit'])->name('exam.submit');
Route::post('/exam/reset', [ExamController::class, 'reset'])->name('exam.reset');
Route::get('/exam/history', [ExamController::class, 'history'])->name('exam.history');
Route::get('/exam/history/{attempt}', [ExamController::class, 'showHistory'])->name('exam.history.show');

Route::get('/practice', [CodePracticeController::class, 'index'])->name('practice.index');
Route::get('/practice/{id}', [CodePracticeController::class, 'show'])->name('practice.show');
Route::post('/practice/run', [CodePracticeController::class, 'run'])->name('practice.run');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
