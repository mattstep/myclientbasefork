<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MCB_Language extends Controller {

	var $languages;

	function __construct() {

		parent::__construct();

		$this->load->helper('directory');

		$languages = directory_map(APPPATH . '/language');

		foreach ($languages as $key=>$language) {

			if (is_array($language)) {

				if (is_numeric(array_search('mcb_lang.php', $language)) and
					is_numeric(array_search('config.php', $language))) {

					require(APPPATH . '/language/' . $key . '/config.php');

					$this->languages[$key] = $config;


				}

			}

		}

	}
	
}

?>
