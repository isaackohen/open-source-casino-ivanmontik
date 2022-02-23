<?php

namespace App\Models;

use App\Helpers\Traits\CacheableTrait;
use App\Helpers\Traits\SearchableScope;
use App\Helpers\Traits\SearchableTrait;
use App\Helpers\Traits\User\PermissionTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable /*implements MustVerifyEmail*/
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
//    use \Illuminate\Auth\MustVerifyEmail;
    use HasFactory;
    use HasSnowflakePrimary;
    use SearchableTrait;
    use SearchableScope;
    use HasRoles;
    use HasPermissions;
    use CacheableTrait;
    use PermissionTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'country', 'language', 
        'profile_photo_path', 'permissions', 'roles', 'currentCurrency', 'super',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function paymentlog()
    {
        return $this->hasMany(\App\Models\PaymentLog::class);
    }
    public function withdrawlog()
    {
        return $this->hasMany(\App\Models\WithdrawLog::class);
    }
    public function UserBalances()
    {
        return $this->hasMany(\App\Models\UserBalances::class);
    }

    public function isAdmin() {
        if(auth()->user()->email !== 'admin@example.com') {
            return false;
        } else {
            return true;
        }

    }

}
