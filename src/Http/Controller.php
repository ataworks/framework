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
     * @return mixed
     */
    public function loadModel(String $model)
    {
        /* Check model type */
        if (is_admin_folder()) {
            $class = "\\Backend\\Models\\$model";

            $file   = ADMIN_MODELS."$model.php";
            $static = ADMIN_MODELS."static/$model.php";

            if (file_exists($file)) require $file;
            if (file_exists($static)) require $static;

        } else {
            $class = "\\Frontend\\Models\\$model";

            $file   = MODELS."$model.php";
            $static = MODELS."static/$model.php";

            if (file_exists($file)) require $file;
            if (file_exists($static)) require $static;
        }

        return Registry::set($class, new $class);
    }

    /* Controllers for default method */
    abstract public function index();
}
