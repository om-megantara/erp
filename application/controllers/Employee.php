<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH.'libraries/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Employee extends CI_Controller {
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

        $this->load->model('model_employee');
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

	public function view_profile($id)
	{
		// cek jika user punya hak akses melihat profil orang lain
		if ($id != $this->session->userdata('EmployeeID')) { 
	    	$this->auth->cek2('view_profile'); 
		}
        $this->data['PageTitle'] = 'PROFILE';
        $this->data['body'] = 'employee/profile.php';
        $this->data['content_profile'] = $this->model_employee->content_profile($id);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'none';
		$this->load->view('main',$this->data);
	}
	public function employee_public_detail($id)
	{
		// cek jika user punya hak akses melihat profil orang lain
		if ($id != $this->session->userdata('EmployeeID')) { 
	    	$this->auth->cek2('view_profile'); 
		}
        $this->data['PageTitle'] = 'EMPLOYEE PUBLIC DETAIL';
        $this->data['body'] = 'employee/employee_public_detail.php';
        $this->data['content_profile'] = $this->model_employee->content_profile($id);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'none';
		$this->load->view('main',$this->data);
	}
	public function employee_all()
	{
        $this->data['PageTitle'] = 'LIST ALL EMPLOYEE';
        $this->data['body'] = 'employee/employee_all.php';
        $this->data['data']['content'] = $this->model_employee->employee_all();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'none';
		$this->load->view('main',$this->data);
	}
	public function employee_all2()
	{
	    $this->auth->cek2('employee_list'); 
        $this->data['PageTitle'] = 'LIST ALL EMPLOYEE';
        $this->data['body'] = 'employee/employee_all.php';
        $this->data['data']['content'] = $this->model_employee->employee_all2();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'none';
		$this->load->view('main',$this->data);
	}

