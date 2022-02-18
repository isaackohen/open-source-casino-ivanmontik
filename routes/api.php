
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Games\ThirdpartyGamesController;
use Spatie\QueryBuilder\QueryBuilder;
use \App\Models\GamelistPublic;
use \App\Models\Providers;

Route::any('/callback/extGames/balance', [ThirdpartyGamesController::class, 'balance']);
Route::any('/callback/extGames/bet', [ThirdpartyGamesController::class, 'result']);

Route::get('/gamelist', function (Request $request) {

$gamelist = QueryBuilder::for(GamelistPublic::class)
    ->allowedFilters('name', 'type', 'game_provider')
    ->paginate(18)
    ->appends(request()->query());

   return $gamelist;
});

Route::get('/providers', function (Request $request) {

$gamelist = QueryBuilder::for(Providers::class)
    ->allowedFilters('provider')
    ->paginate(100)
    ->appends(request()->query());

   return $gamelist;
});
/*
|--------------------------------------------------------------------------
| Disabled API Routes
|--------------------------------------------------------------------------



*/
