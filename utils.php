<?php
$method = strtolower($_SERVER['REQUEST_METHOD']);
$http_vars = array();
	switch($method)
	{
		case 'get':
			$CONTEXT =& $_GET;
			$http_vars = ""; //$HTTP_GET_VARS;
			break;
		case 'post':
			$CONTEXT =& $_POST;
			$http_vars = ""; //$HTTP_GET_VARS;
			break;
		default:
			$CONTEXT = array();
			break;
	}

function Sanitizacion($var){
	$var = htmlspecialchars ($var,ENT_NOQUOTES); 
	if(!get_magic_quotes_gpc()) {
		 $var  = addslashes($var); 
	}
	return utf8_decode($var);
}


$_Months = Array ('01'=>"Ene",
                '02'=>"Feb",
                '03'=>"Mar",
                '04'=>"Abr",
                '05'=>"May",
                '06'=>"Jun",
                '07'=>"Jul",
                '08'=>"Ago",
                '09'=>"Sep",
                '10'=>"Oct",
                '11'=>"Nov",
                '12'=>"Dic");



$months = Array (1=>"Ene",
                 2=>"Feb",
                 3=>"Mar",
                 4=>"Abr",
                 5=>"May",
                 6=>"Jun",
                 7=>"Jul",
                 8=>"Ago",
                 9=>"Sep",
                10=>"Oct",
                11=>"Nov",
                12=>"Dic");




$_Monthsre = Array ("Enero"=>1,
                 "Febrero"=>2,
                 "Marzo"=>3,
                 "Abril"=>4,
                 "Mayo"=>5,
                 "Junio"=>6,
                 "Julio"=>7,
                 "Agosto"=>8,
                 "Septiembre"=>9,
                "Octubre"=>10,
                "Noviembre"=>11,
                "Diciembre"=>12);


$_MonthsE = Array ('01'=>"Enero",
                '02'=>"Febrero",
                '03'=>"Marzo",
                '04'=>"Abril",
                '05'=>"Mayo",
                '06'=>"Junio",
                '07'=>"Julio",
                '08'=>"Agosto",
                '09'=>"Septiembre",
                '10'=>"Octubre",
                '11'=>"Noviembre",
                '12'=>"Diciembre");

$_MonthsE2S = array(
    "january" => "enero",
    "february" => "febrero",
    "march" => "marzo",
    "april" => "abril",
    "may" => "mayo",
    "june" => "junio",
    "july" => "julio",
    "august" => "agosto",
    "september" => "septiembre",
    "october" => "octubre",
    "november" => "noviembre",
    "december" => "diciembre"

);


function SelectComidas($establecimiento,$id, $caption, $value, $extra="", $type="interface")
{
    
	global $MyQuerys;
	$campos = array("id", "nombre_es", "amigable");
	$condicion = array ('status' => '1', "idtipoestablecimiento" => $establecimiento); 
        
   	$html .= "<select name='$id' id='$id' $extra>";
	if(!empty($caption)) {
		$html .= "<option value=''>$caption</option>";
	}
 
	if($MyQuerys->SeleccionarFila("comida_tipos", $campos, $condicion, "", "nombre_es") == CONSULTAS_SUCCESS)
	{
		while($registro = $MyQuerys->Fetch())
		{
			$_id = ($type == "interface" ? $registro["amigable"] : $registro['id']);
			$name=($registro['nombre_es']);
                        
			$comidas[strtr(utf8_decode($name),'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY')] = $_id; 
            $_names[strtr(utf8_decode($name),'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY')] = utf8_encode($name);
		}
        $comidas["Bares"] = "bares-y-antros";
        $_names["Bares"] = "Bares y antros   >>>";
        $comidas["Fast-Food"] = "comida-rapida";
        $_names["Fast-Food"] = "Comida rapida   >>>";
        ksort($comidas);
        foreach($comidas as $name=> $_id) {
			$html .="<option value='".$_id."'";
			if($value==$_id) {
				$html .= " selected='selected'";
			}
			$html .= ">".$_names[$name]."</option>";
		}
		$html .= "<option value='otros-lugares' ".($value == "otros-lugares" ? "selected='selected'" : "").">Otros lugares   >>></option>";
	}
	$html .= "</select>";
	return ($html);
}

function SelectZonas($id, $caption, $value, $extra="",  $type="interface")
{
	global $MyQuerys;
	$campos 	= array("id", "nombre", "amigable");
	$condicion 	= array ('status' => '1');
	$html .= "<select name='$id' id='$id' $extra>";

	if(!empty($caption))
	{
		$html .= "<option value=''>$caption</option>";
	}

	if($MyQuerys->SeleccionarFila("zonas", $campos, $condicion, "", "nombre") == CONSULTAS_SUCCESS)
	{
		while($registro = $MyQuerys->Fetch())
		{
                    $_id = ($type == "interface" ? $registro["amigable"] : $registro['id']);
			$html .= "<option value='".$_id."'";
			if($value==$_id)
			{
				$html .= " selected='selected'";
			}
			$html .= ">".utf8_encode($registro['nombre'])."</option>";
		}
	}
	$html .= "</select>";
	return ($html);
}


//Estados

