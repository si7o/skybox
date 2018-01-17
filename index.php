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

/*
switch(count($p)) 
{
    case 0: $App->{$r->getControllerName()}->{$r->getFunctionName()}(); break;
    case 1: $App->{$r->getControllerName()}->{$r->getFunctionName()}(...$r->getFunctionParams()); break;
    case 2: $App->{$r->getControllerName()}->{$r->getFunctionName()}($p[0], $p[1]); break;
    case 3: $App->{$r->getControllerName()}->{$r->getFunctionName()}($p[0], $p[1], $p[2]); break;
    case 4: $App->{$r->getControllerName()}->{$r->getFunctionName()}($p[0], $p[1], $p[2], $p[3]); break;
    case 5: $App->{$r->getControllerName()}->{$r->getFunctionName()}($p[0], $p[1], $p[2], $p[3], $p[4]); break;
    //default: call_user_func_array(array($c, $a), $p);  break;
} */
