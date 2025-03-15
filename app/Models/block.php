<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class block extends Model
{
    use HasFactory;
    protected $table = 'block_semeter';
    protected $fillable = ['name','id_semeter'];

    public function semeterOne(){
        return $this->hasOne(semeter::class,'id','id_semeter');
    }
}
