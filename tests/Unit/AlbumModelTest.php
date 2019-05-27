<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumModelTest extends TestCase
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

    public function test_album_belongsTo_relationship() {
        $user = factory(User::class)->create([
            'email' => "doryn113223@gmail.com",
            'password' => bcrypt("test"),
            'username' => "Doryn123334",
        ]);

        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);

        $this->assertInstanceOf(User::class, $album->user()->first());
    }

    public function test_album_hasMany_relationship() {
        $user = factory(User::class)->create([
            'email' => "doryn113223@gmail.com",
            'password' => bcrypt("test"),
            'username' => "Doryn123334",
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

        $this->assertInstanceOf(User::class, $album->user()->first());
        $this->assertInstanceOf(Track::class, $album->tracks()->first());
    }
}
