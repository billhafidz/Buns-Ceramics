<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashAdminController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect('/')->with('error', 'Mau ngapain bang');
        } else if('user' == session('user')) {
            return redirect('/')->with('error', 'nyasar bang?');
        }

        $totalUangMasuk = Transaction::sum('total_transaksi');
        $totalMember = Account::where('role', 'Member')->count();
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
            $monthlyRevenue[(int)$data->bulan] = (float)$data->total;
        }

        // Ambil 5 kelas paling sering dibeli dan jumlah transaksinya
        $topClasses = Transaction::select('nama_kelas', DB::raw('count(*) as jumlah'), DB::raw('sum(total_transaksi) as total_pendapatan'))
            ->groupBy('nama_kelas')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get();

        $labelsTopClasses = $topClasses->pluck('nama_kelas')->toArray();
        $dataTopClasses = $topClasses->pluck('jumlah')->toArray();
        $totalPendapatanClasses = $topClasses->pluck('total_pendapatan')->toArray();

        return view('admin-buns.dashboard', compact(
            'totalUangMasuk',
            'totalMember',
            'totalNonMember',
            'monthlyRevenue',
            'labelsTopClasses',
            'dataTopClasses',
            'totalPendapatanClasses'
        ));
    }
}
