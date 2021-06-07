<?php


namespace App\Services;


use App\Models\Artist;
use App\Models\Record;
use \DB;

class SearchService
{

    public function getArtistTableName()
    {
        static $artist_table_name;

        if (!$artist_table_name) {
            $artist_table_name = (new Artist())->getTable();
        }

        return $artist_table_name;
    }

    public function getRecordTableName()
    {
        static $record_table_name;

        if (!$record_table_name) {
            $record_table_name = (new Record())->getTable();
        }

        return $record_table_name;
    }

    public function simpleSearch($query) {

        $records = DB::table($this->getRecordTableName())
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        return $records;

    }
}
