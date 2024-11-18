<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan penamaan default
    protected $table = 'menu_role';

    // Tentukan kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'menu_id',
        'role_id',
    ];

    /**
     * Relasi dengan model Menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Relasi dengan model Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
