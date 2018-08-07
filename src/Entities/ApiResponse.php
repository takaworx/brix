<?php

namespace Takaworx\Brix\Entities;

use Illuminate\Http\Response;

class ApiResponse
{
    /**
     * Returns success data
     *
     * @param mixed $data
     * @param string $message
     * @return Response
     */
    public static function success($data = null, $message = null)
    {
        $status = Response::HTTP_OK;

        if (is_null($message)) {
            $message = Response::$statusTexts[$status];
        }

        return response()
            ->json($data)
            ->setStatusCode($status, $message);
    }

    /**
     * Returns error data
     *
     * @param int $status
     * @param mixed $data
     * @param string $message
     * @return Response
     */
    public static function error($status, $data = null, $message = null)
    {
        if (is_null($message)) {
            $message = Response::$statusTexts[$status];
        }

        return response()
            ->json($data)
            ->setStatusCode($status, $message);
    }

    /**
     * Return an error data based from an ApiException
     *
     * @param ApiException $e
     * @return Response
     */
    public static function exception($e)
    {
        return response()
            ->json($e->getData())
            ->setStatusCode($e->getCode(), $e->getMessage());
    }
}
