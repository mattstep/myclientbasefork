<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Reports extends Admin_Controller {

	function __construct() {

		parent::__construct();

		$this->load->model('mdl_clients');

	}

	function index() {

	}

	function client_list() {

		$this->load->helper('text');

		$clients = $this->mdl_clients->get();

		$data = array(
			'clients'	=>	$clients,
			'validated'	=>	FALSE
		);
		
		$this->form_validation->set_rules('client_id', $this->lang->line('client'), 'required');
		$this->form_validation->set_rules('output_type', $this->lang->line('output_type'), 'required');



		if (!$this->form_validation->run()) {

			$this->load->view('reports/client_list/index', $data);

		}

		else {

			if ($this->input->post('client_id') == 'all') {

				$data['result_clients'] = $this->mdl_clients->get();

			}

			else {

				$data['result_clients'] = $this->mdl_clients->get(array('where'=>array('client_id'=>$this->input->post('client_id'))));

			}

			$data['validated'] = TRUE;

			if ($this->input->post('output_type') == 'preview') {

				$this->load->view('reports/client_list/index', $data);

			}

			elseif ($this->input->post('output_type') == 'html') {

				$this->load->view('reports/client_list/html', $data);

			}

			elseif ($this->input->post('output_type') == 'pdf') {

				$this->load->plugin($this->mdl_mcb_data->pdf_plugin);

				$html = $this->load->view('reports/client_list/html', $data, TRUE);

				pdf_create($html, 'client_details_' . date('Y-m-d'), TRUE);

			}

		}

	}

}

?>
