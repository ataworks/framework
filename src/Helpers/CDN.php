<?php

namespace Ataworks\Helpers;

use Ataworks\Layouts\Helpers\CDN as ICDN;

/**
 * Ataworks CDN class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class CDN implements ICDN
{
    /**
     * Keep styles.
     *
     * @var array $styles
     */
    public static $styles = [
        'fontawesome'  =>  PUBLIC_URI.'fontawesome/css/all.min.css',
        'bootstrap'    =>  PUBLIC_URI.'bootstrap/css/bootstrap.min.css',
        'morris'       => 'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css',
        'datepicker'   => 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
        'morris'       => 'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css',
        'lightbox'     =>  PUBLIC_URI.'css/lightbox.min.css',
        'prism'        =>  PUBLIC_URI.'css/prism.css'
    ];

    /**
     * Keep scripts.
     *
     * @var array static
     */
    public static $scripts = [
        'jquery'       =>  PUBLIC_URI.'js/jquery.min.js',
        'angular'      => 'https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js',
        'react'        => 'https://cdnjs.cloudflare.com/ajax/libs/react/15.5.4/react.min.js',
        'bootstrap'    =>  PUBLIC_URI.'bootstrap/js/bootstrap.min.js',
        'morris'       => 'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
        'sweetalert'   =>  PUBLIC_URI.'js/sweetalert.min.js',
        'html5shiv'    =>  PUBLIC_URI.'js/html5shiv.js',
        'lightbox'     =>  PUBLIC_URI.'js/lightbox.min.js',
        'popper'       =>  PUBLIC_URI.'js/popper.min.js',
        'prism'        =>  PUBLIC_URI.'js/prism.js'
    ];

    /**
     * Return script url
     *
     * @param  string $name
     * @return string
     */
    public static function script(String $name) : String
    {
        return self::$scripts[$name];
    }

    /**
     * Return style url
     *
     * @param  string $name
     * @return string
     */
    public static function style(String $name) : String
    {
        return self::$styles[$name];
    }

    /**
     * Return all style
     *
     * @return array
     */
    public static function styles() : Array
    {
        return self::$styles;
    }

    /**
     * Return all script
     *
     * @return array
     */
    public static function scripts() : Array
    {
        return self::$scripts;
    }
}
