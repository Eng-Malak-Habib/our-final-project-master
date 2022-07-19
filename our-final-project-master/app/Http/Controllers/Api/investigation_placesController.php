<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\investigation_place;
use Illuminate\Support\Carbon;
use App\Http\Resources\investigation_placesResource;
use DB;

class investigation_placesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 'true',
            'message' => 'investigation_places viewed successfully',
            'data' => investigation_placesResource::collection(investigation_place::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        investigation_place::insert([
            'name' => $request->name,
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'investigation_place inserted successfully',
            'data' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'investigation_place viewed successfully',
            'data' => investigation_placesResource::collection(investigation_place::all()->where('id', $id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        DB::table('investigation_place')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'investigation_place updated successfully',
            'data' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = investigation_place::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'investigation_place deleted successfully',
            'data' => null
        ]);
    }
}
