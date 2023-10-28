<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
include APPPATH.'libraries/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Master extends CI_Controller {
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

        $this->load->model('model_master');
        $this->load->model('model_master2');
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

// contact=====================================================================
	public function contact_list()
	{
	    $this->auth->cek2('contact_list');
        $this->data['PageTitle'] = 'LIST CONTACT';
        $this->data['body'] = 'master/contact/contact_list2.php';
        $this->data['data']['help'] = 'CONTACT_LIST_v.1';
        $this->data['data']['menu'] = 'contact_list';
		$this->load->view('main',$this->data);
	}
	public function contact_list_data2()
	{
	    $this->auth->cek2('contact_list');
	    
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
	        'table' => 'vw_contact1', 
	        'column_order' => array('ContactID','Company2','address','phone',null), 
	        'column_search' => array('ContactID','Company2','address','phone'),  
	        'order' => array('ContactID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $field->ContactID;
			$row[] = $field->Company2;
			$row[] = $field->phone;
			$row[] = wordwrap($field->address,85,"<br>\n");
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
	public function contact_list_detail() 
	{
	    $this->auth->cek2('contact_list');
        $this->data['content'] = $this->model_master->contact_list_detail();
        $this->load->view('master/contact/contact_list_detail.php',$this->data);
	}
	public function contact_cu($val)
	{
	    $this->auth->cek2('contact_cu');
        $this->data['PageTitle'] = 'ADD/EDIT CONTACT';
        $this->data['body'] = 'master/contact/contact_cu.php';
        $this->data['data']['content'] = $this->model_master->contact_cu($val);
        $this->data['data']['help'] = 'CONTACT_LIST_v.1';
        $this->data['data']['menu'] = 'contact_list';
		$this->load->view('main',$this->data);
	}
	public function contact_cu_act()
	{
	    $this->auth->cek2('contact_cu');
        $this->model_master->contact_cu_act();
        echo "<script>window.close();</script>";
        // redirect(base_url('master/contact_list'));
	}
	
// sales=======================================================================
	public function sales_list()
	{
		$this->auth->cek2('sales_list');
        $this->data['PageTitle'] = 'LIST SALES';
        $this->data['body'] = 'master/contact/sales_list.php';
		$this->data['data']['content' ]= $this->model_master->sales_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sales_list';
		$this->load->view('main',$this->data);
	}
	public function sales_set($val)
	{
	    $this->auth->cek2('sales_cu');
		$this->model_master->sales_set($val);
        redirect(base_url('master/sales_list'));
	}
	public function sales_cu($val)
	{
	    $this->auth->cek2('sales_cu');
        $this->data['PageTitle'] = 'ADD/EDIT SALES';
        $this->data['body'] = 'master/contact/sales_cu.php';
		$this->data['data']['content' ]= $this->model_master->sales_cu($val);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sales_list';
		$this->load->view('main',$this->data);
	}
	public function sales_cu_act()
	{
	    $this->auth->cek2('sales_cu');
        $this->model_master->sales_cu_act();
        echo "<script>window.close();</script>";
        // redirect(base_url('master/sales_list'));
	}
	public function sales_list_detail() 
	{
		$this->auth->cek2('sales_list');
        $this->data['content'] = $this->model_master->sales_list_detail();
        $this->load->view('master/contact/sales_list_detail.php',$this->data);
	}

// expedition==================================================================
	public function expedition_list()
	{
		$this->auth->cek2('expedition_list');
        $this->data['PageTitle'] = 'LIST EXPEDITION';
        $this->data['body'] = 'master/contact/expedition_list.php';
		$this->data['data']['content' ]= $this->model_master->expedition_list();
        $this->data['data']['help'] = 'Expedition List v.1';
        $this->data['data']['menu'] = 'expedition_list';
		$this->load->view('main',$this->data);
	}
	public function expedition_list_detail() 
	{
		$this->auth->cek2('expedition_list');
        $this->data['content'] = $this->model_master->expedition_list_detail();
        $this->data['data']['help'] = 'Expedition List v.1';
        $this->load->view('master/contact/expedition_list_detail.php',$this->data);
	}
	public function expedition_set($val)
	{
	    $this->auth->cek2('expedition_list');
		$this->model_master->expedition_set($val);
        redirect(base_url('master/expedition_list'));
	}
	public function expedition_cu($val)
	{
	    $this->auth->cek2('expedition_list');
        $this->data['PageTitle'] = 'ADD/EDIT EXPEDITION';
        $this->data['body'] = 'master/contact/expedition_cu.php';
		$this->data['data']['content' ]= $this->model_master->expedition_cu($val);
        $this->data['data']['help'] = 'Expedition List v.1';
        $this->data['data']['menu'] = 'expedition_list';
		$this->load->view('main',$this->data);
	}
	public function expedition_cu_act()
	{
	    $this->auth->cek2('expedition_list');
        $this->model_master->expedition_cu_act();
        redirect(base_url('master/expedition_list'));
	}
	
// customer====================================================================
	public function customer_list()
	{
		$this->auth->cek2('customer_list');
        $this->data['PageTitle'] = 'LIST CUSTOMER';
        $this->data['body'] = 'master/contact/customer_list2.php';
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'customer_list';
		$this->load->view('main',$this->data);
	}
	public function customer_list_data2()
	{
		$this->auth->cek2('customer_list');
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
	        'table' => 'vw_customer1', 
	        'column_order' => array(null,'ContactID','CustomerID','Company2','CustomercategoryName','phone','Address','isActive',null), 
	        'column_search' => array('ContactID','CustomerID','Company2','CustomercategoryName','phone','Address'),  
	        'order' => array('CustomerID' => 'asc')  
	    );
	    $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$status = ($field->isActive == 1 ? "Active" : "notActive");
			$row = array();
			$row[] = $field->ContactID;
			$row[] = $field->CustomerID;
			$row[] = $field->Company2;
			$row[] = $field->CustomercategoryName;
			$row[] = $field->phone;
			$row[] = $field->Address;
			$row[] = '';
			$row[] = $status;
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
	public function customer_list_data2_with_sales()
	{
    	$num_char = 30;	
		$this->auth->cek2('customer_list');
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
	        'table' => 'vw_customer4', 
	        'column_order' => array('ContactID','CustomerID','Company2','CustomercategoryName','phone','Address','isActive','Sales',null), 
	        'column_search' => array('ContactID','CustomerID','Company2','Address','Sales'),  
	        'order' => array('CustomerID' => 'asc')  
	    );
	    $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$status = ($field->isActive == 1 ? "Active" : "notActive");
			$row = array();
			$row[] = $field->ContactID;
			$row[] = $field->CustomerID;
			$row[] = '<a class="linkname view" data-toggle="modal" data-target="#modal-contact">'.$field->Company2.'</a>';
			$row[] = $field->CustomercategoryName;
			$row[] = $field->phone;
			$row[] = substr($field->Address, 0, $num_char) . '...';
			$row[] = $field->Sales;
			$row[] = $status;
			$row[] = '<button type="button" class="btn btn-flat btn-primary btn-xs view" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-file-image-o"></i></button>';

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
	public function customer_list_detail() 
	{
		$this->auth->cek2('customer_list');
        $this->data['content'] = $this->model_master->customer_list_detail();
        $this->load->view('master/contact/customer_list_detail.php',$this->data);
	}
	public function customer_cu($val)
	{
	    $this->auth->cek2('customer_cu');
        $this->data['PageTitle'] = 'ADD/EDIT CUSTOMER';
        $this->data['body'] = 'master/contact/customer_cu.php';
		$this->data['data']['content' ]= $this->model_master->customer_cu($val);
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'customer_list';
		$this->load->view('main',$this->data);
	}
	public function customer_cu_act()
	{
	    $this->auth->cek2('customer_cu');
	    // echo json_encode($this->input->post());
        $this->model_master->customer_cu_act();
        redirect(base_url('master/customer_list'));
        // echo "<script>window.close();</script>";
	}
	public function customer_pv_cu($val)
	{
	    $this->auth->cek2('customer_pv_cu');
        $this->data['PageTitle'] = 'ADD/EDIT PV - CUSTOMER MULTIPLIER';
        $this->data['body'] = 'master/contact/customer_pv_cu.php';
		$this->data['data']['content']= $this->model_master->customer_pv_cu($val);
		// echo json_encode($this->data['data']['content']);
        $this->data['data']['help'] = 'Customer List v.1';
        $this->data['data']['menu'] = 'customer_pv_cu';
		$this->load->view('main',$this->data);
	}
	public function customer_pv_cu_act()
	{
	    $this->auth->cek2('customer_pv_cu');
	    // echo json_encode($this->input->post());
        $this->model_master->customer_pv_cu_act();
        redirect(base_url('master/customer_list'));
	}

// supplier====================================================================
	public function supplier_list()
	{
		$this->auth->cek2('supplier_list');
        $this->data['PageTitle'] = 'LIST SUPPLIER';
        $this->data['body'] = 'master/contact/supplier_list.php';
		$this->data['data']['content' ]= $this->model_master->supplier_list() ;
        $this->data['data']['help'] = 'Supplier List v.1';
        $this->data['data']['menu'] = 'supplier_list';
		$this->load->view('main',$this->data);
	}
	public function supplier_list_detail() 
	{
		$this->auth->cek2('supplier_list');
        $this->data['content'] = $this->model_master->supplier_list_detail();
        $this->load->view('master/contact/supplier_list_detail.php',$this->data);
	}
	public function supplier_set($val)
	{
	    $this->auth->cek2('supplier_list');
		$this->model_master->supplier_set($val);
        redirect(base_url('master/supplier_list'));
	}
	public function supplier_cu($val)
	{
	    $this->auth->cek2('supplier_cu');
        $this->data['PageTitle'] = 'ADD/EDIT SUPPLIER';
        $this->data['body'] = 'master/contact/supplier_cu.php';
		$this->data['data']['content' ]= $this->model_master->supplier_cu($val);
        $this->data['data']['help'] = 'Supplier List v.1';
        $this->data['data']['menu'] = 'supplier_list';
		$this->load->view('main',$this->data);
	}
	public function supplier_cu_act()
	{
	    $this->auth->cek2('supplier_cu');
        $this->model_master->supplier_cu_act();
        redirect(base_url('master/supplier_list'));
	}

// product=====================================================================
	public function product_list()
	{
	    $this->auth->cek2('manage_product');
        $this->data['PageTitle'] = 'LIST PRODUCT';
        // list server-side
        $this->data['body'] = 'master/product/product_list2.php';

        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_list';
		$this->load->view('main',$this->data);
	}
	public function product_list_data()
	{
	    $this->auth->cek2('manage_product');
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
	        'table' => 'vw_product_list_popup4', 
	        'column_order' => array(null,null,'ProductID','ProductName','ProductCode','ProductPriceDefault','ProductCategoryName','ProductBrandName','stock','ProductCodeBar','ProductAtributeSetName','isActive',null,null,'ModifiedDate',null),
	        'column_search' => array('ProductID','ProductName','ProductCode','ProductCodeBar','ProductCategoryName','ProductBrandName'),
	        'order' => array('ProductID' => 'asc')
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no1 = 0;
		$no2 = $_POST['start'];
		$number = 1;

        $categoryFull = $this->model_master->get_full_category();
        $brandFull = $this->model_master->get_full_brand();

		foreach ($list as $field) {
			$doc = "";
			$action = '<a href="'.base_url().'master/product_add?id='.$field->ProductID.'" id="edit" class="btn btn-flat btn-primary btn-xs edit view" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a> ';
			$action .= '<a href="#" class="btn btn-flat btn-primary btn-xs dtbutton view" id="view_product" data-toggle="modal" data-target="#modal-product"><i class="fa fa-fw fa-info"></i></a> ';
			$action .= '<a href="#" class="btn btn-flat btn-primary btn-xs view" id="view_price_history" data-toggle="modal" data-target="#modal-product" title="Price History"><i class="fa fa-fw fa-clock-o"></i></a>';

            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$no1++;
			$no2++;
			$row = array();
			$row[] = $no1.'_'.$field->ProductID;
			$row[] = $no2;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->stock;
			$row[] = $field->ProductCodeBar;
			$row[] = $field->ProductAtributeSetName;
			$row[] = $status;
			$row[] = $categoryFull[$field->ProductCategoryID]['ProductCategoryName'];
			$row[] = $brandFull[$field->ProductBrandID]['ProductBrandName'];
			$row[] = $field->ModifiedDate;
			$row[] = $doc.$action;

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
	public function product_hpp_list()
	{
	    $this->auth->cek2('manage_product_hpp');
        $this->data['PageTitle'] = 'LIST PRODUCT';
        // list server-side
        $this->data['body'] = 'master/product/product_hpp_list2.php';

        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'manage_product_hpp';
		$this->load->view('main',$this->data);
	}
	public function product_hpp_list_data()
	{
		$this->auth->cek2('manage_product_hpp');
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
	        'table' => 'vw_product_list_popup4',
	        'column_order' => array(null,null,'ProductID','ProductName','ProductCode','ProductPriceHPP','ProductPriceDefault','ProductCategoryName','ProductBrandName','stock','ProductCodeBar','ProductAtributeSetName','isActive',null,null,'ModifiedDate',null),
	        'column_search' => array('ProductID','ProductName','ProductCode','ProductCodeBar','ProductCategoryName','ProductBrandName'),
	        'order' => array('ProductID' => 'asc')
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no1 = 0;
		$no2 = $_POST['start'];
		$number = 1;

        $categoryFull = $this->model_master->get_full_category();
        $brandFull = $this->model_master->get_full_brand();

		foreach ($list as $field) {
			$doc = "";
			$action = '<a href="'.base_url().'master/product_add?id='.$field->ProductID.'" id="edit" class="btn btn-flat btn-primary btn-xs edit view" style="margin: 0px;" target="_blank" title="EDIT"><i class="fa fa-fw fa-edit"></i></a> ';
			$action .= '<a href="#" class="btn btn-flat btn-primary btn-xs dtbutton view" id="view_product" data-toggle="modal" data-target="#modal-product"><i class="fa fa-fw fa-info"></i></a> ';
			$action .= '<a href="#" class="btn btn-flat btn-primary btn-xs view" id="view_price_history" data-toggle="modal" data-target="#modal-product" title="Price History"><i class="fa fa-fw fa-clock-o"></i></a>';

            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$no1++;
			$no2++;
			$row = array();
			$row[] = $no1.'_'.$field->ProductID;
			$row[] = $no2;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->ProductPriceHPP);
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->stock;
			$row[] = $field->ProductCodeBar;
			$row[] = $field->ProductAtributeSetName;
			$row[] = $status;
			$row[] = $categoryFull[$field->ProductCategoryID]['ProductCategoryName'];
			$row[] = $brandFull[$field->ProductBrandID]['ProductBrandName'];
			$row[] = $field->ModifiedDate;
			$row[] = $doc.$action;

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
	public function product_add()
	{
	    $this->auth->cek2('manage_product');
        $this->data['PageTitle'] = 'ADD/EDIT PRODUCT';
        $this->data['body'] = 'master/product/product_add.php';
		$this->data['data']['productcategory' ]= $this->model_master->fill_parent_category();
		$this->data['data']['productbrand' ]= $this->model_master->fill_parent_brand() ;
        if (isset($_REQUEST['id'])) {
        	$this->data['data']['productdetail'] = $this->model_master->product_detail($_REQUEST['id']);
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_list';
		$this->load->view('main',$this->data);
	}
	public function product_cu()
	{
		$this->auth->cek2('manage_product');
		// cek jika ada post ProductID
		if ($this->input->post('productid2') == "" ) {
			// new product
			$this->model_master->product_add_act();
		} else {
			// edit product
			$this->model_master->product_edit_act();
		}
		redirect(base_url('master/product_list'));
	}
	public function product_cu_batch_formula()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'BATCH EDIT FORMULA PRODUCT';
	    $this->data['body'] = 'master/product/product_cu_batch_formula.php';
        if (isset($_REQUEST['data']) && $this->input->get('data') != "" ) {
			$this->data['data']['productdetail'] = $this->model_master->get_product_detail_batch($this->input->get('data'));
			$this->data['data']['productcategory'] = $this->model_master->fill_parent_category();
			$this->data['data']['productbrand'] = $this->model_master->fill_parent_brand() ;
	        $this->data['data']['help'] = 'Doc';
	        $this->data['data']['menu'] = 'product_list';
			$this->load->view('main',$this->data);
	    } else ( redirect(base_url()) );
	}
	public function product_cu_batch_formula_act()
	{
		$this->auth->cek2('manage_product_detail');
		$this->model_master->product_cu_batch_formula_act();
		redirect(base_url('master/product_list'));
	}
	public function product_cu_batch_edit()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'BATCH EDIT DETAIL PRODUCT';
	    $this->data['body'] = 'master/product/product_cu_batch_edit.php';
	    // cek batch edit disertai data
        if (isset($_REQUEST['data']) && $this->input->get('data') != "" ) {
	        $this->data['data']['product'] = $this->model_master->get_product_detail_batch2($this->input->get('data'));
	        $this->data['data']['help'] = 'Doc';
	        $this->data['data']['menu'] = 'product_list';
			$this->load->view('main',$this->data);
	    } else ( redirect(base_url()) );
	}
	public function product_cu_batch_edit_act()
	{
	    $this->auth->cek2('manage_product_detail');
    	$this->model_master->product_cu_batch_edit_act();
        redirect(base_url('master/product_list'));
	}
	public function product_cu_batch_shop()
	{
	    $this->auth->cek2('shop_cu');
        $this->data['PageTitle'] = 'BATCH EDIT PRODUCT SHOP';
	    $this->data['body'] = 'master/product/product_cu_batch_shop.php';
	    // cek batch edit disertai data
        if (isset($_REQUEST['data']) && $this->input->get('data') != "" ) {
	        $this->data['data']['main'] = $this->model_master->get_product_detail_batch_shop($this->input->get('data'));
	        $this->data['data']['help'] = 'Doc';
	        $this->data['data']['menu'] = 'product_list';
			$this->load->view('main',$this->data);
	    } else ( redirect(base_url()) );
	}
	public function product_cu_batch_shop_act()
	{
	    $this->auth->cek2('shop_cu');
    	$this->model_master->product_cu_batch_shop_act();
        redirect(base_url('master/product_list'));
	}
	public function get_product_detail() 
	{
	    $this->auth->cek2('manage_product');
        $this->data['content'] = $this->model_master->get_product_detail();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/product/product_detail.php',$this->data);
	}
	public function get_product_price_history() 
	{
	    $this->auth->cek2('manage_product');
        $this->data['content'] = $this->model_master->get_product_price_history();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/product/product_price_history.php',$this->data);
	}
	public function product_list_popup_data()
	{
	    $this->auth->cek2('manage_product');
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
	        'table' => 'vw_product_list_popup2_active', 
	        'column_order' => array(null,'ProductID','ProductName','ProductCode','ProductPriceDefault','ProductCategoryName','ProductBrandName','stock','ProductStatusName','isActive'), 
	        'column_search' => array('ProductID','ProductName','ProductCode','ProductPriceDefault','ProductCategoryName','ProductBrandName'),  
	        'order' => array('ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$no++;
			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->stock;
			$row[] = $field->ProductStatusName;
            $row[] = $status;

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
	public function CopyProductACZ()
	{
	    $this->auth->cek2('manage_product');
        $this->model_master->CopyProductACZ();
	}
	public function import_stock_online()
	{
	    $this->auth->cek2('manage_product');
	    $result = array();
		$fileName = $_FILES['excel']['name'];
		if($fileName != ''){
	        $config['upload_path'] = './assets/';
	        $config['file_name'] = $fileName;
	        $config['allowed_types'] = 'xls|xlsx|csv';
	        $config['max_size'] = 10000;
	        $config['overwrite'] = FALSE;
	         
	        $this->load->library('upload');
	    	$this->upload->initialize($config);
	         
	    	if (! $this->upload->do_upload('excel')) {
		        $this->upload->display_errors();
	    	} else {

				// include APPPATH.'libraries/vendor/autoload.php';
		        $file_name = './assets/'.$fileName;
				
				$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
				$spreadsheet = $reader->load($file_name);

				$data = $spreadsheet->getActiveSheet()->toArray();
	    		$data_all = array();
			    $numrow = 1;
				foreach($data as $row) {
			      	if($numrow > 1){
	                	$a = 0;
						$data_all[] = array( 
							          'mo_id' => strval($row[$a++]), 
							          'mo_name' => $row[$a++], 
							          'bo_id' => $row[$a++], 
							        );
					}
			      	$numrow++;
				}

		        $this->model_master->import_stock_online($data_all);
		    }
		}
		redirect(base_url('master/product_list'));
	}
	public function export_stock_online()
	{
        $result = $this->model_master->export_stock_online();
		if (count($result) > 0) {
			$spreadsheet = new Spreadsheet;
			$spreadsheet->setActiveSheetIndex(0)
					  ->setCellValue('A1', 'Kode Gudang')
					  ->setCellValue('A2', '001')
					  ->setCellValue('B2', 'Isi kode gudang sesuai dengan master gudang pada sheet2')
			          ->setCellValue('A4', 'Kode Barang')
			          ->setCellValue('B4', 'Nama Barang')
			          // ->setCellValue('C1', 'BO ID')
			          // ->setCellValue('D1', 'BO Name')
			          ->setCellValue('C4', 'QTY');
			$kolom = 5;
			$nomor = 1;
			foreach($result as $list) {
			   $spreadsheet->setActiveSheetIndex(0)
			               ->setCellValue('A' . $kolom, strval($list['mo_id']))
			               ->setCellValue('B' . $kolom, $list['mo_name'])
			               // ->setCellValue('C' . $kolom, $list['bo_id'])
			               // ->setCellValue('D' . $kolom, $list['bo_name'])
			               ->setCellValue('C' . $kolom, $list['bo_stock']);
			   $kolom++;
			   $nomor++;
			}
			$writer = new Xls($spreadsheet);
			$file_output = 'export_'.date('Y-m-d').'.xls';
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$file_output.'"');
			header('Cache-Control: max-age=0');

	  		$writer->save('php://output');
		}
	}
	public function export_stock_online_BASITH()
	{
	    $this->auth->cek2('manage_product');
	    $result = array();
		$fileName = $_FILES['excel']['name'];
		if($fileName != ''){
	        $config['upload_path'] = './assets/';
	        $config['file_name'] = $fileName;
	        $config['allowed_types'] = 'xls|xlsx|csv';
	        $config['max_size'] = 10000;
	        $config['overwrite'] = FALSE;
	         
	        $this->load->library('upload');
	    	$this->upload->initialize($config);
	         
	    	if (! $this->upload->do_upload('excel')) {
		        $this->upload->display_errors();
	    	} else {

				// include APPPATH.'libraries/vendor/autoload.php';
		        $file_name = './assets/'.$fileName;
				
				$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
				$spreadsheet = $reader->load($file_name);

				$data = $spreadsheet->getActiveSheet()->toArray();
	    		$data_all = array();
			    $numrow = 1;
				foreach($data as $row) {
			      	if($numrow > 1){
	                	$a = 0;
					$data_all[$row[$a]] = array( 
									          'mo_id' => strval($row[$a++]), 
									          'mo_name' => $row[$a++], 
									          'bo_id' => $row[$a++], 
									        );
					}
			      	$numrow++;
				}
		        $result = $this->model_master->export_stock_online($data_all);
		        // $result = $data_all;
				// echo json_encode($result);
		    }
		}
	}
	public function price_recommendation_add()
	{
        $this->auth->cek2('price_recommendation');
        $this->data['PageTitle'] = 'Add Recommendation Price';
        $this->data['body'] = 'master/product/price_recommendation_add.php';
        // $this->data['body'] = 'master/product/price_recommendation_new.php';
        $this->data['data']['content'] = $this->model_master->price_recommendation_add();
        $this->data['data']['menu'] = 'price_recommendation';
        $this->load->view('main',$this->data);
	}
	public function price_recommendation_add_act()
	{
        $this->auth->cek2('price_recommendation');
        $this->model_master->price_recommendation_add_act();
        redirect(base_url('report/report_price_check_list'));
	}
	public function price_recommendation_edit()
	{
        $this->auth->cek2('price_recommendation');
        $this->data['PageTitle'] = 'Edit Recommendation Price';
        $this->data['body'] = 'master/product/price_recommendation_edit.php';
        $this->data['data']['content'] = $this->model_master->price_recommendation_edit();
        $this->load->view('main',$this->data);
	}
	public function price_recommendation_edit_act()
	{
        $this->auth->cek2('price_recommendation');
        $this->model_master->price_recommendation_edit_act();
        redirect(base_url('approval/approve_price_recommendation'));
	}
	public function price_check_add()
	{
        $this->auth->cek2('price_check');
        $this->data['PageTitle'] = 'Price Check';
        $this->data['body'] = 'master/product/price_check_add.php';
        $this->data['data']['content'] = $this->model_master->price_check_add();
        $this->data['data']['menu'] = 'price_check';
        $this->load->view('main',$this->data);
	}
	public function price_check_add_act($val)
	{
        $this->auth->cek2('price_check');
        $this->model_master->price_check_add_act($val);
	}

// productatribute=============================================================
	public function productatribute_list()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'LIST PRODUCT ATRIBUTE';
        $this->data['body'] = 'master/product/productatribute_list.php';
		$this->data['data']['content' ]= $this->model_master->productatribute_list() ;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'atribute_list';
		$this->load->view('main',$this->data);
	}
	public function productatribute_add()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productatribute_add();
        redirect(base_url('master/productatribute_list'));
	}
	public function productatribute_edit()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productatribute_edit();
        redirect(base_url('master/productatribute_list'));
	}

// productatributeset==========================================================
	public function productatributeset_list()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'LIST PRODUCT ATRIBUTE SET';
        $this->data['body'] = 'master/product/productatributeset_list.php';
		$this->data['data']['content' ]= $this->model_master->productatributeset_list() ;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'atributeset_list';
		$this->load->view('main',$this->data);
	}
	public function productatributeset_add()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productatributeset_add();
        redirect(base_url('master/productatributeset_list'));
	}
	public function productatributeset_edit()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productatributeset_edit();
        redirect(base_url('master/productatributeset_list'));
	}

