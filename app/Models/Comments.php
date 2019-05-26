<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $fillable = ['Details', 'track_id', 'user_id'];

    /**
     * Method to return the user a comment is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Local query scope to return comments associated with a track
     *
     * @param $query
     * @param track_id of the track
     * @return mixed
     */
    public function scopeTrackComments($query, $track_id)
    {
        return $query->where('song_id', $track_id);
    }
}
