<?php

namespace Ataworks\Layouts\Core;

interface View
{
    /**
     * Render view file.
     *
     * @param  string $path
     * @param  array  $data
     * @return void
     */
    public static function render(String $path, $data = []);
}