// productcategory=============================================================
	public function productcategory_list()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'LIST PRODUCT CATEGORY';
        $this->data['body'] = 'master/product/productcategory_list.php';
		$this->data['data']['content' ]= $this->model_master->productcategory_list();
		$this->data['data']['content2' ]= $this->model_master->fill_parent_category() ;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'category_list';
		$this->load->view('main',$this->data);
	}
	public function productcategory_add()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productcategory_add();
        redirect(base_url('master/productcategory_list'));
	}
	public function productcategory_edit()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productcategory_edit();
        redirect(base_url('master/productcategory_list'));
	}
	public function productnamingformula($id)
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'PRODUCT NAMING FORMULA';
        $this->data['body'] = 'master/product/productnamingformula.php';
		$this->data['data']['content' ]= $this->model_master->get_category_formula($id);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'category_list';
		$this->load->view('main',$this->data);
	}
	public function productnamingformula_act()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->productnamingformula_act();
        redirect(base_url('master/productcategory_list'));
	}

// brand=======================================================================
	public function brand_list()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->data['PageTitle'] = 'LIST BRAND';
        $this->data['body'] = 'master/product/brand_list.php';
		$this->data['data']['content' ]= $this->model_master->brand_list();
		$this->data['data']['content2' ]= $this->model_master->fill_parent_brand() ;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'brand_list';
		$this->load->view('main',$this->data);
	}
	public function brand_add()
	{
		$val 	= $this->input->get_post('idp');
		$this->auth->cek2('manage_product_detail');
        $this->model_master->brand_add();
        if($val==1){
			redirect(base_url('master/product_add'));
        } else {
			redirect(base_url('master/brand_list'));
        }
	}
	public function brand_edit()
	{
	    $this->auth->cek2('manage_product_detail');
        $this->model_master->brand_edit();
        redirect(base_url('master/brand_list'));
	}
	
