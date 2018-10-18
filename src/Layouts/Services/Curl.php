<?php

namespace Ataworks\Layouts\Services;

interface Curl
{
    /**
     * Curl connect
     *
     * @param  string $url
     * @return object
     */
    public function init(String $url);

    /**
     * Curl options
     *
     * @param  string $key
     * @param  mixed $values
     * @return object
     */
    public function option(String $key, $value);

    /**
     * Curl exec
     *
     * @return mixed
     */
    public function exec();

    /**
     * Curl pause
     *
     * @param  int   $time
     * @return mixed
     */
    public function pause(Int $time);

    /**
     * Curl info
     *
     * @return mixed
     */
    public function info();

    /**
     * Curl close
     *
     * @return boolean
     */
    public function close() : Bool;
}
