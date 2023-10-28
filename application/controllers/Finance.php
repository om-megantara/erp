<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH.'libraries/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Finance extends CI_Controller {
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

        $this->load->model('model_finance');
	    $this->data = array(
	        'notification' => $this->notification->notif_all(),
	        'menu' => 'menu.php',
	        'UserAccountID' => $this->session->userdata('UserAccountID'),
	        'EmployeeID' => $this->session->userdata('EmployeeID'),
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

// bank_transaction======================================================
	public function bank_transaction()
	{	
	   	$this->auth->cek2('bank_transaction'); 
        $this->data['PageTitle'] = 'BANK TRANSACTION';
        $this->data['body'] = 'finance/bank_transaction.php';
		$this->data['data']['content'] = $this->model_finance->bank_transaction(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'bank_transaction';
		$this->load->view('main',$this->data);
	}
	public function bank_transaction_add()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->bank_transaction_add(); 
        redirect(base_url('finance/bank_transaction'));
	}
	public function excel_transaction()
	{
	   	$this->auth->cek2('bank_transaction_add');

		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
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
        $inputFileName = './assets/'.$fileName;
         
        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $data_all = array();
        $data_note = array();
        for ($row = 1; $row <= $highestRow; $row++){    //  Read a row of data into an array                 
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
			// $data = str_getcsv($rowData[0],',','"');
            array_push($data_all, $rowData[0]);
            array_push($data_note, $rowData[0][1]);
			if(empty($rowData[0])){break;}
        }
        $this->model_finance->excel_transaction($data_all, $data_note);
        redirect(base_url('finance/bank_transaction'));
	}
	public function transaction_setasdesposit()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->transaction_setasdesposit();
        // redirect(base_url('finance/bank_transaction'));
	}
	public function transaction_undodesposit()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->transaction_undodesposit(); 
        // redirect(base_url('finance/bank_transaction'));
	}
	public function transaction_delete()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->transaction_delete(); 
	}
	public function transaction_recalculate()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->transaction_recalculate(); 
        redirect(base_url('finance/bank_transaction'));
	} 
	public function bank_transaction_daily_report()
	{	
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->data['PageTitle'] = 'PRINT TRANSACTION DAILY REPORT';
		$this->data['content'] = $this->model_finance->bank_transaction_daily_report(); 
        $this->load->view('finance/bank_transaction_daily_report.php',$this->data);
	}
	
