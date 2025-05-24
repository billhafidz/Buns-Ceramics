<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;


class DashAdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect('/')->with('error', 'Mau ngapain bang');
        } else if('user' == session('user')) {
            return redirect('/')->with('error', 'nyasar bang?');
        }

        $totalUangMasuk = Transaction::sum('total_transaksi');
        $totalMember = Account::where('role', 'Member')->count();
        $totalNonMember = Account::where('role', 'Non Member')->count();

        return view('admin-buns.dashboard', compact('totalUangMasuk', 'totalMember', 'totalNonMember'));
    }
}
