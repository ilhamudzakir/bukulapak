<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class Sales extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->controller_name='Sales';
		
	
	}
	
	public function index(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = '';
		$data['page'] = $this->load->view('sales-login',$data,true);
		$this->load->view('layout',$data);
	}

	public function dashboard(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Dashboard';
		$data['page'] = $this->load->view('dashboard',$data,true);
		$this->load->view('layout',$data);
	}
		public function Detail(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Detail Lapak';
		$data['page'] = $this->load->view('detail',$data,true);
		$this->load->view('layout',$data);
	}
			public function Edit(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Edit Lapak';
		$data['page'] = $this->load->view('edit',$data,true);
		$this->load->view('layout',$data);
	}
				public function Add(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Edit Lapak';
		$data['page'] = $this->load->view('add',$data,true);
		$this->load->view('layout',$data);
	}
		public function Add_book(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Edit Lapak';
		$data['page'] = $this->load->view('add-book',$data,true);
		$this->load->view('layout',$data);
	}
			public function Finish(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Edit Lapak';
		$data['page'] = $this->load->view('finish',$data,true);
		$this->load->view('layout',$data);
	}
				public function lapak(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Lapak Aktif';
		$data['page'] = $this->load->view('lapak',$data,true);
		$this->load->view('layout',$data);
	}

}

