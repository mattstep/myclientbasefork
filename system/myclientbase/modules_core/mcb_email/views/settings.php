<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/settings_email.js"></script>

<dl>
	<dt><?php echo $this->lang->line('protocol'); ?></dt>
	<dd>
	<select name="email_settings[email_protocol]" id="email_protocol">
		<option value="php_mail_function" <?php if($this->mdl_mcb_data->email_protocol == 'php_mail_function'){ ?>selected="selected"<?php } ?>><?php echo $this->lang->line('php_mail_function'); ?></option>
		<option value="sendmail" <?php if($this->mdl_mcb_data->email_protocol == 'sendmail'){ ?>selected="selected"<?php } ?>><?php echo $this->lang->line('sendmail'); ?></option>
		<option value="smtp" <?php if($this->mdl_mcb_data->email_protocol == 'smtp'){ ?>selected="selected"<?php } ?>><?php echo $this->lang->line('smtp'); ?></option>
	</select>
	</dd>
</dl>

<dl style="display: none;" class="sendmail">
	<dt><?php echo $this->lang->line('sendmail_path'); ?></dt>
	<dd><input type="text" name="email_settings[sendmail_path]" value="<?php echo $this->mdl_mcb_data->sendmail_path; ?>" /></dd>
</dl>

<dl style="display: none;" class="smtp">
	<dt><?php echo $this->lang->line('smtp_host'); ?></dt>
	<dd><input type="text" name="email_settings[smtp_host]" value="<?php echo $this->mdl_mcb_data->smtp_host; ?>" /></dd>
</dl>

<dl style="display: none;" class="smtp">
	<dt><?php echo $this->lang->line('smtp_user'); ?></dt>
	<dd><input type="text" name="email_settings[smtp_user]" value="<?php echo $this->mdl_mcb_data->smtp_user; ?>" /></dd>
</dl>

<dl style="display: none;" class="smtp">
	<dt><?php echo $this->lang->line('smtp_password'); ?></dt>
	<dd><input type="password" name="email_settings[smtp_pass]" value="<?php echo $this->mdl_mcb_data->smtp_pass; ?>" /></dd>
</dl>

<dl style="display: none;" class="smtp">
	<dt><?php echo $this->lang->line('smtp_port'); ?></dt>
	<dd><input type="text" name="email_settings[smtp_port]" value="<?php echo $this->mdl_mcb_data->smtp_port; ?>" /></dd>
</dl>

<dl style="display: none;" class="smtp">
	<dt><?php echo $this->lang->line('security'); ?></dt>
	<dd>
		<select name="email_settings[smtp_security]">
			<?php foreach ($security_options as $key=>$option) { ?>
				<option value="<?php echo $key; ?>" <?php if ($this->mdl_mcb_data->smtp_security == $key) { ?>selected="selected"<?php } ?>><?php echo $option; ?></option>
			<?php } ?>
		</select>
	</dd>
</dl>

<dl style="display: none;" class="smtp">
	<dt><?php echo $this->lang->line('smtp_timeout'); ?></dt>
	<dd><input type="text" name="email_settings[smtp_timeout]" value="<?php echo $this->mdl_mcb_data->smtp_timeout; ?>" /></dd>
</dl>

<dl>
	<dt><?php echo $this->lang->line('default_cc'); ?></dt>
	<dd><input type="text" name="email_settings[default_cc]" value="<?php echo $this->mdl_mcb_data->default_cc; ?>"</dd>
</dl>

<dl>
	<dt><?php echo $this->lang->line('default_bcc'); ?></dt>
	<dd><input type="text" name="email_settings[default_bcc]" value="<?php echo $this->mdl_mcb_data->default_bcc; ?>"</dd>
</dl>