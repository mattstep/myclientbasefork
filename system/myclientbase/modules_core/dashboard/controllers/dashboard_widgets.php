<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_Widgets extends Admin_Controller {

	function total_balance() {

		if ($this->session->userdata('global_admin')) {

			$invoice_total_balance = $this->mdl_invoices->get_total_invoice_balance();

		}

		else {

			$invoice_total_balance = $this->mdl_invoices->get_total_invoice_balance($this->session->userdata('user_id'));

		}

		$data = array(
			'invoice_total_balance'	=>	$invoice_total_balance
		);

		$this->load->view('dashboard/sidebar_invoice_balance', $data);

	}

}

?>