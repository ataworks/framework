<?php

namespace Ataworks\Services;

use Ataworks\Layouts\Services\Curl as ICurl;

/**
 * Ataworks curl class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Curl implements ICurl
{
    /**
     * Keep curl init
     *
     * @var resource $init
     */
    private $init;

    /**
     * Keep options
     *
     * @var array $options
     */
    private $options = [
        //
    ];

    /**
     * Curl connect
     *
     * @param  string $url
     * @return object
     */
    public function init(String $url)
    {
        $this->init = curl_init($url);
        return $this;
    }

    /**
     * Curl options
     *
     * @param  string $key
     * @param  mixed  $values
     * @return object
     */
    public function option(String $key, $value)
    {
        $this->options[constant("CURLOPT_".mb_strtoupper($key))] = $value;
        return $this;
    }

    /**
     * Curl exec
     *
     * @return mixed
     */
    public function exec()
    {
        if (!is_resource($this->init)) return false;
        curl_setopt_array($this->init, $this->options);

        /* Reset Options */
        $this->options = [
            //
        ];

        if (is_resource($this->init)) return curl_exec($this->init);
        return false;        
    }

    /**
     * Curl pause
     *
     * @param  int   $time
     * @return mixed
     */
    public function pause(Int $time = 0)
    {
        if (isset($time)) {
            return curl_pause($this->init, constant("CURLPAUSE_".$time));
        }
        return false;
    }

    /**
     * Curl info
     *
     * @param  string $key
     * @return mixed
     */
    public function info(String $key = null)
    {
        if ($key === null) return curl_getinfo($this->init);
        return curl_getinfo($this->init, constant("CURLINFO_".mb_strtoupper($key)));
    }

    /**
     * Curl close
     *
     * @return boolean
     */
    public function close() : Bool
    {
        $init = $this->init;
        if (is_resource($init)) {
            $this->init = null;
            curl_close($init);
            return true;
        }
        return false;
    }
}
