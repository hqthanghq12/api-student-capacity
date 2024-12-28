<?php

namespace App\Services\Modules\MQuestion;

interface MQuestionInterface
{
    public function findById($id, $with = [], $select = []);

    public function findInId($id = [], $with = [], $select = []);

    public function createQuestionsAndAttchSkill($question, $skill);

    public function getAllQuestion();

    public function getQuestionSkill();

    public function getLastVersion($base_id);
}
