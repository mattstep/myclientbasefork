<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			<?php echo $this->lang->line('invoice_number'); ?>
			<?php echo invoice_id($invoice); ?>
		</title>
		<style type="text/css">

			body {
				font-family: Verdana, Geneva, sans-serif;
				font-size: 12px;
				margin-left: 35px;
				margin-right: 45px;
			}

			th {
				border: 1px solid #666666;
				background-color: #D3D3D3;
			}

			h2, h4 {
				margin-bottom: 0px;
			}

			p.notop {
				margin-top: 0px;
			}
			tr.invoiceItemRows:nth-of-type(odd) {
			  background-color: #eeeeee;
			}

		</style>
	</head>
	<body>

		<table width="100%">
			<tr>
				<td width="60%" valign="top">
					<h2>New Horizon Communications Inc.</h2>
          <p class="notop">PO Box 840645<br>
          Houston, Texas 77284<br>
          832-593-0221</p>
				</td>
				<td width="40%" align="right" valign="top">
					<h2><?php echo $this->lang->line('invoice'); ?></h2>
					<p class="notop">
						<?php echo $this->lang->line('invoice_number'); ?>
						<?php echo invoice_id($invoice); ?><br />
						<?php echo $this->lang->line('invoice_date'); ?>:
						<?php echo invoice_date_entered($invoice); ?><br />
						<?php echo $this->lang->line('due_date'); ?>:
						<?php echo invoice_due_date($invoice); ?>
					</p>

				</td>
			</tr>
		<tr><td>
		  <h4>Bill to:</h4>
			<?php echo invoice_to_client_name($invoice); ?><br />
			<?php echo invoice_to_address($invoice); ?><br />
			<?php if (invoice_to_address_2($invoice)) { echo invoice_to_address_2($invoice) . '<br />'; } ?>
			<?php echo invoice_to_city($invoice) . ', ' . invoice_to_state($invoice) . ' ' . invoice_to_zip($invoice) . ' ' . invoice_to_country($invoice); ?><br />
		</p></td></tr>
	</table>


		<table style="width: 100%;">
			<tr>
				<th width="60px">
					<?php echo $this->lang->line('date'); ?>
				</th>
				<th>
					<?php echo $this->lang->line('item_name'); ?>
				</th>
				<th width="60px">
					<?php echo $this->lang->line('quantity'); ?>
				</th>
				<th width="60px" align="right">
					<?php echo $this->lang->line('unit'); ?>
				</th>
				<th width="60px" align="right">
					<?php echo $this->lang->line('cost'); ?>
				</th>
			</tr>
			<?php foreach ($invoice->invoice_items as $item) { ?>
			<tr class="invoiceItemRows">
				<td>
					<?php echo invoice_item_date($item); ?>
				</td>
				<td>
					<?php echo invoice_item_name($item); ?>
				</td>
				<td align="center">
					<?php echo invoice_item_qty($item); ?>
				</td>
				<td align="right">
					<?php echo invoice_item_unit_price($item); ?>
				</td>
				<td align="right">
					<?php echo invoice_item_pretax_total($item); ?>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="2"></td>
				<td colspan="3">
					<hr />
				</td>
			</tr>

			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('subtotal'); ?>
				</td>
				<td align="right">
					<?php echo invoice_item_subtotal($invoice); ?>
				</td>
			</tr>

			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('total_tax'); ?>
				</td>
				<td align="right">
					<?php echo invoice_tax_total($invoice); ?>
				</td>
			</tr>

			<?php foreach ($invoice->invoice_tax_rates as $invoice_tax_rate) { ?>
			<?php if (invoice_has_tax($invoice_tax_rate)) { ?>
			<tr>
				<td colspan="4" align="right">
					<?php echo invoice_tax_rate_name($invoice_tax_rate); ?>
				</td>
				<td align="right">
					<?php echo invoice_tax_rate_amount($invoice_tax_rate); ?>
				</td>
			</tr>
			<?php } ?>
			<?php } ?>

			<?php if ($invoice->invoice_shipping > 0) { ?>
			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('shipping'); ?>
				</td>
				<td align="right">
					<?php echo invoice_shipping($invoice); ?>
				</td>
			</tr>
			<?php } ?>

			<?php if ($invoice->invoice_discount > 0) { ?>
			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('discount'); ?>
				</td>
				<td align="right">
					<?php echo invoice_discount($invoice); ?>
				</td>
			</tr>
			<?php } ?>

			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('grand_total'); ?>
				</td>
				<td align="right">
					<?php echo invoice_total($invoice); ?>
				</td>
			</tr>

			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('amount_paid'); ?>
				</td>
				<td align="right">
					<?php echo invoice_paid($invoice); ?>
				</td>
			</tr>

			<tr>
				<td colspan="4" align="right">
					<?php echo $this->lang->line('total_due'); ?>
				</td>
				<td align="right">
					<?php echo invoice_balance($invoice); ?>
				</td>
			</tr>
		</table>

	</body>
</html>