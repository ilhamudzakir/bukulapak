<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenjang extends MX_Controller {

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
            $this->data['controller_name'] = 'jenjang';

            $this->_render_page('jenjang/index', $this->data);
        }
        else
        {
            return show_error('You must be an administrator to view this page.');
        }
    }


    public function detail($id=0)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        $this->data['controller_name'] = 'jenjang';
        if($id==0){
          $this->data['static']='null';
        }else{
        $this->data['static']=$this->db->query("select * from static_page where id='".$id."'")->row();
        }

        $this->_render_page('jenjang/detail', $this->data);
      
    }

   

    
    public function ajax_admin_list()
    {   
        //$area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        
        $list = $this->db->query("select * from jenjang_buku where is_deleted='0'")->result();
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $static) {
            $no++;
            $row = array();
            $row[] = $static->title;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('jenjang/detail/'.$static->id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a> <a class="btn btn-sm btn-danger" href="'.site_url('jenjang/delete/'.$static->id).'" title="Delete">Delete</a>';
    
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->db->query("select * from jenjang_buku where is_deleted='0'")->num_rows(),
                        "recordsFiltered" => $this->db->query("select * from jenjang_buku where is_deleted='0'")->num_rows(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

       
    
    function _render_page($view, $data=null, $render=false)
    {
        $data = (empty($data)) ? $this->data : $data;
        if ( ! $render)
        {
            $this->load->library('template');

            if(in_array($view, array('jenjang/index')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('jenjang.js');
            }

           

             if(in_array($view, array('jenjang/detail')))
            {
                //$this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                //$this->template->add_js('datatables/js/jquery.dataTables.min.js');
                //$this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_css('editor.css');
                $this->template->add_js('editor.js');
                $this->template->add_js('static_detail.js');
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
    function update(){
        $id=$this->input->post('id');
        $data=array(
            'title'=>$this->input->post('title'),
            'modify_date'=>date('Y-m-d H:i:s'),
            'modify_user_id'=>$this->session->userdata('user_id'),
            );
        $update=$this->db->update('jenjang_buku', $data, array('id' => $id));
        if($update){
        $this->session->set_flashdata('message_success','Data telah diperbarui');
        redirect('jenjang/detail/'.$id);
        }else{
        $this->session->set_flashdata('message_success','Data gagal diperbarui');
         redirect('jenjang/detail/'.$id);
        }

    }

     function add(){
        $data=array(
            'title'=>$this->input->post('title'),
            'create_date'=>date('Y-m-d H:i:s'),
            'create_user_id'=>$this->session->userdata('user_id'),
            );
        $insert=$this->db->insert('jenjang_buku', $data);
        if($insert){
        $this->session->set_flashdata('message_success','Data telah diperbarui');
        redirect('jenjang/');
        }else{
        $this->session->set_flashdata('message_success','Data gagal diperbarui');
         redirect('jenjang/');
        }

    }

    function delete($id){
        $data=array(
            'is_deleted'=>1,
            'delete_date'=>date('Y-m-d H:i:s'),
            'delete_user_id'=>$this->session->userdata('user_id'),
            );
        $update=$this->db->update('jenjang_buku', $data, array('id' => $id));
        if($update){
        $this->session->set_flashdata('message_success','Data telah dihapus');
        redirect('jenjang');
        }else{
        $this->session->set_flashdata('message_success','Data gagal dihapus');
         redirect('jenjang');
        }

    }

       

}
