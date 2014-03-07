


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	
         
<title>Documento sin título</title>
</head>



<body>
      <form id="google" name="google" action="#">
         
        <label>Direcci&oacute;n</label>
        <input type="text" id="direccion" name="direccion" value="Luro 1200, Mar del Plata, Buenos Aires, Argentina"/> 
        <button id="pasar">Pasar al mapa</button>
         
        <!-- div donde se dibuja el mapa-->
        <div id="map_canvas" style="width:600px;height:400px;"></div>
         
        <!--campos ocultos donde guardamos los datos-->
        <input type= "text" name="lat" id="lat"/>
        <input type="text"  name="lng" id="long"/>
     </form>

</body>
</html>
