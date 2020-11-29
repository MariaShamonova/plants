<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataDelivery;
use App\Filters\DataDeliveryFilter;

class DataDeliveryController extends Controller
{
    public function index(DataDeliveryFilter $filters)
    {  
        $dataDeliveryArray = DataDelivery::filter($filters)->get();
        $dataDeliveryTotal = DataDelivery::all();
        $dataDeliveryArray[] = count($dataDeliveryTotal);
      
        return $dataDeliveryArray;
    }

    public function show(DataDelivery $dataDelivery)
    {
        return $dataDelivery;
    }

    public function store(Request $request)
    {
        $dataDelivery = DataDelivery::create($request->all()); 
        return response()->json([
            'success'=> true,
            'dataDelivery' => $dataDelivery
        ], 201);
    }

    public function update(Request $request, DataDelivery $dataDelivery)
    {
        
        $dataDelivery->update($request->all());
        
        return response()->json($dataDelivery, 200);
    }

    public function delete(DataDelivery $dataDelivery)
    {
        $dataDelivery->delete();
        return response()->json(null, 204);
    }

    public function updatedataDelivery(Request $request, DataDelivery $dataDelivery)
    { 
 
        $dataDelivery->update($request->all());   
        return response()->json($dataDelivery, 200);
    }

}