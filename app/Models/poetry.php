<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poetry extends Model
{
    use HasFactory;

    protected $table = 'poetry';
    protected $fillable = [
        'id_semeter',
        'id_block_subject',
        'room',
        'id_campus',
        'start_examination_id',
        'finish_examination_id',
        'examination_count',
        'id_class',
        'assigned_user_id',
        'status',
        'parent_poetry_id',
        'exam_date',
        'created_at',
        'updated_at',
    ];

    public function semeter()
    {
        return $this->hasOne(semeter::class, 'id', 'id_semeter');
    }

    public function subject()
    {
        return $this->hasOne(subject::class, 'id', 'id_subject');
    }

    public function classsubject()
    {
        return $this->hasOne(ClassModel::class, 'id', 'id_class');
    }

    public function playtopic()
    {
        return $this->hasOne(playtopic::class, 'id_poetry', 'id');
    }

//    public function block_subject()
//    {
//        return $this->hasOne(blockSubject::class, 'id_block_subject', 'id');
//    }
    public function block_subject()
    {
        return $this->belongsTo(blockSubject::class, 'id_block_subject', 'id');
    }

    public function student_poetry(){
        return $this->hasMany(studentPoetry::class, 'id_poetry', 'id');
    }

    public function examination()
    {
        return $this->hasOne(examination::class, 'id', 'id_examination');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'id_campus');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }

    public function child_poetry()
    {
        return $this->hasMany(poetry::class, 'parent_poetry_id');
    }

}
