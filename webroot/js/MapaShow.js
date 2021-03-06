//Asignar mapa a la division mapa
	var mymap = L.map('mapid').setView([$("#lat").text(), $("#lng").text()], 18);
	
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
	var marker2 = L.marker([$("#lat").text(), $("#lng").text()],{icon: iconMarker}).addTo(mymap);