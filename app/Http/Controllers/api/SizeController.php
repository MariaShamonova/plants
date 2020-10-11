<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sizes;

class SizeController extends Controller
{
    public function index()
    {
        return Sizes::all();
    }

    public function show(Sizes $size)
    {
        return $size;
    }

    public function store(Request $request)
    {
        $size = Sizes::create($request->all());
        echo($size);
        return response()->json([
            'success'=> true,
            'size' => $size
        ], 201);
    }

    public function update(Request $request, Sizes $size)
    {
        $size->update($request->all());

        return response()->json($size, 200);
    }

    public function delete(Sizes $size)
    {
        $size->delete();

        return response()->json(null, 204);
    }
}
