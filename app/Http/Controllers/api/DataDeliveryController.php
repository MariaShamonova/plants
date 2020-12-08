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
        //echo($request->{'fullName'});
        //$dataDelivery->update($request->all());
        //$dataDelivery->save();
        
        $id = $request->{'id'};
        $info = DataDelivery::where('id', $id)->update(array('fullName' => $request->{'fullName'}));
        $infoPhone = DataDelivery::where('id', $id)->update(array('phone' => $request->{'phone'}));
        $infoPhone = DataDelivery::where('id', $id)->update(array('address' => $request->{'address'}));
        
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