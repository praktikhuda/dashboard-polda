<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
        $this->middleware('auth', ['only' => ['logout']]);
    }

    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'      => 'required',
            'password'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'error',
                'errors'     => $validator->errors()
            ]);
        }
        $username = $request->username;
        $user = DB::table('users')
            ->where('username', $username)
            ->first();
        if (!$user) {
            return response()->json([
                'status'    => 'error',
                'toast'     => 'Username atau password salah!',
                'resets'    => 'all'
            ]);
        }

        $credentials = [
            'username'      => $request->username,
            'password'      => $request->password
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $userName = $user->name;  // Assuming 'name' is the column that stores the user's name.

            $session = [
                'username' => $request->username,
                'name'     => $userName, // Add the user's name to the session
            ];

            Session::put($session);

            Session::put($session);
            return response()->json([
                'status'    => 'success',
                'toast'     => 'Login berhasil',
                'resets'    => 'all',
                'redirect'  => route('dashboard'),
                'name'      => $userName
            ]);
        } else {
            return response()->json([
                'status'    => 'error',
                'toast'     => 'Username atau password salah!',
                'resets'    => 'all'
            ]);
        }

        return response()->json([
            'status'    => 'error',
            'toast'     => 'Login gagal, silahkan tunggu beberapa saat lagi atau hubungi administrator'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'status'    => 'success',
            'toast'     => 'Logout berhasil',
            'redirect'  => route('auth.login')
        ]);
    }
}
