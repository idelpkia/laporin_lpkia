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
    Route::resource('reports', ReportController::class);
    Route::resource('penalties', PenaltyController::class);
    Route::resource('investigations', InvestigationController::class);
    Route::resource('violation-types', ViolationTypeController::class);
    Route::resource('penalty-levels', PenaltyLevelController::class);
    Route::resource('committee-members', CommitteeMemberController::class);
    Route::resource('system-settings', SystemSettingController::class);
    Route::resource('appeals', AppealController::class);

    Route::post('/admin/generate-css', [App\Http\Controllers\ThemeController::class, 'generateCSS'])->name('admin.generate-css');
});




Route::post('reports/{report}/documents', [ReportController::class, 'addDocument'])->name('reports.documents.store');
Route::delete('reports/{report}/documents/{document}', [ReportController::class, 'deleteDocument'])->name('reports.documents.destroy');
Route::post('reports/{report}/change-status', [ReportController::class, 'changeStatus'])->name('reports.changeStatus');
