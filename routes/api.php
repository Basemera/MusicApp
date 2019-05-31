<?php

use Illuminate\Http\Request;

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
//    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {


    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('/register', 'UserController@createUser');

});

Route::get('/', function (Request $request) {
//    var_dump(($request));
    return response()->json(["message"=>"Welcome to basemera-music. Your online music store"]);
});

Route::group(['middleware' => ['jwt.verify']], function() {

//Route::post('/user/register', 'UserController@createUser');
Route::group(['middleware' => ['premium.verify']], function() {
    Route::post('/user/add_album/{id}', 'AlbumController@addAlbum');
    Route::get('/user/{id}', 'UserController@getSingleUser');
    Route::get('/users', 'UserController@getAllUsers');
    Route::put('/user/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@deleteUser');
    Route::put('/user/album/user/{id}/edit/{album_id}', 'AlbumController@editAlbum');
    Route::get('/user/{id}/album', 'AlbumController@getUserAlbum');
    Route::put('/user/albums', 'AlbumController@getAllAlbums');
    Route::delete('/user/album/user/{id}/delete/{album_id}', 'AlbumController@deleteAlbum');
    Route::post('/user/{id}/album/{album_id}/track', 'TrackController@addTrack');
    Route::patch('/user/{user_id}/album/{album_id}/track/{id}', 'TrackController@editTrack');
    Route::delete('/user/{user_id}/album/{album_id}/track/{id}', 'TrackController@deleteTrack');
    Route::post('/user/{user_id}/playlist', 'PlaylistController@createPlaylist');
    Route::patch('/user/{user_id}/playlist/{playlist_id}', 'PlaylistController@updatePlaylist');
});
Route::get('/user/album/{id}', 'AlbumController@getAllUserAlbums');
Route::get('/user/album/details/{id}', 'AlbumController@getSingleAlbum');
Route::get('/user/{user_id}/album/{album_id}/track/{id}', 'TrackController@getSingleTrack');
Route::get('/user/{user_id}/playlist', 'PlaylistController@getAllUserPlaylists');
Route::get('/user/playlist', 'PlaylistController@getAllPlaylists');
Route::get('/user/playlist/{id}', 'PlaylistController@getSinglePlaylist');
Route::post('/user/{user_id}/track/{track_id}/comment', 'CommentsController@createComment');
Route::get('/user/comment/{comment_id}', 'CommentsController@getSingleComment');
Route::get('/user/comment/track/{track_id}', 'CommentsController@getTrackComments');
Route::patch('/user/comment/{comment_id}', 'CommentsController@editSingleComment');
Route::delete('/user/comment/{comment_id}', 'CommentsController@deleteSingleComment');
Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');
});






