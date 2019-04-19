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

Route::get('/user', function (Request $request) {
//    var_dump(($request));
    return "Memmmmmme";
});

Route::post('/user/register', 'UserController@createUser');
Route::post('/user/login', 'UserController@logIn');
Route::post('/user/add_album/{id}', 'AlbumController@addAlbum');
Route::get('/user/album/{id}', 'AlbumController@getAllUserAlbums');
Route::get('/user/album/details/{id}', 'AlbumController@getSingleAlbum');
Route::put('/user/album/user/{id}/edit/{album_id}', 'AlbumController@editAlbum');
Route::delete('/user/album/user/{id}/delete/{album_id}', 'AlbumController@deleteAlbum');
Route::post('/user/{id}/album/{album_id}/track', 'TrackController@addTrack');
Route::patch('/user/{user_id}/album/{album_id}/track/{id}', 'TrackController@editTrack');
Route::delete('/user/{user_id}/album/{album_id}/track/{id}', 'TrackController@deleteTrack');
Route::get('/user/{user_id}/album/{album_id}/track/{id}', 'TrackController@getSingleTrack');
Route::post('/user/{user_id}/playlist', 'PlaylistController@createPlaylist');
Route::patch('/user/{user_id}/playlist/{playlist_id}', 'PlaylistController@updatePlaylist');
Route::get('/user/{user_id}/playlist', 'PlaylistController@getAllUserPlaylists');
Route::get('/user/playlist', 'PlaylistController@getAllPlaylists');
Route::get('/user/playlist/{id}', 'PlaylistController@getSinglePlaylist');




