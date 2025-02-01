<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StadiumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stadiums = Stadium::paginate();
        return response()->json(['status' => true, 'data' => $stadiums], 200);
    }
    public function all()
    {
        //
        $stadiums = Stadium::get();
        return response()->json(['status' => true, 'data' => $stadiums], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255|unique:stadiums',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        try {
            $stadium = Stadium::create([
                'description' => $request->description
            ]);
            return response()->json(['status' => true, 'message' => 'Se ha registrado el estadio', 'data' => $stadium], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar el estadio', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Stadium $stadium)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stadium $stadium)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stadium $stadium)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stadium $stadium)
    {
        //
    }
}
