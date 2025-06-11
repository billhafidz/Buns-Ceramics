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

        // Start query with active status filter
        $query = Gallery::where('status', 'active');

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis', 'like', '%' . $search . '%');
            });
        }

        // Apply type filter
        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        // Get results
        $gallery = $query->orderBy('created_at', 'desc')->get();

        return view('gallery', compact('gallery', 'members'));
    }
}
