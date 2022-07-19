<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\investigation;
use Illuminate\Support\Carbon;
use App\Http\Resources\investigationsResource;
use DB;

class investigationsController extends Controller
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
            'message' => 'investigations viewed successfully',
            'data' => investigationsResource::collection(investigation::all())
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
            'investigation_id' => 'required|unique:investigations',
            'topic' => 'required',
            'in_Date' => 'required',
            'contender' => 'required',
            'client' => 'required',
            'Decision' => 'required',
            'Lawyer_id' => 'required|integer',
            'Case_id' => 'required|integer',
            'investigation_place_No' => 'required|integer',

        ]);
        investigation::insert([
            'investigation_id' => $request->investigation_id,
            'topic' => $request->topic,
            'created_at' => Carbon::now(),
            'in_Date' => $request->in_Date,
            'client' => $request->client,
            'contender' => $request->contender,
            'Decision' => $request->Decision,
            'Lawyer_id' => $request->Lawyer_id,
            'Case_id' => $request->Case_id,
            'Note' => $request->Note,
            'investigation_place_No' => $request->investigation_place_No,
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'investigation inserted successfully',
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
            'message' => 'investigation viewed successfully',
            'data' => investigationsResource::collection(investigation::all()->where('id', $id))
        ]);
    }

    public function fk_lawyerid($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'investigations viewed successfully',
            'data' => investigationsResource::collection(investigation::all()->where('Lawyer_id', $Lawyer_id))
        ]);
    }
    public function fk_caseid($Case_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'investigations viewed successfully',
            'data' => investigationsResource::collection(investigation::all()->where('Case_id', $Case_id))
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
        $inv = investigation::find($id);
        if (!strcasecmp($inv->investigation_id, $request->investigation_id)) {
            $validate = $request->validate([
                'investigation_id' => 'required',
                'topic' => 'required',
                'in_Date' => 'required',
                'client' => 'required',
                'contender' => 'required',
                'Decision' => 'required',
                'Lawyer_id' => 'required|integer',
                'Case_id' => 'required|integer',
                'investigation_place_No' => 'required|integer',
            ]);
        } else {
            $validate = $request->validate([
                'investigation_id' => 'required|unique:investigations',
                'topic' => 'required',
                'in_Date' => 'required',
                'contender' => 'required',
                'client' => 'required',
                'Decision' => 'required',
                'Lawyer_id' => 'required|integer',
                'Case_id' => 'required|integer',
                'investigation_place_No' => 'required|integer',
            ]);
        }


        $data = array();
        $data['investigation_id'] = $request->investigation_id;
        $data['topic'] = $request->topic;
        $data['in_Date'] = $request->in_Date;
        $data['client'] = $request->client;
        $data['contender'] = $request->contender;
        $data['Decision'] = $request->Decision;
        $data['Lawyer_id'] = $request->Lawyer_id;
        $data['Case_id'] = $request->Case_id;
        $data['Note'] = $request->Note;
        $data['investigation_place_No'] = $request->investigation_place_No;
        DB::table('investigations')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'investigation updated successfully',
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
        $delete = investigation::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'investigation deleted successfully',
            'data' => null
        ]);
    }
}
