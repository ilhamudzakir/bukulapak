<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('print_mz')){	
	function print_mz($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		die();
	}
}

if (!function_exists('GetIdLang')){	
	function GetIdLang()
	{
		$CI =& get_instance();
		//return GetIDLang();

		/*andi's custom*/
		$language = $CI->config->item('language');

		$languages = array(
			'en' => 'english',
			'id' => 'indonesia'
		);
		
		$lang = array_search($language, $languages);
		if ($lang)
		{
			$langs = $lang;
		}

		$uri = uri_string();
		if ($uri != "")
		{
			$exploded = explode('/', $uri);
			if($exploded[0] == $langs)
			{
				$id_lang = ($exploded[0] == 'id') ? $CI->session->set_userdata("id_lang",3) : $CI->session->set_userdata("id_lang",1);
			}
		}
		return $CI->session->userdata("id_lang");

	}
}

if (!function_exists('ViewResultQuery')){	
	function ViewResultQuery($query)
	{
		$CI =& get_instance();
		if($query){
			if($query->num_rows() > 0){
				return $query->result_array();
			}else{
				return array();
			}
		}
	}
}

if (!function_exists('ViewRowQuery')){	
	function ViewRowQuery($query)
	{
		$CI =& get_instance();
		if($query){
			if($query->num_rows() > 0){
				return $query->row_array();
			}else{
				return array();
			}
		}
	}
}

if (!function_exists('GetUserID')){	
	function GetUserID()
	{
		$CI =& get_instance();
		return $CI->session->userdata("user_id");
		//return $CI->session->userdata("MzID");
	}
}

if (!function_exists('GetUserNameLogin')){	
	function GetUserNameLogin()
	{
		$CI =& get_instance();
        $f = array("id"=>"where/".$CI->session->userdata("user_id"));
        $q = GetAll('users',$f);
        if($q->num_rows() > 0){
          $v = $q->row_array();
          $u = $v['username'];
        }
        else $u = 'anonymous';

        return $u;
	}
}

if (!function_exists('getemailbyid')){	
	function getemailbyid($id)
	{
		$CI =& get_instance();
        $f = array("id"=>"where/".$id);
        $q = GetAll('users',$f);
        if($q->num_rows() > 0){
          $v = $q->row_array();
          $u = $v['email'];
        }
        else $u = 'anonymous';

        return $u;
	}
}

if (!function_exists('getphonebyid')){	
	function getphonebyid($id)
	{
		$CI =& get_instance();
        $f = array("id"=>"where/".$id);
        $q = GetAll('users',$f);
        if($q->num_rows() > 0){
          $v = $q->row_array();
          $u = $v['phone'];
        }
        else $u = 'anonymous';

        return $u;
	}
}

if (!function_exists('GetUserName')){	
	function GetUserName($table,$field,$userID)
	{
		$CI =& get_instance();
        $f = array("id"=>"where/".$userID);
        $q = GetAll($table,$f);
        if($q->num_rows() > 0){
          $v = $q->row_array();
          $u = $v[$field];
        }
        else $u = 'anonymous';

        return $u;
	}
}

if (!function_exists('GetHeaderFooter')){	
	function GetHeaderFooter($flag=NULL)
	{
		$CI =& get_instance();
		
		$data['header'] = 'header';
		$data['main_menu'] = 'main_menu';
		$data['footer'] = 'footer';
		
		return $data;
	}
}

if (!function_exists('GetSidebar')){	
	function GetSidebar($flag=NULL)
	{
		$CI =& get_instance();
		$detail_url = $CI->uri->segment(3);
		if($detail_url == 'detail' && $CI->uri->segment(2) == 'news'){
			$filternews = array("id <>"=>"where/".$CI->uri->segment(4),"is_publish"=>"where/publish","limit"=>"0/3","id"=>"order/desc");
		}else{
			$filternews = array("is_publish"=>"where/publish","limit"=>"0/3","id"=>"order/desc");
		}
		$data['news'] = GetAll("news",$filternews);
		
		return $data;
	}
}

if (!function_exists('GetImgConfirmation')){	
	function GetImgConfirmation($order_id=NULL)
	{
		$CI =& get_instance();
        $f = array("order_id"=>"where/".$order_id);
        $q = GetAll('orders',$f);
        if($q->num_rows() > 0){
          $v = $q->row_array();
          $u = $v['order_code'];
          $f1 = array("confirmation_code"=>"where/".$u);
          $q1 = GetAll('confirmations',$f1);
          if($q1->num_rows() > 0)
          {
          	$v1 = $q1->row_array();
          	$u1 = $v1['upload_file'];
          }else
          	$u1 = 'No Image';
        }
        else $u1 = 'No Image';

        return $u1;
	}
}

if (!function_exists('GetValue')){
	function GetValue($field,$table,$filter=array(),$order=NULL)
	{
		$CI =& get_instance();
		$CI->db->select($field);
		foreach($filter as $key=> $value)
		{
			$exp = explode("/",$value);
			if(isset($exp[1]))
			{
				if($exp[0] == "where") $CI->db->where($key, $exp[1]);
				else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
				else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
				else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
			}
			
			if($exp[0] == "group") $CI->db->group_by($key);
		}
		
		if($order) $CI->db->order_by($order);
		$q = $CI->db->get($table);
		foreach($q->result_array() as $r)
		{
			return $r[$field];
		}
		return 0;
	}
}

if (!function_exists('GetAll')){
	function GetAll($tbl,$filter=array())
	{
		$CI =& get_instance();
		foreach($filter as $key=> $value)
		{
			$exp = explode("/",$value);
			if(isset($exp[1]))
			{
				if($exp[0] == "where") $CI->db->where($key, $exp[1]);
				else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
				else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
				else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
			}
			else if($exp[0] == "where") $CI->db->where($key);
			
			if($exp[0] == "group") $CI->db->group_by($key);
		}
		
		if($tbl == "kg_news_subcategory" || $tbl == "contents" || $tbl == "news" || $tbl=="news_category" || $tbl=="kg_view_news")
		$CI->db->where("id_lang", GetIdLang());
		
		$q = $CI->db->get($tbl);
		
		return $q;
	}
}

