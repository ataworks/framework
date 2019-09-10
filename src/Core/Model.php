<?php

namespace Ataworks\Core;

/**
 * Ataworks model class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
abstract class Model
{
    /**
     * Keep database object.
     *
     * @var object $db
     */
    protected $db;

    /**
     * Keep database prefix
     *
     * @var string $prefix
     */
    protected $prefix;

    /**
     * Set database object.
     *
     * @return void
     */
    public function __construct()
    {
        /* Set instance */
        $this->db = Registry::get('Ataworks\Core\Db');

        /* Set prefix */
        $this->prefix = DB_PREFIX;
    }
}
