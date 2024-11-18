<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['activity', 'loggable_id', 'loggable_type'];

    public function loggable()
    {
        return $this->morphTo();
    }
}
