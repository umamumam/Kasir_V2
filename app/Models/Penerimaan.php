<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    protected $table = 'penerimaan'; 
    protected $fillable = ['produk_id', 'jumlah', 'harga_jual', 'tanggal']; 

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}

