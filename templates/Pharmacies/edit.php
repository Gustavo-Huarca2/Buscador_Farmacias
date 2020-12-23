<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pharmacy $pharmacy
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Home'), ['controller' => 'Search','action' => 'index'], ['class' => 'side-nav-item']) ?>
        

            <?php if($this->request->getSession()->read('Auth.rol_id')==1){?>
                <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pharmacy->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pharmacy->id), 'class' => 'side-nav-item']
            ) ?>
            
            <?= $this->Html->link(__('List Pharmacies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('View Products'), ['controller' => 'Products','action' => 'index', $pharmacy->id], ['class' => 'side-nav-item']) ?>
			<?php	}else{?>
            <?= $this->Html->link(__('View Products'), ['controller' => 'Products','action' => 'index', $pharmacy->id], ['class' => 'side-nav-item']) ?>
            
            <?= $this->Html->link(__('Return to pharmacy'), ['action' => 'show', $pharmacy->id], ['class' => 'side-nav-item']) ?>
            <?php }?>
            <?= $this->Html->link(__('Logout'), ['controller' => 'Users','action' => 'logout'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pharmacies form content">
            <?= $this->Form->create($pharmacy) ?>
            <fieldset>
                <legend><?= __('Edit Pharmacy') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    if($this->request->getSession()->read('Auth.rol_id')==1){
                        //echo $this->Form->control('user_id', ['options' => $users]);
                        echo $this->Form->control('user_id', ['options' => $users, 'disabled' => 'true']);
                    }else{
                        echo $this->Form->control('user_id', ['options' => $users, 'disabled' => 'true']);
                    }
                    echo $this->Form->control('address');
                    echo $this->Form->control('status');
                    echo $this->Form->control('latitude',['type' => 'hidden']);
                    echo $this->Form->control('length',['type' => 'hidden']);
                ?>
				<div class="message text-center">
					<p id="msg">Posicion de farmacia no modificada. </p>
				</div>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
		<br>
		<div id="mapid" class="farmacia form content mapsize">
		</div>
    </div>
</div>
<br>
<?= $this->Html->script(['MapaEdit']) ?>