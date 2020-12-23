<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Home'), ['controller' => 'Search','action' => 'index'], ['class' => 'side-nav-item']) ?>
            
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            
            
            <?php if($this->request->getSession()->read('Auth.rol_id')==1){?>
			<?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pharmacies'), ['controller' => 'pharmacies'], ['class' => 'side-nav-item']) ?>
		
			
            
            <?= $this->Html->link(__('View messages'), ['controller' => 'Messages','action' => 'index'], ['class' => 'side-nav-item']);?>
			
            
            <?php	}?>
            <?= $this->Html->link(__('Logout'), ['controller' => 'Users','action' => 'logout'], ['class' => 'side-nav-item']) ?>
            
            
            
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Born') ?></th>
                    <td><?= h($user->date_born) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Comments') ?></h4>
                <?php if (!empty($user->comments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Comentario') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('State') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Pharmacy Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->comments as $comments) : ?>
                        <tr>
                            <td><?= h($comments->id) ?></td>
                            <td><?= h($comments->Comentario) ?></td>
                            <td><?= h($comments->date) ?></td>
                            <td><?= h($comments->state) ?></td>
                            <td><?= h($comments->user_id) ?></td>
                            <td><?= h($comments->pharmacy_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Pharmacies') ?></h4>
                <?php if (!empty($user->pharmacies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Address') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->pharmacies as $pharmacies) : ?>
                        <tr>
                            <td><?= h($pharmacies->id) ?></td>
                            <td><?= h($pharmacies->name) ?></td>
                            <td><?= h($pharmacies->location_id) ?></td>
                            <td><?= h($pharmacies->user_id) ?></td>
                            <td><?= h($pharmacies->address) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Pharmacies', 'action' => 'view', $pharmacies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Pharmacies', 'action' => 'edit', $pharmacies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Pharmacies', 'action' => 'delete', $pharmacies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pharmacies->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
