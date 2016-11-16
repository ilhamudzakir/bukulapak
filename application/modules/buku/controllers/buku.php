<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends MX_Controller {

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

		$this->load->model('databuku_model','buku');

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
			$this->data['controller_name'] = 'buku';

			$this->_render_page('buku/buku_view', $this->data);
        }
	}

	public function ajax_list()
	{
		$list = $this->buku->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $buku) {
			if($buku->publish=='1'){$publish="Publish";}else{ $publish="Not Publish";}
			$no++;
			$row = array();
			$row[]="<input type='checkbox' value='".$buku->kode_buku."' name='check[]' id='check'/>";
			$row[] = '<img src="'.base_url().'uploads/cover/'.$buku->cover.'" style="width: 100px;"> ';
			$row[] = $buku->kode_buku;
			$row[] = $buku->judul;
			$row[] = $buku->jenjang;
			$row[] = $buku->pengarang;
			$row[] = $buku->harga;
			$row[] = $publish;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_buku('."'".$buku->kode_buku."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->buku->count_all(),
						"recordsFiltered" => $this->buku->count_filtered(),
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
					$no=1;
					foreach ($arr_data as $key1 => $value1) {
						//$values .= $value1['B'].'<br/>';
					$no++;
					$bukunya=select_where('buku','kode_buku',$value1['B'])->num_rows();
						$data = array(
				                'thn_katalog'    => $value1['A'],
				                'kode_buku'    =>  $value1['B'],
				                'isbn'    =>  $value1['C'],
				                'judul'    =>  $value1['D'],
				                'pengarang'    =>  $value1['E'],
				                'sinopsis'    =>  $value1['F'],
				                'sinopsis_html'    =>  $value1['G'],
				                'lebar'    =>  $value1['H'],
				                'tinggi'    =>  $value1['I'],
				                'warna'    =>  $value1['J'],
				                'berat'    =>  $value1['K'],
				                'tebal'    =>  $value1['L'],
				                'jml_halaman'    =>  $value1['M'],
				                'thn_terbit'    =>  $value1['N'],
				                'harga'    =>  $value1['O'],
				                'kertas'    =>  $value1['P'],
				                'jenjang'    =>  $value1['Q'],
				                'bstudi'    =>  $value1['R'],
				                'cover'    =>  $value1['S'],
				                'tgl_terbit'    =>  $value1['T'],
				                'brandname'    =>  $value1['U'],
				            );
						if($bukunya>0){
							$this->buku->update(array('kode_buku' => $value1['B']), $data);
						}else{
							$this->buku->add($data);
						}
					}
						//foreach ($value1 as $key2 => $value2) {
							
							 /*$data = array(
				                'thn_katalog'    => $value2['A'],
				                'kode_buku'    =>  $value2['B'],
				                'isbn'    =>  $value2['C'],
				                'judul'    =>  $value2['D'],
				                'pengarang'    =>  $value2['E'],
				                'sinopsis'    =>  $value2['F'],
				                'sinopsis_html'    =>  $value2['G'],
				                'lebar'    =>  $value2['H'],
				                'tinggi'    =>  $value2['I'],
				                'warna'    =>  $value2['J'],
				                'berat'    =>  $value2['K'],
				                'tebal'    =>  $value2['L'],
				                'jml_halaman'    =>  $value2['M'],
				                'thn_terbit'    =>  $value2['N'],
				                'harga'    =>  $value2['O'],
				                'kertas'    =>  $value2['P'],
				                'jenjang'    =>  $value2['Q'],
				                'bstudi'    =>  $value2['R'],
				                'cover'    =>  $value2['S'],
				                'tgl_terbit'    =>  $value2['T'],
				                'brandname'    =>  $value2['U'],
				            );
							$this->buku->add($data);*/
						//}
					//die('value. = '. $values);
					//send the data in an array format
					//$data['header'] = $header;
					//$data['values'] = $arr_data;

                	echo json_encode(array('nonya'=>$no,'status'=>TRUE,'validation_errors'=>'<div class="alert alert-success">Upload file Success</div>'));
                }else{
                	echo json_encode(array('nonya'=>$no,'status'=>FALSE,'validation_errors'=>'<div class="alert alert-success">Upload file failed</div>'));
                }


            }else{
                $fileName = "";
                echo json_encode(array('status'=>FALSE,'validation_errors'=>'<div class="alert alert-success">Please input file</div>'));
            }

           /* $data = array(
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

            $this->order_history->add(array('order_id'=>$order_id,'order_status_id'=>2,'create_date'=>date('Y-m-d H:i:s',now())));*/


            //echo "success";
            //echo json_encode(array('validation_errors'=>'<div class="alert alert-success">Success</div>'));
            
        /*}else{
            echo json_encode(array('validation_errors'=>validation_errors('<div class="alert alert-error">', '</div>')));
        }*/

        
    }

	public function ajax_edit($id)
	{
		$data = $this->buku->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		//$this->_validate();
		$attachment_file=$_FILES["upload_file2"];
        if($attachment_file) 
        {
            $output_dir = "uploads/cover/";
            $fileName = strtolower($_FILES["upload_file2"]["name"]);
            move_uploaded_file($_FILES["upload_file2"]["tmp_name"],$output_dir.$fileName);
            //echo "File uploaded successfully";
        }else{
            $fileName = $this->input->post('cover');  
        }

        $data = array(
				'thn_katalog' => $this->input->post('thn_katalog'),
				'isbn' => $this->input->post('isbn'),
				'judul' => $this->input->post('judul'),
				'pengarang' => $this->input->post('pengarang'),
				'sinopsis' => $this->input->post('sinopsis'),
				'sinopsis_html' => $this->input->post('sinopsis_html'),
				'lebar' => $this->input->post('lebar'),
				'tinggi' => $this->input->post('tinggi'),
				'warna' => $this->input->post('warna'),
				'berat' => $this->input->post('berat'),
				'tebal' => $this->input->post('tebal'),
				'jml_halaman' => $this->input->post('jml_halaman'),
				'thn_terbit' => $this->input->post('thn_terbit'),
				'harga' => $this->input->post('harga'),
				'kertas' => $this->input->post('kertas'),
				'jenjang' => $this->input->post('jenjang'),
				'bstudi' => $this->input->post('bstudi'),
				'cover' => $fileName,
				'tgl_terbit' => $this->input->post('tgl_terbit'),
				'brandname' => $this->input->post('brandname'),
			);
        $this->db->insert('buku',$data);
		
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		//$this->_validate();
		$attachment_file=$_FILES["upload_file2"];
        if($attachment_file) 
        {
            $output_dir = "uploads/cover/";
            $fileName = strtolower($_FILES["upload_file2"]["name"]);
            move_uploaded_file($_FILES["upload_file2"]["tmp_name"],$output_dir.$fileName);
            //echo "File uploaded successfully";
        }else{
            $fileName = $this->input->post('cover');  
        }

        $data = array(
				'thn_katalog' => $this->input->post('thn_katalog'),
				'isbn' => $this->input->post('isbn'),
				'judul' => $this->input->post('judul'),
				'pengarang' => $this->input->post('pengarang'),
				'sinopsis' => $this->input->post('sinopsis'),
				'sinopsis_html' => $this->input->post('sinopsis_html'),
				'lebar' => $this->input->post('lebar'),
				'tinggi' => $this->input->post('tinggi'),
				'warna' => $this->input->post('warna'),
				'berat' => $this->input->post('berat'),
				'tebal' => $this->input->post('tebal'),
				'jml_halaman' => $this->input->post('jml_halaman'),
				'thn_terbit' => $this->input->post('thn_terbit'),
				'harga' => $this->input->post('harga'),
				'kertas' => $this->input->post('kertas'),
				'jenjang' => $this->input->post('jenjang'),
				'bstudi' => $this->input->post('bstudi'),
				'cover' => $fileName,
				'tgl_terbit' => $this->input->post('tgl_terbit'),
				'brandname' => $this->input->post('brandname'),
			);
        
		$this->buku->update(array('kode_buku' => $this->input->post('kode_buku')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$data = array(
				'is_deleted' => 1
			);
		$this->groups->update(array('id' => $id), $data);
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
            $this->template->add_js('databuku.js');

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
    function change_publish(){
    	$id=$this->input->post('id');
    	$data=array(
    		'publish'=>$this->input->post('publish'),
    	);
    	foreach ($id as $id) {
    	$this->db->update('buku', $data, "kode_buku = $id");
    	}
    }
}