// ======================================================================
	public function employee_list()
	{
	    $this->auth->cek2('employee_list'); 
        $this->data['PageTitle'] = 'LIST ALL EMPLOYEE';
        $this->data['body'] = 'employee/employee_list.php';
		$this->data['data']['content'] = $this->model_employee->employee_list();
        $this->data['data']['help'] = 'EMPLOYEE_LIST_v.1';
        $this->data['data']['menu'] = 'employee_list';
		$this->load->view('main',$this->data);
	}
	public function employee_add()
	{
	    $this->auth->cek2('employee_add'); 
        $this->data['PageTitle'] = 'ADD EMPLOYEE';
        $this->data['body'] = 'employee/employee_add.php';
        $this->data['data']['help'] = 'EMPLOYEE_LIST_v.1';
        $this->data['data']['menu'] = 'employee_list';
		$this->load->view('main',$this->data);
	}
	public function employee_add_act()
	{
	    $this->auth->cek2('employee_add'); 
        $this->model_employee->employee_add_act(); 
        redirect(base_url('employee/employee_list'));
	}
	public function employee_edit($id)
	{
	    $this->auth->cek2('employee_edit'); 
        $this->data['PageTitle'] = 'EDIT EMPLOYEE';
        $this->data['body'] = 'employee/employee_edit.php';
        $this->data['data']['content'] = $this->model_employee->employee_edit($id);
        $this->data['data']['help'] = 'EMPLOYEE_LIST_v.1';
        $this->data['data']['menu'] = 'employee_list';
		$this->load->view('main',$this->data);
	}
	public function employee_edit_act($val)
	{
	    $this->auth->cek2('employee_edit'); 
        $this->model_employee->employee_edit_act($val); 
        // echo "<script>window.close();</script>";
        redirect(base_url('employee/employee_list'));
	}
	public function employee_view_file($val)
	{
		$val2 = explode("_", $val); 
		// cek jika user punya hak akses melihat profil orang lain
		if ($val2[0] != $this->session->userdata('EmployeeID')) { 
			$this->auth->cek2('view_profile'); 
		}
        $this->model_employee->employee_view_file($val);
	}
	public function employee_export($id)
	{
	    $this->auth->cek2('employee_edit'); 
		$file = new Spreadsheet();
		$active_sheet = $file->getActiveSheet();

		// -----------------------------------------------------------------------
			$query = $this->db->get_where('tb_contact', array('ContactID' => $id));
			$row = $query->row();
	        $active_sheet->setCellValue('A1', 'NameFirst');
			$active_sheet->setCellValue('A2', $row->NameFirst);
			$active_sheet->setCellValue('B1', 'NameMid');
			$active_sheet->setCellValue('B2', $row->NameMid);
			$active_sheet->setCellValue('C1', 'NameLast');
			$active_sheet->setCellValue('C2', $row->NameLast);
			$active_sheet->setCellValue('D1', 'Gender');
			$active_sheet->setCellValue('D2', $row->Gender);
			$active_sheet->setCellValue('E1', 'ReligionID');
			$active_sheet->setCellValue('E2', $row->ReligionID);
			$active_sheet->setCellValue('F1', 'NPWP');
			$active_sheet->setCellValue('F2', $row->NPWP);
	        $active_sheet->setCellValue('G1', 'NoKTP');
			$active_sheet->setCellValue('G2', $row->NoKTP);

			$query = $this->db->get_where('tb_contact_address', array('ContactID' => $id));
			$row = $query->row();
	        $active_sheet->setCellValue('H1', 'DetailType');
			$active_sheet->setCellValue('H2', $row->DetailType);
	        $active_sheet->setCellValue('I1', 'DetailValue');
			$active_sheet->setCellValue('I2', $row->DetailValue);
	        $active_sheet->setCellValue('J1', 'StateID');
			$active_sheet->setCellValue('J2', $row->StateID);
	        $active_sheet->setCellValue('K1', 'ProvinceID');
			$active_sheet->setCellValue('K2', $row->ProvinceID);
	        $active_sheet->setCellValue('L1', 'CityID');
			$active_sheet->setCellValue('L2', $row->CityID);
	        $active_sheet->setCellValue('M1', 'DistrictsID');
			$active_sheet->setCellValue('M2', $row->DistrictsID);
	        $active_sheet->setCellValue('N1', 'PosID');
			$active_sheet->setCellValue('N2', $row->PosID);

			$query = $this->db->get_where('tb_contact_detail', array('ContactID' => $id, 'DetailName' => 'phone'));
			$row = $query->row();
	        $active_sheet->setCellValue('O1', 'DetailName');
			$active_sheet->setCellValue('O2', 'phone');
	        $active_sheet->setCellValue('P1', 'DetailValue');
			$active_sheet->setCellValue('P2', $row->DetailValue);

			$query = $this->db->get_where('tb_contact_detail', array('ContactID' => $id, 'DetailName' => 'email'));
			$row = $query->row();
	        $active_sheet->setCellValue('Q1', 'DetailName');
			$active_sheet->setCellValue('Q2', 'email');
	        $active_sheet->setCellValue('R1', 'DetailValue');
			$active_sheet->setCellValue('R2', $row->DetailValue);

			$query = $this->db->get_where('tb_employee_main', array('ContactID' => $id));
			$row = $query->row();
	        $active_sheet->setCellValue('S1', 'BirthDate');
			$active_sheet->setCellValue('S2', $row->BirthDate);
	        $active_sheet->setCellValue('T1', 'JoinDate');
			$active_sheet->setCellValue('T2', $row->JoinDate);
	        $active_sheet->setCellValue('U1', 'EmploymentID');
			$active_sheet->setCellValue('U2', $row->EmploymentID);
	        $active_sheet->setCellValue('V1', 'StartDate');
			$active_sheet->setCellValue('V2', $row->StartDate);
	        $active_sheet->setCellValue('W1', 'LocID');
			$active_sheet->setCellValue('W2', $row->LocID);
	        $active_sheet->setCellValue('X1', 'Email');
			$active_sheet->setCellValue('X2', $row->Email);
	        $active_sheet->setCellValue('Y1', 'MaritalStatus');
			$active_sheet->setCellValue('Y2', $row->MaritalStatus);
	        $active_sheet->setCellValue('Z1', 'NIP');
			$active_sheet->setCellValue('Z2', $row->NIP);
	        $active_sheet->setCellValue('AA1', 'BioID');
			$active_sheet->setCellValue('AA2', $row->BioID);
			$EmployeeID = $row->EmployeeID;

			$query = $this->db->get_where('tb_employee_family', array('EmployeeID' => $EmployeeID));
			$row = $query->row();
	        $active_sheet->setCellValue('AB1', 'empFamilyName');
	        $active_sheet->setCellValue('AB2', $row->empFamilyName);
	        $active_sheet->setCellValue('AC1', 'empFamilySex');
	        $active_sheet->setCellValue('AC2', $row->empFamilySex);
	        $active_sheet->setCellValue('AD1', 'empFamilyJob');
	        $active_sheet->setCellValue('AD2', $row->empFamilyJob);
	        $active_sheet->setCellValue('AE1', 'empFamilyStatus');
	        $active_sheet->setCellValue('AE2', $row->empFamilyStatus);
	        $active_sheet->setCellValue('AF1', 'empFamilyAddress');
	        $active_sheet->setCellValue('AF2', $row->empFamilyAddress);
	        $active_sheet->setCellValue('AG1', 'empFamilyPhone');
	        $active_sheet->setCellValue('AG2', $row->empFamilyPhone);
	        $active_sheet->setCellValue('AH1', 'empFamilyEmail');
	        $active_sheet->setCellValue('AH2', $row->empFamilyEmail);
 
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file,'Xls');
		$file_name = 'Employee_'.$EmployeeID.strtolower('.xls');
		$writer->save($file_name); 

		header('Content-Type: application/x-www-form-urlencoded'); 
		header('Content-Transfer-Encoding: Binary'); 
		header("Content-disposition: attachment; filename=\"".$file_name."\""); 
		readfile($file_name); 
		unlink($file_name); 
	}
	public function employee_import_excel()
	{
	    $this->auth->cek2('employee_edit'); 
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
                	$a = 0;
			      	if($numrow > 1){
						array_push($data_all, array( 
							'NameFirst' => $row[$a++],
							'NameMid' => $row[$a++],
							'NameLast' => $row[$a++],
							'Gender' => $row[$a++],
							'ReligionID' => $row[$a++],
							'NPWP' => $row[$a++],
							'NoKTP' => $row[$a++],

							'DetailType' => $row[$a++],
							'DetailValue' => $row[$a++],
							'StateID' => $row[$a++],
							'ProvinceID' => $row[$a++],
							'CityID' => $row[$a++],
							'DistrictsID' => $row[$a++],
							'PosID' => $row[$a++],

							'DetailNamePhone' => $row[$a++],
							'DetailValuePhone' => $row[$a++],

							'DetailNameEmail' => $row[$a++],
							'DetailValueEmail' => $row[$a++],

							'BirthDate' => $row[$a++],
							'JoinDate' => $row[$a++],
							'EmploymentID' => $row[$a++],
							'StartDate' => $row[$a++],
							'LocID' => $row[$a++],
							'Email' => $row[$a++],
							'MaritalStatus' => $row[$a++],
							'NIP' => $row[$a++],
							'BioID' => $row[$a++],

							'empFamilyName' => $row[$a++],
							'empFamilySex' => $row[$a++],
							'empFamilyJob' => $row[$a++],
							'empFamilyStatus' => $row[$a++],
							'empFamilyAddress' => $row[$a++],
							'empFamilyPhone' => $row[$a++],
							'empFamilyEmail' => $row[$a++], 
				        ));
					
					} else {
						if (
							($row[$a++] == 'NameFirst') and 
							($row[$a++] == 'NameMid') and 
							($row[$a++] == 'NameLast') and 
							($row[$a++] == 'Gender') and 
							($row[$a++] == 'ReligionID') and 
							($row[$a++] == 'NPWP') and 
							($row[$a++] == 'NoKTP') and 
							($row[$a++] == 'DetailType') and 
							($row[$a++] == 'DetailValue') and 
							($row[$a++] == 'StateID') and 
							($row[$a++] == 'ProvinceID') and 
							($row[$a++] == 'CityID') and 
							($row[$a++] == 'DistrictsID') and 
							($row[$a++] == 'PosID') and 
							($row[$a++] == 'DetailName') and 
							($row[$a++] == 'DetailValue') and 
							($row[$a++] == 'DetailName') and 
							($row[$a++] == 'DetailValue') and 
							($row[$a++] == 'BirthDate') and 
							($row[$a++] == 'JoinDate') and 
							($row[$a++] == 'EmploymentID') and 
							($row[$a++] == 'StartDate') and 
							($row[$a++] == 'LocID') and 
							($row[$a++] == 'Email') and 
							($row[$a++] == 'MaritalStatus') and 
							($row[$a++] == 'NIP') and 
							($row[$a++] == 'BioID') and 
							($row[$a++] == 'empFamilyName') and 
							($row[$a++] == 'empFamilySex') and 
							($row[$a++] == 'empFamilyJob') and 
							($row[$a++] == 'empFamilyStatus') and 
							($row[$a++] == 'empFamilyAddress') and 
							($row[$a++] == 'empFamilyPhone') and 
							($row[$a++] == 'empFamilyEmail') 
						) { } else {
							$newdata['error_info'] = "upload excel gagal, Format excel employee salah";
							$this->session->set_userdata($newdata);
       		 				redirect(base_url('employee/employee_list'));
						}
					}
			      	$numrow++;
				}
		        $this->model_employee->employee_import_excel($data_all);
		    }
		}
        redirect(base_url('employee/employee_list'));
	}
	public function employee_list_active()
	{
	    $this->auth->cek2('employee_list_active'); 
        $this->data['PageTitle'] = 'LIST ACTIVE EMPLOYEE';
        $this->data['body'] = 'employee/employee_list_active.php';
		$this->data['data']['content'] = $this->model_employee->employee_list_active();
        $this->data['data']['help'] = 'EMPLOYEE_LIST_v.1';
        $this->data['data']['menu'] = 'employee_list_active';
		$this->load->view('main',$this->data);
	}
	public function employee_penalty_list()
	{
	    $this->auth->cek2('employee_penalty');
        $this->data['PageTitle'] = 'EMPLOYEE PENALTY';
        $this->data['body'] = 'employee/employee_penalty_list.php';
		$this->data['data']['content'] = $this->model_employee->employee_penalty_list();
        $this->data['data']['help'] = 'EMPLOYEE_LIST_v.1';
        $this->data['data']['menu'] = 'employee_penalty';
		$this->load->view('main',$this->data);
	}
	public function employee_penalty_detail()
	{
	    $this->auth->cek2('employee_penalty');
		$this->data['content'] = $this->model_employee->employee_penalty_detail();
        $this->load->view('employee/employee_penalty_detail.php',$this->data);
	}
	public function employee_penalty($id)
	{
        $this->auth->cek2('employee_penalty');
        $this->data['PageTitle'] = 'Penalty Order';
        $this->data['body'] = 'employee/employee_penalty.php';
        $this->data['data']['content'] = $this->model_employee->employee_penalty($id); 
        // echo json_encode($this->model_employee->employee_penalty($id));
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'employee_penalty';
        $this->load->view('main',$this->data);
	}
	public function employee_penalty_act()
	{
        $this->auth->cek2('employee_penalty'); 
        $this->model_employee->employee_penalty_act(); 
        redirect(base_url('employee/employee_penalty_list'));
	}
	public function employee_penalty_point($id)
	{
        $this->auth->cek2('employee_penalty_point'); 
        $this->data['PageTitle'] = 'Penalty Point Order';
        $this->data['body'] = 'employee/employee_penalty_point.php';
        $this->data['data']['content'] = $this->model_employee->employee_penalty_point($id); 
        // echo json_encode($this->model_employee->employee_penalty($id));
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'employee_penalty_point';
        $this->load->view('main',$this->data);
	}
	public function employee_penalty_point_act()
	{
        $this->auth->cek2('employee_penalty_point'); 
        $this->model_employee->employee_penalty_point_act(); 
        redirect(base_url('employee/employee_penalty_list'));
	}
	public function employee_overtime()
	{
        $this->auth->cek2('employee_overtime');
        $this->data['PageTitle'] = 'EMPLOYEE OVERTIME';
        $this->data['body'] = 'employee/employee_overtime.php';
        $this->data['data']['content'] = $this->model_employee->employee_overtime();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'employee_overtime';
        $this->load->view('main',$this->data);
	}
	public function employee_overtime_add()
	{
        $this->auth->cek2('employee_overtime');
        $this->data['PageTitle'] = 'EMPLOYEE OVERTIME ADD';
        $this->data['body'] = 'employee/employee_overtime_add.php';
        $this->data['data']['content'] = $this->model_employee->employee_overtime_add();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'employee_overtime';
        $this->load->view('main',$this->data);
	}
	public function employee_overtime_add_act()
	{
        $this->auth->cek2('employee_overtime');
        $this->model_employee->employee_overtime_add_act();
        redirect(base_url('employee/employee_overtime'));
	}
	public function employee_overtime_edit()
	{
        $this->auth->cek2('employee_overtime');
        $this->data['PageTitle'] = 'EMPLOYEE OVERTIME EDIT';
        $this->data['body'] = 'employee/employee_overtime_edit.php';
        $this->data['data']['content'] = $this->model_employee->employee_overtime_edit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'employee_overtime';
        $this->load->view('main',$this->data);
	}
	public function employee_overtime_edit_act()
	{
        $this->auth->cek2('employee_overtime');
        $this->model_employee->employee_overtime_edit_act();
        redirect(base_url('employee/employee_overtime'));
	}
	public function employee_overtime_cancel()
	{
		$this->auth->cek2('employee_overtime');
		$this->model_employee->employee_overtime_cancel();
	}
	public function get_quantity()
	{
		$this->model_employee->get_quantity();
	}
	public function get_poin()
	{
		$this->model_employee->get_poin();
	}

