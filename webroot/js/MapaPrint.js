//Asignar mapa a la division mapa
	var mymap = L.map('mapid').setView([-16.431269, -71.512413], 16);
	
	//Invocar mapa de proveedor mapbox
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, Iconos diseñados por <a href="https://www.flaticon.es/autores/surang" title="surang">surang</a> from <a href="https://www.flaticon.es/" title="Flaticon"> www.flaticon.es</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
	}).addTo(mymap);
	
	let iconMarker = L.icon({
		iconUrl: '../../img/farmacia.png',
		iconSize: [30,30],
		iconAnchor:[15,15]
	})
	
	//Funcionalidad que dibuja ruta
	L.Routing.control({
	waypoints: [
    L.latLng(-16.429335, -71.523614),
    L.latLng(-16.431269, -71.512413),
	L.latLng(-16.433101, -71.514441)
	],
	lineOptions:{
                   styles: [{color: 'black', opacity: 1, weight: 5}],
                   addWaypoints:false
               },
	draggableWaypoints: false,
	createMarker: function(){ return false; }
	})
	.addTo(mymap);
	
	var marker1 = L.marker([-16.429335, -71.523614]).addTo(mymap);
	var marker2 = L.marker([-16.433101, -71.514441],{icon: iconMarker}).addTo(mymap);
	
	//Funcionalidad que captura coordenada
	var popup = L.popup();
	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("La ubicacion seleccionada es: " + e.latlng.toString())
			.openOn(mymap);
		$("#length").val(e.latlng.lng);
		$("#latitude").val(e.latlng.lat);
	}
	
	mymap.on('click', onMapClick);