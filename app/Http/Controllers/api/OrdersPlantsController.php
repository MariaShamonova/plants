<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdersPlants;
use App\Filters\OrdersPlantsFilter;

class OrdersPlantsController extends Controller
{
    public function index(OrdersPlantsFilter $filters)
    {  
        $ordersArray = OrdersPlants::filter($filters)->get();
        $ordersTotal = OrdersPlants::all();
        $ordersArray[] = count($ordersTotal);
      
        return $ordersArray;
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

    public function update(Request $request, OrdersPlants $orders)
    { 
        $orders->update($request->all());
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