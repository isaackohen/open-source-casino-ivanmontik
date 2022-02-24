<?php

namespace App\Http\Controllers\Games;

use App\Helpers\Traits\AvailableLanguages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;
use \App\Http\Controllers\Games\ResourceController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserBalances;
use App\Models\Gamelist;

class GamesController extends Controller
{
    use AvailableLanguages;


    /**
     * Show admin games control page.
     *
     * @return Response
     */
    public function index()
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }
 
        $gamesCount = Gamelist::count();
        $providerCount = \App\Models\Providers::count();
        $apikey = config('settings.main_api_key');
        return Inertia::render('Admin/Games/Show', ['gamescount' => $gamesCount, 'providerscount' => $providerCount, 'apikey' => $apikey]);
    }
  

    /**
     * Run session test.
     *
     * @return Response
     */
    public function runTest(Request $request)
    {
            // Get First Currency
            $selectFirstCurrency = \App\Models\Currencies::where('hidden', 0)->first();

            // Get random game from your list
            $selectRandomGame = \App\Models\Gamelist::where('demo', 1)->get()->random(1)->first();
            Log::warning($selectRandomGame);

            try {
            if($request->method === 'createSession') {
                $start = \App\Http\Controllers\Games\ThirdpartyGamesController::start($selectRandomGame->game_slug, 'test');
                if($start) {
                $success = 'Session created properly.';
                }
            }
            if($request->method === 'balance') {
                $start = \App\Http\Controllers\Games\ThirdpartyGamesController::start('pra-c-wolf-gold', 'test');
                if($start) {
                $success = 'API was able to do correct balance test.';
                }

            }
        } catch(Exception $e) {
                $success = $e;
        }


        return back()->with('flash', [
            'bannerStyle' => 'success',
            'banner' => $success,
        ]);
    }

    /**
     * Update Games Externally.
     *
     * @return Response
     */  
    public function updateGames()
    {
        $apikey = config('settings.main_api_key');
        $apihost = config('settings.api_server');
        $response = Http::get('https://'.$apihost.'/v2/listGames?apikey='.$apikey.'&framework=1');
        $arrayList = ['data' => $response->json()];
        Gamelist::truncate();
        foreach ($arrayList['data'] as $game) {
            Gamelist::insert(['game_slug' => $game['id'], 'game_name' => $game['name'], 'game_desc' => $game['desc'], 'game_provider' => $game['provider'], 'demo' => $game['demo'], 'index_rating' => $game['index_rating'], 'disabled' => (int) $game['d'], 'freespins' => (int) $game['freespins'], 'bonusbuy' => $game['bonus'], 'type' => $game['category'], 'rtp' => (100 - $game['rtp']), 'hidden' => 0]);
        }
        \Artisan::call('optimize:clear');

        $count = Gamelist::count();

        return back()->with('flash', [
            'bannerStyle' => 'success',
            'banner' => 'Game list update completed. Loaded '.$count.' games.',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function delete(Request $request)
    {
        Log::warning($request);
        if ($request->game) {
            Gamelist::where('game_slug', $request->game)->delete();
            return back();
        }
    }

}
