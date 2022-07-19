<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\records;
use Illuminate\Support\Carbon;
use App\Http\Resources\recordsResource;
use Illuminate\Support\Facades\Storage;
use Image;
use DB;
use Exception;


class recordsController extends Controller
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
            'message' => 'records viewed successfully',
            'data' => recordsResource::collection(records::all())
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
            'record_id' => 'required|unique:records',
            'topic' => 'required',
            'Lawyer_id' => 'required|integer',
            // 'Case' => 'required|integer',
            'Client_name' => 'required',
            'Attachment' => 'required',
            'Contender' => 'required',
        ]);



        $pos = strpos($request->Attachment, ';');
        $sub = substr($request->Attachment, 0, $pos);
        $ext = explode('/', $sub);
        $fileName = time() . "." . $ext[1];
        // $upload_path = storage_path('app/public/records/');
        // $fileURL = $upload_path . $fileName;


        $base_64 = explode(',', $request->Attachment);
        Storage::disk('s3')->put('records/' . $fileName, base64_decode($base_64[1]));
        $path = Storage::disk('s3')->url('records/' . $fileName);


        $records = new records;
        $records->record_id = $request->record_id;
        $records->topic = $request->topic;
        $records->Lawyer_id = $request->Lawyer_id;
        $records->Case = $request->Case;
        $records->Note = $request->Note;
        $records->Client_name = $request->Client_name;
        $records->Contender = $request->Contender;
        $records->Attachment = $path;
        $records->save();

        return response()->json([
            'status' => 'true',
            'message' => 'record inserted successfully',
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
            'message' => 'record viewed successfully',
            'data' => recordsResource::collection(records::all()->where('id', $id))
        ]);
    }
    public function fk_lawyerid($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => recordsResource::collection(records::all()->where('Lawyer_id', $Lawyer_id))
        ]);
    }
    public function fk_caseid($Case)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => recordsResource::collection(records::all()->where('Case', $Case))
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
        $record = records::find($id);
        if (!strcasecmp($record->record_id, $request->record_id)) {
            $validate = $request->validate([
                'record_id' => 'required',
                'topic' => 'required',
                'Lawyer_id' => 'required|integer',
                // 'Case' => 'required|integer',
                'Client_name' => 'required',
                'Contender' => 'required',
            ]);
        } else {
            $validate = $request->validate([
                'record_id' => 'required|unique:records',
                'topic' => 'required',
                'Lawyer_id' => 'required|integer',
                // 'Case' => 'required|integer',
                'Client_name' => 'required',
                'Contender' => 'required',
            ]);
        }

        $data = array();
        $data['record_id'] = $request->record_id;
        $data['topic'] = $request->topic;
        $data['Lawyer_id'] = $request->Lawyer_id;
        $data['Case'] = $request->Case;
        $data['Client_name'] = $request->Client_name;
        $data['Contender'] = $request->Contender;
        $data['Note'] = $request->Note;
        $file = $request->newAttachment;

        if ($file) {
            $pos = strpos($request->newAttachment, ';');
            $sub = substr($request->newAttachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/records/');
            // $fileURL = $upload_path . $fileName;


            $base_64 = explode(',', $request->newAttachment);
            $success = Storage::disk('s3')->put('records/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('records/' . $fileName);



            if ($success) {
                $data['Attachment'] = $path;
                $content = DB::table('records')->where('id', $id)->first();
                $oldfile = $content->Attachment;
                Storage::disk('s3')->delete(explode('com/', $oldfile)[1]);
                DB::table('records')->where('id', $id)->update($data);
            }
        } else {
            $data['Attachment'] = $request->Attachment;
            DB::table('records')->where('id', $id)->update($data);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'record updated successfully',
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
            $records = DB::table('records')->where('id', $id)->first();
            $Attachment = $records->Attachment;
            if ($Attachment) {
                Storage::disk('s3')->delete(explode('com/', $Attachment)[1]);
                DB::table('records')->where('id', $id)->delete();
            } else {
                DB::table('records')->where('id', $id)->delete();
            }
            return response()->json([
                'status' => 'true',
                'message' => 'record deleted successfully',
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
