<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('check_file_exist')) {
    function check_file_exist($path, $fileName, $ext)
    {
        if (Storage::exists("$path/" . "$fileName." . $ext)) {
            $key = 1;
            while (Storage::exists("$path/" . "$fileName ($key)." . $ext)) {
                $key++;
            }
            $fileName .= " ($key)";
        }
        return $fileName . "." . $ext;
    }
}
