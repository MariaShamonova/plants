<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\User;
Use App\Models\Plants;
class PlantsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsPlantsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'articul' =>'First Plants',
            'title' => 'First Title',
            'price' => 'First Price', 
            'size_id' =>'First Size_id',
            'color_id' => 'First Color_id',
            'category_id' => 'First Cat_id',
            'description' =>  'First Desc',
            'image' => 'First Inage',
        ];

        $this->json('POST', '/api/plants', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'atricle'=>123456, 'title' => 'Lorem', 'price' => 123, 'size_id'=>1, 'color_id'=>2, 'category_id'=> 3, 'description' => 'Desc', 'image'=> 'file']);
    }

    public function testsPlantsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $plants= factory(Plants::class)->create([
            'articul' =>'First Plants',
            'title' => 'First Title',
            'price' => 'First Price', 
            'size_id' =>'First Size_id',
            'color_id' => 'First Color_id',
            'category_id' => 'First Cat_id',
            'description' =>  'First Desc',
            'image' => 'First Inage',
        ]);

        $payload = [
            'articul' =>'First Plants',
            'title' => 'First Title',
            'price' => 'First Price', 
            'size_id' =>'First Size_id',
            'color_id' => 'First Color_id',
            'category_id' => 'First Cat_id',
            'description' =>  'First Desc',
            'image' => 'First Inage',
        ];

        $response = $this->json('PUT', '/api/plants/' . $plants->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 
                'id' => 1, 
                'articul' =>'First Plants',
                'title' => 'First Title',
                'price' => 'First Price', 
                'size_id' =>'First Size_id',
                'color_id' => 'First Color_id',
                'category_id' => 'First Cat_id',
                'description' =>  'First Desc',
                'image' => 'First Inage',
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $plants = factory(Plants::class)->create([
            'articul' =>'First Plants',
            'title' => 'First Title',
            'price' => 'First Price', 
            'size_id' =>'First Size_id',
            'color_id' => 'First Color_id',
            'category_id' => 'First Cat_id',
            'description' =>  'First Desc',
            'image' => 'First Inage',
        ]);

        $this->json('DELETE', '/api/plants/' . $plants->id, [], $headers)
            ->assertStatus(204);
    }

    public function testPlantssAreListedCorrectly()
    {
        factory(Plants::class)->create([
            'articul' =>'First Plants',
            'title' => 'First Title',
            'price' => 'First Price', 
            'size_id' =>'First Size_id',
            'color_id' => 'First Color_id',
            'category_id' => 'First Cat_id',
            'description' =>  'First Desc',
            'image' => 'First Inage',
        ]);

        factory(Plants::class)->create([
            'articul' =>'First Plants',
            'title' => 'First Title',
            'price' => 'First Price', 
            'size_id' =>'First Size_id',
            'color_id' => 'First Color_id',
            'category_id' => 'First Cat_id',
            'description' =>  'First Desc',
            'image' => 'First Inage',
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/plants', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 
                'articul' =>'First Plants',
                'title' => 'First Title',
                'price' => 'First Price', 
                'size_id' =>'First Size_id',
                'color_id' => 'First Color_id',
                'category_id' => 'First Cat_id',
                'description' =>  'First Desc',
                'image' => 'First Inage', ],
                [ 'articul' =>'Second Plants',
                'title' => 'Second Title',
                'price' => 'Second Price', 
                'size_id' =>'Second Size_id',
                'color_id' => 'Second Color_id',
                'category_id' => 'Second Cat_id',
                'description' =>  'Second Desc',
                'image' => 'Second Inage',]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'articul', 'title', 'price', 'size_id', 'color_id', 'category_id', 'description','image', 'created_at', 'updated_at'],
            ]);
    }

}
