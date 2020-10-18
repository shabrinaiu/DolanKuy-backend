<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListLocations extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'list_locations';
=======
    protected $table = "list_locations";
>>>>>>> 23a91847dfb9171e60e2be688a004f415d57b56d
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

<<<<<<< HEAD
    
    protected $hidden = [
    ];

    
    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

=======
    protected $hidden = [
    ];


    protected $casts = [
    ];

    public function users()
    {
    	return $this->belongsToMany('App\Models\Users', 'user_list_locations');
    }
>>>>>>> 23a91847dfb9171e60e2be688a004f415d57b56d
}