function SelectEstados($id, $caption, $value, $extra="",  $type="")
{
	global $MyQuerys;
	$campos = array("id", "nombre");
	$condicion = array ('1' => '1');
	$html .= "<select name='$id' id='$id' $extra>";

	if(!empty($caption))
	{
		$html .= "<option value=''>$caption</option>";
	}

	if($MyQuerys->SeleccionarFila("estados", $campos, $condicion, "", "nombre") == CONSULTAS_SUCCESS)
	{
		while($registro = $MyQuerys->Fetch())
		{
                    $_id = ($type == "interface" ? $registro["amigable"] : $registro['id']);
                    
			$html .= "<option value='".$_id."'";
			if($value==$_id)
			{
				$html .= " selected='selected'";
			}
			$html .= ">".utf8_encode($registro['nombre'])."</option>";
		}
	}
	$html .= "</select>";
	return ($html);
}

function IP_REAL()
{

	if (isset($_SERVER))
	{
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$ip = Sanitizacion($_SERVER["HTTP_X_FORWARDED_FOR"]);
		elseif (isset($_SERVER["HTTP_CLIENT_IP"]))
			$ip = Sanitizacion($_SERVER["HTTP_CLIENT_IP"]);
		else
		$ip = Sanitizacion($_SERVER["REMOTE_ADDR"]);
	}
	else
	{
		if (getenv('HTTP_X_FORWARDED_FOR'))
		$ip = Sanitizacion(getenv('HTTP_X_FORWARDED_FOR'));
		elseif (getenv('HTTP_CLIENT_IP'))
			$ip = Sanitizacion(getenv('HTTP_CLIENT_IP'));
		else
		$ip = Sanitizacion(getenv('REMOTE_ADDR'));
	}

	return $ip;
}
function LimitePalabras($limit,$txt)
{

    $contador = 0;
    $arrayTexto = split(' ',$txt);
    $newtxt = '';

    while($limit >= strlen($newtxt) + strlen($arrayTexto[$contador]) && isset($arrayTexto[$contador]))
    {
        
        $newtxt .= ' '.$arrayTexto[$contador];
    	$contador++;
    }
    return $newtxt;

}
function InterpreteIntHours($i)
{
    $n=1;
    for($x=1 ; $x<=12; $x++)
    {
	if($x==1)
	{
        	$hora= abs($x-13);
	}
	else
	{
		$hora= abs($x-1);
	}
	if($n==$i)
        {
                return $hora.":00";
        }
        ++$n;
	if($n==$i)
        {
                return $hora.":30";
        }
	$n++;
    }
}

function makeHTMLPaginar($numrows1, $maxPage, $terminamosconel,$paginanum, $seccion, $caption)
{

	if ($terminamosconel >= $numrows1)
	{
		$terminamoscon = $numrows1;
	}
	else
	{
		$terminamoscon = $terminamosconel;
	}
	$empezamoscon = $terminamosconel - 9;

	if ($paginanum > 1)
	{
		$page = $paginanum - 1;

                $prev = '<span>
                        <a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');">
                            <img class="img_middle" src="/images/flecha-atras.jpg" width="22" height="16" alt="icono-queremos-tomar"  />
                            </a>
                    </span><a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');"> Anterior</a>';
        }

	else
	{
		$prev  = '';
	}

	if ($paginanum < $maxPage)
	{
		$page = $paginanum + 1;

                $next = '<a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');"> Siguiente</a><span><a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');">
                <img class="img_middle" src="/images/flecha-siguiente.jpg"  width="22" height="16" alt="icono-queremos-tomar"  /></a>
                </span>';

	}
	else
	{
		$next = '';
	}


	$html .= "<div class=\"texto-siguiente\">".$prev."  $empezamoscon - $terminamoscon (de $numrows1 $caption) ".$next."</div>";
	return $html;
}



 function makeHTMLPaginar50($numrows1, $maxPage, $terminamosconel,$paginanum, $seccion, $caption)
{

	if ($terminamosconel >= $numrows1)
	{
		$terminamoscon = $numrows1;
	}
	else
	{
		$terminamoscon = $terminamosconel;
	}
	$empezamoscon = $terminamosconel - 49;

	if ($paginanum > 1)
	{
		$page = $paginanum - 1;

                $prev = '<span class="conte-flecha-siguiente">
                        <a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');">
                            <img class="img_middle" src="/images/flecha-atras.jpg" width="22" height="16" alt="icono-queremos-tomar"  />
                            </a>
                    <a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');"> Anterior</a></span>';
        }

	else
	{
		$prev  = '';
	}

	if ($paginanum < $maxPage)
	{
		$page = $paginanum + 1;

                $next = '<span class="conte-flecha-siguiente"><a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');"> Siguiente</a><a href="javascript: FuncPaginar(\''.$page.'\',\''.$seccion.'\');">
                <img class="img_middle" src="/images/flecha-siguiente.jpg"  width="22" height="16" alt="icono-queremos-tomar"  /></a>
                </span>';

	}
	else
	{
		$next = '';
	}


	$html .= "<span class=\"texto-siguiente\"><span class=\"conte-texto-siguiente\">".$prev."  $empezamoscon - $terminamoscon (de $numrows1 $caption) ".$next." </span> </span>";
	return $html;
}



