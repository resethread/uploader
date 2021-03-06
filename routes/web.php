<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => '/', 'namespace' => 'Front'], function() {
    Route::get('/', 'FrontController@getIndex');

    Route::get('watch/{id}/{slug}', 'FrontController@getWatch');

    Route::get('search', 'FrontController@getSearch');

    Route::get('tag/{tag}', 'FrontController@getTag');

    // Menu
    Route::get('news', 'FrontController@getNews');
    Route::get('most-viewed', 'FrontController@getMostViewed');
    Route::get('top-rated', 'FrontController@getTopRated');
    Route::get('most-favorited', 'FrontController@getMostFavorited');
    Route::get('most-commented', 'FrontController@getMostCommented');
    Route::get('tags', 'FrontController@getTags');
    Route::get('random', 'FrontController@getRandom');
    Route::get('stars', 'FrontController@getstars');
    Route::get('channels', 'FrontController@getChannels');

    Route::get('contact', 'FrontController@getContact');
    Route::post('contact', 'FrontController@postContact');
    Route::get('conditions', 'FrontController@getConditions');

    Route::get('test', ['as' => 'test', 'uses' => 'FrontController@test']);

});

Auth::routes();

Route::get('/confirm/{id}/{token}', 'Auth\RegisterController@confirm');

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function() {
    Route::get('video/{id}/{string}', ['as' => 'video.watch', 'uses' => 'ApiController@watch']);
    Route::get('avatar/{id}/{string}', ['as' => 'avatar', 'uses' => 'ApiController@avatar']);

    Route::get('thumbnail/{id}/{public_id}/{index}', ['as' => 'thumbnail', 'uses' => 'ApiController@thumbnail']);

    Route::get('comments/{id}', ['as' => 'get.comments', 'uses' => 'ApiController@getComments']);
    Route::post('comments/{id}', ['as' => 'post.comments', 'uses' => 'ApiController@postComments']);

    Route::post('favorite/{video_id}', 'ApiController@postFavorite');
    Route::post('download/{id}/{public_id}', ['as' => 'download', 'uses' => 'ApiController@download']);
    //Route::post('rate/{video_id}', 'ApiController@postRate');
    Route::get('related/{id}', ['as' => 'get.related', 'uses' => 'ApiController@related']);
});


Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin', 'as' => 'admin.'], function() {
    Route::get('/', ['as' => 'index', 'uses' => 'AdminController@index']);
    Route::resources([
        'users' => 'UsersController',
        'videos' => 'VideosController',
        'validations' => 'ValidationsController',
        'tags' => 'TagsController',
        'messages' => 'MessagesController',
        'menu' => 'MenuController',
        'pages' => 'PagesController',
       // 'banners' => 'BannersController',
        'delete' => 'DeleteController',
        'settings' => 'SettingsController'
    ]);

    Route::get('fetch-menu', ['as' => 'fetch-menu', 'uses' => 'MenuController@fetchMenu']);
   
    Route::get('converting', ['as' => 'converting.index', 'uses' => 'ConvertingController@index']);
});
