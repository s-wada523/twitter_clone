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
Route::get('/', function () {
    return view('welcome');
});

// テスト
// ログインログアウトに関係なくHell Worldを出力
Route::get('hello', function () {
    return 'Hello World';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    // ログインしたときにしかアクセスできない

    // ユーザ関連
    // Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);

    // 以下を正規なものにしたい
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index');
        Route::get('/{id}', 'UsersController@show');
        Route::get('/following', 'UsersController@following');
        // Route::get('/{id}/following', 'UsersController@following');
        Route::get('/{id}/edit', 'UsersController@edit');

    //     Route::get('update', 'UsersController@update');
    });

    // 検索画面を表示
    Route::get('/serch', 'UsersController@serch');
    // 検索結果を表示
    Route::get('/search', 'UsersController@search');



    // Route::get('users/following', 'UsersController@followingIndex');
    // Route::get('users/{id}', 'UsersController@show');
    // Route::get('{id}/edit', 'UsersController@edit');
    // Route::post('update', 'UsersController@update');
    
    // Route::resource('users/following', 'UsersController', ['only' => ['index', 'followingIndex', 'show', 'edit', 'update']]);
    // Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'edit', 'update']]);

    // Route::get('users', 'UsersController@index');
    // Route::get('users/{id}', 'UsersController@edit');
    // Route::get('users/update', 'UsersController@update');

    

    // Route::group(['prefix' => 'users'], function() {
        // Route::get('/', 'UsersController@index');
        // Route::get('index', 'UsersController@index');
        // Route::get('{id}/show', 'UsersController@show');
        // Route::get('{id}/edit', 'UsersController@edit');
        // Route::post('update', 'UsersController@update');

        // Route::get('/followme', 'UsersController@')

    // });




    // フォロー/フォロー解除を追加
    Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
    Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow');

    // ツイート関連
    // Route::resource('tweets', 'TweetsController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    Route::get('tweets', 'TweetsController@index');
    Route::get('tweets/{id}', 'TweetsController@show');

    // コメント関連
    Route::resource('comments', 'CommentsController', ['only' => ['store']]);

    // いいね関連
    Route::resource('favorites', 'FavoritesController', ['only' => ['store', 'destroy']]);
});