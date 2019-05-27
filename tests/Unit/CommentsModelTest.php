<?php

namespace Tests\Unit;

use App\Models\Comments;
use App\Models\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsModelTest extends TestCase
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

    public function test_comments_belongsTo_relationship() {
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

        $this->assertInstanceOf(User::class, $comment->user()->first());
    }
}
