<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class propinsi_model extends CI_Model {

	var $table = 'propinsi';
	

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
