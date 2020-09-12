<?php

namespace Ataworks\Core;

use Ataworks\Layouts\Core\Logger as ILogger;

/**
 * Ataworks logger class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Logger implements ILogger
{
    /**
     * Keep logs dir.
     *
     * @var string $path
     */
    public static $path = APP_DIR.'Storage/Logs/';

    /**
     * Keep log date time format.
     *
     * @var string $timeFormat
     */
    public static $timeFormat = "[Y-m-d H:i:s]";

    /**
     * List of available error levels.
     *
     * @var array $levels
     */
    public static $levels = [
        E_ERROR           => 'Error',
        E_WARNING         => 'Warning',
        E_PARSE           => 'Parsing Error',
        E_NOTICE          => 'Notice',
        E_CORE_ERROR      => 'Core Error',
        E_CORE_WARNING    => 'Core Warning',
        E_COMPILE_ERROR   => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR      => 'User Error',
        E_USER_WARNING    => 'User Warning',
        E_USER_NOTICE     => 'User Notice',
        E_STRICT          => 'Runtime Notice',
        0                 => 'Fatal Error'
    ];

    /**
     * Add new error log.
     *
     * @param  mixed  $code
     * @param  string $msg
     * @param  string $filePath
     * @param  int    $line
     * @return void
     */
    public static function addErrorLog($code, String $msg, String $filePath, Int $line)
    {
        /* Get config */
        $Config = CONFIG;

        /* Keep error log file */
        $file = self::$path.'error.log';

        /* Get url */
        $url = get_url();

        /* Create log message */
        $logMessage = date(self::$timeFormat).' '.self::$levels[$code].": message => $msg file $filePath line => $line url => $url\r\n";

        /* Check error report status */
        if ($Config['general']['error_report'] == 'on') {
            if (file_exists($file)) {
                return self::filePuts($file, $logMessage);
            }
            return self::fileWrite($file, $logMessage);
        }
    }

    /**
     * Add new database log.
     *
     * @param  string $type
     * @param  string $table
     * @param  mixed  $where
     * @param  mixed  $values
     * @return void
     */
    public static function addDbLog(String $type, String $table, $where, $values)
    {
        /**
         * Keep database log file name.
         *
         * If a query has been made from the administration panel, the log is kept in the 'db.panel.log' file,
         * if not it keeps the log in 'db.log' file.
         */
        if (is_admin_folder()) {
            $file = self::$path.'db.panel.log';
        } else {
            $file = self::$path.'db.log';
        }

        /* Check values */
        if (is_array($values)) $values = implode(",", $values);

        /* Create log message */
        $logMessage = date(self::$timeFormat)." $type: table => $table where => $where values => $values "
        ."IP => ".get_ip()." url => ".get_url()." user => ".Session::get('uname')."\r\n";

        /* Check database log file */
        if (file_exists($file)) {
            return self::filePuts($file, $logMessage);
        }
        return self::fileWrite($file, $logMessage);
    }


    /**
     * Add new account log.
     *
     * @param  string $msg
     * @param  string $name
     * @return void
     */
    public static function addAccountLog(String $msg, String $name)
    {
        /* Get config */
        $Config = CONFIG;

        /* Keep error log file */
        $file = self::$path.'account.log';

        /* Get url */
        $url = get_url();

        /* Create log message */
        $logMessage = date(self::$timeFormat)." result_code => $msg UserName|Email => ".$name." IP => ".get_ip()." url => $url user => ".Session::get('uname')."\r\n";

        /* Check error report status */
        if ($Config['general']['error_report'] == 'on') {
            if (file_exists($file)) {
                return self::filePuts($file, $logMessage);
            }
            return self::fileWrite($file, $logMessage);
        }
    }

    /**
     * File puts contents.
     *
     * @param  string $file
     * @param  mixed  $data
     * @return void
     */
    public static function filePuts(String $file, $data)
    {
        /* Appending for file open */
        $f = fopen($file, "a");
        fputs($f, $data);
        fclose($f);
    }

    /**
     * File write.
     *
     * @param  string $file
     * @param  mixed  $data
     * @return void
     */
    public static function fileWrite(String $file, $data)
    {
        /* Create file */
        touch($file);

        /* Write for file open */
        $f = fopen($file, "w");
        fwrite($f, $data);
        fclose($f);
    }
}
