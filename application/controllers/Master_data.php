<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_data extends CI_Controller {
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

        $this->load->model('model_master_data');
	    $this->data = array(
	        'menu' => 'menu.php',
	        'UserID' => $this->session->userdata('UserID'),
	        'UserFullName' => $this->session->userdata('UserFullName'),
	        'UserMenu' => $this->session->userdata('UserMenu'),
	        'data' => array()
	    );
	}
 
// product --------------------------------------------------------
	public function product_list()
	{
        $this->data['PageTitle'] = 'Product List';
        $this->data['body'] = 'master_data/product_list.php';
        $this->data['menu_side'] = 'product_list';
        $this->data['data']['content'] = $this->model_master_data->product_list(); 
		$this->load->view('main',$this->data);
	}
	public function product_cu()
	{
	    $this->auth->cek2('product_cu');
	    if ($this->input->post('ProductID') == '') {
        	$this->model_master_data->product_add(); 
	    } else {
        	$this->model_master_data->product_edit(); 
	    }
        redirect(base_url('master_data/product_list'));
	}
	public function get_product_detail()
	{
    	$this->model_master_data->get_product_detail(); 
	}
	public function search_treatment()
	{
		$this->model_master_data->search_treatment();
	}

// customer --------------------------------------------------------
	public function customer_list()
	{
        $this->data['PageTitle'] = 'Customer List';
        $this->data['body'] = 'master_data/customer_list.php';
        $this->data['menu_side'] = 'customer_list';
        $this->data['data']['content'] = $this->model_master_data->customer_list(); 
		$this->load->view('main',$this->data);
	}
	public function customer_cu()
	{
	    $this->auth->cek2('customer_cu');
	    if ($this->input->post('CustomerID') == '') {
        	$this->model_master_data->customer_add(); 
	    } else {
        	$this->model_master_data->customer_edit(); 
	    }
        redirect(base_url('master_data/customer_list'));
	}
	public function get_customer_detail()
	{
    	$this->model_master_data->get_customer_detail(); 
	}
	public function search_customer()
	{
		$this->model_master_data->search_customer();
	}

// treatment --------------------------------------------------------
	public function treatment_list()
	{
        $this->data['PageTitle'] = 'Treatment List';
        $this->data['body'] = 'master_data/treatment_list.php';
        $this->data['menu_side'] = 'treatment_list';
        $this->data['data']['content'] = $this->model_master_data->treatment_list(); 
		$this->load->view('main',$this->data);
	}
	public function treatment_cu()
	{
	    $this->auth->cek2('treatment_cu');
	    if ($this->input->post('TreatmentID') == '') {
        	$this->model_master_data->treatment_add(); 
	    } else {
        	$this->model_master_data->treatment_edit(); 
	    }
        redirect(base_url('master_data/treatment_list'));
	}
	public function get_treatment_detail()
	{
    	$this->model_master_data->get_treatment_detail(); 
	}

}
