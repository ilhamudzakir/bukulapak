<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employe extends MX_Controller {

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

		$this->load->model('employe_model','employe');

		$this->data['hide_sidebar'] = "";
	}

	public function index()
	{
		if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin())
        {
            return show_error('You must be an administrator to view this page.');
        }
        else
        {
			$this->data['controller_name'] = 'employe';

			$this->_render_page('employe/employe_view', $this->data);
        }
	}

	public function ajax_list()
	{
		$list = $this->employe->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $employe) {
			$no++;
			$row = array();
			$row[] = $employe->nik;
			$row[] = $employe->email;
			$row[] = $employe->first_name;
			$row[] = $employe->last_name;
			$row[] = $employe->phone;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_employe('."'".$employe->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void()" title="Edit" onclick="deleted('.$employe->id.')"><i class="glyphicon glyphicon-erase"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->employe->count_all(),
						"recordsFiltered" => $this->employe->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function upload()
    {
        /*if ($this->form_validation->run() == TRUE)
        {*/
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
						//$values .= $value1['B'].'<br/>';
						$data = array(
				                'nik'    => $value1['A'],
				                'email'    => $value1['B'],
				                'first_name'    => $value1['C'],
				                'last_name'    => $value1['D'],
				                'phone'    => $value1['E'],
				                
				            );
							$this->employe->add($data);
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
		$data = $this->employe->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nik' => $this->input->post('nik'),
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
			);
		$this->db->insert('employe',$data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		//$this->_validate();
		

        $data = array(
				'nik' => $this->input->post('nik'),
				'email' => $this->input->post('email'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'phone' => $this->input->post('phone'),
			);
		$this->employe->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->db->query("DELETE FROM employe WHERE id = '".$id."' ");
		echo json_encode(array("status" => TRUE));
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
		}

		if($this->input->post('description') == '')
		{
			$data['inputerror'][] = 'description';
			$data['error_string'][] = 'description is required';
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

    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

            $this->template->add_css('datatables/css/dataTables.bootstrap.css');
            $this->template->add_js('datatables/js/jquery.dataTables.min.js');
            $this->template->add_js('datatables/js/dataTables.bootstrap.js');
            $this->template->add_js('bootstrap-wysihtml5/wysihtml5-0.3.0.js');
            $this->template->add_js('bootstrap-wysihtml5/bootstrap-wysihtml5.js');
	        $this->template->add_js('dataemploye.js');

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
