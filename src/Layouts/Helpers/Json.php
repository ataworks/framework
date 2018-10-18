<?php

namespace Ataworks\Layouts\Helpers;

interface Json
{
    /**
     * Json decode object
     *
     * @param  string $data
     * @param  int    $length
     * @return object
     */
    public static function decodeObject(String $data, Int $length = 1048576);

    /**
     * Json decode array
     *
     * @param  string $data
     * @param  int    $length
     * @return mixed
     */
    public static function decodeArray(String $data, Int $length = 1048576);

    /**
     * Json execute
     *
     * @param  string $data
     * @param  bool   $type
     * @param  int    $length
     * @return mixed
     */
    public static function execute(String $data, Bool $type = false, Int $length = 1048576);

    /**
     * Json encode
     *
     * @param  mixed  $data
     * @param  string $type
     * @return string
     */
    public static function encode($data, String $type = 'unescaped_unicode') : String;

    /**
     * Check json process
     *
     * @param  string  $data
     * @return boolean
     */
    public static function check(String $data) : Bool;
}
