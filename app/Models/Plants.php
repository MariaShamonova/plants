<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;

class Plants extends Model
{
    use HasFactory;

    protected $fillable = ['articul','title', 'price', 'size_id', 'color_id', 'category_id', 'description', 'image' ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'title',
        'price',
        
    ];

    protected $allowedFilters = [
        'title',
        'size_id',
        'color_id',
        'category_id'
    ];
    
}