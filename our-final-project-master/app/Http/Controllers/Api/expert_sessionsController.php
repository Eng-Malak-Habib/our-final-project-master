<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\expert_sessions;
use Illuminate\Support\Carbon;
use App\Http\Resources\expert_sessionsResource;
use Image;
use DB;
use Exception;
use Illuminate\Support\Facades\Storage;

class expert_sessionsController extends Controller
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
            'message' => 'e-sessions viewed successfully',
            'data' => expert_sessionsResource::collection(expert_sessions::all())
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
            'Office_address' => 'required',
            'present_Lawyer_name' => 'required',
            'Session_Reason' => 'required',
            'Session_date' => 'required',
            'Expert_name' => 'required',
            'Next_date' => 'required',
            'Desicion' => 'required',
            'Case_id' => 'required|integer',
        ]);
        if ($request->Attachment) {
            $pos = strpos($request->Attachment, ';');
            $sub = substr($request->Attachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/expert_sessions/');
            // $fileURL = $upload_path . $fileName;

            $base_64 = explode(',', $request->Attachment);
            Storage::disk('s3')->put('expert_sessions/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('expert_sessions/' . $fileName);


            $sessions = new expert_sessions;
            $sessions->Office_address = $request->Office_address;
            $sessions->present_Lawyer_name = $request->present_Lawyer_name;
            $sessions->Session_Reason = $request->Session_Reason;
            $sessions->Session_date = $request->Session_date;
            $sessions->Expert_name = $request->Expert_name;
            $sessions->Next_date = $request->Next_date;
            $sessions->Desicion = $request->Desicion;
            $sessions->Case_id = $request->Case_id;
            $sessions->Attachment = $path;
            $sessions->save();
        } else {
            expert_sessions::insert([
                'Office_address' => $request->Office_address,
                'present_Lawyer_name' => $request->present_Lawyer_name,
                'created_at' => Carbon::now(),
                'Session_Reason' => $request->Session_Reason,
                'Session_date' => $request->Session_date,
                'Expert_name' => $request->Expert_name,
                'Next_date' => $request->Next_date,
                'Desicion' => $request->Desicion,
                'Case_id' => $request->Case_id,
            ]);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'e-session inserted successfully',
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
            'message' => 'e-session viewed successfully',
            'data' => expert_sessionsResource::collection(expert_sessions::all()->where('id', $id))
        ]);
    }
    public function foriegn($Case_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => expert_sessionsResource::collection(expert_sessions::all()->where('Case_id', $Case_id))
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
            'Office_address' => 'required',
            'present_Lawyer_name' => 'required',
            'Session_Reason' => 'required',
            'Session_date' => 'required',
            'Expert_name' => 'required',
            'Next_date' => 'required',
            'Desicion' => 'required',
            'Case_id' => 'required|integer',
        ]);

        $data = array();
        $data['Office_address'] = $request->Office_address;
        $data['present_Lawyer_name'] = $request->present_Lawyer_name;
        $data['Session_Reason'] = $request->Session_Reason;
        $data['Session_date'] = $request->Session_date;
        $data['Expert_name'] = $request->Expert_name;
        $data['Next_date'] = $request->Next_date;
        $data['Desicion'] = $request->Desicion;
        $data['Case_id'] = $request->Case_id;
        $file = $request->newAttachment;

        if ($file) {
            $pos = strpos($request->newAttachment, ';');
            $sub = substr($request->newAttachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/expert_sessions/');
            // $fileURL = $upload_path . $fileName;


            $base_64 = explode(',', $request->newAttachment);
            $success = Storage::disk('s3')->put('expert_sessions/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('expert_sessions/' . $fileName);

            if ($success) {
                $data['Attachment'] = $path;
                $content = DB::table('expert_sessions')->where('id', $id)->first();
                $oldimage = $content->Attachment;
                Storage::disk('s3')->delete(explode('com/', $oldimage)[1]);
                DB::table('expert_sessions')->where('id', $id)->update($data);
            }
        } else {
            $data['Attachment'] = $request->Attachment;
            DB::table('expert_sessions')->where('id', $id)->update($data);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'e-session updated successfully',
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
        try {
            $expert_sessions = DB::table('expert_sessions')->where('id', $id)->first();
            $Attachment = $expert_sessions->Attachment;
            if ($Attachment) {
                Storage::disk('s3')->delete(explode('com/', $Attachment)[1]);
                DB::table('expert_sessions')->where('id', $id)->delete();
            } else {
                DB::table('expert_sessions')->where('id', $id)->delete();
            }
            return response()->json([
                'status' => 'true',
                'message' => 'e-session deleted successfully',
                'data' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'wrong ID',
                'data' => null
            ]);
        }
    }
}
