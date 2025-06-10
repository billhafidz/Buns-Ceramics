<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function showPaymentForm(Request $request)
    {
        if (! Session::has('subscription_data')) {
            return $this->redirectWithError('Sesi langganan tidak ditemukan. Silakan isi formulir kembali.');
        }

        $subscriptionData = Session::get('subscription_data');
        $validationError  = $this->validateSubscriptionData($subscriptionData);

        if ($validationError) {
            return $this->redirectWithError($validationError);
        }

        try {
            $invoiceData = $this->createXenditInvoice($subscriptionData);
            Session::put('xendit_invoice_id', $invoiceData['id']);
            return redirect($invoiceData['invoice_url']);
        } catch (\Exception $e) {
            return $this->redirectWithError($e->getMessage());
        }
    }

    private function validateSubscriptionData($data)
    {
        $requiredFields = ['nama_member', 'email_member', 'no_telp', 'alamat_member', 'harga_subs', 'id_account'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return "Data tidak lengkap: Field {$field} kosong. Silakan isi formulir kembali.";
            }
        }
        return null;
    }

    private function createXenditInvoice($data)
    {
        $xenditSecretKey = env('XENDIT_SECRET_KEY');
        $orderId         = 'SUB-' . time() . '-' . $data['id_account'];
        $amount          = (float) $data['harga_subs'];

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($xenditSecretKey . ':'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.xendit.co/v2/invoices', [
            'external_id'          => $orderId,
            'amount'               => $amount,
            'description'          => 'Langganan ' . $data['pilihan_subs'],
            'payer_email'          => $data['email_member'],
            'customer'             => [
                'given_names'   => $data['nama_member'],
                'email'         => $data['email_member'],
                'mobile_number' => $data['no_telp'],
                'address'       => $data['alamat_member'],
            ],
            'success_redirect_url' => route('payment.success'),
            'failure_redirect_url' => route('payment.failure'),
            'currency'             => 'IDR',
            'items'                => [
                [
                    'name'     => $data['pilihan_subs'],
                    'quantity' => 1,
                    'price'    => $amount,
                    'category' => 'Subscription',
                ],
            ],
        ]);

        if ($response->failed()) {
            throw new \Exception('Xendit API Error: ' . $response->body());
        }

        return $response->json();
    }

    private function redirectWithError($message)
    {
        Log::error('XENDIT ERROR: ' . $message);
        return redirect()->route('subscribe')->with('error', $message);
    }

    public function handleNotification(Request $request)
    {
        try {
            $xenditCallbackToken = env('XENDIT_CALLBACK_TOKEN');
            $callbackToken       = $request->header('x-callback-token');

            if ($callbackToken !== $xenditCallbackToken) {
                Log::error('XENDIT ERROR: Invalid callback token');
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
            }

            $payload = $request->all();
            Log::info("XENDIT NOTIFICATION: Received payment notification", $payload);

            if ($payload['status'] === 'PAID') {
                $this->processSuccessfulPaymentWebhook($payload);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error("XENDIT NOTIFICATION ERROR: {$e->getMessage()}");
            return response()->json(['status' => 'error', 'message' => 'System error'], 500);
        }
    }

    private function processSuccessfulPaymentWebhook($payload)
    {
        $externalId     = $payload['external_id'];
        $paymentChannel = $payload['payment_channel'] ?? 'UNKNOWN';

        $transaction = Transaction::where('order_id', $externalId)->first();

        if ($transaction) {
            if ($transaction->payment_method !== $paymentChannel) {
                $transaction->payment_method = $paymentChannel;
                $transaction->save();

                Log::info("XENDIT: Transaksi {$externalId} diupdate payment_method menjadi {$paymentChannel}");
            }
        } else {
            Log::warning("XENDIT: Transaksi dengan order_id {$externalId} tidak ditemukan saat webhook.");
        }
    }

    public function paymentSuccess(Request $request)
    {
        $invoiceId        = Session::get('xendit_invoice_id');
        $subscriptionData = Session::get('subscription_data');

        if (! $subscriptionData || ! $invoiceId) {
            return redirect()->route('subscribe')->with('error', 'Data pembayaran tidak ditemukan atau sesi habis.');
        }

        try {
            DB::beginTransaction();

            $member = Member::updateOrCreate(
                ['id_account' => $subscriptionData['id_account']],
                [
                    'nama_member'   => $subscriptionData['nama_member'],
                    'alamat_member' => $subscriptionData['alamat_member'],
                    'no_telp'       => $subscriptionData['no_telp'],
                    'email_member'  => $subscriptionData['email_member'],
                    'day'           => $subscriptionData['pilihan_hari'],
                ]
            );

            $paymentMethod = 'SABAR BANG, KALO GA KEUBAH WEBHOOKNYA YANG MASALAH BUKAN KODENYA';

            $xenditSecretKey = env('XENDIT_SECRET_KEY');
            $invoiceResponse = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($xenditSecretKey . ':'),
            ])->get("https://api.xendit.co/v2/invoices/{$invoiceId}");

            if ($invoiceResponse->successful()) {
                $invoiceData = $invoiceResponse->json();
                if (isset($invoiceData['payment_channel'])) {
                    $paymentMethod = $invoiceData['payment_channel'];
                }
            }

            $now      = Carbon::now();
            $duration = (int) $subscriptionData['pilihan_hari'];

            Transaction::create([
                'nama_kelas'        => $subscriptionData['pilihan_subs'],
                'total_transaksi'   => $subscriptionData['harga_subs'],
                'id_pelanggan'      => $member->id_member,
                'tanggal_transaksi' => $now,
                'order_id'          => $invoiceId,
                'payment_method'    => $paymentMethod,
                'ended_date'        => $now->copy()->addDays($duration),
            ]);

            $account = Account::find($subscriptionData['id_account']);
            if ($account) {
                $account->role = 'Member';
                $account->save();
            }

            session(['user' => $account]);

            DB::commit();

            Session::forget('subscription_data');
            Session::forget('xendit_invoice_id');

            return view('payment.success', compact('invoiceId'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error menyimpan data pembayaran: ' . $e->getMessage());
            return redirect()->route('subscribe')->with('error', 'Gagal menyimpan data pembayaran.');
        }
    }

    public function paymentFailure(Request $request)
    {
        return view('payment.failure');
    }
}
