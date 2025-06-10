<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckSubscription extends Command
{
    protected $signature = 'subscription:check';
    protected $description = 'Cek masa aktif subscription dan kirim notifikasi jika hampir habis atau habis.';

    public function handle()
    {
        $now = Carbon::now();

        $members = Member::with('account', 'transactions')->get();

        foreach ($members as $member) {
            $lastTransaction = $member->transactions->sortByDesc('tanggal_transaksi')->first();

            if ($lastTransaction && $lastTransaction->ended_date) {
                $endedDate = Carbon::parse($lastTransaction->ended_date);
                $daysLeft = $now->diffInDays($endedDate, false);

                Log::info("Cek member: {$member->email_member} | Tanggal Berakhir: {$endedDate->toDateString()} | Sisa Hari: {$daysLeft}");

                if ($daysLeft <= 5 && $daysLeft > 0) {
                    Mail::raw("Halo {$member->nama_member}, langganan Anda akan berakhir dalam 5 hari. Jangan lupa perpanjang ya!", function ($message) use ($member) {
                        $message->to($member->email_member)
                                ->subject('Peringatan: Langganan Akan Segera Berakhir');
                    });

                    Log::info("Email peringatan dikirim ke {$member->email_member}");
                }

                // Jika masa aktif sudah habis
                if ($daysLeft < 0) {
                    $account = $member->account;
                    if ($account && $account->role !== 'Non Member') {
                        $account->role = 'Non Member';
                        $account->save();

                        Log::info("Role {$member->email_member} diubah jadi Non Member karena langganan habis.");
                    }
                }
            } else {
                Log::warning("Member {$member->email_member} belum punya transaksi atau ended_date kosong.");
            }
        }

        $this->info('Cek subscription selesai.');
    }
}
