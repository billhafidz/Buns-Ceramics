<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Account;
use App\Models\Member;

class AccountController extends Controller
{
    public function showProfile()
    {
        $user = session('user');
        $accountId = $user->id_account;

        $member = Member::where('id_account', $accountId)->first();
        $isMember = true;

        if (!$member) {
            $member = Account::find($accountId);
            $isMember = false;

            if (!$member) {
                return redirect('/')->with('error', 'Data akun tidak ditemukan.');
            }
        }

        return view('account.profile', compact('member', 'isMember'));
    }

public function updateProfile(Request $request)
{
    $user = session('user');
    $accountId = $user->id_account;

    $member = Member::where('id_account', $accountId)->first();

    $request->validate([
        'nama_member' => 'required|string|max:255',
        'alamat_member' => 'required|string|max:255',
        'no_telp' => 'required|string|max:20',
        'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if (!$member) {
        $account = Account::findOrFail($accountId);

        $member = new Member();
        $member->id_account = $accountId;
        $member->email_member = $account->email; // ← ini yang wajib ditambahkan
    }

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