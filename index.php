<?php
/**
 * 
 * MAIN CONSTANTS & INCLUDES
 * 
 */
define("DS","/",true);
define('BASE_PATH',realpath(dirname(__FILE__)).DS,true);


include 'app/config/constants.php';
require_once CORE_PATH.'helper.php';
require_once CORE_PATH.'app.php';

// BEGIN
$App = new App();

require_once CORE_PATH.'router.php';
$Router = new Router();

$c = $Router->routing['controller_name'];
$a = $Router->routing['function_name'];
$p = $Router->routing['function_params'];

$App->load_controller($c);	

switch(count($p)) 
{
    case 0: $App->{$c}->{$a}(); break;
    case 1: $App->{$c}->{$a}($p[0]); break;
    case 2: $App->{$c}->{$a}($p[0], $p[1]); break;
    case 3: $App->{$c}->{$a}($p[0], $p[1], $p[2]); break;
    case 4: $App->{$c}->{$a}($p[0], $p[1], $p[2], $p[3]); break;
    case 5: $App->{$c}->{$a}($p[0], $p[1], $p[2], $p[3], $p[4]); break;
    //default: call_user_func_array(array($c, $a), $p);  break;
} 
