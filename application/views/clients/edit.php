<?php
$this->load->view('header');
?>
<h2><?php echo $page_title; ?></h2>

<?php echo form_open('clients/edit', array('id' => 'newClientForm', 'onsubmit' => 'return requiredFields();'), array('id'=>$row->id));?>

	<p><label><span><?php echo $this->lang->line('clients_name');?>:</span> <input class="requiredfield" type="text" id="clientName" name="clientName" size="50" maxlength="50" value="<?php echo (set_value('clientName')) ? (set_value('clientName')) : ($row->name);?>" /></label> <?php echo form_error('clientName'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_website');?>:</span> <input type="text" name="website" id="website" size="50" maxlength="50" value="<?php echo (set_value('website')) ? (set_value('website')) : ($row->website);?>" /></label> <?php echo form_error('website'); ?></p>
	<div class="address">
	<p><label><span><?php echo $this->lang->line('clients_address1');?>:</span> <input type="text" name="address1" id="address1" size="50" maxlength="50" value="<?php echo (set_value('address1')) ? (set_value('address1')) : ($row->address1);?>" /></label> <?php echo form_error('address1'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_address2');?>:</span> <input type="text" name="address2" id="address2" size="50" maxlength="50" value="<?php echo (set_value('address2')) ? (set_value('address2')) : ($row->address2);?>" /></label> <?php echo form_error('address2'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_city');?>:</span> <input type="text" name="city" id="city" size="50" maxlength="50" value="<?php echo (set_value('city')) ? (set_value('city')) : ($row->city);?>" /></label> <?php echo form_error('city'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_province');?>:</span> <input type="text" name="province" id="province" size="25" maxlength="25" value="<?php echo (set_value('province')) ? (set_value('province')) : ($row->province);?>" /></label> <?php echo form_error('province'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_country');?>:</span> <input type="text" name="country" id="country" size="25" maxlength="25" value="<?php echo (set_value('country')) ? (set_value('country')) : ($row->country);?>" /></label><?php echo form_error('country'); ?></p>
	<p><label><span><?php echo $this->lang->line('clients_postal');?>:</span> <input type="text" name="postal_code" id="postal_code" size="10" maxlength="10" value="<?php echo (set_value('postal_code')) ? (set_value('postal_code')) : ($row->postal_code);?>" /></label> <?php echo form_error('postal_code'); ?></p>
	</div>

	<p><label><span><?php echo $this->lang->line('settings_tax_code');?>:</span> <input type="text" name="tax_code" id="tax_code" size="50" maxlength="75" value="<?php echo (set_value('tax_code')) ? (set_value('tax_code')) : ($row->tax_code);?>" /></label> <?php echo form_error('tax_code'); ?></p>

	<fieldset style="clear:left;"><legend><?php echo $this->lang->line('invoice_tax_status');?>:</legend>
	<?php if ($row->tax_status): ?>
	<label for="taxable"><input type="radio" name="tax_status" id="taxable" value="1" checked="checked" class="noborder" /><?php echo $this->lang->line('invoice_taxable');?></label><br />
	<label for="notax"><input type="radio" name="tax_status" id="notax" value="0" class="noborder" /><?php echo $this->lang->line('invoice_not_taxable');?></label>
	<?php else:?>
	<label for="taxable"><input type="radio" name="tax_status" id="taxable" value="1" class="noborder" /><?php echo $this->lang->line('invoice_taxable');?></label><br />
	<label for="notax"><input type="radio" name="tax_status" id="notax" value="0" checked="checked" class="noborder" /><?php echo $this->lang->line('invoice_not_taxable');?></label>
	<?php endif;?>
	</fieldset>

	<p><?php echo form_submit('updateClient', $this->lang->line('clients_update_client'), 'id="updateClient"');?></p>

<?php echo form_close();?>

<?php
$this->load->view('footer');
?>
