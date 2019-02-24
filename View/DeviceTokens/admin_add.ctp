<div class="deviceTokens form">
<?php echo $this->Form->create('DeviceToken'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Device Token'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Device Tokens'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
