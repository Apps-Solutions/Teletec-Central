<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title> Dashboard </title>
<!-- Bootstrap core CSS -->
    
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
     
    <!-- Custom styles for this template 
    <link href="jumbotron.css" rel="stylesheet">-->
</head>

<body>
	<? require_once 'menu.php' ?>
    
    
 <div class="container fondoo_negro_total"><!--Container General-->
 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pading_20 ">
    
      <div class="row  pading_row_uno">
      		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="col-xs-9 col-sm-9 col-md-4 col-lg-4">
                	<div class="class_select">
                        <select class="class_select" name="">
                          <option value="1" selected="selected">Comunicacion</option>
                          <option value="2">Catering</option>
                          <option value="3">General</option>
                          <option value="4">Property</option> 
                        </select>
                   </div>
                </div>
                
                <div class="col-xs-3 col-sm-3 col-md-8 col-lg-8"></div>
            </div>
      </div>
      
 	
     <!--////////////////////////////////////////////////////////////////////-->
  
      <div class="row tam_espacio_libre_uno "><!--Row espacio_libre-->
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
          </div>
      </div><!--FIN Row espacio_libre-->
   
    <!--////////////////////////////////////////////////////////////////////-->
      
 	
     	<div class="row ">
     		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="row pading_20">
                
                
           			        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 tam_result_busqueda_mitad1 ">
                          
                          <? for ($i=0;$i<4;$i++) { ?>
                    	      <div class="row estilo_resultado_busqueda">
                            	  <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                   
                                	  <div class="row">    
                                         
                                    	<div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        	<img src="gfx/sr_busqueda.png"  class="img-responsive img-circle" alt="Imagen" />
                                      </div>
    
                                        <div class=" col-xs-10 col-sm-7 col-md-7 col-lg-7">
                                            <div class="table-responsive">
                                                <ul class=" list-unstyled ">
                                                    <li>Cesar Ventosasssssssssssssssssssssssssssssss</li>
                                                    <li>Administrador Menu</li>
                                                    <li>C.ventosa@vodafone.com</li>
                                                </ul>
                                            </div>  
                                    	  </div>

                                        <div class=" col-xs-2 col-sm-2 col-md-2 col-lg-2 pading_top_elimi_y_edi">
                                          <img src="gfx/lapiz_admin.png"  class="  flotar_izquierda margen_derecho" alt="Imagen" />
                                          <img src="gfx/basurero_admin.png"  class=" flotar_izquierda" alt="Imagen" />
                                        </div>


                                	  </div>
                             	  </div>
                            </div>
                        <? } ?>
                        </div>
                        

                    
                    
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 tam_result_busqueda_mitad2 "><!--usuario especifi-->
                 		   <div class="row">
                    		 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  fondo_rojo_degra_total">
                             
                   	  			<div class="row">
                                	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  tam_busqueda_mitad2_uno">
                              	   		<div class="row">
                                     	 	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
                                     		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 agustar ">
                                            	<div class="div_redondo">
                                            	
                                              		<img src="gfx/mujer.jpg"  class="img-responsive img-circle " alt="Imagen"   />
                                              	 </div>
                                             </div>
                                      		 <div class=" col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
                                  	   </div>
                             		</div>
                        		 </div>  
                      
                      
                            <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                  <div class="row">

                                    <div class=" hidden-xs col-sm-3 col-md-3 col-lg-3"></div>
                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 text_blanco tam_texto_14">
                                    	<div class="row pading_bottom">
                                        	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Nombre:</div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><span>Armando  </span></div>
                                            
                                        </div>
                                        <div class="row pading_bottom">
                                        	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Apellido:</div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Tamayo Conde  </div>
                                            
                                        </div>
                                        <div class="row pading_bottom">
                                        	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Email:</div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><span>a.tamayo@vodafone.com </span></div>
                                            
                                        </div>
                                        <div class="row pading_bottom">
                                        	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Telefono:</div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><span>55 66 77 00 ext.345 </span></div>
                                            
                                        </div>
                                        <div class="row pading_bottom">
                                        	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Cargo:</div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><span>Administrador-Cominicación </span></div>
                                            
                                        </div>   
                                	   </div>
                                    <div class=" hidden-xs col-sm-1 col-md-1 col-lg-1"></div>

                                </div>
                              </div>
                           </div> 
                           
                       	</div>
                     </div><!-- FIN Con este mostaremos un uauario en especifico-->
                  </div>
              </div>
           </div>
        </div><!-- FIN row-->
     </div>
  </div>
 


<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>