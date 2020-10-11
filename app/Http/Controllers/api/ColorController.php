<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colors;

class ColorController extends Controller
{
    public function index()
    {
        return Colors::all();
    }

    public function show(Colors $color)
    {
        return $color;
    }

    public function store(Request $request)
    {
        $color = Colors::create($request->all());
        echo($color);
        return response()->json([
            'success'=> true,
            'color' => $color
        ], 201);
    }

    public function update(Request $request, Colors $color)
    {
        $color->update($request->all());

        return response()->json($color, 200);
    }

    public function delete(Colors $color)
    {
        $color->delete();

        return response()->json(null, 204);
    }
}
