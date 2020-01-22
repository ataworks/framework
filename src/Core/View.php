<?php

namespace Ataworks\Core;

use Ataworks\Layouts\Core\View as IView;
use Ataworks\Helpers\CDN;

/**
 * Ataworks view class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class View implements IView
{
    /**
     * Render view file.
     *
     * @param  string $path
     * @param  array  $data
     * @return void
     */
    public static function render(String $path, $data = [])
    {
        /* Get twig */
        $twig = Registry::get('Twig');

        /* Check theme path for import theme functions */
        if (is_admin_folder()) {
            $viewDir = ADMIN_VIEW;
        } else {
            $viewDir = THEME_DIR;
        }

        /* Check theme functions.php and import */
        if (file_exists($viewDir.'functions.php')) {
            require $viewDir.'functions.php';
        }

        /* Default data */
        $data['CDNStyles']  = CDN::styles();
        $data['CDNScripts'] = CDN::scripts();
        $data['CDNFontAwesomeList'] = CDN::fontAwesomeList();

        /* Render */
        echo $twig->render("template/$path.twig", $data);
    }
}
