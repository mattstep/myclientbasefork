<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Invoice_Items extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model('mdl_invoice_items');

	}

	function index() {

		$this->redir->set_last_index();

		$page = (uri_assoc('page')) ? uri_assoc('page') : 1;

		$params = array(
			'paginate'	=>	TRUE,
			'page'		=>	$page,
			'order_by'	=>	'invoice_stored_item'
		);

		$items = $this->mdl_invoice_items->get($params);

		$data = array(
			'items'	=>	$items
		);

		$this->load->view('index', $data);

	}

	function form() {

		if (!$this->mdl_invoice_items->validate()) {

			$this->load->helper('form');

			if (!$_POST AND uri_assoc('invoice_stored_item_id')) {

				$this->mdl_invoice_items->prep_validation(uri_assoc('invoice_stored_item_id'));

			}

			$this->load->view('form');

		}

		else {

			$this->mdl_invoice_items->save($this->mdl_invoice_items->db_array(), uri_assoc('invoice_stored_item_id'));

			$this->redir->redirect('invoice_items');

		}

	}

	function details() {

		$this->load->module('invoices');

		$item_params = array(
			'where'	=>	array(
				'mcb_items.invoice_stored_item_id'	=>	uri_assoc('invoice_stored_item_id')
			)
		);

		$invoice_params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_stored_item_id'	=>	uri_assoc('invoice_stored_item_id')
			)
		);

		$item = $this->mdl_invoice_items->get($item_params);

		$invoices = $this->invoices->get($invoice_params);

		$data = array(
			'item'		=>	$item,
			'invoices'	=>	$invoices);

		$this->load->view('details', $data);

	}

	function delete() {

		if (uri_assoc('invoice_stored_item_id')) {

			$this->mdl_invoice_items->delete(array('invoice_stored_item_id'=>uri_assoc('invoice_stored_item_id')));

		}

		$this->redir->redirect('invoice_items');

	}

	function jquery_item_data() {

		/* This function is only used to send JSON data back to a jquery function */

		$params = array(
			'where'	=>	array(
				'mcb_invoice_stored_items.invoice_stored_item_id'	=>	$this->input->post('invoice_stored_item_id')
			)
		);

		$invoice_item = $this->mdl_invoice_items->get($params);

		$array = array(
			'item_name'			=>	$invoice_item->invoice_stored_item,
			'item_cost'			=>	format_number($invoice_item->invoice_stored_unit_price, FALSE),
			'item_description'	=>	$invoice_item->invoice_stored_description
		);

		echo json_encode($array);

	}

	function _post_handler() {

		if ($this->input->post('btn_add')) {

			redirect('invoice_items/form');

		}

		if ($this->input->post('btn_cancel')) {

			redirect('invoice_items/index');

		}

	}

}

?>