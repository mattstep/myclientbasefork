<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Invoices extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('mdl_invoices');

	}

	function index() {

		$this->_post_handler();

		$this->redir->set_last_index();

		$order_by = uri_assoc('order_by');

		$client_id = uri_assoc('client_id');

		$status = uri_assoc('status');

		$is_quote = uri_assoc('is_quote');

		$page = (uri_assoc('page')) ? uri_assoc('page') : 1;

		$params = array(
			'paginate'		=>	TRUE,
			'limit'			=>	$this->mdl_mcb_data->results_per_page,
			'page'			=>	$page,
			'set_client'	=>	TRUE,
			'where'			=>	array()
		);

		$params['where']['mcb_invoices.invoice_is_quote'] = ($is_quote) ? 1 : 0;

		if (!$this->session->userdata('global_admin')) $params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		if ($client_id) {

			$params['where']['client_id'] = $client_id;

		}

		if ($status) {

			$params['where']['invoice_status'] = $status;

		}

		switch ($order_by) {
			case 'invoice_id':
				$params['order_by'] = 'mcb_invoices.invoice_id DESC';
				break;
			case 'client':
				$params['order_by'] = 'client_name';
				break;
			case 'total':
				$params['order_by'] = 'invoice_total DESC';
				break;
			case 'balance':
				$params['order_by'] = 'invoice_balance DESC';
				break;
			default:
				$params['order_by'] = 'mcb_invoices.invoice_date_entered DESC, mcb_invoices.invoice_id DESC';
		}

		$invoices = $this->mdl_invoices->get($params);

		$this->load->model('templates/mdl_templates');

		$data = array(
			'invoices'		=>	$invoices,
			'page_links'	=>	TRUE,
			'sort_links'	=>	TRUE
		);

		$this->load->view('index', $data);

	}

	function create() {

		if ($this->input->post('btn_cancel')) {

			redirect('invoices');

		}

		if (!$this->mdl_invoices->validate_create()) {

			$this->load->model(array('clients/mdl_clients','mdl_invoice_groups'));

			$this->load->helper('text');

			$data = array(
				'clients'			=>	$this->mdl_clients->get_active(),
				'invoice_groups'	=>	$this->mdl_invoice_groups->get()
			);

			$this->load->view('choose_client', $data);

		}

		else {

			$this->load->module('invoices/invoice_api');

			$package = array(
				'client_id'				=>	$this->input->post('client_id'),
				'invoice_date_entered'	=>	$this->input->post('invoice_date_entered'),
				'invoice_group_id'		=>	$this->input->post('invoice_group_id'),
				'invoice_is_quote'		=>	$this->input->post('invoice_is_quote')
			);

			$invoice_id = $this->invoice_api->create_invoice($package);

			redirect('invoices/edit/invoice_id/' . $invoice_id);

		}

	}

	function delete() {

		$invoice_id = uri_assoc('invoice_id');

		if ($invoice_id) {

			$this->mdl_invoices->delete($invoice_id);

		}

		redirect($this->session->userdata('last_index'));

	}

	function edit() {

		$tab_index = ($this->session->flashdata('tab_index')) ? $this->session->flashdata('tab_index') : 0;

		$this->_post_handler();

		$this->redir->set_last_index();

		$this->load->model(array(
			'clients/mdl_clients',
			'payments/mdl_payments',
			'tax_rates/mdl_tax_rates',
			'invoice_statuses/mdl_invoice_statuses',
			'templates/mdl_templates'
			)
		);

		$this->load->helper('text');

		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	uri_assoc('invoice_id')
			),
			'set_invoice_payments'	=>	TRUE,
			'set_invoice_items'		=>	TRUE,
			'set_invoice_tax_rates'	=>	TRUE,
			'set_tags'				=>	TRUE,
			'set_client'			=>	TRUE
		);

		if (!$this->session->userdata('global_admin')) {

			$params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		}

		$invoice = $this->mdl_invoices->get($params);

		$data = array(
			'invoice'					=>	$invoice,
			'payments'					=>	$invoice->invoice_payments,
			'clients'					=>	$this->mdl_clients->get_active(),
			'tax_rates'					=>	$this->mdl_tax_rates->get(),
			'invoice_statuses'			=>	$this->mdl_invoice_statuses->get(),
			'tab_index'					=>	$tab_index,
			'custom_fields'				=>	$this->mdl_fields->get_object_fields(1)
		);

		if ($data['invoice']) {

			$this->load->view('invoice_edit', $data);

		}

		else {

			redirect('dashboard/record_not_found');

		}

	}

	function generate_pdf() {

		$invoice_id = uri_assoc('invoice_id');

		$this->load->library('lib_output');

		$this->mdl_invoices->save_invoice_history($invoice_id, $this->session->userdata('user_id'), $this->lang->line('generated_invoice_pdf'));

		$this->lib_output->pdf($invoice_id, uri_assoc('invoice_template'));

	}

	function generate_html() {

		$invoice_id = uri_assoc('invoice_id');

		$this->load->library('invoices/lib_output');

		$this->mdl_invoices->save_invoice_history($invoice_id, $this->session->userdata('user_id'), $this->lang->line('generated_invoice_html'));

		$this->lib_output->html($invoice_id, uri_assoc('invoice_template'));

	}

	function jquery_load_history() {

		$this->load->model('mdl_invoice_history');

		$invoice_id = $this->input->post('invoice_id');

		$params = array(
			'where'	=>	array(
				'mcb_invoice_history.invoice_id'	=>	$invoice_id
			)
		);

		$data = array(
			'invoice_history'	=>	$this->mdl_invoice_history->get($params)
		);

		$this->load->view('invoice_history_table', $data);

	}

	function recalculate() {

		$this->load->model('mdl_invoice_amounts');

		$this->mdl_invoice_amounts->adjust();

		redirect('settings');

	}

	function quote_to_invoice() {

		$invoice_id = uri_assoc('invoice_id');

		if (!$this->mdl_invoices->validate_quote_to_invoice()) {

			$this->load->model('mdl_invoice_groups');

			$data = array(
				'invoice_groups'	=>	$this->mdl_invoice_groups->get(),
				'invoice'			=>	$this->mdl_invoices->get_by_id($invoice_id)
			);

			$this->load->view('quote_to_invoice', $data);

		}

		else {

			$this->mdl_invoices->quote_to_invoice($invoice_id, $this->input->post('invoice_date_entered'), $this->input->post('invoice_group_id'));

			redirect('invoices/edit/invoice_id/' . $invoice_id);

		}

	}

	function _post_handler() {

		if ($this->input->post('btn_add_new_item')) {

			redirect('invoices/items/form/invoice_id/' . uri_assoc('invoice_id'));

		}

		elseif ($this->input->post('btn_add_payment')) {

			redirect('payments/form/invoice_id/' . uri_assoc('invoice_id'));

		}

		elseif ($this->input->post('btn_add_invoice')) {

			redirect('invoices/create');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect('invoices/index');

		}

		elseif ($this->input->post('btn_submit_options_general') or $this->input->post('btn_submit_options_tax') or $this->input->post('btn_submit_notes')) {

			if ($this->input->post('btn_submit_options_general')) {

				$this->session->set_flashdata('tab_index', 0);

			}

			elseif ($this->input->post('btn_submit_options_tax')) {

				$this->session->set_flashdata('tab_index', 3);

			}

			elseif ($this->input->post('btn_submit_notes')) {

				$this->session->set_flashdata('tab_index', 4);

			}

			$this->mdl_invoices->save_invoice_options($this->mdl_fields->get_object_fields(1));

			$this->load->model('mdl_invoice_amounts');

			$this->mdl_invoice_amounts->adjust(uri_assoc('invoice_id'));

			redirect('invoices/edit/invoice_id/' . uri_assoc('invoice_id'));

		}

		elseif ($this->input->post('btn_quote_to_invoice')) {

			redirect('invoices/quote_to_invoice/invoice_id/' . uri_assoc('invoice_id'));

		}

	}

}

?>