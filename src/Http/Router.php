<?php

namespace Ataworks\Http;

use Ataworks\Core\Registry;
use Ataworks\Layouts\Http\Router as IRouter;

/**
 * Ataworks router class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
final class Router implements IRouter
{
    /**
     * Keep route.
     *
     * @var array
     */
    private $route = [
        //
    ];

    /**
     * Keep controller path.
     *
     * @var string $type
     */
    private $type = CONTROLLERS;

    /**
     * Start router.
     *
     * @param  boolean $type
     * @return void
     */
    public function __construct(Bool $type = false)
    {
        /* Router type */
        if (isset($type)) {

            switch ($type)
            {
                case true:
                    $this->type = ADMIN_CONTROLLERS;
                    break;

                default:
                    $this->type = CONTROLLERS;
                    break;
            }

        }

        /* Check route */
        if (!Request::get('do')) {
            /* Go default controller */
            $this->route = $this->index();

        } else {

            $route  = clean(array_filter(explode("/", trim( Request::get('do') ))));
            $file   = $this->type.mb_strtolower($route[0]).".php";
            $static = $this->type.'static/'.mb_strtolower($route[0]).".php";

            /* Check controller file */
            if (file_exists($file) || file_exists($static)) {
                $this->route["cont"] = $route[0];

                /* Check method */
                if (isset($route[1])) {
                    $this->route["method"] = $route[1];
                    if (isset($route[2])) $this->route["params"] = $route[2];
                } else {
                    /* Go to default method */
                    $this->route["method"] = "index";
                }

            } else {
                /* Error method */
                $this->error();
            }

        }

        $this->run($this->route);
    }

    /**
     * Run router.
     *
     * @param  array $params
     * @return void
     */
    private function run(Array $params = [])
    {
        if (isset($params)) {
            $file   = mb_strtolower($params['cont']).".php";
            $static = 'static/'.mb_strtolower($params['cont']).".php";

            if (file_exists($this->type.$file)) require_once($this->type.$file);
            if (file_exists($this->type.$static)) require_once($this->type.$static);

            $controller = $params['cont'];

            /* Set controller type */
            if ($this->type == CONTROLLERS) {
                $controller = "\Frontend\\Controllers\\$controller";
            } else {
                $controller = "\Backend\\Controllers\\$controller";
            }

            /* Start controller */
            $this->route["cont"] = Registry::set($controller, new $controller());

            /* Check method */
            if (method_exists(Registry::get($controller), $params['method'])) {

                $method = (string) $params['method'];

                /* Check parameter */
                if (isset($params['params'])) {
                    /* Params to array */
                    $param = str_replace(' ', '', $params['params']);
                    $param = explode(",", $param);

                    /* Call function */
                    call_user_func_array([Registry::get($controller), $method], $param);

                } else {
                    Registry::get($controller)->$method();
                }

            } else {
                /* Error method */
                $this->error();
            }
        }
    }

    /**
     * Error controller and method.
     *
     * @return void
     */
    private function error()
    {
        exit(redirect_err());
    }

    /**
     * Default controller and methods.
     *
     * @return array
     */
    private function index() : Array
    {
        $this->route["cont"]   = "Home";
        $this->route["method"] = "index";
        return $this->route;
    }
}
