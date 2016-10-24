<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items_model extends CI_Model {
	function __Construct()
	{
		parent::__Construct();
	}
	
	var $table = 'items';
	
	function add($items)
	{
		$this->db->insert($this->table, $items);
	}
	
	function get_items_by_order_id($order_id)
	{
		// $this->db->select($this->table.'.*,products.product_image');
		// $this->db->join('products','products.product_id = items.product_id');
		$this->db->where('order_id',$order_id);
		$this->db->order_by('item_id','desc');
		return $this->db->get($this->table);
	}

	function get_lapak_pertama($order_id)
	{
		$this->db->select_min($this->table.'.item_id');
		$this->db->select($this->table.'.lapak_id as lapak_id,'.$this->table.'.sales_id as sales_id, lapak.active_user_id as admin_area_id, users.username as admin_area_name, users.email as admin_area_email ');
		$this->db->from($this->table);
		$this->db->join('lapak','lapak.id = '.$this->table.'.lapak_id');
		$this->db->join('users','users.id = lapak.active_user_id');
		$this->db->where('order_id',$order_id);
		return $this->db->get();
	}
}
// END items_model Class

/* End of file items_model.php */ 
/* Location: ./system/application/model/items_model.php */