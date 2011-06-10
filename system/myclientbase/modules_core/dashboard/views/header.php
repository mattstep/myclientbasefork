<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $this->lang->line('myclientbase'); ?></title>
		<link href="<?php echo base_url(); ?>assets/style/css/styles.css" rel="stylesheet" type="text/css" media="screen" />
		<!--[if IE 6]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/style/css/ie6.css" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/style/css/ie7.css" /><![endif]-->
		<link type="text/css" href="<?php echo base_url(); ?>assets/jquery/ui-themes/myclientbase1/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/jquery-ui-1.8.4.custom.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/jquery/jquery.maskedinput-1.2.2.min.js" type="text/javascript"></script>

		<?php if (isset($header_insert)) { $this->load->view($header_insert); } ?>

		<script type="text/javascript">
			$(function() {
				if($('#navigation li.selected ul'))
				{
					$('#navigation li.selected ul').css('display', 'block');
				}

				$('#navigation li').hover(function() {
					$('#navigation li ul').css('display', 'none');
					$(this).find('ul').css('display', 'block');

				}, function() {
					$(this).find('ul').css('display', 'block');
				});
			});
		</script>

	</head>
	<body>

		<div id="header_wrapper">

			<div class="container_10" id="header_content">

				<h1><?php echo $this->lang->line('myclientbase'); ?></h1>

			</div>

		</div>

		<div id="navigation_wrapper">

			<ul class="container_10" id="navigation">

				<li <?php if (!$this->uri->segment(1) or $this->uri->segment(1) == 'dashboard') { ?>class="selected"<?php } ?>><?php echo anchor('dashboard', $this->lang->line('dashboard')); ?></li>
				<li <?php if ($this->uri->segment(1) == 'clients') { ?>class="selected"<?php } ?>>
					<?php echo anchor('clients', $this->lang->line('clients')); ?>
					
					<ul>
						<li><?php echo anchor('clients', $this->lang->line('view_clients')); ?> |</li>
						<li><?php echo anchor('clients/form', $this->lang->line('add_client')); ?> |</li>
						<li><?php echo anchor('clients/reports/client_list', $this->lang->line('client_detail_report')); ?> |</li>
					</ul>
				</li>
				<li <?php if ($this->uri->segment(2) <> 'invoice_groups' and ($this->uri->segment(1) == 'invoices' or 
					$this->uri->segment(1) == 'invoice_items' or $this->uri->segment(1) == 'invoice_search' or 
					($this->uri->segment(1) == 'templates' and $this->uri->segment(4) == 'invoices'))) { ?>class="selected"<?php } ?>>
					<?php echo anchor('invoices/index', $this->lang->line('invoices')); ?>
					<ul>
						<li><?php echo anchor('invoices/create', $this->lang->line('create_invoice')); ?> |</li>
						<li><?php echo anchor('invoices/index', $this->lang->line('view_invoices')); ?> |</li>
						<li><?php echo anchor('invoices/index/is_quote/1', $this->lang->line('view_quotes')); ?> |</li>
						<li><?php echo anchor('invoice_search', $this->lang->line('invoice_search')); ?> |</li>
						<li><?php echo anchor('invoice_items', $this->lang->line('invoice_items')); ?> |</li>
						<li><?php echo anchor('templates/index/type/invoices', $this->lang->line('invoice_templates')); ?></li>
					</ul>
					
				</li>
				<li <?php if ($this->uri->segment(1) == 'payments' or ($this->uri->segment(1) == 'templates' and $this->uri->segment(4) == 'payment_receipts')) { ?>class="selected"<?php } ?>>
					<?php echo anchor('payments/index', $this->lang->line('payments')); ?>
					<ul>
						<li><?php echo anchor('payments/index', $this->lang->line('view_payments')); ?> |</li>
						<li><?php echo anchor('payments/form', $this->lang->line('enter_payment')); ?> |</li>
						<li><?php echo anchor('payments/payment_methods', $this->lang->line('payment_methods')); ?> |</li>
						<li><?php echo anchor('templates/index/type/payment_receipts', $this->lang->line('receipt_templates')); ?> |</li>
					</ul>
					
				</li>

				<?php if ($this->session->userdata('global_admin')) { ?>

				<li <?php if ($this->uri->segment(1) == 'settings' or $this->uri->segment(1) == 'users' or
					$this->uri->segment(1) == 'tax_rates' or $this->uri->segment(1) == 'invoice_statuses' or
					$this->uri->segment(2) == 'invoice_groups' or ($this->uri->segment(1) == 'fields' or
						$this->uri->segment(1) == 'mcb_modules')) { ?>class="selected"<?php } ?>>
					<?php echo anchor('settings', $this->lang->line('system')); ?>
					<ul>
						<li><?php echo anchor('settings', $this->lang->line('system_settings')); ?></li>
						<li><?php echo anchor('users', $this->lang->line('user_accounts')); ?></li>
						<li><?php echo anchor('tax_rates', $this->lang->line('tax_rates')); ?></li>
						<li><?php echo anchor('invoice_statuses', $this->lang->line('invoice_statuses')); ?></li>
						<li><?php echo anchor('invoices/invoice_groups', $this->lang->line('invoice_groups')); ?> |</li>
						<li><?php echo anchor('fields', $this->lang->line('custom_fields')); ?> |</li>
						<li><?php echo anchor('mcb_modules', $this->lang->line('modules')); ?></li>
					</ul>
					
				</li>

				<?php } ?>
				
				<li><?php echo anchor('sessions/logout', $this->lang->line('log_out')); ?></li>
			</ul>

		</div>

		<div class="container_10" id="center_wrapper">