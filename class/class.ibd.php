<?php
 
class IBD
{

	var $m_dbResultados;
	var $m_link;

	function IBD()
	{
		$this->Limpiar();
	}

	function Limpiar()
	{
		$m_link=0;
		$m_dbResultados=array();
	}

	function ConectarBD()
	{
		global $MyDebug;

		$link= mysql_connect(DBCONNECT, DBUSERNAME, DBPASSWORD);

		if (!$link)
		{
			$MyDebug->DebugMessage("IBD::ConectarBD(): No se puede hacer la conexion.");
			return IBD_ERR_CANTCONNECT;
		}

		if(!mysql_select_db(DBNAME, $link))
		{
			$MyDebug->DebugMessage("IBD::ConectarBD(): No se puede Seleccionar la base de datos.");
			return IBD_CANTSELECT;
			mysql_close($link);
		}

		$this->m_link=$link;
		return IBD_SUCCESS;
	}

	function Query($origen, $consulta)
	{
		global $MyDebug; 
		if(($result=$this->ConectarBD())!=IBD_SUCCESS)
		{
			$MyDebug->DebugMessage("IBD::Query(): Fallo en la conexion.");
			return $result;
		} 
		$result= mysql_query($consulta, $this->m_link); 
		if(!$result)
		{
			$MyDebug->DebugMessage("IBD::Query(): Error en la consulta");
			return IBD_ERR_DBUNAVAILABLE;
		} 
		$this->m_dbResultados[$origen]=$result;
		return IBD_SUCCESS;
	}

	function Fetch($origen)
	{
		$dbResultados=$this->m_dbResultados[$origen];

		if($dbResultados)
		{
				return mysql_fetch_array($dbResultados);
		}

		return 0;
	}
	
	function Fetcharray($origen){
		$dbResultados=$this->m_dbResultados[$origen];
		while ($rows = mysql_fetch_assoc($dbResultados)){
			$registros[] = $rows;
		}
		return $registros;
	}

	function  Liberar($origen)
	{
		$dbResultados=$this->m_dbResultados[$origen];

		if($dbResultados)
		{
			mysql_free_result($dbResultados);
			$this->m_dbResultados[$origen]=0;
		}

		return IBD_SUCCESS;
	}

	function NumeroRegistros($origen)
	{
		$dbResultados=$this->m_dbResultados[$origen];

		if($dbResultados)
		{
			return mysql_num_rows($dbResultados);
		}

		return 0;
	}

	function UltimoID()
	{
		if ( ! $this->m_link )
		{
			return 0;
		}
		return mysql_insert_id($this->m_link);
	}
}

$ibd = new IBD;
?>
