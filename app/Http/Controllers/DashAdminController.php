<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Account;
use Illuminate\Http\Request;


class DashAdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect('/')->with('error', 'Mau ngapain bang');
        }

        $totalUangMasuk = 5000000;
        $totalMember = Account::where('role', 'Member')->count();
        $totalNonMember = Account::where('role', 'Non Member')->count();

        return view('adminbuns.dashboard', compact('totalUangMasuk', 'totalMember', 'totalNonMember'));
    }
}
