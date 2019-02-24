<div class="bumps index">
	<h2><?php echo __('Bumps'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('myId'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('location'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bumps as $bump): ?>
	<tr>
		<td><?php echo h($bump['Bump']['id']); ?>&nbsp;</td>
		<td><?php echo h($bump['Bump']['myId']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($bump['User']['name'], array('controller' => 'users', 'action' => 'view', $bump['User']['id'])); ?>
		</td>
		<td><?php echo h($bump['Bump']['location']); ?>&nbsp;</td>
		<td><?php echo h($bump['Bump']['created']); ?>&nbsp;</td>
		<td><?php echo h($bump['Bump']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $bump['Bump']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $bump['Bump']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $bump['Bump']['id']), array(), __('Are you sure you want to delete # %s?', $bump['Bump']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
		<li><?php echo $this->Html->link(__('New Bump'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
