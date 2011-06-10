<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Sessions extends Controller {

	function __construct() {

		parent::__construct();

		$this->load->library(array('session'));

		$this->load->database();

	}

	function index() {

		redirect('sessions/login');

	}

	function login() {

		$this->_load_language();

		$this->load->helper(array('url', 'form'));

		$this->load->model('mdl_sessions');

		if ($this->mdl_sessions->validate()) {

			$this->load->model('mdl_auth');

			if ($user = $this->mdl_auth->auth('mcb_users', 'username', 'password', $this->input->post('username'), $this->input->post('password'))) {

				$object_vars = array('user_id', 'last_name', 'first_name', 'global_admin');

				// set the session variables
				$this->mdl_auth->set_session($user, $object_vars, array('is_admin'=>TRUE));

				// update the last login field for this user
				$this->mdl_auth->update_timestamp('mcb_users', 'user_id', $user->user_id, 'last_login', time());

				redirect('dashboard');

			}

		}

		$this->load->view('login');

	}

	function logout() {

		$this->load->helper('url');

		$this->session->sess_destroy();

		redirect('sessions/login');

	}

	function _load_language() {

		$this->load->model('mcb_data/mdl_mcb_data');

		$default_language = $this->mdl_mcb_data->get('default_language');

		if ($default_language) {

			$this->load->language('mcb', $default_language);

		}

		else {

			$this->load->language('mcb');

		}

	}

}

?>