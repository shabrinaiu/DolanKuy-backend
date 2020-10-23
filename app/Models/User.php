<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "user";
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'created_at',
    ];

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
