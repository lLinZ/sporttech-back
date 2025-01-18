<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $disciplines = Discipline::paginate();
        return response()->json(['status' => true, 'data' => $disciplines], 200);
    }

    public function all()
    {
        //
        $disciplines = Discipline::get();
        return response()->json(['status' => true, 'data' => $disciplines], 200);
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
            'description' => 'required|string|max:255|unique:disciplines',
        ], [
            'description.unique' => 'La disciplina ya se encuentra registrada',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $discipline = Discipline::create([
                'description' => $request->description,
            ],);
            return response()->json(['status' => true, 'message' => 'Se ha registrado la disciplina'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar la disciplina', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Discipline $discipline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discipline $discipline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discipline $discipline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discipline $discipline)
    {
        //
    }
}