if (!function_exists('GetJoin')){
	function GetJoin($tbl,$tbl_join,$condition,$type,$select,$filter=array())
	{
		$CI =& get_instance();
		$CI->db->select($select);
		foreach($filter as $key=> $value)
		{
			$exp = explode("/",$value);
			if(isset($exp[1]))
			{
				if($exp[0] == "where") $CI->db->where($key, $exp[1]);
				else if($exp[0] == "like") $CI->db->like($key, $exp[1]);
				else if($exp[0] == "order") $CI->db->order_by($key, $exp[1]);
				else if($key == "limit") $CI->db->limit($exp[1], $exp[0]);
			}
			
			if($exp[0] == "group") $CI->db->group_by($key);
		}
		$CI->db->join($tbl_join, $condition, $type);
		$q = $CI->db->get($tbl);
		
		return $q;
	}
}



if (!function_exists('GetAgen')){
	function GetAgen()
	{
		$CI =& get_instance();
		$area_id = $CI->session->userdata('area_id');
		$filter_agen = array('users_groups.group_id'=>"where/4","users.area_id"=>"where/".$area_id,"users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getbuku')){
	function Getbuku()
	{
		$CI =& get_instance();
		//$filter_agen = array('users_groups.group_id'=>"where/4","users.username"=>"order/desc");
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$kodebuku = GetAll('buku');
    	if($kodebuku->num_rows() > 0){
    		$q = $kodebuku->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('GetPropinsi')){
	function GetPropinsi($propinsi_id)
	{
		$CI =& get_instance();
		$filter = array('propinsi_id'=>"where/".$propinsi_id);
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$kodebuku = GetAll('propinsi',$filter);
    	if($kodebuku->num_rows() > 0){
    		$q = $kodebuku->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getsekolahbyid')){
	function Getsekolahbyid($sekolah_id)
	{
		$CI =& get_instance();
		$filter = array('id'=>"where/".$sekolah_id,'is_deleted'=>"where/0");
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$sekolah = GetAll('sekolah',$filter);
    	if($sekolah->num_rows() > 0){
    		$q = $sekolah->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('GetsekolahbyidDetail')){
	function GetsekolahbyidDetail($propinsi_id,$kabupaten_id,$sekolah_id)
	{
		$CI =& get_instance();
		$filter = array('propinsi_id'=>"where/".$propinsi_id,'kabupaten_id'=>"where/".$kabupaten_id,'id'=>"where/".$sekolah_id,'is_deleted'=>"where/0");
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$sekolah = GetAll('sekolah',$filter);
    	if($sekolah->num_rows() > 0){
    		$q = $sekolah->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('GetArea')){
	function GetArea()
	{
		$CI =& get_instance();
		$filter = array('is_active'=>"where/active",'is_deleted'=>"where/0");
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$kodebuku = GetAll('area',$filter);
    	if($kodebuku->num_rows() > 0){
    		$q = $kodebuku->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('GetAreaSales')){
	function GetAreaSales($sales_id)
	{
		$CI =& get_instance();
		$areas = array();
		$filter = array('users.id'=>"where/".$sales_id,'users.active'=>"where/1");
    	$agen = GetJoin('users','area','users.area_id = area.id','left','area.title as area_title, area.id as area_id',$filter);
    	//$kodebuku = GetAll('users',$filter);
    	if($agen->num_rows() > 0){
    		$q = $agen->row_array();
    		$areas = array('area_id'=>$q['area_id'],'area_title'=>$q['area_title']);
    	}
		
		return $areas;
	}
}

if (!function_exists('GetSekolah')){
	function GetSekolah()
	{
		$CI =& get_instance();
		$filter = array('is_deleted'=>"where/0");
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$sekolah = GetAll('sekolah',$filter);
    	if($sekolah->num_rows() > 0){
    		$q = $sekolah->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getkabupaten')){
	function Getkabupaten($kabupaten_id)
	{
		$CI =& get_instance();
		$filter = array('kabupaten_id'=>"where/".$kabupaten_id);
    	//$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	$kodebuku = GetAll('kabupaten',$filter);
    	if($kodebuku->num_rows() > 0){
    		$q = $kodebuku->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getagenbyid')){
	function Getagenbyid($agen_id)
	{
		$CI =& get_instance();
		$filter_agen = array('users_groups.group_id'=>"where/4",'users.id'=>"where/".$agen_id,"users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getsuperiorbyid')){
	function Getsuperiorbyid($superior_id)
	{
		$CI =& get_instance();
		$filter_agen = array('users_groups.group_id'=>"where/3",'users.id'=>"where/".$superior_id,"users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getnextsuperiorbyid')){
	function Getnextsuperiorbyid($next_superior_id)
	{
		$CI =& get_instance();
		$filter_agen = array('users_groups.group_id'=>"where/3",'users.id'=>"where/".$next_superior_id,"users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->row_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('GetLapakBuku')){
	function GetLapakBuku($lapak_id)
	{
		$CI =& get_instance();
		$filter = array('lapak_buku.lapak_id'=>"where/".$lapak_id,"lapak_buku.is_deleted"=>"where/0","lapak_buku.create_date"=>"order/desc");
    	$query = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','buku.judul as judul,buku.harga as harga,buku.cover as cover,buku.jenjang as jenjang,buku.kode_buku as kode_buku,lapak_buku.lapak_id as lapak_id,lapak_buku.id as id',$filter);
    	//$kodebuku = GetAll('buku');
    	/*if($query->num_rows() > 0){
    		$q = $query->result_array();
    	}else{
    		$q = array();
    	}*/
		
		return $query;
	}
}

if (!function_exists('GetLapakArea')){
	function GetLapakArea($lapak_id)
	{
		$CI =& get_instance();
		$CI->db->select('users.area_id as area_id, area.title as area_title');
		$CI->db->from('lapak');
		$CI->db->join('users','users.id = lapak.sales_id','left');
		$CI->db->join('area','area.id = users.area_id','left');
		$CI->db->where('lapak.id',$lapak_id);
		$query = $CI->db->get();
		if($query->num_rows() >0)
		{
			$value = $query->row_array();
		}else{
			$value = array();
		}

		return $value;
	}
}

if (!function_exists('GetLapakSummarybyArea')){
	function GetLapakSummarybyArea($area_id)
	{
		$CI =& get_instance();
		$CI->db->select('count(lapak.active) as jumlah_lapak, lapak.active as status_lapak');
		$CI->db->from('lapak');
		$CI->db->join('users','users.id = lapak.sales_id','left');
		$CI->db->join('area','area.id = users.area_id');
		$CI->db->join('sekolah','sekolah.id = lapak.sekolah_id');
		$CI->db->where('users.area_id',$area_id);
		$CI->db->group_by('lapak.active');
		$query = $CI->db->get();
		
		return $query;
	}
}

if (!function_exists('GetLapakSummarybySales')){
	function GetLapakSummarybySales($sales_id)
	{
		$CI =& get_instance();
		$CI->db->select('count(lapak.active) as jumlah_lapak, lapak.active as status_lapak');
		$CI->db->from('lapak');
		$CI->db->join('users','users.id = lapak.sales_id','left');
		$CI->db->join('area','area.id = users.area_id');
		$CI->db->join('sekolah','sekolah.id = lapak.sekolah_id');
		$CI->db->where('lapak.sales_id',$sales_id);
		$CI->db->group_by('lapak.active');
		$query = $CI->db->get();
		
		return $query;
	}
}

if (!function_exists('GetOrderSalesbyArea')){
	function GetOrderSalesbyArea($area_id)
	{
		$CI =& get_instance();
		$CI->db->select('sum(order_subtotal) AS total_order,area_id');
		$CI->db->from('orders');
		$CI->db->where('order_status_id >=',3);
		$CI->db->where('area_id',$area_id);
		$CI->db->group_by('area_id');
		$query = $CI->db->get();
		
		return $query;
	}
}

if (!function_exists('GetOrderSalesbySales')){
	function GetOrderSalesbySales($sales_id)
	{
		$CI =& get_instance();
		$CI->db->select('sum(items.item_subtotal) AS total_order,items.sales_id as sales_id');
		$CI->db->from('items');
		$CI->db->join('orders','orders.order_id = items.order_id');
		//$CI->db->where('order_status_id >=',3);
		$CI->db->where('items.sales_id',$sales_id);
		$CI->db->where('orders.order_status_id >=',3);
		$CI->db->group_by('sales_id');
		$query = $CI->db->get();
		
		return $query;
	}
}

if (!function_exists('GetSales')){
	function GetSales()
	{
		$CI =& get_instance();
		$filter_agen = array('users_groups.group_id'=>"where/3","users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('GetSalesbyArea')){
	function GetSalesbyArea()
	{
		$CI =& get_instance();
		$area_id = $CI->session->userdata('area_id');
		$filter_agen = array('users_groups.group_id'=>"where/3","users.area_id"=>"where/".$area_id,"users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as sales_id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}



if (!function_exists('GetAdmin')){
	function GetAdmin()
	{
		$CI =& get_instance();
		$filter_agen = array('users_groups.group_id'=>"where/1","users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('Getmember')){
	function Getmember()
	{
		$CI =& get_instance();
		$filter_agen = array('users_groups.group_id'=>"where/2","users.username"=>"order/asc");
    	$agen = GetJoin('users_groups','users','users_groups.user_id = users.id','left','users.username as title,users_groups.user_id as agen_id',$filter_agen);
    	if($agen->num_rows() > 0){
    		$q = $agen->result_array();
    	}else{
    		$q = array();
    	}
		
		return $q;
	}
}

if (!function_exists('ExplodeNameFile')){
	function ExplodeNameFile($source)
	{
		$ext = strrchr($source, '.');
		$name = ($ext === FALSE) ? $source : substr($source, 0, -strlen($ext));

		return array('ext' => $ext, 'name' => $name);
	}
}

if (!function_exists('GetThumb')){	
	function GetThumb($image, $path="_thumb")
	{
		$exp = ExplodeNameFile($image);
		return $exp['name'].$path.$exp['ext'];
	}
}

if (!function_exists('ResizeImage')){	
	function ResizeImage($up_file,$w,$h)
	{
		//Resize
		$CI =& get_instance();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $up_file;
		$config['dest_image'] = "./".$CI->config->item('path_upload')."/";
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = FALSE; //Width=Height
		$config['height'] = $h;
		$config['width'] = $w;
		
		$CI->load->library('image_lib', $config);
		if($CI->image_lib->resize()) return 1;
		else return 0; 
	}
}

if (!function_exists('Page')){
	//function Page($jum_record,$lmt,$pg,$path,$uri_segment)
	function Page($jum_record,$lmt,$path,$uri_segment)
	{
		$link = "";
		$config['base_url'] = $path;
		$config['total_rows'] = $jum_record;
		$config['per_page'] = $lmt;
		$config['num_links'] = 2;
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-prev">';
		$config['prev_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['uri_segment'] = $uri_segment;
		$config['next_link'] = 'NEXT >>';
		$config['prev_link'] = '<< Prev';
		$config['display_pages'] = TRUE; 
		
		$CI =& get_instance();
		$CI->pagination->initialize($config);
		$link = $CI->pagination->create_links();
		return $link;
	}
}


if (!function_exists('explodetags')){	
	function explodetags($val)
	{
		$i = 0;
		$files = array();
		$tags = explode(',',$val);
		$numItems = count($tags);
		$result="";
		foreach($tags as $tag=>$val){
			$result .= "<a href='".site_url('searching/tags/'.url_title(trim($val),'underscore',TRUE))."'>".trim($val)."</a>";
			if(++$i === $numItems) {
			    $result .= "";
			}else{
				$result .= ", ";
			}
		}
		return $result;
	}
}



if (!function_exists('redirectswitchlang')){	
	function redirectswitchlang()
	{
		$CI =& get_instance();
		$uri = $CI->uri->uri_string();
		if ($uri != ""){
			$exploded = explode('/', $uri);

			if($exploded[0] == 'en')
			{
				$new_uri = str_replace('en', 'id', $uri);
				redirect($new_uri);
			}else{
				$new_uri = str_replace('id', 'en', $uri);
				redirect($new_uri);
			}
		}
	}
}

if (!function_exists('cindexpage')){
	// function untuk halaman yang bersifat listing dengan category di tablenya
	// mandatory field : id_lang, is_publish, tags, views, downloads
	// cindexpage('view_books','books','books_list','book',4,4,'books/page')
	function cindexpage($table,$module,$main_content,$menu,$per_page=4,$uri_segment=4,$uri_paging){
		$CI =& get_instance();
		$data = GetHeaderFooter(1);
		$data = GetSidebar();
		
		$breadcrumb = "";
		$awal = $CI->uri->segment($uri_segment);
		
		$data['main_content'] = $main_content;
		$data['breadcrumb'] = $breadcrumb;
		//die($menu);
		$filter = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/Publish","id"=>"order/desc","limit"=> $awal."/".$per_page);
		$data['list'] = GetAll($table,$filter);
		
		
		$filter2 = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/Publish","id"=>"order/desc");
		$q = GetAll($table,$filter2);

		$path_paging = site_url($uri_paging);
		$pagination = Page($q->num_rows(),$per_page,$awal,$path_paging,$uri_segment);
		if(!$pagination) $pagination = "";
		$data['pagination'] = $pagination;

		return $data;
	}
}

if (!function_exists('ccategorypage')){
	// function untuk halaman per category yang bersifat listing 
	// mandatory field : id_lang, is_publish, tags, views, downloads
	// ccategorypage(1,'view_books','books','books_list','book',4,5,'books/cat/page')
	function ccategorypage($id,$table,$module,$main_content,$menu,$per_page,$uri_segment,$uri_paging){
		$CI =& get_instance();

			$data = GetHeaderFooter(1);
			$data = GetSidebar();

			$awal = $CI->uri->segment($uri_segment);

			$filtercat = array("id_lang"=>"where/".GetIDLang(),"id"=>"where/".$id,"is_publish"=>"where/publish");
			$category = ViewRowQuery(GetAll($module."_category",$filtercat));
			$id_category = $category['id'];
			filter_per_category($id_category,$module);

			if($category){
				$data['category'] = $category = $category['title']; 
			}else{
				$data['category'] = $category = '';
			}

			$filtercats = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/publish");
			$data['categories'] = GetAll($module."_category",$filtercats);

			//if($data['categories']->num_rows() == 0){
			//	redirect(site_url($module));
			//}

			
			$breadcrumb = "";
			
			$data['main_content'] = $main_content;
			$data['breadcrumb'] = $breadcrumb;

			$filter = array("id_lang"=>"where/".GetIDLang(),"id_".$module."_category"=>"where/".$id,"is_publish"=>"where/publish","is_featured"=>"where/featured","id"=>"order/desc","limit"=> "0/1");
			$data['featured'] = $f = GetAll($table,$filter);

			if($f){
				if($f->num_rows() > 0) {
					$fe = $f->row_array();
					$featured_id = $fe['id'];
				}else{
					$featured_id = 0;
				}
			}else{
				$featured_id = 0;
			}
			
			$filter = array("id !="=>"where/".$featured_id,"id_lang"=>"where/".GetIDLang(),"id_".$module."_category"=>"where/".$id,"is_publish"=>"where/publish","id"=>"order/desc","limit"=> $awal."/".$per_page);
			$data['list'] = GetAll($table,$filter);
			
			$filter2 = array("id !="=>"where/".$featured_id,"id_lang"=>"where/".GetIDLang(),"id_".$module."_category"=>"where/".$id,"is_publish"=>"where/publish","id"=>"order/desc");
			$q = GetAll($table,$filter2);

			$path_paging = site_url($uri_paging);
			$pagination = Page($q->num_rows(),$per_page,$awal,$path_paging,$uri_segment);
			if(!$pagination) $pagination = "";
			$data['pagination'] = $pagination;

			return $data;
		
	}
}

if (!function_exists('cdetailpage')){
	// function untuk halaman detail dengan table category
	// mandatory field : id_lang, is_publish, tags, views, downloads
	// cdetailpage(1,'kg_view_books','books','books_detail','book')	
	function cdetailpage($id,$table,$module,$main_content,$menu){
		$CI =& get_instance();


			$data = GetHeaderFooter(1);
			$data = GetSidebar();
			$data['main_content'] = $main_content;

			$filtercats = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/publish");
			$data['categories'] = GetAll($module."_category",$filtercats);
			$qcat = $data['categories']->row_array();
			$id_category = $qcat['id'];

			filter_per_category($id_category,$module);

			$filtercontent = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/Publish","id"=>"where/".$id);
			$data['content'] = $rowcontent = ViewRowQuery(GetAll($table,$filtercontent));
			$list = GetAll($table,$filtercontent);
			
			if($rowcontent){
				$contenttitle = $data['contenttitle'] = $rowcontent['title'];
				//$category = $rowcontent['category'];

				$filtercat = array("id_lang"=>"where/".GetIDLang(),"id"=>"where/".$id_category,"is_publish"=>"where/publish");
				$category = ViewRowQuery(GetAll($module."_category",$filtercat));
				//print_r($category);
				if($category){
					$data['category'] = $category['title'];
					$data['category_id'] = $category['id'];
				}else{
					$data['category'] = $category = '';
					$category_id = 0;
				}

				$id_category = $rowcontent['id_'.$module.'_category'];
				$data['tags'] = $rowcontent['tags'];
				$views = $rowcontent['views'];

				updateviews($id,'kg_'.$module,$views);
			}else{
				$contenttitle = $data['contenttitle'] = '';
				$category = '';
				$id_category = 1;

				redirectswitchlang();
			}

			foreach($list->result_array() as $f)
			{
				$i = 0;
				$files = "";
				$tags = explode(',',$f['tags']);
				$numItems = count($tags);
				$result="";
				$files = "SELECT * FROM kg_".$module." where id_lang = ".GetIDLang()." and id <> ".$f['id']. " and (";
				foreach($tags as $tag=>$val){
					if($val != ""){
						$files .= " tags like '%".$val."%'";
						if(++$i === $numItems){
					    	$files .= "";
						}else{
							$files .= " or ";
						}
					}else
					{
						$files .= " tags like '0'";
					}
				}
				$files .= ") limit 0,4";
			}

			$data['rel_link'] = $CI->db->query($files);

			$breadcrumb = "";
			$breadcrumb .= '<ol class="breadcrumb text-right">';
			$breadcrumb .= '<li><a href="'.site_url('home').'">Home</a></li>';
			$breadcrumb .= '<li><a href="'.site_url($module.'/cat/'.$data['category_id'].'/'.strtolower(url_title($data['category']))).'">'.$data['category'].'</a></li>';
			$breadcrumb .= '<li class="active">'.word_limiter($contenttitle, 6).'</li>';
			$breadcrumb .= '</ol>';	

			$data['breadcrumb'] = $breadcrumb;
			return $data;
		
	}
}

if (!function_exists('detailpage')){
	// function untuk halaman detail tanpa table category
	// mandatory field : id_lang, is_publish, tags, views, downloads
	// detailpage(1,'kg_view_books','books','books_detail','book')
	function detailpage($id,$table,$module,$main_content,$menu){
		$CI =& get_instance();
		$data = GetHeaderFooter(1);
		$data = GetSidebar();
		$data['main_content'] = $main_content;

		$filtercontent = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/Publish","id"=>"where/".$id);
		$data['content'] = $rowcontent = ViewRowQuery(GetAll($table,$filtercontent));
		$list = GetAll($table,$filtercontent);

		if($rowcontent){
			$contenttitle = $data['contenttitle'] = $rowcontent['title'];
			$views = $rowcontent['views'];
			updateviews($id,$table,$views);
		}else{
			redirectswitchlang();
		}

		foreach($list->result_array() as $f)
		{
			$i = 0;
			$files = "";
			$tags = explode(',',$f['tags']);
			$numItems = count($tags);
			$result="";
			$files = "SELECT * FROM ".$table." where id_lang = ".GetIDLang()." and id <> ".$f['id']. " and (";
			foreach($tags as $tag=>$val){
				if($val != ""){
					$files .= " tags like '%".$val."%'";
					if(++$i === $numItems){
				    	$files .= "";
					}else{
						$files .= " or ";
					}
				}else
				{
					$files .= " tags like '0'";
				}
			}
			$files .= ") limit 0,4";
		}

		$data['rel_link'] = $CI->db->query($files);

		$breadcrumb = "";
		$data['breadcrumb'] = $breadcrumb;
		return $data;
	}
}

if(!function_exists('filter_per_category')){
	function filter_per_category($id,$module){
		$CI =& get_instance();
//die('yes');
		$filterakses = array("id_lang"=>"where/".GetIDLang(),"is_publish"=>"where/publish","id"=>"where/".$id);
		$qakses = GetAll($module."_category",$filterakses);

		if($qakses->num_rows() == 0){
			redirect(site_url($module));
		}
	}
}

if (!function_exists('updateviews')){	
	function updateviews($id,$table,$views){
		$CI =& get_instance();
		$views_curr = $views + 1;
		$CI->db->where('id', $id);
		$CI->db->where('id_lang', GetIdLang());
		$CI->db->update($table,array('views' => $views_curr)); 
	}
}

if (!function_exists('flickr_api_setup')){
	function flickr_api_setup(){
		$CI =& get_instance();
		//$CI->load->library('flickr_api','flickr_api');
		$q = GetAll('kg_flickr_api',array("id"=>"where/1"));
		$val = $q->row_array();
		$flickr_api_params = array(
            'request_format'    => $val['request_format'],
            'response_format'    => $val['response_format'],
            'api_key'            => $val['api_key'],
            'secret'            => $val['secret_key'],
            'cache_use_db'        => FALSE,
            'cache_expiration'    => $val['cache_expiration'],
            'cache_max_rows'    => $val['cache_max_rows']
        );
	    //$CI->flickr_api->initialize($flickr_api_params);
	    $CI->phpflickr->phpflickr($val['api_key'], $val['secret_key'], true);
	    return $val;
	}
}

if (!function_exists('flickr_api_paging')){
	function flickr_api_paging($controller,$function,$total_photos,$perpage,$page){
		//start Paging
	    $total_page = ceil(intval($total_photos) / intval($perpage));
	   	if($total_page == 1){
	   		$total_page = 0;
	   	}

		if($page == 1){
			$next = intval($page) + 1;
			$prev = "";
			$itemnext = "<a href='".site_url($controller.'/'.$function.'/'.$next)."' class='btn btn-default'>Next</a>";
			$itemprev = "";
		}

		if($page > 1){
			$next = intval($page) + 1;
			$prev = intval($page) - 1;
			$itemnext = "<a href='".site_url($controller.'/'.$function.'/'.$next)."' class='btn btn-default'>Next</a>";
			$itemprev = "<a href='".site_url($controller.'/'.$function.'/'.$prev)."' class='btn btn-default'>Prev</a>";
		}

		if($page == $total_page){
			$next = "";
			$prev = intval($page) - 1;
			$itemnext = "";
			$itemprev = "<a href='".site_url($controller.'/'.$function.'/'.$prev)."' class='btn btn-default'>Prev</a>";
		}

		if($page > $total_page){
			$next = "";
			$prev = intval($page) - 1;
			$itemnext = "";
			$itemprev = "";
		}

		$data['next'] = $itemnext;
		$data['prev'] = $itemprev;
		//end paging

		return $data;
	}
}

if (!function_exists('flickr_api_paging_by_id')){
	function flickr_api_paging_by_id($id,$controller,$function,$total_photos,$perpage,$page){
		//start Paging
	    $total_page = ceil(intval($total_photos) / intval($perpage));
	   	if($total_page == 1){
	   		$total_page = 0;
	   	}

		if($page == 1){
			$next = intval($page) + 1;
			$prev = "";
			$itemnext = "<a href='".site_url($controller.'/'.$function.'/'.$id.'/'.$next)."' class='btn btn-default'>Next</a>";
			$itemprev = "";
		}

		if($page > 1){
			$next = intval($page) + 1;
			$prev = intval($page) - 1;
			$itemnext = "<a href='".site_url($controller.'/'.$function.'/'.$id.'/'.$next)."' class='btn btn-default'>Next</a>";
			$itemprev = "<a href='".site_url($controller.'/'.$function.'/'.$id.'/'.$prev)."' class='btn btn-default'>Prev</a>";
		}

		if($page == $total_page){
			$next = "";
			$prev = intval($page) - 1;
			$itemnext = "";
			$itemprev = "<a href='".site_url($controller.'/'.$function.'/'.$id.'/'.$prev)."' class='btn btn-default'>Prev</a>";
		}

		if($page > $total_page){
			$next = "";
			$prev = intval($page) - 1;
			$itemnext = "";
			$itemprev = "";
		}

		$data['next'] = $itemnext;
		$data['prev'] = $itemprev;
		//end paging

		return $data;
	}
}


if (!function_exists('inside_module')){
	function inside_module($id_parents){
		$CI =& get_instance();
		$filterp = array("is_publish"=>"where/publish","id_parents"=>"where/".$id_parents,"id_lang"=>"where/".GetIdLang(),"sort"=>"order/asc");
		$pmenu = GetAll("kg_menu",$filterp);
		$result = "";
		if($pmenu->num_rows() > 0){
			foreach ($pmenu->result_array() as $v) {
				$result .='<li>';
				$result .='<a href="'.site_url($v['file']).'">'.$v['title'].'</a>';
				

				$filters = array("is_publish"=>"where/publish","id_parents"=>"where/".$v['id'],"id_lang"=>"where/".GetIdLang(),"sort"=>"order/asc");
				$smenu = GetAll("kg_menu",$filters);
				if($smenu->num_rows() > 0){
					$result .='<ul>';
					foreach ($smenu->result_array() as $s) {
						$result .='<li>';
						$result .='<a href="'.site_url($s['file']).'">'.$s['title'].'</a>';
						$result .='</li>';
					}
					$result .='</ul>';
				} 	
				$result .='</li>';
			}
		} 
		return $result;
	}
}

if (!function_exists('latest_news')){
	function latest_news(){
		$CI =& get_instance();
		$filterp = array("is_publish"=>"where/publish","id_lang"=>"where/".GetIdLang(),"sort"=>"id/desc","limit"=>"0/3");
		$pmenu = GetAll("kg_news",$filterp);
		$result = "";
		if($pmenu->num_rows() > 0){
			$result .="<div class='inside-module'>";
			$result .="<h4>Latest News</h4>";
			$result .="<ul>";
			
			foreach ($pmenu->result_array() as $v) {
				$result .='<li>';
				$result .='<a href="'.site_url('news/detail/'.$v['id'].'/'.url_title($v['title'])).'" title="'.$v['title'].'" >'.$v['title'].'</a>'; 	
				$result .='</li>';
			}

			$result .= "</ul>";
			$result .= "</div>";

		} 
		return $result;
	}
}

if (!function_exists('latest_publication')){
	function latest_publication(){
		$CI =& get_instance();
		$filterp = array("is_publish"=>"where/publish","id_lang"=>"where/".GetIdLang(),"sort"=>"id/desc","limit"=>"0/1");
		$pmenu = GetAll("kg_publication",$filterp);
		$result = "";
		if($pmenu->num_rows() > 0){
			$result .="<div class='inside-module'>";
			$result .="<h4>Latest Publication</h4>";
			$result .="<ul>";
			
			foreach ($pmenu->result_array() as $v) {
				$result .='<li>';
				if($v['thumbnail'] != "" || $v['thumbnail'] != NULL){
                    $result.='<a href="'.site_url('publication/detail/'.$v['id'].'/'.url_title($v['title'])).'"><img src="'.base_url().'uploads/'.getThumb($v['thumbnail']).'" class="img-thumbnail sidebar-thumbnail img-responsive" /><h5>'.$v['title'].'</h5></a>';
                }

				//$result .='<a href="'.site_url('publication/detail/'.$v['id'].'/'.url_title($v['title'])).'" title="'.$v['title'].'" ><img src="'.base_url().'uploads/getThumb('..')">'.$v['title'].'</a>'; 	
				$result .='</li>';
			}

			$result .= "</ul>";
			$result .= "</div>";

		} 
		return $result;
	}
}

if (!function_exists('content_breadcrumb')){
	function content_breadcrumb(){
		$CI =& get_instance();
		$breadcrumb = "";
		$uri_string = uri_string();
		$expuri = explode('/',$uri_string);
		$lasturi = end($expuri);
		$filter = array("is_publish"=>"where/publish","file"=>"like/".$lasturi,"id_lang"=>"where/".GetIdLang(),"id"=>"order/asc","limit"=>"0/1");
		$mainmenu = GetAll("kg_menu",$filter);
		if($mainmenu->num_rows() > 0){
			$mm = $mainmenu->row_array();
			if($mm['id_parents'] != 0){
				$filterp = array("is_publish"=>"where/publish","id"=>"where/".$mm['id_parents'],"id_lang"=>"where/".GetIdLang(),"sort"=>"order/asc");
				$mainmenup = GetAll("kg_menu",$filterp);
				if($mainmenup->num_rows() > 0){
					$mmp = $mainmenup->row_array();
					$filterps = array("is_publish"=>"where/publish","id"=>"where/".$mmp['id_parents'],"id_lang"=>"where/".GetIdLang(),"sort"=>"order/asc");
		    		$mainmenups = GetAll("kg_menu",$filterps);
		    		if($mainmenups->num_rows() > 0){
		    			$mmps = $mainmenups->row_array();
		    			$breadcrumb .= '<li><a href="'.site_url($mmps['file']).'">'.$mmps['title'].'</a></li>';
		    		}
					$breadcrumb .= '<li><a href="'.site_url($mmp['file']).'">'.$mmp['title'].'</a></li>';
				}	
			}
			$breadcrumb .= '<li><a href="'.site_url($mm['file']).'">'.$mm['title'].'</a></li>';
		}	
		return $breadcrumb;
	}
}

/*BEGIN Andi helper*/
if ( ! function_exists('link_menu'))
	{
		function link_menu()
		{
			$CI =& get_instance();
			$data = array(
									'add'=>anchor(site_url($CI->uri->segment(1).'/submit/'),'Add',array('class'=>'btn primary')),
									'list'=>anchor(site_url($CI->uri->segment(1)),'List',array('class'=>'btn primary'))
			);
			return $data;
		}
	}
	
	if ( ! function_exists('get_init'))
	{
		function get_init($title=NULL,$h2_title=NULL,$main_view='partials/main_view')
		{
			$CI =& get_instance();
			$data['title'] = $title;
			$data['h2_title'] = $h2_title;
			$data['main_view'] = $main_view;
			//$data['username'] = $CI->login_model->get_login_user();
			$data['link'] = link_menu();
			return $data;
		}
	}
	
	if ( ! function_exists('get_init_list'))
	{
		function get_init_list($title=NULL,$h2_title=NULL,$main_view='partials/main_view')
		{
			$CI =& get_instance();
			
			$data = get_init($title,$h2_title,$main_view);
			/*$data['scripts'] = array(
				load_js('jquery.dataTables.js'),
				load_js("
						$(document).ready(function(){
							$('#managetable').dataTable({
									'bPaginate': true,
									'bLengthChange': true,
									'bFilter': true,
									'bSort': true,
									'bInfo': true,
									'bAutoWidth': false,
									'sPaginationType': 'full_numbers'
								});
						
					}); 
				", TRUE) 
			);*/
			return $data;
		}
	}
	
	if ( ! function_exists('get_init_form'))
	{
		function get_init_form($title=NULL,$h2_title=NULL,$main_view='partials/main_view',$form_action)
		{
			$CI =& get_instance();
			$data = get_init($title,$h2_title,$main_view);
			$data['form_action']		= $form_action;
			return $data;
		}
	}
	
	if ( ! function_exists('get_query_view'))
	{
		function get_query_view($model, $function, $function_count=NULL,$limit=NULL, $uri_segment=NULL)
		{
			$CI =& get_instance();
			if($uri_segment != NULL)
				$offset = $CI->uri->segment($uri_segment);
			else
				$offset = 0;
			
			$data['query'] = $q_ = $CI->$model->$function($limit,$offset);
			$data['result_array'] = $q_->result_array();
			if($function_count != '')
				$data['num_rows'] = $CI->$model->$function_count();
			else
				$data['num_rows'] = $q_->num_rows();
			return $data;
		}
	}

	if ( ! function_exists('get_query_by_ref'))
	{
		function get_query_by_ref($model, $function, $id)
		{
			$CI =& get_instance();
			/*if($uri_segment != NULL)
				$offset = $CI->uri->segment($uri_segment);
			else
				$offset = 0;*/
			
			$data['query'] = $q_ = $CI->$model->$function($id);
			$data['result_array'] = $q_->result_array();
			/*if($function_count != '')
				$data['num_rows'] = $CI->$model->$function_count();
			else
				$data['num_rows'] = $q_->num_rows();*/
			return $data;
		}
	}
	
	if ( ! function_exists('get_query_by_id'))
	{
		function get_query_by_id($model, $id)
		{
			$CI =& get_instance();
			
			$data['query'] = $q_ = $CI->$model->get_by_id($id);
			$data['result_array'] = $q_->result_array();
			$data['row_array'] = $q_->row_array();
			$data['num_rows'] = $q_->num_rows();
			return $data;
		}
	}
	
	if ( ! function_exists('pagination'))
	{
		function pagination($site_url, $num_rows, $limit, $uri_segment)
		{
			$CI =& get_instance();

			/*$config['base_url'] = base_url().'jenis_insiden/index';
            $config['total_rows'] = $jml->num_rows();
            $config['per_page'] = '20';
            $config['first_page'] = 'Awal';
            $config['last_page'] = 'Akhir';
            $config['next_page'] = '«';
            $config['prev_page'] = '»';
            
            $config['num_links'] = 10;
            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
            $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
            $config['display_pages'] = TRUE; */



			//$config['base_url'] = site_url($site_url);
			$config['base_url'] = base_url().'jenis_insiden/index';
			$config['total_rows'] = $num_rows;
			$config['per_page'] = $limit;
			//$config['uri_segment'] = $uri_segment;
			$config['num_links'] = 10;
			/*$config['full_tag_open'] = '<div id="managetable_paginate" class="dataTables_paginate">';
			$config['full_tag_close'] = '</div>';*/
			//$config['first_link'] = 'First';
			$config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
			$config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
			$config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
			$config['next_link'] = '<i class="fa fa-chevron-right"></i>';
			$config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
			//$config['last_link'] = 'Last';
			$config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
			$config['display_pages'] = TRUE; 
			$CI->pagination->initialize($config);
			return $CI->pagination->create_links();
		}
	}
	
	if ( ! function_exists('table_template'))
	{
		function table_template($heading)
		{
			$CI =& get_instance();
			$tmpl = array(  
					'table_open'     => '<table id="managetable" class="dataTables_table">',
					'heading_row_start'   => '<tr>',
					'heading_row_end'     => '</tr>',
					'heading_cell_start'  => '<th>',
					'heading_cell_end'    => '</th>',
					'row_start'           => '<tr>',
					'row_end'             => '</tr>',
					'cell_start'          => '<td>',
					'cell_end'            => '</td>',
					'row_alt_start'  => '<tr class="zebra">',
					'row_alt_end'    => '</tr>',
					'cell_alt_start'      => '<td>',
					'cell_alt_end'        => '</td>',
					'table_close'         => '</table>'
					);
				$CI->table->set_template($tmpl);
				$CI->table->set_empty("&nbsp;");
				$CI->table->set_heading($heading);
		}
	}
	
	if ( ! function_exists('table_std'))
	{
		function table_std($heading)
		{
			$CI =& get_instance();
			$tmpl = array(
					'table_open'     => '<table class="table table-striped table-fixed-layout table-hover" id="table">',
					//'table_open'     => '<table class="dataTables_table">',
					'heading_row_start'   => '<tr>',
					'heading_row_end'     => '</tr>',
					'heading_cell_start'  => '<th>',
					'heading_cell_end'    => '</th>',
					//'row_start'           => '<tr class="tr_id">',
					'row_start'           => '<tr>',
					'row_end'             => '</tr>',
					'cell_start'          => '<td>',
					'cell_end'            => '</td>',
					//'row_alt_start'  => '<tr class="tr_id zebra">',
					'row_alt_start'  => '<tr>',
					'row_alt_end'    => '</tr>',
					'cell_alt_start'      => '<td>',
					'cell_alt_end'        => '</td>',
					'table_close'         => '</table>'
					);
				$CI->table->set_template($tmpl);
				$CI->table->set_empty("&nbsp;");
				$CI->table->set_heading($heading);
		}
	}
	
	if ( ! function_exists('add_del_single'))
	{
		function add_del_single($process,$id, $model, $message='data has been deleted',$url)
		{
			$CI =& get_instance();
			$CI->$model->$process($id);
			$CI->session->set_flashdata('message', $message);
			redirect(site_url($url));	
		}
	}
	
	if ( ! function_exists('add_del_single_ajax'))
	{
		function add_del_single_ajax($process,$id, $model, $message='data has been deleted',$url)
		{
			$CI =& get_instance();
			$CI->$model->$process($id);
			echo $url;
		}
	}
	
	if ( ! function_exists('update_single'))
	{
		function update_single($id, $datas, $model, $message='data has been updated',$url)
		{
			$CI =& get_instance();
			$CI->$model->update($id,$datas);
			$CI->session->set_flashdata('message', $message);
			redirect(site_url($url));	
		}
	}
	
	if ( ! function_exists('update_single_ajax'))
	{
		function update_single_ajax($id, $datas, $model, $message='data has been updated',$url)
		{
			$CI =& get_instance();
			$CI->$model->update($id,$datas);
			echo $url;
		}
	}
	
	if ( ! function_exists('options_row'))
	{
		function options_row($model=NULL,$function=NULL,$id_field=NULL,$title_field=NULL,$default=NULL)
		{
			$CI =& get_instance();
			$query = get_query_view($model, $function, '' ,'','');
			if($default) $data['options_row'][99999] = $default;
			
			foreach($query['result_array'] as $row)
			{
				$data['options_row'][$row[$id_field]] = $row[$title_field];
			}
			return $data['options_row'];
		}
	}

	if ( ! function_exists('options_month'))
	{
		function options_month()
		{
			return array(
				'01'=>'Januari',
				'02'=>'Februari',
				'03'=>'Maret',
				'04'=>'April',
				'05'=>'Mei',
				'06'=>'Juni',
				'07'=>'Juli',
				'08'=>'Agustus',
				'09'=>'September',
				'10'=>'Oktober',
				'11'=>'November',
				'12'=>'Desember'
				);
		}
	}

	if ( ! function_exists('month_ind'))
	{
		function month_ind($month)
		{
			if($month == 01 || $month == 1){
				$bulan = 'Januari';
			}elseif($month == 02 || $month == 2){
				$bulan = 'Februari';
			}elseif($month == 03 || $month == 3){
				$bulan = 'Maret';
			}elseif($month == 04 || $month == 4){
				$bulan = 'April';
			}elseif($month == 05 || $month == 5){
				$bulan = 'Mei';
			}elseif($month == 06 || $month == 6){
				$bulan = 'Juni';
			}elseif($month == 07 || $month == 7){
				$bulan = 'Juli';
			}elseif($month == 08 || $month == 8){
				$bulan = 'Agustus';
			}elseif($month == 09 || $month == 9){
				$bulan = 'September';
			}elseif($month == 10 || $month == 10){
				$bulan = 'Oktober';
			}elseif($month == 11){
				$bulan = 'November';
			}else{
				$bulan = 'Desember';
			}

			return $bulan;
		}
	}

	if ( ! function_exists('options_year'))
	{
		function options_year()
		{
			return array(
				'2015'=>'2015',
				'2016'=>'2016',
				'2017'=>'2017',
				'2018'=>'2018',
				'2019'=>'2019',
				'2020'=>'2020',
				'2021'=>'2021',
				'2022'=>'2022',
				'2023'=>'2023',
				'2024'=>'2024',
				'2025'=>'2025'
				);
		}
	}

	if ( ! function_exists('options_row_by_ref'))
	{
		function options_row_by_ref($model=NULL,$function=NULL,$id_field=NULL,$title_field=NULL,$default=NULL,$id=NULL)
		{
			$CI =& get_instance();
			
			//$query = get_query_view($model, $function, '' ,'','');
			$query = get_query_by_ref($model,$function,$id);
			if($default) $data['options_row'][0] = $default;
			
			foreach($query['result_array'] as $row)
			{
				$data['options_row'][$row[$id_field]] = $row[$title_field];
			}
			return $data['options_row'];
		}
	}
	
	if ( ! function_exists('options_row_def'))
	{
		function options_row_def($model=NULL,$function=NULL,$id_field=NULL,$title_field=NULL,$default=NULL,$id_def=NULL)
		{
			$CI =& get_instance();
			$query = get_query_view($model, $function, '' ,'','');
			if($default) $data['options_row'][$id_def] = $default;
			
			foreach($query['result_array'] as $row)
			{
				$data['options_row'][$row[$id_field]] = $row[$title_field];
			}
			return $data['options_row'];
		}
	}
/*END Andi helper */


function getcoverbuku($id){
        $ci=& get_instance();
        $ci->load->database(); 

        $sql = "select * from buku where kode_buku='".$id."'"; 
        $query = $ci->db->query($sql);
        $row = $query->row();
        return $row->cover;
   }

function select_where($table,$column,$where){
		$ci=& get_instance();
		$ci->load->database('default',TRUE);
		$ci->db->select('*');
		$ci->db->from($table);
		$ci->db->where($column,$where);
		$data = $ci->db->get();
		return $data;
}


function select_all($table){
		$ci=& get_instance();
		$ci->load->database('default',TRUE);
		$ci->db->select('*');
		$ci->db->from($table);
		$data = $ci->db->get();
		return $data;
}

function select_where_array($table,$where){
		$ci=& get_instance();
		$ci->load->database('default',TRUE);
		$ci->db->select('*');
		$ci->db->from($table);
		$ci->db->where($where);
		$data = $ci->db->get();
		return $data;
	}
?>