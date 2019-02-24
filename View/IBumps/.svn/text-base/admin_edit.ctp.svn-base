<div class="iBumps form">
<?php echo $this->Form->create('IBump'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit I Bump'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('myId');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('IBump.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('IBump.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List I Bumps'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
