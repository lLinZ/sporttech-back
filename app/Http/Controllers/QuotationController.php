<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $quotations = Quotation::with(['brand' => function ($query) {
            $query->select('id', 'description', 'photo');
        }, 'stadium', 'location', 'team', 'league'])->where('user_id', $user->id)->paginate();
        return response()->json(['status' => true, 'data' => $quotations], 200);
    }
    public function latest(Request $request)
    {
        //
        $user = $request->user();
        $client = Client::where('user_id', $user->id)->first();
        $brand = Brand::where('id', $client->brand_id)->first();
        $quotations = Quotation::with(['brand' => function ($query) {
            $query->select('id', 'description', 'photo');
        }, 'stadium', 'location', 'team', 'league'])->where('brand_id', $brand->id)->take(5)->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => true, 'data' => $quotations], 200);
    }
    public function index_by_client(Request $request)
    {
        //
        $user = $request->user();
        $client = Client::where('user_id', $user->id)->first();
        $brand = Brand::where('id', $client->brand_id)->first();
        $quotations = Quotation::with(['brand' => function ($query) {
            $query->select('id', 'description', 'photo');
        }, 'stadium', 'location', 'team', 'league'])->where('brand_id', $brand->id)->paginate();
        return response()->json(['status' => true, 'data' => $quotations], 200);
    }

    public function all()
    {
        $quotations = Quotation::get();
        return response()->json(['status' => true, 'data' => $quotations], 200);
    }
    public function get_quotation_by_id(Request $request, Quotation $quotation)
    {
        //
        $quotation_data = Quotation::select('id', 'description', 'price',  'brand_id', 'stadium_id', 'location_id', 'team_id', 'league_id', 'user_id')->with([
            'team' => function ($query) {
                $query->select('id', 'description', 'photo');
            },
            'league' => function ($query) {
                $query->select('id', 'description');
            },
            'location' => function ($query) {
                $query->select('id', 'description');
            },
            'stadium' => function ($query) {
                $query->select('id', 'description');
            },
            'brand' => function ($query) {
                $query->select('id', 'description', 'photo');
            },
            'user' => function ($query) {
                $query->select('id', 'names', 'surnames', 'email');
            }
        ])->find($quotation->id);
        return response()->json(['status' => true, 'data' => $quotation_data], 200);
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
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $request->price], 400);
        }
        try {
            //code...
            $quotation = Quotation::create([
                'price' => $request->price,
                'description' => $request->description,
            ]);
            $quotation->user()->associate($request->user());
            $quotation->brand()->associate($request->brand_id);
            if ($request->stadium_id) $quotation->stadium()->associate($request->stadium_id);
            if ($request->location_id) $quotation->location()->associate($request->location_id);
            if ($request->team_id) $quotation->team()->associate($request->team_id);
            if ($request->league_id) $quotation->league()->associate($request->league_id);
            $quotation->save();
            return response()->json(['status' => true, 'data' => $quotation], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
