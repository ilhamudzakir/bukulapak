<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class Atasan extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->controller_name='Atasan';
		
	
	}
	
	public function index(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = '';
		$data['page'] = $this->load->view('login',$data,true);
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
			public function Lapak(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Lapak';
		$data['page'] = $this->load->view('short',$data,true);
		$this->load->view('layout',$data);
	}
			

}

