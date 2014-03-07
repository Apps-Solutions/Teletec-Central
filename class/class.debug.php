<?php
$MyDebug = new MYDEBUG();

class MYDEBUG
{
	var $m_msg;
	var $m_debugOn;
	
	function MYDEBUG()
	{
		$this->I_Init();
	}
	
	function I_Init()
	{
		$this->m_msg = "";
		$this->m_debugOn = 0;
	}
	
	function DebugMessage( $msg )
	{
		if ( $this->m_debugOn )
		{
			$this->m_msg .= $msg . "<br />";
		}
	}
	
	function DebugEnabled()
	{
		return ($this->m_debugOn ? 1 : 0);
	}

	function SetDebug( $debugOn )
	{
		$this->m_debugOn = $debugOn;
	}
	
	function Dump()
	{
		if ( $this->m_debugOn )
		{
			print("<div class=\"dbgText\">" . $this->m_msg . "</div>");
		}
	}
	
	function DumpArray( $arrayName, $a )
	{
		foreach( $a as $k => $v )
		{
			$this->DebugMessage( "$arrayName.[$k] = [$v]" );
		}
	}
		
		
}
?>
