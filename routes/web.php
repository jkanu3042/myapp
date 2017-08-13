<?php

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

/*
Route::get('/', function () {
//  case 1. with 사용.
//    return view('welcome')->with([
//        'name' => 'Foo',
//        'greeting' => '안녕하세요',
//    ]);

//  case 2. view 인자 사용.(실전 권장)

//    $items = ['사과','바나나','포도'];
//    return view('welcome',[
//        'items'=>$items,
//    ]);
});
*/


Route::get('/', 'WelcomeController@index');

Route::resource('articles', 'ArticlesController');
