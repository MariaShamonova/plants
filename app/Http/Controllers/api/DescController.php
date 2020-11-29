<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Description;

class DescController extends Controller
{
    public function index()
    {
        return Description::all();
    }

    public function show(Description $desc)
    {
        return $desc;
    }

    public function store(Request $request)
    {
        $desc = Description::create($request->all());
        echo($desc);
        return response()->json([
            'success'=> true,
            'desc' => $desc
        ], 201);
    }

    public function update(Request $request, Description $desc)
    {
        $desc->update($request->all());

        return response()->json($desc, 200);
    }

    public function delete(Description $desc)
    {
        $desc->delete();

        return response()->json(null, 204);
    }
}