<?php

namespace Takaworx\Brix\Helpers;

use Takaworx\Brix\Exceptions\ApiException;

class ApiResponse
{
    public static function success($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.success');
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function badRequest($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.badRequest');
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 400);
    }

    public static function unauthorized($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.unauthorized');
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 401);
    }

    public static function forbidden($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.forbidden');
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 403);
    }

    public static function notFound($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.notFound');
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 404);
    }

    public static function serverError($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.serverError');
        }

        return response()->json([
            'message' => $message,
            'data' => $data
        ], 500);
    }

    public static function exception(ApiException $e)
    {
        switch ($e->getCode()) {
            case 400:
                return self::badRequest($e->getData(), $e->getMessage());
                break;
            case 401:
                return self::unauthorized($e->getData(), $e->getMessage());
                break;
            case 403:
                return self::forbidden($e->getData(), $e->getMessage());
                break;
            case 404:
                return self::notFound($e->getData(), $e->getMessage());
                break;
            case 500:
                return self::serverError($e->getData(), $e->getMessage());
                break;
        }
    }
}
