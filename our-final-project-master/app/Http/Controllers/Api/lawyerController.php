<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Http\Resources\lawyerResource;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\IsEmpty;

use function Symfony\Component\HttpFoundation\isEmpty;

class lawyerController extends Controller
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
            'message' => 'lawyers viewed successfully',
            'data' => lawyerResource::collection(User::all())
        ]);
        // return lawyerResource::collection(User::all());
        // $lawyer = User::all();
        // return response()->json($lawyer);
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
            'Lawyer_National_Number' => 'required|unique:users|digits:14',
            'email' => 'required|unique:users|email',
            'name' => 'required',
        ]);
        $data = array();
        $data['Lawyer_National_Number'] = $request->Lawyer_National_Number;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $request->Role == '' ? $data['Role'] = 'Lawyer' : $data['Role'] = $request->Role;
        $data['DOB'] = $request->DOB;
        $data['Gender'] = $request->Gender;
        $data['phone'] = $request->phone;
        $data['password'] = Hash::make('Avocado2022');
        $data['status'] = 'offline';

        if ($request->profile_photo_path != '') {
            $fileName = time() . ".jpg";
            Storage::disk('s3')->put('profile_images/' . $fileName, base64_decode($request->profile_photo_path));
            $path = Storage::disk('s3')->url('profile_images/' . $fileName);
            $data['profile_photo_path'] = $path;
        }
        DB::table('users')->insert($data);
        return response()->json([
            'status' => 'true',
            'message' => 'lawyer inserted successfully',
            'data' => lawyerResource::collection(User::all()->where('Lawyer_National_Number', $request->Lawyer_National_Number))
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
            'message' => 'lawyer viewed successfully',
            'data' => lawyerResource::collection(User::all()->where('id', $id))
        ]);
    }
    public function search($name)
    {
        return response()->json([
            'status' => 'true',
            'message' => 'lawyer viewed successfully',
            'data' => lawyerResource::collection(User::query()
                ->where('name', 'LIKE', "%" . $name . "%")
                ->orWhere('name', 'LIKE', "%" . ucfirst($name) . "%")
                ->orWhere('name', 'LIKE', "%" . strtolower($name) . "%")
                ->orWhere('name', 'LIKE', "%" . strtoupper($name) . "%")
                ->get())
        ]);
    }

    public function changePassword(Request $request, $id)
    {
        $validate = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|confirmed|min:8',
        ]);

        $content = DB::table('users')->where('id', $id)->first();
        $hashedPassword = $content->password;

        if (Hash::check($request->oldPassword, $hashedPassword)) {
            $data = array();
            $data['password'] = Hash::make($request->newPassword);
            DB::table('users')->where('id', $id)->update($data);

            return response()->json([
                'status' => 'true',
                'message' => 'password changed successfully',
                'data' => null,
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'oldPasswordError' => 'old password is incorrect',
                'data' => null,
            ], 422);
        }
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
        $lawyer = User::find($id);
        if (!strcasecmp($lawyer->email, $request->email)) {
            $validate = $request->validate([
                'email' => 'required|email',
            ]);
        } else {
            $validate = $request->validate([
                'email' => 'required|unique:users|email',
            ]);
        }
        if (!strcasecmp($lawyer->Lawyer_National_Number, $request->Lawyer_National_Number)) {
            $validate = $request->validate([
                'Lawyer_National_Number' => 'required|digits:14',
                'name' => 'required|string',
            ]);
        } else {
            $validate = $request->validate([
                'Lawyer_National_Number' => 'required|unique:users|digits:14',
                'name' => 'required|string',
            ]);
        }

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $request->address == '' ? 1 : $data['address'] = $request->address;
        $request->Role == '' ? 1 : $data['Role'] = $request->Role;
        $request->DOB == '' ? 1 : $data['DOB'] = $request->DOB;
        $request->Gender == '' ? 1 : $data['Gender'] = $request->Gender;
        $request->phone == '' ? 1 : $data['phone'] = $request->phone;
        $data['Lawyer_National_Number'] = $request->Lawyer_National_Number;

        if ($request->profile_photo_path != '') {
            $fileName = time() . ".jpg";
            Storage::disk('s3')->put('profile_images/' . $fileName, base64_decode($request->profile_photo_path));
            $path = Storage::disk('s3')->url('profile_images/' . $fileName);
            $data['profile_photo_path'] = $path;
        }

        DB::table('users')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'lawyer updated successfully',
            'data' => lawyerResource::collection(User::all()->where('Lawyer_National_Number', $request->Lawyer_National_Number))
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
        $delete = User::find($id)->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'lawyer deleted successfully',
            'data' => null,
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $data = array();
        $data['status'] = $request->status;
        DB::table('users')->where('id', $id)->update($data);
        return response()->json([
            'status' => 'true',
            'message' => 'status updated successfully',
            'data' => null,
        ]);
    }
}
