<?php
include_once('class.session.php');

/**/ 
class INDEX
{
	var $m_js;
	var $m_content;
	var $m_title;
	var $m_css;
	var $m_ajax;

	function INDEX() {

		$this->m_js         = "";
		$this->m_content    = "";
		$this->m_title      = "";
		$this->m_css        = "";
		$this->m_ajax        = "";

	}

	function Title()
	{
		return $this->m_title;
	}


	function MyPHPFile()
	{
		return $this->m_content;
	}



	function MyJSFile()
	{
		return $this->m_js;
	}

	function MyCSSFile()
	{
		return $this->m_css;
	}

	function MyAjaxFile()
	{
		return $this->m_ajax;
	}
	function MyCommand()
	{
		return $this->m_command;
	}


	function Logic($command)
	{
		global $uiCommand;
        global $MySession;
		
        if(!in_array($MySession->Nivel(),$uiCommand[$command][0])) {
            $command = LOGIN; 
        }

		if($MySession->LoggedIn() && !isset($uiCommand[$command])) {
           $command = LOGIN; 
        }

		$this->m_title      = $uiCommand[$command]['1'];
		$this->m_content    = $uiCommand[$command]['2'];
		$this->m_js         = $uiCommand[$command]['3'];
		$this->m_css        = $uiCommand[$command]['4'];
        $this->m_ajax       = $uiCommand[$command]['5'];
        $this->m_command    = $command;
	}
}

$MyIndex	= new INDEX;
?>