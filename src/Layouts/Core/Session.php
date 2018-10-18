<?php

namespace Ataworks\Layouts\Core;

interface Session
{
    /**
     * Start session.
     *
     * @return void
     */
    public static function init();

    /**
     * Set session key.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public static function set($key, $value);

    /**
     * Return request session key.
     *
     * @param  string $key
     * @return mixed
     */
    public static function get(String $key);

    /**
     * Check login.
     *
     * @return boolean
     */
    public static function loginCheck();

    /**
     * Logout.
     *
     * @return void
     */
    public static function logout();
}
