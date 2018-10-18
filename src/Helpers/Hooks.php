<?php

namespace Ataworks\Helpers;

use Ataworks\Layouts\Helpers\Hooks as IHooks;

/**
 * Ataworks hooks class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Hooks implements IHooks
{
    /**
     * Keep plugin dir
     *
     * @var const PLUGIN_DIR
     */
    const PLUGIN_DIR = PLUGINS_DIR;

    /**
     * Array of available hooks
     *
     * @var array $hooks
     */
    public static $hooks = [
        //
    ];

    /**
     * Array of plugins
     *
     * @var array $plugins
     */
    public static $plugins = [
        //
    ];

    /**
     * Load plugins
     *
     * @param  string $dir
     * @return void
     */
    public static function loadPlugins(String $dir = null)
    {
        /* Empty dir */
        if (empty($dir)) $dir = self::PLUGIN_DIR;

        /* Check plugins home dir */
        if ($dir == self::PLUGIN_DIR) {
            if ($handle = opendir($dir)) {
                while ($file = readdir($handle)) {
                    if (is_dir($dir.$file) && $file != '.' && $file != '..') {
                        /* Open and read plugin json file */
                        if (file_exists($dir.$file."/$file.json")) {
                            $read = file_get_contents($dir.$file."/$file.json");
                            $json = Json::decodeArray($read);

                            /* Check plugin active/deactive */
                            if ($json['status'] == 'active') {
                                self::$plugins[$file] = $json['name'];
                                self::loadPlugins($dir.$file.'/');
                            }
                        }
                    }
                }
                closedir($handle);
            }
        } else {
            if ($handle = opendir($dir)) {
                while ($file = readdir($handle)) {
                    if (is_dir($dir.$file) && $file != '.' && $file != '..') {
                        self::loadPlugins($dir.$file.'/');
                    }
                    if (is_file($dir.$file)) {
                        if (preg_match('@.php@', $file)) {
                            require_once $dir.$file;
                        }
                    }
                }
                closedir($handle);
            }
        }

        /* Default hooks */
        self::defaultHooks();
    }

    /**
     * Activate plugin
     *
     * @param  string $dir
     * @return void
     */
    public static function activatePlugin(String $plugin)
    {
        self::updatePluginStatus($plugin, 'active');
    }

    /**
     * Deactivate plugin
     *
     * @param  string $dir
     * @return void
     */
    public static function deactivatePlugin(String $plugin)
    {
        self::updatePluginStatus($plugin, 'deactive');
    }

    /**
     * Update plugin status
     *
     * @param  string $plugin
     * @param  string $status
     * @return void
     */
    public static function updatePluginStatus(String $plugin, String $status)
    {
        $file = self::PLUGIN_DIR.$plugin;

        /* Check plugin dir */
        if (is_dir($file)) {
            /* Set plugin json */
            $json = $file."/$plugin.json";

            /* Json open */
            $file = file_get_contents($json);
            
            /* Plugin json content get and edit */
            $data = Json::decodeArray($file);
            $data['status'] = $status;

            file_put_contents($json, Json::encode($data)); 
        }
    }

    /**
     * Add hook
     *
     * @param  string $hook
     * @param  string $function
     * @param  array  $args
     * @return void
     */
    public static function addHook(String $hook, String $function, Array $args = [])
    {
        self::$hooks[$hook][] = [$function, $args];
    }

    /**
     * Remove hook
     *
     * @param  string $hook
     * @return void
     */
    public static function removeHook(String $hook)
    {
        unset(self::$hooks[$hook]);
    }

    /**
     * Run hook
     *
     * @param  string $hook
     * @return void
     * @throws \Exception
     */
    public static function run(String $hook)
    {
        /* Check hook */
        if (!isset(self::$hooks[$hook])) return false;

        foreach (self::$hooks[$hook] as $hook) {
            if (preg_match("/@/i", $hook[0])) {
                /* Grab all parts based on a / separator */
                $parts = explode('/', $hook[0]);

                /* Collect the last index of the array */
                $last = end($parts);

                /* Grab the controller name and method call */
                $segments = explode('@', $last);

                /* Set class name */
                $classname = new $segments[0]();

                /* Execute function */
                $result = call_user_func_array([$classname, $segments[1]], $hook[1]);
            } else {
                /* Execute function */
                if (function_exists($hook[0])) {
                    $result = call_user_func_array($hook[0], $hook[1]);
                } else {
                    throw new \Exception('Hook location ('.$hook[0].') not defined!');
                }
            }
        }
        return $result;
    }

    /**
     * Default hooks
     *
     * @return void
     */
    public static function defaultHooks()
    {
        # code...
    }
}
