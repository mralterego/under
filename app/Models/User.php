<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $connection = 'pgsql';

    protected $table = 'users';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function createBySocialProvider($providerUser)
    {
        if ($providerUser->getEmail() == null){
            return self::create([
                'email' => $providerUser->getNickname(),
                'username' => $providerUser->getNickname(),
                'name' => $providerUser->getName(),
                'password' => bcrypt('AaBa123'),
            ]);
        } else {
            return self::create([
                'email' => $providerUser->getEmail(),
                'username' => $providerUser->getNickname(),
                'name' => $providerUser->getName(),
                'password' => bcrypt('AaBa123'),
            ]);
        }


    }
}
