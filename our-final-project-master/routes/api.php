<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\lawyerController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@register');
});


Route::ApiResource('/lawyers', lawyerController::class);
Route::patch('/changeStatus/{id}', 'App\Http\Controllers\Api\lawyerController@changeStatus');
Route::post('/changePassword/{id}', 'App\Http\Controllers\Api\lawyerController@changePassword');

Route::ApiResource('/cases', 'App\Http\Controllers\Api\casesController');
Route::ApiResource('/clients', 'App\Http\Controllers\Api\clientsController');
Route::ApiResource('/courts', 'App\Http\Controllers\Api\courtsController');
Route::ApiResource('/expenses', 'App\Http\Controllers\Api\expensesController');
Route::ApiResource('/expert_sessions', 'App\Http\Controllers\Api\expert_sessionsController');
Route::ApiResource('/investigations', 'App\Http\Controllers\Api\investigationsController');
Route::ApiResource('/investigation_places', 'App\Http\Controllers\Api\investigation_placesController');
Route::ApiResource('/legislations', 'App\Http\Controllers\Api\legislationsController');
Route::ApiResource('/models', 'App\Http\Controllers\Api\modelsController');
Route::ApiResource('/payments', 'App\Http\Controllers\Api\paymentsController');
Route::ApiResource('/records', 'App\Http\Controllers\Api\recordsController');
Route::ApiResource('/sessions', 'App\Http\Controllers\Api\sessionsController');
Route::ApiResource('/tasks', 'App\Http\Controllers\Api\tasksController');
Route::get('/tasks-originalFormat/{Lawyer_id}', 'App\Http\Controllers\Api\tasksController@originalFormat');



//foriegn key search
Route::get('/cases_foriegn/{Lawyer_id}', 'App\Http\Controllers\Api\casesController@foriegn');
Route::get('/clients_foriegn/{Lawyer_id}', 'App\Http\Controllers\Api\clientsController@foriegn');
Route::get('/expert_sessions_foriegn/{Case_id}', 'App\Http\Controllers\Api\expert_sessionsController@foriegn');
Route::get('/expenses_foriegn/{Case_id}', 'App\Http\Controllers\Api\expensesController@foriegn');
Route::get('/investigations_foriegn/{Case_id}', 'App\Http\Controllers\Api\investigationsController@fk_caseid');
Route::get('/investigations_foriegn-byLawyers/{Lawyer_id}', 'App\Http\Controllers\Api\investigationsController@fk_lawyerid');
Route::get('/legislations_foriegn/{Lawyer_id}', 'App\Http\Controllers\Api\legislationsController@foriegn');
Route::get('/models_foriegn/{Lawyer_id}', 'App\Http\Controllers\Api\modelsController@foriegn');
Route::get('/payments_foriegn/{Case_id}', 'App\Http\Controllers\Api\paymentsController@foriegn');
Route::get('/records_foriegn-byLawyers/{Lawyer_id}', 'App\Http\Controllers\Api\recordsController@fk_lawyerid');
Route::get('/records_foriegn/{Case}', 'App\Http\Controllers\Api\recordsController@fk_caseid');
Route::get('/sessions_foriegn/{Case_id}', 'App\Http\Controllers\Api\sessionsController@foriegn');
Route::get('/tasks_foriegn/{Lawyer_id}', 'App\Http\Controllers\Api\tasksController@foriegn');



// basic search
Route::get('/tasks_search/{Date}', 'App\Http\Controllers\Api\tasksController@search');



// pattern search
Route::get('/lawyers_search/{name}', 'App\Http\Controllers\Api\lawyerController@search');
Route::get('/cases_search/{Title}', 'App\Http\Controllers\Api\casesController@search');
Route::get('/clients_search/{name}', 'App\Http\Controllers\Api\clientsController@search');
Route::get('/courts_search/{name}', 'App\Http\Controllers\Api\courtsController@search');
Route::get('/Tasks_search/{name}', 'App\Http\Controllers\Api\tasksController@patternsearch');
