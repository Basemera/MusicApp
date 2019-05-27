<?php

namespace Tests\Unit;

use App\Models\Comments;
use App\Models\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Carbon\Carbon;

class CommentsControllerTest extends TestCase
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

    public function test_can_add_comment() {
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
            "Details" => "This is the comment"
        ];
        $response = $this->json("POST", "/api/user/1/track/1/comment", $data)
                                                                            ->assertStatus(201)
                                                                            ->assertJsonStructure([
                                                                                "Details",
                                                                                "song_id",
                                                                                "user_id",
                                                                                "updated_at",
                                                                                "created_at",
                                                                                "id"
                                                                            ]);
    }

    public function test_can_edit_comment() {
        $user = factory(User::class)->create([
            "username"=> "Raster",
            "email"=>"doryn113223@gmail.com",
            "password"=>bcrypt('test')
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
        $comment =  factory(Comments::class)->create([
            "Details" => "This is the comment section"
        ]);
        $data = [
            "Details" => "This is the comment edited"
        ];
        $response = $this->json("PATCH", "/api/user/comment/1", $data)
                                                                            ->assertStatus(200)
                                                                            ->assertJsonStructure([
                                                                                "Details",
                                                                                "song_id",
                                                                                "user_id",
                                                                                "updated_at",
                                                                                "created_at",
                                                                                "id"
                                                                            ])
                                                                            ;

    }

    public function test_can_delete_comment() {
        $user = factory(User::class)->create([
            "username"=> "Raster",
            "email"=>"doryn113223@gmail.com",
            "password"=>bcrypt('test')
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
        $comment =  factory(Comments::class)->create([
            "Details" => "This is the comment section"
        ]);
        $data = [
            "Details" => "This is the comment edited"
        ];
        $response = $this->json("DELETE", "/api/user/comment/1", $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                "Details",
                "song_id",
                "user_id",
                "updated_at",
                "created_at",
                "id"
            ])
        ;

    }

    public function test_can_get_comments() {
        $user = factory(User::class)->create([
            "username"=> "Raster",
            "email"=>"doryn113223@gmail.com",
            "password"=>bcrypt('test')
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
        $comment =  factory(Comments::class)->create([
            "Details" => "This is the comment section",
            'user_id' => 1,
            "song_id" => 1
        ]);
        $mytime = Carbon::now();
        echo $mytime->toDateTimeString();
        $response = $this->json("GET", "/api/user/comment/track/1")
            ->assertStatus(200)
            ->assertJson([
                [

                    "id" => 1,
                    "Details" => "This is the comment section",
                    "user_id" => 1,
                    "song_id" => 1,
                    "created_at"=>date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),

                ]
            ])
        ;

    }

    public function test_can_get_comment() {
        $user = factory(User::class)->create([
            "username"=> "Raster",
            "email"=>"doryn113223@gmail.com",
            "password"=>bcrypt('test')
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
        $comment =  factory(Comments::class)->create([
            "Details" => "This is the comment section",
            'user_id' => 1,
            "song_id" => 1
        ]);
        $mytime = Carbon::now();
        echo $mytime->toDateTimeString();
        $response = $this->json("GET", "/api/user/comment/1")
            ->assertStatus(200)
        ;

    }
}
