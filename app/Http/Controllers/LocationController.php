<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $locations = Location::paginate();
        return response()->json(['status' => true, 'data' => $locations], 200);
    }
    public function all()
    {
        //
        $locations = Location::get();
        return response()->json(['status' => true, 'data' => $locations], 200);
    }

    public function get_locations_by_stadium(Stadium $stadium)
    {
        //
        $locations = Location::where('stadium_id', $stadium->id)->get();
        return response()->json(['status' => true, 'data' => $locations], 200);
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
    public function store(Request $request, Stadium $stadium)
    {
        //
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255|unique:locations',
            'stadium_id' => 'required|integer|exists:stadiums,id',
        ], [
            'description.required' => 'La descripcion es requerida',
            'description.string' => 'La descripcion debe ser un string',
            'description.max' => 'La descripcion no debe ser mayor a 255 caracteres',
            'description.unique' => 'La descripcion debe ser unica',
            'stadium_id.required' => 'El id del estadio es requerido',
            'stadium_id.integer' => 'El id del estadio debe ser un entero',
            'stadium_id.exists' => 'El estadio no existe',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        try {
            $location = Location::create([
                'description' => $request->description,
            ]);
            $location->stadium()->associate($stadium);
            $location->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado la ubicacion', 'data' => $location], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar la ubicacion', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
    }
}
