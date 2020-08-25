<?php

define("IS_RELEASE", $_SERVER['SERVER_NAME'] == 'release-server.com');
!defined('IS_TEST') or define('IS_TEST', false);

error_reporting(IS_RELEASE ? E_ALL :E_ALL);

include "functions.php";
require(__DIR__ . '/vendor/autoload.php');

session_start();

// the test get var denotes that unit testing goes on
if (!IS_RELEASE && isset($_GET['test'])) {
    define('IS_TEST', true);
    $_SESSION['is_admin_logged'] = 1;
} else {
    define('IS_TEST', false);
}


use osoznan\patri\Top;

Top::$app = new osoznan\patri\App(require('config/config.php'));
Top::$app->config = require('config/config.php');
Top::$app->init();

Top::$app->run($_SERVER['REQUEST_URI']);


