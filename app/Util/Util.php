<?php

namespace App\Util;

class Util
{
    public static function ArrayFromCSV(string $file, bool $hasFieldNames = false,
                                        ?int $lineLength = 512, string $separator = ',',
                                        string $enclosure = '"', string $escape = '\\')
    {
        $result = [];
        $file = fopen($file, 'r');
        #TO DO: There must be a better way of finding out the size of the longest row... until then
        if ($hasFieldNames) {
            $keys = fgetcsv($file, $lineLength, $separator, $enclosure, $escape);
        }
        while ($row = fgetcsv($file, $lineLength, $separator, $enclosure, $escape)) {
            $n = count($row);
            $res = [];
            for ($i = 0; $i < $n; $i++) {
                $idx = ($hasFieldNames) ? $keys[$i] : $i;
                $res[$idx] = $row[$i];
            }
            $result[] = $res;
        }
        fclose($file);
        return $result;
    }
}
