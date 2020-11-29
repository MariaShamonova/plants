<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Filters\OrdersFilter;

class OrdersController extends Controller
{
    public function index(OrdersFilter $filters)
    {  
        $ordersArray = Orders::filter($filters)->get();
        $ordersTotal = Orders::all();
        $ordersArray[] = count($ordersTotal);
      
        return $ordersArray;
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
 
        $orders->update($request->all());   
        return response()->json($orders, 200);
    }

}