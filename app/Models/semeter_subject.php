<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semeter_subject extends Model
{
    use HasFactory;
    protected $table='semester_subject';
    protected $fillable = ['id_semeter','id_subject','status','created_at','updated_at','deleted_at'];
}
