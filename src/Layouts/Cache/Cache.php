<?php

namespace Ataworks\Layouts\Cache;

interface Cache
{
    /**
     * Check whether the query is being cached.
     * 
     * @param  string  $sql
     * @param  int     $cacheTime
     * @return boolean
     */
    public static function queryCheck(String $sql, Int $cacheTime = null) : Bool;

    /**
     * Add query cache.
     *
     * @param  string $sql
     * @param  array  $data
     * @return void
     */
    public static function setQuery(String $sql, Array $data = []);

    /**
     * Return the requested cache.
     *
     * @param  string $sql
     * @return array
     */
    public static function getQuery(String $sql) : Array;

    /**
     * Clear all cache.
     *
     * @return void
     */
    public static function clear();

    /**
     * Clear query cache.
     *
     * @return void
     */
    public static function clearQuery();
}
