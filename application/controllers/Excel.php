<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller {
	public function __construct()
    {
	    parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        // cek login
	    $this->load->library('Auth');
        $this->auth->cek();
        // cek hak akses
	    $this->auth->cek2('excel');
        // cek referrer
        $this->auth->cek3();
	    // save log
	    $this->log_user->log_page();
	    // cek notif
	    $this->load->library('Notification'); 

        $this->load->model('model_excel');
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
	        'image' => $this->session->userdata('image'),
	        'error_info' => $this->session->userdata('error_info'),
	        'data' => array()
	    );
	}
	
	public function index()
	{	
        $this->data['body'] = 'excel.php';
        $this->data['PageTitle'] = 'EXCEL';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'excel';
		$this->load->view('main',$this->data);
	}
	public function excel_supplier()
	{
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $data = array(
                "namefirst" => $rowData[0][0],
                "namemid" => $rowData[0][1],
                "namelast" => $rowData[0][2],
                "gender" => $rowData[0][3],
                "religion" => $rowData[0][4],
                "company" => $rowData[0][5],
                "noktp" => $rowData[0][6],
                "npwp" => $rowData[0][7],
                "isemployee" => $rowData[0][8],
                "iscustomer" => $rowData[0][9],
                "issupplier" => $rowData[0][10],
                "iscompany" => $rowData[0][11],
                "suppliernote" => $rowData[0][12],
                "phone1" => $rowData[0][13],
                "phone2" => $rowData[0][14],
                "phone3" => $rowData[0][15],
                "phone4" => $rowData[0][16],
                "email1" => $rowData[0][17],
                "email2" => $rowData[0][18],
                "email3" => $rowData[0][19],
                "email4" => $rowData[0][20],
                "address1" => $rowData[0][21],
                "address2" => $rowData[0][22],
                "address3" => $rowData[0][23],
                "address4" => $rowData[0][24]
            );
            array_push($data_all, $data);
        }
        $this->model_excel->excel_supplier($data_all);
        redirect(base_url('excel'));
	}
    public function excel_customer()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $data = array(
                "CustomerID" => $rowData[0][0],
                "namefirst" => $rowData[0][1],
                "namemid" => $rowData[0][2],
                "namelast" => $rowData[0][3],
                "gender" => $rowData[0][4],
                "religion" => $rowData[0][5],
                "company" => $rowData[0][6],
                "noktp" => $rowData[0][7],
                "npwp" => $rowData[0][8],
                "creditlimit" => $rowData[0][9],
                "paymentterm" => $rowData[0][10],
                "customernote" => $rowData[0][11],
                "phone1" => $rowData[0][12],
                "phone2" => $rowData[0][13],
                "phone3" => $rowData[0][14],
                "phone4" => $rowData[0][15],
                "email1" => $rowData[0][16],
                "email2" => $rowData[0][17],
                "email3" => $rowData[0][18],
                "address1" => $rowData[0][19],
                "address2" => $rowData[0][20],
                "address3" => $rowData[0][21]
            );
            array_push($data_all, $data);
        }
        
        $this->model_excel->excel_customer($data_all);
        redirect(base_url('excel'));
    }
    public function excel_employee()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $data = array(
                "namefirst" => $rowData[0][0],
                "namemid" => $rowData[0][1],
                "namelast" => $rowData[0][2],
                "gender" => $rowData[0][3],
                "religion" => $rowData[0][4],
                "company" => $rowData[0][5],
                "noktp" => $rowData[0][6],
                "npwp" => $rowData[0][7],
                "isemployee" => $rowData[0][8],
                "iscustomer" => $rowData[0][9],
                "issupplier" => $rowData[0][10],
                "iscompany" => $rowData[0][11],
                "EmploymentID" => $rowData[0][12],
                "StartDate" => $rowData[0][13],
                "EndDate" => $rowData[0][14],
                "phone1" => $rowData[0][15],
                "phone2" => $rowData[0][16],
                "phone3" => $rowData[0][17],
                "phone4" => $rowData[0][18],
                "email1" => $rowData[0][19],
                "email2" => $rowData[0][20],
                "email3" => $rowData[0][21],
                "email4" => $rowData[0][22],
                "address1" => $rowData[0][23],
                "address2" => $rowData[0][24],
                "address3" => $rowData[0][25], 
                "address4" => $rowData[0][26], 
                "BirthDate" => $rowData[0][27], 
                "JoinDate" => $rowData[0][28], 
                "Email11" => $rowData[0][29], 
                "MaritalStatus" => $rowData[0][30], 
                "NIP" => $rowData[0][31],
                "BioID" => $rowData[0][32],
                "empFamilyName" => $rowData[0][33],
                "empFamilySex" => $rowData[0][34],
                "empFamilyJob" => $rowData[0][35],
                "empFamilyStatus" => $rowData[0][36],
                "empFamilyAddress" => $rowData[0][37],
                "empFamilyPhone" => $rowData[0][38],
                "empFamilyEmail" => $rowData[0][39],
                "isAktif" => $rowData[0][40],

            );
            array_push($data_all, $data);
        }
        $this->model_excel->excel_employee($data_all);
        redirect(base_url('excel'));
    }
    public function excel_expedition()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $data = array(
                "Company" => $rowData[0][1],
                "Address" => $rowData[0][2],
                "phone" => $rowData[0][3]
            );
            array_push($data_all, $data);
        }
        
        $this->model_excel->excel_expedition($data_all);
        redirect(base_url('excel'));
    }
    public function excel_fc()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $data = array(
                "CityID" => $rowData[0][0],
                "CityName" => $rowData[0][1],
                "FCPrice" => $rowData[0][2],
                "FCWeight" => $rowData[0][3]
            );
            array_push($data_all, $data);
        }
        
        $this->model_excel->excel_fc($data_all);
        redirect(base_url('excel'));
    }
    public function excel_product()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
            // door
                $data = array(
                    "ProductID" => $rowData[0][$a++],
                    "Name" => $rowData[0][$a++],
                    "Code" => $rowData[0][$a++],
                    "Brand" => $rowData[0][$a++],
                    "Category" => $rowData[0][$a++],
                    "Netto" => $rowData[0][$a++],
                    "Bruto" => $rowData[0][$a++],
                    "Height" => $rowData[0][$a++],
                    "Width" => $rowData[0][$a++],
                    "Design" => $rowData[0][$a++],
                    "Thickness" => $rowData[0][$a++],
                    "Core" => $rowData[0][$a++],
                    "Color" => $rowData[0][$a++],
                    "Species" => $rowData[0][$a++],
                    "Grain" => $rowData[0][$a++],
                    "Open" => $rowData[0][$a++],
                    "HPP" => $rowData[0][$a++],
                    "Price" => $rowData[0][$a++],
                    "Multiplier" => $rowData[0][$a++]
                );
            // =====================================
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_product($data_all);
        redirect(base_url('excel'));
    }
    public function excel_se()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            
                $data = array(
                    "SalesID" => $rowData[0][0],
                    "EmployeeID" => $rowData[0][1],
                    "namefirst" => $rowData[0][2],
                    "namemid" => $rowData[0][3],
                    "namelast" => $rowData[0][4],
                    "gender" => $rowData[0][5],
                    "religion" => $rowData[0][6],
                    "phone" => $rowData[0][7],
                    "email" => $rowData[0][8],
                    "address" => $rowData[0][9],
                    "active" => $rowData[0][10]
                );
            array_push($data_all, $data);
        }
        
        $this->model_excel->excel_se($data_all);
        redirect(base_url('excel'));
    }
    public function excel_inv_main()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'INVID' => $rowData[0][$a++],
                    'DOID' => $rowData[0][$a++],
                    'SOID' => $rowData[0][$a++],
                    'CustomerID' => $rowData[0][$a++],
                    'SalesID' => $rowData[0][$a++],
                    'SECID' => $rowData[0][$a++],
                    'RegionID' => $rowData[0][$a++],
                    'BillingAddress' => $rowData[0][$a++],
                    'ShipAddress' => $rowData[0][$a++],
                    'TaxAddress' => $rowData[0][$a++],
                    'NPWP' => $rowData[0][$a++],
                    'FakturNumber' => $rowData[0][$a++],
                    'PaymentWay' => $rowData[0][$a++],
                    'PaymentTerm' => $rowData[0][$a++],
                    'INVDate' => $rowData[0][$a++],
                    'INVTerm' => "",
                    'INVNote' => "",
                    'TaxRate' => $rowData[0][$a++],
                    'FCInclude' => $rowData[0][$a++],
                    'FCTax' => $rowData[0][$a++],
                    'FCExclude' => $rowData[0][$a++],
                    'FCTotal' => $rowData[0][$a++],
                    'FCRetur' => $rowData[0][$a++],
                    'PriceBeforeTax' => $rowData[0][$a++],
                    'PriceTax' => $rowData[0][$a++],
                    'PriceTotal' => $rowData[0][$a++],
                    'INVTotal' => $rowData[0][$a++],
                    'paymentdate' => $rowData[0][$a++]
                );
                array_push($data_all, $data);
        }
        
        // echo json_encode($data_all);
        $this->model_excel->excel_inv_main_paid($data_all);
        // redirect(base_url('excel'));
    }
    public function excel_inv_main_unpaid()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'INVID' => $rowData[0][$a++],
                    'DOID' => $rowData[0][$a++],
                    'SOID' => $rowData[0][$a++],
                    'CustomerID' => $rowData[0][$a++],
                    'SalesID' => $rowData[0][$a++],
                    'SECID' => $rowData[0][$a++],
                    'RegionID' => $rowData[0][$a++],
                    'BillingAddress' => $rowData[0][$a++],
                    'ShipAddress' => $rowData[0][$a++],
                    'TaxAddress' => $rowData[0][$a++],
                    'NPWP' => $rowData[0][$a++],
                    'FakturNumber' => $rowData[0][$a++],
                    'PaymentWay' => $rowData[0][$a++],
                    'PaymentTerm' => $rowData[0][$a++],
                    'INVDate' => $rowData[0][$a++],
                    'INVTerm' => "",
                    'INVNote' => "",
                    'TaxRate' => $rowData[0][$a++],
                    'FCInclude' => $rowData[0][$a++],
                    'FCTax' => $rowData[0][$a++],
                    'FCExclude' => $rowData[0][$a++],
                    'FCTotal' => $rowData[0][$a++],
                    'FCRetur' => $rowData[0][$a++],
                    'PriceBeforeTax' => $rowData[0][$a++],
                    'PriceTax' => $rowData[0][$a++],
                    'PriceTotal' => $rowData[0][$a++],
                    'INVTotal' => $rowData[0][$a++],
                    'paymentdate' => $rowData[0][$a++],
                    'paymentamount' => $rowData[0][$a++]
                );
                array_push($data_all, $data);
        }
        
        $this->model_excel->excel_inv_main_unpaid($data_all);
        redirect(base_url('excel'));
    }
    public function excel_inv_detail()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'INVID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'ProductName' => $rowData[0][$a++],
                    'ProductQty' => $rowData[0][$a++],
                    'ProductMultiplier' => $rowData[0][$a++],
                    'ProductHPP' => $rowData[0][$a++],
                    'ProductPriceDefault' => $rowData[0][$a++],
                    'ProductWeight' => $rowData[0][$a++],
                    'PromoPercent' => $rowData[0][$a++],
                    'PTPercent' => $rowData[0][$a++],
                    'PriceAmount' => $rowData[0][$a++],
                    'FreightCharge' => $rowData[0][$a++],
                    'PriceTotal' => $rowData[0][$a++],
                    'PV' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        
        $this->model_excel->excel_inv_detail_paid($data_all);
        redirect(base_url('excel'));
    }

    public function excel_ro_main()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'ROID' => $rowData[0][$a++],
                    'SOID' => $rowData[0][$a++],
                    'RONote' => $rowData[0][$a++],
                    'RODate' => $rowData[0][$a++],
                    'ROInput' => $rowData[0][$a++],
                    'ROBy' => $rowData[0][$a++],
                    'ROStatus' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_ro_main($data_all);
        redirect(base_url('excel'));
    }
    public function excel_ro_product()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'ROID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'ProductQty' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_ro_product($data_all);
        redirect(base_url('excel'));
    }
    public function excel_ro_raw()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'ROID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'RawID' => $rowData[0][$a++],
                    'RawQty' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_ro_raw($data_all);
        redirect(base_url('excel'));
    }

    public function excel_po_main()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'POID' => $rowData[0][$a++],
                    'ROID' => $rowData[0][$a++],
                    'SupplierID' => $rowData[0][$a++],
                    'SupplierNote' => $rowData[0][$a++],
                    'BillingTo' => $rowData[0][$a++],
                    'PODate' => $rowData[0][$a++],
                    'PONote' => $rowData[0][$a++],
                    'ShippingTo' => $rowData[0][$a++],
                    'ShippingMethod' => $rowData[0][$a++],
                    'ShippingDate' => $rowData[0][$a++],
                    'PaymentTerm' => $rowData[0][$a++],
                    'TaxRate' => $rowData[0][$a++],
                    'DownPayment' => $rowData[0][$a++],
                    'TaxAmount' => $rowData[0][$a++],
                    'PriceBefore' => $rowData[0][$a++],
                    'TotalPrice' => $rowData[0][$a++],
                    'POCreate' => $rowData[0][$a++],
                    'POBy' => $rowData[0][$a++],
                    'POStatus' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_po_main($data_all);
        redirect(base_url('excel'));
    }
    public function excel_po_product()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'POID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'ProductQty' => $rowData[0][$a++],
                    'ProductPrice' => $rowData[0][$a++],
                    'ProductDisc' => $rowData[0][$a++],
                    'ProductPriceTotal' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_po_product($data_all);
        redirect(base_url('excel'));
    }
    public function excel_po_raw()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'POID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'RawID' => $rowData[0][$a++],
                    'RawQty' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_po_raw($data_all);
        redirect(base_url('excel'));
    }

    public function excel_so_main()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'SOID' => $rowData[0][$a++],
                    'CustomerID' => $rowData[0][$a++],
                    'SalesID' => $rowData[0][$a++],
                    'BillingAddress' => $rowData[0][$a++],
                    'ShipAddress' => $rowData[0][$a++],
                    'TaxAddress' => $rowData[0][$a++],
                    'RegionID' => $rowData[0][$a++],
                    'SECID' => $rowData[0][$a++],
                    'NPWP' => $rowData[0][$a++],
                    'PaymentWay' => $rowData[0][$a++],
                    'PaymentTerm' => $rowData[0][$a++],
                    'SODate' => $rowData[0][$a++],
                    'SOShipDate' => $rowData[0][$a++],
                    'SOTerm' => $rowData[0][$a++],
                    'SONote' => $rowData[0][$a++],
                    'ExpeditionID' => $rowData[0][$a++],
                    'FreightCharge' => $rowData[0][$a++],
                    'SOTotalBefore' => $rowData[0][$a++],
                    'TaxRate' => $rowData[0][$a++],
                    'TaxAmount' => $rowData[0][$a++],
                    'SOTotal' => $rowData[0][$a++],
                    'SOInput' => $rowData[0][$a++],
                    'SOBy' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_so_main($data_all);
        redirect(base_url('excel'));
    }
    public function excel_so_detail()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'SOID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'ProductName' => $rowData[0][$a++],
                    'ProductQty' => $rowData[0][$a++],
                    'ProductMultiplier' => $rowData[0][$a++],
                    'ProductHPP' => $rowData[0][$a++],
                    'ProductPriceDefault' => $rowData[0][$a++],
                    'ProductWeight' => $rowData[0][$a++],
                    'PT1Percent' => $rowData[0][$a++],
                    'PT1Price' => $rowData[0][$a++],
                    'PT2Percent' => $rowData[0][$a++],
                    'PT2Price' => $rowData[0][$a++],
                    'PricePercent' => $rowData[0][$a++],
                    'PriceAmount' => $rowData[0][$a++],
                    'FreightCharge' => $rowData[0][$a++],
                    'PriceTotal' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_so_detail($data_all);
        redirect(base_url('excel'));
    }
    
    public function excel_do_main()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'DOID' => $rowData[0][$a++],
                    'DOReff' => $rowData[0][$a++],
                    'DODate' => $rowData[0][$a++],
                    'DONote' => $rowData[0][$a++],
                    'DOBy' => $rowData[0][$a++],
                    'DOInput' => $rowData[0][$a++],
                    'DOStatus' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_do_main($data_all);
        redirect(base_url('excel'));
    }
    public function excel_do_detail()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'DOID' => $rowData[0][$a++],
                    'ProductID' => $rowData[0][$a++],
                    'ProductQty' => $rowData[0][$a++]
                );
            array_push($data_all, $data);
        }
        echo json_encode($data_all);
        $this->model_excel->excel_do_detail($data_all);
        redirect(base_url('excel'));
    }

    public function excel_dp_free()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
                $data = array(
                    'CustomerID' => $rowData[0][$a++],
                    'Company' => $rowData[0][$a++],
                    'BankTransactionAmount' => $rowData[0][$a++]
                );
                array_push($data_all, $data);
        }
        // echo json_encode(count($data_all));
        $this->model_excel->excel_dp_free($data_all);
        redirect(base_url('excel'));
    }
    public function excel_kw2()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
                $a = 0;
            // door
                $data = array(
                    "ProductID" => $rowData[0][$a++],
                    "ProductID2" => $rowData[0][$a++],
                    "ProductCode" => $rowData[0][$a++],
                    "ProductName" => $rowData[0][$a++],
                    "Qty" => $rowData[0][$a++]
                );
            // =====================================
            array_push($data_all, $data);
        }
        
        $this->model_excel->excel_kw2($data_all);
        redirect(base_url('excel'));
    }

    public function excel_asset_detail()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $a = 0;
            // door
                $data = array(
                    /*
                    "AssetID"           => $rowData[0][$a++],
                    "EmployeeID"        => $rowData[0][$a++],
                    "DateIn"            => $rowData[0][$a++],
                    "DateOut"           => $rowData[0][$a++],
                    "Note"              => $rowData[0][$a++],
                    */
                    "AssetID"           => $rowData[0][$a++],
                    "EmployeeID"        => $rowData[0][$a++],
                    "DateIn"            => $rowData[0][$a++],
                    "DateOut"           => $rowData[0][$a++],
                    "StatusIn"          => $rowData[0][$a++],
                    /*"Note"              => $rowData[0][$a++],*/
                );
            // =====================================
            array_push($data_all, $data);
        }
        // echo json_encode($data_all);
        $this->model_excel->excel_asset_detail($data_all);
        redirect(base_url('excel'));
    }
    public function excel_asset_main()
    {
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
        for ($row = 2; $row <= $highestRow; $row++){                     
            $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, NULL, TRUE, FALSE);
            $a = 0;
            // door
            /*    $data = array(
                    "AssetID"                           => $rowData[0][$a++],
                    "AssetSpesification"                => $rowData[0][$a++],
                    "ModelNumber"                       => $rowData[0][$a++],
                    "SerialNumber"                      => $rowData[0][$a++],
                    "AssetColor"                        => $rowData[0][$a++],
                    "AssetCategory"                     => $rowData[0][$a++],
                    "AssetType"                         => $rowData[0][$a++],
                    "AssetCondition"                    => $rowData[0][$a++],
                    "AssetName"                         => $rowData[0][$a++],
                    "AssetNote"                         => $rowData[0][$a++],
                    "DateIn"                            => $rowData[0][$a++],
                    "Price"                             => $rowData[0][$a++],
                );
            */
            // =====================================
            // door
                $data = array(
                    "AssetID"                           => $rowData[0][$a++],
                    "AssetName"                         => $rowData[0][$a++],
                    "ModelNumber"                       => $rowData[0][$a++],
                    "SerialNumber"                      => $rowData[0][$a++],
                    "AssetColor"                        => $rowData[0][$a++],
                    "AssetType"                         => $rowData[0][$a++],
                    "AssetCategory"                     => $rowData[0][$a++],
                    "AssetCondition"                    => $rowData[0][$a++],
                    "AssetSpesification"                => $rowData[0][$a++],
                    "AssetNote"                         => $rowData[0][$a++],
                    "DateIn"                            => $rowData[0][$a++],
                    "Price"                             => $rowData[0][$a++],
                );
            // =====================================
            array_push($data_all, $data);
        }
        // echo json_encode($data_all);
        $this->model_excel->excel_asset_main($data_all);
        redirect(base_url('excel'));
        
    }

    public function delete_duplicate()
    {
        $this->model_excel->delete_duplicate();
    }
}
