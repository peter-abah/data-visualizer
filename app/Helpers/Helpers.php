<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

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

    public static function extractKeysFromArray(array $array, array $keysToExtract) {
        $extractedArray = [];

        foreach ($keysToExtract as $key) {
            if (isset($array[$key])) {
                $extractedArray[$key] = $array[$key];
            }
        }

        return $extractedArray;
    }
}
