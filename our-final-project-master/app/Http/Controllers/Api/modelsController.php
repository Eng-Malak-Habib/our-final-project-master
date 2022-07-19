<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\models;
use Illuminate\Support\Carbon;
use App\Http\Resources\modelsResource;
use Image;
use DB;
use Exception;
use Illuminate\Support\Facades\Storage;

class modelsController extends Controller
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
            'message' => 'models viewed successfully',
            'data' => modelsResource::collection(models::all())
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
            'Attachment' => 'required',
            'Lawyer_id' => 'required|integer',
        ]);

        $pos = strpos($request->Attachment, ';');
        $sub = substr($request->Attachment, 0, $pos);
        $ext = explode('/', $sub);
        $fileName = time() . "." . $ext[1];
        // $upload_path = storage_path('app/public/models/');
        // $fileURL = $upload_path . $fileName;

        $base_64 = explode(',', $request->Attachment);
        Storage::disk('s3')->put('models/' . $fileName, base64_decode($base_64[1]));
        $path = Storage::disk('s3')->url('models/' . $fileName);

        $models = new models;
        $models->name = $request->name;
        $models->Lawyer_id = $request->Lawyer_id;
        $models->Attachment = $path;
        $models->save();

        return response()->json([
            'status' => 'true',
            'message' => 'model inserted successfully',
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
            'message' => 'model viewed successfully',
            'data' => modelsResource::collection(models::all()->where('id', $id))
        ]);
    }
    public function foriegn($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => modelsResource::collection(models::all()->where('Lawyer_id', $Lawyer_id))
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
            'Lawyer_id' => 'required|integer',
        ]);

        $data = array();
        $data['name'] = $request->name;
        $data['Lawyer_id'] = $request->Lawyer_id;
        $file = $request->newAttachment;

        if ($file) {
            $pos = strpos($request->newAttachment, ';');
            $sub = substr($request->newAttachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/models/');
            // $fileURL = $upload_path . $fileName;

            $base_64 = explode(',', $request->newAttachment);
            $success = Storage::disk('s3')->put('models/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('models/' . $fileName);


            if ($success) {
                $data['Attachment'] = $path;
                $content = DB::table('models')->where('id', $id)->first();
                $oldimage = $content->Attachment;
                Storage::disk('s3')->delete(explode('com/', $oldimage)[1]);
                DB::table('models')->where('id', $id)->update($data);
            }
        } else {
            $data['Attachment'] = $request->Attachment;
            DB::table('models')->where('id', $id)->update($data);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'model updated successfully',
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
            $models = DB::table('models')->where('id', $id)->first();
            $Attachment = $models->Attachment;
            if ($Attachment) {
                Storage::disk('s3')->delete(explode('com/', $Attachment)[1]);
                DB::table('models')->where('id', $id)->delete();
            } else {
                DB::table('models')->where('id', $id)->delete();
            }
            return response()->json([
                'status' => 'true',
                'message' => 'model deleted successfully',
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
