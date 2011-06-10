<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Invoices extends MY_Model {

	public $date_formats;

	public function __construct() {

		parent::__construct();

		$this->table_name = 'mcb_invoices';

		$this->primary_key = 'mcb_invoices.invoice_id';

		$this->order_by = 'mcb_invoices.invoice_date_entered DESC, mcb_invoices.invoice_id DESC';

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS
		mcb_invoices.*,
		mcb_invoice_amounts.*,
		mcb_users.username,
	    mcb_users.company_name AS from_company_name,
	    mcb_users.last_name AS from_last_name,
	    mcb_users.first_name AS from_first_name,
	    mcb_users.address AS from_address,
		mcb_users.address_2 AS from_address_2,
	    mcb_users.city AS from_city,
	    mcb_users.state AS from_state,
	    mcb_users.zip AS from_zip,
		mcb_users.country AS from_country,
	    mcb_users.phone_number AS from_phone_number,
		mcb_users.email_address AS from_email_address,
		mcb_invoice_statuses.invoice_status AS invoice_status,
		mcb_invoice_statuses.invoice_status_type AS invoice_status_type";

		if ($this->mdl_mcb_data->version >= '0.8.9') {

			$this->select_fields .= ', mcb_users.tax_id_number AS from_tax_id_number';

		}

		$this->joins = array(
			'mcb_invoice_statuses'	=>	array(
				'mcb_invoice_statuses.invoice_status_id = mcb_invoices.invoice_status_id',
				'left'
			),
			'mcb_invoice_amounts'	=>	'mcb_invoice_amounts.invoice_id = mcb_invoices.invoice_id',
			'mcb_clients'			=>	'mcb_clients.client_id = mcb_invoices.client_id',
			'mcb_users'				=>	'mcb_users.user_id = mcb_invoices.user_id'
		);

		$this->date_formats = array(
			'm/d/Y'		=>	array(
				'key'		=>	'm/d/Y',
				'picker'	=>	'mm/dd/yy',
				'mask'		=>	'99/99/9999',
				'dropdown'	=>	'mm/dd/yyyy'),
			'm/d/y'		=>	array(
				'key'		=>	'm/d/y',
				'picker'	=>	'mm/dd/y',
				'mask'		=>	'99/99/99',
				'dropdown'	=>	'mm/dd/yy'),
			'Y/m/d'		=>	array(
				'key'		=>	'Y/m/d',
				'picker'	=>	'yy/mm/dd',
				'mask'		=>	'9999/99/99',
				'dropdown'	=>	'yyyy/mm/dd'),
			'd/m/Y'		=>	array(
				'key'		=>	'd/m/Y',
				'picker'	=>	'dd/mm/yy',
				'mask'		=>	'99/99/9999',
				'dropdown'	=>	'dd/mm/yyyy'),
			'd/m/y'		=>	array(
				'key'		=>	'd/m/y',
				'picker'	=>	'dd/mm/y',
				'mask'		=>	'99/99/99',
				'dropdown'	=>	'dd/mm/yy'),
			'm-d-Y'		=>	array(
				'key'		=>	'm-d-Y',
				'picker'	=>	'mm-dd-yy',
				'mask'		=>	'99-99-9999',
				'dropdown'	=>	'mm-dd-yyyy'),
			'm-d-y'		=>	array(
				'key'		=>	'm-d-y',
				'picker'	=>	'mm-dd-y',
				'mask'		=>	'99-99-99',
				'dropdown'	=>	'mm-dd-yy'),
			'Y-m-d'		=>	array(
				'key'		=>	'Y-m-d',
				'picker'	=>	'yy-mm-dd',
				'mask'		=>	'9999-99-99',
				'dropdown'	=>	'yyyy-mm-dd'),
			'y-m-d'		=>	array(
				'key'		=>	'y-m-d',
				'picker'	=>	'y-mm-dd',
				'mask'		=>	'99-99-99',
				'dropdown'	=>	'yy-mm-dd'),
			'd.m.Y'		=>	array(
				'key'		=>	'd.m.Y',
				'picker'	=>	'dd.mm.yy',
				'mask'		=>	'99.99.9999',
				'dropdown'	=>	'dd.mm.yyyy'),
			'd.m.y'		=>	array(
				'key'		=>	'd.m.y',
				'picker'	=>	'dd.mm.y',
				'mask'		=>	'99.99.99',
				'dropdown'	=>	'dd.mm.yy')
		);

	}

	public function get($params = NULL) {

		$invoices = parent::get($params);

		if (is_array($invoices)) {

			foreach ($invoices as $invoice) {

				$invoice = $this->set_invoice($invoice, $params);

			}

		}

		else {

			$invoices = $this->set_invoice($invoices, $params);

		}

		return $invoices;

	}

	public function get_open() {

		$params = array(
			'limit'	=>	10,
			'where'	=>	array(
				'invoice_status_type'	=>	1,
				'invoice_is_quote'		=>	0
			),
			'set_client'	=>	TRUE
		);

		if (!$this->session->userdata('global_admin')) {

			$params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		}

		return $this->get($params);

	}

	public function get_pending() {

		$params = array(
			'limit'	=>	10,
			'where'	=>	array(
				'invoice_status_type'	=>	2,
				'invoice_is_quote'		=>	0
			),
			'set_client'	=>	TRUE
		);

		if (!$this->session->userdata('global_admin')) {

			$params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		}

		return $this->get($params);

	}

	public function get_closed() {

		$params = array(
			'limit'	=>	10,
			'where'	=>	array(
				'invoice_status_type'	=>	3,
				'invoice_is_quote'		=>	0
			),
			'set_client'	=>	TRUE
		);

		if (!$this->session->userdata('global_admin')) {

			$params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		}

		return $this->get($params);

	}

	public function get_overdue() {

		$params = array(
			'limit'	=>	10,
			'where'	=>	array(
				'invoice_status_type <>'	=>	3,
				'invoice_due_date <'		=>	time(),
				'invoice_is_quote'			=>	0
			),
			'set_client'	=>	TRUE
		);

		if (!$this->session->userdata('global_admin')) {

			$params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		}

		return $this->get($params);

	}

	private function set_invoice($invoice, $params = NULL) {

		if (isset($params['set_invoice_items'])) {

			$invoice->invoice_items = $this->set_items($invoice->invoice_id);

		}

		if (isset($params['set_invoice_payments'])) {

			$invoice->invoice_payments = $this->set_payments($invoice->invoice_id);

		}

		if (isset($params['set_client'])) {

			$invoice->client = $this->set_client($invoice->client_id);

		}

		if (isset($params['set_invoice_tax_rates'])) {

			$invoice->invoice_tax_rates = $this->set_tax_rates($invoice->invoice_id);

		}

		if (isset($params['set_item_tax_sums'])) {

			$invoice->item_tax_sums = $this->set_item_tax_sums($invoice->invoice_id);

		}

		if (isset($params['set_tags'])) {

			$invoice->tags = $this->set_tags($invoice->invoice_id);
			
		}

		return $invoice;

	}

	public function save($client_id, $date_entered, $invoice_is_quote = 0, $strtotime = TRUE) {

		if ($strtotime) {

			$date_entered = strtotime(standardize_date($date_entered));

		}

		$db_array = array(
			'client_id'					=>	$client_id,
			'invoice_date_entered'		=>	$date_entered,
			'invoice_due_date'			=>	$this->calculate_due_date($date_entered),
			'user_id'					=>	$this->session->userdata('user_id'),
			'invoice_status_id'			=>	$this->mdl_mcb_data->default_open_status_id,
			'invoice_is_quote'			=>	$invoice_is_quote
		);

		$this->db->insert($this->table_name, $db_array);

		$invoice_id = $this->db->insert_id();

		$db_array = array(
			'invoice_id'	=>	$invoice_id,
			'tax_rate_id'	=>	$this->mdl_mcb_data->default_tax_rate_id
		);

		$this->db->insert('mcb_invoice_tax_rates', $db_array);

		$this->save_invoice_history($invoice_id, $this->session->userdata('user_id'), $this->lang->line('created_invoice'));

		return $invoice_id;

	}

	public function save_invoice_options($custom_fields = NULL) {

		$invoice_id = uri_assoc('invoice_id');

		$this->db->where('invoice_id', $invoice_id);

		$db_array = array(
			'client_id'					=>	$this->input->post('client_id'),
			'invoice_date_entered'		=>	strtotime(standardize_date($this->input->post('invoice_date_entered'))),
			'invoice_notes'				=>	$this->input->post('invoice_notes')
		);

		if (is_numeric($this->input->post('invoice_status_id'))) {

			$db_array['invoice_status_id'] = $this->input->post('invoice_status_id');

		}

		if ($this->input->post('invoice_due_date')) {

			$db_array['invoice_due_date'] = strtotime(standardize_date($this->input->post('invoice_due_date')));
			
		}

		if ($custom_fields) {

			foreach ($custom_fields as $custom_field) {

				$db_array[$custom_field->column_name] = $this->input->post($custom_field->column_name);

			}

		}

		$this->db->update($this->table_name, $db_array);

		$this->db->where('invoice_id', $invoice_id);

		$this->db->delete('mcb_invoice_tax_rates');

		foreach ($this->input->post('tax_rate_id') as $key=>$tax_rate_id) {

			$db_array = array(
				'invoice_id'		=>	$invoice_id,
				'tax_rate_id'		=>	$tax_rate_id,
				'tax_rate_option'	=>	$_POST['tax_rate_option'][$key]
			);

			$this->db->insert('mcb_invoice_tax_rates', $db_array);

		}

		$this->load->model('mdl_invoice_tags');

		$this->mdl_invoice_tags->save_tags($invoice_id, $this->input->post('tags'));

		$db_array = array(
			'invoice_shipping'	=>	standardize_number($this->input->post('invoice_shipping')),
			'invoice_discount'	=>	standardize_number($this->input->post('invoice_discount'))
		);

		$this->db->where('invoice_id', $invoice_id);

		$this->db->update('mcb_invoice_amounts', $db_array);

		$this->save_invoice_history($invoice_id, $this->session->userdata('user_id'), $this->lang->line('saved_invoice_options'));

		$this->session->set_flashdata('custom_success', $this->lang->line('invoice_options_saved'));

	}

	public function delete($invoice_id) {

		parent::delete(array('invoice_id'=>$invoice_id));

		$this->db->where('invoice_id', $invoice_id);

		$this->db->delete(
			array(
			'mcb_invoice_items',
			'mcb_payments',
			'mcb_invoice_amounts',
			'mcb_invoice_tax_rates',
			'mcb_invoice_history',
			'mcb_invoice_tax_rates'
			)
		);

		$this->db->query('DELETE FROM mcb_invoice_item_amounts WHERE invoice_item_id NOT IN (SELECT invoice_item_id FROM mcb_invoice_items)');

		$this->save_invoice_history($invoice_id, $this->session->userdata('user_id'), $this->lang->line('deleted_invoice'));

	}

	public function get_logos() {

		$this->load->helper('directory');

		return directory_map('./uploads/invoice_logos');

	}

	public function add_invoice_item($invoice_id, $item_name, $item_description, $item_qty, $item_price, $is_taxable = 0, $tax_rate_id = 0, $item_date = NULL) {
		
		$item_date = ($item_date) ? strtotime(standardize_date($item_date)) : time();

		$db_array = array(
			'invoice_id'		=>	$invoice_id,
			'item_name'			=>	$item_name,
			'item_description'	=>	$item_description,
			'item_qty'			=>	$item_qty,
			'item_price'		=>	$item_price,
			'is_taxable'		=>	$is_taxable,
			'tax_rate_id'		=>	$tax_rate_id,
			'item_date'			=>	$item_date
		);

		$this->db->insert('mcb_invoice_items', $db_array);

		$invoice_item_id = $this->db->insert_id();

		$this->load->model('invoices/mdl_invoice_amounts');

		$this->mdl_invoice_amounts->adjust($invoice_id);

		return $invoice_item_id;

	}

	public function set_invoice_discount($invoice_id, $invoice_discount) {

		$this->db->where('invoice_id', $invoice_id);

		$this->db->set('invoice_discount', $invoice_discount);

		$this->db->update('mcb_invoice_amounts');

		$this->mdl_invoice_amounts->adjust($invoice_id);

	}

	public function set_invoice_shipping($invoice_id, $invoice_shipping) {

		$this->db->where('invoice_id', $invoice_id);

		$this->db->set('invoice_shipping', $invoice_shipping);

		$this->db->update('mcb_invoice_amounts');

		$this->mdl_invoice_amounts->adjust($invoice_id);

	}

	public function get_client($invoice_id) {

		$this->db->select('mcb_clients.*');

		$this->db->join('mcb_clients', 'mcb_clients.client_id = mcb_invoices.client_id');

		$this->db->where('invoice_id', $invoice_id);

		return $this->db->get('mcb_invoices')->row();

	}

	public function validate() {

		$this->form_validation->set_rules('client_id', $this->lang->line('client'), 'required');
		$this->form_validation->set_rules('user_id', $this->lang->line('created_by'), 'required');
		$this->form_validation->set_rules('invoice_date_entered', $this->lang->line('date_entered'), 'required');
		$this->form_validation->set_rules('invoice_date_closed', $this->lang->line('date_closed'));
		$this->form_validation->set_rules('invoice_number', $this->lang->line('invoice_number'), 'required');
		$this->form_validation->set_rules('invoice_notes', $this->lang->line('notes'));

		return parent::validate();

	}

	public function validate_email() {

		$this->form_validation->set_rules('invoice_template', $this->lang->line('invoice_template'), 'required');
		$this->form_validation->set_rules('email_from_name', $this->lang->line('from_name'), 'required');
		$this->form_validation->set_rules('email_from_email', $this->lang->line('from_email'), 'required|valid_email');
		$this->form_validation->set_rules('email_to', $this->lang->line('to'), 'required|valid_email');
		$this->form_validation->set_rules('email_subject', $this->lang->line('subject'), 'required|max_length[100]');
		$this->form_validation->set_rules('email_body', $this->lang->line('body'));

		return parent::validate();

	}

	public function validate_create() {

		$this->form_validation->set_rules('invoice_date_entered', $this->lang->line('invoice_date'), 'required');
		$this->form_validation->set_rules('client_id', $this->lang->line('client'), 'required');
		$this->form_validation->set_rules('invoice_group_id', $this->lang->line('invoice_group'), 'required');
		$this->form_validation->set_rules('invoice_is_quote', $this->lang->line('quote_only'));

		return parent::validate();

	}

	public function validate_quote_to_invoice() {

		$this->form_validation->set_rules('invoice_date_entered', $this->lang->line('invoice_date'), 'required');
		$this->form_validation->set_rules('invoice_group_id', $this->lang->line('invoice_group'), 'required');

		return parent::validate();

	}

	public function quote_to_invoice($invoice_id, $invoice_date_entered, $invoice_group_id) {

		$db_array = array(
			'invoice_is_quote'		=>	0,
			'invoice_date_entered'	=>	strtotime(standardize_date($invoice_date_entered))
		);

		$this->db->where('invoice_id', $invoice_id);

		$this->db->update('mcb_invoices', $db_array);

		$this->load->model('mdl_invoice_groups');

		$this->mdl_invoice_groups->adjust_invoice_number($invoice_id, $invoice_group_id);

	}

	public function delete_invoice_file($filename) {

		if (file_exists('uploads/temp/' . $filename)) unlink('uploads/temp/' . $filename);

	}

	public function save_invoice_history($invoice_id, $user_id, $invoice_history_data) {

		$db_array = array(
			'invoice_id'			=>	$invoice_id,
			'user_id'				=>	$user_id,
			'invoice_history_date'	=>	time(),
			'invoice_history_data'	=>	$invoice_history_data
		);

		$this->db->insert('mcb_invoice_history', $db_array);

	}

	private function calculate_due_date($date_entered) {

		return mktime(0, 0, 0, date("m", $date_entered), date("d", $date_entered) + $this->mdl_mcb_data->invoices_due_after, date("Y", $date_entered));

	}

	private function set_items($invoice_id) {

		$this->db->where('invoice_id', $invoice_id);

		$this->db->join('mcb_invoice_item_amounts', 'mcb_invoice_item_amounts.invoice_item_id = mcb_invoice_items.invoice_item_id');

		$this->db->join('mcb_tax_rates', 'mcb_tax_rates.tax_rate_id = mcb_invoice_items.tax_rate_id', 'LEFT');

		$items = $this->db->get('mcb_invoice_items')->result();

		return $items;

	}

	private function set_payments($invoice_id) {

		$this->load->model('payments/mdl_payments');

		$params = array(
			'where'	=>	array(
				'mcb_payments.invoice_id'	=>	$invoice_id
			)
		);

		return $this->mdl_payments->get($params);

	}

	private function set_client($client_id) {

		if (!isset($tmp_clients->$client_id)) {

			$this->load->model('clients/mdl_clients');

			$params = array(
				'where'	=>	array(
					'mcb_clients.client_id'	=>	$client_id
				)
			);

			$tmp_clients->$client_id = $this->mdl_clients->get($params);

		}

		return $tmp_clients->$client_id;

	}

	private function set_tax_rates($invoice_id) {

		$this->load->model('tax_rates/mdl_tax_rates');

		return $this->mdl_tax_rates->get_invoice_tax_rates($invoice_id);

	}

	private function set_item_tax_sums($invoice_id) {

		$this->db->select('tax_rate_name, tax_rate_percent, SUM(item_tax) AS tax_rate_sum');

		$this->db->group_by('mcb_tax_rates.tax_rate_id');

		$this->db->join('mcb_invoice_item_amounts', 'mcb_invoice_item_amounts.invoice_item_id = mcb_invoice_items.invoice_item_id');

		$this->db->join('mcb_tax_rates', 'mcb_tax_rates.tax_rate_id = mcb_invoice_items.tax_rate_id', 'LEFT');

		$this->db->where('mcb_invoice_items.invoice_id', $invoice_id);

		return $this->db->get('mcb_invoice_items')->result();


	}

	private function set_tags($invoice_id) {

		if ($this->mdl_mcb_data->version >= '0.8') {

			$this->load->model('invoices/mdl_invoice_tags');

			return $this->mdl_invoice_tags->get_tags($invoice_id);

		}

	}

	public function get_total_invoice_balance($user_id = NULL) {

		$this->db->select('SUM(invoice_balance) AS total_invoice_balance');

		$this->db->join('mcb_invoices', 'mcb_invoices.invoice_id = mcb_invoice_amounts.invoice_id');

		$this->db->where('mcb_invoices.invoice_is_quote', 0);

		if ($user_id) {

			$this->db->where('mcb_invoices.user_id', $user_id);

		}

		return $this->db->get('mcb_invoice_amounts')->row()->total_invoice_balance;

	}

}

?>