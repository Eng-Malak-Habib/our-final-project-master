<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\payments;
use Illuminate\Support\Carbon;
use App\Http\Resources\paymentsResource;
use DB;

class paymentsController extends Controller
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
            'message' => 'payments viewed successfully',
            'data' => paymentsResource::collection(payments::all())
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
            'Amount' => 'required',
            'Case_id' => 'required|integer',
        ]);
        payments::insert([
            'name' => $request->name,
            'Amount' => $request->Amount,
            'created_at' => Carbon::now(),
            'Note' => $request->Note,
            'Case_id' => $request->Case_id,
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'payment inserted successfully',
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
            'message' => 'payment viewed successfully',
            'data' => paymentsResource::collection(payments::all()->where('id', $id))
        ]);
    }
    public function foriegn($Case_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'payments viewed successfully',
            'data' => paymentsResource::collection(payments::all()->where('Case_id', $Case_id))
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
            'Amount' => 'required',
            'Case_id' => 'required|integer',
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['Amount'] = $request->Amount;
        $data['Note'] = $request->Note;
        $data['Case_id'] = $request->Case_id;
        DB::table('payments')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'payment updated successfully',
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
        $delete = payments::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'payment deleted successfully',
            'data' => null
        ]);
    }
}
