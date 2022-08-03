<?php

use App\Http\Controllers\Admin\ContestController;
use App\Http\Controllers\Admin\RoundController;
use App\Http\Controllers\Admin\TakeExamController as AdminTakeExamController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::group(['middleware' => ['role:super admin']], function () {
//    Route::group(['prefix' => 'account'], function () {
//        Route::post('/', [UserController::class, 'list']);
//        Route::post('add', [UserController::class, 'add_user']);
//        Route::delete('block/{id}', [UserController::class, 'block_user']);
//        Route::post('update-role-user/{id}', [UserController::class, 'updateRoleUser']);
//    });
//});

//Route::group(['prefix' => 'majors'], function () {
//    Route::post('/', [\App\Http\Controllers\Admin\Majorcontroller::class, 'store']);
//    Route::delete('/{id}', [\App\Http\Controllers\Admin\Majorcontroller::class, 'destroy']);
//    Route::put('/{id}', [\App\Http\Controllers\Admin\Majorcontroller::class, 'update']);
//    Route::get('/{id}/edit', [\App\Http\Controllers\Admin\Majorcontroller::class, 'edit']);
//});


Route::prefix('teams')->group(function () {
    // Route::get('{id}', [AdminTeamController::class, 'apiShow']);
    Route::post('add-team', [AdminTeamController::class, "apiAddTeam"]);
    Route::put('edit-team/{team_id}', [AdminTeamController::class, "apiEditTeam"]);
    Route::get('{id}', [AdminTeamController::class, 'apiShow'])->name('team.api.show');
    Route::get('check-user-team-contest/{id_contest}', [AdminTeamController::class, "checkUserTeamContest"]);
    Route::post('add-user-team-contest/{id_contest}/{id_team}', [AdminTeamController::class, "addUserTeamContest"]);
    Route::post('user-team-search/{id_contest}', [AdminTeamController::class, "userTeamSearch"]);
    Route::post('delete-user-team-contest', [AdminTeamController::class, "deleteUserTeamContest"]);
});

Route::prefix('take-exam')->group(function () {
    Route::post('student', [AdminTakeExamController::class, 'takeExamStudent']);
    Route::post('student-submit', [AdminTakeExamController::class, 'takeExamStudentSubmit']);

    Route::post('check-student-capacity', [AdminTakeExamController::class, 'checkStudentCapacity']);
    Route::post('student-capacity', [AdminTakeExamController::class, 'takeExamStudentCapacity']);
    Route::post('student-capacity-submit', [AdminTakeExamController::class, 'takeExamStudentCapacitySubmit']);
});


Route::prefix('round')->group(function () {
    Route::get('{id_round}/team-me', [RoundController::class, 'userTeamRound']);
});


Route::prefix('users')->group(function () {
    Route::get('contest-joined', [ContestController::class, 'apiIndex']);
    Route::get('contest-joined-1', [UserController::class, 'contestJoined']);
    Route::post('edit', [UserController::class, 'updateDetailUser']);
});