<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$config = array(
	'module_name'	=>	$this->lang->line('email'),
	'module_path'	=>	'mcb_email',
	'module_order'	=>	5,
	'module_config'	=>	array(
		'settings_view'	=>	'mcb_email/mcb_email_settings/display',
		'settings_save'	=>	'mcb_email/mcb_email_settings/save'
	)
);

?>