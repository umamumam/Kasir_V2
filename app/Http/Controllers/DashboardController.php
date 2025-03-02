<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supliyer;
use App\Models\Transaksi;
use App\Models\Penerimaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total produk
        $totalProduk = Produk::count();
        $totalSupliyer = Supliyer::count();
        $totalKategori = Kategori::count();
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
        $stokRendah = Produk::where('stok', '<=', 5)->count();

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
            
        $penerimaanTerbaru = Penerimaan::with('produk')->paginate(request('entries', 10));

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
            'tanggal',  
            'penjualan',
            'totalSupliyer',
            'totalKategori'
        ));
    }
    public function exportExcel()
    {
        $penerimaanTerbaru = Penerimaan::with('produk')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
    
        $fileName = 'Penerimaan_Terbaru_' . now()->format('Y-m-d') . '.xlsx';
    
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
    
        $headerRow = WriterEntityFactory::createRowFromArray(['No', 'Nama Produk', 'Jumlah', 'Harga Jual', 'Tanggal']);
        $writer->addRow($headerRow);
    
        foreach ($penerimaanTerbaru as $index => $penerimaan) {
            $row = WriterEntityFactory::createRowFromArray([
                $index + 1,
                $penerimaan->produk->nama ?? '-',
                $penerimaan->jumlah ?? '-',
                'Rp ' . number_format($penerimaan->harga_jual, 2),
                \Carbon\Carbon::parse($penerimaan->tanggal)->format('Y-m-d'),
            ]);
            $writer->addRow($row);
        }
    
        $writer->close();
    }

    public function exportLaporanExcel(Request $request)
    {
        $start = $request->input('start_date', Carbon::now()->startOfMonth());
        $end = $request->input('end_date', Carbon::now()->endOfMonth());
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);
        $laporan = Transaksi::whereDate('tanggaltransaksi', '>=', $start)
            ->whereDate('tanggaltransaksi', '<=', $end)
            ->with(['detailTransaksi.produk'])
            ->get();
        $fileName = 'Laporan_Transaksi_' . now()->format('Y-m-d') . '.xlsx';
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName);
        $headerRow = WriterEntityFactory::createRowFromArray(['No', 'Tanggal', 'Total Transaksi', 'Detail Produk']);
        $writer->addRow($headerRow);
        foreach ($laporan as $index => $transaksi) {
            $detailProduk = $transaksi->detailTransaksi->map(function ($detail) {
                return ($detail->produk->nama ?? '-') . ' - ' . ($detail->jumlah ?? '-') . ' item';
            })->implode(', ');

            $row = WriterEntityFactory::createRowFromArray([
                $index + 1,
                $transaksi->tanggaltransaksi->format('Y-m-d'),
                'Rp ' . number_format($transaksi->total, 2),
                $detailProduk,
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }

}
