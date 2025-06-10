<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function showProfile()
    {
        $user      = session('user');
        $accountId = $user->id_account;

        $member   = Member::where('id_account', $accountId)->first();
        $isMember = true;

        if (! $member) {
            $member   = Account::find($accountId);
            $isMember = false;

            if (! $member) {
                return redirect('/')->with('error', 'Data akun tidak ditemukan.');
            }
        }

        return view('account.profile', compact('member', 'isMember'));
    }

    public function updateProfile(Request $request)
    {
        $user      = session('user');
        $accountId = $user->id_account;

        $member = Member::where('id_account', $accountId)->first();

        $request->validate([
            'nama_member'   => 'required|string|max:255',
            'alamat_member' => 'required|string|max:255',
            'no_telp'       => 'required|string|max:20',
            'foto_profil'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (! $member) {
            $account              = Account::findOrFail($accountId);
            $member               = new Member();
            $member->id_account   = $accountId;
            $member->email_member = $account->email;
        }

        if ($request->hasFile('foto_profil')) {
            if ($member->foto_profil) {
                Storage::delete('public/' . $member->foto_profil);
            }

            $path                = $request->file('foto_profil')->store('foto_profil', 'public');
            $member->foto_profil = $path;
        }

        $member->nama_member   = $request->nama_member;
        $member->alamat_member = $request->alamat_member;
        $member->no_telp       = $request->no_telp;
        $member->save();

        return redirect()->route('account.profile')->with('success', 'Data Berhasil Diperbarui');
    }

    public function history()
    {
        $user = session('user');
        if (! $user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $accountId = $user->id_account;
        $member    = Member::where('id_account', $accountId)->first();

        if (! $member) {
            $transactions = collect();
            return view('account.history', [
                'transactions' => \Illuminate\Pagination\Paginator::resolveCurrentPath($transactions),
                'member'       => null,
            ]);
        }

        $transactions = Transaction::where('id_pelanggan', $member->id_member)
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        return view('account.history', compact('transactions', 'member'));
    }

    public function getInvoice($order_id)
    {
        $user   = session('user');
        $member = Member::where('id_account', $user->id_account)->first();

        $transaction = Transaction::where('order_id', $order_id)
            ->where('id_pelanggan', $member->id_member)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => [
                'order_id'          => $transaction->order_id,
                'nama_kelas'        => $transaction->nama_kelas,
                'tanggal_transaksi' => $transaction->tanggal_transaksi->format('d M Y'),
                'payment_method'    => $transaction->payment_method,
                'total_transaksi'   => 'Rp ' . number_format($transaction->total_transaksi, 0, ',', '.'),
                'ended_date'        => $transaction->ended_date ? $transaction->ended_date->format('d M Y') : '-',
            ],
        ]);
    }

}
