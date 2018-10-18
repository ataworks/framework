<?php

namespace Ataworks\Core;

use Ataworks\Layouts\Core\Session as ISession;

/**
 * Ataworks session class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
final class Session implements ISession
{
    /**
     * Keep prefix to session.
     *
     * @var string $prefix
     */
    public static $prefix = SESSION_PREFIX;

    /**
     * Start session.
     *
     * @return void
     */
    public static function init()
    {
        /* Turn on output buffering and start session */
        ob_start();
        session_start();

        /* Session for guest account */
        if (self::get('uname') === false) self::set('uname', 'Guest');
    }

    /**
     * Set session key.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[self::$prefix.clean($key)] = clean($value);
    }

    /**
     * Return request session key.
     *
     * @param  string $key
     * @return mixed
     */
    public static function get(String $key)
    {
        /**
         * Check $key.
         * If empty $key return false else string.
         */
        if (isset($_SESSION[self::$prefix.$key])) {
            return $_SESSION[self::$prefix.$key];
        }
        return false;
    }
    
    /**
     * Check login.
     *
     * @return boolean
     */
    public static function loginCheck()
    {
        if (self::get('login') == true && self::get('token') == md5(get_ip())) {
            return true;
        }
        return false;
    }

    /**
     * Logout.
     *
     * @return void
     */
    public static function logout()
    {
        session_destroy();
    }
}
