<?php

function debug($data, $dump = false) {
	echo "<pre>";
	if (is_object($data) or $dump)
		var_dump($data);
	else 
		print_r($data);	
	echo "</pre>";
}

function title_to_uri ($title) {
    $url = $title;
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url); // TRANSLIT does the whole job
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url); // keep only letters, numbers, '_' and separator
    return $url;
}