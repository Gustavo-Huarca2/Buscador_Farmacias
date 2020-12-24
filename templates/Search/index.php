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
<a class="button float-right" id="price" data-rel="<?= $this->Url->build(['_ext' => 'json']) ?>">Sort by price</a>
<h3 id="result-length" style="font-size: 200%;"></h3>
<div class="table-responsive">
	<table>
            <thead>
                <tr id="result-head">
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
					<th><?= $this->Paginator->sort('value') ?></th>
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
<?php foreach ($farmacias as $pharmacy): ?>
	L.marker([<?= $this->Number->format($pharmacy->latitude) ?>, <?= $this->Number->format($pharmacy->length) ?>],{icon: iconMarker}).addTo(mymap);
<?php endforeach; ?>
</script>
</div>
</div>