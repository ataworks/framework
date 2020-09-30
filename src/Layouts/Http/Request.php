<?php

namespace Ataworks\Layouts\Http;

interface Request
{
    /**
     * Url decode to array.
     * 
     * @return string
     */
    public static function requestUri() : String;

    /**
     * Request Url
     *
     * @return string
     */
    public static function requestFullUri() : String;

    /**
     * Post method
     *
     * @param  string|null $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function post(String $key = null, $value = null);

    /**
     * Get method
     *
     * @param  string|null $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function get(String $key = null, $value = null);

    /**
     * Env method
     *
     * @param  string|null $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function env(String $key = null, $value = null);

    /**
     * Server method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function server(String $key = '', $value = null);

    /**
     * Request method
     *
     * @param  string|null $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function request(String $key = null, $value = null);

    /**
     * Return files
     *
     * @param  string|null $name
     * @param  string $type
     * @return mixed
     */
    public static function files(String $name = null, String $type = 'name');

    /**
     * Delete input
     *
     * @param  string $input
     * @param  string $key
     * @return void
     */
    public static function delete(String $input, String $key);

    /**
     * Check ajax request
     *
     * @return boolean
     */
    public static function isAjax() : Bool;

    /**
     * Check curl
     *
     * @return boolean
     */
    public static function isCurl() : Bool;
}
