<?php

namespace App\Http\Controllers;

use App\Ad;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        if($user = Auth::user()) {
            return redirect('/ad');
        }
        return view('index');
    }

    public function auth(Request $request) {
        $data = $request->all();
        $user = User::where('login', '=', $data['login'])->first();
        if(!$user){
            User::create([
                'login' => $data['login'],
                'password' => bcrypt($data['password'])
            ]);
        }
        Auth::attempt($data);
        if(Auth::user()) {
            return redirect('/ad');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}
