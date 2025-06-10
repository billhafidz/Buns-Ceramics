<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

    class AdminAccountController extends Controller
    {
        public function index()
        {
            $accounts = Member::orderBy('nama_member')->paginate(10); 
            return view('admin-buns.users.index', compact('accounts'));
        }
    }