<?php $this->load->view('dashboard/header'); ?>

<div class="container_10" id="center_wrapper">

	<div class="grid_7" id="content_wrapper">

		<div class="section_wrapper">

			<h3 class="title_black"><?php echo $this->lang->line('invoice_item_form'); ?></h3>

			<?php $this->load->view('dashboard/system_messages'); ?>

			<div class="content toggle">

				<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

					<dl>
						<dt><label><?php echo $this->lang->line('item_name'); ?>: </label></dt>
						<dd><input type="text" name="invoice_stored_item" id="invoice_stored_item" value="<?php echo $this->mdl_invoice_items->invoice_stored_item; ?>" /></dd>
					</dl>
					
					<dl>
						<dt><label><?php echo $this->lang->line('item_description'); ?></label></dt>
						<dd><textarea name="invoice_stored_description" id="invoice_stored_description"><?php echo $this->mdl_invoice_items->invoice_stored_description; ?></textarea></dd>
					</dl>

					<dl>
						<dt><label><?php echo $this->lang->line('unit_price'); ?>: </label></dt>
						<dd><input type="text" name="invoice_stored_unit_price" id="invoice_stored_unit_price" value="<?php echo format_number($this->mdl_invoice_items->invoice_stored_unit_price); ?>" /></dd>
					</dl>

					<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
					<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

				</form>

			</div>

		</div>

	</div>
</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>'invoice_items/sidebar')); ?>

<?php $this->load->view('dashboard/footer'); ?>