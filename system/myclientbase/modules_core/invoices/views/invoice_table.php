<table style="width: 100%;">
		<tr>
			<th scope="col" class="first"><?php echo $this->lang->line('invoice_number'); ?></th>
			<th scope="col"><?php echo $this->lang->line('date'); ?></th>
			<th scope="col" class="client"><?php echo $this->lang->line('client'); ?></th>
			<th scope="col" class="col_amount"><?php echo $this->lang->line('amount'); ?></th>
			<th scope="col"><?php echo $this->lang->line('status'); ?></th>
			<th scope="col" class="last"><?php echo $this->lang->line('actions'); ?></th>
		</tr>
		<?php foreach ($invoices as $invoice) { ?>

			<tr>
				<td class="first"><a href="javascript:void(0)" class="invoice_history_link" id="invoice_history_link_<?php echo $invoice->invoice_id; ?>"><?php echo invoice_id($invoice); ?></a></td>
				<td><?php echo format_date($invoice->invoice_date_entered); ?></td>
				<td class="client"><?php echo anchor('clients/details/client_id/' . $invoice->client_id, $invoice->client->client_name); ?></td>
				<td class="col_amount"><?php echo display_currency($invoice->invoice_total); ?></td>
				<td><?php echo $invoice->invoice_status; ?></td>
				<td class="last">
					<a href="<?php echo site_url('invoices/edit/invoice_id/' . $invoice->invoice_id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
						<?php echo icon('edit'); ?>
					</a>
					<a href="javascript:void(0)" class="output_link" id="<?php echo $invoice->invoice_id; ?>" title="<?php echo $this->lang->line('generate'); ?>">
						<?php echo icon('generate_invoice'); ?>
					</a>
					<a href="<?php echo site_url('invoices/delete/invoice_id/' . $invoice->invoice_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
						<?php echo icon('delete'); ?>
					</a>
				</td>
			</tr>

		<?php } ?>
</table>

<?php if ($this->mdl_invoices->page_links) { ?>
<div id="pagination">
	<?php echo $this->mdl_invoices->page_links; ?>
</div>
<?php } ?>