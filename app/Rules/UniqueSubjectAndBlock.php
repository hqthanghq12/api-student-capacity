<?php

namespace App\Rules;

use App\Models\blockSubject;
use Illuminate\Contracts\Validation\Rule;
use App\Models\subject;
use App\Models\block;
class UniqueSubjectAndBlock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $subjectId;
    private $blockId;
    public function __construct($subjectId, $blockId)
    {
        $this->subjectId = $subjectId;
        $this->blockId = $blockId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $subjectId = $this->subjectId;
        $blockId = $this->blockId;

        // Kiểm tra xem bản ghi nào trong bảng block_subject có subject_id và block_id tương ứng
        $existingRecord = BlockSubject::where('id_subject', $subjectId)
            ->where('id_block', $blockId)
            ->first();

        // Kiểm tra xem bản ghi đã tồn tại hay chưa
        return $existingRecord ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $subjectName = subject::find(request('subject_id'))->first()->name;
        $blockId =  block::find(request('block_id'))->first()->name;
        return 'Đã tồn tại môn '.$subjectName.' trong '.$blockId;
    }
}
