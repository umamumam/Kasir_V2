<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;
use App\Models\MenuRole;

class MenuRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan role dan menu yang akan digunakan sudah ada di database

        // Ambil role berdasarkan nama
        $adminRole = Role::where('name', 'admin')->first();
        $kasirRole = Role::where('name', 'kasir')->first();

        // Ambil menu berdasarkan nama
        $dashboardMenu = Menu::where('name', 'Dashboard')->first();
        $userManagementMenu = Menu::where('name', 'Manajemen User')->first();
        $transactionMenu = Menu::where('name', 'Transaksi')->first();

        // Pastikan data menu dan role ditemukan, jika tidak akan menghindari error saat insert
        if ($adminRole && $kasirRole) {
            if ($dashboardMenu) {
                MenuRole::create([
                    'menu_id' => $dashboardMenu->id,
                    'role_id' => $adminRole->id,
                ]);
            }

            if ($userManagementMenu) {
                MenuRole::create([
                    'menu_id' => $userManagementMenu->id,
                    'role_id' => $adminRole->id,
                ]);
            }

            if ($transactionMenu) {
                MenuRole::create([
                    'menu_id' => $transactionMenu->id,
                    'role_id' => $kasirRole->id,
                ]);
            }
        }
    }
}
