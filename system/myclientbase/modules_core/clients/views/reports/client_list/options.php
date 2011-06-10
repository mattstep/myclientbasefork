<table style="width: 100%;">
	<tr>
		<th><?php echo $this->lang->line('clients'); ?></th>
		<th><?php echo $this->lang->line('output_type'); ?></th>
		<th><?php echo $this->lang->line('generate_report'); ?></th>
	</tr>
	<tr>
		<td>
			<select name="client_id">
				<option value="all" <?php echo set_select('client_id', 'all', TRUE); ?>><?php echo $this->lang->line('all_clients'); ?></option>
				<?php foreach ($clients as $client) { ?>
				<option value="<?php echo $client->client_id; ?>"><?php echo $client->client_name; ?></option>
				<?php } ?>
			</select>
		</td>
		<td>
			<select name="output_type">
				<option value="preview" <?php echo set_select('output_type', 'preview', TRUE); ?>><?php echo $this->lang->line('preview'); ?></option>
				<option value="pdf" <?php echo set_select('output_type', 'pdf'); ?>><?php echo $this->lang->line('pdf'); ?></option>
				<option value="html" <?php echo set_select('output_type', 'html'); ?>><?php echo $this->lang->line('html'); ?></option>
			</select>
		</td>
		<td><input type="submit" name="btn_generate_report" value="<?php echo $this->lang->line('generate_report'); ?>" /></td>
	</tr>
</table>