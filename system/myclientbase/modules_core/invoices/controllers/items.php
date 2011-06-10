<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Items extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model('mdl_items');

		$this->load->model('mdl_invoices');

		$this->load->model('invoice_items/mdl_invoice_items');

		$this->load->model('tax_rates/mdl_tax_rates');

	}

	function form() {

		if (!$this->mdl_items->validate()) {

			if (!$_POST AND uri_assoc('invoice_item_id', 4)) {

				$this->mdl_items->prep_validation(uri_assoc('invoice_item_id', 4));

				$this->mdl_items->item_date = format_date($this->mdl_items->item_date);

			}

			elseif (!$_POST AND !uri_assoc('invoice_item_id', 4)) {

				$this->mdl_items->item_date = format_date(time());
				
			}

			$invoice = $this->mdl_invoices->get(array('where'=>array('mcb_invoices.invoice_id'=>uri_assoc('invoice_id', 4))));

			$data = array(
				'invoice'		=>	$invoice,
				'invoice_items'	=>	$this->mdl_invoice_items->get(),
				'tax_rates'		=>	$this->mdl_tax_rates->get(),
				'custom_fields'	=>	$this->mdl_items->custom_fields
			);

			$this->load->view('item_form', $data);

		}

		else {

			$this->mdl_items->save($this->mdl_items->db_array(), uri_assoc('invoice_item_id', 4));

			$this->load->model('mdl_invoice_amounts');

			$this->mdl_invoice_amounts->adjust(uri_assoc('invoice_id', 4));

			$this->session->set_flashdata('tab_index', 1);

			redirect($this->session->userdata('last_index'));

		}

	}

	function delete() {

		if (uri_assoc('invoice_item_id', 4)) {

			$this->mdl_items->delete(uri_assoc('invoice_item_id', 4));

			$this->load->model('mdl_invoice_amounts');

			$this->mdl_invoice_amounts->adjust(uri_assoc('invoice_id', 4));

		}

		$this->session->set_flashdata('tab_index', 1);

		redirect($this->session->userdata('last_index'));

	}

	function _post_handler() {

		if ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

	}

}

?>