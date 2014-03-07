<?php
require 'init.php';
include_once(DIRECTORY_CLASS.'class.login.php');

$login 		= new LOGIN; 
$usuario	= isset($CONTEXT["usuario"]) 	? Sanitizacion($CONTEXT["usuario"]) 	: "";
$contrasena	= isset($CONTEXT["contrasena"]) ? Sanitizacion($CONTEXT["contrasena"]) 	: "";
$error 		= false;

if(empty($usuario)){
    $http_vars["MsgErr"] .=  "Favor de llenar el campo Usuario\n";
    $error = true;
}

if(empty($contrasena)){
    $http_vars["MsgErr"] .=  "Favor de llenar el campo Contraseña\n";
    $error = true;
}
if($error == false){
    if($login->LoginE($usuario, md5($contrasena)) == LOGIN_SUCCESS) { 
        $MySession->setVar('teletec_nombre', 	$login->Nombre());
        $MySession->SetVar('teletec_perfil', 	$login->Nivel());
        $MySession->SetVar('teletec_correo',	$login->Email());
        $MySession->SetVar('teletec_id', 		$login->Id()); 
        $location ="index.php";
    }
    else {
        $http_vars["MsgErr"] .= "El Usuario o la Contrase&ntilde;a no son correctos ";
        $location = "index.php?command=" . LOGIN;
    }
}
else{
    $location = "index.php?command=" . LOGIN;
}

$_SESSION["cookie_http_vars"] = $http_vars;
header("HTTP/1.1 302 Moved Temporarily");
header("Location: $location");
