<div class="notificationsUsers index">
	<h2><?php echo __('Notifications Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('notification_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('is_read'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($notificationsUsers as $notificationsUser): ?>
	<tr>
		<td><?php echo h($notificationsUser['NotificationsUser']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($notificationsUser['User']['name'], array('controller' => 'users', 'action' => 'view', $notificationsUser['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($notificationsUser['Notification']['title'], array('controller' => 'notifications', 'action' => 'view', $notificationsUser['Notification']['id'])); ?>
		</td>
		<td><?php echo h($notificationsUser['NotificationsUser']['created']); ?>&nbsp;</td>
		<td><?php echo h($notificationsUser['NotificationsUser']['modified']); ?>&nbsp;</td>
		<td><?php echo h($notificationsUser['NotificationsUser']['is_read']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $notificationsUser['NotificationsUser']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $notificationsUser['NotificationsUser']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $notificationsUser['NotificationsUser']['id']), null, __('Are you sure you want to delete # %s?', $notificationsUser['NotificationsUser']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Notifications User'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
