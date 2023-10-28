<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hrd extends CI_Controller {
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
		
        $this->load->model('model_hrd');
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
	
// company============================================================
	public function company_list()
	{
	    $this->auth->cek2('company_list'); 
        $this->data['PageTitle'] = 'LIST COMPANY';
        $this->data['body'] = 'hrd/company_list.php';
		$this->data['data']['content'] = $this->model_hrd->company_list(); 
        $this->data['data']['help'] = 'COMPANY_LIST_v.1';
        $this->data['data']['menu'] = 'company_list';
		$this->load->view('main',$this->data);
	}
	public function company_add()
	{
	    $this->auth->cek2('company_cu'); 
        $this->model_hrd->company_add(); 
        redirect(base_url('hrd/company_list'));
	}
	public function company_edit()
	{
	    $this->auth->cek2('company_cu'); 
        $this->model_hrd->company_edit(); 
        redirect(base_url('hrd/company_list'));
	}

// divisi============================================================
	public function division_list()
	{
	    $this->auth->cek2('division_list'); 
        $this->data['PageTitle'] = 'LIST DIVISI';
        $this->data['body'] = 'hrd/division_list.php';
		$this->data['data']['content'] = $this->model_hrd->division_list(); 
        $this->data['data']['fill_company'] = $this->model_hrd->company_list(); 
        $this->data['data']['help'] = 'DEVISION_LIST_v.1';
        $this->data['data']['menu'] = 'division_list';
		$this->load->view('main',$this->data);
	}
	public function division_add()
	{
	    $this->auth->cek2('division_cu'); 
        $this->model_hrd->division_add(); 
        redirect(base_url('hrd/division_list'));
	}
	public function division_edit()
	{
	    $this->auth->cek2('division_cu'); 
        $this->model_hrd->division_edit(); 
        redirect(base_url('hrd/division_list'));
	}

// job============================================================
	public function job_list()
	{
	    $this->auth->cek2('job_list'); 
        $this->data['PageTitle'] = 'JOB LIST';
        $this->data['body'] = 'hrd/job_list.php';
        $this->data['data']['fill_company'] = $this->model_hrd->company_list(); 
        $this->data['data']['fill_employee'] = $this->model_hrd->fill_employee(); 
        $this->data['data']['content'] = $this->model_hrd->job_list();
        $this->data['data']['help'] = 'JOB_LEVEL_LIST_v.1';
        $this->data['data']['menu'] = 'job_list';
		$this->load->view('main',$this->data);
	}
	public function job_add()
	{
	    $this->auth->cek2('job_cu'); 
        $this->model_hrd->job_add(); 
        redirect(base_url('hrd/job_list'));
	}
	public function job_edit()
	{
	    $this->auth->cek2('job_cu'); 
        $this->model_hrd->job_edit(); 
        redirect(base_url('hrd/job_list'));
	}
	public function job_history()
	{
	    $this->auth->cek2('job_cu'); 
        $this->data['content'] = $this->model_hrd->job_history(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('hrd/job_history.php',$this->data);
	}

// office============================================================
	public function office_list()
	{
	    $this->auth->cek2('office_list'); 
        $this->data['PageTitle'] = 'OFFICE LIST';
        $this->data['body'] = 'hrd/office_list.php';
        $this->data['data']['content'] = $this->model_hrd->office_list(); 
        $this->data['data']['fill_company'] = $this->model_hrd->company_list();
        $this->data['data']['help'] = 'OFFICE_LOCATION_LIST_v.1';
        $this->data['data']['menu'] = 'office_list';
		$this->load->view('main',$this->data);
	}
	public function office_add()
	{
	    $this->auth->cek2('office_cu'); 
        $this->model_hrd->office_add(); 
        redirect(base_url('hrd/office_list'));
	}
	public function office_edit()
	{
	    $this->auth->cek2('office_cu'); 
        $this->model_hrd->office_edit(); 
        redirect(base_url('hrd/office_list'));
	}
	
// asset============================================================
	public function asset_list_detail() 
	{
	    $this->auth->cek2('asset_list'); 
        $this->data['content'] = $this->model_hrd->asset_list_detail(); 
        $this->data['data']['help'] = 'ASSET_LIST_v.1';
        $this->load->view('hrd/asset_list_detail.php',$this->data);
    }
	public function asset_list()
	{
	    $this->auth->cek2('asset_list'); 
        $this->data['PageTitle'] = 'LIST ASSET';
        $this->data['body'] = 'hrd/asset_list.php';
        $this->data['data']['content'] = $this->model_hrd->asset_list();
        $this->data['data']['help'] = 'ASSET_LIST_v.1';
        $this->data['data']['menu'] = 'asset_list';
		$this->load->view('main',$this->data);
	}
	public function asset_list_data()
	{
	    $this->auth->cek2('asset_list'); 
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
	        'table' => 'vw_asset_main',
	        'column_order' => array('AssetID','AssetName','DateLast','LevelName','fullname',null), 
	        'column_search' => array('AssetID','AssetName','DateLast','LevelName','fullname'),    
	        'order' => array('ContactID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = $field->AssetID;
			$row[] = $field->AssetName;
			$row[] = $field->DateLast;
			$row[] = $field->LevelName;
			$row[] = $field->fullname;
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
	public function asset_cu($val)
	{
	    $this->auth->cek2('asset_cu'); 
        $this->data['PageTitle'] = 'ADD EDIT ASSET';
        $this->data['body'] = 'hrd/asset_cu.php';
        $this->data['data']['content'] = $this->model_hrd->asset_cu($val); 
        $this->data['data']['help'] = 'ASSET_LIST_v.1';
        $this->data['data']['menu'] = 'asset_list';
		$this->load->view('main',$this->data);
	}
	public function asset_cu_act()
	{
	    $this->auth->cek2('asset_cu'); 
        $this->model_hrd->asset_cu_act(); 
        redirect(base_url('hrd/asset_list'));
	}
	public function asset_assignment($val)
	{
	    $this->auth->cek2('asset_assignment'); 
        $this->data['PageTitle'] = 'ASSET ASSIGNMENT';
        $this->data['body'] = 'hrd/asset_assignment.php';
        $this->data['data']['content'] = $this->model_hrd->asset_assignment($val); 
        $this->data['data']['help'] = 'ASSET_LIST_v.1';
        $this->data['data']['menu'] = 'asset_list';
		$this->load->view('main',$this->data);
	}
	public function asset_assignment_add()
	{
	    $this->auth->cek2('asset_assignment'); 
        $this->model_hrd->asset_assignment_add(); 
        redirect($_SERVER['HTTP_REFERER']);
	}
    public function asset_transfer_print()
	{
	    $this->auth->cek2('asset_assignment'); 
    	$this->data['content'] = $this->model_hrd->asset_transfer_print(); 
        $this->load->view('hrd/asset_transfer_print.php',$this->data);
	}
	public function asset_assignment_history()
	{
	    $this->auth->cek2('asset_assignment_history'); 
        $this->data['PageTitle'] = 'LIST ASSET ASSIGNMENT HISTORY';
        $this->data['body'] = 'hrd/asset_assignment_history.php';
        $this->data['data']['content'] = $this->model_hrd->asset_assignment_history();
        $this->data['data']['help'] = 'ASSET_ASSIGNMENT_LIST_HISTORY_v.1';
        $this->data['data']['menu'] = 'asset_assignment_history';
		$this->load->view('main',$this->data);
	}
	
// tasklist=======================================================================
	public function task_list()
	{
		$this->auth->cek2('job_list');
        $this->data['PageTitle'] = 'LIST TASK';
        $this->data['body'] = 'hrd/task_list.php';
		$this->data['data']['content'] = $this->model_hrd->task_list(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'manage_menu';
		$this->load->view('main',$this->data);
	}
	public function task_cu($val)
	{
        $this->data['PageTitle'] = 'ADD EDIT TASK';
        $this->data['body'] = 'hrd/task_cu.php';
		$this->data['data']['content'] = $this->model_hrd->task_cu($val); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'manage_menu';
		$this->load->view('main',$this->data);
	}
	public function task_cu_act()
	{
        $this->model_hrd->task_cu_act();
        redirect(base_url('hrd/task_list'));
	}
	public function task_list_detail() 
	{
        $this->data['content'] = $this->model_hrd->task_list_detail(); 
        $this->data['data']['help'] = 'Doc';
        $this->load->view('hrd/task_list_detail.php',$this->data);
    }
	public function task_list_comment($val)
	{
        $this->data['PageTitle'] = 'COMMENT TASK';
        $this->data['body'] = 'hrd/task_list_comment.php';
		$this->data['data']['content'] = $this->model_hrd->task_list_comment($val); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'manage_menu';
		$this->load->view('main',$this->data);
	}
	public function task_comment_act()
	{
		$val 	= $this->input->post('taskid');
        $this->model_hrd->task_comment_act();
        redirect(base_url('hrd/task_list_comment/'.$val));
	}
	public function task_done()
	{
		$val 	= $this->input->get('idt');
        $this->model_hrd->task_done();
        redirect(base_url('hrd/task_list_comment/'.$val));
	}
	public function task_on()
	{
		$val 	= $this->input->get('idt');
        $this->model_hrd->task_on();
        redirect(base_url('hrd/task_list_comment/'.$val));
	}

// =========================================================================
	public function search_company()
	{
		$this->model_hrd->search_company();       
    }
    public function get_company_code()
    {
		$this->model_hrd->get_company_code();       
    }
    public function fill_divisi()
    {
		$this->model_hrd->fill_divisi();       
    }
	public function fill_asset($val)
	{
		$this->model_hrd->fill_asset();       
    }
    public function get_divisi_code()
    {
		$this->model_hrd->get_divisi_code();       
    }
	public function fill_employee()
	{
        $this->load->model('model_employee');
		$this->model_employee->fill_employee();       
    }
	public function fill_employee_active()
	{
        $this->load->model('model_employee');
		$this->model_employee->fill_employee_active();       
    }
	public function fill_taskpriority()
	{
		$this->model_hrd->fill_taskpriority();
	}
	public function fill_taskstatus()
	{
		$this->model_hrd->fill_taskstatus();
	}
	public function fill_tasklevel()
	{
		$this->model_hrd->fill_tasklevel();
	}
	
}
