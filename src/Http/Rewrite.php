<?php

namespace Ataworks\Http;

use Ataworks\Layouts\Http\Rewrite as IRewrite;

/**
 * Ataworks rewrite class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Rewrite implements IRewrite
{
    /**
     * Keep rewrite rules.
     *
     * @var array $rules
     */
    public static $rules = [
        //
    ];

    /**
     * Check rewrite.
     *
     * @return void
     */
    public function __construct()
    {
        /* Get rules */
        $rules = $this->get();

        /* Format url */
        $uri = ltrim(get_url(), '/');

        /* Check for loop */
        foreach ($rules as $rule)
        {
            if (preg_match_all($rule[0], $uri, $result)) {
                /* Check rewrite level */
                if (strstr($result[0][0], '/')) {

                    $str  = explode("/", $result[0][0]);
                    $param= explode(".", $str[1]);

                    /* Set do parameter */
                    $_GET['do'] = str_replace('$', $param[0], $rule[1]);

                } else {
                    $_GET['do'] = $rule[1];
                }
                break;
            }
        }
    }

    /**
     * Add rewrite rule.
     *
     * @param  string $regex
     * @param  string $value
     * @return void
     */
    public static function set(String $regex, String $value)
    {
        self::$rules[] = [$regex, $value];
    }

    /**
     * Return rules array.
     *
     * @return array
     */
    public function get() : Array
    {
        return self::$rules;
    }
}
