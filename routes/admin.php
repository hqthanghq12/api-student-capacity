<?php

use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\RoundController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\SendMailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PrintPDFController;
use App\Http\Controllers\Admin\PrintExcelController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\subjectController;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\SemeterController;
use App\Http\Controllers\Admin\PoetryController;
use App\Http\Controllers\Admin\studentPoetryController;
use App\Http\Controllers\Admin\playtopicController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\chartController;
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::prefix('dashboard')->group(function () {
    Route::get('api-cuoc-thi', [DashboardController::class, 'chartCompetity'])->name('dashboard.chart-competity');
    Route::get('rank-contest', [DashboardController::class, 'getRankContest']);

});

// Route rounds
//Route::prefix('rounds')->group(function () {
//
//    Route::get('', [RoundController::class, 'index'])->name('admin.round.list')->middleware('role_admin');
//
//
//    Route::group([
//        'middleware' => 'role_admin'
//    ], function () {
//        Route::post('send-mail/{id}', [SendMailController::class, 'sendMailRoundUser'])->name('round.send.mail.pass');
//        Route::get('{id}/form-send-mail', [RoundController::class, 'sendMail'])->name('admin.round.send.mail');
      // Route::get('form-add', [RoundController::class, 'create'])->name('admin.round.create');
//        Route::get('form-add', [RoundController::class, 'creatRound'])->name('admin.round.create');
////        Route::post('form-add-save', [RoundController::class, 'store'])->name('admin.round.store');
//        Route::post('form-add-save', [RoundController::class, 'storeNew'])->name('admin.round.store');
//        Route::get('{id}/edit', [RoundController::class, 'edit'])->name('admin.round.edit');
//        Route::put('{id}', [RoundController::class, 'update'])->name('admin.round.update');
//        Route::delete('{id}', [RoundController::class, 'destroy'])->name('admin.round.destroy');
//        Route::get('round-soft-delete', [RoundController::class, 'softDelete'])->name('admin.round.soft.delete');
//        Route::get('round-soft-delete/{id}/backup', [RoundController::class, 'backUpRound'])->name('admin.round.soft.backup');
//        Route::get('round-soft-delete/{id}/delete', [RoundController::class, 'deleteRound'])->name('admin.round.soft.destroy');
//    });
//
//
//
//    Route::prefix('{id}/detail')->group(function () {
//        Route::get('', [RoundController::class, 'adminShow'])->name('admin.round.detail');
//
////        Route::prefix('exam')->group(function () {
////            Route::get('', [ExamController::class, 'index'])->name('admin.exam.index');
////            Route::get('create', [ExamController::class, 'create'])->name('admin.exam.create');
////            Route::post('store', [ExamController::class, 'store'])->name('admin.exam.store');
////            Route::get('{id_exam}/edit', [ExamController::class, 'edit'])->name('admin.exam.edit');
////            Route::post('{id_exam}/un-status', [ExamController::class, 'un_status'])->name('admin.exam.un_status');
////            Route::post('{id_exam}/re-status', [ExamController::class, 're_status'])->name('admin.exam.re_status');
////            Route::put('{id_exam}', [ExamController::class, 'update'])->name('admin.exam.update');
////        });
//
//        Route::prefix('exam')->group(function () {
//            Route::get('', [ExamController::class, 'index'])->name('admin.exam.index');
//            Route::get('create', [ExamController::class, 'create'])->name('admin.exam.create');
//            Route::post('store', [ExamController::class, 'store'])->name('admin.exam.store');
//            Route::get('{id_exam}/edit', [ExamController::class, 'edit'])->name('admin.exam.edit');
//            Route::post('{id_exam}/un-status', [ExamController::class, 'un_status'])->name('admin.exam.un_status');
//            Route::post('{id_exam}/re-status', [ExamController::class, 're_status'])->name('admin.exam.re_status');
//            Route::put('{id_exam}', [ExamController::class, 'update'])->name('admin.exam.update');
//        });
//
//        Route::prefix('result')->group(function () {
//            Route::get('', [ResultController::class, 'index'])->name('admin.result.index');
//        });
//    });
//});

