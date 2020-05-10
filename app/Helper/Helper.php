<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('checkFileExist')) {
    function checkFileExist($path, $fileName, $ext = null)
    {
        if (Storage::exists("$path/" . "$fileName." . $ext)) {
            $key = 1;
            while (Storage::exists("$path/" . $fileName . "_($key)." . $ext)) {
                $key++;
            }
            $fileName .= "_($key)";
        }
        return $fileName . "." . $ext;
    }
}
