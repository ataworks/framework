<?php

namespace Ataworks\Http;

use Ataworks\Layouts\Http\Request as IRequest;

/**
 * Ataworks request class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Request implements IRequest
{
    /**
     * Url decode to array.
     * 
     * @return string
     */
    public static function requestUri() : String
    {
        $uri = urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
        return $uri;
    }

    /**
     * Request Url
     *
     * @return string
     */
    public static function requestFullUri() : String
    {
        return rtrim(CONFIG['url'], '/').self::requestUri();
    }

    /**
     * Post method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function post(String $key = null, $value = null)
    {
        if (!empty($value)) return $_POST[$key] = $value;
        if (isset($_POST[$key])) return clean($_POST[$key]);
        return false;
    }

    /**
     * Get method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function get(String $key = null, $value = null)
    {
        if (!empty($value)) return $_GET[$key] = $value;
        if (isset($_GET[$key])) return clean($_GET[$key]);
        return false;
    }

    /**
     * Env method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function env(String $key = null, $value = null)
    {
        if (!empty($value)) return $_ENV[$key] = $value;
        if (isset($_ENV[$key])) return clean($_ENV[$key]);
        return false;
    }

    /**
     * Server method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function server(String $key = '', $value = null)
    {
        $key = mb_strtoupper($key);
        if (!empty($value)) return $_SERVER[$key] = $value;
        if (isset($_SERVER[$key])) return clean($_SERVER[$key]);
        return false;
    }

    /**
     * Request method
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    public static function request(String $key = null, $value = null)
    {
        if (!empty($value)) return $_REQUEST[$key] = $value;
        if (isset($_REQUEST[$key])) return clean($_REQUEST[$key]);
        return false;
    }

    /**
     * Return files
     *
     * @param  string $name
     * @param  string $type
     * @return mixed
     */
    public static function files(String $name = null, String $type = 'name')
    {
        return $_FILES[$name][$type];
    }

    /**
     * Delete input
     *
     * @param  string $input
     * @param  string $key
     * @return void
     */
    public static function delete(String $input, String $key)
    {
        switch ($input) {
            case 'post':
                unset($_POST[$key]);
                break;
            case 'get':
                unset($_GET[$key]);
                break;
            case 'env':
                unset($_ENV[$key]);
                break;
            case 'server':
                unset($_SERVER[$key]);
                break;
            case 'request':
                unset($_REQUEST[$key]);
                break;
        }
    }

    /**
     * Check ajax request
     *
     * @return boolean
     */
    public static function isAjax() : Bool
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return true;
        }
        return false;
    }

    /**
     * Check curl
     *
     * @return boolean
     */
    public static function isCurl() : Bool
    {
        if (!empty($_SERVER['HTTP_COOKIE'])) return false;
        return true;
    }
}
