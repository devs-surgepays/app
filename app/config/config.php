<?php
define('ENVIRONMENT', 'prod');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}
  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_PORT', '3306');
  define('DB_NAME', 'hr_surgepays');

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', 'http://localhost/surge-hr');
  // Site Name
  define('SITENAME', 'Emmizy MVC Frame');
  // App Version
  define('APPVERSION', '1.0.0');