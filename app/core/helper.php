<?php

/**
 * Helper
 * 
 * Common functions
 * 
 */

/**
 * debug
 * 
 * Old school debug function in case XDEBUG is not installed or configured
 * 
 * @param any $data data to debug
 * @param boolean $dump dump or print_r
 * 
 * 
 */
function debug($data, $dump = false)
{
    echo "<pre>";
    if (is_object($data) or $dump)
        var_dump($data);
    else
        print_r($data);
    echo "</pre>";
}

/**
 * title_to_uri
 * 
 * Convert text to uri
 * 
 * @param string $title
 * @return string
 */
function title_to_uri($title)
{
    $url = $title;
    // substitutes anything but letters, numbers and '_' with separator
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    // TRANSLIT does the whole job
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    // keep only letters, numbers, '_' and separator
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
    return $url;
}
