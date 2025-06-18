<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $timestamps = false;
    
    public function location()
    {
        return $this->belongsTo(Locations::class, 'location_id');
    }

    public function equipment_type()
    {
        return $this->belongsTo(Equipment_type::class, 'equipment_type_id');
    }
}
