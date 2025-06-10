<?php

namespace App\Http\Controllers;
use App\Models\Member;
use App\Models\Account;

use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    public function index()
    {
        $accounts = Account::where('role', 'Member')->paginate(10);

        $accounts->load('member');

        return view('admin-buns.members.index', compact('accounts'));
    }
}
