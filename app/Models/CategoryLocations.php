<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLocations extends Model
{
    use HasFactory;

<<<<<<< HEAD
    
    protected $table = 'category_locations';
    public $timestamps = true;

=======
    protected $table = "category_locations";
    public $timestamps = true;
    
>>>>>>> 23a91847dfb9171e60e2be688a004f415d57b56d
    protected $fillable = [
        'name',
        'created_at',
    ];

    
    protected $hidden = [
    ];

<<<<<<< HEAD
    
=======
   
>>>>>>> 23a91847dfb9171e60e2be688a004f415d57b56d
    protected $casts = [
    ];
}
