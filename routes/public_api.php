<?php

use App\Events\ChatSupportEvent;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\ContestController as AdminContestController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\playtopicController;
use App\Http\Controllers\Admin\PoetryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\RankUserController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\SemeterController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\subjectController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TakeExamController as AdminTakeExamController;

Route::get('users', [AdminUserController::class, 'index']); // danh sách user

Route::prefix('capacity')->group(function () {
    Route::get('', [AdminContestController::class, 'apiIndexCapacity'])->name('capacity.api.index');
    Route::get('{id}', [AdminContestController::class, 'apiShowCapacity'])->name('capacity.api.show');
    Route::get('user-top/{id}', [AdminContestController::class, 'userTopCapacity']);
    Route::get('{id}/related', [AdminContestController::class, 'apiContestRelated'])->name('capacity.api.related');
});

Route::prefix('subject')->group(function () {
    Route::get('', [subjectController::class, 'apiIndex'])->name('round.api.list.subject');
});

Route::prefix('semeter')->group(function () {
    Route::get('/{codeCampus}', [SemeterController::class, 'indexApi'])->name('admin.semeterApi.index');
    Route::prefix('poetry')->group(function () {
        Route::get('/{id}/{id_user}', [PoetryController::class, 'indexApi'])->name('admin.poetry.api.index');
        Route::get('oneItem/{id_poetry}', [PoetryController::class, 'oneindexApi']);
    });

    Route::prefix('playtopic')->group(function () {
        Route::get('/{id_user}/{id_poetry}/{id_campus}/{id_subject}', [playtopicController::class, 'indexApi'])->name('admin.poetryAPI.index');
    });

    Route::prefix('exams')->group(function () {
        Route::get('/{id}', [playtopicController::class, 'show'])->name('admin.poetryAPI.index');
    });

    Route::prefix('check/exams')->group(function () {
        Route::get('/{id_user}/{id_exam}', [AdminTakeExamController::class, 'checkTakeExam'])->name('admin.poetryAPI.index');
    });

});

Route::prefix('rounds')->group(function () {
    Route::get('', [RoundController::class, 'apiIndex'])->name('round.api.index');
    Route::prefix('{id}')->group(function () {
        Route::get('', [RoundController::class, 'show'])->name('round.api.show');
    });
});

Route::prefix('sliders')->group(function () {
    Route::get('', [SliderController::class, 'apiIndex'])->name('slider.api.index');
});
Route::prefix('campuses')->group(function () {
    Route::get('', [CampusController::class, 'apiIndex'])->name('campus.api.index');
});

Route::prefix('exam')->group(function () {
    Route::post('store', [ExamController::class, 'store'])->name('exam.api.store');
    Route::get('download', [ExamController::class, 'download'])->name('exam.api.download');
    Route::get('get-by-round/{id}', [ExamController::class, 'get_by_round'])->name('exam.api.get.round');
    Route::get('get-question-by-exam/{id}', [ExamController::class, 'showQuestionAnswerExams'])->name('exam.api.get.questions.exam');
    Route::get('get-history/{id}', [ExamController::class, 'getHistory']);
});

Route::prefix('questions')->group(function () {
    Route::get('', [QuestionController::class, 'indexApi'])->name('questions.api.list');
    Route::post('save-question', [QuestionController::class, 'save_questions'])->name('questions.api.save.question');
    Route::post('dettach-question', [QuestionController::class, 'remove_question_by_exams'])->name('questions.api.dettach.question');
});

Route::prefix('contest/round/{id_round}/result')->group(function () {
    Route::get('', [ResultController::class, 'indexApi']);
});



