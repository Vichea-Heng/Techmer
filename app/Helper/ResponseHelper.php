<?php

use Symfony\Component\HttpFoundation\Response;

if (!function_exists('dataResponse')) {
    function dataResponse($data)
    {
        return response()->json($data, Response::HTTP_OK);
    }
}
// if (!function_exists('failedResponse')) {
//     function failedResponse($message)
//     {
//         return response()->json(["message" => $message], Response::HTTP_EXPECTATION_FAILED);
//     }
// }
if (!function_exists('successResponse')) {
    function successResponse($message)
    {
        return response()->json(["message" => $message], Response::HTTP_OK);
    }
}
// if (!function_exists('storeResponse')) {
//     function storeResponse()
//     {
//     }
// }
// if (!function_exists('showResponse')) {
//     function showResponse()
//     {
//     }
// }
// if (!function_exists('updateResponse')) {
//     function updateResponse()
//     {
//     }
// }
if (!function_exists('destoryResponse')) {
    function destoryResponse($message = NULL)
    {
        return successResponse($message ?? "Data Delete successfully !!!");
    }
}
if (!function_exists('restoreResponse')) {
    function restoreResponse($message = NULL)
    {
        return successResponse($message ?? "Data Restore successfully !!!");
    }
}
if (!function_exists('forceDestoryResponse')) {
    function forceDestoryResponse($message = NULL)
    {
        return successResponse($message ?? "Data Force Delete successfully !!!");
    }
}
