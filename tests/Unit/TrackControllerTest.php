<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\Track;
use App\User;
use Cloudder;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
//use JD\Cloudder\Facades\Cloudder;
use JD\Cloudder\Facades\Cloudder as Cloud;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrackControllerTest extends TestCase
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

//     public function test_user_can_create_tracks() {
//         $data = [
//             "released_on" => "2012",
//             "name" => "Cinderella and her sisters",
//             "email" => "bsmrrachel@gmail.com",
//             "password"=> "test"
//         ];
//
//         $album = factory(Album::class)->create([
//             "name"=> "Raster",
//             "released_on"=>"2012",
//             "user_id"=>1
//         ]);
//
//         Storage::fake('videos');
//
//
//
//         $cloudder = $this->getMockBuilder(Cloud::class)
//                          ->setMethods(['uploadVideo', 'secureShow', 'getPublicId', 'getResult'])
//                          ->getMock();
//
//         $cloudder->expects($this->once())
//                  ->method('uploadVideo')
//                  ->with($this->equalTo(UploadedFile::fake()->create('video', 1)
// ));
//         $song = new \Illuminate\Http\UploadedFile(resource_path(
//             'files/ZION_S_DAUGHTER___SHIRU.MP3'),
//             'ZION_S_DAUGHTER___SHIRU.MP3',
//             null,
//             null,
//             null,
//             true
//         );
//         $data = [
//             'title' => "Felix",
//
//
//         ];
//
//         $response = $this->json("POST", "/api/user/1/album/1/track", $data, ["Content-Type" => "application/json"]);
//         dd($response->getContent());
//     }


    public function test_create_tracks_fails_when_title_is_missing() {
        $data = [
            "released_on" => "2012",
            "name" => "Cinderella and her sisters",
            "email" => "bsmrrachel@gmail.com",
            "password"=> "test"
        ];

        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);

        $data = [
            'upload' => "song",
        ];

        $response = $this->json("POST", "/api/user/1/album/1/track", $data)
                        ->assertStatus(422)
                        ->assertJson(
                            [
                                "message" => "The given data was invalid.",
                                "errors" => [
                                    "title" => ["The title field is required."]
                                ]
                            ]
                        )
        ;
    }

//    public function test_create_tracks_fails_when_title_is_duplicate() {
//
//        $user = factory(User::class)->create([
//            'email' => "doryn113223@gmail.com",
//            'password' => bcrypt("test"),
//            'username' => "Doryn123334",
//        ]);
//
//        $album = factory(Album::class)->create([
//            "name"=> "Raster",
//            "released_on"=>"2012",
//            "user_id"=>1
//        ]);
//
//        Storage::fake('public');
//
//
//
//        $track = factory(Track::class)->create(
//            [
//                'title' => "Zion",
//                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqciv.mp3",
//                'public_id' => "cbc0rg7pp2hof4oyqciv",
//                'album_id' => 1,
//                'user_id' => 1,
//            ]
//        );
//
////        $track = factory(Track::class)->create(
////            [
////                'title' => "Zion",
////                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqcilv.mp3",
////                'public_id' => "cbc0rg7pp2hof4oyqcivy",
////                'album_id' => 1,
////                'user_id' => 1,
////            ]
////        );
//
////        dd($track);
//
//        $data = [
//            "title" => "Zions",
//            "upload" => UploadedFile::fake()->create('summer_time.mp3', 10)
//        ];
//
//        $response = $this->json("POST", "/api/user/1/album/1/track", $data)
////            ->assertStatus(400)
////            ->assertJson(
////                [
////                    "message" => "The given data was invalid.",
////                    "errors" => [
////                        "title" => ["The title field is required."]
////                    ]
////                ]
////            )
//        ;
//        dd($response->getContent());
//    }

    public function test_user_can_retrieve_tracks() {
        $track = factory(Track::class)->create(
            [
                'title' => "Zion",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqciv.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqciv",
                'album_id' => 1,
                'user_id' => 1,
            ]
        );
        $response = $this->json("GET", "/api/user/1/album/1/track/1")->assertStatus(200)->assertJsonStructure([
            'song_url'
        ]);
    }

    public function test_user_can_edit_track() {
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
            'title' => "Changed me"
        ];

        $response = $this->json("PATCH", "/api/user/1/album/1/track/1", $data)->assertStatus(200)->assertJsonStructure([
            "id",
            "user_id",
            "album_id",
            "title",
            "url",
            "public_id",
            "ratings",
            "created_at",
            "updated_at"
        ]);
    }

    public function test_user_cannot_edit_non_existant_track() {
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
            'title' => "Changed me"
        ];

        $response = $this->json("PATCH", "/api/user/1/album/1/track/2", $data)
            ->assertStatus(404)
            ->assertJson(["message" => "No query results for model [App\\Models\\Track] 2"])
        ;
    }

    public function test_user_can_delete_track() {
        $track = factory(Track::class)->create(
            [
                'title' => "Zion",
                'url' => "https://res.cloudinary.com/bas-music-store/video/upload/cbc0rg7pp2hof4oyqciv.mp3",
                'public_id' => "cbc0rg7pp2hof4oyqciv",
                'album_id' => 1,
                'user_id' => 1,
            ]
        );
        $response = $this->json("DELETE", "/api/user/1/album/1/track/1")
                    ->assertStatus(200)
                    ->assertSeeText("Track deleted successfully");
    }
}
