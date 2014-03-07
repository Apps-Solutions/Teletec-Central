<?php

class Correo
{
 	static function Enviar($Asunto, $Direccion, $Texto, $Headers)
	{
		if(!stristr(php_uname(),'Windows'))
		{
 			mail($Direccion,$Asunto,$Texto, $Headers);
		}
		else
		{
			$ServidorSMTP=ini_get('SMTP');
			if($ServidorSMTP==''|| $ServidorSMTP=='localhost')
			{
				try
				{
 					$Mensaje=new COM('CDO.Message');
 					$Mensaje->Configuration->Load(1);
 					$Mensaje->To		=	$Direccion;
 					$Mensaje->Subject	=	$Asunto;
 					$Mensaje->TextBody	=	$Texto;
 					$Mensaje->From		=	$Headers;
 					$Mensaje->Send();
				}
				catch(Exception $e)
				{
 					try
					{
   						$Outlook=new COM('Outlook.Application');
   						$Mensaje=$Outlook->CreateItem(0);
   						$Mensaje->Recipients->Add($Direccion);
   						$Mensaje->Subject	=$Asunto;
 						$Mensaje->Body		=$Texto;
 						$Mensaje->Send();
			  		}
					catch(Exception $e)
					{
   						file_put_contents('Correo.log',implode(",",array(time(),$Direccion,"Imposible enviar correo"))."\n",FILE_APPEND);
 					}
				}
			}
			else
			{
 				mail($Direccion, $Asunto, $Texto,$Headers);
 			}
		}
	}
}

?>