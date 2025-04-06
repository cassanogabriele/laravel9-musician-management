<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musician extends Model
{
    use HasFactory;

    protected $table = 'musicians';

    protected $fillable = [
        'name', 
        'style',
        'email',
        'phone',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }    
}