function makeHTMLPaginarNorm($numrows1, $maxPage, $terminamosconel,$paginanum, $caption,$tampag='10')
{

	if ($terminamosconel >= $numrows1)
	{
		$terminamoscon = $numrows1;
	}
	else
	{
		$terminamoscon = $terminamosconel;
	}
	$empezamoscon = $terminamosconel - ($tampag-1);

	if ($paginanum > 1)
	{
		$page = $paginanum - 1;
		$prev = " <a href=\"javascript: PaginarSimple($page);\">";
		$prev .= "<img class='img_middle' src='/images/atras.gif' width='24' height='18' align='absmiddle' border='0'/>  Anterior</a> ";
	}
	else
	{
		$prev  = '';
	}

	if ($paginanum < $maxPage)
	{
		$page = $paginanum + 1;
		$next = " <a href=\"javascript: PaginarSimple($page);\"> ";
		$next .= "Siguiente <img class='img_middle' src='/images/siguiente.gif' width='24' height='18' align='absmiddle' border='0'/></a> ";
	}
	else
	{
		$next = '';
	}


	$html .= "<div class='col_560'><span class='bsnaviresult'>".$first.$prev."  $empezamoscon - $terminamoscon (de $numrows1 $caption) ".$next.$last."</span></div>";
	return $html;
}


function makeHTMLPaginarMarco($numrows1, $maxPage, $terminamosconel,$paginanum)
{

	global $_Strings;
	if ($terminamosconel >= $numrows1)
	{
		$terminamoscon = $numrows1;
	}
	else
	{
		$terminamoscon = $terminamosconel;
	}
	$empezamoscon = $terminamosconel - 9;
	$html .= "<span class='resultadocount'>$empezamoscon ".$_Strings["a"]." $terminamoscon ".$_Strings["De"]." $numrows1</span>";
	return $html;
}


function getAcentos($text)
{
	$caracteres = array("ACUTE;" => "acute;","TILDE;" => "tilde;","EXCL;" => "excl;","GRAVE;" => "grave;");

	foreach($caracteres as $key => $value)
	{
		$text = str_replace($key,$value,$text);
	}
	return $text;
}

function calif_opina($total_cal)
{
	if ($total_cal >= 5.0)
	{
		$total_cal= 5.0;
	}
	if ($total_cal <= 0)
	{
		$total_cal= 0;
	}

	for($x=1; $x <= 5; $x++)
	{

		if($total_cal >= 1)
		{
			$html .= "<img src='/images/naranja.png' alt='Queremoscomer.com La guia de Restauarntes, 2 Puntos' width='24' height='24' />";
			$total_cal--;
		}
		elseif($total_cal >.5 && $total_cal < 1)
		{
			$html .= "<img src='/images/naranja.png' alt='Queremoscomer.com La guia de Restauarntes, 2 Puntos' width='24' height='24' />";
			$total_cal = 0;
		}
		elseif($total_cal == .5)
		{
			$html .= "<img src='/images/media.png' alt='Queremoscomer.com La guia de Restauarntes, Un Punto' width='24' height='24' />";
			$total_cal = 0;
		}
		elseif($total_cal > 0 && $total_cal < .6)
		{
			$html .= "<img src='/images/gris.png' alt='Queremoscomer.com La guia de Restauarntes, Un Punto' width='24' height='24' />";
			$total_cal = 0;
		}
		elseif($total_cal <= 0)
		{
			$html .= "<img src='/images/gris.png' alt='Queremoscomer.com La guia de Restauarntes, Estrella nula' width='24' height='24' />";
		}

	}

	return $html;
}
function califopinaBuscadores($total_cal)
{
	if ($total_cal >= 5.0)
	{
		$total_cal= 5.0;
	}
	if ($total_cal <= 0)
	{
		$total_cal= 0;
	}

	for($x=1; $x <= 5; $x++)
	{

		if($total_cal >= 1)
		{
			$html .= "<img src='/images/naranja.png' alt='Queremoscomer.com La guia de Restauarntes, 2 Puntos' width='17' height='17' />";
			$total_cal--;
		}
		elseif($total_cal >.5 && $total_cal < 1)
		{
			$html .= "<img src='/images/naranja.png' alt='Queremoscomer.com La guia de Restauarntes, 2 Puntos' width='17' height='17' />";
			$total_cal = 0;
		}
		elseif($total_cal == .5)
		{
			$html .= "<img src='/images/media.png' alt='Queremoscomer.com La guia de Restauarntes, Un Punto' width='17' height='17' />";
			$total_cal = 0;
		}
		elseif($total_cal > 0 && $total_cal < .6)
		{
			$html .= "<img src='/images/gris.png' alt='Queremoscomer.com La guia de Restauarntes, Un Punto' width='17' height='17' />";
			$total_cal = 0;
		}
		elseif($total_cal <= 0)
		{
			$html .= "<img src='/images/gris.png' alt='Queremoscomer.com La guia de Restauarntes, Estrella nula' width='17' height='17' />";
		}

	}

	return $html;
}




function SeciconEditorial($idSeccion)
{
	switch($idSeccion)
	{
		case 1:
			$idSeccion ='conocelo';
			break;
		case 2:
			$idSeccion ='chefs';
			break;
		case 3:
			$idSeccion ='recetas';
			break;
		case 4:
			$idSeccion ='sobremesa';
			break;
		case 5:
			$idSeccion ='entrecopas';
			break;
		default:
			break;
	}

	return $idSeccion;
}


