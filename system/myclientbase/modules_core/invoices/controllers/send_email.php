<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Send_Email extends Admin_Controller {

	function index() {}

	function form() {

		if ($this->input->post('btn_cancel')) {

			redirect('invoices');

		}

		$invoice_id = uri_assoc('invoice_id', 4);

		if (!$invoice_id) {

			redirect($this->session->userdata('last_index'));

		}

		$this->load->model(array('mdl_invoices', 'users/mdl_users'));

		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	$invoice_id
			),
			'set_client'			=>	TRUE,
			'set_invoice_items'		=>	TRUE,
			'set_invoice_tax_rates'	=>	TRUE,
			'set_invoice_payments'	=>	TRUE
		);

		$invoice = $this->mdl_invoices->get($params);

		if (!$this->mdl_invoices->validate_email()) {

			if (!$_POST) {

				$this->mdl_invoices->email_to = $invoice->client->client_email_address;

				$this->mdl_invoices->email_from_name = $invoice->from_first_name . ' ' . $invoice->from_last_name;

				$this->mdl_invoices->email_from_email = $invoice->from_email_address;

				$this->mdl_invoices->email_subject = $this->lang->line('invoice') . ' #' . $invoice_id;

				$this->mdl_invoices->email_body = '';

				$this->mdl_invoices->invoice_template = uri_assoc('invoice_template', 4);

			}
			
			$this->load->model('templates/mdl_templates');

			$data = array(
				'templates'	=>	$this->mdl_templates->get('invoices')
			);

			$this->load->view('send_email', $data);

		}

		else {

			$filename = 'invoice_' . $invoice_id;

			$full_filename = 'uploads/temp/' . $filename . '.pdf';

			$this->load->plugin($this->mdl_mcb_data->pdf_plugin);

			$data = array(
				'invoice'   =>  $invoice
			);

			$html = $this->load->view('invoice_templates/' . $this->input->post('invoice_template'), $data, TRUE);

			pdf_create($html, 'invoice_' . $invoice_id, FALSE);

			$this->load->plugin('phpmailer');

			$email_body = ($this->input->post('invoice_as_body')) ? $this->input->post('email_body') . $html : $this->input->post('email_body');

			if (!$email_body) {

				$email_body = ' ';

			}

			phpmail_send(
				array($this->input->post('email_from_email'), $this->input->post('email_from_name')),
				$this->input->post('email_to'),
				$this->input->post('email_subject'),
				$email_body,
				$full_filename,
				$this->input->post('email_cc'),
				$this->input->post('email_bcc'));

			$this->mdl_invoices->delete_invoice_file($filename . '.pdf');

			$this->mdl_invoices->save_invoice_history($invoice_id, $this->session->userdata('user_id'), $this->lang->line('emailed_invoice') . ' to ' . $this->input->post('email_to'));

			redirect($this->session->userdata('last_index'));

		}

	}

}

?>