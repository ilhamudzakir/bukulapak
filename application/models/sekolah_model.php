<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sekolah_model extends CI_Model {

	var $table = 'sekolah';
	var $column = array('title');
	var $order = array('title' => 'asc');
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getAll()
	{
		$filter = array("is_deleted"=>"where/0");
        $query = GetAll($this->table,$filter);
        return $query;
	}

	public function getAllbyidpropkab($sekolah_id,$propinsi_id,$kabupaten_id)
	{
		$filter = array("is_deleted"=>"where/0","id"=>"where/".$sekolah_id,"propinsi_id"=>"where/".$propinsi_id,"kabupaten_id"=>"where/".$kabupaten_id);
        $sekolah = GetAll('sekolah',$filter);
        return $sekolah;
	}

	private function _get_datatables_query()
	{
		if($this->ion_auth->is_admin_area()){
			$id=$this->sekolah->select_where_user('id',$this->session->userdata('user_id'))->row();
			$area=$id->area_id;
			
		}
		$this->db->from($this->table);
		if($this->ion_auth->is_admin_area()){
				$this->db->where('area_id',$area);
		}
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
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('is_deleted',0);
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
		/*$this->db->where('id', $id);
		$this->db->delete($this->table);*/
	}

	public function add($data)
	{
		$this->db->insert($this->table, $data);
		//return $this->db->insert_id();
	}
	function select_where_user($column,$where){
		$this->load->database('default',TRUE);
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($column,$where);
		$data = $this->db->get();
		return $data;
	}
	function select_sekolah(){
		$query=$this->db->query("select sekolah.id, sekolah.title from sekolah inner join lapak on sekolah.id=lapak.sekolah_id  where lapak.active='active' group by sekolah.id");
		return $query;
	}

}
