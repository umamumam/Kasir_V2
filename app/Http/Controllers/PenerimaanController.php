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
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $entries = $request->get('entries', 10); 
        $penerimaan = Penerimaan::with('produk')
            ->when($search, function ($query, $search) {
                return $query->whereHas('produk', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->paginate($entries);
        $penerimaan->appends([
            'search' => $search,
            'entries' => $entries,
        ]);
        return view('penerimaan.index', compact('penerimaan', 'search', 'entries'));
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
            'produk_id' => 'required|array',
            'produk_id.*' => 'required|exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga_jual' => 'required|array',
            'harga_jual.*' => 'required|numeric|min:0',
            'tanggal' => 'required|array',
            'tanggal.*' => 'required|date',
        ]);
    
        foreach ($request->produk_id as $index => $produkId) {
            $produk = Produk::findOrFail($produkId);
    
            // Update stok produk
            $produk->stok += $request->jumlah[$index];
            $produk->harga_jual = $request->harga_jual[$index];
            $produk->save();
    
            // Tambahkan data ke tabel penerimaan
            $penerimaan = Penerimaan::create([
                'produk_id' => $produkId,
                'jumlah' => $request->jumlah[$index],
                'harga_jual' => $request->harga_jual[$index],
                'tanggal' => $request->tanggal[$index],
            ]);
    
            // Menambahkan log untuk penerimaan baru
            Log::create([
                'activity' => 'Penerimaan produk ditambahkan: ' . $produk->nama . ', Jumlah: ' . $request->jumlah[$index],
                'loggable_type' => Penerimaan::class,
                'loggable_id' => $penerimaan->id,
            ]);
        }
    
        return redirect()->route('penerimaan.index')->with('success', 'Penerimaan berhasil ditambahkan.');
    }
    
}
