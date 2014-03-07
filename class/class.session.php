<?php

class MYSESSION {
	var $m_nombre;
	var $m_hash;
	var $m_nivel;
	var $m_email;
	var $m_id;


	function MYSESSION(){
		$this->I_Init();
	}

		function I_Init() {
			global $MyDebug;
			global $facebook;
			$this->m_email = "";
			$this->m_nivel = 0;
			$this->m_id = "";

			if (
				isset($_SESSION['teletec_nombre']) && ($_SESSION['teletec_nombre'] != "") &&
				isset($_SESSION['teletec_perfil']) && ($_SESSION['teletec_perfil'] != "") &&
				isset($_SESSION['teletec_correo']) && ($_SESSION['teletec_correo'] != "") &&
				isset($_SESSION['teletec_id']) && ($_SESSION['teletec_id'] != "")
			) {
                $this->m_nombre = $_SESSION['teletec_nombre'];
				$this->m_nivel 	= $_SESSION['teletec_perfil'];
				$this->m_email 	= $_SESSION['teletec_correo'];
				$this->m_id 	= $_SESSION['teletec_id'];
				$MyDebug->DebugMessage("SESSION::Login:[".$this->m_nivel."][".$this->m_email."][".$this->m_id."]");
				if ( $this->m_nivel == 1 ){
					define('ES_ADMIN', true);
				} else {
					define('ES_ADMIN', false);
				}
			}
		}

		function LoggedIn() {
			return ($this->m_id != "");
		} 
		
        function Nombre() {
            return $this->m_nombre;
        } 
                
		function Nivel() {
			return $this->m_nivel;
		}

		function Email() {
			return $this->m_email;
		}

		function Id() {
			return $this->m_id;
		}

		function SetVar( $varname, $value ) {
			$_SESSION[$varname] = $value;
		}

		function GetVar( $varname ) {
			return ( isset($_SESSION[$varname]) ? $_SESSION[$varname] : "" );
		}


		function EndSession() {
			$_SESSION['teletec_nombre'] = "";
			$_SESSION['teletec_correo'] = "";
			$_SESSION['teletec_id'] 	= "";
			$_SESSION['teletec_perfil'] = 0;
			session_destroy();
			session_start();
			$this->I_Init();
		}

	}

$MySession = new MYSESSION;
?>
