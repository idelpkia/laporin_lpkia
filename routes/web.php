<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\CommitteeMemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestigationController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\PenaltyLevelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViolationTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('penalties', PenaltyController::class);
    Route::resource('investigations', InvestigationController::class);
    Route::resource('violation-types', ViolationTypeController::class);
    Route::resource('penalty-levels', PenaltyLevelController::class);
    Route::resource('committee-members', CommitteeMemberController::class);
    Route::resource('system-settings', SystemSettingController::class);
    Route::resource('appeals', AppealController::class);

    // Resource routes untuk reports
    Route::resource('reports', ReportController::class);

    // Routes untuk document management
    Route::post('/reports/{report}/documents', [ReportController::class, 'addDocument'])->name('reports.documents.add');
    Route::delete('/reports/{report}/documents/{document}', [ReportController::class, 'deleteDocument'])->name('reports.documents.delete');
    Route::get('/reports/{report}/documents/{document}/download', [ReportController::class, 'downloadDocument'])->name('reports.documents.download');

    // Route untuk change status
    Route::post('/reports/{report}/change-status', [ReportController::class, 'changeStatus'])->name('reports.change-status');
});




// Route::post('reports/{report}/documents', [ReportController::class, 'addDocument'])->name('reports.documents.store');
// Route::delete('reports/{report}/documents/{document}', [ReportController::class, 'deleteDocument'])->name('reports.documents.destroy');
// Route::post('reports/{report}/change-status', [ReportController::class, 'changeStatus'])->name('reports.changeStatus');
