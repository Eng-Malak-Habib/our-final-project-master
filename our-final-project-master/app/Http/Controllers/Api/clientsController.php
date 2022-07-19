<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\clients;
use Illuminate\Support\Carbon;
use App\Http\Resources\clientsResource;
use DB;

class clientsController extends Controller
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
            'message' => 'clients viewed successfully',
            'data' => clientsResource::collection(clients::all())
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
            'Client_National_Number' => 'required|unique:clients|digits:14',
            'email' => 'required|unique:clients|email',
            'name' => 'required',
            'Lawyer_id' => 'required|integer',

        ]);
        clients::insert([
            'Client_National_Number' => $request->Client_National_Number,
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'Lawyer_id' => $request->Lawyer_id,
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'client inserted successfully',
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
            'message' => 'client viewed successfully',
            'data' => clientsResource::collection(clients::all()->where('id', $id))
        ]);
    }
    public function foriegn($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => clientsResource::collection(clients::all()->where('Lawyer_id', $Lawyer_id))
        ]);
    }

    public function search($name)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => clientsResource::collection(clients::query()
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
        $clients = clients::find($id);
        if (!strcasecmp($clients->email, $request->email)) {
            $validate = $request->validate([
                'email' => 'required|email',
            ]);
        } else {
            $validate = $request->validate([
                'email' => 'required|unique:clients|email',
            ]);
        }
        if (!strcasecmp($clients->Client_National_Number, $request->Client_National_Number)) {
            $validate = $request->validate([
                'Client_National_Number' => 'required|digits:14',
                'name' => 'required|string',
                'Lawyer_id' => 'required|integer',
            ]);
        } else {
            $validate = $request->validate([
                'Client_National_Number' => 'required|unique:clients|digits:14',
                'name' => 'required|string',
                'Lawyer_id' => 'required|integer',
            ]);
        }

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['Lawyer_id'] = $request->Lawyer_id;
        $data['Client_National_Number'] = $request->Client_National_Number;
        DB::table('clients')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'client updated successfully',
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
        $delete = clients::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'client deleted successfully',
            'data' => null
        ]);
    }
}
