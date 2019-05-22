<?php

namespace Tests\Unit;

use App\Album;
use App\Models\Track;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_user_can_create_tracks() {
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

        Storage::fake('videos');



        $cloudder = $this->getMockBuilder(\Cloudder::class)
                         ->setMethods(['uploadVideo', 'secureShow', 'getPublicId', 'getResult'])
                         ->getMock();

        $cloudder->expects($this->once())
                 ->method('uploadVideo')
                 ->with($this->equalTo(UploadedFile::fake()->create('video', 2)
));
        $song = new \Illuminate\Http\UploadedFile(resource_path(
            'files/ZION_S_DAUGHTER___SHIRU.MP3'),
            'ZION_S_DAUGHTER___SHIRU.MP3',
            null,
            null,
            null,
            true
        );
        $data = [
            'upload' => $song->get(),
            'title' => "Felix",

        ];

        $response = $this->json("POST", "/api/user/1/album/1/track", $data, ["CONTENT_TYPE" => "multipart/mixed"]);
        dd($response->getContent());
    }

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
