<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class User extends Model
{
    protected $fillable = ['username', 'email', 'password'];

    /**
     * Create a new token.
     *
     * @param \App\Models\User $user
     * @return string
     */
    static function jwt(User $user) {
        if (!$user->id) {
            return "user doesnot exist";
        }
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 3600*3600
        ];
        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
}
