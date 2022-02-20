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
use App\Models\GamelistPublic;

class GamesController extends Controller
{
    use AvailableLanguages;


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }
 
        $gamesCount = GamelistPublic::count();
        $providerCount = \App\Models\Providers::count();
        $apikey = config('settings.main_api_key');
        return Inertia::render('Admin/Games/Show', ['gamescount' => $gamesCount, 'providerscount' => $providerCount, 'apikey' => $apikey]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'code' => ['required', 'min:2', 'max:10'],
            'name' => ['required', 'min:2', 'max:25'],
            'price_api' => ['required'],
            'price_api_id' => ['required'],
            'payment_method' => ['required'],
            'hidden' => ['required'],
        ])->validate();
  
    if($request->price_api === 'coingecko') { 
        try {
            $requestCoingecko = Http::get('https://api.coingecko.com/api/v3/coins/'.$request->price_api_id.'?localization=false&market_data=true');
            $price = floatval($requestCoingecko['market_data']['current_price']['usd']);
         } catch (\Exception $exception) {
                return back()->with('flash', ['bannerStyle' => 'danger', 'banner' => 'Was unable to retrieve USD$ Price from '.$request->price_api.' for '.$request->code.' using price tag ID: '.$request->price_api_id.'.',]);
         }

    } else {

    }
        \App\Models\Currencies::create($request->all());
  
        return back()->with('flash', ['bannerStyle' => 'success', 'banner' => $request->code.' currency has succesfully been added.',]);
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
            $selectRandomGame = \App\Models\GamelistPublic::where('demo', 1)->get()->random(1)->first();
            Log::warning($selectRandomGame);

            try {
            if($request->method === 'createSession') {
                $start = \App\Http\Controllers\Games\ThirdpartyGamesController::start($selectRandomGame->game_slug, 'test');
                if($start) {
                $success = 'Session created properly.';
                }
            }
            if($request->method === 'balance') {
                $start = \App\Http\Controllers\Games\ThirdpartyGamesController::start('pra-c-wolf-gold', 'real');
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
        GamelistPublic::truncate();
        foreach ($arrayList['data'] as $game) {
            GamelistPublic::insert(['game_slug' => $game['id'], 'game_name' => $game['name'], 'game_desc' => $game['desc'], 'game_provider' => $game['provider'], 'demo' => $game['demo'], 'index_rating' => $game['index_rating'], 'disabled' => (int) $game['d'], 'freespins' => (int) $game['freespins'], 'bonusbuy' => $game['bonus'], 'type' => $game['category'], 'rtp' => (100 - $game['rtp']), 'hidden' => 0]);
        }
        \Artisan::call('optimize:clear');

        $count = GamelistPublic::count();

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
    public function destroy(Request $request)
    {
        if ($request->has('id')) {
            \App\Models\Currencies::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }

}
