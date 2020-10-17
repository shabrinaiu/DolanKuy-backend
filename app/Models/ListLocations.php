<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLocations extends Model
{
    use HasFactory;

    protected $table = "list_locations";
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'address',
        'description',
        'image',
        'tag',
        'contact',
        'latitude',
        'longitude',
        'created_at',
    ];


    protected $hidden = [
    ];

    
    protected $casts = [
    ];

    public function users()
    {
    	return $this->belongsToMany('App\Models\User', 'user_list_locations');
    }
}
