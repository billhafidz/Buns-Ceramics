<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function view(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');

        // Tambahkan ini untuk mengambil data members
        $members = Member::all();

        $gallery = Gallery::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('jenis', 'like', '%' . $search . '%');
        })
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis', $jenis);
            })
            ->paginate(5);

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
        $data = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        // Handle file upload if a file is selected
        if ($request->hasFile('gambar')) {
            $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $path = $request->file('gambar')->storeAs('uploads/galleries', $filename, 'public');
            $data['gambar'] = $path;
        }

        // Create a new Gallery entry in the database
        Gallery::create($data);

        // Redirect back with a success message
        return redirect(route('admin-buns.gallery'))->with('success', 'Gallery berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $members = Member::all();
        return view('admin-buns.gallery.editGallery', compact('gallery', 'members')); // Kirim ke view
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
        $gallery = Gallery::findOrFail($id);

        if ($gallery->gambar && Storage::exists('public/' . $gallery->gambar)) {
            Storage::delete('public/' . $gallery->gambar);
        }

        $gallery->delete();

        return redirect()->route('admin-buns.gallery')->with('success', 'Gallery berhasil dihapus.');
    }
}
