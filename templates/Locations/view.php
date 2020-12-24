<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location $location
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Locations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="locations view content">
            <h3><?= h($location->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($location->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Latitude') ?></th>
                    <td><?= $this->Number->format($location->latitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Length') ?></th>
                    <td><?= $this->Number->format($location->length) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Pharmacies') ?></h4>
                <?php if (!empty($location->pharmacies)) : ?>
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
                        <?php foreach ($location->pharmacies as $pharmacies) : ?>
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
