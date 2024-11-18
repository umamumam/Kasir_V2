<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kode', 'harga_beli', 'harga_jual', 'stok', 'kategori_id'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class);
    }
}
