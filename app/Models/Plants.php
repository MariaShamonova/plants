<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plants extends Model
{
    use HasFactory;

    protected $fillable = ['articul','title', 'price', 'size_id', 'color_id', 'category_id', 'description', 'image' ];
}
