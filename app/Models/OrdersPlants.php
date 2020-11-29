<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filterable;
use App\Filters\QueryFilter;

class OrdersPlants extends Model
{
    use HasFactory;

    protected $fillable = ['plant_id','order_id'];

    protected $allowedFilters = [
        'plant_id',
        'order_id',
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