<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashAdminController extends Controller
{
    public function dashboard()
    {
        if (! session('admin_logged_in')) {
            return redirect('/')->with('error', 'Mau ngapain bang');
        } else if ('user' == session('user')) {
            return redirect('/')->with('error', 'nyasar bang?');
        }

        $totalUangMasuk = Transaction::sum('total_transaksi');
        $totalMember    = Account::where('role', 'Member')->count();
        $totalNonMember = Account::where('role', 'Non Member')->count();

        // Ambil pendapatan bulanan tahun ini
        $currentYear = Carbon::now()->year;

        $monthlyRevenueRaw = Transaction::select(
            DB::raw('MONTH(tanggal_transaksi) as bulan'),
            DB::raw('SUM(total_transaksi) as total')
        )
            ->whereYear('tanggal_transaksi', $currentYear)
            ->groupBy(DB::raw('MONTH(tanggal_transaksi)'))
            ->orderBy('bulan')
            ->get();

        // Buat array bulan 1-12 dengan default 0
        $monthlyRevenue = array_fill(1, 12, 0);

        foreach ($monthlyRevenueRaw as $data) {
            $monthlyRevenue[(int) $data->bulan] = (float) $data->total;
        }

        // Ambil 3 kelas paling sering dibeli untuk chart
        $top3Classes = Transaction::select('nama_kelas', DB::raw('count(*) as jumlah'))
            ->groupBy('nama_kelas')
            ->orderByDesc('jumlah')
            ->limit(3)
            ->get();

        $labelsTopClasses = $top3Classes->pluck('nama_kelas')->toArray();
        $dataTopClasses   = $top3Classes->pluck('jumlah')->toArray();

        // Ambil semua kelas dengan pagination untuk tabel
        $allClasses = Transaction::select(
            'nama_kelas',
            DB::raw('count(*) as jumlah'),
            DB::raw('sum(total_transaksi) as total_pendapatan')
        )
            ->groupBy('nama_kelas')
            ->orderByDesc('jumlah')
            ->paginate(5);

        return view('admin-buns.dashboard', compact(
            'totalUangMasuk',
            'totalMember',
            'totalNonMember',
            'monthlyRevenue',
            'labelsTopClasses',
            'dataTopClasses',
            'allClasses'
        ));
    }
}
