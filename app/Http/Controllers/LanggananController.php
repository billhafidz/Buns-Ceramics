<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanggananRequest;
use App\Http\Requests\UpdateLanggananRequest;
use App\Models\Langganan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LanggananController extends Controller
{
    public function index(Request $request)
    {
        if(session('user')) {
          redirect('/')->with('error', 'nyasar bang?');
        }
        if(!session('admin_logged_in')) {
          return redirect('/')->with('error', 'Mau ngapain bang');
        }
        
        $search = $request->input('search');
    
        $langganans = Langganan::when($search, function($query) use ($search) {
            return $query->where('pilihan_subs', 'like', '%'.$search.'%')
                        ->orWhere('penjelasan_subs', 'like', '%'.$search.'%')
                        ->orWhere('harga_subs', 'like', '%'.$search.'%')
                        ->orWhereJsonContains('benefit_subs', $search);
        })
        ->paginate(1)
        ->appends(['search' => $search]);

        return view('admin-buns.classes.index', compact('langganans', 'search'));
    }

    public function store(StoreLanggananRequest $request)
    {
        $data = $request->validated();
        $data['benefit_subs'] = json_encode($data['benefit_subs']);

        if ($request->hasFile('gambar_subs')) {
            $imagePath = $request->file('gambar_subs')->store('langganan_images', 'public');
            $data['gambar_subs'] = basename($imagePath);
        }

        Langganan::create($data);

        if ($request->ajax()) {
            session()->flash('success', 'Kelas berhasil ditambahkan.');
            return response()->json([
                'redirect' => route('admin-buns.classes.index')
            ]);
        }
    }

    public function edit($id)
    {
        $langganan = Langganan::findOrFail($id);
        return view('admin-buns.classes.edit', compact('langganan'));
    }

    public function update(UpdateLanggananRequest $request, $id)
    {
        $langganan = Langganan::findOrFail($id);
        $data = $request->validated();
        $data['benefit_subs'] = json_encode($data['benefit_subs']);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image == '1') {
            // Delete existing image if any
            if ($langganan->gambar_subs) {
                Storage::delete('public/langganan_images/'.$langganan->gambar_subs);
                $data['gambar_subs'] = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('gambar_subs')) {
            // Delete existing image if any
            if ($langganan->gambar_subs) {
                Storage::delete('public/langganan_images/'.$langganan->gambar_subs);
            }
            
            $imagePath = $request->file('gambar_subs')->store('langganan_images', 'public');
            $data['gambar_subs'] = basename($imagePath);
        }

        $langganan->update($data);

        if ($request->ajax()) {
            session()->flash('success', 'Kelas berhasil diperbarui.');
            return response()->json([
                'redirect' => route('admin-buns.classes.index')
            ]);
        }

        return redirect()->route('admin-buns.classes.index')
                       ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $langganan = Langganan::findOrFail($id);
        
        if ($langganan->gambar_subs) {
            Storage::delete('public/langganan_images/'.$langganan->gambar_subs);
        }
        
        $langganan->delete();

        return redirect()->route('admin-buns.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
