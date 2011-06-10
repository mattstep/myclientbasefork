<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('invoice_items'); ?><?php $this->load->view('dashboard/btn_add', array('btn_value'=>$this->lang->line('add_invoice_item'))); ?></h3>

		<div class="content toggle no_padding">

			<table>
				<tr>
					<th scope="col" class="first" style="width: 70%;"><?php echo $this->lang->line('item'); ?></th>
					<th scope="col" style="width: 15%;"><?php echo $this->lang->line('unit_price'); ?></th>
					<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
				</tr>
				<?php foreach ($items as $item) { ?>
				<tr>
					<td class="first"><?php echo $item->invoice_stored_item; ?></td>
					<td><?php echo display_currency($item->invoice_stored_unit_price); ?></td>
					<td class="last">
						<a href="<?php echo site_url('invoice_items/form/invoice_stored_item_id/' . $item->invoice_stored_item_id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
							<?php echo icon('edit'); ?>
						</a>
						<a href="<?php echo site_url('invoice_items/delete/invoice_stored_item_id/' . $item->invoice_stored_item_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
							<?php echo icon('delete'); ?>
						</a>
					</td>
				</tr>
				<?php } ?>
			</table>

			<?php if ($this->mdl_invoice_items->page_links) { ?>
			<div id="pagination">
				<?php echo $this->mdl_invoice_items->page_links; ?>
			</div>
			<?php } ?>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>'invoice_items/sidebar')); ?>

<?php $this->load->view('dashboard/footer'); ?>