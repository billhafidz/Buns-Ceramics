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
        $data = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
            'keep_image' => 'nullable',
        ]);

        // Ambil data gallery yang ingin diperbarui
        $gallery = Gallery::findOrFail($id);

        // Perbarui field 'nama' dan 'jenis'
        $gallery->nama = $data['nama'];
        $gallery->jenis = $data['jenis'];

        // Proses gambar baru jika ada
        if ($request->hasFile('gambar') && !$request->has('keep_image')) {
            // Hapus gambar lama jika ada
            if ($gallery->gambar && Storage::exists('public/' . $gallery->gambar)) {
                Storage::delete('public/' . $gallery->gambar);
            }

            // Simpan gambar baru
            $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $path = $request->file('gambar')->storeAs('uploads/galleries', $filename, 'public');
            $gallery->gambar = $path;  // Simpan path gambar baru
        }

        // Simpan perubahan di database
        $gallery->save();

        // Redirect ke halaman gallery dengan pesan sukses
        return redirect()->route('admin-buns.gallery')->with('success', 'Gallery berhasil diperbarui.');
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
