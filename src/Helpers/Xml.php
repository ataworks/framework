<?php

namespace Ataworks\Helpers;

/**
 * Ataworks xml class
 *
 * @author Emrullah Tanıma <emrtnm@gmail.com>
 * @package Ataworks
 * @license MIT
 * @copyright 2018
 */
class Xml
{
    /**
     * Convert xml
     *
     * @param  array  $data
     * @param  string $nodeName
     * @param  mixed  $xml
     * @return xml
     */
    public function convertXml(Array $data = [], String $nodeName = 'data', $xml = null)
    {
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='UTF-8'?><$nodeName />");
        }

        foreach ($data as $key => $val) {
            if (is_numeric($key))    $key = "item_" . (string) $key;
            $key = preg_replace('/[^a-z]/i', '', $key);

            if (is_array($val)) {
                $node = $xml->addChild($key);
                self::convertXml($val, $nodeName, $node);
            } else {
                $xml->addChild($key, $val);
            }
        }
        return $xml->asXML();
    }

    /**
     * Check
     * 
     * @param  string $xml
     * @return boolean
     */
    public function check(String $xml) : Bool
    {
        if (empty($xml)) return false;
        libxml_use_internal_errors(true);
        simplexml_load_string($xml);
        $return = ! (bool) libxml_get_errors();
        libxml_clear_errors();
        return $return;
    }
}
