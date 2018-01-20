<?php
/**
 * 
 * MAIN CONSTANTS, INCLUDES & ROUTING
 * 
 */
error_reporting(E_ERROR);

define("DS","/",true);
define('BASE_PATH',realpath(dirname(__FILE__)).DS,true);


include BASE_PATH.'app/config/constants.php';
require_once CORE_PATH.'helper.php';
require_once CORE_PATH.'app.php';

// BEGIN
$App = new App();

require_once CORE_PATH.'router.php';
$Router = new Router();

$r = $Router->getRouting();

$App->load_controller($r->getControllerName());	
$App->{$r->getControllerName()}->{$r->getFunctionName()}(...$r->getFunctionParams());
