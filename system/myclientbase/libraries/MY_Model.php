<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * My_Model is an extension to CodeIgniter's core model that helps make
 * developing models easier and less repetitive.
 *
 * Version 2010.11.18
 * Written by Jesse Terry
 *
 * CHANGELOG
 * 2010.11.18 - Added get_by_id() method
 *
 */

class MY_Model extends Model {

	var $table_name;

	var $primary_key;

	var $joins;

	var $select_fields;

	var $total_rows;

	var $page_links;

	var $current_page;

	var $num_pages;

	var $optional_params;

	var $order_by;

	function __construct() {

		parent::Model();

	}

	public function __get($member) {

		if (isset($this->$member)) {

			return $this->$member;

		}

	}

	public function __set($key, $value) {

		$this->$key = $value;

	}


	function get($params = NULL) {

		// prepare the query segments
		$this->_prep_params($params);

		// set up the joins
		$this->_prep_joins();

		// execute the query
		$query = $this->db->get($this->table_name);

		if (isset($params['debug']) and $params['debug'] == TRUE) {

			echo $this->db->last_query();

			exit;

		}

		$this->_prep_pagination($params);

		if (isset($params['where']) and is_array($params['where']) and isset($params['where'][$this->primary_key])) {

			// return a single row if the primary key exists in the where element
			return $query->row();

		}

		else {

			// otherwise return a full result set
			return $query->result();

		}

	}

	function get_by_id($id) {

		$this->db->where($this->primary_key, $id);

		$this->_prep_joins();

		$query = $this->db->get($this->table_name);

		return $query->row();

	}

	function save($db_array, $id=NULL, $set_flashdata = TRUE) {

		$success = FALSE;

		if ($id) {

			$this->db->where($this->primary_key, $id);

			$success = $this->db->update($this->table_name, $db_array);

		}

		else {

			$success = $this->db->insert($this->table_name, $db_array);

		}

		if ($set_flashdata) {

			$this->session->set_flashdata('success_save', TRUE);

		}

		return $success;

	}

	function delete($params, $set_flashdata = TRUE) {

		foreach ($params as $field=>$value) {

			$this->db->where($field, $value);

		}

		$this->db->delete($this->table_name);

		if ($set_flashdata) {

			$this->session->set_flashdata('success_delete', TRUE);

		}

	}

	function _prep_params($params = NULL) {

		if (isset($params['select'])) {

			$this->db->select($params['select'], FALSE);

		}

		elseif (isset($this->select_fields)) {

			$this->db->select($this->select_fields, FALSE);

		}

		if (isset($params['where'])) {

			if (is_array($params['where'])) {

				foreach ($params['where'] as $key=>$value) {

					if ($key) {

						$this->db->where($key, $value);

					}

					else {

						$this->db->where($value);

					}

				}

			}

			else {

				$this->db->where($params['where']);

			}

		}

		if (isset($params['like'])) {

			if (is_array($params['like'])) {

				foreach ($params['like'] as $key=>$value) {

					$this->db->like($key, $value);

				}

			}

			else {

				$this->db->like($params['like']);

			}

		}

		if (isset($params['where_in'])) {

			if (is_array($params['where_in'])) {

				foreach ($params['where_in'] as $key=>$value) {

					$this->db->where_in($key, $value);

				}

			}

			else {

				$this->db->where_in($params['where_in']);

			}

		}

		elseif (isset($this->where_in)) {

			if (is_array($this->where_in)) {

				foreach ($this->where_in as $key=>$value) {

					$this->db->where_in($key, $value);

				}

			}

			else {

				$this->db->where_in($this->where_in);

			}

		}

		// should the results be paginated?
		if (isset($params['paginate']) AND $params['paginate'] == TRUE AND (isset($params['limit']) OR isset($this->limit))) {

			if (!isset($params['page'])) {

				// set 1 as the default page if not specified
				$params['page'] = 1;

			}

			if (isset($params['limit'])) {

				$limit = $params['limit'];

			}

			else {

				$limit = $this->limit;

			}

			// define the offset
			$offset = ($params['page'] * $limit) - $limit;

			// set the limit
			$this->db->limit($limit, $offset);

		}

		elseif (isset($params['limit']) AND (!isset($params['paginate']) OR $params['paginate'] == FALSE)) {

			$this->db->limit($params['limit']);

		}

		if (isset($params['order_by'])) {

			$this->db->order_by($params['order_by']);

		}

		elseif (isset($this->order_by)) {

			$this->db->order_by($this->order_by);

		}

		// are there any optional parameters?

		if (isset($params) AND isset($this->optional_params)) {

			foreach ($this->optional_params as $key=>$param) {

				if (key_exists($key, $params)) {

					$method = $this->optional_params[$key]['method'];

					$clause = $this->optional_params[$key]['clause'];

					$this->db->$method($clause);

				}

			}

		}

	}

