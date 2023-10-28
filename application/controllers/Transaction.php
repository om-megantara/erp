<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH.'libraries/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Transaction extends CI_Controller {
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

        $this->load->model('model_transaction');
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

//invoice ============================================================
	public function invoice_list()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'INVOICE';
        $this->data['body'] = 'transaction/invoice_list.php';

        $list1 = $this->model_transaction->invoice_list_so();
        $list2 = $this->model_transaction->invoice_list_do();
        $this->data['data']['content'] = array_merge($list1,$list2);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_list';
		$this->load->view('main',$this->data);
	}
	public function detail_to_invoice()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'CREATE INVOICE';
        $this->data['body'] = 'transaction/detail_to_invoice.php';
        $this->data['data']['content']['list1'] = $this->model_transaction->do_to_inv(); 
        $this->data['data']['content']['list2'] = $this->model_transaction->so_to_inv(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_list';
		$this->load->view('main',$this->data);
	}
	public function invoice_add()
	{
	    $this->auth->cek2('invoice_add'); 
        $this->data['PageTitle'] = 'ADD INVOICE';
        if (isset($_GET['do'])) {
	        $this->data['body'] = 'transaction/invoice_add_do.php';
	        $this->data['content'] = $this->model_transaction->do_to_inv_detail();
        } elseif (isset($_GET['so'])) {
	        $this->data['body'] = 'transaction/invoice_add_so.php';
	        $this->data['content'] = $this->model_transaction->so_to_inv_detail();
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_list';
		$this->load->view('main',$this->data);
	}
	public function invoice_add_act()
	{
	    $this->auth->cek2('invoice_add'); 
    	$this->model_transaction->invoice_add_act(); 
        redirect(base_url('transaction/detail_to_invoice'));
	}
	public function invoice_add_act_batch()
	{
	    $this->auth->cek2('invoice_add'); 
    	$this->model_transaction->invoice_add_act_batch(); 
        // redirect(base_url('transaction/detail_to_invoice'));
	}
	public function print_invoice()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'INVOICE Print';
    	$this->data['content'] = $this->model_transaction->print_invoice(); 
        // $this->load->view('transaction/print_invoice_pdf.php',$this->data);
        $this->load->view('transaction/print_invoice.php',$this->data);
	}
	public function print_invoice_offline()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'INVOICE Print';
    	$this->data['content'] = $this->model_transaction->print_invoice(); 
        $this->load->view('transaction/print_invoice_offline.php',$this->data);
	}
	public function print_invoice_offline_new()
	{
		$this->auth->cek2('invoice_list');
		$this->data['PageTitle'] = 'INVOICE Print';
		$this->data['content'] = $this->model_transaction->print_invoice();
		$this->load->view('transaction/print_invoice_offline_new.php',$this->data);
	}
	public function print_invoice2()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'INVOICE Print';
    	$this->data['content'] = $this->model_transaction->print_invoice(); 
        $this->load->view('transaction/print_invoice3.php',$this->data);
        // $this->load->view('transaction/print_invoice3.php',$this->data);
	}
	public function print_freight_charge()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'FREIGHT CHARGE Print';
    	$this->data['content'] = $this->model_transaction->print_freight_charge(); 
        $this->load->view('transaction/print_freight_charge.php',$this->data);
	}
	public function print_faktur()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'FAKTUR Print';
    	$this->data['content'] = $this->model_transaction->print_faktur(); 
        $this->load->view('transaction/print_faktur.php',$this->data);
	}
	public function complete_payment_under()
	{
	    $this->auth->cek2('invoice_add'); 
    	$this->model_transaction->complete_payment_under(); 
	}

