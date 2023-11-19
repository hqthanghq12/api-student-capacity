<?php

namespace App\Models;

use App\Services\Traits\UsesExamConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;

class Question extends Model
{
    use HasFactory, SoftDeletes, UsesExamConnection;
    protected $table = 'questions';
    protected $primaryKey = "id";
    public $fillable = [
        'content',
        'status',
        'type',
        'rank',
        'version',
        'created_by',
        'base_id',
        'is_current_version',
    ];
    protected $casts = [
//        'created_at' => FormatDate::class,
//        'updated_at' =>  FormatDate::class,
        // 'image' => FormatImageGet::class,
    ];
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->answers()->delete();
            $q->skills()->detach();
        });
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'question_skills', 'question_id', 'skill_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class, 'question_id');
    }

    public function resultCapacityDetail()
    {
        return $this->hasMany(ResultCapacityDetail::class, 'question_id');
    }

    public function images()
    {
        return $this->hasMany(QuestionImage::class, 'question_id');
    }

    public function versions()
    {
        return $this->where('base_id', $this->base_id)->orWhere('id', $this->base_id)->orderBy('version', 'desc')->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
