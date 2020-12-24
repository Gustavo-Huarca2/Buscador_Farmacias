//ACORDEON---------------------------------------------------------------------------------------
$(function(){
  $(".accordion-titulo").click(function(e){
           
        e.preventDefault();
    
        var contenido=$(this).next(".accordion-content");

        if(contenido.css("display")=="none"){ //open		
          contenido.slideDown(250);			
          $(this).addClass("open");
        }
        else{ //close		
          contenido.slideUp(250);
          $(this).removeClass("open");	
        }

      });
});


//Asignar mapa a la division mapa----------------------------------------
	var mymap = L.map('mapid').setView([-16.399687, -71.53636], 13);
	var myposition; /*myposition = L.marker([e.latlng.lng, e.latlng.lat]).addTo(mymap);*/
	var myrute;
	var blockP=1;
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
		iconUrl: 'img/farmacia.png',
		iconSize: [20,20],
		iconAnchor:[15,15]
	})
	//imprimir mapas al inicio
	 
	/*$("#msg").text(farmacias[0].name);*/
	/*var marker2 = L.marker([-16.399687, -71.53636],{icon: iconMarker}).addTo(mymap);*/
	//Funcionalidad que captura coordenada
	var popup = L.popup();
	function onMapClick(e) {
		if(blockP==1){
			$("#length").val(e.latlng.lng);
			$("#latitude").val(e.latlng.lat);
			$(".message").addClass("success");
			$("#msg").text("Ubicacion seleccionada");
			var temp=myposition;
			myposition=L.marker([e.latlng.lat, e.latlng.lng]).addTo(mymap);
			mymap.removeLayer(temp);
		}
	}
	mymap.on('click', onMapClick);
	

//FUNCIONES DE INTERACCION Y GRAFICA-------------------------------------------------------------------
$(function() {
	var farmacias;
	$('#button').click(function() {
		var targeturl = $(this).data('rel'); //'/Farmacia/pharmacies/search'
		var search = 'csrfToken=<?= $csrfToken ?>&edit=' + $('#edit').val() + "&length=" + $('#length').val() +"&latitude="+ $('#latitude').val();
		var lat=$("#latitude").val(),lng=$("#length").val();
		$('#result-length').html('Search...');
		if(navigator.geolocation&&lat==""&&lng==""){
			navigator.geolocation.getCurrentPosition(function(position){
				$("#latitude").val(position.coords.latitude);
				$("#length").val(position.coords.longitude);
				var temp=myposition;
				myposition=L.marker([$("#latitude").val(), $("#length").val()]).addTo(mymap);
				mymap.removeLayer(temp);
				$('#msg').html('Uso de gps');
			});
			
		}
		//console.log(search);
		$.ajax({
			type: 'get',
			url: targeturl,
			data: search,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response){
				farmacias=response.pharmacies;
				$('#result-container').html('');
				for(i=0;i<farmacias.length;i++){
					//var nuevoTr = "<tr><th>Columna 1</th><th>Column 2</th><th>Columna 3</th></tr>";
					var nuevoTr = "<tr><td>";
					nuevoTr=nuevoTr.concat(farmacias[i].name,"</td><td>",farmacias[i].address,
						"</td><td>",farmacias[i].latitude,",",farmacias[i].length,
						"</td><td><a href=/Buscador_Farmacias/pharmacies/show/",farmacias[i].id,">view</a></td>");
					$('#result-container').append(nuevoTr);
				}
				
				$('#result-length').html('Result search: ');
				$('#result-length').append(farmacias.length);
				/* if (pharmacies) {
					//var rpta = pharmacies;
					$('#result-container').html('xD');
				}else
					$('#result-container').html('vacio'); */
				
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	});
	
	$('#price').click(function() {
		var targeturl = '/Buscador_Farmacias/search/price'; //'/Farmacia/pharmacies/search'
		var search = 'csrfToken=<?= $csrfToken ?>&edit=' + $('#edit').val();
		var lat=$("#latitude").val(),lng=$("#length").val();
		$('#result-length').html('Processing...');
		//console.log(search);
		$.ajax({
			type: 'get',
			url: targeturl,
			data: search,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response){
				farmacias=response.pharmacies;
				var productos=response.products;
				$('#result-container').html('');
				if(farmacias.length==productos.length){
					for(i=0;i<farmacias.length;i++){
						//var nuevoTr = "<tr><th>Columna 1</th><th>Column 2</th><th>Columna 3</th></tr>";
						var nuevoTr = "<tr><td>";
						nuevoTr=nuevoTr.concat(farmacias[i].name,"</td><td>",productos[i].name,
							"</td><td>",productos[i].price," S/",
							"</td><td><a href=/Buscador_Farmacias/pharmacies/show/",farmacias[i].id,">view</a></td>");
						$('#result-container').append(nuevoTr);
					}
				}
				$('#result-length').html('Result search: ');
				$('#result-length').append(productos.length);
				/* if (pharmacies) {
					//var rpta = pharmacies;
					$('#result-container').html('xD');
				}else
					$('#result-container').html('vacio'); */
				
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	});
	
	$('#distance').click(function(){
		var lat=$("#latitude").val(),lng=$("#length").val();
		$('#result-length').html('Sort by distance');
		if(navigator.geolocation&&lat==""&&lng==""){
			navigator.geolocation.getCurrentPosition(function(position){
				$("#latitude").val(position.coords.latitude);
				$("#length").val(position.coords.longitude);
				$('#msg').html('Uso de gps');
				lat=$("#latitude").val();
				lng=$("#length").val();
			});
		}
		if(lat!=""&&lng!=""){
			let n = farmacias.length;
			for (let i = 1; i < n; i++) {
				var current = farmacias[i];
				let j = i-1; 
				while ((j > -1) && (Math.sqrt(Math.pow(current.length-lng,2)+Math.pow(current.latitude-lat,2)) < 
					(Math.sqrt(Math.pow(farmacias[j].length-lng,2)+Math.pow(farmacias[j].latitude-lat,2)))) ) {
					farmacias[j+1] = farmacias[j];
					j--;
				}
				farmacias[j+1] = current;
			}
			$('#result-container').html('');
			for(i=0;i<farmacias.length;i++){
				//var nuevoTr = "<tr><th>Columna 1</th><th>Column 2</th><th>Columna 3</th></tr>";
				var nuevoTr = "<tr><td>";
				nuevoTr=nuevoTr.concat(farmacias[i].name,"</td><td>",farmacias[i].address,
					"</td><td>",farmacias[i].latitude,",",farmacias[i].length,
					"</td><td><a href=/Buscador_Farmacias/pharmacies/show/",farmacias[i].id,
					">view</a><button name='pointF' class='noBorder' onclick='graficRute(",farmacias[i].latitude,",",farmacias[i].length,")'>Rute</button>");
				$('#result-container').append(nuevoTr);
			}
			
		}else{
			$('#result-length').html('No se registro ubicacion');
		}
		
		
	});

});

function graficRute(lat,lng){
	blockP=0;
	var temp=myrute;
	myrute=L.Routing.control({
	waypoints: [
    L.latLng($("#latitude").val(), $("#length").val()),
	L.latLng(lat, lng)
	],
	lineOptions:{
                   styles: [{color: 'black', opacity: 1, weight: 5}],
                   addWaypoints:false
				},
	draggableWaypoints: false,
	createMarker: function(){ return false; }
	})
	.addTo(mymap);
	mymap.removeControl(temp);
	/*temp.spliceWaypoints(0, 2);*/
}