<?php
include_once('class.ibd.php');

$iCONSULTASNextError=200;

define ("CONSULTAS_SUCCESS", 		$iCONSULTASNextError++);
define ("CONSULTAS_ERR_NOROWS", 	$iCONSULTASNextError++);

class CONSULTAS
{
	var $m_ibd;
	var $m_key;

	function CONSULTAS()
	{
		$this->Iniciar();
	}

	function Iniciar()
	{
		$this->m_ibd = new IBD;
	}

	function AgregarRegistro($tabla, $nvoregistro)
	{
		global $MyDebug;

		$sql = "INSERT INTO $tabla (".implode(', ', array_keys($nvoregistro)).") VALUES ('".implode('\', \'', $nvoregistro)."')";

                   // echo $sql;

		if (($result = $this->m_ibd->Query(time(), $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::AgregarRegistro($sql): Fallo [$result]");
			return $result;
		}

		$MyDebug->DebugMessage("CONSULTAS::AgregarRegistro($sql): Proceso Satisfactorio");
		return CONSULTAS_SUCCESS;
	}

	function ActualizarRegistro($tabla, $nvoregistro, $condiciones)
	{
		global $MyDebug;

		foreach ($nvoregistro as $llave => $valor )
		{
			$nvoregistroDB .= "$llave=$valor, ";
		}

		$nvoregistroDB = substr($nvoregistroDB, 0, -2);

		foreach ($condiciones as $llave => $valor)
		{

			$condicionesDB .= "$llave='$valor' and ";
		}


		$condicionesDB = substr($condicionesDB, 0, -5);

		$sql = "UPDATE $tabla SET $nvoregistroDB WHERE $condicionesDB";


                    echo $sql;

		if (($result = $this->m_ibd->Query(time(), $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::ActualizarRegistro($sql): Fallo [$result]");
			return $result;
		}

		$MyDebug->DebugMessage("CONSULTAS::ActualizarRegistro($qsl): Proceso Satisfactorio");

		return CONSULTAS_SUCCESS;
	}

	function EliminarRegistro($tabla, $condiciones)
	{
		global $MyDebug;

		foreach ($condiciones as $llave => $valor)
		{
			$condicionesDB .= "$llave='$valor' and ";
		}

		$condicionesDB = substr($condicionesDB, 0, -5);

		$sql = "DELETE FROM $tabla WHERE $condicionesDB";

		if (($result=$this->m_ibd->Query(time(), $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::EliminarRegistro($sql): Fallo [$result]");
			return $result;
		}

		$MyDebug->DebugMessage("CONSULTAS::EliminarRegistro($sql): Proceso Satisfactorio");

		return CONSULTAS_SUCCESS;
	}

	function SeleccionarTodo($tabla, $campos, $group, $order)
	{
		global $MyDebug;


		$sql = "SELECT  ".implode(', ',$campos)." FROM $tabla ";

		if(!empty($orden))
		{
			$sql .= "GROUP BY $group ";
		}

		if(!empty($order))
		{
			$sql .= " ORDER BY $order ";
		}
		$key = time();
		if(($result=$this->m_ibd->Query($key, $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::SeleccionarTodo($sql): Fallo [$result]");
			return $result;
		}

		if(($result=$this->m_ibd->NumeroRegistros($key)) < 1)
		{
			$MyDebug->DebugMessage("CONSULTAS::SeleccionarTodo($sql): Fallo [$result] registros");
			$this->m_ibd->Liberar($key);
			return CONSULTAS_ERR_NOROWS;
		}

		$this->m_key=$key;
		$MyDebug->DebugMessage("CONSULTAS::SeleccionarTodo($sql): Proceso Satisfactorio");
		return CONSULTAS_SUCCESS;
	}

	function SeleccionarTablaFila($tabla, $campos, $condiciones, $group, $order)
	{
		global $MyDebug;

		foreach ($condiciones as $llave => $valor)
		{
			$condicionesDB .= "$llave='$valor' and ";
		}

		$condicionesDB = substr($condicionesDB, 0, -5);

		$sql = "SELECT ".implode(', ',$campos)." FROM $tabla WHERE $condicionesDB ";

                    //echo $sql;

		if(!empty($group))
		{
			$sql .= "GROUP BY $group ";
		}
		if(!empty($order))
		{
			$sql .= "ORDER BY $order";
		}

		$key = time();

		if(($result=$this->m_ibd->Query($key, $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::SeleccionarTablaFila($sql): Fallo [$result]");
			return $result;
		}

		if(($result=$this->m_ibd->NumeroRegistros($key)) <1 )
		{
			$MyDebug->DebugMessage("CONSULTAS::SeleccionarTablaFila($sql): Fallo [$result] registros");
			$this->m_ibd->Liberar($key);
			return CONSULTAS_ERR_NOROWS;
		}
		$this->m_key=$key;
		$MyDebug->DebugMessage("CONSULTAS::SeleccionarTablaFila($sql): Proceso Satisfactorio");
		return CONSULTAS_SUCCESS;
	}



	function BuscarTexto($tabla, $campos, $condiciones, $group, $order)
	{
		global $MyDebug;


		foreach ($condiciones as $llave => $valor)
		{
			$condicionDB .= "$llave like '%$valor%' or ";
		}

		$condicionDB = substr($condicionDB, 0, -4);

		$sql = "SELECT ".implode(', ',$campos)." FROM $tabla WHERE $condicionDB ";

		if(!empty($group))
		{
			$sql .= "GROUP BY $group ";
		}

		if(!empty($order))
		{
			$sql .= "ORDER BY $order";
		}

		$key = time();

		if(($result = $this->m_ibd->Query($key, $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::BuscarTexto($sql): Fallo [$result]");
			return $result;
		}

		if(($result = $this->m_ibd->NumeroRegistros($key)) <1 )
		{
			$this->m_ibd->Liberar($key);
			$MyDebug->DebugMessage("CONSULTAS::BuscarTexto($sql): Fallo [$result] registros");
			return CONSULTAS_ERR_NOROWS;
		}

		$this->m_key=$key;
		$MyDebug->DebugMessage("CONSULTAS::BuscarTexto($sql): Proceso Satisfactorio");
		return CONSULTAS_SUCCESS;
	}

	function QueryINNERJOIN($inner, $campos, $condicion, $group, $order )
	{
		global $MyDebug;


		foreach ($condicion as $llave => $valor)
		{
			$condicionDB .= "$llave='$valor' and ";
		}

		$condicionDB = substr($condicionDB, 0, -5);

		foreach ($inner as $llave => $valor)
		{
			list($table1, $table2) = explode(":", $llave);
			$innerDB .= "$table1 INNER JOIN $table2 ON $valor ";
		}

		$innerDB = substr($innerDB, 0, -1);

		$sql = "SELECT ".implode(', ',$campos)." FROM $innerDB WHERE $condicionDB ";

		if(!empty($group))
		{
			$sql .= "GROUP BY $group ";
		}

		if(!empty($order))
		{
			$sql .= "ORDER BY $order";
		}
  //echo $sql;
		$key = time();
		if(($result = $this->m_ibd->Query($key, $sql)) != IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("CONSULTAS::QueryINNERJOIN($sql): Fallo [$result]");
			return $result;
		}

		if(($result=$this->m_ibd->NumeroRegistros($key)) < 1 )
		{
			$this->m_ibd->Liberar($key);
			$MyDebug->DebugMessage("CONSULTAS::QueryINNERJOIN($sql): Fallo [$result] registros");
			return CONSULTAS_ERR_NOROWS;
		}

		$this->m_key=$key;
		$MyDebug->DebugMessage("CONSULTAS::QueryINNERJOIN($sql): Proceso Satisfactorio");
		return CONSULTAS_SUCCESS;
	}

	function Fetch()
	{
		global $MyDebug;

		if ( ! $this->m_key )
		{
			$MyDebug->DebugMessage("CONSULTAS::Fetch(): Null key.");
			return 0;
		}

		if ( ! $this->m_ibd )
		{
			$MyDebug->DebugMessage("CONSULTAS::Fetch(): Null IBD");
			return 0;
		}

		return $this->m_ibd->Fetch( $this->m_key );

	}

	function NumeroRegistros()
	{
		global $MyDebug;

		if ( ! $this->m_key )
		{
			$MyDebug->DebugMessage("CONSULTAS::NumeroRegistros(): Null key.");
			return 0;
		}

		if ( ! $this->m_ibd )
		{
			$MyDebug->DebugMessage("CONSULTAS::NumeroRegistros(): Null IBD");
			return 0;
		}

		return $this->m_ibd->NumeroRegistros($this->m_key);
	}

	function Free()
	{
		global $MyDebug;

		if ( ! $this->m_key )
		{
			$MyDebug->DebugMessage("CONSULTAS::Free(): Null key.");
			return 0;
		}

		if ( ! $this->m_ibd )
		{
			$MyDebug->DebugMessage("CONSULTAS::Free(): Null IBD");
			return 0;
		}

		$this->m_ibd->Liberar( $this->m_key );
		$this->Iniciar();
		return CONSULTAS_SUCCESS;
	}

	function UltimoID()
	{
		if ( ! $this->m_ibd )
		{
			return 0;
		}
		return $this->m_ibd->UltimoID();
	}


	function NuevaConsulta()
	{
		global $MyDebug;

		if ( ! $this->m_key )
		{
			$MyDebug->DebugMessage("CONSULTAS::NuevaConsulta(): Null key.");
			return 0;
		}

		if ( ! $this->m_ibd )
		{
			$MyDebug->DebugMessage("CONSULTAS::NuevaConsulta(): Null IBD");
			return 0;
		}

		$this->m_ibd->Liberar( $this->m_key );
		$this->m_key = 0;
		return CONSULTAS_SUCCESS;
	}
}

$consultas	= new CONSULTAS;
?>
