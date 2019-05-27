<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Add a user to the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }

        $newUser = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'username' => $request->get('username'),
        ]);


        return response()->json(($newUser),201);
    }
    /**
     * Return all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers() {
        $allUsers = [];
        $users = User::all();
        foreach ($users as $user) {
            $userDetail = [
                'id'=>$user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
            array_push($allUsers, $userDetail);
        }
        return response()->json($allUsers, 200);
    }
    /**
     * @param Request $request
     * @param $id - id of user to be updated
     * @return \Illuminate\Http\JsonResponse - details of user
     */
    public function update(Request $request, $id) {
        $user = User::findorFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }
    /**
     * Return details of a single user
     *
     * @param $id - id of user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleUser($id) {
        return response()->json(User::findorFail($id), 200);
    }
    /**
     *  Delete a user
     *
     * @param $id - id of user to be deleted
     */
    public function deleteUser($id) {
        User::findorFail($id)->delete();
        return response()->json('successfully deleted', 200);
    }
}
