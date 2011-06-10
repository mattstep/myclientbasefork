<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Client_Center_Controller extends Controller {

	function __construct($var_required = NULL) {

		parent::Controller();

		$this->load->database();

		$this->load->helper('url');

		$this->load->model('mcb_modules/mdl_mcb_modules');

		$this->mdl_mcb_modules->set_module_data();

		if (!$this->mdl_mcb_modules->check_enable('client_center')) {

			redirect('sessions/login');

		}

		$this->load->library('session');

		if ($this->session->userdata('is_admin')) {

			redirect('client_center/admin');

		}

		if ($var_required and (!$this->session->userdata($var_required))) {

			redirect('client_center/sessions/login');

		}

		$this->load->model('mcb_data/mdl_mcb_data');

		$this->mdl_mcb_data->set_session_data();

		$this->load->helper(array('uri', 'mcb_currency', 'mcb_invoice', 'mcb_date', 'mcb_icon'));

		$this->load->language('mcb', $this->mdl_mcb_data->default_language);

		$this->load->language('client_center', $this->mdl_mcb_data->default_language);

		$this->load->library('form_validation');

		$this->load->model('fields/mdl_fields');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	}

}

?>