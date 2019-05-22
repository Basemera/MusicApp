<?php

namespace Tests\Unit;

use App\Album;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class albumControllerTest extends TestCase
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

    public function test_user_can_create_album () {
    $data = [
        "released_on" => "2012",
        "name" => "Cinderella and her sisters",
        "email" => "bsmrrachel@gmail.com",
        "password"=> "test"
    ];
    $response = $this->json("POST", "/api/user/add_album/1", $data)->assertStatus(201)->assertJsonStructure(
        [
            "name",
            "released_on",
            "user_id",
            "updated_at",
            "created_at",
            "id"
        ]
    );
    }

    public function test_user_can_view_albums() {
        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);

        $response = $this->json('GET', "/api/user/album/1")
            ->assertStatus(200)
        ;
    }

    public function test_user_can_update_album() {
        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);
        $data = [
            "name" => "New Album"
        ];
        $response = $this->json('PUT', "/api/user/album/user/1/edit/1", $data)
            ->assertStatus(200)->assertJsonStructure(
                [
                    "name",
                    "released_on",
                    "user_id",
                    "updated_at",
                    "created_at",
                    "id"
                ]
            );
    }

    public function test_user_delete_album () {
        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);
        $response = $this->json('DELETE', "/api/user/album/user/1/delete/1")
            ->assertStatus(200)->assertSee("Rastersuccessfully deleted");
    }

    public function test_user_can_view_single_album (){
        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);

        $response = $this->json('GET', "/api/user/album/details/1")
            ->assertStatus(200)
        ;
    }
}
