<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $clients = Client::with([
            'user' => function ($query) {
                $query->select('id', 'names', 'surnames');
            },
            'brand' => function ($query) {
                $query->select('id', 'description', 'photo');
            },
        ])->paginate();
        return response()->json(['status' => true, 'data' => $clients], 200);
    }
    public function all()
    {
        //
        $clients = Client::get();
        return response()->json(['status' => true, 'data' => $clients], 200);
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
        $role = Role::where('description', 'Cliente')->firstOrCreate(['description' => 'Cliente']);
        $validator = Validator::make($request->all(), [
            'names' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|max:255',
            'description' => 'string|max:255|unique:clients',
            'address' => 'string',
            'document' => 'string|max:255',
            'phone' => 'string|max:255',
        ]);
        if ($request->has('photo')) {
        } else {
            return response()->json(['status' => false, 'errors' => ['La imagen es obligatoria']], 400);
        }
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $user = User::create([
                'names' => $request->names,
                'surnames' => $request->surnames,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'color' => '#C0EA0F',
                'theme' => 'light',
            ]);
            $user->status()->associate($status_active);
            $user->role()->associate($role);
            $user->save();
            $client = Client::create([
                'description' => $request->description ?? '',
                'address' => $request->address ?? '',
                'document' => $request->document ?? '',
                'phone' => $request->phone ?? '',
            ]);
            $brand = Brand::where('id', $request->brand_id)->first();
            $image_name =  md5(time() . rand()) . '_' . $client->id . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs(
                'assets/img/clients',
                $image_name
            );
            $client->photo = $path;
            $client->brand()->associate($brand);
            $client->user()->associate($user);
            $client->status()->associate($status_active);
            $client->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado el cliente', 'data' => $client], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar el cliente', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