function certifica($cadena)
	{


		$ruta = "";
		$llaves = array("command=resultados","/restaurantes","/menu","/mapa","/opinion","/editorial","/vinos","/registro","/actualizanos","/anunciate","/contacto","/registroqueremoscomer","/promociones","/miembros","/miperfil","/Compraenlinea","/empleo","/prensa","/quienessomos","/anunciaterest","/privacidad","/condiciones","/opiniones","/comentarios","/promo.php","/avanzada","/Boletines" );

		foreach ($llaves as $valor)
		{
			$resultado = strstr($cadena,$valor);
			if($resultado)
				$encontrado = $valor;
			elseif ($cadena == "/")
				$encontrado = "/";
		}



		switch ($encontrado)
		{
			case "command=resultados":
				$ruta = "/queremoscomer/resultados";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/restaurantes":
				$restaurante = substr($cadena, 14, -5);
				$ruta = "/queremoscomer/restaurantes";
				$miScript = "
				<script type='text/javascript' language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
                                    hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Restaurantes');
				// -->
				</script>";
				break;
			case "/menu" :

				$restaurante = substr($cadena, 18, -5);
				$ruta = "/queremoscomer/restaurantes";
				$miScript = "
				<script language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
                                    hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Menu');
				// -->
				</script>";
				break;
			case "/mapa" :

				$restaurante = substr($cadena, 18, -5);
				$ruta = "/queremoscomer/restaurantes";
				$miScript = "
				<script type='text/javascript' language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
                                    hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Mapa');
				// -->
				</script>";

				break;
			case "/opinion":

				$restaurante = substr($cadena, 21, -5);
				$ruta = "/queremoscomer/restaurantes";
				$miScript = "
				<script type='text/javascript' language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
                                    hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Opinion');
				// -->
				</script>";

				break;
			case "/opiniones":

				$restaurante = substr($cadena, 23, -5);
				$ruta = "/queremoscomer/restaurantes";
				$miScript = "
				<script type='text/javascript' language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
                                    hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Opiniones');
				// -->
				</script>";
				break;

			case "/comentarios":

				$restaurante = substr($cadena, 25, -5);
				$ruta = "/queremoscomer/restaurantes";
				$miScript = "
				<script type='text/javascript' language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='/js/cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
                                    hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Opiniones');
				// -->
				</script>";
				break;
			case "/editorial" :

				$ruta = "/queremoscomer/editorial";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/editorial-" :
				$ruta = "/queremoscomer/editorial";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/vinos" :
				$ruta = "/queremoscomer/editorial";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/registro" :
				$ruta = "/queremoscomer/formularios";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/actualizanos" :
				$ruta = "/queremoscomer/formularios";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/anunciate" :
				$ruta = "/queremoscomer/formularios";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/contacto" :
				$ruta = "/queremoscomer/formularios";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/registroqueremoscomer" :
				$ruta = "/queremoscomer/formularios";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/promociones" :
				$ruta = "/queremoscomer/promociones";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/miembros" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/miperfil" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/Compraenlinea" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/empleo" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/prensa" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/quienessomos" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/anunciaterest" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/privacidad" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/condiciones" :
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>";
				break;
			case "/" :
				$ruta = "/queremoscomer/portada";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&amp;path=$ruta'></script>

				<script type='text/javascript' src='http://www.queremoscomer.com/ovl_cert.js'></script>
				<script type='text/javascript'>
				<!--
                                    cert_overlay(201854,'portada');
				// -->
				</script>

				";
				break;
			case "/promo.php":
				$restaurante = substr($cadena, 49);
				$ruta = "/queremoscomer/promociones";
				$miScript = "
				<script type='text/javascript' language='JavaScript1.4' src='http://c.scorecardresearch.com/certifica-js14.js'></script>
				<script type='text/javascript' src='http://c.scorecardresearch.com/certifica.js'></script>
				<script type='text/javascript' src='cert_editorial.js'></script>
				<script type='text/javascript'>
				<!--
				hitNota(201854,  '$ruta', '$restaurante', Formatos.TEXTO, 'Cupones');
				// -->
				</script>";
				break;
			case "/avanzada" :
				$ruta = "/queremoscomer/busqueda-avanzada";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&path=$ruta'></script>";
				break;

			case "/Boletines" :
				$ruta = "/queremoscomer/boletines";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&path=$ruta'></script>";
				break;
			default:
				$ruta = "/queremoscomer/otros";
				$miScript = "<script type='text/javascript' src='http://b.scorecardresearch.com/c2/7363468/cs.js#sitio_id=201854&path=$ruta'></script>";
				break;
		}
		return $miScript;
	}

function calificacionStars($cal)
{
	if ($cal >= 5.0)
	{
		$cal= 5.0;
	}
	if ($cal <= 0)
	{
		$cal= 0;
	}
        $_cal = $cal;
	for($x=1; $x <= 5; $x++)
	{

		if($cal >= 1)
		{
			$html .= "<img src='http://www.queremostomar.com/skin/morado/images/qt/estrellas/estrella_llena.png' alt='Calificacion $_cal' style='width:19px; height:19px' />";
			$cal--;
		}
		elseif($cal >.5 && $cal < 1)
		{
			$html .= "<img src='http://www.queremostomar.com/skin/morado/images/qt/estrellas/estrella_llena.png' alt='Calificacion $_cal' style='width:19px; height:19px' />";
			$cal = 0;
		}
		elseif($cal == .5)
		{
			$html .= "<img src='http://www.queremostomar.com/skin/morado/images/qt/estrellas/estrella_media.png' alt='Calificacion $_cal' style='width:19px; height:19px' />";
			$cal = 0;
		}
		elseif($cal > 0 && $cal < .5)
		{
			$html .= "<img src='http://www.queremostomar.com/skin/morado/images/qt/estrellas/estrella_vacia.png' alt='Calificacion $_cal' style='width:19px; height:19px' />";
			$cal = 0;
		}
		elseif($cal <= 0)
		{
			$html .= "<img src='http://www.queremostomar.com/skin/morado/images/qt/estrellas/estrella_vacia.png' alt='Calificacion $_cal' style='width:19px; height:19px' />";

                        $cal=0;
                }

	}

	return $html;
}

