<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public static function loadCatalogos()
    {
        $countrys = Country::get(['id', 'name']);
        return collect(["countrys" => $countrys]);

    }

    public function country()
    {
        return $this->belongsTo('\App\Country');
    }

    public function state()
    {
        return $this->belongsTo('\App\State');
    }

    public function city()
    {
        return $this->belongsTo('\App\City');
    }

}
