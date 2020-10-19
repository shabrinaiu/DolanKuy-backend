<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "users";
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD:app/Models/Users.php
<<<<<<< Updated upstream:app/Models/User.php
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
=======
        'image',
        'latitude',
        'longitude',
        'created_at',
    ];

>>>>>>> Stashed changes:app/Models/Users.php
=======
        'image',
        'latitude',
        'longitude',
        'created_at',
    ];

>>>>>>> 23a91847dfb9171e60e2be688a004f415d57b56d:app/Models/User.php
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function listLocations()
    {
    	return $this->belongsToMany('App\Models\ListLocations', 'user_list_locations');
    }
}
