<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Static_page extends MX_Controller {

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
            $this->data['controller_name'] = 'static_page';

            $this->_render_page('static_page/index', $this->data);
        }
        else
        {
            return show_error('You must be an administrator to view this page.');
        }
    }

        public function change_background()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif($this->ion_auth->is_admin())
        {
            $this->data['controller_name'] = 'static_page';

            $this->_render_page('static_page/change_background', $this->data);
        }
        else
        {
            return show_error('You must be an administrator to view this page.');
        }
    }

    public function detail($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        $this->data['controller_name'] = 'static_page';

        $this->data['static']=$this->db->query("select * from static_page where id='".$id."'")->row();
        $this->_render_page('static_page/detail', $this->data);
      
    }

    public function detail_background($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        $this->data['controller_name'] = 'static_page';

        $this->data['static']=$this->db->query("select * from background where id='".$id."'")->row();
        $this->_render_page('static_page/detail_background', $this->data);
      
    }

    function upload()
    {
                $id=$this->input->post('id');
                $config['upload_path'] = './assets/front/images/';
                $config['allowed_types']        = 'gif|jpg|png';

                $this->load->library('upload', $config);
                if ( !  $this->upload->do_upload("user_file"))
                {
                        $error =  $this->upload->display_errors();

                        echo $error;
                }
                else
                {       
                     $upload_data = $this->upload->data();
           
            $file_name = $upload_data['file_name']; //Now you got the file name in the $file_name var. Use it to record in db.
            $data = array(
            'content'=> $file_name,
             );
            $this->db->update('background', $data, "id ='".$id."'");
            redirect('static_page/detail_background/'.$id);

                }
    }

    
    public function ajax_admin_list()
    {   
        //$area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        
        $list = $this->db->query('select * from static_page')->result();
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $static) {
            $no++;
            $row = array();
            $row[] = $static->title;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('static_page/detail/'.$static->id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
    
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->db->query('select * from static_page')->num_rows(),
                        "recordsFiltered" => $this->db->query('select * from static_page')->num_rows(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

        public function ajax_background_list()
    {   
        //$area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        
        $list = $this->db->query('select * from background')->result();
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $static) {
            $no++;
            $row = array();
            $row[] = $static->title;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('static_page/detail_background/'.$static->id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
    
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->db->query('select * from static_page')->num_rows(),
                        "recordsFiltered" => $this->db->query('select * from static_page')->num_rows(),
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

            if(in_array($view, array('static_page/index')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('static.js');
            }

            if(in_array($view, array('static_page/layout_email')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('layout_email.js');
            }
             if(in_array($view, array('static_page/notification')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('notification.js');
            }

               if(in_array($view, array('static_page/change_background')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_css('bootstrap-datepicker/css/datepicker.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                //$this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
                $this->template->add_js('change_background.js');
            }

             if(in_array($view, array('static_page/detail','static_page/layout_email_detail','notification')))
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
            'content'=>$this->input->post('content'),
            );
        $update=$this->db->update('static_page', $data, array('id' => $id));
        if($update){
        $this->session->set_flashdata('message_success','Data telah diperbarui');
        redirect('static_page/detail/'.$id);
        }else{
        $this->session->set_flashdata('message_success','Data gagal diperbarui');
         redirect('static_page/detail/'.$id);
        }

    }

        public function layout_email_detail($id)
    {   
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        $this->data['controller_name'] = 'static_page';

        $this->data['static']=select_where('email_order','id',$id)->row();
        $this->_render_page('static_page/layout_email_detail', $this->data);

            
      
    }
       public function layout_email()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif($this->ion_auth->is_admin())
        {
            $this->data['controller_name'] = 'static_page';

            $this->_render_page('static_page/layout_email', $this->data);
        }
        else
        {
            return show_error('You must be an administrator to view this page.');
        }
    }
    function layout_email_list()
    {   
       $id = $this->session->userdata('user_id');
        
        $list = $this->db->query('select * from email_order')->result();
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $static) {
            $no++;
            $row = array();
            $row[] = $static->title;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('static_page/layout_email_detail/'.$static->id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
    
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->db->query('select * from email_order')->num_rows(),
                        "recordsFiltered" => $this->db->query('select * from email_order')->num_rows(),
                        "data" => $data,
                );
        echo json_encode($output);

            
      
    }


    public function notification_detail($id)
    {   
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        $this->data['controller_name'] = 'static_page';

        $this->data['static']=select_where('notifications','id',$id)->row();
        $this->_render_page('static_page/notification_detail', $this->data);

            
      
    }
       public function notification()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif($this->ion_auth->is_admin())
        {
            $this->data['controller_name'] = 'static_page';

            $this->_render_page('static_page/notification', $this->data);
        }
        else
        {
            return show_error('You must be an administrator to view this page.');
        }
    }
    function notification_list()
    {   
       $id = $this->session->userdata('user_id');
        
        $list = $this->db->query('select * from notifications')->result();
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $static) {
            $no++;
            $row = array();
            $row[] = $static->title;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('static_page/notification_detail/'.$static->id).'" title="Detail"><i class="glyphicon glyphicon-pencil"></i> Detail</a>';
    
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->db->query('select * from notifications')->num_rows(),
                        "recordsFiltered" => $this->db->query('select * from notifications')->num_rows(),
                        "data" => $data,
                );
        echo json_encode($output);

            
      
    }

}
