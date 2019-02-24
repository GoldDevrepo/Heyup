<div class="users index">
	<h2><?php echo __('Users'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('dob'); ?></th>
			<th><?php echo $this->Paginator->sort('password'); ?></th>
			<th><?php echo $this->Paginator->sort('lives_in'); ?></th>
			<th><?php echo $this->Paginator->sort('tagline'); ?></th>
			<th><?php echo $this->Paginator->sort('hair_color'); ?></th>
			<th><?php echo $this->Paginator->sort('about_me'); ?></th>
			<th><?php echo $this->Paginator->sort('gender'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('mobile_no'); ?></th>
			<th><?php echo $this->Paginator->sort('latest_activity'); ?></th>
			<th><?php echo $this->Paginator->sort('is_message'); ?></th>
			<th><?php echo $this->Paginator->sort('is_notify'); ?></th>
			<th><?php echo $this->Paginator->sort('is_friend_request'); ?></th>
			<th><?php echo $this->Paginator->sort('search_type'); ?></th>
			<th><?php echo $this->Paginator->sort('sound'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['dob']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['password']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['lives_in']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['tagline']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['hair_color']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['about_me']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['gender']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['mobile_no']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['latest_activity']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['is_message']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['is_notify']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['is_friend_request']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['search_type']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['sound']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
<?php echo $this->element('menu');?>
