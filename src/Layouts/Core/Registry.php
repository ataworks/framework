<?php

namespace Ataworks\Layouts\Core;

interface Registry
{
    /**
     * Return request object.
     *
     * @param  string $class
     * @return mixed
     */
    public static function get(String $class);

    /**
     * Set object.
     *
     * @param  string $name
     * @param  object $object
     * @return mixed
     */
    public static function set(String $name, $object);
}
