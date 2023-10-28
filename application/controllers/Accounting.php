<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M'); 

class Accounting extends CI_Controller {
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

        $this->load->model('model_acc');
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

// account=======================================================================
    public function acc_account_list()
    {   
        $this->auth->cek2('acc_account');
        $this->data['PageTitle'] = 'ACCOUNT LIST';
        $this->data['body'] = 'accounting/acc_account_list.php';
        $this->data['data']['fill_account_no_child_no_jurnal'] = $this->model_acc->fill_account_no_child_no_jurnal();
        $this->data['data']['fill_account_no_jurnal'] = $this->model_acc->fill_account_no_jurnal();

        $this->load->model('model_hrd');
        $this->data['data']['fill_company'] = $this->model_hrd->company_list();

        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_account_list';
        $this->load->view('main',$this->data);
    }
    public function acc_account_detail()
    {
        $this->auth->cek2('acc_account');
        $this->model_acc->acc_account_detail(); 
    }
    public function acc_account_add()
    {
        $this->auth->cek2('acc_account'); 
        $this->model_acc->acc_account_add(); 
        redirect(base_url('accounting/acc_account_list'));
    }
    public function acc_account_edit()
    {
        $this->auth->cek2('acc_account'); 
        $this->model_acc->acc_account_edit(); 
        redirect(base_url('accounting/acc_account_list'));
    }
    public function acc_account_delete()
    {
        $this->auth->cek2('acc_account'); 
        $this->model_acc->acc_account_delete(); 
    }
    public function ajax_account_list_jstree_table()
    {
        $this->auth->cek2('acc_account'); 
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->model_acc->ajax_account_list_jstree_table()); 
        } else {
            return $this->model_acc->ajax_account_list_jstree_table();
        }
    }
    public function acc_account_assignment()
    {   
        $this->auth->cek2('acc_account');
        $this->data['PageTitle'] = 'ACCOUNT ASSIGNMENT';
        $this->data['body'] = 'accounting/acc_account_assignment.php';
        $this->data['data']['content'] = $this->model_acc->acc_account_assignment();
        $this->data['data']['fill_account_no_child'] = $this->model_acc->fill_account_no_child();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_account_assignment';
        $this->load->view('main',$this->data);
    }
    public function acc_account_assignment_add()
    {
        $this->auth->cek2('acc_account'); 
        $this->model_acc->acc_account_assignment_add(); 
        redirect(base_url('accounting/acc_account_assignment'));
    }
    public function cek_real_amount()
    {
        $this->auth->cek2('acc_account'); 
        $this->model_acc->cek_real_amount(); 
    }

// journal=======================================================================
    public function acc_journal_list()
    {   
        $this->auth->cek2('acc_journal');
        $this->data['PageTitle'] = 'JOURNAL LIST';
        $this->data['body'] = 'accounting/acc_journal_list.php';
        $this->data['data']['content'] = $this->model_acc->acc_journal_list();
        $this->data['data']['fill_account'] = $this->model_acc->fill_account_no_child();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_journal_list';
        $this->load->view('main',$this->data);
    }
    public function acc_journal_add()
    {   
        $this->auth->cek2('acc_journal'); 
        $this->model_acc->acc_journal_add(); 
        redirect(base_url('accounting/acc_journal_list'));
        // echo "<script>window.history.go(-1);</script>";
    }
    public function acc_journal_edit()
    {
        $this->auth->cek2('acc_journal'); 
        $this->model_acc->acc_journal_edit(); 
    }
    public function acc_journal_edit_act()
    {
        $this->auth->cek2('acc_journal'); 
        $this->model_acc->acc_journal_edit_act(); 
        redirect(base_url('accounting/acc_journal_list'));
        // echo "<script>window.history.go(-1);</script>";
    }
    public function acc_journal_recalculate()
    {
        $this->auth->cek2('acc_journal'); 
        $this->model_acc->acc_journal_recalculate(); 
        redirect(base_url('accounting/acc_journal_list'));
    }
    public function journal_opposite()
    {   
        $this->auth->cek2('acc_journal'); 
        $this->data['PageTitle'] = 'CREATE JOURNAL OPPOSITE';
        $this->data['body'] = 'accounting/journal_opposite.php';
        $this->data['data']['content'] = $this->model_acc->journal_opposite(); 
        $this->data['data']['fill_account'] = $this->model_acc->fill_account_no_child();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_journal_list';
        $this->load->view('main',$this->data);
    } 
    public function journal_opposite_add()
    {
        $this->auth->cek2('acc_journal'); 
        $this->model_acc->journal_opposite_add(); 
        redirect(base_url('accounting/journal_opposite'));
    }
    public function journal_delete()
    {
        $this->auth->cek2('acc_journal'); 
        $this->model_acc->journal_delete(); 
    }

