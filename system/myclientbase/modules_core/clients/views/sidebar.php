<div class="section_wrapper">

	<h3 class="title_white"><?php echo $this->lang->line('clients'); ?></h3>

	<ul class="quicklinks content toggle">
		<li><?php echo anchor('clients', $this->lang->line('view_clients')); ?></li>
		<li><?php echo anchor('clients/form', $this->lang->line('add_client')); ?></li>
		<li class="last"><?php echo anchor('clients/reports/client_list', $this->lang->line('client_detail_report')); ?></li>
	</ul>

</div>