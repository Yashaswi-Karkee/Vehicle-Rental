<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class adminController extends Controller
{
    public function showAdmin()
    {
        return view('adminDashboard');
    }

    //Logout function
    public function logoutAdmin()
    {
        if (Session::has('loginEmail')) {
            Session::pull('loginEmail');
            return redirect()->to(route('homepage'))->with('success', 'Successfully logged out!');
        }
        return back()->with('fail', 'Login first');
    }

    // public function createAdminCredentials()
    // {
    //     $email = "admin@yahoo.com";
    //     $password = Hash::make("password");
    //     $admin = new Admin();
    //     $admin->email = $email;
    //     $admin->password = $password;
    //     $admin->save();
    // }
}