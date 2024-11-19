<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supliyer extends Model
{
    use HasFactory;

    protected $table = 'supliyer'; 
    protected $fillable = ['nama', 'email', 'telepon', 'alamat']; 

}
