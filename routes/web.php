<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\SurveyExportController;
use App\Http\Controllers\Admin\AdminManagerController;
use App\Http\Controllers\PublicController;

// Public Routes (Responden)
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/survei', [PublicController::class, 'surveys'])->name('surveys.index');
Route::get('/survei/{id}', [PublicController::class, 'show'])->name('surveys.show');
Route::post('/survei/{id}/submit', [PublicController::class, 'submit'])->name('surveys.submit')->middleware('throttle:10,1');
Route::get('/survei/{id}/submit', function ($id) {
    return redirect()->route('surveys.show', $id);
});
Route::get('/terima-kasih', [PublicController::class, 'thanks'])->name('surveys.thanks');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Dashboard (Protected Route)
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dasbor', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/admin/kelola-survei', [SurveyController::class, 'index'])->name('admin.surveys.index');
    Route::get('/admin/survei/create', [SurveyController::class, 'create'])->name('admin.surveys.create');
    Route::post('/admin/survei', [SurveyController::class, 'store'])->name('admin.surveys.store');
    Route::get('/admin/survei/{survey}', [SurveyController::class, 'show'])->name('admin.surveys.show');
    Route::get('/admin/survei/{survey}/edit', [SurveyController::class, 'edit'])->name('admin.surveys.edit');
    Route::put('/admin/survei/{survey}', [SurveyController::class, 'update'])->name('admin.surveys.update');
    Route::delete('/admin/survei/{survey}', [SurveyController::class, 'destroy'])->name('admin.surveys.destroy');
    Route::get('/admin/survei/{survey}/responden/{submission}', [SurveyController::class, 'showSubmission'])->name('admin.surveys.submissions.show');
    
    Route::get('/admin/survei/{survey}/export-excel', [SurveyExportController::class, 'exportExcel'])->name('admin.surveys.export_excel');
    Route::get('/admin/survei/{survey}/export-pdf', [SurveyExportController::class, 'exportPdf'])->name('admin.surveys.export_pdf');
    
    Route::get('/admin/manajemen-admin', [AdminManagerController::class, 'index'])->name('admin.admins.index');
    Route::post('/admin/manajemen-admin', [AdminManagerController::class, 'store'])->name('admin.admins.store');
    Route::put('/admin/manajemen-admin/{admin}', [AdminManagerController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/manajemen-admin/{admin}', [AdminManagerController::class, 'destroy'])->name('admin.admins.destroy');
});
