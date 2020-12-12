<?php

namespace Ataworks\Cache;

use Ataworks\Helpers\Json;
use Ataworks\Layouts\Cache\Cache as ICache;

/**
 * Ataworks cache class
 *
 * Only cache for queries but deletes the template cache and all cache.
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Cache implements ICache
{
    /**
     * Keep query cache time.
     *
     * Note: Template cache time is not.
     *
     * @var int $delay
     */
    public static $delay = 20;

    /**
     * Keep query cache folder path.
     *
     * @var string $queryDir
     */
    public static $queryDir = APP_DIR.'Storage/Cache/query/';

    /**
     * Keep template cache folder path.
     *
     * @var string $templateDir
     */
    public static $templateDir = APP_DIR.'Storage/Cache/template/';

    /**
     * Check whether the query is being cached.
     *
     * @param  string   $sql
     * @param  int|null $cacheTime
     * @return boolean
     */
    public static function queryCheck(String $sql, Int $cacheTime = null) : Bool
    {
        if (isset($cacheTime)) self::$delay = $cacheTime;

        $file = self::$queryDir.md5($sql).'.cache';
        $time = date("Ymdhis");

        /**
         * Check cache file and last modification time.
         * Return false if last modified date is not true if $delay is small.
         */
        if (file_exists($file)) {
            $last_mod = date("Ymdhis", filemtime($file));
            if (($time-$last_mod) <= self::$delay) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Add query cache.
     *
     * @param  string $sql
     * @param  array  $data
     * @return void
     */
    public static function setQuery(String $sql, Array $data = [])
    {
        $file = self::$queryDir.md5($sql).'.cache';

        /* Check cache file */
        if (file_exists($file)) {

            $fp = fopen($file, "w");
            fwrite($fp, Json::encode($data));
            fclose($fp);

        } else {

            touch($file);
            $fp = fopen($file, "w");
            fwrite($fp, Json::encode($data));
            fclose($fp);

        }
    }

    /**
     * Return the requested cache.
     *
     * @param  string $sql
     * @return array
     */
    public static function getQuery(String $sql) : array
    {
        $file = self::$queryDir.md5($sql).'.cache';

        /* File actions */
        $open  = fopen($file, "r");
        $cache = fread($open, filesize($file));
        fclose($open);

        /* Content to json format convert and return */
        return Json::decodeArray($cache);
    }

    /**
     * Clear all cache.
     *
     * @return void
     */
    public static function clear()
    {
        self::clearQuery();

        /* Clear template cache */
        $dir = self::$templateDir;
        if ($handle = opendir($dir)) {
            while ($file = readdir($handle)) {
                if (is_dir($dir.$file) && $file != "." && $file != "..") {
                    remove_dir($dir.$file);
                }
                if (is_file($dir.$file) && $file != ".gitignore") {
                    unlink($dir.$file);
                }
            }
        }
        closedir($handle);
    }

    /**
     * Clear query cache.
     *
     * @return void
     */
    public static function clearQuery()
    {
        if ($handle = opendir(self::$queryDir)) {
            while ($file = readdir($handle)) {
                if (is_file(self::$queryDir.$file) && $file != '.gitignore') unlink(self::$queryDir.$file);
            }
            closedir($handle);
        }
    }
}
