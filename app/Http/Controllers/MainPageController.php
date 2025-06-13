<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Langganan;
use app\Models\Transaction;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    public function index()
    {
        $langganans = Langganan::select('langganans.*', DB::raw('COUNT(transactions.id) as purchase_count'))
            ->leftJoin('transactions', 'langganans.pilihan_subs', '=', 'transactions.nama_kelas')
            ->groupBy('langganans.id_langganan', 'langganans.pilihan_subs', 'langganans.penjelasan_subs', 
                     'langganans.benefit_subs', 'langganans.harga_subs', 'langganans.gambar_subs',
                     'langganans.created_at', 'langganans.updated_at', 'langganans.status')
            ->orderBy('purchase_count', 'desc')
            ->orderBy('langganans.created_at', 'desc')
            ->take(3)
            ->get();

        return view('index', compact('langganans'));
    }
}
