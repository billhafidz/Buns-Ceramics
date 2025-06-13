<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (empty($credentials['username']) || empty($credentials['password'])) {
            return back()->withErrors([
                'username' => empty($credentials['username']) ? 'Username cannot be empty' : null,
                'password' => empty($credentials['password']) ? 'Password cannot be empty' : null,
            ])->withInput($request->except('password'));
        }

        $user = Account::where('username', $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            session(['user' => $user]);
            return redirect('/')->with('success', 'Berhasil login');
        }

        return back()->withErrors([
            'login' => 'The account is not registered'
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/')->with('success', 'Berhasil logout');
    }
}