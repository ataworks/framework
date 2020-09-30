<?php

if (!function_exists('get_ip'))
{
    /**
     * Return IP address.
     *
     * @return string
     */
    function get_ip()
    {
        if (getenv("HTTP_CLIENT_IP")) {
            return $ip = getenv("HTTP_CLIENT_IP");
        } else if(getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ",")) {
                $tmp = explode(",", $ip);
                $ip = trim($tmp[0]);
            }
            return $ip;
        }
        return $_SERVER['REMOTE_ADDR'];
    }
}

if (!function_exists('get_user_agent'))
{
    /**
     * Find user agent.
     *
     * @return string
     */
    function get_user_agent()
    {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($browser, 'Chrome')) return 'Chrome';
        if (strpos($browser, 'Firefox')) return 'Firefox';
        if (strpos($browser, 'Android')) return 'Android';
        if (strpos($browser, 'iPhone')) return 'iPhone';
        if (strpos($browser, 'Windows Phone')) return 'Windows Phone';
        if (strpos($browser, 'rv:11.0')) return 'Internet Explorer 11';
        if (strpos($browser, 'Safari')) return 'Safari';
        if (strpos($browser, 'MSIE')) return 'Internet Explorer';
        return $browser;
    }
}

if (!function_exists('user_name'))
{
    /**
     * Format username.
     *
     * @param  string $str
     * @return string
     */
    function user_name(String $str)
    {
        $find    = ['Ç', 'Ş', 'Ğ', 'Ü','U', 'İ','I', 'Ö','O', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı'];
        $replace = ['c', 's', 'g', 'u','u', 'i','i', 'o', 'o', 'c', 's', 'g', 'u', 'o', 'i'];
        $str = mb_strtolower(str_replace($find, $replace, $str));
        $str = preg_replace("@[^a-z0-9]@i", ' ', $str);
        return str_replace(' ', '', $str);
    }
}

if (!function_exists('is_robot'))
{
    /**
     * Is robot.
     *
     * @return boolean
     */
    function is_robot()
    {
        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
        return false;
    }
}