// ============================================================================
	public function supplier_list_detail2()
	{
		$this->model_master->supplier_list_detail2();
	}
	public function fill_city()
	{
		$this->model_master->fill_city();
	}
	public function fill_customer()
	{
		$this->model_master->fill_customer();
	}
	public function fill_customercategory()
	{
		$this->model_master->fill_customercategory();
	}
	public function fill_sales()
	{
		$this->model_master->fill_sales();
	}
	public function fill_price()
	{
		$this->model_master->fill_price();
	}
	public function fill_atribute()
	{
		$this->model_master->fill_atribute();
	}
	public function fill_atribute_set()
	{
		$this->model_master->fill_atribute_set();
	}
	public function fill_pricelist()
	{
		$this->model_master->fill_pricelist();
	}
	public function fill_product_price_list()
	{
		$this->model_master->fill_product_price_list();
	}
	public function get_category_detail()
	{
		$this->model_master->get_category_detail();
	}
	public function get_atribute_value()
	{
		$this->model_master->get_atribute_value();
	}
	public function get_atribute_set_value()
	{
		$this->model_master->get_atribute_set_value();
	}
	public function get_category_aribute_set()
	{
		$this->model_master->get_category_aribute_set();
	}
	public function get_pricelist_set_value()
	{
		$this->model_master->get_pricelist_set_value();
	}
	public function fill_category_name_code()
	{
		$this->model_master->fill_category_name_code();
	}
	public function fill_statusquality()
	{
		$this->model_master->fill_statusquality();
	}
	public function get_category_code()
	{
		$this->model_master->get_category_code();
	}
	public function get_category_name()
	{
		$this->model_master->get_category_name();
	}
	public function get_brand_code()
	{
		$this->model_master->get_brand_code();
	}
	public function get_brand_name()
	{
		$this->model_master->get_brand_name();
	}
	public function get_atribute_set_detail()
	{
		$this->model_master->get_atribute_set_detail();
	}
	public function fill_product_list()
	{
		$this->model_master->fill_product_list();
	}
	public function generatenamecode()
	{
		$this->model_master->generatenamecode("single");
	}
	public function generatenamecodebatch()
	{
		$this->model_master->generatenamecodebatch();
	}
	public function get_product_set_value()
	{
		$this->model_master->get_product_set_value();
	}
	public function cek_product_code()
	{
        $this->model_master->cek_product_code();
	}
	public function product_list_popup()
	{
		$this->data['content'] = $this->model_master->product_list();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/product/product_list_popup.php',$this->data);
	}
	public function product_list_popup2()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/product/product_list_popup2.php',$this->data);
	}
	function product_list_popup2_data()
	{
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
	        'table' => 'vw_product_list_popup2_active', 
	        'column_order' => array(null,'ProductID','ProductName','ProductCode','stock','ProductStatusName','ProductCategoryName','ProductBrandName','ProductPriceDefault','InputDate','isActive',null,null), 
	        'column_search' => array('ProductID','ProductName','ProductCode','stock','ProductStatusName','ProductCategoryName','ProductBrandName'),  
	        'order' => array('ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$row = array();
			$row[] = '<a href="#" class="btn btn-flat btn-primary btn-xs insert_data" stockable="'.$field->Stockable.'" forsale="'.$field->forSale.'">Submit</a>';
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = $field->stock;
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->InputDate;
			$row[] = $status;
			$row[] = '';
			$row[] = '';

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
	public function product_list_popup3_hpp()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/product/product_list_popup3_hpp.php',$this->data);
	}
	function product_list_popup3_hpp_data()
	{
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
	        'table' => 'vw_product_list_popup2_active', 
	        'column_order' => array(null,'ProductID','ProductName','ProductCode','stock','ProductStatusName','ProductCategoryName','ProductBrandName','ProductPriceDefault','ProductPriceHPP','ProductSupplier','isActive',null), 
	        'column_search' => array('ProductID','ProductName','ProductCode','stock','ProductStatusName','ProductCategoryName','ProductBrandName'),  
	        'order' => array('ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$row = array();
			$row[] = '<a href="#" class="btn btn-flat btn-primary btn-xs insert_data" stockable="'.$field->Stockable.'" forsale="'.$field->forSale.'">Submit</a>';
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = $field->stock;
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductPriceHPP;
			$row[] = $field->ProductSupplier;
			$row[] = $status;
			$row[] = '';

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
	public function cek_duplicate_atribute_code()
	{
        $this->model_master->cek_duplicate_atribute_code();
	}
	public function cek_used_atribute_code()
	{
        $this->model_master->cek_used_atribute_code();
	}



// MODEL MASTER2===============================================================

// warehouse===================================================================
	public function warehouse_list()
	{
	    $this->auth->cek2('manage_warehouse');
        $this->data['PageTitle'] = 'LIST WAREHOUSE';
        $this->data['body'] = 'master/administration/warehouse_list.php';
		$this->data['data']['content']= $this->model_master2->warehouse_list() ;
        $this->data['data']['help'] = 'Warehouse List v.1';
        $this->data['data']['menu'] = 'warehouse_list';
		$this->load->view('main',$this->data);
	}
	public function warehouse_add()
	{
	    $this->auth->cek2('manage_warehouse');
        $this->model_master2->warehouse_add();
        redirect(base_url('master/warehouse_list'));
	}
	public function warehouse_edit()
	{
	    $this->auth->cek2('manage_warehouse');
        $this->model_master2->warehouse_edit();
        redirect(base_url('master/warehouse_list'));
	}
	
// city========================================================================
	public function city_list()
	{
	    $this->auth->cek2('manage_city');
        $this->data['PageTitle'] = 'LIST CITY';
        $this->data['body'] = 'master/administration/city_list.php';
		$this->data['data']['content' ]= $this->model_master2->city_list() ;
        $this->data['data']['help'] = 'City List v.1';
        $this->data['data']['menu'] = 'city_list';
		$this->load->view('main',$this->data);
	}
	public function city_cu()
	{
	    $this->auth->cek2('manage_city');
        $this->data['PageTitle'] = 'EDIT CITY';
        $this->data['body'] = 'master/administration/city_cu.php';
		$this->data['data']['city_detail' ]= $this->model_master2->city_detail();
		$this->data['data']['expedition' ]= $this->model_master->expedition_list() ;
        $this->data['data']['help'] = 'City List v.1';
        $this->data['data']['menu'] = 'city_list';
		$this->load->view('main',$this->data);
	}
	public function city_cu_act()
	{
	    $this->auth->cek2('manage_city');
        $this->model_master2->city_cu_act();
        redirect(base_url('master/city_list'));
	}
	public function city_list_popup()
	{
	    $this->auth->cek2('manage_city');
		$this->data['content'] = $this->model_master2->city_list();
        $this->load->view('master/administration/city_list_popup.php',$this->data);
	}

// region======================================================================
	public function region_list()
	{
	    $this->auth->cek2('manage_region');
        $this->data['PageTitle'] = 'LIST REGION';
        $this->data['body'] = 'master/administration/region_list.php';
		$this->data['data']['content' ]= $this->model_master2->region_list() ;
        $this->data['data']['help'] = 'Region List v.1';
        $this->data['data']['menu'] = 'region_list';
		$this->load->view('main',$this->data);
	}
	public function region_cu()
	{
	    $this->auth->cek2('manage_region');
        $this->data['PageTitle'] = 'EDIT REGION';
        $this->data['body'] = 'master/administration/region_cu.php';
		$this->data['data']['region_detail' ]= $this->model_master2->region_detail() ;
        $this->data['data']['help'] = 'Region List v.1';
        $this->data['data']['menu'] = 'region_list';
		$this->load->view('main',$this->data);
	}
	public function region_cu_act()
	{
	    $this->auth->cek2('manage_region');
        $this->model_master2->region_cu_act();
        redirect(base_url('master/region_list'));
	}

// price_category==============================================================
	public function productpricecategory_list()
	{
		$this->auth->cek2('manage_price');
        $this->data['PageTitle'] = 'LIST PRODUCT PRICE CATEGORY';
        $this->data['body'] = 'master/administration/productpricecategory_list.php';
		$this->data['data']['content'] = $this->model_master->productpricecategory_list();
        $this->data['data']['help'] = 'Price Category v.1';
        $this->data['data']['menu'] = 'price_category';
		$this->load->view('main',$this->data);
	}
	public function price_category_detail() 
	{
		$this->auth->cek2('manage_price');
        $this->data['content'] = $this->model_master->price_category_detail();
        $this->load->view('master/administration/price_category_detail.php',$this->data);
	}
	public function productpricecategory_add()
	{
		$this->auth->cek2('manage_edit_price');
        $this->load->model('model_master');
        $this->model_master->productpricecategory_add();
        redirect(base_url('master/productpricecategory_list'));
	}
	public function productpricecategory_edit()
	{
		$this->auth->cek2('manage_edit_price');
        $this->model_master->productpricecategory_edit();
        redirect(base_url('master/productpricecategory_list'));
	}
	
// price=======================================================================
	public function price_list()
	{
		$this->auth->cek2('manage_price');
        $this->data['PageTitle'] = 'PROMO PIECE ';
        $this->data['body'] = 'master/administration/price_list.php';
		$this->data['data']['content'] = $this->model_master->price_list();
        $this->data['data']['help'] = 'Price List v.1';
        $this->data['data']['menu'] = 'price_list';
		$this->load->view('main',$this->data);
	}
	public function price_list_detail() 
	{
		$this->auth->cek2('manage_price');
        $this->data['content'] = $this->model_master->price_list_detail();
		$this->data['content']['category'] = $this->model_master->get_full_category();
		$this->data['content']['brand'] = $this->model_master->get_full_brand();
        $this->load->view('master/administration/price_list_detail.php',$this->data);
	}
	public function price_list_cu($val)
	{
	    $this->auth->cek2('manage_edit_price');
        $this->data['PageTitle'] = 'ADD/EDIT PROMO PIECE ';
        $this->data['body'] = 'master/administration/price_list_cu.php';
		$this->data['data']['content']['main'] = $this->model_master->price_list_cu($val);
		$this->data['data']['content']['category'] = $this->model_master->get_full_category();
		$this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Price List v.1';
        $this->data['data']['menu'] = 'price_list';
		$this->load->view('main',$this->data);
	}
	public function price_list_cu_act()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master->price_list_cu_act();
        redirect(base_url('master/price_list'));
	}
	public function price_add()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master->price_add();
        redirect(base_url('master/price_list'));
	}
	public function price_edit()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master->price_edit();
        redirect(base_url('master/price_list'));
	}
	public function update_product_price_by_filter()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master->update_product_price_by_filter();
	}
	public function clear_price_list()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master->clear_price_list();
	}

