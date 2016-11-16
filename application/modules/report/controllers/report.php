<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MX_Controller {

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

        $this->load->model('lapak_model','lapak');
        $this->load->model('orders_model','orders');
        $this->load->model('order_history_model','order_history');
        $this->load->model('order_status_model','order_status');
        $this->load->model('items_model','items');
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
            $this->data['controller_name'] = 'order';

            $this->_render_page('order/index', $this->data);
        }
        elseif ($this->ion_auth->is_admin_area())
        {
            //die('here');
            $this->data['controller_name'] = 'order';

            $this->_render_page('order/index_admin_area', $this->data);
        }
        else
        {
        	return show_error('You must be an administrator or sales to view this page.');
        }
	}

    
    function transaksi()
    {
        //die('here');
        $this->data['title'] = "Report Transaksi";

        $this->data['controller_name'] = 'report';
        $this->data['start_active'] = array(
            'name'  => 'start',
            'id'    => 'dt1',
            'type'  => 'text',
            'placeholder' => 'Dari',
            
        );
        $this->data['end_active'] = array(
            'name'  => 'end',
            'id'    => 'dt2',
            'type'  => 'text',
            'placeholder' => 'Sampai',
            
        );

        $this->_render_page('report/transaksi_form', $this->data);
    }

    function transaksi_csv($froms,$to){
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $query = $this->orders->filter_transaksi($froms,$to);
        $delimiter = ",";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('Transaksi '.$froms.'-'.$to.'.csv', $data);
    }

     public function ajax_admin_transaksi($froms,$to)
    {   
        //$area_id = $this->session->userdata('area_id');
        $id = $this->session->userdata('user_id');
        $list = $this->orders->filter_transaksi($froms,$to)->result();

            
        $data = array();
        $no = $_POST['start'];
        $rec = "";
        foreach ($list as $order) {
            $no++;
            $row = array();

           

            $row[] = $order->order_code;
            $row[] = $order->order_name;
            $row[] = $order->order_email;
            $row[] = $order->order_phone;
            $row[] = $order->order_recipient_name;
            $row[] = $order->order_recipient_address;
            $row[] = $order->order_recipient_phone;
            $row[] = $order->order_propinsi;
            $row[] = $order->order_kabupaten;
            $row[] = $order->order_kecamatan;
            $row[] = $order->order_recipient_postcode;
            $row[] = $order->order_shipping_price;
            $row[] = $order->order_subtotal;
            $row[] = $order->order_total;
            $row[] = $order->order_date;
            $row[] = $order->order_confirm;
            $row[] = $order->order_date_confirm;
            $row[] = $order->status_order;
            $row[] = $order->area;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->orders->filter_transaksi($froms,$to)->num_rows(),
                        "recordsFiltered" => $this->orders->filter_transaksi($froms,$to)->num_rows(),
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

            $this->template->add_css('datatables/css/dataTables.bootstrap.css');
            $this->template->add_css('bootstrap-datepicker/css/datepicker.css');
            $this->template->add_js('datatables/js/jquery.dataTables.min.js');
            $this->template->add_js('datatables/js/dataTables.bootstrap.js');
            $this->template->add_js('bootstrap-datepicker/js/bootstrap-datepicker.js');
            $this->template->add_js('report.js');

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
