<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Clients extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->_post_handler();

		$this->load->model('mdl_clients');

	}

	function index() {

		$this->load->helper('text');

		$this->redir->set_last_index();

		$page = (uri_assoc('page')) ? uri_assoc('page') : 1;

		$params = array(
			'paginate'	=>	TRUE,
			'limit'		=>	$this->mdl_mcb_data->results_per_page,
			'page'		=>	$page
		);

		if (uri_assoc('order_by') == 'email') {

			$params['order_by'] = 'email_address';

		}

		elseif (uri_assoc('order_by') == 'balance') {

			$params['order_by'] = 'client_total_balance DESC';

		}

		else {

			$params['order_by'] = 'client_name';

		}

		$data = array(
			'clients'	=>	$this->mdl_clients->get($params)
		);

		$this->load->view('index', $data);

	}

	function form() {

		$this->load->model('mcb_data/mdl_mcb_client_data');

		if (uri_assoc('client_id')) {

			$this->mdl_mcb_client_data->set_session_data(uri_assoc('client_id'));

		}

		$this->load->module('mcb_language');

		if ($this->mdl_clients->validate()) {

			$this->mdl_clients->save();

			redirect($this->session->userdata('last_index'));

		}

		else {

			$this->load->helper('form');

			if (!$_POST AND uri_assoc('client_id')) {

				$this->mdl_clients->prep_validation(uri_assoc('client_id'));

			}

			$data = array(
				'custom_fields'	=>	$this->mdl_clients->custom_fields
			);

			$this->load->view('form', $data);

		}

	}

	function details() {

		$this->redir->set_last_index();

		$this->load->model(
			array(
			'invoices/mdl_invoices',
			'mdl_contacts',
			'templates/mdl_templates'
			)
		);

		$client_params = array(
			'where'	=>	array(
				'mcb_clients.client_id'	=>	uri_assoc('client_id')
			)
		);

		$contact_params = array(
			'where'	=>	array(
				'mcb_contacts.client_id'	=>	uri_assoc('client_id')
			)
		);

		$invoice_params = array(
			'where'	=>	array(
				'mcb_invoices.client_id'	=>	uri_assoc('client_id')
			),
			'set_client'	=>	TRUE
		);

		if (!$this->session->userdata('global_admin')) {

			$invoice_params['where']['mcb_invoices.user_id'] = $this->session->userdata('user_id');

		}

		$client = $this->mdl_clients->get($client_params);

		$contacts = $this->mdl_contacts->get($contact_params);

		$invoices = $this->mdl_invoices->get($invoice_params);

		if ($this->session->flashdata('tab_index')) {

			$tab_index = $this->session->flashdata('tab_index');

		}

		else {

			$tab_index = 0;

		}

		$data = array(
			'client'	=>	$client,
			'contacts'	=>	$contacts,
			'invoices'	=>	$invoices,
			'tab_index'	=>	$tab_index
		);

		$this->load->view('details', $data);

	}

	function delete() {

		if (uri_assoc('client_id')) {

			$this->mdl_clients->delete(uri_assoc('client_id'));

		}

		$this->redir->redirect('clients');

	}

	function get($params = NULL) {

		return $this->mdl_clients->get($params);

	}

	function _post_handler() {

		if ($this->input->post('btn_add_client')) {

			redirect('clients/form');

		}

		elseif ($this->input->post('btn_cancel')) {

			redirect($this->session->userdata('last_index'));

		}

		elseif ($this->input->post('btn_add_contact')) {

			redirect('clients/contacts/form/client_id/' . uri_assoc('client_id'));

		}

	}

	function dropdown_options() {

		$this->load->helper('text');

		$data = array(
			'clients'	=>	$this->mdl_clients->get()
		);

		$this->load->view('dropdown_options', $data);

	}

}

?>