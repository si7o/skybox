<?php

$routes['default'] = "home";
$routes['error404'] = "error404";

$routes['pano/(\d+)/([a-zA-Z0-9\-]+)'] = "pano/viewer/$1/$2";

$routes['pano/flickr'] = "pano/flickr";
$routes['pano/flickr/(\d+)'] = "pano/flickr/$1";
$routes['proxyFlickrImage/(\d+)/(\d+)'] = "pano/getFlickrImage/$1/$2";
$routes['proxy\?(.*)'] = "pano/proxyImage";
$routes['pano/imgur/(\w+)'] = "pano/imgur/$1";
$routes['pano/file/?\?(.*)'] = "pano/file";