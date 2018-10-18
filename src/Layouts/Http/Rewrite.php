<?php

namespace Ataworks\Layouts\Http;

interface Rewrite
{
    /**
     * Add rewrite rule.
     *
     * @param  string $regex
     * @param  string $value
     * @return void
     */
    public static function set(String $regex, String $value);

    /**
     * Return rules array.
     *
     * @return array
     */
    public function get() : Array;
}
