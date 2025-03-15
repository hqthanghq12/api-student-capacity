<?php

namespace App\Models;

use App\Casts\FormatImageGet;
use App\Services\Traits\UsesExamConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionImage extends Model
{
    use HasFactory, UsesExamConnection;

    protected $table = 'question_images';
    protected $casts = [
        'path' => FormatImageGet::class,
    ];
}
