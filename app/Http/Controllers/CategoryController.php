<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::paginate();
        return response()->json(['status' => true, 'data' => $categories], 200);
    }
    public function all()
    {
        //
        $categories = Category::get();
        return response()->json(['status' => true, 'data' => $categories], 200);
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
            'description' => 'required|string|max:255|unique:categories',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $category = Category::create([
                'description' => $request->description,
            ]);
            return response()->json(['status' => true, 'message' => 'Se ha registrado la categoria'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => 'No se ha logrado registrar la categoria', 'err' => [$th->getMessage()]], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
