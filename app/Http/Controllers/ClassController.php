<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;

class ClassController extends Controller
{
    public function index() {
        $langganans = Langganan::all();
        return view('classes', compact('langganans'));
    }
}
