<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clubs = Club::paginate();
        return response()->json(['status' => true, 'data' => $clubs], 200);
    }
    public function all()
    {
        //
        $clubs = Club::get();
        return response()->json(['status' => true, 'data' => $clubs], 200);
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
            'description' => 'required|string|max:255|unique:clubs',
        ], [
            'description.unique' => 'La divisa ya se encuentra registrada',
        ]);
        if ($request->has('photo')) {
        } else {
            return response()->json(['status' => false, 'errors' => ['La imagen es obligatoria']], 400);
        }
        // Validacion de errores
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $club = Club::create([
                'description' => $request->description,
            ]);
            $image_name =  md5(time() . rand()) . '_' . $club->id . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs(
                'assets/img/clubs',
                $image_name
            );
            $club->photo = $path;
            $club->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado el club'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar el club', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        //
    }
}
