<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function success($data, $msg, $code)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $msg
        ], $code);
    }

    public function error($data = null, $msg, $code)
    {
        return response()->json([
            'status' => 'error',
            'code' => 400,
            'data' => $data,
            'message' => $msg,
        ], $code);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'dob' => 'required|date_format:Y-m-d',
            'address' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($request->all(), 'Unprocessable Entity', 400);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'dob'      => $request->dob,
            'address'  => $request->address,
            'description' => $request->description
        ]);

        return $this->success($user, 'User Created', 200);
    }

    public function show()
    {
        $users = User::paginate(20);
        return response()->json(['users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required',
            'email'       => 'required|email',
            'password'    => 'required',
            'dob'         => 'required|date_format:Y-m-d',
            'address'     => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails())
            return $this->error($request->all(), 'Unprocessable Entity to Update', 422);

        $user = User::where('id', $id)->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'dob'      => $request->dob,
            'address'  => $request->address,
            'description' => $request->description
        ]);

        return $this->success($user, 'User Updated', 200);
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return $this->success($user, 'User Deleted', 200);
        }
        return $this->error(null, 'Unable to delete', 422);
    }
}
