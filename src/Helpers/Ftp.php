<?php

namespace Ataworks\Helpers;

use Ataworks\Layouts\Helpers\Ftp as IFtp;

/**
 * Ataworks ftp class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Ftp implements IFtp
{
    /**
     * Keeps ftp connect object.
     *
     * @var object $connect
     */
    private $connect;

    /**
     * Keeps the home directory of the ftp connection.
     *
     * @var string $basePath
     */
    private $basePath;

    /**
     * Ftp connection.
     *
     * @param  string $host
     * @param  string $user
     * @param  string $pass
     * @param  string $base
     * @return object
     */
    public function __construct(String $host, String $user, String $pass, String $base)
    {
        $this->basePath = $base.'/';
        $this->connect  = ftp_connect($host);
        ftp_login($this->connect, $user, $pass);
        return $this;
    }

    /**
     * Create new dir.
     *
     * @param  string $dir
     * @return void
     */
    public function makeDir(String $dir)
    {
        if (!file_exists($this->basePath.$dir)) {
            ftp_mkdir($this->connect, $this->basePath.$dir);
        }
    }

    /**
     * Delete dir.
     *
     * @param  string  $dir
     * @return boolean
     */
    public function deleteDir(String $dir) : Bool
    {
        return ftp_rmdir($this->connect, $this->basePath.$dir);
    }

    /**
     * Rename dir
     *
     * @param  string  $dir
     * @param  string  $newName
     * @return boolean
     */
    public function renameDir(String $dir, String $newName) : Bool
    {
        return ftp_rename($this->connect, $this->basePath.$dir, $newName);
    }

    /**
     * Apply chmod values.
     * 
     * @param  int    $permission
     * @param  string $dir
     * @return string
     */
    public function chmod(Int $permission, String $dir) : String
    {
        if (ftp_chmod($this->connect, $permission, $dir) !== false) {
            return "<p>$dir chmoded successfully to $permission.</p>\n";
        }
    }

    /**
     * Upload ftp.
     * 
     * @param  string $remoteFile
     * @param  string $localeFile
     * @return string
     */
    public function upload(String $remoteFile, String $localeFile) : String
    {
        if (ftp_put($this->connect, $this->basePath.$remoteFile, $localFile, FTP_ASCII)) {
            return "<p>Successfully uploaded $localFile to $remoteFile</p>\n";
        }
        return "<p>There was a problem while uploading $remoteFile</p>\n";
    }

    /**
     * Download ftp.
     *
     * @param  string  $remoteFile
     * @param  string  localeFile
     * @return boolean
     */
    public function download(String $remoteFile, String $localeFile) : Bool
    {
        if (ftp_get($this->connect, $localeFile, $remoteFile, FTP_ASCII)) return true;
        return false;
    }

    /**
     * Return file size.
     * 
     * @param  string $dir
     * @return int
     */
    public function getSize(String $dir) : Int
    {
        return ftp_size($this->connect, $this->basePath.$dir);
    }

    /**
     * Return file last mod.
     *
     * @param  string $file
     * @return string
     */
    public function getLastMod(String $file) : String
    {
        return ftp_mdtm($this->connect, $file);
    }

    /**
     * Get Base Path
     *
     * @return string
     */
    public function getBasePath() : String
    {
        return $this->basePath;
    }

    /**
     * Close ftp connection.
     *
     * @return void
     */
    public function close()
    {
        ftp_close($this->connect);
    }
}
