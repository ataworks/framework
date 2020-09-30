<?php

namespace Ataworks\Layouts\Core;

interface Db
{
    /**
     * Database connect.
     *
     * @param  string $type
     * @param  string $server
     * @param  string $dbname
     * @param  string $user
     * @param  string $pass
     * @param  string $prefix
     * @return void
     */
    public function __construct(String $type, String $server, String $dbname, String $user,String $pass, String $prefix);

    /**
     * Add new data to database.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $values
     * @return mixed
     */
    public function add(String $table, String $cols, $values);

    /**
     * Update affected data.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $values
     * @param  string $where
     * @return mixed
     */
    public function update(String $table, String $cols, $values, $where);

    /**
     * Delete affected data.
     *
     * @param  string $table
     * @param  mixed  $where
     * @param  mixed  $values
     * @return mixed
     */
    public function delete(String $table, $where, $values);

    /**
     * Return affected rows.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $where
     * @param  mixed  $values
     * @param  mixed  $limit
     * @param  string $order_by
     * @return mixed
     */
    public function select(String $table, String $cols, $where = 1, $values = 1, $limit = 120, String $order_by = 'id DESC');

    /**
     * Return affected row.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $where
     * @param  mixed  $values
     * @param  string $order_by
     * @return mixed
     */
    public function selectSingle(String $table, String $cols, $where = 1, $values = 1, String $order_by = "id DESC");

    /**
     * Return affected rows
     *
     * @param  string $cols
     * @param  string $table
     * @param  string $joinTables
     * @param  mixed $where
     * @param  mixed  $values
     * @param  boolean $single
     * @param  mixed $limit
     * @param  string|null $order_by
     * @return mixed
     */
    public function innerJoin(String $cols, String $table, String $joinTables, $where = 1, $values = 1, $single = false, $limit = 120, String $order_by = null);

    /**
     * Return the count of affected rows.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $where
     * @return int
     */
    public function getCount(String $table, String $cols = "*", $where = null) : Int;

    /**
     * Return affected search results.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $where
     * @param  mixed  $values
     * @param  mixed  $limit
     * @param  string $order_by
     * @return mixed
     */
    public function search(String $table, String $cols, $where, $values,  $limit = 120, String $order_by = 'DESC');

    /**
     * Cache on/off.
     *
     * @param  boolean $type
     * @param  int|null $time
     * @return object
     */
    public function cache(Bool $type, Int $time = null);

    /**
     * Set log permission.
     *
     * @param boolean $value
     * @return object
     */
    public function setLog(Bool $value);
}
