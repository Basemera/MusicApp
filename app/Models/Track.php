<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = ['title', 'url', 'public_id', 'album_id', 'user_id'];

    /**
     * Method to return the user a track is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Method to return the album a track is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album() {
        return $this->belongsTo('App\Models\Album');
    }

    /**
     * Local query scope to return tracks associated with an album
     *
     * @param $query
     * @param $album_id album_id of the album
     * @return mixed
     */
    public function scopeAlbumTracks($query, $album_id)
    {
        return $query->where('album_id', $album_id);
    }
}