function getCodifica($txt)
{
    return utf8_encode($txt);
}

function reemplaza($datos)
{
			  	$acentos = array (
                                    "&"  => "&amp;",
                                    "“" => "&quot;",
                                    "<strong>"   => "",
                					"</strong>"   => "",
                                    "ñ"  => "&ntilde;",
                                    "Ñ"  => "&Ntilde;",
                                    "á"  => "&aacute;",
                                    "Á"  => "&Aacute;",
                                    "é"  => "&eacute;",
                                    "É"  => "&Eacute;",
                                    "í"  => "&iacute;",
                                    "Í"  => "&Iacute;",
                                    "ó"  => "&oacute;",
                                    "Ó"  => "&Oacute;",
                                    "ö"  => "&ouml;",
                                    "Ö"  => "&Ouml;",
                                    "ú"  => "&uacute;",
                                    "Ú"  => "&Uacute;",
                                    "ü"  => "&uuml;",
                                    "Ü"  => "&Uuml;",
                                    "<a"   => "a",
                                    "</a>"   => "a",
                                    ""   => "<!--StartFragment-->",
                                    ""   => "<!--EndFragment-->",
                                    "“"  => "",
                                    "”"  => "",
                					"<b>" => "",
                					"</b>" => "",
                					"<it>" => "",
                					"</it>" => "",
                					"<u>" => "",
                					"</u>" => "",
                					"<i>" => "",
                					"</i>" => "",
                					". " => "",
                                    "<br>" => " ",
                                    "<br/>" => " "
                                  

                                  );
			  
				foreach ($acentos as $llave => $valor) 
				{
					$datos = str_replace($llave,$valor,$datos);
				}
						
				return $datos;
					
}


