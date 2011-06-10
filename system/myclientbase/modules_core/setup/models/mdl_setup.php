<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Setup extends MY_Model {

	var $install_version = '0.9.0';

	var $upgrade_path;

	function __construct() {

		parent::__construct();

		$this->table_name = 'mcb_users';

		$this->primary_key = 'mcb_users.user_id';

		$this->upgrade_path = array(
			array(
				'from'		=>	'0.8',
				'to'		=>	'0.8.1',
				'function'	=>	'u08_to_081'
			),
			array(
				'from'		=>	'0.8.1',
				'to'		=>	'0.8.2',
				'function'	=>	'u081_to_082'
			),
			array(
				'from'		=>	'0.8.2',
				'to'		=>	'0.8.3',
				'function'	=>	'u082_to_083'
			),
			array(
				'from'		=>	'0.8.3',
				'to'		=>	'0.8.4',
				'function'	=>	'u083_to_084'
			),
			array(
				'from'		=>	'0.8.4',
				'to'		=>	'0.8.5',
				'function'	=>	'u084_to_085'
			),
			array(
				'from'		=>	'0.8.5',
				'to'		=>	'0.8.6',
				'function'	=>	'u085_to_086'
			),
			array(
				'from'		=>	'0.8.6',
				'to'		=>	'0.8.7',
				'function'	=>	'u086_to_087'
			),
			array(
				'from'		=>	'0.8.7',
				'to'		=>	'0.8.8',
				'function'	=>	'u087_to_088'
			),
			array(
				'from'		=>	'0.8.8',
				'to'		=>	'0.8.9',
				'function'	=>	'u088_to_089'
			),
			array(
				'from'		=>	'0.8.9',
				'to'		=>	'0.8.9.1',
				'function'	=>	'u089_to_0891'
			),
			array(
				'from'		=>	'0.8.9.1',
				'to'		=>	'0.9.0',
				'function'	=>	'u0891_to_090'
			)
		);

		$this->load->model('mcb_modules/mdl_mcb_modules');

	}

	function validate_database() {

		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('hostname', $this->lang->line('database_server'), 'required');
		$this->form_validation->set_rules('database', $this->lang->line('database_name'), 'required');
		$this->form_validation->set_rules('username', $this->lang->line('database_username'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('database_password'), 'required');

		return parent::validate();

	}

	function validate() {

		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('last_name'), 'required');
		$this->form_validation->set_rules('username', $this->lang->line('username'), 'required');
		$this->form_validation->set_rules('password', $this->lang->line('password'), 'required');
		$this->form_validation->set_rules('passwordv', $this->lang->line('password_verify'), 'required|matches[password]');
		$this->form_validation->set_rules('address', $this->lang->line('street_address'));
		$this->form_validation->set_rules('address', $this->lang->line('street_address_2'));
		$this->form_validation->set_rules('city', $this->lang->line('city'));
		$this->form_validation->set_rules('state', $this->lang->line('state'));
		$this->form_validation->set_rules('zip', $this->lang->line('zip'));
		$this->form_validation->set_rules('country', $this->lang->line('country'));
		$this->form_validation->set_rules('phone_number', $this->lang->line('phone_number'));
		$this->form_validation->set_rules('fax_number', $this->lang->line('fax_number'));
		$this->form_validation->set_rules('mobile_number', $this->lang->line('mobile_number'));
		$this->form_validation->set_rules('email_address', $this->lang->line('email_address'));
		$this->form_validation->set_rules('web_address', $this->lang->line('web_address'));
		$this->form_validation->set_rules('company_name', $this->lang->line('company_name'));

		return parent::validate();

	}

	function db_array() {

		$db_array = parent::db_array();

		unset($db_array['passwordv']);

		$db_array['password'] = md5($db_array['password']);

		$db_array['global_admin'] = 1;

		return $db_array;

	}

	function db_install() {

		$return = array();

		$this->load->database();

		$this->db->db_debug = 0;

		if ($this->db_install_tables()) {

			$return[] = $this->lang->line('install_database_success');

		}

		else {

			$return[] = $this->lang->line('install_database_problem');

			return $return;

		}

		$db_array = parent::db_array();

		$db_array['password'] = md5($db_array['password']);

		$db_array['global_admin'] = 1;

		unset($db_array['passwordv']);

		if (parent::save($db_array, NULL, FALSE)) {

			$return[] = $this->lang->line('install_admin_account_success');

		}

		else {

			$return[] = $this->lang->line('install_admin_account_problem');

			return $return;

		}

		$return[] = $this->lang->line('installation_complete');

		$return[] = $this->lang->line('install_delete_folder');

		$return[] = APPPATH . 'modules_core/setup';

		$return[] = anchor('sessions/login', $this->lang->line('log_in'));

		return $return;

	}

	function db_install_tables() {

		foreach ($this->db_tables() as $query) {

			if (!$this->db->query($query)) {

				return FALSE;

			}

		}

		$this->mcb_data_prev();

		$this->mcb_data_085();

		$this->mcb_data_086();

		$this->mcb_data_087();

		$this->mcb_data_088();

		$this->mcb_data_089();

		$this->mcb_data_090();

		$this->mdl_mcb_data->save('version', $this->install_version);

		return TRUE;

	}

	function db_tables() {

		return array(

			"CREATE TABLE `mcb_clients` (
			`client_id` int(11) NOT NULL AUTO_INCREMENT,
			`client_address` varchar(100) NOT NULL DEFAULT '',
			`client_address_2` varchar(100) NOT NULL DEFAULT '',
			`client_city` varchar(50) NOT NULL DEFAULT '',
			`client_state` varchar(50) NOT NULL DEFAULT '',
			`client_zip` varchar(10) NOT NULL DEFAULT '',
			`client_country` varchar(50) NOT NULL DEFAULT '',
			`client_phone_number` varchar(25) NOT NULL DEFAULT '',
			`client_fax_number` varchar(25) NOT NULL DEFAULT '',
			`client_mobile_number` varchar(25) NOT NULL DEFAULT '',
			`client_email_address` varchar(100) NOT NULL DEFAULT '',
			`client_web_address` varchar(255) NOT NULL DEFAULT '',
			`client_name` varchar(255) NOT NULL DEFAULT '',
			`client_notes` longtext NULL DEFAULT NULL,
			`client_tax_id` varchar(25) NOT NULL DEFAULT '',
			`client_active` int(1) NOT NULL DEFAULT '1',
			PRIMARY KEY (`client_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_client_data` (
			`mcb_client_data_id` int(11) NOT NULL AUTO_INCREMENT,
			`client_id` int(11) NOT NULL,
			`mcb_client_key` varchar(50) NOT NULL DEFAULT '',
			`mcb_client_value` varchar(100) NOT NULL DEFAULT '',
			PRIMARY KEY (`mcb_client_data_id`),
			KEY `client_id` (`client_id`),
			KEY `mcb_client_key` (`mcb_client_key`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_contacts` (
			`contact_id` int(11) NOT NULL AUTO_INCREMENT,
			`client_id` int(11) NOT NULL,
			`first_name` varchar(50) NOT NULL DEFAULT '',
			`last_name` varchar(50) NOT NULL DEFAULT '',
			`address` varchar(100) NOT NULL DEFAULT '',
			`address_2` varchar(100) NOT NULL DEFAULT '',
			`city` varchar(50) NOT NULL DEFAULT '',
			`state` varchar(50) NOT NULL DEFAULT '',
			`zip` varchar(10) NOT NULL DEFAULT '',
			`country` varchar(50) NOT NULL DEFAULT '',
			`phone_number` varchar(25) NOT NULL DEFAULT '',
			`fax_number` varchar(25) NOT NULL DEFAULT '',
			`mobile_number` varchar(25) NOT NULL DEFAULT '',
			`email_address` varchar(100) NOT NULL DEFAULT '',
			`web_address` varchar(255) NOT NULL DEFAULT '',
			`notes` longtext NULL DEFAULT NULL,
			PRIMARY KEY (`contact_id`),
			KEY `client_id` (`client_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_data` (
			`mcb_data_id` int(11) NOT NULL AUTO_INCREMENT,
			`mcb_key` varchar(50) NOT NULL DEFAULT '',
			`mcb_value` varchar(255) NULL DEFAULT '',
			PRIMARY KEY (`mcb_data_id`),
			UNIQUE KEY `mcb_data_key` (`mcb_key`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_fields` (
			  `field_id` int(11) NOT NULL AUTO_INCREMENT,
			  `object_id` int(11) NOT NULL,
			  `field_name` varchar(50) NOT NULL DEFAULT '',
			  `field_index` int(11) NOT NULL,
			  `column_name` varchar(25) NOT NULL DEFAULT '',
			  PRIMARY KEY (`field_id`),
			  KEY `object_id` (`object_id`),
			  KEY `field_index` (`field_index`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoices` (
			`invoice_id` int(11) NOT NULL AUTO_INCREMENT,
			`client_id` int(11) NOT NULL,
			`user_id` int(11) NOT NULL,
			`invoice_status_id` int(11) NOT NULL,
			`invoice_date_entered` varchar(25) NOT NULL DEFAULT '',
			`invoice_number` varchar(50) NOT NULL DEFAULT '',
			`invoice_notes` longtext NULL DEFAULT NULL,
			`invoice_due_date` varchar(25) NOT NULL DEFAULT '',
			`invoice_is_quote` INT( 1 ) NOT NULL DEFAULT '0',
			`invoice_group_id` int(11) NOT NULL,
			PRIMARY KEY (`invoice_id`),
			KEY `client_id` (`client_id`),
			KEY `user_id` (`user_id`),
			KEY `invoice_status_id` (`invoice_status_id`),
			KEY `is_quote` (`invoice_is_quote`),
			KEY `invoice_group_id` (`invoice_group_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_amounts` (
			`invoice_amount_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`invoice_id` INT NOT NULL ,
			`invoice_item_subtotal` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_item_taxable` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_item_tax` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_subtotal` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_tax` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_shipping` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_discount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_paid` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_total` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_balance` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			INDEX ( `invoice_id` )
			) ENGINE = MYISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_groups` (
			`invoice_group_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_group_name` varchar(50) NOT NULL DEFAULT '',
			`invoice_group_prefix` varchar(10) NOT NULL DEFAULT '',
			`invoice_group_next_id` int(11) NOT NULL,
			`invoice_group_left_pad` int(2) NOT NULL,
			`invoice_group_prefix_year` int(1) NOT NULL DEFAULT '0',
			`invoice_group_prefix_month` int(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`invoice_group_id`),
			KEY `invoice_group_next_id` (`invoice_group_next_id`),
			KEY `invoice_group_left_pad` (`invoice_group_left_pad`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_items` (
			`invoice_item_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_id` int(11) NOT NULL,
			`item_name` longtext NULL DEFAULT NULL,
			`item_description` longtext NULL DEFAULT NULL,
			`item_date` VARCHAR(14) NOT NULL DEFAULT '',
			`item_qty` decimal(10,2) NOT NULL DEFAULT '0.00',
			`item_price` decimal(10,2) NOT NULL DEFAULT '0.00',
			`tax_rate_id` int(11) NOT NULL,
			`is_taxable` int(1) NOT NULL DEFAULT 0,
			PRIMARY KEY (`invoice_item_id`),
			KEY `invoice_id` (`invoice_id`),
			KEY `tax_rate_id` (`tax_rate_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_item_amounts` (
			`invoice_item_amount_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_item_id` int(11) NOT NULL,
			`item_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
			`item_tax` decimal(10,2) NOT NULL DEFAULT '0.00',
			`item_total` decimal(10,2) NOT NULL DEFAULT '0.00',
			PRIMARY KEY (`invoice_item_amount_id`),
			KEY `invoice_item_id` (`invoice_item_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_stored_items` (
			`invoice_stored_item_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_stored_item` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
			`invoice_stored_unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
			`invoice_stored_description` longtext NULL DEFAULT NULL,
			PRIMARY KEY (`invoice_stored_item_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_tax_rates` (
			`invoice_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_id` int(11) NOT NULL,
			`tax_rate_id` int(11) NOT NULL,
			`tax_rate_option` int(1) NOT NULL DEFAULT '1',
			`tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
			PRIMARY KEY (`invoice_tax_rate_id`),
			KEY `invoice_id` (`invoice_id`,`tax_rate_id`),
			KEY `tax_rate_option` (`tax_rate_option`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_modules` (
			`module_id` int(11) NOT NULL AUTO_INCREMENT,
			`module_path` varchar(50) NOT NULL DEFAULT '',
			`module_name` varchar(50) NOT NULL DEFAULT '',
			`module_description` varchar(255) NOT NULL DEFAULT '',
			`module_enabled` int(1) NOT NULL DEFAULT '0',
			`module_author` varchar(50) NOT NULL DEFAULT '',
			`module_homepage` varchar(255) NOT NULL DEFAULT '',
			`module_version` varchar(25) NOT NULL DEFAULT '',
			`module_available_version` varchar(25) NOT NULL DEFAULT '',
			`module_config` longtext NULL DEFAULT NULL,
			`module_core` INT( 1 ) NOT NULL DEFAULT '0',
			`module_order` INT( 2 ) NOT NULL DEFAULT '99',
			PRIMARY KEY (`module_id`),
			KEY `module_order` (`module_order`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_payments` (
			`payment_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_id` int(11) NOT NULL,
			`payment_method_id` INT(11) NOT NULL,
			`payment_date` varchar(25) NOT NULL DEFAULT '',
			`payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
			`payment_note` longtext NULL DEFAULT NULL,
			PRIMARY KEY (`payment_id`),
			KEY `invoice_id` (`invoice_id`),
			KEY `payment_method_id` (`payment_method_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_payment_methods` (
			`payment_method_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`payment_method` VARCHAR( 25 ) NOT NULL
			) ENGINE = MYISAM ;",

			"INSERT INTO `mcb_payment_methods` (`payment_method`) VALUES
			('" . $this->lang->line('cash') . "'),
			('" . $this->lang->line('check') . "'),
			('" . $this->lang->line('credit') . "');",

			"CREATE TABLE `mcb_tax_rates` (
			`tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
			`tax_rate_name` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
			`tax_rate_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
			PRIMARY KEY (`tax_rate_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_users` (
			`user_id` int(11) NOT NULL AUTO_INCREMENT,
			`username` varchar(25) NOT NULL DEFAULT '',
			`password` varchar(50) NOT NULL DEFAULT '',
			`first_name` varchar(50) NOT NULL DEFAULT '',
			`last_name` varchar(50) NOT NULL DEFAULT '',
			`address` varchar(100) NOT NULL DEFAULT '',
			`address_2` varchar(100) NOT NULL DEFAULT '',
			`city` varchar(50) NOT NULL DEFAULT '',
			`state` varchar(50) NOT NULL DEFAULT '',
			`zip` varchar(10) NOT NULL DEFAULT '',
			`country` varchar(50) NOT NULL DEFAULT '',
			`phone_number` varchar(25) NOT NULL DEFAULT '',
			`fax_number` varchar(25) NOT NULL DEFAULT '',
			`mobile_number` varchar(25) NOT NULL DEFAULT '',
			`email_address` varchar(100) NOT NULL DEFAULT '',
			`web_address` varchar(255) NOT NULL DEFAULT '',
			`company_name` varchar(255) NOT NULL DEFAULT '',
			`last_login` varchar(25) NOT NULL DEFAULT '',
			`global_admin` int(1) NOT NULL DEFAULT '0',
			`tax_id_number` varchar(50) NOT NULL DEFAULT '',
			PRIMARY KEY (`user_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_statuses` (
			`invoice_status_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_status` varchar(255) NOT NULL DEFAULT '',
			`invoice_status_type` int(1) NOT NULL DEFAULT 1,
			PRIMARY KEY (`invoice_status_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"INSERT INTO `mcb_invoice_statuses` (`invoice_status_id`, `invoice_status`, `invoice_status_type`) VALUES
			(1, '" . $this->lang->line('open') . "', 1),
			(2, '" . $this->lang->line('pending') . "', 2),
			(3, '" . $this->lang->line('closed') . "', 3);",

			"CREATE TABLE `mcb_invoice_history` (
			`invoice_history_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_id` int(11) NOT NULL,
			`user_id` int(11) NOT NULL,
			`invoice_history_date` varchar(14) NOT NULL DEFAULT '',
			`invoice_history_data` longtext NULL DEFAULT NULL,
			PRIMARY KEY (`invoice_history_id`),
			KEY `user_id` (`user_id`),
			KEY `invoice_id` (`invoice_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_tags` (
			`tag_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`tag` VARCHAR( 50 ) NOT NULL DEFAULT ''
			) ENGINE = MYISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE `mcb_invoice_tags` (
			`invoice_tag_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`invoice_id` INT NOT NULL ,
			`tag_id` INT NOT NULL ,
			INDEX ( `invoice_id` , `tag_id` )
			) ENGINE = MYISAM DEFAULT CHARSET=utf8;"

		);

	}

	function db_upgrade() {

		$this->load->database();

		$return = array();

		if ($this->mdl_mcb_data->get('version') <> $this->install_version) {

			foreach ($this->upgrade_path as $path) {

				$app_version = $this->mdl_mcb_data->get('version');

				if ($path['from'] == $app_version) {

					if ($this->{$path['function']}()) {

						$return[] = 'Upgrade from ' . $path['from'] . ' to ' . $path['to'] . ' successful<br />';

					}

					else {

						$return[] = 'Upgrade from ' . $path['from'] . ' to ' . $path['to'] . ' FAILED. Script exiting.';

						return $return;

					}

				}

			}

			$return[] = $this->lang->line('upgrade_complete');

			$return[] = $this->lang->line('install_delete_folder');

			$return[] = APPPATH . 'modules_core/setup';

			$return[] = anchor('sessions/login', $this->lang->line('log_in'));

			return $return;

		}

		else {

			$return[] = anchor('sessions/login', $this->lang->line('log_in'));

			$return[] = $this->lang->line('install_already_current');

			return $return;

		}

	}

	function u08_to_081() {

		$this->mdl_mcb_data->save('version', '0.8.1');

		return TRUE;

	}

	function u081_to_082() {

		$queries = array(

			"CREATE TABLE `mcb_client_data` (
			`mcb_client_data_id` int(11) NOT NULL AUTO_INCREMENT,
			`client_id` int(11) NOT NULL,
			`mcb_client_key` varchar(50) NOT NULL DEFAULT '',
			`mcb_client_value` varchar(100) NOT NULL DEFAULT '',
			PRIMARY KEY (`mcb_client_data_id`),
			KEY `client_id` (`client_id`),
			KEY `mcb_client_key` (`mcb_client_key`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"ALTER TABLE `mcb_clients`
			DROP `username`,
			DROP `password`;"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->mdl_mcb_data->save('version', '0.8.2');

		return TRUE;

	}

	function u082_to_083() {

		$this->mdl_mcb_data->save('version', '0.8.3');

		return TRUE;

	}

	function u083_to_084() {

		$this->mdl_mcb_data->save('version', '0.8.4');

		return TRUE;

	}

	function u084_to_085() {

		$queries = array(

			"ALTER TABLE `mcb_clients` ADD `client_active` INT( 1 ) NOT NULL DEFAULT '1'",

			"CREATE TABLE `mcb_payment_methods` (
			`payment_method_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`payment_method` VARCHAR( 25 ) NOT NULL
			) ENGINE = MYISAM ;",

			"INSERT INTO `mcb_payment_methods` (`payment_method`) VALUES
			('" . $this->lang->line('cash') . "'),
			('" . $this->lang->line('check') . "'),
			('" . $this->lang->line('credit') . "');",

			"ALTER TABLE `mcb_payments` ADD `payment_method_id` INT NOT NULL AFTER `invoice_id` ,
			ADD INDEX ( `payment_method_id` )"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->mcb_data_085();

		$this->mdl_mcb_data->save('version', '0.8.5');

		return TRUE;

	}

	function u085_to_086() {

		$queries = array(

			"ALTER TABLE `mcb_invoice_items` ADD `item_description` longtext NULL DEFAULT NULL AFTER `item_name`",

			"ALTER TABLE `mcb_invoice_stored_items` ADD `invoice_stored_description` longtext NULL DEFAULT NULL"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->mcb_data_086();

		$this->mdl_mcb_data->save('version', '0.8.6');

		return TRUE;

	}

	function u086_to_087() {

		$queries = array(

			"ALTER TABLE `mcb_invoices` ADD `is_quote` INT( 1 ) NOT NULL DEFAULT '0'",

			"ALTER TABLE `mcb_invoice_amounts` ADD `invoice_shipping_amount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00' AFTER `invoice_taxed_amount` ,
			ADD `invoice_discount_amount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00' AFTER `invoice_shipping_amount`,
			ADD `invoice_grand_total_amount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00'"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->mcb_data_087();

		$this->mdl_mcb_data->save('version', '0.8.7');

		$this->mdl_mcb_data->set_session_data();

		return TRUE;

	}

	function u087_to_088() {

		$queries = array(
			"ALTER TABLE `mcb_invoice_item_amounts` CHANGE `item_amount` `item_subtotal` DECIMAL( 10, 2 ) NOT NULL ,
			CHANGE `item_tax_amount` `item_tax` DECIMAL( 10, 2 ) NOT NULL ,
			CHANGE `item_taxed_amount` `item_total` DECIMAL( 10, 2 ) NOT NULL",

			"DROP TABLE `mcb_invoice_amounts`",

			"CREATE TABLE `mcb_invoice_amounts` (
			`invoice_amount_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`invoice_id` INT NOT NULL ,
			`invoice_item_subtotal` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_item_taxable` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_item_tax` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_subtotal` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_tax` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_shipping` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_discount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_paid` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_total` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			`invoice_balance` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			INDEX ( `invoice_id` )
			) ENGINE = MYISAM ;",

			"ALTER TABLE `mcb_clients`
			CHANGE `address` `client_address` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `address_2` `client_address_2` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `city` `client_city` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `state` `client_state` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `zip` `client_zip` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `country` `client_country` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
			CHANGE `phone_number` `client_phone_number` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `fax_number` `client_fax_number` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `mobile_number` `client_mobile_number` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `email_address` `client_email_address` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `web_address` `client_web_address` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `notes` `client_notes` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL",

			"ALTER TABLE `mcb_payments` CHANGE `amount` `payment_amount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
			CHANGE `note` `payment_note` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL",

			"ALTER TABLE `mcb_invoices` CHANGE `date_entered` `invoice_date_entered` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `notes` `invoice_notes` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
			CHANGE `due_date` `invoice_due_date` VARCHAR( 25 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `is_quote` `invoice_is_quote` INT( 1 ) NOT NULL DEFAULT '0'"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->load->model('invoices/mdl_invoice_amounts');

		$this->mdl_invoice_amounts->adjust();

		$this->mdl_mcb_data->save('version', '0.8.8');

		$this->mcb_data_088();

		return TRUE;

	}

	function u088_to_089() {

		$this->db->select('invoice_tax_rate_id, tax_item_option');

		$invoice_tax_rates = $this->db->get('mcb_invoice_tax_rates')->result();

		foreach ($invoice_tax_rates as $invoice_tax_rate) {

			$this->db->set('tax_rate_option', $invoice_tax_rate->tax_item_option);

			$this->db->where('invoice_tax_rate_id', $invoice_tax_rate->invoice_tax_rate_id);

			$this->db->update('mcb_invoice_tax_rates');

		}

		$queries = array(

			"ALTER TABLE `mcb_invoice_tax_rates` DROP `tax_item_option`",

			"CREATE TABLE `mcb_invoice_groups` (
			`invoice_group_id` int(11) NOT NULL AUTO_INCREMENT,
			`invoice_group_name` varchar(50) NOT NULL DEFAULT '',
			`invoice_group_prefix` varchar(10) NOT NULL DEFAULT '',
			`invoice_group_next_id` int(11) NOT NULL,
			`invoice_group_left_pad` int(2) NOT NULL,
			PRIMARY KEY (`invoice_group_id`),
			KEY `invoice_group_next_id` (`invoice_group_next_id`),
			KEY `invoice_group_left_pad` (`invoice_group_left_pad`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",

			"ALTER TABLE `mcb_users` ADD `tax_id_number` VARCHAR( 50 ) NOT NULL DEFAULT ''",

			"ALTER TABLE `mcb_invoices` ADD `invoice_group_id` INT NOT NULL ,
			ADD INDEX ( `invoice_group_id` )"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->load->model('invoices/mdl_invoice_amounts');

		$this->mdl_invoice_amounts->adjust();

		$this->mdl_mcb_data->save('version', '0.8.9');

		$this->mcb_data_089();

		return TRUE;

	}

	function u089_to_0891() {

		$queries = array(

			"ALTER TABLE `mcb_invoice_items` ADD `item_date` VARCHAR( 14 ) NOT NULL DEFAULT '' AFTER `item_description`",

			"ALTER TABLE `mcb_invoices` CHANGE `invoice_date_entered` `invoice_date_entered` VARCHAR( 14 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
			CHANGE `invoice_due_date` `invoice_due_date` VARCHAR( 14 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''",

			"ALTER TABLE `mcb_payments` CHANGE `payment_date` `payment_date` VARCHAR( 14 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''",

			"UPDATE mcb_invoice_items SET item_date = (SELECT invoice_date_entered FROM mcb_invoices WHERE mcb_invoices.invoice_id = mcb_invoice_items.invoice_id)"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}
		
		$this->mdl_mcb_data->save('version', '0.8.9.1');

		return TRUE;

	}

	function u0891_to_090() {

		$queries = array(
			"CREATE TABLE `mcb_fields` (
			  `field_id` int(11) NOT NULL AUTO_INCREMENT,
			  `object_id` int(11) NOT NULL,
			  `field_name` varchar(50) NOT NULL DEFAULT '',
			  `field_index` int(11) NOT NULL,
			  `column_name` varchar(25) NOT NULL DEFAULT '',
			  PRIMARY KEY (`field_id`),
			  KEY `object_id` (`object_id`),
			  KEY `field_index` (`field_index`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;",

			"ALTER TABLE `mcb_modules` ADD `module_order` INT( 2 ) NOT NULL DEFAULT '99',
			ADD INDEX ( `module_order` )",

			"ALTER TABLE `mcb_invoice_groups` ADD `invoice_group_prefix_year` INT( 1 ) NOT NULL DEFAULT '0',
			ADD `invoice_group_prefix_month` INT( 1 ) NOT NULL DEFAULT '0'"

		);

		if (!$this->run_queries($queries)) {

			return FALSE;

		}

		$this->mdl_mcb_data->save('version', '0.9.0');

		$this->mcb_data_090();

		return TRUE;

	}

	function mcb_data_prev() {

		$this->load->model('tax_rates/mdl_tax_rates');

		if (!$this->mdl_tax_rates->get()) {

			$db_array = array(
				'tax_rate_name'		=>	$this->lang->line('no_tax'),
				'tax_rate_percent'	=>	'0.00'
			);

			$this->db->insert('mcb_tax_rates', $db_array);

		}

		$this->mdl_mcb_data->save('default_tax_rate_id', 1);

		$this->mdl_mcb_data->save('currency_symbol', '$');

		$this->mdl_mcb_data->save('dashboard_show_open_invoices', 'TRUE');

		$this->mdl_mcb_data->save('dashboard_show_closed_invoices', 'TRUE');

		$this->mdl_mcb_data->save('default_date_format', 'm/d/Y');

		$this->mdl_mcb_data->save('default_date_format_mask', '99/99/9999');

		$this->mdl_mcb_data->save('default_date_format_picker', 'mm/dd/yy');

		$this->mdl_mcb_data->save('default_invoice_template', 'default');

		$this->mdl_mcb_data->save('tax_id_number_label', $this->lang->line('tax_id_number'));

		$this->mdl_mcb_data->save('currency_symbol_placement', 'before');

		$this->mdl_mcb_data->save('invoices_due_after', '30');

		$this->mdl_mcb_data->save('pdf_plugin', 'dompdf');

		$this->mdl_mcb_data->save('email_protocol', 'php_mail_function');

		$this->mdl_mcb_data->save('dashboard_show_pending_invoices', 'TRUE');

		$this->mdl_mcb_data->save('default_open_status_id', 1);

		$this->mdl_mcb_data->save('default_closed_status_id', 3);

		if (!$this->mdl_mcb_data->get('default_language')) {

			$this->mdl_mcb_data->save('default_language', 'english');

		}

		if (!$this->mdl_mcb_data->get('include_logo_on_invoice')) {

			$this->mdl_mcb_data->save('include_logo_on_invoice', 'FALSE');

		}

	}

	function mcb_data_085() {

		$this->mdl_mcb_data->save('dashboard_show_overdue_invoices', 'TRUE');

	}

	function mcb_data_086() {
		$this->mdl_mcb_data->save('decimal_taxes_num', 2);

		$this->mdl_mcb_data->save('default_receipt_template', 'default');

	}

	function mcb_data_087() {

		$this->mdl_mcb_data->save('dashboard_override', '');

		$this->mdl_mcb_data->save('decimal_symbol', '.');

		$this->mdl_mcb_data->save('thousands_separator', ',');

	}

	function mcb_data_088() {

		$this->mdl_mcb_data->save('default_quote_template', 'default_quote');

	}

	function mcb_data_089() {

		$this->mdl_mcb_data->delete('include_tax_id_invoice');

		$this->mdl_mcb_data->delete('tax_id_number');

		$this->db->query('UPDATE mcb_invoices SET invoice_number = invoice_id WHERE invoice_id > 0');

		$query = $this->db->query("SHOW TABLE STATUS LIKE 'mcb_invoices'");

		$auto_increment = $query->row()->Auto_increment;

		$db_array = array(
			'invoice_group_name'		=>	$this->lang->line('simple_increment'),
			'invoice_group_prefix'		=>	'',
			'invoice_group_next_id'		=>	$auto_increment,
			'invoice_group_left_pad'	=>	0
		);

		$this->db->insert('mcb_invoice_groups', $db_array);

	}

	function mcb_data_090() {

		$this->mdl_mcb_data->save('results_per_page', 15);
		
		$this->mdl_mcb_data->save('display_quantity_decimals', 1);

		$this->mdl_mcb_modules->refresh();
		
	}

	function run_queries($queries) {

		foreach ($queries as $query) {

			if (!$this->db->query($query)) {

				return FALSE;

			}

		}

		return TRUE;

	}

}

?>