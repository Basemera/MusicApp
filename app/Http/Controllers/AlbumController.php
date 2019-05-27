<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * @param Request $request
     * @param $user_id
     * @return Album|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addAlbum(Request $request, $user_id) {
        $this->validate($request, [
            'name' => 'required',
            'released_on' => 'nullable'
        ]);
//        dd($user_id);

        $albums = Album::select('id')->where('user_id', $user_id)->where('name', strtolower($request->name))->first();
//        dd($albums);
        if ($albums) {
            return response()->json("Album already exists", 400);
        }
        $album =  new Album();
        $album->name = strtolower($request->name);
        $album->released_on = $request->released_on;
        $album->user_id = $user_id;
        $album->save();
        return  response()->json($album, 201);
    }
    /**
     * Return the user an album is associated with
     * @param $user_id
     * @return mixed
     */
    public function getUserAlbum($user_id) {
//        dd($user_id);
        return Album::find($user_id)->user;
    }
    /**
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse Array of all albums associated with a user
     */
    public function getAllUserAlbums($user_id) {
        $albums = Album::where('user_id',$user_id)->get();
        return response()->json($albums, 200);
    }

    /**
     * Return details of a single album
     * @param $id
     * @param $category_id
     * @return \Illuminate\Http\JsonResponse Object of a single category's detail
     */
    public function getSingleAlbum(Request $request, $album_id) {
        $album = Album::where('id', $album_id)->get();
        return response()->json($album, 200);
    }
    /**
     * Edit a category
     * @param Request $request
     * @param $id
     * @param $album_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function editAlbum(Request $request, $id, $album_id ) {
        $album = Album::UserAlbums($id)->findorFail($album_id);
        $album->update($request->all());
        return response()->json($album, 200);
    }
    /**
     * Delete album
     * @param $id
     * @param $album_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAlbum($id, $album_id) {
        $album = Album::UserAlbums($id)->findorFail($album_id);
        $album->delete();
        return response()->json($album->name.'successfully deleted', 200);
    }

//    public function getAllCategoryRecipes($category_id) {
//        return Category::find($category_id)->recipes;
//    }
}