//Route::prefix('contests')->group(function () {
//
//    Route::get('', [ContestController::class, 'index'])->name('admin.contest.list');
//    // Send mail method poss
//
//    Route::group([
//        'middleware' => 'role_admin'
//    ], function () {
//        Route::get('form-add', [ContestController::class, 'create'])->name('admin.contest.create');
//        Route::get('register-deadline/{id}', [ContestController::class, 'register_deadline'])->name('contest.register.deadline');
//        Route::post('send-mail/{id}', [SendMailController::class, 'sendMailContestUser'])->name('contest.send.mail.pass');
//        // Send mail method Get
//        Route::get('{id}/form-send-mail', [ContestController::class, 'sendMail'])->name('admin.contest.send.mail');
//        Route::post('form-add-save', [ContestController::class, 'store'])->name('admin.contest.store');
//        Route::post('un-status/{id}', [ContestController::class, 'un_status'])->name('admin.contest.un.status');
//        Route::post('re-status/{id}', [ContestController::class, 're_status'])->name('admin.contest.re.status');
//        Route::delete('{id}', [ContestController::class, 'destroy'])->name('admin.contest.destroy');
//        Route::get('{id}/edit', [ContestController::class, 'edit'])->name('admin.contest.edit');
//        Route::put('{id}', [ContestController::class, 'update'])->name('admin.contest.update');
//    });
//
//    Route::prefix('{id}/detail')->group(function () {
//        Route::get('', [ContestController::class, 'show'])->name('admin.contest.show');
//        Route::get('rounds', [RoundController::class, 'contestDetailRound'])->name('admin.contest.detail.round');
//    });
//    Route::group([
//        'middleware' => 'role_admin'
//    ], function () {
//        Route::get('contest-soft-delete', [ContestController::class, 'softDelete'])->name('admin.contest.soft.delete');
//        Route::get('contest-soft-delete/{id}/backup', [ContestController::class, 'backUpContest'])->name('admin.contest.soft.backup');
//        Route::get('contest-soft-delete/{id}/delete', [ContestController::class, 'deleteContest'])->name('admin.contest.soft.destroy');
//    });
//});

