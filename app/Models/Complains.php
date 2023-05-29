<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complains extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'category', 'ward', 'area', 'road', 'house', 'description', 'user_id', 'pictures'
    ];
}
