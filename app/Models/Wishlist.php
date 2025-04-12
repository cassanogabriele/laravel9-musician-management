<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{   
    protected $table = 'wishlists';
   
    protected $fillable = [
        'name', 
        'user_id'
    ];   

    public function musicians()
    {
        return $this->belongsToMany(Musician::class, 'musician_wishlist');
    }

}
