<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;

class AccountController extends Controller
{
    public function showProfile()
    {
        $accountId = session('user')->id_account;

        $member = Member::where('id_account', $accountId)->first();

        if (!$member) {
            return redirect('/')->with('error', 'Data member tidak ditemukan.');
        }

        return view('account.profile', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        $accountId = session('user')->id_account;

        $member = Member::where('id_account', $accountId)->firstOrFail();

        $request->validate([
            'nama_member' => 'required|string|max:255',
            'alamat_member' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($member->foto_profil) {
                Storage::delete('public/' . $member->foto_profil);
            }

            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $member->foto_profil = $path;
        }

        $member->nama_member = $request->nama_member;
        $member->alamat_member = $request->alamat_member;
        $member->no_telp = $request->no_telp;
        $member->save();

        return redirect()->route('account.profile')->with('success', 'Data Berhasil Diperbarui');
    }
}
