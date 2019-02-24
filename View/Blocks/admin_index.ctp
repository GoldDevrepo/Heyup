<div class="blocks index">
	<h2><?php echo __('Blocks'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('userId1'); ?></th>
			<th><?php echo $this->Paginator->sort('userId2'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($blocks as $block): ?>
	<tr>
		<td><?php echo h($block['Block']['id']); ?>&nbsp;</td>
		<td><?php echo h($block['Block']['userId1']); ?>&nbsp;</td>
		<td><?php echo h($block['Block']['userId2']); ?>&nbsp;</td>
		<td><?php echo h($block['Block']['created']); ?>&nbsp;</td>
		<td><?php echo h($block['Block']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $block['Block']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $block['Block']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $block['Block']['id']), null, __('Are you sure you want to delete # %s?', $block['Block']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Block'), array('action' => 'add')); ?></li>
	</ul>
</div>
