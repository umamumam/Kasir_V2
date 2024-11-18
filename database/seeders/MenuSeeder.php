<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Data menu untuk Admin
        DB::table('menus')->insert([
            [
                'name' => 'Dashboard',
                'url' => 'dashboard.index',
                'role' => 'admin',
                'order' => 1
            ],
            [
                'name' => 'Manajemen User',
                'url' => 'users.index',
                'role' => 'admin',
                'order' => 2
            ],
            [
                'name' => 'Manajemen Menu',
                'url' => 'menus.index',
                'role' => 'admin',
                'order' => 3
            ],
            [
                'name' => 'Penerimaan Barang',
                'url' => 'penerimaan.index',
                'role' => 'admin',
                'order' => 4
            ],
            [
                'name' => 'Kategori',
                'url' => 'kategori.index',
                'role' => 'admin',
                'order' => 5
            ],
            [
                'name' => 'Produk',
                'url' => 'produk.index',
                'role' => 'admin',
                'order' => 6
            ],
            [
                'name' => 'Log Riwayat',
                'url' => 'logs.index',
                'role' => 'admin',
                'order' => 7
            ],
            // Data menu untuk Kasir
            [
                'name' => 'Transaksi',
                'url' => 'transaksi.index',
                'role' => 'kasir',
                'order' => 1
            ]
        ]);
    }
}
