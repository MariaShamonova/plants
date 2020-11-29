<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        return Status::all();
    }

    public function show(Status $status)
    {
        return $status;
    }

    public function store(Request $request)
    {
        $status = Status::create($request->all());
        echo($status);
        return response()->json([
            'success'=> true,
            'status' => $status
        ], 201);
    }

    public function update(Request $request, Status $status)
    {
        $status->update($request->all());

        return response()->json($status, 200);
    }

    public function delete(Status $status)
    {
        $status->delete();

        return response()->json(null, 204);
    }
}