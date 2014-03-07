<?php
require_once 'class.api.php';

class teletecApi extends api{
    protected $User;
	protected $bd;
	public $error;
    public function __construct($request, $origin) {
        parent::__construct($request); 
		$this->bd = new IBD;
        /*
        if (!array_key_exists('apiKey', $this->request)) {
            throw new Exception('No API Key provided');
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            throw new Exception('Invalid API Key');
        } else if (array_key_exists('token', $this->request) &&  !$User->get('token', $this->request['token'])){ 
            throw new Exception('Invalid User Token');
        }
		*/ 
    }
	
	/**
	 * Check Login
	 */
	 protected function login(){
	 	if ($this->method == 'POST'){ 
	 		if (!array_key_exists('usuario', $this->request)) {
	            throw new Exception('No se recibió un nombre de usuario');
	        } else if (!array_key_exists('password', $this->request)) {
	            throw new Exception('No se recibió una contraseña');
	        } 
			$usuario = $this->request['usuario'];
			$pwd	 = $this->request['password']; 
	 		$consulta  = "SELECT * FROM user_app "
                        . " WHERE email ='" . $usuario . "' AND password='" . md5( $pwd ) . "' "; 
			if (($result = $this->bd->Query("Login", $consulta))!= IBD_SUCCESS) {
				throw new Exception('Ocurrió un error al consultar la BD.');
			} 
			if (($result = $this->bd->NumeroRegistros("Login")) < 1 ) {
				$this->bd->Liberar("Login");
				return array('success' => FALSE, 'resp' => "Usuario y/o contraseña inválidos."); 
			}  
			$registro = $this->bd->Fetch("Login");
			if ( !$registro ){
				$this->bd->Liberar("Login");
				return array('success' => FALSE, 'resp' => "Ocurrió un error en la BD."); 
			} 
			$this->User = new stdClass;
			$this->User->id 	= $registro['id'];
			$this->User->email 	= $registro['email'];
			$this->User->perfil	= $registro['type_profile_id'];
			$this->bd->Liberar("Login");
			return array('success' => TRUE, 'resp' => 'OK');
			
	 	} else {
			return array('success' => FALSE, 'resp' =>"ERROR: Utilice POST para hacer Login.");
        }
	 }
}
?>