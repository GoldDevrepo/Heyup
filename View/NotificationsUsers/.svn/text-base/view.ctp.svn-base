<div class="notificationsUsers view">
<h2><?php echo __('Notifications User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($notificationsUser['NotificationsUser']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($notificationsUser['User']['name'], array('controller' => 'users', 'action' => 'view', $notificationsUser['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notification'); ?></dt>
		<dd>
			<?php echo $this->Html->link($notificationsUser['Notification']['title'], array('controller' => 'notifications', 'action' => 'view', $notificationsUser['Notification']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($notificationsUser['NotificationsUser']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($notificationsUser['NotificationsUser']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Read'); ?></dt>
		<dd>
			<?php echo h($notificationsUser['NotificationsUser']['is_read']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Notifications User'), array('action' => 'edit', $notificationsUser['NotificationsUser']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Notifications User'), array('action' => 'delete', $notificationsUser['NotificationsUser']['id']), null, __('Are you sure you want to delete # %s?', $notificationsUser['NotificationsUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notifications User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
	</ul>
</div>
