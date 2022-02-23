<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Gamelist extends Model
{
    use HasFactory;
    
    protected $table = 'gamelist';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'game_slug', 'game_name', 'game_provider', 'rtp', 'game_desc', 'index_rating', 'disabled', 'type', 'demo', 'hidden'
    ];

    public static function cachedList()
    {
        $cachedList = Cache::get('cachedList');

        if (! $cachedList) {
            $cachedList = self::all();
            Cache::put('cachedList', $cachedList, Carbon\Carbon::now()->addMinutes(120));
        }

        return $cachedList;
    }

}
