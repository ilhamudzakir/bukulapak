<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MX_Controller {

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('authentication', NULL, 'ion_auth');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->helper('mz');

        $this->load->database();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

        $this->load->model('lapak_model','lapak');
        $this->load->model('orders_model','orders');
        $this->load->model('order_history_model','order_history');
        $this->load->model('order_status_model','order_status');
        $this->load->model('items_model','items');
		$this->load->model('config_model','config__');

        $this->data['hide_sidebar'] = "";
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif($this->ion_auth->is_admin())
        {
            $this->data['controller_name'] = 'order';

            $this->_render_page('order/index', $this->data);
        }
        elseif ($this->ion_auth->is_admin_area())
        {
            //die('here');
            $this->data['controller_name'] = 'order';

            $this->_render_page('order/index_admin_area', $this->data);
        }
        else
        {
        	return show_error('You must be an administrator or sales to view this page.');
        }
	}

    public function status($order_status_id)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ($this->ion_auth->is_admin_area() || $this->ion_auth->is_admin())
        {
            $this->session->set_userdata('order_status_id',$order_status_id);

            redirect('order/index', 'refresh');
        }
        else
        {
            return show_error('You must be an administrator or sales to view this page.');
        }
    }

    public function detail($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ($this->ion_auth->is_admin_area() || $this->ion_auth->is_admin())
        {
            $order_by_id = $this->orders->get_by_id($id);
            if($order_by_id->num_rows() > 0)
            {
                $q_lapak_pertama = $this->items->get_lapak_pertama($id);
                if($q_lapak_pertama->num_rows() > 0)
                {
                    $value = $q_lapak_pertama->row_array();
                    $this->data['admin_area_name'] = $value['admin_area_name'];
                    $this->data['admin_area_email'] = $value['admin_area_email'];
                    $this->data['admin_area_id'] = $value['admin_area_id'];
                }else{
                    $this->data['admin_area_name'] = '';
                    $this->data['admin_area_email'] = '';
                    $this->data['admin_area_id'] = 0;
                }

                $this->data['order'] = $order = $order_by_id->row_array();
                $next_order_status_id = $order['order_status_id'] + 1;
                $q_next_order_status = $this->order_status->get_by_id($next_order_status_id);
                if($q_next_order_status->num_rows() > 0)
                {
                    $value = $q_next_order_status->row_array();
                    $this->data['next_order_status_title'] = $value['title'];
                    $this->data['next_order_status_id'] = $next_order_status_id;
                }else{
                    $this->data['next_order_status_title'] = "";
                    $this->data['next_order_status_id'] = 0;
                }

            }else{
                $message_success =  "<div class='alert alert-danger text-center'><button data-dismiss='alert' class='close'></button><h4>PERINGATAN</h4>".
                                    "<p>Maaf data yang anda minta tidak tersedia disistem kami".
                                    "<br/>Silakan coba kembali<br/></div>";
                $this->session->set_flashdata('message', $message_success);

               redirect(site_url('order'));
            }

            $item_group=$this->orders->get_items_by_id_group($id)->result();
            $items_order="";
            foreach ($item_group as $item_group) {
                $items_order.="<ul class='no-list-type border-all-side row'>";
                $items_by_order = $this->orders->get_items_by_id($id,$item_group->lapak_id)->result();
                $lapak_sum = $this->orders->lapak_sum($id,$item_group->lapak_id)->row();
                 $items_order.="
                    <li class='row col-md-12'><b>Kode Lapak</b> : ".$item_group->lapak_code."</li>
                    <li class='row col-md-12'><b>Nama Sales Lapak</b> : ".$item_group->first_name." ".$item_group->last_name."</li>";

                foreach ($items_by_order as $key) {
                $items_order.="
                    <li class='col-md-12 border-top-bottom'>
                         <div class='row'>
                            <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'>

                              <label><b>Nama Buku</b> : ".$key->judul_buku."</label>
                              <label><b>Jumlah Buku</b> :".$key->item_qty." buku</label>
                               <label><b>Kode Buku</b> : ".$key->kode_buku."</label>

                            </div>
                            <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left'>
                              <label><b>IDR.".number_format($key->item_subtotal)."</b> </label>
                            </div>
                            </div>
                        </li>";
                    }
                      $items_order.="<li style='margin-top:10px' class='row col-md-12'><b>Total Penjualan Lapak</b> : IDR.".number_format($lapak_sum->lapak_sum)."</li>";
                    $items_order.="</ul>";
            }
            $this->data['items_order'] = $items_order;
           
            $this->data['order_history'] = $this->order_history->get_by_order_id($id);

            $this->data['title'] = "Pesanan";

            $this->data['controller_name'] = 'order';
            
            $this->data['cek_rekening'] = $this->config__->getbytitle('cek_rekening');

            $this->data['img_confirmation'] = GetImgConfirmation($id);


            $this->_render_page('order/detail', $this->data);

            
        }
        else
        {
            return show_error('Hanya user administrator atau admin area yang dapat mengakses halaman ini.');
        }
    }
    public function get_image_confirm($id,$con){
        $a=$this->db->query("select confirmations.upload_file, confirmations.confirmation_method, confirmations.confirmation_name, confirmations.confirmation_bank, confirmations.notes from order_history INNER JOIN orders ON orders.order_id=order_history.order_id INNER JOIN confirmations on confirmations.confirmation_code=orders.order_code where order_history.order_id='".$id."' and order_history.order_status_id='2' limit ".$con.",1 ")->row();
         echo json_encode($a);
       
    }
    public function ajax_add()
    {
        $this->_validate();
        if($this->input->post('next_order_status_id')==5){
            $catatan=$this->input->post('catatan')." ".$this->input->post('resi');
        }else{
            $catatan=$this->input->post('catatan');
        }
        $data = array(
                'order_id' => $this->input->post('order_id'),
                'order_status_id' => $this->input->post('next_order_status_id'),
                'catatan' => $catatan,
                'operator' => $this->input->post('operator'),
                'create_date' => date('Y-m-d H:i:s',now()),
                'create_user_id' => $this->session->userdata('user_id'),
            );
        if($this->input->post('next_order_status_id')==5 and $this->input->post('resi')==''){
            
        }else{
        $insert = $this->order_history->add($data);
        $update_status = array('order_status_id'=>$this->input->post('next_order_status_id'));
        $this->orders->update($this->input->post('order_id'),$update_status);
        }
        

        /*kirim email notif*/
        $config1['wordwrap'] = TRUE;
        $config1['mailtype'] = 'html';
        $this->email->initialize($config1);
        
        if(($this->input->post('next_order_status_id') == 3) && $this->ion_auth->is_admin()){
            $this->email->from(getemailbyid($this->session->userdata('user_id')));
            $this->email->to($this->input->post('admin_area_email'));
            $this->email->subject('bukusekolahku.com : Perubahan status order dengan kode '.$this->input->post('order_code').' menjadi pembayaran diterima');
            $this->email->message('Hello '.$this->input->post('admin_area_name').',<br/><br/>
                Berikut adalah perubahan status order dengan kode '.$this->input->post('order_code').' menjadi pembayaran diterima<br/><br/>
                Silakan dilanjutkan proses ordernya oleh user admin area.<br/><br/>
                Terima kasih<br/>
                '.GetUserNameLogin()
                );    
        }
        elseif(($this->input->post('next_order_status_id') == 4) && $this->ion_auth->is_admin_area()){
            $this->email->from($this->input->post('admin_area_email'));
            $this->email->to($this->input->post('order_email'));
            $this->email->subject('bukusekolahku.com : Perubahan status order dengan kode '.$this->input->post('order_code').' menjadi pesanan diproses');
            $this->email->message('Hello '.$this->input->post('order_name').',<br/><br/>
                Berikut adalah perubahan status order dengan kode '.$this->input->post('order_code').' menjadi pesanan diproses<br/><br/>
                Terima kasih<br/>
                Admin area bukusekolahku.com'
                );    
        }
        elseif(($this->input->post('next_order_status_id') == 5) && $this->ion_auth->is_admin_area()){
            $this->email->from($this->input->post('admin_area_email'));
            $this->email->to($this->input->post('order_email'));
            $this->email->subject('bukusekolahku.com : Perubahan status order dengan kode '.$this->input->post('order_code').' menjadi barang dikirim');
            $this->email->message('Hello '.$this->input->post('order_name').',<br/><br/>
                Berikut adalah perubahan status order dengan kode '.$this->input->post('order_code').' menjadi BARANG DIKIRIM<br/><br/>
                berikut adalah informasinya : <strong>'.$catatan.'</strong> <br/><br/>
                Terima kasih<br/>
                Admin area bukusekolahku.com'
                );    
        }

        
        
        $get_history = $this->order_history->get_by_order_id($this->input->post('order_id'));;
        $html_ = "";
        //$html_agen .= '<option value="0">Pilih agen</option>';
        if($get_history->num_rows() > 0) { 
            $i = 1;
            foreach ($get_history->result_array() as $key => $value) { 
              $html_ .= '<li class="row">';
                $html_ .= '<div class="col-md-4">'.$value['order_status'].'</div>';
                $html_ .= '<div class="col-md-4">'.date('d M Y H:i',strtotime($value['create_date'])).'</div>';
                $html_ .= '<div class="col-md-4">';
                    if($i == $get_history->num_rows()) { 
                         $html_ .= '<label class="label label-inverse" onClick="ubahstatus()">Ubah status</label>';
                    }
                    $i++;
                $html_ .= '</div>';
                $html_ .= '</li>';
            }
        }    

        if($this->config->item('sending_email', 'ion_auth') == TRUE)
        {
            $this->email->send();    
        }
        if($this->input->post('next_order_status_id')==5 and $this->input->post('resi')==''){
            echo json_encode(array("status" => FALSE));
        }else{
        echo json_encode(array("status" => TRUE, "html_"=>$html_));
        }
    }

    public function ajax_admin_list()
    {   
        //$area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        $order_status_id = $this->session->userdata('order_status_id');
        $list = $this->orders->get_admindatatables($order_status_id);

            
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $order) {
            $no++;
            $row = array();

            /*$rec = '<div class="row">'.
                        '<div class="col-md-12"><a class="" href="'.site_url('order/detail/'.$order->order_id).'" title="Detail"><span class="head-title"><strong>'.$order->order_code.' ('.$order->area.')</strong></span></a></div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-6">'.
                            '<ul>'.
                                '<li><label>Nama pemesan : '.$order->order_name.'</label></li>'.
                                '<li><label>Email pemesan : '.$order->order_email.'</label></li>'.
                                '<li><label>Tlp pemesan : '.$order->order_phone.'</label></li>'.
                            '</ul>'.
                        '</div>'.
                        '<div class="col-md-6">'.
                            '<ul>'.
                                '<li><label>Total : IDR. '.number_format($order->order_total).'</label></li>'.
                                '<li><label>Status : <a class="" href="'.site_url('order/detail/'.$order->order_id).'" title="Detail"><span class="label label-inverse">'.$order->order_status.'</span></a></label></li>'.
                                '<li><label>Tanggal pesan : '.date('d M Y H:i',strtotime($order->order_date)).'</label></li>'.
                            '</ul>'.
                        '</div>'.
                    '</div>';
            $row[] = $rec;*/

            /*$rec = '<div class="row">'.
                        '<div class="col-md-12"><a class="" href="'.site_url('order/detail/'.$order->order_id).'" title="detail"><span class="head-title"><strong>'.$order->order_code.'</strong></span></a></div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-6">'.
                            '<ul>'.
                                '<li><label>Nama pemesan : '.$order->order_name.'</label></li>'.
                                '<li><label>Email pemesan : '.$order->order_email.'</label></li>'.
                                '<li><label>Tlp pemesan : '.$order->order_phone.'</label></li>'.
                            '</ul>'.
                        '</div>'.
                        '<div class="col-md-6">'.
                            '<ul>'.
                                '<li><label>Total : IDR. '.number_format($order->order_total).'</label></li>'.
                                '<li><label>Status : <a class="" href="'.site_url('order/detail/'.$order->order_id).'" title="detail"><span class="label label-inverse">'.$order->order_status.'</span></label></a></li>'.
                                '<li><label>Tanggal pesan : '.date('d M Y H:i',strtotime($order->order_date)).'</label></li>'.
                            '</ul>'.
                        '</div>'.
                    '</div>';
            $row[] = $rec;*/

            $row[] = $order->order_code;
            $row[] = '<i class="fa fa-file-image-o"></i>';
            $row[] = $order->order_name;
            $row[] = $order->order_email;
            $row[] = $order->order_phone;
            $row[] = number_format($order->order_total);
            $row[] = $order->order_status;
            $row[] = date('d M Y H:i',strtotime($order->order_date));
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('order/detail/'.$order->order_id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
    
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->orders->admincount_all($order_status_id),
                        "recordsFiltered" => $this->orders->admincount_filtered($order_status_id),
                        "data" => $data,
                        "order_status_id"=>$order_status_id,
                );
        echo json_encode($output);
    }

    public function ajax_admin_area_list()
    {   
        $area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        $order_status_id = $this->session->userdata('order_status_id');
        $list = $this->orders->get_datatables($area_id,$order_status_id);

            
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $order) {
            $no++;
            $row = array();

            /*$rec = '<div class="row">'.
                        '<div class="col-md-12"><a class="" href="'.site_url('order/detail/'.$order->order_id).'" title="detail"><span class="head-title"><strong>'.$order->order_code.'</strong></span></a></div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-6">'.
                            '<ul>'.
                                '<li><label>Nama pemesan : '.$order->order_name.'</label></li>'.
                                '<li><label>Email pemesan : '.$order->order_email.'</label></li>'.
                                '<li><label>Tlp pemesan : '.$order->order_phone.'</label></li>'.
                            '</ul>'.
                        '</div>'.
                        '<div class="col-md-6">'.
                            '<ul>'.
                                '<li><label>Total : IDR. '.number_format($order->order_total).'</label></li>'.
                                '<li><label>Status : <a class="" href="'.site_url('order/detail/'.$order->order_id).'" title="detail"><span class="label label-inverse">'.$order->order_status.'</span></label></a></li>'.
                                '<li><label>Tanggal pesan : '.date('d M Y H:i',strtotime($order->order_date)).'</label></li>'.
                            '</ul>'.
                        '</div>'.
                    '</div>';
            $row[] = $rec;*/

            $row[] = $order->order_code;
            $row[] = '<i class="fa fa-file-image-o"></i>';
            $row[] = $order->order_name;
            $row[] = $order->order_email;
            $row[] = $order->order_phone;
            $row[] = number_format($order->order_total);
            $row[] = $order->order_status;
            $row[] = date('d M Y H:i',strtotime($order->order_date));
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('order/detail/'.$order->order_id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
        
            //$data[] = $row;
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->orders->count_all($area_id,$order_status_id),
                        "recordsFiltered" => $this->orders->count_filtered($area_id,$order_status_id),
                        "data" => $data,
                        "order_status_id"=>$order_status_id,
                );
        echo json_encode($output);
    }

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		/*if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}*/

		if($this->input->post('catatan') == '')
		{
			$data['inputerror'][] = 'catatan';
			$data['error_string'][] = 'catatan wajib diisi';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
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

    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

            if(in_array($view, array('order/index_admin_area','order/index')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('order.js');
            }

             if(in_array($view, array('order/detail')))
            {
                //$this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                //$this->template->add_js('datatables/js/jquery.dataTables.min.js');
                //$this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('order_detail.js');
            }

            if ( ! empty($data['title']))
            {
                $this->template->set_title($data['title']);
            }

            $this->template->load_view($view, $data);
        }
        else
        {
            return $this->load->view($view, $data, TRUE);
        }
    }
