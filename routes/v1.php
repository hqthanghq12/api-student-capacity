<?php

use App\Events\ChatSupportEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\WishlistController;
use App\Http\Controllers\Admin\CodeManagerController;
use App\Http\Controllers\Admin\CapacityPlayController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\TakeExamController as AdminTakeExamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('get-user-by-token', [UserController::class, 'get_user_by_token']);

Route::prefix('take-exam')->group(function () {
    Route::post('student', [AdminTakeExamController::class, 'takeExamStudent']);
    Route::post('student-submit', [AdminTakeExamController::class, 'takeExamStudentSubmit']);

    Route::post('check-student-capacity', [AdminTakeExamController::class, 'checkStudentCapacity']);
    Route::post('student-capacity', [AdminTakeExamController::class, 'takeExamStudentCapacity']);
    Route::post('student-exam', [AdminTakeExamController::class, 'takeExamStudent']);
    Route::post('student-capacity-submit', [AdminTakeExamController::class, 'takeExamStudentCapacitySubmit']);
    Route::post('student-capacity-history', [AdminTakeExamController::class, 'takeExamStudentCapacityHistory']);
});


Route::prefix('round')->group(function () {
    Route::get('{id_round}/team-me', [RoundController::class, 'userTeamRound']);
});


Route::prefix('users')->group(function () {
    Route::get('contest-joined-and-not-joined', [UserController::class, 'contestJoinedAndNotJoined']);
    Route::get('contest-joined', [UserController::class, 'contestJoined']);
    Route::post('edit', [UserController::class, 'updateDetailUser']);
    Route::post('/updatePassword', [UserController::class, 'updatePassword']);
});