// ======================================================================
	public function employee_attendance()
	{
	    $this->auth->cek2('employee_list'); 
        $this->data['PageTitle'] = 'EMPLOYEE ATTENDANCE';
        $this->data['body'] = 'employee/employee_attendance.php';
		$this->data['data']['content'] = $this->model_employee->employee_attendance_record();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'employee_attendance';
		$this->load->view('main',$this->data);
	}
	public function employee_attendance_excel()
	{
	    $this->auth->cek2('employee_add'); 
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
                	$a = 0;
			      	if($numrow > 1){
						array_push($data_all, array( 
							'MachineID' => $row[$a++], 
							'BioID' => $row[$a++], 
							'AttendanceName' => $row[$a++], 
							'AttendanceTime' => date('Y-m-d H:i:s', strtotime($row[$a++]) ), 
							'InputDate' => date('Y-m-d H:i:s'),
							'InputBy' => $this->session->userdata('UserAccountID'),
				        ));
					} else {
						if (
							($row[$a++] == 'Location ID') and 
							($row[$a++] == 'No.') and 
							($row[$a++] == 'Name') and 
							($row[$a++] == 'clock')  
						) { } else {
							$newdata['error_info'] = "upload excel gagal, Format excel Attendance salah";
							$this->session->set_userdata($newdata);
       		 				redirect(base_url('employee/employee_attendance'));
						}
					}
			      	$numrow++;
				}
		        $this->model_employee->employee_attendance_excel($data_all);
		    }
		}
        redirect(base_url('employee/employee_attendance'));
	}
	public function employee_attendance_adjust()
	{
	    $this->auth->cek2('employee_add'); 
        $this->model_employee->employee_attendance_adjust(); 
        redirect(base_url('employee/employee_attendance'));
	}
	public function employee_attendance_personal($id)
	{
		// cek jika user punya hak akses melihat profil orang lain
		if ($id != $this->session->userdata('EmployeeID')) { 
	    	$this->auth->cek2('view_profile'); 
		}
        $this->data['PageTitle'] = 'EMPLOYEE PERSONAL ATTENDANCE';
        $this->data['body'] = 'employee/employee_attendance_personal.php';
		$this->data['data']['content'] = $this->model_employee->employee_attendance_personal($id);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'none';
		$this->load->view('main',$this->data);
	}

// ======================================================================
	public function fill_employee()
	{
		$this->model_employee->fill_employee();
	}
	public function fill_employee_active()
	{
		$this->model_employee->fill_employee_active();
	}
	public function fill_attendance_group()
	{
		$this->model_employee->fill_attendance_group();
	}
	public function fill_religion()
	{
		$this->model_employee->fill_religion();
	}
	public function fill_state()
	{
		$this->model_employee->fill_state();
	}
	public function fill_province()
	{
		$this->model_employee->fill_province();
	}
	public function fill_city()
	{
		$this->model_employee->fill_city();
	}
	public function fill_districts()
	{
		$this->model_employee->fill_districts();
	}
	public function fill_pos()
	{
		$this->model_employee->fill_pos();
	}
	public function fill_employment()
	{
		$this->model_employee->fill_employment();
	}
	public function fill_officelocation()
	{
		$this->model_employee->fill_officelocation();
	}
	public function fill_jobtitle()
	{
		$this->model_employee->fill_jobtitle();
	}


}
