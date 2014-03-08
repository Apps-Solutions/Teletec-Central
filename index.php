<?php
require 'init.php';
 
if (isset($_POST['command']) && $_POST['command'] != ''){
	$command = $_POST['command'];
} else if (isset($_GET['command']) && $_GET['command'] != ''){
	$command = $_GET['command'];
} else $command = HOME;

global $mensaje, $error;
if (isset($_GET['msg'])) $mensaje .= $_GET['msg'];
if (isset($_GET['err'])) $error .= $_GET['err']; 
$msg_class = "oculto";
$err_class = "oculto";
if ($mensaje != '') {
	$msg_class = "";
	$timer = "mensaje";
} 
if ($error != ''){
	$err_class = "";
	$timer = "error";
}
$MyIndex->Logic($command); 
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8">
	    <title><?php echo $MyIndex->Title(); ?></title>
	<!-- CSS -->
	    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.22.custom.css"/>
        <link rel="stylesheet" type="text/css" href="css/ui.jqgrid.css"/>
        <link rel="stylesheet" type="text/css" href="css/css_teletec.css"/>
	<!-- /CSS -->
	<!-- JS -->
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
        <script type="text/javascript" src="js/grid.locale-sp.js"></script>
        <script type="text/javascript" src="js/jquery.jqGrid.min.js"></script>
        <script type="text/javascript" src="js/moment.js"></script>
	<!-- /JS -->
	</head> 
	<body> 
    <!--aqui es para mistar errores o msj -->
           
           
		<div id='cont_msg' style="z-index: 99999999; position:fixed; width:95%;"> 
			<div  id='msg_div'  class="ui-widget  <? echo  $msg_class; ?>" 	>
				<div class="ui-state-highlight ui-corner-all" style="padding: 1em .7em;"  >
					<p><span class="ui-icon ui-icon-info" style=" float:left; margin-right: .3em; "> </span>
					 <span id='msg_span' ><? echo  $mensaje; ?> </span>
					 <span style="float:right;"><a href="javascript:void(0);" onclick="javascript:$('#msg_div').hide();"> X </a> </span> 
					 </p>
				</div> 
			</div>
			<div  id='err_div' class="ui-widget <? echo  $err_class; ?> " >
				<div class="ui-state-error ui-corner-all " style="padding: 1em .7em;">
					<span class="ui-icon ui-icon-alert" style=" float:left;  margin-right: .3em; "> </span>
					 <span id='err_span' ><? echo  $error; ?> </span></p> 
					 <span style="float:right;"><a href="javascript:void(0);" onclick="javascript:$('#err_div').hide();"> X </a> </span> 
				</div> 
			</div>  
		</div>
    
    <div class="container fondoo_gris_total "><!--Container General-->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
	        <div class="row ">
	        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 quitar_padding quitar_borde">
	              	<img src="gfx/banner.png" class="img-responsive agustar" alt="Teletec" >
	            </div>
	        </div> 
	        <div class="row">
	          	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tam_uno_formulario"></div>
	        </div>
        
    <?php
    if ($MySession->LoggedIn()):
        require_once DIRECTORY_VIEWS . DIRECTORY_BASE . 'menu.php';
    endif;
    ?>
    <?php include_once 'getcookiedata.php';?>
    <?php include_once $MyIndex->MyPHPFile(); ?>
    	</div>
    </div>
</body>
</html>