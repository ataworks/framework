<?php

namespace Ataworks\Helpers;

use Ataworks\Layouts\Helpers\Pagination as IPagination;

/**
 * Ataworks pagination class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Pagination implements IPagination
{
    /**
     * Keep limit for page.
     *
     * @var int $limit
     */
    public static $limit = 10;

    /**
     * Keep presentation limit
     * 
     * @var int presentation
     */
    public static $presentation = 9;

    /**
     * Return total element.
     *
     * @param  int $element
     * @return int
     */
    public static function getTotal(Int $element) : Int
    {
        return ceil($element / self::$limit);
    }

    /**
     * Return limit.
     *
     * @param  int    $element
     * @return string
     */
    public static function getLimit(Int $element) : String
    {
        $limit = self::$limit;
        $page  = self::getPage();

        /* Check page number */
        $allPage = self::getTotal($element);
        if ($page > $allPage) $page = $allPage;
        if ($page <= 0) $page = 1;
        return ($page - 1) * $limit.",".$limit;
    }


    /**
     * Get request page number.
     *
     * @return int
     */
    public static function getPage() : Int
    {
        /* Check page number */
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        /* Check integer for page number */
        if (!is_numeric($page)) $page = 1;
        return $page;
    }

    /**
     * Create content and return content.
     *
     * @param  int    $totalElement
     * @param  int    $active
     * @param  string $url
     * @return mixed
     */
    public static function getContent(Int $totalElement, Int $active, String $url)
    {
        /* Check page number */
        if (ceil($totalElement / self::$limit) > 1) {
            /* Start create content */
            $content = "
            <li>
              <a href=\"$url\" title=\"".__('first_page')."\">
                <i class=\"fas fa-step-backward\"></i>
              </a>
            </li>";

            /**
             * Start loop.
             *
             * Loops up to the number of pages.
             * And append to content. 
             */
            foreach (self::getPageNumbers($totalElement, $active) as $row)
            {
                /* Check page active */
                if ($row == $active) {
                    $class = "active";
                } else {
                    $class = "";
                }

                /* Add to content */
                $content .= "
                <li>
                  <a class=\"$class\" href=\"$url&page=$row\" title=\"".__('page')." $row\">
                    <span>$row</span>
                  </a>
                </li>";
                $class = "";
            }

            /* Add last page to content */
            $content .= "
            <li>
              <a href=\"$url&page=".ceil($totalElement / self::$limit)."\" title=\"".__('last_page')."\">
                <i class=\"fas fa-step-forward\"></i>
              </a>
            </li>";

            /* Return ready content */
            return $content;
        }

        return false;
    }

    /**
     * Set limit
     *
     * @param  int  $limit
     * @return void
     */
    public static function setLimit(Int $limit)
    {
        if (is_numeric($limit)) self::$limit = $limit;
    }

    /**
     *  Get page numbers
     *
     * @param int $pages
     * @param int $current
     * @return array
     */
    public static function getPageNumbers(Int $pages, Int $current) : array
    {
        /* Array for data */
        $data = [];

        /* Set presentation link */
        $adj = self::$presentation;
        
        if (isset($pages, self::$limit) === true)
        {
            $data = range(1, ceil($pages / self::$limit));

            if (isset($current, $adj) === true) {
                if (($adj = floor($adj / 2) * 2 + 1) >= 1)
                {
                    $data = array_slice($data, max(0, min(count($data) - $adj, intval($current) - ceil($adj / 2))), $adj);
                }
            }
        }

        return $data;
    }
}
