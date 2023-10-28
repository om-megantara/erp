<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
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

        $this->load->model('model_report');
        $this->load->model('model_master');
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

// report_bonus_invoice=============================================================
	public function report_bonus_invoice()
	{
		$this->auth->cek2('report_pv_inv');
        $this->data['PageTitle'] = 'REPORT BONUS BY INVOICE';
        $this->data['body'] = 'report/report_bonus_invoice.php';
        $this->data['data']['content'] = $this->model_report->pv_by_inv();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_pv_inv';
		$this->load->view('main',$this->data);
	}
	public function report_bonus_sales()
	{
		$this->auth->cek2('report_pv_sales');
        $this->data['PageTitle'] = 'REPORT BONUS BY SALES';
        $this->data['body'] = 'report/report_bonus_sales.php';
        $this->data['data']['content'] = $this->model_report->pv_by_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_pv_sales';
		$this->load->view('main',$this->data);
	}
	public function pv_inv_detail()
	{
	    $this->auth->cek2('report_pv_inv');
		$this->data['content'] = $this->model_report->pv_inv_detail();
        $this->load->view('report/pv_inv_detail.php',$this->data);
	}
	public function report_pv_sales_print()
	{
	    $this->auth->cek2('report_pv_sales');
		$this->data['content'] = $this->model_report->report_pv_sales_print();
        $this->load->view('report/report_pv_sales_print.php',$this->data);
	}
	public function report_bonus_invoice_percentage()
	{
		$this->auth->cek2('report_pv_inv');
        $this->data['PageTitle'] = 'REPORT BONUS BY INVOICE PERCENTAGE';
        $this->data['body'] = 'report/report_bonus_invoice_percentage.php';
        $this->data['data']['content'] = $this->model_report->pv_by_inv_percentage();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_pv_inv_percentage';
		$this->load->view('main',$this->data);
	}
	public function report_bonus_sales_percentage()
	{
		$this->auth->cek2('report_pv_sales');
        $this->data['PageTitle'] = 'REPORT BONUS BY SALES PERCENTAGE';
        $this->data['body'] = 'report/report_bonus_sales_percentage.php';
        $this->data['data']['content'] = $this->model_report->pv_by_sales_percentage();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_pv_sales_percentage';
		$this->load->view('main',$this->data);
	}

// report_stock_flow_daily==========================================================
	public function report_stock_flow_daily()
	{
		$this->auth->cek2('report_stock_flow_daily');
        $this->data['PageTitle'] = 'REPORT STOCK FLOW DAILY';
        $this->data['body'] = 'report/report_stock_flow_daily.php';
        $this->data['data']['content'] = $this->model_report->report_stock_flow_daily();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_stock_flow_daily';
		$this->load->view('main',$this->data);
	}

// report_inv=======================================================================
	public function report_inv_customer()
	{
		$this->auth->cek2('report_inv_customer');
        $this->data['PageTitle'] = 'REPORT INVOICE PER CUSTOMER';
        $this->data['body'] = 'report/report_inv_customer.php';
        $this->data['data']['content'] = $this->model_report->report_inv_customer();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_customer';
		$this->load->view('main',$this->data);
	}
	public function report_inv_customer_detail()
	{
	    $this->auth->cek2('report_inv_customer');
		$this->data['content'] = $this->model_report->report_inv_customer_detail();
        $this->load->view('report/report_inv_customer_detail.php',$this->data);
	}
	public function report_inv_customer_detail_month()
	{
	    $this->auth->cek2('report_inv_customer');
		$this->data['content'] = $this->model_report->report_inv_customer_detail_month();
        $this->load->view('report/report_inv_customer_detail_month.php',$this->data);
	}
	public function report_inv_global()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE GLOBAL';
        $this->data['body'] = 'report/report_inv_global.php';
        // $list1 = $this->model_report->invoice_list_so();
        // $list2 = $this->model_report->invoice_list_do();
        // $this->data['data']['content'] = array_merge($list1,$list2);
        $this->data['data']['content'] = $this->model_report->report_inv_global();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_global';
		$this->load->view('main',$this->data);
	}
	public function report_inv_unpaid()
	{
		$this->auth->cek2('report_inv_unpaid');
        $this->data['PageTitle'] = 'REPORT INVOICE UNPAID';
        $this->data['body'] = 'report/report_inv_unpaid.php';
        // $list1 = $this->model_report->invoice_list_so_unpaid();
        // $list2 = $this->model_report->invoice_list_do_unpaid();
        // $this->data['data']['content'] = array_merge($list1,$list2);
        $this->data['data']['content'] = $this->model_report->invoice_list_global_unpaid();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_unpaid';
		$this->load->view('main',$this->data);
	}
	public function report_inv_retur()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE RETUR';
        $this->data['body'] = 'report/report_inv_retur.php';
        $this->data['data']['content'] = $this->model_report->report_inv_retur();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_retur';
		$this->load->view('main',$this->data);
	}

	// custom----------------------------------------------------------------
	public function report_inv_100_cities_east_customer()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE CUSTOMER';
        $this->data['body'] = 'report/report_inv_100_cities_customer.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_east_customer();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_east_customer';
		$this->load->view('main',$this->data);
	}
	public function report_inv_100_cities_east_sales()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE SALES';
        $this->data['body'] = 'report/report_inv_100_cities_sales.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_east_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_east_sales';
		$this->load->view('main',$this->data);
	}
	public function report_inv_100_cities_east_product()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE PRODUCT';
        $this->data['body'] = 'report/report_inv_100_cities_product.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_east_product();

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_east_product';
		$this->load->view('main',$this->data);
	}
	public function report_inv_100_cities_east_city()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE CITY';
        $this->data['body'] = 'report/report_inv_100_cities_city.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_east_city();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_east_city';
		$this->load->view('main',$this->data);
	}

	public function report_inv_100_cities_west_customer()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE CUSTOMER';
        $this->data['body'] = 'report/report_inv_100_cities_customer.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_west_customer();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_west_customer';
		$this->load->view('main',$this->data);
	}
	public function report_inv_100_cities_west_sales()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE SALES';
        $this->data['body'] = 'report/report_inv_100_cities_sales.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_west_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_west_sales';
		$this->load->view('main',$this->data);
	}
	public function report_inv_100_cities_west_product()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE PRODUCT';
        $this->data['body'] = 'report/report_inv_100_cities_product.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_west_product();

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_west_product';
		$this->load->view('main',$this->data);
	}
	public function report_inv_100_cities_west_city()
	{
		$this->auth->cek2('menu_report_inv_custom');
        $this->data['PageTitle'] = 'REPORT INVOICE CITY';
        $this->data['body'] = 'report/report_inv_100_cities_city.php';
        $this->data['data']['content'] = $this->model_report->report_inv_100_cities_west_city();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_100_cities_west_city';
		$this->load->view('main',$this->data);
	}

	public function report_inv_having_display()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE HAVING DISPLAY';
        $this->data['body'] = 'report/report_inv_having_display.php';
        $this->data['data']['content'] = $this->model_report->report_inv_having_display();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_having_display';
		$this->load->view('main',$this->data);
	}
	public function report_so_display_detail_by_customer()
	{
	    $this->auth->cek2('report_inv_global');
		$this->data['content'] = $this->model_report->report_so_display_detail_by_customer();
        $this->load->view('report/report_so_display_detail_by_customer.php',$this->data);
	}

	public function report_inv_paid_customer_product()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE PAID / CUSTOMER / PRODUCT';
        $this->data['body'] = 'report/report_inv_paid_customer_product.php';
        $this->data['data']['content'] = $this->model_report->report_inv_paid_customer_product();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_paid_customer_product';
		$this->load->view('main',$this->data);
	}
	public function report_inv_paid_customer_product_category()
	{
	    $this->auth->cek2('report_inv_customer');
		$this->data['content']['main'] = $this->model_report->report_inv_paid_customer_product_category();
        $this->load->model('model_master');
        $this->data['content']['category'] = $this->model_master->get_full_category();
        $this->load->view('report/report_inv_paid_customer_product_category.php',$this->data);
	}
	public function report_inv_paid_customer_product_brand()
	{
	    $this->auth->cek2('report_inv_customer');
		$this->data['content']['main'] = $this->model_report->report_inv_paid_customer_product_brand();
        $this->load->model('model_master');
        $this->data['content']['brand'] = $this->model_master->get_full_brand();
        $this->load->view('report/report_inv_paid_customer_product_brand.php',$this->data);
	} 
	public function report_inv_product_id()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE PER PRODUCT ID';
        $this->data['body'] = 'report/report_inv_product_id.php';
        $this->data['data']['content']['main'] = $this->model_report->report_inv_product_id();
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_product_id';
		$this->load->view('main',$this->data);
	}
	public function report_inv_product_detail_month()
	{
	    $this->auth->cek2('report_inv_global');
		$this->data['content'] = $this->model_report->report_inv_product_detail_month();
        $this->load->view('report/report_inv_product_detail_month.php',$this->data);
	}

	// ---------------------------------------------------------------------
	public function report_inv_sales()
	{
		$this->auth->cek2('report_inv_sales');
        $this->data['PageTitle'] = 'REPORT INVOICE PER SALES';
        $this->data['body'] = 'report/report_inv_sales.php';
        $this->data['data']['content'] = $this->model_report->report_inv_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_sales';
		$this->load->view('main',$this->data);
	}
	public function report_inv_sales_detail()
	{
	    $this->auth->cek2('report_inv_customer');
		$this->data['content'] = $this->model_report->report_inv_sales_detail();
        $this->load->view('report/report_inv_sales_detail.php',$this->data);
	}
	public function report_inv_sales_detail_month()
	{
	    $this->auth->cek2('report_inv_customer');
		$this->data['content'] = $this->model_report->report_inv_sales_detail_month();
        $this->load->view('report/report_inv_sales_detail_month.php',$this->data);
	}
	public function report_inv_product()
	{
		$this->auth->cek2('report_inv_product');
        $this->data['PageTitle'] = 'REPORT INVOICE PER PRODUCT';
        $this->data['body'] = 'report/report_inv_product.php';
        $this->data['data']['content']['main'] = $this->model_report->report_inv_product();
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_product';
		$this->load->view('main',$this->data);
	}
	public function report_inv_product_detail()
	{
	    $this->auth->cek2('report_inv_product');
		$this->data['content'] = $this->model_report->report_inv_product_detail();
        $this->load->view('report/report_inv_product_detail.php',$this->data);
	}
	public function report_inv_city()
	{
		$this->auth->cek2('report_inv_city');
        $this->data['PageTitle'] = 'REPORT INVOICE PER CITY';
        $this->data['body'] = 'report/report_inv_city.php';
        $this->data['data']['content'] = $this->model_report->report_inv_city();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_city';
		$this->load->view('main',$this->data);
	}
	public function report_inv_city_detail()
	{
	    $this->auth->cek2('report_inv_city');
		$this->data['content'] = $this->model_report->report_inv_city_detail();
        $this->load->view('report/report_inv_city_detail.php',$this->data);
	}
	public function report_inv_city_detail_month()
	{
	    $this->auth->cek2('report_inv_city');
		$this->data['content'] = $this->model_report->report_inv_city_detail_month();
        $this->load->view('report/report_inv_city_detail_month.php',$this->data);
	}
	public function report_inv_shop()
	{
		$this->auth->cek2('report_inv_shop');
        $this->data['PageTitle'] = 'REPORT INVOICE PER OMZET SHOP';
        $this->data['body'] = 'report/report_inv_shop.php';
        $this->data['data']['content'] = $this->model_report->report_inv_shop();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_shop';
		$this->load->view('main',$this->data);
	}
	public function report_inv_shop_detail()
	{
	    $this->auth->cek2('report_inv_shop');
		$this->data['content'] = $this->model_report->report_inv_shop_detail();
        $this->load->view('report/report_inv_shop_detail.php',$this->data);
	}
	public function report_inv_shop_detail_month()
	{
	    $this->auth->cek2('report_inv_shop');
		$this->data['content'] = $this->model_report->report_inv_shop_detail_month();
        $this->load->view('report/report_inv_shop_detail_month.php',$this->data);
	}
	public function report_inv_product_category()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE BY PRODUCT CATEGORY';
        $this->data['body'] = 'report/report_inv_product_category.php';
        if ($this->input->get_post('CategoryID')) {
	        $this->data['data']['content']['main'] = $this->model_report->report_inv_product_category();
        }
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_product_category';
		$this->load->view('main',$this->data);
	}
	public function report_inv_product_brand()
	{
		$this->auth->cek2('report_inv_global');
        $this->data['PageTitle'] = 'REPORT INVOICE BY PRODUCT BRAND';
        $this->data['body'] = 'report/report_inv_product_brand.php';
        if ($this->input->get_post('BrandID')) {
	        $this->data['data']['content']['main'] = $this->model_report->report_inv_product_brand();
        }
        $this->load->model('model_master');
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_product_brand';
		$this->load->view('main',$this->data);
	}
	public function report_inv_profit()
	{
		$this->auth->cek2('report_inv_profit');
        $this->data['PageTitle'] = 'REPORT INVOICE PROFIT';
        $this->data['body'] = 'report/report_inv_profit.php';
        $this->data['data']['content'] = $this->model_report->report_inv_profit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_profit';
		$this->load->view('main',$this->data);
	}
	public function report_inv_profit_detail()
	{
	    $this->auth->cek2('report_inv_profit');
		$this->data['content'] = $this->model_report->report_inv_profit_detail();
        $this->load->view('report/report_inv_profit_detail.php',$this->data);
	} 
	public function report_inv_profit_product()
	{
		$this->auth->cek2('report_inv_profit');
        $this->data['PageTitle'] = 'REPORT INVOICE PROFIT BY PRODUCT';
        $this->data['body'] = 'report/report_inv_profit_product.php';
        $this->data['data']['content']['main'] = $this->model_report->report_inv_profit_product();
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_inv_profit_product';
		$this->load->view('main',$this->data);
	}

