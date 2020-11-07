<?php

namespace Ataworks\Core;

use PDO, PDOException;
use Ataworks\Cache\Cache;
use Ataworks\Layouts\Core\Db as IDb;

/**
 * Ataworks database class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @deprecated PDO
 * @copyright 2018
 */
class Db extends PDO implements IDb
{
    /**
     * Keep prefix to database table.
     *
     * @var string $prefix
     */
    private $prefix;

    /**
     * Keep columns data for database query.
     *
     * @var string $cols
     */
    private $cols;

    /**
     * Keep values for database query.
     *
     * @var array $values
     */
    private $values = [
        //
    ];

    /**
     * Keep cache on/off.
     *
     * @var boolean $cache
     */
    private $cache = false;

    /**
     * Keep cache time.
     *
     * @var int $cacheTime
     */
    private $cacheTime = 20;

    /**
     * Keep log permission on/off
     *
     * @var boolean $log;
     */
    private $log = true;

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
    public function __construct(String $type, String $server, String $dbname, String $user, String $pass, String $prefix)
    {
        /* Set $prefix */
        $this->prefix = $prefix;

        /**
         * Select database management system.
         *
         * This class Mysql and PostreSQL systems supported.
         */
        switch ($type) {
            case 'mysql':
                $dbms = "mysql:host=$server;dbname=$dbname;charset=utf8";
                break;

            case 'postresql':
                $dbms = "pqsql:host=$server dbname=$dbname";
                break;
        }

        /* Check database connect */
        try {

            /* Database connect */
            parent::__construct($dbms, $user, $pass);

        } catch(PDOException $e) {

            /* Database connect error message */
            $error=("<br/><div style='text-align:center'>"
                . "<span style='padding: 5px; border: 1px solid red; background:#fce0e0;"
                . "font-family: Verdana; color:red; font-size: 11px; margin:0 auto'>"
                . "<b>Database Error: </b>" . $dbname . " database connection failed!</span></div>");
            exit($error);
        }

        /* Set the database charset */
        $this->exec("SET NAMES UTF8");

        /* Set pdo attribute mode */
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * Add new data to database.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $values
     * @return mixed
     */
    public function add(String $table, String $cols, $values)
    {
        /* Convert cols and values */
        $this->cols   = $this->convertCols($cols);
        $this->values = $this->convertValues($values);

        $sql = "INSERT INTO ".$this->prefix.$table." SET $this->cols";
        $sth = $this->prepare($sql)->execute($this->values);

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('insert', $table, $cols, $values);
        }

        /**
         * If the operation completes successfully,
         * returns an error if not integer.
         */
        if ($sth) return $this->lastInsertId();
        return $this->errorInfo();
    }

    /**
     * Update affected data.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $values
     * @param  string $where
     * @return mixed
     */
    public function update(String $table, String $cols, $values, $where)
    {
        /* Convert cols and values */
        $this->cols   = $this->convertCols($cols);
        $this->values = $this->convertValues($values);

        $sql = "UPDATE ".$this->prefix.$table." SET ".$this->cols." WHERE ".$where;
        $sth = $this->prepare($sql);
        $sth->execute($this->values);

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('update', $table, $where, $values);
        }

