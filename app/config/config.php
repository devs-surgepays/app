<?php
define('ENVIRONMENT', 'prod');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
 
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);

  $host = 'localhost';
  $user = 'root';
  $pass = '';
  $url_root = 'http://localhost/app';

}else{
  $host = '172.24.13.20';
  $user = 'hrsurge';
  $pass = '01cNSZZEwK1t';
  #$url_root = 'https://hr-surge.com/app';
  $url_root = "https;//hr-surgepays.com/app"
}
  // DB Params
  define('DB_HOST', $host);
  define('DB_USER', $user);
  define('DB_PASS', $pass);
  define('DB_PORT', '3306');
  define('DB_NAME', 'hr_surgepays');

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', $url_root);
  // Site Name
  define('SITENAME', 'HR Surgepays');
  // App Version
  define('APPVERSION', '1.0.0');