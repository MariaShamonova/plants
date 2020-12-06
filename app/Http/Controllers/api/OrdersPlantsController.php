<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdersPlants;
use App\Filters\OrdersPlantsFilter;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
class OrdersPlantsController extends Controller
{
    public function index(OrdersPlantsFilter $filters)
    {  
        $ordersArray = OrdersPlants::filter($filters)->get();
        $ordersTotal = OrdersPlants::all();
        $ordersArray[] = count($ordersTotal);
      
        return $ordersArray;
    }

    //Custom GET
    public function getBusket(OrdersPlantsFilter $filters)
    {  
        $ordersArray = OrdersPlants::filter($filters)->get();
        
        $array = [];
        //echo($ordersArray);
        foreach ($ordersArray as $plant => $plants) {
            //Получить название растения из таблицы Plant по plant_id из таблицы OrderPlant
            $product = OrdersPlants::filter($filters)->select('*')
            ->join('plant_infos', 'plant_infos.id', '=', 'orders_plants.plant_id')
            ->join('plants', 'plants.id', '=', 'plant_infos.plant_id')
            ->first();
            //echo($plants->{'count'});
            $obj = (object) [
                'title' => $product->{'title'},
                'id'  => $product->{'id'},
                'articul'  => $product->{'articul'},
                'image'  => $product->{'image'},
                'description'  => $product->{'description'},
                'price' =>$product->{'price'},
                'count' => $plants->{'count'},
                'size' => $product->{'size_id'},
                'color' => $product->{'color_id'},
                'category' => $product->{'category_id'},
                'data'=> $plants
            ];
            $arrayTemp[] = $obj;
            
        }
  
        $ordersTotal = OrdersPlants::all();
        $arrayTemp[] = count($ordersTotal);
      
        return $arrayTemp;
    }

    public function show(OrdersPlants $orders)
    {
        return $orders;
    }

    public function store(Request $request)
    {
        $orders = OrdersPlants::create($request->all());
        return response()->json([
            'success'=> true,
            'orders-plants' => $orders
        ], 201);
    }
    
    public function addToBasket(Request $request, OrdersPlants $orders)
    {
       
        $id = Orders::where([
            ['client_id', '=', $request->{'client_id'}],
            ['status_id', '=', '1']
        ])->first()->{'id'};
        
        $plantsCount = OrdersPlants::where([
            ['order_id','=', $id],
            ['plant_id', '=', $request->{'plant_id'} ]
        ])->get();
        
        if (count($plantsCount) == 0 ){
            //Создаем новую запись

            $orders = OrdersPlants::create([
                'plant_id'=> $request->{'plant_id'},
                'order_id'=> $id
            ] );
        } else {
            $orders = OrdersPlants::where('plant_id', $request->{'plant_id'})->update(array('count' => DB::raw('count+1')));
        }
     
        //$orders = OrdersPlants::create($request->all());
        return response()->json([
            'success'=> true,
            'orders-plants' => $orders
        ], 201);
    }

    public function update(Request $request, OrdersPlants $orders)
    { 

        $id = $request->{'id'};
        $orders = OrdersPlants::where('id', $id)->update(array('count' => $request->{'count'}));
        return response()->json($orders, 200);
    }

    public function delete(OrdersPlants $orders)
    {
        $orders->delete();
        return response()->json(null, 204);
    }

    public function updateOrders(Request $request, OrdersPlants $orders)
    {
        $orders->update($request->all());
        return response()->json($orders, 200);
    }

}