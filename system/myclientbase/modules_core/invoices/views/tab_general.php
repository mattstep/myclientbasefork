<div class="left_box">

	<dl>
		<dt><label><?php echo $this->lang->line('client'); ?>: </label></dt>
		<dd>
			<?php if ($invoice->client->client_active) { ?>
			<select name="client_id">
				<?php foreach ($clients as $client) { ?>
				<option value="<?php echo $client->client_id; ?>" <?php if($invoice->client_id == $client->client_id) { ?>selected="selected"<?php } ?>><?php echo character_limiter($client->client_name, 25); ?></option>
					<?php } ?>
			</select>
			<?php } else { ?>
			<?php echo $invoice->client->client_name; ?>
			<?php } ?>
		</dd>
	</dl>

	<dl>
		<dt><label><?php echo $this->lang->line('user'); ?>: </label></dt>
		<dd><?php echo $invoice->username; ?></dd>
	</dl>

	<?php if (!$invoice->invoice_is_quote) { ?>
	<dl>
		<dt><label><?php echo $this->lang->line('invoice_status'); ?>: </label></dt>
		<dd>
			<select name="invoice_status_id">
				<?php foreach ($invoice_statuses as $invoice_status) { ?>
				<option value="<?php echo $invoice_status->invoice_status_id; ?>" <?php if($invoice_status->invoice_status_id == $invoice->invoice_status_id) { ?>selected="selected"<?php } ?>><?php echo $invoice_status->invoice_status; ?></option>
				<?php } ?>
			</select>
		</dd>
	</dl>
	<?php } ?>

	<dl>
		<dt><label><?php echo (!$invoice->invoice_is_quote ? $this->lang->line('invoice_date') : $this->lang->line('date')); ?>: </label></dt>
		<dd><input class="datepicker" type="text" name="invoice_date_entered" value="<?php echo format_date($invoice->invoice_date_entered); ?>" /></dd>
	</dl>

	<?php if (!$invoice->invoice_is_quote) { ?>
	<dl>
		<dt><label><?php echo $this->lang->line('due_date'); ?>: </label></dt>
		<dd><input class="datepicker" type="text" name="invoice_due_date" value="<?php echo format_date($invoice->invoice_due_date); ?>" /></dd>
	</dl>
	<?php } ?>

	<dl>
		<dt><label><?php echo $this->lang->line('generate'); ?>: </label></dt>
		<dd>
			<a href="javascript:void(0)" class="output_link" id="<?php echo $invoice->invoice_id; ?>"><?php echo $this->lang->line('generate'); ?></a>
		</dd>
	</dl>

	<input type="submit" id="btn_submit" name="btn_submit_options_general" value="<?php echo $this->lang->line('save_options'); ?>" />

</div>

<div class="right_box">

	<dl>
		<dt><label><?php echo $this->lang->line('subtotal'); ?>: </label></dt>
		<dd><?php echo invoice_item_subtotal($invoice); ?></dd>
	</dl>

	<dl>
		<dt><label><?php echo $this->lang->line('tax'); ?>: </label></dt>
		<dd><?php echo invoice_tax_total($invoice); ?></dd>
	</dl>

	<?php if ($invoice->invoice_shipping > 0) { ?>
	<dl>
		<dt><label><?php echo $this->lang->line('shipping'); ?>: </label></dt>
		<dd><?php echo invoice_shipping($invoice); ?></dd>
	</dl>
	<?php } ?>

	<?php if ($invoice->invoice_discount > 0) { ?>
	<dl>
		<dt><label><?php echo $this->lang->line('discount'); ?>: </label></dt>
		<dd><?php echo invoice_discount($invoice); ?></dd>
	</dl>
	<?php } ?>

	<dl>
		<dt><label><?php echo $this->lang->line('grand_total'); ?>: </label></dt>
		<dd><?php echo invoice_total($invoice); ?></dd>
	</dl>

	<?php if (!$invoice->invoice_is_quote) { ?>
	<dl>
		<dt><label><?php echo $this->lang->line('paid'); ?>: </label></dt>
		<dd><?php echo invoice_paid($invoice); ?></dd>
	</dl>

	<dl>
		<dt><label><?php echo $this->lang->line('invoice_balance'); ?>: </label></dt>
		<dd><?php echo invoice_balance($invoice); ?></dd>
	</dl>
	<?php } ?>

</div>

<div style="clear: both;">&nbsp;</div>