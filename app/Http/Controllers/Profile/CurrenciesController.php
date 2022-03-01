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
use App\Models\Currencies;
use App\Models\PaymentLog;
use App\Models\WithdrawLog;

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

        return number_format($currentBalance, 9, '.', '');
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
            $address = Currencies::where('code', $currency)->first()->end_wallet;
            $lowerCaseCurrency = strtoupper($currency);

            $query = array(
              "callback" => $url.'/api/callback/cryptapi?secret='.$secret,
              "address" => $address,
              "pending" => "0",
              "confirmations" => "1",
              "post" => "0",
              "priority" => "fast"
            );
            $url = "https://api.cryptapi.io/".config('currencytickers.'.$lowerCaseCurrency.'')."/create?" . http_build_query($query);
            $curl = curl_init();
            $get = Http::get($url);

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

        foreach(Currencies::where('hidden', 0)->get() as $currency)
        {
            if(auth()->user()){
            $selectUserBalance = UserBalances::where('user_id', auth()->user()->id)->where('currency_code', $currency->code)->first();
            
            // Retrieve User Balance for specific currency, if not found insert new balance row
            if($selectUserBalance) {
                $printUserBalance = $selectUserBalance->value;
            } else {
                $insert = UserBalances::insert(['currency_code' => $currency->code, 'user_id' => auth()->user()->id, 'value' => floatval('0')]);
                $printUserBalance = UserBalances::where('user_id', auth()->user()->id)->first()->value;
            }
            // Combine currency info & user balance
                $balances[] = array('currency_code' => $currency->code, 'minimum_deposit' =>  number_format(floatval(1.1 * $currency->minimum_deposit), 7, '.', ''), 'minimum_deposit_usd' => number_format(floatval(($currency->minimum_deposit * $currency->usd_price) * 1.1), 2, '.', ''), 'balance' => number_format($printUserBalance, 9, '.', ''), 'usd_value' => number_format(floatval($printUserBalance * $currency->usd_price), 2, '.', ''), 'hidden' => $currency->hidden);
            } else {
                // Send just currency info if not logged in
                $balances[] = array('currency_code' => $currency->code, 'balance' => number_format('0', 9, '.', ''), 'usd_value' => floatval('0' * $currency->usd_price), 'hidden' => $currency->hidden);
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
        $findWalletInDb = UserBalances::where('wallet', $address)->where('currency_code', $currency)->first();

        if($findWalletInDb) {
            $cryptapiSecret = config('settings.cryptapi_secret');
            $generatedSecret = md5($findWalletInDb->user_id.'_'.$cryptapiSecret);

            if($secret === $generatedSecret) {
                if(!PaymentLog::where('transaction_id', $request->txid_in)->first()) {
                $usdValue = Currencies::where('code', $currency)->first()->usd_price;
                $insertPaymentLog = PaymentLog::insert(['user_id' => $findWalletInDb->user_id, 'amount' => $request->value_coin, 'transaction_id' => $request->txid_in, 'currency_code' => $currency, 'callback_log' => json_encode($request->all()), 'usd_value' => number_format(($usdValue * $request->value_coin), 4, '.', ''), 'created_at' => now(), 'updated_at' => now()]);
                    $currentBalance = $findWalletInDb->value;
                    $updateWalletBalance = $findWalletInDb->update(['value' => number_format(floatval($currentBalance + $amount), 9, '.', '')]);
                }
            }

        }
        return;
    }

    /*
     *  Show payment ledger for admin
     */
    public function paymentLedger()
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }
         return Inertia::render('Admin/Ledger/Show', [
            'payment_history' => \App\Models\PaymentLog::orderBy('id', 'DESC')->get(),
            'withdraw_history' => \App\Models\WithdrawLog::orderBy('id', 'DESC')->get(),
        ]);
    }

    /*
     *  Show payment ledger for admin
     */
    public function markPayment(Request $request)
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }
        $findWithdrawal = \App\Models\WithdrawLog::where('id', $request->id)->first();
        
        $findWithdrawal->update(['status' => 'SENT', 'transaction_id' => 1]);


         return back(303);
    }

    /**
     * 
     * Show all currency page for admin
     * 
     **/
    public function index()
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }
 
        return Inertia::render('Admin/Currencies/Show', ['available_crypto' => config('currencytickers.available_crypto'), 'currencies' => Currencies::all()]);
    }
  
    /**
     * Show withdraw request page
     *
     * @return Response
     */
    public function withdrawRequestShow()
    {
        return Inertia::render('Profile/WithdrawRequest');
    }
  
    /**
     * User withdrawal request form
     *
     * @return Response
     */
    public function withdrawRequestSubmit(Request $request)
    {
        Validator::make($request->all(), [
            'withdraw_currency' => ['required', 'min:1', 'max:10'],
            'withdraw_address' => ['required', 'min:5', 'max:30'],
            'withdraw_amount' => ['required', 'min:1', 'max:40'],
        ])->validate();
  
    $findWalletInDb = UserBalances::where('currency_code', $request->withdraw_currency)->where('user_id', auth()->user()->id)->first();

    if(floatval($request->withdraw_amount) < floatval($findWalletInDb->value)) { 
        $updateWalletBalance = $findWalletInDb->update(['value' => number_format(floatval($findWalletInDb->value - $request->withdraw_amount), 9, '.', '')]);
        $usdValue = Currencies::where('code', $request->withdraw_currency)->first()->usd_price;
        $insertWithdrawLog = WithdrawLog::insert(['user_id' => $findWalletInDb->user_id, 'amount' => $request->withdraw_amount, 'transaction_id' => '0', 'currency_code' => $request->withdraw_currency, 'withdraw_address' => $request->withdraw_address, 'usd_value' => number_format(($usdValue * $request->withdraw_amount), 4, '.', ''), 'status' => 'REQUESTED','created_at' => now(), 'updated_at' => now()]);

        return back()->with('flash', ['bannerStyle' => 'success', 'banner' => 'Succesfully requested withdrawal.',]);
    } else {
        return back()->with('flash', ['bannerStyle' => 'danger', 'banner' => 'Not enough balance.',]);
    }
        return back()->with('flash', ['bannerStyle' => 'success', 'banner' => $request->code.' currency has succesfully been added.',]);
    }

    /**
     * Admin Form to add new currency
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }

        Validator::make($request->all(), [
            'code' => ['required', 'min:2', 'max:10'],
            'name' => ['required', 'min:2', 'max:25'],
            'end_wallet' => ['required'],
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
        //Spacing future price API's
    }
        Currencies::create($request->all());
        \Artisan::call('currency:updateprices');
        \Artisan::call('optimize:clear');

        return back()->with('flash', ['bannerStyle' => 'success', 'banner' => $request->code.' currency has succesfully been added.',]);
    }

    /**
     * Admin Route for updating existing currency settings
     *
     * @return Response
     */
    public function update(Request $request)
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }
        
        try {
        if($request->method === 'updatePrices') {
            \Artisan::call('currency:updateprices');
            \Artisan::call('optimize:clear');
            $success = 'Currency prices updated.';
        }

        if ($request->has('currency')) {
            $get = Currencies::where('id', $request->input('currency'))->first();

            if($request->method === 'hide') {
                $change = Currencies::where('id', $request->input('currency'))->update(['hidden' => 1]);
                $success = 'Currency has been hidden. Players with balance are still able to use this currency.';
            }
            if($request->method === 'unhide') {
                $change = Currencies::where('id', $request->input('currency'))->update(['hidden' => 0]);
                $success = 'Currency has been made public.';
            }
        }
         } catch (\Exception $exception) {
                return back()->with('flash', ['bannerStyle' => 'danger', 'banner' => 'Error occured: '.$exception.'.',]);
        }

        return back()->with('flash', [
            'bannerStyle' => 'success',
            'banner' => $success,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        if(! auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($request->has('id')) {
            Currencies::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
