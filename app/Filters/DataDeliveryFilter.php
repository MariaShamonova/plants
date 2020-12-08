<?php

namespace App\Filters;

class DataDeliveryFilter extends QueryFilter
{ 
    public function client_id($id)
    {
        return $this->builder->where('client_id', $id);
    }

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

   
}