<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playtopic extends Model
{
    use HasFactory;

    protected $table = 'playtopic';
    protected $fillable = [
        'has_received_exam',
        'exam_name',
        'questions_order',
        'exam_time',
        'student_poetry_id',
        'rejoined_at',
        'created_at',
        'updated_at',
    ];

    public function userStudent()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function examStd()
    {
        return $this->belongsTo(Exam::class, 'id_exam', 'id');
    }

    public function subjectStd()
    {
        return $this->belongsTo(subject::class, 'id_subject', 'id');
    }

    public function poetryStd()
    {
        return $this->belongsTo(poetry::class, 'id_poetry', 'id');
    }

    public function campusName()
    {
        return $this->hasOne(Campus::class, 'id', 'id_campus');
    }

    public function resultCapacity()
    {
        return $this->hasMany(ResultCapacity::class, 'playtopic_id', 'id');
    }

    public function studentPoetry()
    {
        return $this->belongsTo(StudentPoetry::class, 'student_poetry_id', 'id');
    }
}
