<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Invoice_Items extends MY_Model {

	public function __construct() {

		parent::__construct();

		$this->table_name = 'mcb_invoice_stored_items';

		$this->primary_key = 'mcb_invoice_stored_items.invoice_stored_item_id';

		$this->select_fields = 'SQL_CALC_FOUND_ROWS *';

		$this->order_by = 'invoice_stored_item';

		$this->limit = $this->mdl_mcb_data->results_per_page;

	}

	public function validate() {

		$this->form_validation->set_rules('invoice_stored_item', $this->lang->line('item'), 'required');
		$this->form_validation->set_rules('invoice_stored_description', $this->lang->line('item_description'));
		$this->form_validation->set_rules('invoice_stored_unit_price', $this->lang->line('unit_price'), 'required');

		return parent::validate();

	}

	public function db_array() {

		$db_array = parent::db_array();

		$db_array['invoice_stored_unit_price'] = standardize_number($db_array['invoice_stored_unit_price']);

		return $db_array;

	}

}

?>