// report_approval==================================================================
	public function report_approval_customer()
	{
		$this->auth->cek2('report_approval_customer');
        $this->data['PageTitle'] = 'REPORT APPROVAL CUSTOMER';
        $this->data['body'] = 'report/report_approval_customer.php';
        $this->data['data']['content'] = $this->model_report->report_approval_customer();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_customer';
		$this->load->view('main',$this->data);
	}
	public function report_approval_so()
	{
		$this->auth->cek2('report_approval_so');
        $this->data['PageTitle'] = 'REPORT APPROVAL SO';
        $this->data['body'] = 'report/report_approval_so.php';
        $this->data['data']['content'] = $this->model_report->report_approval_so();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_so';
		$this->load->view('main',$this->data);
	}
	public function report_approval_adjustment()
	{
		$this->auth->cek2('report_approval_adjustment');
        $this->data['PageTitle'] = 'REPORT APPROVAL ADJUSTMENT STOCK';
        $this->data['body'] = 'report/report_approval_adjustment.php';
        $this->data['data']['content'] = $this->model_report->report_approval_adjustment();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_adjustment';
		$this->load->view('main',$this->data);
	}
	public function report_approval_price_list()
	{
		$this->auth->cek2('report_approval_price_list');
        $this->data['PageTitle'] = 'REPORT APPROVAL PROMO PIECE';
        $this->data['body'] = 'report/report_approval_price_list.php';
        $this->data['data']['content'] = $this->model_report->report_approval_price_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_price_list';
		$this->load->view('main',$this->data);
	}
	public function report_approval_price_list_detail()
	{
		$this->auth->cek2('report_approval_price_list');
		$this->data['content'] = $this->model_report->report_approval_price_list_detail();
        $this->load->view('report/report_approval_price_list_detail.php',$this->data);
	}
	public function report_approval_price_recommendation()
	{
		$this->auth->cek2('report_approval_price_recommendation');
		$this->data['PageTitle'] = 'REPORT APPROVAL RECOMMENDATION PRICE';
		$this->data['body'] = 'report/report_approval_price_recommendation.php';
		$this->data['data']['content'] = $this->model_report->report_approval_price_recommendation();
		$this->data['data']['help'] = 'Doc';
		$this->data['data']['menu'] = 'report_approval_price_recommendation';
		$this->load->view('main',$this->data);
	}
	public function report_approval_promo_volume()
	{
		$this->auth->cek2('report_approval_promo_volume');
        $this->data['PageTitle'] = 'REPORT APPROVAL PROMO VOLUME';
        $this->data['body'] = 'report/report_approval_promo_volume.php';
        $this->data['data']['content'] = $this->model_report->report_approval_promo_volume();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_promo_volume';
		$this->load->view('main',$this->data);
	}
	public function report_approval_mutation_product()
	{
		$this->auth->cek2('report_approval_mutation_product');
        $this->data['PageTitle'] = 'REPORT APPROVAL MUTATION';
        $this->data['body'] = 'report/report_approval_mutation_product.php';
        $this->data['data']['content'] = $this->model_report->report_approval_mutation_product();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_mutation_product';
		$this->load->view('main',$this->data);
	}
	public function report_approval_purchase_order()
	{
		$this->auth->cek2('report_approval_purchase_order');
        $this->data['PageTitle'] = 'REPORT APPROVAL PURCHASE ORDER';
        $this->data['body'] = 'report/report_approval_purchase_order.php';
        $this->data['data']['content'] = $this->model_report->report_approval_purchase_order();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_approval_purchase_order';
		$this->load->view('main',$this->data);
	}

