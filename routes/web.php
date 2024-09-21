<?php

//use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApothecaryController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:dokter'])->group(function () {
        Route::get('/dokter/dashboard', [ExaminationController::class, 'index'])->name('dokter.dashboard');
        Route::get('/dokter/examinations/create', [ExaminationController::class, 'create'])->name('examinations.create');
        Route::post('/dokter/examinations', [ExaminationController::class, 'store'])->name('examinations.store');
        Route::get('/dokter/examinations/{examination}/edit', [ExaminationController::class, 'edit'])->name('examinations.edit');
        Route::put('/dokter/examinations/{examination}', [ExaminationController::class, 'update'])->name('examinations.update');
    });

    Route::middleware(['auth', 'role:apoteker'])->group(function () {
        Route::get('/apoteker/dashboard', [ApothecaryController::class, 'dashboard'])->name('apoteker.dashboard');
        Route::get('/apoteker/examination/{id}', [ApothecaryController::class, 'showExamination'])->name('apoteker.showExamination');
        Route::post('/apoteker/examination/{id}/pay', [ApothecaryController::class, 'pay'])->name('apoteker.pay');
        Route::get('/apoteker/examination/{id}/export-pdf', [ApothecaryController::class, 'exportPdf'])->name('apoteker.exportPdf');
    });
});