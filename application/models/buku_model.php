<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

	var $table = 'lapak_buku';
	

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
	
	public function select_limit()
	{
		$query = $this->db->query("select * from buku  limit 0,8");
        return $query;
	}
	
	public function getbukubysekolah($sekolah_id)
	{
        $this->db->select('lapak.title as title,lapak.sales_id as sales_id,lapak_buku.kode_buku as kode_buku, lapak_buku.lapak_id as lapak_id, lapak_buku.id as id, buku.cover as cover, buku.judul as judul, buku.pengarang as pengarang, buku.harga as harga, buku.bstudi as bstudi, buku.jenjang as jenjang, buku.berat as berat, sekolah.title as sekolah');
		$this->db->from('lapak');
		$this->db->join('sekolah', 'lapak.sekolah_id = sekolah.id');
		$this->db->join('lapak_buku', 'lapak.id = lapak_buku.lapak_id');
		$this->db->join('buku', 'lapak_buku.kode_buku = buku.kode_buku');
		$this->db->where('lapak.sekolah_id',$sekolah_id);
		$this->db->where('lapak_buku.is_deleted',0);
		$this->db->order_by('lapak_buku.create_date','desc');

		$query = $this->db->get();

		return $query;
	}
	public function getbukubysekolahstudy($sekolah_id,$study)
	{
        $this->db->select('lapak.title as title,lapak.sales_id as sales_id,lapak_buku.kode_buku as kode_buku, lapak_buku.lapak_id as lapak_id, lapak_buku.id as id, buku.cover as cover, buku.judul as judul, buku.pengarang as pengarang, buku.harga as harga, buku.bstudi as bstudi, buku.jenjang as jenjang, buku.berat as berat, sekolah.title as sekolah');
		$this->db->from('lapak');
		$this->db->join('sekolah', 'lapak.sekolah_id = sekolah.id');
		$this->db->join('lapak_buku', 'lapak.id = lapak_buku.lapak_id');
		$this->db->join('buku', 'lapak_buku.kode_buku = buku.kode_buku');
		$this->db->where('lapak.sekolah_id',$sekolah_id);
		$this->db->where('buku.bstudi',$study);
		$this->db->where('lapak_buku.is_deleted',0);
		$this->db->order_by('lapak_buku.create_date','desc');

		$query = $this->db->get();

		return $query;
	}

	public function getbukustudy($sekolah_id)
	{
        $this->db->select('lapak.title as title,lapak.sales_id as sales_id,lapak_buku.kode_buku as kode_buku, lapak_buku.lapak_id as lapak_id, lapak_buku.id as id, buku.cover as cover, buku.judul as judul, buku.pengarang as pengarang, buku.harga as harga, buku.bstudi as bstudi, buku.jenjang as jenjang, buku.berat as berat, sekolah.title as sekolah');
		$this->db->from('lapak');
		$this->db->join('sekolah', 'lapak.sekolah_id = sekolah.id');
		$this->db->join('lapak_buku', 'lapak.id = lapak_buku.lapak_id');
		$this->db->join('buku', 'lapak_buku.kode_buku = buku.kode_buku');
		$this->db->where('lapak.sekolah_id',$sekolah_id);
		$this->db->where('lapak_buku.is_deleted',0);
		$this->db->group_by('buku.bstudi');

		$query = $this->db->get();

		return $query;
	}

	public function getbukubylapak($lapak_id)
	{
        $this->db->select('lapak.title as title,lapak.sales_id as sales_id,lapak_buku.kode_buku as kode_buku, lapak_buku.lapak_id as lapak_id, lapak_buku.id as id, buku.cover as cover, buku.judul as judul, buku.pengarang as pengarang, buku.harga as harga, buku.bstudi as bstudi, buku.jenjang as jenjang, buku.berat as berat, sekolah.title as sekolah');
		$this->db->from('lapak');
		$this->db->join('sekolah', 'lapak.sekolah_id = sekolah.id');
		$this->db->join('lapak_buku', 'lapak.id = lapak_buku.lapak_id');
		$this->db->join('buku', 'lapak_buku.kode_buku = buku.kode_buku');
		$this->db->where('lapak.id',$lapak_id);
		$this->db->where('lapak_buku.is_deleted',0);
		$this->db->order_by('lapak_buku.create_date','desc');

		$query = $this->db->get();

		return $query;
	}

	public function delete_by_id($id)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function count_max(){
		$query=$this->db->query("select items.item_name, buku.cover, count(items.product_id) as jumlah from items inner join buku on items.product_id=buku.kode_buku group by items.item_name order by jumlah desc Limit 0,8")->result();
		return $query;
	}


}
