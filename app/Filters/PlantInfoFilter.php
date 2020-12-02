<?php

namespace App\Filters;

class PlantInfoFilter extends QueryFilter
{ 

    public function plant_id($id)
    {
        return $this->builder->where('plant_id', $id);
    }

    public function size_id($id)
    {
        return $this->builder->where('size_id', $id);
    }
    public function color_id($id)
    {
        return $this->builder->where('color_id', $id);
    }
   
   
    public function paggination($pag)
    {
        echo($pag);
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