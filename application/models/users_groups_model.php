<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users_groups_model extends CI_Model {

	var $table = 'users_groups';
	//var $column = array('user_id','area_id', 'group_id','users.username','groups.name','users.active');
	var $column = array('users.username');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->select('users.area_id as area_id,'.$this->table.'.id as id,'.$this->table.'.user_id as user_id,'.$this->table.'.group_id as group_id, users.username as username, groups.name as group_name,users.active as active, users.first_name as first_name, users.last_name as last_name, users.email as email, users.last_login as last_login, users.nik as nik, users.phone as phone');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = '.$this->table.'.user_id');
		$this->db->join('groups', 'groups.id = '.$this->table.'.group_id');

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($item != 'id'){
				if($_POST['search']['value'])
					($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
				$column[$i] = $item;
				$i++;
			}
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.group_id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_area_datatables($id,$area_id = 0)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.group_id',$id);
		$this->db->where('users.area_id',$area_id);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
	}

	function count_filtered($id)
	{
		$this->_get_datatables_query();
		$this->db->where($this->table.'.group_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id)
	{
		//$this->db->from($this->table);
		$this->db->select('users.area_id as area_id,'.$this->table.'.id as id,'.$this->table.'.user_id as user_id,'.$this->table.'.group_id as group_id, users.username as username, groups.name as group_name,users.active as active, users.first_name as first_name, users.last_name as last_name, users.email as email, users.last_login as last_login, users.nik as nik, users.phone as phone');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = '.$this->table.'.user_id');
		$this->db->join('groups', 'groups.id = '.$this->table.'.group_id');
		$this->db->where($this->table.'.group_id',$id);
		return $this->db->count_all_results();
	}
	
	public function count_filter($id)
	{
		//$this->db->from($this->table);
		$this->db->select('users.area_id as area_id,'.$this->table.'.id as id,'.$this->table.'.user_id as user_id,'.$this->table.'.group_id as group_id, users.username as username, groups.name as group_name,users.active as active, users.first_name as first_name, users.last_name as last_name, users.email as email, users.last_login as last_login, users.nik as nik, users.phone as phone');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = '.$this->table.'.user_id');
		$this->db->join('groups', 'groups.id = '.$this->table.'.group_id');
		$this->db->where($this->table.'.group_id',$id);
		$this->db->where('users.area_id',$this->session->userdata('area_id'));
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
