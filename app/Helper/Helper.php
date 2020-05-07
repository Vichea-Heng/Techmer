<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('check_file_exist')) {
    function check_file_exist($path, $fileName, $ext = null)
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
