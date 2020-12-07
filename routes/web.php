<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'layouts.master');

Route::resource('questions', QuestionController::class)->except(['show']);
Route::resource('categories', CategoryController::class)->except(['show']);
Route::get('exams/answering-wrong-answers', 'ExamController@createAnsweringWrongAnswers')->name('exams.create.answering.wrong.answers');
Route::post('exams/answering-wrong-answers', 'ExamController@postAnsweringWrongAnswers')->name('exams.post.answering.wrong.answers');
Route::post('exams/ajax', 'ExamController@ajax')->name('exams.ajax');
Route::resource('exams', ExamController::class)->except('edit');
Route::get('exams/{exam}/wrong-answers', 'ExamController@wrongAnswers')->name('exams.wrong.answers');
Route::get('exams/{exam}/correct-answers', 'ExamController@correctAnswers')->name('exams.correct.answers');
Route::get('exams/{exam}/unanswered-questions', 'ExamController@unansweredQuestions')->name('exams.unanswered.questions');

Route::get('exams/{exam}/questions/show', 'ExamQuestionController@show')->name('exams.questions.show');
Route::post('exams/{exam}/questions/{question}', 'ExamQuestionController@store')->name('exams.questions.store');

// Route::get('test', function () {
// });
