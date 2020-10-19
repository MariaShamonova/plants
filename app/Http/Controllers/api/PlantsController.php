<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plants;

class PlantsController extends Controller
{
    public function index()
    {
        return Plants::all();
    }

    public function show(Plants $plants)
    {
        echo $plants;
        return $plants;
    }

    public function store(Request $request)
    {
        $plants = Plants::create($request->all());
        echo($plants);
        return response()->json([
            'success'=> true,
            'plants' => $plants
        ], 201);
    }

    public function update(Request $request, Plants $plants)
    {
        
        $plants->update($request->all());
        
        
        return response()->json($plants, 200);
    }

    public function delete(Plants $plants)
    {
        $plants->delete();
        return response()->json(null, 204);
    }

    public function searchTitle($title)
    {   
    
     
        $plant = Plants::where('title', 'LIKE', "%$title%")->get();
       
        return response()->json($plant, 200);
    }

    public function updatePlants(Request $request, Plants $plants)
    {
        
        echo 'hello';
        $plants->update($request->all());
       
        return response()->json($plants, 200);
    }

}