// report========================================================================
    public function report_balance()
    {
        $this->auth->cek2('acc_report');
        $this->data['PageTitle'] = 'REPORT BALANCE';
        $this->data['body'] = 'accounting/report_balance.php';
        $this->data['data']['content'] = $this->model_acc->report_balance();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_balance';
        $this->load->view('main',$this->data);
    }
    public function report_formula()
    {
        $this->auth->cek2('acc_report');
        $this->data['PageTitle'] = 'REPORT FORMULA';
        $this->data['body'] = 'accounting/report_formula.php';
        $this->data['data']['content'] = $this->model_acc->report_formula();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_formula';
        $this->load->view('main',$this->data);
    }
    public function report_formula_add()
    {
        $this->auth->cek2('acc_report');
        $this->data['PageTitle'] = 'ADD REPORT FORMULA';
        $this->data['body'] = 'accounting/report_formula_add.php';
        $this->data['data']['content']['fill_account'] = $this->model_acc->fill_account();
        if (isset($_REQUEST['report'])) {
            $this->data['data']['content']['report_formula_detail'] = $this->model_acc->report_formula_edit(); 
        }
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_formula';
        $this->load->view('main',$this->data);
    }
    public function report_formula_add_act()
    {
        $this->auth->cek2('acc_report'); 
        if ($this->input->get_post('ReportID')) {
            $this->model_acc->report_formula_edit_act(); 
        } else {
            $this->model_acc->report_formula_add_act(); 
        }
        redirect(base_url('accounting/report_formula'));
    }
    public function report_formula_detail()
    {
        $this->auth->cek2('acc_report'); 
        $this->data['PageTitle'] = 'REPORT FORMULA';
        $this->data['content'] = $this->model_acc->report_formula_detail(); 
        $this->load->view('accounting/report_formula_detail.php',$this->data);
    }
    public function report_result()
    {
        $this->auth->cek2('acc_report');
        $this->data['PageTitle'] = 'REPORT RESULT';
        $this->data['body'] = 'accounting/report_result.php';
        $this->data['data']['content'] = $this->model_acc->report_formula();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_result';
        $this->load->view('main',$this->data);
    }
    public function report_result_detail()
    {
        $this->auth->cek2('acc_report'); 
        $this->data['content'] = $this->model_acc->report_result_detail(); 
        $this->load->view('accounting/report_result_detail.php',$this->data);
    }
    public function report_posted()
    {
        $this->auth->cek2('acc_report');
        $this->data['PageTitle'] = 'REPORT BALANCE';
        $this->data['body'] = 'accounting/report_posted.php';
        $this->data['data']['content'] = $this->model_acc->report_posted();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'report_posted';
        $this->load->view('main',$this->data);
    }

