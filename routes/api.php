<?php

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
Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('validate-uuid', 'Auth\AuthController@validateUUID');
        Route::post('login', 'Auth\AuthController@login');
    });

//    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('user', 'Auth\AuthController@user');

        Route::post('users/{idUser}/photo', 'UserController@profilePhoto');
        Route::resource('users', 'UserController');
        Route::resource('sectors', 'SectorController');

        Route::get('observes/{idObserve}/deviations-motive', 'ObserveController@observeDeviationsMotive');
        Route::resource('observes', 'ObserveController');

        Route::get('absences/pending-approval', 'AbsenceController@absencesPendingApproval');
        Route::get('absences/solicited-approval', 'AbsenceController@absencesSolicitedApproval');
        Route::resource('absences', 'AbsenceController');
        Route::resource('absence-motive-settings', 'AbsenceMotiveSettingController', [
            'parameters' => ['absence-motive-settings' => 'absenceMotiveSettings']
        ]);

        Route::resource('deviation-types', 'DeviationTypeController', [
            'parameters' => ['deviation-types' => 'deviationTypeSetting']
        ]);

        Route::resource('motives-alleged', 'MotiveAllegedSettingController', [
            'parameters' => ['motives-alleged' => 'motiveAllegedSetting']
        ]);

        //        Route::get('cron-jobs/verify-preventives-dates', 'CronjobController@getVerifyPreventivesDates');
    //        Route::get('cron-jobs/verify-preventives-schedule', 'CronjobController@getVerifyPreventivesSchedule');
//    });

    //    Route::post('needle-model/import', 'NeedleModelController@importNeedleModel');
});
