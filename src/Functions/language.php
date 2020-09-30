<?php

if (!function_exists('__'))
{
    /**
     * Return language word.
     *
     * @param  string $code
     * @return string
     */
    function __(String $code)
    {
        global $_;
        if (isset($_[$code])) {
            return $_[$code];
        }
        return $code;
    }
}

if (!function_exists('lang_name'))
{
    /**
     * Return language name.
     *
     * @param  string $name
     * @return string
     */
    function lang_name(String $name)
    {
        switch ($name)
        {
            case 'tr':
                return 'Türkçe';
            case 'en':
                return 'English';
            case 'de':
                return 'German';
            default:
                return __($name);
        }
    }
}

if (!function_exists('load_lang_files'))
{
    /**
     * Load language file.
     *
     * @param  string $dir
     * @return void
     */
    function load_lang_files(String $dir)
    {
        if (file_exists($dir)) {
            if ($handle = opendir($dir)) {
                while ($file = readdir($handle))
                {
                    if (is_dir($dir.$file) && file_check($file)) {
                        load_lang_files($dir.$file."/");
                    }
                    if (is_file($dir.$file) && file_check($file)) require $dir.$file;
                }
                closedir($handle);
            }
        }
    }
}

if (!function_exists('get_lang_id_in_cookie'))
{
    /**
     * Return language id in cookie
     *
     * @return int
     */
    function get_lang_id_in_cookie()
    {
        if (isset($_COOKIE['language_id'])) {
            return $_COOKIE['language_id'];
        }

        return CONFIG['general']['site_lang'];
    }
}
