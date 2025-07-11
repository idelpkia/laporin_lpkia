<?php

use App\Http\Controllers\ReportController;
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

Route::redirect('/', '/dashboard-general-dashboard');
Route::resource('reports', ReportController::class);


Route::post('reports/{report}/documents', [ReportController::class, 'addDocument'])->name('reports.documents.store');
Route::delete('reports/{report}/documents/{document}', [ReportController::class, 'deleteDocument'])->name('reports.documents.destroy');
Route::post('reports/{report}/change-status', [ReportController::class, 'changeStatus'])->name('reports.changeStatus');
