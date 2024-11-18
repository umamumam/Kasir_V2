<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'role', 'order'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }
}
