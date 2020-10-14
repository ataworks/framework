<?php

namespace Ataworks\Helpers;

use Ataworks\Layouts\Helpers\TwigFunctions as ITwigFunctions;
use App\Helpers\Dashboard\Content;
use App\Helpers\Content\Head;
use Twig\TwigFunction;

class TwigFunctions
{
    /**
     * Keep twig functions
     *
     * @var array $functions
     */
    public static $functions = [
        //
    ];

    public function __construct()
    {
        /* File version function */
        self::$functions[] = new TwigFunction('add_file_with_ver', function ($file) {
            if (is_admin_folder()) {
                $version = filemtime(ADMIN_VIEW.$file);
                return ADMIN_THEME.$file."?v=".$version;
            }
            $version = filemtime(THEME_DIR.$file);
            return THEME.$file."?v=".$version;
        });

        /* Active user info function */
        self::$functions[] = new TwigFunction('active_user_info', function ($key) {
            return active_user_info($key);
        });

        /* Language function */
        self::$functions[] = new TwigFunction('lang', function ($word) {
            return __($word);
        });

        /* Get route function */
        self::$functions[] = new TwigFunction('get_route', function () {
            return get_route();
        });

        /* File size function */
        self::$functions[] = new TwigFunction('filesize', function ($file) {
            if (file_exists($file)) {
                return filesize($file);
            }
            return 0;
        });

        /* Pagination function */
        self::$functions[] = new TwigFunction('pagination', function ($pages, $active, $uri) {
            if (is_admin_folder()) {
                $uri = create_dp_url($uri);
            } else {
                $uri = URI.$uri;
            }
            return pagination($pages, $active, $uri);
        });

        /* Token function */
        self::$functions[] = new TwigFunction('token', function () {
            return get_token();
        });

        /* Config function */
        self::$functions[] = new TwigFunction('config', function ($key) {
            $Config = CONFIG;
            if (isset($Config[$key])) {
                return $Config[$key];
            }
            return 'undefined';
        });

        /* Entry restriction function */
        self::$functions[] = new TwigFunction('check_entry_rest', function () {
            return \App\Helpers\EntryRestriction::check();
        });

        /* Return language list */
        self::$functions[] = new TwigFunction('get_lang_list', function () {
            return Content::getLanguages();
        });

        /* Return current language code */
        self::$functions[] = new TwigFunction('get_current_lang', function () {
            return Content::getCurrentLang();
        });

        /* Get menu function */
        self::$functions[] = new TwigFunction('get_menu_items', function ($locationId, $parent = 0) {
            return \App\Helpers\MenuManager::getMenu($locationId, $parent);
        });

        /* Return user data */
        self::$functions[] = new TwigFunction('get_user', function ($id) {
            return get_user($id);
        });

        /* Get current url function */
        self::$functions[] = new TwigFunction('get_url', function () {
            return \Ataworks\Http\Request::requestFullUri();
        });

        /* Get favicon function */
        self::$functions[] = new TwigFunction('get_favicon', function () {
            Head::getFavicon();
        });

        /* Get javascript codes */
        self::$functions[] = new TwigFunction('head_js_codes', function () {
            Head::getHeadJsCodes();
        });

        /* Get title function */
        self::$functions[] = new TwigFunction('get_title', function ($title) {
            return Head::replaceTitle($title);
        });

        /* Get description function */
        self::$functions[] = new TwigFunction('get_desc', function ($desc) {
            return Head::replaceDesc($desc);
        });

        /* Get theme config */
        self::$functions[] = new TwigFunction('get_theme_config', function ($key) {
            return get_theme_config($key);
        });

        /* Reading time function */
        self::$functions[] = new TwigFunction('reading_time', function($text) {
            return reading_time($text);
        });

        /* Json encode function */
        self::$functions[] = new TwigFunction('json_encode', function($data) {
            return Json::encode($data);
        });

        /* Json decode function */
        self::$functions[] = new TwigFunction('json_decode', function($data) {
            return Json::decodeArray($data);
        });

        /* Slug function */
        self::$functions[] = new TwigFunction('slug', function($str) {
           return slug($str);
        });

        /* Session function */
        self::$functions[] = new TwigFunction('get_session', function($key) {
            return \Ataworks\Core\Session::get($key);
        });
    }

    /**
     * Return functions
     *
     * @return mixed
     */
    public function getFunctions()
    {
        return self::$functions;
    }
}
