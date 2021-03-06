<?php $this->load->view('dashboard/header'); ?>

<?php echo modules::run('invoices/widgets/generate_dialog'); ?>

<?php $this->load->view('invoices/jquery_invoice_history'); ?>

<div class="grid_7" id="content_wrapper">

	<?php $this->load->view('dashboard/system_messages'); ?>

	<?php if ($this->mdl_mcb_data->dashboard_show_overdue_invoices == "TRUE") { ?>

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('overdue_invoices'); ?></h3>

		<div class="content toggle no_padding">

			<?php $this->load->view('invoices/invoice_table', array('invoices'=>$overdue_invoices)); ?>

		</div>

	</div>

	<?php } ?>

	<?php if ($this->mdl_mcb_data->dashboard_show_open_invoices == "TRUE") { ?>

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('open_invoices'); ?></h3>

		<div class="content toggle no_padding">

			<?php $this->load->view('invoices/invoice_table', array('invoices'=>$open_invoices)); ?>

		</div>

	</div>

	<?php } ?>

	<?php if ($this->mdl_mcb_data->dashboard_show_pending_invoices == "TRUE") { ?>

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('pending_invoices'); ?></h3>

		<div class="content toggle no_padding">

			<?php $this->load->view('invoices/invoice_table', array('invoices'=>$pending_invoices)); ?>

		</div>

	</div>

	<?php } ?>

	<?php if ($this->mdl_mcb_data->dashboard_show_closed_invoices == "TRUE") { ?>

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('recently_closed_invoices'); ?></h3>

		<div class="content toggle no_padding">

			<?php $this->load->view('invoices/invoice_table', array('invoices'=>$closed_invoices)); ?>

		</div>

	</div>

	<?php } ?>

	<?php echo modules::run('dashboard/show_widgets'); ?>

</div>

<?php $this->load->view('dashboard/sidebar',
	array('side_block'=>array('dashboard/sidebar_custom_modules'),
	'show_quicklinks'=>TRUE,
	'side_widgets'=>array('dashboard/dashboard_widgets/total_balance'))); ?>

<?php $this->load->view('dashboard/footer'); ?>