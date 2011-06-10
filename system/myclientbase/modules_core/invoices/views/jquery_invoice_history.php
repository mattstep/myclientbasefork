<script type="text/javascript">

	$(function() {

		$('#invoice_history_dialog').dialog({
			modal: true,
			draggable: true,
			resizable: false,
			autoOpen: false,
			width: 600,
			height: 400,
			title: '<?php echo $this->lang->line('invoice_history'); ?>',
			buttons: {
				'<?php echo $this->lang->line('close'); ?>': function() {
					$(this).dialog('close');
				}
			}
		});

		$('.invoice_history_link').click(function() {

			invoice_id = $(this).attr('id').replace('invoice_history_link_', '');

			$('#invoice_history_dialog').load('<?php echo site_url('invoices/jquery_load_history'); ?>',
			{
				invoice_id: invoice_id
			});

			$('#invoice_history_dialog').dialog('open');

		});

	});

</script>

<div id="invoice_history_dialog"></div>