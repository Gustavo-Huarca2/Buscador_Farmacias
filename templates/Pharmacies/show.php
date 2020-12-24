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
            <?php if($this->request->getSession()->read('Auth.rol_id')==2){?>
				<?= $this->Html->link(__('Add comment'), ['controller' => 'Comments','action' => 'addToPharmacy', $pharmacy->id], ['class' => 'side-nav-item']);?>
			<?php	}?>
            <?php if($this->request->getSession()->read('Auth.rol_id')==3){?>
                <?= $this->Html->link(__('Edit Pharmacy'), ['action' => 'edit', $pharmacy->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('View Products'), ['controller' => 'Products','action' => 'index', $pharmacy->id], ['class' => 'side-nav-item']) ?>
            <?php	}?>

           
            <?= $this->Html->link(__('Logout'), ['controller' => 'Users','action' => 'logout'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pharmacies view content">
            <h3><?= h($pharmacy->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($pharmacy->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $pharmacy->has('user') ? $this->Html->link($pharmacy->user->name, ['controller' => 'Users', 'action' => 'view', $pharmacy->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($pharmacy->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $pharmacy->status ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Comments') ?></h4>
                <?php if (!empty($pharmacy->comments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Commentary') ?></th>
                            <th><?= __('Date') ?></th>
                        </tr>
                        <?php foreach ($pharmacy->comments as $comments) : ?>
                        <tr>
                            <td><?= h($comments->commentary) ?></td>
                            <td><?= h($comments->date) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Products') ?></h4>
                <?php if (!empty($pharmacy->products)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Pharmacy Id') ?></th>
                            <th><?= __('Mark') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Presentation') ?></th>
                        </tr>
                        <?php foreach ($pharmacy->products as $products) : ?>
                        <tr>
                            <td><?= h($products->name) ?></td>
                            <td><?= h($products->price) ?></td>
                            <td><?= h($products->amount) ?></td>
                            <td><?= h($products->pharmacy_id) ?></td>
                            <td><?= h($products->mark) ?></td>
                            <td><?= h($products->Type) ?></td>
                            <td><?= h($products->due_date) ?></td>
                            <td><?= h($products->presentation) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
		<br>
		<div id="mapid" class="farmacia form content mapsize">
		</div>
    </div>
</div>
<br>
<div  style="display:none;">
	<div id="lat"><?= h($pharmacy->latitude) ?></div>
	<div id="lng"><?= h($pharmacy->length) ?></div>
</div>
<?= $this->Html->script(['MapaShow']) ?>