<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master2 extends CI_Controller {
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

        $this->load->model('model_master');
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
		redirect(base_url());
	}

	// price=======================================================================
	public function price_list()
	{
	    $this->auth->cek2('manage_price'); 
        $this->data['PageTitle'] = '-PRICELIST';
        $this->data['body'] = 'master/api/price_list.php';
		$this->data['data']['content'] = $this->model_master->price_list();
        $this->data['data']['help'] = 'Price List v.1';
        $this->data['data']['menu'] = 'price_list';
		$this->load->view('main',$this->data);
	}
	public function price_list_detail() 
	{
    	$this->auth->cek2('manage_price'); 
        $this->data['content'] = $this->model_master->price_list_detail(); 
		$this->data['content']['category'] = $this->model_master->get_full_category(); 
		$this->data['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->load->view('master/administration/price_list_detail.php',$this->data);
    }
	public function manage_api_product_cu($val)
	{	
	    $this->auth->cek2('manage_edit_price'); 
        $this->data['PageTitle'] = 'ADD/EDIT PRODUCT API';
        $this->data['body'] = 'master/api/manage_api_product_cu.php';
		$this->data['data']['content']['main'] = $this->model_master->price_list_cu($val); 
		$this->data['data']['content']['category'] = $this->model_master->get_full_category(); 
		$this->data['data']['content']['brand'] = $this->model_master->get_full_brand(); 
        $this->data['data']['help'] = 'Price List v.1';
        $this->data['data']['menu'] = 'price_list';
		$this->load->view('main',$this->data);
	}
	public function manage_api_product_cu_act()
	{
	    $this->auth->cek2('manage_edit_price');
        $this->model_master3->manage_api_product_cu_act();
        redirect(base_url('master/price_list'));
	}
	public function price_add()
	{
	    $this->auth->cek2('manage_edit_price'); 
        $this->model_master->price_add(); 
        redirect(base_url('master/price_list'));
	}
	public function price_edit()
	{
	    $this->auth->cek2('manage_edit_price'); 
        $this->model_master->price_edit(); 
        redirect(base_url('master/price_list'));
	}
	public function update_product_price_by_filter()
	{
	    $this->auth->cek2('manage_edit_price'); 
        $this->model_master->update_product_price_by_filter();
	}
	public function fill_category_api()
	{
		$this->model_master->fill_category_api();
	}
}
