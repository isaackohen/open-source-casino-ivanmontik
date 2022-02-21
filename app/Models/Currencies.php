<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use App\Models\UserBalances;

class Currencies extends Model
{
    use HasFactory;
    
    protected $table = 'currencies';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'code', 'name', 'usd_price', 'price_api', 'price_api_id', 'hidden', 'payment_method', 'end_wallet'
    ];

    public function UserBalances()
    {
        return $this->belongsTo(UserBalances::class, 'currency_code', 'code');
    }
}
