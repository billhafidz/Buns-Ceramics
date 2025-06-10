<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CheckSubscriptionStatus extends Command
{
    protected $signature = 'subscription:check';
    protected $description = 'Cek status subscription dan kirim email jika mendekati ended_date, ubah role jika expired';

    public function handle()
    {
        $now = Carbon::now();
        $transactions = Transaction::with('member')->get();

        foreach ($transactions as $transaction) {
            if (!$transaction->ended_date || !$transaction->member) {
                continue;
            }

            $endedDate = Carbon::parse($transaction->ended_date);
            $account = $transaction->member->account;

            if ($now->diffInDays($endedDate, false) === 5) {
                $email = $transaction->member->email_member;

                Mail::raw("Langganan Anda akan berakhir pada {$endedDate->toDateString()}. Perpanjang segera agar tidak kehilangan akses.", function ($message) use ($email) {
                    $message->to($email)
                            ->subject('Peringatan Langganan Hampir Habis');
                });

                $this->info("Email peringatan dikirim ke: $email");
            }

            if ($now->gt($endedDate)) {
                if ($account && $account->role === 'Member') {
                    $account->role = 'Non Member';
                    $account->save();

                    $this->info("Role user ID {$account->id} diubah jadi Non Member");
                }
            }
        }

        return 0;
    }
}