//invoice retur=======================================================
	public function invoice_retur_list()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'INVOICE RETUR';
        $this->data['body'] = 'transaction/invoice_retur_list.php';
        $this->data['data']['content'] = $this->model_transaction->invoice_retur_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_retur_list';
		$this->load->view('main',$this->data);
	}
	public function detail_to_invoice_retur()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'CREATE INVOICE RETUR';
        $this->data['body'] = 'transaction/detail_to_invoice_retur.php';
        $this->data['data']['content'] = $this->model_transaction->detail_to_invoice_retur(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_retur_list';
		$this->load->view('main',$this->data);
	}
	public function invoice_retur_add()
	{
	    $this->auth->cek2('invoice_add'); 
        $this->data['PageTitle'] = 'ADD INVOICE RETUR';
        if (isset($_GET['dor'])) {
	        $this->data['body'] = 'transaction/invoice_retur_add_dor.php';
	        $this->data['content'] = $this->model_transaction->dor_to_inv_retur_detail();
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_retur_list';
		$this->load->view('main',$this->data);
	}
	public function invoice_retur_add_act()
	{
	    $this->auth->cek2('invoice_add');
    	$this->model_transaction->invoice_retur_add_act(); 
        redirect(base_url('transaction/invoice_retur_list'));
	}
	public function print_invoice_retur()
	{
	    $this->auth->cek2('invoice_list'); 
        $this->data['PageTitle'] = 'INVOICE RETUR Print';
    	$this->data['content'] = $this->model_transaction->print_invoice_retur(); 
        $this->load->view('transaction/print_invoice_retur.php',$this->data);
	}

//sales order ========================================================
	public function sales_order_list()
	{
	    $this->auth->cek2('sales_order_list'); 
        $this->data['PageTitle'] = 'SALES ORDER LIST';
        $this->data['body'] = 'transaction/sales_order_list.php';
        $this->data['data']['content'] = $this->model_transaction->sales_order_list(); 
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'sales_order_list';
        // echo json_encode($this->data['data']);
		$this->load->view('main',$this->data);
	}
	public function sales_order_add()
	{
	    $this->auth->cek2('sales_order_add'); 
        $this->data['PageTitle'] = 'ADD SALES ORDER';
        $this->data['body'] = 'transaction/sales_order_add.php';
        $this->data['data']['content'] = $this->model_transaction->sales_order_add();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'sales_order_list';
		$this->load->view('main',$this->data);
	}
	public function sales_order_offline_add()
	{
	    $this->auth->cek2('sales_order_offline_add'); 
        $this->data['PageTitle'] = 'ADD SALES ORDER';
        $this->data['body'] = 'transaction/sales_order_offline.php';
        $this->data['data']['content'] = $this->model_transaction->sales_order_add();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'sales_order_offline_add';
		$this->load->view('main',$this->data);
	}
	public function sales_order_online_add()
	{
	    $this->auth->cek2('sales_order_online_add');
        $this->data['PageTitle'] = 'ADD SALES ORDER';
        $this->data['body'] = 'transaction/sales_order_online.php';
        $this->data['data']['content'] = $this->model_transaction->sales_order_add();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'sales_order_online_add';
		$this->load->view('main',$this->data);
	}
	public function sales_order_add_act()
	{
	    $this->auth->cek2('sales_order_add'); 
    	$this->model_transaction->sales_order_add_act(); 
        redirect(base_url('transaction/sales_order_list'));
	}
	public function sales_order_offline_add_act()
	{
		$this->auth->cek2('sales_order_offline_add');
		$this->model_transaction->sales_order_offline_add_act();
		redirect(base_url('transaction/sales_order_list'));
	}
	public function sales_order_online_add_act()
	{
	    $this->auth->cek2('sales_order_add');
		$this->model_transaction->sales_order_online_add_act();
        redirect(base_url('transaction/sales_order_list'));
	}
	public function sales_order_edit()
	{
		$this->auth->cek2('sales_order_add');
		$this->data['PageTitle'] = 'EDIT SALES ORDER';
		$SOID 	= $this->input->get_post('so');
		// if ($SOID < 43738) {
			// $this->data['body'] = 'transaction/sales_order_edit2.php';
		// } else {
			$this->data['body'] = 'transaction/sales_order_edit.php';
		// }
		$this->data['data']['content'] = $this->model_transaction->sales_order_edit();
		$this->data['data']['help'] = 'SO v.1';
		$this->data['data']['menu'] = 'sales_order_list';
		$this->load->view('main',$this->data);
	}
	public function sales_order_edit_act()
	{
		$this->auth->cek2('sales_order_add');
		$this->model_transaction->sales_order_edit_act();
		redirect(base_url('transaction/sales_order_list'));
	}
	public function sales_order_offline_edit()
	{
		$this->auth->cek2('sales_order_offline_add');
		$this->data['PageTitle'] = 'EDIT SALES ORDER OFFLINE';
		$SOID 	= $this->input->get_post('so');
		$this->data['body'] = 'transaction/sales_order_edit_offline.php';
		$this->data['data']['content'] = $this->model_transaction->sales_order_offline_edit();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'SO v.1';
		$this->data['data']['menu'] = 'sales_order_list';
		$this->load->view('main',$this->data);
	}
	public function sales_order_offline_edit_act()
	{
		$this->auth->cek2('sales_order_offline_add');
		$this->model_transaction->sales_order_offline_edit_act();
		redirect(base_url('transaction/sales_order_list'));
	}
	public function search_customer()
	{
		$this->auth->cek2('sales_order_add');
		$this->load->model('model_master');
		$this->model_master->search_customer();
	}
	public function get_customer_address()
	{
		$this->auth->cek2('sales_order_add');
		$this->load->model('model_master');
		$this->model_master->get_customer_address();
	}
	public function get_product_price()
	{
		$this->auth->cek2('sales_order_add');
		$this->model_transaction->get_product_price();
	}
	public function get_product_promo()
	{
		$this->auth->cek2('sales_order_add');
		$this->model_transaction->get_product_promo();
	}
	public function get_customer_address_pv()
	{
		$this->auth->cek2('sales_order_offline_add');
		$this->load->model('model_master');
		$this->model_master->get_customer_address();
	}
	public function get_product_price_pv()
	{
		$this->auth->cek2('sales_order_offline_add');
		$this->model_transaction->get_product_price_pv();
	}
	public function get_product_promo_pv()
	{
		$this->auth->cek2('sales_order_offline_add');
		$this->model_transaction->get_product_promo_pv();
	}
	public function sales_order_cancel()
	{
		$this->auth->cek2('sales_order_add');
		$this->model_transaction->sales_order_cancel();
		redirect(base_url('transaction/sales_order_list'));
	}
	// ------------------------------------------------------------------
	public function sales_order_permit_note()
	{
		$this->auth->cek2('sales_order_add'); 
		$this->model_transaction->sales_order_permit_note(); 
        redirect(base_url('transaction/sales_order_list'));
	}
	public function get_sales_order_permit_note()
	{
		$this->model_transaction->get_sales_order_permit_note(); 
	}
	// ------------------------------------------------------------------
	public function sales_order_tax_note()
	{
		$this->auth->cek2('sales_order_add'); 
		$this->model_transaction->sales_order_tax_note(); 
        redirect(base_url('transaction/sales_order_list'));
	}
	public function get_sales_order_tax_note()
	{
		$this->model_transaction->get_sales_order_tax_note(); 
	}
	// ------------------------------------------------------------------
	public function sales_order_print()
	{
        $this->data['PageTitle'] = 'SO Print';
		$this->data['content'] = $this->model_transaction->sales_order_print(); 
		$SODate = $this->data['content']['so']['SODate'];
		$time 	= "2019-05-07";
		if ($SODate <= $time) {
        	$this->load->view('transaction/sales_order_print.php',$this->data);
		} else {
        	$this->load->view('transaction/sales_order_print_3.php',$this->data);
        	// $this->load->view('transaction/sales_order_print2.php',$this->data);
        	
		}
	}
	public function sales_order_print_no()
	{
        $this->data['PageTitle'] = 'SO Print';
		$this->data['content'] = $this->model_transaction->sales_order_print(); 
		$SODate = $this->data['content']['so']['SODate'];
		$time 	= "2019-05-07";
		if ($SODate <= $time) {
        	$this->load->view('transaction/sales_order_print.php',$this->data);
		} else {
        	// $this->load->view('transaction/sales_order_print2.php',$this->data);
        	$this->load->view('transaction/sales_order_print_no.php',$this->data);
		}
	}
	public function get_so_detail()
	{
		$this->model_transaction->get_so_detail(); 
	}
	public function complete_deposit_under()
	{
	    $this->auth->cek2('sales_order_add'); 
    	$this->model_transaction->complete_deposit_under(); 
	}
	public function sales_order_goApproval()
	{
        $this->model_transaction->sales_order_goApproval();
	}
	public function product_list_popup_so()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/product_list_popup_so.php',$this->data);
	}
	function product_list_popup_so_data()
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
	public function product_list_popup_so_offline()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/product_list_popup_so_offline.php',$this->data);
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
	        'table' => 'vw_stock_product_ready_not_nol',
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
	// ------------------------------------------------------------------
	public function sales_order_due_date()
	{
	    $this->auth->cek2('sales_order_due_date'); 
        $this->data['PageTitle'] = 'SO Due Date';
        $this->data['body'] = 'transaction/sales_order_due_date.php';
        $this->data['data']['content'] = $this->model_transaction->sales_order_due_date(); 
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'sales_order_due_date';
		$this->load->view('main',$this->data);
	}
	public function sales_order_due_date_detail() 
	{
	    $this->auth->cek2('sales_order_due_date'); 
        $this->data['content'] = $this->model_transaction->sales_order_due_date_detail(); 
        $this->load->view('transaction/sales_order_due_date_detail.php',$this->data);
	}
	public function sales_order_due_date_detail_act()
	{
        $this->auth->cek2('sales_order_due_date'); 
        $this->model_transaction->sales_order_due_date_detail_act(); 
	}
	// ------------------------------------------------------------------
	public function sales_order_file_attach() 
	{
	    $this->auth->cek2('sales_order_add'); 
        $this->data['content'] = $this->model_transaction->sales_order_file_attach(); 
        $this->load->view('transaction/sales_order_file_attach.php',$this->data);
	}
	public function sales_order_file_attach_act()
	{
        $this->auth->cek2('sales_order_add'); 
        $this->model_transaction->sales_order_file_attach_act(); 
        redirect(base_url('transaction/sales_order_list'));
	}
	// SO upload ---------------------------------------------------------
	public function sales_order_upload()
	{
	    $this->auth->cek2('sales_order_upload'); 
        $this->data['PageTitle'] = 'SALES ORDER UPLOAD';
        $this->data['body'] = 'transaction/sales_order_upload.php';
        $this->data['data']['content'] = $this->model_transaction->sales_order_add();
        $this->data['data']['help'] = 'SO v.1';
        $this->data['data']['menu'] = 'sales_order_upload';
		$this->load->view('main',$this->data);
	}
	public function sales_order_upload_act()
	{
	    $this->auth->cek2('sales_order_upload'); 
	    $customer 	= $this->input->post('customer');
		$contactid 	= $this->input->post('contactid');
	    $sales 		= $this->input->post('sales');
		$billing 	= $this->input->post('billing');
		$creditlimit 	= $this->input->post('creditlimit');
		$creditavailable= $this->input->post('creditavailable');
		$paymentterm 	= $this->input->post('paymentterm');
		$regionid 	= $this->input->post('regionid');
		$secid 		= $this->input->post('secid');
		$npwp 		= $this->input->post('npwp');
		$pricelist 	= $this->input->post('pricelist');
		$promovolume = $this->input->post('promovolume');
		$mplace = $this->input->post('mplace');

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
	    		$data_so = array();
	    		$data_main = array();
	    		$data_detail = array();
	    		$inv_ol = array();
	    		$product_ol = array();
	    		$inv_product = array();
	    		$inv_product_duplicate = array();

				if ($mplace == 'tokopedia') {
				    $numrow = 1;
					foreach($data as $row) {
	                	$a = 0;
				      	if($numrow > 1){
			                $data = array(
								'Count' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Order_ID' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Invoice' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Payment_Date' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Order_Status' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Product_ID' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Product_Name' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Quantity' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Stock_Keeping_Unit' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Notes' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Price' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Discount_Amount' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Subsidi_Amount' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Customer_Name' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Customer_Phone' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Recipient' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Recipient_Number' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Recipient_Address' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Courier' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Shipping_Price_fee' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Insurance' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Total_Shipping_Fee' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Total_Amount' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'AWB' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Jenis_Layanan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Bebas_Ongkir' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Warehouse_Origin' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Campaign_Name' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
			                );
			                if ($data['Invoice'] != '') {
	            				$data_all[] = $data;
			                }
						} else {
							if (
								($row[$a++] == 'Count') and
								($row[$a++] == 'Order ID') and
								($row[$a++] == 'Invoice') and
								($row[$a++] == 'Payment Date') and
								($row[$a++] == 'Order Status') and
								($row[$a++] == 'Product ID') and
								($row[$a++] == 'Product Name') and
								($row[$a++] == 'Quantity') and
								($row[$a++] == 'Stock Keeping Unit (SKU)') and
								($row[$a++] == 'Notes') and
								($row[$a++] == 'Price (Rp.)') and
								($row[$a++] == 'Discount Amount (Rp.)') and
								($row[$a++] == 'Subsidi Amount (Rp.)') and
								($row[$a++] == 'Customer Name') and
								($row[$a++] == 'Customer Phone') and
								($row[$a++] == 'Recipient') and
								($row[$a++] == 'Recipient Number') and
								($row[$a++] == 'Recipient Address') and
								($row[$a++] == 'Courier') and
								($row[$a++] == 'Shipping Price + fee (Rp.)') and
								($row[$a++] == 'Insurance (Rp.)') and
								($row[$a++] == 'Total Shipping Fee (Rp.)') and
								($row[$a++] == 'Total Amount (Rp.)') and
								($row[$a++] == 'AWB') and
								($row[$a++] == 'Jenis Layanan') and
								($row[$a++] == 'Bebas Ongkir') and
								($row[$a++] == 'Warehouse Origin') and
								($row[$a++] == 'Campaign Name') 
							) { } else {
								$newdata['error_info'] = "upload excel gagal, Format excel SO tokopedia salah";
								$this->session->set_userdata($newdata);
	       		 				redirect(base_url('transaction/sales_order_upload'));
							}
						}
				      	$numrow++;
					}

					$CountBefore = 0;
					$TotalPriceBefore = 0;
					foreach ($data_all as $key => $value) {
						$date_1 = strtotime($value['Payment_Date']); 
						$date_2 = date('Y-m-d', $date_1);

						if ($value['Count'] != null) { 
			                $data_real = array(
								'Count' => $value['Count'],
								'Order_ID' => $value['Order_ID'],
								'Invoice' => $value['Invoice'],
								'Payment_Date' => $date_2,
								'Order_Status' => $value['Order_Status'],
								'Customer_Name' => $value['Customer_Name'],
								'Customer_Phone' => $value['Customer_Phone'],
								'Recipient' => $value['Recipient'],
								'Recipient_Number' => $value['Recipient_Number'],
								'Recipient_Address' => $value['Recipient_Address'],
								'Courier' => $value['Courier'],
								'Shipping_Price_fee' => $value['Shipping_Price_fee'],
								'Insurance' => $value['Insurance'],
								'Total_Shipping_Fee' => $value['Total_Shipping_Fee'],
								'Total_Amount' => $value['Total_Amount'],
								'AWB' => $value['AWB'],
								'Jenis_Layanan' => $value['Jenis_Layanan'],
								'Bebas_Ongkir' => $value['Bebas_Ongkir'],
								'Warehouse_Origin' => $value['Warehouse_Origin'],
								'Campaign_Name' => $value['Campaign_Name'],
			                );
			                $data_main[ $value['Count'] ] = array(
								'CustomerID' => $customer,
								'SalesID' => $sales,
								'BillingAddress' => str_replace(array('\n', '\r'), ' ', $billing),
								'ShipAddress' => (explode(";",$billing))[0].';'.$value['Customer_Name'].';'.$value['Recipient'].' - '.$value['Recipient_Number'].' - '.$value['Recipient_Address'],
								'RegionID' => $regionid,
								'SECID' => $secid,
								'NPWP' => $npwp,
								'PaymentWay' => 'TOP',
								'PaymentTerm' => 7,
								'SOCategory' => 1,
								'SOType' => 'standard',
								'INVCategory' => 1,
								'PaymentDeposit' => 0,
								'SODate' => $date_2,
								'ShopID' => 0,
								'SOShipDate' => $date_2,
								'SOTerm' => '',
								'SONote' => urldecode(http_build_query($data_real,'','//',PHP_QUERY_RFC3986)),
								'ExpeditionID' => 1,
								'ExpeditionPrice' => 0,
								'ExpeditionWeight' => 0,
								'FreightCharge' => 0,
								'SOTotalBefore' => $value['Total_Amount'] - $value['Total_Shipping_Fee'],
								'TaxRate' => 0,
								'TaxAmount' => 0,
								'SOTotal' => $value['Total_Amount'] - $value['Total_Shipping_Fee'], 
								'PermitNote' => '', 
								'InputDate' => date('Y-m-d H:i:s'),
								'InputBy' => $this->session->userdata('UserAccountID'),
								'ModifiedDate' => date('Y-m-d H:i:s'),
								'ModifiedBy' => $this->session->userdata('UserAccountID'),
								'Count' => $value['Count'],
								'INVMP' => $value['Invoice'],
							);
							$data_real_arr[] = $data_real;
			            }
		                $value['Count'] = ($value['Count'] == null) ? $CountBefore : $value['Count'] ;
		                $cek_product_exist = $value['Count'].'_'.$value['Stock_Keeping_Unit'];
		                if (!in_array($cek_product_exist, $inv_product)) {
							$inv_product[] = $cek_product_exist;
							$product_ol[] = $value['Stock_Keeping_Unit'];
							$inv_ol[] = $value['Invoice'];
			                $data_so_detail[$value['Count']][] = array(
								'Product_ID' => ($value['Product_ID'] == null) ? 0 : $value['Product_ID'],
								'Product_Name' => $value['Product_Name'],
								'Quantity' => $value['Quantity'],
								'Stock_Keeping_Unit' => $value['Stock_Keeping_Unit'],
								'Notes' => $value['Notes'],
								'Price' => $value['Price'],
								'Discount_Amount' => $value['Discount_Amount'],
								'Subsidi_Amount' => $value['Subsidi_Amount'],
			                );
			                $data_detail[$value['Count']][] = array(
								'ProductID' => ($value['Stock_Keeping_Unit'] == null) ? 0 : $value['Stock_Keeping_Unit'],
								'ProductName' => $value['Product_Name'],
								'ProductQty' => $value['Quantity'],
								'PriceAmount' => $value['Price'],
								'PriceTotal' => $value['Price']*$value['Quantity'],
								'Pending' => $value['Quantity'],
							);
			                $CountBefore = $value['Count'];
			            } else {
							$inv_product_duplicate[] = $value['Order_ID'];
			            }
					}

				} elseif ($mplace == 'shopee') {
				    $numrow = 1;
					foreach($data as $row) {
	                	$a = 0;
				      	if($numrow > 1){
			                $data = array(
			                	'No_Pesanan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Status_Pesanan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Alasan_Pembatalan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Status_Pembatalan_Pengembalian' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'No_Resi' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Opsi_Pengiriman' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Antar_ke_counter_pick_up' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Pesanan_Harus_Dikirimkan_Sebelum_Menghindari_keterlambatan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Waktu_Pengiriman_Diatur' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Waktu_Pesanan_Dibuat' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Waktu_Pembayaran_Dilakukan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'SKU_Induk' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Nama_Produk' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Nomor_Referensi_SKU' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Nama_Variasi' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Harga_Awal' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Harga_Setelah_Diskon' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Jumlah' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Total_Harga_Produk' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Total_Diskon' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Diskon_Dari_Penjual' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Diskon_Dari_Shopee' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Berat_Produk' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Jumlah_Produk_di_Pesan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Total_Berat' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Voucher_Ditanggung_Penjual' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Cashback_Koin' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Voucher_Ditanggung_Shopee' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Paket_Diskon' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Paket_Diskon_Diskon_dari_Shopee' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Paket_Diskon_Diskon_dari_Penjual' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Potongan_Koin_Shopee' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Diskon_Kartu_Kredit' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Ongkos_Kirim_Dibayar_oleh_Pembeli' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Total_Pembayaran' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Perkiraan_Ongkos_Kirim' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Catatan_dari_Pembeli' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Catatan' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Username_Pembeli' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Nama_Penerima' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'No_Telepon' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Alamat_Pengiriman' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Kota_Kabupaten' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Provinsi' => str_replace(array(chr(39), chr(34)), '', $row[$a++]),
								'Waktu_Pesanan_Selesai' => str_replace(array(chr(39), chr(34)), '', $row[$a++]), 
			                ); 
			                if ($data['No_Pesanan'] != '' && $data['Alasan_Pembatalan'] == null && $data['Waktu_Pembayaran_Dilakukan'] != '-' ) {
	            				$data_all[] = $data;
			                }
				      	} else {
							if (
								($row[$a++] == 'No. Pesanan') and
								($row[$a++] == 'Status Pesanan') and
								($row[$a++] == 'Alasan Pembatalan') and
								($row[$a++] == 'Status Pembatalan/ Pengembalian') and
								($row[$a++] == 'No. Resi') and
								($row[$a++] == 'Opsi Pengiriman') and
								($row[$a++] == 'Antar ke counter/ pick-up') and
								($row[$a++] == 'Pesanan Harus Dikirimkan Sebelum (Menghindari keterlambatan)') and
								($row[$a++] == 'Waktu Pengiriman Diatur') and
								($row[$a++] == 'Waktu Pesanan Dibuat') and
								($row[$a++] == 'Waktu Pembayaran Dilakukan') and
								($row[$a++] == 'SKU Induk') and
								($row[$a++] == 'Nama Produk') and
								($row[$a++] == 'Nomor Referensi SKU') and
								($row[$a++] == 'Nama Variasi') and
								($row[$a++] == 'Harga Awal') and
								($row[$a++] == 'Harga Setelah Diskon') and
								($row[$a++] == 'Jumlah') and
								($row[$a++] == 'Total Harga Produk') and
								($row[$a++] == 'Total Diskon') and
								($row[$a++] == 'Diskon Dari Penjual') and
								($row[$a++] == 'Diskon Dari Shopee') and
								($row[$a++] == 'Berat Produk') and
								($row[$a++] == 'Jumlah Produk di Pesan') and
								($row[$a++] == 'Total Berat') and
								($row[$a++] == 'Voucher Ditanggung Penjual') and
								($row[$a++] == 'Cashback Koin') and
								($row[$a++] == 'Voucher Ditanggung Shopee') and
								($row[$a++] == 'Paket Diskon') and
								($row[$a++] == 'Paket Diskon (Diskon dari Shopee)') and
								($row[$a++] == 'Paket Diskon (Diskon dari Penjual)') and
								($row[$a++] == 'Potongan Koin Shopee') and
								($row[$a++] == 'Diskon Kartu Kredit') and
								($row[$a++] == 'Ongkos Kirim Dibayar oleh Pembeli') and
								($row[$a++] == 'Total Pembayaran') and
								($row[$a++] == 'Perkiraan Ongkos Kirim') and
								($row[$a++] == 'Catatan dari Pembeli') and
								($row[$a++] == 'Catatan') and
								($row[$a++] == 'Username (Pembeli)') and
								($row[$a++] == 'Nama Penerima') and
								($row[$a++] == 'No. Telepon') and
								($row[$a++] == 'Alamat Pengiriman') and
								($row[$a++] == 'Kota/Kabupaten') and
								($row[$a++] == 'Provinsi') and
								($row[$a++] == 'Waktu Pesanan Selesai') 
							) { } else {
								$newdata['error_info'] = "upload excel gagal, Format excel SO Shopee salah";
								$this->session->set_userdata($newdata);
	       		 				redirect(base_url('transaction/sales_order_upload'));
							}
						}
				      	$numrow++;
				    }

					$CountBefore = 0;
					$TotalPriceBefore = 0;
					foreach ($data_all as $key => $value) {
						$date_1 = strtotime($value['Waktu_Pembayaran_Dilakukan']); 
						$date_2 = date('Y-m-d', $date_1);

		                $data_real = array(
		                	'No_Pesanan' => $value['No_Pesanan'],
							'Status_Pesanan' => $value['Status_Pesanan'],
							'Alasan_Pembatalan' => $value['Alasan_Pembatalan'],
							'Status_Pembatalan_Pengembalian' => $value['Status_Pembatalan_Pengembalian'],
							'No_Resi' => $value['No_Resi'],
							'Opsi_Pengiriman' => $value['Opsi_Pengiriman'],
							'Antar_ke_counter_pick_up' => $value['Antar_ke_counter_pick_up'],
							'Pesanan_Harus_Dikirimkan_Sebelum_Menghindari_keterlambatan' => $value['Pesanan_Harus_Dikirimkan_Sebelum_Menghindari_keterlambatan'],
							'Waktu_Pengiriman_Diatur' => $value['Waktu_Pengiriman_Diatur'],
							'Waktu_Pesanan_Dibuat' => $value['Waktu_Pesanan_Dibuat'],
							'Waktu_Pembayaran_Dilakukan' => $value['Waktu_Pembayaran_Dilakukan'],
							'SKU_Induk' => $value['SKU_Induk'],
							'Nama_Produk' => $value['Nama_Produk'],
							'Nomor_Referensi_SKU' => $value['Nomor_Referensi_SKU'],
							'Nama_Variasi' => $value['Nama_Variasi'],
							'Harga_Awal' => (float) str_replace(array("Rp","."), "", $value['Harga_Awal']),
							'Harga_Setelah_Diskon' => (float) str_replace(array("Rp","."), "", $value['Harga_Setelah_Diskon']),
							'Jumlah' => $value['Jumlah'],
							'Total_Harga_Produk' => (float) str_replace(array("Rp","."), "", $value['Total_Harga_Produk']),
							'Total_Diskon' => (float) str_replace(array("Rp","."), "", $value['Total_Diskon']),
							'Diskon_Dari_Penjual' => (float) str_replace(array("Rp","."), "", $value['Diskon_Dari_Penjual']),
							'Diskon_Dari_Shopee' => (float) str_replace(array("Rp","."), "", $value['Diskon_Dari_Shopee']),
							'Berat_Produk' => $value['Berat_Produk'],
							'Jumlah_Produk_di_Pesan' => $value['Jumlah_Produk_di_Pesan'],
							'Total_Berat' => $value['Total_Berat'],
							'Voucher_Ditanggung_Penjual' => (float) str_replace(array("Rp","."), "", $value['Voucher_Ditanggung_Penjual']),
							'Cashback_Koin' => (float) str_replace(array("Rp","."), "", $value['Cashback_Koin']),
							'Voucher_Ditanggung_Shopee' => (float) str_replace(array("Rp","."), "", $value['Voucher_Ditanggung_Shopee']),
							'Paket_Diskon' => $value['Paket_Diskon'],
							'Paket_Diskon_Diskon_dari_Shopee' => (float) str_replace(array("Rp","."), "", $value['Paket_Diskon_Diskon_dari_Shopee']),
							'Paket_Diskon_Diskon_dari_Penjual' => (float) str_replace(array("Rp","."), "", $value['Paket_Diskon_Diskon_dari_Penjual']),
							'Potongan_Koin_Shopee' => $value['Potongan_Koin_Shopee'],
							'Diskon_Kartu_Kredit' => (float) str_replace(array("Rp","."), "", $value['Diskon_Kartu_Kredit']),
							'Ongkos_Kirim_Dibayar_oleh_Pembeli' => (float) str_replace(array("Rp","."), "", $value['Ongkos_Kirim_Dibayar_oleh_Pembeli']),
							'Total_Pembayaran' => (float) str_replace(array("Rp","."), "", $value['Total_Pembayaran']),
							'Perkiraan_Ongkos_Kirim' => (float) str_replace(array("Rp","."), "", $value['Perkiraan_Ongkos_Kirim']),
							'Catatan_dari_Pembeli' => $value['Catatan_dari_Pembeli'],
							'Catatan' => $value['Catatan'],
							'Username_Pembeli' => $value['Username_Pembeli'],
							'Nama_Penerima' => $value['Nama_Penerima'],
							'No_Telepon' => $value['No_Telepon'],
							'Alamat_Pengiriman' => $value['Alamat_Pengiriman'],
							'Kota_Kabupaten' => $value['Kota_Kabupaten'],
							'Provinsi' => $value['Provinsi'],
							'Waktu_Pesanan_Selesai' => $value['Waktu_Pesanan_Selesai'], 
		                );
			                
						if ($value['No_Pesanan'] != $CountBefore) { 
			                $data_main[ $value['No_Pesanan'] ] = array(
								'CustomerID' => $customer,
								'SalesID' => $sales,
								'BillingAddress' => str_replace(array('\n', '\r'), ' ', $billing),
								'ShipAddress' => (explode(";",$billing))[0].';'.$data_real['Username_Pembeli'].';'.$data_real['Nama_Penerima'].' - '.$data_real['No_Telepon'].' - '.$data_real['Alamat_Pengiriman'],
								'RegionID' => 0,
								'SECID' => 0,
								'NPWP' => $npwp,
								'PaymentWay' => 'TOP',
								'PaymentTerm' => 7,
								'SOCategory' => 1,
								'SOType' => 'standard',
								'INVCategory' => 1,
								'PaymentDeposit' => 0,
								'SODate' => $date_2,
								'ShopID' => 0,
								'SOShipDate' => $date_2,
								'SOTerm' => '',
								'SONote' => urldecode(http_build_query($data_real,'','//',PHP_QUERY_RFC3986)),
								'ExpeditionID' => 1,
								'ExpeditionPrice' => 0,
								'ExpeditionWeight' => 0,
								'FreightCharge' => 0,
								'SOTotalBefore' => $data_real['Total_Pembayaran'] - $data_real['Ongkos_Kirim_Dibayar_oleh_Pembeli'],
								'TaxRate' => 0,
								'TaxAmount' => 0,
								'SOTotal' => $data_real['Total_Pembayaran'] - $data_real['Ongkos_Kirim_Dibayar_oleh_Pembeli'], 
								'PermitNote' => '', 
								'InputDate' => date('Y-m-d H:i:s'),
								'InputBy' => $this->session->userdata('UserAccountID'),
								'ModifiedDate' => date('Y-m-d H:i:s'),
								'ModifiedBy' => $this->session->userdata('UserAccountID'),
								'Count' => $data_real['No_Pesanan'],
								'INVMP' => $data_real['No_Pesanan'],
							);
							$data_real_arr[] = $data_real;
			            }
		                $data_real['No_Pesanan'] = ($data_real['No_Pesanan'] == null) ? $CountBefore : $data_real['No_Pesanan'] ;
		                $cek_product_exist = $data_real['No_Pesanan'].'_'.$data_real['Nomor_Referensi_SKU'];
		                if (!in_array($cek_product_exist, $inv_product)) {
							$inv_product[] = $cek_product_exist;
							$product_ol[] = ($data_real['Nomor_Referensi_SKU'] == null) ? 0 : $data_real['Nomor_Referensi_SKU'];
							$inv_ol[] = $data_real['No_Pesanan'];
			                $data_so_detail[$data_real['No_Pesanan']][] = array(
								'Product_ID' => ($data_real['Nomor_Referensi_SKU'] == null) ? 0 : $data_real['Nomor_Referensi_SKU'],
								'Product_Name' => $data_real['Nama_Produk'],
								'Quantity' => $data_real['Jumlah'],
								'Stock_Keeping_Unit' => $data_real['Nomor_Referensi_SKU'],
								'Notes' => $data_real['Catatan_dari_Pembeli'],
								'Price' => $data_real['Harga_Awal'],
								'Discount_Amount' => $data_real['Harga_Awal'] - $data_real['Harga_Setelah_Diskon'],
								'Subsidi_Amount' => $data_real['Harga_Awal'] - $data_real['Harga_Setelah_Diskon'],
			                );
			                $data_detail[$data_real['No_Pesanan']][] = array(
								'ProductID' => ($data_real['Nomor_Referensi_SKU'] == null) ? 0 : $data_real['Nomor_Referensi_SKU'],
								'ProductName' => $data_real['Nama_Produk'],
								'ProductQty' => $data_real['Jumlah'],
								'PriceAmount' => $data_real['Harga_Awal'],
								'PriceTotal' => $data_real['Harga_Awal']*$data_real['Jumlah'],
								'Pending' => $data_real['Harga_Awal'],
							);
			                $CountBefore = $data_real['No_Pesanan'];

			            } else {
							$inv_product_duplicate[] = $data_real['No_Pesanan'];
			            }
					}
				
				}

				$product_ol_last = array_unique($product_ol);
				$inv_ol_last = array_unique($inv_ol);
    			$this->model_transaction->sales_order_upload_act($data_main, $data_detail, $inv_ol_last, $product_ol_last, $inv_product_duplicate);
		    }
		}
        redirect(base_url('transaction/sales_order_upload'));
	}

