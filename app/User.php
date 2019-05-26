<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Exception as Exception;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'premium_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
 * Return a key value array, containing any custom claims to be added to the JWT.
 *
 * @return array
 */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param Album $album
     *
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createAlbum(Album $album)
    {
        dd("am here");

//        $newAlbum = $this->albums()->save($album);

        try {
            $newAlbum = $this->albums()->save($album);
            return response()->json($newAlbum, 201);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), 400);

        }
//        return response()->json($newAlbum, 201);

//        if ($newAlbum){
//            return response()->json($newAlbum, 201);
//        }
//        return response()->json("Album already exists", 400);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
