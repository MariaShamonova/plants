<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filterable;
use App\Filters\QueryFilter;

class DataDelivery extends Model
{
    use HasFactory;
    protected $fillable = [ 'id', 'client_id', 'address', 'fullName', 'phone'];

    protected $allowedFilters = [
        'id',
        'client_id',
        'address',
        'fullName',
        'phone'
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