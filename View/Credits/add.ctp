<div class="credits form">
<?php echo $this->Form->create('Credit'); ?>
	<fieldset>
		<legend><?php echo __('Add Credit'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Credits'), array('action' => 'index')); ?></li>
	</ul>
</div>
