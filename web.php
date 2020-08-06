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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/questionnaire', function () {
    return view('questionnaire');
});
Route::get('/GRIT', function () {
    return view('GRIT');
});
Route::get('/VIA-IS', function () {
    return view('VIA-IS');
});
Route::get('/PCL-R', function () {
    return view('PCL-R');
});
Route::get('/Psychopass', function () {
    return view('Psychopass');
});
