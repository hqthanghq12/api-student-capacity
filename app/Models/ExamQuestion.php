<?php

namespace App\Models;

use App\Services\Traits\UsesExamConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory, UsesExamConnection;
    protected $table = 'exam_questions';

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
