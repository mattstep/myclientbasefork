<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Send_Email extends Admin_Controller {

	function form() {

		if ($this->input->post('btn_cancel')) {

			redirect('payments');

		}

		if (!uri_assoc('invoice_id', 4)) {

			redirect($this->session->userdata('last_index'));

		}

		$this->load->model(
			array(
			'mdl_payments',
			'invoices/mdl_invoices',
			'users/mdl_users'
			)
		);
		
		$invoice_id = uri_assoc('invoice_id', 4);

		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	$invoice_id
			),
			'set_client'			=>	TRUE,
			'set_invoice_payments'	=>	TRUE
		);

		$invoice = $this->mdl_invoices->get($params);

		if (!$this->mdl_payments->validate_email()) {

			if (!$_POST) {

				$this->mdl_payments->email_to = $invoice->client->client_email_address;

				$this->mdl_payments->email_from_name = $invoice->from_first_name . ' ' . $invoice->from_last_name;

				$this->mdl_payments->email_from_email = $invoice->from_email_address;

				$this->mdl_payments->email_subject = $this->lang->line('payment_receipt');

				$this->mdl_payments->email_body = '';

				$this->mdl_payments->template = uri_assoc('receipt_template', 4);

			}

			$this->load->model('templates/mdl_templates');

			$data = array(
				'templates'	=>	$this->mdl_templates->get('payment_receipts')
			);

			$this->load->view('send_email', $data);

		}

		else {

			$filename = 'receipt_' . $invoice_id;

			$full_filename = 'uploads/temp/' . $filename . '.pdf';

			$this->load->plugin($this->mdl_mcb_data->pdf_plugin);

			$data = array(
				'invoice'   =>  $invoice
			);

			$html = $this->load->view('receipt_templates/' . $this->input->post('template'), $data, TRUE);

			pdf_create($html, $filename, FALSE);

			$this->load->plugin('phpmailer');

			$email_body = $this->input->post('email_body');

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

			/* @todo - Add mdl_invoices->save_invoice_history */

			redirect($this->session->userdata('last_index'));

		}

	}

}

?>