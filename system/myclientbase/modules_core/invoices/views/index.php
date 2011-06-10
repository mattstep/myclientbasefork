<?php $this->load->view('dashboard/header'); ?>

<?php echo modules::run('invoices/widgets/generate_dialog'); ?>

<?php $this->load->view('invoices/jquery_invoice_history'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo (!uri_assoc('is_quote') ? $this->lang->line('invoices') : $this->lang->line('quotes')); ?><?php $this->load->view('dashboard/btn_add', array('btn_name'=>'btn_add_invoice', 'btn_value'=>$this->lang->line('create_invoice'))); ?></h3>

		<div class="content toggle no_padding">

			<?php $this->load->view('dashboard/system_messages'); ?>

			<?php $this->load->view('invoice_table'); ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>'invoices/sidebar')); ?>

<?php $this->load->view('dashboard/footer'); ?>