<?php

namespace App\Http\Controllers;

use App\Http\Requests\accountRequest;
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

    public function updateProfile(accountRequest $request)
    {
        $accountId = session('user')->id_account;
        $member = Member::where('id_account', $accountId)->firstOrFail();

        // Handle profile image deletion
        if ($request->delete_image == '1') {
            if ($member->foto_profil) {
                Storage::delete('public/' . $member->foto_profil);
                $member->foto_profil = null;
            }
        }

        // Handle new profile image upload
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

        return redirect()->route('account.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}