function cek_orderbayar($tgl1,$tgl2){
        $from = $tgl1;
        $to = $tgl2;
        $query=$this->orders->filter_order($this->session->userdata('area_id'),$from,$to);
        $cek=$query->num_rows();
        if($cek>0){
            $result="<a href='order/order_csv/".$from."/".$to."' ><button class='btn btn-info btn-cons' type='button'><i class='
fa fa-cloud-download'></i> Download Excel</button></a> <a href='order/order_pdf/".$from."/".$to."' ><button class='btn btn-info btn-cons' type='button'><i class='
fa fa-cloud-download'></i> Download PDF</button></a>";
             echo json_encode(array('status' => 'found','result' => $result)); 
        }else{
            $result='';
           echo json_encode(array('status' => 'null','result' => $result)); 
            
        }
       
    }

    function order_csv($from,$to){
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $query = $this->orders->filter_csv_pembayaran($this->session->userdata('area_id'),$from,$to);
        $delimiter = ",";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Konfirmasi_Pembayaran.csv', $data);
    }

    function order_pdf($from,$to){
    $this->load->library('m_pdf');
    $this->load->helper('download');
    $html="<table>
    <thead>
    <tr>
    <td style='padding:3px;'>Order Id</td>
    <td style='padding:3px'>Order Code</td>
    <td style='padding:3px'>Order Name</td>
    <td style='padding:3px'>Order Email</td>
    <td style='padding:3px'>Order Phone</td>
    <td style='padding:3px'>Order Recipient Name</td>
    <td style='padding:3px'>Order Recipient Address</td>
    <td style='padding:3px'>Order Recipient Phone</td>
    <td style='padding:3px'>Propinsi</td>
    <td style='padding:3px'>Kabupaten</td>
    <td style='padding:3px'>Kecamatan</td>
    <td style='padding:3px'>Order Recipient poscode</td>
    <td style='padding:3px'>Order Shipping Price</td>
    <td style='padding:3px'>Order Subtotal</td>
    <td style='padding:3px'>Order Total</td>
    <td style='padding:3px'>Order Date</td>
    <td style='padding:3px'>Order Date Confirm</td>
    <td style='padding:3px'>Area</td>
    </tr>
    </thead>
    ";
    $html.="<tbody>";
    $query = $this->orders->filter_csv_pembayaran($this->session->userdata('area_id'),$from,$to)->result();
    foreach ($query as $data) {
    $html.="
    <tr>
    <td style='padding:3px'>".$data->order_id."</td>
    <td style='padding:3px'>".$data->order_code."</td>
    <td style='padding:3px'>".$data->order_name."</td>
    <td style='padding:3px'>".$data->order_email."</td>
    <td style='padding:3px'>".$data->order_phone."</td>
    <td style='padding:3px'>".$data->order_recipient_name."</td>
    <td style='padding:3px'>".$data->order_recipient_address."</td>
    <td style='padding:3px'>".$data->order_recipient_phone."</td>
    <td style='padding:3px'>".$data->propinsi."</td>
    <td style='padding:3px'>".$data->kabupaten."</td>
    <td style='padding:3px'>".$data->kecamatan."</td>
    <td style='padding:3px'>".$data->order_recipient_postcode."</td>
    <td style='padding:3px'>".$data->order_shipping_price."</td>
    <td style='padding:3px'>".$data->order_subtotal."</td>
    <td style='padding:3px'>".$data->order_total."</td>
    <td style='padding:3px'>".$data->order_date."</td>
    <td style='padding:3px'>".$data->order_date_confirm."</td>
    <td style='padding:3px'>".$data->area."</td>
    </tr>";
    }
    $html.="</tbody>";
    $html.="</table>";
    $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    $this->m_pdf->pdf->WriteHTML(utf8_encode($PDFContent));
    $this->m_pdf->pdf->Output('Konfirmasi_Pembayaran.pdf', 'D');

    }

