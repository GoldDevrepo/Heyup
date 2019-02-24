<div class="checkins view">
<h2><?php echo __('Checkin'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($checkin['User']['name'], array('controller' => 'users', 'action' => 'view', $checkin['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['lng']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timeline'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['timeline']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($checkin['Checkin']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Checkin'), array('action' => 'edit', $checkin['Checkin']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Checkin'), array('action' => 'delete', $checkin['Checkin']['id']), null, __('Are you sure you want to delete # %s?', $checkin['Checkin']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Checkins'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Checkin'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
