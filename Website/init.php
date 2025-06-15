<?php

// Include secure session configuration
require_once 'includes/functions/session_config.php';

// Start secure session
secure_session_start();

// Set default timezone
date_default_timezone_set('UTC');

// Error Reporting

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'admin/connect.php';

$sessionUser = '';
$sessionAvatar = '';

if (isset($_SESSION['user'])) {
	$sessionUser = $_SESSION['user'];
	$sessionAvatar = $_SESSION['avatar'];
}

// Routes

$tpl 	= 'includes/templates/'; // Template Directory
$lang 	= 'includes/languages/'; // Language Directory
$func	= 'includes/functions/'; // Functions Directory
$css 	= 'layout/css/'; // Css Directory
$js 	= 'layout/js/'; // Js Directory

// Include The Important Files

include $func . 'functions.php';
include $lang . 'english.php';
include $tpl . 'header.php';
