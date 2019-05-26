<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\Track;

class CommentsController extends Controller
{
    //
    /**
     * Add a track
     * @param Request $request
     * @param $track_id
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createComment (Request $request, $user_id, $track_id) {

        $this->validate($request, [
            'Details' => 'required'
        ]);

        $exists = Track::findorFail($track_id);

        $comment = new Comments();
        $comment->Details = strtolower($request->Details);
        $comment->song_id = $track_id;
        $comment->user_id = $user_id;
        $comment->save();
        return response()->json($comment, 201);
    }

    /**
     * Get the details of a single track
     * @param $album_id
     * @param $track_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleComment($comment_id) {
        $comment = Comments::findorFail($comment_id);
        $this->comment = $comment;
        return response()->json($this->comment, 200);
    }

    /**
     * Get the details of a single track
     * @param $album_id
     * @param $track_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTrackComments($track_id) {
        $comments = Comments::TrackComments($track_id)->get();
        $this->comments = $comments;
        return response()->json($this->comments, 200);
    }

    /**
     * Get the details of a single track
     * @param $album_id
     * @param $track_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editSingleComment(Request $request, $comment_id) {
        $comment = Comments::findorFail($comment_id);
        $this->comment = $comment;
        $this->comment->update($request->all());
        return response()->json($this->comment, 200);
    }

    /**
     * Get the details of a single track
     * @param $album_id
     * @param $track_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSingleComment(Request $request, $comment_id) {
        $comment = Comments::findorFail($comment_id);
        $this->comment = $comment;
        $this->comment->delete();
        return response()->json($this->comment, 200);
    }
}
