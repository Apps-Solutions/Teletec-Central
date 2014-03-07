//Declaramos las variables que vamos a user
var lat = null;
var lng = null;
var map = null;
var geocoder = null;
var marker = null;
var marker_2 = [];
var localizaciones = [];
         
jQuery(document).ready(function(){
     //obtenemos los valores en caso de tenerlos en un formulario ya guardado en la base de datos
     lat1 = jQuery('#lat').val();
     lng1 = jQuery('#long').val();
     //Asignamos al evento click del boton la funcion codeAddress
     jQuery('#pasar').click(function(){
		 clearMarkers();
        codeAddress();
        return false;
     });
	 
	 
	 jQuery('#creamapa').click(function(){
		 
		
		 var creamapa= localizaciones;
		 
		 
		 
	  bermudaTriangle = new google.maps.Polygon({
		paths: creamapa,
		strokeColor: '#FF0000',
		strokeOpacity: 0.8,
		strokeWeight: 3,
		fillColor: '#FF0000',
		fillOpacity: 0.35
	  });
	
	  bermudaTriangle.setMap(map);
		
		
        return false;
     });
	 
	 
     //Inicializamos la función de google maps una vez el DOM este cargado
    initialize();
});
     
    function initialize() {
     
      geocoder = new google.maps.Geocoder();
        
       //Si hay valores creamos un objeto Latlng
       if(lat !='' && lng != '')
      {
         var latLng = new google.maps.LatLng(lat,lng);
      }
      else
      {
        //Si no creamos el objeto con una latitud cualquiera como la de Mar del Plata, Argentina por ej
         var latLng = new google.maps.LatLng(37.0625,-95.677068);
      }
      //Definimos algunas opciones del mapa a crear
       var myOptions = {
          center: latLng,//centro del mapa
          zoom: 9,//zoom del mapa
          mapTypeId: google.maps.MapTypeId.ROADMAP //tipo de mapa, carretera, híbrido,etc
        };
        //creamos el mapa con las opciones anteriores y le pasamos el elemento div
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
         
        //creamos el marcador en el mapa
       crear_maker(latLng);
        
       //función que actualiza los input del formulario con las nuevas latitudes
       //Estos campos suelen ser hidden
        updatePosition(latLng);
         
         
    }
     
    //funcion que traduce la direccion en coordenadas
    function codeAddress() {
         
        //obtengo la direccion del formulario
        var address = document.getElementById("direccion").value;
        //hago la llamada al geodecoder
        geocoder.geocode( { 'address': address}, function(results, status) {
         
        //si el estado de la llamado es OK
        if (status == google.maps.GeocoderStatus.OK) {
            //centro el mapa en las coordenadas obtenidas
            map.setCenter(results[0].geometry.location);
            //coloco el marcador en dichas coordenadas
            marker.setPosition(results[0].geometry.location);
            //actualizo el formulario      
            updatePosition(results[0].geometry.location);
             
            //Añado un listener para cuando el markador se termine de arrastrar
            //actualize el formulario con las nuevas coordenadas
            
      } else {
          //si no es OK devuelvo error
          alert("No podemos encontrar la direcci&oacute;n, error: " + status);
      }
    });
  }
   
  //funcion que simplemente actualiza los campos del formulario
  function updatePosition(latLng)
  {
       crear_maker_pos(latLng);
	   llena_arreglo(latLng);
       jQuery('#lat').val(latLng.lat());
       jQuery('#long').val(latLng.lng());
	  
  }
  
  
  function  llena_arreglo(latLng)
  {  
	  var Coords = [
		new google.maps.LatLng(latLng.lat(), latLng.lng()),
		
	  ];
	  var todas_loc=localizaciones.push(new google.maps.LatLng(latLng.lat(), latLng.lng()));
	  console.log(localizaciones);
	 }
  
  
  
  
   function crear_maker(latLng)
   
  {
	  var image='gfx/pin_0.png';
   marker = new google.maps.Marker({
            map: map,//el mapa creado en el paso anterior
            position: latLng,//objeto con latitud y longitud
            draggable: true,//que el marcador se pueda arrastrar
			icon: image,
			title :  'Click para crear tu mapa' 
        });
	 google.maps.event.addListener(marker, 'dragend', function(){
                updatePosition(marker.getPosition());
				
            });
  }
  
  function crear_maker_pos(latLng)
   
  {
	  
   marker_2= new google.maps.Marker({
            map: map,//el mapa creado en el paso anterior
            position: latLng,//objeto con latitud y longitud
			
             //que el marcador se pueda arrastrar
			
        });
  }
  
  function clearMarkers() {
  setAllMap(null);
}

function setAllMap(map) {
  for (var i = 0; i < marker_2.length; i++) {
    marker_2[i].setMap(map);
  }
}