function ValidaMail($pMail)
{
    if (ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@+([_a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]{2,200}\.[a-zA-Z]{2,6}$", $pMail ) )
    {
        return true;
    }
    else
    {
       return false;
    }
}

//Acentos en Mayusculas
function  Convert($cadena)
{
    $Acentos = strtr($cadena,"àèìòùáéíóúçñäëïöüãâ","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜÃÂ");
    return $Acentos;
}

function Espacioswhite($text)
{
	if(empty($text))
	{
		return true;
	}

	$text= str_replace(" ","",$text);

	if(strlen($text)==0)
	{
		return true;
	}
	return false;
}

function getPathImg($file)
{
   // return "skin/".TEMA_WEB."/images/qt/".$file;
   return "calendario/".$file;
}

function getToken($name='')
{
     $alphanum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789";
     $token = md5(substr(md5(str_shuffle($alphanum)), 0, 10));
     $_SESSION["token_".$name] = $token;

     return $token;
}

function ErrorPromos()
{
    $html = '<p class="style2" style="font-weight: bold">Tu mensaje se envio correctamente <br />pero hubo un error al tratar de inscribirte a nuestras promociones
             *El Correo ya esta registrado.
             *Le falta alg&uacute;n arroba o punto.<br />
             <strong><a title="La Gu&iacute;a de Restaurantes" href="http://www.queremoscomer.com/"><span class="style4"><font color="#ff8c00">QUEREMOS</font><font color="black">COMER</font><font color="#ff8c00">.</font><font color="black">COM</font></span></a></strong></p>';
    return $html;
}

function graciasPromos()
{
    $html ='<div align="center"><p class="style2 style1">Has quedado inscrito en las promociones de <span class="style4"> <font color="#ff8c00">queremos</font></span>comer<span class="style4"> <font color="#ff8c00">.</font></span>com, para quedar activado por favor confirma el correo que se te acaba de enviar y comienza a disfrutar de nuestras promociones.
  &iexcl; GRACIAS ! <br /><br /><strong> <a title="La Gu&iacute;a de Restaurantes" href="http://www.queremoscomer.com/"> <span class="style4"><font color="#ff8c00">QUEREMOS</font><font color="black">COMER</font><font color="#ff8c00">.</font><font color="black">COM</font> <font color="black"></font></span></a></strong></p></div> ';
    return $html;
}

function tinyurl($url_larga)
{
    $tiny = "http://que.mx/addurl.php?url=".urlencode($url_larga);
    $sesion = curl_init();
    curl_setopt ( $sesion, CURLOPT_URL, $tiny );
    curl_setopt ( $sesion, CURLOPT_RETURNTRANSFER, 1 );
    $url_tiny = curl_exec ( $sesion );
    curl_close( $sesion );
    return($url_tiny);
}

function NopromosAdd($email,$name,$status)
{
   $sql = "CALL Suscriptores('$email','$name','$status','".date('Y-m-d')." ".date('H:i:s')."','".$_SERVER["REMOTE_ADDR"]."');";
   $link = mysqli_connect ("www.queremoscomer.com", "interspire", "b0letines","qc_interspire");
   $result=mysqli_query ($link,$sql);
   mysqli_close($link);
}

/********************** PANEL ***************************/

function makeHTMLPaginarPanel($numrows1, $maxPage, $terminamosconel,$paginanum, $by, $order, $tampag)
{
	$anterior		= $paginanum - 1;
	$posterior		= $paginanuml + 1;
	if ($terminamosconel >= $numrows1)
	{
		$terminamoscon = $numrows1;
	}
	else
	{
		$terminamoscon = $terminamosconel;
	}
	$empezamoscon = $terminamosconel - ($tampag-1);

	if ($paginanum > 1)
	{
		$page = $paginanum - 1;
		$prev = " <a  href=\"javascript: PaginacionSubmit('$page','$by','$order');\" class='ligafunc'>";
		$prev .= "<img src='images/atras.gif' align='absmiddle' border='0'/>  Anterior</a> ";
	}
	else
	{
		$prev  = '';
	}

	if ($paginanum < $maxPage)
	{
		$page = $paginanum + 1;
		$next = " <a  href=\"javascript: PaginacionSubmit('$page','$by','$order');\" class='ligafunc'> ";
		$next .= "Siguiente <img src='images/siguiente.gif' align='absmiddle' border='0'/></a> ";
	}
	else
	{
		$next = '';
	}


	$html .= "<span class='ligafunc'>".$first.$prev."  $empezamoscon - $terminamoscon (de $numrows1) ".$next.$last."</span><br /><br />";

	if($tampag <= $numrows1)
	{

		if ($paginanum>1)
    		$html .= "<a  href=\"javascript: PaginacionSubmit('1','$by','$order');\" class='ligafunc'>&laquo;</a> ";
  		else
    		$html.= "<span class='ligafunc'><b>&laquo;</b></span>";


		if ($paginanum< 6)
		{
			for ($i=1; $i<$paginanum; $i++)
				$html .= "<a  href=\"javascript: PaginacionSubmit('$i','$by','$order');\" class='ligafunc'> $i</a> ";
  		}
		else
		{
			for ($i=$paginanum-5; $i<$paginanum; $i++)
				$html .= "<a  href=\"javascript: PaginacionSubmit('$i','$by','$order');\" class='ligafunc'> $i</a> ";
		}

		$html .= "<span class='ligafunc'>[<b>$paginanum</b>]</span>";

		if($paginanum +6 > $maxPage)
		{
			for ($i=$paginanum+1; $i<=$maxPage; $i++)
			    	$html .= "<a  href=\"javascript: PaginacionSubmit('$i','$by','$order');\" class='ligafunc'> $i</a> ";
  		}
		else
		{
			for ($i=$paginanum+1; $i<=$paginanum+6; $i++)
			    	$html .= "<a  href=\"javascript: PaginacionSubmit('$i','$by','$order');\" class='ligafunc'> $i</a> ";
		}
		if ($paginanum<$maxPage)
		    	$html .= "<a  href=\"javascript: PaginacionSubmit('$maxPage','$by','$order');\" class='ligafunc'> &raquo;</a>";
	  	else
		    	$html .= "<span class='ligafunc'><b>&raquo;</b></span>";

		$html .= "<br /><br />";
	}

	return $html;
}

function makeHTMLOrder($order, $ordercampo, $campo, $caption, $page, $width)
{
	if($campo == $ordercampo && (!empty($campo) && !empty($ordercampo)))
	{
		$order = $order == "ASC" ? "DESC" : "ASC";
		$thisClass = $order == "ASC" ? "class='MyASC'" : "class='MyDESC'";
		$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	else
	{
		$thisClass = "class='THtitle'";
	}


	if(!empty($width))
	{
		$thisWidth = "width='$width'";
	}

	if(!empty($caption))
	{
		$caption = "<a href=\"javascript:PaginacionSubmit('$page','$campo','$order');\" class='urlorder'>".$tab.$caption."</a>";
	}

	print ("<th $thisWidth  $thisClass>$caption</th>");

}

function SelectReferencia($id, $caption, $referencia,$class='')
{
	$MyQuerys = new CONSULTAS;

	$campos = array("id_referencia", "referencia");
	$condicion = array ('status' => '1');

   	$html .= "<select name='$id' id='$id' $class>";
	if(!empty($caption))
	{
		$html .= "<option value=''>$caption</option>";
	}

	if($MyQuerys->SeleccionarFila("restaurante_referencia", $campos, $condicion, "", "referencia") == CONSULTAS_SUCCESS)
	{
		while($registro = $MyQuerys->Fetch())
		{
			$html .="<option value='".$registro['id_referencia']."'";
			if($referencia==$registro['id_referencia'])
			{
				$html .= " selected";
			}
			$html .= ">".$registro['referencia']."</option>";
		}
	}
	$html .= "</select>";
	return ($html);
}


function CTR($clicks, $impresiones)
{

	if($impresiones > 0)
	{
		$ctr = ($clicks * 100) / $impresiones;
		return round($ctr, 2)."%";
   	}
	return 0;

}


function getZona($id_zona)
{
       $MyQuerys = new CONSULTAS;

	$campos = array("nombre");
	$condicion = array ('id' => $id_zona);

        if($MyQuerys->SeleccionarFila("zonas", $campos, $condicion,"","") == CONSULTAS_SUCCESS)
        {
            $registro = $MyQuerys->Fetch();

            $zona = $registro["nombre"];
        }


       return $zona;
}


function getPrecio($id_precio)
{
       $MyQuerys = new CONSULTAS;

	$campos = array("precio_esp");
	$condicion = array ('id' => $id_precio);

        if($MyQuerys->SeleccionarFila("precios", $campos, $condicion,"","") == CONSULTAS_SUCCESS)
        {
            $registro = $MyQuerys->Fetch();

            $precio = $registro["precio_esp"];
        }


       return $precio;
}



function getComida($id_comida)
{
       $MyQuerys = new CONSULTAS;

	$campos = array("nombre_es");
	$condicion = array ('id' => $id_comida);

        if($MyQuerys->SeleccionarFila("comida_tipos", $campos, $condicion,"","") == CONSULTAS_SUCCESS)
        {
            $registro = $MyQuerys->Fetch();

            $comida = $registro["nombre_es"];
        }


       return $comida;
}

function getRerePlaza($id)
{
       $MyQuerys = new CONSULTAS;

	$campos = array("referencia");
	$condicion = array ('id_referencia' => $id);

        if($MyQuerys->SeleccionarFila("restaurante_referencia", $campos, $condicion,"","") == CONSULTAS_SUCCESS)
        {
            $registro = $MyQuerys->Fetch();

            $referencia = $registro["referencia"];
        }


       return $referencia;
}


function getHorariosLog($horarios)
{
    //print_r($horarios);
    
    foreach ($horarios as $horario)
    {
                        $html .= "<p>";

			if($horario[0] == "Lun" && $horario[1] == "Dom" &&  $horario[2] == "12" && $horario[4] == "12")
			{
				$html .= "Abierto las 24 Horas.";
			}
			else
			{

                            if ($horario[0] != "")
                            {
				$html .=  $horario[0];					
                            }
                            if ($horario[1] != "")
                            {
				$html .= " a ".$horario[1];					
                            }
				                          
		
                            if ($horario[2] != "")
                            {

                                
                                if($horario[2] == "12")

                                {
                                    $html .= " de 12:".$horario[3]." pm";					
                                }

                                elseif($horario[2] == "24")
                                {
                                    $html .= " de 12:".$horario[3]." am";					
                                }
                                elseif($horario[2] < "12")
                                {
                                    $html .= " de ".$horario[2].":".$horario[3]." am";	
                                }
                                elseif($horario[2] > "12")
                                {
                                    $html .= " de ".($horario[2]-12).":".$horario[3]." pm";	

                                }
                                
                            }


                            
                           
                            
                           if ($horario[4] != "")
                            {

                                
                                if($horario[4] == "12")

                                {
                                    $html .= " a 12:".$horario[5]." pm";					
                                }

                                elseif($horario[4] == "24")
                                {
                                    $html .= " a 12:".$horario[5]." am";					
                                }
                                elseif($horario[4] < "12")
                                {
                                    $html .= " a ".$horario[4].":".$horario[5]." am";	
                                }
                                elseif($horario[4] > "12")
                                {
                                    $html .= " a ".($horario[4]-12).":".$horario[5]." pm";	

                                }
                                
                            }
                                        
          
                            $html .= "</p>";
                    }
		
	}
	
    
    return $html;
}


function getTotalRestaurantes($type='none')
{
    $MyQuerys = new CONSULTAS;
    $campos = array("count(id) as total");
    $condiciones = array('status' => '1');
    if($type=='miembro')
    {
        $condiciones["posicionamiento < 85 and 1"] = "1";
    }
    elseif($type=="free")
    {
        $condiciones["posicionamiento >= 85 and 1"] = "1";
    }
    
   
    $MyQuerys->NuevaConsulta();
    if($MyQuerys->SeleccionarFila("restaurantes", $campos, $condiciones, "", "") == CONSULTAS_SUCCESS)
    {
        $registro = $MyQuerys->Fetch();
        
        return $registro["total"];
    }
    return 0;

    
}

function getRestaurante($id)
{
    $MyQuerys = new CONSULTAS;
    $MyQuerys->SeleccionarFila("restaurantes", array("nombre"),array("id" => $id), "", ""); 
    $registro = $MyQuerys->Fetch();
    return $registro["nombre"];	
}


function getTelefonos($telefonos)
{
    $telefonos = $telefonos;
    $count = 0;
    

    
    foreach ($telefonos as $telefono)
    {
        $telefono = (array)$telefono;
        if(!empty($telefono["lada"]) && !empty($telefono["tel"]))
        {
            if($count == 1)
            {
                $html .= " / ";
            }
            $html .= "(".$telefono["lada"].") ".$telefono["tel"].(!empty($telefono["ext"]) ? " Ext. ".$telefono["ext"]: "");
            $count++;
        }
    }
    
    return $html;
}




function url_valida($url)
{
    static $urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

    return eregi($urlregex, $url);
}
function validaCaracteres($txt)
{
    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.";
    for ($i=0; $i<strlen($txt); $i++)
    {
        if (strpos($permitidos, substr($txt,$i,1))===false){

            return false;
        }
    }
    return true;
}


function validFormsServer($rules)
{
    $msg = "";
    foreach ($rules as $campo => $rule)
    {
     
        $valor = $rule['valor'];
    
    
        if(in_array("required",$rule) && $valor == "")
        {
            $msg = "Favor de llenar el campo $campo";
        }
        if($valor != "" && in_array("valid_chars",$rule) && !validaCaracteres($valor))
        {
           $msg = "El campo $campo contiene caracteres no permitidos";
        }
        if($valor != "" && in_array("email",$rule) && !ValidaMail($valor))
        {
           $msg = "El formato del campo $campo no es valido";
        }
        if($valor != "" && in_array("url",$rule) && !url_valida($valor))
        {
            $msg = "El formato del campo $campo no es valido";
        }
        if($valor != "" && in_array("numeric",$rule) && !is_numeric($valor))
        {
            $msg = "El formato del campo $campo no es valido";
        }
        if(in_array("length",$rule) && in_array("min",$rule["length"]) && strlen($valor)< $rule["leng"]["min"])
        {
            $msg = "El campo $campo no debe tener menos de ".$rule["leng"]["min"]." caracteres";
        }
        if($valor != "" && in_array("length",$rule) && in_array("max",$rule["length"]) && strlen($valor)< $rule["leng"]["max"])
        {
            $msg = "El campo $campo no debe tener mas de ".$rule["leng"]["max"]." caracteres";
        }
        if($valor != "" && in_array("apropiado", $rule) && isApropiado($valor) == false)
        {
            $msg = "El campo $campo no debe tener palabras inapropiadas";
        }
        
    }
   
    return $msg;
    
}

function getCountReactions($id_rest,$reaction)
{
    global $MySession;
    $MyQuerys = new CONSULTAS;
    $count = 0;
    $click = false;
    
    $MyQuerys->SeleccionarFila("reactions", array("id","uid"),array("id_rest" => "$id_rest","reaction" => $reaction), "", ""); 
    while($registro = $MyQuerys->Fetch())
    {
        
        
         if($registro["uid"] == $MySession->Id())
            {
                
                $click = true;
            }
               
            $count++;
    }
    return array("count" => $count,"click" => $click);

}


function edad($fecha_nac)
{
    $dia=date("d");
    $mes=date("m");
    $anno=date("Y");
	
    $dia_nac=substr($fecha_nac, 8, 2);
    $mes_nac=substr($fecha_nac, 5, 2);
    $anno_nac=substr($fecha_nac, 0, 4);
	
    if($mes_nac>$mes){
        $calc_edad= $anno-$anno_nac-1;
    }else{
        if($mes==$mes_nac AND $dia_nac>$dia){
            $calc_edad= $anno-$anno_nac-1;  
        }else{
            $calc_edad= $anno-$anno_nac;
        }
    }
    return $calc_edad;
}

function makeHTMLSelectEstados($id,$value,$caption,$extra="")
{
    $MyQuerys = new CONSULTAS;
    
    $html = "<select name=\"$id\" $extra>";
    $html .= "<option value=\"\">$caption</option>";
    if($MyQuerys->seleccionarFila("estados", array("id","nombre"),array("1" => "1"),"","nombre aSC") == CONSULTAS_SUCCESS)
    {
        while($registro = $MyQuerys->Fetch())
        {
            $html .= "<option value=\"".$registro["id"]."\" ".($registro["id"] == $value ? "selected='selected'" : "").">".$registro["nombre"]."</option>";
        }
    }
    $html .= "</select>";
    
    return $html;
}

function getEstado($estado)
{
    $MyQuerys = new CONSULTAS;
    if($MyQuerys->seleccionarFila("estados", array("nombre"),array("id" => $estado),"","nombre aSC") == CONSULTAS_SUCCESS)
    {
        $registro = $MyQuerys->Fetch();
        return utf8_encode($registro["nombre"]);
        
    }
    
    return "";
}

function getMunicipio($municipio)
{
    $MyQuerys = new CONSULTAS;
    if($MyQuerys->seleccionarFila("municipios", array("municipio"),array("id_municipio" => $municipio),"","municipio aSC") == CONSULTAS_SUCCESS)
    {
        $registro = $MyQuerys->Fetch();
        return utf8_encode($registro["municipio"]);
        
    }
    
    return "";
}

function isApropiado($txt)
{
    $palabras = "mendiga,http,mendigas,w w w,maldito,xxx,maldita,www,malditos,malditas,pendeja,vomito,porquerias,cabron,";
    $palabras .= "cucarachas,cucaracha,put,chingadera,chingaderas,chingada,cucaracha,ratero,ratera,rateros,rateras,";
    $palabras .= "cucarachas,mierda,cucaracha,mendigo,ratas,mendigos,rata,chinga,Chinga tu madre,golfa,@";
    
    $p = explode(",",$palabras);
    foreach ($p as $p_)
    {
        if(preg_match("/$p_/",$txt))
        {
            return false;
        }
    }    
    
    return true;
}

function getServiciosLog($servicios)
{
    $hmlt = "<ul>";
     foreach($servicios as $valor)
    {
        $html .= "<li style='margin-left:20px;' type='circle'>".$valor[1]."</li>";
        
    }
    $hmlt .= "</ul>";
    return substr($html,0,-2);
    
}
?>