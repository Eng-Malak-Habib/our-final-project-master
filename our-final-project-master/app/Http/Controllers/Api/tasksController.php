<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tasks;
use Illuminate\Support\Carbon;
use App\Http\Resources\tasksResource;
use App\Http\Resources\orignal_form_tasks;
use DB;

class tasksController extends Controller
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
            'message' => 'tasks viewed successfully',
            'data' => tasksResource::collection(tasks::all())
        ]);
    }
    public function originalFormat($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'tasks viewed successfully',
            'data' => orignal_form_tasks::collection(tasks::all()->where('Lawyer_id', $Lawyer_id))
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
            'Title' => 'required',
            'StartTime' => 'required',
            'Date' => 'required',
            'Lawyer_id' => 'required',
        ]);
        $start = date("H:i:s", strtotime($request->StartTime));
        $end = date("H:i:s", strtotime($request->EndTime));
        tasks::insert([
            'Title' => $request->Title,
            'Date' => $request->Date,
            'StartTime' => $start,
            'EndTime' => $end,
            'Description' => $request->Description,
            'Lawyer_id' => $request->Lawyer_id,
            'created_at' => Carbon::now(),
        ]);
        return response()->json([
            'status' => 'true',
            'message' => 'task inserted successfully',
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
            'message' => 'task viewed successfully',
            'data' => tasksResource::collection(tasks::all()->where('id', $id))
        ]);
    }

    public function search($Date)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'task viewed successfully',
            'data' => tasksResource::collection(tasks::all()->where('Date', $Date))
        ]);
    }
    public function foriegn($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'task viewed successfully',
            'data' => tasksResource::collection(tasks::all()->where('Lawyer_id', $Lawyer_id))
        ]);
    }

    public function patternsearch($Title)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'task viewed successfully',
            'data' => tasks::query()
                ->where('Title', 'LIKE', "%" . $Title . "%")
                ->orWhere('Title', 'LIKE', "%" . ucfirst($Title) . "%")
                ->orWhere('Title', 'LIKE', "%" . strtolower($Title) . "%")
                ->orWhere('Title', 'LIKE', "%" . strtoupper($Title) . "%")
                ->get()
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
            'Title' => 'required',
            'StartTime' => 'required',
            'Date' => 'required',
            'Lawyer_id' => 'required',
        ]);
        $data = array();
        $data['Title'] = $request->Title;
        $data['Date'] = $request->Date;
        $data['StartTime'] = $request->StartTime;
        $data['EndTime'] = $request->EndTime;
        $data['Description'] = $request->Description;
        $data['Lawyer_id'] = $request->Lawyer_id;
        DB::table('tasks')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'task updated successfully',
            'data' => tasksResource::collection(tasks::all()->where('id', $id))
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
        $delete = tasks::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'task deleted successfully',
            'data' => null
        ]);
    }
}