//request order ======================================================
	public function request_order_list()
	{
	    $this->auth->cek2('request_order_list'); 
        $this->data['PageTitle'] = 'REQUEST ORDER';
        $this->data['body'] = 'transaction/request_order_list.php';
        $this->data['data']['content'] = $this->model_transaction->request_order_list(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'request_order';
		$this->load->view('main',$this->data);
	}
	public function request_order_add()
	{
	    $this->auth->cek2('request_order_add'); 
        $this->data['PageTitle'] = 'ADD/EDIT REQUEST ORDER';
        $this->data['body'] = 'transaction/request_order_add.php';
        if (isset($_REQUEST['ro'])) {
	        $this->data['data']['ro_detail'] = $this->model_transaction->request_order_detail(); 
        } else if (isset($_REQUEST['ro_sugestion_val'])) {
	        $this->data['data']['ro_sugestion'] = $this->model_transaction->request_order_sugestion(); 
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'request_order';
		$this->load->view('main',$this->data);
	}
	public function request_order_add_act()
	{
	    $this->auth->cek2('request_order_add'); 
        if ($this->input->get_post('ro')) {
        	$this->model_transaction->request_order_edit_act(); 
        } else {
        	$this->model_transaction->request_order_add_act(); 
        }
        redirect(base_url('transaction/request_order_list'));
	}
	public function request_order_cancel()
	{
	    $this->auth->cek2('request_order_add'); 
    	$this->model_transaction->request_order_cancel(); 
        redirect(base_url('transaction/request_order_list'));
	}
	public function request_order_detail_full()
	{
	    $this->auth->cek2('request_order_list'); 
    	$this->data['content'] = $this->model_transaction->request_order_detail_full(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/request_order_detail_full.php',$this->data);
	}
	public function request_order_detail_raw_full()
	{
	    $this->auth->cek2('request_order_list'); 
    	$this->data['content'] = $this->model_transaction->request_order_detail_raw_full(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/request_order_detail_raw_full.php',$this->data);
	}
	public function request_order_print()
	{
	    $this->auth->cek2('request_order_list'); 
        $this->data['PageTitle'] = 'RO Print';
    	$this->data['content'] = $this->model_transaction->request_order_print(); 
        $this->load->view('transaction/request_order_print.php',$this->data);
	}

//purchase order =====================================================
	public function purchase_order_list()
	{
	    $this->auth->cek2('purchase_order_list'); 
        $this->data['PageTitle'] = 'PURCHASE ORDER';
        $this->data['body'] = 'transaction/purchase_order_list.php';
        $this->data['data']['content'] = $this->model_transaction->purchase_order_list(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'purchase_order';
		$this->load->view('main',$this->data);
	}
	public function purchase_order_add()
	{
	    $this->auth->cek2('purchase_order_add'); 
        $this->data['PageTitle'] = 'PURCHASE ORDER';
        $this->data['body'] = 'transaction/purchase_order_add.php';

    	$this->load->model('model_master');
    	$this->load->model('model_master2');
    	$this->load->model('model_hrd');
        $this->data['data']['supplier'] = $this->model_master->supplier_list();
        $this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['company'] = $this->model_hrd->company_list();

        if (isset($_REQUEST['ro']) && $_REQUEST['ro']!=0) {
	        $this->data['data']['ro_detail'] = $this->model_transaction->request_to_purchase_detail();
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'purchase_order';
		$this->load->view('main',$this->data);
	}
	public function purchase_order_add_act()
	{
	    $this->auth->cek2('purchase_order_add'); 
    	$this->model_transaction->purchase_order_add_act(); 
        redirect(base_url('transaction/purchase_order_list'));
	}
	public function purchase_order_edit()
	{
	    $this->auth->cek2('purchase_order_add'); 
        $this->data['PageTitle'] = 'PURCHASE ORDER';
        $this->data['body'] = 'transaction/purchase_order_edit.php';
        if (isset($_REQUEST['po'])) {
        	$this->load->model('model_master');
        	$this->load->model('model_master2');
        	$this->load->model('model_hrd');
	        $this->data['data']['po_detail'] = $this->model_transaction->purchase_order_edit();
	        $this->data['data']['supplier'] = $this->model_master->supplier_list();
	        $this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
	        $this->data['data']['company'] = $this->model_hrd->company_list();
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'purchase_order';
		$this->load->view('main',$this->data);
	}
	public function purchase_order_edit_act()
	{
	    $this->auth->cek2('purchase_order_add'); 
    	$this->model_transaction->purchase_order_edit_act(); 
        redirect(base_url('transaction/purchase_order_list'));
	}
	public function request_to_purchase()
	{
	    $this->auth->cek2('purchase_order_add'); 
        $this->data['PageTitle'] = 'REQUEST TO PURCHASE';
        $this->data['body'] = 'transaction/request_to_purchase.php';
        $this->data['data']['content'] = $this->model_transaction->request_to_purchase(); 
        $this->load->model('model_master2');
        $this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'purchase_order';
		$this->load->view('main',$this->data);
	}
	public function purchase_order_print()
	{
	    $this->auth->cek2('purchase_order_add'); 
        $this->data['PageTitle'] = 'PO Print';
    	$this->data['content'] = $this->model_transaction->purchase_order_print(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_print3.php', $this->data);
	}
	public function purchase_order_cancel()
	{
	    $this->auth->cek2('purchase_order_add'); 
    	$this->model_transaction->purchase_order_cancel(); 
        redirect(base_url('transaction/purchase_order_list'));
	}
	public function purchase_order_expired()
	{
	    $this->auth->cek2('purchase_order_add'); 
    	$this->model_transaction->purchase_order_expired(); 
        redirect(base_url('transaction/purchase_order_list'));
	}
	public function purchase_order_detail_full()
	{
	    $this->auth->cek2('purchase_order_list'); 
    	$this->data['content'] = $this->model_transaction->purchase_order_detail_full();

        $this->load->model('model_report');
    	$this->data['content']['history'] = $this->model_report->history_po(); 

        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_detail_full.php',$this->data);
	}
	public function purchase_order_detail_raw_full()
	{
	    $this->auth->cek2('purchase_order_list'); 
    	$this->data['content'] = $this->model_transaction->purchase_order_detail_raw_full(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_detail_raw_full.php',$this->data);
	}
	public function purchase_order_dor()
	{
	    $this->auth->cek2('purchase_order_add'); 
        $this->data['PageTitle'] = 'DOR FROM PO';
        $this->data['body'] = 'transaction/purchase_order_dor.php';
	    $this->data['data']['content'] = $this->model_transaction->purchase_order_dor();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'purchase_order';
		$this->load->view('main',$this->data);
	}

//delivery order received ============================================
	public function delivery_order_received_list()
	{
	    $this->auth->cek2('delivery_order_received_list'); 
        $this->data['PageTitle'] = 'DELIVERY ORDER RECEIVED';
        $this->data['body'] = 'transaction/delivery_order_received_list.php';
        $list1 = $this->model_transaction->delivery_order_received_list_po();
        $list2 = $this->model_transaction->delivery_order_received_list_mutation();
        $list3 = $this->model_transaction->delivery_order_received_list_do();
        $list4 = $this->model_transaction->delivery_order_received_list_inv();
        $this->data['data']['content'] = array_merge($list1, $list2, $list3, $list4); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'delivery_order_received';
		$this->load->view('main',$this->data);
	}
	public function delivery_order_received_add()
	{
	    $this->auth->cek2('delivery_order_received_add'); 
        $this->data['PageTitle'] = 'ADD DELIVERY ORDER RECEIVED';

	    $cek_dor_approval_not_complete = $this->model_transaction->cek_dor_approval_not_complete();
	    if ($cek_dor_approval_not_complete) {
  			echo "<script>alert('DOR dari sumber yang sama sedang dalam proses approval!')</script>";
  			echo "<script>window.close();</script>";
	    }
        
        if (isset($_REQUEST['po'])) {
    		$this->load->model('model_master2');
        	$this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        	$this->data['data']['detail'] = $this->model_transaction->po_to_dor_detail();
        	$this->data['body'] = 'transaction/delivery_order_received_add_po.php';
        } elseif (isset($_REQUEST['mutationid'])) {
        	$this->data['data']['detail'] = $this->model_transaction->mutation_to_dor_detail();
        	$this->data['body'] = 'transaction/delivery_order_received_add_mutation.php';
        } elseif (isset($_REQUEST['doid'])) {
        	$this->data['data']['detail'] = $this->model_transaction->do_to_dor_detail();
        	$this->data['body'] = 'transaction/delivery_order_received_add_do.php';
        } elseif (isset($_REQUEST['invid'])) {
        	$this->data['data']['detail'] = $this->model_transaction->inv_to_dor_detail();
        	$this->data['body'] = 'transaction/delivery_order_received_add_inv.php';
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'delivery_order_received';
		$this->load->view('main',$this->data);
	}
	public function delivery_order_received_add_act()
	{
	    $this->auth->cek2('delivery_order_received_add'); 
	    $cek_dor_approval = $this->model_transaction->cek_dor_approval();
	    if (!$cek_dor_approval) {
	        if ($_REQUEST['type'] == "PO") {
	    		$this->model_transaction->delivery_order_received_add_act_po(); 
	        } else if ($_REQUEST['type'] == "MUTATION") {
	    		$this->model_transaction->delivery_order_received_add_act_mutation(); 
	        } else if ($_REQUEST['type'] == "DO") {
	    		$this->model_transaction->delivery_order_received_add_act_do(); 
	        } else if ($_REQUEST['type'] == "INV") {
	    		$this->model_transaction->delivery_order_received_add_act_inv(); 
	        }
	    } else {
	    	$this->model_transaction->delivery_order_received_approval(); 
	    }
        redirect(base_url('transaction/delivery_order_received_list'));
	}
	public function detail_to_dor()
	{
	    $this->auth->cek2('delivery_order_received_add'); 
        $this->data['PageTitle'] = 'CREATE DOR';
        $this->data['body'] = 'transaction/detail_to_dor.php';
        $this->data['data']['content'] = $this->model_transaction->purchase_to_dor(); 
        $this->data['data']['content2'] = $this->model_transaction->mutation_to_dor(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'delivery_order_received';
		$this->load->view('main',$this->data);
	}
	public function purchase_order_print2()
	{
        $this->data['PageTitle'] = 'PO Print';
    	$this->data['content'] = $this->model_transaction->purchase_order_print(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_print5.php',$this->data);
	}
	public function delivery_order_received_print()
	{
	    $this->auth->cek2('delivery_order_received_list'); 
        $this->data['PageTitle'] = 'DOR Print';
        if ($this->input->get_post('type') == "PO") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_received_print_po(); 
	        $this->load->view('transaction/delivery_order_received_print_po.php',$this->data);
        } elseif ($this->input->get_post('type') == "MUTATION") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_received_print_mutation(); 
	        $this->load->view('transaction/delivery_order_received_print_mutation.php',$this->data);
        } elseif ($this->input->get_post('type') == "DO") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_received_print_do(); 
	        $this->load->view('transaction/delivery_order_received_print_do.php',$this->data);
        } elseif ($this->input->get_post('type') == "INV") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_received_print_inv(); 
	        $this->load->view('transaction/delivery_order_received_print_inv.php',$this->data);
        }
	}
	public function delivery_order_received_print2()
	{
	    $this->auth->cek2('purchase_order_list'); 
        $this->data['PageTitle'] = 'DOR Print';
    	$this->data['content'] = $this->model_transaction->delivery_order_received_print_po(); 
        $this->load->view('transaction/delivery_order_received_print_po2.php',$this->data);
	}

//delivery order =====================================================
	public function delivery_order_list()
	{
	    $this->auth->cek2('delivery_order_list'); 
        $this->data['PageTitle'] = 'DELIVERY ORDER';
        $this->data['body'] = 'transaction/delivery_order_list.php';
        $list1 = $this->model_transaction->delivery_order_list_po();
        $list2 = $this->model_transaction->delivery_order_list_mutation();
        $list3 = $this->model_transaction->delivery_order_list_so();
        $this->data['data']['content'] = array_merge($list1, $list2, $list3); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'delivery_order';
		$this->load->view('main',$this->data);
	}
	public function detail_to_do()
	{
	    $this->auth->cek2('delivery_order_add'); 
        $this->data['PageTitle'] = 'CREATE DO';
        $this->data['body'] = 'transaction/detail_to_do.php';
        $this->data['data']['content1'] = $this->model_transaction->purchase_to_do(); 
        $this->data['data']['content2'] = $this->model_transaction->mutation_to_do(); 
        $this->data['data']['content3'] = $this->model_transaction->so_to_do(); 
        $this->load->model('model_master2');
        $this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'delivery_order';
		$this->load->view('main',$this->data);
	}
	public function delivery_order_add()
	{
	    $this->auth->cek2('delivery_order_add'); 
        $this->data['PageTitle'] = 'ADD DELIVERY ORDER';
        if (isset($_REQUEST['po'])) {
        	$this->data['data']['detail'] = $this->model_transaction->po_to_do_detail();
        	$this->data['body'] = 'transaction/delivery_order_add_po.php';
        	$this->data['data']['help'] = 'Doc';
        } else if (isset($_REQUEST['mutationid'])) {
        	$this->data['data']['detail'] = $this->model_transaction->mutation_to_do_detail();
        	$this->data['body'] = 'transaction/delivery_order_add_mutation.php';
        	$this->data['data']['help'] = 'Doc';
        } else if (isset($_REQUEST['so'])) {
        	$so_status = $this->model_transaction->check_so_confirm2($_REQUEST['so']);
		    if (!$so_status) {
	  			echo "<script>alert('SO not Ready yet to DO!')</script>";
	  			echo "<script>window.close();</script>";
		    }

        	$this->data['data']['detail'] = $this->model_transaction->so_to_do_detail();
        	$this->data['body'] = 'transaction/delivery_order_add_so.php';
        	$this->data['data']['help'] = 'Doc';
        }
        $this->data['data']['menu'] = 'delivery_order';
		$this->load->view('main',$this->data);
	}
	public function delivery_order_edit()
	{
	    $this->auth->cek2('delivery_order_add'); 
        $this->data['PageTitle'] = 'EDIT DELIVERY ORDER';
        if (isset($_REQUEST['do'])) {
        	if ($_REQUEST['type'] == 'SO') {
	        	$so_status = $this->model_transaction->check_so_confirm2($_REQUEST['reff']);
			    if (!$so_status) {
		  			echo "<script>alert('SO not Ready yet to DO!')</script>";
		  			echo "<script>window.close();</script>";
			    }
	        	$this->data['data']['detail'] = $this->model_transaction->do_so_edit_detail();
	        	$this->data['body'] = 'transaction/delivery_order_edit_so.php';
	        	$this->data['data']['help'] = 'Doc';
        	} elseif ($_REQUEST['type'] == 'RAW PO') {
	        	$this->data['data']['detail'] = $this->model_transaction->do_po_edit_detail();
	        	$this->data['body'] = 'transaction/delivery_order_edit_po.php';
	        	$this->data['data']['help'] = 'Doc';
        	}
        }
        $this->data['data']['menu'] = 'delivery_order';
		$this->load->view('main',$this->data);
	}
	public function delivery_order_add_act()
	{
	    $this->auth->cek2('delivery_order_add'); 
        if ($_REQUEST['type'] == "RAW PO") {
    		$this->model_transaction->delivery_order_add_act_po(); 
        } else if ($_REQUEST['type'] == "MUTATION") {
    		$this->model_transaction->delivery_order_add_act_mutation(); 
        } else if ($_REQUEST['type'] == "SO") {
    		$this->model_transaction->delivery_order_add_act_so(); 
        }
        redirect(base_url('transaction/delivery_order_list'));
	}
	public function delivery_order_edit_act()
	{
	    $this->auth->cek2('delivery_order_add'); 
        if ($_REQUEST['type'] == "SO") {
    		$this->model_transaction->delivery_order_edit_act_so(); 
        } elseif ($_REQUEST['type'] == "RAW PO") {
    		$this->model_transaction->delivery_order_edit_act_po(); 
        }
        redirect(base_url('transaction/delivery_order_list'));
	}
	public function delivery_order_print()
	{
	    $this->auth->cek2('delivery_order_list'); 
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
	    	$this->data['content'] = $this->model_transaction->delivery_order_so_print2(); 
	        // $this->load->view('transaction/delivery_order_so_print.php',$this->data);
	        $this->load->view('transaction/delivery_order_so_print_pdf.php',$this->data);
        }
	}
	public function delivery_order_print2()
	{
	    $this->auth->cek2('delivery_order_list'); 
        $this->data['PageTitle'] = 'DO Print';
        $this->load->model('model_transaction');
        if ($this->input->get_post('type') == "RAW") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_raw_print(); 
	        $this->load->view('transaction/delivery_order_raw_print2.php',$this->data);
        } elseif ($this->input->get_post('type') == "MUTATION") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_mutation_print(); 
	        $this->load->view('transaction/delivery_order_mutation_print2.php',$this->data);
        } elseif ($this->input->get_post('type') == "SO") {
	    	$this->data['content'] = $this->model_transaction->delivery_order_so_print(); 
	        $this->load->view('transaction/delivery_order_so_print2.php',$this->data);
        }
	}
	public function complete_do()
	{
	    $this->auth->cek2('delivery_order_add'); 
    	$this->model_transaction->complete_do(); 
        redirect(base_url('transaction/delivery_order_list'));
	}
	public function do_history() 
	{
	    $this->auth->cek2('delivery_order_list'); 
        $this->data['content'] = $this->model_transaction->do_history(); 
        $this->load->view('transaction/do_history.php',$this->data);
	}
	public function do_fc_add() 
	{
	    $this->auth->cek2('delivery_order_add'); 
        $this->data['content'] = $this->model_transaction->do_fc_add(); 
        $this->load->view('transaction/do_fc_add.php',$this->data);
	}
	public function do_fc_add_act() 
	{
	    $this->auth->cek2('delivery_order_add'); 
		$this->model_transaction->do_fc_add_act(); 
		$DOID = $this->input->post('DOID');
        redirect(base_url('transaction/do_fc_report?do='.$DOID));
	}
	public function do_fc_report()
	{
	    $this->auth->cek2('delivery_order_list'); 
        $this->data['PageTitle'] = 'DO FC Print';
    	$this->data['content'] = $this->model_transaction->do_fc_report(); 
    	if ($this->data['content']['type'] == 'SO') {
        	$this->load->view('transaction/do_fc_print_so.php',$this->data);
    	} else {
        	$this->load->view('transaction/do_fc_print_do.php',$this->data);
    	}
	}
	public function complete_do_batch()
	{
		$this->auth->cek2('delivery_order_add'); 
        $this->model_transaction->complete_do_batch();
	}

//Stock ==============================================================
	public function product_stock_list()
	{
	    $this->auth->cek2('product_stock_list'); 
        $this->data['PageTitle'] = 'PRODUCT STOCK';
        $this->data['body'] = 'transaction/product_stock_list.php';
        
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list(); 

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_stock';
		$this->load->view('main',$this->data);
	}
	function product_stock_list_data()
	{
	    $this->auth->cek2('product_stock_list'); 
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
	        'table' => 'vw_stock_product_full_active_profit', 
	        'column_select' => array('ProductID','ProductCode','ProductName','ProductStatusName','ProductCategoryName','ProductBrandName','MinStock','MaxStock','stock','sopending','rawpending','ReadyStock','ropending','popending','mutationpending','NetStock','maxrosugestion','minrosugestion','isActive','apersen','Profit'), 
	        'column_order' => array(null,'ProductID','ProductCode','ProductName','ProductStatusName','ProductCategoryName','ProductBrandName','MinStock','MaxStock','stock','sopending','rawpending','ReadyStock','ropending','popending','mutationpending','NetStock','maxrosugestion','minrosugestion','isActive','apersen','Profit'), 
	        'column_search' => array('ProductID','ProductName','ProductCode'),  
	        'order' => array('ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			}
			$ropending = $field->ropending;
			if ($ropending != 0) {
				$ropending = "<button type='button' class='btn btn-flat btn-default btn-xs ro' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->ropending."</button>";
			}
			$popending = $field->popending;
			if ($popending != 0) {
				$popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->popending."</button>";
			}
			$mutationpending = $field->mutationpending;
			if ($mutationpending != 0) {
				$mutationpending = "<button type='button' class='btn btn-flat btn-default btn-xs mutation' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->mutationpending."</button>";
			}
			$stock = $field->stock;
			if ($stock != 0) {
				$stock = $field->stock." <button type='button' class='btn btn-flat btn-default btn-xs view_stock' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-stock'><i class='fa fa-fw fa-search-plus'></i></button>";
			}
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("view_margin", $MenuList)){
				$apersen = $field->apersen;
				$Profit = $field->Profit;
			} else {
				$apersen = "";
				$Profit = "";
			}

			$ReadyStock = $field->stock - ($field->sopending+$field->rawpending);
			$NetStock = $ReadyStock + ($field->ropending+$field->popending+$field->mutationpending);
            $status = ($field->isActive == 1 ? "Active" : "notActive");

			$row = array();
			// $row[] = $number++;
			$row[] = $field->ProductID;
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = $field->ProductName;
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $stock;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $field->ReadyStock;
			$row[] = $ropending;
			$row[] = $popending;
			$row[] = $mutationpending;
			$row[] = $field->NetStock;
			$row[] = $field->maxrosugestion;
			$row[] = $field->minrosugestion;
			$row[] = $status;
			$row[] = $apersen." %";
			$row[] = $Profit;
			$row[] = "
			<button type='button' class='btn btn-flat btn-primary btn-xs history' title='HISTORY' product='".$field->ProductID."'><i class='fa fa-fw fa-history'></i></button>
			";

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
	public function product_stock_history()
	{
	    $this->auth->cek2('product_stock_list'); 
        $this->data['PageTitle'] = 'PRODUCT STOCK HISTORY';
        // $this->data['body'] = 'transaction/product_stock_history.php';
        $this->data['content'] = $this->model_transaction->product_stock_history(); 
        // $this->data['data']['content'] = $this->model_transaction->product_stock_history(); 
        // $this->data['data']['help'] = 'Doc';
        // $this->data['data']['menu'] = 'product_stock';
		$this->load->view('transaction/product_stock_history.php',$this->data);
	}
	public function product_stock_pending()
	{
		$this->auth->cek2('product_stock_list'); 
		$type 	= $this->input->get_post('type');
		if ($type == "so") {
    		$this->data['content'] = $this->model_transaction->product_stock_pending_so(); 
        	$this->load->view('transaction/product_stock_pending_so.php',$this->data);
		} elseif ($type == "so_pending_non_confirm") {
    		$this->data['content'] = $this->model_transaction->product_stock_pending_so_pending_non_confirm(); 
        	$this->load->view('transaction/product_stock_pending_so.php',$this->data);
		} elseif ($type == "raw") {
    		$this->data['content'] = $this->model_transaction->product_stock_pending_raw(); 
        	$this->load->view('transaction/product_stock_pending_raw.php',$this->data);
		} elseif ($type == "so_raw") {
    		$this->data['content'] = $this->model_transaction->product_stock_pending_so_raw(); 
        	$this->load->view('transaction/product_stock_pending_so_raw.php',$this->data);
		} elseif ($type == "ro") {
    		$this->data['content'] = $this->model_transaction->product_stock_pending_ro(); 
        	$this->load->view('transaction/product_stock_pending_ro.php',$this->data);
		} elseif ($type == "po") {
    		$this->data['content'] = $this->model_transaction->product_stock_pending_po(); 
        	$this->load->view('transaction/product_stock_pending_po.php',$this->data);
		} elseif ($type == "mutation") {
    		// $this->data['content'] = $this->model_transaction->product_stock_pending_mutation(); 
        	$this->load->view('transaction/product_stock_pending_mutation.php',$this->data);
		} else {
        	redirect(base_url());
		}
	}
	public function product_stock_detail()
	{
	    $this->auth->cek2('product_stock_list'); 
    	$this->data['content'] = $this->model_transaction->product_stock_detail(); 
        $this->load->view('transaction/product_stock_detail.php',$this->data);
	}
	public function get_stock()
	{
    	$this->data['content'] = $this->model_transaction->get_stock(); 
	}
	public function product_minmax()
	{
	    $this->auth->cek2('product_minmax'); 
        $this->data['PageTitle'] = 'BATCH INPUT MIN MAX';
	    $this->data['body'] = 'transaction/product_minmax.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_stock';
        if (isset($_REQUEST['data']) && $this->input->get('data') != "" ) {
			$this->data['data']['productdetail'] = $this->model_transaction->get_product_detail_minmax();
			$this->load->view('main',$this->data);
	    } else ( redirect(base_url()) );
	}
	public function product_minmax_act()
	{
	    $this->auth->cek2('product_minmax'); 
    	$this->model_transaction->product_minmax_act(); 
        redirect(base_url('transaction/product_stock_list'));
	}

//mutation ===========================================================
	public function product_mutation_list()
	{
	    $this->auth->cek2('product_mutation_list'); 
        $this->data['PageTitle'] = 'PRODUCT MUTATION';
        $this->data['body'] = 'transaction/product_mutation_list.php';
        $this->data['data']['content'] = $this->model_transaction->product_mutation_list(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_mutation';
		$this->load->view('main',$this->data);
	}
	public function product_mutation_add()
	{
	    $this->auth->cek2('product_mutation_add'); 
        $this->data['PageTitle'] = 'ADD/EDIT PRODUCT MUTATION';
        $this->data['body'] = 'transaction/product_mutation_add.php';
        $this->load->model('model_master2');
    	$this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        if (isset($_REQUEST['mutationid'])) {
    		$this->data['data']['detail'] = $this->model_transaction->mutation_detail();
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_mutation';
		$this->load->view('main',$this->data);
	}
	public function product_mutation_add_act()
	{
	    $this->auth->cek2('product_mutation_add'); 
    	if ($this->input->get_post('mutationid')) {
        	$this->model_transaction->product_mutation_edit_act(); 
        } else {
        	$this->model_transaction->product_mutation_add_act(); 
        }
        redirect(base_url('transaction/product_mutation_list'));
	}
	public function product_mutation_cancel()
	{
	    $this->auth->cek2('product_mutation_add'); 
    	$this->model_transaction->product_mutation_cancel(); 
        redirect(base_url('transaction/product_mutation_list'));
	}
	public function product_mutation_detail_full()
	{
	    $this->auth->cek2('product_mutation_list'); 
    	$this->data['content'] = $this->model_transaction->product_mutation_detail_full(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/product_mutation_detail_full.php',$this->data);
	}

//stock Opname =======================================================
	public function product_stock_opname_list()
	{
	    $this->auth->cek2('product_stock_opname_list'); 
        $this->data['PageTitle'] = 'STOCK OPNAME';
        $this->data['body'] = 'transaction/product_stock_opname_list.php';
        $this->load->model('model_master2');
        $this->data['data']['content'] = $this->model_transaction->product_stock_opname_list(); 
        $this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'product_stock_opname';
		$this->load->view('main',$this->data);
	}
	public function product_stock_opname_add()
	{
	    $this->auth->cek2('product_stock_opname_list'); 
    	$this->model_transaction->product_stock_opname_add(); 
        redirect(base_url('transaction/product_stock_opname_list'));
	}
	public function product_stock_opname_detail()
	{
	    $this->auth->cek2('product_stock_opname_list'); 
        $this->data['PageTitle'] = 'STOCK OPNAME DETAIL';
    	$this->data['content'] = $this->model_transaction->product_stock_opname_detail(); 
    	if ($this->auth->cek5('acc_stock_value')) {
        	$this->load->view('transaction/product_stock_opname_detail2.php',$this->data);
    	} else {
        	$this->load->view('transaction/product_stock_opname_detail.php',$this->data);
    	}
	}

//stock adjustment ===================================================
	public function stock_adjustment_list()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
        $this->data['PageTitle'] = 'STOCK ADJUSTMENT';
        $this->data['body'] = 'transaction/stock_adjustment_list.php';
        $this->data['data']['content'] = $this->model_transaction->stock_adjustment_list(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'stock_adjustment';
		$this->load->view('main',$this->data);
	}
	public function stock_adjustment_add()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
        $this->data['PageTitle'] = 'ADD STOCK ADJUSTMENT';
        $this->data['body'] = 'transaction/stock_adjustment_add.php';

        $id = $this->input->get_post('id');
	    if (isset($id)) {
			$this->data['data']['content'] = $this->model_transaction->stock_adjustment_edit();
        }
        $this->load->model('model_master2');
		$this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'stock_adjustment';
		$this->load->view('main',$this->data);
	}
	public function stock_adjustment_add_act()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
    	$this->model_transaction->stock_adjustment_add_act(); 
        redirect(base_url('transaction/stock_adjustment_list'));
	}
	public function stock_adjustment_add_non_opname()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
        $this->data['PageTitle'] = 'ADD STOCK ADJUSTMENT NON OPNAME ';
        $this->data['body'] = 'transaction/stock_adjustment_add_non_opname.php';

        $id = $this->input->get_post('id');
	    if (isset($id)) {
			$this->data['data']['content'] = $this->model_transaction->stock_adjustment_edit_non_opname();
        }
        $this->load->model('model_master2');
		$this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'stock_adjustment';
		$this->load->view('main',$this->data);
	}
	public function stock_adjustment_add_non_opname_act()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
    	$this->model_transaction->stock_adjustment_add_non_opname_act(); 
        redirect(base_url('transaction/stock_adjustment_list'));
	}
	public function stock_adjustment_detail()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
    	$this->data['content'] = $this->model_transaction->stock_adjustment_detail(); 
        $this->load->view('transaction/stock_adjustment_detail.php',$this->data);
	}
	public function stock_adjustment_approval_submission()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
    	$this->model_transaction->stock_adjustment_approval_submission(); 
	}
	public function stock_adjustment_cancel()
	{
	    $this->auth->cek2('stock_adjustment_list'); 
    	$this->model_transaction->stock_adjustment_cancel(); 
	}
	public function upload_excel_adjustment()
	{
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
		                $data = array(
		                    'ProductID' => $row[$a++],
		                    'ProductCode' => $row[$a++],
		                    'Category' => $row[$a++],
		                    'Brand' => $row[$a++],
		                    'Quantity' => $row[$a++],
		                    'Adjust' => $row[$a++],
		                    // 'Result' => $row[$a++],
		                );
            			$data_all[] = $data;
					}
			      	$numrow++;
				}

        		echo json_encode($data_all);
		    }
		}
	}

