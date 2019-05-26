<?php

namespace Tests\Unit;

use App\Album;
use App\Models\Track;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaylistControllerTest extends TestCase
{
    use DatabaseMigrations;
    use withoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test_can_create_playlist() {

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

        $track = factory(Track::class)->create(
            [
                'title' => "Zion and me",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcsiv.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivw",
                'album_id' => 1,
                'user_id' => 1,
            ]
        );

        $data = [
            'name' => "First",
            'tracks' => [1,2]
        ];

        $response = $this->json("POST", "/api/user/1/playlist", $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'tracks'
            ]);
    }
}
