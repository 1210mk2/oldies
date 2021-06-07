<?php

namespace Tests\Feature;

use App\Models\Artist;
use Faker\Provider\en_US\Text;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArtistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_artist_store()
    {
        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => 'Nena']);
        $response->assertStatus(201);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => 'Nena']);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => '']);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => null]);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', []);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => Str::random(300)]);
        $response->assertStatus(422);
    }

    public function test_artist_update()
    {
        $artist = Artist::factory()->create();

        $name = 'Nena or not Nena';

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->put('/api/artist/'.$artist->id, ['name' => $name]);
        $response->assertStatus(200);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => '']);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', ['name' => null]);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/artist', []);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->put('/api/artist/'.$artist->id, ['name' => Str::random(300)]);
        $response->assertStatus(422);

    }

    public function test_artist_destroy()
    {
        $artist = Artist::factory()->create();

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->delete('/api/artist/'.$artist->id);
        $response->assertStatus(200);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->delete('/api/artist/'.$artist->id);
        $response->assertStatus(404);

    }

    public function test_artist_show()
    {
        $artist = Artist::factory()->create();

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->get('/api/artist/'.$artist->id);
        $response->assertStatus(200);
    }

}
