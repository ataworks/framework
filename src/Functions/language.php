<?php

if (!function_exists('__'))
{
    /**
     * Return language word.
     *
     * @param  string $code
     * @return string
     */
    function __($code)
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
    function lang_name($name)
    {
        switch ($name) {
            case 'tr':
                return 'Türkçe';
                break;
            case 'en':
                return 'English';
                break;
            case 'de':
                return 'Deutsch';
                break;
            default:
                return __($name);
                break;
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
    function load_lang_files($dir)
    {
        if (file_exists($dir)) {
            if ($handle = opendir($dir)) {
                while ($file = readdir($handle)) {
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
