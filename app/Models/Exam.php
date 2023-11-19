<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use App\Services\Traits\UsesExamConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use SoftDeletes, UsesExamConnection;

//    protected $connection = 'exam';

    protected $table = 'exams';
    protected $fillable = ['name', 'description', 'max_ponit', 'ponit', 'external_url', 'round_id', 'time', 'time_type', "type", "status", "room_code", "room_token", "room_progress", "subject_id", "campus_id", "total_questions"];
    use HasFactory;

    protected $casts = [
//        'created_at' => FormatDate::class,
//        'updated_at' =>  FormatDate::class,
        'external_url' => FormatImageGet::class,
    ];

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function round()
    {
        return $this->hasOne(Round::class, 'id', 'round_id');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'id', 'campus_id');
    }

    public function playtopic($id_user)
    {
        return Playtopic::where('id_exam', $this->id)
            ->where('id_user',$id_user)
            ->first();
    }


    public function subject()
    {
        return $this->hasOne(subject::class, 'id', 'subject_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions', 'exam_id', 'question_id');
    }

    public function resultCapacity()
    {
        return $this->hasMany(ResultCapacity::class, 'exam_id');
    }
}