// promo volume================================================================
	public function promo_volume()
	{
		$this->auth->cek2('manage_price');
        $this->data['PageTitle'] = 'PROMO VOLUME';
        $this->data['body'] = 'master/administration/promo_volume.php';
		$this->data['data']['content'] = $this->model_master2->promo_volume_list();
        $this->data['data']['help'] = 'Promo Volume v.1';
        $this->data['data']['menu'] = 'promo_volume';
		$this->load->view('main',$this->data);
	}
	public function promo_volume_detail() 
	{
		$this->auth->cek2('manage_price');
        $this->data['content'] = $this->model_master2->promo_volume_detail();
		$this->data['content']['category'] = $this->model_master->get_full_category();
		$this->data['content']['brand'] = $this->model_master->get_full_brand();
        $this->load->view('master/administration/promo_volume_detail.php',$this->data);
	}
	public function promo_volume_cu($val)
	{
	    $this->auth->cek2('manage_edit_price');
        $this->data['PageTitle'] = 'ADD/EDIT PROMO VOLUME';
        $this->data['body'] = 'master/administration/promo_volume_cu.php';
		$this->data['data']['content']['main'] = $this->model_master2->promo_volume_cu($val);
		$this->data['data']['content']['category'] = $this->model_master->get_full_category();
		$this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Promo Volume v.1';
        $this->data['data']['menu'] = 'promo_volume';
		$this->load->view('main',$this->data);
	}
	public function promo_volume_cu_act()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master2->promo_volume_cu_act();
        redirect(base_url('master/promo_volume'));
	}
	public function update_product_promovol_by_filter()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master2->update_product_promovol_by_filter();
	}
	public function clear_promo_volume()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master2->clear_promo_volume();
	}

