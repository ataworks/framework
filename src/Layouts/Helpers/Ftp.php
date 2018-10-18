<?php

namespace Ataworks\Layouts\Helpers;

interface Ftp
{
    /**
     * Ftp connection.
     *
     * @param  string $host
     * @param  string $user
     * @param  string $pass
     * @param  string $base
     * @return object
     */
    public function __construct(String $host, String $user, String $pass, String $base);

    /**
     * Create new dir.
     *
     * @param  string $dir
     * @return void
     */
    public function makeDir(String $dir);

    /**
     * Delete dir.
     *
     * @param  string  $dir
     * @return boolean
     */
    public function deleteDir(String $dir) : Bool;

    /**
     * Rename dir
     *
     * @param  string  $dir
     * @param  string  $newName
     * @return boolean
     */
    public function renameDir(String $dir, String $newName) : Bool;

    /**
     * Apply chmod values.
     * 
     * @param  int    $permission
     * @param  string $dir
     * @return string
     */
    public function chmod(Int $permission, String $dir) : String;

    /**
     * Upload ftp.
     * 
     * @param  string $remoteFile
     * @param  string $localeFile
     * @return string
     */
    public function upload(String $remoteFile, String $localeFile) : String;

    /**
     * Download ftp.
     *
     * @param  string  $remoteFile
     * @param  string  localeFile
     * @return boolean
     */
    public function download(String $remoteFile, String $localeFile) : Bool;

    /**
     * Return file size.
     * 
     * @param  string $dir
     * @return int
     */
    public function getSize(String $dir) : Int;

    /**
     * Return file last mod.
     *
     * @param  string $file
     * @return string
     */
    public function getLastMod(String $file) : String;

    /**
     * Get Base Path
     *
     * @return string
     */
    public function getBasePath() : String;

    /**
     * Close ftp connection.
     *
     * @return void
     */
    public function close();
}