// faktur_inv====================================================================
    public function acc_faktur_inv()
    {   
        $this->auth->cek2('acc_faktur_inv');
        $this->data['PageTitle'] = 'FAKTUR INVOICE SALES';
        $this->data['body'] = 'accounting/acc_faktur_inv.php';
        $this->data['data']['content'] = $this->model_acc->acc_faktur_inv();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_faktur_inv';
        $this->load->view('main',$this->data);
    }
    public function print_faktur()
    {
        $this->auth->cek2('acc_faktur_inv');
        $this->data['PageTitle'] = 'FAKTUR PRINT';
        $this->load->model('model_transaction');
        $this->data['content'] = $this->model_transaction->print_faktur();
        $this->load->view('transaction/print_faktur.php',$this->data);
    }
    public function acc_faktur_inv_retur()
    {   
        $this->auth->cek2('acc_faktur_inv');
        $this->data['PageTitle'] = 'FAKTUR INVOICE RETUR';
        $this->data['body'] = 'accounting/acc_faktur_inv_retur.php';
        $this->data['data']['content'] = $this->model_acc->acc_faktur_inv_retur();;
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_faktur_inv_retur';
        $this->load->view('main',$this->data);
    }
    public function setFakturRetur()
    {   
        $this->auth->cek2('acc_faktur_inv');
        $this->model_acc->setFakturRetur(); 
        redirect(base_url('accounting/acc_faktur_inv_retur'));
    }
    public function print_faktur_retur()
    {
        $this->auth->cek2('acc_faktur_inv');
        $this->data['PageTitle'] = 'FAKTUR RETUR PRINT';
        $this->load->model('model_transaction');
        $this->data['content'] = $this->model_transaction->print_faktur_retur();
        $this->load->view('transaction/print_faktur_retur.php',$this->data);
    }

// acc_stock_value===============================================================
    public function acc_stock_value()
    {   
        $this->auth->cek2('acc_stock_value');
        $this->data['PageTitle'] = '(Product List) Value of Inventory';
        $this->data['body'] = 'accounting/acc_stock_value.php';
        $this->data['data']['content']['summary'] = $this->model_acc->total_stock_value();

        $this->load->model('model_master');
        $this->data['data']['content']['category'] = $this->model_master->get_full_category();
        $this->data['data']['content']['brand'] = $this->model_master->get_full_brand();
        $this->data['data']['content']['atribute'] = $this->model_master->get_atribute_list();
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_stock_value';
        $this->load->view('main',$this->data);
    }
    function acc_stock_value_data()
    {
        $this->auth->cek2('acc_stock_value');
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
            // nama tabel
            'table' => 'vw_product_list_popup8',
            // field yg ditampilkan
            'column_order' => array('ProductID','ProductCode','ProductName','stock','ProductPriceHPP','totalValueStock','totalValueStock','isActive','ProductCategoryID'),
            //field pencarian 
            'column_search' => array('ProductID','ProductCode','ProductName'), 
            'order' => array('ProductID' => 'asc') 
        );

        $this->load->model('Model_datatable2');
        $list = $this->Model_datatable2->get_datatables($data_dt);

        $this->load->model('model_master');
        $ProductCategoryParent = $this->model_master->get_category_parent_main();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $status = ($field->isActive == 1 ? "Active" : "notActive");
            
            $row = array();
            $row[] = $field->ProductID;
            $row[] = $field->ProductName;
            $row[] = $field->ProductCode;
            $row[] = number_format($field->stock);
            $row[] = number_format($field->ProductPriceHPP);
            $row[] = number_format($field->totalValueStock);
            $row[] = $status;
            $row[] = $ProductCategoryParent[$field->ProductCategoryID]['ProductCategoryName'];

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
    public function acc_stock_value2()
    {   
        $this->auth->cek2('acc_stock_value');
        $this->data['PageTitle'] = '(Category List) Value of Inventory ';
        $this->data['body'] = 'accounting/acc_stock_value2.php';
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_stock_value2';
        $this->load->view('main',$this->data);
    }

// faktur_inv====================================================================
    public function acc_dp_payment()
    {   
        $this->auth->cek2('acc_dp_payment');
        $this->data['PageTitle'] = 'DOWN PAYMENT AND REPAYMENT';
        $this->data['body'] = 'accounting/acc_dp_payment.php';

        $list2 = $this->model_acc->acc_dp_payment_payment();
        $this->data['data']['content']['main'] = array_merge($list2);
        $this->data['data']['help'] = 'Doc';
        $this->data['data']['menu'] = 'acc_dp_payment';
        $this->load->view('main',$this->data);
    }

// ==============================================================================

}
