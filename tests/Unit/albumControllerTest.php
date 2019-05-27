<?php

namespace Tests\Unit;

use App\Models\Album;
use App\User;
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

    public function test_user_cannot_create_duplicate_album () {
        $user = factory(User::class)->create([
            'email' => "doryn113223@gmail.com",
            'password' => bcrypt("test"),
            'username' => "Doryn123334",
        ]);

        $data = [
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ];
        $response = $this->json("POST", "/api/user/add_album/1", $data);



        $response = $this->json("POST", "/api/user/add_album/1", $data)
            ->assertStatus(400)->assertSeeText(
            "Album already exists"
        )
        ;
    }

    public function test_get_user_associated_with_album() {
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

        $response = $this->json("GET", "/api/user/1/album")
            ->assertStatus(200)
            ->assertJsonStructure([
                "email",
                "password",
                "username",
                "updated_at",
                "created_at",
                "id",
                "premium_user"
            ])
        ;
//        dd($response->getContent());
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


    public function test_user_cannot_update_non_existant_album() {
        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);
        $data = [
            "name" => "New Album"
        ];
        $response = $this->json('PUT', "/api/user/album/user/1/edit/2", $data)
            ->assertStatus(404)
            ->assertJson(["message" => "No query results for model [App\\Models\\Album] 2"])
        ;
//        dd($response->getContent());
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

    public function test_user_cannot_delete_non_existent_album () {
        $album = factory(Album::class)->create([
            "name"=> "Raster",
            "released_on"=>"2012",
            "user_id"=>1
        ]);
        $response = $this->json('DELETE', "/api/user/album/user/1/delete/2")
            ->assertStatus(404)
            ->assertJson(["message" => "No query results for model [App\\Models\\Album] 2"]);
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
