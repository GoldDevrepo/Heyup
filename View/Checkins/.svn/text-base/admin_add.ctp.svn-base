<div class="checkins form">
<?php echo $this->Form->create('Checkin'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Checkin'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('address');
		echo $this->Form->input('lat');
		echo $this->Form->input('lng');
		echo $this->Form->input('timeline');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Checkins'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
