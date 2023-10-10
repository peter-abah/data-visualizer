<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\ViewErrorBag;

class Helpers
{
    public static function spoofStringAsFile(string $data)
    {
        // Remove Byte Order Mark if it exists in string
        $data = str_replace("\xEF\xBB\xBF", '', $data);

        // Spoof string as a file
        $fp = fopen("php://temp", 'r+');
        fputs($fp, $data);
        rewind($fp);

        return $fp;
    }

    // Removes all occurences of Byte Order mark from uploaded file
    public static function removeBOMFromUploadedFile(UploadedFile $file)
    {
        $contents = str_replace("\xEF\xBB\xBF", '', $file->get());
        $fileObj = $file->openFile("w");
        $fileObj->fwrite($contents);
    }

    // Filters keys and values in $array from $keysToFilter and returns a new array with the filtered keys
    public static function filterKeysInArray(array $array, array $keysToFilter)
    {
        $extractedArray = [];

        foreach ($keysToFilter as $key) {
            if (isset($array[$key])) {
                $extractedArray[$key] = $array[$key];
            }
        }

        return $extractedArray;
    }

    public static function mergeDataColumnsErrors(ViewErrorBag $errors, int $columnsNo)
    {
        if ($columnsNo < 1) {
            return [];
        }

        $mapFunc = function ($i) use ($errors) {
            return $errors->get("dataColumns.$i");
        };

        return array_merge($errors->get('dataColumns'), ...array_map($mapFunc, range(0, $columnsNo - 1)));
    }
}
