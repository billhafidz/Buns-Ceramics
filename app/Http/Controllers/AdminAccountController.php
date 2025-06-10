<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Member;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $accounts = Account::with('member')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('member', function ($q) use ($search) {
                    $q->where('nama_member', 'like', '%' . $search . '%')
                        ->orWhere('email_member', 'like', '%' . $search . '%');
                })
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin-buns.users.index', compact('accounts'));
    }
}
