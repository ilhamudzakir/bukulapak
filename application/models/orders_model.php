<?php

class Orders_model extends CI_Model {

	function __Construct()
	{
		parent::__Construct();
	}
	
	var $table = 'orders';
	var $id_field = 'order_id';
	var $limit = 1000; 
	var $column = array('orders.order_code');
	var $order = array('order_date' => 'desc');

	private function _get_datatables_query()
	{
		$this->db->select('orders.*,order_status.title as order_status, area.title as area');
		$this->db->from($this->table);
		$this->db->join('order_status', 'orders.order_status_id = order_status.id');
		$this->db->join('area', 'orders.area_id = area.id');

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
			//$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			$this->db->order_by('orders.order_date','desc');
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($id,$order_status_id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.area_id',$id);
		if($order_status_id){
			$this->db->where($this->table.'.order_status_id',$order_status_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_admindatatables($order_status_id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		//$this->db->where($this->table.'.area_id',$id);
		if($order_status_id){
			$this->db->where($this->table.'.order_status_id',$order_status_id);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_statusdatatables($id,$order_status_id)
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where($this->table.'.area_id',$id);
		$this->db->where($this->table.'.order_status_id',$order_status_id);
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

	function count_filtered($id,$order_status_id)
	{
		$this->_get_datatables_query();
		$this->db->where($this->table.'.area_id',$id);
		
		if($order_status_id){
			$this->db->where($this->table.'.order_status_id',$order_status_id);	
		}

		$query = $this->db->get();
		return $query->num_rows();
	}

	function admincount_filtered($order_status_id)
	{
		$this->_get_datatables_query();
		//$this->db->where($this->table.'.area_id',$id);
		
		if($order_status_id){
			$this->db->where($this->table.'.order_status_id',$order_status_id);	
		}

		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id,$order_status_id)
	{
		$this->db->from($this->table);
		/*$this->db->select('users.area_id as area_id,'.$this->table.'.id as id,'.$this->table.'.user_id as user_id,'.$this->table.'.group_id as group_id, users.username as username, groups.name as group_name,users.active as active, users.first_name as first_name, users.last_name as last_name, users.email as email, users.last_login as last_login, users.nik as nik, users.phone as phone');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = '.$this->table.'.user_id');
		$this->db->join('groups', 'groups.id = '.$this->table.'.group_id');*/
		$this->db->where($this->table.'.area_id',$id);
		if($order_status_id){
			$this->db->where($this->table.'.order_status_id',$order_status_id);
		}
		return $this->db->count_all_results();
	}

	public function admincount_all($order_status_id)
	{
		$this->db->from($this->table);
		/*$this->db->select('users.area_id as area_id,'.$this->table.'.id as id,'.$this->table.'.user_id as user_id,'.$this->table.'.group_id as group_id, users.username as username, groups.name as group_name,users.active as active, users.first_name as first_name, users.last_name as last_name, users.email as email, users.last_login as last_login, users.nik as nik, users.phone as phone');
		$this->db->from($this->table);
		$this->db->join('users', 'users.id = '.$this->table.'.user_id');
		$this->db->join('groups', 'groups.id = '.$this->table.'.group_id');*/
		//$this->db->where($this->table.'.area_id',$id);
		if($order_status_id){
			$this->db->where($this->table.'.order_status_id',$order_status_id);
		}
		return $this->db->count_all_results();
	}

	
	function get_detail($id)
	{
		$this->db->select('orders.*, users.user_fullname, users.user_email,users.user_telepon,users.user_address, cities.city_name, order_status.order_status_name');
		$this->db->from($this->table);
		$this->db->join('users', 'orders.user_id = users.user_id');
		$this->db->join('cities', 'orders.city_id = cities.city_id');
		$this->db->join('order_status', 'orders.order_status_id = order_status.order_status_id');
		$this->db->where($this->id_field, $id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function update_admin($id, $datas)
	{
		$this->db->where($this->id_field, $id);
		$this->db->update($this->table, $datas);
		
		return TRUE;
	}
	
	function get_all($limit=null, $offset=null)
	{
		$this->db->select('order_id,order_code,users.user_fullname,order_date,order_status_name,order_date_confirm,city_name');
		$this->db->from($this->table);
		$this->db->join('users', 'orders.user_id = users.user_id');
		$this->db->join('cities', 'orders.city_id = cities.city_id');
		$this->db->join('order_status', 'orders.order_status_id = order_status.order_status_id');
		if(isset($limit)) $this->db->limit($limit, $offset);
		$this->db->order_by('order_id');
		return $this->db->get();
	}
	
	function get_all_count()
	{
		$this->db->select('order_id,order_code,users.user_fullname,order_date,order_status_name,order_date_confirm,city_name');
		$this->db->from($this->table);
		$this->db->join('users', 'orders.user_id = users.user_id');
		$this->db->join('cities', 'orders.city_id = cities.city_id');
		$this->db->join('order_status', 'orders.order_status_id = order_status.order_status_id');
		if(isset($limit)) $this->db->limit($limit, $offset);
		$this->db->order_by('order_id');
		return $this->db->count_all_results();
	}
	
	function get_items_by_id($id,$lapak_id)
	{
		$this->db->select("items.*,buku.judul as judul_buku, buku.kode_buku as kode_buku");
		$this->db->from("items");
		$this->db->join("buku", "buku.kode_buku = items.product_id");
		$this->db->where("order_id",$id);
		$this->db->where("lapak_id",$lapak_id);
		$this->db->order_by("item_id");
		return $this->db->get(); 
	}

	function get_items_by_id_group($id)
	{
		$this->db->select("items.*,buku.judul as judul_buku, buku.kode_buku as kode_buku, lapak.lapak_code as lapak_code");
		$this->db->from("items");
		$this->db->join("buku", "buku.kode_buku = items.product_id");
		$this->db->join("lapak", "lapak.id = items.lapak_id");
		$this->db->where("order_id",$id);
		$this->db->group_by("lapak_id");
		return $this->db->get(); 
	}
	
	function lapak_sum($id,$lapak_id)
	{
		$this->db->select("SUM(item_subtotal) as lapak_sum");
		$this->db->from("items");
		$this->db->join("buku", "buku.kode_buku = items.product_id");
		$this->db->where("order_id",$id);
		$this->db->where("lapak_id",$lapak_id);
		$this->db->order_by("item_id");
		return $this->db->get(); 
	}
	function get_items_by_id_count($id)
	{
		$this->db->select("*,product_sizes.product_size_code");
		$this->db->from("items");
		$this->db->join("products", "products.product_id = items.product_id");
		$this->db->join('product_sizes', 'product_sizes.product_size_id = items.product_size_id');
		$this->db->where("order_id",$id);
		$this->db->order_by("item_id");
		return $this->db->count_all_results();
	}

	function cekstatusorder($order_code)
	{
		$filter = array('order_code'=>'where/'.$order_code);
		$query = GetAll($this->table, $filter);
		return $query;
	}

	function add($orders)
	{
		$this->db->insert($this->table, $orders);
	}
	
	function update($id, $datas)
	{
		$this->db->where($this->id_field, $id);
		$this->db->update($this->table, $datas);
	}
	
	function update_by_code($code, $datas)
	{
		$this->db->where('order_code', $code);
		$this->db->update($this->table, $datas);
	}
	
	function valid_by_code($code)
	{
		$this->db->where('order_code', $code); 
		$query = $this->db->get($this->table, 1); 
		if($query->num_rows() > 0){
			return TRUE;
		}else
		{
			return FALSE;
		}
	}
	
	function get_by_code($code)
	{
		$this->db->select($this->table.'.*');
		$this->db->from($this->table);
		$this->db->where('order_code', $code); 
		return $this->db->get();
	}
	
	function send_mail_by_code($code)
	{
		$CI =& get_instance();
		
		$row = $this->get_by_code($code)->row_array();
		/*Start Send Mail*/
		$CI->email->from('shop@byabyu.com', 'shop@byabyu.com');
		$CI->email->to('febrika15286@gmail.com');
		$CI->email->cc('nisye_rhandayani@yahoo.co.id');
		$CI->email->bcc('andy13galuh@gmail.com');
		$CI->email->subject('Konfirmasi Pembayaran - '.$row['order_code'].' a/n '.$row['order_recipient']);
		$message ="";
		$message .='Konfirmasi pembayaran dari '.$row['order_code'];
		$message .="\n\n";
		$message .='Atas nama '.$row['order_recipient'];
		$message .="\n\n";
		$message .='Sebesar Rp. '.$row['order_total'];
		$message .="\n\n";
		$message .='Tanggal Order '.date('d-M-Y H:i',strtotime($row['order_date']));
		$message .="\n\n";
		$message .='Tanggal konfirmasi '.date('d-M-Y H:i',strtotime($row['order_date_confirm']));
		
		$CI->email->message($message);
		if($CI->email->send())
		{
			return TRUE;
		}else
		{
			return FALSE;
		}
		
		/*End Send Mail*/
	}
	
	function get_by_id($order_id)
	{
		$this->db->select($this->table.'.*,order_status.title as order_status');
		$this->db->from($this->table);
		$this->db->join('order_status','order_status.id = '.$this->table.'.order_status_id');
		$this->db->where('order_id',$order_id);
		return $this->db->get();
	}

	function filter_order($area,$from,$to){
		if($area==0){
		$query=$this->db->query("SELECT * FROM orders WHERE  order_status_id='2' and order_date BETWEEN '".$from." 00:00:00.000000' AND '".$to." 23:59:59.999999' ");
		}else{
		$query=$this->db->query("SELECT * FROM orders WHERE  area_id ='".$area."' and order_status_id='2' and order_date BETWEEN '".$from." 00:00:00.000000' AND '".$to." 23:59:59.999999' ");
		}
		return $query;
	}
	function filter_csv_pembayaran($area,$from,$to){
		if($area=='0'){
			$query=$this->db->query("select orders.order_id, orders.order_code, orders.order_name, orders.order_email, orders.order_phone, orders.order_recipient_name, orders.order_recipient_address, orders.order_recipient_phone, propinsi.title as propinsi, kabupaten.title as kabupaten, kecamatan.title as kecamatan, orders.order_recipient_postcode, orders.order_shipping_price, orders.order_subtotal, orders.order_total, orders.order_date, orders.order_date_confirm, area.title as area FROM orders INNER JOIN propinsi on propinsi.propinsi_id=orders.order_propinsi_id INNER JOIN kabupaten on kabupaten.kabupaten_id=orders.order_kabupaten_id INNER JOIN kecamatan on kecamatan.kecamatan_id=orders.order_kecamatan_id INNER JOIN area on area.id=orders.area_id  WHERE orders.order_status_id='2' and orders.order_date BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59'  ");
		}else{
		$query=$this->db->query("select orders.order_id, orders.order_code, orders.order_name, orders.order_email, orders.order_phone, orders.order_recipient_name, orders.order_recipient_address, orders.order_recipient_phone, propinsi.title as propinsi, kabupaten.title as kabupaten, kecamatan.title as kecamatan, orders.order_recipient_postcode, orders.order_shipping_price, orders.order_subtotal, orders.order_total, orders.order_date, orders.order_date_confirm, area.title as area FROM orders INNER JOIN propinsi on propinsi.propinsi_id=orders.order_propinsi_id INNER JOIN kabupaten on kabupaten.kabupaten_id=orders.order_kabupaten_id INNER JOIN kecamatan on kecamatan.kecamatan_id=orders.order_kecamatan_id INNER JOIN area on area.id=orders.area_id  WHERE  orders.area_id ='".$area."' and orders.order_status_id='2' and orders.order_date BETWEEN '".$from." 00:00:00' AND '".$to." 23:59:59'  ");
	}
		return $query;
	}
}
// END order_model Class

/* End of file order_model.php */ 
/* Location: ./system/application/model/order_model.php */