<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;
use App\Models\Gallery;
use App\Models\Member;

class MainPageController extends Controller
{
    public function index()
    {
        $langganans = Langganan::take(3)->get();
        return view('index', compact('langganans'));;
    }
}
