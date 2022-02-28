<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Profile\CurrenciesController;
use App\Http\Controllers\Games\ResourceController;
use App\Http\Controllers\Games\ThirdpartyGamesController;
use App\Http\Controllers\Games\GamesController;

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
    ]);
})->name('casino');

Route::get('/dashboard', function () {
    return Redirect::route('casino');
})->name('dashboard');

Route::get('/poker', function () {
    return Inertia::render('Dashboard', [
    ]);
})->name('poker');

Route::post('login-web3', \App\Actions\LoginUsingWeb3::class);
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

Route::middleware(['auth:sanctum', 'verified'])->get('/admin/games', [GamesController::class, 'index'])->name('admin.games.show');
Route::middleware(['auth:sanctum', 'verified'])->put('/admin/games/update', [GamesController::class, 'updateGames'])->name('admin.games.update');
Route::middleware(['auth:sanctum', 'verified'])->put('/admin/games/test', [GamesController::class, 'runTest'])->name('admin.games.test');
Route::middleware(['auth:sanctum', 'verified'])->put('/admin/games/delete', [GamesController::class, 'delete'])->name('admin.games.delete');
Route::middleware(['auth:sanctum', 'verified'])->post('/currencies/generateWallet', [CurrenciesController::class, 'generateWallet'])
            ->name('currencies.generateWallet');
Route::middleware(['auth:sanctum', 'verified'])->get('/user/withdrawRequest', [CurrenciesController::class, 'withdrawRequestShow'])
            ->name('withdrawRequest.show');
Route::middleware(['auth:sanctum', 'verified'])->put('/user/withdrawRequest/submit', [CurrenciesController::class, 'withdrawRequestSubmit'])
            ->name('withdrawRequest.submit');