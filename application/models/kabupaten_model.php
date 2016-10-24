<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kabupaten_model extends CI_Model {

	var $table = 'kabupaten';
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getAll()
	{
		$filter = array("title"=>"order/asc");
        $query = GetAll($this->table,$filter);
        return $query;
	}

	public function delete_by_id($id)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}


}
