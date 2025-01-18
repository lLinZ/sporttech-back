<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $leagues = League::paginate();
        return response()->json(['status' => true, 'data' => $leagues], 200);
    }
    public function all()
    {
        //
        $leagues = League::get();
        return response()->json(['status' => true, 'data' => $leagues], 200);
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
        $status_active = Status::where('description', 'Activo')->firstOrCreate(['description' => 'Activo']);
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255|unique:leagues',
            'discipline_id' => 'required|integer|exists:disciplines,id',
        ], [
            'description.unique' => 'La liga ya se encuentra registrada',
            'discipline_id.exists' => 'La disciplina no es válida',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $league = League::create([
                'description' => $request->description,
            ],);
            $league->discipline()->associate($request->discipline_id);
            $league->status()->associate($status_active);
            $league->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado la liga'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar la liga', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(League $league)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(League $league)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, League $league)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(League $league)
    {
        //
    }
}
