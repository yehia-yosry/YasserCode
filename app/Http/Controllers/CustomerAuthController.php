<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;
class CustomerAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.customer-register');
    }

    public function register(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $fname = $request->input('firstname');
        $lname = $request->input('lastname');
        $phone = $request->input('phone');
        $address = $request->input('address');

        if (!preg_match('/^01[0-9]{9}$/', $phone)) {
            return back()
                ->with('error', 'Invalid Phone Number. Must be 11 digits starting with 01.')
                ->withInput();
        }

        $check = DB::select("SELECT COUNT(*) as total FROM CUSTOMER WHERE Username=? OR Email=?", [$username, $email]);

        if ($check[0]->total > 0) {
            return back()->with('error', "Username or Email already exists. Please try registering with different credentials");
        }

        DB::insert("INSERT INTO CUSTOMER(Username, Password, FirstName, LastName, Email, PhoneNumber, ShippingAddress) VALUES (?,?,?,?,?,?,?)", [$username, $password, $fname, $lname, $email, $phone, $address]);

        return redirect()->route('customer.login');
    }

    public function showLogin()
    {
        return view('auth.customer-login');
    }


    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $results = DB::select("SELECT * FROM CUSTOMER WHERE Username=?", [$username]);

        if (count($results) > 0) {
            $customer = $results[0];

            if (Hash::check($password, $customer->Password)) {
                Auth::guard('web')->loginUsingId($customer->CustomerID);
                return redirect()->route('home');
            }

            return back()->with('error', 'Incorrect Password. Please try again');
        }
        return back()->with('error', 'Invalid Credentials. Please try again or register to proceed');
    }

    public function showProfile()
    {
        $id = Auth::guard('web')->id();

        if (!$id) {
            return redirect()->route('customer.login');
        }

        $result = DB::select("SELECT * FROM CUSTOMER WHERE CustomerID=?", [$id]);

        if (count($result) == 0) {
            Auth::guard('web')->logout();
            return redirect()->route('customer.login')->with('error', 'Unable to find account');
        }

        return view('customer.profile', ['user' => $result[0]]);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::guard('web')->id();

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $fname = $request->input('firstname');
        $lname = $request->input('lastname');
        $phone = $request->input('phone');
        $address = $request->input('address');


        $validate = DB::select("SELECT COUNT(*) as total FROM CUSTOMER WHERE (Username=? or Email=?) AND CustomerID!=?", [$username, $email, $id]);

        if ($validate[0]->total > 0) {
            return back()->with('error', "Username or email is already used by another user.");
        }

        if (!empty($password)) {
            $hashed = Hash::make($password);
            DB::update("UPDATE CUSTOMER SET Username=?, Password=?, FirstName=?, LastName=?, Email=?, PhoneNumber=?, ShippingAddress=? WHERE CustomerID=?", [$username, $hashed, $fname, $lname, $email, $phone, $address, $id]);
        } else {
            DB::update("UPDATE CUSTOMER SET Username=?, FirstName=?, LastName=?, Email=?, PhoneNumber=?, ShippingAddress=? WHERE CustomerID=?", [$username, $fname, $lname, $email, $phone, $address, $id]);
        }

        return back()->with('success', 'Profile successfully updated');
    }


public function logout(Request $request): \Illuminate\Http\RedirectResponse
{
    $id = Auth::id();

    if ($id) {
        DB::delete("DELETE FROM SHOPPING_CART WHERE CustomerID = ?", [$id]);
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('customer.login');
}

}
