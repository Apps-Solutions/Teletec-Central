	<script>  
		$(document).ready(function()
		{
  			$('#carousel').carousel({ interval: 10000 }); 
  			
  			/*
          	$.fn.datetimepicker.dates['es'] = 
	          {
	            days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
	            daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
	            daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
	            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
	            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"] ,
	            today: "Hoy"
	          }; 
          */
			$('#div_desde, #div_hasta').datetimepicker( {
  				format: 'MM/dd/yyyy',
  				autoclose: true,
			}); 
			var picker = $('#desde').data('datepicker'); 
			 
			$("#visitas_lst").jqGrid({ 
                url:'',
                datatype: "xml", 
                colNames:['Usuario', 'Anfitrión', 'C.P.', 'FECHA', ' '], 
                colModel:[ 
                    {name:'usuario',		index:'usuario', 	width:100,  align:'left'  } ,
                    {name:'persona',		index:'persona', 	width:100,  align:'left'  } ,
                    {name:'cp',				index:'cp', 		width:120, 	align:'left' 	} ,
                    {name:'fecha',		    index:'fecha',		width:120, 	align:'center'  , sortable:false },
                    {name:'acciones',		index:'acciones',	width:100,	align:'center', sortable:false }  
                ],
                rowNum:30,
                width:800,
                height: 300,
                rowList:[30,50,100],
                pager: '#visitas_pager',
                sortname: 'Usuario',
                viewrecords: true, 
                altRows: true, 
                altclass: 'zebra', 
                sortorder: "asc",
                caption: "Usuarios", 
                loadtext: "Cargando...", 
                multiselect: false,
                footerrow : false,
                userDataOnFooter : false,
                onSelectRow: function(id){ }
            });
        
            jQuery("#visitas_lst").jqGrid('navGrid','#visitas_pager',
                {edit:false,add:false,del:false,search:true, view:true}, //options
                {}, // edit options
                {}, // add options
                {}, // del options
                { sopt: true }, // search options
                {	closeOnEscape:true,
                    beforeShowForm: function(form) { 
                  } ,jqModal:false
                }
            ); 
        });
        
        function confirmacion(){
            if(!confirm("Por favor, confirme que desea eliminar el producto.")) {
                return false;
            }
        }
         
	</script> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 agustar">
       	 <span class="text_zise_18">Dashboard</span>
        </div>
    </div> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tam_dos_formulario "></div>
    </div> 
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        	<div class="row">
          	<div class="col-lg-1">Usuarios:</div>
              <div class="col-lg-4">
              	<div class="conte_select">
                    <select class="class_select" name="">
                      <option value="1" selected="selected">Administrar Menu</option>
                      <option value="2">Administrar Mapa</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                    </select>
                  </div>
              </div>
              <div class="col-lg-7"></div>
          </div>
        </div>
    </div>
    
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  pading_bottom ">
        	<div  class="row">
          	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
              	<span class="flotar_izquierda">Desde:</span>
				<div id="div_desde" class="input-append date">
					<input type="text" name="inp_desde"  id="inp_desde" class="tam_text_fecha flotar_izquierda text_negro"  data-date-format="mm/dd/yy" value=''>
					<span id="span_desde" class="add-on flotar_izquierda margen_izquierdo">
					<i data-time-icon="icon-time" data-date-icon="icon-calendar">
						<img class=" pading_left margen_izquierdo" src="gfx/calendario_verde.png" alt="Imagen" />
					</i>
					</span>
                </div>     
              </div>
              <div class="hidden-xs col-sm-4 col-md-4 col-lg-4"></div>
              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
              	<span class="flotar_izquierda">Hasta:</span>
                  	<div id="div_hasta" class="input-append date">
                            <input type="text" name="inp_hasta"  id="inp_hasta" class="tam_text_fecha flotar_izquierda text_negro"  data-date-format="mm/dd/yy">
                            <span id="span_hasta" class="add-on flotar_izquierda margen_izquierdo">
                              <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                  <img class=" pading_left margen_izquierdo" src="gfx/calendario_verde.png" alt="Imagen" />
                              </i>
                            </span>
                      </div>
              </div>
          </div>
        </div>
    </div>
        
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pading_bottom ">
                       <div cellpadding="0" cellspacing="0" border="0" class="display" style="width:800px;margin-left: auto;margin-right: auto; margin-top: 30px"> 
                  <table id="tabla_listado" >
                      <tr>
                          <th colspan="2" style="text-align: center;font-weight: bold;font-size: 1.3em;padding-bottom: 30px">
                              <span class="titulo_formulario"></span>
                          </th>
                      </tr> 
                  </table>
                  <div align="center" style="margin:0 auto; display:block;width:100%;"  >  
                      <table id='visitas_lst' class="scroll"></table>
                      <div id="visitas_pager" class="scroll" style="text-align:center;"></div>  
                  </div>   
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pading_bottom ">
            	<img src="gfx/mapa_form.png" width="899" height="337" class="img-responsive agustar"> 
            </div>
        </div>

    </div>
  </div>
   
   <!--  Modal Pequeño -->
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header  text_blanco_2 ">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title text_negro" id="myModalLabel">Informacion de Visita</h4>
        </div>
        <div class="modal-body ">
        
        	<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  agustar text_zise_18 text_negro">Resumen</div>
          </div>
          <div class="row pading_left_30">
          	<div class="col-lg-8 text_negro ">
              	<div class="row">
                  	<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                      	<div class="row">Nombre:</div>
                          <div class="row">Edad:</div>
                          <div class="row">Sexo:</div>
                          <div class="row">Calle y Num:</div>
                          <div class="row">Cp:</div>
                          <div class="row">Colonia:</div>
                          <div class="row">Municipio:</div>
                      </div>
                      <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 ">
                      	<div class="row"><?php echo"Jose Martinez"?></div>
                          <div class="row"><?php echo"39 años"?></div>
                          <div class="row"><?php echo"Masculino"?></div>
                          <div class="row"><?php echo"Progreso N.17"?></div>
                          <div class="row"><?php echo"53120"?></div>
                          <div class="row"><?php echo"El encanto"?></div>
                          <div class="row"><?php echo"Santa Catarina"?></div>
                      </div>
                      <div class="hidden-xs col-sm-7 col-md-7 col-lg-7 "></div>
                      
                  </div>
                  <div class="row">
                  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tam_uno_popup_formulario"></div>
                  </div>
                  
                  <div class="row">
                  	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tam_dos_popup_formulario">
                      	<div class="row margen_bottom">Equipo Entregado</div>
                          <div class="row over_flou">
                          	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
                              <? for ($c=0; $c<20;$c++)
                              {?>
                                  <div class="row">
                                      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Antena:</div>
                                      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">1</div>
                                  </div>
                              <?php
                              }?>
                              </div>
                              <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"></div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text_negro ">
              	<div class="row margen_bottom">Evidencias</div>
                  <div class="row pading_bottom"><img class="img-responsive" src="http://placehold.it/181x170" alt="Imagen" /></div>
                  <div class="row pading_bottom"><img class="img-responsive" src="http://placehold.it/181x170" alt="Imagen" /></div>
              </div>
          </div>
          
          <div class="row ">
          	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
              <div class="well">
                  <div id="carousel" class="carousel slide">
                      <div class="carousel-inner">
                          <?php
                          $z=12/4;
                          $y="active";
                          for($i=0;$i<3;$i++)
                          { ?>
                            <div class="item <?php echo $y ?>">
                                  <?php for ($a=0;$a<4;$a++){?>
                                    <div class="col-sm-3"><a href="#x"><img src="http://placehold.it/139x100" alt="Image<? echo $i ?>" class="img-responsive"></a>
                                    </div>
                                  <?php } 
                                  $a=0;
                                  $y="";?>
                            </div>
                            
                        <?php
                         } ?>
                      </div>
                      <a class="left carousel-control" href="#carousel" data-slide="prev">‹</a>
                      <a class="right carousel-control" href="#carousel" data-slide="next">›</a>
                  </div>
              </div>    
            </div>     
          </div>
        </div>
      </div>
      <div class="modal-footer fondoo_blanco_total_poppus text_blanco"></div>  