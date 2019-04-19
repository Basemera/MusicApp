<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    //
    /**
     * Add a track
     * @param Request $request
     * @param $album_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createPlaylist (Request $request, $user_id) {
        $song_url = "";
        $public_id = "";
        $this->validate($request, [
            'name' => 'required',
            'tracks' => 'required'
        ]);

        $playlist = Playlist::UserPlaylists($user_id)->where('name', strtolower($request->name))->first();
        if ($playlist) {
            return response()->json('Playlist already exists. Do you want to add songs instead', 400);
        }

        foreach ($request->tracks as $track) {
            $exists = Track::findorFail($track);
            if (! $exists) {
                return response()->json('Track doesnot exists.' , 400);
            }
        }

        $new_playlist = new Playlist();
        $new_playlist->name = strtolower($request->name);
        $new_playlist->tracks = $request->tracks;
        $new_playlist->user_id = $user_id;
        $new_playlist->save();
        return response()->json($new_playlist, 201);
    }

    public function UpdatePlaylist (Request $request, $user_id, $playlist_id) {
        $new_tracks = [];
        $playlist = Playlist::findorFail($playlist_id);
        if ($request->tracks) {
            foreach ($request->tracks as $track) {
                $exists = Track::findorFail($track);
                if (!$exists) {
                    return response()->json('Track doesnot exists.' , 400);
                }
            }



            if($request->condition == "add") {
                array_push($new_tracks, $playlist['tracks']);
                foreach ($request->tracks as $track) {
                    if (!in_array($track, $playlist['tracks'])) {
                        array_push($new_tracks, $track);
                    }
                }
            }
            elseif ($request->condition == "remove") {
                array_push($new_tracks, $playlist['tracks']);
                $new_tracks = array_diff($playlist['tracks'], $request->tracks);
                $request->tracks = $new_tracks;
            }
            $playlist->update($request->all());
            return response()->json($playlist, 200);
        }
    }

    /**
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse Array of all playlists associated with a user
     */
    public function getAllUserPlaylists($user_id) {
        $playlists = Playlist::where('user_id',$user_id)->get();
        return response()->json($playlists, 200);
    }

    public function getAllPlaylists() {
        $playlists = Playlist::all();
        return response()->json($playlists, 200);
    }
    /**
     * Return details of a single playlist
     * @param $id
     * @param $category_id
     * @return \Illuminate\Http\JsonResponse Object of a single category's detail
     */
    public function getSinglePlaylist(Request $request, $playlist_id) {
        $playlist = Playlist::where('id', $playlist_id)->get();
        return response()->json($playlist, 200);
    }
}
