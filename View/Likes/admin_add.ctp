<div class="likes form">
<?php echo $this->Form->create('Like'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Like'); ?></legend>
	<?php
		echo $this->Form->input('who');
		echo $this->Form->input('whom');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Likes'), array('action' => 'index')); ?></li>
	</ul>
</div>