// ============================================================================
	public function cek_product_pricelist()
	{
        $this->model_master->cek_product_pricelist();
	}
	public function cek_product_promovol()
	{
        $this->model_master2->cek_product_promovol();
	}

// manage hrd==============================================================
	public function penalty_list()
	{
	    $this->auth->cek2('penalty_list');
        $this->data['PageTitle'] = 'PENALTY LIST';
        $this->data['body'] = 'master/hrd/penalty_list.php';
		$this->data['data']['content' ]= $this->model_master->penalty_list() ;
        $this->data['data']['help'] = 'doc';
        $this->data['data']['menu'] = 'penalty_list';
		$this->load->view('main',$this->data);
	}

	public function penalty_add()
	{
        $this->auth->cek2('penalty_list');
        $this->data['PageTitle'] = 'Penalty Add';
        $this->data['body'] = 'master/hrd/penalty_add.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'penalty_add';
        $this->load->view('main',$this->data);
	}
	public function penalty_add_act()
	{
        $this->auth->cek2('penalty_list');
        $this->model_master->penalty_add_act();
        redirect(base_url('master/penalty_list'));
	}
	public function penalty_edit()
	{
        $this->auth->cek2('penalty_list');
        $this->data['PageTitle'] = 'Penalty Edit';
        $this->data['body'] = 'master/hrd/penalty_edit.php';
        $this->data['data']['content'] = $this->model_master->penalty_edit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'penalty_list';
        // print_r(json_encode($this->data['data']['content']));
        $this->load->view('main',$this->data);
	}
	public function penalty_edit_act()
	{
        $this->auth->cek2('penalty_list');
        $this->model_master->penalty_edit_act();
        redirect(base_url('master/penalty_list'));
	}
	public function sop_list()
	{
        $this->auth->cek2('sop_list');
        $this->data['PageTitle'] = 'SOP LIST';
        $this->data['body'] = 'report/sop_list.php';
        // $this->data['data']['content'] = $this->model_report->report_customer_complaint();
        $this->data['data']['content'] = $this->model_master->sop_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sop_list';
        $this->load->view('main',$this->data);
	}
	public function sop_list_add()
	{
		$this->auth->cek2('sop_list');
        $this->data['PageTitle'] = 'SOP Add';
        $this->data['body'] = 'report/sop_list_add.php';
        $this->data['data']['content'] = $this->model_master->sop_list_add();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sop_list';
        $this->load->view('main',$this->data);
	}
	public function sop_list_add_act()
	{
        $this->auth->cek2('sop_list');
        $this->data['content'] = $this->model_master->sop_list_add_act();
        redirect(base_url('master/sop_list'));
	}
	public function sop_list_cancel()
	{
		$this->auth->cek2('sop_list');
		$this->model_master->sop_list_cancel();
	}
	public function sop_list_edit()
	{
		$this->auth->cek2('sop_list');
        $this->data['PageTitle'] = 'SOP Update';
        $this->data['body'] = 'report/sop_list_edit.php';
        $this->data['data']['content'] = $this->model_master->sop_list_edit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sop_list';
        $this->load->view('main',$this->data);
	}
	public function sop_list_edit_act()
	{
        $this->auth->cek2('sop_list');
        $this->data['content'] = $this->model_master->sop_list_edit_act();
        redirect(base_url('master/sop_list'));
	}
	public function get_code()
	{
		$this->model_master->get_code();
	}

