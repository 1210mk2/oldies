<?php

namespace App\Helpers;

use DB;

class Helpers
{
    private static $ts;

    public static function timeStart()
    {
        self::$ts = microtime(true);
    }
    public static function timeEnd($dd = false)
    {
        $time = microtime(true) - self::$ts;
        $result = @round($time, 5) . ' s';

        if ($dd) {
            dd($result);
        }

        return $result;
    }

    public static function getMemoryUsage($size = null)
    {
        $unit = ['b','kb','mb','gb','tb','pb'];

        $size = $size ?? memory_get_usage();

        return @round($size/pow(1024,($i=floor(log($size,1024)))),2) . ' ' . $unit[$i];
    }

    /**
     * Enables query log for all connections.
     *
     * @return array connections to check
     */
    public static function enableQueryLog()
    {
        $connections = [
            env('DB_CONNECTION'),
        ];

        foreach ($connections as $connection) {
            DB::connection($connection)->enableQueryLog();

        }

        return $connections;
    }

    /**
     * Get DB queries data since enableQueryLog() mentioned.
     * Uses enableQueryLog() to get connections to show
     *
     * @param bool $dd if set dumps queries and dies.
     * @return array|string
     */
    public static function getQueryLog($dd = false)
    {
        $connections = self::enableQueryLog();

        $result = [];

        foreach ($connections as $connection) {
            $log_array = DB::connection($connection)->getQueryLog();

            if (!$log_array) {

                $result[$connection] = [];
                continue;
            }

            foreach ($log_array as $log) {
                $result[$connection][] = vsprintf(str_replace('?', '\'%s\'', $log['query']), $log['bindings']);
            }

        }
        $result = self::formatArrayWithIndent($result);

        if ($dd) {
            dd($result);
        }

        return $result;
    }

    public static function formatArrayWithIndent($array_or_string)
    {
        static $indent = 0;
        $res = "";

        $tab    = "\t";
        $lf     = "\n";

        if (is_array($array_or_string)) {

            foreach ($array_or_string as $key => $item) {

                $res .= $lf . str_repeat($tab, $indent++)
                      . $key . " => " . self::formatArrayWithIndent($item) . $lf;
                $indent--;
            }

        } else {
            $res .=  (string) $array_or_string;
        }

        return $res;

    }

    public static function getHeaderBodyArrayForModelCollection($data = null)
    {
        if (!$data) {
            return null;
        }
        $first_item = $data->first();
        $attributes = $first_item->getAttributes();
        $header = array_keys($attributes);

        $body = [];
        foreach ($data as $key => $item) {
            $attributes = $item->getAttributes();
            $body[] = array_values($attributes);
        }

        return [
            'header'    => $header,
            'body'      => $body,
        ];

    }
    public static function getHeaderBodyArrayForDBCollection($data = null)
    {
        if (!$data) {
            return null;
        }

        $header = array_keys((array) $data->first());

        $body = [];
        foreach ($data as $key => $item) {
            $body[] = array_values((array) $item);
        }

        return [
            'header'    => $header,
            'body'      => $body,
        ];

    }
}
