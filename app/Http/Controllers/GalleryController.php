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


        $members = Member::all();

        $gallery = Gallery::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                ->orWhere('jenis', 'like', '%' . $search . '%');
        })
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis', $jenis);
            })
            ->paginate(5);


        return view('admin-buns.gallery.gallery', compact('gallery', 'members'));
    }

    public function create(Request $request)
    {

        $members = Member::all();


        return view('admin-buns.gallery.create', compact('members'));
    }



    public function store(Request $request)
    {

        $data = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        if ($request->hasFile('gambar')) {
            $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $path = $request->file('gambar')->storeAs('uploads/galleries', $filename, 'public');
            $data['gambar'] = $path;
        }


        Gallery::create($data);


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

        $data = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
            'keep_image' => 'nullable',
        ]);


        $gallery = Gallery::findOrFail($id);


        $gallery->nama = $data['nama'];
        $gallery->jenis = $data['jenis'];


        if ($request->hasFile('gambar') && !$request->has('keep_image')) {

            if ($gallery->gambar && Storage::exists('public/' . $gallery->gambar)) {
                Storage::delete('public/' . $gallery->gambar);
            }


            $filename = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $path = $request->file('gambar')->storeAs('uploads/galleries', $filename, 'public');
            $gallery->gambar = $path;
        }


        $gallery->save();


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
