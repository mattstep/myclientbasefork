<dl>
	<dt><label><?php echo $this->lang->line('active_client'); ?>: </label></dt>
	<dd><input type="checkbox" name="client_active" id="client_active" value="1" <?php if ($this->mdl_clients->client_active or (!$_POST and !uri_assoc('client_id'))) { ?>checked="checked"<?php } ?> /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('client_name'); ?>: </label></dt>
	<dd><input type="text" name="client_name" id="client_name" value="<?php echo $this->mdl_clients->client_name; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('tax_id_number'); ?>: </label></dt>
	<dd><input type="text" name="client_tax_id" id="client_tax_id" value="<?php echo $this->mdl_clients->client_tax_id; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('street_address'); ?>: </label></dt>
	<dd><input type="text" name="client_address" id="client_address" value="<?php echo $this->mdl_clients->client_address; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('street_address_2'); ?>: </label></dt>
	<dd><input type="text" name="client_address_2" id="client_address_2" value="<?php echo $this->mdl_clients->client_address_2; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('city'); ?>: </label></dt>
	<dd><input type="text" name="client_city" id="client_city" value="<?php echo $this->mdl_clients->client_city; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('state'); ?>: </label></dt>
	<dd><input type="text" name="client_state" id="client_state" value="<?php echo $this->mdl_clients->client_state; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('zip'); ?>: </label></dt>
	<dd><input type="text" name="client_zip" id="client_zip" value="<?php echo $this->mdl_clients->client_zip; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('country'); ?>: </label></dt>
	<dd><input type="text" name="client_country" id="client_country" value="<?php echo $this->mdl_clients->client_country; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('phone_number'); ?>: </label></dt>
	<dd><input type="text" name="client_phone_number" id="client_phone_number" value="<?php echo $this->mdl_clients->client_phone_number; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('fax_number'); ?>: </label></dt>
	<dd><input type="text" name="client_fax_number" id="client_fax_number" value="<?php echo $this->mdl_clients->client_fax_number; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('mobile_number'); ?>: </label></dt>
	<dd><input type="text" name="client_mobile_number" id="client_mobile_number" value="<?php echo $this->mdl_clients->client_mobile_number; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('email_address'); ?>: </label></dt>
	<dd><input type="text" name="client_email_address" id="client_email_address" value="<?php echo $this->mdl_clients->client_email_address; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('web_address'); ?>: </label></dt>
	<dd><input type="text" name="client_web_address" id="client_web_address" value="<?php echo $this->mdl_clients->client_web_address; ?>" /></dd>
</dl>

<dl>
	<dt><label><?php echo $this->lang->line('notes'); ?>: </label></dt>
	<dd><textarea name="client_notes" id="client_notes" rows="5" cols="40"><?php echo form_prep($this->mdl_clients->client_notes); ?></textarea></dd>
</dl>

<?php foreach ($custom_fields as $custom_field) { ?>
<dl>
	<dt><label><?php echo $custom_field->field_name; ?>: </label></dt>
	<dd><input type="text" name="<?php echo $custom_field->column_name; ?>" id="<?php echo $custom_field->column_name; ?>" value="<?php echo $this->mdl_clients->{$custom_field->column_name}; ?>" /></dd>
</dl>
<?php } ?>

<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

<div style="clear: both;">&nbsp;</div>