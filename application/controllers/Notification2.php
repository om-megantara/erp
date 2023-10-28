<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification2 extends CI_Controller {
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

		$this->load->model('model_notification');
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
	public function update_price_list()
	{
		$this->auth->cek2('update_price_list');
		$this->data['PageTitle'] = 'PRICE LIST UPDATED';
		$this->data['body'] = 'notification/update_price_list.php';
		$this->data['data']['content'] = $this->model_notification->update_price_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_price_list';
		$this->load->view('main',$this->data);
	}
	public function update_price_list_act($val)
	{
		$this->auth->cek2('update_price_list');
		$this->model_notification->update_price_list_act($val);
	}
	public function notif_price()
	{
		$this->auth->cek2('notif_price');
		$this->data['PageTitle'] = 'NOTIFICATION PRICE';
		$this->data['body'] = 'notification/notif_price.php';
		$this->data['data']['content'] = $this->model_notification->notif_price();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'notif_price';
		$this->load->view('main',$this->data);
	}
	public function notif_price_act($val)
	{
		$this->auth->cek2('notif_price');
		$this->model_notification->notif_price_act($val);
	}
	public function notif_minmax()
	{
		$this->auth->cek2('notif_minmax');
		$this->data['PageTitle'] = 'NOTIFICATION ROS MIN MAX';
		$this->data['body'] = 'notification/notif_minmax.php';
		$this->data['data']['content'] = $this->model_notification->notif_minmax();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'notif_minmax';
		$this->load->view('main',$this->data);
	}
	public function notif_minmax_act($val)
	{
		$this->auth->cek2('notif_minmax');
		$this->model_notification->notif_minmax_act($val);
	}
	public function notif_sop()
	{
		$this->auth->cek2('notif_sop');
		$this->data['PageTitle'] = 'NOTIFICATION SOP';
		$this->data['body'] = 'notification/notif_sop.php';
		$this->data['data']['content'] = $this->model_notification->notif_sop();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'notif_sop';
		$this->load->view('main',$this->data);
	}
	public function notif_sop_act($val)
	{
		$this->auth->cek2('notif_sop');
		$this->model_notification->notif_sop_act($val);
	}
	public function update_stock()
	{
		$this->auth->cek2('update_stock');
		$this->data['PageTitle'] = 'PRODUCT STOCK UPDATED';
		$this->data['body'] = 'notification/update_stock.php';
		$this->data['data']['content'] = $this->model_notification->update_stock();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_stock';
		$this->load->view('main',$this->data);
	}
	public function update_stock_act($val)
	{
		$this->auth->cek2('update_stock');
		$this->model_notification->update_stock_act($val);
	}
	public function update_mp()
	{
		$this->auth->cek2('update_mp');
		$this->data['PageTitle'] = 'PRICE LIST UPDATED';
		$this->data['body'] = 'notification/update_mp.php';
		$this->data['data']['content'] = $this->model_notification->update_mp();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_mp';
		$this->load->view('main',$this->data);
	}
	public function update_mp_act($val)
	{
		$this->auth->cek2('update_mp');
		$this->model_notification->update_mp_act($val);
	}
	public function update_ready_for_sale()
	{
		$this->auth->cek2('update_ready_for_sale');
		$this->data['PageTitle'] = 'PRODUCT READY FOR SALE';
		$this->data['body'] = 'notification/update_ready_for_sale.php';
		$this->data['data']['content'] = $this->model_notification->update_ready_for_sale();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_ready_for_sale';
		$this->load->view('main',$this->data);
	}
	public function update_ready_for_sale_act($val)
	{
		$this->auth->cek2('update_ready_for_sale');
		$this->model_notification->update_ready_for_sale_act($val);
	}
}
