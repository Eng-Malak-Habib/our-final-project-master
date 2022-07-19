<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\case_attachments;
use Illuminate\Support\Carbon;
use App\Http\Resources\case_attachmentsResource;
use DB;
use Exception;
use Illuminate\Support\Facades\Storage;


class case_attachmentsController extends Controller
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
            'message' => 'Attachments viewed successfully',
            'data' => case_attachmentsResource::collection(case_attachments::all())
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
            'Case_id' => 'required|integer',
        ]);
        if ($request->Attachment) {
            $pos = strpos($request->Attachment, ';');
            $sub = substr($request->Attachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/case_attach/');
            // $fileURL = $upload_path . $fileName;


            $base_64 = explode(',', $request->Attachment);
            Storage::disk('s3')->put('case_attach/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('case_attach/' . $fileName);

            $c_attachment = new case_attachments;
            $c_attachment->Case_id = $request->Case_id;
            $c_attachment->Attachment = $path;
            $c_attachment->save();
        } else {
            case_attachments::insert([
                'Case_id' => $request->Case_id,
                'created_at' => Carbon::now(),
            ]);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment inserted successfully',
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
            'message' => 'Attachment viewed successfully',
            'data' => case_attachmentsResource::collection(case_attachments::all()->where('id', $id))
        ]);
    }
    public function foriegn($Case_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => case_attachmentsResource::collection(case_attachments::all()->where('Case_id', $Case_id))
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
            'Case_id' => 'required|integer',
        ]);
        $data = array();
        $data['Case_id'] = $request->Case_id;
        $file = $request->newAttachment;

        if ($file) {
            $pos = strpos($request->newAttachment, ';');
            $sub = substr($request->newAttachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/case_attach/');
            // $fileURL = $upload_path . $fileName;


            $base_64 = explode(',', $request->newAttachment);
            $success = Storage::disk('s3')->put('case_attach/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('case_attach/' . $fileName);


            if ($success) {
                $data['Attachment'] = $path;
                $content = DB::table('case_attachments')->where('id', $id)->first();
                $oldimage = $content->Attachment;
                Storage::disk('s3')->delete(explode('com/', $oldimage)[1]);
                DB::table('case_attachments')->where('id', $id)->update($data);
            }
        } else {
            $data['Attachment'] = $request->Attachment;
            DB::table('case_attachments')->where('id', $id)->update($data);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment updated successfully',
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
            $c_attachment = DB::table('case_attachments')->where('id', $id)->first();
            $Attachment = $c_attachment->Attachment;
            if ($Attachment) {
                Storage::disk('s3')->delete(explode('com/', $Attachment)[1]);
                DB::table('case_attachments')->where('id', $id)->delete();
            } else {
                DB::table('case_attachments')->where('id', $id)->delete();
            }
            return response()->json([
                'status' => 'true',
                'message' => 'Attachment deleted successfully',
                'data' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => 'wrong id',
                'data' => null
            ]);
        }
    }
}
