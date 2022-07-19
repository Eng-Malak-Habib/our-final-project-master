<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cases;
use Illuminate\Support\Carbon;
use App\Http\Resources\casesResource;
use DB;
use Illuminate\Support\Facades\Storage;


class casesController extends Controller
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
            'message' => 'cases viewed successfully',
            'data' => casesResource::collection(cases::all())
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
            'Case_id' => 'required|unique:cases',
            'Case_type' => 'required',
            'Title' => 'required',
            'Court_no' => 'required|integer',
            'contender' => 'required',
            'client_name' => 'required',
            'Lawyer_id' => 'required|integer',
        ]);


        if ($request->Attachment) {
            $pos = strpos($request->Attachment, ';');
            $sub = substr($request->Attachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/cases/');
            // $fileURL = $upload_path . $fileName;

            $base_64 = explode(',', $request->Attachment);
            Storage::disk('s3')->put('cases/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('cases/' . $fileName);
            cases::insert([
                'Case_id' => $request->Case_id,
                'Case_type' => $request->Case_type,
                'Title' => $request->Title,
                'created_at' => Carbon::now(),
                'Court_no' => $request->Court_no,
                'Content' => $request->Content,
                'contender' => $request->contender,
                'client_name' => $request->client_name,
                'Lawyer_id' => $request->Lawyer_id,
                'Note' => $request->Note,
                'Attachment' => $request->$path,
                'status' => 'open',
            ]);
        } else {
            cases::insert([
                'Case_id' => $request->Case_id,
                'Case_type' => $request->Case_type,
                'Title' => $request->Title,
                'created_at' => Carbon::now(),
                'Court_no' => $request->Court_no,
                'Content' => $request->Content,
                'contender' => $request->contender,
                'client_name' => $request->client_name,
                'Lawyer_id' => $request->Lawyer_id,
                'Note' => $request->Note,
                'status' => 'open',
            ]);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'case inserted successfully',
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
            'message' => 'case viewed successfully',
            'data' => casesResource::collection(cases::all()->where('id', $id))
        ]);
    }
    public function foriegn($Lawyer_id)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => casesResource::collection(cases::all()->where('Lawyer_id', $Lawyer_id))
        ]);
    }

    public function search($Title)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'Attachment viewed successfully',
            'data' => casesResource::collection(cases::query()
                ->where('Title', 'LIKE', "%" . $Title . "%")
                ->orWhere('Title', 'LIKE', "%" . ucfirst($Title) . "%")
                ->orWhere('Title', 'LIKE', "%" . strtolower($Title) . "%")
                ->orWhere('Title', 'LIKE', "%" . strtoupper($Title) . "%")
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
        $case = cases::find($id);
        if (!strcasecmp($case->Case_id, $request->Case_id)) {
            $validate = $request->validate([
                'Case_id' => 'required',
                'Case_type' => 'required',
                'Title' => 'required',
                'Court_no' => 'required|integer',
                'contender' => 'required',
                'client_name' => 'required',
                'status' => 'required',
                'Lawyer_id' => 'required|integer',
            ]);
        } else {
            $validate = $request->validate([
                'Case_id' => 'required|unique:cases',
                'Title' => 'required',
                'Case_type' => 'required',
                'Court_no' => 'required|integer',
                'contender' => 'required',
                'client_name' => 'required',
                'status' => 'required',
                'Lawyer_id' => 'required|integer',
            ]);
        }



        if ($request->newAttachment) {
            $pos = strpos($request->newAttachment, ';');
            $sub = substr($request->newAttachment, 0, $pos);
            $ext = explode('/', $sub);
            $fileName = time() . "." . $ext[1];
            // $upload_path = storage_path('app/public/cases/');
            // $fileURL = $upload_path . $fileName;

            $base_64 = explode(',', $request->newAttachment);
            Storage::disk('s3')->put('cases/' . $fileName, base64_decode($base_64[1]));
            $path = Storage::disk('s3')->url('cases/' . $fileName);

            $content = DB::table('cases')->where('id', $id)->first();
            $oldfile = $content->Attachment;
            if ($oldfile) {
                Storage::disk('s3')->delete(explode('com/', $oldfile)[1]);
            }
            $data = array();
            $data['Case_id'] = $request->Case_id;
            $data['Case_type'] = $request->Case_type;
            $data['Title'] = $request->Title;
            $data['Court_no'] = $request->Court_no;
            $data['Content'] = $request->Content;
            $data['Lawyer_id'] = $request->Lawyer_id;
            $data['contender'] = $request->contender;
            $data['client_name'] = $request->client_name;
            $data['Note'] = $request->Note;
            $data['Attachment'] = $path;
            $data['status'] = $request->status;
            DB::table('cases')->where('id', $id)->update($data);
        } else {
            $data = array();
            $data['Case_id'] = $request->Case_id;
            $data['Case_type'] = $request->Case_type;
            $data['Title'] = $request->Title;
            $data['Court_no'] = $request->Court_no;
            $data['Content'] = $request->Content;
            $data['Lawyer_id'] = $request->Lawyer_id;
            $data['contender'] = $request->contender;
            $data['client_name'] = $request->client_name;
            $data['Note'] = $request->Note;
            $data['status'] = $request->status;
            DB::table('cases')->where('id', $id)->update($data);
        }
        return response()->json([
            'status' => 'true',
            'message' => 'case updated successfully',
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
            $models = DB::table('cases')->where('id', $id)->first();
            $Attachment = $models->Attachment;
            if ($Attachment) {
                Storage::disk('s3')->delete(explode('com/', $Attachment)[1]);
                DB::table('cases')->where('id', $id)->delete();
            } else {
                DB::table('cases')->where('id', $id)->delete();
            }
            return response()->json([
                'status' => 'true',
                'message' => 'Case deleted successfully',
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
