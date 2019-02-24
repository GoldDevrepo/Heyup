<div class="credits form">
<?php echo $this->Form->create('Credit'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Credit'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('credit');
		echo $this->Form->input('amount');
		echo $this->Form->input('itunes_product');
		echo $this->Form->input('itunes_price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Credit.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Credit.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Credits'), array('action' => 'index')); ?></li>
	</ul>
</div>
