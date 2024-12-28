<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semeter extends Model
{
    use HasFactory;
    protected $table='semester';

    public function campus(){
        return $this->hasOne(Campus::class,'id','id_campus');
    }

    public function blocks()
    {
        return $this->hasMany(block::class, 'id_semeter', 'id');
    }
}
