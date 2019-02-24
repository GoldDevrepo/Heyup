<div class="credits view">
<h2><?php echo __('Credit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Credit'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['credit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Itunes Product'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['itunes_product']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Itunes Price'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['itunes_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($credit['Credit']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Credit'), array('action' => 'edit', $credit['Credit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Credit'), array('action' => 'delete', $credit['Credit']['id']), array(), __('Are you sure you want to delete # %s?', $credit['Credit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Credits'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Credit'), array('action' => 'add')); ?> </li>
	</ul>
</div>
