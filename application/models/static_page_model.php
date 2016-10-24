<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_page_model extends CI_Model {

	var $table = 'static_page';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function select_id($id){
		$this->load->database('default',TRUE);
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$data = $this->db->get();
		return $data;
	}
}