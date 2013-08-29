<?php
/**
 *
 * Initial configs
 *
 *
 */
//namespace \Sblog;

define('START_TIME', microtime(true));
require 'server_env.php';
require 'php_ini.php';
require 'database.php';
// Root Directory
define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));
define('DS', DIRECTORY_SEPARATOR);
// DEBUG mode TODO depends on server env
define('DEBUG', true);
define('DEBUG_PRINT', true);

// basic PATH
define('APP_DIR',               ROOT_DIR . DS . 'app');
define('SBLOG_DIR',             ROOT_DIR . DS . 'src' . DS . 'Sblog');
define('VENDOR_DIR',            ROOT_DIR . DS . 'vendor');
define('TEMPLATES_DIR',         APP_DIR  . DS . 'templates');
define('TEMPLATES_CACHE_DIR',   APP_DIR  . DS . 'templates' . DS . 'cache');
// Log
define('LOG_DIR',        APP_DIR . DS . 'logs');
define('LOG_LEVEL',      4);
define('LOG_ENABLED',    true);
// Core directory
//define('LIB_DIR',        APP_DIR . DS . 'Lib');
//define('LIB_DIR',        SBLOG_DIR . DS . 'Lib');
define('CONTROLLER_DIR', APP_DIR . DS . 'Controller');
define('CONFIG_DIR',     APP_DIR . DS . 'Config');
define('MODEL_DIR',      APP_DIR . DS . 'Model');

// EDIT THIS! FIXME move this to site config
define('SECRET_KEY', 'change_this_secret_key');
