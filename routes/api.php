
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Games\ThirdpartyGamesController;
use Spatie\QueryBuilder\QueryBuilder;
use \App\Models\Gamelist;
use \App\Models\Providers;
use App\Http\Controllers\Profile\CurrenciesController;

Route::any('/callback/extGames/balance', [ThirdpartyGamesController::class, 'balance']);
Route::any('/callback/extGames/bet', [ThirdpartyGamesController::class, 'result']);
Route::any('/callback/cryptapi', [CurrenciesController::class, 'cryptapiCallback']);

Route::get('/providers', function (Request $request) {

$providers = QueryBuilder::for(Providers::class)
    ->allowedFilters('name')
    ->defaultSort('-index_rating')
    ->paginate(81)
    ->appends(request()->query());

   return $providers;
});

Route::get('/gamelistAdmin', function (Request $request) {

$gamelist = QueryBuilder::for(Gamelist::class)
    ->allowedFilters('name', 'type', 'game_provider')
    ->defaultSort('-index_rating')
    ->paginate(50)
    ->appends(request()->query());

   return $gamelist;
});

Route::get('/gamelist', function (Request $request) {

$gamelist = QueryBuilder::for(Gamelist::class)
    ->allowedFilters('name', 'type', 'game_provider')
    ->defaultSort('-index_rating')
    ->paginate(18)
    ->appends(request()->query());

   return $gamelist;
});

/*
|--------------------------------------------------------------------------
| Disabled API Routes
|--------------------------------------------------------------------------



*/
