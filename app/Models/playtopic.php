<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playtopic extends Model
{
    use HasFactory;
    protected $table = 'playtopic';
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
        return $this->hasMany(ResultCapacity::class, 'playtopic_id','id');
    }
}
