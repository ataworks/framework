<?php

namespace Ataworks\Http;

use Ataworks\Core\Registry;
use Ataworks\Layouts\Http\Controller as IController;

/**
 * Ataworks controller class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
abstract class Controller implements IController
{
    /**
     * Load model file
     *
     * @param  string $model
     * @return void
     */
    public function loadModel(String $model)
    {
        /* Check model type */
        if (is_admin_folder()) {
            /* Set class name */
            $class = "\\Backend\\Models\\$model";

            /* Import model file */
            require ADMIN_MODELS."$model.php";
        } else {
            /* Set class name */
            $class = "\\Frontend\\Models\\$model";

            /* Import model file */
            require MODELS."$model.php";
        }

        /* Return model file */
        return Registry::set($class, new $class);
    }

    /* Controllers for default method */
    abstract public function index();
}
