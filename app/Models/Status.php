<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filterable;
use App\Filters\QueryFilter;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'status'];
}