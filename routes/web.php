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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/questionnaire', function () {
//     return view('questionnaire');
// });
// Route::get('/GRIT', function () {
//     return view('GRIT');
// });
// Route::get('/VIA-IS', function () {
//     return view('VIA-IS');
// });
// Route::get('/PCL-R', function () {
//     return view('PCL-R');
// });
// Route::get('/Psychopass', function () {
//     return view('Psychopass');
// });
// Route::get('/', 'WelcomesController@show');
Route::get('/', 'CategoryController@show')->name('Category_show');
Route::get('/test/{Category}', 'CategoryController@test');
Route::get('/dashboard', 'CategoryController@Dashboard');
Route::get('/past_result/{Category}', 'CategoryController@Past_result');
Route::post('/calculate/{Category}', 'CategoryController@Calculate');

Route::group(['middleware' => ['auth', 'can:system-only']], function () {
	//カテゴリー関連ページ
	Route::post('/Category/store', 'CategoryController@store');
	Route::patch('/Category/{Category}', 'CategoryController@edit');
	Route::delete('/Category/delete/{Category}', 'CategoryController@delete');
	//サブカテゴリー関連ページ
	Route::get('/SubCategory/{Category}', 'SubCategoryController@show')->name('show');
	Route::post('/SubCategory/{Category}', 'SubCategoryController@store');
	Route::delete('/SubCategory/{SubCategory}', 'SubCategoryController@delete');
	//質問関連ページ
	Route::post('/Question/{SubCategory}', 'QuestionController@store');
	Route::delete('/Question/{Question}', 'QuestionController@delete');
	Route::patch('/Question/{Question}', 'QuestionController@edit');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
