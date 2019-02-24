<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('dob');
		echo $this->Form->input('password');
		echo $this->Form->input('lives_in');
		echo $this->Form->input('tagline');
		echo $this->Form->input('hair_color');
		echo $this->Form->input('about_me');
		echo $this->Form->input('gender');
		echo $this->Form->input('email');
		echo $this->Form->input('mobile_no');
		echo $this->Form->input('latest_activity');
		echo $this->Form->input('is_message');
		echo $this->Form->input('is_notify');
		echo $this->Form->input('is_friend_request');
		echo $this->Form->input('search_type');
		echo $this->Form->input('sound');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Activities'), array('controller' => 'activities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Activity'), array('controller' => 'activities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Checkins'), array('controller' => 'checkins', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Checkin'), array('controller' => 'checkins', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Tokens'), array('controller' => 'device_tokens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Token'), array('controller' => 'device_tokens', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pictures'), array('controller' => 'pictures', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Picture'), array('controller' => 'pictures', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Transactions'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transaction'), array('controller' => 'transactions', 'action' => 'add')); ?> </li>
	</ul>
</div>
