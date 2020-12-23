<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pharmacy[]|\Cake\Collection\CollectionInterface $pharmacies
 */
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Home'), ['controller' => 'Search','action' => 'index'], ['class' => 'side-nav-item']) ?>
            
            <?php if($this->request->getSession()->read('Auth.rol_id')==1){?>
                <?= $this->Html->link(__('Mi Profile'), ['controller' => 'Users','action' => 'view', $this->request->getSession()->read('Auth.id')], ['class' => 'side-nav-item']) ?>
            
            <?php } ?>
            <?= $this->Html->link(__('Logout'), ['controller' => 'Users','action' => 'logout'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">

<div class="pharmacies index content">

<?php if($this->request->getSession()->read('Auth.rol_id')==3){?>
    <?= $this->Html->link(__('New Pharmacy'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php } ?>
    


    <h3><?= __('Pharmacies') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('latitude') ?></th>
                    <th><?= $this->Paginator->sort('length') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pharmacies as $pharmacy): ?>
                <tr>
                    <td><?= $this->Number->format($pharmacy->id) ?></td>
                    <td><?= h($pharmacy->name) ?></td>
                    <td><?= $pharmacy->has('user') ? $this->Html->link($pharmacy->user->name, ['controller' => 'Users', 'action' => 'view', $pharmacy->user->id]) : '' ?></td>
                    <td><?= h($pharmacy->address) ?></td>
                    <td><?= h($pharmacy->status) ?></td>
                    <td><?= $this->Number->format($pharmacy->latitude) ?></td>
                    <td><?= $this->Number->format($pharmacy->length) ?></td>
                    <td class="actions">

                    <?php if($this->request->getSession()->read('Auth.rol_id')==1){?>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pharmacy->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pharmacy->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pharmacy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pharmacy->id)]) ?>
                    <?php	}else{?>
                        <?= $this->Html->link(__('View'), ['action' => 'show', $pharmacy->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pharmacy->id]) ?>
                     <?php	}?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
</div>

