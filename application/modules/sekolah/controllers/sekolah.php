<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","-1");
set_time_limit(0);

class Sekolah extends MX_Controller {

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

		$this->load->model('sekolah_model','sekolah');

		$this->data['hide_sidebar'] = "";
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin_area())
        {
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
			$this->data['controller_name'] = 'sekolah';
			$filter_propinsi = array("title"=>"order/asc");
			$propinsi = GetAll('propinsi',$filter_propinsi);
            if($propinsi->num_rows() > 0){
                $this->data['propinsi'] = $propinsi->result_array();
            }else{
                $this->data['propinsi'] = array();
            }

			$this->_render_page('sekolah/sekolah_view', $this->data);
        }
	}

	public function ajax_list()
	{	
		$list = $this->sekolah->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sekolah) {
			$no++;
			$row = array();
			$row[] = $sekolah->title;
			$row[] = $sekolah->jenjang;
			$row[] = $sekolah->propinsi;
			$row[] = $sekolah->kabupaten;
			$row[] = $sekolah->kecamatan;
			/*$row[] = $sekolah->description;*/
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_sekolah('."'".$sekolah->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_sekolah('."'".$sekolah->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sekolah->count_all(),
						"recordsFiltered" => $this->sekolah->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function getkabupaten($propinsi_id)
	{
		$filter_kabupaten = array("propinsi_id"=>"where/".$propinsi_id,"title"=>"order/asc");
		$this->data['kabupaten'] = GetAll('kabupaten',$filter_kabupaten);

		$this->_render_page('sekolah/getkabupaten', $this->data);
	}

	public function getkecamatan($kabupaten_id)
	{
		$filter_kecamatan = array("kabupaten_id"=>"where/".$kabupaten_id,"title"=>"order/asc");
		$this->data['kecamatan'] = GetAll('kecamatan',$filter_kecamatan);

		$this->_render_page('sekolah/getkecamatan', $this->data);
	}

	public function upload()
    {
        /*if ($this->form_validation->run() == TRUE)
        {*/	
        	$id=$this->sekolah->select_where_user('id',$this->session->userdata('user_id'))->row();
			$area=$id->area_id;
			$attachment_file=$_FILES["upload_file"];
            if($attachment_file) 
            {
                $output_dir = "uploads/";
                $fileName = strtolower($_FILES["upload_file"]["name"]);
                if(move_uploaded_file($_FILES["upload_file"]["tmp_name"],$output_dir.$fileName))
                {
                	$file = './uploads/'.$fileName;
					//load the excel library
					$this->load->library('excel');
					//read file from path
					$objPHPExcel = PHPExcel_IOFactory::load($file);
					//get only the Cell Collection
					$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
					//die('cell :'.print_mz($cell_collection));
					//extract to a PHP readable array format
					$values = "";
					$arr_data = array();
					foreach ($cell_collection as $cell) {
					    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
					    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
					    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
					    //header will/should be in row 1 only. of course this can be modified to suit your need.
					    /*if ($row == 1) {
					        $header[$row][$column] = $data_value;
					    } else {
					        $arr_data[$row][$column] = $data_value;
					    }*/
					    $arr_data[$row][$column] = $data_value;
					}
					foreach ($arr_data as $key1 => $value1) {
						$data = array(
				                'title'    => $value1['A'],
				                'npsn'    =>  $value1['B'],
				                'status'    =>  $value1['C'],
				                'jenjang'    =>  $value1['D'],
				                'alamat'    =>  $value1['E'],
				                'kecamatan_id'    =>  $value1['F'],
				                'kecamatan'    =>  $value1['G'],
				                'kabupaten_id'    =>  $value1['H'],
				                'kabupaten'    =>  $value1['I'],
				                'propinsi_id'    =>  $value1['J'],
				                'propinsi'    =>  $value1['K'],
				                'kls1'    =>  $value1['L'],
				                'kls2'    =>  $value1['M'],
				                'kls3'    =>  $value1['N'],
				                'kls4'    =>  $value1['O'],
				                'kls5'    =>  $value1['P'],
				                'kls6'    =>  $value1['Q'],
				                'kls7'    =>  $value1['R'],
				                'kls8'    =>  $value1['S'],
				                'kls9'    =>  $value1['T'],
				                'bos'    =>  $value1['U'],
				                'area_id'=> $area,
				            );
							$this->sekolah->add($data);
					}

                	echo json_encode(array('status'=>TRUE,'validation_errors'=>'<div class="alert alert-success">Upload file Success</div>'));
                }else{
                	echo json_encode(array('status'=>FALSE,'validation_errors'=>'<div class="alert alert-success">Upload file failed</div>'));
                }


            }else{
                $fileName = "";
                echo json_encode(array('status'=>FALSE,'validation_errors'=>'<div class="alert alert-success">Please input file</div>'));
            }
    }

	public function ajax_edit($id)
	{
		
		$data = $this->sekolah->get_by_id($id);
		$data->propinsi_eid = $data->propinsi_id;
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$id=$this->sekolah->select_where_user('id',$this->session->userdata('user_id'))->row();
		$area=$id->area_id;
		$data = array(
			'title' => $this->input->post('title'),
			'npsn' => $this->input->post('npsn'),
			'status' => $this->input->post('status'),
			'jenjang' => $this->input->post('jenjang'),
			'alamat' => $this->input->post('alamat'),
			'propinsi_id' => $this->input->post('propinsi_id'),
			'kabupaten_id' => $this->input->post('kabupaten_id'),
			'kecamatan_id' => $this->input->post('kecamatan_id'),
			'kls1' => $this->input->post('kls1'),
			'kls2' => $this->input->post('kls2'),
			'kls3' => $this->input->post('kls3'),
			'kls4' => $this->input->post('kls4'),
			'kls5' => $this->input->post('kls5'),
			'kls6' => $this->input->post('kls6'),
			'kls7' => $this->input->post('kls7'),
			'kls8' => $this->input->post('kls8'),
			'kls9' => $this->input->post('kls9'),
			'bos' => $this->input->post('bos'),
			'area_id'=>$area,
			'create_user_id' => $this->session->userdata('user_id'),
			'create_date' => date('d-m-y H:i:s',now()),
		);
		$insert = $this->sekolah->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
			'title' => $this->input->post('title'),
			'npsn' => $this->input->post('npsn'),
			'status' => $this->input->post('status'),
			'jenjang' => $this->input->post('jenjang'),
			'alamat' => $this->input->post('alamat'),
			'propinsi_id' => $this->input->post('propinsi_id'),
			'kabupaten_id' => $this->input->post('kabupaten_id'),
			'kecamatan_id' => $this->input->post('kecamatan_id'),
			'kls1' => $this->input->post('kls1'),
			'kls2' => $this->input->post('kls2'),
			'kls3' => $this->input->post('kls3'),
			'kls4' => $this->input->post('kls4'),
			'kls5' => $this->input->post('kls5'),
			'kls6' => $this->input->post('kls6'),
			'kls7' => $this->input->post('kls7'),
			'kls8' => $this->input->post('kls8'),
			'kls9' => $this->input->post('kls9'),
			'bos' => $this->input->post('bos'),
		);
		$this->sekolah->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$data = array(
				'is_deleted' => 1
			);
		$this->sekolah->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('title') == '')
		{
			$data['inputerror'][] = 'title';
			$data['error_string'][] = 'Title is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('status') == '')
		{
			$data['inputerror'][] = 'status';
			$data['error_string'][] = 'Status is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('jenjang') == '')
		{
			$data['inputerror'][] = 'jenjang';
			$data['error_string'][] = 'Jenjang is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('propinsi_id') == 0)
		{
			$data['inputerror'][] = 'propinsi_id';
			$data['error_string'][] = 'Propinsi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('kabupaten_id') == 0)
		{
			$data['inputerror'][] = 'kabupaten_id';
			$data['error_string'][] = 'Kabupaten is required';
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

            $this->template->add_css('datatables/css/dataTables.bootstrap.css');
            $this->template->add_js('datatables/js/jquery.dataTables.min.js');
            $this->template->add_js('datatables/js/dataTables.bootstrap.js');
            $this->template->add_js('sekolah.js');

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
