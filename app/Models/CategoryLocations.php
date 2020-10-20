<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLocations extends Model
{
    use HasFactory;


    
    protected $table = 'category_locations';
    public $timestamps = true;


    protected $fillable = [
        'name',
        'created_at',
    ];

    
    protected $hidden = [
    ];

    
    protected $casts = [
    ];
}
