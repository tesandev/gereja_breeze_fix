<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bacaan extends Model
{
    use HasFactory;

    protected $table = 'bacaan';
    
    protected $fillable = [
        'title', 
        'content',
        'featured_image',
    ];
}
