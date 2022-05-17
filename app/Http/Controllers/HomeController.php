<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HomeController extends Controller
{ 
    public function index()
    {
        return view('login');
    }

    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required'
           ]);
           
           $user = User::where(['email'=>$request->email])->first();
           
        if(empty($user->email))
        {
            return back()->withErrors([
                'email' => ['The e-mail You enterd does not match our record.']
            ]);
        }
        if (!empty($user)) 
        {
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'password' => ['The provided password does not match our records.']
                ]);
            }

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->route('dashboard');
            }else{
                return back()->withErrors([
                    'email' => ['Please Check Your credentials.']
                ]);
            }
        }   
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
