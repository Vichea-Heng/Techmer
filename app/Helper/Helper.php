<?php

if (!function_exists('check_empty_array')) {
    function check_empty_array($array, $prop)
    {
        try {
            $array[$prop];
            if (empty($array[$prop]))
                return true;
        } catch (Throwable $th) {
            return false;
        }
    }
}
