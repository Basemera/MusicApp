<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\Playlist;
use App\Models\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaylistModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function test_playlists_belongsTo_relationship() {
        $user = factory(User::class)->create([
            "username"=> "Raster",
            "email"=>"doryn113223@gmail.com",
            "password"=>bcrypt('test')
        ]);

        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);

        $track = factory(Track::class)->create(
            [
                'title' => "Zion",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqciv.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqciv",
                'album_id' => 1,
                'user_id' => 1,
            ]
        );

        $track1 = factory(Track::class)->create(
            [
                'title' => "Zion king",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcivf.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivf",
                'album_id' => 1,
                'user_id' => 1,
            ]
        );

        $track2 = factory(Track::class)->create(
            [
                'title' => "Zion and me",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcsiv.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivw",
                'album_id' => 1,
                'user_id' => 1,
            ]
        );

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $this->assertInstanceOf(User::class, $playlist->user()->first());
    }
}
