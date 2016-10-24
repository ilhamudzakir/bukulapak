<?php

class Order_status_model extends CI_Model {

	function __Construct()
	{
		parent::__Construct();
	}
	
	var $table = 'order_status';
	var $id_field = 'id';
	var $limit = 1000; 
	var $column = array('id');
	var $order = array('create_date' => 'desc');

	function add($data)
	{
		$this->db->insert($this->table, $data);
	}

	function get_by_id($id)
	{
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->where('id',$id);
		return $this->db->get();
	}
	
}
// END order_model Class

/* End of file order_model.php */ 
/* Location: ./system/application/model/order_model.php */