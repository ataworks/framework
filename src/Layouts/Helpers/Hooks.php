<?php

namespace Ataworks\Layouts\Helpers;

interface Hooks
{
    /**
     * Load plugins
     *
     * @param  string|null $dir
     * @return void
     */
    public static function loadPlugins(String $dir = null);

    /**
     * Activate plugin
     *
     * @param  string $plugin
     * @return void
     */
    public static function activatePlugin(String $plugin);

    /**
     * Deactivate plugin
     *
     * @param  string $plugin
     * @return void
     */
    public static function deactivatePlugin(String $plugin);

    /**
     * Update plugin status
     *
     * @param  string $plugin
     * @param  string $status
     * @return void
     */
    public static function updatePluginStatus(String $plugin, String $status);

    /**
     * Add hook
     *
     * @param  string $hook
     * @param  string $function
     * @param  array  $args
     * @return void
     */
    public static function addHook(String $hook, String $function, Array $args = []);

    /**
     * Remove hook
     *
     * @param  string $hook
     * @return void
     */
    public static function removeHook(String $hook);

    /**
     * Run hook
     *
     * @param  string $hook
     * @return void
     */
    public static function run(String $hook);

    /**
     * Default hooks
     *
     * @return void
     */
    public static function defaultHooks();
}
