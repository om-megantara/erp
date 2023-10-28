<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_mkt extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
		date_default_timezone_set("Asia/Jakarta");
    }

// marketing_activity=====================================================================
	function marketing_activity()
	{
		$show   = array();
		$show['info_filter'] = "";
		$ActivityDate = $this->input->get_post('filterstart');
		$ActivityDate2= $this->input->get_post('filterend');

		if ($ActivityDate && $ActivityDate2 != "") {
			$ActivityDate = date_create($this->input->get_post('filterstart'));
			$ActivityDate2 = date_create($this->input->get_post('filterend'));
			$ActivityDate = date_format($ActivityDate, "Y-m-d");
			$ActivityDate2 = date_format($ActivityDate2, "Y-m-t");

			$sqlINVDate = "AND (ma.ActivityDate between '".$ActivityDate."' AND '".$ActivityDate2."') ";
		} else { 
			
			$sqlINVDate = "and MONTH(ActivityDate)=MONTH(CURRENT_DATE()) AND YEAR(ActivityDate)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT ma.*, cm.Company2 as customer, em.Company2 as sales, CityName  
				FROM tb_marketing_activity ma 
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=ma.SalesID) 
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID=ma.ActivityReffNo) 
				WHERE ma.ActivityReffType='customer' ".$sqlINVDate;

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("marketing_activity_linked", $MenuList)) {
        	$this->load->model('model_report');
			$SalesID = $this->model_report->get_sales_child($SalesID);
			$sql .= "and ma.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("marketing_activity_all", $MenuList)) {
			$sql .= "and ma.SalesID<>'' ";
		}
			$sql .= "order by ActivityID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function marketing_activity_add()
	{
		$CustomerID = $this->input->get_post('CustomerID'); 
		$sql 	= "SELECT * FROM vw_customer2 where CustomerID=".$CustomerID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0]; 
	    return $show;
	}
	function marketing_activity_add_act()
	{
		$this->db->trans_start();

		$CustomerID = $this->input->get_post('customer'); 
		$ActivityDate = $this->input->get_post('date');
		$ActivityType = $this->input->get_post('type');
		$ActivityLink = $this->input->get_post('link');
		$ActivityNote = $this->input->get_post('note');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'SalesID' => $this->session->userdata('SalesID'),
					'ActivityType' => $ActivityType,
					'ActivityDate' => $ActivityDate,
					'ActivityReffType' => 'customer',
					'ActivityReffNo' => $CustomerID,
					'ActivityLink' => $ActivityLink,
					'ActivityNote' => $ActivityNote,
					'InputDate' => $datetime, 
				);
		$this->db->insert('tb_marketing_activity', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(ActivityID) as ActivityID from tb_marketing_activity ";
		$getActivityID 	= $this->db->query($sql);
		$row 		= $getActivityID->row();
		$ActivityID = $row->ActivityID;

   		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='marketing_activity' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		if ($Actor3 != 0) {
			$data_approval = array(
		        'ActivityID' => $ActivityID,
	        	'isComplete' => "0",
	        	'Status' => "OnProgress",
			);
			$this->db->insert('tb_approval_marketing_activity', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
		        'ActivityID' => $ActivityID,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
			);
			$this->db->insert('tb_approval_marketing_activity', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	} 
	function marketing_activity_edit()
	{
		$ActivityID = $this->input->get_post('ActivityID'); 
		$sql 	= "SELECT tma.ActivityID, vc3.Company2 as Customer, tma.ActivityReffNo, tma.ActivityDate, ActivityType , tma.ActivityLink, tma.ActivityNote
					FROM tb_marketing_activity tma 
					LEFT JOIN vw_customer3 vc3 ON tma.ActivityReffNo=vc3.CustomerID 
					WHERE ActivityID=".$ActivityID;
					// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0]; 

	    return $show;
	}
	function marketing_activity_edit_act()
	{
		$this->db->trans_start();

		$ActivityID = $this->input->get_post('ActivityID');
		$CustomerID = $this->input->get_post('customerid'); 
		$ActivityDate = $this->input->get_post('date');
		$ActivityType = $this->input->get_post('type');
		$ActivityLink = $this->input->get_post('link');
		$ActivityNote = $this->input->get_post('note');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'SalesID' => $this->session->userdata('SalesID'),
					'ActivityType' => $ActivityType,
					'ActivityReffNo' => $CustomerID,
					'ActivityLink' => $ActivityLink,
					'ActivityNote' => $ActivityNote,
				);
		$this->db->where('ActivityID', $ActivityID);
		$this->db->update('tb_marketing_activity', $data);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	} 
	function marketing_activity_delete()
	{
		$this->db->trans_start();

		$ActivityID = $this->input->get_post('ActivityID'); 

		$this->db->where('ActivityID', $ActivityID);
		$this->db->delete('tb_marketing_activity');
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('ActivityID', $ActivityID);
		$this->db->delete('tb_approval_marketing_activity');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_category()
	{
		$show   = array();
		$show['info_filter'] = "";
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');

		if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sqlDate = "(Date between '".$Date."' AND '".$Date2."') ";
		} else { 
			
			$sqlDate = "MONTH(Date)=MONTH(CURRENT_DATE()) AND YEAR(Date)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT * FROM tb_marketing_activity_category WHERE ".$sqlDate;

		$sql .= " AND Status=1 order by ID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function marketing_activity_category_add_act()
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Category = $this->input->get_post('Category'); 
		$CFU = $this->input->get_post('CFU');
		$CV = $this->input->get_post('CV');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
			'Date' => $date,
			'FeeCategory' => $Category,
			'Date' => $date,
			'FeeCFU' => $CFU,
			'FeeCV' => $CV,
			'Status' => '1',
			'EmployeeID' => $EmployeeID, 
		);
		$this->db->insert('tb_marketing_activity_category', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_category_edit()
	{
		$show   = array();
		$ID = $this->input->get_post('ID'); 

		$sql = "SELECT * FROM tb_marketing_activity_category WHERE ID=".$ID;

		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];
	    return $show;
	}
	function marketing_activity_category_edit_act()
	{
		$this->db->trans_start();
		$ID = $this->input->get_post('ID'); 
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Category = $this->input->get_post('Category'); 
		$CFU = $this->input->get_post('CFU');
		$CV = $this->input->get_post('CV');
		$Status = $this->input->get_post('status'); 
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
			'FeeCategory' => $Category,
			'Date' => $date,
			'FeeCFU' => $CFU,
			'FeeCV' => $CV,
			'Status' => $Status,
			'EmployeeID' => $EmployeeID, 
		);
		$this->db->where('ID', $ID);
		$this->db->update('tb_marketing_activity_category', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_category_delete()
	{
		$this->db->trans_start();

		$ID = $this->input->get_post('ID'); 

		$this->db->set('Status', '0');
		$this->db->where('ID', $ID);
		$this->db->update('tb_marketing_activity_category');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_bonus()
	{
		$show   = array();
		$show['info_filter'] = "";
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');

		if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sqlDate = "(tmb.Date between '".$Date."' AND '".$Date2."') ";
		} else { 
			
			$sqlDate = "MONTH(tmb.Date)=MONTH(CURRENT_DATE()) AND YEAR(tmb.Date)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT tmb.*, tmc.FeeCategory FROM tb_marketing_activity_bonus tmb
				LEFT JOIN tb_marketing_activity_category tmc ON tmb.CategoryID=tmc.ID
				WHERE ".$sqlDate;

		$sql .= " AND tmb.Status=1 ORDER by tmb.BonusID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function marketing_activity_bonus_add()
	{
		$show   = array();

		$sql = "SELECT ID, FeeCategory FROM tb_marketing_activity_category";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['Category'][] = array(
				'ID' => $row->ID,
				'FeeCategory' => $row->FeeCategory,
			);
		};
	    return $show;
	}
	function marketing_activity_bonus_add_act()
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$BonusID = $this->input->get_post('BonusID');
		$Category = $this->input->get_post('Category');
		$Bonus = $this->input->get_post('Bonus');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		if ($Category==0){
			$sql = "SELECT ID, FeeCFU, FeeCV FROM tb_marketing_activity_category";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$CFU=$row->FeeCFU;
				$CV=$row->FeeCV;
				$CFUUp=$CFU*$Bonus/100;
				$CVUp=$CV*$Bonus/100;
				$show['Category'][] = array(
					'ID' => $row->ID,
					'FeeCFU' => $row->FeeCFU,
					'FeeCV' => $row->FeeCV,
				);
				$databonus = array(
						'Date' => $date,
						'CategoryID' => $row->ID,
						'Bonus' => $Bonus,
						'CFUUp' => $CFUUp,
						'CVUp' => $CVUp,
						'Status' => '1',
						'EmployeeID' => $EmployeeID,
					);
				$this->db->insert('tb_marketing_activity_bonus', $databonus);
				$this->last_query .= "//".$this->db->last_query();	
			};
		} else {
			$sql2 = "SELECT ID, FeeCFU, FeeCV FROM tb_marketing_activity_category WHERE ID=".$Category;
			// echo $sql2;
			$getID 	= $this->db->query($sql2);
			$row 	= $getID->row();
			$CFU    = $row->FeeCFU;
			$CV     = $row->FeeCV;
			$CFUUp  = $CFU*$Bonus/100;
			$CVUp   = $CV*$Bonus/100;
			$data = array(
				'Date' => $date,
				'CategoryID' => $row->ID,
				'Bonus' => $Bonus,
				'CFUUp' => $CFUUp,
				'CVUp' => $CVUp,
				'Status' => '1',
				'EmployeeID' => $EmployeeID, 
			);
			$this->db->insert('tb_marketing_activity_bonus', $data);
			$this->last_query .= "//".$this->db->last_query();
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_bonus_edit()
	{
		$show   = array();
		$ID = $this->input->get_post('ID'); 

		$sql = "SELECT * FROM tb_marketing_activity_bonus tmb
				LEFT JOIN tb_marketing_activity_category tmc ON tmb.CategoryID=tmc.ID
				WHERE BonusID=".$ID;

		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];
	    return $show;
	}
	function marketing_activity_bonus_edit_act()
	{
		$this->db->trans_start();
		$ID = $this->input->get_post('ID'); 
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Category = $this->input->get_post('Category'); 
		$Bonus = $this->input->get_post('Bonus');
		$Status = $this->input->get_post('status'); 
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$sql2 = "SELECT ID, FeeCFU, FeeCV FROM tb_marketing_activity_category WHERE ID=".$ID;
		// echo $sql2;
		$getID 	= $this->db->query($sql2);
		$row 	= $getID->row();
		$CFU    = $row->FeeCFU;
		$CV     = $row->FeeCV;
		$CFUUp  = $CFU*$Bonus/100;
		$CVUp   = $CV*$Bonus/100;

		$data = array(
			'Date' => $date,
			'Bonus' => $Bonus,
			'CFUUp' => $CFUUp,
			'CVUp' => $CVUp,
			'Status' => $Status,
			'EmployeeID' => $EmployeeID, 
		);
		$this->db->where('BonusID', $ID);
		$this->db->update('tb_marketing_activity_bonus', $data);
		$this->last_query .= "//".$this->db->last_query();
		// echo ($this->last_query);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_bonus_delete()
	{
		$this->db->trans_start();

		$ID = $this->input->get_post('ID');

		$this->db->set('Status', '0');
		$this->db->where('BonusID', $ID);
		$this->db->update('tb_marketing_activity_bonus');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_category_fee()
	{
		$show   = array();
		$show['info_filter'] = "";
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');

		if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sqlDate = "(tmb.Date between '".$Date."' AND '".$Date2."') ";
		} else { 
			
			$sqlDate = "MONTH(tmb.Date)=MONTH(CURRENT_DATE()) AND YEAR(tmb.Date)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT tmb.*, tmc.FeeCategory FROM tb_marketing_activity_bonus tmb
				LEFT JOIN tb_marketing_activity_category tmc ON tmb.CategoryID=tmc.ID
				WHERE ".$sqlDate;

		$sql .= " AND tmb.Status=1 ORDER by tmb.BonusID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function marketing_activity_category_fee_add()
	{
		$show   = array();

		$sql = "SELECT ID, FeeCategory FROM tb_marketing_activity_category";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['Category'][] = array(
				'ID' => $row->ID,
				'FeeCategory' => $row->FeeCategory,
			);
		};
	    return $show;
	}
	function marketing_activity_category_fee_add_act()
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$BonusID = $this->input->get_post('BonusID');
		$Category = $this->input->get_post('Category');
		$Bonus = $this->input->get_post('Bonus');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		if ($Category==0){
			$sql = "SELECT ID, FeeCFU, FeeCV FROM tb_marketing_activity_category";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$CFU=$row->FeeCFU;
				$CV=$row->FeeCV;
				$CFUUp=$CFU*$Bonus/100;
				$CVUp=$CV*$Bonus/100;
				$show['Category'][] = array(
					'ID' => $row->ID,
					'FeeCFU' => $row->FeeCFU,
					'FeeCV' => $row->FeeCV,
				);
				$databonus = array(
						'Date' => $date,
						'CategoryID' => $row->ID,
						'Bonus' => $Bonus,
						'CFUUp' => $CFUUp,
						'CVUp' => $CVUp,
						'Status' => '1',
						'EmployeeID' => $EmployeeID,
					);
				$this->db->insert('tb_marketing_activity_bonus', $databonus);
				$this->last_query .= "//".$this->db->last_query();	
			};
		} else {
			$sql2 = "SELECT ID, FeeCFU, FeeCV FROM tb_marketing_activity_category WHERE ID=".$Category;
			// echo $sql2;
			$getID 	= $this->db->query($sql2);
			$row 	= $getID->row();
			$CFU    = $row->FeeCFU;
			$CV     = $row->FeeCV;
			$CFUUp  = $CFU*$Bonus/100;
			$CVUp   = $CV*$Bonus/100;
			$data = array(
				'Date' => $date,
				'CategoryID' => $row->ID,
				'Bonus' => $Bonus,
				'CFUUp' => $CFUUp,
				'CVUp' => $CVUp,
				'Status' => '1',
				'EmployeeID' => $EmployeeID, 
			);
			$this->db->insert('tb_marketing_activity_bonus', $data);
			$this->last_query .= "//".$this->db->last_query();
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_category_fee_edit()
	{
		$show   = array();
		$ID = $this->input->get_post('ID'); 

		$sql = "SELECT * FROM tb_marketing_activity_bonus tmb
				LEFT JOIN tb_marketing_activity_category tmc ON tmb.CategoryID=tmc.ID
				WHERE BonusID=".$ID;

		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];
	    return $show;
	}
	function marketing_activity_category_fee_edit_act()
	{
		$this->db->trans_start();
		$ID = $this->input->get_post('ID'); 
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Category = $this->input->get_post('Category'); 
		$Bonus = $this->input->get_post('Bonus');
		$Status = $this->input->get_post('status'); 
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$sql2 = "SELECT ID, FeeCFU, FeeCV FROM tb_marketing_activity_category WHERE ID=".$ID;
		// echo $sql2;
		$getID 	= $this->db->query($sql2);
		$row 	= $getID->row();
		$CFU    = $row->FeeCFU;
		$CV     = $row->FeeCV;
		$CFUUp  = $CFU*$Bonus/100;
		$CVUp   = $CV*$Bonus/100;

		$data = array(
			'Date' => $date,
			'Bonus' => $Bonus,
			'CFUUp' => $CFUUp,
			'CVUp' => $CVUp,
			'Status' => $Status,
			'EmployeeID' => $EmployeeID, 
		);
		$this->db->where('BonusID', $ID);
		$this->db->update('tb_marketing_activity_bonus', $data);
		$this->last_query .= "//".$this->db->last_query();
		// echo ($this->last_query);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function marketing_activity_category_fee_delete()
	{
		$this->db->trans_start();

		$ID = $this->input->get_post('ID');

		$this->db->set('Status', '0');
		$this->db->where('BonusID', $ID);
		$this->db->update('tb_marketing_activity_bonus');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

	// manage city ======================================================================
	function manage_city()
	{
		$sql 	= "SELECT ac.*, ap.ProvinceName, ast.StateName, se.Company2 AS SEC, se2.Company2 AS Sales
					FROM vw_city ac 
					LEFT JOIN tb_address_province ap ON (ac.ProvinceID = ap.ProvinceID) 
					LEFT JOIN tb_address_state ast ON (ap.StateID = ast.StateID)
					LEFT JOIN tb_region_main rm ON rm.RegionID=ac.RegionID
					LEFT JOIN vw_sales_executive2 se ON rm.SEC=se.SalesID
					LEFT JOIN vw_sales_executive2 se2 ON ac.SalesID=se2.SalesID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'CityID' => $row->CityID,
		  			'CityName' => $row->CityName,
		  			'ProvinceName' => $row->ProvinceName,
		  			'StateName' => $row->StateName,
		  			'SEC' => $row->SEC,
		  			'Sales' => $row->Sales,
		  			'TargetOmzet' => $row->TargetOmzet,
		  			'TargetCustomer' => $row->TargetCustomer,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function city_detail()
    {
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
			$sql 	= "SELECT * from vw_city where CityID =".$_REQUEST['id'];
			$query 	= $this->db->query($sql);
			$show   = json_decode( json_encode($query->result()), true);
			// foreach ($query->result() as $row) {
			//   	$show = array(
			// 		'CityID' => $row->CityID,
			// 		'CityName' => $row->CityName,
			// 		'CityAbbreviation' => $row->CityAbbreviation,
			// 		'ExpeditionID' => $row->ExpeditionID,
			// 		'FCPrice' => $row->FCPrice,
			// 		'FCWeight' => $row->FCWeight,
			// 	);
			// };
		}
	    return $show[0];
		$this->log_user->log_query($this->last_query);
	}
	function manage_city_cu_act()
	{
		$this->db->trans_start();

		$CityID 		= $this->input->post('cityid');
		$CityName 		= $this->input->post('cityname');
		$CityAbbreviation = $this->input->post('cityabbreviation');
		$Population		= $this->input->post('Population');
		$SalesID		= $this->input->post('sales');
		$TargetOmzet= $this->input->post('Omzet');
		$TargetCustomer	= $this->input->post('Retailer');

		$data = array(
	        // 'CityName' => $CityName,
	        // 'CityAbbreviation' => $CityAbbreviation,
	        'SalesID' => $SalesID,
	        'Population' => $Population,
	        'TargetOmzet' => $TargetOmzet,
	        'TargetCustomer' => $TargetCustomer,
		);
		$this->db->where('CityID', $CityID);
		$this->db->update('tb_mkt_city', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	// Online Order ======================================================================

	function online_order()
	{
		$show   = array();
		$show['info_filter'] = "";
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');

		if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sqlDate = " WHERE (olo.DateOLO between '".$Date."' AND '".$Date2."') ";
		} else { 
			
			$sqlDate = " WHERE olo.Status='0' AND MONTH(olo.DateOLO)=MONTH(CURRENT_DATE()) AND YEAR(olo.DateOLO)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT OLOID, InvoiceMP, Customer, DateINV, DateOLO, File, olo.ShopID, shm.ShopName, shm.CodeShop, shm.CodeMP, olo.Note, olo.Status
				FROM tb_online_order olo
				LEFT JOIN tb_shop_main shm ON (olo.ShopID=shm.ShopID) 
				".$sqlDate;

		$sql .= " AND Status!=2 order by olo.OLOID asc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function online_order_add()
	{
		$sql 	= "SELECT * FROM tb_shop_main ";
		$query 	= $this->db->query($sql);
		$show   = array(); 
		foreach ($query->result() as $row) {
		  	$show['shop'][] = array(
		  			'ShopID' => $row->ShopID,
		  			'ShopName' => $row->ShopName,
				);
		};

	    return $show;
	}
	function online_order_add_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);

		$ShopID = $this->input->get_post('toko');
		$File = $this->input->get_post('cv');
		$Customer = $this->input->get_post('customer');
		$InvoiceMP = $this->input->get_post('inv');
		$DateINV = $this->input->get_post('date');
		$Note = $this->input->get_post('note');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;

		if ($_FILES['cv']['name'] != "" && $_FILES['cv']['size'] < $limit) {  //copy file ke server
			$filesnames = $_FILES['cv']['name'];
            $target_dir = "assets/PDFOLO/";
            $target_file = $target_dir . $filesnames;
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
				$cv = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
				$data_file['File'] = $cv;
            }
        }

		$data = array(
			'InvoiceMP' => $InvoiceMP,
			'Customer' => $Customer,
			'DateINV' => $DateINV,
			'DateOLO' => $datetime,
			'File' => $filesnames,
			'ShopID' => $ShopID,
			'Note' => $Note,
			'InsertBy' => $this->session->userdata('UserAccountID'),
			'Status' => '0',
		);
		// array_map('unlink', glob("assets/PDF/*"));
		$this->db->insert('tb_online_order', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function online_order_edit()
	{
		$show   = array();
		$OLOID = $this->input->get_post('OLOID');

		$sql 	= "SELECT * FROM tb_shop_main ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['shop'][] = array(
				'ShopID' => $row->ShopID,
				'ShopName' => $row->ShopName,
			);
		};
		$sql2 = "SELECT * FROM tb_online_order olo
				LEFT JOIN tb_shop_main shm ON shm.ShopID=olo.ShopID
				WHERE olo.OLOID=".$OLOID;
		// echo $sql2;
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
			$show[] = array(
					'OLOID' => $row->OLOID,
					'InvoiceMP' => $row->InvoiceMP,
					'Customer' => $row->Customer,
					'DateINV' => $row->DateINV,
					'DateOLO' => $row->DateOLO,
					'ShopID' => $row->ShopID,
					'ShopName' => $row->ShopName,
					'CodeShop' => $row->CodeShop,
					'CodeMP' => $row->CodeMP,
					'Note' => $row->Note,
					'File' => $row->File,
				);
		};
	    return $show;
	}
	function online_order_edit_act()
	{
		$this->db->trans_start();

		$OLOID = $this->input->get_post('oloid');
		$ShopID = $this->input->get_post('toko');
		$Customer = $this->input->get_post('customer');
		$InvoiceMP = $this->input->get_post('inv');
		$DateINV = $this->input->get_post('date');
		$Note = $this->input->get_post('note');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
			'InvoiceMP' => $InvoiceMP,
			'Customer' => $Customer,
			'DateINV' => $DateINV,
			'ShopID' => $ShopID,
			'Note' => $Note,
		);
		$this->db->where('OLOID', $OLOID);
		$this->db->update('tb_online_order', $data);
		$this->last_query .= "//".$this->db->last_query();
		// echo ($this->last_query);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function online_order_approve_act()
	{
		$this->db->trans_start();
		$OLOID = $this->input->get_post('OLOID');
		$UserAccountID =$this->session->userdata('UserAccountID');

		$this->db->set('Status', '1');
		$this->db->set('ApproveBy', $UserAccountID);
		$this->db->where('OLOID', $OLOID);
		$this->db->update('tb_online_order');
		$this->last_query .= "//".$this->db->last_query();
		// echo ($this->last_query);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function online_order_delete_act()
	{
		$this->db->trans_start();
		$OLOID = $this->input->get_post('OLOID');
		$UserAccountID =$this->session->userdata('UserAccountID');

		$this->db->set('Status', '2');
		$this->db->set('ApproveBy', $UserAccountID);
		$this->db->where('OLOID', $OLOID);
		$this->db->update('tb_online_order');
		$this->last_query .= "//".$this->db->last_query();
		// echo ($this->last_query);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	// ========================================================
	function search_customer_having_sales()
	{
		$q = $this->input->get('q');
		if (strlen($q) > 3) {
			$sql = "SELECT c2.CustomerID, c2.Company FROM vw_customer2 c2 
					RIGHT JOIN( SELECT CustomerID FROM tb_customer_detail WHERE DetailType='sales' AND DetailValue=".$this->session->userdata('UserAccountID').") cd ON (c2.CustomerID=cd.CustomerID)
					WHERE c2.Company LIKE '%".$q."%'";
			$hasil = $this->db->query ($sql);
			$data = array();
	        if ($hasil->num_rows()){ 
	            foreach ($hasil->result() as $row) {
	                $data[] = array(
	                    'text' => $row->Company,
	                    'id' => $row->CustomerID
	                    ); 
	            }
	        }
   	 		echo json_encode($data);
		}      
	}

	// compress image==============================================
	function compress($source, $destination, $quality) {

	    $info = getimagesize($source);

	    if ($info['mime'] == 'image/jpeg') 
	        $image = imagecreatefromjpeg($source);

	    elseif ($info['mime'] == 'image/gif') 
	        $image = imagecreatefromgif($source);

	    elseif ($info['mime'] == 'image/png') 
	        $image = imagecreatefrompng($source);

	    imagejpeg($image, $destination, $quality);

	    return $destination;
	}

	// $source_img = 'source.jpg';
	// $destination_img = 'destination .jpg';
	// $d = compress($source_img, $destination_img, 90);

	function do_upload() 
	{
		$config['upload_path']          = './assets/PDF/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 100000;

        $this->load->library('upload', $config);

        if ( $this->upload->do_upload('userfile')) {
        	return $this->upload->data();
            // $data = array('upload_data' => $this->upload->data());
        } 
	}
}

?>