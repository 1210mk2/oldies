<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Record;
use Faker\Provider\en_US\Text;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RecordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_record_store()
    {
        $artist = Artist::factory()->create();

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => '99 Luftballons',
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(201);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => '99 Luftballons',
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => '',
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => null,
            '_artist'   => $artist->id,
        ]);

        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', []);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => Str::random(300),
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(422);
    }

    public function test_record_update()
    {
        $record = Record::factory()->create();
        $artist = Artist::factory()->create();

        $name = '99 Luftballons or 100 Luftballons';

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->put('/api/record/'.$record->id, [
            'name'      => $name,
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(200);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => '',
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', [
            'name'      => null,
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->post('/api/record', []);
        $response->assertStatus(422);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->put('/api/record/'.$record->id, [
            'name' => Str::random(300),
            '_artist'   => $artist->id,
        ]);
        $response->assertStatus(422);

    }

    public function test_record_destroy()
    {
        $record = Record::factory()->create();

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->delete('/api/record/'.$record->id);
        $response->assertStatus(200);

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->delete('/api/record/'.$record->id);
        $response->assertStatus(404);

    }

    public function test_record_show()
    {
        $record = Record::factory()->create();

        $response = $this->withHeaders([
            'api_key' => env('API_KEY'),
        ])->get('/api/record/'.$record->id);
        $response->assertStatus(200);
    }

}
