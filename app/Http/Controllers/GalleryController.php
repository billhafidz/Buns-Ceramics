<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function view(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $perPage = 5;

        // Tambahkan ini untuk mengambil data members
        $members = Member::all();

        $gallery = Gallery::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('jenis', 'like', '%' . $search . '%');
        })
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis', $jenis);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Kirim kedua variable ke view
        return view('admin-buns.gallery.gallery', compact('gallery', 'members'));
    }

    public function create(Request $request)
    {
        // Fetch all members from the database
        $members = Member::all();

        // Pass the fetched members to the view
        return view('admin-buns.gallery.create', compact('members'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'jenis' => 'required|string|in:gelas,mangkuk,piring',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $path = $request->file('gambar')->store('gallery', 'public');

            Gallery::create([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'gambar' => $path,
            ]);

            // Pesan sukses untuk respons AJAX atau redirect
            $successMessage = 'Data gallery berhasil ditambahkan!';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }

            return redirect()->route('admin-buns.gallery')->with('success', $successMessage);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $members = Member::all();

        return view('admin-buns.gallery.editGallery', compact('gallery', 'members'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'jenis' => 'required|string|in:gelas,mangkuk,piring',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
            'remove_image' => 'nullable|in:0,1',
        ]);

        // If validation fails
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Ambil data gallery yang ingin diperbarui
            $gallery = Gallery::findOrFail($id);

            // Perbarui field 'nama' dan 'jenis'
            $gallery->nama = $request->nama;
            $gallery->jenis = $request->jenis;


            // Handle image removal
            if ($request->remove_image == '1') {
                // Remove old image if exists
                if ($gallery->gambar && Storage::disk('public')->exists($gallery->gambar)) {
                    Storage::disk('public')->delete($gallery->gambar);
                }
                $gallery->gambar = null;
            }
            // Handle new image upload
            elseif ($request->hasFile('gambar')) {
                // Remove old image if exists
                if ($gallery->gambar && Storage::disk('public')->exists($gallery->gambar)) {
                    Storage::disk('public')->delete($gallery->gambar);
                }

                // Store new image
                $path = $request->file('gambar')->store('gallery', 'public');
                $gallery->gambar = $path;
            }

            // Save changes to database
            $gallery->save();

            $successMessage = 'Gallery berhasil diperbarui.';

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }

            // If not AJAX, redirect with success message
            return redirect()->route('admin-buns.gallery')->with('success', $successMessage);
        } catch (\Exception $e) {
            // If there is an error, catch and show error message
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }

            // If not AJAX, show error and redirect back
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    public function delete($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            // Hapus file gambar dari storage
            if ($gallery->gambar && Storage::disk('public')->exists($gallery->gambar)) {
                Storage::disk('public')->delete($gallery->gambar);
            }

            $gallery->delete();

            return redirect()->route('admin-buns.gallery')->with('success', 'Data gallery berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
