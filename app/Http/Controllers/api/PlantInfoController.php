<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantInfo;
use App\Filters\PlantsInfoFilter;

class PlantsInfoController extends Controller
{
    public function index(PlantsInfoFilter $filters)
    {  
        $plantsInfoArray = PlantsInfo::filter($filters)->get();
        $plantsInfoTotal = PlantsInfo::all();
        $plantsInfoArray[] = count($plantsInfoTotal);
      
        return $plantsInfoArray;
    }

    public function show(PlantsInfo $plantsInfo)
    {
        return $plantsInfo;
    }

    public function store(Request $request)
    {
        $plantsInfo = PlantsInfo::create($request->all()); 
        return response()->json([
            'success'=> true,
            'plantsInfo' => $plantsInfo
        ], 201);
    }

    public function update(Request $request, PlantsInfo $plantsInfo)
    {
        
        $plantsInfo->update($request->all());
        
        return response()->json($plantsInfo, 200);
    }

    public function delete(PlantsInfo $plantsInfo)
    {
        $plantsInfo->delete();
        return response()->json(null, 204);
    }

    public function updateOrders(Request $request, PlantsInfo $plantsInfo)
    { 
 
        $plantsInfo->update($request->all());   
        return response()->json($plantsInfo, 200);
    }

}