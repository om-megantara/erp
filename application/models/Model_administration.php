<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_administration extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }
    
// site configuration ==============================================================
    function site_config()
	{
		$sql 	= "select * from tb_site_config ";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		$show = array(
			'ReportPagingDefault' => $row->ReportPagingDefault,
			'ReportPaging' => $row->ReportPaging,
			'ReportResult' => $row->ReportResult,
			'CustomerCreditLimit' => $row->CustomerCreditLimit,
			'CustomerPaymentTerm' => $row->CustomerPaymentTerm,
			'TitleMenuMini' => $row->TitleMenuMini,
			'TitleMenuFull' => $row->TitleMenuFull,
			'MainTitle' => $row->MainTitle,
			'MainWarning' => $row->MainWarning,
			'MainInfo' => $row->MainInfo,
			'SODepositStandard' => $row->SODepositStandard,
			'SODepositCustom' => $row->SODepositCustom,
			'SODepositProject' => $row->SODepositProject,
			'SOShipDate' => $row->SOShipDate,
			'SODPDeviation' => $row->SODPDeviation,
			'INVLatePayment' => $row->INVLatePayment,
			'StockMin' => $row->StockMin,
			'StockMax' => $row->StockMax,
			'SlowMovingMply' => $row->SlowMovingMply,
			'PV' => $row->PV,
			'MPfee' => $row->MPfee,
			'CustomerPVMultiplier' => $row->CustomerPVMultiplier,
			'SEPVMultiplier' => $row->SEPVMultiplier,
		);

			$opts=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);  
			$Faktur1 = fopen(('./tool/HeaderFaktur1.txt'), "r", false, stream_context_create($opts)) or die("Unable to open file!");
			$show ['HeaderFaktur1'] = fgets($Faktur1);
			fclose($Faktur1);

			$Faktur2 = fopen(('./tool/HeaderFaktur2.txt'), "r", false, stream_context_create($opts)) or die("Unable to open file!");
			$show ['HeaderFaktur2'] = '';
			while(! feof($Faktur2))  {
				$show ['HeaderFaktur2'] .= fgets($Faktur2);
			}
			fclose($Faktur2);

	    $this->log_user->log_query($this->last_query);
	    return $show;
	}
	function site_config_edit($val)
	{
		$this->db->trans_start();

		if ($val == "site") {
			$ReportPaging 			= $this->input->post('ReportPaging'); 
			$ReportPagingDefault 	= $this->input->post('ReportPagingDefault'); 
			$ReportResult 	= $this->input->post('ReportResult'); 
			$CustomerCreditLimit 	= $this->input->post('CustomerCreditLimit'); 
			$CustomerPaymentTerm 	= $this->input->post('CustomerPaymentTerm'); 

			$TitleMenuMini 	= $this->input->post('TitleMenuMini'); 
			$TitleMenuFull 	= $this->input->post('TitleMenuFull'); 
			$MainTitle = $this->input->post('MainTitle'); 
			$MainWarning = $this->input->post('MainWarning'); 
			$MainInfo = $this->input->post('MainInfo');
			$HeaderFaktur1 = $this->input->post('HeaderFaktur1');
			$HeaderFaktur2 = $this->input->post('HeaderFaktur2');
			$SODepositStandard = $this->input->post('SODepositStandard'); 
			$SODepositCustom = $this->input->post('SODepositCustom'); 
			$SODepositProject = $this->input->post('SODepositProject'); 
			$SOShipDate 	= $this->input->post('SOShipDate'); 
			$SODPDeviation 	= $this->input->post('SODPDeviation'); 
			$INVLatePayment = $this->input->post('INVLatePayment'); 
			$StockMin = $this->input->post('StockMin'); 
			$StockMax = $this->input->post('StockMax'); 
			$SlowMovingMply = $this->input->post('SlowMovingMply'); 
			$PV = $this->input->post('PV'); 
			$MPfee = $this->input->post('MPfee'); 
			$customerPV = $this->input->post('customerPV');
			$SEPV = $this->input->post('SEPV');

			$data = array(
				'ReportPaging' => $ReportPaging,
				'ReportPagingDefault' => $ReportPagingDefault,
				'ReportResult' => $ReportResult,
				'CustomerCreditLimit' => $CustomerCreditLimit,
				'CustomerPaymentTerm' => $CustomerPaymentTerm,

				'TitleMenuMini' => $TitleMenuMini,
				'TitleMenuFull' => $TitleMenuFull,
				'MainTitle' => $MainTitle,
				'MainWarning' => $MainWarning,
				'MainInfo' => $MainInfo,
				'SODepositCustom' => $SODepositCustom,
				'SODepositStandard' => $SODepositStandard,
				'SODepositProject' => $SODepositProject,
				'SOShipDate' => $SOShipDate,
				'SODPDeviation' => $SODPDeviation,
				'INVLatePayment' => $INVLatePayment,
				'StockMin' => $StockMin,
				'StockMax' => $StockMax,
				'SlowMovingMply' => $SlowMovingMply,
				'PV' => $PV,
				'CustomerPVMultiplier' => $customerPV,
				'SEPVMultiplier' => $SEPV,
				'MPfee' => $MPfee,
			);

			$opts=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);  
			$Faktur1 = fopen('tool/HeaderFaktur1.txt', "w", false, stream_context_create($opts)) or die("Unable to open file!");
			$txt = $HeaderFaktur1;
			fwrite($Faktur1, $txt);
			fclose($Faktur1);

			$Faktur2 = fopen('tool/HeaderFaktur2.txt', "w", false, stream_context_create($opts)) or die("Unable to open file!");
			$txt = $HeaderFaktur2;
			fwrite($Faktur2, $txt);
			fclose($Faktur2);

			$this->db->where('id', '1');
			$this->db->update('tb_site_config', $data);
			$this->last_query .= "//".$this->db->last_query();

	        if ( $_FILES['logo_big']['name'] != "" ) {  //copy file ke server
	            $target_dir = "tool/";
				$extension = pathinfo($_FILES['logo_big']['name'], PATHINFO_EXTENSION);
	            $target_file = $target_dir . "logo_big.".$extension;
	            if (move_uploaded_file($_FILES["logo_big"]["tmp_name"], $target_file)) {
					$opts=array(
					    "ssl"=>array(
					        "verify_peer"=>false,
					        "verify_peer_name"=>false,
					    ),
					);  
					$logo = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
	            }
	        }

	        if ( $_FILES['logo_small']['name'] != "" ) {  //copy file ke server
	            $target_dir = "tool/";
				$extension = pathinfo($_FILES['logo_small']['name'], PATHINFO_EXTENSION);
	            $target_file = $target_dir . "logo_small.".$extension;
	            if (move_uploaded_file($_FILES["logo_small"]["tmp_name"], $target_file)) {
					$opts=array(
					    "ssl"=>array(
					        "verify_peer"=>false,
					        "verify_peer_name"=>false,
					    ),
					);
					$logo = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
	            }
	        }

		} elseif ($val == "approval") {
			$Actor1 = $this->input->post('approval_cc1');
			$Actor2 = $this->input->post('approval_cc2');
			$Actor3 = $this->input->post('approval_cc3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'customer_category');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('approval_so1');
			$Actor2 = $this->input->post('approval_so2');
			$Actor3 = $this->input->post('approval_so3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'approve_so');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('stock_adjustment1');
			$Actor2 = $this->input->post('stock_adjustment2');
			$Actor3 = $this->input->post('stock_adjustment3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'stock_adjustment');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();
			
			$Actor1 = $this->input->post('mutation_product1');
			$Actor2 = $this->input->post('mutation_product2');
			$Actor3 = $this->input->post('mutation_product3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'mutation_product');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('dor_invr1');
			$Actor2 = $this->input->post('dor_invr2');
			$Actor3 = $this->input->post('dor_invr3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'dor_invr');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();
			
			$Actor1 = $this->input->post('product_price_list1');
			$Actor2 = $this->input->post('product_price_list2');
			$Actor3 = $this->input->post('product_price_list3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'product_price_list');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('price_recommendation1');
			$Actor2 = $this->input->post('price_recommendation2');
			$Actor3 = $this->input->post('price_recommendation3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'price_recommendation');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('product_promo_volume1');
			$Actor2 = $this->input->post('product_promo_volume2');
			$Actor3 = $this->input->post('product_promo_volume3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'product_promo_volume');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();
			
			$Actor1 = $this->input->post('purchase_order1');
			$Actor2 = $this->input->post('purchase_order2');
			$Actor3 = $this->input->post('purchase_order3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'purchase_order');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();
			
			$Actor1 = $this->input->post('purchase_order_expired1');
			$Actor2 = $this->input->post('purchase_order_expired2');
			$Actor3 = $this->input->post('purchase_order_expired3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'purchase_order_expired');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('marketing_activity1');
			$Actor2 = $this->input->post('marketing_activity2');
			$Actor3 = $this->input->post('marketing_activity3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'marketing_activity');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('so_complaint1');
			$Actor2 = $this->input->post('so_complaint2');
			$Actor3 = $this->input->post('so_complaint3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'so_complaint');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

			$Actor1 = $this->input->post('employee_overtime1');
			$Actor2 = $this->input->post('employee_overtime2');
			$Actor3 = $this->input->post('employee_overtime3');
			$data = array(
				'Actor1' => $Actor1,
				'Actor2' => $Actor2,
				'Actor3' => $Actor3
			);
			$this->db->where('ApprovalCode', 'employee_overtime');
			$this->db->update('tb_approval_actor', $data);
			$this->last_query .= "//".$this->db->last_query();

		}
	    $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function approval_list()
	{
		$sql 	= "select * from tb_approval_actor";
		$query2 = $this->db->query($sql);
		foreach ($query2->result() as $row2) {
			if ($row2->ApprovalCode == "customer_category") {
				$show['approval_cc'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "approve_so") {
				$show['approval_so'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "dor_invr") {
				$show['dor_invr'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "stock_adjustment") {
				$show['stock_adjustment'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "mutation_product") {
				$show['mutation_product'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "product_price_list") {
				$show['product_price_list'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "price_recommendation") {
				$show['price_recommendation'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "product_promo_volume") {
				$show['product_promo_volume'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "purchase_order") {
				$show['purchase_order'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "purchase_order_expired") {
				$show['purchase_order_expired'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "marketing_activity") {
				$show['marketing_activity'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "so_complaint") {
				$show['so_complaint'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
			if ($row2->ApprovalCode == "employee_overtime") {
				$show['employee_overtime'] = array(
					'ApprovalNote' => $row2->ApprovalNote,
					'Actor1' => $row2->Actor1,
					'Actor2' => $row2->Actor2,
					'Actor3' => $row2->Actor3
				);
			}
		};
	    $this->log_user->log_query($this->last_query);
	    return $show;
	}

// manage user =====================================================================
	function user_account_list()
	{
		$sql 	= "select ua.*, if(ua.EmployeeID=0,'',ej.LevelName) as LevelName 
					from vw_user_account ua 
					left join vw_employee_job ej on (ua.EmployeeID = ej.EmployeeID) ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$status = $row->isActive=="1" ? "Active" : "NonActive" ;
		  	$show[] = array(
		  			'UserAccountID' => $row->UserAccountID,
		  			'fullname' => $row->fullname,
		  			'jobcode' => $row->LevelName,
		  			'username' => $row->Username,
		  			'Email' => $row->Email,
		  			'group' => $row->UsergroupID,
		  			'status' => $status,
		  			'ForceLogOut' => $row->ForceLogOut,
				);
		};
	    $this->log_user->log_query($this->last_query);
	    return $show;
	}
	function user_account_add()
	{
		$this->db->trans_start();

		$contactid 	= $this->input->post('contactid'); 
		$username 	= $this->input->post('username'); 
		$groupname 	= $this->input->post('groupname'); 
		$password	= explode(".", $username); 
		$fullgroupname = "";

		$sql 	= "select ContactID from vw_user_account where ContactID = ".$contactid;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (empty($row)) {
			$sql 	= "SELECT IF(ce.email = '', em.Email, ce.email) AS Email
						FROM vw_contact_email ce 
						LEFT JOIN tb_employee_main em ON ce.ContactID=em.ContactID
						WHERE ce.ContactID=".$contactid;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$Email 	= $row->Email;

			for ($i=0; $i < count($groupname);$i++) { //join untuk nama2 grup
	   			$fullgroupname .= ",".$groupname[$i];
	   		};

			$data = array(
		        'ContactID' => $contactid,
				'Username' => $username,
				'Email' => $Email,
				'Password' => md5($password[0].date("d").date("H").date("s")).sha1($password[0].date("d").date("H").date("s")),
				'UsergroupID' => substr($fullgroupname,1),
				'isActive' => "1"
			);
			$this->db->insert('tb_user_account', $data);
			$this->last_query .= "//".$this->db->last_query();


			$new = $password[0].date("d").date("H").date("s");
			$config = Array(
			    'protocol' => 'smtp',
			    'smtp_host' => 'smtp.angzdna.net',
			    'smtp_port' => 587,
			    'smtp_user' => 'bo.system.angzdna.net',
			    'smtp_pass' => 'systemboanghauz',
			    'mailtype'  => 'html', 
			    'charset'   => 'iso-8859-1'
			);
			$this->load->library('email', $config);

			$this->email->from('bo.system@angzdna.net', 'AnghauzBO System');
			$this->email->to($Email);
			$list = array('abdul.basith@angzdna.net', 'andhika.septiono@angzdna.net');
			$this->email->cc($list);
			$this->email->subject('New User Password');
			$this->email->message('New User Password for Account : '.$username.'.<br> Here The Password : '.$new);
			$this->email->send();
		}
		
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function user_account_edit()
	{
		$this->db->trans_start();

		$contactid 		= $this->input->post('contactid'); 
		$username 	= $this->input->post('username'); 
		$groupname 	= $this->input->post('groupname'); 
		$fullgroupname = "";
		$status 	= $this->input->post('status'); 

		for ($i=0; $i < count($groupname);$i++) { //join untuk nama2 grup
   			$fullgroupname .= ",".$groupname[$i];
   		};

		$data = array(
			'Username' => $username,
			'UsergroupID' => substr($fullgroupname,1),
			'isActive' => $status
		);
		$this->db->where('UserAccountID', $contactid);
		$this->db->update('tb_user_account', $data);
		$this->last_query .= "//".$this->db->last_query();

	    $this->log_user->log_query($this->last_query);
	    $this->last_query .= "//".$this->db->last_query();

	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function ForceLogOut_set()
	{
		$UserAccountID = $this->input->post('UserAccountID');
		$this->db->set('ForceLogOut', 1);
		$this->db->where('UserAccountID', $UserAccountID);
		$this->db->update('tb_user_account');
		echo json_encode("success");
	}
	function ForceLogOut_setAll()
	{
		$this->db->set('ForceLogOut', 1);
		$this->db->update('tb_user_account');
		echo json_encode("success");
	}

// manage group=====================================================================
	function group_list()
	{
		$show   = array();
		$sql = "select * from tb_menu_group ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['group'][] = array(
		  			'UsergroupID' => $row->UsergroupID,
		  			'UsergroupNama' => $row->UsergroupNama,
		  			'UsergroupMenu' => $row->UsergroupMenu
				);
		};
	  	$show['menu'] = $this->fill_menu_list();
	    $this->log_user->log_query($this->last_query);
	    return $show;
	}
	function group_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$menu 	= "";
		$postmenu = $this->input->post('menu');
		if (!empty($postmenu)) { //jika ada menu yg dicentang
			foreach ($this->input->post('menu') as $key => $value) {
				$menu .= ", ".$value; //join nama2 menu
			}
			$menu = substr($menu,2 );	
		} 
		$data = array(
	        'UsergroupNama'	=> $name,
			'UsergroupMenu' => $menu
		);
		$this->db->insert('tb_menu_group', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function group_edit()
	{
		$this->db->trans_start();

		$id = $this->input->post('id'); 
		$name = $this->input->post('name'); 
		$menu = "";
		$postmenu = $this->input->post('menu');
		if (!empty($postmenu)) { //jika ada menu yg dicentang
			foreach ($this->input->post('menu') as $key => $value) {
				$menu .= ", ".$value; //join nama2 menu	
			}
			$menu = substr($menu,2 );	
		} 
		$data = array(
	        'UsergroupNama'	=> $name,
			'UsergroupMenu' => $menu
		);
		$this->db->where('UsergroupID', $id);
		$this->db->update('tb_menu_group', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// manage personal menu=============================================================
	function user_menu()
	{
		$show   = array();
	  	$show['menu'] = $this->fill_menu_list();

		$sql 	= "select um.*, em.*, if(em.EmployeeID=0,'',ej.LevelName) as LevelName 
					from tb_menu_personal um 
					left join vw_user_account em on (um.UserAccountID = em.UserAccountID) 
					left join vw_employee_job ej on (em.EmployeeID = ej.EmployeeID) ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			if ($row->fullname != '') {
			  	$show['listmenu'][] = array(
			  			'UserAccountID' => $row->UserAccountID,
			  			'fullname' => $row->fullname,
			  			'jobcode' => $row->LevelName,
			  			'menu' => $row->MenuID
					);
		  	}
		};
	    $this->log_user->log_query($this->last_query);
	    return $show;
	}
	function user_menu_add()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$menu 	= "";
		$postmenu = $this->input->post('menu');
		if (!empty($postmenu)) {
			foreach ($this->input->post('menu') as $key => $value) {
				$menu .= ", ".$value;	
			}
			$menu = substr($menu,2 );	
		} 
		$data = array(
	        'UserAccountID'	=> $id,
			'MenuID' => $menu
		);
		$this->db->insert('tb_menu_personal', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function user_menu_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$menu 	= "";
		$postmenu = $this->input->post('menu');
		if (!empty($postmenu)) {
			foreach ($this->input->post('menu') as $key => $value) {
				$menu .= ", ".$value;	
			}
			$menu = substr($menu, 2);	
		} 
		$data = array(
			'MenuID' => $menu
		);
		$this->db->where('UserAccountID', $id);
		$this->db->update('tb_menu_personal', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	
// manage menu =====================================================================
	function user_manage_menu()
	{
	  	$show = $this->fill_menu_list();
	    $this->log_user->log_query($this->last_query);
	    return $show;
	}
	function menu_add()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$note   = $this->input->post('note'); 
		$name 	= $this->input->post('name'); 
		$parent	= $this->input->post('parent'); 
		$data = array(
	        'MenuID'	=> $id,
			'MenuName' => $name,
			'MenuNote' => $note,
			'MenuParent' => $parent
		);
		$this->db->insert('tb_menu_list', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	}
	function menu_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$name 	= $this->input->post('name');
		$note   = $this->input->post('note');
		// $location 	= $this->input->post('location'); 
		$data = array(
			'MenuName' => $name,
			'MenuNote' => $note,
			// 'MenuLocation' => $location
		);
		$this->db->where('MenuID', $id);
		$this->db->update('tb_menu_list', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function fill_menu_list($parent=0, $menu_tree_array = array())
	{
		$sql 	= "select * from tb_menu_list where MenuParent='".$parent."' ORDER by MenuID+0";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$menu_tree_array[$row->MenuID] = array(
		  			'MenuID' => $row->MenuID,
		  			'MenuName' => $row->MenuName,
		  			'MenuNote' => $row->MenuNote,
		  			'MenuLocation' => $row->MenuLocation,
		  			'MenuParent' => $row->MenuParent
				);
		      	$menu_tree_array = $this->fill_menu_list($row->MenuID, $menu_tree_array);
			};
		}
		return $menu_tree_array;
	}

// =================================================================================
	function fill_groupname()
	{
		$sql = "select * from tb_menu_group ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'UsergroupID' => $row->UsergroupID,
				'UsergroupNama' => $row->UsergroupNama
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_employee_user_account_list()
	{
		$sql = "SELECT EmployeeID, ContactID, fullname FROM vw_employee3 where EmployeeID not in (select EmployeeID from tb_user_account) ORDER BY fullname ASC";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'EmployeeID' => $row->EmployeeID,
				'ContactID' => $row->ContactID,
				'EmployeeName' => $row->fullname,
				'Fullname' => $row->fullname
			);
		};
		if ($this->input->is_ajax_request()) {
			$this->log_user->log_query($this->last_query);
			echo json_encode($show);
		} else {
			$this->log_user->log_query($this->last_query);
			return $show;
		}
	}
	function fill_employee_user_account_list2()
	{
    	$EmployeeID  = $this->input->get_post('EmployeeID');	
		$sql = "SELECT vem.*, jl.LevelCode, jl.LevelName
				FROM vw_employee2 vem 
				LEFT JOIN (SELECT EmployeeID, GROUP_CONCAT(jl.LevelName SEPARATOR ',') as LevelName, GROUP_CONCAT(jl.LevelCode SEPARATOR ',') as LevelCode 
				FROM tb_job_level jl GROUP BY EmployeeID) jl ON (vem.EmployeeID = jl.EmployeeID) where vem.EmployeeID=".$EmployeeID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$username = $row->NameFirst;
			$username .= (is_null($row->NameLast)) ? '' : '.'.$row->NameLast;
			$show[] = array(
				'EmployeeID' => $row->EmployeeID,
				'LevelCode' => $row->LevelCode,
				'username' => strtolower($username)
			);
		};
		if ($this->input->is_ajax_request()) {
			$this->log_user->log_query($this->last_query);
			echo json_encode($show);
		} else {
			$this->log_user->log_query($this->last_query);
			return $show;
		}
	}
	function fill_user_personal_menu()
	{
		$sql = "SELECT UserAccountID, ContactID, fullname 
				FROM vw_user_account 
				where UserAccountID not in (select UserAccountID from tb_menu_personal) and isActive=1 ORDER BY fullname ASC";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'UserAccountID' => $row->UserAccountID,
				'ContactID' => $row->ContactID,
				'Fullname' => $row->fullname
			);
		};
		if ($this->input->is_ajax_request()) {
			$this->log_user->log_query($this->last_query);
			echo json_encode($show);
		} else {
			$this->log_user->log_query($this->last_query);
			return $show;
		}
	}
}
?>