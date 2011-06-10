<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('clients'); ?><?php $this->load->view('dashboard/btn_add', array('btn_name'=>'btn_add_client', 'btn_value'=>$this->lang->line('add_client'))); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first"><?php echo anchor('clients/index/order_by/client_id', $this->lang->line('id')); ?></th>
					<th scope="col" ><?php echo anchor('clients/index/order_by/name', $this->lang->line('name')); ?></th>
					<th scope="col" ><?php echo anchor('clients/index/order_by/balance', $this->lang->line('balance')); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($clients as $client) { ?>
				<tr>
					<td class="first"><?php echo $client->client_id; ?></td>
					<td nowrap="nowrap"><?php echo $client->client_name; ?></td>
					<td><?php echo display_currency($client->client_total_balance); ?></td>
					<td class="last">
						<a href="<?php echo site_url('clients/details/client_id/' . $client->client_id); ?>" title="<?php echo $this->lang->line('view'); ?>">
							<?php echo icon('zoom'); ?>
						</a>
						<a href="<?php echo site_url('clients/form/client_id/' . $client->client_id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('clients/delete/client_id/' . $client->client_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('client_delete_warning'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_clients->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_clients->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>'clients/sidebar')); ?>

<?php $this->load->view('dashboard/footer'); ?>