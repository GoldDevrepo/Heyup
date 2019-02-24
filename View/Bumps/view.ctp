<div class="bumps view">
<h2><?php echo __('Bump'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($bump['Bump']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('MyId'); ?></dt>
		<dd>
			<?php echo h($bump['Bump']['myId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($bump['User']['name'], array('controller' => 'users', 'action' => 'view', $bump['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($bump['Bump']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($bump['Bump']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($bump['Bump']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Bump'), array('action' => 'edit', $bump['Bump']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Bump'), array('action' => 'delete', $bump['Bump']['id']), array(), __('Are you sure you want to delete # %s?', $bump['Bump']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Bumps'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bump'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
