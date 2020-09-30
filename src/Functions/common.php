<?php

if (!function_exists('get_url'))
{
    /**
     * Url decode to array.
     *
     * @return string
     */
    function get_url()
    {
        return urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
    }
}

if (!function_exists('clean_xss'))
{
    /**
     * Clean xss.
     *
     * @param  string $string
     * @return string
     */
    function clean_xss(String $string)
    {
        $xss = [
            '@<script&#91;^>]*?>.*?</script>@si',
            '@<&#91;\/\!&#93;*?&#91;^<>]*?>@si',
            '@<style&#91;^>]*?>.*?</style>@siU',
            '@<!&#91;\s\S&#93;*?--&#91; \t\n\r&#93;*>@'
        ];
        $base   = ['../', './', '..\\', '.\\', '..'];
        $string = str_replace($base, '', $string);
        return strip_tags(trim( preg_replace($xss, '', $string) ));
    }
}

if (!function_exists('clean'))
{
    /**
     * Clean array or parameter.
     *
     * @param  mixed $data
     * @return mixed
     */
    function clean($data)
    {
        if (is_array($data)) {
            return array_map(function($item) {
                return clean_xss($item);
            }, $data);
        }
        return clean_xss($data);
    }
}

if (!function_exists('clean_out'))
{
    /**
     * Clean output.
     *
     * @param  mixed  $str
     * @return string
     */
    function clean_out($str){
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('redirect'))
{
    /**
     * Redirect.
     *
     * @param  string $url
     * @param  int    $time
     * @return void
     */
    function redirect(String $url, $time = 0)
    {
        if (!strstr($url, URI)) exit;
        if (!headers_sent()) {
            if (is_integer($time) && $time <> 0) {
                header('Refresh: '.$time.';url='.$url);
            } else {
                header('Location: '.$url);
            }
        } else {
            echo '<meta http-equiv="refresh" content="'.$time.';url='.$url.'" />';
        }
    }
}

if (!function_exists('random_str'))
{
    /**
     * Create random.
     *
     * @return string
     */
    function random_str()
    {
        return str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }
}

if (!function_exists('slug'))
{
    /**
     * Generate slug
     *
     * @param  mixed $slug
     * @return mixed
     */
    function slug($slug)
    {
        $find    = array('Ç', 'Ş', 'Ğ', 'Ü','U', 'İ','I', 'Ö','O', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı');
        $replace = array('c', 's', 'g', 'u','u', 'i','i', 'o', 'o', 'c', 's', 'g', 'u', 'o', 'i');
        $slug    = str_replace($find, $replace, $slug);
        setlocale(LC_ALL, 'en_US.utf8');
        $slug    = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));
        $slug    = htmlentities($slug, ENT_QUOTES, 'UTF-8');
        $pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $slug    = preg_replace($pattern, '$1', $slug);
        $slug    = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');
        $pattern = '~[^0-9a-z]+~i';
        $slug    = preg_replace($pattern, '-', $slug);
        return strtolower(trim($slug, '-'));
    }
}

if (!function_exists('pass'))
{
    /**
     * Create password encrypt.
     *
     * @param  mixed $str
     * @return string md5
     */
    function pass($str)
    {
        return md5(sha1(sha1(md5($str.'||{@pHi_[YFW-~CryP0]}||'))));
    }
}

if (!function_exists('get_route'))
{
    /**
     * Return route.
     *
     * @return mixed
     */
    function get_route()
    {
        if (isset($_GET["do"])) {
            return array_filter(explode("/", clean($_GET["do"])));
        }
        return false;
    }
}

if (!function_exists('file_check'))
{
    /**
     * Check file type.
     *
     * @param  string  $string
     * @return boolean
     */
    function file_check(String $string)
    {
        if ($string == ".") return false;
        if ($string == "..") return false;
        if ($string == "../") return false;
        if ($string == "./") return false;
        if ($string == ".\\") return false;
        if ($string == "..\\") return false;
        if ($string == ".gitkeep") return false;
        if ($string == ".gitignore") return false;
        return true;
    }
}

if (!function_exists('set_cache_name'))
{
    /**
     * Set cache file name.
     *
     * @param  string $name
     * @param  mixed  $param
     * @return string
     */
    function set_cache_name(String $name, $param)
    {
        if (is_array($param)) {
            $latest = implode(',', $param);
        } else {
            $latest = $param;
        }
        return $name.$latest;
    }
}

