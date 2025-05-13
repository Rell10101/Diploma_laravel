<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    public $timestamps = false;

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    // Определяем связь с моделью User
    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_id'); // 'executor' - это поле в таблице Requests
    }

}
