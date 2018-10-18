<?php

namespace Ataworks\Layouts\Helpers;

interface Xml
{
    /**
     * Convert xml
     *
     * @param  array  $data
     * @param  string $nodeName
     * @param  mixed  $xml
     * @return xml
     */
    public function convertXml(Array $data = [], String $nodeName = 'data', $xml = null);

    /**
     * Check
     * 
     * @param  string $xml
     * @return boolean
     */
    public function check(String $xml) : Bool;
}
