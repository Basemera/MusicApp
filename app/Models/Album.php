<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //
    protected $fillable = ['name', 'released_on'];


    /**
     * Method to return the user a category is associated with
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
    /**
     * Local query scope to return albums associated with a user
     *
     * @param $query
     * @param $user_id user_id of the user
     * @return mixed
     */
    public function scopeUserAlbums($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    /**
     * Method to return the categories' recipes
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasmany
     */
    public function tracks() {
        return $this->hasMany('App\Models\Track');
    }

}
