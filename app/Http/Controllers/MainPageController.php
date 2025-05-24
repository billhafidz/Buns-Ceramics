<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;


class MainPageController extends Controller
{
    public function index()
{
    $wheelThrowing = Langganan::where('pilihan_subs', 'Wheel Throwing')->first();
    $handbuilding = Langganan::where('pilihan_subs', 'Handbuilding')->first();
    $painting = Langganan::where('pilihan_subs', 'Painting')->first();

    return view('index', compact('wheelThrowing', 'handbuilding', 'painting'));
}
}
