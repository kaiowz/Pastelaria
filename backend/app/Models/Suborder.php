<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suborder extends Model
{
    use HasFactory;

    protected $table = 'suborders';

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }
}
