<?php $this->load->view('dashboard/header'); ?>

<?php $this->load->view('invoice_items/invoice_item_select'); ?>

<?php $this->load->view('dashboard/jquery_date_picker'); ?>

<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('invoice_number') . ' ' . invoice_id($invoice); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="#" name="invoice_item_selection" id="invoice_item_selection">

				<dl>
					<dt><label></label></dt>
					<dd>
						<select name="invoice_stored_item_id" id="invoice_stored_item_id">
							<option value="please_select"><?php echo $this->lang->line('choose_stored_item'); ?></option>
							<?php foreach ($invoice_items as $invoice_item) { ?>
								<option value="<?php echo $invoice_item->invoice_stored_item_id; ?>"><?php echo $invoice_item->invoice_stored_item; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>

			</form>

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" name="invoice_item_form">

				<dl>
					<dt><label><?php echo $this->lang->line('item_date'); ?>: </label></dt>
					<dd><input class="datepicker" type="text" name="item_date" value="<?php echo $this->mdl_items->item_date; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('quantity'); ?>: </label></dt>
					<dd><input type="text" name="item_qty" id="item_qty" value="<?php echo format_qty($this->mdl_items->item_qty); ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('item_name'); ?>: </label></dt>
					<dd><input type="text" name="item_name" id="item_name" value="<?php echo $this->mdl_items->item_name; ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('item_description'); ?>: </label></dt>
					<dd><textarea name="item_description" id="item_description" rows="5" cols="40"><?php echo $this->mdl_items->item_description; ?></textarea></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('unit_price'); ?>: </label></dt>
					<dd><input type="text" name="item_price" id="item_price" value="<?php if(isset($this->mdl_items->item_price)) { echo format_number($this->mdl_items->item_price); } ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('tax_rate'); ?>: </label></dt>
					<dd>
						<select name="tax_rate_id">
							<?php foreach ($tax_rates as $tax_rate) { ?>
							<option value="<?php echo $tax_rate->tax_rate_id; ?>" <?php if($this->mdl_items->tax_rate_id == $tax_rate->tax_rate_id) { ?>selected="selected"<?php } ?>><?php echo $tax_rate->tax_rate_percent . '% - ' . $tax_rate->tax_rate_name; ?></option>
							<?php } ?>
						</select>
					</dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('taxable'); ?>: </label></dt>
					<dd><input type="checkbox" name="is_taxable" value="1" <?php if ($this->mdl_items->is_taxable) { ?>checked="checked"<?php } ?> /></dd>
				</dl>

				<?php foreach ($custom_fields as $field) { ?>
				<dl>
					<dt><label><?php echo $field->field_name ?>: </label></dt>
					<dd><input type="text" id="<?php echo $field->column_name; ?>" name="<?php echo $field->column_name; ?>" value="<?php echo $this->mdl_items->{$field->column_name}; ?>" /></dd>
				</dl>
				<?php } ?>

				<input type="submit" name="btn_submit_item" id="btn_submit" value="<?php echo $this->lang->line('save_item'); ?>" />
				<input type="submit" name="btn_cancel" id="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>