<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use App\Models\UserBalances;

class WithdrawLog extends Model
{
    use HasFactory;
    
    protected $table = 'withdraw_log';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'user_id', 'transaction_id', 'withdraw_address', 'currency_code', 'amount', 'usd_value', 'status', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'updated_at' => "datetime:Y-m-d H:i",
        'created_at' => "datetime:Y-m-d H:i",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
