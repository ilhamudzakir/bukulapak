<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users_model extends CI_Model {

	var $table = 'users';
	var $join1 = 'area';
	var $column = array('users.nik','users.username','users.email', 'users.first_name', 'users.last_name','users.phone','tab_area.title','users.created_on','users.last_login','users.active','users.password_mask');
	//var $column = array('username');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		//$this->db->from($this->table);
		$this->db->select(
			$this->table.'.id as id,'.
			'tab_area.id as tab_area_id,'.
			$this->table.'.nik as nik,'.
			$this->table.'.username as username,'.
			$this->table.'.email as email,'.
			$this->table.'.first_name as first_name,'.
			$this->table.'.last_name as last_name,'.
			$this->table.'.phone as phone,'.
			$this->table.'.area_id as area_id,'.
			$this->table.'.created_on as created_on,'.
			$this->table.'.last_login as last_login,'.
			$this->table.'.active as active,'.
			$this->table.'.password_mask as password_mask,'.
			'tab_area.title as area,'
			);
		$this->db->from($this->table);
		$this->db->join($this->join1.' as tab_area', 'tab_area.id = '.$this->table.'.area_id');

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			//$this->db->order_by('id', 'desc');
		} 
		elseif(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
			//$this->db->order_by('id', 'DESC');
		}

		//die('is'.print_mz($_POST['order']));
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		//$this->db->where('active',1);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_user_groups($id)
	{
		$this->db->select('users_groups.id as id, users_groups.group_id as group_id, users_groups.user_id as user_id, , groups.name as group_name');
		$this->db->from('users_groups');
		$this->db->join('groups', 'groups.id = users_groups.group_id');
		$this->db->where('users_groups.user_id',$id);
		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->result();
		else
			return array();
	}


}