// subject cập nhật
Route::prefix('subject')->group(function () {
    Route::get('', [subjectController::class, 'index'])->name('admin.subject.list');
    Route::group([
        'middleware' => 'role_admin'
    ], function () {
        Route::post('form-add-subject', [subjectController::class, 'create'])->name('admin.subject.create');
        Route::get('edit/{id}', [subjectController::class, 'edit'])->name('admin.basis.edit');
        Route::put('update/{id}', [subjectController::class, 'update'])->name('admin.basis.update');
        Route::delete('delete/{id}', [subjectController::class, 'delete'])->name('admin.basis.delete');
        Route::put('now-status/{id}', [subjectController::class, 'now_status'])->name('admin.subject.un.status');
    });

    Route::prefix('exam')->group(function () {
        Route::get('/{id}', [ExamController::class, 'index'])->name('admin.exam.index');
        Route::get('create/{id}/{name}', [ExamController::class, 'create'])->name('admin.exam.create');
        Route::post('store', [ExamController::class, 'store'])->name('admin.exam.store');
        Route::get('{id_exam}/edit', [ExamController::class, 'edit'])->name('admin.exam.edit');
        Route::post('{id_exam}/un-status', [ExamController::class, 'un_status'])->name('admin.exam.un_status');
        Route::post('{id_exam}/re-status', [ExamController::class, 're_status'])->name('admin.exam.re_status');
        Route::put('{id_exam}', [ExamController::class, 'update'])->name('admin.exam.update');
    });
    Route::prefix('question')->group(function () {
        Route::get('/{id}/{id_subject}/{name}', [QuestionController::class, 'indexSubject'])->name('admin.subject.question.index');
        Route::get('edit/{id}', [QuestionController::class, 'editSubject'])->name('admin.subject.question.edit');
        Route::get('destroy/{id}/{id_exam}', [QuestionController::class, 'destroysubject'])->name('admin.subject.question.destroy');
        Route::post('un-status/{id}', [QuestionController::class, 'un_status'])->name('admin.subject.question.un.status');
        Route::post('re-status/{id}', [QuestionController::class, 're_status'])->name('admin.subject.question.re.status');
        Route::delete('delete/{id}', [QuestionController::class, 'deletesubject'])->name('admin.subject.question.delete');
        Route::get('restore-delete/{id}', [QuestionController::class, 'restoreDelete'])->name('admin.subject.question.restore');
        Route::get('soft-delete', [QuestionController::class, 'softDeleteListSubject'])->name('admin.subject.question.soft.delete');
    });
});
Route::prefix('contests')->group(function () {

    Route::get('', [ContestController::class, 'index'])->name('admin.contest.list');
    // Send mail method poss

    Route::group([
        'middleware' => 'role_admin'
    ], function () {
        Route::get('form-add', [ContestController::class, 'create'])->name('admin.contest.create');
        Route::get('register-deadline/{id}', [ContestController::class, 'register_deadline'])->name('contest.register.deadline');
        Route::post('send-mail/{id}', [SendMailController::class, 'sendMailContestUser'])->name('contest.send.mail.pass');
        // Send mail method Get
        Route::get('{id}/form-send-mail', [ContestController::class, 'sendMail'])->name('admin.contest.send.mail');
        Route::post('form-add-save', [ContestController::class, 'store'])->name('admin.contest.store');
        Route::post('un-status/{id}', [ContestController::class, 'un_status'])->name('admin.contest.un.status');
        Route::post('re-status/{id}', [ContestController::class, 're_status'])->name('admin.contest.re.status');
        Route::delete('{id}', [ContestController::class, 'destroy'])->name('admin.contest.destroy');
        Route::get('{id}/edit', [ContestController::class, 'edit'])->name('admin.contest.edit');
        Route::put('{id}', [ContestController::class, 'update'])->name('admin.contest.update');
    });

    Route::prefix('{id}/detail')->group(function () {
        Route::get('', [ContestController::class, 'show'])->name('admin.contest.show');
        Route::get('rounds', [RoundController::class, 'contestDetailRound'])->name('admin.contest.detail.round');
    });
    Route::group([
        'middleware' => 'role_admin'
    ], function () {
        Route::get('contest-soft-delete', [ContestController::class, 'softDelete'])->name('admin.contest.soft.delete');
        Route::get('contest-soft-delete/{id}/backup', [ContestController::class, 'backUpContest'])->name('admin.contest.soft.backup');
        Route::get('contest-soft-delete/{id}/delete', [ContestController::class, 'deleteContest'])->name('admin.contest.soft.destroy');
    });
});
Route::prefix('semeter')->group(function () {
    Route::get('', [SemeterController::class, 'index'])->name('admin.semeter.index');
    Route::post('form-add-subject', [SemeterController::class, 'create'])->name('admin.semeter.create');
    Route::get('edit/{id}', [SemeterController::class, 'edit'])->name('admin.semeter.edit');
    Route::put('update/{id}', [SemeterController::class, 'update'])->name('admin.semeter.update');
    Route::delete('delete/{id}', [SemeterController::class, 'delete'])->name('admin.semeter.delete');
    Route::put('now-status/{id}', [SemeterController::class, 'now_status'])->name('admin.semeter.un.status');
    Route::get('block/{id}', [BlockController::class, 'block'])->name('admin.semeter.block');
    Route::prefix('subject')->group(function () {
        Route::get('/{id}', [subjectController::class, 'setemer'])->name('admin.semeter.subject.index');
        Route::group([
            'middleware' => 'role_admin'
        ], function () {
            Route::post('add-subject', [subjectController::class, 'create_semeter'])->name('admin.semeter.subject.create');
            Route::put('now-status/{id}', [subjectController::class, 'now_status_semeter'])->name('admin.semeter.subject.un.status');
            Route::delete('delete/{id}/{id_semeter}', [subjectController::class, 'delete_semeter'])->name('admin.basis.delete');
        });
    });
});
Route::prefix('accountStudent')->group(function () {
    Route::get('', [UserController::class, 'listStudent'])->name('manage.student.list');
    Route::get('GetBlock/{id_semeter}', [BlockController::class, 'index'])->name('manage.semeter.list');
    Route::get('GetSubject/{id_block}', [subjectController::class, 'ListSubject'])->name('manage.semeter.list');
    Route::get('GetPoetry/{id_subject}', [PoetryController::class, 'ListPoetryRespone'])->name('manage.semeter.list');
    Route::post('GetPoetryDetail', [PoetryController::class, 'ListPoetryResponedetail'])->name('manage.semeter.list');
    Route::get('ListUser/{id}', [studentPoetryController::class, 'listUser'])->name('admin.manage.semeter.index');
    Route::get('viewpoint/{id_user}', [UserController::class, 'Listpoint'])->name('manage.student.view');
    Route::get('exportPoint/{id_user}', [UserController::class, 'Exportpoint'])->name('manage.student.export');
    Route::get('exportUserPoint/{id}', [studentPoetryController::class, 'UserExportpoint'])->name('manage.student.list.export');
});

