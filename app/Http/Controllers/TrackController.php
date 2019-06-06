<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Track;
//use JD\Cloudder\CloudinaryWrapper as Cloudder;

class TrackController extends Controller
{
    public $song_url = "";
    public $public_id = "";
    //
    /**
     * Add a track
     * @param Request $request
     * @param $album_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addTrack (Request $request, $id, $album_id ) {
//        $song_url = "";
//        $public_id = "";
       $this->validate($request, [
           'title' => 'required',
       ]);

        $track = Track::AlbumTracks($album_id)->where('title', strtolower($request->title))->first();
        if ($track) {
            return response()->json('Title already taken. Please pick another one', 400);
        }

        if($request->hasFile('upload')) {
            \Cloudder::uploadVideo($request->file('upload'));
            $this->song_url = \Cloudder::secureShow(\Cloudder::getPublicId(), ['resource_type' => 'video', 'format' => 'mp3', "width" =>  null, "height"=> null, "crop" => null]);
            $this->public_id = \Cloudder::getPublicId();
            $c = \Cloudder::getResult();
        }
        $new_track = new Track();
        $new_track->title = strtolower($request->title);
        $new_track->url = $this->song_url;
        $new_track->public_id = $this->public_id;
        $new_track->album_id = $album_id;
        $new_track->user_id = $id;
        $new_track->save();
        return response()->json($new_track, 201);
    }
    /**
     * Edit a track
     * @param Request $request
     * @param $album_id - id of category to which track belongs
     * @param $id - id of recipe to be edited
     * @return \Illuminate\Http\JsonResponse - details of the edited track
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editTrack(Request$request, $user_id, $album_id, $id) {
        $track = Track::AlbumTracks($album_id)->findorFail($id);
        if (!$track) {
            return response()->json('Track doesnot exist', 400);
        }
        $track->update($request->all());
        return response()->json($track, 200);
    }
    /**
     * Delete a single track
     * @param $album_id
     * @param $track_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTrack($album_id, $track_id) {
        $track = Track::AlbumTracks($album_id)->findorFail($track_id);
        try{
            $publicId = $track['public_id'];
            \Cloudder::delete($publicId);
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        $track->delete();
        return response()->json('Track deleted successfully', 200);
    }
    /**
     * Get the details of a single track
     * @param $album_id
     * @param $track_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleTrack($user_id, $album_id, $track_id) {
        $track = Track::findorFail($track_id);
        $publicId = $track['public_id'];
        $this->song_url = ["song_url" => $track['url']];
//        dd($publicId);

//        $this->song_url = \Cloudder::secureShow($publicId, ['resource_type' => 'video', 'format' => 'mp3', "width" =>  null, "height"=> null, "crop" => null]);
        return response()->json($this->song_url, 200);
    }
}
