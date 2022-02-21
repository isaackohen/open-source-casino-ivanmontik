<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;
use App\Models\User;
use App\Models\Currencies;

class UserBalances extends Model
{
    use HasFactory;
    
    protected $table = 'user_balances';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'currency_code', 'user_id', 'value', 'created_at', 'updated_at', 'wallet'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Currencies()
    {
        return $this->hasMany(Currencies::class, 'code', 'currency_code');
    }


}
