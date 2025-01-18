<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $teams = Team::paginate();
        return response()->json(['status' => true, 'data' => $teams], 200);
    }
    public function all()
    {
        //
        $teams = Team::get();
        return response()->json(['status' => true, 'data' => $teams], 200);
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
            'description' => 'required|string|max:255|unique:teams',
            'discipline_id' => 'required|integer|exists:disciplines,id',
            'league_id' => 'required|integer|exists:leagues,id',
            'club_id' => 'required|integer|exists:clubs,id',
            'category_id' => 'required|integer|exists:categories,id',
        ], [
            'description.unique' => 'El equipo ya se encuentra registrado',
            'discipline_id.exists' => 'La disciplina no es valida',
            'league_id.exists' => 'La liga no es valida',
            'club_id.exists' => 'El club no es valido',
            'category_id.exists' => 'La categoria no es valida',
        ]);
        //
        if ($request->has('photo')) {
        } else {
            return response()->json(['status' => false, 'errors' => ['La imagen es obligatoria']], 400);
        }
        // Validacion de errores
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $team = Team::create([
                'description' => $request->description,
            ]);
            $team->discipline()->associate($request->discipline_id);
            $team->league()->associate($request->league_id);
            $team->club()->associate($request->club_id);
            $team->category()->associate($request->category_id);
            $team->status()->associate($status_active);
            $image_name =  md5(time() . rand()) . '_' . $team->id . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs(
                'assets/img/teams',
                $image_name
            );
            $team->photo = $path;
            $team->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado el equipo'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar el equipo', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
