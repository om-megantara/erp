<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {
	public function __construct()
    {
	    parent::__construct();
	    date_default_timezone_set('Asia/Jakarta');
        // cek login
	    $this->load->library('Auth');
	    $this->auth->cek();
        // cek referrer
        $this->auth->cek3(); //cek jika link dari luar
	    // save log
	    $this->log_user->log_page();
	    // cek notif
	    $this->load->library('Notification'); 

	    $this->data = array(
	        'notification' => $this->notification->notif_all(),
	        'menu' => 'menu.php',
	        'EmployeeID' => $this->session->userdata('EmployeeID'),
	        'SalesID' => $this->session->userdata('SalesID'),
	        'ContactID' => $this->session->userdata('ContactID'),
	        'UserName' => $this->session->userdata('UserName'),
	        'CreatedDate' => $this->session->userdata('CreatedDate'),
	        'JobTitleCode' => $this->session->userdata('JobTitleCode'),
	        'MainTitle' => $this->session->userdata('MainTitle'),
	        'MenuList' => $this->session->userdata('MenuList'),
	        'image' => $this->session->userdata('image'),
	        'error_info' => $this->session->userdata('error_info'),
	        'data' => array()
	    );
	}

	public function index()
	{	
		redirect(base_url());
	}

// =======================================================================
	public function emptyJson()
	{
		$data = array();
		$output = array(
			"draw" => 1,
			"recordsTotal" => 0,
			"recordsFiltered" => 0,
			"data" => $data,
		);
		echo json_encode($output);
	}
    public function product_list_popup()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list(); 
        $this->load->view('master/product/product_list_popup.php',$this->data);
	}
	public function product_list_popup_data()
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
	        'column_order' => array(null,null,'ProductID','ProductName','ProductCode','ProductPriceDefault','ProductCategoryName','ProductBrandName','stock','ProductStatusName','ProductDescription','isActive'), 
	        'column_search' => array('ProductID','ProductName','ProductCode','ProductPriceDefault','ProductCategoryName','ProductBrandName'),  
	        'order' => array('ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no1 = 0;
		$no2 = $_POST['start'];
		foreach ($list as $field) {
            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$no1++;
			$no2++;

			$row = array();
			$row[] = $no1;
			$row[] = $no2;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->stock;
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductDescription;
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
	public function product_list_popup_warehouse()
	{
        $this->data['data']['help'] = 'Doc';
        
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list(); 
        $this->load->view('master/product/product_list_popup_warehouse.php',$this->data);
	}
	public function product_list_popup_warehouse_check()
	{
		$this->data['data']['help'] = 'Doc';

		$this->load->model('model_master');
		$this->data['data']['content']['category'] = $this->model_master->get_full_category();
		$this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
		$this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
		$this->load->view('master/product/product_list_popup_warehouse_check.php',$this->data);
	}
	public function product_list_popup_warehouse_data()
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
		'column_order' => array(null,null,'t1.ProductID','ProductName','ProductCode','stockWarehouse','ProductPriceDefault','ProductCategoryName','ProductBrandName','ProductStatusName','ProductDescription','isActive'),
		'column_search' => array('t1.ProductID','ProductName','ProductCode','ProductCategoryName','ProductBrandName'),
		'order' => array('t1.ProductID' => 'asc')
		);

		$this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no1 = 0;
		$no2 = $_POST['start'];
		foreach ($list as $field) {
			$status = ($field->isActive == 1 ? "Active" : "notActive");
			$no1++;
			$no2++;

			$row = array();
			$row[] = $no1;
			$row[] = $no2;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = $field->stockWarehouse;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductDescription;
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
	public function product_list_popup_warehouse_data_check()
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
			'table' => 'vw_product_list_popup2_active_check',
			'column_order' => array(null,null,'t1.ProductID','ProductName','ProductCode','ProductPriceDefault','ProductCategoryName','ProductBrandName','ProductStatusName','ProductDescription','isActive','LastCheck','Dcheck'),
			'column_search' => array('t1.ProductID','ProductName','ProductCode','ProductCategoryName','ProductBrandName'),
			'order' => array('t1.ProductID' => 'asc')
		);

		$this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no1 = 0;
		$no2 = $_POST['start'];
		foreach ($list as $field) {
			$ProductID=$field->ProductID;
			$sql="SELECT a.ProductID,a.isApprove
					FROM tb_product_stock_adjustment_detail a
					LEFT JOIN tb_product_stock_adjustment b on a.AdjustmentID=b.AdjustmentID
					WHERE a.ProductID=".$ProductID." and a.isApprove=1";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			if (empty($row)){
				$block=0;
			} else {
				$block=1;
			}
		    $status = ($field->isActive == 1 ? "Active" : "notActive");
			$no1++;
			$no2++;

			$row = array();
			$row[] = $no1;
			$row[] = $no2;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			//$row[] = $field->stockWarehouse;
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductDescription;
		    $row[] = $status;
		    $row[] = $field->LastCheck." (".$field->DCheck.")";
		    $row[] = $block;

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
	public function product_list_popup_opname()
	{
        $this->data['data']['help'] = 'Doc';
        
        $this->load->model('model_transaction');
    	$this->data['content'] = $this->model_transaction->product_stock_opname_detail(); 
        $this->load->view('master/product/product_list_popup_opname.php',$this->data);
	}
	public function product_list_popup_opname2()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->model('model_transaction');
    	$this->data['content'] = $this->model_transaction->product_stock_opname_detail2(); 
        $this->load->view('master/product/product_list_popup_opname.php',$this->data);
	}
    public function sales_order_print()
	{
	    $this->auth->cek2('menu_report_so'); 
        $this->data['PageTitle'] = 'SO Print';
        $this->load->model('model_transaction');
    	$this->data['content'] = $this->model_transaction->sales_order_print(); 
        $this->load->view('transaction/sales_order_print_3.php',$this->data);
        // $this->load->view('transaction/sales_order_print2.php',$this->data);
	}
	public function invoice_payment_detail() 
	{
        $this->load->model('model_finance');
        $this->data['content'] = $this->model_finance->invoice_payment(); 
        $this->load->view('finance/invoice_payment_detail.php',$this->data);
    }
	public function do_history() 
	{
        $this->load->model('model_transaction');
        $this->data['content'] = $this->model_transaction->do_history(); 
        $this->load->view('transaction/do_history.php',$this->data);
    }
    public function print_faktur()
	{
        $this->load->model('model_transaction');
        $this->data['PageTitle'] = 'FAKTUR Print';
    	$this->data['content'] = $this->model_transaction->print_faktur(); 
        $this->load->view('transaction/print_faktur.php',$this->data);
	}
    public function print_invoice()
	{
        $this->load->model('model_transaction');
        $this->data['PageTitle'] = 'INVOICE Print';
    	$this->data['content'] = $this->model_transaction->print_invoice(); 
        $this->load->view('transaction/print_invoice_pdf.php',$this->data);
        // $this->load->view('transaction/print_invoice.php',$this->data);
	}
    public function print_invoice2()
	{
        $this->load->model('model_transaction');
        $this->data['PageTitle'] = 'INVOICE Print';
    	$this->data['content'] = $this->model_transaction->print_invoice(); 
        $this->load->view('transaction/print_invoice3.php',$this->data);
	}
    public function print_invoice_retur()
	{
        $this->load->model('model_transaction');
        $this->data['PageTitle'] = 'INVOICE RETUR Print';
    	$this->data['content'] = $this->model_transaction->print_invoice_retur(); 
        $this->load->view('transaction/print_invoice_retur.php',$this->data);
	}
	public function delivery_order_print()
	{
        $this->data['PageTitle'] = 'DO Print';
        $this->load->model('model_transaction');
        if ($this->input->get_post('type') == "RAW") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_raw_print(); 
	        // $this->load->view('transaction/delivery_order_raw_print.php',$this->data);
	        $this->load->view('transaction/delivery_order_raw_print_pdf.php',$this->data);
        } elseif ($this->input->get_post('type') == "MUTATION") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_mutation_print(); 
	        // $this->load->view('transaction/delivery_order_mutation_print.php',$this->data);
	        $this->load->view('transaction/delivery_order_mutation_print_pdf.php',$this->data);
        } elseif ($this->input->get_post('type') == "SO") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_so_print(); 
	        // $this->load->view('transaction/delivery_order_so_print.php',$this->data);
	        $this->load->view('transaction/delivery_order_so_print_pdf.php',$this->data);
        }
	}
	public function delivery_order_print2()
	{
        $this->data['PageTitle'] = 'DO Print';
        $this->load->model('model_transaction');
        if ($this->input->get_post('type') == "RAW") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_raw_print(); 
	        $this->load->view('transaction/delivery_order_raw_print.php',$this->data);
        } elseif ($this->input->get_post('type') == "MUTATION") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_mutation_print(); 
	        $this->load->view('transaction/delivery_order_mutation_print.php',$this->data);
        } elseif ($this->input->get_post('type') == "SO") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_so_print(); 
	        $this->load->view('transaction/delivery_order_so_print2.php',$this->data);
        }
	}
    
