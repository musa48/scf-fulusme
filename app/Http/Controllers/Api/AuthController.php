<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Mail\UserVerification;
use App\Models\User;
use DB;
use Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(10)
        ]);

        event(new Registered($user));

        return response()->json([
            'result' => 'sukses',
            'message' => 'registrasi berhasil, silakan periksa email anda untuk melakukan verifikasi'
        ], 200);
    }

    /**
    * Handle an incoming authentication request.
    */
    public function store()
    {
        if (\Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successfull authentication
            $user = User::find(\Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'result' => 'sukses',
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'result' => 'gagal',
                'message' => 'Gagal melakukan autentikasi.',
            ], 401);
        }
    }

    /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
    public function destroy(Request $request)
    {
        if (\Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'result' => 'sukses',
                'message' => 'Logged out successfully',
            ], 200);
        }
    }

    public function myInfo()
    {
        if (\Auth::user()) {
            $data = \Auth::user();

            return response()->json([
                'result' => 'sukses',
                'data' => $data
            ], 200);
        }
    }
}
