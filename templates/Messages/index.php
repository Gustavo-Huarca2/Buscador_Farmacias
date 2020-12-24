<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messages
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




<div class="messages index content">
    <?= $this->Html->link(__('New Message'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Messages') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('message') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?= $this->Number->format($message->id) ?></td>
                    <td><?= h($message->date) ?></td>
                    <td><?= h($message->message) ?></td>
                    <td><?= h($message->status) ?></td>
                    
                    <td><?= $this->Html->link($message->user_id, ['controller' => 'Users', 'action' => 'view', $message->user_id]) ?></td>
                    <td><?= h($message->email) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $message->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?>
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
