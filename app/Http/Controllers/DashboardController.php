<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Penerimaan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total produk
        $totalProduk = Produk::count();

        // Pendapatan harian
        $pendapatanHarian = Transaksi::whereDate('tanggaltransaksi', Carbon::today())
            ->sum('total');

        // 5 Produk Terlaris
        $produkTerlaris = Produk::select('nama')
            ->join('detail_transaksis', 'produks.id', '=', 'detail_transaksis.produk_id')
            ->selectRaw('SUM(detail_transaksis.jumlah) as total_terjual')
            ->groupBy('produks.id', 'produks.nama')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        // Stok rendah
        $stokRendah = Produk::where('stok', '<=', 5)->get();

        // Penerimaan (5 terbaru)
        $penerimaanTerbaru = Penerimaan::with('produk')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Laporan berdasarkan tanggal yang dipilih
        $start = $request->input('start_date', Carbon::now()->startOfMonth());
        $end = $request->input('end_date', Carbon::now()->endOfMonth());

        // Konversi ke Carbon jika masih berupa string
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        // Ambil laporan transaksi dalam rentang tanggal yang ditentukan
        $laporan = Transaksi::whereDate('tanggaltransaksi', '>=', $start)
            ->whereDate('tanggaltransaksi', '<=', $end)
            ->with(['detailTransaksi.produk'])
            ->get();

        // Ambil data penjualan harian untuk grafik
        $penjualanHarian = Transaksi::selectRaw('DATE(tanggaltransaksi) as date, SUM(total) as total_penjualan')
            ->whereDate('tanggaltransaksi', '>=', $start)
            ->whereDate('tanggaltransaksi', '<=', $end)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Data untuk grafik
        $tanggal = $penjualanHarian->pluck('date');
        $penjualan = $penjualanHarian->pluck('total_penjualan');

        return view('dashboard.index', compact(
            'totalProduk',
            'pendapatanHarian',
            'produkTerlaris',
            'stokRendah',
            'penerimaanTerbaru',
            'laporan',
            'start',
            'end',
            'tanggal',  // Mengirimkan tanggal untuk grafik
            'penjualan'
        ));
    }
}
