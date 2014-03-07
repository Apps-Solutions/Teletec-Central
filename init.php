<?php
session_start();
if (!isset($_GET['dbg']))
	ini_set('display_errors', 0);
else ini_set('display_errors', 1);
ini_set('session.cookie_domain', str_replace("www.", "", $_SERVER['HTTP_HOST']));

define("DIRECTORY_VIEWS", 	"views/");
define("DIRECTORY_CLASS",	"class/");
define("DIRECTORY_TEMPLATES","templates/");
define("DIRECTORY_BASE", 	"base/");
define("DIRECTORY_CONFIG", 	"config/");

require_once(DIRECTORY_CONFIG . 'config.php');

include_once(DIRECTORY_CLASS . 'class.debug.php');
$MyDebug->SetDebug(0);
include_once('utils.php');
include_once(DIRECTORY_CLASS . 'class.consultas.php');
include_once(DIRECTORY_CLASS . 'class.logic.php');