<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        // Pastikan pengguna sudah login
        if (Auth::check()) {
            // Ambil role pengguna yang sedang login
            $userRole = Auth::user()->role;

            // Ambil menu yang sesuai dengan role pengguna
            // Menu yang diambil sesuai dengan role, urutannya berdasarkan kolom 'order'
            $menus = Menu::where('role', $userRole)->orderBy('order')->get();

            // Kirim data menu ke view
            return view('menus.index', compact('menus'));
        }

        // Jika pengguna belum login, arahkan ke halaman login
        return redirect()->route('login');
    }

    /**
     * Tampilkan form untuk menambah menu.
     */
    public function create()
    {
        return view('menus.create');
    }

    /**
     * Simpan menu baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            'role' => 'nullable|in:admin,kasir,user', // Role tertentu
        ]);
    
        Menu::create($request->all());
    
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit menu.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menus.edit', compact('menu'));
    }

    /**
     * Update menu.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Hapus menu.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}

