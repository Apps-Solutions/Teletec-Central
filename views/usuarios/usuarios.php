		 
		<script>  
			$(document).ready(function(){ 
		    	$("#usuarios_lst").jqGrid({ 
			        url:'usuarios.php?accion=xml',
			        datatype: "xml", 
			        colNames:['Usuario', 'Nombre', 'Perfil', 'Última Actualización',  'Acciones'], 
			        colModel:[ 
			            {name:'usuario',	index:'usuario', 	width:100,  align:'center'  } ,
			            {name:'nombre',		index:'nombre', 	width:120, 	align:'left' 	} ,
			            {name:'perfil',		index:'perfil', 	width:120, 	align:'left' 	} , 
			            {name:'fecha',		index:'fecha ', 	width:80,  	align:'center', sortable:false },
			            {name:'acciones',	index:'acciones', 	width:100,	align:'center', sortable:false, searchable:false }  
			        ],
			        rowNum:30,
			        width:1000,
			        height: 300,
			        rowList:[30,50,100],
			        pager: '#usuarios_pager',
			        sortname: 'usuario',
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
		
			    jQuery("#usuarios_lst").jqGrid('navGrid','#usuarios_pager',
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
			    if(!confirm("Por favor, confirme que desea eliminar el usuario.")) {
			        return false;
			    }
			} 
			
			function editar_usuario( cual ){
				
				if (cual > 0 ){
					$.ajax({
	                type: "POST",
	                url: "usuarios.php",
	                data: {
	                	id_usuario: 	cual, 
	                    accion: 		'get_info_usuario'
	                }
		            }).done(function(resultado) { 
		                resultado = jQuery.parseJSON(resultado);
		            	if (resultado.success == true){
		            		var usuario = resultado.usuario;  
							$('#inp_usuario').val( usuario.usuario 	);
							$('#inp_nombre'	).val( usuario.nombre 	);
							$('#inp_apellidos').val( usuario.apellidos 	);
							$('#inp_perfil'	).val( usuario.id_perfil);
							$('#inp_password').val('');
							$('#inp_confirmacion').val('');
							
							$('#inp_id_usuario').val(cual);
		            		return true;
		                }else{
		                    alert(resultado.msg);
		                    return false;
						}
					}); 
					
					
				} else { 
					$('#inp_usuario').val('');
					$('#inp_nombre').val('');
					$('#inp_apellidos').val('');
					$('#inp_perfil').val(0);
					$('#inp_password').val('');
					$('#inp_confirmacion').val(''); 
					$('#inp_id_usuario').val(0);
				}
				return ;
			}
		</script>
		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 agustar">
				<h2 class="text_size_18">Usuarios</h2>
			</div>
		</div> 
		<div class="row"> 
			<div class="col-lg-10"></div> 
			<div class="col-lg-2"> 
				<button type="button" class="btn btn-default " data-toggle="modal" data-target=".bs-usuario-modal-lg" onclick="editar_usuario(0);">
					Nuevo Usuario
				</button> 
			</div>
		</div> 
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pading_bottom " align="center" style="margin:30px auto; display:block;width:100%;">  
    			<table id='usuarios_lst' class="scroll"></table> 
    			<div id="usuarios_pager" class="scroll" style="text-align:center;"></div>  
            </div>
        </div>  
   <!--  Modal Pequeño -->
	<div class="modal fade bs-usuario-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-md"> 
			<div class="modal-content"> 
				<div class="modal-header text_blanco_2 "> 
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
					<h4 class="modal-title text_negro" id="myModalLabel">Edición de Usuario</h4>
        		</div>
        		<form id='frm_usuario' name='frm_usuario' method="post" action='usuarios.php'>
				<div class="modal-body pading_20 "> 
					<div class="row"> 
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  text_negro border_pading_conte_nuevo"> 
							<div class="row"> 
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "> 
									<div class="row"> 
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 agustar">Formulario de Usuario</div> 
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tam_espa_uno_user_pop"></div>
									</div> 
									<div class="row "> 
										<div class="col-lg-3 derecha">Usuario<span class="obligatorio"> * </span></div> 
										<div class="col-lg-7"><input type="email" id='inp_usuario' name='inp_usuario' required class="form-control text_nue_user" placeholder="Usuario" value=''>
                                        </div> 
										<div class="col-lg-3"></div> 
									</div> 
									<div class="row">
										<div class="col-lg-3 derecha">Nombre (s)<span class="obligatorio"> * </span></div>
										<div class="col-lg-7"><input type="text"  id='inp_nombre' name='inp_nombre'  required="required" class="form-control text_nue_user" placeholder="Nombre (s)" value=''></div>
										<div class="col-lg-3"></div>   	
									</div>
									<div class="row">
										<div class="col-lg-3 derecha">Apellidos<span class="obligatorio"> * </span></div>
										<div class="col-lg-7"><input type="text"  id='inp_apellidos' name='inp_apellidos'  required="required" class="form-control text_nue_user" placeholder="Apellidos" value=''></div>
										<div class="col-lg-3"></div>   	
									</div>
									<div class="row">
										<div class="col-lg-3 derecha">Perfil<span class="obligatorio"> * </span></div>
										<div class="col-lg-7">
											<select id='inp_perfil' name='inp_perfil'  required="required" class="form-control text_nue_user">
												<option value='0'> -- Elija una opción -- </option>
												<option value='1'> Administrador de Sistema </option>
												<option value='2'> Admin Inventario </option>
												<option value='3'> Supervisor </option>
												<option value='4'> Encuestador </option>
												<option value='5'> Instalador </option>
											</select>
										</div>
										<div class="col-lg-3"></div>   	
									</div>
									<div class="row">
										<div class="col-lg-3 derecha">Contraseña<span class="obligatorio"> * </span></div>
										<div class="col-lg-7"><input type="password" id='inp_password' name='inp_password' required="required" class="form-control text_nue_user" placeholder="Contraseña" value=''></div>
										<div class="col-lg-3"></div>   	
									</div>
									<div class="row">
										<div class="col-lg-3 derecha">Confirmación<span class="obligatorio"> * </span></div>
										<div class="col-lg-7"><input type="password" id='inp_confirmacion' name='inp_confirmacion'  required="required" class="form-control text_nue_user " placeholder="Confirmacion" value=''></div>
										<div class="col-lg-3"></div>   	
									</div> 
								</div>
								<div class="row ">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  tam_texto_11 derecha">
										<input type='hidden' id='accion' name='accion' value='edicion' />
										<input type='hidden' id='inp_id_usuario' name='inp_id_usuario' value='' />
										<span class="obligatorio flotar_derecha">* Obligatorio</span>
									</div>
								</div>
							</div> 
						</div> 
					</div> 
				</div>
				<div class="modal-footer  text_blanco">
					<div class="row">
						<div class=" col-xs-4 col-sm-4 col-md-4 col-lg-4 agustar"><input type="button" class="btn btn-default fondo_gris_degra_total " value=' Cancelar ' data-dismiss="modal" />  </div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 agustar"><input type="reset"  class="btn btn-default fondo_gris_degra_total " value=' Reiniciar ' /> </div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 agustar"><input type="submit" class="btn btn-default fondo_gris_degra_total " value=' Guardar ' /> </div>
					</div>  
				</div> 
				</form>
			</div> 
		</div> 
	</div>
<!-- FIN Modal -->
