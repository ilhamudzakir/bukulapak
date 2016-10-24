<?php

class Confirmation_model extends CI_Model {
	function __Construct()
	{
		parent::__Construct();
	}
	
	var $table = 'confirmations';
	var $id_field = 'id';
	var $limit = 1000; 

	function add($data)
	{
		$this->db->insert($this->table, $data);
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
		$this->db->select($this->table.'.*,cities.city_name,countries.country_title');
		$this->db->join('cities','cities.city_id = '.$this->table.'.city_id');
		$this->db->join('countries','countries.country_id = '.$this->table.'.country_id');
		$this->db->from($this->table);
		$this->db->where('order_id',$order_id);
		return $this->db->get();
	}

	function unique_kode() { 
		$query=$this->db->query("select * from orders WHERE order_date LIKE '%".date('Y-m-d')."%' order by order_id DESC")->num_rows();
		if($query>0){
        $q = $this->db->query("SELECT MAX(RIGHT(order_total,3)) AS kodenya FROM orders order by order_id DESC")->row();
        $kd = $q->kodenya+1; 
       	
        }else{
        	$kd="001";
        }
        return $kd;
   } 

}
// END order_model Class

/* End of file order_model.php */ 
/* Location: ./system/application/model/order_model.php */