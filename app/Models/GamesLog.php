<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use App\Models\UserBalances;

class GamesLog extends Model
{
    use HasFactory;
    
    protected $table = 'games_log';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'user_id', 'currency_code', 'bet', 'win', 'game', 'round', 'old_balance', 'new_balance', 'callback_log', 'created_at', 'updated_at'
    ];

}
