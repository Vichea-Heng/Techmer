<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('indexResponse')) {
    function createResponse($data)
    {
        return response()->json($data, Response::HTTP_OK);
    }
}
if (!function_exists('storeResponse')) {
    function createResponse()
    {
    }
}
if (!function_exists('showResponse')) {
    function createResponse()
    {
    }
}
if (!function_exists('updateResponse')) {
    function createResponse()
    {
    }
}
if (!function_exists('destoryResponse')) {
    function createResponse()
    {
    }
}
if (!function_exists('restoreResponse')) {
    function createResponse()
    {
    }
}
if (!function_exists('forceDestoryResponse')) {
    function createResponse()
    {
    }
}
