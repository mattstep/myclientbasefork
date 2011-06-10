<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Lib_output {

	var $CI;

	function __construct() {

		$this->CI =& get_instance();

	}

	function html($invoice_id, $invoice_template) {
		
		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	$invoice_id
			),
			'set_client'			=>	TRUE,
			'set_invoice_items'		=>	TRUE,
			'set_invoice_tax_rates'	=>	TRUE,
			'set_invoice_payments'	=>	TRUE
		);

		$data = array(
			'invoice'		=>	$this->CI->mdl_invoices->get($params)
		);

		$this->CI->load->view('invoices/invoice_templates/' . $invoice_template, $data);

	}

	function pdf($invoice_id, $invoice_template) {

		$this->CI->load->plugin($this->CI->mdl_mcb_data->pdf_plugin);

		$params = array(
			'where'	=>	array(
				'mcb_invoices.invoice_id'	=>	$invoice_id
			),
			'set_client'			=>	TRUE,
			'set_invoice_items'		=>	TRUE,
			'set_invoice_tax_rates'	=>	TRUE,
			'set_invoice_payments'	=>	TRUE
		);

		$invoice = $this->CI->mdl_invoices->get($params);

		$invoice_number = $invoice->invoice_number;

		$data = array(
			'invoice'		=>	$invoice
		);

		$html = $this->CI->load->view('invoices/invoice_templates/' . $invoice_template, $data, TRUE);

		$file_prefix = (!$data['invoice']->invoice_is_quote) ? $this->CI->lang->line('invoice') . '_' : $this->CI->lang->line('quote') . '_';

		pdf_create($html, $file_prefix . $invoice_number, TRUE);
		
	}

}

?>