// manage shop=================================================================

// shop list===================================================================
	public function shop_list()
	{
		$this->auth->cek2('shop_list');
        $this->data['PageTitle'] = 'SHOP LIST';
        $this->data['body'] = 'master/shop/shop_list.php';
		$this->data['data']['content' ]= $this->model_master2->shop_list() ;
        $this->data['data']['help'] = 'doc';
        $this->data['data']['menu'] = 'shop_list';
		$this->load->view('main',$this->data);
	}
	public function shop_cu($val)
	{
		$this->auth->cek2('shop_cu');
        $this->data['PageTitle'] = 'ADD/EDIT SHOP';
        $this->data['body'] = 'master/shop/shop_cu.php';
		$this->data['data']['content'] = $this->model_master2->shop_cu($val);
		$this->data['data']['content']['sales'] = $this->model_master->fill_sales($val);
        $this->data['data']['help'] = 'doc';
        $this->data['data']['menu'] = 'shop_list';
		$this->load->view('main',$this->data);
	}
	public function shop_cu_act()
	{
		$this->auth->cek2('shop_cu');
        $this->model_master2->shop_cu_act();
        redirect(base_url('master/shop_list'));
	}
	public function shop_update_link($val)
	{
		$this->auth->cek2('shop_update_link');
        $this->data['PageTitle'] = 'UPDATE LINK PRODUCT';
        $this->data['body'] = 'master/shop/shop_update_link.php';
		$this->data['data']['content'] = $this->model_master2->shop_update_link($val);
        $this->data['data']['help'] = 'doc';
        $this->data['data']['menu'] = 'shop_list';
		$this->load->view('main',$this->data);
	}
	public function shop_update_link_act()
	{
		$this->auth->cek2('shop_update_link');
        $this->model_master2->shop_update_link_act();
	}
	public function shop_detail() 
	{
		$this->auth->cek2('shop_list');
        $this->data['content'] = $this->model_master2->shop_detail();
        $this->load->view('master/shop/shop_detail.php',$this->data);
	}