// fill========================================================================================
	public function search_expedition()
	{
        $this->load->model('model_master');
		$this->model_master->search_expedition();
	}
	public function search_contact()
	{
        $this->load->model('model_master');
		$this->model_master->search_contact();
	}
	public function search_customer_by_sales()
	{
        $this->load->model('model_master');
		$this->model_master->search_customer_by_sales();
	}
	public function search_customer()
	{
        $this->load->model('model_master');
		$this->model_master->search_customer();
	}
	public function search_customer_having_sales()
	{
        $this->load->model('model_master');
		$this->model_master->search_customer_having_sales();
	}
	public function search_customer_city()
	{
        $this->load->model('model_master');
		$this->model_master->search_customer_city();      
    }
    public function search_customer_city_sales()
	{
        $this->load->model('model_master');
		$this->model_master->search_customer_city_sales();      
    }
	public function get_atribute_detail()
	{
        $this->load->model('model_master');
		$this->model_master->get_atribute_detail();
	}
	public function fill_warehouse()
	{
        $this->load->model('model_master2');
		$this->model_master2->warehouse_list();
	}
	public function ajax_product_category_list_jstree()
	{
        $this->load->model('model_master');
    	echo json_encode($this->model_master->ajax_product_category_list_jstree()); 
	}
	public function ajax_product_category_list_jstree_table()
	{
        $this->load->model('model_master');
    	echo json_encode($this->model_master->ajax_product_category_list_jstree_table()); 
	}
	public function ajax_product_brand_list_jstree()
	{
        $this->load->model('model_master');
    	echo json_encode($this->model_master->ajax_product_brand_list_jstree()); 
	}
	public function ajax_product_brand_list_jstree_table()
	{
        $this->load->model('model_master');
    	echo json_encode($this->model_master->ajax_product_brand_list_jstree_table()); 
	}
	public function contact_print()
	{
        $this->load->model('model_master');
    	$this->data = $this->model_master->contact_label(); 
        $this->load->view('report/report_perbaikan_contact_print.php',$this->data);
	}

}
