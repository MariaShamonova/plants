<?php

namespace App\Filters;

class OrdersFilter extends QueryFilter
{ 
   
    public function paggination($pag)
    {
        $obj = json_decode($pag);
        $limit = $obj->{'limit'};
        $offset = $obj->{'offset'};

        if ($offset && $limit) {
            return $this->builder->limit($limit)->offset($offset)->get();
        } else {
            if ($limit !== null) {
                return $this->builder->limit($limit)->get();
            } else {
            
                return $this->builder->get();
            }
        }
    }

    public function price($order = 'asc')
    {
        return $this->builder->orderBy('price', $order);
    }
}