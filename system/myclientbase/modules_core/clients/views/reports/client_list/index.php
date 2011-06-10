<?php $this->load->view('dashboard/header'); ?>

<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('client_detail_report'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

			<?php $this->load->view('reports/client_list/options'); ?>

			</form>

			<?php if ($validated) { ?>

			<hr />

				<?php if ($result_clients) { ?>

					<?php $this->load->view('reports/client_list/result_table'); ?>

					<?php } else { ?>
						<p><?php echo $this->lang->line('no_records_found'); ?>.</p><br />
					<?php } ?>

				<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>