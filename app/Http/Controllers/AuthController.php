<?php

namespace App\Http\Controllers;

use App\Models\Logins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
        if (Auth::check()) {
            return redirect('/');
        }else{
            return view('auth.login');
        }
    }

    public function register() {
        if (Auth::check()) {
            return redirect('/');
        }else{
            return view('auth.register');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'user' => $request->input('user'),
            'password' => $request->input('password'),
        ];

        $validator = Validator::make($data, [
            'user' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator)->withInput();
        }

        if (Auth::Attempt($data)) {
            return redirect('/');
        }else{
            return back()->with('error', 'User atau Password salah!');
        }
    }

    public function actionRegister(Request $request) {
        $data = [
            'user' => $request->input('user'),
            'password' => $request->input('password'),
        ];

        $validator = Validator::make($data, [
            'user' => ['required', 'string', 'max:50', 'unique:logins'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator)->withInput();
        }

        Logins::create([
            'user' => $data['user'],
            'password' => Hash::make($data['password']),
        ]);
        
        return redirect('/login');
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
