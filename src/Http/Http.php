<?php

namespace Ataworks\Http;

use Ataworks\Layouts\Http\Http as IHttp;

/**
 * Ataworks http class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Http implements IHttp
{
    /**
     * Keep http messages list.
     *
     * @var array $messages
     */
    protected $messages = [
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        103 => '103 Checkpoint',
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '301 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        306 => '306 Switch Proxy',
        307 => '307 Temporary Redirect',
        308 => '308 Resume Incomplete',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported',
        511 => '511 Network Authentication Required'
    ];

    /**
     * Return host info
     *
     * @return string
     */
    public function host() : String
    {
        return Request::server('http_host');
    }

    /**
     * Return http encoding
     *
     * @return string
     */
    public function encoding() : String
    {
        return Request::server('http_accept_encoding');
    }

    /**
     * Return http accept language
     *
     * @return string
     */
    public function language() : String
    {
        return strtolower(substr(Request::server('http_accept_language'), 0, 2));
    }

    /**
     * Return http accept language full
     *
     * @return string
     */
    public function languageFull() : String
    {
        return Request::server('http_accept_language');
    }

    /**
     * Return client IP
     *
     * @return string
     */
    public function clientIp() : String
    {
        return Request::server('http_client_ip');
    }

    /**
     * Return user agent full name
     *
     * @return string
     */
    public function userAgentFull() : String
    {
        return Request::server('http_user_agent');
    }

    /**
     * Return user agent name
     *
     * @return string
     */
    public function userAgent() : String
    {
        return get_user_agent();
    }

    /**
     * Return cookie
     *
     * @return string
     */
    public function cookie() : String
    {
        return Request::server('http_cookie');
    }

    /**
     * Return accept
     *
     * @return string
     */
    public function accept() : String
    {
        return Request::server('http_accept');
    }

    /**
     * Return http status code
     *
     * @param  int    $code
     * @return string
     */
    public function code(Int $code = 200) : String
    {
        if (isset($this->messages[$code])) return $this->messages[$code];
        return false;
    }

    /**
     * Return path info
     *
     * @return string
     */
    public function pathInfo() : String
    {
        return Request::server('path_info');
    }
}
