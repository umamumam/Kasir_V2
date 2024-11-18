<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;

class TransaksiController extends Controller
{
    // Fungsi untuk menampilkan daftar transaksi
    public function index()
    {
        $transaksis = Transaksi::all();
        return view('transaksi.index', compact('transaksis'));
    }

    // Fungsi untuk membuat transaksi baru
    public function create()
    {
        // Ambil data produk
        $produks = Produk::all();

        // Ambil tanggaltransaksi hari ini dalam format YYYYMMDD
        $today = now()->format('Ymd');

        // Cari transaksi terakhir dengan kode yang sama (tanggaltransaksi yang sama)
        $lastTransaction = Transaksi::where('kode', 'like', $today . '%')
            ->orderBy('kode', 'desc')
            ->first();

        // Tentukan nomor urut
        $lastNumber = $lastTransaction ? (int) substr($lastTransaction->kode, -2) : 0;
        $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

        // Gabungkan kode transaksi baru
        $kodeTransaksi = $today . '/' . $newNumber;

        // Kirim data produk dan kode transaksi ke view
        return view('transaksi.create', compact('produks', 'kodeTransaksi'));
    }

    // Fungsi untuk menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:transaksis',
            'produk_id' => 'required|array',
            'jumlah' => 'required|array',
            'bayar' => 'required|numeric',
            'tanggaltransaksi' => 'nullable|date',
        ]);

        // Buat transaksi baru
        $transaksi = new Transaksi();
        $transaksi->kode = $request->kode;
        $transaksi->total = 0; // Akan dihitung setelah detail transaksi disimpan
        $transaksi->bayar = $request->bayar;
        $transaksi->kembalian = 0; // Akan dihitung setelah total dihitung
        $transaksi->tanggaltransaksi = $request->tanggaltransaksi ?: now(); // Jika tidak ada tanggaltransaksi, gunakan tanggaltransaksi sekarang
        $transaksi->save();

        // Menambahkan log untuk transaksi baru
        Log::create([
            'activity' => 'Transaksi baru dibuat: ' . $transaksi->kode,
            'loggable_type' => Transaksi::class,
            'loggable_id' => $transaksi->id,
        ]);

        // Simpan detail transaksi
        $total = 0;
        foreach ($request->produk_id as $index => $produk_id) {
            $produk = Produk::find($produk_id);
            $jumlah = $request->jumlah[$index];

            // Mengurangi stok produk
            if ($produk->stok >= $jumlah) {
                $produk->stok -= $jumlah;
                $produk->save();
            } else {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk produk ' . $produk->nama);
            }

            $subtotal = $produk->harga_jual * $jumlah;
            $total += $subtotal;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produk_id,
                'harga' => $produk->harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ]);
        }

        // Update total dan kembalian
        $transaksi->total = $total;
        $transaksi->kembalian = $request->bayar - $total;
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dilakukan');
    }

    // Fungsi untuk menampilkan form edit transaksi
    public function edit(Transaksi $transaksi)
    {
        $produks = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'produks'));
    }

    // Fungsi untuk update transaksi
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'kode' => 'required',
            'produk_id' => 'required|array',
            'jumlah' => 'required|array',
            'bayar' => 'required|numeric',
            'tanggaltransaksi' => 'nullable|date',
        ]);

        // Menyimpan log sebelum update
        Log::create([
            'activity' => 'Transaksi diperbarui: ' . $transaksi->kode,
            'loggable_type' => Transaksi::class,
            'loggable_id' => $transaksi->id,
        ]);

        // Hapus detail transaksi lama
        $old_details = DetailTransaksi::where('transaksi_id', $transaksi->id)->get();

        // Kembalikan stok produk yang dibatalkan
        foreach ($old_details as $detail) {
            $produk = Produk::find($detail->produk_id);
            $produk->stok += $detail->jumlah;
            $produk->save();
        }

        // Hapus detail transaksi lama
        DetailTransaksi::where('transaksi_id', $transaksi->id)->delete();

        // Update transaksi
        $transaksi->kode = $request->kode;
        $transaksi->total = 0;
        $transaksi->bayar = $request->bayar;
        $transaksi->kembalian = 0;
        $transaksi->tanggaltransaksi = $request->tanggaltransaksi ?: $transaksi->tanggaltransaksi;
        $transaksi->save();

        // Simpan detail transaksi baru
        $total = 0;
        foreach ($request->produk_id as $index => $produk_id) {
            $produk = Produk::find($produk_id);
            $jumlah = $request->jumlah[$index];

            // Mengurangi stok produk
            if ($produk->stok >= $jumlah) {
                $produk->stok -= $jumlah;
                $produk->save();
            } else {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk produk ' . $produk->nama);
            }

            $subtotal = $produk->harga_jual * $jumlah;
            $total += $subtotal;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produk_id,
                'harga' => $produk->harga_jual,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ]);
        }

        // Update total dan kembalian
        $transaksi->total = $total;
        $transaksi->kembalian = $request->bayar - $total;
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate');
    }

    // Fungsi untuk menampilkan detail transaksi
    public function show(Transaksi $transaksi)
    {
        // Mengambil data detail transaksi terkait transaksi yang dipilih
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $transaksi->id)->get();
    
        // Cek apakah detail transaksi ada
        if ($detailTransaksi->isEmpty()) {
            return redirect()->back()->with('error', 'Detail transaksi tidak ditemukan.');
        }
    
        // Menampilkan view dan mengirimkan data transaksi dan detail transaksi
        return view('transaksi.show', compact('transaksi', 'detailTransaksi'));
    }
    

    // Fungsi untuk menghapus transaksi beserta detailnya
    public function destroy(Transaksi $transaksi)
    {
        // Menyimpan log sebelum menghapus transaksi
        Log::create([
            'activity' => 'Transaksi dihapus: ' . $transaksi->kode,
            'loggable_type' => Transaksi::class,
            'loggable_id' => $transaksi->id,
        ]);

        // Hapus detail transaksi terlebih dahulu
        DetailTransaksi::where('transaksi_id', $transaksi->id)->delete();

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function cetakKuitansi($id)
    {
        // Pastikan relasi detailTransaksi dan produk di-load dengan benar
        $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);

        try {
            // Generate PDF menggunakan DomPDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transaksi.kuitansi', compact('transaksi'));

            // Untuk mengunduh otomatis PDF
            return $pdf->download('Kuitansi-' . $transaksi->kode . '.pdf');
        } catch (\Exception $e) {
            // Mengembalikan pesan error jika terjadi masalah saat mencetak PDF
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat mencetak PDF: ' . $e->getMessage()]);
        }
    }

    // public function print(Transaksi $transaksi)
    // {
    //     // Memuat view kuitansi dan mengirimkan data transaksi
    //     $pdf = Pdf::loadView('kuitansi', compact('transaksi'));

    //     // Mengirim PDF ke browser untuk dicetak
    //     return $pdf->stream('kuitansi_' . $transaksi->kode . '.pdf');
    // }
    public function print(Transaksi $transaksi)
    {
        // Pastikan detail transaksi sudah ada
        if ($transaksi->detailTransaksi->isEmpty()) {
            return redirect()->route('transaksi.index')->with('error', 'Detail transaksi tidak ditemukan.');
        }
    
        // Ganti karakter yang tidak diperbolehkan dalam nama file
        $filename = 'kuitansi_' . str_replace(['/', '\\'], '_', $transaksi->kode) . '.pdf';
    
        // Memuat view kuitansi
        $pdf = Pdf::loadView('transaksi.print', compact('transaksi'));
    
        // Mengirim PDF ke browser untuk dicetak
        return $pdf->stream($filename);
    }

}
