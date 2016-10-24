<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class Agen extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->controller_name='Agen';
		
	
	}
	
	public function index(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = '';
		$data['page'] = $this->load->view('agen-login',$data,true);
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
		public function Edit_profile(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Edit Profile';
		$data['page'] = $this->load->view('edit-profile',$data,true);
		$this->load->view('layout',$data);
	}
		public function Edit_password(){
		$data='';
		$data['name'] = $this->controller_name;
		$data['function'] = 'Edit Password';
		$data['page'] = $this->load->view('change-password',$data,true);
		$this->load->view('layout',$data);
	}

}

