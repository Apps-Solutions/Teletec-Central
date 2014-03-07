<?php
require 'init.php';

$accion = isset( $_REQUEST['accion'] ) ?  $_REQUEST['accion']: '';
$respuesta = array('success' => false, 'msg' => '');

switch ( $accion ){
	case 'xml':
		include_once(DIRECTORY_CLASS.'class.listado.php');
		$listado = new Listado('usuarios');
		$listado->acciones = "<a href='#' onclick='consultar_usuario(%ID%);'  data-toggle='modal' data-target='.bs-infousuario-modal-lg' ><img src='gfx/bullet.png' alt='Consultar Usuario' /></a> &nbsp;"
							."<a href='#' onclick='editar_usuario(%ID%);' data-toggle='modal' data-target='.bs-usuario-modal-lg'><img src='gfx/lapiz.png' alt='Editar Usuario' /></a> &nbsp;";
		$listado->imprime();
		die();
		break;
	case 'get_info_usuario':
		include_once(DIRECTORY_CLASS.'class.usuario.php');
		$id_usuario = $_POST['id_usuario'];  
		$usuario = new Usuario($id_usuario); 
		if ( count($usuario->error) == 0 ){
			$respuesta['success'] = TRUE;
			$respuesta['usuario'] = $usuario->get_array();
		} else {
			$respuesta['err'] = $usuario->error[0];
		}
		echo json_encode( $respuesta );
		break;
	case 'edicion': 
		if (ES_ADMIN){
			include_once(DIRECTORY_CLASS.'class.usuario.php');
			$id_usuario = (isset($_POST['inp_id_usuario']) && $_POST['inp_id_usuario'] > 0 ) ? $_POST['inp_id_usuario'] : 0 ; 
			$usuario = new Usuario( $id_usuario );
			$usuario->usuario	=  (isset($_POST['inp_usuario']) && $_POST['inp_usuario'] != '' ) ? $_POST['inp_usuario'] : '' ;
			$usuario->nombre	=  (isset($_POST['inp_nombre'])  && $_POST['inp_nombre']  != '' ) ? $_POST['inp_nombre']  : '' ;
			$usuario->apellidos	=  (isset($_POST['inp_apellidos']) && $_POST['inp_apellidos'] != '' ) ? $_POST['inp_apellidos'] : '' ;
			$usuario->id_perfil	=  (isset($_POST['inp_perfil']) && $_POST['inp_perfil'] > 0  ) ? $_POST['inp_perfil'] : 0;
			
			if ( isset($_POST['inp_password']) && $_POST['inp_password'] != ''  )
				$usuario->set_password($_POST['inp_password']);
			
			if ( count($usuario->error) > 0 ){
				$respuesta['msg'] = $usuario->error[0];
			} else{ 
				$resp = $usuario->guardar();
				if ( $resp === TRUE && count($usuario->error) == 0){
					header('Location: index.php?command=usuarios&msg=' . urlencode( 'El registro se guardó correctamente.'));
				} else {
					header('Location: index.php?command=usuarios&err=' . urlencode( $usuario->error[0] )); 
				} 
			}
		} 
		else {
			header('Location: index.php?msg=' . urlencode( 'Acceso denegado.'));
		} 
		die();
		break; 
	default: 
		echo utf8_decode("Acción inválida.");
		die();
		break;
}
?>