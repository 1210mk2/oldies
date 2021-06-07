<?php


namespace App\Services;


use App\Helpers\Helpers;
use App\Models\Artist;
use App\Models\Record;
use \DB;

class SearchService
{

    public const FULLTEXT_SEARCH_SENS = 5;

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

        $artists = $this->artistNameSearch($query);

        $count_of_letters = mb_strlen((string)$query);

        if ($count_of_letters > self::FULLTEXT_SEARCH_SENS) {
            $records = $this->recordFulltextNameOrCatNoSearch($query);
        } else {
            $records = $this->recordNameOrCatNoSearch($query);
        }

        $result = [];

        for ( $i = 0, $l = count($artists); $i < $l; $i++ ) {
            $item = $artists[$i];
            $item->type = 'a';
            $result[] = $item;
        }

        for ( $i = 0, $l = count($records); $i < $l; $i++ ) {
            $item = $records[$i];
            $item->type = 'r';
            $result[] = $item;
        }

        return $result;

    }

    public function artistNameSearch($query) {

        $artist_table_name = $this->getArtistTableName();

        $result = DB::table($artist_table_name)
            ->select([
                "$artist_table_name.id AS artist_id",
                "$artist_table_name.name AS artist_name",
            ])
            ->where("$artist_table_name.name", 'like', '%' . $query . '%')
            ->orderBy("$artist_table_name.name")
            ->get();

        return $result;

    }

    public function recordNameOrCatNoSearch($query) {

        $record_table_name = $this->getRecordTableName();
        $artist_table_name = $this->getArtistTableName();

//        Helpers::enableQueryLog();
        $result = DB::table($record_table_name)
            ->select([
                "$record_table_name.id AS record_id",
                "$record_table_name.name AS record_name",
                "$record_table_name.catno AS record_catno",
                "$artist_table_name.name AS artist_name",
            ])
            ->where("$record_table_name.name", 'like', '%' . $query . '%')
            ->orWhere("$record_table_name.catno", 'like', '%' . $query . '%')
            ->join($artist_table_name, "$record_table_name._artist", '=', "$artist_table_name.id")
            ->orderBy("$artist_table_name.name")
            ->orderBy("$record_table_name.name")
            ->get();

//        Helpers::getQueryLog(1);
        return $result;

    }

    public function recordFulltextNameOrCatNoSearch($query) {

        $record_table_name = $this->getRecordTableName();
        $artist_table_name = $this->getArtistTableName();

//        Helpers::enableQueryLog();
        $result = DB::table($record_table_name)
            ->select([
                "$record_table_name.id AS record_id",
                "$record_table_name.name AS record_name",
                "$record_table_name.catno AS record_catno",
                "$artist_table_name.name AS artist_name",
            ])
            ->whereRaw("MATCH ($record_table_name.name, $record_table_name.catno) AGAINST ('$query')")
            ->join($artist_table_name, "$record_table_name._artist", '=', "$artist_table_name.id")
            ->orderBy("$artist_table_name.name")
            ->orderBy("$record_table_name.name")
            ->get();

//        Helpers::getQueryLog(1);
        return $result;

    }
}
