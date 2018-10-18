<?php

namespace Ataworks\Helpers;

use Ataworks\Layouts\Helpers\Json as IJson;

/**
 * Ataworks json class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Json implements IJson
{
    /**
     * Json decode object
     *
     * @param  string $data
     * @param  int    $length
     * @return object
     */
    public static function decodeObject(String $data, Int $length = 1048576)
    {
        return self::execute($data, false, $length);
    }

    /**
     * Json decode array
     *
     * @param  string $data
     * @param  int    $length
     * @return mixed
     */
    public static function decodeArray(String $data, Int $length = 1048576)
    {
        return self::execute($data, true, $length);
    }

    /**
     * Json execute
     *
     * @param  string $data
     * @param  bool   $type
     * @param  int    $length
     * @return mixed
     */
    public static function execute(String $data, Bool $type = false, Int $length = 1048576)
    {
        return json_decode($data, $type, $length);
    }

    /**
     * Json encode
     *
     * @param  mixed  $data
     * @param  string $type
     * @return string
     */
    public static function encode($data, String $type = 'unescaped_unicode') : String
    {
        return json_encode($data, constant("JSON_".mb_strtoupper($type)) );
    }

    /**
     * Check json process
     *
     * @param  string $data
     * @return boolean
     */
    public static function check(String $data) : Bool
    {
        return (is_array(json_decode($data, true)) && json_last_error() === 0);
    }
}
