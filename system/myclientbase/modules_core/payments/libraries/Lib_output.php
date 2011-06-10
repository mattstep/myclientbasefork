<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Lib_output {

	var $CI;

	function __construct() {

		$this->CI =& get_instance();

		$this->CI->load->model('invoices/mdl_invoices');

	}

	function html($invoice_id, $payment_id, $template) {

		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	$invoice_id
			),
			'set_client'			=>	TRUE,
			'set_invoice_payments'	=>	TRUE
		);

		$data = array(
			'invoice'		=>	$this->CI->mdl_invoices->get($params)
		);

		$this->CI->load->view('payments/receipt_templates/' . $template, $data);

	}

	function pdf($invoice_id, $payment_id, $template) {

		$this->CI->load->plugin($this->CI->mdl_mcb_data->pdf_plugin);

		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	$invoice_id
			),
			'set_client'			=>	TRUE,
			'set_invoice_payments'	=>	TRUE
		);

		$data = array(
			'invoice'		=>	$this->CI->mdl_invoices->get($params)
		);

		$html = $this->CI->load->view('payments/receipt_templates/' . $template, $data, TRUE);

		pdf_create($html, 'receipt_' . $invoice_id, TRUE);
		
	}

}

?>