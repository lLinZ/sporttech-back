<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $players = Player::paginate();
        return response()->json(['status' => true, 'data' => $players], 200);
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
        $status_active = Status::where('description', 'Activo')->firstOrCreate(['description' => 'Activo']);

        $validator = Validator::make(
            $request->all(),
            [
                'names' => 'required|string|max:255',
                'surnames' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:players',
                'document' => 'required|string|max:255|unique:players',
                'team_id' => 'required|integer|exists:teams,id',
                'category_id' => 'required|integer|exists:categories,id',
                'league_id' => 'required|integer|exists:leagues,id',
                'discipline_id' => 'required|integer|exists:disciplines,id',
            ],
            [
                'email.unique' => 'El correo ya se encuentra registrado',
                'document.unique' => 'La cedula ya se encuentra registrada',
                'team_id.exists' => 'El equipo no es valido',
                'category_id.exists' => 'La categoria no es valida',
                'league_id.exists' => 'La liga no es valida',
                'discipline_id.exists' => 'La disciplina no es valida',
            ]
        );
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
            $player = Player::create([
                'names' => $request->names,
                'surnames' => $request->surnames,
                'email' => $request->email,
                'document' => $request->document,
            ]);
            $player->discipline_id()->associate($request->discipline_id);
            $player->league()->associate($request->league_id);
            $player->team()->associate($request->team_id);
            $player->category()->associate($request->category_id);
            $player->status()->associate($status_active);
            $image_name =  md5(time() . rand()) . '_' . $player->id . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs(
                'assets/img/players',
                $image_name
            );
            $player->photo = $path;
            $player->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado el jugador'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar el jugador', 'err' => [$th->getMessage()]], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        //
    }
}
