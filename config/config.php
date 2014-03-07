<?php
/**************** Definición de Errores ****************/
$iIBDNextError=200;
define("IBD_SUCCESS",			$iIBDNextError++);
define("IBD_ERR_CANTCONNECT",	$iIBDNextError++);
define("IBD_ERR_CANTSELECT",	$iIBDNextError++);
define("IBD_ERR_DBUNAVAILABLE",	$iIBDNextError++);

$_iLOGINError = 200;
define("LOGIN_SUCCESS", 		$_iLOGINError++);
define("LOGIN_BADLOGIN",  		$_iLOGINError++);
define("LOGIN_DBFAILURE", 		$_iLOGINError++);

/****************** Configuración WEB ******************/
define("NOMBRE_WEB",			strtoupper(str_replace("www.","", $_SERVER["SERVER_NAME"])));
define("URL_WEB",				"");
define("MAIL_WEB",				"");
define("TEMA_WEB",				"default");
define("MSG_ALERT", 			"THICKBOX");

/****************** Configuración BD ******************/
define ("DBCONNECT", 			'localhost');
define ("DBUSERNAME", 			'teletec');
define ("DBPASSWORD", 			'teletec1234');
define ("DBNAME", 				'teletec');


/*******************************************************/
define("NIVEL_USERPUBLICO",		0);
define("NIVEL_USERADMIN",		1);
/************** Configuración de vistas ****************/
$_command=1001;
define("HOME", 					"dashboard");
define("LOGIN",	 				"login");
define("USUARIOS", 				"usuarios");

$uiCommand = array(); 
$uiCommand[LOGIN]	=	array(
	array(NIVEL_USERPUBLICO),
	"Iniciar Sesion",
	"frm.login.php",
	"",
	"",
	""
);

$uiCommand[HOME]	=	array(
	array(NIVEL_USERADMIN), //Controla los permisos
	"Central Teletec", //Titulo
	DIRECTORY_VIEWS.DIRECTORY_BASE."dashboard.php", //Archivo PHP
	"", //array("ejemplo.js","ejemplo2.js")
	"", //array("css.css","css2.css")
	"" //Ajax File
);

$uiCommand[USUARIOS]=	array(
	array(NIVEL_USERADMIN), //Controla los permisos
	"Central Teletec | Usuarios", //Titulo
	DIRECTORY_VIEWS."usuarios/usuarios.php", //Archivo PHP
	"", //array("ejemplo.js","ejemplo2.js")
	"", //array("css.css","css2.css")
	"" //Ajax File
);

?>