<?php

namespace App\Console\Commands;
use App\Models\Currencies;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:updateprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update USD value for currencies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currencies = \App\Models\Currencies::all();

        foreach($currencies as $currency) {
            
            if($currency->price_api === 'coingecko')
            {
                //Updating USD$ Value using Coingecko
                $requestCoingecko = Http::get('https://api.coingecko.com/api/v3/coins/'.$currency->price_api_id.'?localization=false&market_data=true');
                $price = floatval($requestCoingecko['market_data']['current_price']['usd']);
                
                $currency->update([
                    'usd_price' => $price,
                    'updated_at' => now(),
                ]);
            }

            if($currency->payment_method === 'cryptapi') {
                //Getting estimated tx fees for each currency
                $txUrl = "https://api.cryptapi.io/".config('currencytickers.'.$currency->code.'')."/estimate?priority=fast&addresses=1";
                $txGet = Http::get($txUrl);
                if($txGet['status'] === 'success') {
                    $currency->update(['txfee' => $txGet['estimated_cost']]);
                }

                //Getting minimum deposit value
                $minDepUrl = "https://api.cryptapi.io/".config('currencytickers.'.$currency->code.'')."/info?prices=0";
                $minDepGet = Http::get($minDepUrl);
                if($minDepGet['status'] === 'success') {
                    $currency->update(['minimum_deposit' => $minDepGet['minimum_transaction_coin']]);
                }
            }



           $currency->update([
                'sum' => \App\Models\UserBalances::where('currency_code', $currency->code)->sum('value'),
                'updated_at' => now(),
            ]);
        }
    }
}