// confirmation_deposit==================================================
	public function confirmation_deposit()
	{	
	   	$this->auth->cek2('customer_deposit'); 
        $this->data['PageTitle'] = 'CONFIRMATION DEPOSIT';
        $this->data['body'] = 'finance/confirmation_deposit.php';
		$this->data['data']['content'] = $this->model_finance->confirmation_deposit(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'confirmation_deposit';
		$this->load->view('main',$this->data);
	}
	public function confirmation_deposit_distribution()
	{	
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->data['PageTitle'] = 'CONFIRMATION DEPOSIT';
        $this->data['body'] = 'finance/confirmation_deposit_distribution.php';
		$this->data['data']['content'] = $this->model_finance->confirmation_deposit_distribution(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'confirmation_deposit';
		$this->load->view('main',$this->data);
	}
	public function confirmation_deposit_distribution_act()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->model_finance->confirmation_deposit_distribution_act(); 
        redirect(base_url('finance/confirmation_deposit'));
	}
	public function retur_deposit_so()
	{	
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->data['PageTitle'] = 'RETUR DEPOSIT';
        $this->data['body'] = 'finance/retur_deposit_so.php';
		$this->data['data']['content'] = $this->model_finance->retur_deposit_so(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'confirmation_deposit';
		$this->load->view('main',$this->data);
	}
	public function retur_deposit_so_act()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->model_finance->retur_deposit_so_act(); 
        redirect(base_url('transaction/sales_order_list'));
	}
	public function retur_payment_inv()
	{	
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->data['PageTitle'] = 'RETUR PAYMENT';
        $this->data['body'] = 'finance/retur_payment_inv.php';
		$this->data['data']['content'] = $this->model_finance->retur_payment_inv(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'confirmation_deposit';
		$this->load->view('main',$this->data);
	}
	public function retur_payment_inv_act()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->model_finance->retur_payment_inv_act(); 
        redirect(base_url('transaction/invoice_list'));
	}
	public function print_bkbm()
	{	
	   	$this->auth->cek2('customer_deposit'); 
        $this->data['PageTitle'] = 'PRINT BKBM';
		$this->data['content'] = $this->model_finance->print_bkbm(); 
        $this->load->view('finance/bkbm_print.php',$this->data);
	} 

// customer_deposit======================================================
	public function customer_deposit()
	{	
	   	$this->auth->cek2('customer_deposit'); 
        $this->data['PageTitle'] = 'CUSTOMER DEPOSIT';
        $this->data['body'] = 'finance/customer_deposit.php';

        $this->load->model('model_hrd');
  		$this->data['data']['fill_company'] = $this->model_hrd->company_list();
  		
		$this->data['data']['content'] = $this->model_finance->customer_deposit_summary(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_deposit';
		$this->load->view('main',$this->data);
	}
	public function customer_deposit_list()
	{
    	$this->auth->cek2('customer_deposit'); 
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
            // nama tabel
	        'table' => 'vw_customer_deposit', 
            // field yg ditampilkan
	        'column_order' => array(null,'CustomerID','Company','TotalDeposit','DepositUsed','TotalBalance','TotalDebt',null), 
            //field pencarian 
	        'column_search' => array('CustomerID','Company'),  
	        'order' => array('CustomerID' => 'asc')  
	    );
	    
	    $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$row = array();
			$row[] = $field->CustomerID;
			$row[] = $field->CustomerID;
			$row[] = $field->Company;
			$row[] = number_format($field->TotalDeposit,2);
			$row[] = number_format($field->DepositUsed,2);
			$row[] = number_format($field->TotalBalance,2);
			$row[] = number_format($field->TotalDebt,2);
			$row[] = '<a href="#" class="btn btn-flat btn-xs btn-success dtbutton" id="view" customer="'.$field->CustomerID.'" title="VIEW ALL DEPOSIT"><i class="fa fa-fw fa-file-image-o"></i></a>';

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
	public function customer_deposit_detail()
	{	
	   	$this->auth->cek2('customer_deposit'); 
        $this->data['PageTitle'] = 'CUSTOMER DEPOSIT DETAIL';
        $this->data['body'] = 'finance/customer_deposit_detail.php';
		$this->data['data']['content'] = $this->model_finance->customer_deposit_detail(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_deposit';
		$this->load->view('main',$this->data);
	}
	public function customer_deposit_detail_full() 
	{
	    $this->auth->cek2('customer_deposit'); 
        $this->data['content'] = $this->model_finance->customer_deposit_distribution(); 
        $this->load->view('finance/customer_deposit_detail_full.php',$this->data);
    }
	public function customer_deposit_distribution()
	{	
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->data['PageTitle'] = 'CUSTOMER DEPOSIT';
        $this->data['body'] = 'finance/customer_deposit_distribution.php';
		$this->data['data']['content'] = $this->model_finance->customer_deposit_distribution(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_deposit';
		$this->load->view('main',$this->data);
	}
	public function customer_deposit_distribution_act()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
		$CustomerID = $this->input->get_post('CustomerID');
        $this->model_finance->customer_deposit_distribution_act(); 
        redirect(site_url('finance/customer_deposit_detail?id=').$CustomerID);
	}
	public function customer_deposit_retur()
	{	
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->data['PageTitle'] = 'CUSTOMER DEPOSIT RETUR';
        $this->data['body'] = 'finance/customer_deposit_retur.php';
		$this->data['data']['content'] = $this->model_finance->customer_deposit_retur(); 
  		// $this->data['data']['fill_type'] = $this->model_finance->fill_bank_distribution_type();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_deposit';
		$this->load->view('main',$this->data);
	}
	public function customer_deposit_retur_act()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
		$CustomerID = $this->input->get_post('CustomerID');
        $this->model_finance->customer_deposit_retur_act(); 
        redirect(site_url('finance/customer_deposit_detail?id=').$CustomerID);
	}
	public function customer_deposit_batch_retur()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->model_finance->customer_deposit_batch_retur(); 
	}

// invoice_payment=======================================================
	public function invoice_payment()
	{	
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->data['PageTitle'] = 'INVOICE PAYMENT';
        $this->data['body'] = 'finance/invoice_payment.php';
		$this->data['data']['content'] = $this->model_finance->invoice_payment(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'invoice_list';
		$this->load->view('main',$this->data);
	}
	public function invoice_payment_act()
	{
	   	$this->auth->cek2('customer_deposit_allocation'); 
        $this->model_finance->invoice_payment_act(); 
        redirect(base_url('transaction/invoice_list'));
	}
	public function invoice_payment_detail() 
	{
	    $this->auth->cek2('customer_deposit'); 
        $this->data['content'] = $this->model_finance->invoice_payment(); 
        $this->load->view('finance/invoice_payment_detail.php',$this->data);
    }

// bank_distribution=====================================================
    public function bank_distribution()
	{	
	   	$this->auth->cek2('bank_distribution'); 
        $this->data['PageTitle'] = 'BANK DISTRIBUTION';
        $this->data['body'] = 'finance/bank_distribution.php';

        $this->load->model('model_hrd');
  		$this->data['data']['fill_company'] = $this->model_hrd->company_list();

		$this->data['data']['content'] = $this->model_finance->bank_distribution(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'bank_distribution';
		$this->load->view('main',$this->data);
	}
	public function bank_distribution_add()
	{	
	   	$this->auth->cek2('bank_distribution'); 
        $this->data['PageTitle'] = 'BANK DISTRIBUTION ADD';
        $this->data['body'] = 'finance/bank_distribution_add.php';
  		// $this->data['data']['fill_type'] = $this->model_finance->fill_distribution_type();

        if (isset($_REQUEST['id']) && $_REQUEST['id']!=0) {
  			$this->data['data']['content'] = $this->model_finance->bank_distribution_edit();
  		}

        $this->load->model('model_hrd');
  		$this->data['data']['fill_company'] = $this->model_hrd->company_list();
  		$this->data['data']['fill_divisi'] = $this->model_hrd->divisi_list_current();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'bank_distribution';
		$this->load->view('main',$this->data);
	}
	public function bank_distribution_add_act()
	{
	   	$this->auth->cek2('bank_distribution'); 
	   	if (isset($_REQUEST['DistributionID']) && $_REQUEST['DistributionID']!=0) {
        	$this->model_finance->bank_distribution_edit_act(); 
  		} else {
        	$this->model_finance->bank_distribution_add_act(); 
  		}
        redirect(base_url('finance/bank_distribution'));
	}
	public function bank_distribution_delete()
	{
	   	$this->auth->cek2('bank_distribution'); 
    	$this->model_finance->bank_distribution_delete(); 
	}
	public function setBankTransactionID()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->setBankTransactionID(); 
        redirect(base_url('finance/bank_distribution'));
	}
	public function bank_distribution_print()
	{
	    $this->auth->cek2('bank_distribution'); 
        $this->data['PageTitle'] = 'BANK DISTRIBUTION Print';
    	$this->data['content'] = $this->model_finance->bank_distribution_print(); 
        $this->load->view('finance/bank_distribution_print.php',$this->data);
	}
	public function bank_distribution_print_all()
	{
	    $this->auth->cek2('bank_distribution'); 
        $this->data['PageTitle'] = 'BANK DISTRIBUTION Print ALL';
    	$this->data['content'] = $this->model_finance->bank_distribution_print_all(); 
        $this->load->view('finance/bank_distribution_print_all.php',$this->data);
	}
	public function inputIntoBankTransaction()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->inputIntoBankTransaction(); 
        redirect(base_url('finance/bank_distribution'));
	}
	public function excel_distribution()
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
			if (count($row) == 5) {
				$data_all[] = $row;
				$data_note[] = $row[1];
		      	$numrow++;
			} else { 
				$newdata['error_info'] = "upload excel gagal, Format excel Bank salah";
				$this->session->set_userdata($newdata);
 				redirect(base_url('finance/bank_distribution'));
			}
		}
        $this->model_finance->excel_distribution($data_all, $data_note);
        redirect(base_url('finance/bank_distribution'));
	}
	public function get_distribution_detail()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->get_distribution_detail(); 
	}
	public function distribution_delete_batch()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->distribution_delete_batch(); 
	}
	public function distribution_disable_batch()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->distribution_disable_batch(); 
	}
	public function distribution_enable_batch()
	{
	   	$this->auth->cek2('bank_transaction_add'); 
        $this->model_finance->distribution_enable_batch(); 
	}

