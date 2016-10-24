<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class config_model extends CI_Model {

	var $table = 'config';
	

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

	public function getbytitle($title='')
	{
		$filter = array("title"=>"where/".$title);
        $query = GetAll($this->table,$filter);
        if($query->num_rows() > 0)
        {
        	$value = $query->row_array();
        	$varvalue = $value['value'];
        }else{
        	$varvalue = '';
        }
        return $varvalue;
	}

	public function delete_by_id($id)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}


}
