<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lapak_model extends CI_Model {

	var $table = 'lapak';
	var $join1 = 'users';
	var $join2 = 'propinsi';
	var $join3 = 'kabupaten';
	var $join4 = 'sekolah';
	var $column = array(
		//'lapak.id',
		//'lapak.sales_id',
		'lapak.title',
		//'lapak.start_active',
		//'lapak.end_active',
		//'lapak.propinsi_id',
		//'lapak.kabupaten_id',
		//'lapak.school_name',
		//'lapak.agen_id',
		//'lapak.agen_disc',
		//'lapak.buyer_disc',
		//'lapak.notes',
		//'lapak.is_approve_superior',
		//'lapak.superior_id',
		//'lapak.approve_superior_date',
		//'lapak.is_approve_next_superior',
		//'lapak.next_superior_id',
		//'lapak.approve_next_superior_date',
		//'lapak.active',
		//'user_sales.username',
		//'propinsi.title',
		//'kabupaten.title',
		//'user_agen.username',
		//'user_superior.username',
		//'user_next_superior.username',
		);
	var $order = array('lapak.id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->select(
			$this->table.'.id as lapak_id,'.
			//$this->table.'.sales_id as sales_id,'.
			$this->table.'.title as title,'.
			$this->table.'.start_active as start_active,'.
			$this->table.'.end_active as end_active,'.
			//$this->table.'.propinsi_id as propinsi_id,'.
			//$this->table.'.kabupaten_id as kabupaten_id,'.
			'sekolah.title as school_name,'.
			//$this->table.'.agen_id as agen_id,'.
			//$this->table.'.agen_disc as agen_disc,'.
			//$this->table.'.buyer_disc as buyer_disc,'.
			//$this->table.'.notes as notes,'.
			$this->table.'.is_approve_superior as is_approve_superior,'.
			//$this->table.'.superior_id as superior_id,'.
			//$this->table.'.approve_superior_date as approve_superior_date,'.
			$this->table.'.is_approve_next_superior as is_approve_next_superior,'.
			//$this->table.'.next_superior_id as next_superior_id,'.
			//$this->table.'.approve_next_superior_date as approve_next_superior_date,'.
			$this->table.'.active as active,'.
			//'user_sales.username as sales_name,'.
			//$this->join2.'.title as propinsi,'.
			//$this->join3.'.title as kabupaten,'.
			'user_agen.username as agen_name,'
			//'user_superior.username as superior_name,'.
			//'user_next_superior.username as next_superior_name,'
			);
		$this->db->from($this->table);
		//$this->db->join($this->join1.' as user_sales', 'user_sales.id = '.$this->table.'.sales_id');
		$this->db->join($this->join1.' as user_agen', 'user_agen.id = '.$this->table.'.agen_id');
		$this->db->join($this->join4.' as sekolah', 'sekolah.id = '.$this->table.'.sekolah_id');
		//$this->db->join($this->join1.' as user_superior', 'user_superior.id = '.$this->table.'.superior_id');
		//$this->db->join($this->join1.' as user_next_superior', 'user_next_superior.id = '.$this->table.'.next_superior_id');
		//$this->db->join($this->join2, $this->join2.'.propinsi_id = '.$this->table.'.propinsi_id');
		//$this->db->join($this->join3, $this->join3.'.kabupaten_id = '.$this->table.'.kabupaten_id');
		//$this->db->where($this->table.'.sales_id',$id);

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
			$this->db->order_by('lapak.id', 'desc');
			//$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
		$this->db->where($this->table.'.sales_id',$id);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
	}

	function get_datatables_agen($id)
	{

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.agen_id',$id);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
	}

	function get_datatables_admin_area($area_id)
	{

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('user_agen.area_id',$area_id);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
	}

	function get_datatables_atasan_1($id)
	{

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.superior_id',$id);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
	}

	function get_datatables_atasan_2($id)
	{

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.next_superior_id',$id);
		$query = $this->db->get();
		//die($this->db->last_query());
		return $query->result();
	}

	function count_filtered_admin_area($area_id)
	{
		$this->_get_datatables_query();
		$this->db->where('user_agen.area_id',$area_id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_admin_area($area_id)
	{
		$this->db->select(
			$this->table.'.id as lapak_id,'.
			$this->table.'.title as title,'.
			$this->table.'.start_active as start_active,'.
			$this->table.'.end_active as end_active,'.
			'sekolah.title as school_name,'.
			$this->table.'.active as active,'.
			'user_agen.username as agen_name,'
			);
		$this->db->from($this->table);
		$this->db->join($this->join1.' as user_agen', 'user_agen.id = '.$this->table.'.sales_id');
		$this->db->join($this->join4.' as sekolah', 'sekolah.id = '.$this->table.'.sekolah_id');
		$this->db->where('user_agen.area_id',$area_id);
		return $this->db->count_all_results();
	}

	function count_filtered_atasan_1($id)
	{
		$this->_get_datatables_query();
		$this->db->where($this->table.'.superior_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_atasan_1($id)
	{
		$this->db->select(
			$this->table.'.id as lapak_id,'.
			$this->table.'.title as title,'.
			$this->table.'.start_active as start_active,'.
			$this->table.'.end_active as end_active,'.
			'sekolah.title as school_name,'.
			$this->table.'.active as active,'.
			'user_agen.username as agen_name,'
			);
		$this->db->from($this->table);
		$this->db->join($this->join1.' as user_agen', 'user_agen.id = '.$this->table.'.sales_id');
		$this->db->join($this->join4.' as sekolah', 'sekolah.id = '.$this->table.'.sekolah_id');
		$this->db->where($this->table.'.superior_id',$id);
		return $this->db->count_all_results();
	}

	function count_filtered_atasan_2($id)
	{
		$this->_get_datatables_query();
		$this->db->where($this->table.'.next_superior_id',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_atasan_2($id)
	{
		$this->db->select(
			$this->table.'.id as lapak_id,'.
			$this->table.'.title as title,'.
			$this->table.'.start_active as start_active,'.
			$this->table.'.end_active as end_active,'.
			'sekolah.title as school_name,'.
			$this->table.'.active as active,'.
			'user_agen.username as agen_name,'
			);
		$this->db->from($this->table);
		$this->db->join($this->join1.' as user_agen', 'user_agen.id = '.$this->table.'.sales_id');
		$this->db->join($this->join4.' as sekolah', 'sekolah.id = '.$this->table.'.sekolah_id');
		$this->db->where($this->table.'.next_superior_id',$id);
		return $this->db->count_all_results();
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

	public function cronactivelapak()
	{
		$data = array(
               'active' => 'active',
            );

		$this->db->where('start_active', date('Y-m-d'));
		$this->db->where('active', 'approve');
		$this->db->where('is_deleted', 0);
		$this->db->update($this->table, $data); 
		return $this->db->affected_rows();
	}

	public function croninactivelapak()
	{
		$data = array(
               'active' => 'not active',
            );

		$this->db->where('end_active', date('Y-m-d'));
		$this->db->where('active', 'active');
		$this->db->where('is_deleted', 0);
		$this->db->update($this->table, $data); 
		return $this->db->affected_rows();
	}

	function count_filtered_agen($id)
	{
		$this->_get_datatables_query();
		$this->db->where($this->table.'.agen_id',$id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function count_all_agen($id)
	{
		$this->db->from($this->table);
		$this->db->where($this->table.'.agen_id',$id);
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

	public function save_sekolah($data)
	{
		$this->db->insert('sekolah', $data);
		return $this->db->insert_id();
	}

	public function masukkan_buku($data)
	{
		$this->db->insert('lapak_buku', $data);
		return $this->db->insert_id();
	}

	public function save_agen($data)
	{
		$this->db->insert('users', $data);
		$insert_id = $this->db->insert_id();
		$data_agen = array('user_id'=>$insert_id, 'group_id'=>4);
		$this->db->insert('users_groups',$data_agen);
		return $insert_id;
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function update_lapak_buku($where, $data)
	{
		$this->db->update('lapak_buku', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
		/*$this->db->where('id', $id);
		$this->db->delete($this->table);*/
	}

	public function getAllbysekolah($sekolah_id)
	{
		$filter_lapak = array("is_deleted"=>"where/0","sekolah_id"=>"where/".$sekolah_id,"id"=>"order/asc");
        $q_lapak = getAll($this->table,$filter_lapak);
        return $q_lapak;
	}

	public function getAllbycode($code)
	{
		/*
		$filter_lapak = array("is_deleted"=>"where/0","id"=>"where/".$id,"title"=>"where/".$title);
        $q_lapak = getJoin($this->table,$filter_lapak);
        return $q_lapak;
        */
        $this->db->select($this->table.".*,".$this->join4.".title as sekolah");
		$this->db->from($this->table);
		$this->db->join($this->join4, $this->join4.".id = ".$this->table.".sekolah_id");
		$this->db->where($this->table.".is_deleted",0);
		$this->db->where($this->table.".lapak_code",$code);
		$this->db->order_by($this->join4.".title");
		return $this->db->get(); 
        
	}

	public function getlapakbysekolah($sekolah_id)
	{
        $this->db->select('lapak.lapak_code as lapak_code,lapak.title as title,lapak.sales_id as sales_id, sekolah.title as sekolah');
		$this->db->from('lapak');
		$this->db->join('sekolah', 'lapak.sekolah_id = sekolah.id');
		$this->db->where('lapak.sekolah_id',$sekolah_id);
		$this->db->where('lapak.is_deleted',0);
		$this->db->order_by('lapak.create_date','desc');

		$query = $this->db->get();

		return $query;
	}
	
		function getrow($table,$where,$isi){
		$query=$this->db->query("select * from ".$table." where ".$where."='".$isi."'");
		return $query;
	}
	
	function select_where_order($column,$where,$order_by,$order_type){
		$this->load->database('default',TRUE);
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where($column,$where);
                $this->db->order_by($order_by, $order_type);
		$data = $this->db->get();
		return $data;
	}

}