if (!function_exists('is_admin_folder'))
{
    /**
     * Check admin folder url.
     *
     * @return boolean
     */
    function is_admin_folder()
    {
        global $adminFolder;
        if (strstr($_SERVER['REQUEST_URI'], $adminFolder)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('error_handler'))
{
    /**
     * Error handler.
     *
     * @param  int    $code
     * @param  string $msg
     * @param  string $file
     * @param  int    $line
     * @return void
     */
    function error_handler(Int $code, String $msg, String $file, Int $line)
    {
        Ataworks\Exceptions\Handler::report($code, $msg, $file, $line);
    }
}

if (!function_exists('exception_handler'))
{
    /**
     * Exception handler.
     *
     * @param  array $e
     * @return void
     */
    function exception_handler(Array $e)
    {
        Ataworks\Exceptions\Handler::report($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
    }
}

if (!function_exists('shutdown_handler'))
{
    /**
     * Shutdown handler.
     *
     * @return void
     */
    function shutdown_handler()
    {
        $e = error_get_last();
        if (isset($e) && ($e['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING)))
        {
            Ataworks\Exceptions\Handler::report($e['type'], $e['message'], $e['file'], $e['line']);
        }
    }
}

if (!function_exists('pagination'))
{
    /**
     * Return pagination content.
     *
     * @param  int    $pages
     * @param  int    $active
     * @param  string $url
     * @return string
     */
    function pagination(Int $pages, Int $active, String $url)
    {
        return Ataworks\Helpers\Pagination::getContent($pages, $active, $url);
    }
}

if (!function_exists('add_file_with_ver'))
{
    /**
     * Add file with version
     *
     * @param  string $file
     * @return string
     */
    function add_file_with_ver(String $file)
    {
        if (is_admin_folder()) {
            $ver = filemtime(ADMIN_VIEW.$file);
            return ADMIN_THEME.$file."?v=".$ver;
        }
        $ver = filemtime(THEME_DIR.$file);
        return THEME.$file."?v=".$ver;
    }
}

if(!function_exists('create_dp_url'))
{
    /**
     * Create url for admin home page.
     *
     * @param  string|null $url
     * @return string
     */
    function create_dp_url($url = null)
    {
        if (isset($url)) {
            return ADMIN_URI.$url;
        }
        return ADMIN_URI;
    }
}

if (!function_exists('add_slash'))
{
    /**
     * Add slash
     *
     * @param  string $word
     * @return string
     */
    function add_slash(String $word)
    {
        return rtrim($word, '/') . '/';
    }
}

if (!function_exists('remove_dir'))
{
    /**
     * Remove dir
     *
     * @param  string  $dir
     */
    function remove_dir(String $dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object)
            {
                if ($object != "." && $object != "..")
                {
                    if (is_dir($dir. "/" . $object)) {
                        remove_dir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}

if (!function_exists('copy_dir'))
{
    /**
     * Copy directory
     *
     * @param string $src
     * @param string $dst
     */
    function copy_dir(String $src, String $dst)
    {
        if (is_dir($src)) {
            if (!is_dir($dst)) mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
            {
                if ($file != "." && $file != "..")
                {
                    copy_dir("$src/$file", "$dst/$file");
                }
            }
        } else if (file_exists($src)) {
            copy($src, $dst);
        }
    }
}

if (!function_exists('is_email'))
{
    /**
     * Check email
     *
     * @param  string  $str
     * @return boolean
     */
    function is_email(String $str)
    {
        if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return  false;
    }
}

if (!function_exists('prev_url'))
{
    /**
     * Previous url
     *
     * @return string
     */
    function prev_url()
    {
        return htmlspecialchars($_SERVER['HTTP_REFERER']);
    }
}

if (!function_exists('is_ssl'))
{
    /**
     * Check ssl certified
     *
     * @return boolean
     */
    function is_ssl()
    {
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            return false;
        }
        return true;
    }
}

if (!function_exists('is_phone'))
{
    /**
     * Check phone number for turkey.
     * Note: at the beginning without zero.
     *
     * @example is_phone('501 000 00 00') or is_phone('501000000')
     * @example is_phone('0501 000 00 00')
     * @param  int|string $number
     * @return boolean
     */
    function is_phone($number)
    {
        /* Dec out */
        $number = decoct($number);

        /* Parse blanks */
        $number = str_replace(' ', '', $number);

        /* Check numeric */
        if (!is_numeric($number)) return false;

        /* Check length */
        if (strlen($number) != 10) return false;

        /* Check valid number */
        if ($number <= 5010000000 || $number >= 5559999999) return false;

        return true;
    }
}

if (!function_exists('get_theme_config'))
{
    /**
     * Return theme config
     *
     * @param  string $key
     * @return string
     */
    function get_theme_config(String $key)
    {
        if (file_exists(THEME_DIR.'customize.json')) {
            /* Get file content */
            $config = file_get_contents(THEME_DIR.'customize.json');

            /* Json decode */
            $config = \Ataworks\Helpers\Json::decodeArray($config);

            /* Check key */
            if (isset($config[$key])) {
                return $config[$key];
            }
        }
        return '';
    }
}

if (!function_exists('reading_time'))
{
    /**
     * Reading time function.
     *
     * @param  string $content
     * @return string
     */
    function reading_time($content = "")
    {
        /* Set time variables */
        $fiftySeconds = 50;
        $oneMinute = 60;
        $totalSecondsInOneHour = 3600;

        /* It then calculates how many words are in the content, based on gaps. */
        $wordCount = round(count(explode(" ", strip_tags($content))));

        /* Calculates the reading speed by dividing the word count by the incoming speed value (default is 2). */
        $readingTime = ceil($wordCount / 2);

        /* If the reading time is below 1 min, the output is given in seconds. */
        if ($readingTime < $fiftySeconds) {
            $second = intval($readingTime / 10);
            $second++;
            $second *= 10;
            return "$second " . __('second');
        }

        /* If the reading time is above 1 min, output is given in minutes. */
        if ($readingTime < $totalSecondsInOneHour) {
            $minute = ceil($readingTime / $oneMinute);
            return "$minute " . __('minute');
        }

        /* If the reading time is over 1 hour, the output is given in hours. */
        $hour = floor($readingTime / $totalSecondsInOneHour);
        return "$hour " . __('hour');
    }
}
