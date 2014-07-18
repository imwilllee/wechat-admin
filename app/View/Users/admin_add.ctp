<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('group_id');
		echo $this->Form->input('is_active');
		echo $this->Form->input('mobile');
		echo $this->Form->input('alias_name');
		echo $this->Form->input('avatar');
		echo $this->Form->input('sex');
		echo $this->Form->input('birth');
		echo $this->Form->input('last_logined');
		echo $this->Form->input('last_login_ip');
		echo $this->Form->input('last_user_agent');
		echo $this->Form->input('secret_key');
		echo $this->Form->input('secret_key_expired');
		echo $this->Form->input('explain');
		echo $this->Form->input('created_by');
		echo $this->Form->input('updated_by');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
