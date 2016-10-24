<?php

class Order_history_model extends CI_Model {

	function __Construct()
	{
		parent::__Construct();
	}
	
	var $table = 'order_history';
	var $id_field = 'id';
	var $limit = 1000; 
	var $column = array('order_history.order_id');
	var $order = array('create_date' => 'desc');

	function add($data)
	{
		$this->db->insert($this->table, $data);
	}

	function get_by_order_id($id)
	{
		$this->db->select($this->table.'.*,order_status.title as order_status, users.username as username');
		$this->db->from($this->table);
		$this->db->join('order_status','order_status.id = '.$this->table.'.order_status_id');
		$this->db->join('users','users.id = '.$this->table.'.create_user_id','left');
		$this->db->where('order_id',$id);
		return $this->db->get();
	}
	
}
// END order_model Class

/* End of file order_model.php */ 
/* Location: ./system/application/model/order_model.php */