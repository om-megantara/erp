<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketing extends CI_Controller {
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

        $this->load->model('model_mkt');
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

    // marketing_activity====================================================================
    public function marketing_activity()
    {   
        $this->auth->cek2('marketing_activity'); 
        $this->data['PageTitle'] = 'Marketing Activity';
        $this->data['body'] = 'marketing/marketing_activity.php';
        $this->data['data']['content'] = $this->model_mkt->marketing_activity();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_add()
    {   
        $this->auth->cek2('marketing_activity'); 
        if ($this->session->userdata('SalesID') != "0") {
            $this->data['PageTitle'] = 'Marketing Activity Add';
            $this->data['body'] = 'marketing/marketing_activity_add.php';
            
            $CustomerID = $this->input->get_post('CustomerID'); 
            if (isset($CustomerID)) {
                $this->data['data']['content'] = $this->model_mkt->marketing_activity_add(); 
            }
            $this->data['data']['help'] = 'Doc';
            $this->data['data']['menu'] = 'marketing_activity';
            $this->load->view('main',$this->data);
        } else {
            redirect(base_url('marketing/marketing_activity'));
        }
    }
    public function marketing_activity_add_act()
    {   
        $this->auth->cek2('marketing_activity'); 
        $this->model_mkt->marketing_activity_add_act(); 
        redirect(base_url('marketing/marketing_activity'));
    }
    public function marketing_activity_edit()
    {   
        $this->auth->cek2('marketing_activity'); 
        if ($this->session->userdata('SalesID') != "0") {
            $this->data['PageTitle'] = 'Marketing Activity Edit';
            $this->data['body'] = 'marketing/marketing_activity_edit.php';
            
            $ActivityID = $this->input->get_post('ActivityID'); 
            if (isset($ActivityID)) {
                $this->data['data']['content'] = $this->model_mkt->marketing_activity_edit(); 
            }
            $this->data['data']['help'] = 'Doc';
            $this->data['data']['menu'] = 'marketing_activity';
            $this->load->view('main',$this->data);
        } else {
            redirect(base_url('marketing/marketing_activity'));
        }
    }
    public function marketing_activity_edit_act()
    {   
        $this->auth->cek2('marketing_activity'); 
        $this->model_mkt->marketing_activity_edit_act(); 
        redirect(base_url('marketing/marketing_activity'));
    }
    public function marketing_activity_delete()
    {
        $this->auth->cek2('marketing_activity');
        $this->model_mkt->marketing_activity_delete();
        redirect(base_url('marketing/marketing_activity'));
    }
    public function marketing_activity_category()
    {
        $this->auth->cek2('marketing_activity_category');
        $this->data['PageTitle'] = 'Marketing Activity Category';
        $this->data['body'] = 'marketing/marketing_activity_category.php';
        $this->data['data']['content'] = $this->model_mkt->marketing_activity_category(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_category';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_category_add()
    {
        $this->auth->cek2('marketing_activity_category');
        $this->data['PageTitle'] = 'Add Category Fee Marketing Activity';
        $this->data['body'] = 'marketing/marketing_activity_category_add.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_category';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_category_add_act()
    {
        $this->auth->cek2('marketing_activity_category');
        $this->model_mkt->marketing_activity_category_add_act();
        redirect(base_url('marketing/marketing_activity_category'));
    }
    public function marketing_activity_category_edit()
    {
        $this->auth->cek2('marketing_activity_category');
        $this->data['PageTitle'] ='Edit Category Fee Marketing Activity';
        $this->data['body'] = 'marketing/marketing_activity_category_edit.php';
        $this->data['data']['content' ]= $this->model_mkt->marketing_activity_category_edit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_category';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_category_edit_act()
    {
        $this->auth->cek2('marketing_activity_category');
        $this->model_mkt->marketing_activity_category_edit_act();
        redirect(base_url('marketing/marketing_activity_category'));
    }
    public function marketing_activity_category_delete()
    {   
        $this->auth->cek2('marketing_activity_category'); 
        $this->model_mkt->marketing_activity_category_delete(); 
        redirect(base_url('marketing/marketing_activity_category'));
    }
    public function marketing_activity_bonus()
    {   
        $this->auth->cek2('marketing_activity_bonus'); 
        $this->data['PageTitle'] = 'Marketing Activity Bonus';
        $this->data['body'] = 'marketing/marketing_activity_bonus.php';
        $this->data['data']['content'] = $this->model_mkt->marketing_activity_bonus(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_bonus';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_bonus_add()
    {   
        $this->auth->cek2('marketing_activity_bonus'); 
        $this->data['PageTitle'] = 'Add Bonus Fee Marketing Activity';
        $this->data['body'] = 'marketing/marketing_activity_bonus_add.php';
        $this->data['data']['content'] = $this->model_mkt->marketing_activity_bonus_add();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_bonus';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_bonus_add_act()
    {   
        $this->auth->cek2('marketing_activity_bonus'); 
        $this->model_mkt->marketing_activity_bonus_add_act(); 
        redirect(base_url('marketing/marketing_activity_bonus'));
    }
    public function marketing_activity_bonus_edit()
    {   
        $this->auth->cek2('marketing_activity_bonus'); 
        $this->data['PageTitle'] ='Edit Bonus Fee Marketing Activity';
        $this->data['body'] = 'marketing/marketing_activity_bonus_edit.php';
        $this->data['data']['content' ]= $this->model_mkt->marketing_activity_bonus_edit() ;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_bonus';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_bonus_edit_act()
    {   
        $this->auth->cek2('marketing_activity_bonus'); 
        $this->model_mkt->marketing_activity_bonus_edit_act(); 
        redirect(base_url('marketing/marketing_activity_bonus'));
    }
    public function marketing_activity_bonus_delete()
    {   
        $this->auth->cek2('marketing_activity_bonus'); 
        $this->model_mkt->marketing_activity_bonus_delete(); 
        redirect(base_url('marketing/marketing_activity_bonus'));
    }
    public function marketing_activity_category_fee()
    {   
        $this->auth->cek2('marketing_activity_category_fee'); 
        $this->data['PageTitle'] = 'Marketing Activity Employee';
        $this->data['body'] = 'marketing/marketing_activity_category_fee.php';
        $this->data['data']['content'] = $this->model_mkt->marketing_activity_category_fee(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_category_fee';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_category_fee_add()
    {   
        $this->auth->cek2('marketing_activity_category_fee'); 
        $this->data['PageTitle'] = 'Add Fee Category';
        $this->data['body'] = 'marketing/marketing_activity_category_fee.php';
        $this->data['data']['content'] = $this->model_mkt->marketing_activity_category_fee();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_category_fee';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_employee_add_act()
    {   
        $this->auth->cek2('marketing_activity_employee'); 
        $this->model_mkt->marketing_activity_bonus_add_act(); 
        redirect(base_url('marketing/marketing_activity_employee'));
    }
    public function marketing_activity_employee_edit()
    {   
        $this->auth->cek2('marketing_activity_employee'); 
        $this->data['PageTitle'] ='Edit Bonus Fee Marketing Activity';
        $this->data['body'] = 'marketing/marketing_activity_bonus_edit.php';
        $this->data['data']['content' ]= $this->model_mkt->marketing_activity_bonus_edit() ;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'marketing_activity_employee';
        $this->load->view('main',$this->data);
    }
    public function marketing_activity_employee_edit_act()
    {   
        $this->auth->cek2('marketing_activity_employee'); 
        $this->model_mkt->marketing_activity_bonus_edit_act(); 
        redirect(base_url('marketing/marketing_activity_employee'));
    }
    public function marketing_activity_employee_delete()
    {   
        $this->auth->cek2('marketing_activity_employee'); 
        $this->model_mkt->marketing_activity_bonus_delete(); 
        redirect(base_url('marketing/marketing_activity_employee'));
    }
    public function daily_report_add_coment()
    {   
        $this->auth->cek2('daily_report'); 
        $this->model_mkt->daily_report_add_coment(); 
    }
    public function daily_report_detail()
    {
        $this->auth->cek2('daily_report');
        $this->data['PageTitle'] = 'Daily Report';
        $this->data['body'] = 'marketing/daily_report_detail.php';
        $this->data['data']['content'] = $this->model_mkt->daily_report_detail(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'daily_report';
        $this->load->view('main',$this->data);
    }
 
    // manage city ========================================================================
    public function manage_city()
    {
        $this->auth->cek2('manage_city');
        $this->data['PageTitle'] = 'MANAGE CITY';
        $this->data['body'] = 'marketing/manage_city.php';
        $this->data['data']['content' ]= $this->model_mkt->manage_city();
        $this->data['data']['help'] = 'doc';
        $this->data['data']['menu'] = 'manage_city';
        $this->load->view('main',$this->data);
    }
    public function manage_city_cu()
    {
        $this->auth->cek2('manage_city');
        $this->data['PageTitle'] = 'EDIT CITY';
        $this->data['body'] = 'marketing/manage_city_cu.php';
        $this->data['data']['city_detail'] = $this->model_mkt->city_detail(); 
        $this->load->model('model_master');
        $this->load->model('model_master2');
        $this->data['data']['region' ]= $this->model_master2->region_list(); 
        $this->data['data']['sales' ]= $this->model_master->sales_list2();
        $this->data['data']['help'] = 'City List v.1';
        $this->data['data']['menu'] = 'city_list';
        $this->load->view('main',$this->data);
    }
    public function manage_city_cu_act()
    {
        $this->auth->cek2('manage_city');
        $this->model_mkt->manage_city_cu_act();
        redirect(base_url('marketing/manage_city'));
    }
    public function city_list_popup()
    {
        $this->auth->cek2('manage_city');
        $this->data['content'] = $this->model_master2->city_list();
        $this->load->view('master/administration/city_list_popup.php',$this->data);
    }
   
    // Order Online ========================================================================
    public function online_order()
    {
        $this->auth->cek2('online_order');
        $this->data['PageTitle'] = 'ONLINE ORDER';
        $this->data['body'] = 'marketing/online_order.php';
        $this->data['data']['content'] = $this->model_mkt->online_order(); 
        // echo json_encode($this->data['data']['content']); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'online_order';
        $this->load->view('main',$this->data);
    }
    public function online_order_add()
    {
        $this->auth->cek2('online_order');
        $this->data['PageTitle'] = 'Online Order Add';
        $this->data['body'] = 'marketing/online_order_add.php';
        
        $this->data['data']['content'] = $this->model_mkt->online_order_add(); 
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'online_order';
        $this->load->view('main',$this->data);
    }
    public function online_order_add_act()
    {
        $this->auth->cek2('online_order');
        $this->model_mkt->online_order_add_act();
        redirect(base_url('marketing/online_order'));
    }
    public function online_order_edit()
    {
        $this->auth->cek2('online_order');
        $this->data['PageTitle'] = 'Online Order Edit';
        $this->data['body'] = 'marketing/online_order_edit.php';
        $this->data['data']['content'] = $this->model_mkt->online_order_edit();
        // echo json_encode($this->data['data']['content']);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'online_order';
        $this->load->view('main',$this->data);
    }
    public function online_order_edit_act()
    {
        $this->auth->cek2('online_order');
        $this->model_mkt->online_order_edit_act();
        redirect(base_url('marketing/online_order'));
    }
    public function online_order_approve()
    {
        $this->auth->cek2('online_order_approve');
        $this->model_mkt->online_order_approve_act();
        redirect(base_url('marketing/online_order'));
    }
    public function online_order_delete()
    {
        $this->auth->cek2('online_order');
        $this->model_mkt->online_order_delete_act();
        redirect(base_url('marketing/online_order'));
    }
    // ==============================================================================
}
