<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Member;

class ListGalleryController extends Controller
{
    public function view(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');

        // Ambil data members
        $members = Member::all();

        // Ambil semua data gallery 
        $gallery = Gallery::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('jenis', 'like', '%' . $search . '%');
        })
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis', $jenis);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gallery', compact('gallery', 'members'));
    }
}
