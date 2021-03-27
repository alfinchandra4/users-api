<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function index (){
        $user = User::create([
            'name'     => '121',
            'email'    => '121',
            'password' => bcrypt('1212'),
            'dob'      => 'asd',
            'address'  => '12',
            'description' => 'qw'
        ]);
        
        if ($user) {
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => 'User created'
            ], 210);
        }
        return response()->json([
            'status' => 'success',
            'code' => $user,
            'data' => null,
            'message' => 'Unprocessable Entity'
        ], 422);
    }
}
