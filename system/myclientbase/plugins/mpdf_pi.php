<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename, $stream=TRUE) {

	require_once(APPPATH.'plugins/mpdf/mpdf.php');

	$CI =& get_instance();

	$CI->load->module('mcb_language');

	$charset = $CI->mcb_language->languages[$CI->mdl_mcb_data->default_language]['charset'];

	$mpdf = new mPDF($charset);

	$mpdf->charset_in='utf-8';

	$mpdf->default_font = 'F345reeSans';

	$mpdf->WriteHTML($html);

	if ($stream) {

		$mpdf->Output($filename, 'I');

	}

	else {

		$mpdf->Output('./uploads/temp/' . $filename . '.pdf', 'F');

	}

}

?>