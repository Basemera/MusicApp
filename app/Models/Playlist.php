<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['name', 'tracks', 'user_id'];

    protected $casts = [
        'tracks' => 'array'
    ];

    /**
     * Method to return the user a track is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Local query scope to return tracks associated with an album
     *
     * @param $query
     * @param $user_id album_id of the album
     * @return mixed
     */
    public function scopeUserPlaylists($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
