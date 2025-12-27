<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;

class AdminAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.admin-register');
    }

    public function register(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $check = DB::select("SELECT COUNT(*) as total FROM ADMIN WHERE UserName=? OR Email=?", [$username, $email]);

        if ($check[0]->total > 0) {
            return back()->with('error', "Username or Email already exists. Please try registering with different credentials");
        }

        DB::insert("INSERT INTO ADMIN(UserName, Email, Password) VALUES (?,?,?)", [$username, $email, $password]);

        return redirect()->route('admin.login');
    }

    public function showLogin()
    {
        return view('auth.admin-login');
    }


    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $results = DB::select("SELECT * FROM ADMIN WHERE Email=?", [$email]);

        if (count($results) > 0) {
            $admin = $results[0];

            if (Hash::check($password, $admin->Password)) {
                Auth::guard('admin')->loginUsingId($admin->AdminID);
                return redirect()->route('admin.dashboard');
            }

            return back()->with('error', 'Incorrect Password. Please try again');
        }
        return back()->with('error', 'Invalid Credentials. Please try again or register to proceed');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_username']);
        return redirect()->route('admin.login');
    }
}
