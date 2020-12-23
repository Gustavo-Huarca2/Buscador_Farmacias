<h2>Pharmacy search</h2>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <?= $this->Html->link(__('My profile'), ['controller' => 'Users','action' => 'view', $this->request->getSession()->read('Auth.id')], ['class' => 'side-nav-item']) ?>
			<?php if($this->request->getSession()->read('Auth.rol_id')==3){?>
				<?= $this->Html->link(__('My pharmacies'), ['controller' => 'Pharmacies','action' => 'index'], ['class' => 'side-nav-item']);?>
				<?= $this->Html->link(__('Send Message'), ['controller' => 'Messages','action' => 'add'], ['class' => 'side-nav-item']);?>
			<?php	}?>
			
			<?php if($this->request->getSession()->read('Auth.rol_id')==2){?>
				
				<?= $this->Html->link(__('Send Message'), ['controller' => 'Messages','action' => 'add'], ['class' => 'side-nav-item']);?>
			<?php	}?>


			<?php if($this->request->getSession()->read('Auth.rol_id')==1){?>
				
				<?= $this->Html->link(__('View messages'), ['controller' => 'Messages','action' => 'index'], ['class' => 'side-nav-item']);?>
			<?php	}?>


			 <?= $this->Html->link(__('Logout'), ['controller' => 'Users','action' => 'logout'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">

 



<label for="edit">Enter Medicine</label>
<div class="">
	<input type="text" id="edit" name="edit" placeholder="Enter Product" class="search-input" value="">
	<input type="text" id="latitude" name="latitude" hidden>
	<input type="text" id="length" name="length" hidden>
    <button id="button" data-rel="<?= $this->Url->build(['_ext' => 'json']) ?>">Search</button>
	<!-- AL PREISONAR ESTE BOTON SE ABRIRA EL MDOA DE ABAJO  hidden-->
	<button id="myBtn" hidden>View Map</button>
	<div class="message text-center" id="msg" hidden></div>
	<!-- <div class="message text-center">
		<div class="input select">
			<label for="user-id">Ubicacion</label>
			<select name="user_id" id="user-id">
			<option value="0">GPS</option>
			<option value="1">Seleccionar ubicacion</option>
			</select>
		</div>
	</div>-->
</div>

<div class="accordion-container">
	
		<a href="#" class="accordion-titulo">Map: Select ubication<span class="toggle-icon"></span></a>
		<div class="accordion-content">
			<div id="mapid" class="farmacia form content mapsize"></div>
		</div>
		
</div>

<!-- ACOMODAR EL COMPONENTE MAPA EN UN MODAL-->

<script src="//code.jquery.com/jquery-3.5.0.min.js"></script>
<div class="pharmacies index content">
<a class="button float-right" id="distance">Sort by distance</a>
<h3 id="result-length" style="font-size: 200%;"></h3>
<div class="table-responsive">
	<table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
			<tbody id="result-container">
			
			</tbody>
	</table>
</div>
</div>
<br>
<?= $this->Html->script(['Index']) ?>
<script>
$(function() {
	var farmacias;
	$('#button').click(function() {
		var targeturl = $(this).data('rel'); //'/Farmacia/pharmacies/search'
		var search = 'csrfToken=<?= $csrfToken ?>&edit=' + $('#edit').val() + "&length=" + $('#length').val() +"&latitude="+ $('#latitude').val();
		var lat=$("#latitude").val(),lng=$("#length").val();
		$('#result-length').html('Buscando...');
		if(navigator.geolocation&&lat==""&&lng==""){
			navigator.geolocation.getCurrentPosition(function(position){
				$("#latitude").val(position.coords.latitude);
				$("#length").val(position.coords.longitude);
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
				var productos=response.products;
				$('#result-container').html('');
				for(i=0;i<farmacias.length;i++){
					//var nuevoTr = "<tr><th>Columna 1</th><th>Column 2</th><th>Columna 3</th></tr>";
					var nuevoTr = "<tr><td>";
					nuevoTr=nuevoTr.concat(farmacias[i].name,"</td><td>",farmacias[i].address,
						"</td><td><a href=/Buscador_Farmacias/pharmacies/show/",farmacias[i].id,">Ver Farmacia</a></td>");
					$('#result-container').append(nuevoTr);
				}
				
				$('#result-length').html('Resultados encontrados: ');
				$('#result-length').append(farmacias.length);
				/* if (pharmacies) {
					//var rpta = pharmacies;
					$('#result-container').html('xD');
				}else
					$('#result-container').html('vacio'); */
					if(farmacias.length!=0){
						window.scrollTo(0,document.body.scrollHeight); 
					}
			},
			error: function(e) {
				alert("An error occurred: " + e.responseText.message);
				console.log(e);
			}
		});
	});
	
	$('#distance').click(function(){
		var lat=$("#latitude").val(),lng=$("#length").val();
		$('#result-length').html('Orden por distancia');
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
					"</td><td><a href=/Buscador_Farmacias/pharmacies/show/",farmacias[i].id,">Ver Farmacia</a></td>");
				$('#result-container').append(nuevoTr);
			}
			
		}else{
			$('#result-length').html('No se registro ubicacion');
		}
		
		
	});

});
</script>
</div>
</div>