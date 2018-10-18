<?php

namespace Ataworks\Layouts\Http;

interface Http
{
    /**
     * Return host info
     *
     * @return string
     */
    public function host() : String;

    /**
     * Return http encoding
     *
     * @return string
     */
    public function encoding() : String;

    /**
     * Return http accept language
     *
     * @return string
     */
    public function language() : String;

    /**
     * Return http accept language full
     *
     * @return string
     */
    public function languageFull() : String;

    /**
     * Return client IP
     *
     * @return string
     */
    public function clientIp() : String;

    /**
     * Return user agent full name
     *
     * @return string
     */
    public function userAgentFull() : String;

    /**
     * Return user agent name
     *
     * @return string
     */
    public function userAgent() : String;

    /**
     * Return cookie
     *
     * @return string
     */
    public function cookie() : String;

    /**
     * Return accept
     *
     * @return string
     */
    public function accept() : String;

    /**
     * Return http status code
     *
     * @param  int    $code
     * @return string
     */
    public function code(Int $code = 200) : String;

    /**
     * Return path info
     *
     * @return string
     */
    public function pathInfo() : String;
}
