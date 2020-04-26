<?php

namespace Ataworks\Core;

/**
 * Ataworks core application
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Application
{
    /**
     * The framework version.
     *
     * @var string
     */
    const FW_VERSION = '1.0.0';

    /**
     * Main Method.
     *
     * @return object
     */
    public function __construct()
    {
        /* Framework version */
        define('FW_VERSION', $this->version());

        /* Start handler class */
        new \Ataworks\Exceptions\Handler(new Logger());

        /**
         * Exception Handler
         *
         * Define a custom error handler so we can log PHP errors.
         */
        set_error_handler('error_handler');
        set_exception_handler('exception_handler');
        register_shutdown_function('shutdown_handler');
    }

    /**
     * Run application
     *
     * @param  boolean $type
     * @return void
     */
    public function run(Bool $type = false)
    {
        /* Get config */
        $Config = CONFIG;

        /* Check cache */
        if ($Config['general']['cache'] == 1) {
            $twigConfig = ["cache" => APP_DIR.'Storage/Cache/template/', "auto_reload" => true];
        } else {
            $twigConfig = ["auto_reload" => false];
        }

        if (is_admin_folder()) {
            /* Load common language files for admin */
            load_lang_files(ADMIN_LANG_DIR.$Config['general']['admin_lang'].'/');

            /* Twig loader */
            $loader = new \Twig\Loader\FilesystemLoader(ADMIN_VIEW);
        } else {
            /* Check language */
            if (!isset($_COOKIE['language']) || strlen($_COOKIE['language']) > 2) {
                /* Default language block */
                defaultLanguage:

                $lang = Registry::get("Ataworks\Core\Db")
                    ->setLog(false)
                    ->cache(true, 3600)
                    ->selectSingle('languages', 'code', 'id = ?', $Config['general']['site_lang']);

                /* Default database class settings */
                Registry::get("Ataworks\Core\Db")->setLog(true);
                Registry::get("Ataworks\Core\Db")->cache(false);

                /* Set lang code */
                $lang = $lang['code'];
            } else {
                /* Check language data */
                $item = Registry::get("Ataworks\Core\Db")
                    ->setLog(false)
                    ->cache(true, 3600)
                    ->selectSingle('languages', 'code', 'code = ?', $_COOKIE['language']);

                /* Default database class settings */
                Registry::get("Ataworks\Core\Db")->setLog(true);
                Registry::get("Ataworks\Core\Db")->cache(false);

                if (!is_array($item)) {
                    goto defaultLanguage;
                } else {
                    $lang = $_COOKIE['language'];
                }
            }

            /* Load common language files */
            load_lang_files(LANG_DIR.$lang.'/');

            /* Twig loader */
            $loader = new \Twig\Loader\FilesystemLoader($Config['general']['site_theme'], VIEW);
        }

        /* Start twig */
        $twig   = Registry::set("Twig", new \Twig\Environment($loader, $twigConfig));

        /* Start system twig functions */
        $functions = new \Ataworks\Helpers\TwigFunctions();
        $functions = $functions->getFunctions();

        /* Add twig function */
        foreach ($functions as $function) {
            $twig->addFunction($function);
        }

        /* Start project twig functions */
        $functions = new \App\Functions\TwigFunctions();
        $functions = $functions->getFunctions();

        /* Add twig function */
        foreach ($functions as $function) {
            $twig->addFunction($function);
        }

        /* Unset variables */
        unset($loader, $twig, $functions, $lang);

        /**
         * Check maintenance mode.
         *
         * Import the maintenance.php file if maintenance mode is active.
         * Only applied to the front-end.
         * TAdministrators can always view the site.
         */
        if ($Config['general']['environment'] == 'maintenance' && Session::get('rank') != 'admin' && is_admin_folder() === false )
        {
            exit(View::render('maintenance'));
        }

        /* Start Default Rewrite */
        new \App\Http\Rewrite();

        /* Start Rewrite and set for registry class */
        Registry::set('Ataworks\Http\Rewrite', new \Ataworks\Http\Rewrite());

        /* Start Router Class */
        Registry::set('Ataworks\Http\Router', new \Ataworks\Http\Router($type));
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version() : String
    {
        return static::FW_VERSION;
    }
}
