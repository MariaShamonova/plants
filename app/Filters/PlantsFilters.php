<?php

namespace App\Filters;

class PlantsFilters extends QueryFilter
{

    
    public function plant_id($id)
    {
        return $this->builder->where('id', $id);
    }

    // public function category($id)
    // {
    //     return $this->builder->whereIn('category_id', $id);
    // }

    // public function color($id)
    // {
        
    //     return $this->builder->whereIn('color_id', $id);
    // }

    // public function size($id)
    // {
        
    //     return $this->builder->whereIn('size_id', $id);
    // }

    // public function min($number)
    // {

    //     return $this->builder->where('price', '>=', $number);
    // }

    // public function max($number)
    // {
    //     return $this->builder->where('price', '<=', $number);
    // }

    public function paggination($pag)
    {

        
        $obj = json_decode($pag);
        $limit = $obj->{'limit'};
        $offset = $obj->{'offset'};
        //$limit = $pag->limit;
        //echo($limit);
        
        if ($offset && $limit) {
            return $this->builder->limit($limit)->offset($offset)->get();
        } else {
            if ($limit !== null) {
                return $this->builder->limit($limit)->get();
            } else {
            
                return $this->builder->get();
            }
        }
        //return $this->builder->limit($limit)->get();
    }
    // public function offset($offset)
    // {

    //     return $this->builder->limit($lim)->offset($offset)->get();
    // }
    

    // public function brands($brandIds)
    // {
    //     return $this->builder->whereIn('brand_id', $this->paramToArray($brandIds));
    // }

    // public function search($keyword)
    // {
    //     return $this->builder->where('title', 'like', '%'.$keyword.'%');
    // }

    public function price($order = 'asc')
    {
        return $this->builder->orderBy('price', $order);
    }
}