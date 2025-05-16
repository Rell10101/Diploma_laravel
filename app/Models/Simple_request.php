<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simple_request extends Model
{
    public $timestamps = false;
    
    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class);
    }
}
