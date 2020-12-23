<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Home'), ['controller' => 'Search','action' => 'index'], ['class' => 'side-nav-item']) ?>

            <?php if($this->request->getSession()->read('Auth.rol_id')==1){?>
                <?= $this->Html->link(__('List Messages'), ['action' => 'index'], ['class' => 'side-nav-item']); ?>
            <?php }?>

            
            <?= $this->Html->link(__('Logout'), ['controller' => 'Users','action' => 'logout'], ['class' => 'side-nav-item']) ?>
        
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="messages form content">
            <?= $this->Form->create($message) ?>
            <fieldset>
                <legend><?= __('Add Message') ?></legend>
                <?php
                   //echo $this->Form->control('date');
                   echo $this->Form->control('date', [ 'readonly'=>'readonly']);
                   echo $this->Form->control('message');
                   
                   echo $this->Form->control('status',['type' => 'hidden', 'value' => true]);
                   echo $this->Form->control('user_id',['type' => 'hidden', 'value' => $id]);
                   echo $this->Form->control('email',['type' => 'hidden', 'value' => $email]);
                   //echo $this->Form->control('users._ids', ['options' => $users]);
                   
                   ?>
            </fieldset>
            <?= $this->Form->button(__('Send to administrators')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
