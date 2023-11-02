<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\ChartUpdateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('dashboard'));
    }
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource("projects", ProjectController::class);
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard');
    Route::get('/projects/{project}/preview', [ProjectController::class, 'preview'])->name('projects.preview');
    Route::get('/projects/{project}/getData', [ProjectController::class, 'getData'])->name('projects.getData');

    Route::resource("projects.charts", ChartController::class)->shallow()->scoped()->except('update');
    Route::controller(ChartUpdateController::class)->group(function () {
        Route::put('/charts/{chart}', 'update')->name('charts.update');
        Route::put('/charts/sort/{chart}', 'sort')->name('charts.sort');
        Route::put('/charts/rebuild-data/{chart}', 'rebuildData')->name('charts.rebuildData');
        Route::put('/charts/update-config/{chart}', 'updateConfig')->name('charts.updateConfig');
    });
});

require __DIR__ . '/auth.php';
