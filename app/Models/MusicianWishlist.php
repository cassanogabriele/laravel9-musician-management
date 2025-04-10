<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicianWishlist extends Model
{
    use HasFactory;

    protected $table = 'musician_wishlist';

    protected $fillable = [
        'musician_id', 
        'wishlist_id'
    ];
}
