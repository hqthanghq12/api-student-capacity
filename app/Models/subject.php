<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $table = "subject";
    protected $fillable = ['name'];
    public function semester_subject()
    {
        return $this->belongsToMany(semeter::class, 'semester_subject', 'id_subject', 'id_semeter');
    }
//    public function block()
//    {
//        return $this->hasOne(block::class, 'id', 'id_block');
//    }

    public function block_subject()
    {
        return $this->hasMany(blockSubject::class, 'id_subject', 'id');
    }

}
