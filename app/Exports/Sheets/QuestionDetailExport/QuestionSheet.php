<?php

namespace App\Exports\Sheets\QuestionDetailExport;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionSheet implements WithTitle, WithHeadings, WithStyles, WithColumnWidths, WithMapping, FromQuery
{

    private $question;

    public function title(): string
    {
        return 'Câu hỏi';
    }

    public function __construct(
        $question
    )
    {
        $this->question = $question;
    }

    public function headings(): array
    {
        return [
            'Thể loại câu hỏi',
            'Câu hỏi',
            'Câu trả lời',
            'Đáp án đúng',
            'Mức độ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function map($question): array
    {
        $return = [];
        $answers = $question->answers->toArray();
        $firstAns = array_shift($answers);
        $return[] = [
            $question->type == config('util.INACTIVE_STATUS') ? 'Một đáp án' : 'Nhiều đáp án',
            $question->content,
            $firstAns['content'],
            $firstAns['is_correct'] ? 'Đáp án đúng' : '',
            config('util.EXCEL_QESTIONS.RANKS')[$question->rank],
        ];
        foreach ($answers as $answer) {
            $return[] = [
                '',
                '',
                $answer['content'],
                $answer['is_correct'] ? 'Đáp án đúng' : '',
                '',
            ];
        }
        return $return;
    }

    public function query()
    {
        return $this->question;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 45,
            'C' => 45,
            'D' => 20,
            'E' => 15,
        ];
    }
}
