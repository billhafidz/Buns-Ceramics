<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index() {
        $langganans = \App\Models\Langganan::all();
        return view('classes', compact('langganans'));
    }
}