//adjust_stock_history ===============================================
	public function adjust_stock_history()
	{
	    $this->auth->cek2('adjust_stock_history'); 
        $this->data['PageTitle'] = 'ADJUSTMENT EVERYTHING';
        $this->data['body'] = 'transaction/adjust_stock_history.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'adjust_stock_history';
		$this->load->view('main',$this->data);
	}
	public function adjust_stock_history_act()
	{
	    $this->auth->cek2('adjust_stock_history'); 
    	$this->model_transaction->adjust_stock_history_act(); 
        redirect(base_url('transaction/adjust_stock_history'));
	}
	public function adjust_balance_ro()
	{
	    $this->auth->cek2('adjust_stock_history'); 
		$ROID	= $this->input->post('reff');
    	$this->model_transaction->update_pending_ro($ROID); 
    	$this->model_transaction->update_status_ro($ROID); 
        redirect(base_url('transaction/adjust_stock_history'));
	}
	public function adjust_balance_po()
	{
		$this->auth->cek2('adjust_stock_history');
		$POID	= $this->input->post('reff');
		$this->model_transaction->update_pending_raw_po($POID);
		$this->model_transaction->update_pending_product_po($POID);
		$this->model_transaction->update_status_po($POID);
        redirect(base_url('transaction/adjust_stock_history'));
	}
	public function adjust_balance_so()
	{
	    $this->auth->cek2('adjust_stock_history'); 
		$SOID	= $this->input->post('reff');
    	$this->model_transaction->update_pending_so($SOID); 
        redirect(base_url('transaction/adjust_stock_history'));
	}
	public function excel_content_cek()
	{
	   	$this->auth->cek2('bank_transaction_add');

		$fileName = $_FILES['excel']['name'];
         
        $config['upload_path'] = './assets/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;
        $config['overwrite'] = FALSE;
         
        $this->load->library('upload');
        $this->upload->initialize($config);
         
        if(! $this->upload->do_upload('excel') )
        $this->upload->display_errors();
             
        $media = $this->upload->data('file');
        $file_name = './assets/'.$fileName;
         
		$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
		$spreadsheet = $reader->load($file_name);

		$data = $spreadsheet->getActiveSheet()->toArray();
		$data_all = array();
        $data_note = array();
	    $numrow = 1;
		foreach($data as $row) {
        	$a = 0;
			$data_all[] = $row;
			$data_note[] = $row[1];
	      	$numrow++;
		}
		echo json_encode($data_all);
	}
	public function cek_value()
	{
    	$this->model_transaction->cek_value(); 
	}

// ===================================================================
	function get_opname_detail()
	{
    	$this->model_transaction->get_opname_detail(); 
	}
	function cekAmount()
	{
		$ReffTypeMain = $this->input->get_post('ReffTypeMain');
		if ($ReffTypeMain == "DOR") {
    		$this->model_transaction->cekAmount_DOR(); 
		} elseif ($ReffTypeMain == "DO") {
    		$this->model_transaction->cekAmount_DO_FC(); 
		}
	}
	function cek_stock_all()
	{
		$this->model_transaction->cek_stock_all(); 
	}

}
