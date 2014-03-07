<?php

/**
 * Usuario class
 * @package Teletec
 * @author Manuel Fernández 
*/
class Usuario {

	public $id_usuario;
    public $usuario;
    public $nombre;
    public $apellidos;
    public $apaterno;
    public $amaterno;
    public $nombre_completo;
    public $id_perfil;
    public $perfil;
	
	public $error;
	
	private $password;
    private $bd;  
	/**
	* Creates an object from a specific database record or a new one
	* @param integer $id_usuario
	*/
	function Usuario( $id_usuario = 0 ){
		$this->bd = new IBD;
		 
		$this->error = array();
		if( $id_usuario > 0 ) {
			$this->id_usuario = $id_usuario;
			$query = " SELECT * FROM usuario "
						. " INNER JOIN perfil ON id_perfil = us_pf_id_perfil "  
					. " WHERE id_usuario = " . $this->id_usuario . " " ; 
			if (($result = $this->bd->Query("Usuario", $query))!= IBD_SUCCESS) {
				$this->limpiar(); 
				$this->error[] = "Ocurrió un error al consultar la BD. "; 
			} 
			else {
				
			}
			if (($result = $this->bd->NumeroRegistros("Usuario")) < 1 ) {
				$this->limpiar();
				$this->error[] = "No se encontró el registro. "; 
			}
			else { 
				$usuario = $this->bd->Fetch("Usuario"); 
				if ( !$usuario ) {
					$this->error[] = "Ocurrió un error en la BD al obtener el registro. "; 
				}  else { 
					$this->id_usuario 	= stripslashes( $usuario['id_usuario'] );
					$this->usuario	 	= stripslashes( $usuario['us_correo'] );
					$this->nombre 		= stripslashes( $usuario['us_nombre'] );
					$this->apellidos	= stripslashes( $usuario['us_apaterno'] . " " . $usuario['us_amaterno'] );
					$this->id_perfil	= stripslashes( $usuario['id_perfil'] );
					$this->perfil	 	= stripslashes( $usuario['pf_perfil'] );  
				}
			}
			$this->bd->Liberar("Usuario");
		}
		else  {
			// Creating a new record
			$this->limpiar();
		}
	} 

	/**
	* Inserts or updates the selected record
	* @return boolean
	*/
	public function guardar(){
		if (ES_ADMIN){
			$this->valida_datos(); 
			if (count($this->error) > 0 ){
				return FALSE;
			} 
			if ($this->id_usuario > 0) {
				$sql = "UPDATE usuario SET  
							us_nombre 		=  '" . mysql_real_escape_string(strip_tags($this->nombre)) . "',
							us_apaterno		=  '" . mysql_real_escape_string(strip_tags($this->apellidos)) . "',
							us_pf_id_perfil =  '" . mysql_real_escape_string(strip_tags($this->id_perfil)) . "',
							us_correo 		=  '" . mysql_real_escape_string(strip_tags($this->usuario)) . "',"
						. (( $this->password != '') ? "us_password = '" .  $this->password . "' " : " ")	
						. " us_timestamp 	= " . time() . "
						WHERE id_usuario 	= " . $this->id_usuario . "; ";
			}
			else {
				$sql = "INSERT INTO usuario
							( us_correo, us_nombre, us_apaterno, us_pf_id_perfil, us_password, us_timestamp )
						VALUES ( " 
							. "'" . mysql_real_escape_string(strip_tags($this->usuario)) 	. "', "
							. "'" . mysql_real_escape_string(strip_tags($this->nombre)) 	. "', "
							. "'" . mysql_real_escape_string(strip_tags($this->apellidos)) 	. "', "
							. "'" . mysql_real_escape_string(strip_tags($this->id_perfil)) 	. "', "
							. "'" . mysql_real_escape_string(strip_tags($this->password)) 	. "', "
							. "'" . time() . "' " 
						. " ); "; 
			}
			
			if (($result = $this->bd->Query("SV_USUARIO", $sql))!= IBD_SUCCESS) {
				$this->error[] = "Ocurrió un error al guardar la información. ";
				return FALSE;
			}
			else{
				if ($this->id_usuario == 0)
					$this->id_usuario = $this->bd->UltimoID(); 
				$this->bd->Liberar("SV_USUARIO");
				return TRUE; 
			}
		} 
	}  
	  
	public function borrar( ){
		if ($this->id_usuario > 1){  
			//$query = "UPDATE tausuario SET FISTATUS = 0 WHERE FIIDUSUARIO = " . $this->id_usuario . " ";
			$query = "DELETE FROM usuario WHERE id_usuario = " . $this->id_usuario;
			if (($result = $this->bd->Query("DL_USUARIO", $consulta))!= IBD_SUCCESS) {
				$this->error[] = "Ocurrió un error al guardar la información. ";
				return FALSE;
			}
			$this->bd->Liberar("DL_USUARIO");
			return TRUE;
		}
	}
	
	public function valida_datos(){
		if ( $this->usuario == '' ){
			$this->error[] = "Usuario inválido."; 
		}
		if ( $this->nombre == '' ){
			$this->error[] = "Nombre inválido."; 
		}
		if ( $this->apellidos == '' ){
			$this->error[] = "Apellidos inválido.";
		}
		if ( !$this->id_perfil > 0 ){
			$this->error[] = "Perfil inválido.";
		}
		
		if ( $this->id_usuario == 0 && $this->password == ''){
			$this->error[] = "Password inválido.";
		}
			
		if ( count( $this->error ) > 0 ) return FALSE; 
		else return TRUE;
	}
	
	public function set_password( $pwd ){
		if ( $pwd != '' ){
			$this->password = md5( trim($pwd) );
		} else {
			$this->error[] = "Password inválido.";
		}
	}
	
	public function get_array(){
		if ($this->id_usuario > 0){
			return array(
				'id_usuario'	=> $this->id_usuario,
				'usuario' 		=> $this->usuario,
				'nombre' 		=> $this->nombre,
				'apellidos' 	=> $this->apellidos,
				'id_perfil' 	=> $this->id_perfil,
				'perfil'	 	=> $this->perfil
			);
		}  
	}
	
	
	public function limpiar(){
		$this->id_usuario	= 0;
		$this->usuario 		= ""; 
		$this->nombre 		= ""; 
		$this->apellidos 	= ""; 
		$this->apaterno 	= ""; 
		$this->amaterno 	= ""; 
		$this->id_perfil 	= 0; 
		$this->perfil	 	= ""; 
		$this->nombre_completo 	= ""; 
		
		$this->error = array();
	} 	
} # class Usuario

?>