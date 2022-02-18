<?php

namespace App\Console\Commands;
use App\Models\Providers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\GamelistPublic;

class ProvidersUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'providers:gamescount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update providers count';

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
        $providers = Providers::all();

        foreach($providers as $provider) {
            
            $count = GamelistPublic::where('game_provider', $provider->provider)->where('hidden', 0)->count();


           $provider->update([
                'count' => $count
            ]);
        }
    }
}