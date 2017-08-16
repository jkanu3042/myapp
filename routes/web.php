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

Route::get('auth/login', function(){
   $credentials = [
       'email' => 'john@example.com',
       'password' => 'password',
   ];

   if (! auth()->attempt($credentials)) {
      return '로그인 정보가 정확하지 않습니다.';
   }

    return redirect('protected');
});

Route::get('protected', ['middleware' => 'auth',function(){
   dump(session()->all());

    return '어서 오세요'. auth()->user()->name.'님';

}]);

Route::get('auth/logout', function(){
   auth()->logout();

    return '또 봐요~';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//DB::listen(function ($query){
//    var_dump($query->sql);
//});


//Event::listen('article.created', function ($article){
//    var_dump('이벤트를 받았습니다. 받은 데이터(상태)는 다음과 같습니다.');
//    var_dump($article->toArray());
//});