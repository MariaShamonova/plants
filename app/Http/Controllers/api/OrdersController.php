<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Filters\OrdersFilter;
use App\Models\OrdersPlants;
use App\Filters\OrdersPlantsFilter;
use Illuminate\Support\Facades\DB;
use stdClass;
class OrdersController extends Controller
{
    public function index(OrdersFilter $filters)
    {  
        $ordersArray = Orders::filter($filters)->get();
        $ordersTotal = Orders::all();
        //$ordersArray[] = count($ordersTotal);
      
        return $ordersArray;
    }

    public function getActiveOrders(OrdersFilter $filters)
    {  
        $ordersArray = Orders::filter($filters)->get();
        $productAll = [];
        $arrayTemp = [];
        $productSum = 0;
        foreach ($ordersArray as $order => $orders) {
            $productAll = OrdersPlants::select('*')
            ->join('plant_infos', 'plant_infos.id', '=', 'orders_plants.plant_id')
            ->join('plants', 'plants.id', '=', 'plant_infos.plant_id')
            ->where('order_id',  '=', $orders->{'id'})
            ->get();
            
            $address = Orders::select('*')
            ->join('data_deliveries', 'data_deliveries.id', '=', 'orders.delivery_id' )
            ->where('orders.id', '=',$orders->{'id'} )
            ->first();
            //echo($address);
            $obj = (object) [
                'plants' =>  $productAll,
                'order_id' => $orders->{'id'},
                'date' => $orders->{'date'},
                'sum' => $orders->{'price'},
                'status_id' => $orders->{'status_id'},
                'address' => $address->{'address'},
                'person'=>$address->{'fullName'},
                'phone' => $address->{'phone'}

            ];
            $arrayTemp[] = $obj;
            
        }
        
        return $arrayTemp;
    }

    public function show(Orders $orders)
    {
        return $orders;
    }

    public function store(Request $request)
    {
        $orders = Orders::create($request->all()); 
        return response()->json([
            'success'=> true,
            'orders' => $orders
        ], 201);
    }

    public function update(Request $request, Orders $orders)
    {
        
        $orders->update($request->all());
        
        return response()->json($orders, 200);
    }

    public function delete(Orders $orders)
    {
        $orders->delete();
        return response()->json(null, 204);
    }

    public function updateOrders(Request $request, Orders $orders)
    { 
 
        //$orders->update($request->all()); 
        $id = $request->{'id'};
        $orders = Orders::where('id', $id)->update(array('status_id' => $request->{'status_id'}));  
        
        if ($request->{'date'}){
            $date = Orders::where('id', $id)->update(array('date' => $request->{'date'}));  
        }
        if ($request->{'status_id'} == 2) {
            $order = Orders::create(
                [
                    'client_id' => $request->{'client_id'}, 
                    'delivery_id'=> $request->{'delivery_id'},
                    'status_id' => 1, 
                    'price' => 0, 
                    'date'=> ''
                ]
            );
            $orders = Orders::where('id', $id)->update(array('price' => $request->{'price'}));  
      
            $order->save();
        }
        
        return response()->json([
            'orders' => $orders
        ],  200);
    }

    //Custom GET
    public function getProductsFromBasket(OrdersFilter $filters)
    {  
       
           //Сначала нужно получить id заказа для клиента со статусом 1 
            $orderId = Orders::filter($filters)->first();

            $id = $orderId->{'id'};
           
            $ordersArray = OrdersPlants::select('*')
            ->where('order_id', '=', $id)->get();
            
            $array = [];
     
            foreach ($ordersArray as $plant => $plants) {
                //Получить название растения из таблицы Plant по plant_id из таблицы OrderPlant
            
                $product = OrdersPlants::select('*')
                ->join('plant_infos', 'plant_infos.id' , '=', 'orders_plants.plant_id')
                ->join('plants', 'plants.id', '=', 'plant_infos.plant_id')
                ->where([
                    [ 'orders_plants.order_id', '=', $id],
                    [ 'orders_plants.plant_id', '=', $plants->{'plant_id'}]
                ])
                ->first();
                
                $idField = OrdersPlants::where([
                    [ 'orders_plants.order_id', '=', $id],
                    [ 'orders_plants.plant_id', '=', $plants->{'plant_id'}]
                ])->first()->{'id'};
                
                $obj = (object) [
                    'title' => $product->{'title'},
                    'id'  => $product->{'plant_id'},
                    'orders_plants_id'  => $idField,
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
            $object = new stdClass();  
            $object->count= count($ordersTotal);
            $arrayTemp[] = $object;

            return $arrayTemp;

        
    }

}