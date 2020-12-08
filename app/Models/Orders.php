<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filterable;
use App\Filters\QueryFilter;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = ['client_id','delivery_id','status_id', 'price', 'date' ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'status_id',
        'price',
        'date'
    ];

    protected $allowedFilters = [
        'client_id',
        'delivery_id',
        'status_id',
        'price',
        'date'
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