Route::prefix('chart')->group(function(){
    Route::get('',[chartController::class, 'index'])->name('admin.chart');
    Route::get('getsemeter/{id_campus}',[chartController::class, 'semeter'])->name('admin.getsemter');
    Route::get('getBlock/{id_semeter}',[chartController::class, 'block'])->name('admin.getsemter');
    Route::post('GetPoetryDetail', [PoetryController::class, 'ListPoetryResponedetailChart'])->name('manage.semeter.list');
    Route::get('detail',[chartController::class, 'detail'])->name('admin.chart.detail');
});
//Ca học =>done
Route::prefix('poetry')->group(function () {
    Route::get('/{id}/{id_block}', [PoetryController::class, 'index'])->name('admin.poetry.index');
    Route::post('form-add-poetry', [PoetryController::class, 'create'])->name('admin.poetry.create');
    Route::put('now-status/{id}', [PoetryController::class, 'now_status'])->name('admin.poetry.un.status');
    Route::delete('delete/{id}', [PoetryController::class, 'delete'])->name('admin.poetry.delete');
    Route::get('edit/{id}/{idpoety}', [subjectController::class, 'getsemeterEdit'])->name('admin.poetry.edit');
    Route::put('update/{id}', [PoetryController::class, 'update'])->name('admin.poetry.update');
//    call lai route bên hoc ky
    Route::get('getsubject/{id}', [subjectController::class, 'getsemeter'])->name('admin.poetry.subject.index');
    Route::prefix('manage')->group(function () {
        Route::get('/{id}/{id_poetry}/{id_block}', [studentPoetryController::class, 'index'])->name('admin.poetry.manage.index');
        Route::post('/form-add-student', [studentPoetryController::class, 'create'])->name('admin.poetry.manage.create');
        Route::put('now-status/{id}', [studentPoetryController::class, 'now_status'])->name('admin.poetry.un.status');
        Route::delete('delete/{id}', [studentPoetryController::class, 'delete'])->name('admin.poetry.delete');
    });
    Route::prefix('playTopic')->group(function(){
        Route::get('/{id_peotry}/{id_subject}', [playtopicController::class, 'index'])->name('admin.poetry.playtopic.index');
        Route::get('getExam/{id_subject}', [playtopicController::class, 'listExam']);
        Route::post('addTopics', [playtopicController::class, 'AddTopic'])->name('admin.poetry.playtopic.create');
        Route::post('addTopicsReload', [playtopicController::class, 'AddTopicReload'])->name('admin.poetry.playtopic.create.reload');
    });
});
// Middleware phân quyền ban giám khảo chấm thi , khi nào gộp code sẽ chỉnh sửa lại route để phân quyền route
Route::group([
    'middleware' => 'role_admin:judge|admin|super admin'
], function () {
    Route::get('prinft-pdf', [PrintPDFController::class, 'printf'])->name('admin.prinf');
    Route::get('prinft-excel', [PrintExcelController::class, 'printf'])->name('admin.excel');
});

