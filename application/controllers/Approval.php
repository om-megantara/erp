<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {
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

		$this->load->model('model_approval');
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

// upgrade_customer==================================================
	public function upgrade_customer()
	{
		$this->auth->cek2('upgrade_customer');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/upgrade_customer.php';
		$this->data['data']['content'] = $this->model_approval->upgrade_customer_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'upgrade_customer';
		$this->load->view('main',$this->data);
	}
	public function upgrade_customer_act($val)
	{
		$this->auth->cek2('upgrade_customer');
		$this->model_approval->upgrade_customer_act($val);
	}

// approve_so========================================================
	public function approve_so()
	{
		$this->auth->cek2('approve_so');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_so.php';
		$this->data['data']['content'] = $this->model_approval->approve_so_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_so';
		$this->load->view('main',$this->data);
	}
	public function approve_so_detail()
	{
		$this->auth->cek2('approve_so');
		$this->data['content'] = $this->model_approval->sales_order_detail();
		$this->load->view('approval/approve_so_detail.php',$this->data);
	}
	public function approve_so_act($val)
	{
		$this->auth->cek2('approve_so');
		$this->model_approval->approve_so_act($val);
	}

// stock adjutment===================================================
	public function approve_stock_adjustment()
	{
		$this->auth->cek2('approve_stock_adjustment');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_stock_adjustment.php';
		$this->data['data']['content'] = $this->model_approval->approve_stock_adjustment();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_stock_adjustment';
		$this->load->view('main',$this->data);
	}
	public function approve_stock_adjustment_detail()
	{
		$this->auth->cek2('approve_stock_adjustment');
		$this->data['content'] = $this->model_approval->approve_stock_adjustment_detail();
		$this->load->view('approval/approve_stock_adjustment_detail.php',$this->data);
	}
	public function approve_stock_adjustment_act()
	{
		$this->auth->cek2('approve_stock_adjustment');
		$this->model_approval->approve_stock_adjustment_act();
		redirect(base_url('approval/approve_stock_adjustment'));
	}

// mutation product==================================================
	public function approve_mutation_product()
	{
		$this->auth->cek2('approve_mutation_product');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_mutation_product.php';
		$this->data['data']['content'] = $this->model_approval->approve_mutation_product();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_mutation_product';
		$this->load->view('main',$this->data);
	}
	public function approve_mutation_product_detail()
	{
		$this->auth->cek2('approve_mutation_product');
		$this->data['content'] = $this->model_approval->mutation_detail();
		$this->load->view('approval/approve_mutation_product_detail.php',$this->data);
	}
	public function approve_mutation_product_act($val)
	{
		$this->auth->cek2('approve_mutation_product');
		$this->model_approval->approve_mutation_product_act($val);
	}

// approve_dor_inv==================================================
	public function approve_dor_invr()
	{
		$this->auth->cek2('approve_dor_invr');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_dor_invr.php';
		$this->data['data']['content'] = $this->model_approval->approve_dor_invr();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_dor_invr';
		$this->load->view('main',$this->data);
	}
	public function approve_dor_invr_detail()
	{
		$this->auth->cek2('approve_dor_invr');
		$this->data['content'] = $this->model_approval->dor_invr_detail();
		$this->load->view('approval/approve_dor_invr_detail.php',$this->data);
	}
	public function approve_dor_invr_act($val)
	{
		$this->auth->cek2('approve_dor_invr');
		$this->model_approval->approve_dor_invr_act($val);
	}

// price list========================================================
	public function approve_price_list()
	{
		$this->auth->cek2('approve_price_list');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_price_list.php';
		$this->data['data']['content'] = $this->model_approval->approve_price_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_price_list';
		$this->load->view('main',$this->data);
	}
	public function approve_price_list_detail()
	{
		$this->auth->cek2('approve_price_list');
		$this->data['content'] = $this->model_approval->price_list_detail();
		$this->load->model('model_master');
		$this->data['content']['category'] = $this->model_master->get_full_category();
		$this->data['content']['brand'] = $this->model_master->get_full_brand();
		$this->load->view('approval/approve_price_list_detail.php',$this->data);
	}
	public function approve_price_list_act()
	{
		$this->auth->cek2('approve_price_list');
		$this->model_approval->approve_price_list_act();
		redirect(base_url('approval/approve_price_list'));
	}

// price recommendation==============================================
	public function approve_price_recommendation()
	{
		$this->auth->cek2('approve_price_recommendation');
		$this->data['PageTitle'] = 'LIST APPROVAL ';
		$this->data['body'] = 'approval/approve_price_recommendation.php';
		$this->data['data']['content'] = $this->model_approval->approve_price_recommendation();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_price_recommendation';
		// echo json_encode($this->model_approval->approve_price_recommendation());
		$this->load->view('main',$this->data);
	}
	public function approve_price_recommendation_act($val)
	{
		$this->auth->cek2('approve_price_recommendation');
		$this->model_approval->approve_price_recommendation_act($val);
		// redirect(base_url('approval/approve_price_recommendation2'));
	}

// promo volume======================================================
	public function approve_promo_volume()
	{
		$this->auth->cek2('approve_promo_volume');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_promo_volume.php';
		$this->data['data']['content'] = $this->model_approval->approve_promo_volume();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_promo_volume';
		$this->load->view('main',$this->data);
	}
	public function approve_promo_volume_detail()
	{
		$this->auth->cek2('approve_promo_volume');
		$this->data['content'] = $this->model_approval->promo_volume_detail();
		$this->load->model('model_master');
		$this->data['content']['category'] = $this->model_master->get_full_category();
		$this->data['content']['brand'] = $this->model_master->get_full_brand();
		$this->load->view('approval/approve_promo_volume_detail.php',$this->data);
	}
	public function approve_promo_volume_act()
	{
		$this->auth->cek2('approve_promo_volume');
		$this->model_approval->approve_promo_volume_act();
		redirect(base_url('approval/approve_promo_volume'));
	}

// po========================================================
	public function approve_po()
	{
		$this->auth->cek2('approve_po');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_po.php';
		$this->data['data']['content'] = $this->model_approval->approve_po();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_po';
		$this->load->view('main',$this->data);
	}
	public function approve_po_detail()
	{
		$this->auth->cek2('approve_po');
		$this->data['content'] = $this->model_approval->po_detail();
		$this->load->view('approval/approve_po_detail.php',$this->data);
	}
	public function approve_po_act($val)
	{
		$this->auth->cek2('approve_po');
		$this->model_approval->approve_po_act($val);
		redirect(base_url('approval/approve_po'));
	}

// po expired========================================================
	public function approve_po_expired()
	{
		$this->auth->cek2('approve_po_expired');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_po_expired.php';
		$this->data['data']['content'] = $this->model_approval->approve_po_expired();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_po_expired';
		$this->load->view('main',$this->data);
	} 
	public function approve_po_expired_act($val)
	{
		$this->auth->cek2('approve_po_expired');
		$this->model_approval->approve_po_expired_act($val);
		redirect(base_url('approval/approve_po_expired'));
	}

// marketing_activity=================================================
	public function approve_marketing_activity()
	{
		$this->auth->cek2('approve_marketing_activity');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_marketing_activity.php';
		$this->data['data']['content'] = $this->model_approval->approve_marketing_activity_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_marketing_activity';
		// echo json_encode($this->model_approval->approve_marketing_activity_list());
		$this->load->view('main',$this->data);
	}
	public function approve_marketing_activity_act($val)
	{
		$this->auth->cek2('approve_marketing_activity');
		$this->model_approval->approve_marketing_activity_act($val);
	}

// cancel_marketing_activity==========================================
	public function cancel_marketing_activity()
	{
		$this->auth->cek2('cancel_marketing_activity');
		$this->data['PageTitle'] = 'LIST CANCEL';
		$this->data['body'] = 'approval/cancel_marketing_activity.php';
		$this->data['data']['content'] = $this->model_approval->cancel_marketing_activity_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'cancel_marketing_activity';
		$this->load->view('main',$this->data);
	}
	public function cancel_marketing_activity_act()
	{
		$this->auth->cek2('cancel_marketing_activity');
		$this->model_approval->cancel_marketing_activity_act();
	}

// so_complaint=======================================================
	public function approve_so_complaint()
	{
		$this->auth->cek2('approve_so_complaint');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_so_complaint.php';
		$this->data['data']['content'] = $this->model_approval->approve_so_complaint_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_so_complaint';
		$this->load->view('main',$this->data);
	}
	public function approve_so_complaint_act($val)
	{
		$this->auth->cek2('approve_so_complaint');
		$this->model_approval->approve_so_complaint_act($val);
	}

	public function update_price_list()
	{
		$this->auth->cek2('update_price_list');
		$this->data['PageTitle'] = 'PRICE LIST UPDATED';
		$this->data['body'] = 'approval/update_price_list.php';
		$this->data['data']['content'] = $this->model_approval->update_price_list();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_price_list';
		$this->load->view('main',$this->data);
	}
	public function update_price_list_act($val)
	{
		$this->auth->cek2('update_price_list');
		$this->model_approval->update_price_list_act($val);
	}
	public function update_stock()
	{
		$this->auth->cek2('update_stock');
		$this->data['PageTitle'] = 'PRODUCT STOCK UPDATED';
		$this->data['body'] = 'approval/update_stock.php';
		$this->data['data']['content'] = $this->model_approval->update_stock();
		// echo json_encode($this->data['data']['content']);
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_stock';
		$this->load->view('main',$this->data);
	}
	public function update_stock_act($val)
	{
		$this->auth->cek2('update_stock');
		$this->model_approval->update_stock_act($val);
	}
	public function update_mp()
	{
		$this->auth->cek2('update_mp');
		$this->data['PageTitle'] = 'PRICE LIST UPDATED';
		$this->data['body'] = 'approval/update_mp.php';
		$this->data['data']['content'] = $this->model_approval->update_mp();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'update_mp';
		$this->load->view('main',$this->data);
	}
	public function update_mp_act($val)
	{
		$this->auth->cek2('update_mp');
		$this->model_approval->update_mp_act($val);
	}
// employee_overtime=======================================================
	public function approve_employee_overtime()
	{
		$this->auth->cek2('approve_employee_overtime');
		$this->data['PageTitle'] = 'LIST APPROVAL';
		$this->data['body'] = 'approval/approve_employee_overtime.php';
		$this->data['data']['content'] = $this->model_approval->approve_employee_overtime();
		// echo json_encode($this->model_approval->approve_employee_overtime());
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'approve_employee_overtime';
		$this->load->view('main',$this->data);
	}
	public function approve_employee_overtime_act($val)
	{
		$this->auth->cek2('approve_employee_overtime');
		$this->model_approval->approve_employee_overtime_act($val);
	}
}
