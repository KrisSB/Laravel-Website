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

Route::get('/', 'PagesController@getHome');

Route::get('/Hearthstone/Deckbuilder', function () {
    return view('deckbuilder');
});

Route::resource('VideoGames', 'GamesController');
Route::get('/VideoGames/{id}/delete','GamesController@getDelete');
Route::post('/VideoGames/{id}','GamesController@updateVisibility');

Route::resource('VideoGames.Wiki','WikisController');
Route::post('VideoGames/{game}/Wiki/{wiki}/Revision/{id}', 'WikisController@pushUpdate');
Route::post('/VideoGames/{id}/Wiki/{wiki}','WikisController@updateVisibility');
Route::get('VideoGames/{game}/Wiki/{wiki}/delete','WikisController@getDelete');

Route::resource('VideoGames.Wiki.Section','WikiPostsController');
Route::post('VideoGames/{game}/Wiki/{wiki}/Section/{post_id}/Revision/{id}', 'WikiPostsController@pushUpdate');
Route::get('VideoGames/{game}/Wiki/{wiki}/Section/{post_id}/delete','WikiPostsController@getDelete');
Route::post('/VideoGames/{id}/Wiki/{wiki}/Section/{post_id}','WikiPostsController@updateVisibility');

Auth::routes();

Route::get('/Dashboard', 'DashboardController@index');

Route::resource('Forum', 'ForumsController');
