<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;


class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
//    use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_register()
{

        $data = [
            "username" => "Doryn123334",
            "email"    => "doryn113223@gmail.com",
            "password" => "test"
        ];

    $response = $this->json('POST', '/api/auth/register', $data);

    $response->assertStatus(201)->assertJsonStructure([
            "email",
            "password",
            "username",
            "updated_at",
            "created_at",
            "id"
    ]

    );

}

    public function test_user_cannot_register_with_missing_username()
    {
        $response = $this->json('POST', '/api/auth/register', [
            "username" => "Doryn123334",
            "password" => "test"
        ]);
        $response->assertStatus(400)->assertJsonStructure([
            "email"
        ]);
    }

    public function test_user_cannot_register_with_missing_email()
    {
        $response = $this->json('POST', '/api/auth/register', [
            "username" => "Doryn123334",
            "password" => "test"
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            "email"
        ]);

    }

    public function test_user_cannot_register_without_password()
    {
        $response = $this->json('POST', '/api/auth/register', [
            "username" => "Doryn123334",
            "email"    => "doryn113223@gmail.com",
        ]);

        $response->assertStatus(400)->assertJsonStructure([
            "password"
        ]);
    }

//    public function test_user_can_login() {
////        $user = factory(User::class)->create([
//////            'email' => "doryn113223@gmail.com",
//////            'password' => Hash::make("test"),
//////            'username' => "Doryn123334",        ]);
//////
/////
////        $user = factory(User::class)->create([
////            "username"=> "Raster",
////            "email"=>"test3@gmail.com",
////            "password"=>bcrypt('test')
////        ]);
//
//
//        $response=$this->json('POST', 'api/auth/login', [
//            "email"    => "test@gmail.com",
//            "password" => ("test")
//        ])
//         ->assertStatus(200)
//        ;
////        dd($response->getContent());
//    }

}
