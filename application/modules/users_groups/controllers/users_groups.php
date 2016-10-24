<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users_groups extends MX_Controller {

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('authentication', NULL, 'ion_auth');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->helper('url');

        $this->config->load('ion_auth', TRUE);

        $this->load->database();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');

		$this->load->model('users_groups_model','users_groups');

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
        	redirect('users_groups/sales_area', 'refresh');
        }
	}

	public function admin()
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
			$this->data['controller_name'] = 'users_groups';

			$this->_render_page('users_groups/admin', $this->data);
        }
	}

	public function sales()
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
			$this->data['controller_name'] = 'users_groups';

			$this->_render_page('users_groups/sales', $this->data);
        }
	}

	public function agen()
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
			$this->data['controller_name'] = 'users_groups';

			$this->_render_page('users_groups/agen', $this->data);
        }
	}

    public function sales_area()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin_area())
        {
            return show_error('You must be an area administrator to view this page.');
        }
        else
        {
            $this->data['controller_name'] = 'users_groups';

            $this->_render_page('users_groups/sales_area', $this->data);
        }
    }

    public function area_ajax_list($id=3)
    {
        $area_id = $this->session->userdata('area_id');
        $list = $this->users_groups->get_area_datatables($id,$area_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $users_groups) {
            $no++;
            $row = array();
            //$row[] = $users_groups->id;
            //$row[] = $users_groups->area_id;
            //$row[] = $users_groups->user_id;
            /*$row[] = $users_groups->username.'here';
            $row[] = $users_groups->group_name;
            $active_label = ($users_groups->active == 1) ? anchor("users_groups/deactivate/".$users_groups->user_id."/5/sales_area", lang('index_active_link')) : anchor("users_groups/activate/". $users_groups->user_id."/5", lang('index_inactive_link'));
            $row[] = $active_label;
            
            $row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('users_groups/edit_user/'.$users_groups->user_id.'/'.$users_groups->group_id).'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            */
            $active_label = ($users_groups->active == 1) ? anchor("users_groups/deactivate/".$users_groups->user_id."/5/sales_area", lang('index_active_link')) : anchor("users_groups/activate/". $users_groups->user_id."/5", lang('index_inactive_link'));
            $action_label = '<a class="btn btn-sm btn-primary" href="'.site_url('users_groups/edit_user/'.$users_groups->user_id.'/'.$users_groups->group_id).'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i></a>';
            $row[] =    '<div class="row">'.
                            '<div class="col-md-12">'.
                            '<h4><a href="'.site_url('users_groups/edit_user/'.$users_groups->user_id.'/'.$users_groups->group_id).'">'.$users_groups->nik.' - '.strtoupper($users_groups->username).'</a></h4>'.
                                '<div class="row">'.
                                    '<div class="col-md-6">'.
                                        '<ul class="">'.
                                            '<li class=""><label>Email : '.$users_groups->email.'</label></li>'.
                                            '<li class=""><label>First name : '.$users_groups->first_name.'</label></li>'.
                                            '<li class=""><label>Last name : '.$users_groups->last_name.'</label></li>'.
                                        '</ul>'.
                                    '</div>'.
                                    '<div class="col-md-6">'.
                                        '<ul class="">'.
                                            '<li class=""><label>Phone : '.$users_groups->phone.'</label></li>'.
                                            '<li class=""><label>Active : '.$active_label.'</label></li>'.
                                            /*'<li class=""><label>Action : '.$action_label.'</label></li>'.*/
                                        '</ul>'.
                                    '</div>'.
                                '</div>'.
                            '</div>'.
                        '</div>';
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->users_groups->count_filter($id),
                        "recordsFiltered" => $this->users_groups->count_filter($id),
                        "data" => $data,
                );
        echo json_encode($output);
    }

	public function ajax_list($id=1)
	{
		$list = $this->users_groups->get_datatables($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $users_groups) {
			$no++;
			$row = array();
			$row[] = $users_groups->id;
			$row[] = $users_groups->user_id;
			$row[] = $users_groups->username;
			$row[] = $users_groups->group_name;
			$active_label = ($users_groups->active == 1) ? anchor("users_groups/deactivate/".$users_groups->user_id."/".$users_groups->group_id, lang('index_active_link')) : anchor("users_groups/activate/". $users_groups->user_id."/".$users_groups->group_id, lang('index_inactive_link'));
            $row[] = $active_label;
			$row[] = '<a class="btn btn-sm btn-primary" href="'.site_url('users_groups/edit_user/'.$users_groups->user_id.'/'.$users_groups->group_id).'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->users_groups->count_all(),
						"recordsFiltered" => $this->users_groups->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	function create_user()
    {
        $this->data['title'] = "Create User";

        if (!$this->ion_auth->logged_in() || $this->ion_auth->is_agen() || $this->ion_auth->is_sales())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');

        //validate form input
        $this->form_validation->set_rules('nik', $this->lang->line('create_user_validation_nik_label'), 'required|xss_clean');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique['.$tables['users'].'.email]');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|xss_clean');
        //$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required|xss_clean');
        //$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        //$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');

        if ($this->form_validation->run() == true)
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email    = strtolower($this->input->post('email'));
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'nik'  => $this->input->post('nik'),
                'area_id'  => $this->session->userdata('area_id'),
                'phone'      => $this->input->post('phone'),
                //'active' => 1
                //'company'    => $this->input->post('company'),
                //'phone'      => $this->input->post('phone'),
            );

            $group = array('group_id' => $this->input->post('group_id'));
        
            $insert_id = $this->ion_auth->register($username, $password, $email, $additional_data,$group);
            //check to see if we are creating the user
            //redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());

            /*kirim email buat user sales*/
            $config1['wordwrap'] = TRUE;
            $config1['mailtype'] = 'html';
        
            $this->email->initialize($config1);
            $this->email->from($this->config->item('admin_email', 'ion_auth'));
            $this->email->to($email);
            $this->email->subject('Informasi login sebagai sales di bukusekolahku.com ');
            $this->email->message('Hello '.$username.',<br/><br/>
                Berikut adalah informasi login sebagai sales di bukusekolahku.com :<br/><br/>
                username : '.$username.'<br/>
                email : '.$email.'<br/>
                password : '.$password.'<br/><br/>
                Simpan informasi ini dengan baik. lakukanlah perubahan password secara berkala.<br/><br/>
                Terima kasih<br/>
                Salam
                ');
            
            if($this->config->item('sending_email', 'ion_auth') == TRUE){
                $this->email->send();    
            }
            

            $this->activate($insert_id);
        }
        else
        {
            //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['nik'] = array(
                'name'  => 'nik',
                'id'    => 'nik',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('nik'),
            );

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );

            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            
            $group_id = 3;
            
            $this->data['group_id'] = array(
                'name'  => 'group_id',
                'id'    => 'group_id',
                'type'  => 'hidden',
                'value' => $group_id,
            );

            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'text',
                'readonly' => TRUE,
                'value' => $this->form_validation->set_value('password'),
            );

            /*$this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );*/

            $this->data['gen_password'] = array(
                'name'  => 'gen_password',
                'id'    => 'gen_password',
            );

            $this->_render_page('users_groups/create_user', $this->data);
        }
    }

    //activate the user
    function activate($id)
    {
        
        if ($this->ion_auth->is_admin() || $this->ion_auth->is_admin_area())
        {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation)
        {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            //redirect("auth", 'refresh');
            if(strlen($this->uri->segment(4)) > 0){
            	if($this->uri->segment(4) == 1){
            		$red_url = "users_groups/admin";
            	}elseif ($this->uri->segment(4) == 3) {
            		$red_url = "users_groups/sales";
            	}elseif ($this->uri->segment(4) == 4) {
            		$red_url = "users_groups/agen";
            	}elseif ($this->uri->segment(4) == 5) {
                    $red_url = "users_groups/sales_area";
                }else{
            		$red_url = "users_groups/admin";
            	}
            }else{
            	$red_url = "users_groups/sales_area";
            }

            redirect($red_url, 'refresh');
        }
        else
        {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL)
    {
        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE)
        {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->_render_page('users_groups/deactivate_user', $this->data);
        }
        else
        {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes')
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
                {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin_area())
                {
                    $this->ion_auth->deactivate($id);
                }
            }

            //redirect them back to the auth page
            //redirect('auth', 'refresh');
            if(strlen($this->uri->segment(4)) > 0){
            	if($this->uri->segment(4) == 1){
            		$red_url = "users_groups/admin";
            	}elseif ($this->uri->segment(4) == 3) {
                    if($this->uri->segment(5) == 'sales_area'){
                        $red_url = "users_groups/sales_area";
                    }else{
                        $red_url = "users_groups/sales";    
                    }
            		
            	}elseif ($this->uri->segment(4) == 4) {
            		$red_url = "users_groups/agen";
            	}elseif ($this->uri->segment(4) == 5) {
                    $red_url = "users_groups/sales_area";
                }else{
            		$red_url = "users_groups/admin";
            	}
            }else{
            	$red_url = "users_groups/admin";
            }

            redirect($red_url, 'refresh');
        }
    }

    //edit a user
    function edit_user($id,$id_group)
    {
        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin_area() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }

        $user = $this->ion_auth->user($id)->row();
        $groups=$this->ion_auth->where('is_deleted', 0)->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        //validate form input
        $this->form_validation->set_rules('nik', $this->lang->line('edit_user_validation_nik_label'), 'required|xss_clean');
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'valid_email|required|xss_clean');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required|xss_clean');
        //$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required|xss_clean');
        $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'xss_clean');

        if (isset($_POST) && !empty($_POST))
        {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }

            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email    = strtolower($this->input->post('email'));

            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'nik'  => $this->input->post('nik'),
                'email'    => $this->input->post('email'),
                'phone'      => $this->input->post('phone'),
            );

            // Only allow updating groups if user is admin
            if ($this->ion_auth->is_admin())
            {
                //Update the groups user belongs to
                $groupData = $this->input->post('groups');

                if (isset($groupData) && !empty($groupData)) {

                    $this->ion_auth->remove_from_group('', $id);

                    foreach ($groupData as $grp) {
                        $this->ion_auth->add_to_group($grp, $id);
                    }

                }
            }

            //update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
                //$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                //$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

                $data['password'] = $password_email = $this->input->post('password');
            }else{
                $password_email = '<i>[tidak ada perubahan password]</i>';
            }

            if ($this->form_validation->run() === TRUE)
            {
                $this->ion_auth->update($user->id, $data);

                //check to see if we are creating the user
                //redirect them back to the admin page
                $this->session->set_flashdata('message', "User Saved");

                /*kirim email buat user sales*/
                $config1['wordwrap'] = TRUE;
                $config1['mailtype'] = 'html';
            
                $this->email->initialize($config1);
                $this->email->from($this->config->item('admin_email', 'ion_auth'));
                $this->email->to($email);
                $this->email->subject('Informasi login sebagai sales di bukusekolahku.com ');
                $this->email->message('Hello '.$username.',<br/><br/>
                    Berikut adalah perubahan informasi login sebagai sales di bukusekolahku.com :<br/><br/>
                    username : '.$username.'<br/>
                    email : '.$email.'<br/>
                    password : '.$password_email.'<br/><br/>
                    Simpan informasi ini dengan baik. lakukanlah perubahan password secara berkala.<br/><br/>
                    Terima kasih<br/>
                    Salam
                    ');
                
                if($this->config->item('sending_email', 'ion_auth') == TRUE){
                    $this->email->send();    
                }

                if ($this->ion_auth->is_admin_area())
                {
                	if(strlen($this->uri->segment(4)) > 0)
                    {
		            	if($this->uri->segment(4) == 1){
		            		$red_url = "users_groups/admin";
		            	}elseif ($this->uri->segment(4) == 3) {
                            $red_url = "users_groups/sales_area"; 
		            		/*if($this->uri->segment(5) == 'sales_area'){
                                $red_url = "users_groups/sales_area";
                            }else{
                                $red_url = "users_groups/sales_area";    
                            }*/
		            	}elseif ($this->uri->segment(4) == 4) {
		            		$red_url = "users_groups/agen";
		            	}else{
		            		$red_url = "users_groups/admin";
		            	}
		            }else{
		            	$red_url = "users_groups/admin";
		            }

            		redirect($red_url, 'refresh');
                    //redirect('users_groups/sales_area', 'refresh');
                }
                else
                {
                    redirect('/', 'refresh');
                }
            }
        }

        //display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        //pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['nik'] = array(
            'name'  => 'nik',
            'id'    => 'nik',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->nik),
        );

        $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email', $user->email),
            );

        $this->data['first_name'] = array(
            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );

        $this->data['phone'] = array(
            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );

        $this->data['password'] = array(
            'name' => 'password',
            'id'   => 'password',
            'type' => 'text',
            //'disabled' => 'disabled'
        );
        /*$this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id'   => 'password_confirm',
            'type' => 'password'
        );*/

        $this->data['gen_password'] = array(
            'name'  => 'gen_password',
            'id'    => 'gen_password',
        );

        $this->_render_page('users_groups/edit_user', $this->data);
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

            if(in_array($view, array('users_groups/admin','users_groups/sales','users_groups/agen')))
            {
	            $this->template->add_css('datatables/css/dataTables.bootstrap.css');
	            $this->template->add_js('datatables/js/jquery.dataTables.min.js');
	            $this->template->add_js('datatables/js/dataTables.bootstrap.js');
	            $this->template->add_js('users_groups.js');
	        }

            if(in_array($view, array('users_groups/sales_area')))
            {
                $this->template->add_css('datatables/css/dataTables.bootstrap.css');
                $this->template->add_js('datatables/js/jquery.dataTables.min.js');
                $this->template->add_js('datatables/js/dataTables.bootstrap.js');
                $this->template->add_js('sales_area.js');
            }

            if(in_array($view, array('users_groups/create_user','users_groups/edit_user')))
            {
                //$this->template->add_css('datatables/css/dataTables.bootstrap.css');
                //$this->template->add_js('datatables/js/jquery.dataTables.min.js');
                //$this->template->add_js('datatables/js/dataTables.bootstrap.js');
                $this->template->add_js('input_sales_area.js');
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

}
