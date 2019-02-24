<div class="blocks view">
<h2><?php echo __('Block'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($block['Block']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UserId1'); ?></dt>
		<dd>
			<?php echo h($block['Block']['userId1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UserId2'); ?></dt>
		<dd>
			<?php echo h($block['Block']['userId2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($block['Block']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($block['Block']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Block'), array('action' => 'edit', $block['Block']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Block'), array('action' => 'delete', $block['Block']['id']), null, __('Are you sure you want to delete # %s?', $block['Block']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Blocks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Block'), array('action' => 'add')); ?> </li>
	</ul>
</div>
