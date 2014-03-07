<?php
require 'init.php';
 
if (isset($_POST['command']) && $_POST['command'] != ''){
	$command = $_POST['command'];
} else if (isset($_GET['command']) && $_GET['command'] != ''){
	$command = $_GET['command'];
} else $command = HOME;

$MyIndex->Logic($command); 
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8">
	    <title><?php echo $MyIndex->Title(); ?></title>
	<!-- CSS -->
	    <link href="css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css" />
	    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
	    <link href="css/css_teletec.css" rel="stylesheet" type="text/css" />
	    <link href="css/ui.jqgrid.css" rel="stylesheet" type="text/css" />  
     	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
	<!-- /CSS -->
	<!-- JS -->
		<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/grid.locale-sp.js"></script>   
		<script type="text/javascript" src='js/jquery.jqGrid.min.js'></script> 
		<script type="text/javascript" src="js/moment.js"></script>
		<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
	<!-- /JS -->
	</head> 
	<body> 
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