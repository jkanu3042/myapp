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

/*Social Login*/
Route::get(
    'social/{provider}',
    'SocialController@execute'
    )->name('social.login');


Route::get('/', 'WelcomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('articles', 'ArticlesController');

Route::resource('attachments', 'AttachmentsController', ['only' => ['store', 'destroy']]);

Route::get(
    'tags/{slug}/articles',
    'ArticlesController@index'
    )->name('tags.articles.index');

//사용자 가입
Route::get(
    'auth/register',
    'UsersController@create'
)->name('users.create');

Route::post(
    'auth/register',
    'UsersController@store'
)->name('users.store');

Route::get(
    'auth/confirm/{code}',
    'UsersController@confirm'
)->name('users.confirm')
    ->where('code', '[\pL-\pN]{60}');

//사용자 인증

Route::get(
    'auth/login',
    'SessionsController@create'
)->name('sessions.create');

Route::post(
    'auth/login',
    'SessionsController@store'
)->name('sessions.store');

Route::get(
    'auth/logout',
    'SessionsController@destroy'
)->name('sessions.destroy');


//비밀번호 초기화

Route::get(
    'auth/remind',
    'PasswordsController@getRemind'
)->name('remind.create');

Route::post(
    'auth/remind',
    'PasswordsController@postRemind'
)->name('remind.store');

Route::get(
    'auth/reset/{token}',
    'PasswordsController@getReset'
)->name('reset.create')
    ->where('code', '[\pL-\pN]{64}');

Route::post(
    'auth/reset',
    'PasswordsController@postReset'
)->name('reset.store');







Route::get('docs/{file?}', 'DocsController@show');

Route::get('docs/images/{image}', 'DocsController@image')
    ->where('image', '[\pL-\pN\._-]+-img-[0-9]{2}.png');



//DB::listen(function ($query){
//    var_dump($query->sql);
//});


//Event::listen('article.created', function ($article){
//    var_dump('이벤트를 받았습니다. 받은 데이터(상태)는 다음과 같습니다.');
//    var_dump($article->toArray());
//});

//Route::get('mail', function() {
//   $article = \App\Article::with('user')->find(1);
//
//    return Mail::send(
//        'emails.articles.created',
//        compact('article'),
//        function($message) use ($article) {
//            $message->to('cshmp6@gmail.com');
//            $message->subject('새 글이 등록되었습니다.'.$article->title);
//        }
//    );
//
//});

//Route::get('markdown', function(){
//   $text =<<<EOT
//# 마크다운 예제 1
//
//이 문서는 [마크다운][1]으로 썼습니다. 화면에서는 HTML로 변환되어있습니다.
//
//## 순서 없는 목록
//
//- 첫 번째 항목
//- 두 번째 항복[^1]
//
//[1] : http://daringfireball.net/projects/markdown
//
//[^1] : 두번째 항목_ http://google.com
//EOT;
//    return app(ParsedownExtra::class)->text($text);
//});
//




























