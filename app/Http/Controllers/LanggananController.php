<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;

class LanggananController extends Controller
{
    public function index()
    {
        $langganans = Langganan::all();
        return view('adminbuns.classes.index', compact('langganans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pilihan_subs' => 'required|string|max:255',
            'penjelasan_subs' => 'required|string',
            'harga_subs' => 'required|numeric',
        ]);

        Langganan::create($request->all());

        return redirect()->route('adminbuns.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $langganan = Langganan::findOrFail($id);
        return view('adminbuns.classes.edit', compact('langganan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pilihan_subs' => 'required|string|max:255',
            'penjelasan_subs' => 'required|string',
            'harga_subs' => 'required|numeric',
        ]);

        $langganan = Langganan::findOrFail($id);
        $langganan->update($request->all());

        return redirect()->route('adminbuns.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $langganan = Langganan::findOrFail($id);
        $langganan->delete();

        return redirect()->route('adminbuns.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