// ============================================================================

// Link Product=======================================================================
	public function product_link_list()
	{
	    $this->auth->cek2('product_link_list');
        $this->data['PageTitle'] = 'LIST LINK PRODUCT';
        $this->data['body'] = 'master/shop/product_link_list.php';
		$this->data['data']['content' ]= $this->model_master2->product_link_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_link_list';
		$this->load->view('main',$this->data);
	}
	public function product_link_list_act($val)
	{
		$this->auth->cek2('product_link_list');
		$this->model_master2->product_link_list_act($val);
	}
	public function product_link_reject()
	{
        $this->auth->cek2('product_link_list');
        $this->data['PageTitle'] = 'Reject Link';
        $this->data['body'] = 'master/shop/product_link_reject.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_link_list';
        $this->load->view('main',$this->data);
	}
	public function product_link_reject_act()
	{
		$this->auth->cek2('product_link_list');
		$this->model_master2->product_link_reject_act();
        redirect(base_url('report/report_product_shop'));
	}


//fungsi cuman untuk custom
	public function customer_list_data2_perbaikan()
	{
		$num_char = 30;
    	$this->auth->cek2('customer_list');
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
	        'table' => 'vw_customer4', 
	        'column_order' => array('ContactID','CustomerID','Company2','CustomercategoryName','phone','Address','isActive','Sales',null), 
	        'column_search' => array('ContactID','CustomerID','Company2','Address','Sales'),  
	        'order' => array('CustomerID' => 'asc')  
	    );
	    $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$status = ($field->isActive == 1 ? "Active" : "notActive");
			$row = array();
			$row[] = $field->ContactID;
			$row[] = $field->CustomerID;
			$row[] = '<a class="linkname view" data-toggle="modal" data-target="#modal-contact">'.$field->Company2.'</a>';
			$row[] = $field->CustomercategoryName;
			$row[] = $field->phone;
			$row[] = substr($field->Address, 0, $num_char) . '...';
			$row[] = $field->Sales;
			
			$row[] = $status;
			$row[] = '<button type="button" class="btn btn-flat btn-primary btn-xs view" data-toggle="modal" data-target="#modal-contact"><i class="fa fa-fw fa-file-image-o"></i></button> 
					  <button type="button" class="btn btn-primary btn-xs detail" title="CFU"  data-toggle="modal" data-target="#modal-detail"><b>+</b>CFU</button>';

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

}
