<?php

namespace Ataworks\Layouts\Cookie;

interface Cookie
{
    /**
     * Update session time
     *
     * @param  int $time
     * @return mixed
     */
    public function time(Int $time);

    /**
     * Update session domain
     *
     * @param  string $domain
     * @return mixed
     */
    public function domain(String $domain);

    /**
     * Update session path
     *
     * @param  string $path
     * @return mixed
     */
    public function path(String $path);

    /**
     * Update session secure
     *
     * @param  string $secure
     * @return mixed
     */
    public function secure(String $secure);

    /**
     * Set cookie
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  int     $time
     * @return boolean
     */
    public function set(String $name, $value, Int $time = null) : Bool;

    /**
     * Return cookie value
     *
     * @param  string $get
     * @return mixed
     */
    public function get(String $name);

    /**
     * Return all cookie
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Delete cookie
     *
     * @param  string  $name
     * @param  string  $path
     * @return boolean
     */
    public function delete(String $name, String $path = null) : Bool;

    /**
     * Delete cookies
     *
     * @return boolean
     */
    public function deleteAll();

    /**
     * Return path
     *
     * @return string
     */
    public function getPath() : String;

    /**
     * Return domain
     *
     * @return string
     */
    public function getDomain() : String;
}
