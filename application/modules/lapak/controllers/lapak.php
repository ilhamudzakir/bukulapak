<?php

defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","-1");
set_time_limit(0);

class Lapak extends MX_Controller {

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('authentication', NULL, 'ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');

        $this->load->database();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

        $this->load->model('lapak_model','lapak');
        $this->load->model('users_model','users');
		/*$this->load->model('ion_auth_model','ion_auth');*/

        $this->data['hide_sidebar'] = "";
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ($this->ion_auth->is_admin())
        {
        	$this->data['controller_name'] = 'lapak';

			$this->_render_page('lapak/index', $this->data);
            //return show_error('You must be an administrator to view this page.');
        }
        elseif ($this->ion_auth->is_sales())
        {
            //die('here');
        	$this->data['controller_name'] = 'lapak';

        	$propinsi = GetAll('propinsi');
        	if($propinsi->num_rows() > 0){
        		$this->data['propinsi'] = $propinsi->result_array();
        	}else{
        		$this->data['propinsi'] = array();
        	}

            //$this->data['hide_sidebar'] = 'hide-sidebar';

            $this->data['gen_password'] = array(
                'name'  => 'gen_password',
                'id'    => 'gen_password',
            );

        	$this->data['agen'] = GetAgen();

			$this->_render_page('lapak/index', $this->data);
        }
        elseif ($this->ion_auth->is_admin_area())
        {
            //die('here');
            $this->data['controller_name'] = 'lapak';

            $propinsi = GetAll('propinsi');
            if($propinsi->num_rows() > 0){
                $this->data['propinsi'] = $propinsi->result_array();
            }else{
                $this->data['propinsi'] = array();
            }

            $this->data['agen'] = GetAgen();

            $this->_render_page('lapak/index_admin_area', $this->data);
        }
        elseif ($this->ion_auth->is_agen())
        {
            //die('here');
            $this->data['controller_name'] = 'lapak';

            $propinsi = GetAll('propinsi');
            if($propinsi->num_rows() > 0){
                $this->data['propinsi'] = $propinsi->result_array();
            }else{
                $this->data['propinsi'] = array();
            }

            $this->data['agen'] = GetAgen();

            $this->_render_page('lapak/index_agen', $this->data);
        }
        else
        {
        	return show_error('You must be an administrator or sales to view this page.');
        }
	}

    public function cronactivelapak()
    {
        echo '<div class="alert alert-info">'.date('Y-m-d').' - Affected rows : '.$this->lapak->cronactivelapak().' rows</div>';
        //$getlapak = GetLapakArea(7);
        //echo $getlapak['area_title'];
    }

    public function croninactivelapak()
    {
        echo '<div class="alert alert-info">'.date('Y-m-d').' - Affected rows : '.$this->lapak->croninactivelapak().' rows</div>';
    }

    public function approve_atasan_1()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ($this->ion_auth->is_sales())
        {
            $this->data['controller_name'] = 'lapak';

            $this->_render_page('lapak/approve_atasan_1', $this->data);
        }
        else
        {
            return show_error('You must be an Superior or sales to view this page.');
        }
    }

    public function approve_atasan_2()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif ($this->ion_auth->is_sales())
        {
            $this->data['controller_name'] = 'lapak';

            $this->_render_page('lapak/approve_atasan_2', $this->data);
        }
        else
        {
            return show_error('You must be an Superior or sales to view this page.');
        }
    }

	public function ajax_list()
	{
		$id = $this->session->userdata('user_id');
		$list = $this->lapak->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
        $rec = "";
		foreach ($list as $lapak) {
            $no++;
            $row = array();
            $filter = array('lapak_id'=>'where/'.$lapak->lapak_id,'is_deleted'=>'where/0');
            $query = GetAll('lapak_buku',$filter);
            $query_harga = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','sum(buku.harga) as total_harga',$filter);
            $num_rows = $query->num_rows();
            $hargas = $query_harga->row_array();
            if($lapak->is_approve_superior != 'approve' || $lapak->is_approve_next_superior != 'approve' )
            {
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/edit/'.$lapak->lapak_id).'" title="Edit" onclick="edit_lapak('."'".$lapak->lapak_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            }else{
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/lapak_app/'.$lapak->lapak_id).'" title="Detail" onclick="edit_lapak('."'".$lapak->lapak_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            }

            
            $row[] = $lapak->sales_name;
            $row[] = $lapak->title;
            $row[] = $lapak->lapak_code;
            $row[] = $lapak->school_name;
            $row[] = $lapak->propinsi;
            $row[] = $lapak->kabupaten;
            $row[] = $lapak->agen_name;
            $row[] = $lapak->agen_disc;
            $row[] = $lapak->buyer_disc;
            $row[] = $lapak->notes;
            $row[] = $lapak->is_approve_superior;
            $row[] = $lapak->superior_name;
			$row[] = $lapak->approve_superior_date;
            $row[] = $lapak->is_approve_next_superior;
            $row[] = $lapak->next_superior_name;
            $row[] = $lapak->approve_next_superior_date;
			$row[] = date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active));
			$row[] = $num_rows.' buku';
			//$row[] = number_format($hargas['total_harga']);
			$row[] = strtoupper($lapak->active);
            $row[] = $lapak->active_date;
            $row[] = $lapak->active_user;
			$row[] =  $button_action;
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->lapak->count_all(),
						"recordsFiltered" => $this->lapak->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

    public function ajax_agen_list()
    {
        $id = $this->session->userdata('user_id');
        $list = $this->lapak->get_datatables_agen($id);
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $lapak) {
            $no++;
            $row = array();
            $filter = array('lapak_id'=>'where/'.$lapak->lapak_id,'is_deleted'=>'where/0');
            $query = GetAll('lapak_buku',$filter);
            $query_harga = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','sum(buku.harga) as total_harga',$filter);
            $num_rows = $query->num_rows();
            $hargas = $query_harga->row_array();
            if($lapak->is_approve_superior != 'approve' || $lapak->is_approve_next_superior != 'approve' )
            {
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/edit/'.$lapak->lapak_id).'" title="Edit" onclick="edit_lapak('."'".$lapak->lapak_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            }else{
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/lapak_app/'.$lapak->lapak_id).'" title="Detail" onclick="edit_lapak('."'".$lapak->lapak_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            }

            
            $row[] = $lapak->sales_name;
            $row[] = $lapak->title;
            $row[] = $lapak->lapak_code;
            $row[] = $lapak->school_name;
            $row[] = $lapak->propinsi;
            $row[] = $lapak->kabupaten;
            //$row[] = $lapak->agen_name;
            //$row[] = $lapak->agen_disc;
            //$row[] = $lapak->buyer_disc;
            //$row[] = $lapak->notes;
            //$row[] = $lapak->is_approve_superior;
            //$row[] = $lapak->superior_name;
            //$row[] = $lapak->approve_superior_date;
            //$row[] = $lapak->is_approve_next_superior;
            //$row[] = $lapak->next_superior_name;
            //$row[] = $lapak->approve_next_superior_date;
            $row[] = date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active));
            $row[] = $num_rows.' buku';
            //$row[] = number_format($hargas['total_harga']);
            $row[] = strtoupper($lapak->active);
            //$row[] = $lapak->active_date;
            //$row[] = $lapak->active_user;
            //$row[] =  $button_action;
            /*$filter = array('lapak_id'=>'where/'.$lapak->lapak_id,'is_deleted'=>'where/0');
            $query = GetAll('lapak_buku',$filter);
            $query_harga = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','sum(buku.harga) as total_harga',$filter);
            $num_rows = $query->num_rows();
            $hargas = $query_harga->row_array();

            $rec = '<div class="row">'.
                        '<div class="col-md-12"><h3><strong>'.$lapak->title.'</strong></h3></div>'.
                    '</div>'.
                    '<div class="row">'.
                        '<div class="col-md-4">'.
                            '<p>'.$lapak->school_name.'<br/>Masa aktif: '.date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active)).'</p><p><span class="label label-info">'.strtoupper($lapak->active).'</span></p>'.
                        '</div>'.
                        '<div class="col-md-4">'.
                            '<p>Total sales : '.$num_rows.' buku<br/><strong>IDR. '.number_format($hargas['total_harga']).'</strong></p>'.
                        '</div>'.
                    '</div>';
             $row[] = $lapak->title;
			$row[] = $lapak->school_name;
			$row[] = date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active));
			$row[] = $num_rows.' buku';
			$row[] = number_format($hargas['total_harga']);
			$row[] = strtoupper($lapak->active);*/
			$data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->lapak->count_all_agen($id),
                        "recordsFiltered" => $this->lapak->count_filtered_agen($id),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function ajax_admin_area_list()
    {   
        $area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        $list = $this->lapak->get_datatables_admin_area($area_id);
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $lapak) {
            $no++;
            $row = array();
            $filter = array('lapak_id'=>'where/'.$lapak->lapak_id,'is_deleted'=>'where/0');
            $query = GetAll('lapak_buku',$filter);
            $query_harga = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','sum(buku.harga) as total_harga',$filter);
            $num_rows = $query->num_rows();
            $hargas = $query_harga->row_array();
            //if($lapak->is_approve_superior != 'approve' || $lapak->is_approve_next_superior != 'approve' )
            //{
            //    $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/edit/'.$lapak->lapak_id).'" title="Edit" onclick="edit_lapak('."'".$lapak->lapak_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            //}else{
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/lapak_app/'.$lapak->lapak_id).'" title="Detail" onclick="edit_lapak('."'".$lapak->lapak_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
            //}

            $row[] = $lapak->sales_name;
            $row[] = $lapak->title;
            $row[] = $lapak->lapak_code;
            $row[] = $lapak->school_name;
            $row[] = $lapak->propinsi;
            $row[] = $lapak->kabupaten;
            $row[] = $lapak->agen_name;
            $row[] = $lapak->agen_disc;
            $row[] = $lapak->buyer_disc;
            $row[] = $lapak->notes;
            $row[] = $lapak->is_approve_superior;
            $row[] = $lapak->superior_name;
            $row[] = $lapak->approve_superior_date;
            $row[] = $lapak->is_approve_next_superior;
            $row[] = $lapak->next_superior_name;
            $row[] = $lapak->approve_next_superior_date;
            $row[] = date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active));
            $row[] = $num_rows.' buku';
            //$row[] = number_format($hargas['total_harga']);
            $row[] = strtoupper($lapak->active);
            $row[] = $lapak->active_date;
            $row[] = $lapak->active_user;
            $row[] =  $button_action;
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->lapak->count_all_admin_area($area_id),
                        "recordsFiltered" => $this->lapak->count_filtered_admin_area($area_id),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function ajax_atasan_1_list()
    {   
        $area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        $list = $this->lapak->get_datatables_atasan_1($id);
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $lapak) {
            $no++;
            $row = array();
            $filter = array('lapak_id'=>'where/'.$lapak->lapak_id,'is_deleted'=>'where/0');
            $query = GetAll('lapak_buku',$filter);
            $query_harga = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','sum(buku.harga) as total_harga',$filter);
            $num_rows = $query->num_rows();
            $hargas = $query_harga->row_array();

            if($lapak->is_approve_superior != 'approve')
            {
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/app_atasan_1/'.$lapak->lapak_id.'/'.$this->session->userdata('user_id')).'" title="Setujui"><i class="glyphicon glyphicon-pencil"></i> Setujui</a>';
            }else{
                $button_action = '<a class="btn btn-sm btn-info" href="'.site_url('lapak/app_atasan_1/'.$lapak->lapak_id.'/'.$this->session->userdata('user_id')).'" title="'.$lapak->is_approve_superior.'"><i class="glyphicon glyphicon-check"></i> '.$lapak->is_approve_superior.'</a>';
            }

            $row[] = $lapak->sales_name;
            $row[] = $lapak->title;
            $row[] = $lapak->lapak_code;
            $row[] = $lapak->school_name;
            $row[] = $lapak->propinsi;
            $row[] = $lapak->kabupaten;
            $row[] = $lapak->agen_name;
            $row[] = $lapak->agen_disc;
            $row[] = $lapak->buyer_disc;
            $row[] = $lapak->notes;
            $row[] = $lapak->is_approve_superior;
            $row[] = $lapak->superior_name;
            $row[] = $lapak->approve_superior_date;
            $row[] = $lapak->is_approve_next_superior;
            $row[] = $lapak->next_superior_name;
            $row[] = $lapak->approve_next_superior_date;
            $row[] = date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active));
            $row[] = $num_rows.' buku';
            //$row[] = number_format($hargas['total_harga']);
            $row[] = strtoupper($lapak->active);
            $row[] = $lapak->active_date;
            $row[] = $lapak->active_user;
            $row[] =  $button_action;
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->lapak->count_all_atasan_1($id),
                        "recordsFiltered" => $this->lapak->count_filtered_atasan_1($id),
                        "data" => $data,
                );
        echo json_encode($output);
    }


    public function ajax_atasan_2_list()
    {   
        $area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        $list = $this->lapak->get_datatables_atasan_2($id);
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $lapak) {
            $no++;
            $row = array();
            $filter = array('lapak_id'=>'where/'.$lapak->lapak_id,'is_deleted'=>'where/0');
            $query = GetAll('lapak_buku',$filter);
            $query_harga = GetJoin('lapak_buku','buku','lapak_buku.kode_buku = buku.kode_buku','left','sum(buku.harga) as total_harga',$filter);
            $num_rows = $query->num_rows();
            $hargas = $query_harga->row_array();
            if($lapak->is_approve_next_superior != 'approve')
            {
                $button_action = '<a class="btn btn-sm btn-primary" href="'.site_url('lapak/app_atasan_2/'.$lapak->lapak_id.'/'.$this->session->userdata('user_id')).'" title="Setujui"><i class="glyphicon glyphicon-pencil"></i> Setujui</a>';
            }else{
                $button_action = '<a class="btn btn-sm btn-info" href="'.site_url('lapak/app_atasan_2/'.$lapak->lapak_id.'/'.$this->session->userdata('user_id')).'" title="'.$lapak->is_approve_superior.'"><i class="glyphicon glyphicon-check"></i> '.$lapak->is_approve_superior.'</a>';
            }
            $row[] = $lapak->sales_name;
            $row[] = $lapak->title;
            $row[] = $lapak->lapak_code;
            $row[] = $lapak->school_name;
            $row[] = $lapak->propinsi;
            $row[] = $lapak->kabupaten;
            $row[] = $lapak->agen_name;
            $row[] = $lapak->agen_disc;
            $row[] = $lapak->buyer_disc;
            $row[] = $lapak->notes;
            $row[] = $lapak->is_approve_superior;
            $row[] = $lapak->superior_name;
            $row[] = $lapak->approve_superior_date;
            $row[] = $lapak->is_approve_next_superior;
            $row[] = $lapak->next_superior_name;
            $row[] = $lapak->approve_next_superior_date;
            $row[] = date('d M Y',strtotime($lapak->start_active)).' - '.date('d M Y',strtotime($lapak->end_active));
            $row[] = $num_rows.' buku';
            //$row[] = number_format($hargas['total_harga']);
            $row[] = strtoupper($lapak->active);
            $row[] = $lapak->active_date;
            $row[] = $lapak->active_user;
            $row[] =  $button_action;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->lapak->count_all_atasan_2($id),
                        "recordsFiltered" => $this->lapak->count_filtered_atasan_2($id),
                        "data" => $data,
                );
        echo json_encode($output);
    }

	//create a new lapak
    function create()
    {
        $this->data['title'] = "Create Lapak";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_sales())
        {
            redirect('lapak', 'refresh');
        }

            $this->data['controller_name'] = 'lapak';

			$data = array(
					'sales_id' => $this->session->userdata('user_id'),
					'create_date' => date('Y-m-d H:i:s',now()),
					'create_user_id' => $this->session->userdata('user_id'),
				);
			$insert = $this->lapak->save($data);

			redirect('lapak/edit/'.$insert,'refresh');
    }

    function not_active($id,$judul_lapak)
    {
        $this->data['title'] = "Create Lapak";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin_area())
        {
            redirect('lapak', 'refresh');
        }

        $this->data['controller_name'] = 'lapak';

            $data = array(
                    'active' => 'not active',
                    'active_date' => date('Y-m-d H:i:s',now()),
                    'active_user_id' => $this->session->userdata('user_id'),
                );
            $insert = $this->lapak->update(array("id"=>$id),$data);

            $message_success =  "<div class='alert alert-success text-center'><button data-dismiss='alert' class='close'></button><h4>Lapak ".$id."-".$judul_lapak." Berhasil di non aktifkan</h4></div>";
            echo json_encode(array("status_message"=>$message_success));
    }

    function active($id,$judul_lapak)
    {
        $this->data['title'] = "Create Lapak";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin_area())
        {
            redirect('lapak', 'refresh');
        }

        $this->data['controller_name'] = 'lapak';

            $data = array(
                    'active' => 'active',
                    'active_date' => date('Y-m-d H:i:s',now()),
                    'active_user_id' => $this->session->userdata('user_id'),
                );
            $insert = $this->lapak->update(array("id"=>$id),$data);

            $message_success =  "<div class='alert alert-success text-center'><button data-dismiss='alert' class='close'></button><h4>Lapak ".$id."-".$judul_lapak." Berhasil di aktifkan</h4></div>";
            echo json_encode(array("status_message"=>$message_success));
    }

    function edit($id)
    {
        //die('here');
        $this->data['title'] = "Edit Lapak";

        $this->data['controller_name'] = 'lapak';

        $this->data['hide_sidebar'] = 'hide-sidebar';

        $filter_lapak = array('id'=>'where/'.$id);
        $lapak_exist = getAll('lapak',$filter_lapak);
        if($lapak_exist->num_rows() > 0){
        	$lapak_exist_q = $lapak_exist->row_array();
        	$lapak_id = $lapak_exist_q['id'];
        }else{
        	$lapak_exist_q = array();
        	$lapak_id = 0;
        }

        //die('lapak id:'.$lapak_id);

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_sales() && !($lapak_id == $id)))
        {
            redirect('lapak', 'refresh');
        }

        $lapak = $lapak_exist->row();

        //validate form input
        $this->form_validation->set_rules('title', 'Nama lapak', 'required|xss_clean');
		$this->form_validation->set_rules('sekolah_id', 'Nama sekolah', 'required|xss_clean');
        $this->form_validation->set_rules('agen_id', 'Nama agen', 'required|xss_clean');
        $this->form_validation->set_rules('start_active', 'Tanggal mulai aktif', 'required|xss_clean');
        $this->form_validation->set_rules('end_active', 'Tanggal selesai aktif', 'required|xss_clean');        
        $this->form_validation->set_rules('propinsi_id', 'Propinsi', 'required|xss_clean');
        $this->form_validation->set_rules('kabupaten_id', 'Kota/Kabupaten', 'required|xss_clean');
        $this->form_validation->set_rules('agen_disc', 'Disc. agen', 'required|xss_clean');
        $this->form_validation->set_rules('buyer_disc', 'Disc. pembeli', 'required|xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            $data = array(
                'lapak_code' => $id.'-'.url_title($this->input->post('title'), '_', TRUE),
                'title' => $this->input->post('title'),
                'start_active'  => date('Y-m-d',strtotime($this->input->post('start_active'))),
                'end_active'    => date('Y-m-d',strtotime($this->input->post('end_active'))),
                'propinsi_id'   => $this->input->post('propinsi_id'),
                'kabupaten_id'   => $this->input->post('kabupaten_id'),
                'sekolah_id'   => $this->input->post('sekolah_id'),
                'agen_id'   => $this->input->post('agen_id'),
                'agen_disc'     => $this->input->post('agen_disc'),
                'buyer_disc'    => $this->input->post('buyer_disc'),
                'notes'         => $this->input->post('notes')
            );

            if ($this->form_validation->run() === TRUE)
            {
                $this->lapak->update(array("id" => $id), $data);
                $message_success =  "<div class='alert alert-success text-center'><button data-dismiss='alert' class='close'></button><h4>Lapak Berhasil Dibuat</h4>".
                                    "<p>Kode Lapak Anda adalah <strong>".$id."-".url_title($this->input->post('title'),"_",TRUE)."</strong>".
                                    "<br/>selanjutnya atasan Anda akan memeriksa dan melakukan persetujuan<br/>".
                                    "Setelah lapak Anda disetujui Anda bisa mulai menggunakan lapak tersebut</p></div>";
                $this->session->set_flashdata('message_success', $message_success);
                if ($this->ion_auth->is_sales())
                {
                    redirect('lapak', 'refresh');
                }
                else
                {
                    redirect('/', 'refresh');
                }
            }
        }

        $propinsi = GetAll('propinsi');
    	if($propinsi->num_rows() > 0){
    		$this->data['propinsi'] = $propinsi->result_array();
    	}else{
    		$this->data['propinsi'] = array();
    	}

        $kabupaten = GetAll('kabupaten');
        if($kabupaten->num_rows() > 0){
            $this->data['kabupaten'] = $kabupaten->result_array();
        }else{
            $this->data['kabupaten'] = array();
        }

       // $filter_sekolah = array("is_deleted"=>"where/0");
        //$sekolah = GetAll('sekolah',$filter_sekolah);
        //if($sekolah->num_rows() > 0){
        //    $this->data['sekolah'] = $sekolah->result_array();
        //}else{
        //}

        $this->data['agen'] = GetAgen();

        $this->data['superior_id'] = GetSalesbyArea();

    	$this->data['next_superior_id'] = GetSalesbyArea();

        $this->data['kode_buku'] = Getbuku();

        $this->data['lapak_buku'] = GetLapakBuku($lapak_id);

        $this->data['csrf'] = $this->_get_csrf_nonce();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        //$this->data['user'] = $user;

        $this->data['lapak_id'] = array(
            'name'  => 'lapak_id',
            'id'    => 'lapak_id',
            'type'  => 'text',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('lapak_id', $lapak->id),
        );

        if($lapak->propinsi_id != 0){
            $getPropinsiq = getPropinsi($lapak->propinsi_id);
            $propinsi_name = $getPropinsiq['title'];
            $propinsi_id = $getPropinsiq['propinsi_id'];
            $this->data['propinsi_id'] = $propinsi_id;
            $this->data['propinsi_name'] = $propinsi_name;

        }else{
            $this->data['propinsi_id'] = 0;
            $this->data['propinsi_name'] = '';
        }

        if($lapak->kabupaten_id != 0){
            $getkabupatenq = getkabupaten($lapak->kabupaten_id);
            $kabupaten_name = $getkabupatenq['title'];
            $kabupaten_id = $getkabupatenq['kabupaten_id'];
            $this->data['kabupaten_id'] = $kabupaten_id;
            $this->data['kabupaten_name'] = $kabupaten_name;

        }else{
            $this->data['kabupaten_id'] = 0;
            $this->data['kabupaten_name'] = '';
        }

        if($lapak->agen_id != 0){
            $getagenq = Getagenbyid($lapak->agen_id);
            $agen_name = $getagenq['title'];
            $agen_id = $getagenq['agen_id'];
            $this->data['agen_id'] = $agen_id;
            $this->data['agen_name'] = $agen_name;

        }else{
            $this->data['agen_id'] = 0;
            $this->data['agen_name'] = '';
        }

        if($lapak->sekolah_id != 0){
            $getagenq = GetsekolahbyidDetail($lapak->propinsi_id,$lapak->kabupaten_id,$lapak->sekolah_id);
            $sekolahname = $getagenq['title'];
            $sekolah_id = $getagenq['id'];
            $this->data['sekolah_id'] = $sekolah_id;
            $this->data['sekolah_name'] = $sekolahname;

        }else{
            $this->data['sekolah_id'] = 0;
            $this->data['sekolah_name'] = '';
        }

        if($lapak->superior_id != 0){
            $getsuperiorq = getsuperiorbyid($lapak->superior_id);
            //$superior_name = $getsuperiorq['title'];
            $is_approve_superior = $getsuperiorq['is_approve_superior'];
            $this->data['valueis_approve_superior'] = $is_approve_superior;
            //$this->data['superior_name'] = $superior_name;

        }else{
            $this->data['valueis_approve_superior'] = "pending";
            //$this->data['superior_name'] = '';
        }
        

        $this->data['title_input'] = array(
            'name'  => 'title',
            'id'    => 'title',
            'type'  => 'text',
            'placeholder' => 'Nama Lapak',
            'value' => $this->form_validation->set_value('title', $lapak->title),
        );
        $this->data['start_active'] = array(
            'name'  => 'start_active',
            'id'    => 'dt1',
            'type'  => 'text',
            'placeholder' => 'Mulai',
            'value' => $this->form_validation->set_value('start_active', ($lapak->start_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->start_active))),
        );
        $this->data['end_active'] = array(
            'name'  => 'end_active',
            'id'    => 'dt2',
            'type'  => 'text',
            'placeholder' => 'Selesai',
            'value' => $this->form_validation->set_value('end_active', ($lapak->end_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->end_active))),
        );
        $this->data['school_name'] = array(
            'name'  => 'school_name',
            'id'    => 'school_name',
            'type'  => 'text',
            'placeholder' => 'Nama Sekolah',
            'value' => $this->form_validation->set_value('school_name', $lapak->sekolah_id),
        );

        $this->data['agen_disc'] = array(
            'name'  => 'agen_disc',
            'id'    => 'agen_disc',
            'type'  => 'text',
            'placeholder' => 'Nama Sekolah',
            'value' => $this->form_validation->set_value('agen_disc', $lapak->agen_disc),
        );

        $this->data['buyer_disc'] = array(
            'name'  => 'buyer_disc',
            'id'    => 'buyer_disc',
            'type'  => 'text',
            'placeholder' => 'Nama Sekolah',
            'value' => $this->form_validation->set_value('buyer_disc', $lapak->buyer_disc),
        );

        $this->data['notes'] = array(
            'name'  => 'notes',
            'id'    => 'notes',
            'placeholder' => 'Catatan',
            'value' => $this->form_validation->set_value('notes', $lapak->notes),
        );

        $this->data['gen_password'] = array(
            'name'  => 'gen_password',
            'id'    => 'gen_password',
        );

        $this->_render_page('lapak/create', $this->data);
    }

    function lapak_app($id)
    {
        $this->data['title'] = "Aktifasi Lapak";

        $this->data['controller_name'] = 'lapak';

        $filter_lapak = array('id'=>'where/'.$id);
        $lapak_exist = getAll('lapak',$filter_lapak);
        if($lapak_exist->num_rows() > 0){
            $lapak_exist_q = $lapak_exist->row_array();
            $lapak_id = $lapak_exist_q['id'];
        }else{
            $lapak_exist_q = array();
            $lapak_id = 0;
        }

        //die('lapak id:'.$lapak_id);

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_sales() && !($lapak_id == $id)))
        {
            redirect('lapak', 'refresh');
        }

        $lapak = $lapak_exist->row();

        //validate form input
        $this->form_validation->set_rules('superior_id', 'Atasan 1', 'required|xss_clean');
        $this->form_validation->set_rules('next_superior_id', 'Atasan 2', 'required|xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            /*if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }*/

            $data = array(
                'superior_id' => $this->input->post('superior_id'),
                'next_superior_id' => $this->input->post('next_superior_id'),
                'active_date'  => date('Y-m-d',now()),
                'active_user_id'    => $this->session->userdata('user_id'),
            );

            if ($this->form_validation->run() === TRUE)
            {
                $this->lapak->update(array("id" => $id), $data);

                $message_success =  "<div class='alert alert-success text-center'><button data-dismiss='alert' class='close'></button><h4>Lapak Berhasil Diaktifkan</h4>".
                                    "<p>Kode Lapak <strong>".$id."-".strtoupper($lapak->title)."</strong>".
                                    "<br/>selanjutnya atasan 1 dan atasan  2lapak ini akan memeriksa dan melakukan persetujuan<br/>".
                                    "Setelah disetujui lapak ini dapat mulai digunakan</p></div>";
                $this->session->set_flashdata('message_success', $message_success);
                if ($this->ion_auth->is_admin_area())
                {
                    redirect('lapak', 'refresh');
                }
                else
                {
                    redirect('/', 'refresh');
                }
            }
        }

        $propinsi = GetAll('propinsi');
        if($propinsi->num_rows() > 0){
            $this->data['propinsi'] = $propinsi->result_array();
        }else{
            $this->data['propinsi'] = array();
        }

        //$this->data['agen'] = GetAgen();

        $this->data['active'] = $lapak->active;

        $this->data['judul_lapak'] = url_title($lapak->title);

        $this->data['superior_id'] = GetSalesbyArea();

        $this->data['next_superior_id'] = GetSalesbyArea();

        //$this->data['kode_buku'] = Getbuku();

        $this->data['lapak_buku'] = GetLapakBuku($lapak_id);

        $this->data['valueis_approve_superior'] = $lapak->is_approve_superior;

        $this->data['csrf'] = $this->_get_csrf_nonce();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        //$this->data['user'] = $user;

        if($lapak->superior_id != 0){
            $getsuperiorq = getsuperiorbyid($lapak->superior_id);
            $superior_name = $getsuperiorq['title'];
            $superior_id = $getsuperiorq['id'];
            //$is_approve_superior = $getsuperiorq['is_approve_superior'];
            $this->data['valuesuperior_id'] = $superior_id;
            $this->data['superior_name'] = $superior_name;
            

        }else{
            $this->data['valuesuperior_id'] = 0;
            $this->data['superior_name'] = '';
            $this->data['valueis_approve_superior'] = "pending";
        }

        if($lapak->next_superior_id != 0){
            $getnext_superiorq = getnextsuperiorbyid($lapak->next_superior_id);
            $next_superior_name = $getnext_superiorq['title'];
            $next_superior_id = $getnext_superiorq['id'];
            $this->data['valuenext_superior_id'] = $next_superior_id;
            $this->data['next_superior_name'] = $next_superior_name;

        }else{
            $this->data['valuenext_superior_id'] = 0;
            $this->data['next_superior_name'] = '';
        }

        $this->data['lapak_id'] = array(
            'name'  => 'lapak_id',
            'id'    => 'lapak_id',
            'type'  => 'text',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('lapak_id', $lapak->id),
        );

        if($lapak->propinsi_id != 0){
            $getPropinsiq = getPropinsi($lapak->propinsi_id);
            $propinsi_name = $getPropinsiq['title'];
            $propinsi_id = $getPropinsiq['propinsi_id'];
            $this->data['propinsi_id'] = $propinsi_id;
            $this->data['propinsi_name'] = $propinsi_name;

        }else{
            $this->data['propinsi_id'] = 0;
            $this->data['propinsi_name'] = '';
        }

        if($lapak->kabupaten_id != 0){
            $getkabupatenq = getkabupaten($lapak->kabupaten_id);
            $kabupaten_name = $getkabupatenq['title'];
            $kabupaten_id = $getkabupatenq['kabupaten_id'];
            $this->data['kabupaten_id'] = $kabupaten_id;
            $this->data['kabupaten_name'] = $kabupaten_name;

        }else{
            $this->data['kabupaten_id'] = 0;
            $this->data['kabupaten_name'] = '';
        }

        if($lapak->sekolah_id != 0){
            $getsekolahq = getsekolahbyid($lapak->sekolah_id);
            $sekolah_name = $getsekolahq['title'];
            $sekolah_id = $getsekolahq['id'];
            $this->data['sekolah_id'] = $sekolah_id;
            $this->data['sekolah_name'] = $sekolah_name;

        }else{
            $this->data['sekolah_id'] = 0;
            $this->data['sekolah_name'] = '';
        }

        if($lapak->agen_id != 0){
            $getagenq = Getagenbyid($lapak->agen_id);
            $agen_name = $getagenq['title'];
            $agen_id = $getagenq['agen_id'];
            $this->data['agen_id'] = $agen_id;
            $this->data['agen_name'] = $agen_name;

        }else{
            $this->data['agen_id'] = 0;
            $this->data['agen_name'] = '';
        }
        

        $this->data['title_input'] = array(
            'name'  => 'title',
            'id'    => 'title',
            'type'  => 'text',
            'placeholder' => 'Nama Lapak',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('title', $lapak->title),
        );
        $this->data['start_active'] = array(
            'name'  => 'start_active',
            'id'    => 'dt1',
            'type'  => 'text',
            'placeholder' => 'Mulai',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('start_active', ($lapak->start_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->start_active))),
        );
        $this->data['end_active'] = array(
            'name'  => 'end_active',
            'id'    => 'dt2',
            'type'  => 'text',
            'placeholder' => 'Selesai',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('end_active', ($lapak->end_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->end_active))),
        );
        $this->data['school_name'] = array(
            'name'  => 'school_name',
            'id'    => 'school_name',
            'type'  => 'text',
            'placeholder' => 'Nama Sekolah',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('school_name', $lapak->sekolah_id),
        );

        $this->data['agen_disc'] = array(
            'name'  => 'agen_disc',
            'id'    => 'agen_disc',
            'type'  => 'text',
            'placeholder' => 'Disc. Agen',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('agen_disc', $lapak->agen_disc),
        );

        $this->data['buyer_disc'] = array(
            'name'  => 'buyer_disc',
            'id'    => 'buyer_disc',
            'type'  => 'text',
            'placeholder' => 'Disc. Pembeli',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('buyer_disc', $lapak->buyer_disc),
        );

        $this->data['notes'] = array(
            'name'  => 'notes',
            'id'    => 'notes',
            'placeholder' => 'Catatan',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('notes', $lapak->notes),
        );

        $this->data['gen_password'] = array(
            'name'  => 'gen_password',
            'id'    => 'gen_password',
        );

        $this->_render_page('lapak/lapak_app', $this->data);
    }

    function app_atasan_1($id)
    {
        $this->data['title'] = "Aktifasi Lapak";

        $this->data['controller_name'] = 'lapak';

        $filter_lapak = array('id'=>'where/'.$id);
        $lapak_exist = getAll('lapak',$filter_lapak);
        if($lapak_exist->num_rows() > 0){
            $lapak_exist_q = $lapak_exist->row_array();
            $lapak_id = $lapak_exist_q['id'];
        }else{
            $lapak_exist_q = array();
            $lapak_id = 0;
        }

        //die('lapak id:'.$lapak_id);

        //if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_sales() && !($lapak_id == $id)))
        //{
        //    redirect('lapak', 'refresh');
        //}

        $lapak = $lapak_exist->row();

        //validate form input
        $this->form_validation->set_rules('optionyes', 'Persetujuan', 'required|xss_clean');
        //$this->form_validation->set_rules('next_superior_id', 'Atasan 2', 'required|xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            /*if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }*/
            if($lapak->is_approve_next_superior != "approve"){
                $active = "waiting";
            }else{
                $active = "approve";
            }
            
            $data = array(
                'active'                    => $active,
                'is_approve_superior'       => $this->input->post('optionyes'),
                'approve_superior_date'     => date('Y-m-d H:i:s',now()),
                'modify_date'               => date('Y-m-d H:i:s',now()),
                'modify_user_id'            => $this->session->userdata('user_id'),
            );

            if ($this->form_validation->run() === TRUE)
            {
                $this->lapak->update(array("id" => $id), $data);

                $message_success =  "<div class='alert alert-success text-center'><button data-dismiss='alert' class='close'></button><h4>Lapak Berhasil Disetujui</h4>".
                                    "<p>Kode Lapak <strong>".$id."-".strtoupper($this->input->post('title'))."</strong>".
                                    "<br/>selanjutnya atasan 2 lapak ini akan memeriksa dan melakukan persetujuan<br/>".
                                    "Setelah disetujui lapak ini dapat mulai digunakan</p></div>";

                $this->session->set_flashdata('message_success', $message_success);

                if ($this->ion_auth->is_sales())
                {
                    redirect('lapak/approve_atasan_1', 'refresh');
                }
                else
                {
                    redirect('lapak/approve_atasan_1', 'refresh');
                }
            }
        }

        $propinsi = GetAll('propinsi');
        if($propinsi->num_rows() > 0){
            $this->data['propinsi'] = $propinsi->result_array();
        }else{
            $this->data['propinsi'] = array();
        }

        //$this->data['agen'] = GetAgen();

        

        $this->data['superior_id'] = GetSalesbyArea();

        $this->data['next_superior_id'] = GetSalesbyArea();

        //$this->data['kode_buku'] = Getbuku();

        $this->data['lapak_buku'] = GetLapakBuku($lapak_id);

        $this->data['csrf'] = $this->_get_csrf_nonce();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        //$this->data['user'] = $user;

        if(strlen($lapak->is_approve_superior) != 0){
            $this->data['valueis_approve_superior'] = $lapak->is_approve_superior;
        }else{
            $this->data['valueis_approve_superior'] = "pending";
        }

        if(strlen($lapak->is_approve_next_superior) != 0){
            $this->data['valueis_approve_next_superior'] = $lapak->is_approve_next_superior;
        }else{
            $this->data['valueis_approve_next_superior'] = "pending";
        }

        if($lapak->superior_id != 0){
            $getsuperiorq = getnextsuperiorbyid($lapak->superior_id);
            $superior_name = $getsuperiorq['title'];
            $superior_id = $getsuperiorq['id'];
            $this->data['valuesuperior_id'] = $superior_id;
            $this->data['superior_name'] = $superior_name;

        }else{
            $this->data['valuesuperior_id'] = 0;
            $this->data['superior_name'] = '';
        }

        if($lapak->next_superior_id != 0){
            $getnext_superiorq = getnextsuperiorbyid($lapak->next_superior_id);
            $next_superior_name = $getnext_superiorq['title'];
            $next_superior_id = $getnext_superiorq['id'];
            $this->data['valuenext_superior_id'] = $next_superior_id;
            $this->data['next_superior_name'] = $next_superior_name;

        }else{
            $this->data['valuenext_superior_id'] = 0;
            $this->data['next_superior_name'] = '';
        }

        $this->data['lapak_id'] = array(
            'name'  => 'lapak_id',
            'id'    => 'lapak_id',
            'type'  => 'text',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('lapak_id', $lapak->id),
        );

        if($lapak->propinsi_id != 0){
            $getPropinsiq = getPropinsi($lapak->propinsi_id);
            $propinsi_name = $getPropinsiq['title'];
            $propinsi_id = $getPropinsiq['propinsi_id'];
            $this->data['propinsi_id'] = $propinsi_id;
            $this->data['propinsi_name'] = $propinsi_name;

        }else{
            $this->data['propinsi_id'] = 0;
            $this->data['propinsi_name'] = '';
        }

        if($lapak->kabupaten_id != 0){
            $getkabupatenq = getkabupaten($lapak->kabupaten_id);
            $kabupaten_name = $getkabupatenq['title'];
            $kabupaten_id = $getkabupatenq['kabupaten_id'];
            $this->data['kabupaten_id'] = $kabupaten_id;
            $this->data['kabupaten_name'] = $kabupaten_name;

        }else{
            $this->data['kabupaten_id'] = 0;
            $this->data['kabupaten_name'] = '';
        }

        if($lapak->sekolah_id != 0){
            $getsekolahq = getsekolahbyid($lapak->sekolah_id);
            $sekolah_name = $getsekolahq['title'];
            $sekolah_id = $getsekolahq['id'];
            $this->data['sekolah_id'] = $sekolah_id;
            $this->data['sekolah_name'] = $sekolah_name;

        }else{
            $this->data['sekolah_id'] = 0;
            $this->data['sekolah_name'] = '';
        }

        if($lapak->agen_id != 0){
            $getagenq = Getagenbyid($lapak->agen_id);
            $agen_name = $getagenq['title'];
            $agen_id = $getagenq['agen_id'];
            $this->data['agen_id'] = $agen_id;
            $this->data['agen_name'] = $agen_name;

        }else{
            $this->data['agen_id'] = 0;
            $this->data['agen_name'] = '';
        }
        

        $this->data['title_input'] = array(
            'name'  => 'title',
            'id'    => 'title',
            'type'  => 'text',
            'placeholder' => 'Nama Lapak',
            'readonly' => 'true',
            'value' => $this->form_validation->set_value('title', $lapak->title),
        );
        $this->data['start_active'] = array(
            'name'  => 'start_active',
            'id'    => 'dt1',
            'type'  => 'text',
            'placeholder' => 'Mulai',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('start_active', ($lapak->start_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->start_active))),
        );
        $this->data['end_active'] = array(
            'name'  => 'end_active',
            'id'    => 'dt2',
            'type'  => 'text',
            'placeholder' => 'Selesai',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('end_active', ($lapak->end_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->end_active))),
        );
        $this->data['school_name'] = array(
            'name'  => 'school_name',
            'id'    => 'school_name',
            'type'  => 'text',
            'placeholder' => 'Nama Sekolah',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('school_name', $lapak->sekolah_id),
        );

        $this->data['agen_disc'] = array(
            'name'  => 'agen_disc',
            'id'    => 'agen_disc',
            'type'  => 'text',
            'placeholder' => 'Disc. Agen',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('agen_disc', $lapak->agen_disc),
        );

        $this->data['buyer_disc'] = array(
            'name'  => 'buyer_disc',
            'id'    => 'buyer_disc',
            'type'  => 'text',
            'placeholder' => 'Disc. Pembeli',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('buyer_disc', $lapak->buyer_disc),
        );

        $this->data['notes'] = array(
            'name'  => 'notes',
            'id'    => 'notes',
            'placeholder' => 'Catatan',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('notes', $lapak->notes),
        );

        $this->data['gen_password'] = array(
            'name'  => 'gen_password',
            'id'    => 'gen_password',
        );

        $this->_render_page('lapak/app_atasan_1', $this->data);
    }

    function app_atasan_2($id)
    {
        $this->data['title'] = "Aktifasi Lapak";

        $this->data['controller_name'] = 'lapak';

        $filter_lapak = array('id'=>'where/'.$id);
        $lapak_exist = getAll('lapak',$filter_lapak);
        if($lapak_exist->num_rows() > 0){
            $lapak_exist_q = $lapak_exist->row_array();
            $lapak_id = $lapak_exist_q['id'];
        }else{
            $lapak_exist_q = array();
            $lapak_id = 0;
        }

        //die('lapak id:'.$lapak_id);

        //if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_sales() && !($lapak_id == $id)))
        //{
        //    redirect('lapak', 'refresh');
        //}

        $lapak = $lapak_exist->row();

        //validate form input
        $this->form_validation->set_rules('optionyes', 'Persetujuan', 'required|xss_clean');
        //$this->form_validation->set_rules('next_superior_id', 'Atasan 2', 'required|xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            /*if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }*/

            if($lapak->is_approve_superior != "approve"){
                $active = "waiting";
            }else{
                $active = "approve";
            }

            /*if(($lapak->is_approve_superior == "pending" || $lapak->is_approve_superior == "notapprove") && ($lapak->is_approve_next_superior == "pending" || $lapak->is_approve_next_superior == "notapprove")){
                $active = "waiting";
            }else{
                $active = "approve";
            }*/

            $data = array(
                'active'       => $active,
                'is_approve_next_superior'       => $this->input->post('optionyes'),
                'approve_next_superior_date'     => date('Y-m-d H:i:s',now()),
                'modify_date'               => date('Y-m-d H:i:s',now()),
                'modify_user_id'            => $this->session->userdata('user_id'),
            );

            if ($this->form_validation->run() === TRUE)
            {
                $this->lapak->update(array("id" => $id), $data);

                $message_success =  "<div class='alert alert-success text-center'><button data-dismiss='alert' class='close'></button><h4>Lapak Berhasil Disetujui</h4>".
                                    "<p>Kode Lapak <strong>".$id."-".strtoupper($lapak->title)."</strong>".
                                    " dapat mulai digunakan<br/>Terima kasih</p></div>";

                $this->session->set_flashdata('message_success', $message_success);
                if ($this->ion_auth->is_sales())
                {
                    redirect('lapak/approve_atasan_2', 'refresh');
                }
                else
                {
                    redirect('lapak/approve_atasan_2', 'refresh');
                }
            }
        }

        $propinsi = GetAll('propinsi');
        if($propinsi->num_rows() > 0){
            $this->data['propinsi'] = $propinsi->result_array();
        }else{
            $this->data['propinsi'] = array();
        }

        //$this->data['agen'] = GetAgen();

        $this->data['superior_id'] = GetSalesbyArea();

        $this->data['next_superior_id'] = GetSalesbyArea();

        //$this->data['kode_buku'] = Getbuku();

        $this->data['lapak_buku'] = GetLapakBuku($lapak_id);

        $this->data['csrf'] = $this->_get_csrf_nonce();

        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        //$this->data['user'] = $user;

        if(strlen($lapak->is_approve_superior) != 0){
            $this->data['valueis_approve_superior'] = $lapak->is_approve_superior;
        }else{
            $this->data['valueis_approve_superior'] = "pending";
        }

        if(strlen($lapak->is_approve_next_superior) != 0){
            $this->data['valueis_approve_next_superior'] = $lapak->is_approve_next_superior;
        }else{
            $this->data['valueis_approve_next_superior'] = "pending";
        }

        if($lapak->superior_id != 0){
            $getsuperiorq = getsuperiorbyid($lapak->superior_id);
            $superior_name = $getsuperiorq['title'];
            $superior_id = $getsuperiorq['id'];
            $this->data['valuesuperior_id'] = $superior_id;
            $this->data['superior_name'] = $superior_name;

        }else{
            $this->data['valuenext_superior_id'] = 0;
            $this->data['next_superior_name'] = '';
        }

        if($lapak->next_superior_id != 0){
            $getnext_superiorq = getnextsuperiorbyid($lapak->next_superior_id);
            $next_superior_name = $getnext_superiorq['title'];
            $next_superior_id = $getnext_superiorq['id'];
            $this->data['valuenext_superior_id'] = $next_superior_id;
            $this->data['next_superior_name'] = $next_superior_name;

        }else{
            $this->data['valuenext_superior_id'] = 0;
            $this->data['next_superior_name'] = '';
        }

        $this->data['lapak_id'] = array(
            'name'  => 'lapak_id',
            'id'    => 'lapak_id',
            'type'  => 'text',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('lapak_id', $lapak->id),
        );

        if($lapak->propinsi_id != 0){
            $getPropinsiq = getPropinsi($lapak->propinsi_id);
            $propinsi_name = $getPropinsiq['title'];
            $propinsi_id = $getPropinsiq['propinsi_id'];
            $this->data['propinsi_id'] = $propinsi_id;
            $this->data['propinsi_name'] = $propinsi_name;

        }else{
            $this->data['propinsi_id'] = 0;
            $this->data['propinsi_name'] = '';
        }

        if($lapak->kabupaten_id != 0){
            $getkabupatenq = getkabupaten($lapak->kabupaten_id);
            $kabupaten_name = $getkabupatenq['title'];
            $kabupaten_id = $getkabupatenq['kabupaten_id'];
            $this->data['kabupaten_id'] = $kabupaten_id;
            $this->data['kabupaten_name'] = $kabupaten_name;

        }else{
            $this->data['kabupaten_id'] = 0;
            $this->data['kabupaten_name'] = '';
        }

        if($lapak->sekolah_id != 0){
            $getsekolahq = getsekolahbyid($lapak->sekolah_id);
            $sekolah_name = $getsekolahq['title'];
            $sekolah_id = $getsekolahq['id'];
            $this->data['sekolah_id'] = $sekolah_id;
            $this->data['sekolah_name'] = $sekolah_name;

        }else{
            $this->data['sekolah_id'] = 0;
            $this->data['sekolah_name'] = '';
        }

        if($lapak->agen_id != 0){
            $getagenq = Getagenbyid($lapak->agen_id);
            $agen_name = $getagenq['title'];
            $agen_id = $getagenq['agen_id'];
            $this->data['agen_id'] = $agen_id;
            $this->data['agen_name'] = $agen_name;

        }else{
            $this->data['agen_id'] = 0;
            $this->data['agen_name'] = '';
        }
        

        $this->data['title_input'] = array(
            'name'  => 'title',
            'id'    => 'title',
            'type'  => 'text',
            'placeholder' => 'Nama Lapak',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('title', $lapak->title),
        );
        $this->data['start_active'] = array(
            'name'  => 'start_active',
            'id'    => 'dt1',
            'type'  => 'text',
            'placeholder' => 'Mulai',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('start_active', ($lapak->start_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->start_active))),
        );
        $this->data['end_active'] = array(
            'name'  => 'end_active',
            'id'    => 'dt2',
            'type'  => 'text',
            'placeholder' => 'Selesai',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('end_active', ($lapak->end_active == '0000-00-00') ? '' : date('d M Y',strtotime($lapak->end_active))),
        );
        $this->data['school_name'] = array(
            'name'  => 'school_name',
            'id'    => 'school_name',
            'type'  => 'text',
            'placeholder' => 'Nama Sekolah',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('school_name', $lapak->sekolah_id),
        );

        $this->data['agen_disc'] = array(
            'name'  => 'agen_disc',
            'id'    => 'agen_disc',
            'type'  => 'text',
            'placeholder' => 'Disc. Agen',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('agen_disc', $lapak->agen_disc),
        );

        $this->data['buyer_disc'] = array(
            'name'  => 'buyer_disc',
            'id'    => 'buyer_disc',
            'type'  => 'text',
            'placeholder' => 'Disc. Pembeli',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('buyer_disc', $lapak->buyer_disc),
        );

        $this->data['notes'] = array(
            'name'  => 'notes',
            'id'    => 'notes',
            'placeholder' => 'Catatan',
            'disabled' => 'disabled',
            'value' => $this->form_validation->set_value('notes', $lapak->notes),
        );

        $this->data['gen_password'] = array(
            'name'  => 'gen_password',
            'id'    => 'gen_password',
        );

        $this->_render_page('lapak/app_atasan_2', $this->data);
    }

	public function getkabupaten($propinsi_id)
	{
		$filter_kabupaten = array("propinsi_id"=>"where/".$propinsi_id,"title"=>"order/asc");
		$this->data['kabupaten'] = GetAll('kabupaten',$filter_kabupaten);

		$this->_render_page('lapak/getkabupaten', $this->data);
	}

    public function getsekolah($propinsi_id,$kabupaten_id)
    {
        $filter_sekolah = array("propinsi_id"=>"where/".$propinsi_id,"kabupaten_id"=>"where/".$kabupaten_id,"title"=>"order/asc");
        $this->data['sekolah'] = GetAll('sekolah',$filter_sekolah);
        //die($this->db->last_query());

        $this->_render_page('lapak/getsekolah', $this->data);
    }

    public function getkodebuku()
    {
        $search = $this->input->get('term'); 
        $filter_kodebuku = array('kode_buku'=>'like/'.$search);
        $query = GetAll('buku',$filter_kodebuku);
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $value) {
               $data[] = array('id' => $value['kode_buku'], 'text' => $value['kode_buku']);   
            }
        } else {
           $data[] = array('id' => 0, 'text' => 'Kode buku tidak ditemukan');
        }
        echo json_encode($data);
    }

    public function getjudulbuku()
    {
        $search = $this->input->get('term'); 
        $filter_judulbuku = array('judul'=>'like/'.$search);
        $query = GetAll('buku',$filter_judulbuku);
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $key => $value) {
               $data[] = array('id' => $value['judul'], 'text' => $value['judul']);   
            }
        } else {
           $data[] = array('id' => 0, 'text' => 'Judul buku tidak ditemukan');
        }
        echo json_encode($data);
    }

	public function ajax_edit($id)
	{
		$data = $this->lapak->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate_agen();
        $area_id = $this->session->userdata('area_id');
		$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'password' => $this->input->post('password'),
				'created_on' => date('Y-m-d H:i:s',now()),
			);
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $additional_data = array(
            'first_name'=>$this->input->post('first_name'),
            'password_mask'=>$this->input->post('password'),
            'area_id' => $area_id,
            'active' => 1,
            'created_on' => date('Y-m-d H:i:s',now()),
            );
        $group = array('group_id'=>4);
        $insert = $this->ion_auth->register($username, $password, $email, $additional_data,$group);
        $get_agen = GetAgen();
        $html_agen = "";
        $html_agen .= '<option value="0">Pilih agen</option>';
        foreach ($get_agen as $key => $value) { 
          $html_agen .= '<option value="'.$value['agen_id'].'">'.$value['title'].'</option>';
        }
        //$html_agen .= '</select>';
		echo json_encode(array("status" => TRUE,"data_agen" => $html_agen));
	}

    public function ajax_add_sekolah()
    {
        $this->_validate_sekolah();
        $area_id = $this->session->userdata('area_id');
        $data = array(
                'title' => $this->input->post('title'),
                'propinsi_id' => $this->input->post('propinsi_sekolah'),
                'kabupaten_id' => $this->input->post('kabupaten_sekolah'),
                'create_user_id' => $this->session->userdata('user_id'),
                'create_date' => date('Y-m-d H:i:s',now()),
            );
        
        $insert = $this->lapak->save_sekolah($data);
        $get_sekolah = GetSekolah();
        $html_sekolah = "";
        $html_sekolah .= '<option value="0">Pilih Sekolah</option>';
        foreach ($get_sekolah as $key => $value) { 
          $html_sekolah .= '<option value="'.$value['id'].'">'.$value['title'].'</option>';
        }
        //$html_sekolah .= '</select>';
        echo json_encode(array("status" => TRUE,"data_sekolah" => $html_sekolah));
    }

    public function ajax_search_buku()
    {
        $lapak_id = $this->input->post('lapak_id');
        $kode_buku = $this->input->post('kode_buku');
        $jenjang = $this->input->post('jenjang');
        $judul_buku = $this->input->post('judul_buku');
        $table_html = '';

        if(strlen($kode_buku) > 0){
            $this->db->like('kode_buku',$kode_buku);
        }

        if (strlen($jenjang) > 0) {
            //if($jenjang != 0){
                $this->db->where('jenjang',$jenjang);    
            //}
        }

        if (strlen($judul_buku) > 0) {
            $this->db->like('judul',$judul_buku);
        }

        $this->db->select('kode_buku,cover,judul, harga, jenjang, bstudi');
        $this->db->limit(30);
        $query = $this->db->get('buku');
        $last_query = $this->db->last_query();
        if($query->num_rows() > 0){
            $table_html .= '<h3>Daftar Buku</h3>';
            $table_html .= '<table class="table"><tr><th>Cover</th><th>Judul Buku</th><th>Jenjang</th><th>&nbsp;</th></tr>';
            foreach ($query->result_array() as $key => $value) {
                $table_html .= '<tr>';
                    $table_html .= '<td>';
                        $table_html .= "<img width='50px' src='".base_url()."uploads/cover/".$value['cover']."'";
                    $table_html .= '</td>';
                    $table_html .= '<td>';
                        $table_html .= $value['judul'].'<br/>IDR. '.number_format($value['harga']);
                    $table_html .= '</td>';
                    $table_html .= '<td>';
                        $table_html .= $value['jenjang'];
                    $table_html .= '</td>';
                    $table_html .= '<td>';
                    $r="'";
                    $kodebuk=$r."".$value['kode_buku']."".$r;
                        $table_html .= '<button type="button" onClick="masukkan_buku('.$lapak_id.','.$kodebuk.')" id="btnmasukkanbuku_'.$value["kode_buku"].'" class="btn btn-info">Tambahkan buku ini</button>';
                    $table_html .= '</td>';
                $table_html .= '</tr>';                
            }
        }else{
            $table_html = '';
        }
        echo json_encode(array("status" => TRUE,"data_buku" => $table_html,"query" => $last_query));        
    }

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'password' => $this->input->post('password'),
				'created_on' => date('Y-m-d H:i:s',now()),
			);
		$this->lapak->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

    public function ajax_update_profile($id)
    {
        $this->_validate_profile();
        $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('telepon'),
            );
        $this->users->update(array('id' => $id), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update_password($id)
    {
        $this->_validate_password($id);
        $data = array(
                'password' => $this->ion_auth->hash_password($this->input->post('password_baru')),
            );
        $this->users->update(array('id' => $id), $data);
        echo json_encode(array("status" => TRUE));
    }

    function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
        {
            //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id'   => 'new',
                'type' => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id'   => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );

            //render
            $this->_render_page('lapak/change_password', $this->data);
        }
        else
        {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('lapak/change_password', 'refresh');
            }
        }
    }

	public function ajax_delete($id)
	{
		$data = array(
				'is_deleted' => 1,
                'delete_date' => date('Y-m-d H:i:s',now()),
                'delete_user_id' => $this->session->userdata('user_id')
			);
		$this->lapak->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

    public function ajax_delete_lapak_buku($lapak_id = NULL,$id = NULL)
    {
        //die('here');
        $data = array(
                'is_deleted' => 1,
                'delete_date' => date('Y-m-d H:i:s',now()),
                'delete_user_id' => $this->session->userdata('user_id')
            );
        $this->lapak->update_lapak_buku(array('id' => $id), $data);
        //if($this->lapak->update_lapak_buku(array('id' => $id), $data)){
            $get_lapak_buku = GetLapakBuku($lapak_id);
            $html_lapak_buku = "";
            if($get_lapak_buku->num_rows() > 0){
                $html_lapak_buku .= '<h3>BUKU</h3>';
                $html_lapak_buku .= '<table class="table">';
                foreach ($get_lapak_buku->result_array() as $key => $value) {
                    $html_lapak_buku .= '<tr>';    
                        $html_lapak_buku .= '<td>';    
                            //$html_lapak_buku .= '<img src="'.$value['cover'].'">';    
                            $html_lapak_buku .= '<img width="50" src="'.base_url().'uploads/cover/'.$value["cover"].'">';    
                        $html_lapak_buku .= '</td>';
                        $html_lapak_buku .= '<td>';
                            $html_lapak_buku .= $value['judul'].'<br/>IDR. '.number_format($value['harga']);            
                        $html_lapak_buku .= '</td>';
                        $html_lapak_buku .= '<td>';
                            $html_lapak_buku .= $value['jenjang'];            
                        $html_lapak_buku .= '</td>'; 
                        $html_lapak_buku .= '<td>';
                            $html_lapak_buku .= '<button type="button" class="btn btn-danger" onClick="delete_lapak_buku('.$lapak_id.','.$value['id'].')"><i class="fa fa-trash"></i></button>';            
                        $html_lapak_buku .= '</td>';    
                    $html_lapak_buku .= '</tr>'; 
                }   
                $html_lapak_buku .= '</table>';
            }else{
                $html_lapak_buku .= '<h3>Buku</h3>';
            }        
            echo json_encode(array("status" => TRUE, "data_lapak_buku" => $html_lapak_buku));
        //}
        //echo json_encode(array("status" => TRUE));
    }

    public function ajax_masukkan_buku($lapak_id,$buku_id)
    {
        //die('here');
        $data = array(
                'lapak_id' => $lapak_id,
                'kode_buku' => $buku_id,
                'create_date' => date('Y-m-d H:i:s',now()),
                'create_user_id' => $this->session->userdata('user_id'),
            );
        $this->lapak->masukkan_buku($data);
        
        $get_lapak_buku = GetLapakBuku($lapak_id);
        $html_lapak_buku = "";
        if($get_lapak_buku->num_rows() > 0){
            $html_lapak_buku .= '<h3>BUKU</h3>';
            $html_lapak_buku .= '<table class="table">';
            foreach ($get_lapak_buku->result_array() as $key => $value) {
                $html_lapak_buku .= '<tr>';    
                    $html_lapak_buku .= '<td>';    
                        //$html_lapak_buku .= '<img src="'.$value['cover'].'">';    
                        $html_lapak_buku .= '<img width="50" src="'.base_url().'uploads/cover/'.$value["cover"].'">';    
                    $html_lapak_buku .= '</td>';
                    $html_lapak_buku .= '<td>';
                        $html_lapak_buku .= $value['judul'].'<br/>IDR. '.number_format($value['harga']);            
                    $html_lapak_buku .= '</td>';
                    $html_lapak_buku .= '<td>';
                        $html_lapak_buku .= $value['jenjang'];            
                    $html_lapak_buku .= '</td>'; 
                    $html_lapak_buku .= '<td>';
                        $html_lapak_buku .= '<button type="button" class="btn btn-danger" onClick="delete_lapak_buku('.$lapak_id.','.$value['id'].')"><i class="fa fa-trash"></i></button>';            
                    $html_lapak_buku .= '</td>';    
                $html_lapak_buku .= '</tr>'; 
            }   
            $html_lapak_buku .= '</table>';
        }else{
            $html_lapak_buku .= '<h3>Tidak Ada Buku</h3>';
        }        
        echo json_encode(array("status" => TRUE, "data_lapak_buku" => $html_lapak_buku));
    }

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('name') == '')
		{
			$data['inputerror'][] = 'name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('description') == '')
		{
			$data['inputerror'][] = 'description';
			$data['error_string'][] = 'description is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private function _validate_agen()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('first_name') == '')
		{
			$data['inputerror'][] = 'first_name';
			$data['error_string'][] = 'Name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}

		/*if($this->input->post('confirm_password') == '')
		{
			$data['inputerror'][] = 'confirm_password';
			$data['error_string'][] = 'Password confirmation is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') != $this->input->post('confirm_password'))
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Password not match';
			$data['status'] = FALSE;
		}*/

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

    private function _validate_profile()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('username') == '')
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username wajib diisi';
            $data['status'] = FALSE;
        }

        if($this->input->post('email') == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email wajib diisi';
            $data['status'] = FALSE;
        }

        if($this->input->post('telepon') == '')
        {
            $data['inputerror'][] = 'telepon';
            $data['error_string'][] = 'Telepon wajib diisi';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_password($id)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $filter = array('id'=>'where/'.$id);
        $query = GetAll('users',$filter);
        if($query->num_rows() > 0)
        {
            $value = $query->row_array();
            $password = $value['password'];
        }

        if($this->input->post('password_lama') == '')
        {
            $data['inputerror'][] = 'password_lama';
            $data['error_string'][] = 'Password lama wajib diisi';
            $data['status'] = FALSE;
        }

        if($this->ion_auth->hash_password($this->input->post('password_lama')) != $password)
        {
            $data['inputerror'][] = 'password_lama';
            $data['error_string'][] = $this->ion_auth->hash_password($this->input->post('password_lama')) .' != '. $password;
            $data['status'] = FALSE;
        }

        if($this->input->post('password_baru') == '')
        {
            $data['inputerror'][] = 'password_baru';
            $data['error_string'][] = 'Password baru wajib diisi';
            $data['status'] = FALSE;
        }

        if($this->input->post('password_baru_confirm') == '')
        {
            $data['inputerror'][] = 'password_baru_confirm';
            $data['error_string'][] = 'Password baru (sekali lagi) wajib diisi';
            $data['status'] = FALSE;
        }

        if($this->input->post('password_baru') != $this->input->post('password_baru_confirm'))
        {
            $data['inputerror'][] = 'password_baru';
            $data['error_string'][] = 'Password baru tidak sama';
            $data['status'] = FALSE;
        }

        /*if($this->input->post('first_name') == '')
        {
            $data['inputerror'][] = 'first_name';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('confirm_password') == '')
        {
            $data['inputerror'][] = 'confirm_password';
            $data['error_string'][] = 'Password confirmation is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') != $this->input->post('confirm_password'))
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password not match';
            $data['status'] = FALSE;
        }*/

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_sekolah()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('title') == '')
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'Nama sekolah is required';
            $data['status'] = FALSE;
        }

        /*if($this->input->post('first_name') == '')
        {
            $data['inputerror'][] = 'first_name';
            $data['error_string'][] = 'Name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('confirm_password') == '')
        {
            $data['inputerror'][] = 'confirm_password';
            $data['error_string'][] = 'Password confirmation is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') != $this->input->post('confirm_password'))
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password not match';
            $data['status'] = FALSE;
        }*/

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

        function export_excel(){
        $this->data['controller_name'] = 'lapak';

        $this->data['area']=select_all('area');
        $this->_render_page('lapak/export_excel', $this->data);
    }

    function export(){
         $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $sales=$this->input->post('sales');
        $kodelapak=$this->input->post('kode_lapak');
        $active=$this->input->post('active');
        if($sales==''){
            $qusername='';
        }else{
            $qusername=" and users.username='".$sales."'";
        }
        if($kodelapak==''){
            $qkodelapak='';
        }else{
            $qkodelapak=" and lapak.lapak_code='".$kodelapak."'";
        }
        if($active==''){
            $qactive='';
        }else{
            $qactive=" and lapak.active='".$active."'";
        }
        $query=$this->db->query("SELECT users.username as nama_sales, lapak.title, lapak.lapak_code, lapak.start_active, lapak.end_active, propinsi.title as propinsi, kabupaten.title as kabupaten, sekolah.title as sekolah, agen.username as agen, lapak.agen_disc, lapak.buyer_disc, lapak.notes, lapak.active FROM lapak INNER JOIN propinsi on propinsi.propinsi_id=lapak.propinsi_id INNER JOIN users on users.id=lapak.sales_id INNER JOIN users as agen on agen.id=lapak.agen_id INNER JOIN kabupaten on kabupaten.kabupaten_id=lapak.kabupaten_id INNER JOIN sekolah on sekolah.id=lapak.sekolah_id where lapak.is_deleted='0'".$qusername."".$qkodelapak."".$qactive);
        $delimiter = ",";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Lapak.csv', $data);
    }


    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

            $this->template->add_css('datatables/css/dataTables.bootstrap.css');
            $this->template->add_css('bootstrap-datepicker/css/datepicker.css');
            $this->template->add_js('datatables/js/jquery.dataTables.min.js');
            $this->template->add_js('datatables/js/dataTables.bootstrap.js');
            $this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
            $this->template->add_js('lapak.js');

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

}
