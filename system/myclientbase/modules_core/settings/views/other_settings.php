<dl>
    <dt><?php echo $this->lang->line('language'); ?></dt>
    <dd>
	<select name="default_language">
	    <?php foreach ($languages as $key=>$language) { ?>
	    <option value="<?php echo $key; ?>" <?php if($this->mdl_mcb_data->default_language == $key) { ?>selected="selected"<?php } ?>><?php echo $language['language']; ?></option>
	    <?php } ?>
	</select>
    </dd>
</dl>

<dl>
    <dt><?php echo $this->lang->line('date_format'); ?></dt>
    <dd>
	<select name="default_date_format">
	    <?php foreach ($date_formats as $date_format) { ?>
	    <option value="<?php echo $date_format['key']; ?>" <?php if($this->mdl_mcb_data->default_date_format == $date_format['key']) { ?>selected="selected"<?php } ?>><?php echo $date_format['dropdown']; ?></option>
	    <?php } ?>
	</select>
    </dd>
</dl>

<dl>
    <dt><?php echo $this->lang->line('pdf_plugin'); ?></dt>
    <dd>
	<select name="pdf_plugin">
	    <?php foreach ($pdf_plugins as $key=>$value) { ?>
	    <option value="<?php echo $key; ?>" <?php if ($this->mdl_mcb_data->pdf_plugin == $key) { ?>selected="selected"<?php } ?>><?php echo $value; ?></option>
    <?php } ?>
	</select>
    </dd>
</dl>

<dl>
    <dt><?php echo $this->lang->line('currency_symbol'); ?></dt>
    <dd><input type="text" name="currency_symbol" value="<?php echo $this->mdl_mcb_data->currency_symbol; ?>" /></dd>
</dl>

<dl>
    <dt><?php echo $this->lang->line('currency_symbol_placement'); ?></dt>
    <dd>
	<select name="currency_symbol_placement">
	    <option value="before" <?php if ($this->mdl_mcb_data->currency_symbol_placement == 'before') { ?>selected="selected"<?php } ?>><?php echo $this->lang->line('currency_symbol_before'); ?></option>
	    <option value="after" <?php if ($this->mdl_mcb_data->currency_symbol_placement == 'after') { ?>selected="selected"<?php } ?>><?php echo $this->lang->line('currency_symbol_after'); ?></option>
	</select>
    </dd>
</dl>

<dl>
    <dt><?php echo $this->lang->line('decimal_symbol'); ?></dt>
    <dd><input type="text" name="decimal_symbol" value="<?php echo $this->mdl_mcb_data->decimal_symbol; ?>" /></dd>
</dl>

<dl>
    <dt><?php echo $this->lang->line('thousands_separator'); ?></dt>
    <dd><input type="text" name="thousands_separator" value="<?php echo $this->mdl_mcb_data->thousands_separator; ?>" /></dd>
</dl>

<dl>
	<dt><?php echo $this->lang->line('results_per_page'); ?></dt>
	<dd><input type="text" name="results_per_page" value="<?php echo $this->mdl_mcb_data->results_per_page; ?>"</dd>
</dl>
