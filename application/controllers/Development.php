<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Development extends CI_Controller {
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
	    $this->load->model('model_development');
	    $this->load->model('model_master');
	    $this->load->model('model_transaction');
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
        $this->data['body'] = 'development/index.php';
        $this->data['PageTitle'] = 'DEVELOPMENT';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'development';
		$this->load->view('main',$this->data);
	}
	// report_perbaikan_customer==================================================
	public function perbaikan_report_customer()
	{	
		$this->auth->cek2('perbaikan_report_customer'); 
        $this->data['PageTitle'] = 'Customer List';
        $this->data['body'] = 'development/perbaikan_report_customer.php';
        //$this->data['data']['content'] = $this->model_report->pv_by_inv(); 
        $this->data['data']['help'] = 'Doc';	
        $this->data['data']['menu'] = 'perbaikan_report_customer';
		$this->load->view('main',$this->data);
	}
	// report_perbaikan_inv_100_cities_east_customer==============================
	public function perbaikan_report_inv_100_cities_east_customer()
	{	
		$this->auth->cek2('perbaikan_report_inv_100_cities_east_customer'); 
        $this->data['PageTitle'] = 'REPORT INVOICE 100 EAST CUSTOMER';
        $this->data['body'] = 'development/perbaikan_report_inv_100_cities_east_customer.php';
        $this->data['data']['content'] = $this->model_development->report_inv_100_cities_east_customer();
        $this->data['data']['help'] = 'Doc';	
        $this->data['data']['menu'] = 'perbaikan_report_inv_100_cities_east_customer';
		$this->load->view('main',$this->data);
	}
	// report_perbaikan_inv_100_cities_west_customer==============================
	public function perbaikan_report_inv_100_cities_west_customer()
	{	
		$this->auth->cek2('perbaikan_report_inv_100_cities_west_customer'); 
        $this->data['PageTitle'] = 'REPORT INVOICE CUSTOMER';
        $this->data['body'] = 'development/perbaikan_report_inv_100_cities_east_customer.php';
        $this->data['data']['content'] = $this->model_development->report_inv_100_cities_west_customer();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_inv_100_cities_west_customer';
		$this->load->view('main',$this->data);
	}
	// report_perbaikan_do_consignment============================================
	public function report_perbaikan_do_consignment()
	{	
		$this->auth->cek2('report_perbaikan_do_consignment'); 
        $this->data['PageTitle'] = 'REPORT DO COnsignment';
        $this->data['body'] = 'report/report_perbaikan_do_consignment.php';
        $this->data['data']['content'] = $this->model_report->report_do_consignment();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_perbaikan_do_consignment';
		$this->load->view('main',$this->data);
	}	
	// report_perbaikan_customer_sales============================================
	public function perbaikan_report_customer_sales()
	{	
		$this->auth->cek2('perbaikan_report_customer_sales'); 
        $this->data['PageTitle'] = 'REPORT CUSTOMER BY SALES';
        $this->data['body'] = 'development/perbaikan_report_customer_sales.php';
        $this->data['data']['content'] = $this->model_development->report_customer_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_customer_sales';
		$this->load->view('main',$this->data);
	}	
	public function perbaikan_report_customer_sales_detail()
	{
	    $this->auth->cek2('perbaikan_report_customer_sales'); 
    	$this->data['content'] = $this->model_development->report_customer_sales_detail(); 
        $this->load->view('development/perbaikan_report_customer_sales_detail.php',$this->data);
	}
	// report_perbaikan_customer_sales============================================
	public function perbaikan_report_customer_city_z()
	{	
		$this->auth->cek2('perbaikan_report_customer_city_z'); 
        $this->data['PageTitle'] = 'REPORT CUSTOMER BY CITY Z';
        $this->data['body'] = 'development/perbaikan_report_customer_city_z.php';
        $this->data['data']['content'] = $this->model_development->report_customer_city();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_customer_city_z';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_report_customer_city_detail_z()
	{
	    $this->auth->cek2('perbaikan_report_customer_city_z'); 
    	$this->data['content'] = $this->model_development->report_customer_city_detail(); 
        $this->load->view('development/perbaikan_report_customer_city_detail_z.php',$this->data);
	}
	public function perbaikan_report_customer_city()
	{	
		$this->auth->cek2('perbaikan_report_customer_city'); 
        $this->data['PageTitle'] = 'REPORT CUSTOMER BY CITY';
        $this->data['body'] = 'development/perbaikan_report_customer_city.php';
        $this->data['data']['content'] = $this->model_development->report_customer_city();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_customer_city';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_report_customer_city_detail()
	{
	    $this->auth->cek2('perbaikan_report_customer_city'); 
    	$this->data['content'] = $this->model_development->report_customer_city_detail(); 
        $this->load->view('development/perbaikan_report_customer_city_detail.php',$this->data);
	}
	public function perbaikan_report_customer_city_act()
	{
	    $this->auth->cek2('report_perbaikan_customer_city'); 
    	$this->data['content'] = $this->model_development->report_customer_city_act(); 
	}
	public function perbaikan_report_product_kpi()
	{	
		$this->auth->cek2('perbaikan_report_product_kpi'); 
        $this->data['PageTitle'] = 'REPORT PRODUCT KPI';
        $this->data['body'] = 'development/perbaikan_report_product_kpi.php';
        $this->data['data']['content']['main'] = $this->model_development->report_product_kpi(); 
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_product_kpi';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_report_customer_display()
	{
		$this->auth->cek2('perbaikan_report_customer_display'); 
        $this->data['PageTitle'] = 'REPORT CUSTOMER (DISPLAY) BY CITY';
        $this->data['body'] = 'development/perbaikan_report_customer_display.php';
        $this->data['data']['content'] = $this->model_development->report_customer_display(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_perbaikan_customer_display';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_report_customer_display_detail()
	{
	    $this->auth->cek2('perbaikan_report_customer_display'); 
    	$this->data['content'] = $this->model_development->report_customer_display_detail(); 
        $this->load->view('development/perbaikan_report_customer_display_detail.php',$this->data);
	}
	public function perbaikan_report_contact_list()
	{	
	    $this->auth->cek2('perbaikan_report_contact_list'); 
        $this->data['PageTitle'] = 'LIST CONTACT';
        $this->data['body'] = 'development/perbaikan_report_contact_list2.php';
        $this->data['data']['help'] = 'CONTACT_LIST_v.1';
        $this->data['data']['menu'] = 'perbaikan_report_contact_list';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_report_contact_list_detail() 
	{
	    $this->auth->cek2('perbaikan_report_contact_list'); 
        $this->data['content'] = $this->model_development->contact_list_detail(); 
        $this->load->view('development/perbaikan_report_contact_list_detail.php',$this->data);
    }
    public function perbaikan_report_product_stock_ready() 
	{
	    $this->auth->cek2('perbaikan_report_product_stock_ready'); 
        $this->data['PageTitle'] = 'REPORT PERBAIKAN PRODUCT STOCK READY';
        $this->data['body'] = 'development/perbaikan_report_product_stock_ready.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_product_stock_ready';
		$this->load->view('main',$this->data);
    }
    function perbaikan_report_product_stock_ready_data()
	{
	    $this->auth->cek2('perbaikan_report_product_stock_ready'); 
	    
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
	        'table' => 'vw_stock_product_ready', 
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','stock','sopending','rawpending','ReadyStock','sopendingNonConfirm','ProductDescription'), 
	        'column_order' => array('t1.ProductID','ProductCode','ProductName','stock','sopending','rawpending','ReadyStock','sopendingNonConfirm','ProductDescription'), 
	        'column_search' => array('t1.ProductID','ProductCode','ProductName','ProductDescription'), 
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			} 
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}
			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = $field->ProductName;
			$row[] = $field->stock;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $field->ReadyStock;
			$row[] = $sopendingNonConfirm;
			// $row[] = number_format($field->stockWarehouse);
			$row[] = 0;
			$row[] = $field->ProductDescription;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function perbaikan_report_cfu()
	{	
	    $this->auth->cek2('perbaikan_report_cfu'); 
        $this->data['PageTitle'] = 'MARKETING CALL FOLLOW UP';
        $this->data['body'] = 'development/perbaikan_report_cfu.php';
        $this->data['data']['content'] = $this->model_development->cfu();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'perbaikan_report_cfu';
		$this->load->view('main',$this->data);
	}
	public function cfu_add()
	{	
	    $this->auth->cek2('perbaikan_report_cfu'); 
        $this->data['PageTitle'] = 'ADD CUSTOMER FOLLOW UP';
        $this->data['body'] = 'development/perbaikan_report_cfu_add2.php';
        $this->data['data']['content'] = $this->model_development->cfu_add();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'perbaikan_report_cfu';
		$this->load->view('main',$this->data);
	}
	public function cfu_act()
	{
	    $this->auth->cek2('perbaikan_report_cfu'); 
    	$this->data['content'] = $this->model_development->cfu_act(); 
    	redirect(base_url('development/cfu_add'));
	}
	public function perbaikan_report_so_complaint()
	{	
		$this->auth->cek2('perbaikan_report_so_complaint'); 
        $this->data['PageTitle'] = 'REPORT SALES ORDER GLOBAL';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER GLOBAL';
        $this->data['body'] = 'development/perbaikan_report_so_complaint.php';
        $this->data['data']['content'] = $this->model_development->report_so_global(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_so_complaint';
		$this->load->view('main',$this->data);
	}
	public function so_complaint_add()
    {   
        $this->auth->cek2('perbaikan_report_so_complaint'); 
        $this->data['PageTitle'] = 'SO Complain Add';
        $this->data['body'] = 'development/perbaikan_complaint_add.php';
            
        $CustomerID = $this->input->get_post('CustomerID'); 
        $SOID = $this->input->get_post('SOID'); 
        $SalesID = $this->input->get_post('SalesID');
            if (isset($CustomerID)) {
                $this->data['data']['content'] = $this->model_development->so_complaint_add(); 
            }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_so_complaint';
        $this->load->view('main',$this->data);
    }
    public function so_complaint_add_act()
    {   
        $this->auth->cek2('perbaikan_report_so_complaint'); 
        $this->data['content'] = $this->model_development->so_complaint_add_act(); 
        redirect(base_url('development/perbaikan_list_complaint'));
    }
    public function perbaikan_list_complaint()
    {   
        $this->auth->cek2('perbaikan_list_complaint'); 
        $this->data['PageTitle'] = 'List Complaint';
        $this->data['body'] = 'development/perbaikan_list_complaint.php';
        $this->data['data']['content'] = $this->model_development->list_complaint(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_list_complaint';
        $this->load->view('main',$this->data);
    }
    public function list_complaint_delete()
    {   
        $this->auth->cek2('perbaikan_list_complaint'); 
        $this->model_development->list_complaint_delete(); 
        redirect(base_url('development/perbaikan_list_complaint'));
    }
    public function perbaikan_marketing_activity_report()
    {   
        $this->auth->cek2('perbaikan_marketing_activity_report'); 
        $this->data['PageTitle'] = 'Report Marketing Activity Monthly';
        $this->data['body'] = 'development/perbaikan_marketing_activity_report.php';
        $this->data['data']['content'] = $this->model_development->marketing_activity_report(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_marketing_activity_report';
        $this->load->view('main',$this->data);
    }
    public function project_list()
    {   
        $this->auth->cek2('project_list'); 
        $this->data['PageTitle'] = 'Project List';
        $this->data['body'] = 'project/list_project.php';
        $this->data['data']['content'] = $this->model_development->list_project(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'project_list';
        $this->load->view('main',$this->data);
    }
    public function project_add()
    {   
        $this->auth->cek2('project_list'); 
        $this->data['PageTitle'] = 'Project Add';
        $this->data['body'] = 'project/project_add.php';
        $this->data['data']['content'] = $this->model_development->project_add(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'project_list';
        $this->load->view('main',$this->data);
    }
    public function project_add_act()
    {   
        $this->auth->cek2('project_list'); 
        $this->model_development->project_add_act(); 
        redirect(base_url('development/project_list'));
    }
    public function project_edit()
    {   
        $this->auth->cek2('project_list'); 
        $this->data['PageTitle'] = 'Project Edit';
        $this->data['body'] = 'project/project_edit.php';
        $this->data['data']['content'] = $this->model_development->project_edit(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'project_list';
        // print_r(json_encode($this->data['data']['content']));
        $this->load->view('main',$this->data);
    }
    public function project_edit_act()
    {   
        $this->auth->cek2('project_list'); 
        $this->model_development->project_edit_act(); 
        redirect(base_url('development/project_list'));
    }
    public function project_so_detail()
	{
	    $this->auth->cek2('project_list'); 
    	$this->data['data']['content'] = $this->model_development->project_so_detail(); 
        $this->load->view('project/project_so_detail.php',$this->data);
	}
	public function project_close()
    {   
        $this->auth->cek2('project_list'); 
        $this->model_development->project_close(); 
        redirect(base_url('development/project_list'));
    }
    public function perbaikan_sales_order_list()
	{	
	    $this->auth->cek2('perbaikan_sales_order_list'); 
        $this->data['PageTitle'] = 'SALES ORDER LIST';
        $this->data['body'] = 'development/perbaikan_sales_order_list.php';
        $this->data['data']['content'] = $this->model_development->sales_order_list(); 
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'perbaikan_sales_order_list';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_sales_order_add()
	{	
	    $this->auth->cek2('perbaikan_sales_order_add'); 
        $this->data['PageTitle'] = 'ADD SALES ORDER';
        $this->data['body'] = 'development/perbaikan_sales_order_add.php';
        $this->data['data']['content'] = $this->model_development->sales_order_add();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'perbaikan_sales_order_add';
		$this->load->view('main',$this->data);
	}
	public function perbaikan_sales_order_add_act()
	{
	    $this->auth->cek2('perbaikan_sales_order_add'); 
    	$this->model_development->sales_order_add_act(); 
        redirect(base_url('development/perbaikan_sales_order_list'));
	}
	public function perbaikan_report_product_shop()
	{	
		$this->auth->cek2('perbaikan_report_product_shop'); 
        $this->data['PageTitle'] = 'REPORT PRODUCT SHOP';
        $this->data['body'] = 'development/perbaikan_report_product_shop.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list(); 
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'perbaikan_report_product_shop';
		$this->load->view('main',$this->data);
	}
	function report_product_shop_data()
	{
	    $this->auth->cek2('shop_list'); 
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
	        'table' => 'vw_product_list_shop_assignment', 
	        'column_select' => array('t1.ProductID','ProductName','ProductCode','CountShop','CountLink','isActive' ), 
	        'column_order' => array(null,'t1.ProductID','ProductName','ProductCode','CountShop','CountLink','isActive',null), 
	        'column_search' => array('t1.ProductID','ProductName','ProductCode'),  
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$document = 
			'<button class="btn btn-primary btn-xs shop" type="button" data-toggle="collapse" data-target="#collapseExample'.$field->ProductID.'" productid='.$field->ProductID.'><i class="fa fa-fw fa-plus-square"></i></button>
			<button type="button" class="btn btn-flat btn-primary btn-xs view_detail" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-info"></i></button>';
            $status = ($field->isActive == 1 ? "Active" : "notActive");

			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductName." (".$field->ProductID.")";
			$row[] = $field->ProductCode;
			$row[] = $field->CountShop.
					'<div class="collapse" id="collapseExample'.$field->ProductID.'">
					  <span class="shopproduct'.$field->ProductID.'"> </span>
					</div>';
			$row[] = $field->CountLink;
			$row[] = $status;
			$row[] = $document;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_detail()
	{
	    $this->auth->cek2('report_product_general'); 
    	$this->data['content'] = $this->model_report->report_product_detail(); 
        $this->load->view('report/report_product_detail.php',$this->data);
	}
	public function product_shop_detail()
	{
		$this->auth->cek2('shop_list'); 
    	$this->model_development->product_shop_detail(); 

        // $this->load->view('report/report_product_detail.php',$this->data);
	}
	public function perbaikan_report_product_price_active()
	{	
		$this->auth->cek2('perbaikan_report_product_price_active'); 
        $this->data['PageTitle'] = 'Product Price Active';
        $this->data['body'] = 'development/perbaikan_report_product_price_active.php';
        $this->data['data']['content']['main'] = $this->model_development->perbaikan_report_product_price_active(); 
        // echo json_encode($this->model_report->report_product_price_active());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_perbaikan_product_price_active';
		$this->load->view('main',$this->data);
	}
	public function product_list_popup_so_offline()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->view('development/product_list_popup_so_offline.php',$this->data);
	}
	function product_list_popup_so_data_offline()
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
	        'table' => 'vw_stock_product_ready', 
	        'column_order' => array(null,'ProductID','ProductCode','stock','ReadyStock','sopendingNonConfirm','ProductPriceDefault','ProductName','InputDate','isActive',null,null), 
	        'column_search' => array('ProductID','ProductName','ProductCode'),  
	        'order' => array('ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
            $status = ($field->isActive == 1 ? "Active" : "notActive");
            
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}

			$row = array();
			$row[] = '<a href="#" class="btn btn-flat btn-primary btn-xs insert_data" stockable="'.$field->Stockable.'" forsale="'.$field->forSale.'">Submit</a>';
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = '<a href="#" class="btn btn-flat btn-primary btn-xs cekStok" ProductID="'.$field->ProductID.'">'.$field->stock.'</a>';
			$row[] = $field->ReadyStock;
			$row[] = $field->sopendingNonConfirm;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductName;
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
	public function search_customer_city()
	{
		$this->model_development->search_customer_city();      
    }
    public function search_customer_city_sales()
	{
		$this->model_development->search_customer_city_sales();      
    }
    public function get_product_price()
    {
		$this->model_development->get_product_price();      
    }
    public function get_product_promo()
    {
		$this->model_development->get_product_promo();      
    }
    public function get_customer_address()
    {
	    $this->auth->cek2('perbaikan_sales_order_add'); 
        $this->load->model('model_master');
		$this->model_master->get_customer_address();      
    }

//===========FAJAR ========================================================
	public function stock_check()
	{
		$this->auth->cek2('stock_check');
		$this->data['PageTitle'] = 'STOCK CHECK';
		$this->data['body'] = 'transaction/stock_check_list.php';
		// $this->data['data']['content'] = $this->model_transaction->stock_adjustment_list();
		$this->data['data']['content'] = $this->model_development->stock_check_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'stock_check';
		$this->load->view('main',$this->data);
	}
	public function stock_check_detail()
	{
		$this->auth->cek2('stock_check');
		// $this->data['content'] = $this->model_transaction->stock_check_detail();
		$this->data['content'] = $this->model_development->stock_check_detail();
		$this->load->view('transaction/stock_check_detail.php',$this->data);
	}
	public function stock_check_add()
	{
		$this->auth->cek2('stock_check');
		$this->data['PageTitle'] = 'ADD STOCK CHECK';
		$this->data['body'] = 'transaction/stock_check_add.php';

		$id = $this->input->get_post('id');
		if (isset($id)) {
			//$this->data['data']['content'] = $this->model_transaction->stock_check_edit();
			$this->data['data']['content'] = $this->model_development->stock_check_edit();
		}
		$this->load->model('model_master2');
		$this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
		// $this->data['data']['warehouse'] = $this->model_development->warehouse_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'stock_check';
		$this->load->view('main',$this->data);
	}

	public function stock_check_add_act()
	{
		$this->auth->cek2('stock_check');
		// $this->model_transaction->stock_check_add_act();
		$this->model_development->stock_check_add_act();
		redirect(base_url('development/stock_check'));
	}
	public function stock_check_approval_submission()
	{
		$this->auth->cek2('stock_check');
		// $this->model_transaction->stock_check_approval_submission();
		$this->model_development->stock_check_approval_submission();
	}
	public function stock_check_cancel()
	{
		$this->auth->cek2('stock_check');
		// $this->model_transaction->stock_chceck_cancel();
		$this->model_development->stock_check_cancel();
	}

	public function report_stock_adjustment_balance()
	{
	    $this->auth->cek2('report_stock_adjustment_balance');
        $this->data['PageTitle'] = 'REPORT STOCK CHECK';
        $this->data['body'] = 'report/report_stock_adjustment_balance.php';
        $this->data['data']['content'] = $this->model_development->report_stock_adjustment_balance();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_stock_adjustment_balance';
		$this->load->view('main',$this->data);

	}
	public function get_report_stock_adjustment_detail()
	{
	    $this->auth->cek2('report_stock_adjustment_balance');
	    $this->data['PageTitle'] = 'PRODUCT CHECK STOCK HISTORY';
        $this->data['content'] = $this->model_development->get_report_stock_adjustment_detail();
        // $this->data['data']['help'] = 'Doc';
        // echo json_encode($this->data['content']);
        $this->load->view('transaction/product_stock_balance_history.php',$this->data);
	}

	public function sop_list()
	{
        $this->auth->cek2('sop_list');
        $this->data['PageTitle'] = 'SOP LIST';
        $this->data['body'] = 'report/sop_list.php';
        // $this->data['data']['content'] = $this->model_report->report_customer_complaint();
        $this->data['data']['content'] = $this->model_development->sop_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sop_list';
        $this->load->view('main',$this->data);
	}
	public function sop_list_add()
	{
		$this->auth->cek2('sop_list');
        $this->data['PageTitle'] = 'SOP Add';
        $this->data['body'] = 'report/sop_list_add.php';
        $this->data['data']['content'] = $this->model_development->sop_list_add();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sop_list';
        $this->load->view('main',$this->data);
	}
	public function sop_list_add_act()
	{
        $this->auth->cek2('sop_list');
        $this->data['content'] = $this->model_development->sop_list_add_act();
        redirect(base_url('development/sop_list'));
	}
	public function sop_list_cancel()
	{
		$this->auth->cek2('sop_list');
		$this->model_development->sop_list_cancel();
	}
	public function sop_list_edit()
	{
		$this->auth->cek2('sop_list');
        $this->data['PageTitle'] = 'SOP Update';
        $this->data['body'] = 'report/sop_list_edit.php';
        $this->data['data']['content'] = $this->model_development->sop_list_edit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'sop_list';
        $this->load->view('main',$this->data);
	}
	public function sop_list_edit_act()
	{
        $this->auth->cek2('sop_list');
        $this->data['content'] = $this->model_development->sop_list_edit_act();
        redirect(base_url('development/sop_list'));
	}
	public function get_code()
	{
		$this->model_development->get_code();
	}
}
