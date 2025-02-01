<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $brands = Brand::paginate();
        return response()->json(['status' => true, 'data' => $brands], 200);
    }

    public function all()
    {
        //
        $brands = Brand::get();
        return response()->json(['status' => true, 'data' => $brands], 200);
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
            'description' => 'required|string|max:255|unique:brands',
            'bio' => 'string|max:255',

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
            $brand = Brand::create([
                'description' => $request->description,
                'bio' => $request->bio,
            ]);
            $image_name =  md5(time() . rand()) . '_' . $brand->id . '.' . $request->photo->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs(
                'assets/img/brands',
                $image_name
            );
            $brand->photo = $path;
            $status_activo = Status::where('description', 'Activo')->firstOrCreate();
            $brand->status()->associate($status_activo);
            $brand->save();
            return response()->json(['status' => true, 'message' => 'Se ha registrado la marca', 'data' => $brand], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar la marca', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
