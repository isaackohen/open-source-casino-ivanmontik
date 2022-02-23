<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use App\Models\UserBalances;

class PaymentLog extends Model
{
    use HasFactory;
    
    protected $table = 'payment_log';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'user_id', 'transaction_id', 'currency_code', 'amount', 'usd_value', 'callback_log', 'created_at', 'updated_at'
    ];

}
