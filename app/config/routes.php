<?php

$routes['default'] = "home";
$routes['error404'] = "error404";

$routes['pano/(\d+)/([a-zA-Z0-9\-]+)'] = "pano/viewer/$1/$2";

$routes['proxy\?(.*)'] = "proxy/index";
$routes['proxy/file/([^/]+)/referer/([^/]+)'] = "proxy/file/$1/$2";
$routes['proxy/file/([^/]+)'] = "proxy/file/$1";

$routes['pano/imgur/(\w+)'] = "pano/imgur/$1";
$routes['pano/file/?\?(.*)'] = "pano/file";

$routes['about'] = "home/about";

$routes['flickr'] = "flickr/index";
$routes['flickr/(\d+)'] = "flickr/photo/$1";

$routes['flickr/photos/([^/]+)/(\d+)'] = "flickr/photo/$2";
$routes['flickr/photos/([^/]+)'] = "flickr/user/$1";