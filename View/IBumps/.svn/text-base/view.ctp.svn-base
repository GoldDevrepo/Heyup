<div class="iBumps view">
<h2><?php echo __('I Bump'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($iBump['IBump']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('MyId'); ?></dt>
		<dd>
			<?php echo h($iBump['IBump']['myId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($iBump['User']['name'], array('controller' => 'users', 'action' => 'view', $iBump['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($iBump['IBump']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($iBump['IBump']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit I Bump'), array('action' => 'edit', $iBump['IBump']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete I Bump'), array('action' => 'delete', $iBump['IBump']['id']), array(), __('Are you sure you want to delete # %s?', $iBump['IBump']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List I Bumps'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New I Bump'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
