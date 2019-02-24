<div class="deviceTokens view">
<h2><?php echo __('Device Token'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($deviceToken['DeviceToken']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($deviceToken['User']['name'], array('controller' => 'users', 'action' => 'view', $deviceToken['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Device Token'); ?></dt>
		<dd>
			<?php echo h($deviceToken['DeviceToken']['device_token']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Device Type'); ?></dt>
		<dd>
			<?php echo h($deviceToken['DeviceToken']['device_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Stage'); ?></dt>
		<dd>
			<?php echo h($deviceToken['DeviceToken']['stage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($deviceToken['DeviceToken']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($deviceToken['DeviceToken']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Device Token'), array('action' => 'edit', $deviceToken['DeviceToken']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Device Token'), array('action' => 'delete', $deviceToken['DeviceToken']['id']), null, __('Are you sure you want to delete # %s?', $deviceToken['DeviceToken']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Tokens'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Token'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
