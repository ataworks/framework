<?php

namespace Ataworks\Layouts\Http;

interface Controller
{
    /**
     * Load model file
     *
     * @param  string $model
     * @return void
     */
    public function loadModel(String $model);
}
