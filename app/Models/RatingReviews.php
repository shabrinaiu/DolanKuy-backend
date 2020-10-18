<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReviews extends Model
{
    use HasFactory;

<<<<<<< HEAD:app/Models/CategoryLocation.php
    
    protected $table = 'rating_reviews';
    public $timestamps = true;

    protected $fillable = [
<<<<<<< Updated upstream:app/Models/CategoryLocation.php
        'name',
        'address',
        'description',
        'image',
        'contact',
        'latitude',
        'longitude',
=======
        'rating',
        'review',
        'created_at',
>>>>>>> Stashed changes:app/Models/RatingReviews.php
=======
    protected $table = "rating_reviews";
    public $timestamps = true;

    protected $fillable = [
        'created_at',
        'rating',
        'review',
>>>>>>> 23a91847dfb9171e60e2be688a004f415d57b56d:app/Models/RatingReviews.php
    ];

    
    protected $hidden = [
    ];

    
    protected $casts = [
        
    ];
}
