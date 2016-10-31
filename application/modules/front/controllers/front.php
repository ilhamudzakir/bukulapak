<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","-1");
set_time_limit(0);
class Front extends MX_Controller {

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('authentication', NULL, 'ion_auth');
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->library('upload');
        $this->load->helper('url');
		$this->load->library('email');
        //$this->load->helper('form');

        $this->load->database();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

        $this->load->model('lapak_model','lapak');
        $this->load->model('sekolah_model','sekolah');
        $this->load->model('propinsi_model','propinsi');
        $this->load->model('kabupaten_model','kabupaten');
        $this->load->model('kecamatan_model','kecamatan');
        $this->load->model('buku_model','buku');
        $this->load->model('area_shipping_model','area_shipping');
        $this->load->model('orders_model','orders');
        $this->load->model('items_model','items');
        $this->load->model('confirmation_model','confirmation');
		$this->load->model('order_history_model','order_history');
        $this->load->model('static_page_model','static_page');

        $this->data['hide_sidebar'] = "";
	}

   // $this->load->library('form_validation');

	public function index()
	{
		$this->data['controller_name'] = 'front';
        $this->data['function'] = '';
        $sekolah=$this->sekolah->select_sekolah();
        $this->data['sekolah']=$sekolah->result_array();

        $propinsi = $this->propinsi->getAll();
        if($propinsi->num_rows() > 0){
            $this->data['propinsi'] = $propinsi->result_array();
        }else{
            $this->data['propinsi'] = array();
        }
        $this->data['background']=select_where('background','id',8)->row();
        $kabupaten = $this->kabupaten->getAll();
        if($kabupaten->num_rows() > 0){
            $this->data['kabupaten'] = $kabupaten->result_array();
        }else{
            $this->data['kabupaten'] = array();
        }
        $filterc = array("id"=>"where/7",);
        $this->data['cara_pembelian'] = GetAll('static_page',$filterc)->row();
        $filterk = array("id"=>"where/6",);
        $this->data['keunggulan'] = GetAll('static_page',$filterk)->row();
        $this->data['buku']=$this->buku->count_max();
        $lapak=$this->db->query("select * from buku order by kode_buku DESC limit 0,8");
        $this->data['lapak']=$lapak->result();
        $this->_render_page('front/home', $this->data);
	}

    public function search_sekolah()
    {
        $sekolah_id = $this->uri->segment(3);
        $propinsi_id = $this->uri->segment(4);
        $kabupaten_id = $this->uri->segment(5);
		

        $sekolah = $this->sekolah->getAllbyidpropkab($sekolah_id,$propinsi_id,$kabupaten_id);
        if($sekolah->num_rows() > 0){
            $data = $sekolah->row_array();
            $this->data['nama_sekolah'] = $data['title'];
            $this->data['sekolah_id'] = $data['id'];
        }else{
            $this->data['nama_sekolah'] = '';
            $this->data['sekolah_id'] = 0;
        }
		if($this->uri->segment(6)!=''){
        $this->data['buku'] = $this->buku->getbukubysekolahstudy($sekolah_id,$this->uri->segment(6));
		}else{
		$this->data['buku'] = $this->buku->getbukubysekolah($sekolah_id);
		}
        $this->data['lapak'] = $this->lapak->getlapakbysekolah($sekolah_id);

        $this->_render_page('front/list-book-sekolah', $this->data);
    }

    public function search_lapak()
    {
        $kodelapak = $this->uri->segment(3);
        //$expkodelapak = explode("-", $kodelapak);
        //$lapak_id = $expkodelapak[0];
        //$lapak_title = $expkodelapak[1];

        $lapak = $this->lapak->getAllbycode($kodelapak);
        if($lapak->num_rows() > 0){
            $data = $lapak->row_array();
            $this->data['nama_sekolah'] = $data['sekolah'];
            $this->data['lapak_id'] = $data['id'];
            $this->data['lapak_code'] = $data['lapak_code'];
        }else{
            $this->data['nama_sekolah'] = '';
            $this->data['lapak_id'] = 0;
            $this->data['lapak_code'] = 0;
        }
        //die($this->db->last_query());

        $this->data['buku'] = $this->buku->getbukubylapak($this->data['lapak_id']);

        $this->_render_page('front/list-book-lapak', $this->data);
    }

    public function addcart($lapak_id,$kode_buku,$sales_id,$area_id)
    {   
        $unique=$this->confirmation->unique_kode();
        $this->session->set_userdata("uniquecode",$unique);
        if($this->session->userdata('valid_area_id') == NULL) {
            $lapak_id = $lapak_id;
            $kode_buku = $kode_buku;
            $sales_id = $sales_id;
            $cty = $this->input->post('cty');
            $berat = $this->input->post('berat');
            $harga = $this->input->post('harga');
            $judul = url_title($this->input->post('judul'));
            $current_url = $this->input->post('current_url');

            $dweight = ($berat * $cty);
            $kg_weight = $dweight;

            $data = array(
                'id'            => $kode_buku,
                'qty'           => $cty,
                'price'         => $harga,
                'name'          => $judul,
                'sales_id'      => $sales_id,
                'weight'        => $kg_weight,
                'lapak_id'      => $lapak_id
            );

            $this->session->set_userdata('url_sekolah_terakhir',$current_url);
            $this->session->set_userdata('sales_id',$sales_id);
            $this->session->set_userdata('valid_sales_id',$sales_id);

            //$area_sales = GetAreaSales($this->session->userdata('sales_id'));
            $this->session->set_userdata('valid_area_id',$area_id);
            
            if($this->cart->insert($data))
            {
                echo json_encode(array("status" => TRUE,"total_item"=>$this->cart->total_items(), "current_url"=>$current_url));
            }else{
                echo json_encode(array("status" => FALSE,"total_item"=>0, "current_url"=>$current_url));
            }
        }
        elseif($this->session->userdata('valid_area_id') == $area_id)
        {
            $lapak_id = $lapak_id;
            $kode_buku = $kode_buku;
            $sales_id = $sales_id;
            $cty = $this->input->post('cty');
            $berat = ($this->input->post('berat') == 0) ? 1 : $this->input->post('berat');
            $harga = $this->input->post('harga');
            $judul = url_title($this->input->post('judul'));
            $current_url = $this->input->post('current_url');

            $dweight = ($berat * $cty);
            $kg_weight = ($dweight < 1) ? 1 : $dweight;

            $data = array(
                'id'            => $kode_buku,
                'qty'           => $cty,
                'price'         => $harga,
                'name'          => $judul,
                'sales_id'      => $sales_id,
                'weight'        => $kg_weight,
                'lapak_id'      => $lapak_id
            );

            $this->session->set_userdata('url_sekolah_terakhir',$current_url);
            $this->session->set_userdata('sales_id',$sales_id);

            //$area_sales = GetAreaSales($this->session->userdata('sales_id'));
            //$this->session->set_userdata('valid_area_id',$area_id);
            
            if($this->cart->insert($data))
            {
                echo json_encode(array("status" => TRUE,"total_item"=>$this->cart->total_items(), "current_url"=>$current_url));
            }else{
                echo json_encode(array("status" => FALSE,"total_item"=>0, "current_url"=>$current_url));
            }
        }
        else
        {
            echo json_encode(array("status" => FALSE,"total_item"=>0, "current_url"=>$current_url));
        }
    }

    /*private function addcartprocess($lapak_id,$kode_buku,$sales_id,$area_id)
    {
            $lapak_id = $lapak_id;
            $kode_buku = $kode_buku;
            $sales_id = $sales_id;
            $cty = $this->input->post('cty');
            $berat = ($this->input->post('berat') == 0) ? 1 : $this->input->post('berat');
            $harga = $this->input->post('harga');
            $judul = $this->input->post('judul');
            $current_url = $this->input->post('current_url');

            $dweight = ($berat * $cty);
            $kg_weight = ($dweight < 1) ? 1 : $dweight;

            $data = array(
                'id'            => $kode_buku,
                'qty'           => $cty,
                'price'         => $harga,
                'name'          => $judul,
                'sales_id'      => $sales_id,
                'weight'        => $kg_weight,
                'lapak_id'      => $lapak_id
            );

            $this->session->set_userdata('url_sekolah_terakhir',$current_url);
            $this->session->set_userdata('sales_id',$sales_id);
            //$this->session->set_userdata('pertama_sales_id',$sales_id);
            $area_sales = GetAreaSales($this->session->userdata('sales_id'));
            $this->session->set_userdata('valid_area_id',$area_sales['area_id']);
            
            if($this->cart->insert($data))
            {
                echo json_encode(array("status" => TRUE,"total_item"=>$this->cart->total_items(), "current_url"=>$current_url));
            }else{
                echo json_encode(array("status" => FALSE,"total_item"=>0, "current_url"=>$current_url));
            }
    }*/

    public function updatecart($rowid)
    {
        $rowid = $rowid;
        $qty = $this->input->post('qty');
        $berat = $this->input->post('berat');
        $beratm=$this->input->post('beratm');
        $propinsi_id=$this->input->post('propinsi_id');
        $kabupaten_id=$this->input->post('kabupaten_id');
        $kecamatan_id=$this->input->post('kecamatan_id');
        $paket=$this->input->post('paket');
        $kg_weight = $qty*$beratm;
        $data = array(
            'rowid'     => $rowid,
            'qty'       => $qty,
            'weight'    => $kg_weight
        );
        if($this->cart->update($data))
        {    
        $query = $this->area_shipping->getbyid($propinsi_id, $kabupaten_id, $kecamatan_id);
        if($query->num_rows() > 0)
        {
            $value = $query->row_array();
            if($paket==''){
            $ongkir = $value['reguler'];
        }elseif($paket=='reguler'){
             $ongkir = $value['reguler'];
         }elseif($paket=='ok'){
             $ongkir = $value['ok'];
        }
        }else{
            $ongkir = 0;
        }
        $free = $this->db->get_where('config_ongkir', array('id' => 1))->row();
        if($free->free=='1'){
             $this->session->set_userdata('ongkir',0);   
        }else{
            $berat=ceil($berat/1000);
            $ongkir=$ongkir*$berat;
            $this->session->set_userdata('ongkir',$ongkir);
        }
            echo json_encode(array("status" => TRUE,"berat" => $kg_weight,"total_item"=>$this->cart->total_items()));
        }else{
            echo json_encode(array("status" => FALSE,"total_item"=>0));
        }
    }

    public function getongkir($area_id, $propinsi_id, $kabupaten_id, $kecamatan_id,$paket,$berat)
    {
        $query = $this->area_shipping->getbyid($propinsi_id, $kabupaten_id, $kecamatan_id);
        if($query->num_rows() > 0)
        {
            $value = $query->row_array();
            if($paket==''){
            $ongkir = $value['reguler'];
        }elseif($paket=='reguler'){
             $ongkir = $value['reguler'];
         }elseif($paket=='ok'){
             $ongkir = $value['ok'];
        }
        }else{
            $ongkir = 0;
        }
        $free = $this->db->get_where('config_ongkir', array('id' => 1))->row();
        if($free->free=='1'){
             $this->session->set_userdata('ongkir',0);   
        }else{
            $berat=ceil($berat/1000);
            $ongkir=$ongkir*$berat;
            $this->session->set_userdata('ongkir',$ongkir);
        }
       $price_total = $this->cart->total() + $ongkir+$this->session->userdata('uniquecode');
        
        echo json_encode(array('ongkir'=>'RP. '.number_format($ongkir),'totalongkir'=>$ongkir,'price_total'=>'RP. '.number_format($price_total)));
    }

    public function cart_destroy()
    {
        $this->cart->destroy();
        $this->session->sess_destroy();
        redirect(site_url('front'));
    }

    public function carts()
    {
        $this->load->library('cart');
        $this->data['controller_name'] = 'front';
        $this->data['function'] = '';

        if(count($this->cart->contents()) > 0) 
        {
            //die('here: '.count($this->cart->contents()));
            $propinsi = $this->propinsi->getAll();
            if($propinsi->num_rows() > 0){
                $this->data['propinsi'] = $propinsi->result_array();
            }else{
                $this->data['propinsi'] = array();
            }

            $kabupaten = $this->kabupaten->getAll();
            if($kabupaten->num_rows() > 0){
                $this->data['kabupaten'] = $kabupaten->result_array();
            }else{
                $this->data['kabupaten'] = array();
            }

            $kecamatan = $this->kecamatan->getAll();
            if($kecamatan->num_rows() > 0){
                $this->data['kecamatan'] = $kecamatan->result_array();
            }else{
                $this->data['kecamatan'] = array();
            }
            $this->data['free'] = $this->db->get_where('config_ongkir', array('id' => 1))->row();
            $this->_render_page('front/cart', $this->data);
        }
        else
        {

            //return show_error('error');
            $this->_render_page('front/cart_empty', $this->data);
        }
    }

    public function getkabupaten($propinsi_id)
    {
        $filter_kabupaten = array("propinsi_id"=>"where/".$propinsi_id,"title"=>"order/asc");
        $this->data['kabupaten'] = GetAll('kabupaten',$filter_kabupaten);

        $this->_render_page('front/getkabupaten', $this->data);
    }

    public function getkecamatan($kabupaten_id)
    {
        $filter_kecamatan = array("kabupaten_id"=>"where/".$kabupaten_id,"title"=>"order/asc");
        $this->data['kecamatan'] = GetAll('kecamatan',$filter_kecamatan);

        $this->_render_page('front/getkecamatan', $this->data);
    }

    public function getsekolah($sekolah_id)
    {
        $filter = array("id"=>"where/".$sekolah_id);
        $query = GetAll('sekolah',$filter);
        if($query->num_rows() > 0){
            $data = $query->row_array();
            $propinsi_id = $data['propinsi_id'];
            $kabupaten_id = $data['kabupaten_id'];
            $status = TRUE;
        }else{
            $propinsi_id = 0;
            $kabupaten_id = 0;
            $status = FALSE;
        }

        echo json_encode(array("status" => $status, "propinsi_id" => $propinsi_id, "kabupaten_id" => $kabupaten_id));
    }

    public function getsekolahsearch($propinsi_id,$kabupaten_id)
    {
        $filter_sekolah = array("propinsi_id"=>"where/".$propinsi_id,"kabupaten_id"=>"where/".$kabupaten_id,"title"=>"order/asc");
        $this->data['sekolah'] = GetAll('sekolah',$filter_sekolah);
        //die($this->db->last_query());

        $this->_render_page('front/getsekolah', $this->data);
    }

    public function proceedcart()
    {

        $propinsi = $this->propinsi->getAll();
        if($propinsi->num_rows() > 0){
            $this->data['propinsi'] = $propinsi->result_array();
        }else{
            $this->data['propinsi'] = array();
        }

        $kabupaten = $this->kabupaten->getAll();
        if($kabupaten->num_rows() > 0){
            $this->data['kabupaten'] = $kabupaten->result_array();
        }else{
            $this->data['kabupaten'] = array();
        }

        $kecamatan = $this->kecamatan->getAll();
        if($kecamatan->num_rows() > 0){
            $this->data['kecamatan'] = $kecamatan->result_array();
        }else{
            $this->data['kecamatan'] = array();
        }

        $order_name = $this->input->post('order_name');
        $order_phone = $this->input->post('order_phone');
        $order_email = $this->input->post('order_email');
        $order_recipient_name = $this->input->post('order_recipient_name');
        $order_recipient_phone = $this->input->post('order_recipient_phone');
        $order_recipient_address = $this->input->post('order_recipient_address');
        $order_propinsi_id = $this->input->post('propinsi_id');
        $order_kabupaten_id = $this->input->post('kabupaten_id');
        $order_kecamatan_id = $this->input->post('kecamatan_id');
        $order_recipient_postcode = $this->input->post('order_recipient_postcode');
        $area_id = $this->input->post('area_id');
        $order_shipping_price = $this->session->userdata('ongkir');
        $order_subtotal = $this->cart->total();
        //$order_total = $this->input->post('totalsemua');

        $order_total = $this->cart->total() + $this->session->userdata('ongkir')+$this->confirmation->unique_kode();
        $order_date = date('Y-m-d H:i:s',now());

        //validate form input
        $this->form_validation->set_rules('order_name', 'Nama', 'required|xss_clean');
        $this->form_validation->set_rules('order_phone', 'Telepon', 'required|xss_clean');
        $this->form_validation->set_rules('order_email', 'Email', 'required|xss_clean');        
        $this->form_validation->set_rules('order_recipient_name', 'Nama penerima', 'required|xss_clean');
        $this->form_validation->set_rules('order_recipient_phone', 'Telepon penerima', 'required|xss_clean');
        $this->form_validation->set_rules('order_recipient_address', 'Alamat penerima', 'required|xss_clean');
       // $this->form_validation->set_rules('order_propinsi_id', 'Propinsi penerima', 'required|xss_clean');
        //$this->form_validation->set_rules('order_kabupaten_id', 'Kabupaten penerima', 'required|xss_clean');
        $this->form_validation->set_rules('order_recipient_postcode', 'Kodepos penerima', 'required|xss_clean');
        $this->form_validation->set_rules('area_id', 'Area', 'required|xss_clean');
       
        $this->session->set_flashdata('order_propinsi_id',$order_propinsi_id);
        $this->session->set_flashdata('order_kabupaten_id',$order_kabupaten_id);
        $this->session->set_flashdata('order_kecamatan_id',$order_kecamatan_id);
        $filter_propinsi = array("propinsi_id"=>"where/".$order_propinsi_id,);
        $filter_kabupaten = array("kabupaten_id"=>"where/".$order_kabupaten_id,);
        $filter_kecamatan = array("kecamatan_id"=>"where/".$order_kecamatan_id,);
        $propop = GetAll('propinsi',$filter_propinsi)->row();
        $prokab = GetAll('kabupaten',$filter_kabupaten)->row();
        $prokec = GetAll('kecamatan',$filter_kecamatan)->row();
        
       
        $this->session->set_flashdata('order_recipient_postcode',$order_recipient_postcode);
        if ($this->form_validation->run() == TRUE)
        {

            $data = array(
                'order_code'    => $order_name,
                'order_name'    => $order_name,
                'order_phone'    => $order_phone,
                'order_email'    => $order_email,
                'order_recipient_name'    => $order_recipient_name,
                'order_recipient_phone'    => $order_recipient_phone,
                'order_recipient_address'    => $order_recipient_address,
                'order_propinsi_id'    => $order_propinsi_id,
                'order_kabupaten_id'    => $order_kabupaten_id,
                'order_kecamatan_id'    => $order_kecamatan_id,
                'order_recipient_postcode'    => $order_recipient_postcode,
                'order_shipping_price'    => $order_shipping_price,
                'order_subtotal'    => $order_subtotal,
                'order_total'    => $order_total,
                'order_date'    => $order_date,
                'area_id' => $area_id
            );

            $this->orders->add($data);
            $order_id = $this->db->insert_id();

           /* $f_area = array("id"=>"where/".$area_id);
            $q_area = getAll('area',$f_area);
            if($q_area->num_rows() > 0)
            {
                $v_area = $q_area->row_array();
                $area_title = strtolower(url_title($v_area['title'],'_'));
            }else{
                $area_title = '';
            }*/
            
            // $srand = srand ((double) microtime( )*1000000);
            // $random_number = rand(100000,999999);
            // $random_number1 = rand(100,999);
            // $random_number2 = rand(200,999);
            // //$confirmation_code = $order_id."-".$random_number."-".$area_title;
            // $confirmation_code = $random_number1.$order_id.$random_number2."-".$area_id;
            
            // $this->orders->update($order_id,array('order_code'=>$confirmation_code));

            $data_history = array('order_id'=>$order_id,'order_status_id'=>1,'create_date'=>date('Y-m-d H:i:s',now()));
            $this->order_history->add($data_history);

            foreach($this->cart->contents() as $items)
            {
                $items_all = array(
                    'order_id'  => $order_id,   
                    'product_id' => $items['id'],
                    'lapak_id' => $items['lapak_id'],
                    'sales_id' => $items['sales_id'],
                    'item_name' => $items['name'],
                    'item_qty'  => $items['qty'],
                    'item_price'    => $items['price'],
                    'item_subtotal' => $items['subtotal'],
                );
                
                $this->items->add($items_all);

            }
            $filterprod= array("order_id"=>"where/".$order_id);
            $product = GetAll('items',$filterprod)->row();
            $filterlap= array("id"=>"where/".$product->lapak_id);
            $lapak = GetAll('lapak',$filterlap)->row();
            $confirmation_code=$lapak->lapak_code."-".$order_id."".$product->sales_id."".date('Y');

            $this->orders->update($order_id,array('order_code'=>$confirmation_code));

            $order_array = array(
                'ongkir'    => ''
            );
			
			$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'mail.bukusekolahku.com',
  'smtp_port' => 26,
  'smtp_user' => 'admin@bukusekolahku.com', // change it to yours
  'smtp_pass' => '1234qwer', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);
		$orders = $this->orders->get_by_code($confirmation_code);
        $value = $orders->row_array();
            $order_total = $value['order_total'];
        
        $order_code = $confirmation_code;
		$emails=select_where('email_order','id','1')->row();
        $email1=str_replace('*order_code', $order_code, $emails);
        $message=str_replace('*order_total', number_format($order_total), $email1);
        //email

		
  //       $this->load->library('email', $config);
  //     $this->email->set_newline("\r\n");
	 //  $this->email->set_mailtype("html");
  //     $this->email->from('admin@bukusekolahku.com','admin bukusekolahku.com'); // change it to yours
  //     $this->email->to($data['order_email']);// change it to yours
  //     $this->email->subject('Order Buku');
  //     $this->email->message($message);
  //     if($this->email->send())
  //    {
      
  //    }
  //    else
  //   {
  //    show_error($this->email->print_debugger());
  //   }
			
            $this->session->unset_userdata($order_array);
            $this->cart->destroy();
            $this->session->sess_destroy();

            redirect('front/thankyou/'.$confirmation_code);
        }else{
            $this->session->set_flashdata('order_propinsi_nama',$propop->title);
            $this->session->set_flashdata('order_kabupaten_nama',$prokab->title);
            $this->session->set_flashdata('order_kecamatan_nama',$prokec->title);
            //die('here');
            $this->data['free'] = $this->db->get_where('config_ongkir', array('id' => 1))->row();
            $this->_render_page('front/cart', $this->data);
        }
    }

    public function thankyou($confirmation_code)
    {
        $this->data['controller_name'] = 'front';
        $this->data['function'] = '';

        $orders = $this->orders->get_by_code($confirmation_code);
        if($orders->num_rows > 0)
        {
            $value = $orders->row_array();
            $this->data['order_total'] = $value['order_total'];
        }else{
            $this->data['order_total'] = 0;
        }
        $this->data['order_code'] = $confirmation_code;
        

        $this->_render_page('front/finish', $this->data);
    }

    public function confirmation()
    {
        //$this->load->library('form_validation');
        $this->data['controller_name'] = 'front';
        $this->data['function'] = '';

        $this->_render_page('front/confirmation', $this->data);
    }

    public function proceedconfirmation()
    {
        //$this->load->library('form_validation');
        $confirmation_code = $this->input->post('confirmation_code');
        $confirmation_method = $this->input->post('confirmation_method');
        $confirmation_name = $this->input->post('confirmation_name');
        $confirmation_bank = $this->input->post('confirmation_bank');
        $upload_file= $this->input->post('upload_file');

        $orders = $this->orders->get_by_code($confirmation_code);
        if($orders->num_rows() > 0){
            $value = $orders->row_array();
            $order_id = $value['order_id'];
        }else{
            $order_id = 0;
        }
        

        //validate form input
        $this->form_validation->set_rules('confirmation_code', 'Code', 'required|xss_clean');
        $this->form_validation->set_rules('confirmation_method', 'Metode', 'required|xss_clean');
        $this->form_validation->set_rules('confirmation_name', 'nama', 'required|xss_clean');        
        $this->form_validation->set_rules('confirmation_bank', 'Bank', 'required|xss_clean');

        if ($this->form_validation->run() == TRUE)
        {
            $attachment_file=$_FILES["upload_file"];
            if($attachment_file) 
            {
                $output_dir = "uploads/transaksi/";
                $fileName = strtolower($_FILES["upload_file"]["name"]);
                move_uploaded_file($_FILES["upload_file"]["tmp_name"],$output_dir.$fileName);
                //echo "File uploaded successfully";
            }else{
                $fileName = "";  
            }

            $data = array(
                'confirmation_code'    => $confirmation_code,
                'confirmation_method'    => $confirmation_method,
                'confirmation_name'    => $confirmation_name,
                'confirmation_bank'    => $confirmation_bank,
                'upload_file'    => $fileName,
                'create_date'    => date('Y-m-d H:i:s',now())
            );

            $this->confirmation->add($data);

            $update_status = array('order_status_id'=>2);
            $this->orders->update_by_code($confirmation_code,$update_status);

            $this->order_history->add(array('order_id'=>$order_id,'order_status_id'=>2,'create_date'=>date('Y-m-d H:i:s',now())));


            //echo "success";
            echo json_encode(array('validation_errors'=>'<div class="alert alert-success">Success</div>'));
            
        }else{
            echo json_encode(array('validation_errors'=>validation_errors('<div class="alert alert-error">', '</div>')));
        }

        
    }

    public function status()
    {
        //$this->load->library('form_validation');
        $this->data['controller_name'] = 'front';
        $this->data['function'] = '';

        $this->_render_page('front/status-transaksi', $this->data);
    }

    public function cektransaksi($id=null)
{   
        $confirmation_code = $this->input->post('confirmation_code');
        $items = "";
        $this->form_validation->set_rules('confirmation_code', 'Code', 'required|xss_clean');
        if ($this->form_validation->run() == TRUE)
        {
            $query = $this->orders->cekstatusorder($confirmation_code);
            if($query->num_rows() > 0)
            {
                $value = $query->row_array();
                $order_status_id = $value['order_status_id'];
                $order_id = $value['order_id'];
                $order_shipping_price = $value['order_shipping_price'];
                $order_total = $value['order_total'];

                if($order_status_id == 1) {
                    $order_ceklist = '&#10004';
                    $Konfirmasi_ceklist = '';
                    $pembayaran_ceklist = '';
                    $proses_ceklist = '';
                    $kirim_ceklist = '';
                    $terima_ceklist = '';
                }elseif($order_status_id <= 2){
                    $order_ceklist = '&#10004';
                    $Konfirmasi_ceklist = '&#10004';
                    $pembayaran_ceklist = '';
                    $proses_ceklist = '';
                    $kirim_ceklist = '';
                    $terima_ceklist = '';
                }elseif($order_status_id <= 3){
                    $order_ceklist = '&#10004';
                    $Konfirmasi_ceklist = '&#10004';
                    $pembayaran_ceklist = '&#10004';
                    $proses_ceklist = '';
                    $kirim_ceklist = '';
                    $terima_ceklist = '';
                }elseif($order_status_id <= 4){
                    $order_ceklist = '&#10004';
                    $Konfirmasi_ceklist = '&#10004';
                    $pembayaran_ceklist = '&#10004';
                    $proses_ceklist = '&#10004';
                    $kirim_ceklist = '';
                    $terima_ceklist = '';
                }elseif($order_status_id <= 5){
                    $order_ceklist = '&#10004';
                    $Konfirmasi_ceklist = '&#10004';
                    $pembayaran_ceklist = '&#10004';
                    $proses_ceklist = '&#10004';
                    $kirim_ceklist = '&#10004';
                    $terima_ceklist = '';
                }elseif($order_status_id <= 6){
                    $order_ceklist = '&#10004';
                    $Konfirmasi_ceklist = '&#10004';
                    $pembayaran_ceklist = '&#10004';
                    $proses_ceklist = '&#10004';
                    $kirim_ceklist = '&#10004';
                    $terima_ceklist = '&#10004';
                }else{
                    $order_ceklist = '';
                    $Konfirmasi_ceklist = '';
                    $pembayaran_ceklist = '';
                    $proses_ceklist = '';
                    $kirim_ceklist = '';
                    $terima_ceklist = '';
                }
                
                $query_items = $this->items->get_items_by_order_id($order_id);
                if($query_items->num_rows() > 0)
                {

                    $items .= '<div class="center text-center"><h4>Detail dan Status Transaksi Nomor '.$confirmation_code.'</h4></div>';
                    $items .= '<div class="col-md-7 center martop bar"></div>';
                    $items .= '<div class="col-md-7 center" style="padding:0px; top:-5px;">';
                        $items .= '<div class="kotak-bullet">';
                           $items .= '<div class="bullet bullet-left">'.$order_ceklist.'</div>';
                           $items .= 'Order';
                         $items .= '</div>';
                         $items .= '<div class="kotak-bullet">';
                           $items .= '<div class="bullet bullet-left">'.$Konfirmasi_ceklist.'</div>';
                           $items .= 'Konfirmasi Pembayaran';
                         $items .= '</div>';
                         $items .= '<div class="kotak-bullet">';
                           $items .= '<div class="bullet bullet-left">'.$pembayaran_ceklist.'</div>';
                           $items .= 'Pembayaran Diterima';
                         $items .= '</div>';
                         $items .= '<div class="kotak-bullet">';
                           $items .= '<div class="bullet bullet-left">'.$proses_ceklist.'</div>';
                           $items .= 'Pesan Diproses';
                         $items .= '</div>';
                         $items .= '<div class="kotak-bullet">';
                           $items .= '<div class="bullet bullet-left">'.$kirim_ceklist.'</div>';
                           $items .= 'Barang Dirikirim';
                         $items .= '</div>';
                         $items .= '<div class="kotak-bullet kotak-w-n">';
                           $items .= '<div class="bullet bullet-left" id="terima">'.$terima_ceklist.'</div>';
                           $items .= 'Barang Diterima';
                         $items .= '</div>';    
                       $items .= '</div>';

                    
                    $items .= '<div class="col-md-8 center">';
                    if($order_status_id == 5) {
                        $filter_ = array("order_id"=>"where/".$order_id, "order_status_id"=>"where/5");
                        $query_ = GetAll('order_history',$filter_);
                        if($query_->num_rows() > 0)
                        {
                            $v_ = $query_->row_array();
                            $op = $v_['operator'];
                            $cat = $v_['catatan'];
                        }else{
                            $op = "";
                            $cat = "";
                        }
                        $items .= '<div class="col-md-12 martop2">';
                            $items .= '<span id="textbarang">Barang pesanan anda sudah kami kirimkan menggunakan operator</span> : <strong>'.$op.'</strong> dengan catatan ';
                            $items .= '<strong>'.$cat.'</strong>';
                        $items .= '</div>';
                       
                        $items .='<div class="col-md-6 martop2 center" id="textbarang2" ><input onClick="submit_diterima(this)" order-id="'.$order_id.'" type="submit" id="barangok" class="form btn2 martop2" value="Barang Sudah Diterima" name="submit"></div>';
                       
                       
                    }

                     if($order_status_id == 6) {
                        $filter_ = array("order_id"=>"where/".$order_id, "order_status_id"=>"where/5");
                        $query_ = GetAll('order_history',$filter_);
                        if($query_->num_rows() > 0)
                        {
                            $v_ = $query_->row_array();
                            $op = $v_['operator'];
                            $cat = $v_['catatan'];
                        }else{
                            $op = "";
                            $cat = "";
                        }
                        $items .= '<div class="col-md-12 martop2 text-center">';
                            $items .= '<span id="textbarang">Barang pesanan anda sudah diterima menggunakan</span> : <strong>'.$op.'</strong> dengan catatan ';
                            $items .= '<strong>'.$cat.'</strong><br/>';
                            $items .='<div class="col-md-6 martop2 center" id="textbarang2" >Terima kasih sudah berbelanja di website kami.</div>';
                        $items .= '</div>';
                       
                       
                       
                    }
                    
                    foreach ($query_items->result_array() as $key => $value) {
						$buku=$this->db->query("select * from buku where kode_buku LIKE '".$value['product_id']."'")->row();
                        $martop2 = ($key == 0) ? 'martop2' : '';
                        $items .= '<div class="col-md-12 '.$martop2.'" style="border-top:1px solid grey; padding: 20px 0px;">';
                          $items .= '<div class="col-md-3 text-center">';
                            $items .= '<img src="uploads/cover/'.$buku->cover.'" width="70px">';
                          $items .= '</div>';
                          $items .= '<div class="col-md-6">';
                            $items .= '<h5><b>'.$value['item_name'].'</b></h5>';
                            $items .= '<h5><b>'.$value['item_qty'].' Pcs</b></h5>';
                          $items .= '</div>';
                          $items .= '<div class="col-md-3">';
                            $items .= '<h5><b>IDR. '.number_format($value['item_subtotal']).'</b></h5>';
                          $items .= '</div>';
                        $items .= '</div>';

                    }
                    $items .= '<div class="col-md-12" style="border-top:1px solid grey; border-bottom:1px solid grey; padding:20px 0px">';
                      $items .= '<div class="col-md-9 text-center"><b>Ongkos Kirim</b></div>';
                      $items .= '<div class="col-md-3"><b>IDR. '.number_format($order_shipping_price).'</b></div>';
                    $items .= '</div>';
                    $items .= '<div class="col-md-12">';
                      $items .= '<div class="col-md-9"></div>';
                      $items .= '<div class="col-md-3"><h5><b>IDR. '.number_format($order_total).'</b></h5></div>';
                    $items .= '</div>';
                    $items .= '</div>';

                }
                echo json_encode(array('status'=>1,'validation_errors'=>'','html_result'=>$items));
            }else
            {
                echo json_encode(array('status'=>0,'validation_errors'=>'<div class="alert alert-error">Kode transaksi salah</div>','html_result'=>$items));
            }
        }else
        {
            echo json_encode(array('status'=>0,'validation_errors'=>'<div class="alert alert-error">Kode Transaksi wajib diisi</div>','html_result'=>$items));
        }
    }

	function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function barang_diterima($id){
        $order=$this->lapak->getrow('orders','order_id',$id)->row();
        $data= array(
            "order_status_id"=>6,
        );
        if($id==''){
         redirect('front/status');   
        }
        $query=$this->db->update('orders', $data, "order_id =".$id."");
        if($query){
           echo json_encode(array('status'=>1,'validation_errors'=>'','html_result'=>$items));
        }else{
           echo json_encode(array('status'=>1,'validation_errors'=>'query errors','html_result'=>$items));
        }
    }

    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('front_template','front_template');
            $this->front_template->set_layout('front');

            if(in_array($view, array('front/home')))
            {
                $this->front_template->add_js('home.js');
            }

            if(in_array($view, array('front/list-book-sekolah','front/list-book-lapak')))
            {
                $this->front_template->add_js('list-book-sekolah.js');
            }

            if(in_array($view, array('front/cart')))
            {
                $this->front_template->add_js('cart.js');
            }

            if(in_array($view, array('front/confirmation')))
            {
                $this->front_template->add_js('confirmation.js');
            }

            if(in_array($view, array('front/status-transaksi')))
            {
                $this->front_template->add_js('status-transaksi.js');
            }

            /*if(in_array($view, array('auth/users_view','auth/admin_area_view')))
            {
                $this->template->set_layout('default');

                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');

                $this->template->add_js('users.js');
            }

            if (in_array($view, array('auth/login')))
            {
                $this->template->set_layout('login');
            } */

            if ( ! empty($data['title']))
            {
                $this->front_template->set_title($data['title']);
            }

            $this->front_template->load_view($view, $data);
        }
        else
        {
            return $this->load->view($view, $data, TRUE);
        }
    }


    function get_kab_prop($id){
       $sekolah=$this->lapak->getrow('sekolah','id',$id)->row();
       $kabupaten=$this->lapak->getrow('kabupaten','kabupaten_id',$sekolah->kabupaten_id)->row();
       $propinsi=$this->lapak->getrow('propinsi','propinsi_id',$sekolah->propinsi_id)->row();
       $kab='<select id="kabupaten_id" class="form arrow-sel" name="kabupaten_id" style="width: 100%" onChange="getsekolah()">
    <option selected value="'.$kabupaten->kabupaten_id.'">'.$kabupaten->title.'</option></select><div id="kabupaten_id_help"></div>';

       echo json_encode(array('propinsi_id' => $propinsi->propinsi_id, 'propinsi_name' => $propinsi->title, 'kabupaten_id' => $kab));

       
    }

    function terms(){
        $this->data['page']=$this->static_page->select_id('1')->row();
        $this->_render_page('front/static', $this->data);
    }

     function faq(){
        $this->data['page']=$this->static_page->select_id('2')->row();
        $this->_render_page('front/static', $this->data);
    }

    function cara_pembelian(){
        $this->data['page']=$this->static_page->select_id('3')->row();
        $this->_render_page('front/static', $this->data);
    }

    function cara_pembayaran(){
        $this->data['page']=$this->static_page->select_id('5')->row();
        $this->_render_page('front/static', $this->data);
    }

    function cara_konfirmasi_pembayaran(){
        $this->data['page']=$this->static_page->select_id('4')->row();
        $this->_render_page('front/static', $this->data);
    }
}
