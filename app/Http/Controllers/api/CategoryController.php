<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function index()
    {
        return Categories::all();
    }

    public function show(Categories $category)
    {
        return $category;
    }

    public function store(Request $request)
    {
        $category = Categories::create($request->all());
        echo($category);
        return response()->json([
            'success'=> true,
            'category' => $category
        ], 201);
    }

    public function update(Request $request, Categories $category)
    {
        $category->update($request->all());

        return response()->json($category, 200);
    }

    public function delete(Categories $category)
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
