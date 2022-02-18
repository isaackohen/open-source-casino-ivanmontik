
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Games\ThirdpartyGamesController;
use Spatie\QueryBuilder\QueryBuilder;




Route::any('/callback/extGames/balance', [ThirdpartyGamesController::class, 'balance']);
Route::any('/callback/extGames/bet', [ThirdpartyGamesController::class, 'result']);

Route::get('/gamelist', function (Request $request) {

$gamelist = QueryBuilder::for(\App\Models\GamelistPublic::class)
    ->allowedFilters('name', 'type', 'game_provider')
    ->paginate(50)
    ->appends(request()->query());

   return $gamelist;
});
/*
|--------------------------------------------------------------------------
| Disabled API Routes
|--------------------------------------------------------------------------



*/
