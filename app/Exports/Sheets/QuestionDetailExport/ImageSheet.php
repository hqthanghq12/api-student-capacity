<?php

namespace App\Exports\Sheets\QuestionDetailExport;

use App\Models\QuestionImage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImageSheet implements WithTitle, WithHeadings, WithStyles, WithColumnWidths, WithMapping, FromQuery, WithDrawings, ShouldAutoSize
{

    private $questionId;

    public function __construct($questionId)
    {
        $this->questionId = $questionId;
    }

    public function title(): string
    {
        return 'Hình ảnh';
    }

    public function headings(): array
    {
        return [
            'Mã ảnh',
            'Ảnh',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function map($image): array
    {
        return [
            $image->img_code
        ];
    }

    public function query()
    {
        return QuestionImage::query()->where('question_id', $this->questionId)->orderBy('id', 'asc');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 55,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $images = $this->query()->get();
        foreach ($images as $key => $image) {
            if (!$imageResource = @imagecreatefromstring(file_get_contents($image->path))) {
                Log::error('Error loading image: ' . $image->path);
                continue;
            }
            $drawing = new MemoryDrawing();
            $drawing->setName($image->img_code);
            $drawing->setImageResource($imageResource);
            $drawing->setHeight(100);
            $drawing->setCoordinates('B' . ($key + 2));

            $drawings[] = $drawing;
        }
        return $drawings;
    }
}