	function _prep_pagination($params) {

		if (isset($params['paginate']) AND $params['paginate'] == TRUE) {

			if (isset($params['limit'])) {

				$limit = $params['limit'];

			}

			else {

				$limit = $this->limit;

			}

			$query = $this->db->query('SELECT FOUND_ROWS() AS total_rows');

			$this->total_rows = $query->row()->total_rows;

			$this->load->library('pagination');

			$config = array(
				'base_url'			=>	$this->_base_url(),
				'total_rows'		=>	$this->total_rows,
				'per_page'			=>	$limit,
				'next_link'			=>	$this->lang->line('next') . ' >',
				'prev_link'			=>	'< ' . $this->lang->line('prev'),
				'cur_tag_open'		=>	'<span class="active_link">',
				'cur_tag_close'		=>	'</span>',
				'num_links'			=>	3
			);

			if (isset($params['page'])) {

				$config['cur_page'] = $params['page'];

			}

			else {

				$config['cur_page'] = 1;

			}

			$this->pagination->initialize($config);

			$this->page_links = $this->pagination->create_links();

			$this->current_page = $config['cur_page'];

			$this->num_pages = ceil($this->total_rows / $limit);

		}

	}

	function _base_url() {

		// strips the page segment and re-adds it to the end
		// for use in CI pagination library for base_url

		$uri_segments = $this->uri->uri_string();

		$uri_segments = explode('/', $uri_segments);

		// this is going to be a null value so unset it
		unset($uri_segments[0]);

		// add the index segment to the end of the array if it does not exist
		if (!in_array('index', $uri_segments, TRUE)) {

			$uri_segments[] = 'index';

		}

		foreach ($uri_segments as $key=>$value) {

			if ($value == 'page') {

				unset($uri_segments[$key], $uri_segments[$key + 1]);

			}

		}

		$uri_segments[] = 'page';

		return site_url(implode('/', $uri_segments));

	}

	function _prep_joins() {

		if (isset($this->joins)) {

			foreach ($this->joins as $table=>$join) {

				if (is_array($join)) {

					$this->db->join($table, $join[0], $join[1]);

				}

				else {

					$this->db->join($table, $join);

				}

			}

		}

	}

	function db_array() {

		$db_array = array();

		$field_data = $this->form_validation->_field_data;

		foreach (array_keys($field_data) as $field) {

			if (isset($_POST[$field])) {

				$db_array[$field] = $this->input->post($field);

			}

		}

		return $db_array;

	}

	function prep_validation($id) {

		// this function will return the initial values to populate a form on an edit

		$result = $this->get(array('where'=>array($this->primary_key=>$id)));

		foreach ($result as $key=>$value) {

			$this->$key = $value;

		}

	}

	function validate($obj = NULL) {

		foreach ($_POST as $key=>$value) {

			$this->$key = $value;

		}

		if ($obj) {

			return $this->form_validation->run($obj);

		}

		else {

			return $this->form_validation->run();

		}

	}

	function show($var) {

		echo "<pre>";

		print_r($var);

		echo "</pre>";

	}

}

?>