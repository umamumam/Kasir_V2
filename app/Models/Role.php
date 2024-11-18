<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_role');
    }
}