<?php
$error = 200;
define(REGISTRO_SUCCESS, 	$error++);
define(REGISTRO_ERROR, 		$error++);
		
abstract class   objectOperations
{
	protected $m_total;
        protected $m_result;
	protected $m_ultimoID;
        protected $m_consultas;
        protected $m_row;
        
	function objectOperations()
	{
		$this->m_total		= 0;
		$this->m_consultas	= new CONSULTAS;
                $this->m_results	= array();
                $this->m_row            = 0;
                $this->m_ultimoId       = 0;
                
	}
        
      
	
	function getTotal()
	{
		return $this->m_total;	
	}
	function getUltimoID()
	{
		return $this->m_ultimoID;	
	}
	function getColeccion($page,$tampag,$grupo,$orden,$tabla,$campos,$condiciones=array())
	{
		
                if(empty($orden))
                {
                    return REGISTRO_ERROR;
                }
		if(!is_array($campos) || empty($campos))
                {
                    return REGISTRO_ERROR;
                }
		if(!is_array($condiciones) || empty($condiciones))
                {
                    $condiciones=array("1" => "1");
                         
                }
                if(empty($tabla))
                {
                    return REGISTRO_ERROR;
                }
                if(is_array($tabla))
                {
                    $query = 'QueryINNERJOIN';
                }
                else
                {
                    $query = 'SeleccionarTablaFila';
                }
                
               
                
                $reg1 = ($page-1) * $tampag;
		$this->m_row = 0;
		$this->m_consultas->NuevaConsulta();
		
            
                
		$this->m_consultas->$query($tabla,$campos,$condiciones, $grupo,$orden);
		
                $this->m_total = $this->m_consultas->NumeroRegistros();
		
		$result = $this->m_consultas->$query($tabla,$campos,$condiciones, $grupo,$orden." LIMIT $reg1, ".$tampag);
		
                
		
                if($result == CONSULTAS_SUCCESS)
		{
                        $n = 0;
			while($registro = $this->m_consultas->Fetch())
			{
                            foreach($campos as $campo)
                            {
                               if(preg_match("/\./", $campo))
                               {
                                   $c = explode(".",$campo);
                                   $campo = $c[count($c)-1];
                               }
                               $this->m_result[$n][$campo]            =	$registro[$campo];
                            }
                            $n++;
			}
		}
		else
 		{
			$this->m_total = 0;			
			return REGISTRO_ERROR;
		}
 
		return REGISTRO_SUCCESS;
	}
	

	
	function eliminarRegistro($tabla,$condiciones)
	{
                if(empty($tabla) || is_array($tabla))
                {
                    return REGISTRO_ERROR;
                
                }
                if(!is_array($condiciones) && empty($condiciones))
                {
                    return REGISTRO_ERROR;
                }
            
		if($this->m_consultas->EliminarRegistro($tabla, $condiciones) != CONSULTAS_SUCCESS)
		{
   			return REGISTRO_ERROR;
		}
		return REGISTRO_SUCCESS;
	}
	
	function guardarRegistro($tabla,$nvoregistro)
	{
            if(empty($tabla) || is_array($tabla))
            {
                return REGISTRO_ERROR;
            }
            if(!is_array($nvoregistro) && empty($nvoregistro))
            {
                return REGISTRO_ERROR;
            }
            if($this->m_consultas->AgregarRegistro($tabla, $nvoregistro) != CONSULTAS_SUCCESS)
            {
                return REGISTRO_ERROR;
            }
		
            $this->m_ultimoID = $this->m_consultas->UltimoID();
            
            return REGISTRO_SUCCESS;
	}
	
	function editarRegistro($tabla,$nvoregistro,$condiciones)
	{
            if(empty($tabla) || is_array($tabla))
            {
               
                return REGISTRO_ERROR;
            }
            if(!is_array($condiciones) && empty($condiciones))
            {
                return REGISTRO_ERROR;
            }
            if(!is_array($nvoregistro) && empty($nvoregistro))
            {
                return REGISTRO_ERROR;
            }
          
            if($this->m_consultas->ActualizarRegistro($tabla, $nvoregistro, $condiciones) != CONSULTAS_SUCCESS)
            {
            	return REGISTRO_ERROR;
            }

            return REGISTRO_SUCCESS;
	}
        
        function getRows()
        {
            if(isset($this->m_result[$this->m_row]))
            {
                $row = $this->m_result[$this->m_row];
                $this->m_row++;
                
                return $row;
            }
            else
            {
                return false;
            }
            
        }
}

?>