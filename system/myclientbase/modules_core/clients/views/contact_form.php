<?php $this->load->view('dashboard/header'); ?>

<div class="container_10" id="center_wrapper">

	<div class="grid_7" id="content_wrapper">

		<div class="section_wrapper">

			<h3 class="title_black"><?php echo $this->lang->line('contact_form'); ?></h3>

			<?php $this->load->view('dashboard/system_messages'); ?>

			<div class="content toggle">

				<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

				<dl>
					<dt><label><?php echo $this->lang->line('first_name'); ?>: </label></dt>
					<dd><input type="text" name="first_name" id="first_name" value="<?php echo $this->mdl_contacts->first_name; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('last_name'); ?>: </label></dt>
					<dd><input type="text" name="last_name" id="last_name" value="<?php echo $this->mdl_contacts->last_name; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('street_address'); ?>: </label></dt>
					<dd><input type="text" name="address" id="address" value="<?php echo $this->mdl_contacts->address; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('street_address_2'); ?>: </label></dt>
					<dd><input type="text" name="address_2" id="address_2" value="<?php echo $this->mdl_contacts->address_2; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('city'); ?>: </label></dt>
					<dd><input type="text" name="city" id="city" value="<?php echo $this->mdl_contacts->city; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('state'); ?>: </label></dt>
					<dd><input type="text" name="state" id="state" value="<?php echo $this->mdl_contacts->state; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('zip'); ?>: </label></dt>
					<dd><input type="text" name="zip" id="zip" value="<?php echo $this->mdl_contacts->zip; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('country'); ?>: </label></dt>
					<dd><input type="text" name="country" id="country" value="<?php echo $this->mdl_contacts->country; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('phone_number'); ?>: </label></dt>
					<dd><input type="text" name="phone_number" id="phone_number" value="<?php echo $this->mdl_contacts->phone_number; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('fax_number'); ?>: </label></dt>
					<dd><input type="text" name="fax_number" id="fax_number" value="<?php echo $this->mdl_contacts->fax_number; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('mobile_number'); ?>: </label></dt>
					<dd><input type="text" name="mobile_number" id="mobile_number" value="<?php echo $this->mdl_contacts->mobile_number; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('email_address'); ?>: </label></dt>
					<dd><input type="text" name="email_address" id="email_address" value="<?php echo $this->mdl_contacts->email_address; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('web_address'); ?>: </label></dt>
					<dd><input type="text" name="web_address" id="web_address" value="<?php echo $this->mdl_contacts->web_address; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('notes'); ?></label></dt>
					<td style="vertical-align: top;"><textarea name="notes" id="notes" rows="5" cols="40"><?php echo form_prep($this->mdl_contacts->notes); ?></textarea></dd>
				</dl>

				<?php foreach ($custom_fields as $custom_field) { ?>
				<dl>
					<dt><label><?php echo $custom_field->field_name; ?>: </label></dt>
					<dd><input type="text" name="<?php echo $custom_field->column_name; ?>" id="<?php echo $custom_field->column_name; ?>" value="<?php echo $this->mdl_contacts->{$custom_field->column_name}; ?>" /></dd>
				</dl>
				<?php } ?>
				
				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

				</form>

			</div>

		</div>

	</div>
</div>

<?php $this->load->view('dashboard/sidebar'); ?>

<?php $this->load->view('dashboard/footer'); ?>