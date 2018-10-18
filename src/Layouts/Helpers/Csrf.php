<?php

namespace Ataworks\Layouts\Helpers;

interface Csrf
{
    /**
     * Get csrf token and a new one if expired
     *
     * @return string
     */
    public static function makeToken() : String;

    /**
     * Check csrf token
     *
     * @return boolean
     */
    public static function isTokenValid() : Bool;
}
