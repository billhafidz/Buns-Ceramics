<?php
namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckSubscription extends Command
{
    protected $signature   = 'subscription:check';
    protected $description = 'Cek masa aktif subscription dan kirim notifikasi jika hampir habis atau habis. Hapus member expired.';

    public function handle()
    {
        $now = Carbon::now();

        $members = Member::with('account', 'transactions')->get();

        foreach ($members as $member) {
            $lastTransaction = $member->transactions->sortByDesc('tanggal_transaksi')->first();

            if ($lastTransaction && $lastTransaction->ended_date) {
                $endedDate = Carbon::parse($lastTransaction->ended_date);
                $daysLeft  = $now->diffInDays($endedDate, false);

                Log::info("Cek member: {$member->email_member} | Tanggal Berakhir: {$endedDate->toDateString()} | Sisa Hari: {$daysLeft}");

                if ($daysLeft <= 5 && $daysLeft > 0) {
                    Mail::send('emails.subscriptionWarning', ['member' => $member], function ($message) use ($member) {
                        $message->to($member->email_member)
                            ->subject('Peringatan: Langganan Akan Segera Berakhir');
                    });

                    Log::info("Email peringatan dikirim ke {$member->email_member}");
                }

                if ($daysLeft < 0) {
                    $account = $member->account;
                    if ($account && $account->role !== 'Non Member') {
                        $account->role = 'Non Member';
                        $account->save();

                        Log::info("Role {$member->email_member} diubah jadi Non Member karena langganan habis.");
                    }

                    if ($daysLeft < -1) {
                        Log::info("Member {$member->email_member} expired > 1 hari, menghapus field day...");

                        $member->day = null;
                        $member->save();

                        Log::info("Field day untuk member {$member->email_member} berhasil dihapus (di-set null/0).");
                    }
                }
            } else {
                Log::warning("Member {$member->email_member} belum punya transaksi atau ended_date kosong.");
            }
        }

        $this->info('Cek subscription selesai.');
    }
}
