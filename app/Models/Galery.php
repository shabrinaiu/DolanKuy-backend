<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    use HasFactory;
    protected $table = 'galery';
    public $timestamps = true;
    
    protected $fillable = [
        'filename',
        'created_at',
        'list_location_id'
    ];
    protected $hidden = [
    ];
    protected $casts = [
    ];
}
