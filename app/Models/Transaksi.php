<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'total', 'bayar', 'kembalian', 'tanggaltransaksi'];
    protected $casts = [
        'tanggaltransaksi' => 'datetime',
    ];
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
