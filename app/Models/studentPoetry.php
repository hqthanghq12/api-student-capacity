<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentPoetry extends Model
{
    use HasFactory;
    protected $table = 'student_poetry';
    protected $fillable = ['id_poetry','id_student','status','created_at','updated_at'];
    public function userStudent()
    {
        return $this->belongsTo(User::class, 'id_student', 'id');
    }

    public function poetry()
    {
        return $this->belongsTo(poetry::class, 'id_poetry', 'id');
    }

    public function playtopic(){
        return $this->hasMany(playtopic::class,'student_poetry_id','id');
    }
}
