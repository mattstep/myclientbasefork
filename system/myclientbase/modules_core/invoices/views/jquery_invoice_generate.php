<script type="text/javascript">

	$(function() {

		$('#output_dialog').dialog({
			modal: true,
			draggable: false,
			resizable: false,
			autoOpen: false,
			title: '<?php echo $this->lang->line('generate_invoice'); ?>',
			buttons: {
				'<?php echo $this->lang->line('generate'); ?>': function() {
					$(this).dialog('close');
					generate_invoice();
				},
				'<?php echo $this->lang->line('cancel'); ?>': function() {
					$(this).dialog('close');
				}
			}
		});

		$('.output_link').click(function() {

			invoice_id = $(this).attr('id');

			$('#output_dialog').dialog('open');

		});

		function generate_invoice() {

			var invoice_output_type = $('#invoice_output_type').val();

			var invoice_template = $('#invoice_template').val();

			if (invoice_output_type != 'email') {

				download_url = '<?php echo site_url('invoices/generate_'); ?>' + invoice_output_type + '/invoice_id/' + invoice_id + '/invoice_template/' + invoice_template;

				window.open(download_url);

			}

			else {

				var email_url = '<?php echo site_url('invoices/send_email/form/invoice_id'); ?>' + '/' + invoice_id + '/invoice_template/' + invoice_template;

				window.location = email_url;

			}

		}

	});

</script>

<div id="output_dialog">
	<table style="width: 100%;">
		<tr>
			<td><?php echo $this->lang->line('output_type'); ?>: </td>
			<td>
				<select name="invoice_output_type" id="invoice_output_type">
					<option value="pdf"><?php echo $this->lang->line('pdf'); ?></option>
					<option value="html"><?php echo $this->lang->line('html'); ?></option>
					<option value="email"><?php echo $this->lang->line('email'); ?></option>
				</select>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->lang->line('invoice_template'); ?>: </td>
			<td>
				<select name="invoice_template" id="invoice_template">
					<?php foreach ($templates as $template) { ?>
						<?php if (uri_assoc('is_quote') or isset($invoice) and $invoice->invoice_is_quote) { ?>
							<option <?php if ($template == $default_quote_template) { ?>selected="selected"<?php } ?>><?php echo $template; ?></option>
						<?php } else { ?>
							<option <?php if ($template == $default_invoice_template) { ?>selected="selected"<?php } ?>><?php echo $template; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
			</td>
		</tr>
	</table>
</div>