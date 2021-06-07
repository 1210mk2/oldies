<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Record;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $path = 'records.csv';

        if (!Storage::disk('public')->exists($path)) {
            throw new \Exception('file not exist');
        }

        $file = fopen(config('filesystems.disks.public.root'). DIRECTORY_SEPARATOR. $path, "r");
        while ( false !== $data = fgetcsv($file, 100000, ';') ) {

            $artist_name    = $data[0];
            $record_name    = $data[1];
            $record_catno   = $data[2];

            $artist = Artist::firstOrCreate(['name' => $artist_name]);
            $record = $artist->records()->firstOrCreate([
                'name'      => $record_name,
                'catno'     => $record_catno,
            ]);

        }
        fclose($file);
    }
}
