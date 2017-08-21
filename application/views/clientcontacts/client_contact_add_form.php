<p>
	<label for="first_name" class="required"><span><?php echo $this->lang->line('clients_first_name');?>*:</span></label> 
	<?php
		echo form_input(
							array(
								'name'		=> 'first_name',
								'id'		=> 'first_name',
								'value'		=> set_value('first_name'),
								'size'		=> '25',
								'maxlength'	=> '25'
								)
						);
		echo form_error('first_name');
	?>
</p>

<p>
	<label for="last_name" class="required"><span><?php echo $this->lang->line('clients_last_name');?>*:</span></label> 
	<?php
		echo form_input(
							array(
								'name'		=> 'last_name',
								'id'		=> 'last_name',
								'value'		=> set_value('last_name'),
								'size'		=> '25',
								'maxlength'	=> '25'
								)
						);
		echo form_error('last_name');
	?>
</p>

<p>
	<label for="title"><span><?php echo $this->lang->line('clients_title');?>:</span></label> 
	<?php
		echo form_input(
							array(
								'name'		=> 'title',
								'id'		=> 'title',
								'value'		=> set_value('title'),
								'size'		=> '25',
								'maxlength'	=> '40'
								)
						);
		echo form_error('title');
	?>
</p>

<p>
	<label for="email" class="required"><span><?php echo $this->lang->line('clients_email');?>*:</span></label> 
	<?php
		echo form_input(
							array(
								'name'		=> 'email',
								'id'		=> 'email',
								'value'		=> set_value('email'),
								'size'		=> '25',
								'maxlength'	=> '50'
								)
						);
		echo form_error('email');
	?>
</p>

<p>
	<label for="phone"><span><?php echo $this->lang->line('clients_phone');?>:</span></label> 
	<?php
		echo form_input(
							array(
								'name'		=> 'phone',
								'id'		=> 'phone',
								'value'		=> set_value('phone'),
								'size'		=> '20',
								'maxlength'	=> '20'
								)
						);
		echo form_error('phone');
	?>
</p>

<p class="required">
	* <?php echo $this->lang->line('actions_required_fields');?>
</p>