// report_customer==================================================================
	public function report_customer_deposit()
	{
		$this->auth->cek2('report_customer_deposit');
        $this->data['PageTitle'] = 'REPORT CUSTOMER DEPOSIT';
        $this->data['body'] = 'report/report_customer_deposit.php';
        $this->data['data']['content'] = $this->model_report->report_customer_deposit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_deposit';
		$this->load->view('main',$this->data);
	}
	public function report_customer_deposit_detail_full() 
	{
	    $this->auth->cek2('report_customer_deposit');
        $this->load->model('model_finance');
        $this->data['content'] = $this->model_finance->customer_deposit_distribution();
        $this->load->view('finance/customer_deposit_detail_full.php',$this->data);
	}
	public function report_customer_sales()
	{
		$this->auth->cek2('report_customer_sales');
        $this->data['PageTitle'] = 'REPORT CUSTOMER BY SALES';
        $this->data['body'] = 'report/report_customer_sales.php';
        $this->data['data']['content'] = $this->model_report->report_customer_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_sales';
		$this->load->view('main',$this->data);
	}
	public function report_customer_sales_detail()
	{
	    $this->auth->cek2('report_customer_sales');
		$this->data['content'] = $this->model_report->report_customer_sales_detail();
        $this->load->view('report/report_customer_sales_detail.php',$this->data);
	}
	public function report_customer_city()
	{
		$this->auth->cek2('report_customer_city');
        $this->data['PageTitle'] = 'REPORT CUSTOMER BY CITY';
        $this->data['body'] = 'report/report_customer_city.php';
        $this->data['data']['content'] = $this->model_report->report_customer_city();
        // echo json_encode($this->data['data']);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_city';
		$this->load->view('main',$this->data);
	}
	public function report_customer_city_detail()
	{
	    $this->auth->cek2('report_customer_city');
		$this->data['content'] = $this->model_report->report_customer_city_detail();
		// echo json_encode($this->model_report->report_customer_city_detail())
        $this->load->view('report/report_customer_city_detail.php',$this->data);
	}
	public function report_customer_display()
	{
		$this->auth->cek2('report_customer_display');
        $this->data['PageTitle'] = 'REPORT CUSTOMER (DISPLAY) BY CITY';
        $this->data['body'] = 'report/report_customer_display.php';
        $this->data['data']['content'] = $this->model_report->report_customer_display();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_display';
		$this->load->view('main',$this->data);
	}
	public function report_customer_display_detail()
	{
	    $this->auth->cek2('report_customer_display');
		$this->data['content'] = $this->model_report->report_customer_display_detail();
        $this->load->view('report/report_customer_display_detail.php',$this->data);
	}
	public function report_customer_consignment()
	{
		$this->auth->cek2('report_customer_consignment');
        $this->data['PageTitle'] = 'REPORT CUSTOMER (CONSIGNMENT) BY CITY';
        $this->data['body'] = 'report/report_customer_consignment.php';
        $this->data['data']['content'] = $this->model_report->report_customer_consignment();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_consignment';
		$this->load->view('main',$this->data);
	}
	public function report_customer_consignment_detail()
	{
	    $this->auth->cek2('report_customer_consignment');
		$this->data['content'] = $this->model_report->report_customer_consignment_detail();
        $this->load->view('report/report_customer_consignment_detail.php',$this->data);
	}
	public function report_customer_complaint()
	{
        $this->auth->cek2('report_customer_complaint');
        $this->data['PageTitle'] = 'Report Customer Complaint';
        $this->data['body'] = 'report/report_customer_complaint.php';
        $this->data['data']['content'] = $this->model_report->report_customer_complaint();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_complaint';
        $this->load->view('main',$this->data);
	}
	public function report_customer_complaint_add()
	{
        $this->auth->cek2('report_customer_complaint');
        $this->data['PageTitle'] = 'Report Customer Complaint Add';
        $this->data['body'] = 'report/report_customer_complaint_add.php';
            
        $CustomerID = $this->input->get_post('CustomerID');
        $SOID = $this->input->get_post('SOID');
        $SalesID = $this->input->get_post('SalesID');
        if (isset($CustomerID)) {
            $this->data['data']['content'] = $this->model_report->report_customer_complaint_add();
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_complaint';
        $this->load->view('main',$this->data);
	}
	public function report_customer_complaint_add_act()
	{
        $this->auth->cek2('report_customer_complaint');
        $this->data['content'] = $this->model_report->report_customer_complaint_add_act();
        redirect(base_url('report/report_customer_complaint'));
	}
	public function report_customer_complaint_edit()
	{
        $this->auth->cek2('report_customer_complaint');
        $this->data['PageTitle'] = 'Report Customer Complaint Edit';
        $this->data['body'] = 'report/report_customer_complaint_edit.php';
        $this->data['data']['content'] = $this->model_report->report_customer_complaint_edit();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_customer_complaint';
        $this->load->view('main',$this->data);
	}
	public function report_customer_complaint_edit_act()
	{
        $this->auth->cek2('report_customer_complaint');
        $this->data['content'] = $this->model_report->report_customer_complaint_edit_act();
        redirect(base_url('report/report_customer_complaint'));
	}
	public function report_customer_complaint_delete()
	{
        $this->auth->cek2('report_customer_complaint');
        $this->model_report->report_customer_complaint_delete();
        redirect(base_url('report/report_customer_complaint'));
	}
	
// report_employee==================================================================
	public function report_employee_login_hours()
	{
		$this->auth->cek2('report_employee_login_hours');
        $this->data['PageTitle'] = 'REPORT EMPLOYEE LOGIN HOURS';
        $this->data['body'] = 'report/report_employee_login_hours.php';
        $this->data['data']['content'] = $this->model_report->report_employee_login_hours();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_employee_login_hours';
		$this->load->view('main',$this->data);
	}
	public function report_employee_login_hours_detail()
	{
	    $this->auth->cek2('report_employee_login_hours');
		$this->data['content'] = $this->model_report->report_employee_login_hours_detail();
        $this->load->view('report/report_employee_login_hours_detail.php',$this->data);
	}
	public function report_employee_penalty()
	{
		$this->auth->cek2('report_employee_penalty');
        $this->data['PageTitle'] = 'REPORT EMPLOYEE PENALTY';
        $this->data['body'] = 'report/report_employee_penalty.php';
        $this->data['data']['content'] = $this->model_report->report_employee_penalty();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_employee_penalty';
		$this->load->view('main',$this->data);
	}
	public function report_employee_penalty_detail()
	{
	    $this->auth->cek2('report_employee_penalty');
		$this->data['content'] = $this->model_report->report_employee_penalty_detail();
        $this->load->view('report/report_employee_penalty_detail.php',$this->data);
	}
	public function report_employee_overtime()
	{
        $this->auth->cek2('report_employee_overtime');
        $this->data['PageTitle'] = 'Report Employee Overtime';
        $this->data['body'] = 'report/report_employee_overtime.php';
        $this->data['data']['content'] = $this->model_report->report_employee_overtime();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_employee_overtime';
        $this->load->view('main',$this->data);
	}
	
// report_do========================================================================
	public function report_do_not_inv()
	{
		$this->auth->cek2('report_do_not_inv');
        $this->data['PageTitle'] = 'REPORT DO not Invoice (SO ONLY)';
        $this->data['body'] = 'report/report_do_not_inv.php';
        $this->data['data']['content'] = $this->model_report->report_do_not_inv();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_not_inv';
		$this->load->view('main',$this->data);
	}
	public function report_do_global()
	{
		$this->auth->cek2('report_do_global');
        $this->data['PageTitle'] = 'REPORT DO GLOBAL (SO ONLY)';
        $this->data['body'] = 'report/report_do_global.php';
        $this->data['data']['content'] = $this->model_report->report_do_global();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_global';
		$this->load->view('main',$this->data);
	}
	public function report_do_fc()
	{
		$this->auth->cek2('report_do_fc');
        $this->data['PageTitle'] = 'REPORT DO FC';
        $this->data['body'] = 'report/report_do_fc.php';
        $this->data['data']['content'] = $this->model_report->report_do_fc();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_fc';
		$this->load->view('main',$this->data);
	}
	public function report_do_product()
	{
		$this->auth->cek2('report_do_product');
        $this->data['PageTitle'] = 'REPORT DO PRODUCT';
        $this->data['body'] = 'report/report_do_product.php';
        $this->data['data']['content']['main'] = $this->model_report->report_do_product();
        // echo json_encode($this->data['data']['content']['main']);
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_product';
		$this->load->view('main',$this->data);
	}
	public function report_do_product_detail()
	{
	    $this->auth->cek2('report_do_product');
		$this->data['content'] = $this->model_report->report_do_product_detail();
        $this->load->view('report/report_do_product_detail.php',$this->data);
	}
	public function report_do_consignment()
	{
		$this->auth->cek2('report_do_consignment');
        $this->data['PageTitle'] = 'REPORT DO Consignment';
        $this->data['body'] = 'report/report_do_consignment.php';
        $this->data['data']['content'] = $this->model_report->report_do_consignment();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_consignment';
		$this->load->view('main',$this->data);
	}
	public function report_do_late_so()
	{
		$this->auth->cek2('report_do_late_so');
        $this->data['PageTitle'] = 'REPORT DO LATE (SO)';
        $this->data['body'] = 'report/report_do_late_so.php';
        $this->data['data']['content'] = $this->model_report->report_do_late_so();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_late_so';
		$this->load->view('main',$this->data);
	}
	public function report_do_schedule()
	{
		$this->auth->cek2('report_do_schedule');
        $this->data['PageTitle'] = 'REPORT DO SCHEDULE';
        $this->data['body'] = 'report/report_do_schedule.php';
        $this->data['data']['content'] = $this->model_report->report_do_schedule();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_do_schedule';
		$this->load->view('main',$this->data);
	}

// report_so=======================================================================
	public function report_so_global()
	{
		$this->auth->cek2('report_so_global');
        $this->data['PageTitle'] = 'REPORT SALES ORDER GLOBAL';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER GLOBAL';
        $this->data['body'] = 'report/report_so_global.php';
        $this->data['data']['content'] = $this->model_report->report_so_global();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_global';
		$this->load->view('main',$this->data);
	}
	public function report_so_resi_mp()
	{
		$this->auth->cek2('report_so_resi_mp');
        $this->data['PageTitle'] = 'REPORT SALES ORDER RESI MARKETPLACE';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER RESI MARKETPLACE';
        $this->data['body'] = 'report/report_so_resi_mp.php';
        $this->data['data']['content'] = $this->model_report->report_so_resi_mp();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_resi_mp';
		$this->load->view('main',$this->data);
	}
	public function report_so_outstanding_do()
	{
		$this->auth->cek2('report_so_outstanding_do');
        $this->data['PageTitle'] = 'REPORT SALES ORDER OUTSTANDING DO';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER OUTSTANDING DO';
        $this->data['body'] = 'report/report_so_outstanding_do.php';
        $this->data['data']['content'] = $this->model_report->report_so_outstanding_do();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_outstanding_do';
		$this->load->view('main',$this->data);
	}
	public function report_so_outstanding_payment()
	{
		$this->auth->cek2('report_so_outstanding_payment');
        $this->data['PageTitle'] = 'REPORT SALES ORDER OUTSTANDING PAYMENT';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER OUTSTANDING PAYMENT';
        $this->data['body'] = 'report/report_so_outstanding_payment.php';
        $this->data['data']['content'] = $this->model_report->report_so_outstanding_payment();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_outstanding_payment';
		$this->load->view('main',$this->data);
	}
	public function report_so_product()
	{
		$this->auth->cek2('report_so_product');
        $this->data['PageTitle'] = 'REPORT SALES ORDER BY PRODUCT (QTY)';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER BY PRODUCT (QTY)';
        $this->data['body'] = 'report/report_so_product.php';
        $this->data['data']['content']['main'] = $this->model_report->report_so_product();
        // echo json_encode($this->data['data']['content']['main']);
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_product';
		$this->load->view('main',$this->data);
	}
	public function report_so_product_detail()
	{
	    $this->auth->cek2('report_so_product');
	    $this->data['content'] = $this->model_report->report_so_product_detail();
        $this->load->view('report/report_so_product_detail.php',$this->data);
	}
	public function report_so_detail()
	{
	    $this->auth->cek2('report_so_global');
		$this->data['content']['product'] = $this->model_report->report_so_detail();
		$this->data['content']['history'] = $this->model_report->history_so();
        $this->load->view('report/report_so_detail.php',$this->data);
	}
	public function so_note()
	{
		$this->auth->cek2('report_so_note');
		$this->model_report->so_note();
        redirect(base_url('report/report_so_outstanding_do'));
	}
	public function report_so_sales()
	{
		$this->auth->cek2('report_so_sales');
        $this->data['PageTitle'] = 'REPORT SALES ORDER PER SALES';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER PER SALES';
        $this->data['body'] = 'report/report_so_sales.php';
        $this->data['data']['content'] = $this->model_report->report_so_sales();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_sales';
		$this->load->view('main',$this->data);
	}
	public function report_so_sales_detail()
	{
	    $this->auth->cek2('report_so_sales');
		$this->data['content'] = $this->model_report->report_so_sales_detail();
        $this->load->view('report/report_so_sales_detail.php',$this->data);
	}
	public function report_so_sales_detail_month()
	{
	    $this->auth->cek2('report_so_sales');
		$this->data['content'] = $this->model_report->report_so_sales_detail_month();
        $this->load->view('report/report_so_sales_detail_month.php',$this->data);
	}
	public function report_so_shop()
	{
		$this->auth->cek2('report_so_shop');
        $this->data['PageTitle'] = 'REPORT SALES ORDER PER OMZET SHOP';
        $this->data['body'] = 'report/report_so_shop.php';
        $this->data['data']['content'] = $this->model_report->report_so_shop();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_shop';
		$this->load->view('main',$this->data);
	}
	public function report_so_shop_detail()
	{
	    $this->auth->cek2('report_so_shop');
		$this->data['content'] = $this->model_report->report_so_shop_detail();
        $this->load->view('report/report_so_shop_detail.php',$this->data);
	}
	public function report_so_shop_detail_month()
	{
	    $this->auth->cek2('report_so_shop');
		$this->data['content'] = $this->model_report->report_so_shop_detail_month();
        $this->load->view('report/report_so_shop_detail_month.php',$this->data);
	}
	// custom------------------------------------------------------------------
	public function report_so_project()
	{
		$this->auth->cek2('report_so_project');
        $this->data['PageTitle'] = 'REPORT SO PROJECT';
        $this->data['body'] = 'report/report_so_project.php';
        $this->data['data']['content'] = $this->model_report->report_so_project();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_project';
		$this->load->view('main',$this->data);
	}
	public function report_so_city_having_display()
	{
		$this->auth->cek2('report_so_custom');
        $this->data['PageTitle'] = 'REPORT SO CITY HAVING DISPLAY';
        $this->data['body'] = 'report/report_so_city_having_display.php';
        $this->data['data']['content'] = $this->model_report->report_so_city_having_display();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_city_having_display';
		$this->load->view('main',$this->data);
	}
	public function report_so_city_having_display_detail()
	{
	    $this->auth->cek2('report_so_custom');
		$this->data['content'] = $this->model_report->report_so_city_having_display_detail();
        $this->load->view('report/report_so_city_having_display_detail.php',$this->data);
	}
	public function report_so_not_inv()
	{
		$this->auth->cek2('report_so_custom');
        $this->data['PageTitle'] = 'REPORT SALES ORDER NOT INVOICE';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER NOT INVOICE';
        $this->data['body'] = 'report/report_so_global.php';
        $this->data['data']['content'] = $this->model_report->report_so_not_inv();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_not_inv';
		$this->load->view('main',$this->data);
	}
	public function report_so_late_payment()
	{
		$this->auth->cek2('report_so_custom');
        $this->data['PageTitle'] = 'REPORT SALES ORDER LATE PAYMENT';
        $this->data['data']['PageTitle'] = 'REPORT SALES ORDER LATE PAYMENT';
        $this->data['body'] = 'report/report_so_late_payment.php';
        $this->data['data']['content'] = $this->model_report->report_so_late_payment();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_late_payment';
		$this->load->view('main',$this->data);
	}
	public function report_so_outstanding_do_product()
	{
		$this->auth->cek2('report_so_outstanding_do_product');
        $this->data['PageTitle'] = 'REPORT PICKING LIST PRINTOUT';
        $this->data['body'] = 'report/report_so_outstanding_do_product.php';
        $this->data['data']['content'] = $this->model_report->report_so_outstanding_do_product();
        // echo json_encode($this->data['data']['content']);
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_so_outstanding_do_product';
		$this->load->view('main',$this->data);
	}

// report_product==================================================================
	public function report_product_general()
	{
		$this->auth->cek2('report_product_general');
        $this->data['PageTitle'] = 'REPORT PRODUCT';
        $this->data['body'] = 'report/report_product.php';
        $this->data['data']['content']['atributelist'] = $this->model_report->all_atribute();

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_general';
		$this->load->view('main',$this->data);
	}
	function report_product_list()
	{
	    $this->auth->cek2('report_product_general');
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
	        'table' => 'vw_product_list_popup2_active3', 
	        'column_select' => array('t1.ProductID','ProductName','ProductCode','stock','t2.Quantity','ProductPriceDefault','PVFinal','ModifiedDate','isActive','ProductSupplier','ProductDescription','ProductCategoryName','ProductBrandName','MinStock','MaxStock'), 
	        'column_order' => array(null,'t1.ProductID','ProductName','ProductCode','stock','t2.Quantity','ProductPriceDefault','PVFinal','ModifiedDate','isActive','ProductSupplier','ProductDescription','ProductCategoryName','ProductBrandName','MinStock','MaxStock',null), 
	        'column_search' => array('t1.ProductID','ProductName','ProductCode','ProductDescription'),  
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$document = '<button type="button" class="btn btn-flat btn-primary btn-xs view_detail" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-info"></i></button>';
			if ($this->auth->cek5('product_stock_list')) {
				$document .= "<button type='button' class='btn btn-flat btn-primary btn-xs history' title='HISTORY' product='".$field->ProductID."'><i class='fa fa-fw fa-history'></i></button>";
			}
	        // if ( $field->ProductImage != '') { 
        	// 	$document .= "<button type='button' class='btn btn-flat btn-primary btn-xs view_file' file='".$field->ProductImage."' title='IMAGE'><i class='fa fa-fw fa-file-image-o'></i></button>";
	        // } 
	        // if ( $field->ProductDoc != '') { 
        	// 	$document .= "<button type='button' class='btn btn-flat btn-primary btn-xs view_file' file='".$field->ProductDoc."' title='PDF'><i class='fa fa-fw fa-file-pdf-o'></i></button>";
	        // } 
            $status = ($field->isActive == 1 ? "Active" : "notActive");
            $PVFinal = ($field->PVFinal < 0 ? "0.00" : number_format($field->PVFinal,2) );
			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->stock);
			$row[] = number_format($field->Quantity);
			$row[] = number_format($field->ProductPriceDefault,2);
			$row[] = $PVFinal;
			$row[] = substr($field->ModifiedDate, 0, 10);
			$row[] = $status;
			$row[] = $field->ProductSupplier;
			$row[] = $field->ProductDescription;
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $document;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_stock_ro()
	{
	    $this->auth->cek2('report_product_stock_ro');
        $this->data['PageTitle'] = 'REPORT PRODUCT STOCK RO SUGGESTION > 0';
        $this->data['body'] = 'report/report_product_stock_ro.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_stock_ro';
		$this->load->view('main',$this->data);
	}
	function report_product_stock_ready_ro()
	{
	    $this->auth->cek2('report_product_stock_ro');

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
	        'table' => 'vw_stock_product_ready_ro',
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','SourceAgent','MinStock','MaxStock','minrosugestion','maxrosugestion','stock','sopending','rawpending','popending','ReadyStock','sopendingNonConfirm','ProductDescription'),
	        'column_order' => array('t1.ProductID','ProductCode','ProductName','SourceAgent','MinStock','MaxStock','minrosugestion','maxrosugestion','stock','sopending','rawpending','popending','ReadyStock','sopendingNonConfirm','ProductDescription'),
	        'column_search' => array('t1.ProductID','ProductCode','ProductName','SourceAgent','ProductDescription'),
	        'order' => array('t1.ProductID' => 'asc')
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			}
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}
			$stockhistory=$field->stock;
			if ($stockhistory !=0){
				$stockhistory ='<button type="button" class="btn btn-flat btn-default btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock">'.$field->stock.'</button>';
			}
			$popending = $field->popending;
			if ($popending != 0) {
				$popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->popending."</button>";
			}

			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = $field->ProductName;
			$row[] = $field->SourceAgent;
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $field->minrosugestion;
			$row[] = $field->maxrosugestion;
			$row[] = $stockhistory;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $popending;
			$row[] = $field->ReadyStock;
			$row[] = $sopendingNonConfirm;
			$row[] = $field->ProductDescription;
			$row[] = '<button type="button" class="btn btn-flat btn-primary btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock"><i class="fa fa-fw fa-info"></i></button>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_stock_ready_std() 
	{
	    $this->auth->cek2('report_product_stock_ready_std');
        $this->data['PageTitle'] = 'REPORT PRODUCT STOCK STANDARD';
        $this->data['body'] = 'report/report_product_stock_ready_std.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_stock_ready_std';
		$this->load->view('main',$this->data);
	}
	function report_product_stock_ready_data2()
	{
	    $this->auth->cek2('report_product_stock_ready_std');
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
	        'table' => 'vw_stock_product_ready_std', 
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','MinStock','MaxStock','stock','sopending','rawpending','popending','ReadyStock','CT','sopendingNonConfirm','ProductDescription'), 
	        'column_order' => array('t1.ProductID','ProductCode','ProductName','MinStock','MaxStock','stock','sopending','rawpending','popending','ReadyStock','CT','sopendingNonConfirm','ProductDescription'), 
	        'column_search' => array('t1.ProductID','ProductCode','ProductName','ProductDescription'), 
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			} 
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}
			$stockhistory=$field->stock;
			if ($stockhistory !=0){
				$stockhistory ='<button type="button" class="btn btn-flat btn-default btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock">'.$field->stock.'</button>';
			}
			$popending = $field->popending;
			if ($popending != 0) {
				$popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->popending."</button>";
			}

			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = wordwrap($field->ProductName,60,'<br>');
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $stockhistory;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $popending;
			$row[] = $field->ReadyStock;
			$row[] = $field->CT;
			$row[] = $sopendingNonConfirm;
			$row[] = $field->ProductDescription;
			$row[] = '<button type="button" class="btn btn-flat btn-primary btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock"><i class="fa fa-fw fa-info"></i></button>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_std_detail()
	{
	    $this->auth->cek2('report_product_general');
		$this->data['content'] = $this->model_report->report_product_detail();
        $this->load->view('report/report_product_std_detail.php',$this->data);
	}
	public function report_product_stock_ro_std() 
	{
	    $this->auth->cek2('report_product_stock_ro_std');
        $this->data['PageTitle'] = 'REPORT PRODUCT STOCK RO SUGGESTION > 0';
        $this->data['body'] = 'report/report_product_stock_ro_std.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_stock_ro_std';
		$this->load->view('main',$this->data);
	}
	function report_product_stock_ready_ro_data()
	{
	    $this->auth->cek2('report_product_stock_ro_std');

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
	        'table' => 'vw_stock_product_ready_ro_std',
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','MinStock','MaxStock','minrosugestion','maxrosugestion','stock','sopending','rawpending','popending','ReadyStock','sopendingNonConfirm','ProductDescription'),
	        'column_order' => array('t1.ProductID','ProductCode','ProductName','MinStock','MaxStock','minrosugestion','maxrosugestion','stock','sopending','rawpending','popending','ReadyStock','sopendingNonConfirm','ProductDescription'),
	        'column_search' => array('t1.ProductID','ProductCode','ProductName','ProductDescription'),
	        'order' => array('t1.ProductID' => 'asc')
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			}
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}
			$stockhistory=$field->stock;
			if ($stockhistory !=0){
				$stockhistory ='<button type="button" class="btn btn-flat btn-default btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock">'.$field->stock.'</button>';
			}
			$popending = $field->popending;
			if ($popending != 0) {
				$popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->popending."</button>";
			}

			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = $field->ProductName;
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $field->minrosugestion;
			$row[] = $field->maxrosugestion;
			$row[] = $stockhistory;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $popending;
			$row[] = $field->ReadyStock;
			$row[] = $sopendingNonConfirm;
			$row[] = $field->ProductDescription;
			$row[] = '<button type="button" class="btn btn-flat btn-primary btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock"><i class="fa fa-fw fa-info"></i></button>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_stock_min_ro() 
	{
	    $this->auth->cek2('report_product_stock_min_ro');
        $this->data['PageTitle'] = 'REPORT PRODUCT STOCK < MIN';
        $this->data['body'] = 'report/report_product_stock_min_ro.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_stock_min_ro';
		$this->load->view('main',$this->data);
	}
	function report_product_stock_min_ro_data()
	{
	    $this->auth->cek2('report_product_stock_min_ro');

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
	        'table' => 'vw_stock_product_ready_min_ro', 
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','MinStock','MaxStock','maxrosugestion','minrosugestion','stock','ReadyStock','sopending','rawpending','popending','sopendingNonConfirm','ProductDescription',''), 
	        'column_order' => array('t1.ProductID','ProductCode','ProductName','MinStock','MaxStock','minrosugestion','maxrosugestion','stock','ReadyStock','sopending','rawpending','popending','sopendingNonConfirm','ProductDescription',''), 
	        'column_search' => array('t1.ProductID','ProductCode','ProductName','ProductDescription'), 
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			} 
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}
			$stockhistory=$field->stock;
			if ($stockhistory !=0){
				$stockhistory ='<button type="button" class="btn btn-flat btn-default btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock">'.$field->stock.'</button>';
			}
			$popending = $field->popending;
			if ($popending != 0) {
				$popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->popending."</button>";
			}

			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = $field->ProductName;
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $field->minrosugestion;
			$row[] = $field->maxrosugestion;
			$row[] = $stockhistory;
			$row[] = $field->ReadyStock;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $popending;
			$row[] = $sopendingNonConfirm;
			$row[] = $field->ProductDescription;
			$row[] = '<button type="button" class="btn btn-flat btn-primary btn-xs view_stock" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-stock"><i class="fa fa-fw fa-info"></i></button>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_stock_ready()
	{
	    $this->auth->cek2('report_product_stock_all');
        $this->data['PageTitle'] = 'REPORT PRODUCT STOCK READY';
        $this->data['body'] = 'report/report_product_stock_ready.php';
        
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_stock_ready';
		$this->load->view('main',$this->data);
	}
	function report_product_stock_ready_data()
	{
	    $this->auth->cek2('report_product_stock_all');
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
	        'table' => 'vw_stock_product_ready', 
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','stock','sopending','rawpending','ReadyStock','sopendingNonConfirm','ProductDescription'), 
	        'column_order' => array('t1.ProductID','ProductCode','ProductName','stock','sopending','rawpending','ReadyStock','sopendingNonConfirm','ProductDescription'), 
	        'column_search' => array('t1.ProductID','ProductCode','ProductName','ProductDescription'), 
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			} 
			$sopendingNonConfirm = $field->sopendingNonConfirm;
			if ($sopendingNonConfirm != 0) {
				$sopendingNonConfirm = "<button type='button' class='btn btn-flat btn-default btn-xs so_pending_non_confirm' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopendingNonConfirm."</button>";
			}
			$row = array();
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = $field->ProductName;
			$row[] = $field->stock;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $field->ReadyStock;
			$row[] = $sopendingNonConfirm;
			// $row[] = number_format($field->stockWarehouse);
			$row[] = 0;
			$row[] = $field->ProductDescription;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function product_stock_history()
	{
	    $this->auth->cek2('product_stock_list');
        $this->data['PageTitle'] = 'PRODUCT STOCK HISTORY';
        $this->data['content'] = $this->model_report->product_stock_history();
		$this->load->view('report/product_stock_history.php',$this->data);
	}
	public function report_product_stock_all()
	{
	    $this->auth->cek2('report_product_stock_all');
        $this->data['PageTitle'] = 'REPORT PRODUCT STOCK ALL';
        $this->data['body'] = 'report/report_product_stock_all.php';
        
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_stock_all';
		$this->load->view('main',$this->data);
	}
	public function report_product_kpi()
	{
		$this->auth->cek2('report_product_kpi');
        $this->data['PageTitle'] = 'REPORT PRODUCT KPI';
        $this->data['body'] = 'report/report_product_kpi.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_kpi();
        // echo json_encode($this->model_report->report_product_kpi());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_kpi';
		$this->load->view('main',$this->data);
	}
	public function report_product_kpi_detail()
	{
	    $this->auth->cek2('report_product_kpi');
	    $this->data['content'] = $this->model_report->report_product_kpi_detail();
        $this->load->view('report/report_product_kpi_detail.php',$this->data);
	}
	public function report_product_kpi_so_detail()
	{
	    $this->auth->cek2('report_product_kpi');
	    $this->data['content'] = $this->model_report->report_product_kpi_so_detail();
        $this->load->view('report/report_product_kpi_so_detail.php',$this->data);
	}
	public function report_product_by_manager()
	{
		$this->auth->cek2('report_product_by_manager');
        $this->data['PageTitle'] = 'REPORT PRODUCT BY MANAGER';
        $this->data['data']['PageTitle'] = 'REPORT PRODUCT BY MANAGER';
        $this->data['body'] = 'report/report_product_by_manager.php';
        $this->data['data']['content'] = $this->model_report->report_product_by_manager();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_by_manager';
		$this->load->view('main',$this->data);
	}
	public function report_product_by_manager_detail()
	{
	    $this->auth->cek2('report_product_by_manager');
		$this->data['content'] = $this->model_report->report_product_by_manager_detail();
        $this->load->view('report/report_product_by_manager_detail.php',$this->data);
	}
	public function report_product_manager()
	{
		$this->auth->cek2('report_product_manager');
        $this->data['PageTitle'] = 'Product Manager';
        $this->data['body'] = 'report/report_product_manager.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_manager();
        // echo json_encode($this->model_report->report_product_manager());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_manager';
		$this->load->view('main',$this->data);
	}
	public function report_product_not_sale()
	{
		$this->auth->cek2('report_product_not_sale');
        $this->data['PageTitle'] = 'PRODUCT NOT READY FOR SALE & STOCK > 0';
        $this->data['body'] = 'report/report_product_not_sale.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_not_sale();
        // echo json_encode($this->model_report->report_product_price_active());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_not_sale';
		$this->load->view('main',$this->data);
	}
	function product_stock_list_data()
	{
	    $this->auth->cek2('report_product_stock_all');
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
	        'table' => 'vw_stock_product_full_active2', 
	        'column_select' => array('t1.ProductID','ProductCode','ProductName','ProductStatusName','ProductCategoryName','ProductBrandName','MinStock','MaxStock','stock','sopending','rawpending','ReadyStock','ropending','popending','mutationpending','NetStock','rosugestion','isActive'), 
	        'column_order' => array(null,'t1.ProductID','ProductCode','ProductName','ProductStatusName','ProductCategoryName','ProductBrandName','MinStock','MaxStock','stock','sopending','rawpending','ReadyStock','ropending','popending','mutationpending','NetStock','rosugestion','isActive'), 
	        'column_search' => array('t1.ProductID','ProductName','ProductCode'),  
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$sopending = $field->sopending;
			if ($sopending != 0) {
				$sopending = "<button type='button' class='btn btn-flat btn-default btn-xs so' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->sopending."</button>";
			}
			$rawpending = $field->rawpending;
			if ($rawpending != 0) {
				$rawpending = "<button type='button' class='btn btn-flat btn-default btn-xs raw' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->rawpending."</button>";
			}
			$ropending = $field->ropending;
			if ($ropending != 0) {
				$ropending = "<button type='button' class='btn btn-flat btn-default btn-xs ro' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->ropending."</button>";
			}
			$popending = $field->popending;
			if ($popending != 0) {
				$popending = "<button type='button' class='btn btn-flat btn-default btn-xs po' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->popending."</button>";
			}
			$mutationpending = $field->mutationpending;
			if ($mutationpending != 0) {
				$mutationpending = "<button type='button' class='btn btn-flat btn-default btn-xs mutation' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-detail'>".$field->mutationpending."</button>";
			}
			$stock = $field->stock;
			if ($stock != 0) {
				$stock = "<button type='button' class='btn btn-flat btn-default btn-xs view_stock' id='".$field->ProductID."'  data-toggle='modal' data-target='#modal-stock'>".$field->stock."</button>";
			}

			$ReadyStock = $field->stock - ($field->sopending+$field->rawpending);
			$NetStock = $ReadyStock + ($field->ropending+$field->popending+$field->mutationpending);

            $status = ($field->isActive == 1 ? "Active" : "notActive");
			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductID;
			$row[] = $field->ProductCode;
			$row[] = wordwrap($field->ProductName,60,'<br>');
			$row[] = $field->ProductStatusName;
			$row[] = $field->ProductCategoryName;
			$row[] = $field->ProductBrandName;
			$row[] = $field->MinStock;
			$row[] = $field->MaxStock;
			$row[] = $stock;
			$row[] = $sopending;
			$row[] = $rawpending;
			$row[] = $field->ReadyStock;
			$row[] = $ropending;
			$row[] = $popending;
			$row[] = $mutationpending;
			$row[] = $field->NetStock;
			$row[] = $field->rosugestion;
			$row[] = $status;
			$row[] = "";

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function product_stock_pending()
	{
		$this->auth->cek2('report_product_stock_all');
        $this->load->model('model_transaction');
		$type 	= $this->input->get_post('type');
		if ($type == "so") {
			$this->data['content'] = $this->model_transaction->product_stock_pending_so();
        	$this->load->view('transaction/product_stock_pending_so.php',$this->data);
		} elseif ($type == "so_pending_non_confirm") {
			$this->data['content'] = $this->model_transaction->product_stock_pending_so_pending_non_confirm();
        	$this->load->view('transaction/product_stock_pending_so.php',$this->data);
		} elseif ($type == "raw") {
			$this->data['content'] = $this->model_transaction->product_stock_pending_raw();
        	$this->load->view('transaction/product_stock_pending_raw.php',$this->data);
		} elseif ($type == "ro") {
			$this->data['content'] = $this->model_transaction->product_stock_pending_ro();
        	$this->load->view('transaction/product_stock_pending_ro.php',$this->data);
		} elseif ($type == "po") {
			$this->data['content'] = $this->model_transaction->product_stock_pending_po();
        	$this->load->view('transaction/product_stock_pending_po.php',$this->data);
		} elseif ($type == "mutation") {
			// $this->data['content'] = $this->model_transaction->product_stock_pending_mutation();
        	$this->load->view('transaction/product_stock_pending_mutation.php',$this->data);
		} else {
			redirect(base_url());
		}
	}
	public function report_product_detail()
	{
	    $this->auth->cek2('report_product_general');
		$this->data['content'] = $this->model_report->report_product_detail();
        $this->load->view('report/report_product_detail.php',$this->data);
	}
	public function report_product_category_list()
	{
		$this->auth->cek2('report_product_brand_category');
        $this->data['PageTitle'] = 'REPORT PRODUCT CATEGORY LIST';
        $this->data['body'] = 'report/report_product_category_list.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_category_list';
		$this->load->view('main',$this->data);
	}
	public function report_product_brand_list()
	{
		$this->auth->cek2('report_product_brand_category');
        $this->data['PageTitle'] = 'REPORT PRODUCT BRAND LIST';
        $this->data['body'] = 'report/report_product_brand_list.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_brand_list';
		$this->load->view('main',$this->data);
	}
	public function report_product_slowmoving()
	{
		$this->auth->cek2('report_product_slowmoving');
        $this->data['PageTitle'] = 'REPORT PRODUCT SLOWMOVING';
        $this->data['body'] = 'report/report_product_slowmoving.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_slowmoving();
        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_slowmoving';
		$this->load->view('main',$this->data);
	}
	function report_product_slowmoving_data()
	{
	    $this->auth->cek2('report_product_slowmoving');
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
	        'table' => 'vw_product_slowmoving', 
	        'column_select' => array('ProductID','ProductName','ProductCode','stock','ProductPriceDefault','ProductCategoryName','ProductBrandName','forSale','ProductManager','ED','LO','ProductQty','avrg','stockAvrg','Last'),
	        'column_order' => array(null,'ProductID','ProductName','ProductCode','stock','ProductPriceDefault','ProductCategoryName','ProductBrandName','forSale','ProductManager','ED','LO','ProductQty','avrg','stockAvrg','Last'),
	        'column_search' => array('ProductID','ProductName','ProductCode','ProductCategoryName','ProductBrandName','forSale','ProductManager','ED','LO'),
	        'order' => array('ProductID' => 'asc')
	    );
        $MenuList = $this->session->userdata('MenuList');

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			if (in_array("report_product_slowmoving_view_all", $MenuList)){
				$edit = '<a type="button" class="btn btn-primary btn-xs" href="'.base_url().'master/product_add?id='.$field->ProductID.'" target="_blank" title="Edit Product"><i class="fa fa-edit"></i></a>';
			} else {
				$edit = "";
			}

			if($field->forSale=='1'){
				$forsale="YES";
			} else {
				$forsale="NO";
			}

			$pricecheck='<a type="button" class="btn btn-success btn-xs" href="'.base_url().'master/price_check_add?ProductID='.$field->ProductID.'" target="_blank" title="Price Check"><i class="fa fa-tags"></i></a>';
			$document = '<a class="view_detail klik" id="view_detail" product="'.$field->ProductID.'" data-toggle="modal" data-target="#modal-detail">'.wordwrap($field->ProductName,45,"<br>\n").'</a>';
			$avrg = ($field->avrg < 1) ? 1 : $field->avrg ;
			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductID;
			$row[] = $document;
			$row[] = $field->ProductCode;
			$row[] = $field->stock;
			$row[] = number_format($field->ProductPriceDefault,2);
			$row[] = wordwrap($field->ProductCategoryName,20,"<br>\n");
			$row[] = $field->ProductBrandName;
			$row[] = $forsale;
			$row[] = $field->ProductManager;
			$row[] = $field->ED;
			$row[] = $field->LO;
			$row[] = $field->ProductQty;
			$row[] = $field->avrg;
			$row[] = number_format($field->stockAvrg,2);
			$row[] = $field->Last;
			$row[] = $edit.' '.$pricecheck;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_hpp_zero()
	{
		$this->auth->cek2('report_product_price');
        $this->data['PageTitle'] = 'REPORT PRODUCT HPP ZERO';
        $this->data['body'] = 'report/report_product_hpp_zero.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_hpp_zero';
		$this->load->view('main',$this->data);
	}
	function report_product_hpp_zero_data()
	{
	    $this->auth->cek2('report_product_price');
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
	        'table' => 'vw_product_list_price_list_count', 
	        'column_select' => array('t1.ProductID','ProductName','ProductCode','ProductPriceHPP','ProductPriceDefault','ProductPricePercent','PriceList','isActive' ), 
	        'column_order' => array(null,'t1.ProductID','ProductName','ProductCode','ProductPriceHPP','ProductPriceDefault','ProductPricePercent','PriceList','isActive',null), 
	        'column_search' => array('t1.ProductID','ProductName','ProductCode'),  
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$document = '<button type="button" class="btn btn-flat btn-primary btn-xs view_detail" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-info"></i></button>';
            $status = ($field->isActive == 1 ? "Active" : "notActive");

			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->ProductPriceHPP);
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductPricePercent;
			$row[] = $field->PriceList;
			$row[] = $status;
			$row[] = $document;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_product_shop()
	{
		$this->auth->cek2('shop_list');
        $this->data['PageTitle'] = 'REPORT PRODUCT ISHOP';
        $this->data['body'] = 'report/report_product_shop.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_shop';
		$this->load->view('main',$this->data);
	}
	function report_product_shop_data()
	{
	    $this->auth->cek2('shop_list');
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
	        'table' => 'vw_product_list_shop_assignment', 
	        'column_select' => array('t1.ProductID','ProductName','ProductCode','ProductManager','Shop','origin','CountShop','CountLink','Early','isActive','' ), 
	        'column_order' => array('t1.ProductID','ProductName','ProductCode','ProductManager','Shop','origin','CountShop','CountLink','Early','isActive',null), 
	        'column_search' => array('t1.ProductID','ProductName','ProductManager','Shop','origin'),
	        'order' => array('t1.ProductID' => 'asc')  
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$document = 
			'<button class="btn btn-primary btn-xs shop" type="button" data-toggle="collapse" data-target="#collapseExample'.$field->ProductID.'" productid='.$field->ProductID.'><i class="fa fa-fw fa-plus-square"></i></button>
			<button type="button" class="btn btn-flat btn-primary btn-xs view_detail" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-info"></i></button>';
            $status = ($field->isActive == 1 ? "Active" : "notActive");

			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductName." (".$field->ProductID.")";
			$row[] = $field->ProductCode;
			$row[] = $field->ProductManager;
			$row[] = $field->Shop;
			$row[] = $field->origin;
			$row[] = '<a href="'.base_url().'report/product_shop?productid='.$field->ProductID.'" target="_blank">'.$field->CountShop.'</a>'.
					'<div class="collapse" id="collapseExample'.$field->ProductID.'">
					  <span class="shopproduct'.$field->ProductID.'"> </span>
					</div>';
			$row[] = $field->CountLink;
			$row[] = $field->Early;
			$row[] = $status;
			$row[] = $document;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function product_shop_detail()
	{
		$this->auth->cek2('shop_list');
		$this->model_report->product_shop_detail();
	}
	public function report_product_shop_dor()
	{
		$this->auth->cek2('report_product_shop_dor');
        $this->data['PageTitle'] = 'ISHOP BY DOR (PSHOP)';
        $this->data['body'] = 'report/report_product_shop_dor.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_shop_dor();
        //echo json_encode($this->model_report->report_product_price_active());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_shop_dor';
		$this->load->view('main',$this->data);
	}
	public function product_shop()
	{
		$this->auth->cek2('shop_list');
		$this->data['PageTitle'] = 'PRODUCT SHOP';
        $this->data['body'] = 'report/product_shop.php';
        $this->data['data']['content'] = $this->model_report->product_shop();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_shop';
        // echo json_encode($this->model_report->product_shop());
		$this->load->view('main',$this->data);
	}
	public function report_stock_adjustment_balance()
	{
	    $this->auth->cek2('report_stock_adjustment_balance');
        $this->data['PageTitle'] = 'REPORT STOCK CHECK';
        $this->data['body'] = 'report/report_stock_adjustment_balance.php';
        $this->data['data']['content'] = $this->model_report->report_stock_adjustment_balance();
        // $this->load->model('model_master');
        // $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_stock_adjustment_balance';
		$this->load->view('main',$this->data);
	}
	public function get_report_stock_adjustment_detail()
	{
	    $this->auth->cek2('report_stock_adjustment_balance');
	    $this->data['PageTitle'] = 'PRODUCT CHECK STOCK HISTORY';
        $this->data['content'] = $this->model_report->get_report_stock_adjustment_detail();
        $this->load->view('transaction/product_stock_balance_history.php',$this->data);
	}
	public function product_shop_act()
	{
		$this->auth->cek2('shop_list');
		$this->model_report->product_shop_act();
		redirect(base_url('report/report_product_shop'));
	}
	public function report_product_price_active()
	{
		$this->auth->cek2('report_product_price_active');
        $this->data['PageTitle'] = 'Pricelist Offline';
        $this->data['body'] = 'report/report_product_price_active.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_price_active();
        //echo json_encode($this->model_report->report_product_price_active());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_price_active';
		$this->load->view('main',$this->data);
	}
	public function report_product_price_offline_reseller()
	{
		$this->auth->cek2('report_product_price_offline_reseller');
        $this->data['PageTitle'] = 'Pricelist Offline Reseller';
        $this->data['body'] = 'report/report_product_price_offline_reseller.php';
        $this->data['data']['content']['main'] = $this->model_report->report_product_price_offline_reseller();
        // echo json_encode($this->model_report->report_product_price_active());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_price_offline_reseller';
		$this->load->view('main',$this->data);
	}
	public function report_product_price_active_detail()
	{
		$this->auth->cek2('report_product_price_active_online');
		$this->data['content'] = $this->model_report->report_product_price_active_detail();
		$this->load->view('report/report_product_price_active_detail.php',$this->data);
	}
	public function report_product_price()
	{
		$this->auth->cek2('report_product_price');
        $this->data['PageTitle'] = 'REPORT PRODUCT PRICE HPP';
        $this->data['body'] = 'report/report_product_price.php';

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->load->model('model_master2');
        $this->data['data']['content']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_product_price';
		$this->load->view('main',$this->data);
	}
	function report_product_price_data()
	{
	    $this->auth->cek2('report_product_price');
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
	        'table' => 'vw_product_list_price_list_count',
	        'column_select' => array('t1.ProductID','ProductName','ProductCode','ProductPriceHPP','ProductPriceDefault','ProductPricePercent','PriceList','isActive' ),
	        'column_order' => array(null,'t1.ProductID','ProductName','ProductCode','ProductPriceHPP','ProductPriceDefault','ProductPricePercent','PriceList','isActive',null),
	        'column_search' => array('t1.ProductID','ProductName','ProductCode'),
	        'order' => array('t1.ProductID' => 'asc')
	    );

        $this->load->model('Model_datatable2');
		$list = $this->Model_datatable2->get_datatables($data_dt);
		$data = array();
		$no = $_POST['start'];
        $number = 1;
		foreach ($list as $field) {
			$document = '<button type="button" class="btn btn-flat btn-primary btn-xs view_detail" id="'.$field->ProductID.'"" data-toggle="modal" data-target="#modal-detail"><i class="fa fa-fw fa-info"></i></button>';
            $status = ($field->isActive == 1 ? "Active" : "notActive");

			$row = array();
			$row[] = $number++;
			$row[] = $field->ProductID;
			$row[] = $field->ProductName;
			$row[] = $field->ProductCode;
			$row[] = number_format($field->ProductPriceHPP);
			$row[] = number_format($field->ProductPriceDefault);
			$row[] = $field->ProductPricePercent;
			$row[] = $field->PriceList;
			$row[] = $status;
			$row[] = $document;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
			"recordsTotal" => $this->Model_datatable2->count_all(),
			"recordsFiltered" => $this->Model_datatable2->count_filtered(),
		);
		//output dalam format JSON
		echo json_encode($output);
	}
	public function report_price_check_list()
	{
		$this->auth->cek2('report_price_check_list');
        $this->data['PageTitle'] = 'REPORT PRICE CHECK LIST';
        $this->data['body'] = 'report/report_price_check_list.php';
        $this->data['data']['content']['main'] = $this->model_report->report_price_check_list();
        // echo json_encode($this->model_report->report_price_check_list());
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_price_check_list';
		$this->load->view('main',$this->data);
	}
	public function get_product_offline_detail() 
	{
	    $this->auth->cek2('report_product_price_active');
        $this->data['content'] = $this->model_report->get_product_offline_detail();
        $this->data['data']['help'] = 'Doc';
        // echo json_encode($this->data['content']);
        $this->load->view('report/product_offline_detail.php',$this->data);
	}

// report_ro=======================================================================
	public function report_ro_outstanding_po()
	{
		$this->auth->cek2('report_ro_outstanding_po');
        $this->data['PageTitle'] = 'REPORT RO OUTSTANDING PO';
        $this->data['body'] = 'report/report_ro_outstanding_po.php';
        $this->data['data']['content'] = $this->model_report->report_ro_outstanding_po();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_ro_outstanding_po';
		$this->load->view('main',$this->data);
	}
	public function report_ro_outstanding_dor()
	{
		$this->auth->cek2('report_ro_outstanding_dor');
        $this->data['PageTitle'] = 'REPORT RO OUTSTANDING DOR';
        $this->data['body'] = 'report/report_ro_outstanding_dor.php';
        $this->data['data']['content'] = $this->model_report->report_ro_outstanding_dor();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_ro_outstanding_dor';
		$this->load->view('main',$this->data);
	}

// report_po=======================================================================
	public function report_po_general()
	{
		$this->auth->cek2('report_po_general');
        $this->data['PageTitle'] = 'REPORT PO GENERAL';
        $this->data['body'] = 'report/report_po_general.php';
        $this->data['data']['content'] = $this->model_report->report_po_general();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_po_general';
		$this->load->view('main',$this->data);
	}
	public function report_po_outstanding_do()
	{
		$this->auth->cek2('report_po_outstanding_do');
        $this->data['PageTitle'] = 'REPORT PO OUTSTANDING DO';
        $this->data['body'] = 'report/report_po_outstanding_do.php';
        $this->data['data']['content'] = $this->model_report->report_po_outstanding_do();
        $this->load->model('model_master2');
        $this->data['data']['warehouse'] = $this->model_master2->warehouse_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_po_outstanding_do';
		$this->load->view('main',$this->data);
	}
	public function report_po_outstanding_dor()
	{
		$this->auth->cek2('report_po_outstanding_dor');
        $this->data['PageTitle'] = 'REPORT PO OUTSTANDING DOR';
        $this->data['body'] = 'report/report_po_outstanding_dor.php';
        $this->data['data']['content'] = $this->model_report->report_po_outstanding_dor();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_po_outstanding_dor';
		$this->load->view('main',$this->data);
	}
	public function report_po_dor_general()
	{
		$this->auth->cek2('report_po_dor_general');
        $this->data['PageTitle'] = 'REPORT PO DOR GENERAL';
        $this->data['body'] = 'report/report_po_dor_general.php';
        $this->data['data']['content'] = $this->model_report->report_po_dor_general();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_po_dor_general';
		$this->load->view('main',$this->data);
	}
	public function report_po_dor_product()
	{
		$this->auth->cek2('report_po_dor_product');
        $this->data['PageTitle'] = 'REPORT PO DOR PRODUCT';
        $this->data['body'] = 'report/report_po_dor_product.php';
        $this->data['data']['content'] = $this->model_report->report_po_dor_product();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_po_dor_product';
		$this->load->view('main',$this->data);
	}
	public function purchase_order_detail_full()
	{
	    $this->auth->cek2('report_po_outstanding_dor');
        $this->load->model('model_transaction');
		$this->data['content'] = $this->model_transaction->purchase_order_detail_full();

		$this->data['content']['history'] = $this->model_report->history_po();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_detail_full.php',$this->data);
	}
	public function purchase_order_detail_full2()
	{
	    $this->auth->cek2('report_po_general');
        $this->load->model('model_transaction');
		$this->data['content'] = $this->model_transaction->purchase_order_detail_full();

		$this->data['content']['history'] = $this->model_report->history_po();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_detail_full2.php',$this->data);
	}
	public function purchase_order_detail_raw_full()
	{
	    $this->auth->cek2('report_po_outstanding_dor');
        $this->load->model('model_transaction');
		$this->data['content'] = $this->model_transaction->purchase_order_detail_raw_full();
        $this->data['data']['help'] = 'Doc';
        $this->load->view('transaction/purchase_order_detail_raw_full.php',$this->data);
	}
	public function po_note()
	{
		$this->auth->cek2('report_po_note');
		$this->model_report->po_note();
        redirect(base_url('report/report_po_outstanding_dor'));
	}
	public function report_marketing_activity()
	{
        $this->auth->cek2('report_marketing_activity');
        $this->data['PageTitle'] = 'Report Marketing Activity Monthly';
        $this->data['body'] = 'report/report_marketing_activity.php';
        $this->data['data']['content'] = $this->model_report->report_marketing_activity();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_marketing_activity';
        $this->load->view('main',$this->data);
	}
	public function marketing_activity_print()
	{
        $this->data['PageTitle'] = 'Marketing Activity';
		$this->data['content'] = $this->model_report->marketing_activity_print();
        $this->load->view('report/marketing_activity_print.php',$this->data);
	}

// =========================================================================== 
}
