<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {
	public function __construct()
    {
	    parent::__construct();
	    date_default_timezone_set('Asia/Jakarta');
	    // cek login
	    $this->load->library('Auth');
	    $this->auth->cek();
        // cek hak akses
	    $this->auth->cek2('menu_app_administration');
        // cek referrer
	    $this->auth->cek3(); 
	    // save log
	    $this->log_user->log_page();
	    // cek notif
	    $this->load->library('Notification'); 

        $this->load->model('model_administration');
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
        redirect(base_url(''));
	}

// site config ============================================================================
	public function site_config()
	{
        $this->data['PageTitle'] = 'SITE CONFIG';
        $this->data['body'] 	= 'administration/site_config.php';
        $this->data['content'] 	= $this->model_administration->site_config();
        $this->data['content2'] = $this->model_administration->approval_list();

        $this->load->model('model_employee');
        $this->data['content3'] = $this->model_employee->fill_employee_active();
        // FOR ADDING SEC 
        $this->data['content3'][] = array('EmployeeID' => 'SEC', 'EmployeeName' => 'SEC');

        $this->data['data']['help'] = 'SITE_CONFIGURATION_v.1';
        $this->data['data']['menu'] = 'site_configuration';
		$this->load->view('main',$this->data);
	}
	public function site_config_edit($val)
	{
	    $this->auth->cek4('post');
	    $this->model_administration->site_config_edit($val);
        redirect(base_url('administration/site_config'));
	}

// manage user ============================================================================
	public function user_account_list()
	{	
        $this->data['PageTitle'] = 'LIST USER';
        $this->data['body'] = 'administration/user_account_list.php';
        $this->data['content'] = $this->model_administration->user_account_list();
        $this->data['data']['help'] = 'USER_ACCOUNT_LIST_v.1';
        $this->data['data']['menu'] = 'user_account_list';
		$this->load->view('main',$this->data);
	}
	public function user_account_add()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->user_account_add();
        redirect(base_url('administration/user_account_list'));
	}
	public function user_account_edit()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->user_account_edit();
    	redirect(base_url('administration/user_account_list'));
	}
	public function ForceLogOut_set()
	{
        $this->model_administration->ForceLogOut_set();
	}
	public function ForceLogOut_setAll()
	{
        $this->model_administration->ForceLogOut_setAll();
	}

// manage group ===========================================================================
	public function group_list()
	{	
        $this->data['PageTitle'] = 'LIST GROUP';
        $this->data['body'] = 'administration/group_account_list.php';
        $this->data['content'] = $this->model_administration->group_list();
        $this->data['data']['help'] = 'GROUP_MENU_LIST_v.1';
        $this->data['data']['menu'] = 'manage_group';
		$this->load->view('main',$this->data);
	}
	public function group_add()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->group_add();
        redirect(base_url('administration/group_list'));
	}
	public function group_edit()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->group_edit();
        redirect(base_url('administration/group_list'));
	}

// manage personal menu ===================================================================
	public function user_menu()
	{	
        $this->data['PageTitle'] = 'LIST MENU USER';
        $this->data['body'] = 'administration/user_personal_menu.php';
        $this->data['content'] = $this->model_administration->user_menu();
        $this->data['content2'] = $this->model_administration->fill_user_personal_menu();

        $this->data['data']['help'] = 'PERSONAL_MENU_LIST_v.1';
        $this->data['data']['menu'] = 'manage_personal';
		$this->load->view('main',$this->data);
	}
	public function user_menu_add()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->user_menu_add();
        redirect(base_url('administration/user_menu'));
	}
	public function user_menu_edit()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->user_menu_edit();
        redirect(base_url('administration/user_menu'));
	}
	
// manage menu ============================================================================
	public function user_manage_menu()
	{	
        $this->data['PageTitle'] = 'LIST MENU';
        $this->data['body'] = 'administration/user_manage_menu.php';
        $this->data['content'] = $this->model_administration->user_manage_menu();
        $this->data['data']['help'] = 'MANAGE_MENU_v.1';
        $this->data['data']['menu'] = 'manage_menu';
		$this->load->view('main',$this->data);
	}
	public function menu_add()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->menu_add();
        redirect(base_url('administration/user_manage_menu'));
	}
	public function menu_edit()
	{	
	    $this->auth->cek4('post');
        $this->model_administration->menu_edit();
        redirect(base_url('administration/user_manage_menu'));
	}
	
// ========================================================================================

	public function fill_employee_user_personal_menu()
	{
		$this->model_administration->fill_employee_user_personal_menu();
	}
	public function fill_employee_user_account_list()
	{
		$this->model_administration->fill_employee_user_account_list();
	}
	public function fill_employee_user_account_list2()
	{
		$this->model_administration->fill_employee_user_account_list2();
	}
	public function fill_groupname()
	{
		$this->model_administration->fill_groupname();
	}
}
