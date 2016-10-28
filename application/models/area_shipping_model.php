<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class area_shipping_model extends CI_Model {

	var $table = 'area_shipping';
	var $join1 = 'area';
	var $join2 = 'propinsi';
	var $join3 = 'kabupaten';
	var $column = array(
		'area.title',
		'propinsi.title',
		'kabupaten.title',
		'area_shipping.reguler',
		'area_shipping.ok',
		);
	var $order = array('area_shipping.id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		if($this->ion_auth->is_admin_area()){
			$id=$this->area_shipping->select_where('id',$this->session->userdata('user_id'))->row();
			$area=$id->area_id;
			
		}
		$this->db->select(
			$this->table.'.id as area_shipping_id,'.
			$this->join1.'.title as area,'.
			$this->join2.'.title as propinsi,'.
			$this->join3.'.title as kabupaten,'.
			$this->table.'.reguler as reguler,'.
			$this->table.'.ok as ok,'.
			$this->table.'.area_id as area_id,'.
			$this->table.'.propinsi_id as propinsi_id,'.
			$this->table.'.kabupaten_id as kabupaten_id,'
			);
		$this->db->from($this->table);
		$this->db->join($this->join1.' as area', 'area.id = '.$this->table.'.area_id');
		$this->db->join($this->join2.' as propinsi', 'propinsi.propinsi_id = '.$this->table.'.propinsi_id');
		$this->db->join($this->join3.' as kabupaten', 'kabupaten.kabupaten_id = '.$this->table.'.kabupaten_id');
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
			//$this->db->order_by('area_shipping.id', 'desc');
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
		$query = $this->db->get();
		//die($this->db->last_query());
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

	public function getAll()
	{
		$filter = array();
        $query = GetAll($this->table,$filter);
        return $query;
	}

	public function getbyid($propinsi_id,$kabupaten_id,$kecamatan_id)
	{
		$filter = array('propinsi_id'=>'where/'.$propinsi_id, 'kabupaten_id'=>'where/'.$kabupaten_id, 'kecamatan_id'=>'where/'.$kecamatan_id);
        $query = GetAll($this->table,$filter);
        return $query;
	}

	public function delete_by_id($id)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function where_like($table,$column,$where){
		$query=$this->db->query("SELECT * FROM ".$table." WHERE ".$column." LIKE '".$where."'"); 
		return $query;
	}
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	public function update($id,$data){
	$this->db->where('id', $id);
	$this->db->update('area_shipping', $data);
	}

	function select_where($column,$where){
		$this->load->database('default',TRUE);
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($column,$where);
		$data = $this->db->get();
		return $data;
	}

	function selected_where($table,$column,$where){
		$this->load->database('default',TRUE);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($column,$where);
		$data = $this->db->get();
		return $data;
	}
}
