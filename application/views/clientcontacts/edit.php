<?php
$this->load->view('header');
?>

<h2><?php echo $page_title;?></h2>

<?php echo form_open('clientcontacts/edit', array('id' => 'clientcontact'), array('id'=>$id));?>

	<input type="hidden" id="client_id" name="client_id" value="<?php echo (set_value('client_id')) ? (set_value('client_id')) : ($clientContactData->client_id);?>" />

	<p><label><span class="required"><?php echo $this->lang->line('clients_first_name');?>*:</span> <input type="text" name="first_name" id="first_name" size="25" maxlength="25" value="<?php echo (set_value('first_name')) ? (set_value('first_name')) : ($clientContactData->first_name);?>" /></label> <?php echo form_error('first_name'); ?></p>
	<p><label><span class="required"><?php echo $this->lang->line('clients_last_name');?>*:</span> <input type="text" name="last_name" id="last_name" size="25" maxlength="25" value="<?php echo (set_value('last_name')) ? (set_value('last_name')) : ($clientContactData->last_name);?>" /></label> <?php echo form_error('last_name'); ?></p>
	<p><label><span class="required"><?php echo $this->lang->line('clients_title');?>*:</span> <input type="text" name="title" id="title" size="25" maxlength="50" value="<?php echo (set_value('title')) ? (set_value('title')) : ($clientContactData->title);?>" /></label> <?php echo form_error('title'); ?></p>
	<p><label><span class="required"><?php echo $this->lang->line('clients_email');?>*:</span> <input type="text" name="email" id="email" size="25" maxlength="50" value="<?php echo (set_value('email')) ? (set_value('email')) : ($clientContactData->email);?>" /></label> <?php echo form_error('email'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_phone');?>:</span> <input type="text" name="phone" id="phone" size="25" maxlength="50" value="<?php echo (set_value('phone')) ? (set_value('phone')) : ($clientContactData->phone);?>" /></label> <?php echo form_error('phone'); ?></p>
	<p class="required">* <?php echo $this->lang->line('actions_required_fields');?></p>

	<p><?php echo form_submit('createClient', $this->lang->line('clients_edit_client'), 'id="createClient"');?></p>

<?php echo form_close();?>

<?php
$this->load->view('footer');
?>
