<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $members = Member::with('account')
            ->whereHas('account', function ($query) {
                $query->where('role', 'Member');
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_member', 'like', '%' . $search . '%')
                      ->orWhere('email_member', 'like', '%' . $search . '%')
                      ->orWhere('no_telp', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin-buns.members.index', compact('members'));
    }
}
