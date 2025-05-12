<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:account',
            'password' => 'required|string|min:6|',
        ]);

        Account::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Non Member',
        ]);

        return redirect()->route('index')->with('success', 'Register Berhasil, Silahkan Login');
    }
}
