<?php

namespace Ataworks\Cookie;

use Ataworks\Layouts\Cookie\Cookie as ICookie;

/**
 * Ataworks cookie class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Cookie implements ICookie
{
    /**
     * Keep cookie time.
     *
     * @var integer $time
     */
    protected $time;

    /**
     * Keep cookie domain.
     *
     * @var string $domain
     */
    protected $domain;

    /**
     * Keep cookie path.
     *
     * @var string $path
     */
    protected $path;

    /**
     * Keep cookie secure.
     *
     * @var bool $secure
     */
    protected $secure;

    public function __construct() { }

    /**
     * Update session time
     *
     * @param  int $time
     * @return bool|string
     */
    public function time(Int $time)
    {
        if (is_numeric($time)) {
            $this->time = $time;
            return $this;
        }
        return false;
    }

    /**
     * Update session domain
     *
     * @param  string $domain
     * @return bool|string
     */
    public function domain(String $domain)
    {
        if (is_string($domain)) {
            $this->domain = $domain;
            return $this;
        }
        return false;
    }

    /**
     * Update session path
     *
     * @param  string $path
     * @return bool|string
     */
    public function path(String $path)
    {
        if (is_string($path)) {
            $this->path = $path;
            return $this;
        }
        return false;
    }

    /**
     * Update session secure
     *
     * @param  string $secure
     * @return bool|string
     */
    public function secure(String $secure)
    {
        if (is_bool($secure)) {
            $this->secure = $secure;
            return $this;
        }
        return false;
    }

    /**
     * Set cookie
     *
     * @param  string    $name
     * @param  mixed     $value
     * @param  int |null $time
     * @return boolean
     */
    public function set(String $name, $value, Int $time = null) : Bool
    {
        if (!empty($time)) $this->time($time);
        $Config = CONFIG['cookie'];

        /* Cookie config */
        if (empty($this->time))     $this->time     = $Config['time'];
        if (empty($this->domain))   $this->domain   = $Config['domain'];
        if (empty($this->path))     $this->path     = $Config['path'];
        if (empty($this->secure))   $this->secure   = $Config['secure'];

        if (setcookie($name, $value, time() + $this->time, $this->path, $this->domain, $this->secure)) {
            return true;
        }

        return false;
    }

    /**
     * Return cookie value
     *
     * @param  string $name
     * @return bool|string
     */
    public function get(String $name)
    {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return false;
    }

    /**
     * Return all cookie
     *
     * @return mixed
     */
    public function getAll()
    {
        if (!empty($_COOKIE)) {
            return $_COOKIE;
        }
        return false;
    }

    /**
     * Delete cookie
     *
     * @param  string $name
     * @param  string|null $path
     * @return boolean
     */
    public function delete(String $name, String $path = null) : Bool
    {
        $Config = CONFIG['cookie'];

        /* Check $path param */
        if (!empty($path))      $this->path = $path;
        if (empty($this->path)) $this->path = $Config["path"];

        if (isset($_COOKIE[$name])) {
            setcookie($name, '', (time() - 1), $this->path);
            $this->path = null;
            return true;
        }
        
        return false;
    }

    /**
     * Delete cookies
     *
     * @return boolean
     */
    public function deleteAll() : bool
    {
        $Config = CONFIG['cookie'];
        $path = $Config['path'];

        if (!empty($_COOKIE))
        {
            foreach ($_COOKIE as $key => $value)
            {
                setcookie($key, '', time() - 1, $path);
            }
            return true;
        }
        return false;
    }

    /**
     * Return path
     *
     * @return string
     */
    public function getPath() : String
    {
        return $this->path;
    }

    /**
     * Return domain
     *
     * @return string
     */
    public function getDomain() : String
    {
        return $this->domain;
    }
}
