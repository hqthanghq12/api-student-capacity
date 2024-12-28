<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuestionDetailExport implements WithMultipleSheets
{
    use Exportable;

    private $questionId;

    private $question;

//    private $model;

    public function __construct(
        $questionId,
    )
    {
        $this->questionId = $questionId;
        $this->question = Question::query()->with(['answers', 'images'])->where('id', $questionId);
    }

    public function sheets(): array
    {
        return [
            new Sheets\QuestionDetailExport\QuestionSheet($this->question),
            new Sheets\QuestionDetailExport\ImageSheet($this->questionId),
        ];
    }
}
