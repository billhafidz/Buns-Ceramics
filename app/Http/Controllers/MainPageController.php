<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;


class MainPageController extends Controller
{
    public function index()
{
$langganans = Langganan::take(3)->get();
        return view('index', compact('langganans'));;
}
}
