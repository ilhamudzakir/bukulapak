<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_shipping extends MX_Controller {

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

		$this->load->model('area_shipping_model','area_shipping');

		$this->data['hide_sidebar'] = "";
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin() and !$this->ion_auth->is_admin_area())
        {
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
			$this->data['controller_name'] = 'area_shipping';

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
	        $this->data['cost']=$this->db->get_where('config_ongkir', array('id' => 1))->row();

	        if($this->ion_auth->is_admin()){
			 $area = GetAll('area');
            if($area->num_rows() > 0){
                $this->data['area'] = $area->result_array();
            }else{
                $this->data['area'] = array();
            }
		}else{
			
			$id=$this->area_shipping->select_where('id',$this->session->userdata('user_id'))->row();
			$this->data['area']=$id;
		}

           


			$this->_render_page('area_shipping/area_shipping_view', $this->data);
        }
	}

	public function ajax_list()
	{
		$list = $this->area_shipping->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $area_shipping) {
			$no++;
			$row = array();
			if($this->ion_auth->is_admin()){
			$row[] = $area_shipping->area;
			}
			$row[] = $area_shipping->propinsi;
			$row[] = $area_shipping->kabupaten;
			$row[] = $area_shipping->reguler;
			$row[] = $area_shipping->ok;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_area_shipping('."'".$area_shipping->area_shipping_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_area_shipping('."'".$area_shipping->area_shipping_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->area_shipping->count_all(),
						"recordsFiltered" => $this->area_shipping->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function getkabupaten($propinsi_id)
	{
		$filter_kabupaten = array("propinsi_id"=>"where/".$propinsi_id,"title"=>"order/asc");
		$this->data['kabupaten'] = GetAll('kabupaten',$filter_kabupaten);

		$this->_render_page('area_shipping/getkabupaten', $this->data);
	}

	public function ajax_edit($id)
	{
		$data = $this->area_shipping->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		
			$area=$this->input->post('area_id');
		
		$data = array(
				'area_id' => $area,
				'propinsi_id' => $this->input->post('propinsi_id'),
				'kabupaten_id' => $this->input->post('kabupaten_id'),
				'reguler' => $this->input->post('reguler'),
				'ok' => $this->input->post('ok'),
				'create_date' => date('Y-m-d H:i:s',now()),
				'create_user_id' => $this->session->userdata('user_id'),
			);
		$insert = $this->area_shipping->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		if($this->ion_auth->is_admin()){
			$area=$this->input->post('area_id');
		}else{
			
			$id=$this->area_shipping->select_where('id',$this->session->userdata('user_id'))->row();
			$area=$id->area_id;
		}
		$data = array(
				'area_id' => $area,
				'propinsi_id' => $this->input->post('propinsi_id'),
				'kabupaten_id' => $this->input->post('kabupaten_id'),
				'reguler' => $this->input->post('reguler'),
				'ok' => $this->input->post('ok'),
				'create_date' => date('Y-m-d H:i:s',now()),
				'create_user_id' => $this->session->userdata('user_id'),
			);
		$this->area_shipping->update($this->input->post('id'), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$data = array(
				'is_deleted' => 1
			);
		$this->area_shipping->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		if($this->ion_auth->is_admin()){
		if($this->input->post('area_id') == '0')
		{
			$data['inputerror'][] = 'area_id';
			$data['error_string'][] = 'Area is required';
			$data['status'] = FALSE;
		}
		}

		if($this->input->post('propinsi_id') == '')
		{
			$data['inputerror'][] = 'propinsi_id';
			$data['error_string'][] = 'Propinsi is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('kabupaten_id') == '')
		{
			$data['inputerror'][] = 'kabupaten_id';
			$data['error_string'][] = 'kabupaten is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('reguler') == '')
		{
			$data['inputerror'][] = 'reguler';
			$data['error_string'][] = 'Harga Reguler is required';
			$data['status'] = FALSE;
		}
		if($this->input->post('ok') == '')
		{
			$data['inputerror'][] = 'ok';
			$data['error_string'][] = 'Harga Ok is required';
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
            $this->template->add_js('area_shipping.js');

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

    function update_cost_config(){
    $id=1;
    $data=array(
    	'free'=>$this->input->post('free'),
    	);
   	$this->db->where('id', $id);
	$query=$this->db->update('config_ongkir', $data);
    if($query){
    	$this->session->set_flashdata('status','ok');
    	$this->session->set_flashdata('msg','sukses');   	
    }else{
    	$this->session->set_flashdata('status','ok');
    	$this->session->set_flashdata('msg','failed');   	
    }
    	redirect('area_shipping');
    }

    	public function upload()
    {
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
					    if ($row == 1) {
					        $header[$row][$column] = $data_value;
					    } else {
					        $arr_data[$row][$column] = $data_value;
					    }
					}
					foreach ($arr_data as $key1 => $value1) {
						$kec=$this->area_shipping->where_like('kecamatan','title',$value1['D']);
						if($kec->num_rows>0){
							$sel_kec=$kec->row();
							$sel_kab=$this->area_shipping->where_like('kabupaten','kabupaten_id',$sel_kec->kabupaten_id)->row();
							$kecamatan_id=$sel_kec->kecamatan_id;
							$kabupaten_id=$sel_kab->kabupaten_id;
							$propinsi_id=$sel_kab->propinsi_id;
						}else{
							$kabupaten_id=$value1['C'];
							$propinsi_id= $value1['B'];
							$kecamatan_id=$value1['D'];
						}
						if($this->ion_auth->is_admin()){
							$area=$value1['A'];
						}else{
							$id=$this->area_shipping->select_where('id',$this->session->userdata('user_id'))->row();
							$area=$id->area_id;
						}
						$data = array(
				                'area_id'         => $area,
				                'propinsi_id'     => $propinsi_id,
				                'kabupaten_id'    => $kabupaten_id,
				                'kecamatan_id'    => $kecamatan_id,
				                'reguler'    	  => $value1['E'],
				                'ok'    	 	  => $value1['F'],
				                'etd_reg'    	  => $value1['G'],
				                'etd_ok'    	  => $value1['H'],
				            );
							$this->area_shipping->save($data);
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

        	public function upload_kecamatan()
    {
        $attachment_file=$_FILES["upload_files"];
            if($attachment_file) 
            {
                $output_dir = "uploads/";
                $fileName = strtolower($_FILES["upload_files"]["name"]);
                if(move_uploaded_file($_FILES["upload_files"]["tmp_name"],$output_dir.$fileName))
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
					    if ($row == 1) {
					        $header[$row][$column] = $data_value;
					    } else {
					        $arr_data[$row][$column] = $data_value;
					    }
					}
					foreach ($arr_data as $key1 => $value1) {
						$id_kec=str_replace('.','',$value1['B']);
						$id_kab=substr($id_kec,0,4);
						
						if(strlen($id_kec)==6){
						$data = array(
				                'kecamatan_id'    => $id_kec,
				                'title'     	  => $value1['C'],
				                'kabupaten_id'    => $id_kab,
				                'StatusSearch'    => 1,
				                );
							$this->db->insert("kecamatan", $data);
						}
					}
                	echo"<script>alert('sukses');</script>";
                	redirect('area_shipping');
                }else{
                	echo"error";
                }


            }else{
               echo"sukses";
            }

        
    }

}
