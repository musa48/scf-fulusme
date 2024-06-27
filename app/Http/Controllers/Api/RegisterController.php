<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name'      => 'required',
            // 'email'     => 'required|email|unique:users',
            // 'password'  => 'required|min:8|confirmed'

            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'email'             => 'required|email|unique:users',
            'no_hp'             => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            // 'name'      => $request->name,
            // 'email'     => $request->email,
            // 'password'  => bcrypt($request->password)
            
            'nama_depan'      => $request->nama_depan,
            'nama_belakang'   => $request->nama_belakang,
            'email'           => $request->email,
            'no_hp'           => $request->no_hp,
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }
}
