<?php

/**
 *  DEFINE CONSTANTS 
 * 
 * 	FL_KEY - Your flickr Api key
 *      IMGUR_CLIENT_ID - your imgur client ID
 * 
 * And save this file as constants.php
 * 
 */

define ('DOMAIN_NAME', 'http://'.$_SERVER['HTTP_HOST'].DS);

define ('APP_PATH', BASE_PATH.'app'.DS);
define ('CORE_PATH', APP_PATH.'core'.DS);
define ('RES_PATH', BASE_PATH.'resources'.DS);
define ('DATA_PATH',RES_PATH.'data'.DS);
define ('CONTROLLER_PATH', APP_PATH.'controller'.DS);
define ('CONFIG_PATH', APP_PATH.'config'.DS);
define ('VIEW_PATH', APP_PATH.'view'.DS);
define ('MODEL_PATH', APP_PATH.'model'.DS);
define ('LIBRARY_PATH', APP_PATH.'libraries'.DS);

define ('FL_KEY', '------------------------------');
define ('FL_FORMAT', 'json');
define ('FL_API_URL','https://api.flickr.com/services/rest/');

define ('PX500_KEY', '--------------------');
define ('PX500_FORMAT', 'json');
define ('PX500_API_URL','https://api.500px.com/v1/');

define ('IMGUR_CLIENT_ID', '---------------------------------');
define ('IMGUR_API_URL', 'https://api.imgur.com/3/');

define ('CACHE',true);
define ('CACHE_PATH', BASE_PATH.'CACHE'.DS);
define ('CACHE_DELETE_OLDFILES', 24*60*60);
