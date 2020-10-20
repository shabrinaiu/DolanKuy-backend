<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReviews extends Model
{
    use HasFactory;

    protected $table = "rating_reviews";
    public $timestamps = true;

    protected $fillable = [
        'created_at',
        'rating',
        'review',
        
    ];

   
    protected $hidden = [
    ];

   
    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];
}
