<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\Traits\AvailableLanguages;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Inertia\Inertia;
use Laravel\Jetstream\Jetstream;
use \App\Http\Controllers\Games\ResourceController;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserBalances;
use Illuminate\Support\Facades\Log;

class CurrenciesController extends Controller
{
    use AvailableLanguages;


    public static function currentBalance()
    {
        if(auth()->user()) {
        $currentBalance = UserBalances::where('user_id', auth()->user()->id)->where('currency_code', auth()->user()->currentCurrency)->first()->value ?? 0;
        } else {
            $currentBalance = '0';
        }

        return number_format($currentBalance, 7, '.', '');
    }


    public static function currentDepositWallet()
    {
        if(auth()->user()) {

        $wallet = UserBalances::where('user_id', auth()->user()->id)->where('currency_code', auth()->user()->currentCurrency)->first()->wallet ?? null;
        if($wallet === null) {

        $getWallet = self::cryptapi(auth()->user()->currentCurrency, auth()->user()->id);
        $insert = UserBalances::where('user_id', auth()->user()->id)->where('currency_code', auth()->user()->currentCurrency)->update(['wallet' => $getWallet]);

        } else {
        $returnWallet = $wallet;
        }

        } else {
            $wallet = '0';
        }

        return $wallet;
    }


    public static function cryptapi($currency, $user_id) {
            $url = config('settings.url');
            $cryptapiSecret = config('settings.cryptapi_secret');
            $secret = md5($user_id.'_'.$cryptapiSecret);
            $address = \App\Models\Currencies::where('code', $currency)->first()->end_wallet;
            $lowerCaseCurrency = strtolower($currency);

            $query = array(
              "callback" => $url.'/api/callback/cryptapi?secret='.$secret,
              "address" => $address,
              "pending" => "0",
              "confirmations" => "1",
              "post" => "0",
              "priority" => "fast"
            );

            $url = "https://api.cryptapi.io/".$lowerCaseCurrency."/create?" . http_build_query($query);
            $curl = curl_init();

            $get = Http::get($url);
              Log::warning($get);

                return $get['address_in'];
    }

    public function selectedCurrency(Request $request)
    {
            $findUser = \App\Models\User::where('id', $request->user()->getAuthIdentifier())->first();
            \App\Models\User::where('id', $request->user()->getAuthIdentifier())->update(['currentCurrency' => $request->selectedCurrency]);
        
        return back(303);
    }

    public static function retrieve()
    {

        foreach(\App\Models\Currencies::where('hidden', 0)->get() as $currency)
        {
            if(auth()->user()){

            $selectUserBalance = UserBalances::where('user_id', auth()->user()->id)->where('currency_code', $currency->code)->first();
            
            if($selectUserBalance) {
                $printUserBalance = $selectUserBalance->value;
            } else {
                $insert = UserBalances::insert(['currency_code' => $currency->code, 'user_id' => auth()->user()->id, 'value' => floatval('0')]);
                $printUserBalance = UserBalances::where('user_id', auth()->user()->id)->first()->value;
            }
            $balances[] = array('currency_code' => $currency->code, 'balance' => number_format($printUserBalance, 7, '.', ''), 'usd_value' => number_format(floatval($printUserBalance * $currency->usd_price), 2, '.', ''), 'hidden' => $currency->hidden);
            } else {

            $balances[] = array('currency_code' => $currency->code, 'balance' => number_format('0', 7, '.', ''), 'usd_value' => floatval('0' * $currency->usd_price), 'hidden' => $currency->hidden);
            }

        }
        return $balances;
    }

    public function updateBalances(Request $request)
    {
           $retrieve = self::retrieve();
        
        return back(303);
    }


    public function cryptapiCallback(Request $request)
    {
        $secret = $request->secret;
        $address = $request->address_in;
        $amount = $request->value_coin;
        $netto = $request->value_forwarded_coin;
        $txid = $request->txid_in;
        $currency = $request->coin;
        Log::notice($request);
        
        $findWalletInDb = UserBalances::where('wallet', $address)->where('currency_code', $currency)->first();

        if($findWalletInDb) {
            $cryptapiSecret = config('settings.cryptapi_secret');
            $generatedSecret = md5($findWalletInDb->user_id.'_'.$cryptapiSecret);

            if($secret === $generatedSecret) {
                    $currentBalance = $findWalletInDb->value;
                    $updateBetBalance = $findWalletInDb->update(['value' => floatval($currentBalance + $amount)]);
            }

        }
        return [];
    }


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
 
        $data = \App\Models\Currencies::all();
        return Inertia::render('Admin/Currencies/Show', ['currencies' => $data]);
    }
  

    public function generateWallet(Request $request)
    {

return Inertia::share(['address' => 'test']);
     
   
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        if ($request->has('currency')) {
            $get = \App\Models\Currencies::where('id', $request->input('currency'))->first();

            if($request->method === 'hide') {
                $change = \App\Models\Currencies::where('id', $request->input('currency'))->update(['hidden' => 1]);
                $success = 'Currency has been hidden. Players with balance are still able to use this currency.';
            }
            if($request->method === 'unhide') {
                $change = \App\Models\Currencies::where('id', $request->input('currency'))->update(['hidden' => 0]);
                $success = 'Currency has been made public.';
            }


        return back()->with('flash', [
            'bannerStyle' => 'success',
            'banner' => $success,
        ]);
    }
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
