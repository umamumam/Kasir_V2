<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penerimaan extends Model
{
    use HasFactory;
    protected $table = 'penerimaan';
    protected $dates = ['tanggal'];
    protected $fillable = ['produk_id', 'jumlah', 'harga_jual', 'tanggal'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
