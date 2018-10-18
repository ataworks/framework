<?php

namespace Ataworks\Layouts\Helpers;

interface CDN
{
    /**
     * Return script url
     *
     * @param  string $name
     * @return string
     */
    public static function script(String $name) : String;

    /**
     * Return style url
     *
     * @param  string $name
     * @return string
     */
    public static function style(String $name) : String;

    /**
     * Return all style
     *
     * @return array
     */
    public static function styles() : Array;

    /**
     * Return all script
     *
     * @return array
     */
    public static function scripts() : Array;
}
