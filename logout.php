<?php
ini_set('session.cookie_domain', str_replace("www.", "", $_SERVER['HTTP_HOST']));
session_start();
include_once('class/class.debug.php');
$MyDebug->SetDebug(0);
include_once('class/class.session.php');
$MySession->EndSession();
header("HTTP/1.1 302 Moved Temporarily");
header("Location: index.php");