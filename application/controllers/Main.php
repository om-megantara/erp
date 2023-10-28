<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
date_default_timezone_set('Asia/Jakarta');

class Main extends CI_Controller {
	public function __construct()
    {
	    parent::__construct();
	    date_default_timezone_set('Asia/Jakarta');
	    // cek login
	    $this->load->library('Auth'); 
	    $this->auth->cek();
	    // save log
	    $this->log_user->log_page();
	    // cek notif
	    $this->load->library('Notification'); 

        $this->load->model('model_main');
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

        // -----------------------
	}

	public function index()
	{

        $this->data['PageTitle'] = 'DASHBOARD';
        $this->data['body'] = 'home.php';
        $this->data['data']['help'] = 'Dashboard v.1';
        $this->data['data']['content']['birthday'] = $this->model_main->birthday(); 
        
        // if ($this->auth->cek5('summary')) {
	       //  $this->data['data']['content']['summary'] = $this->model_main->cek_report_summary(); 
        // }

        // $this->data['data']['content']['tes'] = $this->model_main->tes(); 
        $this->data['data']['menu'] = 'menu_dashboard';
		$this->load->view('main',$this->data);
	}  
	public function home_dashboard()
	{
        // if ($this->auth->cek5('summary')) {
		   //  $this->auth->cek2('summary'); 
	    //     $this->data['content']['summary'] = $this->model_main->cek_report_summary(); 
	    //     $this->load->view('home_dashboard.php',$this->data);
	    // }
		$data = $this->input->get('data'); 
	    if ($data == "summary_so_outstanding_do") {
	        $this->model_main->summary_so_outstanding_do();
	    }
	    if ($data == "summary_so_warehouse") {
	        $this->model_main->summary_so_warehouse();
	    }
	    if ($data == "summary_do_not_inv") {
	        $this->model_main->summary_do_not_inv();
	    }
	    if ($data == "summary_inv_unpaid") {
	        $this->model_main->summary_inv_unpaid();
	    }
	    if ($data == "summary_ro_outstanding") {
	        $this->model_main->summary_ro_outstanding();
	    }
	    if ($data == "summary_po_outstanding") {
	        $this->model_main->summary_po_outstanding();
	    }
	    if ($data == "summary_ro_suggestion") {
	        $this->model_main->summary_ro_suggestion();
	    }
	} 
	public function cek_any1()
	{
		// $arrContextOptions=array(
		//     "ssl"=>array(
		//         "verify_peer"=>false,
		//         "verify_peer_name"=>false,
		//     ),
		// );  
		// $response = file_get_contents("https://acz.anghauz.net/api_gateway/get_product_list", false, stream_context_create($arrContextOptions));
		// echo $response;
		echo json_encode($this->session->userdata('MenuList'));
	}
	public function cek_any2($data = array())
	{
		$data 	= (empty($data)) ? $this->input->post('data') : $data ;
		echo json_encode($data);
		// $post['url'] 	= $data['url'];
		// $post['type'] 	= $data['type'];
		// $post['value'] 	= $data['value'];
		// $this->load->view('redirect_ajax_post.php', $post);
	}
	public function change_password()
	{
		$this->model_main->change_password();
	}
	public function stillAlive()
	{
		$this->model_main->stillAlive();
	}
	public function checkAlive()
	{
		$this->model_main->checkAlive();
	}
	public function userlive()
	{
		$this->model_main->userlive();
	}
}