Route::group([
    'middleware' => 'role_admin'
], function () {

    Route::prefix('acount')->group(function () {
        Route::get('', [UserController::class, 'listAdmin'])->name('admin.acount.list');
        Route::post('add-account', [UserController::class, 'create'])->name('admin.acount.add');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.acount.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('admin.acount.update');
//        Route::post('un-status/{id}', [UserController::class, 'un_status'])->name('admin.acount.un.status');
//        Route::post('re-status/{id}', [UserController::class, 're_status'])->name('admin.acount.re.status');
//        Route::post('change-role', [UserController::class, 'changeRole'])->name('admin.acount.change.role');
    });

    Route::prefix('basis')->middleware(['role_super_admin'])->group(function () {
        Route::get('', [CampusController::class, 'index'])->name('admin.basis.list');
        Route::post('add', [CampusController::class, 'store'])->name('admin.basis.store');
        Route::get('edit/{id}', [CampusController::class, 'edit'])->name('admin.basis.edit');
        Route::put('update/{id}', [CampusController::class, 'update'])->name('admin.basis.update');
        Route::delete('delete/{id}', [CampusController::class, 'delete'])->name('admin.basis.delete');
    });

//
//    Route::prefix('students')->group(function () {
//        Route::get('', [UserController::class, 'stdManagement'])->name('admin.students.list');
//    });

    Route::prefix('capacity')->group(function () {
//        Route::get('{id}', [ContestController::class, 'show_test_capacity'])->name('admin.contest.show.capatity');
        Route::get('', [ContestController::class, 'show_capacity'])->name('admin.contest.show.capatity');
    });

    Route::get('dowload-frm-excel', function () {
        return response()->download(public_path('assets/media/excel/excel_download.xlsx'));
    })->name("admin.download.execel.pass");
    Route::get('dowload-frm-excel-poetry', function () {
        return response()->download(public_path('assets/media/excel/Poetry-dowload-new.xlsx'));
    })->name("admin.download.execel.poetry");
    Route::post('upload-image', [CkeditorController::class, 'updoadFile'])->name('admin.ckeditor.upfile');
    Route::prefix('questions')->group(function () {
        Route::get('', [QuestionController::class, 'index'])->name('admin.question.index');
        Route::get('add', [QuestionController::class, 'create'])->name('admin.question.create');
        Route::post('add', [QuestionController::class, 'store'])->name('admin.question.store');
        Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('admin.question.edit');
        Route::post('update/{id}', [QuestionController::class, 'update'])->name('admin.question.update');
        Route::delete('destroy/{id}', [QuestionController::class, 'destroy'])->name('admin.question.destroy');
        Route::post('un-status/{id}', [QuestionController::class, 'un_status'])->name('admin.question.un.status');
        Route::post('re-status/{id}', [QuestionController::class, 're_status'])->name('admin.question.re.status');
        Route::get('soft-delete', [QuestionController::class, 'softDeleteList'])->name('admin.question.soft.delete');
        Route::delete('delete/{id}', [QuestionController::class, 'delete'])->name('admin.question.delete');
        Route::get('restore-delete/{id}', [QuestionController::class, 'restoreDelete'])->name('admin.question.restore');

        Route::post('import', [QuestionController::class, 'import'])->name('admin.question.excel.import');
        Route::post('import/{exam}', [QuestionController::class, 'importAndRunExam'])->name('admin.question.excel.import.exam');
        Route::post('importEx/{semeter}/{idBlock}', [QuestionController::class, 'importAndRunSemeter'])->name('admin.semeter.excel.import');
        Route::get('export', [QuestionController::class, 'exportQe'])->name('admin.question.excel.export');


        Route::get('skill-question-api', [QuestionController::class, 'skillQuestionApi'])->name('admin.question.skill');
    });

    Route::get('support-poly', [SupportController::class, 'index'])->name('admin.support');
});


Route::get("dev", function () {
    return "<h1>Chức năng đang phát triển</h1> ";
})->name('admin.dev.show');
