<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Member;

class SubscriptionController extends Controller
{
public function showForm()
{
    if (!session()->has('user')) {
        return redirect('/')->with('error', 'Silahkan login terlebih dahulu');
    }

    if (session('user')->role == 'Member') {
        return redirect('/')->with('error', 'Anda sudah menjadi member');
    }

    $user = session('user');

    $member = Member::where('id_account', $user->id_account)->first();

    $data = [
        'email_member' => $user->email ?? '',
        'id_account' => $user->id_account ?? '',
        'nama_member' => $member->nama_member ?? '',
        'alamat_member' => $member->alamat_member ?? '',
        'no_telp' => $member->no_telp ?? '',
        'langganans' => Langganan::all()->map(function ($item) {
            $item->benefit_subs = json_decode($item->benefit_subs, true) ?? [];
            return $item;
        }),
    ];

    $selectedLangganan = null;
    if (request()->has('langganan_id')) {
        $selectedLangganan = Langganan::find(request('langganan_id'));
    }

    return view('subscribe', compact('data', 'selectedLangganan'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_member' => 'required|string|max:100',
            'alamat_member' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'email_member' => 'required|email',
            'id_account' => 'required|integer',
            'langganan_id' => 'required|integer',
            'pilihan_subs' => 'required|string',
            'pilihan_hari' => 'required|in:5,15,30',
            'harga_subs' => 'required|numeric',
        ]);

        $subscriptionData = [
            ...$validated,
            'penjelasan_subs' => $request->input('penjelasan_subs', '') 
        ];

        Session::put('subscription_data', $subscriptionData);
        Session::save();

        Log::info('Subscription data stored', ['data' => $subscriptionData]);

        return redirect()->route('payment.form');
    }
}