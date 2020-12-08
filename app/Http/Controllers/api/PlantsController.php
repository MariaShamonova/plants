<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plants;
use App\Models\PlantInfo;
use App\Models\OrdersPlants;
use App\Filters\PlantsFilters;


use Illuminate\Support\Facades\DB;
use stdClass;

class PlantsController extends Controller
{
    public function index(PlantsFilters $filters, Request $request)
    {  
        $plantsArray = Plants::filter($filters)->get();
      
        $plantsTotal = Plants::all();
        $arrayTemp = array();   
        $object = new stdClass();  
        $object->count= count($plantsTotal);
        $hide = $request->{'all_plants'};
        foreach ($plantsArray  as $element => $elements) {
            $tempdata = PlantInfo::select('count')
            ->join('plants', 'plant_infos.plant_id', '=', 'plants.id')
            ->where('plant_infos.plant_id', '=', $elements->{'id'})
            ->get();

            $sum = 0;
           
            foreach ($tempdata as $oount=> $counts) {
                $sum = $sum  +  $counts->{'count'};
            }
            
            $boolSum = $sum > 0 ? true: false;
            $boolReq = $hide === 'true'? true: false;
    
            if ($boolSum || $boolReq) {
                $tempSizes = PlantInfo::select('size_id')->distinct()
                ->join('plants', 'plant_infos.plant_id', '=', 'plants.id')
                ->where('plant_infos.plant_id', '=', $elements->{'id'})
                ->get();

                $tempColors = PlantInfo::select('color_id')->distinct()
                ->join('plants', 'plant_infos.plant_id', '=', 'plants.id')
                ->where('plant_infos.plant_id', '=', $elements->{'id'})
                ->get();

                $categoryEl = PlantInfo::select('category_id')
                ->join('plants', 'plant_infos.plant_id', '=', 'plants.id')
                ->where('plant_infos.plant_id', '=', $elements->{'id'})
                ->first();

                $sizesArr = array();   
                foreach ($tempSizes as $size => $sizes) {
                    $sizesArr[] = $sizes->{'size_id'};
                }

                $colorsArr = array();   
                foreach ($tempColors as $color => $colors) {
                    $colorsArr[] = $colors->{'color_id'};
                }

                $obj = (object) [
                    'title' => $elements->{'title'},
                    'id'  => $elements->{'id'},
                    'articul'  => $elements->{'articul'},
                    'image'  => $elements->{'image'},
                    'description'  => $elements->{'description'},
                    'price' => $elements->{'price'},
                    'count' => $sum,
                    'sizes' => $sizesArr,
                    'colors' => $colorsArr,
                    'category' => $categoryEl->{'category_id'},
                    'data'=> $plantsArray
                ];
                $arrayTemp[] = $obj;
            }
            
            
        }
        
        // $object = new stdClass();
        // $object->count= count($plantsTotal);
        
        //echo($arrayTemp);
        $arrayTemp[] = $object;
      
        return $arrayTemp;
    }
    

    public function show(Plants $plants)
    {
        return $plants;
    }

    public function store(Request $request)
    {
        DB::transaction(function() use ($request)
        {
            $plants = Plants::create(
                [
                    'title' => $request->get('title'), 
                    'articul' => $request->get('articul'), 
                    'description' => $request->get('description'), 
                    'image' => $request->get('image'), 
                    'price' => $request->get('price'), 
                ]
            );
            $plants->save();
            $plantsInfo = PlantInfo::create(
                [
                    'plant_id' => $plants->id, 
                    'color_id' => $request->get('color_id'), 
                    'size_id' => $request->get('size_id'), 
                    'category_id' => $request->get('category_id'), 
                ]
            );
            $plantsInfo->save();
            return response()->json([
                'success'=> true,
                'plants' => $plants,
                'plant_info' => $plantsInfo,
            ], 201);
        });
        
    }

    public function update(Request $request, Plants $plants)
    {
        
        $plants->update($request->all());
        
        return response()->json($plants, 200);
    }

    public function delete(Plants $plants)
    {
        DB::transaction(function() use ($plants)
        {
            $plants->delete();
            PlantInfo::where('plant_id', '=', $plants->{'id'})->delete();
            OrdersPlants::where('plant_id', '=', $plants->{'id'})->delete();
            return response()->json(null, 204);        
        });

        
        
    }

    public function searchTitle($title)
    {   
     
        $plant = Plants::where('title', 'LIKE', "%$title%")->get();
        $plantsTotal = Plants::all();
        $plant[] = count($plantsTotal);
        
        return response()->json($plant, 200);
    }

    public function updatePlants(Request $request, Plants $plants)
    {
        
        $plants->update($request->all());
   
        return response()->json($plants, 200);
    }

}