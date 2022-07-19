<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\courts;
use Illuminate\Support\Carbon;
use App\Http\Resources\courtsResource;
use DB;

class courtsController extends Controller
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
            'message' => 'courts viewed successfully',
            'data' => courtsResource::collection(courts::all())
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
            'address' => 'required',
        ]);
        courts::insert([
            'name' => $request->name,
            'address' => $request->address,
            'Longtude' => $request->Longtude,
            'Latitude' => $request->Latitude,
            'phone' => $request->phone,
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'court inserted successfully',
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
            'message' => 'court viewed successfully',
            'data' => courtsResource::collection(courts::all()->where('id', $id))
        ]);
    }
    public function search($name)
    {

        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => courtsResource::collection(courts::query()
                ->where('name', 'LIKE', "%" . $name . "%")
                ->orWhere('name', 'LIKE', "%" . ucfirst($name) . "%")
                ->orWhere('name', 'LIKE', "%" . strtolower($name) . "%")
                ->orWhere('name', 'LIKE', "%" . strtoupper($name) . "%")
                ->get())
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
            'address' => 'required',
            'Longtude' => 'double',
            'Latitude' => 'double',
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['Longtude'] = $request->Longtude;
        $data['Latitude'] = $request->Latitude;
        $data['phone'] = $request->phone;
        DB::table('courts')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'court updated successfully',
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
        $delete = courts::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'court deleted successfully',
            'data' => null
        ]);
    }
}