// customer_retur========================================================
	public function customer_retur()
	{	
	   	$this->auth->cek2('customer_retur'); 
        $this->data['PageTitle'] = 'CUSTOMER RETUR';
        $this->data['body'] = 'finance/customer_retur.php';
		$this->data['data']['content'] = $this->model_finance->customer_retur(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'customer_retur';
		$this->load->view('main',$this->data);
	}
	
//=======================================================================
	public function fill_transaction()
	{
		$this->model_finance->fill_transaction();
	}
	public function cekAmountTransaction()
	{
		$this->model_finance->cekAmountTransaction();
	}
	public function customer_list_popup()
	{
        $this->load->model('model_master');
		$this->data['content'] = $this->model_master->customer_list();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/contact/customer_list_popup.php',$this->data);
	}
	public function customer_list_popup2()
	{
        $this->data['data']['help'] = 'Doc';
        $this->load->view('master/contact/customer_list_popup2.php',$this->data);
	}
	public function customer_list_popup2_data()
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
	        'table' => 'vw_customer1', 
	        'column_order' => array(null,'CustomerID', 'fullname','Company','CustomercategoryName'), 
	        'column_search' => array('CustomerID', 'fullname','Company','CustomercategoryName'),  
	        'order' => array('CustomerID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$row = array();
			$row[] = '<a href="#" class="insert_data">Submit</a>';
			$row[] = $field->CustomerID;
			$row[] = $field->fullname;
			$row[] = $field->Company;
			$row[] = $field->CustomercategoryName;

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
	public function get_customer_deposit_dst()
	{
		$this->model_finance->get_customer_deposit_dst();
	}
	public function get_customer_payment_rsc()
	{
		$this->model_finance->get_customer_payment_rsc();
	}
	public function fill_bank_distribution_type()
	{
		$this->model_finance->fill_bank_distribution_type();
	}
	public function cekReffDistribution()
	{
		$this->model_finance->cekReffDistribution();
	}
}
