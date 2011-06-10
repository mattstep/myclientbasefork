<?php foreach ($result_clients as $client) { ?>

<h2><?php echo $client->client_name; ?></h2>

<table width="100%">
	<tr>
		<td width="50%">
			<table style="width: 100%;">
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('street_address'); ?></td>
					<td class="td_box_value"><?php echo $client->client_address; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('city'); ?></td>
					<td class="td_box_value"><?php echo $client->client_city; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('state'); ?></td>
					<td class="td_box_value"><?php echo $client->client_state; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('zip'); ?></td>
					<td class="td_box_value"><?php echo $client->client_zip; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('phone_number'); ?></td>
					<td class="td_box_value"><?php echo $client->client_phone_number; ?></td>
				</tr>
			</table>
		</td>
		<td width="50%">
			<table style="width: 100%;">
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('fax_number'); ?></td>
					<td class="td_box_value"><?php echo $client->client_fax_number; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('mobile_number'); ?></td>
					<td class="td_box_value"><?php echo $client->client_mobile_number; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('web_address'); ?></td>
					<td class="td_box_value"><?php echo $client->client_web_address; ?></td>
				</tr>
				<tr>
					<td class="td_box_label"><?php echo $this->lang->line('email_address'); ?></td>
					<td class="td_box_value"><?php echo $client->client_email_address; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr style="clear: both;"/>

<?php } ?>