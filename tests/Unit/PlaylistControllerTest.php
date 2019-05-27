<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\Playlist;
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

    public function test_cannot_duplicate_playlist() {

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

        $response = $this->json("POST", "/api/user/1/playlist", $data);

        $response = $this->json("POST", "/api/user/1/playlist", $data)
            ->assertStatus(400)
            ->assertSeeText("Playlist already exists. Do you want to add songs instead")
        ;
    }

    public function test_add_track_to_playlist(){
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
                'title' => "Zion king",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcivf.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivf",
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

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $data = [
            'name' => "First",
            'tracks' => [1,2],
            'condition' => 'add'
        ];

        $response = $this->json("PATCH", "/api/user/1/playlist/1", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'user_id',
                'name',
                'tracks',
                'created_at',
                'updated_at'
            ])
        ;
    }

    public function test_remove_track_from_playlist(){
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
                'title' => "Zion king",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcivf.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivf",
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

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $data = [
            'name' => "First",
            'tracks' => [2],
            'condition' => 'remove'
        ];

        $response = $this->json("PATCH", "/api/user/1/playlist/1", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'user_id',
                'name',
                'tracks',
                'created_at',
                'updated_at'
            ])
        ;
    }

    public function test_update_non_existant_track_on_playlist(){
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
                'title' => "Zion king",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcivf.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivf",
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

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $data = [
            'name' => "First",
            'tracks' => [4],
            'condition' => 'add'
        ];

        $response = $this->json("PATCH", "/api/user/1/playlist/1", $data)
            ->assertStatus(404)
            ->assertJson(["message" => "No query results for model [App\\Models\\Track] 4"])

        ;
    }

    public function test_update_non_existant_playlist(){
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

        $data = [
            'name' => "First",
            'tracks' => [1,2,4],
            'condition' => 'add'
        ];

        $response = $this->json("PATCH", "/api/user/1/playlist/1", $data)
            ->assertStatus(404)
            ->assertJson(["message" => "No query results for model [App\\Models\\Playlist] 1"])

        ;
    }

    public function test_get_all_user_playlists(){
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

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $response = $this->json("GET", "/api/user/1/playlist")
            ->assertStatus(200);
    }

    public function test_get_single_playlist(){
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

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $response = $this->json("GET", "/api/user/playlist/1")
            ->assertStatus(200);
    }

    public function test_cannot_update_with_no_tracks(){
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
                'title' => "Zion king",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcivf.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqcivf",
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

        $playlist = factory(Playlist::class)->create(
            [
                'name' => "First",
                'tracks' => [1,2,3],
                "user_id" => 1
            ]
        );

        $data = [
            'name' => "First",
            'condition' => 'add'
        ];

        $response = $this->json("PATCH", "/api/user/1/playlist/1", $data)
            ->assertStatus(400)
            ->assertSeeText("No tracks to add please add some")
        ;
    }

}
