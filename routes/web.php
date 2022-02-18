<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Profile\CurrenciesController;
use App\Http\Controllers\Games\ResourceController;
use App\Http\Controllers\Games\ThirdpartyGamesController;
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



Route::get('/', function () {
    return Inertia::render('Dashboard', [
       'games' => \App\Models\GamelistPublic::where('type', 'slots')->where('demo', '1')->get()->take(18)
    ]);
})->name('dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
       'games' => \App\Models\GamelistPublic::where('type', 'slots')->where('demo', '1')->get()->take(18)
    ]);
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/play/{slug}/{currency}', [ThirdpartyGamesController::class, 'start'])->name('game.real.start');
Route::middleware(['auth:sanctum', 'verified'])->get('/game/{slug}', [ThirdpartyGamesController::class, 'show'])->name('game.show');
Route::middleware(['auth:sanctum', 'verified'])->get('/admin/currencies', [CurrenciesController::class, 'index'])->name('currencies.show');
Route::resource('Currencies', CurrenciesController::class);
Route::middleware(['auth:sanctum', 'verified'])->put('/admin/currencies/store', [CurrenciesController::class, 'store'])
            ->name('admin.currencies.store');
Route::middleware(['auth:sanctum', 'verified'])->delete('/admin/currencies/destroy', [CurrenciesController::class, 'destroy'])
            ->name('admin.currencies.destroy');
Route::middleware(['auth:sanctum', 'verified'])->put('/admin/currencies/update', [CurrenciesController::class, 'update'])
            ->name('admin.currencies.update');