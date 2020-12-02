<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantInfo;
use App\Filters\PlantInfoFilter;

class PlantInfoController extends Controller
{
    public function index(PlantInfoFilter $filters, Request $request)
    {  
        $plantInfoArray = PlantInfo::filter($filters)->get();
        //$plantInfoTotal = PlantInfo::all();
        //$plantInfoArray[] = count($plantInfoTotal);
        $count = count($plantInfoArray);
        $sum = 0;
        foreach ($plantInfoArray as $element => $elements) {
            $sum = $sum + $elements->{'count'};
    
        }
        
        $field = 0;
        if ($count > 0 ) {
            $field = PlantInfo::filter($filters)->first()->{'id'}; 
        } else {  
            $field = null;
        }
        $colorsArr = [];
        $sizesArr = [];
        if ($count > 0) {
            if ($request->{'size_id'} && $request->{'color_id'} == null) {
                $colorsTempArr = PlantInfo::select('color_id')->distinct()
                ->where([ 
                    ['size_id', '=', $request->{'size_id'}],
                    ['plant_id', '=', $request->{'plant_id'}],
                ])
                ->get();
                $colorsArr = array();   
                foreach ($colorsTempArr as $color => $colors) {
                    $colorsArr[] = $colors->{'color_id'};
                }
    
                $sizesArr[] = $request->{'size_id'};
            } else {
                if ($request->{'size_id'} ==  null && $request->{'color_id'} ) {
                    $sizesTempArr = PlantInfo::select('size_id')->distinct()
                    ->where([
                        ['color_id', '=', $request->{'color_id'}],
                        ['plant_id', '=', $request->{'plant_id'}],
                    ])
                    ->get();
                    $sizesArr = array();   
                    foreach ($sizesTempArr as $size => $sizes) {
                        $sizesArr[] = $sizes->{'size_id'};
                    }
    
                    $colorsArr[] = $request->{'color_id'};
                } else {
                    if ($request->{'size_id'} && $request->{'color_id'} ) {
                        $sizesArr[] = $request->{'size_id'};
                        $colorsArr[] = $request->{'color_id'};
                    } else {
                        $sizesTempArr = PlantInfo::select('size_id')->distinct()->get();
                        $sizesArr = array();   
                        foreach ($sizesTempArr as $size => $sizes) {
                            $sizesArr[] = $sizes->{'size_id'};
                        }
                        $colorsTempArr = PlantInfo::select('color_id')->distinct()->get();
                        $colorArr = array();   
                        foreach ($colorsTempArr as $color => $colors) {
                            $colorsArr[] = $colors->{'color_id'};
                        }
                    }
                }
            }
        } else {
            $sizesArr = [];
            $colorsArr = [];
        }

        $obj = (object) [
            'id'  =>$request->{'plant_id'},
            'id_field'=> $field,
            'count' => $sum,
            'sizes' => $sizesArr,
            'colors' => $colorsArr,
            
        ];
        $arrayTemp[] = $obj;

      
        return $arrayTemp;
    }

    public function show(PlantInfo $plantInfo)
    {
        return $plantInfo;
    }

    public function store(Request $request)
    {
        $plantInfo = PlantInfo::create($request->all()); 
        return response()->json([
            'success'=> true,
            'plantInfo' => $plantInfo
        ], 201);
    }

    public function update(Request $request, PlantInfo $plantInfo)
    {

        $id = $request->{'id'};
        $plantInfo = PlantInfo::where('id', $id)->update(array('count' => $request->{'count'}));
        
        //$input = $request->all();
       //$plantInfo->fill($input)->save();
       
        return response()->json($plantInfo, 200);
    }

    public function delete(PlantInfo $plantInfo)
    {
        
        $plantInfo->delete();
        return response()->json(null, 204);
    }

    // public function updatePlantsInfo(Request $request, PlantInfo $plantInfo)
    // {
    //     echo($plantInfo);
 
    //     $plantInfo->update($request->all());
        
    //     return response()->json($plantInfo, 200);
    // }

}