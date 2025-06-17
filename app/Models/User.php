<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public $stores = [];
    protected $appends = ['stores'];
    public $with = 'account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'fist_login',
        'logins',
        'google_id',
        'picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function getStoresAttribute()
    {
        return $this->stores;
    }


    public function authorities()
    {
        return $this->hasMany('App\Models\Authority');
    }


    public function roles()
    {
        return $this->belongsToMany('App\Models\Authority');
    }

    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }

    public function myAccount(){
        $user = DB::table('accounts')
            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
            ->select('accounts.*')
            ->where('users.id',$this->id)
//            ->toSql();
            ->first();

        return $user;
    }


    public function myStores(){
        $stores = Store::with('city')
            ->Where('stores.owner_id' ,$this->id)
//            ->toSql();
        ->get();

        $this->stores = $stores;

        return $stores;
    }

}