function download_surat($id){
    $this->load->library('m_pdf');
    $this->load->helper('download');
    $order_by_id = $this->orders->get_by_id($id);
            if($order_by_id->num_rows() > 0)
            {
                $q_lapak_pertama = $this->items->get_lapak_pertama($id);
                if($q_lapak_pertama->num_rows() > 0)
                {
                    $value = $q_lapak_pertama->row_array();
                    $this->data['admin_area_name'] = $value['admin_area_name'];
                    $this->data['admin_area_email'] = $value['admin_area_email'];
                    $this->data['admin_area_id'] = $value['admin_area_id'];
                }else{
                    $this->data['admin_area_name'] = '';
                    $this->data['admin_area_email'] = '';
                    $this->data['admin_area_id'] = 0;
                }

                $order = $order_by_id->row_array();
                $next_order_status_id = $order['order_status_id'] + 1;
                $q_next_order_status = $this->order_status->get_by_id($next_order_status_id);
                if($q_next_order_status->num_rows() > 0)
                {
                    $value = $q_next_order_status->row_array();
                    $this->data['next_order_status_title'] = $value['title'];
                    $this->data['next_order_status_id'] = $next_order_status_id;
                }else{
                    $this->data['next_order_status_title'] = "";
                    $this->data['next_order_status_id'] = 0;
                }

            }

            
           
           


      $html="<div style='width100%; border-top:3px solid #000; height:100px'>
    <div style='text-align:center'><h3>FAKTUR</h3></div>
    <div>
    <table style='width:100%'>
    <tr>
    <td>No SP</td>
    <td>:</td>
    <td>".$order['order_code']."</td>
    <td>No FAKTUR</td>
    <td>:</td>
    <td>".$order['order_code']."</td>
    </tr>
    <tr>
    <td>Email Pelanggan</td>
    <td>:</td>
    <td>".$order['order_email']."</td>
    <td>Tanggal</td>
    <td>:</td>
    <td>".$order['order_date']."</td>
    </tr>
    <tr>
    <td>Nama Pelanggan</td>
    <td>:</td>
    <td>".$order['order_name']."</td>
    <td>Jatuh Tempo</td>
    <td>:</td>
    <td>-</td>
    </tr>
    <tr>
    <td>Alamat Pelanggan</td>
    <td>:</td>
    <td>".$order['order_recipient_address']."</td>
    
    </tr>
    </table>
    </div>
    <div style='margin-top:20px'>
    <table style='width:100%;border:1px solid #000;' cellspacing='0' cellpadding='3'>
    
    <tr>
    <td style='border-rigt:1px solid #000;border-bottom:1px solid #000'>Kode Barang</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>Nama Barang/Pengarang</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>Kuantum</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>Rabat</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>Harga Satuan</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>Netto</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>Nama Sales</td>
    </tr>";
$item_group=$this->orders->get_items_by_id_group($id)->result();
            $items_order="";
            foreach ($item_group as $item_group) {
                
                $items_by_order = $this->orders->get_items_by_id($id,$item_group->lapak_id)->result();
                foreach ($items_by_order as $key) {
                $bukunya=select_where('buku','kode_buku',$key->kode_buku)->row();
                $harga_disc=$key->price_first-$key->item_price;
                $items_order.="
    <tr>
    <td style='border-rigt:1px solid #000;border-bottom:1px solid #000'>".$key->kode_buku."</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>".$bukunya->judul."/".$bukunya->pengarang."</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>".$key->item_qty."</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>".$harga_disc."</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>$key->price_first</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>".$bukunya->berat."</td>
    <td style='border-left:1px solid #000; border-bottom:1px solid #000'>".$item_group->first_name." ".$item_group->last_name."</td>
    </tr>";
}}
            $html.= $items_order;
          
$ppn1=$order['order_total']/100*10;
$ppn=$order['order_total']+$ppn1;
    $html.="
    <tr>
    <td colspan='5' style='border-top:1px solid #000; border-rigt:1px solid #000'></td>
    <td style='border-top:1px solid #000; border-left:1px solid #000; border-rigt:1px solid #000'>Sub Total</td>
    <td style='border-top:1px solid #000; border-left:1px solid #000; border-rigt:1px solid #000'>".$order['order_total']."</td>
    </tr>
    <tr>
    <td colspan='5' style='border-top:1px solid #000; border-rigt:1px solid #000'></td>
    <td style='border-top:1px solid #000; border-left:1px solid #000; border-rigt:1px solid #000'>PPN 10%</td>
    <td style='border-top:1px solid #000; border-left:1px solid #000; border-rigt:1px solid #000'>".$ppn1."</td>
    </tr>
    <tr>
    <td colspan='5' style='border-top:1px solid #000; border-rigt:1px solid #000'></td>
    <td style='border-top:1px solid #000; border-left:1px solid #000; border-rigt:1px solid #000'>Total</td>
    <td style='border-top:1px solid #000; border-left:1px solid #000; border-rigt:1px solid #000'>".$ppn."</td>
    </tr>
    </table>
    </div>
    <div>
    <br>
    Catatan : <br>
    Pembayaran dengan Cek/Bilyet Giro bila dicantumkan nama <b>PT. PENERBIT ERLANGGA MAHAMERU</b><br>
    Pembayaran dengan Cek/Bilyet Giro sah  bila dicarikan di rekening bank <b>PT. PENERBIT ERLANGGA MAHAMERU</b><br><br>
    </div>
    <div>Jakarta, ".date('d/m/Y')."<br><br></div>
    <div>
    <table style='width:70%;text-align:center'>
    <tr>
    <td style='height:200px'>Dibuat oleh, </td>
    <td>Dikirim oleh, </td>
    <td>Diterima oleh, </td>
    </tr>
    <tr>
    <td>(.........................)</td>
    <td>(.........................)</td>
    <td>(.........................)</td>
    </tr>
     <tr>
    <td>Nama Jelas & tgl</td>
    <td>Nama Jelas & tgl</td>
    <td>Nama Jelas & tgl</td>
    </tr>
    </table>
    </div>
    </div>";
    $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
    $this->m_pdf->pdf->WriteHTML(utf8_encode($PDFContent));
    $this->m_pdf->pdf->Output('Surat Pesanan.pdf', 'D');
    
}

}