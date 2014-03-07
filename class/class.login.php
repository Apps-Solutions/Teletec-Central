<?php
	include_once("class.plantilla.php");

	class LOGIN {
		var $m_ibd;
		var $m_user;
		var $m_nombre; 
		var $m_nivel;
		var $m_email;
		var $m_id;
		var $m_plantilla;

		function LOGIN()
		{
			$this->Iniciar();
		}

		function Iniciar()
		{
			$this->m_ibd = new IBD;
			$this->m_plantilla = new Plantilla;
		}
 
		function Usuario()
		{
			return $this->m_user;
		}
                
        function Nombre()
        {
            return $this->m_nombre;
        }
                
		function Nivel()
		{
			return $this->m_nivel;
		}

		function Email()
		{
			return $this->m_email;
		}

		function Id()
		{
			return $this->m_id;
		}

		function LoginE($usuario, $hash) {
			$consulta  = " SELECT us.id_usuario, us.us_correo, CONCAT(us_apaterno, ' ', us_amaterno, ', ', us_nombre) AS nombre, pf.id_perfil, pf.pf_perfil " 
						. " FROM usuario us "
                        	. " INNER JOIN perfil pf ON id_perfil=us_pf_id_perfil "
                        . " WHERE us_correo='$usuario' AND us_password='$hash'";  
			
			if (($result = $this->m_ibd->Query("Login", $consulta))!= IBD_SUCCESS) { 
				return $result;
			} 
			if (($result = $this->m_ibd->NumeroRegistros("Login")) < 1 ) {
				$this->m_ibd->Liberar("Login");
				return LOGIN_BADLOGIN;
			}
 
			$registro = $this->m_ibd->Fetch("Login"); 
			if ( !$registro ) {
				$result = LOGIN_DBFAILURE;
			} 
			else {
				$this->m_nombre = utf8_encode($registro['nombre']);
				$this->m_nivel 	= $registro['id_perfil'];
				$this->m_email 	= $registro['us_correo'];
				$this->m_id 	= $registro['id_usuario'];
				
				session_start();
				$_SESSION['teletec_nombre']	= $this->m_nombre;
				$_SESSION['teletec_perfil']	= $this->m_nivel;
				$_SESSION['teletec_correo']	= $this->m_email;
				$_SESSION['teletec_id']		= $this->m_id; 
				if ( $this->m_nivel == 1 ){
					define('ES_ADMIN', true);
				} else {
					define('ES_ADMIN', false);
				}
				session_write_close();
				
				//$sql = "UPDATE tbl_usuarios set ultimoAcceso='".date('Y-m-d')."' where id='".$this->m_id."'";
				//$this->m_ibd->Query("ultimoacceso", $sql);
 
				$result = LOGIN_SUCCESS;
			}
			$this->m_ibd->Liberar("Login");
			return $result;
		}

		function Forgot($email) {
			$consulta  = "SELECT usr_id "
						. " FROM usuarios WHERE usr_email='$email' and usr_status='1'";

			if (($result = $this->m_ibd->Query("forgot", $consulta))!= IBD_SUCCESS) {
				return $result;
			}

			if (($result = $this->m_ibd->NumeroRegistros("forgot")) < 1 ) {
				$this->m_ibd->Liberar("forgot");
				return LOGIN_BADLOGIN;
			}

			$registro = $this->m_ibd->Fetch("forgot"); 
			if ( !$registro ) {
				$result = LOGIN_DBFAILURE;
			}
			else {
				$password	=	substr(md5(uniqid()),0,10);

				$sql = "UPDATE usuarios set usr_password='".md5($password)."' where usr_id='".$registro['usr_id']."'";
				$this->m_ibd->Query("updatepass", $sql);

				$this->m_plantilla->asigna_variables(array("email" => $email, "password" => $password, "nombre_web" => NOMBRE_WEB, "url_web" => URL_WEB));
				$ContenidoString = $this->m_plantilla->muestra("../templates/mailolvidopass.tpl");

				$headers = "From: ".NOMBRE_WEB."<".MAIL_WEB.">\r\n";
				$headers .= "Reply-To: ".MAIL_WEB."\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
				Correo::Enviar("Recordatorio de contraseña", $email, $ContenidoString,$headers);

				$result = LOGIN_SUCCESS;
			}

			$this->m_ibd->Liberar("forgot");
			return $result;
		}

	}
?>
