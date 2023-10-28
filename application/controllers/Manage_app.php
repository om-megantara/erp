<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_app extends CI_Controller {
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

        $this->load->model('model_manage_app');
	    $this->data = array(
	        'menu' => 'menu.php',
	        'UserID' => $this->session->userdata('UserID'),
	        'UserFullName' => $this->session->userdata('UserFullName'),
	        'UserMenu' => $this->session->userdata('UserMenu'),
	        'data' => array()
	    );
	}
 
 // --------------------------------------------------------------------------------
	public function account_user()
	{
	    $this->auth->cek2('account_user');
        $this->data['menu_side'] = 'account_user';
        $this->data['PageTitle'] = 'Data Account User';
        $this->data['body'] = 'manage_app/account_user.php';
        $this->data['data']['menu_list'] = $this->model_manage_app->menu_list(); 
        $this->data['data']['content'] = $this->model_manage_app->account_user(); 
		$this->load->view('main',$this->data);
	}
	public function account_user_add_act()
	{
	    $this->auth->cek2('account_user');
        $this->model_manage_app->account_user_add_act(); 
        redirect(base_url('manage_app/account_user'));
	}
	public function account_user_edit_act()
	{
	    $this->auth->cek2('account_user');
        $this->model_manage_app->account_user_edit_act(); 
        redirect(base_url('manage_app/account_user'));
	}
	public function get_account_user_detail()
	{
	    $this->auth->cek2('account_user');
        $this->model_manage_app->get_account_user_detail(); 
	}


 
}
