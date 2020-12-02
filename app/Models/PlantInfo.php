<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filterable;
use App\Filters\QueryFilter;

class PlantInfo extends Model
{
    use HasFactory;

    protected $fillable = ['plant_id', 'size_id', 'color_id', 'category_id', 'count' ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'plant_id',
        'size_id',
        'color_id',
        'category_id',
        'count'
        
    ];

    protected $allowedFilters = [
        'plant_id',
        'size_id',
        'color_id',
        'category_id',
        'count'
    ];
    
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}