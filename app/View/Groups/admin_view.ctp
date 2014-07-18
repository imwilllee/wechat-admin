<div class="groups view">
<h2><?php echo __('Group'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($group['Group']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($group['Group']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($group['Group']['is_active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Explain'); ?></dt>
		<dd>
			<?php echo h($group['Group']['explain']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($group['Group']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created By'); ?></dt>
		<dd>
			<?php echo h($group['Group']['created_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($group['Group']['updated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated By'); ?></dt>
		<dd>
			<?php echo h($group['Group']['updated_by']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group'), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $group['Group']['id']), array(), __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Group Accesses'), array('controller' => 'group_accesses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Access'), array('controller' => 'group_accesses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Group Accesses'); ?></h3>
	<?php if (!empty($group['GroupAccess'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Menu Action Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['GroupAccess'] as $groupAccess): ?>
		<tr>
			<td><?php echo $groupAccess['group_id']; ?></td>
			<td><?php echo $groupAccess['menu_action_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'group_accesses', 'action' => 'view', $groupAccess['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'group_accesses', 'action' => 'edit', $groupAccess['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'group_accesses', 'action' => 'delete', $groupAccess['id']), array(), __('Are you sure you want to delete # %s?', $groupAccess['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Group Access'), array('controller' => 'group_accesses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($group['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Group Id'); ?></th>
		<th><?php echo __('Is Active'); ?></th>
		<th><?php echo __('Mobile'); ?></th>
		<th><?php echo __('Alias Name'); ?></th>
		<th><?php echo __('Avatar'); ?></th>
		<th><?php echo __('Sex'); ?></th>
		<th><?php echo __('Birth'); ?></th>
		<th><?php echo __('Last Logined'); ?></th>
		<th><?php echo __('Last Login Ip'); ?></th>
		<th><?php echo __('Last User Agent'); ?></th>
		<th><?php echo __('Secret Key'); ?></th>
		<th><?php echo __('Secret Key Expired'); ?></th>
		<th><?php echo __('Explain'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Created By'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Updated By'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($group['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><?php echo $user['group_id']; ?></td>
			<td><?php echo $user['is_active']; ?></td>
			<td><?php echo $user['mobile']; ?></td>
			<td><?php echo $user['alias_name']; ?></td>
			<td><?php echo $user['avatar']; ?></td>
			<td><?php echo $user['sex']; ?></td>
			<td><?php echo $user['birth']; ?></td>
			<td><?php echo $user['last_logined']; ?></td>
			<td><?php echo $user['last_login_ip']; ?></td>
			<td><?php echo $user['last_user_agent']; ?></td>
			<td><?php echo $user['secret_key']; ?></td>
			<td><?php echo $user['secret_key_expired']; ?></td>
			<td><?php echo $user['explain']; ?></td>
			<td><?php echo $user['created']; ?></td>
			<td><?php echo $user['created_by']; ?></td>
			<td><?php echo $user['updated']; ?></td>
			<td><?php echo $user['updated_by']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), array(), __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
