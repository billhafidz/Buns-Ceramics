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

        return view('admin-buns.gallery.gallery', compact('gallery', 'members'));
    }

    public function store(Request $request)
    {
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'jenis' => 'required|string|in:gelas,mangkuk,piring',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10120',
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
            $gallery = Gallery::findOrFail($id);

            $gallery->nama = $request->nama;
            $gallery->jenis = $request->jenis;

            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($gallery->gambar && Storage::disk('public')->exists($gallery->gambar)) {
                    Storage::disk('public')->delete($gallery->gambar);
                }

                $path = $request->file('gambar')->store('gallery', 'public');
                $gallery->gambar = $path;
            }

            $gallery->save();

            $successMessage = 'Data gallery berhasil diperbarui!';

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
