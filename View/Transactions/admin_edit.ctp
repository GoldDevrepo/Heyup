<div class="transactions form">
<?php echo $this->Form->create('Transaction'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Transaction'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('itunes_product');
		echo $this->Form->input('itunes_price');
		echo $this->Form->input('android_product');
		echo $this->Form->input('android_price');
		echo $this->Form->input('creadit');
		echo $this->Form->input('amount');
		echo $this->Form->input('description');
                echo $this->Form->input('locale');
                echo $this->Form->input('time_stamp');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Transaction.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Transaction.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Transactions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>