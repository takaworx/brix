<?php

namespace Takaworx\Brix\Exceptions;

class ApiException extends \Exception
{
    protected $data;

    public function __construct($data = null, $message = null, $code = 400)
    {
        if (is_null($message)) {
            $message = trans('brix.response.badRequest');
        }

        $this->data = $data;
        
        parent::__construct($message, $code);
    }

    public function getData()
    {
        return $this->data;
    }

    public static function badRequest($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.badRequest');
        }

        return new self($data, $message, 400);
    }

    public static function unauthorized($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.unauthorized');
        }

        return new self($data, $message, 401);
    }

    public static function forbidden($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.forbidden');
        }

        return new self($data, $message, 403);
    }

    public static function notFound($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.notFound');
        }

        return new self($data, $message, 404);
    }

    public static function serverError($data = null, $message = null)
    {
        if (is_null($message)) {
            $message = trans('brix.response.serverError');
        }

        return new self($data, $message, 500);
    }
}
