<?php

namespace Ataworks\Exceptions;

use Ataworks\Layouts\Core\Logger as ILogger;

class Handler
{
    /**
     * Keep objects.
     *
     * @var array $instance
     */
    public static $instance;

    /**
     * Main method.
     *
     * @param ILogger $class
     */
    public function __construct(ILogger $class)
    {
        self::$instance = $class;
    }

    /**
     * Report error message.
     * 
     * @param  int    $code
     * @param  string $msg
     * @param  string $file
     * @param  int    $line
     * @return void
     */
    public static function report(Int $code, String $msg, String $file, Int $line)
    {
        /* Add new error log */
        self::$instance->addErrorLog($code, $msg, $file, $line);

        /* Print error */
        self::printError($code, $msg, $file, $line);
    }

    /**
     * Print error
     *
     * @param  string $code
     * @param  string $msg
     * @param  string $file
     * @param  int    $line
     * @return void|false
     */
    public static function printError($code, String $msg, String $file, Int $line)
    {
        /* Get config */
        $Config = CONFIG;

        /* Check error mode */
        if ($Config['general']['error_mode'] == 0) return false;

        /* Convert error code */
        $code = self::$instance::$levels[$code];

        /* Error style */
?>
    <style>
        .error-bubble {
            margin-top: 2rem;
            text-align: center;
        }
        .error-bubble span {
            background: #c9302c;
            color: #eee;
            font-size: 13px;
            padding: 1rem 1.5rem;
            border-radius: 3px;
            box-shadow: 1px 1px 2px #111;
        }
    </style>
<?php

        /* Error message */
        echo ("<div class='error-bubble'><span>"
        . "<b>" . $code . ":</b> " . $msg . ' File: ' . $file . ' on line ' . $line . "</span></div>");
    }
}
