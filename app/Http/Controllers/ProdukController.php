<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Log; // Import Log model
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10); 
        $produks = Produk::with('kategori')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->paginate($entries)
            ->appends([
                'search' => $search,
                'entries' => $entries,
            ]);
        return view('produk.index', compact('produks'));
    }
    

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255|unique:produks,kode',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Menambahkan produk baru
        $produk = Produk::create($request->all());

        // Mencatat log untuk produk baru
        Log::create([
            'activity' => 'Produk baru ditambahkan: ' . $produk->nama,
            'loggable_type' => Produk::class,
            'loggable_id' => $produk->id,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:255|unique:produks,kode,' . $produk->id,
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Cek apakah ada perubahan pada data produk
        $produk->update($request->all());

        // Mencatat log perubahan produk
        Log::create([
            'activity' => 'Produk diperbarui: ' . $produk->nama,
            'loggable_type' => Produk::class,
            'loggable_id' => $produk->id,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        // Mencatat log sebelum menghapus produk
        Log::create([
            'activity' => 'Produk dihapus: ' . $produk->nama,
            'loggable_type' => Produk::class,
            'loggable_id' => $produk->id,
        ]);

        // Menghapus produk
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
