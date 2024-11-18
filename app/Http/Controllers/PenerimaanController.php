<?php

// app/Http/Controllers/PenerimaanController.php
namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Produk;
use App\Models\Log;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    // Fungsi untuk menampilkan daftar penerimaan
    public function index()
    {
        $penerimaan = Penerimaan::with('produk')->orderBy('created_at', 'desc')->get();
        return view('penerimaan.index', compact('penerimaan'));
    }

    // Fungsi untuk menampilkan form penerimaan baru
    public function create()
    {
        $produks = Produk::all();
        return view('penerimaan.create', compact('produks'));
    }

    // Fungsi untuk menyimpan penerimaan baru
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Update stok produk
        $produk->stok += $request->jumlah;
        $produk->harga_jual = $request->harga_jual;
        $produk->save();

        // Tambahkan data ke tabel penerimaan
        $penerimaan = Penerimaan::create($request->all());

        // Menambahkan log untuk penerimaan baru
        Log::create([
            'activity' => 'Penerimaan produk ditambahkan: ' . $produk->nama . ', Jumlah: ' . $request->jumlah,
            'loggable_type' => Penerimaan::class,
            'loggable_id' => $penerimaan->id,
        ]);

        return redirect()->route('penerimaan.index')->with('success', 'Penerimaan berhasil ditambahkan.');
    }
}
