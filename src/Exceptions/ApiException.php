<?php

namespace Takaworx\Brix\Exceptions;

use Illuminate\Http\Response;

class ApiException extends \Exception
{
    protected $data;

    public function __construct($message = '', $data = '', $code = 0, \Exception $previous = null)
    {
        $this->data = $data;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Return error data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Generate a bad request error
     *
     * @param mixed $data
     * @param string $message
     * @param ApiException
     */
    public static function badRequest($data = null, $message = null, \Exception $previous = null)
    {
        return new static($message, $data, Response::HTTP_BAD_REQUEST, $previous);
    }

    /**
     * Generate an unauthorized error
     *
     * @param mixed $data
     * @param string $message
     * @param ApiException
     */
    public static function unauthorized($data = null, $message = null, \Exception $previous = null)
    {
        return new static($message, $data, Response::HTTP_UNAUTHORIZED, $previous);
    }

    /**
     * Generate a forbidden error
     *
     * @param mixed $data
     * @param string $message
     * @param ApiException
     */
    public static function forbidden($data = null, $message = null, \Exception $previous = null)
    {
        return new static($message, $data, Response::HTTP_FORBIDDEN, $previous);
    }

    /**
     * Generate not found error
     *
     * @param mixed $data
     * @param string $message
     * @param ApiException
     */
    public static function notFound($data = null, $message = null, \Exception $previous = null)
    {
        return new static($message, $data, Response::HTTP_NOT_FOUND, $previous);
    }

    /**
     * Generate a server error
     *
     * @param mixed $data
     * @param string $message
     * @param ApiException
     */
    public static function serverError($data = null, $message = null, \Exception $previous = null)
    {
        return new static($message, $data, Response::HTTP_INTERNAL_SERVER_ERROR, $previous);
    }
}
