<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koreksi extends CI_Controller {
	public function __construct()
    {
	    parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        // cek login
	    $this->load->library('Auth');
        $this->auth->cek();
        // cek referrer
        $this->auth->cek3();
	    // save log
	    $this->log_user->log_page();
	    // cek notif
	    $this->load->library('Notification');

        $this->load->model('model_koreksi');
	    $this->data = array(
	        'notification' => $this->notification->notif_all(),
	        'menu' => 'menu.php',
	        'UserAccountID' => $this->session->userdata('UserAccountID'),
	        'EmployeeID' => $this->session->userdata('EmployeeID'),
	        'ContactID' => $this->session->userdata('ContactID'),
	        'UserName' => $this->session->userdata('UserName'),
	        'CreatedDate' => $this->session->userdata('CreatedDate'),
	        'JobTitleCode' => $this->session->userdata('JobTitleCode'),
	        'MenuList' => $this->session->userdata('MenuList'),
            'MainTitle' => $this->session->userdata('MainTitle'),
	        'image' => $this->session->userdata('image'),
	        'error_info' => $this->session->userdata('error_info'),
	        'data' => array()
	    );
	}
	
    public function index()
    {   
        redirect(base_url());
    }

// customer=======================================================================
    public function customer_list()
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'LIST CUSTOMER';
        $this->data['body'] = 'koreksi/customer_list2.php';
        $this->data['data']['content'] = $this->model_koreksi->customer_list();;
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'koreksi_data_lama';
        $this->load->view('main',$this->data);
    }
    public function customer_list_data2()
    {
        $this->auth->cek2('koreksi_data_lama');
        if (isset($_POST['initDataTable']) && $_POST['initDataTable'] == 'true') {
            $data = array();
            $output = array(
                "draw" => 1,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => $data,
            );
            echo json_encode($output);
            exit();
        }
        
        $data_dt = array( 
            'table' => 'vw_customer_koreksi_phone', 
            'column_order' => array(null,'ContactID','CustomerID','fullname','Company','Sales',null), 
            'column_search' => array('fullname','Company','Sales'),  
            'order' => array('ContactID' => 'asc')  
        );
        $this->load->model('Model_datatable2');
        $list = $this->Model_datatable2->get_datatables($data_dt);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->ContactID;
            $row[] = $field->CustomerID;
            $row[] = $field->fullname;
            $row[] = $field->Company;
            $row[] = $field->Sales;
            $row[] = '<button type="button" id="view" class="btn btn-flat btn-primary btn-xs" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-file-image-o"></i></button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Model_datatable2->count_all(),
            "recordsFiltered" => $this->Model_datatable2->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    public function customer_list_city_miss()
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'LIST CUSTOMER';
        $this->data['body'] = 'koreksi/customer_list2.php';
        $this->data['data']['content'] = $this->model_koreksi->customer_list_city_miss();;
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'koreksi_data_lama';
        $this->load->view('main',$this->data);
    }
    public function customer_list_se_miss_barat()
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'LIST CUSTOMER';
        $this->data['body'] = 'koreksi/customer_list2.php';
        $this->data['data']['content'] = $this->model_koreksi->customer_list_se_miss_barat();;
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'koreksi_data_lama';
        $this->load->view('main',$this->data);
    }
    public function customer_list_se_miss_timur()
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'LIST CUSTOMER';
        $this->data['body'] = 'koreksi/customer_list2.php';
        $this->data['data']['content'] = $this->model_koreksi->customer_list_se_miss_timur();;
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'koreksi_data_lama';
        $this->load->view('main',$this->data);
    }
    public function customer_list_detail() 
    {
        $this->auth->cek2('koreksi_data_lama');
        $this->load->model('model_master');
        $this->data['content'] = $this->model_master->customer_list_detail();
        $this->load->view('koreksi/customer_list_detail.php',$this->data);
    }
    public function customer_cu($val)
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'ADD/EDIT CUSTOMER';
        $this->data['body'] = 'koreksi/customer_cu.php';
        $this->load->model('model_master');
        $this->data['data']['content']= $this->model_master->customer_cu($val);
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'koreksi_data_lama';
        $this->load->view('main',$this->data);
    }
    public function customer_cu_act()
    {
        $this->auth->cek2('koreksi_data_lama');
        $this->model_koreksi->customer_cu_act();
        echo "<script>window.close();</script>";
        // redirect(base_url('koreksi/customer_list'));
    }

    public function customer_list_miss_cp()
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'LIST CUSTOMER MISS CONTACT PERSON';
        $this->data['body'] = 'koreksi/customer_list_miss_cp.php';
        $this->data['data']['content'] = $this->model_koreksi->customer_list_miss_cp();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_list_miss_cp';
        $this->load->view('main',$this->data);
    }
    public function customer_list_miss_cp_se()
    {   
        $this->auth->cek2('koreksi_data_lama');
        $this->data['PageTitle'] = 'LIST CUSTOMER MISS CONTACT PERSON BY SALES';
        $this->data['body'] = 'koreksi/customer_list_miss_cp_se.php';
        $this->data['data']['content'] = $this->model_koreksi->customer_list_miss_cp_se();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_list_miss_cp_se';
        $this->load->view('main',$this->data);
    }
    public function product_list()
    {
        $this->auth->cek2('koreksi_produk');
        $this->data['PageTitle'] = 'LIST PRODUCT CORRECTION';
        $this->data['body'] = 'koreksi/product_list.php';
        $this->data['data']['content'] = $this->model_koreksi->product_list();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk';
        $this->load->view('main',$this->data);
    }
    public function product_manager()
    {
        $this->auth->cek2('koreksi_produk_manager');
        $this->data['PageTitle'] = 'PRODUCT MANAGER';
        $this->data['body'] = 'koreksi/product_manager_list.php';
        $this->data['data']['content'] = $this->model_koreksi->product_manager_list();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk_manager';
        $this->load->view('main',$this->data);
    }
    public function product_list_acz()
    {
        $this->auth->cek2('koreksi_produk_acz');
        $this->data['PageTitle'] = 'PRODUCT PSHOP ACZ DATA CORRECTION';
        $this->data['body'] = 'koreksi/product_list_acz.php';
        $this->data['data']['content'] = $this->model_koreksi->product_list_acz();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk_acz';
        $this->load->view('main',$this->data);
    }
    public function product_list_cvn()
    {
        $this->auth->cek2('koreksi_produk_cvn');
        $this->data['PageTitle'] = 'PRODUCT PSHOP CVN DATA CORRECTION';
        $this->data['body'] = 'koreksi/product_list_cvn.php';
        $this->data['data']['content'] = $this->model_koreksi->product_list_cvn();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk_cvn';
        $this->load->view('main',$this->data);
    }
    public function product_list_angz()
    {
        $this->auth->cek2('koreksi_produk_angz');
        $this->data['PageTitle'] = 'PRODUCT PSHOP ANGZ DATA CORRECTION';
        $this->data['body'] = 'koreksi/product_list_angz.php';
        $this->data['data']['content'] = $this->model_koreksi->product_list_angz();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk_angz';
        $this->load->view('main',$this->data);
    }
    public function product_list_ati()
    {
        $this->auth->cek2('koreksi_produk_ati');
        $this->data['PageTitle'] = 'PRODUCT PSHOP ATI DATA CORRECTION';
        $this->data['body'] = 'koreksi/product_list_ati.php';
        $this->data['data']['content'] = $this->model_koreksi->product_list_ati();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk_ati';
        $this->load->view('main',$this->data);
    }
    public function product_list_ago()
    {
        $this->auth->cek2('koreksi_produk_ago');
        $this->data['PageTitle'] = 'PRODUCT PSHOP AGO DATA CORRECTION';
        $this->data['body'] = 'koreksi/product_list_ago.php';
        $this->data['data']['content'] = $this->model_koreksi->product_list_ago();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'koreksi_produk_ago';
        $this->load->view('main',$this->data);
    }
}
