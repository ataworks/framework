<?php

namespace Ataworks\Layouts\Helpers;

interface Pagination
{
    /**
     * Return total element.
     *
     * @param  int $element
     * @return int
     */
    public static function getTotal(Int $element) : Int;

    /**
     * Return limit.
     *
     * @param  int $element
     * @return string
     */
    public static function getLimit(Int $element) : String;

    /**
     * Get request page number.
     *
     * @return int
     */
    public static function getPage() : Int;

    /**
     * Create content and return content.
     *
     * @param  int    $pages
     * @param  int    $active
     * @param  string $url
     * @return mixed
     */
    public static function getContent(Int $pages, Int $active, String $url);

    /**
     * Set limit
     *
     * @param  int $limit
     * @return void
     */
    public static function setLimit(Int $limit);

    /**
     *  Get page numbers
     *
     * @param int $pages
     * @param int $current
     * @return array
     */
    public static function getPageNumbers(Int $pages, Int $current);
}