        /**
         * If the operation completes successfully,
         * returns an error if not true.
         */
        if ($sth) return true;
        return $this->errorInfo();
    }

    /**
     * Delete affected data.
     *
     * @param  string $table
     * @param  mixed  $where
     * @param  mixed  $values
     * @return mixed
     */
    public function delete(String $table, $where, $values)
    {
        /* Convert values parameter */
        $this->values = $this->convertValues($values);

        $sql = "DELETE FROM ".$this->prefix.$table." WHERE ".$where;
        $sth = $this->prepare($sql)->execute($this->values);

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('delete', $table, $where, $values);
        }

        /**
         * If the operation completes successfully,
         * returns an error if not true.
         */
        if ($sth) return true;
        return $this->errorInfo();
    }

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
    public function select(String $table, String $cols, $where = 1, $values = 1, $limit = 120, String $order_by = 'id DESC')
    {
        /* Format values parameter */
        $this->values = $this->convertValues($values);

        $sql = "SELECT $cols FROM ".$this->prefix.$table." WHERE $where ORDER BY $order_by LIMIT $limit";

        /* Check cache on/off */
        if ($this->cache === true) {
            /* Set cache file name */
            $cache = set_cache_name($sql, $values);

            if (Cache::queryCheck($cache, $this->cacheTime)) return Cache::getQuery($cache);
        }

        $sth = $this->prepare($sql);
        $sth->execute($this->values);

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('select', $table, $where, $values);
        }

        /**
         * If the operation completes successfully,
         * returns an false if not array.
         */
        if ($sth->rowCount() > 0) {

            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
            if ($this->cache === true) Cache::setQuery($cache, $data);
            return $data;

        }
        return false;
    }

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
    public function selectSingle(String $table, String $cols, $where = 1, $values = 1, String $order_by = "id DESC")
    {
        /* Format values parameter */
        $this->values = $this->convertValues($values);

        $sql = "SELECT $cols FROM ".$this->prefix.$table." WHERE $where ORDER BY $order_by";

        /* Set cache file name */
        $cache = set_cache_name($sql, $values);

        /* Check cache on/off */
        if ($this->cache === true){
            if(Cache::queryCheck($cache, $this->cacheTime)) return Cache::getQuery($cache);
        }

        $sth = $this->prepare($sql);
        $sth->execute($this->values);

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('selectSingle', $table, $where, $values);
        }

        /**
         * If the operation completes successfully,
         * returns an false if not array.
         */
        if ($sth->rowCount() > 0) {
            $data = $sth->fetch(PDO::FETCH_ASSOC);
            if ($this->cache === true) Cache::setQuery($cache, $data);
            return $data;
        }
        return false;
    }

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
    public function innerJoin(String $cols, String $table, String $joinTables, $where = 1, $values = 1, $single = false, $limit = 120, String $order_by = null)
    {
        /* Format values parameter */
        $this->values = $this->convertValues($values);

        /* Check columns */
        if ($cols != "*")
        {
            if (strpos($cols, ",")) {
                /* Set new columns variable */
                $newCols = "";

                /* Explode columns */
                $cols = explode(",", $cols);

                foreach ($cols as $col)
                {
                    $newCols .= $this->prefix.$col.',';
                }

                $cols = rtrim($newCols, ',');
            } else {
                $cols = $this->prefix.$cols;
            }
        }

        /* Explode join tables */
        $joinTables = explode(",", $joinTables);

        /* Set new join tables variable */
        $newJoinTables = "";

        foreach ($joinTables as $row)
        {
            $newJoinTables .= "INNER JOIN ".$this->prefix.$row." ";
        }
        $joinTables = rtrim($newJoinTables, ',');

        /* Check order by */
        if (empty($order_by)) $order_by = $this->prefix.$table.".id DESC";

        /* Set sql */
        $sql = "SELECT {$cols} FROM ".$this->prefix.$table." ".$joinTables." ON {$where} ORDER BY $order_by LIMIT $limit";

        /* Set cache file name */
        $cache = set_cache_name($sql, $values);

        /* Check cache on/off */
        if ($this->cache === true) {
            if (Cache::queryCheck($cache, $this->cacheTime)) return Cache::getQuery($cache);
        }

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('inner join', $joinTables, $where, "");
        }

        $sth = $this->prepare($sql);
        $sth->execute($this->values);

        /**
         * If the operation completes successfully,
         * returns an false if not array.
         */
        if ($sth->rowCount() > 0) {
            if ($single == true) {
                $data = $sth->fetch();
            } else {
                $data = $sth->fetchAll();
            }
            if ($this->cache === true) Cache::setQuery($cache, $data);
            return $data;
        }
        return false;
    }

    /**
     * Return the count of affected rows.
     *
     * @param  string $table
     * @param  string $cols
     * @param  mixed  $where
     * @return int
     */
    public function getCount(String $table, String $cols = "*", $where = null) : Int
    {
        $sql = "SELECT COUNT({$cols}) FROM ".$this->prefix.$table;
        if (isset($where)) $sql .= " WHERE {$where}";

        $sth = $this->prepare($sql);
        $sth->execute();
        return $sth->fetchColumn();
    }

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
    public function search(String $table, String $cols, $where, $values,  $limit = 120, String $order_by = 'DESC')
    {
        /* Set sql */
        $sql = "SELECT $cols FROM ".$this->prefix.$table." WHERE ".$where." LIKE :q ORDER BY id $order_by LIMIT $limit";

        /* Set cache file name */
        $cache = set_cache_name($sql, $values);
        if (Cache::queryCheck($cache)) return Cache::getQuery($cache);

        $sth = $this->prepare($sql);
        $sth->bindValue(":q", "%{$values}%");
        $sth->execute();

        /* Check log permission */
        if ($this->log === true) {
            Logger::addDbLog('search', $table, $where, $values);
        }

        /**
         * If the operation completes successfully,
         * returns an false if not array.
         */
        if ($sth->rowCount()) {
            $data = $sth->fetchAll();
            Cache::setQuery($cache, $data);
            return $data;
        }
        return false;
    }

    /**
     * Parts of the incoming parameter.
     *
     * @param  mixed $param
     * @return string
     */
    private function convertCols($param) : String
    {
        /* Reset */
        $this->cols = "";

        /* Explode $param */
        $var = explode(",", trim($param));

        /* Array append to $this->cols */
        foreach ($var as $key) {
            $this->cols = $this->cols.', '.$key.' = ?';
            $this->cols = ltrim($this->cols, ",");
        }
        return $this->cols;
    }

    /**
     * Parts of the incoming parameter and array push.
     *
     * @param  mixed $values
     * @return array
     */
    private function convertValues($values) : array
    {
        /* Reset values */
        $this->values = [
            //
        ];

        /**
         * Check incoming parameter.
         * Return if the parameter is an array else continue.
         */
        if (is_array($values)) {
            $this->values = $values;
            return $this->values;
        }

        /* Parameter to array */
        $var = explode(",", trim($values));
        foreach ($var as $key) {
            array_push($this->values, $key);
        }
        return $this->values;
    }

    /**
     * Cache on/off.
     *
     * @param  boolean $type
     * @param  int|null $time
     * @return object
     */
    public function cache(Bool $type, Int $time = null)
    {
        $this->cache = $type;
        if (isset($time)) $this->cacheTime  = $time;
        return $this;
    }

    /**
     * Set log permission.
     *
     * @param boolean $value
     * @return object
     */
    public function setLog(Bool $value)
    {
        $this->log = $value;
        return $this;
    }

    /**
     * Reset variables.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->values = [
            //
        ];
        $this->cols  = null;
        $this->limit = 120;
    }
}
