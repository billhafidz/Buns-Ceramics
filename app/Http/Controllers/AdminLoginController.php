<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {

        if (Session::has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        if (Session::has('user')) {
            return redirect('/')->with('error', 'nyasar bang?');
        }
        return view('admin-buns.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_logged_in', true);
            Session::put('admin_nama', $admin->nama);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }
}
