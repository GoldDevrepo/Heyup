<div class="deviceTokens form">
<?php echo $this->Form->create('DeviceToken'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Device Token'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('device_token');
		echo $this->Form->input('device_type');
		echo $this->Form->input('stage');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DeviceToken.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DeviceToken.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Device Tokens'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
