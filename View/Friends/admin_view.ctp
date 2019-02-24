<div class="friends view">
<h2><?php echo __('Friend'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($friend['Friend']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UserId1'); ?></dt>
		<dd>
			<?php echo h($friend['Friend']['userId1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UserId2'); ?></dt>
		<dd>
			<?php echo h($friend['Friend']['userId2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Accept'); ?></dt>
		<dd>
			<?php echo h($friend['Friend']['is_accept']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($friend['Friend']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($friend['Friend']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Friend'), array('action' => 'edit', $friend['Friend']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Friend'), array('action' => 'delete', $friend['Friend']['id']), null, __('Are you sure you want to delete # %s?', $friend['Friend']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Friends'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Friend'), array('action' => 'add')); ?> </li>
	</ul>
</div>
