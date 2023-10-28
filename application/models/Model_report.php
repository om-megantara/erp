<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_report extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }

// bonus===================================================================
	function pv_by_inv()
	{
		$show = array();
		$show['inv'] = 0;
		$show['omzet'] = 0;
		$show['pv'] = 0;
		$show['penalty'] = 0;
		$show['total'] = 0;
		$show['info_filter'] = "";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql 	= "SELECT ibf.*, em.Company2 as fullname FROM vw_invoice_bonus_final2 ibf
					LEFT JOIN vw_sales_executive2 em ON (ibf.SalesID=em.SalesID)";

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( ibf.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ibf.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "where ibf.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "where ibf.SalesID<>'' ";
		}

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && $_REQUEST['datestart'] != "3") {
			$month = date("m",strtotime($_REQUEST['datestart']));
			$year = date("Y",strtotime($_REQUEST['datestart']));
			$sql .= "and MONTH(BonusDate)=".$month." AND YEAR(BonusDate)=".$year." ";
			$show['month'] = $month."-".$year;
			$show['info_filter'] .= "Month ".$month."-".$year;
		} else { 
			$sql .= "and MONTH(BonusDate)=MONTH(CURRENT_DATE()) AND YEAR(BonusDate)=YEAR(CURRENT_DATE()) ";
			$show['month'] = date('m-Y');
		}
		// echo  $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {

			$show['inv'] += 1;
			$show['omzet'] += $row->PriceBeforeTax;
			$show['pv'] += $row->PV_total;
			$show['penalty'] += $row->PV_penalty*1000;
			$show['total'] += $row->PV_final;

		  	$show['main'][] = array(
		  			'INVID' => $row->INVID,
		  			'BankTransactionDate' => $row->BonusDate,
		  			'due_date' => $row->due_date,
		  			'date_diff' => $row->date_diff,
		  			'penalty' => $row->penalty,
		  			'PV_total' => $row->PV_total,
		  			'PV_penalty' => $row->PV_penalty*1000,
		  			'PV_final' => $row->PV_final,
		  			'PriceBeforeTax' => $row->PriceBeforeTax,
		  			'fullname' => $row->fullname
				);
		};
	    return $show;
	}
	function pv_by_inv_percentage()
	{
		$show = array();
		$show['inv'] = 0;
		$show['omzet'] = 0;
		$show['pv'] = 0;
		$show['penalty'] = 0;
		$show['total'] = 0;
		$show['info_filter'] = "";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql 	= "SELECT ibf.*, em.Company2 as fullname FROM vw_invoice_bonus_final2_percentage ibf
					LEFT JOIN vw_sales_executive2 em ON (ibf.SalesID=em.SalesID)";

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( ibf.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ibf.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "where ibf.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "where ibf.SalesID<>'' ";
		}

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && $_REQUEST['datestart'] != "3") {
			$month = date("m",strtotime($_REQUEST['datestart']));
			$year = date("Y",strtotime($_REQUEST['datestart']));
			$sql .= "and MONTH(BonusDate)=".$month." AND YEAR(BonusDate)=".$year." ";
			$show['month'] = $month."-".$year;
			$show['info_filter'] .= "Month ".$month."-".$year;
		} else { 
			$sql .= "and MONTH(BonusDate)=MONTH(CURRENT_DATE()) AND YEAR(BonusDate)=YEAR(CURRENT_DATE()) ";
			$show['month'] = date('m-Y');
		}

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {

			$show['inv'] += 1;
			$show['omzet'] += $row->PriceBeforeTax;
			$show['pv'] += $row->PV_total;
			$show['penalty'] += $row->PV_penalty*1000;
			$show['total'] += $row->PV_final;

		  	$show['main'][] = array(
		  			'INVID' => $row->INVID,
		  			'BankTransactionDate' => $row->BonusDate,
		  			'due_date' => $row->due_date,
		  			'date_diff' => $row->date_diff,
		  			'penalty' => $row->penalty,
		  			'PV_total' => $row->PV_total,
		  			'PV_penalty' => $row->PV_penalty*1000,
		  			'PV_final' => $row->PV_final,
		  			'PriceBeforeTax' => $row->PriceBeforeTax,
		  			'fullname' => $row->fullname
				);
		};
	    return $show;
	}
	function pv_by_sales()
	{
		$show = array();
		$show['sales'] = 0;
		$show['omzet'] = 0;
		$show['pv'] = 0;
		$show['penalty'] = 0;
		$show['total'] = 0;
		$show['info_filter'] = "";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql 	= "SELECT ibfd.SalesID, MONTH(BonusDate) as month, YEAR(BonusDate) as year,
					SUM(PriceTotal) as PriceTotal, SUM(PV_qty) as PV_qty, SUM(PV_total) as PV_total, 
					SUM(PV_penalty) as PV_penalty, SUM(PV_final) as PV_final, SUM(PriceTotal) as Omzet,
					em.Company2 as fullname FROM vw_invoice_bonus_final_detail2 ibfd
					LEFT JOIN vw_sales_executive2 em ON (ibfd.SalesID=em.SalesID)";

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( ibfd.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ibfd.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "where ibfd.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "where ibfd.SalesID<>'' ";
		}

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && $_REQUEST['datestart'] != "3") {
			$month = date("m",strtotime($_REQUEST['datestart']));
			$year = date("Y",strtotime($_REQUEST['datestart']));
			$sql .= "and MONTH(BonusDate)=".$month." AND YEAR(BonusDate)=".$year." ";
			$date = $year.'-'.$month;
			$show['month'] = $month."-".$year;
			$show['info_filter'] .= "Month ".$month."-".$year;
		} else { 
			$sql .= "and MONTH(BonusDate)=MONTH(CURRENT_DATE()) AND YEAR(BonusDate)=YEAR(CURRENT_DATE()) ";

			$now = new DateTime('now');
			$month = $now->format('m');
			$year = $now->format('Y');
			$date = $year.'-'.$month;
			$show['month'] = date('m-Y');
		}
			$sql .= "GROUP BY SalesID, MONTH(BonusDate), YEAR(BonusDate) Desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['sales'] += 1;
			$show['omzet'] += $row->PriceTotal;
			$show['pv'] += $row->PV_total;
			$show['penalty'] += $row->PV_penalty*1000;
			$show['total'] += $row->PV_final;
			$show['date'] = $date;

		  	$show['main'][] = array(
		  			'SalesID' => $row->SalesID,
		  			'fullname' => $row->fullname,
		  			'PV_qty' => $row->PV_qty,
		  			'PV_total' => $row->PV_total,
		  			'PV_penalty' => $row->PV_penalty*1000,
		  			'PV_final' => $row->PV_final,
		  			'Omzet' => $row->Omzet
				);
		};
	    return $show;
	}
	function pv_by_sales_percentage()
	{
		$show = array();
		$show['sales'] = 0;
		$show['omzet'] = 0;
		$show['pv'] = 0;
		$show['penalty'] = 0;
		$show['total'] = 0;
		$show['info_filter'] = "";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql 	= "SELECT ibfd.SalesID, MONTH(BonusDate) as month, YEAR(BonusDate) as year,
					SUM(PriceTotalResult) as PriceTotal, SUM(PV_qty) as PV_qty, SUM(PV_total) as PV_total, 
					SUM(PV_penalty) as PV_penalty, SUM(PV_final) as PV_final, SUM(PriceTotalResult) as Omzet,
					em.Company2 as fullname FROM vw_invoice_bonus_final_detail2_percentage ibfd
					LEFT JOIN vw_sales_executive2 em ON (ibfd.SalesID=em.SalesID)";

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( ibfd.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ibfd.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "where ibfd.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "where ibfd.SalesID<>'' ";
		}

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && $_REQUEST['datestart'] != "3") {
			$month = date("m",strtotime($_REQUEST['datestart']));
			$year = date("Y",strtotime($_REQUEST['datestart']));
			$sql .= "and MONTH(BonusDate)=".$month." AND YEAR(BonusDate)=".$year." ";
			$date = $year.'-'.$month;
			$show['month'] = $month."-".$year;
			$show['info_filter'] .= "Month ".$month."-".$year;
		} else { 
			$sql .= "and MONTH(BonusDate)=MONTH(CURRENT_DATE()) AND YEAR(BonusDate)=YEAR(CURRENT_DATE()) ";

			$now = new DateTime('now');
			$month = $now->format('m');
			$year = $now->format('Y');
			$date = $year.'-'.$month;
			$show['month'] = date('m-Y');
		}
			$sql .= "GROUP BY SalesID, MONTH(BonusDate), YEAR(BonusDate) Desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['sales'] += 1;
			$show['omzet'] += $row->PriceTotal;
			$show['pv'] += $row->PV_total;
			$show['penalty'] += $row->PV_penalty*1000;
			$show['total'] += $row->PV_final;
			$show['date'] = $date;

		  	$show['main'][] = array(
		  			'SalesID' => $row->SalesID,
		  			'fullname' => $row->fullname,
		  			'PV_qty' => $row->PV_qty,
		  			'PV_total' => $row->PV_total,
		  			'PV_penalty' => $row->PV_penalty*1000,
		  			'PV_final' => $row->PV_final,
		  			'Omzet' => $row->Omzet
				);
		};
	    return $show;
	}
	function pv_inv_detail()
	{
		$show	= array();
		$INVID 	= $this->input->get_post('invid');
		$SalesID= $this->input->get_post('sales');
		$date 	= $this->input->get_post('date');
		$month 	= date("m",strtotime($date));
		$year 	= date("Y",strtotime($date));
		if (isset($_REQUEST)) {
			if (isset($INVID)) {
				$sql 	= "select INVID from vw_invoice_bonus_final_detail2 where INVID=".$INVID;
				$query 	= $this->db->query($sql);	
				$row 	= $query->row();
				if (!empty($row)) {
					$table = "vw_invoice_bonus_final_detail2";
				} else {
					$table = "vw_invoice_bonus_final_detail2_percentage";
				}
				$sql 	= "SELECT ibfd.*, pm.ProductCode, si.Percent as PercentINV FROM ".$table." ibfd 
							LEFT JOIN tb_product_main pm ON (pm.ProductID=ibfd.ProductID) 
							LEFT JOIN tb_so_inv_percent si ON (si.INVID=ibfd.INVID) 
							WHERE ibfd.INVID=".$INVID." order by ibfd.INVID, ibfd.ProductID";
			} elseif (isset($SalesID)) {
				$sql 	= "SELECT ibfd.*, pm.ProductCode FROM vw_invoice_bonus_final_detail2 ibfd 
							LEFT JOIN tb_product_main pm ON (pm.ProductID=ibfd.ProductID)
							WHERE ibfd.SalesID=".$SalesID." and YEAR(ibfd.BonusDate)='".$year."' AND MONTH(ibfd.BonusDate)='".$month."' order by ibfd.INVID, ibfd.ProductID";
			}
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$ProductCode = (empty($row->ProductCode)) ? $row->ProductName : $row->ProductCode;
				$PercentINV = (isset($row->PercentINV)) ? $row->PercentINV : 100 ;
			  	$show[] = array(
			  			'INVID' => $row->INVID,
			  			'ProductID' => $row->ProductID,
			  			'ProductCode' => $ProductCode,
			  			'ProductQty' => $row->ProductQty,
			  			'Promo' => $row->PromoPercent,
			  			'PT' => $row->PTPercent,
			  			'PriceAmount' => $row->PriceAmount,
			  			'PV' => $row->PV,
			  			'PV_to_price' => $row->PV_to_price,
			  			'ProductMultiplier' => $row->ProductMultiplier,
			  			'late' => $row->late,
			  			'penalty' => $row->penalty,
			  			'PV_final' => $row->PV_final,
			  			'PercentINV' => $PercentINV
					);
			};
		} else {
        	redirect(base_url());
		}
	    return $show;
	}
	function report_pv_sales_print()
	{
		$show	= array();
		$SalesID= $this->input->get_post('sales');
		$date 	= $this->input->get_post('date');
		$month 	= date("m",strtotime($date));
		$year 	= date("Y",strtotime($date));

		$sql 	= "SELECT Company2 FROM vw_sales_executive2 WHERE SalesID='".$SalesID."'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$show['sales'] = $row->Company2;

		$sql 	= "SELECT ibfd.*, pm.ProductCode FROM vw_invoice_bonus_final_detail2 ibfd 
					LEFT JOIN tb_product_main pm ON (pm.ProductID=ibfd.ProductID)
					WHERE ibfd.SalesID=".$SalesID." and YEAR(ibfd.BonusDate)='".$year."' AND MONTH(ibfd.BonusDate)='".$month."'";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$ProductCode = (empty($row->ProductCode)) ? $row->ProductName : $row->ProductCode;
		  	$show['main'][] = array(
	  			'INVID' => $row->INVID,
	  			'ProductID' => $row->ProductID,
	  			'ProductCode' => $ProductCode,
	  			'ProductQty' => $row->ProductQty,
	  			'Promo' => $row->PromoPercent,
	  			'PT' => $row->PTPercent,
	  			'PriceAmount' => $row->PriceAmount,
	  			'PriceTotal' => $row->PriceTotal,
	  			'PV' => $row->PV,
	  			'PV_to_price' => $row->PV_to_price,
	  			'ProductMultiplier' => $row->ProductMultiplier,
	  			'late' => $row->late,
	  			'penalty' => $row->penalty,
	  			'PV_final' => $row->PV_final
			);
		};
	    return $show;
	}

// stock flow==============================================================
	function report_stock_flow_daily()
	{
		$show = array();
		$sql = "SELECT * FROM vw_stock_flow_daily sfd ";
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && $_REQUEST['datestart'] != "3") {
			// $month = date("m",strtotime($_REQUEST['datestart']));
			// $year = date("Y",strtotime($_REQUEST['datestart']));
			// $sql .= "WHERE MONTH(DateReff)=".$month." AND YEAR(DateReff)=".$year." ";
			$sql .= "WHERE DateReff between '".$_REQUEST['datestart']." 00:00:00' and '".$_REQUEST['dateend']." 23:59:59' ";
		} else { 
			$sql .= "WHERE MONTH(DateReff)=MONTH(CURRENT_DATE()) AND YEAR(DateReff)=YEAR(CURRENT_DATE()) ";
		}

		if (isset($_REQUEST['zero'])) {
			// $sql .= "AND MONTH(DateReff)=".$month." AND YEAR(DateReff)=".$year." ";
		} else { 
			$sql .= "AND (QtyIn+QtyOut>0) ";
		}
			$sql .= "order by DateReff, ProductID ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'DateReff' => $row->DateReff,
		  			'ProductID' => $row->ProductID,
		  			'ProductCode' => $row->ProductCode,
		  			'WarehouseName' => $row->WarehouseName,
		  			'QtyIn' => $row->QtyIn,
		  			'QtyOut' => $row->QtyOut
				);
		};
	    return $show;
	}

// inv=====================================================================
	function report_inv_retur()
	{
		$show   = array();
		$show['info_filter'] = "";
		$sql = "SELECT im.*, se.Company2 as sales, c.Company2 as customer
				FROM tb_invoice_retur_main im 
				LEFT JOIN vw_sales_executive2 se ON im.SalesID=se.SalesID
				LEFT JOIN vw_customer3 c ON im.CustomerID=c.CustomerID ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "where im.INVRDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		} else {
			$sql .= "WHERE MONTH(INVRDate)=MONTH(CURRENT_DATE()) AND YEAR(INVRDate)=YEAR(CURRENT_DATE()) ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVRID in (SELECT DISTINCT INVRID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( !empty($_POST) ) {
			$sql .= "GROUP BY im.INVRID ";
		} else { 
			$sql .= "GROUP BY im.INVRID order by im.INVRID desc limit ".$this->limit_result." ";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
				'INVRID' => $row->INVRID,
				'INVID' => $row->INVID,
				'DORID' => $row->DORID,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'INVRDate' => $row->INVRDate,
				'PriceTotal' => $row->PriceTotal,
				'FCTotal' => $row->FCTotal,
				'INVRTotal' => $row->INVRTotal,
				'FakturNumber' => $row->FakturNumber,
			);
		};
	    return $show;
	}
	function report_inv_global()
	{
		$show   = array();
		$show['info_filter'] = "";

		// DO---------------------------------------------------------------------------------
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment, sm.ShopID, shm.ShopName
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				LEFT JOIN tb_so_main sm ON (sm.SOID = im.SOID) 
				LEFT JOIN tb_shop_main shm ON (shm.ShopID = sm.ShopID)
				WHERE im.INVCategory=1 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVID in (SELECT DISTINCT INVID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					case 'ShopName':
						$sql .= "shm.ShopName in (SELECT ShopName FROM tb_shop_main WHERE ShopName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Shop Name contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( !empty($_POST) ) {
			$sql .= "GROUP BY im.INVID ";
		} else { 
			$sql .= "GROUP BY im.INVID order by im.INVID desc limit ".$this->limit_result." ";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show['main'][] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'ShopName' => $row->ShopName
			);
		};

		// SO---------------------------------------------------------------------------------
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment, sm.ShopID, shm.ShopName
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				LEFT JOIN tb_so_main sm ON (sm.SOID = im.SOID) 
				LEFT JOIN tb_shop_main shm ON (shm.ShopID = sm.ShopID)";
		$sql .= "WHERE im.INVCategory=2 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}  

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVID in (SELECT DISTINCT INVID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					case 'ShopName':
						$sql .= "shm.ShopName in (SELECT ShopName FROM tb_shop_main WHERE ShopName like '%".$atributevalue[$i]."%') ";
						break;	
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( !empty($_REQUEST) ) {
			$sql .= "GROUP BY im.INVID ";
		} else { 
			$sql .= "and MONTH(im.INVDate)=MONTH(CURRENT_DATE()) AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ";
			$sql .= "GROUP BY im.INVID order by im.INVID desc limit ".$this->limit_result." ";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show['main'][] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldor' => 0,
				'ShopName' => $row->ShopName
			);
		};
	    return $show;
	}
	function invoice_list_do()
	{
		$show   = array();
		$show['info_filter'] = "";
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				WHERE im.INVCategory=1 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVID in (SELECT DISTINCT INVID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( !empty($_POST) ) {
			$sql .= "GROUP BY im.INVID ";
		} else { 
			$sql .= "GROUP BY im.INVID order by im.INVID desc limit ".$this->limit_result." ";
		}

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show[] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc
			);
		};
	    return $show;
	}
	function invoice_list_so()
	{
		$show   = array();
		
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) ";
		$sql .= "WHERE im.INVCategory=2 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}  

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVID in (SELECT DISTINCT INVID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( !empty($_REQUEST) ) {
			$sql .= "GROUP BY im.INVID ";
		} else { 
			$sql .= "and MONTH(im.INVDate)=MONTH(CURRENT_DATE()) AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ";
			$sql .= "GROUP BY im.INVID order by im.INVID desc limit ".$this->limit_result." ";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show[] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldor' => 0
			);
		};
	    return $show;
	}
	function invoice_list_global_unpaid()
	{
		$show   = array();
		$show['info_filter'] = "";

		// DO---------------------------------------------------------------------------------
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment,
				SUM(drd.dordProductQty) as totaldor, ib.due_date FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				LEFT JOIN vw_do_return_dor drd ON (im.DOID=drd.DOID)
				LEFT JOIN tb_so_main sm ON (sm.SOID = im.SOID) 
				LEFT JOIN tb_shop_main shm ON (shm.ShopID = sm.ShopID)
				WHERE im.INVCategory=1 and ib.TotalPayment < im.INVTotal ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVInput between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVID in (SELECT DISTINCT INVID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					case 'ShopName':
						$sql .= "shm.ShopName in (SELECT ShopName FROM tb_shop_main WHERE ShopName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Shop Name contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		$sql .= "GROUP BY im.INVID ";
		// echo $sql;
		
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$now = time();
				$your_date = strtotime($row->due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show['main'][] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $row->due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldor' => $row->totaldor
			);
		};

		// SO---------------------------------------------------------------------------------
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) ";
		$sql .= "WHERE im.INVCategory=2 and ib.TotalPayment < im.INVTotal ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVInput between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} 
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show['main'][] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal-$row->FCInclude-$row->FCTax,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldor' => 0
			);
		};
	    return $show;
	}
	function invoice_list_do_unpaid()
	{
		$show   = array();
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment,
				SUM(drd.dordProductQty) as totaldor, ib.due_date FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				LEFT JOIN vw_do_return_dor drd ON (im.DOID=drd.DOID) 
				WHERE im.INVCategory=1 and ib.TotalPayment<im.INVTotal ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVInput between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "GROUP BY im.INVID ";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$now = time();
				$your_date = strtotime($row->due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show[] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $row->due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldor' => $row->totaldor
			);
		};
	    return $show;
	}
	function invoice_list_so_unpaid()
	{
		$show   = array();
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) ";
		$sql .= "WHERE im.INVCategory=2 and ib.TotalPayment<im.INVTotal ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVInput between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "and MONTH(im.INVDate)=MONTH(CURRENT_DATE()) AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show[] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal-$row->FCInclude-$row->FCTax,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldor' => 0
			);
		};
	    return $show;
	}
	function query_invoice_unpaid()
	{
		$show   = array();
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT SUM(t3.CountINV) AS CountINV, SUM(t3.CountUnpaid) AS CountUnpaid, SUM(t3.INV_late) AS CountINVLate FROM ( ";
		$sql .= "( SELECT COUNT(t1.INVID) AS CountINV, SUM(t1.INVTotal) - SUM(t1.TotalPayment) AS CountUnpaid,
				SUM(CASE WHEN t1.due_date <= CURDATE() THEN 1 ELSE 0 END) AS INV_late
				FROM (
				SELECT im.*, ib.TotalPayment, ib.due_date FROM tb_invoice_main im   
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID)  
				WHERE im.INVCategory=1 and ib.TotalPayment < im.INVTotal ";

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}
		$sql .= ") t1";

		$sql .= ") UNION ALL (";

		$sql .= "SELECT COUNT(t2.INVID) AS CountINV, SUM(t2.INVTotal) - SUM(t2.TotalPayment) AS CountUnpaid,
				SUM(CASE WHEN t2.due_date <= CURDATE() THEN 1 ELSE 0 END) AS INV_late
				FROM ( SELECT im.*, ib.TotalPayment, ib.due_date 
				FROM tb_invoice_main im 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				WHERE im.INVCategory=2 and ib.TotalPayment < im.INVTotal ";
 
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and im.SalesID<>'' ";
		}
		$sql .= ") t2 )";
		$sql .= ") t3";
 
	    return $sql;
		$this->log_user->log_query($this->last_query);
	}
	function report_inv_customer()
	{
		$show   = array();
		$show['info_filter'] = "";
		$show['confirmed'] = 0;
		$show['completed'] = 0;

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sqldate = "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sqldate = "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}

		$sql 	= "SELECT ib.CustomerID, ib.CityName, CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.TotalOutstanding) AS TotalOutstanding, tvib.INVConfirmed,
					cus.Company2 FROM vw_invoice_balance ib
					LEFT JOIN vw_customer2 cus ON (ib.CustomerID=cus.CustomerID)
					LEFT JOIN (SELECT COUNT(INVID) AS INVConfirmed, CustomerID FROM vw_invoice_balance vib ".$sqldate." AND vib.status like 'CONFIRM' GROUP BY CustomerID) tvib ON tvib.CustomerID=ib.CustomerID ".$sqldate;

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.CustomerID ORDER BY ib.TotalPayment desc, ib.TotalOutstanding desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['confirmed'] += $row->TotalOutstanding;
			$show['completed'] += $row->TotalPayment;

		  	$show['main'][] = array(
		  			'CustomerID' => $row->CustomerID,
		  			'Company' => $row->Company2,
		  			'CityName' => $row->CityName,
					'INVConfirmed' => $row->INVConfirmed,
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd
				);
		};
	    return $show;
	}
	function report_inv_customer_detail()
	{
		$show = array();
		$CustomerID 	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT id.*, ib.TotalOutstanding, ib.SOID, ib.INVDate FROM tb_invoice_detail id
					LEFT JOIN vw_invoice_balance ib ON (id.INVID=ib.INVID)
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') AND ib.CustomerID=".$CustomerID." order by id.INVID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$date2=date_create($row->INVDate);
			$date1=date_create(date('Y-m-d'));
			$diff=date_diff($date1,$date2);
			$late_days = $diff->format("%a days");

			$status = 'completed';
			if ($row->TotalOutstanding > 0) {
				$status = 'confirmed';
			}
		  	$show[] = array(
				'INVID' => $row->INVID,
				'SOID' => $row->SOID,
				'status' => $status,
				'INVDate' => $row->INVDate,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'PromoPercent' => $row->PromoPercent,
				'PTPercent' => $row->PTPercent,
				'PriceAmount' => $row->PriceTotal-$row->FreightCharge,
				'late_days' => $late_days,
			);
		};
	    return $show;
	}
	function report_inv_customer_detail_month()
	{
		$CustomerID 	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT ib.CustomerID, CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate, 
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.TotalOutstanding) AS TotalOutstanding,
					cus.Company2 FROM vw_invoice_balance ib
					LEFT JOIN vw_customer2 cus ON (ib.CustomerID=cus.CustomerID)
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') 
					AND ib.CustomerID=".$CustomerID." group by MONTH(ib.INVDate), YEAR(ib.INVDate) 
					ORDER BY INVDate ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'INVDate' => $row->INVDate,
		  			'CustomerID' => $row->CustomerID,
		  			'Company' => $row->Company2,
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd
				);
		};
	    return $show;
	}
	function report_inv_sales()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT ib.SalesID, se.Company2 as SalesName,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0'), '-', '01') AS INVDate2,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";
 
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.SalesID, MONTH(ib.INVDate), YEAR(ib.INVDate) ORDER BY se.Company2, INVDate ";
		$query 	= $this->db->query($sql);
		
		$totalLast = 0;
		$idLast	= 0;
		$no = 0;

		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			if ($idLast != $row->SalesID ) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			$Progress = (($row->INVTotal - $totalLast) / $totalLast) * 100;
			$no++ ;
			if ($totalLast == $row->INVTotal) {
				$Progress = 100;
			}
			$INVDateStartSub = isset($row->INVDate2) ? date('Y-m-01', strtotime($row->INVDate2)) : date('d-m-Y');
			$INVDateEndSub = isset($row->INVDate2) ? date('Y-m-t', strtotime($row->INVDate2)) : date('d-m-Y');

		  	$show['main'][] = array(
		  		'No' => $row->SalesName.'('.$no.')',
	  			'INVDate' => $row->INVDate,
	  			'SalesID' => $row->SalesID,
	  			'SalesName' => $row->SalesName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStartSub,
	  			'INVDateEnd' => $INVDateEndSub, 
	  			'Progress' => $Progress,
			);
			$idLast = $row->SalesID;
			$totalLast = $row->INVTotal;
		};

		// total --------------------------------------------------------------------------------
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql 	= "SELECT ib.SalesID, se.Company2 as SalesName, 
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";
 
			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			} else { 
				$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			}

			$EmployeeID = array( $this->session->userdata('UserAccountID') );
			$SalesID = array( $this->session->userdata('SalesID') );
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "and ib.SalesID<>'' ";
			}

			$sql .= "GROUP BY ib.SalesID ORDER BY se.Company2, INVDate ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {

			  	$show['main'][] = array(
			  		'No' => $row->SalesName.'(0)',
		  			'INVDate' => "Total",
		  			'SalesID' => $row->SalesID,
		  			'SalesName' => $row->SalesName,
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVTotal' => $row->INVTotal,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd,
		  			'Progress' => 100,
				); 
			};
		}
	    return $show;
	}
	function report_inv_sales_detail()
	{
		$show   = array();
		$SalesID	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT ib.INVID, cus.Company2,
					ib.INVDate,	ib.TotalOutstanding, ib.TotalPayment , ib.INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_customer2 cus ON cus.CustomerID=ib.CustomerID
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') AND ib.SalesID=".$SalesID." order by INVDate";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'INVID' => $row->INVID,
				'INVDate' => $row->INVDate,
				'Company2' => $row->Company2,
				'TotalOutstanding' => $row->TotalOutstanding,
				'TotalPayment' => $row->TotalPayment,
				'INVTotal' => $row->INVTotal
			);
		};
	    return $show;
	}
	function report_inv_sales_detail_month()
	{
		$show = array();
		$SalesID 	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT ib.SalesID, se.Company2,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID 
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') and ib.SalesID='".$SalesID."' 
					GROUP BY ib.SalesID, YEAR(ib.INVDate), MONTH(ib.INVDate) ORDER BY YEAR(ib.INVDate), MONTH(ib.INVDate) ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'INVDate' => $row->INVDate,
	  			'SalesID' => $row->SalesID,
	  			'fullname' => $row->Company2,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd
			);
		};
	    return $show;
	}
	function report_inv_product()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT ip.ProductID, ip.INVDate, ip.ProductName, pm.ProductCategoryID, pm.ProductBrandID, 
					SUM(IF(ip.`status`='CONFIRM', ip.ProductQty,0)) AS QtyConfirm,
					SUM(IF(ip.`status`='CONFIRM', ip.PriceTotal,0)) AS TotalConfirm,
					SUM(IF(ip.`status`='COMPLETE', ip.ProductQty,0)) AS QtyComplete,
					SUM(IF(ip.`status`='COMPLETE', ip.PriceTotal,0)) AS TotalComplete
					FROM vw_invoice_product ip 
					LEFT JOIN tb_product_main pm ON ip.ProductID=pm.ProductID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ip.SalesID<>'' ";
		}

        $this->load->model('model_master');
        if (!empty($_REQUEST['category'] )) {
        	$category = explode('_', $_REQUEST['category']);
        	$category_full_child = $this->model_master->get_full_category_child_id($category[0]);
			$sql .= "and pm.ProductCategoryID in (". implode(',', array_map('intval', $category_full_child)) .") ";
			$show['info_filter'] .= "Category : ".$category[1]."<br>";
		}
        if (!empty($_REQUEST['brand'] )) {
        	$brand = explode('_', $_REQUEST['brand']);
        	$brand_full_child = $this->model_master->get_full_brand_child_id($brand[0]);
			$sql .= "and pm.ProductBrandID in (". implode(',', array_map('intval', $brand_full_child)) .") ";
			$show['info_filter'] .= "Brand : ".$brand[1]."<br>";
		}
		$sql .= "GROUP BY ip.ProductID, ip.SalesOrderDetailID ORDER BY ip.ProductID ";

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'INVDate' => $row->INVDate,
	  			'ProductID' => $row->ProductID,
	  			'ProductCategoryID' => $row->ProductCategoryID,
	  			'ProductName' => $row->ProductName,
	  			'QtyConfirm' => $row->QtyConfirm,
	  			'TotalConfirm' => $row->TotalConfirm,
	  			'QtyComplete' => $row->QtyComplete,
	  			'TotalComplete' => $row->TotalComplete,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd,
			);
		};
	    return $show;
	}
	function report_inv_product_detail()
	{
		$show   = array();
		$ProductID	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT ip.INVID, ip.INVDate, ip.ProductID, ip.ProductName, cus.Company2, ip.status, 
					ip.ProductQty, ip.ProductPriceDefault, ip.PromoPercent, ip.PTPercent, ip.PriceTotal
					FROM vw_invoice_product ip
					LEFT JOIN vw_customer2 cus ON ip.CustomerID=cus.CustomerID
					WHERE (ip.INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') AND ip.ProductID=".$ProductID." order by ip.INVDate";
		$query 	= $this->db->query($sql);
		// echo $sql;
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'INVID' => $row->INVID,
				'INVDate' => $row->INVDate,
				'Company2' => $row->Company2,
				'status' => $row->status,
				'ProductQty' => $row->ProductQty,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'PromoPercent' => $row->PromoPercent,
				'PTPercent' => $row->PTPercent,
				'PriceTotal' => $row->PriceTotal
			);
		};
	    return $show;
	}
	function report_inv_city()
	{
		$show = array();
		$show['info_filter'] = "";

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT ib.CityName, ib.CityID, 
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0'), '-', '01') AS INVDate2,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal, 
					GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.CityID, MONTH(ib.INVDate), YEAR(ib.INVDate) ORDER BY CityName, INVDate ";
		$query 	= $this->db->query($sql);

		$totalLast = 0;
		$idLast	= 0;
		$no = 0;

		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			if ($idLast != $row->CityID ) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			$Progress = (($row->INVTotal - $totalLast) / $totalLast) * 100;
			$no++ ;
			if ($totalLast == $row->INVTotal) {
				$Progress = 100;
			}
			$INVDateStartSub = isset($row->INVDate2) ? date('Y-m-01', strtotime($row->INVDate2)) : date('d-m-Y');
			$INVDateEndSub = isset($row->INVDate2) ? date('Y-m-t', strtotime($row->INVDate2)) : date('d-m-Y');

		  	$show['main'][] = array(
		  		'No' => $row->CityName.'('.$no.')',
	  			'INVDate' => $row->INVDate,
	  			'CityID' => $row->CityID,
	  			'CityName' => $row->CityName,
	  			'SalesName' => $row->SalesName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStartSub,
	  			'INVDateEnd' => $INVDateEndSub,
	  			'Progress' => $Progress,
			);

			$idLast = $row->CityID;
			$totalLast = $row->INVTotal;
		};


		// total --------------------------------------------------------------------------------
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql 	= "SELECT ib.CityName, ib.CityID, 
						SUM(ib.TotalOutstanding) AS TotalOutstanding,
						SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
						FROM vw_invoice_balance ib ";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			} else { 
				$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			}

			$EmployeeID = array( $this->session->userdata('UserAccountID') );
			$SalesID = array( $this->session->userdata('SalesID') );
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "and ib.SalesID<>'' ";
			}

			$sql .= "GROUP BY ib.CityID ORDER BY CityName, INVDate ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show[] = array(
			  		'No' => $row->CityName.'(0)',
		  			'INVDate' => "Total",
		  			'CityID' => $row->CityID,
		  			'CityName' => $row->CityName,
		  			'SalesName' => "",
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVTotal' => $row->INVTotal,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd,
		  			'Progress' => 100,
				);
			};
		}
		// echo json_encode($show);
	    return $show;
	}
	function report_inv_city_detail()
	{
		$show = array();
		$CityID	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		// $sql 	= "SELECT ib.INVID, cus.Company2, ib.INVDate, ib.TotalOutstanding, ib.TotalPayment , 
		// 			ib.INVTotal, se.Company2 as SalesName
		// 			FROM vw_invoice_balance ib LEFT JOIN vw_customer2 cus ON cus.CustomerID=ib.CustomerID 
		// 			LEFT JOIN vw_sales_executive2 se ON ib.SalesID=se.SalesID
		// 			WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') AND ib.CityID='".$CityID."' order by ib.INVDate";
		// $query 	= $this->db->query($sql);
		// foreach ($query->result() as $row) {
		//   	$show[] = array(
		// 		'INVDate' => $row->INVDate,
		// 		'INVID' => $row->INVID,
		// 		'Company2' => $row->Company2,
		// 		'TotalOutstanding' => $row->TotalOutstanding,
		// 		'TotalPayment' => $row->TotalPayment,
		// 		'INVTotal' => $row->INVTotal,
		// 		'SalesName' => $row->SalesName
		// 	);
		// };


		$sql 	= "SELECT cus.Company2, sum(ib.TotalOutstanding) as TotalOutstanding, 
					sum(ib.TotalPayment) as TotalPayment, sum(ib.INVTotal) as INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_customer2 cus ON cus.CustomerID=ib.CustomerID 
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') AND ib.CityID='".$CityID."' 
					group by ib.CustomerID order by INVTotal desc";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'Company2' => $row->Company2,
				'TotalOutstanding' => $row->TotalOutstanding,
				'TotalPayment' => $row->TotalPayment,
				'INVTotal' => $row->INVTotal,
			);
		};
	    return $show;
	}
	function report_inv_city_detail_month()
	{
		$show = array();

		$CityID	= $this->input->get_post('id');
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT ib.CityName, ib.CityID, 
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID 
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') and CityID='".$CityID."' 
					GROUP BY ib.CityID, YEAR(ib.INVDate), MONTH(ib.INVDate) ORDER BY INVDate ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'INVDate' => $row->INVDate,
	  			'CityID' => $row->CityID,
	  			'CityName' => $row->CityName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd
			);
		};
	    return $show;
	}
	function report_inv_shop()
	{
		$show = array();
		$show['info_filter'] = "";

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= " SELECT
						shm.ShopName, shm.ShopID, t1.INVDate, t1.INVDate2,
						COALESCE(t1.TotalOutstanding, 0) as TotalOutstanding,
						COALESCE(t1.TotalPayment, 0) as TotalPayment,
						COALESCE(t1.INVTotal, 0) as INVTotal,	t1.SalesName
					FROM
						tb_shop_main shm
					LEFT JOIN (
						SELECT sm.ShopID, CONCAT(YEAR (ib.INVDate),'-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
							CONCAT(YEAR (ib.INVDate),'-',LPAD(MONTH(ib.INVDate), 2, '0'),'-','01') AS INVDate2,
							SUM(ib.TotalOutstanding) AS TotalOutstanding,
							SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal,
							GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName
						FROM tb_so_main sm
						LEFT JOIN vw_invoice_balance ib ON (sm.SOID = ib.SOID)
						LEFT JOIN vw_sales_executive2 se ON se.SalesID = ib.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";	
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY
						sm.ShopID,
						MONTH (ib.INVDate),
						YEAR (ib.INVDate)
				) t1 ON t1.ShopID = shm.ShopID
				ORDER BY
					ShopName ";
		$query 	= $this->db->query($sql);
		// echo $sql;
		$totalLast = 0;
		$idLast	= 0;
		$no = 0;

		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			if ($idLast != $row->ShopID ) {
					$totalLast = $row->INVTotal;
					$no = 0;
			}
			if($row->INVTotal==0.00){
			$Progress = 0;	
			} else {	
			$Progress = (($row->INVTotal - $totalLast) / $totalLast) * 100;
			}	
			$no++ ;
			if ($totalLast == $row->INVTotal) {
				$Progress = 100;
			}
			$INVDateStartSub = isset($row->INVDate2) ? date('Y-m-01', strtotime($row->INVDate2)) : date('d-m-Y');
			$INVDateEndSub = isset($row->INVDate2) ? date('Y-m-t', strtotime($row->INVDate2)) : date('d-m-Y');

		  	$show['main'][] = array(
		  		'No' => $row->ShopName.'('.$no.')',
	  			'INVDate' => $row->INVDate,
	  			'ShopID' => $row->ShopID,
	  			'ShopName' => $row->ShopName,
	  			'SalesName' => $row->SalesName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStartSub,
	  			'INVDateEnd' => $INVDateEndSub,
	  			'Progress' => $Progress,
			);

			$idLast = $row->ShopID;
			$totalLast = $row->INVTotal;
		};


		// total --------------------------------------------------------------------------------
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql =" SELECT
						shm.ShopName, shm.ShopID, t1.INVDate, t1.INVDate2,
						COALESCE(t1.TotalOutstanding, 0) as TotalOutstanding,
						COALESCE(t1.TotalPayment, 0) as TotalPayment,
						COALESCE(t1.INVTotal, 0) as INVTotal,	t1.SalesName
					FROM
						tb_shop_main shm
					LEFT JOIN (
						SELECT sm.ShopID, CONCAT(YEAR (ib.INVDate),'-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
							CONCAT(YEAR (ib.INVDate),'-',LPAD(MONTH(ib.INVDate), 2, '0'),'-','01') AS INVDate2,
							SUM(ib.TotalOutstanding) AS TotalOutstanding,
							SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal,
							GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName
						FROM tb_so_main sm
						LEFT JOIN vw_invoice_balance ib ON (sm.SOID = ib.SOID)
						LEFT JOIN vw_sales_executive2 se ON se.SalesID = ib.SalesID 
						";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			} else { 
				$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			}

			$EmployeeID = array( $this->session->userdata('UserAccountID') );
			$SalesID = array( $this->session->userdata('SalesID') );
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "and ib.SalesID<>'' ";
			}

			$sql .= "GROUP BY
							sm.ShopID,
							MONTH (ib.INVDate),
							YEAR (ib.INVDate)
					) t1 ON t1.ShopID = shm.ShopID
					ORDER BY
						ShopName";
			// echo $sql;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show[] = array(
			  		'No' => $row->ShopName.'(0)',
		  			'INVDate' => "Total",
		  			'ShopID' => $row->ShopID,
		  			'ShopName' => $row->ShopName,
		  			'SalesName' => "",
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVTotal' => $row->INVTotal,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd,
		  			'Progress' => 100,
				);
			};
		}
		// echo json_encode($show);

	    return $show;
	}
	function report_inv_shop_detail()
	{
		$show = array();
		$ShopID	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT cus.Company2, sum(ib.TotalOutstanding) as TotalOutstanding, 
					sum(ib.TotalPayment) as TotalPayment, sum(ib.INVTotal) as INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_customer2 cus ON cus.CustomerID=ib.CustomerID 
					LEFT JOIN tb_so_main sm ON (sm.SOID = ib.SOID)
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') AND sm.ShopID='".$ShopID."' 
					group by ib.CustomerID order by INVTotal desc";
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
		  	$show[] = array(
				'Company2' => $row->Company2,
				'TotalOutstanding' => $row->TotalOutstanding,
				'TotalPayment' => $row->TotalPayment,
				'INVTotal' => $row->INVTotal,
			);
		};
	    return $show;
	}
	function report_inv_shop_detail_month()
	{
		$show = array();

		$ShopID	= $this->input->get_post('id');
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT shm.ShopName, shm.ShopID,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM tb_shop_main shm
					LEFT JOIN tb_so_main sm ON (sm.ShopID = shm.ShopID)
					LEFT JOIN vw_invoice_balance ib  ON (ib.SOID = sm.SOID)
					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') and ShopID='".$ShopID."' 
					GROUP BY sm.ShopID, YEAR(ib.INVDate), MONTH(ib.INVDate) ORDER BY INVDate ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'INVDate' => $row->INVDate,
	  			'ShopID' => $row->ShopID,
	  			'ShopName' => $row->ShopName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd
			);
		};
	    return $show;
	}
	function report_inv_100_cities_east_customer()
	{
		$show   = array();
		$show['info_filter'] = "";
		$show['confirmed'] = 0;
		$show['completed'] = 0;

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "16,19,21,33,36,37,38,40,42,43,50,52,54,68,72,73,77,83,84,86,88,89,104,
					111,112,126,127,129,130,131,154,156,159,160,166,173,174,176,177,191,192,
					202,207,210,219,235,236,239,243,244,245,249,251,263,272,286,304,305,316,
					325,327,328,335,341,342,346,349,362,366,372,374,377,383,384,385,387,394,
					403,409,413,417,419,424,429,432,435,436,457,461,464,465,466,473,475,476,
					477,480,485,486,489";

		$sql 	= "SELECT ib.CustomerID, sales.Company2 as sales, ib.CityName, CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate, 
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.TotalOutstanding) AS TotalOutstanding,
					cus.Company2 FROM (vw_invoice_balance ib
					LEFT JOIN vw_customer2 cus ON (ib.CustomerID=cus.CustomerID)) 
					LEFT JOIN vw_sales_executive sales ON (ib.SalesID=sales.SalesID)";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ib.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.CustomerID ORDER BY ib.TotalPayment desc, ib.TotalOutstanding desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['confirmed'] += $row->TotalOutstanding;
			$show['completed'] += $row->TotalPayment;

		  	$show['main'][] = array(
		  			'CustomerID' => $row->CustomerID,
		  			'Company' => $row->Company2,
		  			'Sales' => $row->sales,
		  			'CityName' => $row->CityName,
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd
				);
		};

	    return $show;
	}
	function report_inv_100_cities_east_sales()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "16,19,21,33,36,37,38,40,42,43,50,52,54,68,72,73,77,83,84,86,88,89,104,
					111,112,126,127,129,130,131,154,156,159,160,166,173,174,176,177,191,192,
					202,207,210,219,235,236,239,243,244,245,249,251,263,272,286,304,305,316,
					325,327,328,335,341,342,346,349,362,366,372,374,377,383,384,385,387,394,
					403,409,413,417,419,424,429,432,435,436,457,461,464,465,466,473,475,476,
					477,480,485,486,489";

		$sql 	= "SELECT ib.SalesID, se.Company2,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ib.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.SalesID ORDER BY se.Company2 ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'SalesID' => $row->SalesID,
	  			'fullname' => $row->Company2,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd
			);
		};
	    return $show;
	}
	function report_inv_100_cities_east_product()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$CityList = "16,19,21,33,36,37,38,40,42,43,50,52,54,68,72,73,77,83,84,86,88,89,104,
					111,112,126,127,129,130,131,154,156,159,160,166,173,174,176,177,191,192,
					202,207,210,219,235,236,239,243,244,245,249,251,263,272,286,304,305,316,
					325,327,328,335,341,342,346,349,362,366,372,374,377,383,384,385,387,394,
					403,409,413,417,419,424,429,432,435,436,457,461,464,465,466,473,475,476,
					477,480,485,486,489";

		$sql 	= "SELECT ip.ProductID, ip.INVDate, ip.ProductName, pm.ProductCategoryID, pm.ProductBrandID, 
					SUM(IF(ip.`status`='CONFIRM', ip.ProductQty,0)) AS QtyConfirm,
					SUM(IF(ip.`status`='CONFIRM', ip.PriceTotal,0)) AS TotalConfirm,
					SUM(IF(ip.`status`='COMPLETE', ip.ProductQty,0)) AS QtyComplete,
					SUM(IF(ip.`status`='COMPLETE', ip.PriceTotal,0)) AS TotalComplete
					FROM vw_invoice_product ip 
					LEFT JOIN tb_product_main pm ON ip.ProductID=pm.ProductID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ip.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ip.SalesID<>'' ";
		}

        $this->load->model('model_master');
        if (!empty($_REQUEST['category'] )) {
        	$category = explode('_', $_REQUEST['category']);
        	$category_full_child = $this->model_master->get_full_category_child_id($category[0]);
			$sql .= "and pm.ProductCategoryID in (". implode(',', array_map('intval', $category_full_child)) .") ";
			$show['info_filter'] .= "Category : ".$category[1]."<br>";
		}
        if (!empty($_REQUEST['brand'] )) {
        	$brand = explode('_', $_REQUEST['brand']);
        	$brand_full_child = $this->model_master->get_full_brand_child_id($brand[0]);
			$sql .= "and pm.ProductBrandID in (". implode(',', array_map('intval', $brand_full_child)) .") ";
			$show['info_filter'] .= "Brand : ".$brand[1]."<br>";
		}
		$sql .= "GROUP BY ip.ProductID, ip.SalesOrderDetailID ORDER BY ip.ProductID ";
		
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][] = array(
				'INVDate' => $row->INVDate,
				'ProductID' => $row->ProductID,
				'ProductCategoryID' => $row->ProductCategoryID,
				'ProductName' => $row->ProductName,
				'QtyConfirm' => $row->QtyConfirm,
				'TotalConfirm' => $row->TotalConfirm,
				'QtyComplete' => $row->QtyComplete,
				'TotalComplete' => $row->TotalComplete,
				'INVDateStart' => $INVDateStart,
				'INVDateEnd' => $INVDateEnd,
			);
		};
	    return $show;
	}
	function report_inv_100_cities_east_city()
	{
		$show = array();
		$show['info_filter'] = "";

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "16,19,21,33,36,37,38,40,42,43,50,52,54,68,72,73,77,83,84,86,88,89,104,
					111,112,126,127,129,130,131,154,156,159,160,166,173,174,176,177,191,192,
					202,207,210,219,235,236,239,243,244,245,249,251,263,272,286,304,305,316,
					325,327,328,335,341,342,346,349,362,366,372,374,377,383,384,385,387,394,
					403,409,413,417,419,424,429,432,435,436,457,461,464,465,466,473,475,476,
					477,480,485,486,489";

		$sql 	= "select t2.INVDate, t2.INVDate2, t2.SalesName as SalesName, t1.*,IFNULL(TotalOutstanding,0) AS TotalOutstanding,
					IFNULL(TotalOutstanding,0) AS TotalOutstanding, 
					IFNULL(TotalPayment,0) AS TotalPayment,
					IFNULL(INVTotal,0) AS INVTotal from (
					SELECT ac.CityName, ac.CityID FROM vw_city ac
					WHERE ac.CityID IN (".$CityList.")
					) t1
					LEFT JOIN
					(
					SELECT ib.CityName, ib.CityID, 
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH (ib.INVDate),2,0)) AS INVDate, 
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0'), '-', '01') AS INVDate2,
					SUM(ib.TotalOutstanding) AS TotalOutstanding, SUM(ib.TotalPayment) AS TotalPayment, 
					SUM(ib.INVTotal) AS INVTotal, GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName 
					FROM vw_invoice_balance ib 
					LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ib.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.CityID, MONTH(ib.INVDate), YEAR(ib.INVDate) ORDER BY CityName, INVDate ) 
				t2 ON t1.CityID=t2.CityID
				ORDER BY t1.CityName, t2.INVDate";
		$query 	= $this->db->query($sql);
		$totalLast = 0;
		$idLast	= 0;
		$no = 0;
		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			if ($idLast != $row->CityID ) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}

			if ($totalLast > 0) {
				$Progress = (($row->INVTotal - $totalLast) / $totalLast) * 100;
				$no++ ;
			} else if ($totalLast == 0) {
				$no = 0;
				$Progress = 0;
			} else if ($totalLast == $row->INVTotal) {
				$no = 0;
				$Progress = 100;
			}
			$INVDateStartSub = isset($row->INVDate2) ? date('Y-m-01', strtotime($row->INVDate2)) : date('d-m-Y');
			$INVDateEndSub = isset($row->INVDate2) ? date('Y-m-t', strtotime($row->INVDate2)) : date('d-m-Y');

		  	$show['main'][] = array(
		  		'No' => $row->CityName.'('.$no.')',
	  			'INVDate' => $row->INVDate,
	  			'CityID' => $row->CityID,
	  			'CityName' => $row->CityName,
	  			'SalesName' => $row->SalesName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStartSub,
	  			'INVDateEnd' => $INVDateEndSub,
	  			'Progress' => $Progress,
			);

			$idLast = $row->CityID;
			$totalLast = $row->INVTotal;
		};


		// total --------------------------------------------------------------------------------
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql 	= "SELECT ib.CityName, ib.CityID, 
						SUM(ib.TotalOutstanding) AS TotalOutstanding,
						SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
						FROM vw_invoice_balance ib ";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			} else { 
				$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			}
			$sql .= "AND ib.CityID in (".$CityList.") ";

			$EmployeeID = array( $this->session->userdata('UserAccountID') );
			$SalesID = array( $this->session->userdata('SalesID') );
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "and ib.SalesID<>'' ";
			}

			$sql .= "GROUP BY ib.CityID ORDER BY CityName, INVDate ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['main'][] = array(
			  		'No' => $row->CityName.'(0)',
		  			'INVDate' => "Total",
		  			'CityID' => $row->CityID,
		  			'CityName' => $row->CityName,
		  			'SalesName' => "",
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVTotal' => $row->INVTotal,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd,
		  			'Progress' => 100,
				);
			};
		} 
	    return $show;
	}
	function report_inv_100_cities_west_customer()
	{
		$show   = array();
		$show['info_filter'] = "";
		$show['confirmed'] = 0;
		$show['completed'] = 0;

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "22,23,24,35,49,55,60,62,69,76,90,102,103,105,106,107,113,113,118,124,134,146,148,149,150,151,
					152,153,167,209,228,231,238,247,274,280,317,320,322,323,326,330,333,336,343,347,350,364,373,381,
					391,397,401,414,420,421,422,431,433,446,449,452,458,459,495";

		$sql 	= "SELECT ib.CustomerID, sales.Company2 as sales, ib.CityName, CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate, 
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.TotalOutstanding) AS TotalOutstanding,
					cus.Company2 FROM (vw_invoice_balance ib
					LEFT JOIN vw_customer2 cus ON (ib.CustomerID=cus.CustomerID)) 
					LEFT JOIN vw_sales_executive sales ON (ib.SalesID=sales.SalesID) ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ib.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.CustomerID ORDER BY ib.TotalPayment desc, ib.TotalOutstanding desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['confirmed'] += $row->TotalOutstanding;
			$show['completed'] += $row->TotalPayment;

		  	$show['main'][] = array(
		  			'CustomerID' => $row->CustomerID,
		  			'Company' => $row->Company2,
		  			'Sales' => $row->sales,
		  			'CityName' => $row->CityName,
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd
				);
		};
	    return $show;
	}
	function report_inv_100_cities_west_sales()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "22,23,24,35,49,55,60,62,69,76,90,102,103,105,106,107,113,113,118,124,134,146,148,149,150,151,
					152,153,167,209,228,231,238,247,274,280,317,320,322,323,326,330,333,336,343,347,350,364,373,381,
					391,397,401,414,420,421,422,431,433,446,449,452,458,459,495";

		$sql 	= "SELECT ib.SalesID, se.Company2,
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
					SUM(ib.TotalOutstanding) AS TotalOutstanding,
					SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
					FROM vw_invoice_balance ib LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ib.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.SalesID ORDER BY se.Company2 ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'SalesID' => $row->SalesID,
	  			'fullname' => $row->Company2,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd
			);
		};
	    return $show;
	}
	function report_inv_100_cities_west_product()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "22,23,24,35,49,55,60,62,69,76,90,102,103,105,106,107,113,113,118,124,134,146,148,149,150,151,
					152,153,167,209,228,231,238,247,274,280,317,320,322,323,326,330,333,336,343,347,350,364,373,381,
					391,397,401,414,420,421,422,431,433,446,449,452,458,459,495";
					
		$sql 	= "SELECT ip.ProductID, ip.INVDate, ip.ProductName, pm.ProductCategoryID, pm.ProductBrandID, 
					SUM(IF(ip.`status`='CONFIRM', ip.ProductQty,0)) AS QtyConfirm,
					SUM(IF(ip.`status`='CONFIRM', ip.PriceTotal,0)) AS TotalConfirm,
					SUM(IF(ip.`status`='COMPLETE', ip.ProductQty,0)) AS QtyComplete,
					SUM(IF(ip.`status`='COMPLETE', ip.PriceTotal,0)) AS TotalComplete
					FROM vw_invoice_product ip 
					LEFT JOIN tb_product_main pm ON ip.ProductID=pm.ProductID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ip.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ip.SalesID<>'' ";
		}

        $this->load->model('model_master');
        if (!empty($_REQUEST['category'] )) {
        	$category = explode('_', $_REQUEST['category']);
        	$category_full_child = $this->model_master->get_full_category_child_id($category[0]);
			$sql .= "and pm.ProductCategoryID in (". implode(',', array_map('intval', $category_full_child)) .") ";
			$show['info_filter'] .= "Category : ".$category[1]."<br>";
		}
        if (!empty($_REQUEST['brand'] )) {
        	$brand = explode('_', $_REQUEST['brand']);
        	$brand_full_child = $this->model_master->get_full_brand_child_id($brand[0]);
			$sql .= "and pm.ProductBrandID in (". implode(',', array_map('intval', $brand_full_child)) .") ";
			$show['info_filter'] .= "Brand : ".$brand[1]."<br>";
		}
		$sql .= "GROUP BY ip.ProductID, ip.SalesOrderDetailID ORDER BY ip.ProductID ";
		
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][] = array(
				'INVDate' => $row->INVDate,
				'ProductID' => $row->ProductID,
				'ProductCategoryID' => $row->ProductCategoryID,
				'ProductName' => $row->ProductName,
				'QtyConfirm' => $row->QtyConfirm,
				'TotalConfirm' => $row->TotalConfirm,
				'QtyComplete' => $row->QtyComplete,
				'TotalComplete' => $row->TotalComplete,
				'INVDateStart' => $INVDateStart,
				'INVDateEnd' => $INVDateEnd,
			);
		};
	    return $show;
	}
	function report_inv_100_cities_west_city()
	{
		$show = array();
		$show['info_filter'] = "";

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		$CityList = "22,23,24,35,49,55,60,62,69,76,90,102,103,105,106,107,113,113,118,124,134,146,148,149,150,151,
					152,153,167,209,228,231,238,247,274,280,317,320,322,323,326,330,333,336,343,347,350,364,373,381,
					391,397,401,414,420,421,422,431,433,446,449,452,458,459,495";

		$sql 	= "select t2.INVDate, t2.INVDate2, t2.SalesName as SalesName, t1.*,IFNULL(TotalOutstanding,0) AS TotalOutstanding,
					IFNULL(TotalOutstanding,0) AS TotalOutstanding, 
					IFNULL(TotalPayment,0) AS TotalPayment,
					IFNULL(INVTotal,0) AS INVTotal from (
					SELECT ac.CityName, ac.CityID FROM vw_city ac
					WHERE ac.CityID IN (".$CityList.")
					) t1
					LEFT JOIN
					(
					SELECT ib.CityName, ib.CityID, 
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH (ib.INVDate),2,0)) AS INVDate, 
					CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0'), '-', '01') AS INVDate2,
					SUM(ib.TotalOutstanding) AS TotalOutstanding, SUM(ib.TotalPayment) AS TotalPayment, 
					SUM(ib.INVTotal) AS INVTotal, GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName 
					FROM vw_invoice_balance ib 
					LEFT JOIN vw_sales_executive2 se ON se.SalesID=ib.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}
			$sql .= "AND ib.CityID in (".$CityList.") ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ib.SalesID<>'' ";
		}

		$sql .= "GROUP BY ib.CityID, MONTH(ib.INVDate), YEAR(ib.INVDate) ORDER BY CityName, INVDate ) 
				t2 ON t1.CityID=t2.CityID
				ORDER BY t1.CityName, t2.INVDate";
		$query 	= $this->db->query($sql);

		$totalLast = 0;
		$idLast	= 0;
		$no = 0;
		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}
			if ($idLast != $row->CityID ) {
				$totalLast = $row->INVTotal;
				$no = 0;
			}

			if ($totalLast > 0) {
				$Progress = (($row->INVTotal - $totalLast) / $totalLast) * 100;
				$no++ ;
			} else if ($totalLast == 0) {
				$no = 0;
				$Progress = 0;
			} else if ($totalLast == $row->INVTotal) {
				$no = 0;
				$Progress = 100;
			}
			$INVDateStartSub = isset($row->INVDate2) ? date('Y-m-01', strtotime($row->INVDate2)) : date('d-m-Y');
			$INVDateEndSub = isset($row->INVDate2) ? date('Y-m-t', strtotime($row->INVDate2)) : date('d-m-Y');

		  	$show['main'][] = array(
		  		'No' => $row->CityName.'('.$no.')',
	  			'INVDate' => $row->INVDate,
	  			'CityID' => $row->CityID,
	  			'CityName' => $row->CityName,
	  			'SalesName' => $row->SalesName,
	  			'confirmed' => $row->TotalOutstanding,
	  			'completed' => $row->TotalPayment,
	  			'INVTotal' => $row->INVTotal,
	  			'INVDateStart' => $INVDateStartSub,
	  			'INVDateEnd' => $INVDateEndSub,
	  			'Progress' => $Progress,
			);

			$idLast = $row->CityID;
			$totalLast = $row->INVTotal;
		};
		
		// total --------------------------------------------------------------------------------
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql 	= "SELECT ib.CityName, ib.CityID, 
						SUM(ib.TotalOutstanding) AS TotalOutstanding,
						SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal
						FROM vw_invoice_balance ib ";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			} else { 
				$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			}
			$sql .= "AND ib.CityID in (".$CityList.") ";

			$EmployeeID = array( $this->session->userdata('UserAccountID') );
			$SalesID = array( $this->session->userdata('SalesID') );
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "and ib.SalesID<>'' ";
			}

			$sql .= "GROUP BY ib.CityID ORDER BY CityName, INVDate ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['main'][] = array(
			  		'No' => $row->CityName.'(0)',
		  			'INVDate' => "Total",
		  			'CityID' => $row->CityID,
		  			'CityName' => $row->CityName,
		  			'SalesName' => "",
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVTotal' => $row->INVTotal,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd,
		  			'Progress' => 100,
				);
			};
		} 
	    return $show;
	}
	function report_inv_having_display()
	{
		$show   = array();
		$show['info_filter'] = "";
		$show['confirmed'] = 0;
		$show['completed'] = 0;

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$whereDate = " (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$whereDate = " MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$whereSales = " ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$whereSales .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$whereSales = " ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$whereSales = " ib.SalesID<>'' ";
		}


		$sql 	= "SELECT cus.CustomerID, cus.Company, IFNULL(ib.CityName,cus.CityName) as CityName, 
					IFNULL( CONCAT(YEAR(ib.INVDate), '-', LPAD(MONTH(ib.INVDate), 2, '0')),'".$INVDateStart."' ) AS INVDate, 
					IFNULL( SUM(ib.TotalPayment),0 ) AS TotalPayment, IFNULL( SUM(ib.TotalOutstanding),0) AS TotalOutstanding
					FROM (
						select s.CustomerID, s.Company, CityName from vw_so_list5 s 
						LEFT JOIN vw_customer3 c on s.CustomerID=c.CustomerID 
						where SOCategory=4 and SOStatus=1 and SOConfirm1=1 and SOConfirm2=1 and totaldo<>0
					) cus 
					LEFT JOIN  (
						SELECT * FROM vw_invoice_balance ib
						WHERE ".$whereDate."
						AND ".$whereSales."
					) ib ON (ib.CustomerID=cus.CustomerID) ";


		$sql .= "GROUP BY cus.CustomerID ORDER BY ib.TotalPayment desc, ib.TotalOutstanding desc, cus.CityName, cus.Company ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['confirmed'] += $row->TotalOutstanding;
			$show['completed'] += $row->TotalPayment;

		  	$show['main'][] = array(
		  			'CustomerID' => $row->CustomerID,
		  			'Company' => $row->Company,
		  			'CityName' => $row->CityName,
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd
				);
		};
	    return $show;
	}
	function report_inv_product_category()
	{
		$show   = array();
		$CategoryID 	= $this->input->post('CategoryID'); 
		$CategoryName 	= $this->input->post('CategoryName'); 
		
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

        $this->load->model('model_master');
		for ($i=0; $i < count($CategoryID);$i++) {

		  	$show['main'][] = array(
	  			'CategoryID' => $CategoryID[$i],
	  			'CategoryName' => $CategoryName[$i],
			);

        	$category_full_child = $this->model_master->get_full_category_child_id($CategoryID[$i]);
			$sql = "SELECT t1.*, COALESCE(t2.ProductQty,0) AS ProductQty, COALESCE(t2.PriceTotal,0) AS PriceTotal
					FROM (
					SELECT CONCAT(YEAR(DateReff),'-',LPAD(MONTH(DateReff), 2, '0')) AS MONTH
					FROM tb_date 
					WHERE DateReff BETWEEN '".$INVDateStart."' AND '".$INVDateEnd."'
					GROUP BY MONTH (DateReff), YEAR (DateReff) 
					) t1 
					LEFT JOIN (

					SELECT CONCAT(YEAR(INVDate),'-',LPAD(MONTH(INVDate), 2, '0')) as MONTH, 
					COALESCE(SUM(ProductQty),0) AS ProductQty,
					COALESCE(SUM(PriceTotal),0) AS PriceTotal
					FROM vw_invoice_product
					WHERE ProductID IN (
					SELECT ProductID FROM tb_product_main 
					WHERE ProductCategoryID IN (". implode(',', array_map('intval', $category_full_child)) .") 
					) AND (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') 
					GROUP BY MONTH(INVDate), YEAR(INVDate)

					) 
					t2 ON t1.MONTH = t2.MONTH
					ORDER BY t1.MONTH ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['detail'][$CategoryID[$i]][] = array(
		  			'MONTH' => $row->MONTH,
		  			'ProductQty' => $row->ProductQty,
		  			'PriceTotal' => $row->PriceTotal,
				);
			};
		}
	    return $show;
	}
	function report_inv_product_brand()
	{
		$show = array();
		$BrandID 	= $this->input->post('BrandID'); 
		$BrandName 	= $this->input->post('BrandName'); 
		
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

        $this->load->model('model_master');
		for ($i=0; $i < count($BrandID);$i++) {

		  	$show['main'][] = array(
	  			'BrandID' => $BrandID[$i],
	  			'BrandName' => $BrandName[$i],
			);

        	$brand_full_child = $this->model_master->get_full_brand_child_id($BrandID[$i]);
			$sql = "SELECT t1.*, COALESCE(t2.ProductQty,0) AS ProductQty, COALESCE(t2.PriceTotal,0) AS PriceTotal
					FROM (
					SELECT CONCAT(YEAR(DateReff),'-',LPAD(MONTH(DateReff), 2, '0')) AS MONTH
					FROM tb_date 
					WHERE DateReff BETWEEN '".$INVDateStart."' AND '".$INVDateEnd."'
					GROUP BY MONTH (DateReff), YEAR (DateReff) 
					) t1 
					LEFT JOIN (

					SELECT CONCAT(YEAR(INVDate),'-',LPAD(MONTH(INVDate), 2, '0')) as MONTH, 
					COALESCE(SUM(ProductQty),0) AS ProductQty,
					COALESCE(SUM(PriceTotal),0) AS PriceTotal
					FROM vw_invoice_product
					WHERE ProductID IN (
					SELECT ProductID FROM tb_product_main 
					WHERE ProductBrandID IN (". implode(',', array_map('intval', $brand_full_child)) .") 
					) AND (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') 
					GROUP BY MONTH(INVDate), YEAR(INVDate)

					) 
					t2 ON t1.MONTH = t2.MONTH
					ORDER BY t1.MONTH ";

			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['detail'][$BrandID[$i]][] = array(
		  			'MONTH' => $row->MONTH,
		  			'ProductQty' => $row->ProductQty,
		  			'PriceTotal' => $row->PriceTotal,
				);
			};
		}
	    return $show;
	}
	function report_inv_product_id()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT ip.ProductID, ip.INVDate, ip.ProductName, pm.ProductCategoryID, pm.ProductBrandID, 
					Coalesce( SUM(ip.PriceTotal), 0 ) AS PriceTotal 
					FROM vw_invoice_product ip 
					LEFT JOIN tb_product_main pm ON ip.ProductID=pm.ProductID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			// $sql .= "and ip.ProductID=0 ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and ip.SalesID<>'' ";
		}

        $this->load->model('model_master');
        if (!empty($_REQUEST['category'] )) {
        	$category_full_child = $this->model_master->get_full_category_child_id($_REQUEST['category']);
			$sql .= "and pm.ProductCategoryID in (". implode(',', array_map('intval', $category_full_child)) .") ";
		}
        if (!empty($_REQUEST['brand'] )) {
        	$brand_full_child = $this->model_master->get_full_brand_child_id($_REQUEST['brand']);
			$sql .= "and pm.ProductBrandID in (". implode(',', array_map('intval', $brand_full_child)) .") ";
		}
        if (!empty($_REQUEST['ProductID'] )) {
			$sql .= "and ip.ProductID in (". implode(',', array_map('intval', $_REQUEST['ProductID'])) .") ";
		}
		$sql .= "GROUP BY ip.ProductID, ip.SalesOrderDetailID ORDER BY ip.ProductID ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'INVDate' => $row->INVDate,
	  			'ProductID' => $row->ProductID,
	  			'ProductCategoryID' => $row->ProductCategoryID,
	  			'ProductBrandID' => $row->ProductBrandID,
	  			'ProductName' => $row->ProductName,
	  			'Total' => $row->PriceTotal,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd,
			);
		};
	    return $show;
	}
	function report_inv_product_detail_month()
	{
		$show = array();
		$ProductID 	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT ip.ProductID, ip.ProductName, 
					CONCAT(YEAR(ip.INVDate), '-', LPAD(MONTH(ip.INVDate), 2, '0')) AS INVDate,  
					Coalesce( Count(ip.CustomerID), 0 ) AS CountCustomer, 
					Coalesce( Count(ip.INVID), 0 ) AS CountINV, 
					Coalesce( SUM(ip.ProductQty), 0 ) AS ProductQty, 
					Coalesce( SUM(ip.PriceTotal), 0 ) AS PriceTotal 
					FROM vw_invoice_product ip 
					LEFT JOIN tb_product_main pm ON ip.ProductID=pm.ProductID 
 					WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') 
					AND ip.ProductID=".$ProductID." group by MONTH(ip.INVDate), YEAR(ip.INVDate) 
					ORDER BY INVDate ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'INVDate' => $row->INVDate,
		  			'CountCustomer' => $row->CountCustomer,
		  			'CountINV' => $row->CountINV,
		  			'ProductQty' => $row->ProductQty,
		  			'PriceTotal' => $row->PriceTotal 
				);
		};
	    return $show;
	}
	function report_inv_paid_customer_product()
	{
		$show = array();
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT ip.CustomerID, cus.Company2 AS CustomerName, SUM(id.ProductQty) AS ProductQty, 
				SUM(id.PriceTotal) AS PriceTotal FROM vw_invoice_paid ip
				LEFT JOIN vw_customer2 cus ON ip.CustomerID=cus.CustomerID
				LEFT JOIN tb_invoice_detail id ON ip.INVID=id.INVID ";

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "where ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "where ip.SalesID<>'' ";
		}

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && $_REQUEST['datestart'] != "3") {
			$month = date("m",strtotime($_REQUEST['datestart']));
			$year = date("Y",strtotime($_REQUEST['datestart']));
			$sql .= "and MONTH(TransferDate)=".$month." AND YEAR(TransferDate)=".$year." ";
			$show['month'] = $year."-".$month;
		} else { 
			$sql .= "and MONTH(TransferDate)=MONTH(CURRENT_DATE()) AND YEAR(TransferDate)=YEAR(CURRENT_DATE()) ";
			
			$now = new DateTime('now');
			$month = $now->format('m');
			$year = $now->format('Y');
			$show['month'] = $year.'-'.$month;
		}
		$sql .= "GROUP BY ip.CustomerID ORDER BY cus.Company2";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'CustomerID' => $row->CustomerID,
		  			'CustomerName' => $row->CustomerName,
		  			'ProductQty' => $row->ProductQty,
		  			'PriceTotal' => $row->PriceTotal,
				);
		};
	    return $show;
	}
	function report_inv_paid_customer_product_category()
	{
		$show = array();
		$CustomerID	= $this->input->get_post('customer');

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (isset($_REQUEST)) { 
			$sql = "SELECT pm.ProductCategoryID, SUM(id.ProductQty) AS ProductQty, SUM(id.PriceTotal) AS PriceTotal 
					FROM vw_invoice_paid ip 
					LEFT JOIN tb_invoice_detail id ON ip.INVID=id.INVID
					LEFT JOIN tb_product_main pm ON id.ProductID=pm.ProductID ";

			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "where ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "where ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "where ip.SalesID<>'' ";
			}

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$month = date("m",strtotime($_REQUEST['datestart']));
				$year = date("Y",strtotime($_REQUEST['datestart']));
				$sql .= "and MONTH(TransferDate)=".$month." AND YEAR(TransferDate)=".$year." ";
			} else { 
				$sql .= "and MONTH(TransferDate)=MONTH(CURRENT_DATE()) AND YEAR(TransferDate)=YEAR(CURRENT_DATE()) ";
			}
			$sql .= "AND CustomerID=".$CustomerID." GROUP BY pm.ProductCategoryID ";

			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show[$row->ProductCategoryID] = array(
			  			'ProductQty' => $row->ProductQty,
			  			'PriceTotal' => $row->PriceTotal,
					);
			};
		} else {
        	redirect(base_url());
		}
	    return $show;
	}
	function report_inv_paid_customer_product_brand()
	{
		$show = array();
		$CustomerID	= $this->input->get_post('customer');

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (isset($_REQUEST)) { 
			$sql = "SELECT pm.ProductBrandID, SUM(id.ProductQty) AS ProductQty, SUM(id.PriceTotal) AS PriceTotal 
					FROM vw_invoice_paid ip 
					LEFT JOIN tb_invoice_detail id ON ip.INVID=id.INVID
					LEFT JOIN tb_product_main pm ON id.ProductID=pm.ProductID ";

			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "where ( ip.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "where ip.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "where ip.SalesID<>'' ";
			}

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$month = date("m",strtotime($_REQUEST['datestart']));
				$year = date("Y",strtotime($_REQUEST['datestart']));
				$sql .= "and MONTH(TransferDate)=".$month." AND YEAR(TransferDate)=".$year." ";
			} else { 
				$sql .= "and MONTH(TransferDate)=MONTH(CURRENT_DATE()) AND YEAR(TransferDate)=YEAR(CURRENT_DATE()) ";
			}
			$sql .= "AND CustomerID=".$CustomerID." GROUP BY pm.ProductBrandID ";

			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show[$row->ProductBrandID] = array(
			  			'ProductQty' => $row->ProductQty,
			  			'PriceTotal' => $row->PriceTotal,
					);
			};
		} else {
        	redirect(base_url());
		}
	    return $show;
	}
	function report_inv_profit()
	{
		$show = array();
		$show['info_filter'] = "";
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment, 
				t1.ProfitAmount, t1.PriceTotal FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID)  
				LEFT JOIN (
				SELECT INVID, SUM(ProfitAmount) AS ProfitAmount, SUM(PriceTotal2) AS PriceTotal 
				FROM vw_invoice_bonus_detail_full GROUP BY INVID
				) t1 ON im.INVID=t1.INVID ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( im.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "where im.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "where im.SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "im.INVID in (SELECT DISTINCT INVID FROM tb_invoice_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'Company':
						$sql .= "im.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "im.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= "im.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( !empty($_POST) ) {
			$sql .= "GROUP BY im.INVID ";
		} else { 
			$sql .= "GROUP BY im.INVID order by im.INVID desc limit ".$this->limit_result." ";
		}

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);
			$ProfitPercent = $this->get_percent($row->PriceTotal, $row->ProfitAmount);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
				$datediff = $datediff * -1;
			}

		  	$show['main'][] = array(
				'INVID' => $row->INVID,
				'DOID' => $row->DOID,
				'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVTerm' => $row->INVTerm,
				'INVNote' => $row->INVNote,
				'TaxRate' => $row->TaxRate,
				'FCInclude' => $row->FCInclude,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'FCTotal' => $row->FCTotal,
				'PriceBeforeTax' => $row->PriceBeforeTax,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'due_date' => $due_date,
				'datediff' => $datediff,
				'TotalPayment' => $row->TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'ProfitAmount' => $row->ProfitAmount,
				'ProfitPercent' => $ProfitPercent,
				'PriceTotal' => $row->PriceTotal
			);
		};
	    return $show;
	}
	function report_inv_profit_detail()
	{
		$show   = array();
		$INVID	= $this->input->get_post('id');
		$sql 	= "SELECT * FROM vw_invoice_bonus_detail WHERE INVID='".$INVID."' ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$ProfitPercent = $this->get_percent($row->PriceTotal2, $row->ProfitAmount);
		  	$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductHPP' => $row->ProductHPP,
				'ProductPrice' => $row->PriceAmount,
				'ProductProfit' => $row->PriceAmount - $row->ProductHPP,
				'PriceTotal' => $row->PriceTotal2,
				'ProfitAmount' => $row->ProfitAmount,
				'ProfitPercent' => $ProfitPercent,
			);
		};
	    return $show;
	}
	function report_inv_profit_product()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT ip.*, pm.ProductCategoryID, pm.ProductBrandID 
					FROM vw_invoice_bonus_detail_full ip 
					LEFT JOIN tb_product_main pm ON ip.ProductID=pm.ProductID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";
		} else { 
			$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
		} 

        $this->load->model('model_master');
        if (!empty($_REQUEST['category'] )) {
        	$category = explode('_', $_REQUEST['category']);
        	$category_full_child = $this->model_master->get_full_category_child_id($category[0]);
			$sql .= "and pm.ProductCategoryID in (". implode(',', array_map('intval', $category_full_child)) .") ";
			$show['info_filter'] .= "Category : ".$category[1]."<br>";
		}
        if (!empty($_REQUEST['brand'] )) {
        	$brand = explode('_', $_REQUEST['brand']);
        	$brand_full_child = $this->model_master->get_full_brand_child_id($brand[0]);
			$sql .= "and pm.ProductBrandID in (". implode(',', array_map('intval', $brand_full_child)) .") ";
			$show['info_filter'] .= "Brand : ".$brand[1]."<br>";
		}
		$sql .= "ORDER BY ip.ProductID, ip.INVID";

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$ProfitPercent = $this->get_percent($row->PriceTotal2, $row->ProfitAmount);
		  	$show['main'][] = array(
				'INVID' => $row->INVID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductHPP' => $row->ProductHPP,
				'ProductPrice' => $row->PriceAmount,
				'ProductProfit' => $row->PriceAmount - $row->ProductHPP,
				'PriceTotal' => $row->PriceTotal2,
				'ProfitAmount' => $row->ProfitAmount,
				'ProfitPercent' => $ProfitPercent,
			);
		};
	    return $show;
	}

// approval================================================================
	function report_approval_customer()
	{
		$show   = array();
		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3, cus.Company2
				FROM tb_approval_customer_category acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID)
				LEFT JOIN vw_customer2 cus on (acc.CustomerID=cus.CustomerID) ";

		if ( isset($_REQUEST['customername']) && $_REQUEST['customername'] !="" ) {
			$sql .= "where cus.Company2 like '%".$_REQUEST['customername']."%' ";
		} elseif (isset($_REQUEST['customername'])=="") {
			$sql.="	where isComplete=0 ";
		} else {
			$sql.=" where isComplete=1 ";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}	
		$sql .="order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
	  			'Customer' => $row->Company2,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'Keterangan' => $row->Keterangan,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_so()
	{
		$show   = array();

		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_so acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID)
				WHERE Note <> ''  ";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}
		if ( isset($_REQUEST['soid']) && $_REQUEST['soid'] !="" ) {
			$sql .= "and acc.SOID=".$_REQUEST['soid']." ";
		} elseif (isset($_REQUEST['soid'])=="") {
			$sql.="	and isComplete=0 ";
		} else {
			$sql.="	and isComplete=1 ";
		}
				
		$sql.=" order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'SOID' => $row->SOID,
				'Note' => $row->Note,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_adjustment()
	{
		$show   = array();
		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_stock_adjustment acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID) ";
		if ( isset($_REQUEST['adjustmentid']) && $_REQUEST['adjustmentid'] !="" ) {
			$sql .= "where acc.AdjustmentID=".$_REQUEST['adjustmentid']." ";
		} elseif (isset($_REQUEST['adjustmentid'])=="") {
			$sql.="	where isComplete=0 ";
		} else {
			$sql.="	where isComplete=1 ";
		}	
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}	
		$sql.="	order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'AdjustmentID' => $row->AdjustmentID,
				'Title' => $row->Title,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_price_list()
	{
		$show   = array();
		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_price_list acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID)  ";
		if ( isset($_REQUEST['pricelistid']) && $_REQUEST['pricelistid'] !="" ) {
			$sql .= "where acc.PricelistID=".$_REQUEST['pricelistid']." ";
		} elseif (isset($_REQUEST['pricelistid'])=="") {
			$sql.="	where isComplete=0 ";
		} else {
			$sql.="	where isComplete=1 ";
		}	
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}			
		$sql.="	order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'PricelistID' => $row->PricelistID,
				'Title' => $row->Title,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_price_list_detail()
	{
		$show   = array();
		$sql = "SELECT acc.*, pm.ProductName, ProductCode
				FROM tb_price_list_detail_approval acc
				LEFT JOIN tb_product_main pm on (acc.ProductID=pm.ProductID) 
				WHERE acc.ApprovalID=".$_REQUEST['ApprovalID'];
		$query 	= $this->db->query($sql);
		$show['product'] = $query->result_array();

		$sql = "SELECT abc.*
				FROM tb_price_list_approval_brand_category abc 
				WHERE abc.ApprovalID=".$_REQUEST['ApprovalID'];
		$query 	= $this->db->query($sql);
		$show['brandcategory'] = $query->result_array();

		$sql = "SELECT abc.*
				FROM tb_price_list_approval_filter_percent abc 
				WHERE abc.ApprovalID=".$_REQUEST['ApprovalID'];
		$query 	= $this->db->query($sql);
		$show['promopercent'] = $query->result_array();
	    return $show;
	}
	function report_approval_price_recommendation()
	{
		$show   = array();
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');
		$sql = "SELECT apr.*, tpr.ProductID, tpr.PriceRec, tpm.ProductName, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_price_recommendation apr
				LEFT JOIN tb_price_recommendation tpr on (apr.ApprovalID=tpr.RecID)
				LEFT JOIN tb_product_main tpm on (tpr.ProductID=tpm.ProductID)
				LEFT JOIN vw_user_account em1 on (apr.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (apr.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (apr.Actor3ID=em3.UserAccountID)  ";
		if (in_array("report_approval_price_recommendation_view_all", $MenuList)) {
			$sql .= "WHERE tpr.InputBy<>0 ";
		} else {
			$sql .= "WHERE tpr.InputBy =".$UserAccountID." ";
		}
		if ( isset($_REQUEST['productid']) && $_REQUEST['productid'] !="" ) {
			$sql .= "AND tpr.ProductID=".$_REQUEST['productid']." ";
		} elseif (isset($_REQUEST['productid'])=="") {
			$sql.="	AND isComplete=0 ";
		} else {
			$sql.=" AND (isComplete in (0,1,2))";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "AND Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}
		$sql.="	order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'ApprovalID' => $row->ApprovalID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'PriceRec' => $row->PriceRec,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_promo_volume()
	{
		$show   = array();
		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_promo_volume acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID)  ";
		if ( isset($_REQUEST['promovolid']) && $_REQUEST['promovolid'] !="" ) {
			$sql .= "where acc.PromoVolID=".$_REQUEST['promovolid']." ";
		} elseif (isset($_REQUEST['promovolid'])=="") {
			$sql.="	where isComplete=0 ";
		} else {
			$sql.="	where isComplete=1 ";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}		
		$sql.=	"order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'PromoVolID' => $row->PromoVolID,
				'Title' => $row->Title,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_mutation_product()
	{
		$show   = array();
		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_mutation_product acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID) ";
		if ( isset($_REQUEST['mutationid']) && $_REQUEST['mutationid'] !="" ) {
			$sql .= "where acc.MutationID=".$_REQUEST['mutationid']." ";
		} elseif (isset($_REQUEST['mutationid'])=="") {
			$sql.="	where isComplete=0 ";
		} else {
			$sql.="	where isComplete=1 ";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}		 
		$sql.="	order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'MutationID' => $row->MutationID,
				'Title' => $row->Title,
				'Status' => $row->Status
			);
		};
	    return $show;
	}
	function report_approval_purchase_order()
	{
		$show   = array();
		$sql = "SELECT acc.*, em1.fullname AS A1, em2.fullname as A2, em3.fullname as A3
				FROM tb_approval_po acc
				LEFT JOIN vw_user_account em1 on (acc.Actor1ID=em1.UserAccountID)
				LEFT JOIN vw_user_account em2 on (acc.Actor2ID=em2.UserAccountID)
				LEFT JOIN vw_user_account em3 on (acc.Actor3ID=em3.UserAccountID)
				WHERE Note <> ''  ";
		if ( isset($_REQUEST['poid']) && $_REQUEST['poid'] !="" ) {
			$sql .= "and acc.POID=".$_REQUEST['poid']." ";
		} elseif (isset($_REQUEST['poid'])=="") {
			$sql.="	and isComplete=0 ";
		} else {
			$sql.="	and isComplete=1 ";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and Actor3 between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}	
		$sql.=		"order by ApprovalID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ApprovalID' => $row->ApprovalID,
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'A1' => $row->A1,
				'A2' => $row->A2,
				'A3' => $row->A3,
				'POID' => $row->POID,
				'Note' => $row->Note,
				'Status' => $row->Status
			);
		};
	    return $show;
	}

// CUSTOMER================================================================
	function report_customer_deposit()
	{
		$show   = array();
		$sql = "SELECT tbm.*, bm.*, cm.ContactID, c.Company2, cd.DepositID FROM tb_bank_transaction tbm ";
		$sql .= "LEFT JOIN tb_bank_main bm ON bm.BankID = tbm.BankID ";
		$sql .= "LEFT JOIN tb_customer_main cm ON tbm.DepositCustomer = cm.CustomerID ";
		$sql .= "LEFT JOIN vw_contact2 c ON cm.ContactID = c.ContactID ";
		$sql .= "LEFT JOIN tb_customer_deposit cd ON tbm.BankTransactionID=cd.SourceReff AND cd.SourceType='BankTransaction' ";
		$sql .= "WHERE IsDeposit=1 ";
		
		if ( isset($_REQUEST['customer']) ) {
			$sql .= "and cm.CustomerID=".$_REQUEST['customer']." ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and BankTransactionDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}
		if ( empty($_POST) ) {
			$sql .= "and DepositCustomer is null ";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'DepositID' => $row->DepositID,
	  			'BankTransactionID' => $row->BankTransactionID,
	  			'BankName' => $row->BankName,
	  			'BankTransactionDate' => $row->BankTransactionDate,
				'BankTransactionNote' => $row->BankTransactionNote,
	  			'BankTransactionAmount' => $row->BankTransactionAmount,
	  			'BankTransactionBalance' => $row->BankTransactionBalance,
	  			'DepositCustomer' => $row->DepositCustomer,
	  			'fullname' => $row->Company2
			);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function report_customer_sales()
	{
		$show   = array();
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$filterstart = isset($_REQUEST['filterstart']) ? date('Y-m-01', strtotime($_REQUEST['filterstart'])) : date('d-m-Y');
		$filterend = isset($_REQUEST['filterend']) ? date('Y-m-t', strtotime($_REQUEST['filterend'])) : date('d-m-Y');
		
		$sql = "SELECT Count(CustomerID) as Jumlah, DetailType, SalesID, Company2 FROM `tb_customer_detail` join vw_sales_executive3_active on tb_customer_detail.DetailValue=vw_sales_executive3_active.SalesID where DetailType='sales' and isActive=1 ";
		$SalesID = $this->get_sales_child($SalesID);
		if ( $SalesID[0] != '0'){
			$sql .= "and ( SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		}
		else
		{
			
			$sql .= " ";
		}
		$sql .= "group by DetailValue order by DetailValue asc";

		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			

		  	$show[] = array(
				'SalesID' => $row->SalesID,
				'salesname' => $row->Company2,
				'TotalCustomer' => $row->Jumlah,
				'filterstart' => $filterstart,
				'filterend' => $filterend,
			);
		};
	    return $show;
	}
	function report_customer_sales_detail()
	{
		$show   = array();
		$SalesID = $this->input->get_post('id');
		$sql 	= "SELECT CustomerID, ContactID, Company2, CustomercategoryName, phone, Address, City, (SELECT sum(INVTotal) as total FROM `vw_invoice_balance` WHERE `CustomerID` =vw_customer5.CustomerID) as total   FROM `vw_customer5` WHERE `SalesID` LIKE '%".$SalesID."%' order by City asc, total desc";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row3) {
			  	$show[] = array(
					'CustomerID' => $row3->CustomerID,
					'ContactID' => $row3->ContactID,
					'Name' => $row3->Company2,
					'Category' => $row3->CustomercategoryName,
					'Phone' => $row3->phone,
					'City' => $row3->City,
				);


		};

	    return $show;
	}
	function report_customer_city()
	{
		$show   = array();
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql 	= "SELECT *, DATE_FORMAT((NOW() - INTERVAL 1 MONTH), '%Y-%m') AS Month2,
					DATE_FORMAT((NOW() - INTERVAL 2 MONTH), '%Y-%m') AS Month3,
					DATE_FORMAT((NOW() - INTERVAL 3 MONTH), '%Y-%m') AS Month4,
					DATE_FORMAT((NOW() - INTERVAL 4 MONTH), '%Y-%m') AS Month5,
					DATE_FORMAT((NOW() - INTERVAL 5 MONTH), '%Y-%m') AS Month6
					FROM tb_region_main";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$Month2 =$row->Month2;
		$Month3 =$row->Month3;
		$Month4 =$row->Month4;
		$Month5 =$row->Month5;
		$Month6 =$row->Month6;
		
		$sql = "SELECT COALESCE(sum(t1.CFU1),0) as CFUMonth,COALESCE (sum(t1.CV1),0) as CVMonth, 
					COALESCE(sum(t2.CFU1),0) as CFUYear,COALESCE (sum(t2.CV1),0) as CVYear, 
					Count(vc.CustomerID) AS TotalCustomer, vc.CityID, vc.CityName, COALESCE (Count(tdp.CustomerID),0) AS display, tcity.INVDate, tcity.Last, COALESCE (O1.total, 0) as Omzet1, COALESCE (O2.total, 0) as Omzet2, COALESCE (O3.total, 0) as Omzet3, COALESCE (O4.total, 0) as Omzet4, COALESCE (O5.total, 0) as Omzet5, COALESCE (O6.total, 0) as Omzet6
				FROM vw_customer3 vc 
				LEFT JOIN (
					SELECT ActivityReffNo as CustomerID, 
					SUM(IF (ActivityType = 'Customer Follow Up (CFU)',1,0)) AS CFU1, 
					SUM(IF (ActivityType = 'Customer Visit (CV)',1,0)) AS CV1 
					FROM tb_marketing_activity 
					where MONTH(InputDate)=MONTH(CURRENT_DATE()) AND YEAR(InputDate)=YEAR(CURRENT_DATE()) GROUP BY ActivityReffNo
				) t1 ON vc.CustomerID = t1.CustomerID
				LEFT JOIN (
					SELECT ActivityReffNo as CustomerID, 
					SUM(IF (ActivityType = 'Customer Follow Up (CFU)',1,0)) AS CFU1, 
					SUM(IF (ActivityType = 'Customer Visit (CV)',1,0)) AS CV1 
					FROM tb_marketing_activity 
					where YEAR(InputDate)=YEAR(CURRENT_DATE()) GROUP BY ActivityReffNo
				) t2 ON vc.CustomerID = t2.CustomerID
				LEFT JOIN ( 
					SELECT sm.CustomerID
					FROM tb_so_main sm
					WHERE sm.SOCategory = 4 AND sm.SOStatus = 1 
					GROUP BY sm.CustomerID
				) tdp ON tdp.CustomerID=vc.CustomerID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE MONTH(ib.INVDate) = MONTH(CURRENT_DATE()) AND YEAR(ib.INVDate)=YEAR(CURRENT_DATE())
					GROUP BY ib.CityID
				) O1 ON O1.CityID=vc.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month2."%'
					GROUP BY ib.CityID
				) O2 ON O2.CityID=vc.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month3."%'
					GROUP BY ib.CityID
				) O3 ON O3.CityID=vc.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month4."%'
					GROUP BY ib.CityID
				) O4 ON O4.CityID=vc.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month5."%'
					GROUP BY ib.CityID
				) O5 ON O5.CityID=vc.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month6."%'
					GROUP BY ib.CityID
				) O6 ON O6.CityID=vc.CityID
				LEFT JOIN (
					SELECT ib.CityID, MAX(ib.INVDate) As INVDate, DATEDIFF(NOW(),max(ib.INVDate)) as Last 
					FROM vw_invoice_balance ib ";
					if (in_array("report_customer_city_view_all", $MenuList)) {
						$sql .= "";
					} else {
						$SalesID = $this->get_sales_child($SalesID);
						$sql .= "where ( ib.CustomerID IN (
									SELECT CustomerID FROM vw_customer_sales2 
									WHERE SalesID IN (" . implode(',', array_map('intval', $SalesID)) . ") 
									) 
								)";
					} 

		$sql .=" GROUP BY ib.CityID
				) tcity ON tcity.CityID = vc.CityID
				WHERE vc.CityID!=0 "; 

		if (in_array("report_customer_city_view_all", $MenuList)) {
			$sql .= "";
		} else {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( vc.CustomerID IN (
						SELECT CustomerID FROM vw_customer_sales2 
						WHERE SalesID IN (" . implode(',', array_map('intval', $SalesID)) . ") 
						) 
					)";
		} 

		$sql .= " GROUP BY vc.CityName ORDER BY vc.CityName ASC";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show 	= $query->result_array();
	    return $show;
	}
	function report_customer_city_detail()
	{
		$show   = array();
		$CityID = $this->input->get_post('id');
		$SalesID = array( $this->session->userdata('SalesID') );

		$sql 	= "SELECT *, DATE_FORMAT((NOW() - INTERVAL 1 MONTH), '%Y-%m') AS Month2,
					DATE_FORMAT((NOW() - INTERVAL 2 MONTH), '%Y-%m') AS Month3,
					DATE_FORMAT((NOW() - INTERVAL 3 MONTH), '%Y-%m') AS Month4,
					DATE_FORMAT((NOW() - INTERVAL 4 MONTH), '%Y-%m') AS Month5,
					DATE_FORMAT((NOW() - INTERVAL 5 MONTH), '%Y-%m') AS Month6
					FROM tb_region_main";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$Month2 =$row->Month2;
		$Month3 =$row->Month3;
		$Month4 =$row->Month4;
		$Month5 =$row->Month5;
		$Month6 =$row->Month6;

		$sql 	= "SELECT v5.CustomerID, v5.SalesID, v5.Sales, v5.ContactID, v5.Company2, v5.isActive,
					v5.CustomercategoryName, v5.phone, v5.Address, v5.City, v5.CityID, 
					COALESCE (tl.total, 0) as total, tl.INVDate, tl.Last, COALESCE (tdp.display, 0) as display, ma.datecfu as CFU, ma.lastcfu, ma.QtyCFU,
					cv.datecv as CV, cv.lastcv, cv.QtyCV, COALESCE (bl.InvoiceLama,0) as total2,
					COALESCE (tl.total,0)+COALESCE (bl.InvoiceLama,0) as Omzet, COALESCE(tct.Status,0) as target, 
					COALESCE (C1.total, 0) as Cuzet1, COALESCE (C2.total, 0) as Cuzet2, COALESCE (C3.total, 0) as Cuzet3, COALESCE (C4.total, 0) as Cuzet4, 
					COALESCE (C5.total, 0) as Cuzet5, COALESCE (C6.total, 0) as Cuzet6
				FROM vw_customer5 v5
				LEFT JOIN (
					SELECT ib.CustomerID, MAX(ib.INVDate) As INVDate, sum(ib.INVTotal) as Total, DATEDIFF(NOW(),max(ib.INVDate)) as Last
					FROM vw_invoice_balance ib
					GROUP BY ib.CustomerID
				) tl ON tl.CustomerID=v5.CustomerID
				LEFT JOIN (
					SELECT max(ActivityDate) as datecfu, DATEDIFF(NOW(), max(ActivityDate)) as lastcfu, COUNT(ActivityID) AS QtyCFU, ActivityReffNo
					FROM tb_marketing_activity
					WHERE ActivityType like 'Customer Follow Up (CFU)'
					GROUP BY ActivityReffNo
				) ma ON ma.ActivityReffNo=v5.CustomerID
				LEFT JOIN (
					SELECT max(ActivityDate) as datecv, DATEDIFF(NOW(), max(ActivityDate)) as lastcv, COUNT(ActivityID) AS QtyCV, ActivityReffNo
					FROM tb_marketing_activity
					WHERE ActivityType like 'Customer Visit (CV)'
					GROUP BY ActivityReffNo
				) cv ON cv.ActivityReffNo=v5.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE MONTH(ib.INVDate) = MONTH(CURRENT_DATE()) AND YEAR(ib.INVDate)=YEAR(CURRENT_DATE())
					GROUP BY ib.CustomerID
				) C1 ON C1.CustomerID=v5.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month2."%'
					GROUP BY ib.CustomerID
				) C2 ON C2.CustomerID=v5.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month3."%'
					GROUP BY ib.CustomerID
				) C3 ON C3.CustomerID=v5.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month4."%'
					GROUP BY ib.CustomerID
				) C4 ON C4.CustomerID=v5.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month5."%'
					GROUP BY ib.CustomerID
				) C5 ON C5.CustomerID=v5.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month6."%'
					GROUP BY ib.CustomerID
				) C6 ON C6.CustomerID=v5.CustomerID
				LEFT JOIN tb_invoice_bo_lama bl ON v5.CustomerID=bl.CustomerID
				LEFT JOIN tb_customer_target tct ON v5.CustomerID=tct.CustomerID
				LEFT JOIN (
					SELECT sm.CustomerID, SUM(sd.ProductQty) as display
					FROM tb_so_main sm
					LEFT JOIN tb_so_detail sd ON sd.SOID = sm.SOID
					WHERE sm.SOCategory = 4 AND sm.SOStatus = 1
					GROUP BY sm.CustomerID ) tdp ON tdp.CustomerID=v5.CustomerID
				WHERE v5.CityID = '$CityID' ";
		$SalesID = $this->get_sales_child($SalesID);
		if ( $SalesID[0] != '0'){
			if($SalesID[0] == '233'){
				$sql .= " ";
			} else {
			$sql .= "AND ( v5.CustomerID IN ( SELECT CustomerID FROM vw_customer_sales2	WHERE SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ) )";
			}
		}
		else
		{
			$sql .= " ";
		}		
		$sql .=" ORDER BY v5.City ASC, Omzet desc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row3) {
			$isActive 	= ($row3->isActive!="0" ? "Yes" : "NoActive");
			$target 	= ($row3->target!="0" ? "target" : "Notarget");
			  	$show[] = array(
					'CustomerID' => $row3->CustomerID,
					'Sales' => $row3->Sales,
					'SalesID' => $row3->SalesID,
					'isActive' => $isActive,
					'target' => $target,
					'ContactID' => $row3->ContactID,
					'Name' => $row3->Company2,
					'total' => $row3->total,
					'total2' => $row3->total2,
					'display' => $row3->display,
					'Omzet' => $row3->Omzet,
					'Cuzet1' => $row3->Cuzet1,
					'Cuzet2' => $row3->Cuzet2,
					'Cuzet3' => $row3->Cuzet3,
					'Cuzet4' => $row3->Cuzet4,
					'Cuzet5' => $row3->Cuzet5,
					'Cuzet6' => $row3->Cuzet6,
					'INVDate' => $row3->INVDate,
					'Last' => $row3->Last,
					'Category' => $row3->CustomercategoryName,
					'Phone' => $row3->phone,
					'City' => $row3->City,
					'CFU' => $row3->CFU,
					'QtyCFU' => $row3->QtyCFU,
					'lastcfu' => $row3->lastcfu,
					'CV' => $row3->CV,
					'QtyCV' => $row3->QtyCV,
					'lastcv' => $row3->lastcv,
					'Address' => $row3->Address,
					'CityID' => $row3->CityID,
				);


		};

	    return $show;
	}
	function report_customer_complaint()
	{
		$show   = array();
		$show['info_filter'] = "";
		$Customer = $this->input->get_post('customer');
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sqldate = " WHERE OpenDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "Customer Complaint Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		} else { 
			$sqldate= "";
		}

		$sql = "SELECT cc.*, cm.Company2 as customer, cm.ContactID, em.Company2 as sales, 
				DATEDIFF(NOW(),(OpenDate)) as  lastday, sm.SOTotal, COALESCE(DATEDIFF((PMADate),(OpenDate)),0) as  lastday2, CityName  
				FROM tb_customer_complaint cc 
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=cc.SalesID) 
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID=cc.CustomerID)
				LEFT JOIN tb_so_main sm ON (cc.SOID=sm.SOID) ";
		if ($Customer != "" ) {		
			$sql .= " WHERE cm.Company2 like '%".$Customer."%' ";
		} else if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "") {
			$sql .= $sqldate;	
		} else {

			$sql .= " WHERE CloseDate ='0000-00-00'";
		}
		
		$sql .=" order by cc.ID desc limit ".$this->limit_result;
		// echo $sql;	
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function report_customer_complaint_add()
	{
		$CustomerID = $this->input->get_post('CustomerID'); 
		$SOID = $this->input->get_post('SOID');

		$sql 	= "SELECT vc2.*, vsl.SOID, vsl.SalesID, vsl.salesname as sales, tdm.DOID FROM vw_customer2 vc2 LEFT JOIN vw_so_list3 vsl on vc2.CustomerID=vsl.CustomerID LEFT JOIN (SELECT DOID, DOReff FROM `tb_do_main` WHERE `DOType` LIKE '%SO%') tdm ON tdm.DOReff=vsl.SOID where vc2.CustomerID=".$CustomerID." and vsl.SOID=".$SOID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0]; 
		
		$sql 			= "select max(Month) as month, max(id) as id from tb_customer_complaint";
		$query  		= $this->db->query($sql);
		$row 			= $query->row();
		$show['month'] 	= $row->month;
		$show['id'] 	= $row->id;
		$Month 			= date('Y-m');

		if ($show['month']==$Month){
			$sql 		= "select max(No) as no from tb_customer_complaint where month like '".$Month."'";
			$query  	= $this->db->query($sql);
			$row 		= $query->row();
			$show['no'] = $row->no;
		} else {
			$show['no'] = 0;
		}
	    return $show;
	}
	function report_customer_complaint_add_act()
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Code = $this->input->get_post('code'); 
		$No = $this->input->get_post('no');
		$id = $this->input->get_post('id');
		$CustomerID = $this->input->get_post('customerid');
		$SalesID = $this->input->get_post('salesid'); 
		$OpenDate = $this->input->get_post('date'); 
		$SOID = $this->input->get_post('soid');
		$DOID = $this->input->get_post('doid');
		$ComplaintLink = $this->input->get_post('link');
		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'ComplaintID' => $Code,
					'CustomerID' => $CustomerID,
					'SalesID' => $SalesID,
					'DOID' => $DOID,
					'SOID' => $SOID,
					'OpenDate' => $OpenDate,
					'PMADate' => '0000-00-00',
					'CloseDate' => '0000-00-00 00:00:00',
					'isApprove' => '0',
					'No' => $No,
					'ID' => $id,
					'Month' => $Month,
					'EmployeeID' => $EmployeeID,
					'ComplaintLink' => $ComplaintLink,

				);

		$this->db->insert('tb_customer_complaint', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	} 
	function report_customer_complaint_edit()
	{
		$ComplaintID = $this->input->get_post('ComplaintID'); 
		$sql 	= "SELECT tcc.*, vc3.Company2 as Customer, vse.Company2 as Sales 
					FROM tb_customer_complaint tcc
					LEFT JOIN vw_customer3 vc3 ON tcc.CustomerID=vc3.CustomerID 
					LEFT JOIN vw_sales_executive vse ON vse.SalesID=tcc.SalesID  
					WHERE ComplaintID like '".$ComplaintID."'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0]; 

	    return $show;
	}
	function report_customer_complaint_edit_act()
	{
		$this->db->trans_start();
		$ComplaintID = $this->input->get_post('ComplaintID');
		$PMADate = $this->input->get_post('PMAdate');
		$ComplaintLink = $this->input->get_post('link');
		$CloseDate = $this->input->get_post('ComplaintClose');
		if ($CloseDate=="1"){
			$date = date('Y-m-d');
		} else {
			$date ="0000-00-00";
		}

		if($PMADate == ""){ $PMA= "0000-00-00";
		} else {
			$PMA = $PMADate;
		} 

		$data = array(

					'PMADate' => $PMA,
					'CloseDate' => $date,
					'ComplaintLink' => $ComplaintLink
				);

		$this->db->where('ComplaintID', $ComplaintID);
		$this->db->update('tb_customer_complaint', $data);
		$this->last_query .= "//".$this->db->last_query();

   		if ($CloseDate=="1"){
   		// get actor 3 approval
			$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='so_complaint' ";
			$getActor3 	= $this->db->query($sql);
			$row 		= $getActor3->row();
			$Actor3 	= $row->Actor3;

			if ($Actor3 != 0) {
				$data_approval = array(
			        'ComplaintID' => $ComplaintID,
		        	'isComplete' => "0",
		        	'Status' => "OnProgress",
				);
				$this->db->insert('tb_approval_so_complaint', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			} else {

				$data_approval = array(
			        'ComplaintID' => $ComplaintID,
		        	'isComplete' => "1",
		        	'Status' => "Approved",
				);
				$this->db->insert('tb_approval_so_complaint', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	} 
	function report_customer_complaint_delete()
	{
		$this->db->trans_start();

		$ComplaintID = $this->input->get_post('ComplaintID'); 

		$this->db->where('ComplaintID', $ComplaintID);
		$this->db->delete('tb_customer_complaint');
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('ComplaintID', $ComplaintID);
		$this->db->delete('tb_approval_so_complaint');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function report_customer_display()
	{
		$show   = array();
		$SalesID = array( $this->session->userdata('SalesID') );
		$SODateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$SODateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql = "SELECT COUNT(DISTINCT sm.SOID) AS SOID, COUNT(DISTINCT sm.CustomerID) AS CustomerID,  
				vw_city.CityID, vc.City, sm.totaldo AS ProductQty, vc.SalesID
				FROM vw_so_list5 sm 
				LEFT JOIN vw_customer5 vc ON vc.CustomerID = sm.CustomerID
				LEFT JOIN vw_city ON vc.City = vw_city.CityName
				WHERE sm.SOCategory=4 AND sm.SOStatus=1 and sm.SOConfirm1=1 and sm.SOConfirm2=1 and sm.totaldo<>0
				";
		$SalesID = $this->get_sales_child($SalesID);
		if ( $SalesID[0] != '0'){
			$sql .= "and ( sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		}
		else
		{
			
			$sql .= " ";
		}			
		$sql .="GROUP BY vw_city.CityID Order by vc.City";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'CityID' => $row->CityID,
		  			'City' => $row->City,
		  			'CustomerID' => $row->CustomerID,
		  			'SOID' => $row->SOID,
		  			'ProductQty' => $row->ProductQty,
				);
		};
	    return $show;
	}
	function report_customer_display_detail()
	{
		$CityID = $this->input->get('city');
		$SalesID = array( $this->session->userdata('SalesID') );
		$sql = "SELECT sd.SOID, t1.Customer, t1.CustomerID, t1.SODate, sd.ProductName, sd.ProductQty, t1.SalesID, t1.Sales
				FROM (
				SELECT sm.SOID, sm.SODate, cm.Company2 as Customer, cm.CustomerID, cm.SalesID, cm.Sales FROM tb_so_main sm 
				LEFT JOIN vw_customer5 cm ON cm.CustomerID=sm.CustomerID
				LEFT JOIN vw_contact_address_city cc ON cm.ContactID=cc.ContactID 
				WHERE sm.SOCategory=4 AND sm.SOStatus=1 AND cc.CityID=".$CityID."
				) t1
				LEFT JOIN tb_so_detail sd ON sd.SOID=t1.SOID
				";
		$SalesID = $this->get_sales_child($SalesID);
		if ( $SalesID[0] != '0'){
			$sql .= "where ( t1.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		}
		else
		{
			
			$sql .= " ";
		}			
		
		$sql .= "order by t1.Customer ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();

		foreach ($query->result() as $row) {
		  	$show[] = array(
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'CustomerID' => $row->CustomerID,
				'Customer' => $row->Customer,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'Sales' => $row->Sales,
			);
		};
	    return $show;
	}
	function report_customer_consignment()
	{
		$show   = array();
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		$SODateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$SODateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql = "SELECT COUNT(DISTINCT sm.SOID) AS SOID, COUNT(DISTINCT sm.CustomerID) AS CustomerID,  
				vw_city.CityID, vc.City, SUM(sm.qty) AS ProductQty, SUM(sm.totaldo) AS ProductQtyDO
				FROM vw_so_list5 sm 
				LEFT JOIN vw_customer5 vc ON vc.CustomerID = sm.CustomerID
				LEFT JOIN vw_city ON vc.City = vw_city.CityName
				WHERE sm.SOCategory=2 AND sm.SOStatus=1 and sm.SOConfirm1=1 and sm.SOConfirm2=1
				";
		$SalesID = $this->get_sales_child($SalesID);
		if (in_array("report_customer_consignment_view_all", $MenuList)) {
			$sql .= " ";
		} 
		  elseif ( $SalesID[0] != '0'){
			$sql .= "and ( sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		}
		  else
		{
			$sql .= " ";
		}			
		$sql .="GROUP BY vw_city.CityID Order by vc.City";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'CityID' => $row->CityID,
		  			'City' => $row->City,
		  			'CustomerID' => $row->CustomerID,
		  			'SOID' => $row->SOID,
		  			'ProductQty' => $row->ProductQty,
		  			'ProductQtyDO' => $row->ProductQtyDO,
				);
		};
	    return $show;
	}
	function report_customer_consignment_detail()
	{
		$CityID = $this->input->get('city');
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		$sql = "SELECT
					t1.SOID, t1.SODate, t1.Company2 as Customer, t1.CustomerID, dm.*, dd.ProductID, dm.DOID, dm.DODate, DATEDIFF(NOW(),(dm.DODate)) as  lastday, 
					SUM(dd.ProductQty) AS ProductQty, t1.Sales,
					pm.ProductName
				FROM
					(
						SELECT
							sm.SOID,
							sm.SODate,
							sm.SalesID,
							se.Company2 AS Sales,
							se.Company2 AS SEC,
							vcus.Company2,
							sm.CustomerID
						FROM
							tb_so_main sm
						LEFT JOIN vw_sales_executive2 se ON (sm.SalesID = se.SalesID)
						LEFT JOIN tb_customer_main cm ON (
							sm.CustomerID = cm.CustomerID
						)
						LEFT JOIN vw_contact2 vcus ON (
							cm.ContactID = vcus.ContactID
						)
						LEFT JOIN vw_contact_address_city cc ON cm.ContactID=cc.ContactID
						WHERE
							sm.SOCategory = 2 AND sm.SOStatus=1 and sm.SOConfirm1=1 and sm.SOConfirm2=1 AND cc.CityID=".$CityID." ";
		$SalesID = $this->get_sales_child($SalesID);
		
		if (in_array("report_customer_consignment_view_all", $MenuList)) {
			$sql .= " ";
		} 
		 elseif ( $SalesID[0] != '0'){
			$sql .= "and ( sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		}
		 else
		{	
		 $sql .= " ";
		}			
		
		$sql .= ") t1
				LEFT JOIN tb_do_main dm ON t1.SOID = dm.DOReff
				AND dm.DOType = 'SO'
				LEFT JOIN tb_do_detail dd ON (dd.DOID = dm.DOID)
				LEFT JOIN tb_product_main pm ON (dd.ProductID = pm.ProductID)
				GROUP BY
					dm.DOID,
					dd.ProductID,
					dd.SalesOrderDetailID
				HAVING
					ProductQty > 0
				ORDER BY DOID Desc	";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();

		foreach ($query->result() as $row) {
		  	$show[] = array(
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'DOID' => $row->DOID,
				'DODate' => $row->DODate,
				'lastday' => $row->lastday,
				'CustomerID' => $row->CustomerID,
				'Customer' => $row->Customer,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'Sales' => $row->Sales,
			);
		};
	    return $show;
	}
	
// employee================================================================
	function report_employee_login_hours()
	{
		$show   = array();
		$show['info_filter'] = "";

		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sqlSub = "SELECT EmployeeID, MAX(DateTime) AS EndTime, LoginTime, 
				IF( (TIMESTAMPDIFF(MINUTE,LoginTime,MAX(DateTime))) < 1, 1, (TIMESTAMPDIFF(MINUTE,LoginTime,MAX(DateTime))) ) AS LoginMinute 
				FROM tb_history_user_page ";
		
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sqlSub .= "WHERE (LoginTime between '".$datestart."' AND '".$dateend."') ";
			$show['info_filter'] .= "Filter Date : ".$datestart." <> ".$dateend."<br>";
		} else { 
			$sqlSub .= "WHERE MONTH(LoginTime)=MONTH(CURRENT_DATE()) AND YEAR(LoginTime)=YEAR(CURRENT_DATE()) ";
		}
		$sqlSub .= "GROUP BY EmployeeID, LoginTime ";

		$sql = "SELECT em.EmployeeID, em.fullname, COALESCE(sum(t1.LoginMinute),0) AS LoginMinute 
				FROM vw_employee4 em
				left join (".$sqlSub.") t1 on em.EmployeeID = t1.EmployeeID
				WHERE em.isActive=1 
				GROUP BY EmployeeID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) { 
		  	$show['main'][] = array(
	  			'EmployeeID' => $row->EmployeeID,
	  			'fullname' => $row->fullname,
	  			'LoginMinute' => $row->LoginMinute,
	  			'datestart' => $datestart,
	  			'dateend' => $dateend,
			);
		};
	    return $show;
	}
	function report_employee_login_hours_detail()
	{
		$show   = array();
		$EmployeeID = $_REQUEST['id'];
		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sqlSub = "SELECT EmployeeID, TIME(MAX(DateTime)) AS EndTime, TIME(MAX(LoginTime)) AS LoginTime, 
				DATE(LoginTime) AS LoginDate, IF( (TIMESTAMPDIFF(MINUTE,LoginTime,MAX(DateTime))) < 1, 1, (TIMESTAMPDIFF(MINUTE,LoginTime,MAX(DateTime))) ) AS LoginMinute 
				FROM tb_history_user_page 
				WHERE (LoginTime between '".$datestart."' AND '".$dateend."') 
				AND EmployeeID = ".$EmployeeID."
				GROUP BY EmployeeID, LoginTime ";
		$query 	= $this->db->query($sqlSub);
		$show 	= $query->result_array();
	    return $show;
	}
	function report_employee_penalty()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = $this->session->userdata('EmployeeID');
		$MenuList = $this->session->userdata('MenuList');

		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql = "SELECT tep.EmployeeID, fullname, COUNT(tep.EmployeeID) as penalty, SUM(tep.Nominal) AS Nominal FROM tb_employee_penalty tep LEFT JOIN vw_user_account ve2 ON tep.EmployeeID=ve2.UserAccountID ";
		
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= " WHERE (Date between '".$datestart."' AND '".$dateend."') ";
			$show['info_filter'] .= "Filter Date : ".$datestart." <> ".$dateend."<br>";
		} else { 
			$sql .= " WHERE MONTH(Date)=MONTH(CURRENT_DATE()) AND YEAR(Date)=YEAR(CURRENT_DATE()) ";
		}
		if (in_array("report_employee_penalty_view_all", $MenuList)) {
			$sql .= " ";
		} else {
			$sql .= " AND tep.EmployeeID =".$EmployeeID;
		}
		$sql .= " Group by tep.EmployeeID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) { 
		  	$show['main'][] = array(
	  			'EmployeeID' => $row->EmployeeID,
	  			'fullname' => $row->fullname,
	  			'penalty' => $row->penalty,
	  			'Nominal' => $row->Nominal,
	  			'datestart' => $datestart,
	  			'dateend' => $dateend,
			);
		};
	    return $show;
	}
	function report_employee_penalty_detail()
	{
		$show   = array();
		$EmployeeID = $_REQUEST['id'];
		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql = "SELECT tep.EmployeeID, tep.Nominal, tep.PenaltyOrderID , tep.Quantity as Poin , tpm.Quantity , tep.Date, tpm.PenaltyName, tpm.PenaltyType, tep.Punisher, tep.Link, tep.Note, ve2.fullname, tpm.Note as Potongan		 
				FROM tb_employee_penalty tep
				LEFT JOIN tb_penalty_main tpm ON tep.PenaltyID =tpm.PenaltyID
				LEFT JOIN vw_user_account ve2 ON ve2.UserAccountID=tep.Punisher
				WHERE (Date between '".$datestart."' AND '".$dateend."') 
				AND tep.EmployeeID = ".$EmployeeID."
				";
		// echo $sql;		
		$query 	= $this->db->query($sql);
		$show 	= $query->result_array();
	    return $show;
	}
	function report_employee_overtime()
	{
		$show   = array();
		$show['info_filter'] = "";
		$bulan=date('Y-m');
		$OTDate = $this->input->get_post('filterstart');
		$OTDate2= $this->input->get_post('filterend');
		if ($OTDate && $OTDate2 != "") {
			$OTDate = date_create($this->input->get_post('filterstart'));
			$OTDate2 = date_create($this->input->get_post('filterend'));
			$OTDate = date_format($OTDate, "Y-m-d");
			$OTDate2 = date_format($OTDate2, "Y-m-t");

			$sqlOTDate = "WHERE (teo.OverTimeDate between '".$OTDate."' AND '".$OTDate2."') ";
			$sqlOTDate2 = "WHERE (teo2.OverTimeDate between '".$OTDate."' AND '".$OTDate2."') ";
		} else {
			$sqlOTDate = "WHERE MONTH(teo.OverTimeDate)=MONTH(CURRENT_DATE()) AND YEAR(teo.OverTimeDate)=YEAR(CURRENT_DATE()) ";
			$sqlOTDate2 = "WHERE MONTH(teo2.OverTimeDate)=MONTH(CURRENT_DATE()) AND YEAR(teo2.OverTimeDate)=YEAR(CURRENT_DATE()) ";

		}

		$sql = "SELECT ot.ApprovalID,teo.EmployeeID,tao.OTID, teo.EmployeeID, teo.OverTimeDate, teo.TimeStart, teo.TimeEnd, teo.Job, teo.Qty, ve4.fullname,
						teo.isApprove, SEC_TO_TIME(time_to_sec(teo.TimeEnd-teo.TimeStart))
					As Duration,
						tsql.timeSum
					FROM
						tb_approval_overtime tao
					LEFT JOIN tb_employee_overtime teo on tao.OTID=teo.OTID
					LEFT JOIN tb_approval_overtime ot on ot.OTID=teo.OTID
					LEFT JOIN vw_employee4 ve4 ON ve4.EmployeeID = teo.EmployeeID
					LEFT JOIN (SELECT teo2.EmployeeID,SEC_TO_TIME( SUM(time_to_sec(teo2.TimeEnd-teo2.TimeStart)))
								As timeSum
								FROM
								tb_employee_overtime teo2 "
								.$sqlOTDate2.
								"group by teo2.EmployeeID
					) tsql ON teo.EmployeeID = tsql.EmployeeID "
					.$sqlOTDate.
					"AND tao.isComplete=0 ";
			// if ($OverTimeDate && $OverTimeDate2 != "") {
			// 	$OverTimeDate = date_create($this->input->get_post('filterstart'));
			// 	$OverTimeDate2 = date_create($this->input->get_post('filterend'));
			// 	$OverTimeDate = date_format($OverTimeDate, "Y-m-d");
			// 	$OverTimeDate2 = date_format($OverTimeDate2, "Y-m-t");

			// 	$sql .= "where (teo.OverTimeDate between '".$OverTimeDate."' AND '".$OverTimeDate2."') ";

			// } else {

			// 	$sql .= "where teo.OverTimeDate like '%".$bulan."%' ";

			// }
// echo $sql;
			// $sql .= "GROUP BY SalesID
			// 	) t1
			// 	LEFT JOIN vw_sales_executive2 vse On vse.SalesID=t1.SalesID ";

		// $EmployeeID = array( $this->session->userdata('UserAccountID') );
		// $SalesID = array( $this->session->userdata('SalesID') );
		// $MenuList = $this->session->userdata('MenuList');

		// if (in_array("marketing_activity_linked", $MenuList)) {
  //       	$this->load->model('model_report');
		// 	$SalesID = $this->model_report->get_sales_child($SalesID);
		// 	$sql .= "Where t1.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		// } elseif (in_array("marketing_activity_all", $MenuList)) {
		// 	$sql .= "Where t1.SalesID<>'' ";
		// }
		// 	$sql .= "order by t1.SalesID desc limit ".$this->limit_result;
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
// do======================================================================
	function report_do_not_inv()
	{
		$sql = "(
				SELECT dm.*, wm.WarehouseName, sm.PaymentWay, sc.CategoryName, 
				se.Company2 as Sales, sec.Company2 as SEC, vem.fullname as employee, vcus.Company2, 
				fp.PaymentAmount, dd.DOQty, dsp.PriceAmount 
				FROM tb_do_main dm 
				LEFT JOIN vw_user_account vem ON (dm.DOBy = vem.UserAccountID)
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID) 
				LEFT JOIN vw_sales_executive2 se ON (sm.SalesID = se.SalesID) 
				LEFT JOIN vw_sales_executive2 sec ON (sm.SECID = sec.SalesID) 
				LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID) 
				LEFT JOIN vw_contact2 vcus ON (cm.ContactID = vcus.ContactID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
				LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
				LEFT JOIN tb_fc_payment fp ON (dm.DOID=fp.DOID) 
				LEFT JOIN vw_do_detail_group_by dd ON (dd.DOID=dm.DOID) 
				LEFT JOIN vw_do_so_detail_price_group dsp ON dm.DOID=dsp.DOID 
				where sm.INVCategory=1 AND sm.SOCategory in (1,2,7) 
				AND dm.DOID NOT IN ( SELECT im.DOID FROM tb_invoice_main im ) AND dd.DOQty>0 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}
		$sql .= "GROUP BY dm.DOID ) UNION ALL (";
		$sql .= "SELECT dm.*, wm.WarehouseName, sm.PaymentWay, sc.CategoryName, 
				se.Company2 as Sales, sec.Company2 as SEC, vem.fullname as employee, vcus.Company2, 
				fp.PaymentAmount, dd.DOQty, dsp.PriceAmount 
				FROM tb_do_main dm 
				LEFT JOIN vw_user_account vem ON (dm.DOBy = vem.UserAccountID)
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID) 
				LEFT JOIN vw_sales_executive2 se ON (sm.SalesID = se.SalesID) 
				LEFT JOIN vw_sales_executive2 sec ON (sm.SECID = sec.SalesID) 
				LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID) 
				LEFT JOIN vw_contact2 vcus ON (cm.ContactID = vcus.ContactID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
				LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
				LEFT JOIN tb_fc_payment fp ON (dm.DOID=fp.DOID) 
				LEFT JOIN vw_do_detail_group_by dd ON (dd.DOID=dm.DOID) 
				LEFT JOIN vw_do_so_detail_price_group dsp ON dm.DOID=dsp.DOID 
				where dm.DOStatus<>1 AND sm.SOCategory not in (1,2,7) AND dd.DOQty>0 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}
		$sql .= "GROUP BY dm.DOID )";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		$SOID 	= array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'DOID' => $row->DOID,
	  			'Reff' => $row->DOType." ".$row->DOReff." ".$row->CategoryName,
	  			'Company' => $row->PaymentWay.' - '.$row->Company2,
	  			'Sales' => $row->Sales,
	  			'SEC' => $row->SEC,
				'WarehouseName' => $row->WarehouseName,
	  			'DODate' => $row->DODate,
	  			'DOStatus' => $row->DOStatus,
	  			'Employee' => $row->employee,
	  			'DONote' => $row->DONote,
	  			'DOQty' => $row->DOQty,
	  			'PaymentAmount' => $row->PaymentAmount,
	  			'PriceAmount' => $row->PriceAmount,
			);

		  	array_push($SOID, $row->DOReff);
		};
	    return $show;
	}
	function report_do_not_inv_per_customer($CustomerID)
	{
		$sql = "SELECT dd.*, dm.DODate, sc.CategoryName, sm.SOID, pm.ProductName
				FROM tb_do_main dm
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID)
				LEFT JOIN tb_so_category sc ON ( sm.SOCategory = sc.CategoryID )
				LEFT JOIN tb_do_detail dd ON (dm.DOID = dd.DOID)
				LEFT JOIN tb_product_main pm ON (dd.ProductID = pm.ProductID)
				where dd.ProductQty>0 and sm.CustomerID=".$CustomerID." and dm.DOStatus<>1 and sm.INVCategory=1";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'SOID' => $row->SOID,
	  			'CategoryName' => $row->CategoryName,
	  			'DOID' => $row->DOID,
	  			'DODate' => $row->DODate,
	  			'ProductName' => $row->ProductName,
	  			'ProductQty' => $row->ProductQty,
			);
		};
	    return $show;
	}
	function query_report_do_not_inv()
	{
		$sql = "SELECT COUNT(t1.DOID) AS CountDO, 
				SUM(CASE WHEN t1.CategoryName = 'Consignment' THEN 1 ELSE 0 END) AS CountConsignment,
				SUM(CASE WHEN t1.CategoryName = 'Sales' THEN 1 ELSE 0 END) AS CountSales
				FROM (

				(SELECT dm.*, sm.PaymentWay, sc.CategoryName, fp.PaymentAmount, SUM(dd.ProductQty) AS DOQty 
				FROM tb_do_main dm
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID)
				LEFT JOIN tb_so_category sc ON ( sm.SOCategory = sc.CategoryID)
				LEFT JOIN tb_fc_payment fp ON (dm.DOID = fp.DOID)
				LEFT JOIN tb_do_detail dd ON (dd.DOID = dm.DOID)
				WHERE sm.INVCategory = 1 AND sm.SOCategory in (1,2,7) 
				AND dm.DOID NOT IN ( SELECT im.DOID FROM tb_invoice_main im ) ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}
		$sql .= "GROUP BY dm.DOID having(DOQty)>0 
				)  union all ("; 
		$sql .= "SELECT dm.*, sm.PaymentWay, sc.CategoryName, fp.PaymentAmount, SUM(dd.ProductQty) AS DOQty 
				FROM tb_do_main dm
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID)
				LEFT JOIN tb_so_category sc ON ( sm.SOCategory = sc.CategoryID)
				LEFT JOIN tb_fc_payment fp ON (dm.DOID = fp.DOID)
				LEFT JOIN tb_do_detail dd ON (dd.DOID = dm.DOID)
				WHERE dm.DOStatus<>1 AND sm.SOCategory not in (1,2,7) ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}
		$sql .= "GROUP BY dm.DOID having(DOQty)>0 
				) ) t1";
	    return $sql;
	}
	function report_do_global()
	{
		$show = array();
		$show['info_filter'] = "";
		$sql = "SELECT dm.*, wm.WarehouseName, sm.PaymentWay, sc.CategoryName, se.Company2 as Sales, vem.fullname as employee, 
				vcus.Company2, fp.PaymentAmount, SUM(dd.ProductQty) AS DOQty, sm.ShipAddress 
				FROM tb_do_main dm 
				LEFT JOIN vw_user_account vem ON (dm.DOBy = vem.UserAccountID)
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID) 
				LEFT JOIN vw_sales_executive2 se ON (sm.SalesID = se.SalesID) 
				LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID) 
				LEFT JOIN vw_contact2 vcus ON (cm.ContactID = vcus.ContactID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
				LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
				LEFT JOIN tb_fc_payment fp ON (dm.DOID=fp.DOID) 
				LEFT JOIN tb_do_detail dd ON (dd.DOID=dm.DOID) 
				where dm.DOType='SO'  ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}
		
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "") {
			$sql .= "and dm.DODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "dm.DOID in (SELECT DISTINCT DOID FROM tb_do_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID : ".$atributevalue[$i]."<br>";
						break;
					case 'DONote':
						$sql .= "dm.DONote like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "DONote contains ".$atributevalue[$i]."<br>";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Warehouse : ".$atributevalue[$i]."<br>";
						break;
					case 'DOID':
						$sql .= "dm.DOID like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "DOID contains ".$atributevalue[$i]."<br>";
						break;
					case 'DOReff':
						$sql .= "dm.DOReff like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "DOReff contains ".$atributevalue[$i]."<br>";
						break;
					case 'DOType':
						$sql .= "dm.DOType like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "DOType contains ".$atributevalue[$i]."<br>";
						break;
					case 'Company':
						$sql .= "dm.DOReff in (SELECT SOID FROM tb_so_main sm
								LEFT JOIN vw_customer2 s1 ON sm.CustomerID=s1.CustomerID
								WHERE s1.Company2 LIKE '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Company contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		
		if (empty($_POST)) {
			$sql .= "and MONTH(dm.DODate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DODate) = YEAR(CURRENT_DATE()) ";
		}
		$sql .= "GROUP BY dm.DOID ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
          	$ShipAddress  = explode(";",$row->ShipAddress);
		  	$show['main'][] = array(
	  			'DOID' => $row->DOID,
	  			'Reff' => $row->DOType." ".$row->DOReff." ".$row->CategoryName,
	  			'Company' => $row->PaymentWay.' - '.$row->Company2,
	  			'Sales' => $row->Sales,
				'WarehouseName' => $row->WarehouseName,
	  			'DODate' => $row->DODate,
	  			'DOStatus' => $row->DOStatus,
	  			'Employee' => $row->employee,
	  			'DONote' => $row->DONote,
	  			'DOQty' => $row->DOQty,
	  			'PaymentAmount' => $row->PaymentAmount,
	  			'ShipAddress' => $ShipAddress[1].', '.$ShipAddress[2],
			);
		};
	    return $show;
	}
	function report_do_fc()
	{
		$show 	= array();
		$show['info_filter'] = "";
		$sql = "SELECT fc.*, GROUP_CONCAT(dd.DistributionID SEPARATOR ', ') AS DistributionID
				FROM tb_fc_payment fc
				LEFT JOIN tb_bank_distribution_detail dd ON dd.ReffType='DO' AND dd.ReffNo=fc.DOID ";

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) &&  $_REQUEST['input2'] != "" ) {
			$sql .= "WHERE PaymentDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['input1']." <> ".$_REQUEST['input2']."<br>";
		} else {
			$sql .= "WHERE dd.DistributionID is NULL ";
		}
		$sql .= "GROUP BY fc.DOID ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'DOID' => $row->DOID,
	  			'Company' => $row->ExpeditionName,
	  			'Doc' => $row->ExpeditionReff,
	  			'Date' => $row->PaymentDate,
	  			'Amount' => $row->PaymentAmount,
	  			'DistributionID' => $row->DistributionID,
			);
		};
	    return $show;
	}
	function report_do_consignment()
	{
		$sql = "SELECT t1.*, dm.*, DATEDIFF(NOW(),(dm.DODate)) as  lastday, dd.ProductID, SUM(dd.ProductQty) AS ProductQty, pm.ProductName
				FROM (
				SELECT sm.SOID, sm.SODate, sm.SalesID, se.Company2 AS Sales, sec.Company2 AS SEC, vcus.Company2
				FROM tb_so_main sm 
				LEFT JOIN vw_sales_executive2 se ON (sm.SalesID = se.SalesID)
				LEFT JOIN vw_sales_executive2 sec ON (sm.SECID = sec.SalesID)
				LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID)
				LEFT JOIN vw_contact2 vcus ON (cm.ContactID = vcus.ContactID)
				WHERE sm.SOCategory=2 ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}

		$sql .= ") t1 
				LEFT JOIN tb_do_main dm ON t1.SOID=dm.DOReff AND dm.DOType='SO'
				LEFT JOIN tb_do_detail dd ON (dd.DOID = dm.DOID)
				LEFT JOIN tb_product_main pm ON (dd.ProductID = pm.ProductID)
				WHERE	dm.DOID NOT IN (SELECT DOID FROM tb_invoice_main )
				GROUP BY dm.DOID, dd.ProductID, dd.SalesOrderDetailID
				HAVING ProductQty > 0";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		$SOID 	= array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'DOID' => $row->DOID,
	  			'Date' => $row->SODate,
	  			'DOReff' =>$row->DOReff,
	  			'Reff' => $row->DOType." ".$row->DOReff,
	  			'Company' => $row->Company2,
	  			'Sales' => $row->Sales,
	  			'lastday' => $row->lastday,
	  			'SEC' => $row->SEC,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
	  			'ProductQty' => $row->ProductQty,
			);

		  	array_push($SOID, $row->DOReff);
		};
		// print_r($SOID);
	    return $show;
	}
	function report_do_late_so()
	{
		$show = array();
		$show['info_filter'] = "";
		$sql = "SELECT t1.*, dm.* 
				FROM ( 
					SELECT sm.SOID, sm.SODate, sm.SOShipDate, sm.SalesID, se.Company2 AS Sales, sec.Company2 AS SEC, 
					vcus.Company2 AS Customer
					FROM tb_so_main sm
					LEFT JOIN vw_sales_executive2 se ON (sm.SalesID = se.SalesID)
					LEFT JOIN vw_sales_executive2 sec ON (sm.SECID = sec.SalesID)
					LEFT JOIN tb_customer_main cm ON ( sm.CustomerID = cm.CustomerID )
					LEFT JOIN vw_contact2 vcus ON ( cm.ContactID = vcus.ContactID ) ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_do_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_do_linked", $MenuList)) {
			$sql .= "where sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_do_all", $MenuList)) {
			$sql .= "where sm.SalesID<>'' ";
		}

		$sql .= " and sm.SOCategory<>2) t1 
				LEFT JOIN tb_do_main dm ON t1.SOID = dm.DOReff
				WHERE dm.DOType = 'SO' ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "") {
			$sql .= "and dm.DODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "DO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}
		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) { 
					case 'DOID':
						$sql .= "dm.DOID like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "DO ID : ".$atributevalue[$i]."<br>";
						break; 
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if (empty($_POST)) {
			$sql .= "AND dm.DODate > t1.SOShipDate ";
		}

		$sql .= "GROUP BY dm.DOID
				 order by dm.DOID desc limit ".$this->limit_result." ";
 
		$query 	= $this->db->query($sql);
		// $show   = array();
		foreach ($query->result() as $row) {
			$date2=date_create($row->SOShipDate);
			$date1=date_create($row->DODate);
			$diff=date_diff($date1,$date2);
			$late_days = $diff->format("%R%a days");

		  	$show['main'][] = array(
	  			'DOID' => $row->DOID,
	  			'DODate' => $row->DODate,
	  			'ScheduleDate' => $row->SOShipDate,
	  			'late_days' => $late_days,
	  			'Reff' => $row->DOType." ".$row->DOReff,
	  			'SOID' => $row->SOID,
	  			'Company' => $row->Customer,
	  			'Sales' => $row->Sales,
	  			'SEC' => $row->SEC,
			);
		};
	    return $show;
	}
	function report_do_schedule()
	{
		$show   = array();
		$show['info_filter'] = "";
		$sql = "SELECT sl.* FROM vw_so_list5 sl where SOConfirm2=1 and outstandingdo > 0 ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SOShipDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "DO Scedule : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if ( !empty($_POST) ) {
			$sql .= "GROUP BY sl.SOID order by sl.SOShipDate asc";
		} else { 
			$sql .= "GROUP BY sl.SOID order by sl.SOShipDate asc limit ".$this->limit_result." ";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  		'SOShipDate' => $row->SOShipDate,
		  		'SOID' => $row->SOID,
		  		'CategoryName' => $row->CategoryName,
				'Customer' => $row->Company,
				'ShipAddress' => $row->ShipAddress,
				'SONote' => $row->SONote,
				'salesname' => $row->salesname,
				'secname' => $row->secname,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding' => ($row->qty-$row->totaldo),
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
	}
	// ----------------------------------------------------------
	function report_do_product()
	{
		$this->db->trans_start();
		$show = array();
		$show['info_filter'] = "";
		$DODateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$DODateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sqldate = "WHERE (DODate between '".$DODateStart."' AND '".$DODateEnd."') ";
			$sqlsodate = "WHERE (SODate between '".$DODateStart."' AND '".$DODateEnd."') ";
			$show['info_filter'] .= "DO Date : ".$_REQUEST['datestart']." <> ".$_REQUEST['datestart']."<br>";
		} else {
			$sqldate = "WHERE MONTH(DODate)=MONTH(CURRENT_DATE()) AND YEAR(DODate)=YEAR(CURRENT_DATE()) ";
			$sqlsodate = "WHERE MONTH(SODate)=MONTH(CURRENT_DATE()) AND YEAR(SODate)=YEAR(CURRENT_DATE()) ";
		}
		if (isset($_REQUEST['type']) && $_REQUEST['type'] != "ALL") {
			// $sql .= "and DOType=".$_REQUEST['type']." ";
			$sqltype = "and dpd.DOType='".$_REQUEST['type']."'";
			$show['info_filter'] .= "DO Type : ".$_REQUEST['type']."<br>";
		} else {
			$sqltype = "";
		}

		$sql2 = "SELECT * FROM tb_so_category ";
		$query2 	= $this->db->query($sql2);
		foreach ($query2->result() as $row) {
		  	$show['socategory'][]= array(
	  			'CategoryID' => $row->CategoryID,
	  			'CategoryName' => $row->CategoryName,
			);
		};

		$sql 	= "SELECT dpd.ProductID, pm.ProductCategoryID, pm.ProductBrandID, pm.ProductCode, dpd.DODate, tsales.Qty as tsalesqty , treplacement.Qty as treplacementqty , tdisplay.Qty as tdisplayqty , tbonus.Qty as tbonusqty , tsample.Qty as tsampleqty , DOSO.SOQty, PO.POQty, Mutation.MutationQty, 
					SUM(dpd.ProductQty) AS ProductQty FROM tb_do_detail dpd
					LEFT JOIN tb_product_main pm ON dpd.ProductID=pm.ProductID 
					LEFT JOIN tb_so_main tsm ON dpd.DOReff=tsm.SOID
					LEFT JOIN (
						SELECT ProductID, sum(ProductQty) as SOQty FROM tb_do_detail dpd ".$sqldate." AND DOType LIKE '%SO%' GROUP BY ProductID
					) AS DOSO ON DOSO.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT ProductID, sum(ProductQty) as POQty FROM tb_do_detail dpd ".$sqldate." AND DOType LIKE '%PO%' GROUP BY ProductID
					) AS PO ON PO.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT ProductID, sum(ProductQty) as MutationQty FROM tb_do_detail dpd ".$sqldate." AND DOType LIKE '%Mutation%' GROUP BY ProductID
					) AS Mutation ON Mutation.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT
							tdd.ProductID, SUM(tdd.ProductQty) AS Qty
						FROM
							tb_do_detail tdd
						LEFT JOIN tb_so_main tsm ON tdd.DOReff = tsm.SOID
						".$sqldate."
						AND tsm.SOConfirm2 = 1
						AND tsm.SOCategory IN (1,2,7)
						GROUP BY ProductID
						ORDER BY
							tdd.ProductID ASC
					) tsales ON tsales.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT
							tsd.ProductID, SUM(tsd.ProductQty) AS Qty
						FROM
							tb_do_detail tsd
						LEFT JOIN tb_so_main tsm ON tsd.DOReff = tsm.SOID
						".$sqldate."
						AND tsm.SOConfirm2 = 1
						AND tsm.SOCategory = 4
						GROUP BY ProductID
						ORDER BY
							tsd.ProductID ASC
					) tdisplay ON tdisplay.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT
							tsd.ProductID, SUM(tsd.ProductQty) AS Qty
						FROM
							tb_do_detail tsd
						LEFT JOIN tb_so_main tsm ON tsd.DOReff = tsm.SOID
						".$sqldate."
						AND tsm.SOConfirm2 = 1
						AND tsm.SOCategory = 3
						GROUP BY ProductID
						ORDER BY
							tsd.ProductID ASC
					) treplacement ON treplacement.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT
							tsd.ProductID, SUM(tsd.ProductQty) AS Qty
						FROM
							tb_do_detail tsd
						LEFT JOIN tb_so_main tsm ON tsd.DOReff = tsm.SOID
						".$sqldate."
						AND tsm.SOConfirm2 = 1
						AND tsm.SOCategory = 5
						GROUP BY ProductID
						ORDER BY
							tsd.ProductID ASC
					) tbonus ON tbonus.ProductID=dpd.ProductID
					LEFT JOIN (
						SELECT
							tsd.ProductID, SUM(tsd.ProductQty) AS Qty
						FROM
							tb_do_detail tsd
						LEFT JOIN tb_so_main tsm ON tsd.DOReff = tsm.SOID
						".$sqldate."
						AND tsm.SOConfirm2 = 1
						AND tsm.SOCategory = 6
						GROUP BY ProductID
						ORDER BY
							tsd.ProductID ASC
					) tsample ON tsample.ProductID=dpd.ProductID
					 ".$sqldate.$sqltype;

		if (isset($_REQUEST['socategory']) && $_REQUEST['socategory'] != "0") {
			if ($_REQUEST['socategory']==1){
				$socategory="Sales";
			} else if ($_REQUEST['socategory']==2){
				$socategory="Consignment";
			} else if ($_REQUEST['socategory']==3){
				$socategory="Replacement";
			} else if ($_REQUEST['socategory']==4){
				$socategory="Display";
			} else if ($_REQUEST['socategory']==5){
				$socategory="Bonus";
			} else if ($_REQUEST['socategory']==7){
				$socategory="Sales Offline";
			} else {
				$socategory="Sample";
			}
			$sql .= "and tsm.SOCategory='".$_REQUEST['socategory']."'";
			$show['info_filter'] .= "SO Category : ".$socategory."<br>";
		}

        $this->load->model('model_master');
        if (!empty($_REQUEST['category'] )) {
        	$category = explode('_', $_REQUEST['category']);
        	$category_full_child = $this->model_master->get_full_category_child_id($category[0]);
			$sql .= "and pm.ProductCategoryID in (". implode(',', array_map('intval', $category_full_child)) .") ";
			$show['info_filter'] .= "Category : ".$category[1]."<br>";
		}
        if (!empty($_REQUEST['brand'] )) {
        	$brand = explode('_', $_REQUEST['brand']);
        	$brand_full_child = $this->model_master->get_full_brand_child_id($brand[0]);
			$sql .= "and pm.ProductBrandID in (". implode(',', array_map('intval', $brand_full_child)) .") ";
			$show['info_filter'] .= "Brand : ".$brand[1]."<br>";
		}
		$sql .= "GROUP BY dpd.ProductID ORDER BY dpd.ProductID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][]= array(
				'ProductID' => $row->ProductID,
				'ProductCategoryID' => $row->ProductCategoryID,
				'ProductCode' => $row->ProductCode,
				'SOQty' => $row->SOQty,
				'tsalesqty' => $row->tsalesqty,
				'tdisplayqty' => $row->tdisplayqty,
				'treplacementqty' => $row->treplacementqty,
				'tbonusqty' => $row->tbonusqty,
				'tsampleqty' => $row->tsampleqty,
				'POQty' => $row->POQty,
				'MutationQty' => $row->MutationQty,
				'ProductQty' => $row->ProductQty,
				'DODate' => $row->DODate,
				'DODateStart' => $DODateStart,
				'DODateEnd' => $DODateEnd,
			);
		};
		
	    return $show;
	}
	function report_do_product_detail()
	{
		$show   = array();
		$ProductID	= $this->input->get_post('id');
		$DODateStart = date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$DODateEnd 	= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT ip.DODate, ip.ProductQty, ip.reff FROM vw_do_reff_product_detail ip
					WHERE (ip.DODate between '".$DODateStart."' AND '".$DODateEnd."') AND ip.ProductID=".$ProductID." order by ip.DODate";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'DODate' => $row->DODate,
				'ProductQty' => $row->ProductQty,
				'reff' => $row->reff,
			);
		};
	    return $show;
	}

// so======================================================================
	function report_so_global()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		$sql = "SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID, tsm.ShopName , tsm2.INVMP
				FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID 
				LEFT JOIN tb_shop_main tsm ON tsm.ShopID = sl.ShopID
				LEFT JOIN tb_so_main2 tsm2 ON sl.SOID = tsm2.SOID ";
				
		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( sl.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sl.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "where sl.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "where sl.SalesID<>'' ";
		}

		if (isset($_REQUEST['type']) && $_REQUEST['type'] != 'all') {
			$sql .= "and sl.SOType='".$_REQUEST['type']."' ";
			$show['info_filter'] .= "SO Type : ".$_REQUEST['type']."<br>";
		}


		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'ProductName':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "ProductName contains ".$atributevalue[$i]."<br>";
						break;
					case 'ShopName':
						$sql .= "tsm.ShopName like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "ShopName contains ".$atributevalue[$i]."<br>";
						break;	
					case 'Company':
						$sql .= "CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "sl.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					case 'Category':
						$sql .= "SOCategory in (SELECT CategoryID FROM tb_so_category WHERE CategoryName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "SO Category contains ".$atributevalue[$i]."<br>";
						break;
					case 'SOID':
						$sql .= "sl.SOID like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "SO ID contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= $atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "all") {
			$status = explode('_', $_REQUEST['status']);
			$sql .= "and SOStatus = ".$status[0]." ";
			$show['info_filter'] .= "SO Status : ".$status[1]."<br>";
		}

		if ( !empty($_POST) ) {
			$sql .= "GROUP BY sl.SOID ";
		} else {
			$sql .= "GROUP BY sl.SOID order by sl.SOID desc limit ".$this->limit_result." ";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);

			$TotalDepositPerc = $this->get_percent($row->SOTotal, $row->TotalDeposit);
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $row->TotalPayment);

		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'RegionID' => $row->RegionID,
				'SECID' => $row->SECID,
				'NPWP' => $row->NPWP,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'SOCategory' => $row->SOCategory,
				'SODate' => $row->SODate,
				'SOShipDate' => $row->SOShipDate,
				'SOTerm' => $row->SOTerm,
				'SONote' => $row->SONote,
				'ExpeditionID' => $row->ExpeditionID,
				'ExpeditionPrice' => $row->ExpeditionPrice,
				'ExpeditionWeight' => $row->ExpeditionWeight,
				'FreightCharge' => $row->FreightCharge,
				'SOTotalBefore' => $row->SOTotalBefore,
				'TaxRate' => $row->TaxRate,
				'TaxAmount' => $row->TaxAmount,
				'SOTotal' => $row->SOTotal,
				'ModifiedDate' => $row->ModifiedDate,
				'ModifiedBy' => $row->ModifiedBy,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
				'PermitNote' => $row->PermitNote,
				'Company' => $row->Company,
				'secname' => $row->secname,
				'salesname' => $row->salesname,
				'ShopName' => $row->ShopName,
				'CategoryName' => $row->CategoryName,
				'SOType' => $row->SOType,
				'DPMinimumPercent' => $row->DPMinimumPercent,
				'DPMinimumAmount' => $row->DPMinimumAmount,

				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding' => $row->totaldo-$row->qty,
				'note' => $row->note,
				'ROID' => $row->ROID,
				'POID' => $row->POID,
				'INVMP' => $row->INVMP,
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
	}
	function report_so_resi_mp()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql2 = "SELECT * FROM tb_warehouse_main ";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
			$show['warehouse'][]= array(
				'WarehouseID' => $row->WarehouseID,
				'WarehouseName' => $row->WarehouseName,
			);
		};

		$sql = "SELECT sl.SOID, sl.SODate, sl.SOShipDate, sl.SOConfirm1, sl.SOStatus, sl.SOConfirm2, cm.Company2 as Company, vem2.Company2 as salesname, sc.CategoryName, tsm.INVMP, tsm.Label, tw1.WarehouseName AS Putat, tw2.WarehouseName AS Margo
				FROM tb_so_main sl 
				LEFT JOIN vw_customer2 cm ON cm.CustomerID = sl.CustomerID
				LEFT JOIN vw_sales_executive2 vem2 ON vem2.SalesID=sl.SalesID
				LEFT JOIN tb_so_category sc ON sc.CategoryID=sl.SOCategory
				LEFT JOIN tb_so_main2 tsm ON tsm.SOID=sl.SOID
				LEFT JOIN (
					SELECT SOID, tsd.ProductID, tpsm.WarehouseID, twm.WarehouseName FROM tb_so_detail tsd
					LEFT JOIN tb_product_stock_main tpsm ON tpsm.ProductID =tsd.ProductID
					LEFT JOIN tb_warehouse_main twm ON twm.WarehouseID=tpsm.WarehouseID
					where tpsm.WarehouseID='11' AND Quantity>0
					GROUP BY SOID
				) tw1 ON tw1.SOID=sl.SOID
				LEFT JOIN (
					SELECT SOID, tsd.ProductID, tpsm.WarehouseID, twm.WarehouseName FROM tb_so_detail tsd
					LEFT JOIN tb_product_stock_main tpsm ON tpsm.ProductID =tsd.ProductID
					LEFT JOIN tb_warehouse_main twm ON twm.WarehouseID=tpsm.WarehouseID
					where tpsm.WarehouseID='13' AND Quantity>0
					GROUP BY SOID
				) tw2 ON tw2.SOID=sl.SOID ";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "WHERE SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		} elseif (isset($_REQUEST['invmp']) && $_REQUEST['invmp'] != '') {
			$sql .= " WHERE tsm.INVMP='".$_REQUEST['invmp']."' ";
			$show['info_filter'] .= "INVOICE MP : ".$_REQUEST['invmp']."<br>";
		} else {
			$sql.=" WHERE sl.InputDate >= CURDATE() ";
		}
		$sql .= "GROUP BY sl.SOID order by sl.SOID desc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][] = array(
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'SOShipDate' => $row->SOShipDate,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
				'Company' => $row->Company,
				'salesname' => $row->salesname,
				'INVMP' => $row->INVMP,
				'Label' => $row->Label,
				'CategoryName' => $row->CategoryName,
				'Putat' => $row->Putat,
				'Margo' => $row->Margo,
			);
		};
	    return $show;
	}
	function report_so_outstanding_do()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql2 = "SELECT * FROM tb_warehouse_main ";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
			$show['warehouse'][]= array(
				'WarehouseID' => $row->WarehouseID,
				'WarehouseName' => $row->WarehouseName,
			);
		};

		$sql = "SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID,
				GROUP_CONCAT( DISTINCT sdd.stockReady ORDER BY sdd.stockReady SEPARATOR ',' ) AS stockReady 
				FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID ";
		if (isset($_REQUEST['WarehouseID'])) {
			$sql .= "LEFT JOIN (
					SELECT sd.SOID AS SOID, sd.SalesOrderDetailID AS SalesOrderDetailID, sd.ProductID AS ProductID, 
					sd.ProductName AS ProductName, sd.ProductQty AS ProductQty, sd.ProductWeight AS ProductWeight,
					( sd.ProductQty - sd.Pending ) AS totaldo, 0 AS totaldor, sd.Pending AS pending, 
					( sd.ProductWeight * ( sd.ProductQty - sd.Pending ) ) AS totalweight,
					sm.SOConfirm1 AS SOConfirm1, sm.SOConfirm2 AS SOConfirm2, sm.SOStatus AS SOStatus, COALESCE(ps.stock,0) AS stock,
					IF ( ( (sm.SOStatus = 1) AND ( sd.Pending > 0 ) AND ( ps.stock >= sd.Pending ) ), 'Ready', 'NotReady' ) AS stockReady
					FROM ( ( tb_so_detail sd
					LEFT JOIN tb_so_main sm ON ((sd.SOID = sm.SOID)))
					LEFT JOIN (
						SELECT psm.ProductID AS ProductID, sum(psm.Quantity) AS stock
						FROM tb_product_stock_main psm
						WHERE psm.WarehouseID IN (" . implode(',', array_map('intval', $_REQUEST['WarehouseID'])) . ")
						GROUP BY psm.ProductID
					) ps ON ( ( sd.ProductID = ps.ProductID ) ) )
					WHERE sd.Pending > 0
				) sdd ON sl.SOID=sdd.SOID ";
		} else {
			$sql .= "LEFT JOIN vw_so_do_detail4 sdd ON sl.SOID=sdd.SOID ";
		}
			$sql.=" WHERE (sl.totaldo < qty) and sl.SOStatus = 1 and sl.SOConfirm1 = 1 and sl.SOConfirm2 = 1 ";

		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "and SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "and SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}
		
		$sql .= "GROUP BY sl.SOID order by sl.SOID desc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);
			$TotalOutstanding = number_format($row->TotalOutstanding,2);

			$TotalDepositPerc = $this->get_percent($row->SOTotal, $row->TotalDeposit);
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $row->TotalPayment);

			$date2=date_create($row->SOShipDate);
			$date1=date_create(date('Y-m-d'));
			$diff=date_diff($date1,$date2);
			$late_days = $diff->format("%r%a");

		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'RegionID' => $row->RegionID,
				'SECID' => $row->SECID,
				'NPWP' => $row->NPWP,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'SOCategory' => $row->SOCategory,
				'SODate' => $row->SODate,
				'SOShipDate' => $row->SOShipDate,
				'SOTerm' => $row->SOTerm,
				'SONote' => $row->SONote,
				'ExpeditionID' => $row->ExpeditionID,
				'ExpeditionPrice' => $row->ExpeditionPrice,
				'ExpeditionWeight' => $row->ExpeditionWeight,
				'FreightCharge' => $row->FreightCharge,
				'SOTotalBefore' => $row->SOTotalBefore,
				'TaxRate' => $row->TaxRate,
				'TaxAmount' => $row->TaxAmount,
				'SOTotal' => $row->SOTotal,
				'ModifiedDate' => $row->ModifiedDate,
				'ModifiedBy' => $row->ModifiedBy,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
				'PermitNote' => $row->PermitNote,
				'Company' => $row->Company,
				'secname' => $row->secname,
				'salesname' => $row->salesname,
				'CategoryName' => $row->CategoryName,
				'SOType' => $row->SOType,
				'DPMinimumPercent' => $row->DPMinimumPercent,
				'DPMinimumAmount' => $row->DPMinimumAmount,
				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'outstanding_payment' => $TotalOutstanding,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding_do' => $row->totaldo-$row->qty,
				'note' => $row->note,
				'ROID' => $row->ROID,
				'POID' => $row->POID,
				'late_days' => $late_days,
				'stockReady' => $row->stockReady,
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
	}
	function query_report_so_outstanding_do()
	{
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT COUNT(t1.SOID) AS CountSO, SUM(t1.qty)-SUM(t1.totaldo) AS CountQty,
				SUM(CASE WHEN t1.SOShipDate < CURDATE() THEN 1 ELSE 0 END) AS SO_late
				FROM (
				SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID 
				FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID
				WHERE (totaldo < qty) and SOStatus = 1 and SOConfirm1 = 1 and SOConfirm2 = 1 ";

		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "and SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "and SalesID<>'' ";
		}
		
		$sql .= "GROUP BY sl.SOID order by sl.SOID desc
				) t1";

	    return $sql;
	}
	function report_so_outstanding_payment()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID
				WHERE (sl.TotalDeposit+sl.TotalPayment)<sl.DPMinimumAmount and (totaldo < qty) and SOStatus = 1 and SOConfirm1 = 1 ";

		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "and SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "and SalesID<>'' ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		$sql .= "GROUP BY sl.SOID order by sl.SOID desc";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);
			$TotalOutstanding = number_format($row->TotalOutstanding,2);

			$TotalDepositPerc = $this->get_percent($row->SOTotal, $row->TotalDeposit);
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $row->TotalPayment);

			$date2=date_create($row->SOShipDate);
			$date1=date_create(date('Y-m-d'));
			$diff=date_diff($date1,$date2);
			$late_days = $diff->format("%r%a");

		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'RegionID' => $row->RegionID,
				'SECID' => $row->SECID,
				'NPWP' => $row->NPWP,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'SOCategory' => $row->SOCategory,
				'SODate' => $row->SODate,
				'SOShipDate' => $row->SOShipDate,
				'SOTerm' => $row->SOTerm,
				'SONote' => $row->SONote,
				'ExpeditionID' => $row->ExpeditionID,
				'ExpeditionPrice' => $row->ExpeditionPrice,
				'ExpeditionWeight' => $row->ExpeditionWeight,
				'FreightCharge' => $row->FreightCharge,
				'SOTotalBefore' => $row->SOTotalBefore,
				'TaxRate' => $row->TaxRate,
				'TaxAmount' => $row->TaxAmount,
				'SOTotal' => $row->SOTotal,
				'ModifiedDate' => $row->ModifiedDate,
				'ModifiedBy' => $row->ModifiedBy,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
				'PermitNote' => $row->PermitNote,
				'Company' => $row->Company,
				'secname' => $row->secname,
				'salesname' => $row->salesname,
				'CategoryName' => $row->CategoryName,
				'SOType' => $row->SOType,
				'DPMinimumPercent' => $row->DPMinimumPercent,
				'DPMinimumAmount' => $row->DPMinimumAmount,
				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'outstanding_payment' => $TotalOutstanding,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding_do' => $row->totaldo-$row->qty,
				'note' => $row->note,
				'ROID' => $row->ROID,
				'POID' => $row->POID,
				'late_days' => $late_days,
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
	}
	function report_so_product()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$Category	= $this->input->get_post('category');
		$Brand = $this->input->get_post('brand');

		$MenuList = $this->session->userdata('MenuList');
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sqldate = " WHERE tsm.SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		} else {
			$sqldate = " WHERE MONTH(tsm.SODate)=MONTH(CURRENT_DATE()) AND YEAR(SODate)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT tsd.ProductID, tsd.ProductName, tpm.Productcode, tpm.ProductCategoryID, tpm.ProductBrandID,tsm.SODate, COALESCE(tday.Qty, 0) as SalesDay,
				COALESCE(tsales.Qty, 0) as Sales, COALESCE(tdisplay.Qty, 0) as Display, COALESCE(tbonus.Qty, 0) as Bonus, 
				SUM(tsd.ProductQty) AS TotalQty, SUM(tsd.PriceTotal) AS PriceTotal, 
				plp.MaxStock AS MaxStock, plp.MinStock AS MinStock, 
				COALESCE (ppo.pending, 0) AS popending,
				COALESCE (pso.pending, 0) AS sopending,
				COALESCE (prw.pending, 0) AS rawpending,
				plp.stock - (COALESCE (pso.pending, 0) + COALESCE (prw.pending, 0)) AS stockReady
				FROM tb_so_detail tsd
				LEFT JOIN tb_so_main tsm ON tsd.SOID=tsm.SOID
				LEFT JOIN tb_product_main tpm ON tsd.ProductID = tpm.ProductID
				LEFT JOIN vw_product_list_popup7_active plp ON plp.ProductID=tsd.ProductID
				LEFT JOIN vw_stock_pending_po2 ppo ON tsd.ProductID = ppo.ProductID
				LEFT JOIN vw_stock_pending_so2 pso ON plp.ProductID = pso.ProductID
				LEFT JOIN vw_stock_pending_raw3 prw ON plp.ProductID = prw.ProductID
				LEFT JOIN (
					SELECT * FROM tb_product_atribute_detail
					WHERE ProductAtributeID = '20' GROUP BY ProductID
				) tad on tad.ProductID=tpm.ProductID
				LEFT JOIN (
					SELECT
						tsd.ProductID, SUM(tsd.ProductQty) AS Qty
					FROM
						tb_so_detail tsd
					LEFT JOIN tb_so_main tsm ON tsd.SOID = tsm.SOID
					WHERE DAY ( tsm.SODate )= DAY (CURRENT_DATE ())
					AND MONTH ( tsm.SODate )= MONTH (CURRENT_DATE ())
					AND YEAR ( SODate )= YEAR (CURRENT_DATE ())
					AND tsm.SOConfirm2 = 1
					AND tsm.SOCategory IN (1,2,7)
					GROUP BY ProductID
					ORDER BY
						tsd.SOID DESC
				) tday ON tday.ProductID=tsd.ProductID
				LEFT JOIN (
					SELECT
						tsd.ProductID, SUM(tsd.ProductQty) AS Qty
					FROM
						tb_so_detail tsd
					LEFT JOIN tb_so_main tsm ON tsd.SOID = tsm.SOID
					".$sqldate."
					AND tsm.SOConfirm2 = 1
					AND tsm.SOCategory IN (1,2,7)
					GROUP BY ProductID
					ORDER BY
						tsd.SOID DESC
				) tsales ON tsales.ProductID=tsd.ProductID
				LEFT JOIN (
					SELECT
						tsd.ProductID, SUM(tsd.ProductQty) AS Qty
					FROM
						tb_so_detail tsd
					LEFT JOIN tb_so_main tsm ON tsd.SOID = tsm.SOID
					".$sqldate."
					AND tsm.SOConfirm2 = 1
					AND tsm.SOCategory = 4
					GROUP BY ProductID
					ORDER BY
						tsd.SOID DESC
				) tdisplay ON tdisplay.ProductID=tsd.ProductID
				LEFT JOIN (
					SELECT
						tsd.ProductID, SUM(tsd.ProductQty) AS Qty
					FROM
						tb_so_detail tsd
					LEFT JOIN tb_so_main tsm ON tsd.SOID = tsm.SOID
					".$sqldate."
					AND tsm.SOConfirm2 = 1
					AND tsm.SOCategory = 5
					GROUP BY ProductID
					ORDER BY
						tsd.SOID DESC
				) tbonus ON tbonus.ProductID=tsd.ProductID
						";
		
		$sql .=$sqldate." AND tsm.SOConfirm2=1 ";
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != "0" ) {
			$sql .= " AND tpm.ProductCategoryID=".$_REQUEST['category'];
			// $show['info_filter'] .= "Category : ".$_REQUEST['category']."<br>";
		}
		if (isset($_REQUEST['brand']) && $_REQUEST['brand'] != "0" ) {
			$sql .= " AND tpm.ProductBrandID=".$_REQUEST['brand'];
			// $show['info_filter'] .= "Brand : ".$_REQUEST['brand']."<br>";
		}
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {
			$sql1 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 AND ProductAtributeValueCode='".$_REQUEST['origin']."'";
			// echo $sql1;
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;
			$sql .= "AND tad.AtributeValue like '".$_REQUEST['origin']."' ";
			$show['info_filter'] .= "Source Of Origin : ".$Origin."<br>";
		}
		$sql .= " GROUP BY ProductID ORDER BY tsd.SOID desc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			
			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductCode' => $row->Productcode,
				'ProductName' => $row->ProductName,
				'popending' => $row->popending,
				'stockReady' => $row->stockReady,
				'MaxStock' => $row->MaxStock,
				'MinStock' => $row->MinStock,
				'SalesDay' => $row->SalesDay,
				'Sales' => $row->Sales,
				'Display' => $row->Display,
				'Bonus' => $row->Bonus,
				'TotalQty' => $row->TotalQty,
				'PriceTotal' => $row->PriceTotal,
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};

	    return $show;
	}
	function report_so_product_detail()
	{
		$show = array();
		$ProductID = $this->input->get_post('product');

		$sql = "SELECT pm.ProductName, tsd.SOID, tsm.SODate, tsm.SOConfirm2, tsd.ProductQty, vc3.Company2, tsc.CategoryName, tsd.PriceAmount from tb_so_detail tsd
				LEFT JOIN tb_product_main pm ON tsd.ProductID=pm.ProductID
				LEFT JOIN tb_so_main tsm ON tsm.SOID=tsd.SOID
				LEFT JOIN tb_so_category tsc ON tsm.SOCategory=tsc.CategoryID
				LEFT JOIN vw_customer3 vc3 ON vc3.CustomerID=tsm.CustomerID
				LEFT JOIN tb_invoice_main tim ON tim.SOID=tsm.SOID
				WHERE tsd.ProductID='".$ProductID."' AND tsm.SOStatus=1
				AND tsm.SODate = DATE(NOW())
				ORDER BY tsm.SOID";
		// echo $sql;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['pricelist'][] = array(
				'ProductName' => $row->ProductName,
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'ProductQty' => $row->ProductQty,
				'Company2' => $row->Company2,
				'CategoryName' => $row->CategoryName,
				'SOConfirm2' => $row->SOConfirm2,
				'PriceAmount' => $row->PriceAmount,
			);
		};
		return $show;
	}
	function report_so_detail()
	{
		$show   = array();
		$SOID 	= $this->input->get_post('id');
		$sql 	= "SELECT sm.*, vs.Company, vem1.Company2 as secname, vem2.Company2 as salesname, sc.CategoryName, 
					vsb.TotalDeposit, vsb.TotalPayment, tsm.ShopName, tsm2.INVMP, tsm2.ResiNo, tsm2.label from tb_so_main sm 
					LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID)
					LEFT JOIN tb_contact vs ON (cm.ContactID = vs.ContactID)
					LEFT JOIN vw_sales_executive2 vem1 ON (sm.SECID = vem1.SalesID)
					LEFT JOIN vw_sales_executive2 vem2 ON (sm.SalesID = vem2.SalesID) 
					LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
					LEFT JOIN vw_so_balance vsb ON (sm.SOID = vsb.SOID)
					LEFT JOIN tb_shop_main tsm ON (sm.ShopID = tsm.ShopID) 
					LEFT JOIN tb_so_main2 tsm2 ON (sm.SOID = tsm2.SOID)
					WHERE sm.SOID = ".$SOID;
					// echo $sql;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();
		$show['main'] = (array) $rowso;

		$show['stock'] = array();
		$sql 	= "SELECT sd.*, (sd.ProductQty-sd.Pending) AS totaldo, pm.ProductCode FROM tb_so_detail sd
					LEFT JOIN tb_product_main pm ON ( sd.ProductID=pm.ProductID )
					WHERE sd.SOID =".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'SalesOrderDetailID' => $row->SalesOrderDetailID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'ProductQty' => $row->ProductQty,
				'totaldo' => $row->totaldo
			);
			
			if (!array_key_exists($row->ProductID, $show['stock'])) {
				$sql = "SELECT wm.WarehouseName, psm.Quantity FROM tb_product_stock_main psm
						LEFT JOIN tb_warehouse_main wm ON psm.WarehouseID = wm.WarehouseID
						WHERE psm.ProductID=".$row->ProductID;
				$query 	= $this->db->query($sql);
				foreach ($query->result() as $row2) {
					  	$show['stock'][$row->ProductID][] = array(
				  			'WarehouseName' => $row2->WarehouseName,
				  			'Quantity' => $row2->Quantity
						);
				};
			}

			$sql = "SELECT dm.DOID, dm.DODate, dd.ProductQty FROM tb_do_detail dd
					LEFT JOIN tb_do_main dm ON (dd.DOID=dm.DOID)
					WHERE dm.DOType='SO' AND dm.DOReff=".$SOID." and dd.ProductID=".$row->ProductID." 
					and dd.SalesOrderDetailID=".$row->SalesOrderDetailID;
			$query 	= $this->db->query($sql);
			$DOID = "";
			foreach ($query->result() as $row3) {
				$DOID .= $row3->DOID.",";
				$show['do'][$row->ProductID][$row->SalesOrderDetailID][] = array(
					'DOID' => $row3->DOID,
		  			'DODate' => $row3->DODate,
		  			'ProductQty' => $row3->ProductQty
				);
			};

			if ($DOID != "") {
				$DOID = substr($DOID,0,-1);	
				$sql = "SELECT im.INVID, im.DOID, im.INVDate, id.ProductID, id.SalesOrderDetailID, id.ProductQty
						FROM tb_invoice_main im 
						LEFT JOIN tb_invoice_detail id ON im.INVID=id.INVID
						WHERE im.DOID IN (".$DOID.") and id.ProductID=".$row->ProductID." and id.SalesOrderDetailID=".$row->SalesOrderDetailID;
				$query 	= $this->db->query($sql);
				foreach ($query->result() as $row4) {
					if ($row4->ProductQty > 0) {
							$show['inv'][$row4->ProductID][$row4->SalesOrderDetailID][] = array(
								'INVID' => $row4->INVID,
								'DOID' => $row4->DOID,
								'ProductID' => $row4->ProductID,
								'SalesOrderDetailID' => $row4->SalesOrderDetailID,
					  			'INVDate' => $row4->INVDate,
					  			'ProductQty' => $row4->ProductQty
							);
					}
				};
			}
		};

		$sql 	= "SELECT dd.*, em.fullname FROM tb_so_due_date dd
					LEFT JOIN vw_user_account em ON dd.CreatedBy=em.UserAccountID
					WHERE dd.SOID =".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row3) {
			  	$show['shipDate'][] = array(
					'SOShipDate' => $row3->SOShipDate,
					'CreatedDate' => $row3->CreatedDate,
					'fullname' => $row3->fullname,
				);
		};

		$sql5 = "SELECT * FROM tb_so_file WHERE SOID=".$SOID;
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
	  		$show['SOfile'][] = array(
			  	'SOFileID' => $row5->SOFileID,
			  	'SOID' => $row5->SOID,
			  	'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};

	    return $show;
	}
	function report_so_display_detail_by_customer()
	{
		$show   = array();
		$CustomerID	= $this->input->get_post('id');
		$sql 	= "SELECT sm.SOID, sm.SODate, sd.ProductName, sd.ProductQty, 
					p.ProductCategoryName, p.ProductBrandName FROM tb_so_detail sd
					LEFT JOIN tb_so_main sm ON sd.SOID=sm.SOID
					LEFT JOIN vw_product_list_popup5 p ON sd.ProductID=p.ProductID
					WHERE sm.CustomerID=".$CustomerID." and SOCategory=4 and SOStatus=1 and SOConfirm1=1 and SOConfirm2=1";
		$query 	= $this->db->query($sql);
		// echo $sql;
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
			);
		};
	    return $show;
	}
	function so_note()
	{
		$this->db->trans_start();
		$show   = array();
		$sonote = $this->input->post('sonote');
		$soid	= $this->input->post('soid'); 

		$data = array(
			'NoteType' => 'SO',
			'NoteReff' => $soid,
			'NoteDateTime' => date('Y-m-d H:i:s'),
			'NoteBy' => $this->session->userdata('UserAccountID'),
			'NoteText' => $sonote
		);
		$this->db->insert('tb_note', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function report_so_sales()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$filterstart = isset($_REQUEST['filterstart']) ? date('Y-m-01', strtotime($_REQUEST['filterstart'])) : date('d-m-Y');
		$filterend = isset($_REQUEST['filterend']) ? date('Y-m-t', strtotime($_REQUEST['filterend'])) : date('d-m-Y');
		
		$sql = "SELECT vsl.SalesID, salesname, SUM(SOTotal) AS SOTotal, 
				COALESCE(t1.CTTotal, 0) AS CTTotal, SUM(TotalDeposit) AS TotalDeposit, SUM(TotalPayment) AS TotalPayment 
				FROM vw_so_list3 vsl
				LEFT JOIN (
					SELECT SalesID, sum(SOTotal) as CTTotal FROM `vw_so_list3` WHERE `SOCategory` = '2' ";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "") {
			$sql .= "and (SODate between '".$filterstart."' AND '".$filterend."') ";
		} else { 
			$sql .= " and MONTH(SODate)=MONTH(CURRENT_DATE()) AND YEAR(SODate)=YEAR(CURRENT_DATE()) ";
		}			
		$sql .= " GROUP BY SalesID
				) t1 ON vsl.SalesID = t1.SalesID ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "") {
			$sql .= "where (SODate between '".$filterstart."' AND '".$filterend."') ";
			$show['info_filter'] .= "SO Date : ".$filterstart." <> ".$filterend."<br>";
		} else { 
			$sql .= "where MONTH(SODate)=MONTH(CURRENT_DATE()) AND YEAR(SODate)=YEAR(CURRENT_DATE()) ";
		}

		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or vsl.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "and vsl.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "and vsl.SalesID<>'' ";
		}

		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "all") {
			$status = explode('_', $_REQUEST['status']);
			$sql .= "and SOStatus = ".$status[0]." ";
			$show['info_filter'] .= "SO Status : ".$status[1]."<br>";
		}
		$sql .= "GROUP BY vsl.SalesID order by salesname asc";
		// echo $sql;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$SOTotal 	  = number_format($row->SOTotal,2);
			$CTTotal 	  = number_format($row->CTTotal,2);
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);
			$TotalOutstanding = number_format($row->SOTotal - ($row->TotalDeposit + $row->TotalPayment),2);

		  	$show['main'][] = array(
				'SalesID' => $row->SalesID,
				'salesname' => $row->salesname,
				'SOTotal' => $SOTotal,
				'CTTotal' => $CTTotal,
				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalOutstanding' => $TotalOutstanding,
				'filterstart' => $filterstart,
				'filterend' => $filterend,
			);
		};
	    return $show;
	}
	function report_so_sales_detail()
	{
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = $this->input->get('id', TRUE);
		$MenuList = $this->session->userdata('MenuList');

		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		
		$sql = "SELECT 	SODate, SOID, Company, SOTotal, TotalOutstanding 
				FROM vw_so_list5 sl where SOStatus=1 and SOConfirm1=1 and (SODate between '".$datestart."' AND '".$dateend."') AND sl.SalesID=".$SalesID." order by SODate";
		$query 	= $this->db->query($sql);
		$show   = array();

		foreach ($query->result() as $row) {
		  	$show[] = array(
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'Company' => $row->Company,
				'SOTotal' => $row->SOTotal,
				'TotalOutstanding' => $row->TotalOutstanding,
				'filterstart' => $datestart,
				'filterend' => $dateend,
			
			);
		};
	    return $show;
	}
	function report_so_sales_detail_month()
	{
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = $this->input->get('id', TRUE);
		$MenuList = $this->session->userdata('MenuList');

		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');
		
		$sql = "SELECT SalesID, salesname,
				CONCAT(YEAR(SODate), '-', MONTH(SODate)) AS SODate,
				SUM(TotalOutstanding) AS TotalOutstanding,
				SUM(SOTotal) AS SOTotal FROM vw_so_list5 
				where SOStatus=1 and SOConfirm1=1 and (SODate between '".$datestart."' AND '".$dateend."') AND SalesID=".$SalesID." 
				GROUP BY SalesID, YEAR(SODate), MONTH(SODate) order by SODate";
		$query 	= $this->db->query($sql);
		$show   = array();

		$totalLast = 0;
		$idLast	= 0;
		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->SOTotal;
			}
			$Progress = (($row->SOTotal - $totalLast) / $totalLast) * 100;
			if ($totalLast == $row->SOTotal) {
				$Progress = 100;
			}

		  	$show[] = array(
				'SalesID' => $row->SalesID,
				'SODate' => $row->SODate,
				'salesname' => $row->salesname,
				'SOTotal' => $row->SOTotal,
				'TotalOutstanding' => $row->TotalOutstanding,
				'Progress' => $Progress,
				'filterstart' => $datestart,
				'filterend' => $dateend,
			);
			$totalLast = $row->SOTotal;
		};
	    return $show;
	}
	function report_so_shop()
	{
		$show = array();
		$show['info_filter'] = "";

		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql 	= "SELECT
						shm.ShopName, shm.ShopID, COALESCE(t1.TotalSO, 0) as TotalSO , t1.SODate, t1.SODate2, COALESCE(t1.ProductQty, 0) as ProductQty,t1.SalesName, COALESCE(t1.SOTotal, 0) as SOTotal
					FROM
						tb_shop_main shm
					LEFT JOIN (
						SELECT sm.ShopID, COUNT(sm.SOID) AS TotalSO, CONCAT(YEAR (sm.SODate),'-', LPAD(MONTH(sm.SODate), 2, '0')) AS SODate,
							SUM(sd.ProductQty) AS ProductQty, SUM(sm.SOTotal) AS SOTotal,
							CONCAT(YEAR (sm.SODate), '-', LPAD(MONTH(sm.SODate), 2, '0'),'-','01') AS SODate2,
							GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName
						FROM tb_so_main sm
						LEFT JOIN tb_so_detail sd ON (sm.SOID = sd.SOID)
						LEFT JOIN vw_sales_executive2 se ON se.SalesID = sm.SalesID ";

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= "WHERE (SODate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Filter Date : ".$INVDateStart." <> ".$INVDateEnd."<br>";	
		} else { 
			$sql .= "WHERE MONTH(SODate)=MONTH(CURRENT_DATE()) AND YEAR(SODate)=YEAR(CURRENT_DATE()) ";
		}

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		if (in_array("report_inv_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( sm.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_inv_linked", $MenuList)) {
			$sql .= "and sm.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_inv_all", $MenuList)) {
			$sql .= "and sm.SalesID<>'' ";
		}

		$sql .= "GROUP BY
				sm.ShopID, MONTH (sm.SODate), YEAR (sm.SODate)
				) t1 ON t1.ShopID = shm.ShopID
				ORDER BY
					ShopName";
		$query 	= $this->db->query($sql);
		// echo $sql;
		$totalLast = 0;
		$idLast	= 0;
		$no = 0;

		foreach ($query->result() as $row) {
			if ($totalLast == 0) {
				$totalLast = $row->SOTotal;
				$no = 0;
			}
			if ($idLast != $row->ShopID) {
				$totalLast = $row->SOTotal;
				$no = 0;
			}
			if($row->SOTotal==0.00){
			$Progress = 0;	
			} else {	
			$Progress = (($row->SOTotal - $totalLast) / $totalLast) * 100;
			}	
			$no++ ;
			if ($totalLast == $row->SOTotal) {
				$Progress = 100;
			}
			$SODateStartSub = isset($row->SODate2) ? date('Y-m-01', strtotime($row->SODate2)) : date('d-m-Y');
			$SODateEndSub = isset($row->SODate2) ? date('Y-m-t', strtotime($row->SODate2)) : date('d-m-Y');

		  	$show['main'][] = array(
		  		'No' => $row->ShopName.'('.$no.')',
	  			'SODate' => $row->SODate,
	  			'ShopID' => $row->ShopID,
	  			'ShopName' => $row->ShopName,
	  			'TotalSO' => $row->TotalSO,
	  			'SOTotal' => $row->SOTotal,
	  			'ProductQty' => $row->ProductQty,
	  			'SalesName' => $row->SalesName,
	  			'SODateStartSub' => $SODateStartSub,
	  			'SODateEndSub' => $SODateEndSub,
	  			'Progress' => $Progress,
			);

			$idLast = $row->ShopID;
			$totalLast = $row->SOTotal;
		};


		// total --------------------------------------------------------------------------------
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql 	= "SELECT
						shm.ShopName, shm.ShopID, t1.INVDate, t1.INVDate2,
						COALESCE(t1.TotalOutstanding, 0) as TotalOutstanding,
						COALESCE(t1.TotalPayment, 0) as TotalPayment,
						COALESCE(t1.INVTotal, 0) as INVTotal,	t1.SalesName
					FROM
						tb_shop_main shm
					LEFT JOIN (
						SELECT sm.ShopID, CONCAT(YEAR (ib.INVDate),'-', LPAD(MONTH(ib.INVDate), 2, '0')) AS INVDate,
							CONCAT(YEAR (ib.INVDate),'-',LPAD(MONTH(ib.INVDate), 2, '0'),'-','01') AS INVDate2,
							SUM(ib.TotalOutstanding) AS TotalOutstanding,
							SUM(ib.TotalPayment) AS TotalPayment, SUM(ib.INVTotal) AS INVTotal,
							GROUP_CONCAT(DISTINCT se.Company2 ORDER BY se.Company2 SEPARATOR ', ') AS SalesName
						FROM tb_so_main sm
						LEFT JOIN vw_invoice_balance ib ON (sm.SOID = ib.SOID)
						LEFT JOIN vw_sales_executive2 se ON se.SalesID = ib.SalesID ";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
				$sql .= "WHERE (INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			} else { 
				$sql .= "WHERE MONTH(INVDate)=MONTH(CURRENT_DATE()) AND YEAR(INVDate)=YEAR(CURRENT_DATE()) ";
			}

			$EmployeeID = array( $this->session->userdata('UserAccountID') );
			$SalesID = array( $this->session->userdata('SalesID') );
			$MenuList = $this->session->userdata('MenuList');
			if (in_array("report_inv_sec", $MenuList)) {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ib.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
				$sql .= "or ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			} elseif (in_array("report_inv_linked", $MenuList)) {
				$sql .= "and ib.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} elseif (in_array("report_inv_all", $MenuList)) {
				$sql .= "and ib.SalesID<>'' ";
			}

			$sql .= "GROUP BY
							sm.ShopID,
							MONTH (ib.INVDate),
							YEAR (ib.INVDate)
					) t1 ON t1.ShopID = shm.ShopID
					ORDER BY
						ShopName";
			// echo $sql;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show[] = array(
			  		'No' => $row->ShopName.'(0)',
		  			'INVDate' => "Total",
		  			'ShopID' => $row->ShopID,
		  			'ShopName' => $row->ShopName,
		  			'SalesName' => "",
		  			'confirmed' => $row->TotalOutstanding,
		  			'completed' => $row->TotalPayment,
		  			'INVTotal' => $row->INVTotal,
		  			'INVDateStart' => $INVDateStart,
		  			'INVDateEnd' => $INVDateEnd,
		  			'Progress' => 100,
				);
			};
		}
		// echo json_encode($show);

	    return $show;
	}
	function report_so_shop_detail()
	{
		$show = array();
		$ShopID	= $this->input->get_post('id');
		$INVDateStart	= date('Y-m-01', strtotime($this->input->get_post('datestart'))) ;
		$INVDateEnd		= date('Y-m-t', strtotime($this->input->get_post('dateend'))) ;

		$sql 	= "SELECT cus.Company2, sm.SOID, sm.SODate, sum(sm.SOTotal) as SOTotal, 
					sum(ib.TotalPayment) as TotalPayment, sum(ib.INVTotal) as INVTotal
					FROM tb_so_main sm LEFT JOIN vw_customer2 cus ON cus.CustomerID=sm.CustomerID 
					LEFT JOIN vw_invoice_balance ib ON (sm.SOID = ib.SOID)
					WHERE (SODate between '".$INVDateStart."' AND '".$INVDateEnd."') AND sm.ShopID='".$ShopID."' 
					group by sm.CustomerID order by SODate desc";
		// echo $sql;			
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
		  	$show[] = array(
				'Company2' => $row->Company2,
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'SOTotal' => $row->SOTotal,
				'TotalPayment' => $row->TotalPayment,
				'INVTotal' => $row->INVTotal,
			);
		};
	    return $show;
	}
	function report_so_project()
	{
		$show   = array();
		
		$sql = "SELECT tp.ProjectID, tp.ProjectName, tps.SOID, vc3.Company2, vsl.SOTotal, vsl.TotalDeposit, vsl.TotalOutstanding, vsl.qty, vsl.totaldo, vsl.outstandingdo, vsl.SOShipDate FROM tb_project_so	tps
				LEFT JOIN tb_project tp ON tp.ProjectID=tps.ProjectID
				LEFT JOIN vw_so_list5 vsl ON vsl.SOID=tps.SOID
				LEFT JOIN vw_customer3 vc3 ON tp.CustomerID=vc3.CustomerID";	

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {

			$date2=date_create($row->SOShipDate);
			$date1=date_create(date('Y-m-d'));
			$diff=date_diff($date1,$date2);
			$late_days = $diff->format("%r%a");	

		  	$show[] = array(
		  			'ProjectID' => $row->ProjectID,
		  			'Company2' => $row->Company2,
		  			'ProjectName' => $row->ProjectName,
		  			'SOID' => $row->SOID,
		  			'SOTotal' => $row->SOTotal,
		  			'TotalDeposit' => $row->TotalDeposit,
		  			'outstanding_payment' => $row->TotalOutstanding,
		  			'qty' => $row->qty,
		  			'totaldo' => $row->totaldo,
		  			'outstandingdo' => $row->outstandingdo,
		  			'SOShipDate' => $row->SOShipDate,
		  			'late_days' => $late_days,
				);
		};
	    return $show;
	}
	function report_so_city_having_display()
	{
		$show   = array();

		$sql = "SELECT COUNT(DISTINCT sm.SOID) AS SOID, COUNT(DISTINCT sm.CustomerID) AS CustomerID, 
				cc.CityID, cc.CityName, sm.totaldo AS ProductQty, rm.RegionName
				FROM vw_so_list5 sm 
				LEFT JOIN tb_customer_main cm ON cm.CustomerID=sm.CustomerID
				LEFT JOIN vw_contact_address_city cc ON cm.ContactID=cc.ContactID 
				LEFT JOIN tb_mkt_city mc ON cc.CityID=mc.CityID
				LEFT JOIN tb_region_main rm ON mc.RegionID=rm.RegionID
				WHERE sm.SOCategory=4 AND sm.SOStatus=1 and sm.SOConfirm1=1 and sm.SOConfirm2=1 and sm.totaldo<>0
				GROUP BY cc.CityID Order by rm.RegionName, cc.CityName";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'CityID' => $row->CityID,
		  			'RegionName' => $row->RegionName,
		  			'CityName' => $row->CityName,
		  			'CustomerID' => $row->CustomerID,
		  			'SOID' => $row->SOID,
		  			'ProductQty' => $row->ProductQty,
				);
		};
	    return $show;
	}
	function report_so_city_having_display_detail()
	{
		$CityID = $this->input->get('city');
		$sql = "SELECT sd.SOID, t1.Customer, t1.CustomerID, t1.SODate, sd.ProductName, sd.ProductQty
				FROM (
				SELECT sm.SOID, sm.SODate, cm.Company2 as Customer, cm.CustomerID FROM tb_so_main sm 
				LEFT JOIN vw_customer2 cm ON cm.CustomerID=sm.CustomerID
				LEFT JOIN vw_contact_address_city cc ON cm.ContactID=cc.ContactID 
				WHERE sm.SOCategory=4 AND sm.SOStatus=1 AND cc.CityID=".$CityID."
				) t1
				LEFT JOIN tb_so_detail sd ON sd.SOID=t1.SOID
				order by t1.Customer";
		$query 	= $this->db->query($sql);
		$show   = array();

		foreach ($query->result() as $row) {
		  	$show[] = array(
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'CustomerID' => $row->CustomerID,
				'Customer' => $row->Customer,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
			);
		};
	    return $show;
	}
	function report_so_late_payment()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "select * from (

				SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID 
				FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID ";
				
		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			// $sql .= "where SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "where SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "where SalesID<>'' ";
		}
 
		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'ProductName':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "ProductName contains ".$atributevalue[$i]."<br>";
						break;
					case 'Company':
						$sql .= "CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					case 'Category':
						$sql .= "SOCategory in (SELECT CategoryID FROM tb_so_category WHERE CategoryName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "SO Category contains ".$atributevalue[$i]."<br>";
						break;
					case 'SOID':
						$sql .= "sl.SOID like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "SO ID contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= $atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		if ( !empty($_POST) ) {
			$sql .= "GROUP BY sl.SOID ";
		}
		// ---------------------------------------------------
		$sql .= ") t3 where t3.SOID in (
					SELECT SOID FROM (
					SELECT t1.*, dd2.SourceType FROM (
					SELECT dd.SOID, MAX(dd.CreatedDate) AS maxDate
					FROM tb_so_due_date dd WHERE SOID in (
					SELECT SOID FROM tb_so_due_date
					GROUP BY SOID HAVING COUNT(SOID) > 1
					) GROUP BY dd.SOID
					) t1 
					LEFT JOIN tb_so_due_date dd2 ON dd2.SOID = t1.SOID AND dd2.CreatedDate=t1.maxDate
					ORDER BY t1.SOID 
					) t2 WHERE t2.SourceType='deposit'
				)  order by t3.SOID desc limit ".$this->limit_result." ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);

			$TotalDepositPerc = $this->get_percent($row->SOTotal, $row->TotalDeposit);
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $row->TotalPayment);

		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'RegionID' => $row->RegionID,
				'SECID' => $row->SECID,
				'NPWP' => $row->NPWP,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'SOCategory' => $row->SOCategory,
				'SODate' => $row->SODate,
				'SOShipDate' => $row->SOShipDate,
				'SOTerm' => $row->SOTerm,
				'SONote' => $row->SONote,
				'ExpeditionID' => $row->ExpeditionID,
				'ExpeditionPrice' => $row->ExpeditionPrice,
				'ExpeditionWeight' => $row->ExpeditionWeight,
				'FreightCharge' => $row->FreightCharge,
				'SOTotalBefore' => $row->SOTotalBefore,
				'TaxRate' => $row->TaxRate,
				'TaxAmount' => $row->TaxAmount,
				'SOTotal' => $row->SOTotal,
				'ModifiedDate' => $row->ModifiedDate,
				'ModifiedBy' => $row->ModifiedBy,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
				'PermitNote' => $row->PermitNote,
				'Company' => $row->Company,
				'secname' => $row->secname,
				'salesname' => $row->salesname,
				'CategoryName' => $row->CategoryName,
				'SOType' => $row->SOType,
				'DPMinimumPercent' => $row->DPMinimumPercent,
				'DPMinimumAmount' => $row->DPMinimumAmount,

				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding' => $row->totaldo-$row->qty,
				'note' => $row->note,
				'ROID' => $row->ROID,
				'POID' => $row->POID,
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
	}
	function report_so_not_inv()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID, tsm.ShopName 
				FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID 
				LEFT JOIN tb_shop_main tsm ON tsm.ShopID = sl.ShopID ";
				
		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( sl.SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			// $sql .= "where SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "where sl.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "where sl.SalesID<>'' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ProductID':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						$show['info_filter'] .= "ProductID contains ".$atributevalue[$i]."<br>";
						break;
					case 'ProductName':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "ProductName contains ".$atributevalue[$i]."<br>";
						break;
					case 'ShopName':
						$sql .= "tsm.ShopName like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "ShopName contains ".$atributevalue[$i]."<br>";
						break;	
					case 'Company':
						$sql .= "CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'Sales':
						$sql .= "sl.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Sales contains ".$atributevalue[$i]."<br>";
						break;
					case 'Category':
						$sql .= "SOCategory in (SELECT CategoryID FROM tb_so_category WHERE CategoryName like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "SO Category contains ".$atributevalue[$i]."<br>";
						break;
					case 'SOID':
						$sql .= "sl.SOID like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "SO ID contains ".$atributevalue[$i]."<br>";
						break;
					default:
						$sql .= $atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= $atributeid[$i]." contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
			$show['info_filter'] .= "SO Date : ".$_REQUEST['filterstart']." <> ".$_REQUEST['filterend']."<br>";
		}

		$sql .= "AND sl.SOConfirm1=1 AND sl.SOConfirm2=1 AND SOStatus=1 AND sl.SOID NOT IN (SELECT SOID FROM tb_invoice_main)
					GROUP BY sl.SOID order by sl.SOID desc ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);

			$TotalDepositPerc = $this->get_percent($row->SOTotal, $row->TotalDeposit);
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $row->TotalPayment);

		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'RegionID' => $row->RegionID,
				'SECID' => $row->SECID,
				'NPWP' => $row->NPWP,
				'PaymentWay' => $row->PaymentWay,
				'PaymentTerm' => $row->PaymentTerm,
				'SOCategory' => $row->SOCategory,
				'SODate' => $row->SODate,
				'SOShipDate' => $row->SOShipDate,
				'SOTerm' => $row->SOTerm,
				'SONote' => $row->SONote,
				'ExpeditionID' => $row->ExpeditionID,
				'ExpeditionPrice' => $row->ExpeditionPrice,
				'ExpeditionWeight' => $row->ExpeditionWeight,
				'FreightCharge' => $row->FreightCharge,
				'SOTotalBefore' => $row->SOTotalBefore,
				'TaxRate' => $row->TaxRate,
				'TaxAmount' => $row->TaxAmount,
				'SOTotal' => $row->SOTotal,
				'ModifiedDate' => $row->ModifiedDate,
				'ModifiedBy' => $row->ModifiedBy,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
				'PermitNote' => $row->PermitNote,
				'Company' => $row->Company,
				'secname' => $row->secname,
				'salesname' => $row->salesname,
				'ShopName' => $row->ShopName,
				'CategoryName' => $row->CategoryName,
				'SOType' => $row->SOType,
				'DPMinimumPercent' => $row->DPMinimumPercent,
				'DPMinimumAmount' => $row->DPMinimumAmount,

				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding' => $row->totaldo-$row->qty,
				'note' => $row->note,
				'ROID' => $row->ROID,
				'POID' => $row->POID,
			);
			// $show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
	}
	function report_so_outstanding_do_product()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
 
		$sql = "SELECT sl.*, sdd.ProductID, sdd.ProductName, sdd.ProductQty, coalesce(sdd.stock,0) as stock, sdd.stockReady, tsm2.INVMP, tsm2.ResiNo, vc.Company2, tsc.CategoryName, vps.ProductAtributeValueName as PSHOP, vps.Gudang
				FROM tb_so_main sl
				LEFT JOIN vw_so_do_detail4 sdd ON sl.SOID=sdd.SOID
				LEFT JOIN tb_so_main2 tsm2 ON tsm2.SOID=sl.SOID
				LEFT JOIN vw_customer5 vc ON vc.CustomerID=sl.CustomerID
				LEFT JOIN tb_so_category tsc ON tsc.CategoryID=sl.SOCategory
				LEFT JOIN vw_product_shop vps ON vps.ProductID=sdd.ProductID
					";
		$sql.=" WHERE sdd.pending>0 and sl.SOStatus = 1 and sl.SOConfirm1 = 1 and sl.SOConfirm2 = 1  ";

		if (in_array("report_so_putat", $MenuList)) {
			$sql .= "and vps.Gudang like 'Putat' ";
		} elseif (in_array("report_so_margomulyo", $MenuList)) {
			$sql .= "and vps.Gudang like '%margomulyo%' ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= " ";
		}
		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'ShopName':
						$sql .= "tsm.ShopName like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "ShopName contains ".$atributevalue[$i]."<br>";
						break;	
					case 'Company':
						$sql .= "vc.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						$show['info_filter'] .= "Customer contains ".$atributevalue[$i]."<br>";
						break;
					case 'SOID':
						$sql .= "sl.SOID like '%".$atributevalue[$i]."%' ";
						$show['info_filter'] .= "SO ID contains ".$atributevalue[$i]."<br>";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
		  		'SODate' => $row->SODate,
		  		'SOShipDate' => $row->SOShipDate,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'stock' => $row->stock,
				'PaymentWay' => $row->PaymentWay,
				'ShipAddress' => $row->ShipAddress,
				'CategoryName' => $row->CategoryName,
				'Company2' => $row->Company2,
				'INVMP' => $row->INVMP,
				'ResiNo' => $row->ResiNo,
				'PSHOP' => $row->PSHOP,
				'Gudang' => $row->Gudang,
				'SOConfirm1' => $row->SOConfirm1,
				'SOConfirm2' => $row->SOConfirm2,
				'SOStatus' => $row->SOStatus,
			);
		};
	    return $show;
	}

// product=================================================================
	function report_product_detail()
	{
		$show = array();
		$ProductID = $this->input->get_post('product');


		$sql 	= "SELECT * FROM tb_product_main pm 
					LEFT JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID
					LEFT JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
					WHERE pm.ProductID = '".$ProductID."'
					GROUP BY pm.ProductID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$isActive 	= ($row->isActive!="0" ? "Yes" : "No");
			$forSale 	= ($row->forSale!="0" ? "Yes" : "No");
		  	$show = array(
	  			'ProductID' => $row->ProductID, 
				'ProductName' => $row->ProductName, 
				'ProductCode' => $row->ProductCode, 
				'ProductDescription' => $row->ProductDescription, 
				'ProductStatusName' => $row->ProductStatusName, 
				'ProductPriceDefault' => $row->ProductPriceDefault, 
				'CountryName' => $row->StateName, 
				'MaxStock' => $row->MaxStock, 
				'MinStock' => $row->MinStock, 
				'forSale' => $forSale, 
				'isActive' => $isActive
			);
		};
		
		$sql 	= "SELECT ProductCategoryID, ProductBrandID, ProductImage, ProductDoc from tb_product_main where ProductID=".$ProductID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['ProductImage'] = $row->ProductImage;
		$show['ProductDoc'] = $row->ProductDoc;
		$show['category'] = $this->full_category($row->ProductCategoryID, "");
		$show['brand'] = $this->full_brand($row->ProductBrandID, "");


		$sql = "SELECT pm.ProductID, pm.ProductName, pm.ProductCode FROM tb_product_raw_material pr
				LEFT JOIN tb_product_main pm ON pr.RawMaterialID = pm.ProductID
				WHERE pr.ProductID=".$ProductID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['raw'][] = array(
	  			'ProductCode' => $row2->ProductCode,
	  			'ProductName' => $row2->ProductName,
	  			'ProductID' => $row2->ProductID
			);
		};

		$sql = "SELECT wm.WarehouseName, psm.Quantity FROM tb_product_stock_main psm
				LEFT JOIN tb_warehouse_main wm ON psm.WarehouseID = wm.WarehouseID
				WHERE psm.ProductID=".$ProductID." AND psm.Quantity!=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['stock'][] = array(
	  			'WarehouseName' => $row2->WarehouseName,
	  			'Quantity' => $row2->Quantity
			);
		};

		$sql2 	= "SELECT pad.*, pa.ProductAtributeName, IFNULL(vpo.ProductAtributeValueName,pad.AtributeValue) AS AtributeName FROM tb_product_atribute_detail pad
					LEFT JOIN tb_product_atribute pa ON (pad.ProductAtributeID=pa.ProductAtributeID)
					LEFT JOIN vw_product_atribute_name vpo ON vpo.AtributeValue= pad.AtributeValue AND pad.ProductID=vpo.ProductID AND pad.ProductAtributeID=vpo.ProductAtributeID
					WHERE pad.ProductID ='".$ProductID."'
					ORDER BY pad.ProductAtributeID";
		$query2 = $this->db->query($sql2);
		if ($query2->num_rows() != 0 ) {
			foreach ($query2->result() as $row) {
			  	$show['atribute'][] = array(
			  			'ProductAtributeName' => $row->ProductAtributeName, 
						'AtributeName' => $row->AtributeName
					);
			};
		}

		$sql5 = "SELECT * FROM tb_product_file WHERE ProductID='".$ProductID."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
	  		$show['file'][] = array(
			  	'ProductID' => $row5->ProductID,
			  	'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};
		// if ($this->input->get_post('ShowPriceList')) {
			// $sql5 = "SELECT pld.*, plm.PricelistName, pcm.PricecategoryName, pcm.PromoDefault, pm.ProductPriceDefault 
			// 		FROM tb_price_list_detail pld
			// 		LEFT JOIN tb_product_main pm ON pld.ProductID=pm.ProductID
			// 		LEFT JOIN tb_price_list_main plm ON pld.PricelistID=plm.PricelistID
			// 		LEFT JOIN tb_price_category_detail pcd ON pld.PricelistID=pcd.PricelistID
			// 		LEFT JOIN tb_price_category_main pcm ON pcd.PricecategoryID=pcm.PricecategoryID
			// 		where pld.ProductID='".$ProductID."'";
			$sql5 = "SELECT pl.*, pm.ProductPriceDefault from vw_product_promo_list_active pl
					LEFT JOIN tb_product_main pm ON pl.ProductID=pm.ProductID
					where pl.ProductID='".$ProductID."' order by pl.PromoCategory, pl.PT1Discount";
					// echo $sql5;
			$query5 = $this->db->query($sql5);
			foreach ($query5->result() as $row5) {
				$PriceAfterCategory = $this->get_min_percent($row5->ProductPriceDefault, $row5->PromoCategory);
				$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row5->Promo);
				$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row5->PT1Discount);
				$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row5->PT2Discount);

				$show['pricelist'][] = array(
					'PricecategoryName' => $row5->PricecategoryName,
					'PricelistID' => $row5->PricelistID,
					'PricelistName' => $row5->PricelistName,
					'ProductID' => $row5->ProductID,
					'ProductQty' => $row5->ProductQty,
					'PromoCategory' => $row5->PromoCategory,
					'Promo' => $row5->Promo,
					'PT1Discount' => $row5->PT1Discount,
					'PT2Discount' => $row5->PT2Discount,
					'ProductPriceDefault' => $row5->ProductPriceDefault,
					'PriceAfterCategory' => $PriceAfterCategory,
					'ProductPricePromo' => $ProductPricePromo,
					'ProductPricePT1' => $ProductPricePT1,
					'ProductPricePT2' => $ProductPricePT2
				);
			};
		// }
		if ($this->input->get_post('ShowShop')) {
			$sql4 = "SELECT sp.*, sm.ShopName FROM tb_shop_product sp
					LEFT JOIN tb_shop_main sm ON sp.ShopID = sm.ShopID
					where sp.ProductID='".$ProductID."'";
			$query4 = $this->db->query($sql4);
			foreach ($query4->result() as $row4) {
				$show['shop'][] = array(
					'OrderID' => $row4->OrderID,
					'ShopName' => $row4->ShopName,
					'InputDate' => $row4->InputDate,
					'LinkText' => $row4->LinkText,
					'LinkDate' => $row4->LinkDate,
					'CheckDate' => $row4->CheckDate,
				);
			};
		}
		$sql7 = "SELECT pph.*, pm.ProductPriceDefault 
				FROM tb_product_promo_history pph
				LEFT JOIN tb_product_main pm ON pph.ProductID=pm.ProductID
				WHERE pph.ProductID='".$ProductID."' ORDER BY pph.PromoCategoryPercent, pph.PT1Discount";
				// echo $sql7;
		$query7 = $this->db->query($sql7);
		foreach ($query7->result() as $row7) {
			$PriceAfterCategory = $this->get_min_percent($row7->ProductPriceDefault, $row7->PromoCategoryPercent);
			$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row7->Promo);
			$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row7->PT1Discount);
			$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row7->PT2Discount);
			$isActiveDate 	= ($row7->isActive==0 ? "Yes" : "No");
			$show['promohistory'][] = array(
				'PromoCategoryName' => $row7->PromoCategoryName,
				'PromoID' => $row7->PromoID,
				'InputDate' => $row7->InputDate,
				'NonActiveDate' => $row7->NonActiveDate,
				'PromoID' => $row7->PromoID,
				'PromoName' => $row7->PromoName,
				'ProductID' => $row7->ProductID,
				'ProductQty' => $row7->ProductQty,
				'PromoCategoryPercent' => $row7->PromoCategoryPercent,
				'Promo' => $row7->Promo,
				'PT1Discount' => $row7->PT1Discount,
				'PT2Discount' => $row7->PT2Discount,
				'ProductPriceDefault' => $row7->ProductPriceDefault,
				'PriceAfterCategory' => $PriceAfterCategory,
				'ProductPricePromo' => $ProductPricePromo,
				'ProductPricePT1' => $ProductPricePT1,
				'ProductPricePT2' => $ProductPricePT2,
				'isActiveDate' => $isActiveDate,
			);
		}
		$sql8 = "SELECT pmh.*
				FROM tb_product_minmax_history pmh
				WHERE pmh.ProductID='".$ProductID."' ORDER BY pmh.HistoryID DESC";
		// echo $sql8;
		$query8 = $this->db->query($sql8);
		foreach ($query8->result() as $row8) {
			$show['minmaxhistory'][] = array(
				'ProductID' => $row8->ProductID,
				'MinStock' => $row8->MinStock,
				'MaxStock' => $row8->MaxStock,
				'InputDate' => $row8->InputDate
			);
		}
		$sql9 = "SELECT * FROM tb_product_stock_in tps
				WHERE tps.ProductID='".$ProductID."' AND EXPDate !=''";
			$query9 = $this->db->query($sql9);
			foreach ($query9->result() as $row9) {
				$show['exp'][] = array(
					'NoReff' => $row9->NoReff,
					'EXPDate' => $row9->EXPDate,
				);
			};
		return $show;
	}
	function all_atribute()
	{
		$sql = "SELECT pa.*, count(pav.ProductAtributeID) as countPA FROM tb_product_atribute pa 
				LEFT join tb_product_atribute_value pav on (pa.ProductAtributeID=pav.ProductAtributeID)
				GROUP by pa.ProductAtributeID order by countPA, pa.ProductAtributeName ";
		$query = $this->db->query($sql);
		$show = array();
		foreach ($query->result() as $row2) {
		  	$show['main'][] = array(
	  			'ProductAtributeID' => $row2->ProductAtributeID,
	  			'ProductAtributeName' => $row2->ProductAtributeName
			);
		}

		$sql = "SELECT * FROM tb_product_atribute_value order by ProductAtributeValueName";
		$query = $this->db->query($sql);
		foreach ($query->result() as $row3) {
		  	$show['detail'][$row3->ProductAtributeID][] = array(
	  			'ProductAtributeID' => $row3->ProductAtributeID,
	  			'ProductAtributeValueName' => $row3->ProductAtributeValueName,
	  			'ProductAtributeValueCode' => $row3->ProductAtributeValueCode
			);
		}
		// echo json_encode($show);
		return $show;
	}
	function report_product_slowmoving()
	{
		$sql 	= "SELECT SlowMovingMply from tb_site_config where id=1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$show['SlowMovingMply'] = $row->SlowMovingMply;

		return $show;
	}
	function report_product_kpi()
	{
		$show = array();
		$show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sqlINVDate = "WHERE (im.INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
			$show['info_filter'] .= "Date : ".$_REQUEST['datestart']." <> ".date('Y-m-t', strtotime($_REQUEST['dateend']))."<br>";
		} else { 
			$sqlINVDate = "";
		}

		$sql = "
			SELECT pm.ProductID, pm.ProductName, pm.ProductPriceHPP, COALESCE (tvp.cbd,0) as cbd, tvp.Promo, tvp.PromoCategory, Round(tid.AProfit/tid.ACost*100,2) as apersen, tid.QTYSold, tsd.QTYSold2, tid.tertinggi, tid.terendah, tid.APrice, tid.ACost, tid.totalpenjualan, tid.totalHPP, tid.AProfit, tid.Profit, pm.InputDate, 
			@umur:= DATEDIFF(Now(), pm.InputDate) AS umur,
			@AQTYSold := Round( COALESCE(tid.QTYSold / @umur, 0), 2) AS AQTYSold,
			@AQTYSold2 := Round( COALESCE(tsd.QTYSold2 / @umur, 0), 2) AS AQTYSold2,
			COALESCE (stock, 0) AS Stok, 
			COALESCE (stock * pm.ProductPriceHPP, 0) AS STKVAL,
			Round(COALESCE ((stock / @AQTYSold),0),2) AS DStokLeft,
			pm.ProductCategoryName, pm.ProductBrandName, pm.ProductPriceDefault, tad.AtributeValue as Origin, tad.ProductAtributeValueName as SourceAgent, tam.ProductAtributeValueName as ProductManager,tsd.LastOrder
			FROM vw_product_list_popup6 pm
			LEFT JOIN (
				SELECT vpp.productid, max(vpp.PromoCategory) as PromoCategory, max(vpp.Promo) as Promo, min(vpp.PricePT2Discount) as cbd FROM vw_product_promo_list_active_with_price_no_vol vpp 
				GROUP BY ProductID
			) tvp ON tvp.ProductID=pm.ProductID
			LEFT JOIN (
				SELECT id.ProductID, COALESCE(sum(id.ProductQty), 0) AS QTYSold, COALESCE (max(id.PriceAmount), 0) AS tertinggi, 
				COALESCE (min(id.PriceAmount), 0) AS terendah,
				Round( COALESCE (Avg(id.PriceAmount), 0), 2 ) AS APrice,
				Round( COALESCE (AVG(id.ProductHPP), 0), 2 ) AS ACost,
				COALESCE (sum(id.PriceTotal), 0) AS totalpenjualan,
				COALESCE ( (ProductHPP * sum(id.ProductQty) ), 0 ) AS totalhpp,
				Round(COALESCE( (Avg(id.PriceAmount) - AVG(id.ProductHPP) ), 0), 2) AS AProfit,
				COALESCE ( sum((id.PriceTotal) - (ProductHPP*(id.ProductQty)) ), 0) AS Profit
				FROM tb_invoice_detail id
				WHERE id.INVID IN (
					SELECT im.INVID FROM tb_invoice_main im ".$sqlINVDate."
				) 
				GROUP BY id.ProductID 
			) tid on pm.ProductID=tid.ProductID
			LEFT JOIN ( 
				SELECT * FROM vw_product_origin
			) tad on tad.ProductID=pm.ProductID
			LEFT JOIN ( 
				SELECT * FROM vw_product_manager
			) tam on tam.ProductID=pm.ProductID
			LEFT JOIN (
				SELECT tsd.ProductID, sum(tsd.ProductQty) as Qtysold2, MAX(tsm.SODate) AS LastOrder
				FROM tb_so_detail tsd 
				LEFT JOIN tb_so_main tsm ON tsm.SOID=tsd.SOID
				WHERE tsm.SOStatus=1
				GROUP BY tsd.ProductID
			) tsd ON tsd.ProductID = pm.ProductID
		";
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {
			$sql1 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 AND ProductAtributeValueCode='".$_REQUEST['origin']."'";
			// echo $sql1;
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;
			$sql .= "where tad.AtributeValue like '".$_REQUEST['origin']."' ";
			$show['info_filter'] .= "Source Of Origin : ".$Origin."<br>";
		} else {$sql .="";}
		$sql.=" ORDER BY QTYSold DESC ";

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$PriceAfterCategory = $this->get_min_percent($row->ProductPriceDefault, $row->PromoCategory);
			$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row->Promo);
			$ProductPricePT1 = $ProductPricePromo;

			if($row->cbd==0){
				$price=$row->ProductPriceDefault;
			} else {
				$price=$row->cbd;
			}
			if ($row->ProductPriceHPP==0) {
				$HPP=1;
				$cprofit=0;
				$cpersen=0;
			} else {
				$HPP=$row->ProductPriceHPP;
				$cprofit=$price-$row->ProductPriceHPP;
				$HPPPersen=$cprofit/$HPP;
				$cpersen=$HPPPersen*100;
			}
			$HPPPersen=$HPP*100;
			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductPriceHPP' => $row->ProductPriceHPP,
				'ProductPricePT1' => $ProductPricePT1,
				'price' => $price,
				'cprofit' => $cprofit,
				'cpersen' => $cpersen,
				'apersen' => $row->apersen,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'LastOrder' => $row->LastOrder,
				'Origin' => $row->Origin,
				'SourceAgent' => $row->SourceAgent,
				'ProductManager' => $row->ProductManager,
				'QTYSold' => $row->QTYSold,
				'QTYSold2' => $row->QTYSold2,
				'tertinggi' => $row->tertinggi,
				'terendah' => $row->terendah,
				'APrice' => $row->APrice,
				'ACost' => $row->ACost,
				'AProfit' => $row->AProfit,
				'totalpenjualan' => $row->totalpenjualan,
				'Profit' => $row->Profit,
				'umur' => $row->umur,
				'AQTYSold' => $row->AQTYSold,
				'AQTYSold2' => $row->AQTYSold2,
				'Stok' => $row->Stok,
				'STKVAL' => $row->STKVAL,
				'DStokLeft' => $row->DStokLeft,
				'INVDateStart' => $INVDateStart,
				'INVDateEnd' => $INVDateEnd,
			);
		};

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};
	    return $show;
	}
	function report_product_kpi_detail()
	{
		$show = array();
		$ProductID = $this->input->get_post('product');

		$sql5 = "SELECT pl.*, pm.ProductPriceDefault, pm.ProductName from vw_product_promo_list_active pl
				LEFT JOIN tb_product_main pm ON pl.ProductID=pm.ProductID
				where pl.ProductID='".$ProductID."' order by pl.PromoCategory, pl.PT1Discount";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$PriceAfterCategory = $this->get_min_percent($row5->ProductPriceDefault, $row5->PromoCategory);
			$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row5->Promo);
			$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row5->PT1Discount);
			$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row5->PT2Discount);

			$show['pricelist'][] = array(
				'ProductName' => $row5->ProductName,
				'PricecategoryName' => $row5->PricecategoryName,
				'PricelistName' => $row5->PricelistName,
				'ProductID' => $row5->ProductID,
				'ProductQty' => $row5->ProductQty,
				'PromoCategory' => $row5->PromoCategory,
				'Promo' => $row5->Promo,
				'PT1Discount' => $row5->PT1Discount,
				'PT2Discount' => $row5->PT2Discount,
				'ProductPriceDefault' => $row5->ProductPriceDefault,
				'PriceAfterCategory' => $PriceAfterCategory,
				'ProductPricePromo' => $ProductPricePromo,
				'ProductPricePT1' => $ProductPricePT1,
				'ProductPricePT2' => $ProductPricePT2
			);
		};
		return $show;
	}
	function report_product_kpi_so_detail()
	{
		$show = array();
		$ProductID = $this->input->get_post('product');

		$sql = "SELECT pm.ProductName, tsd.SOID, tsm.SODate, tsd.ProductQty, vc3.Company2, tsc.CategoryName, tim.INVID, tsd.PriceAmount from tb_so_detail tsd
				LEFT JOIN tb_product_main pm ON tsd.ProductID=pm.ProductID
				LEFT JOIN tb_so_main tsm ON tsm.SOID=tsd.SOID
				LEFT JOIN tb_so_category tsc ON tsm.SOCategory=tsc.CategoryID
				LEFT JOIN vw_customer3 vc3 ON vc3.CustomerID=tsm.CustomerID
				LEFT JOIN tb_invoice_main tim ON tim.SOID=tsm.SOID
				LEFT JOIN (SELECT INVID, PriceAmount FROM tb_invoice_detail WHERE ProductID = '".$ProductID."') tid ON tim.INVID = tid.INVID
				WHERE tsd.ProductID='".$ProductID."' AND tsm.SOStatus=1 ORDER BY tsm.SOID DESC";
		// echo $sql;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['pricelist'][] = array(
				'ProductName' => $row->ProductName,
				'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'ProductQty' => $row->ProductQty,
				'Company2' => $row->Company2,
				'CategoryName' => $row->CategoryName,
				'INVID' => $row->INVID,
				'PriceAmount' => $row->PriceAmount,
			);
		};
		return $show;
	}
	function report_product_by_manager()
	{
		$show   = array();
		$show['info_filter'] = "";

		$sql = "SELECT vpm.*, COUNT(vpm.ProductID) AS Total
				FROM vw_product_manager vpm
				GROUP BY vpm.AtributeValue Order By vpm.AtributeValue asc ";
		// echo $sql;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$show['main'][] = array(
				'ProductAtributeValueName' => $row->ProductAtributeValueName,
				'AtributeValue' => $row->AtributeValue,
				'Total' => $row->Total,
			);
		};
		return $show;
	}
	function report_product_by_manager_detail()
	{
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$AtributeValue = $this->input->get('id', TRUE);

		$sql = "SELECT pm.ProductID, pm.ProductName, COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault, ast.StateName, tad.ProductAtributeValueName AS ProductManager
				FROM tb_product_main pm
				LEFT JOIN vw_product_stock psm ON pm.ProductID = psm.ProductID
				LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
				LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
				LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
				LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent
				LEFT JOIN (
					SELECT * FROM vw_product_manager
				) tad on tad.ProductID=pm.ProductID
				LEFT JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
				WHERE tad.AtributeValue=".$AtributeValue;
		$sql.= " ORDER BY pm.ProductID ASC ";
		$query 	= $this->db->query($sql);
		$show   = array();

		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'ProductManager' => $row->ProductManager,
				'Price' => $row->ProductPriceDefault,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'Stock' => $row->Stock,
				'StateName' => $row->StateName,
			);
		};
		return $show;
	}
	function report_product_manager()
	{
		$show = array();
		$show['info_filter'] = "";
		$UserAccountID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');
		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');
		$Category = $this->input->get_post('category');
		$Brand = $this->input->get_post('brand');

		$sql = "
			SELECT pm.ProductID, pm.ProductName,
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault, ast.StateName, tad.ProductAtributeValueName AS ProductManager
			FROM tb_product_main pm
			LEFT JOIN vw_product_stock psm ON pm.ProductID = psm.ProductID
			LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
			LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
			LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
			LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent
			LEFT JOIN (
				SELECT * FROM vw_product_manager
			) tad on tad.ProductID=pm.ProductID
			LEFT JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
		";
		if(in_array("report_product_manager_view_all", $MenuList)){
			$sql .="WHERE tad.AtributeValue<>0 ";
		} else {$sql .="WHERE tad.AtributeValue=".$UserAccountID." ";}
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "AND pm.ProductID like '".$_REQUEST['productid']."'";
			$show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "AND pm.ProductName like '%".$_REQUEST['productname']."%'";
			$show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		} else {
			$sql.="";
		}
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {

			$sql .= "AND pm.ProductCountry = '".$_REQUEST['origin']."' ";
			$show['info_filter'] .= "Country Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND pm.ProductCategoryID = '".$_REQUEST['category']."' ";
			$show['info_filter'] .= "Category : ".$_REQUEST['category']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['brand']) && $_REQUEST['brand'] != '0') {
			$sql .= "AND pm.ProductBrandID  = '".$_REQUEST['brand']."'";
		} else {$sql .="";}
		$sql.=" ORDER BY pm.ProductID ASC ";

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'ProductManager' => $row->ProductManager,
				'Price' => $row->ProductPriceDefault,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'Stock' => $row->Stock,
				'StateName' => $row->StateName,
			);
		};

		$sql5 = "SELECT * FROM tb_address_state";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$show['state'][] = array(
				'StateID' => $row5->StateID,
				'StateName' => $row5->StateName,
			);
		};

	    return $show;
	}
	function report_product_not_sale()
	{
		$show = array();
		// $show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');
		$Category = $this->input->get_post('category');
		$Brand = $this->input->get_post('brand');
		$Expiry = $this->input->get_post('expiry');

		$sql = "
			SELECT pm.ProductID, pm.ProductName, pm.forSale, pm.ProductPriceHPP, vps.stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName
			FROM tb_product_main pm
			LEFT JOIN vw_product_stock vps ON vps.ProductID=pm.ProductID
			LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
			LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
			LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
			LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent
			WHERE forSale = 0 AND vps.stock>0
			";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "AND pm.ProductID like '".$_REQUEST['productid']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "AND pm.ProductName like '%".$_REQUEST['productname']."%' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND pm.ProductCategoryID = '".$_REQUEST['category']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['brand']) && $_REQUEST['brand'] != '0') {
			$sql .= "AND pm.ProductBrandID  = '".$_REQUEST['brand']."'";
		} else {$sql .="";}
		$sql.=" ORDER BY pm.ProductID ASC ";

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {

			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'ProductPriceHPP' => $row->ProductPriceHPP,
				'Stock' => $row->stock,
			);
		};

	    return $show;
	}
	function report_product_shop_dor()
	{
		$show = array();
		$show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');
		$Category = $this->input->get_post('category');
		$Brand = $this->input->get_post('brand');

		$sql = "SELECT tdm.DORID, tdd.ProductID, pm.ProductName, DORDate, ps.LinkDate,
			COALESCE (CountLink,0) as CountLink, COALESCE (CountShop,0) as CountShop,
			vps.AtributeValue AS Shop, vpo.ProductAtributeValueName AS SourceAgent, pm.forSale,
			vpm.ProductAtributeValueName AS ProductManager, DATEDIFF(now(),DORDate) AS UUDays,
			DATEDIFF(LinkDate, DORDate) AS UUDays2
			FROM tb_dor_detail tdd
			LEFT JOIN tb_dor_main tdm ON tdd.DORID=tdm.DORID
			LEFT JOIN tb_product_main pm ON pm.ProductID=tdd.ProductID
			LEFT JOIN vw_product_shop_assignment ps ON tdd.ProductID = ps.ProductID
			LEFT JOIN vw_product_shop vps ON vps.ProductID = tdd.ProductID
			LEFT JOIN vw_product_origin vpo ON vpo.ProductID=tdd.ProductID
			LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tdd.ProductID
		";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "WHERE pm.ProductID like '".$_REQUEST['productid']."' AND pm.isActive=1 ";
			$show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "WHERE pm.ProductName like '%".$_REQUEST['productname']."%' AND pm.isActive=1 ";
			$show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		} else {$sql .="WHERE pm.isActive=1  ";}
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {

			$sql .= "AND pm.ProductCountry = '".$_REQUEST['origin']."' ";
			// $show['info_filter'] .= "Country Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND pm.ProductCategoryID = '".$_REQUEST['category']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['brand']) && $_REQUEST['brand'] != '0') {
			$sql .= "AND pm.ProductBrandID  = '".$_REQUEST['brand']."'";
		} else {$sql .="";}
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql1 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 AND ProductAtributeValueCode='".$_REQUEST['source']."'";
			// echo $sql1;
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;
			$sql .= "AND vpo.AtributeValue like '".$_REQUEST['source']."' ";
			$show['info_filter'] .= "Source Agent : ".$Origin."<br>";
		} else {$sql .="";}
		$sql.=" GROUP BY ProductID ORDER BY tdm.DORID desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['product'][] = array(
				'DORID' => $row->DORID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'DORDate' => $row->DORDate,
				'CountLink' => $row->CountLink,
				'CountShop' => $row->CountShop,
				'Shop' => $row->Shop,
				'SourceAgent' => $row->SourceAgent,
				'forSale' => $row->forSale,
				'UUDays' => $row->UUDays,
				'UUDays2' => $row->UUDays2,
				'ProductManager' => $row->ProductManager,
			);
		};

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};

		$sql5 = "SELECT * FROM tb_address_state";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$show['state'][] = array(
				'StateID' => $row5->StateID,
				'StateName' => $row5->StateName,
			);
		};

	    return $show;
	}
	function report_stock_adjustment_balance()
	{
		$show   = array();

		$show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');
		$sql = "
			SELECT pm.ProductID,pm.ProductName,pm.ProductCode, COALESCE(b.Sab,0) as Sab, LastCheck, COALESCE(DCheck,0) as DCheck,  LastAdjust, COALESCE(DAdjust,0) as DAdjust, COALESCE(sum(psm.Quantity),0) as Quantity,
			vps.AtributeValue AS Shop, vpo.ProductAtributeValueName AS SourceAgent, pm.forSale,
			vpm.ProductAtributeValueName AS ProductManager
			FROM tb_product_main pm
			LEFT JOIN vw_product_sab b on pm.ProductID=b.ProductID
			LEFT JOIN tb_product_stock_main psm on psm.ProductID= pm.ProductID
			LEFT JOIN vw_product_shop vps ON vps.ProductID = pm.ProductID
			LEFT JOIN vw_product_origin vpo ON vpo.ProductID=pm.ProductID
			LEFT JOIN vw_product_manager vpm ON vpm.ProductID=pm.ProductID
			LEFT JOIN vw_product_adjustment vpa ON vpa.ProductID=pm.ProductID
			where pm.isActive=1 ";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "AND pm.ProductID like '".$_REQUEST['productid']."' ";
			$show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "AND pm.ProductName like '%".$_REQUEST['productname']."%' AND pm.forSale=1 ";
			$show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		}
		$sql.="GROUP BY pm.ProductID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][]= array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'Sab' => $row->Sab,
				'LastCheck' => $row->LastCheck,
				'Quantity' => $row->Quantity,
				'DCheck' => $row->DCheck,
				'Shop'=>$row->Shop,
				'SourceAgent'=>$row->SourceAgent,
				'forSale'=>$row->forSale,
				'ProductManager'=>$row->ProductManager,
				'LastAdjust'=>$row->LastAdjust,
				'DAdjust'=>$row->DAdjust,

			);
		 };
		return $show;
	}
	function get_report_stock_adjustment_detail()
	{
		$id = $this->input->get('a');
		$sql1 = "SELECT a.ProductID, a.ProductName, a.ProductCode, COALESCE(b.Sab,0) as Sab,
				b.CheckDate, b.WarehouseID, b.WarehouseName, COALESCE(b.Quantity,0) as Quantity
				FROM tb_product_main a
				LEFT JOIN vw_product_sab_detail b on a.ProductID=b.ProductID
				where a.ProductID=".$id."
				GROUP BY b.WarehouseID ";
		$query1 	= $this->db->query($sql1);
		foreach ($query1->result() as $row1) {
			$show['main1'][]= array(
				'ProductID' => $row1->ProductID,
				'ProductName' => $row1->ProductName,
				'ProductCode' => $row1->ProductCode,
				'WarehouseID'=>$row1->WarehouseID,
				'WarehouseName'=>$row1->WarehouseName,
				'Stock'=>$row1->Quantity,
			);
		}
		$sql = "SELECT a.ProductID, a.ProductName, a.ProductCode,
				COALESCE(b.Sab,0) as Sab,
				b.CheckDate, b.WarehouseID, b.WarehouseName, COALESCE(b.Quantity,0) as Quantity
				FROM tb_product_main a
				LEFT JOIN vw_product_sab_detail b on a.ProductID=b.ProductID
				where a.isActive=1 and a.ProductID= $id and b.ProductID is not null order by b.WarehouseID, b.CheckDate";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][]= array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'Sab' => $row->Sab,
				'Quantity'=>$row->Quantity,
				'CheckDate' => $row->CheckDate,
				'WarehouseID'=>$row->WarehouseID,
				'WarehouseName'=>$row->WarehouseName
			);
		 };
		return $show;
	}
	function product_stock_history()
	{
		$ProductID 	= $this->input->get_post('product');
		$sql = "SELECT psm.ProductID, pm.ProductCode, pm.ProductName, COALESCE(wm.WarehouseName,'Kosong') as WarehouseName, COALESCE(psm.Quantity, '0') as Quantity
				FROM tb_product_main pm
				LEFT JOIN tb_product_stock_main psm ON (pm.ProductID = psm.ProductID)
				LEFT JOIN tb_warehouse_main wm ON (psm.WarehouseID = wm.WarehouseID)
				WHERE pm.ProductID = ".$ProductID;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'ProductID' => $row->ProductID,
		  			'ProductCode' => $row->ProductCode,
		  			'ProductName' => $row->ProductName,
		  			'WarehouseName' => $row->WarehouseName,
		  			'Quantity' => $row->Quantity
				);
		};

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_shop_detail()
	{
		$show = array();
		$ProductID = $this->input->get_post('productid');
		$sql4 = "SELECT sp.*, sm.ShopName FROM tb_shop_product sp
					LEFT JOIN tb_shop_main sm ON sp.ShopID = sm.ShopID
					where sp.ProductID='".$ProductID."'";
		// echo $sql4;	
		$url="";		
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
				$ShopName = $row4->ShopName;
				$LinkText = $row4->LinkText;
				if($LinkText==""){
					$url.=$ShopName;
				} else {
					$url.="<a href='".$LinkText."' target='_blank'>".$ShopName."</a><br>";
				}
		};
		echo $url;
	}
	function product_shop()
	{
		$show = array();
		$ProductID = $this->input->get_post('productid');
		$sql = "SELECT ProductID, ProductName FROM tb_product_main where ProductID='".$ProductID."'";
		// echo $sql;	
		$query 	= $this->db->query($sql);
		$show['main']  = $query->result_array()[0];
	
		$sql 	= "SELECT * from tb_shop_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['shoplist'][] = array(
					'ShopID' => $row->ShopID, 
					'ShopName' => $row->ShopName, 
				);
		};
		
		$sql 	= "SELECT tsp.ShopID, tsm.ShopName, tsp.LinkText, tsp.OrderID from tb_shop_product tsp left join tb_shop_main tsm on tsp.ShopID = tsm.ShopID where ProductID=".$ProductID;
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
					'ShopID' => $row->ShopID, 
					'OrderID' => $row->OrderID,
					'ShopName' => $row->ShopName,
					'LinkText' => $row->LinkText,
				);
		};
		return $show;
	}
	function product_shop_act()
	{
		$this->db->trans_start();
		// echo json_encode($this->input->post());
		$ShopID = $this->input->post('shopname');
		$ProductID	= $this->input->post('ProductID'); 
		$OrderID	= $this->input->post('OrderID');
		$LinkText	= $this->input->post('LinkText');

		$this->db->where('ProductID', $ProductID);
		$this->db->where_not_in('OrderID', $OrderID); // delete array not in
		$this->db->delete('tb_shop_product');
		$this->last_query .= "//".$this->db->last_query();
		
		for ($i=0; $i < count($OrderID) ; $i++) { 
			// echo $OrderID[$i].$LinkText[$i].'<br>';

			if ($OrderID[$i] == 0) {
				$data = array(
					'ShopID' => $ShopID[$i],
					'ProductID' => $ProductID,
					'InputDate' => date('Y-m-d H:i:s'),
					'LinkText' => $LinkText[$i],
					'LinkDate' => date('Y-m-d H:i:s')
				);
				$this->db->insert('tb_shop_product', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}	

	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	}
	function get_product_offline_detail()
	{
		$id = $this->input->get('a');
		$sql 	= "SELECT * FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID
					left JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
					left JOIN vw_product_origin vpo ON vpo.ProductID=pm.ProductID
					where pm.ProductID = '".$id."'
					GROUP BY pm.ProductID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$isActive 	= ($row->isActive!="0" ? "Yes" : "No");
			$forSale 	= ($row->forSale!="0" ? "Yes" : "No");
			$Stockable 	= ($row->Stockable!="0" ? "Yes" : "No");
			$show = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'ProductSupplier' => $row->ProductSupplier,
				'ProductDescription' => $row->ProductDescription,
				'ProductStatusName' => $row->ProductStatusName,
				'ProductCategoryID' => $row->ProductCategoryID,
				'ProductBrandID' => $row->ProductBrandID,
				'ProductAtributeSetName' => $row->ProductAtributeSetName,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'CountryName' => $row->StateName,
				'AtributeValue' => $row->AtributeValue,
				'ProductAtributeValueName' => $row->ProductAtributeValueName,
				'ProductCodeBar' => $row->ProductCodeBar,
				'Stockable' => $Stockable,
				'MaxStock' => $row->MaxStock,
				'MinStock' => $row->MinStock,
				'forSale' => $forSale,
				'isActive' => $isActive
			);
		};
		$result_category = "";
		$arr1 		= array();
		$category 	= $this->fill_category_code($row->ProductCategoryID, $arr1);
		$category 	= array_reverse($category);
		foreach($category as $result) {
		    $result_category .= $result['ProductCategoryName'].'-';
		}
		$show['category'] = substr($result_category, 0, -1);

		$result_brand = "";
		$arr2 	= array();
		$brand 	= $this->fill_brand_code($row->ProductBrandID, $arr2);
		$brand 	= array_reverse($brand);
		foreach($brand as $result) {
		    $result_brand .= $result['ProductBrandName'].'-';
		}
		$show['brand'] = substr($result_brand, 0, -1);

		$sql2 	= "SELECT pad.*, pa.ProductAtributeName, IFNULL(vpo.ProductAtributeValueName,pad.AtributeValue) AS AtributeName 
					FROM tb_product_atribute_detail pad
					LEFT JOIN tb_product_atribute pa ON (pad.ProductAtributeID=pa.ProductAtributeID)
					LEFT JOIN vw_product_atribute_name vpo ON vpo.AtributeValue= pad.AtributeValue AND pad.ProductID=vpo.ProductID AND pad.ProductAtributeID=vpo.ProductAtributeID
					WHERE pad.ProductID ='".$id."'
					ORDER BY pad.ProductAtributeID";
		$query2 = $this->db->query($sql2);
		if ($query2->num_rows() != 0 ) {
			foreach ($query2->result() as $row2) {
				$show['atribute'][] = array(
					'ProductID' => $row2->ProductID,
					'ProductAtributeName' => $row2->ProductAtributeName,
					'AtributeName' => $row2->AtributeName
				);
			};
		}

		$sql3 	= "SELECT ProductID, EXPDate, DATEDIFF(psi.EXPDate,NOW()) as EXPDays FROM tb_product_stock_in psi
					WHERE psi.ProductID = '".$id."' AND EXPDate !='' AND EXPDate > DATE(NOW())";
		$query3 = $this->db->query($sql3);
		if ($query3->num_rows() != 0 ) {
			foreach ($query3->result() as $row3) {
				$show['expiry'][] = array(
					'EXPDate' => $row3->EXPDate,
					'EXPDays' => $row3->EXPDays,
					'ProductID' => $row3->ProductID
				);
			};
		}

		$sql5 = "SELECT * FROM tb_product_file WHERE ProductID='".$id."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$show['file'][] = array(
				'ProductID' => $row5->ProductID,
				'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};
		
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

// Price==================================================================
	function report_product_price_active()
	{
		$show = array();
		$show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');
		$Category = $this->input->get_post('category');
		$Brand = $this->input->get_post('brand');
		$Expiry = $this->input->get_post('expiry');

		$sql = "
			SELECT pm.ProductID, pm.ProductName, tpsi.EXPDate,
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault, tvp.cbd, ast.StateName, pm.ProductMultiplier, pm.ProductPriceHPP
			FROM tb_product_main pm
			LEFT JOIN vw_product_stock psm ON pm.ProductID = psm.ProductID
			LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
			LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
			LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
			LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent
			LEFT JOIN (
				SELECT * FROM tb_product_atribute_detail
				WHERE ProductAtributeID = '20' GROUP BY ProductID
			) tad on tad.ProductID=pm.ProductID
			LEFT JOIN (
				SELECT vpp.ProductID, min(vpp.PricePT2Discount) as cbd
				FROM vw_product_promo_list_active_with_price_no_vol vpp
				GROUP BY vpp.ProductID
			) tvp ON tvp.ProductID=pm.ProductID
			LEFT JOIN (
				SELECT psi.ProductID, psi.EXPDate FROM tb_product_stock_in psi
					WHERE psi.EXPDate !='' AND psi.EXPDate > DATE(NOW())
				GROUP BY psi.ProductID
			) tpsi ON tpsi.ProductID=pm.ProductID
			LEFT JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
		";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "WHERE pm.ProductID like '".$_REQUEST['productid']."' AND pm.forSale=1 ";
			$show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "WHERE pm.ProductName like '%".$_REQUEST['productname']."%' AND pm.forSale=1 ";
			$show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		} else {$sql .="WHERE psm.stock >0 AND pm.forSale=1 ";}
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {

			$sql .= "AND pm.ProductCountry = '".$_REQUEST['origin']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND pm.ProductCategoryID = '".$_REQUEST['category']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['brand']) && $_REQUEST['brand'] != '0') {
			$sql .= "AND pm.ProductBrandID  = '".$_REQUEST['brand']."'";
		} else {$sql .="";}
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql1 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 AND ProductAtributeValueCode='".$_REQUEST['source']."'";
			// echo $sql1;
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;
			$sql .= "AND tad.AtributeValue like '".$_REQUEST['source']."' ";
			$show['info_filter'] .= "Source Agent : ".$Origin."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['expiry']) && $_REQUEST['expiry'] != '') {
			$sql .= "AND tpsi.EXPDate is Not Null ";
			$show['info_filter'] .= "Expiry : Not Null"."<br>";
		} else {$sql .="";}
		$sql.=" ORDER BY pm.ProductID ASC ";

		$sql2 	= "SELECT PV from tb_site_config ";
		$getrow = $this->db->query($sql2);
		$row2	= $getrow->row();
		$PV 	= $row2->PV;

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			if (empty($row->cbd)){
				$Price= $row->ProductPriceDefault;
			} else {
				$Price= $row->cbd;
			}
			$ProductMultiplier 	= $row->ProductMultiplier;

			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'Price' => $Price,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'Stock' => $row->Stock,
				'StateName' => $row->StateName,
				'EXPDate' => $row->EXPDate,
			);
		};

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};

		$sql5 = "SELECT * FROM tb_address_state";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$show['state'][] = array(
				'StateID' => $row5->StateID,
				'StateName' => $row5->StateName,
			);
		};

	    return $show;
	}
	function report_product_price_active_detail()
	{
		$show = array();
		$ProductID = $this->input->get_post('product');

		$sql5 = "SELECT pl.*, pm.ProductPriceDefault, pm.ProductName from vw_product_promo_list_active pl
				LEFT JOIN tb_product_main pm ON pl.ProductID=pm.ProductID
				where pl.ProductID='".$ProductID."' order by pl.PromoCategory, pl.PT1Discount";
		// echo $sql5;
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$PriceAfterCategory = $this->get_min_percent($row5->ProductPriceDefault, $row5->PromoCategory);
			$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row5->Promo);
			$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row5->PT1Discount);
			$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row5->PT2Discount);

			$show['pricelist'][] = array(
				'ProductName' => $row5->ProductName,
				'PricecategoryName' => $row5->PricecategoryName,
				'PricelistName' => $row5->PricelistName,
				'ProductID' => $row5->ProductID,
				'ProductQty' => $row5->ProductQty,
				'PromoCategory' => $row5->PromoCategory,
				'Promo' => $row5->Promo,
				'PT1Discount' => $row5->PT1Discount,
				'PT2Discount' => $row5->PT2Discount,
				'ProductPriceDefault' => $row5->ProductPriceDefault,
				'PriceAfterCategory' => $PriceAfterCategory,
				'ProductPricePromo' => $ProductPricePromo,
				'ProductPricePT1' => $ProductPricePT1,
				'ProductPricePT2' => $ProductPricePT2
			);
		};
		return $show;
	}
	function report_product_price_offline_reseller()
	{
		$show = array();
		$show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$Category = $this->input->get_post('category');

		$sql = "
			SELECT pm.ProductID, pm.ProductName,
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault, ast.StateName, pm.ProductMultiplier, pm.ProductPriceHPP, tpsi.EXPDate
			FROM tb_product_main pm
			LEFT JOIN vw_product_stock psm ON pm.ProductID = psm.ProductID
			LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
			LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
			LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
			LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent
			LEFT JOIN (
				SELECT * FROM tb_product_atribute_detail
				WHERE ProductAtributeID = '20' GROUP BY ProductID
			) tad on tad.ProductID=pm.ProductID
			LEFT JOIN (
				SELECT psi.ProductID, psi.EXPDate FROM tb_product_stock_in psi
					WHERE psi.EXPDate !='' AND psi.EXPDate > DATE(NOW())
				GROUP BY psi.ProductID
			) tpsi ON tpsi.ProductID=pm.ProductID
			LEFT JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
		";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "WHERE pm.ProductID like '".$_REQUEST['productid']."' ";
			$show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "WHERE pm.ProductName like '%".$_REQUEST['productname']."%' AND pm.forSale=1 ";
			$show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		} else {$sql .="WHERE psm.stock >0 and pm.forSale=1 ";}
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {
			$sql .= "AND pm.ProductCountry = '".$_REQUEST['origin']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND pm.ProductCategoryID = '".$_REQUEST['category']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql1 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 AND ProductAtributeValueCode='".$_REQUEST['source']."'";
			// echo $sql1;
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;

			$sql .= "AND tad.AtributeValue like '".$_REQUEST['source']."' ";
			$show['info_filter'] .= "Source Agent : ".$Origin."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['expiry']) && $_REQUEST['expiry'] != '') {
			$sql .= "AND tpsi.EXPDate is Not Null ";
			$show['info_filter'] .= "Expiry : Not Null"."<br>";
		} else {$sql .="";}
		$sql.=" ORDER BY pm.ProductID ASC ";

		// echo $sql;
		$sql2 	= "SELECT PV from tb_site_config ";
		$getrow = $this->db->query($sql2);
		$row2	= $getrow->row();
		$PV 	= $row2->PV;

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$ProductMultiplier 	= $row->ProductMultiplier;
			$ProductPriceDefault = $row->ProductPriceDefault;
			$ResellerPrice= $ProductPriceDefault-(($ProductPriceDefault - $row->ProductPriceHPP)/$PV*0.7*1000*$ProductMultiplier);
			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'Stock' => $row->Stock,
				'StateName' => $row->StateName,
				'EXPDate' => $row->EXPDate,
				'ResellerPrice' => $ResellerPrice,
			);
		};
		$now=date('Y-m-d');
		$sql4 = "SELECT * FROM tb_price_list_main WHERE DateEnd >='".$now."' AND isActive=1";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['pricelist'][] = array(
				'PricelistID' => $row4->PricelistID,
				'PricelistName' => $row4->PricelistName,
			);
		};

		$sql5 = "SELECT * FROM tb_address_state";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$show['state'][] = array(
				'StateID' => $row5->StateID,
				'StateName' => $row5->StateName,
			);
		};

		$sql6 = "SELECT * FROM tb_price_category_main";
		$query6 = $this->db->query($sql6);
		foreach ($query6->result() as $row6) {
			$show['pricecategory'][] = array(
				'PricecategoryID' => $row6->PricecategoryID,
				'PricecategoryName' => $row6->PricecategoryName,
			);
		};

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};

	    return $show;
	}
	function report_price_check_list()
	{
		$show = array();
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');
		$show['info_filter'] = "";
		$now=date('Y-m-d');
		$date1=date('Y-m')."-15";

		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');
		$Category = $this->input->get_post('category');
		$Brand = $this->input->get_post('brand');

		if($now>$date1){
			$Date="tpc.CheckDate BETWEEN '".date('Y-m')."-16 00:00:00' AND '".date('Y-m-t')." 23:59:00'";
		} else {
			$Date="tpc.CheckDate BETWEEN '".date('Y-m')."-01 00:00:00' AND '".date('Y-m')."-15 23:59:00'";
		}

		$sql = " SELECT vp6.ProductID, vp6.ProductName, vp6.ProductCode, vp6.stock, vp6.forSale,
				vp6.ProductCategoryID, vp6.ProductBrandID, vp6.ProductPriceDefault, CONCAT( vped.ED, ' days' ) AS ED,
				vp6.ProductCategoryName, vp6.ProductBrandName, vpm.ProductAtributeValueName AS ProductManager,
				vpl.LO AS LO, COALESCE(vpr.Last, 100) AS Last, vpr.Screenshot
				FROM vw_product_list_popup6 vp6
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID = vp6.ProductID
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID = vp6.ProductID
				LEFT JOIN vw_product_last_order vpl ON vpl.ProductID = vp6.ProductID
				LEFT JOIN vw_product_expiry_date vped ON vped.ProductID = vp6.ProductID
				LEFT JOIN vw_price_recommendation_last vpr ON vpr.ProductID = vp6.ProductID
		";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "WHERE vp6.ProductID like '".$_REQUEST['productid']."' ";
			$show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "WHERE vp6.ProductName like '%".$_REQUEST['productname']."%' ";
			$show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		} else {$sql .="WHERE vp6.isActive=1 AND vp6.stock>0";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND vp6.ProductCategoryID = '".$_REQUEST['category']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['brand']) && $_REQUEST['brand'] != '0') {
			$sql .= "AND vp6.ProductBrandID  = '".$_REQUEST['brand']."'";
		} else {$sql .="";}
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql1 = "SELECT * FROM vw_product_origin WHERE AtributeValue='".$_REQUEST['source']."'";
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;

			$sql .= " AND vpo.AtributeValue like '".$_REQUEST['source']."' ";
			$show['info_filter'] .= "Source Agent : ".$Origin."<br>";
		} else {$sql .="";}
		if(in_array("report_price_check_list_view_all", $MenuList)){
			$sql .=" AND vpm.AtributeValue<>0 ";
		} else {$sql .=" AND vpm.AtributeValue=".$UserAccountID." ";}
		$sql.=" ORDER BY Last DESC, LO DESC ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['product'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryName' => $row->ProductCategoryName,
				'ProductBrandName' => $row->ProductBrandName,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'Stock' => $row->stock,
				'forSale' => $row->forSale,
				'ProductManager'=> $row->ProductManager,
				'ED'=> $row->ED,
				'LO'=> $row->LO,
				'Last'=> $row->Last,
				'Screenshot'=>$row->Screenshot
			);
		};
		$sql2 = "SELECT COUNT(vp6.ProductID) AS Notyet FROM vw_product_list_popup6 vp6
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID = vp6.ProductID
				WHERE vp6.stock>0 AND vp6.isActive=1 AND vp6.ProductID NOT IN (SELECT tpc.ProductID FROM tb_price_check tpc WHERE ".$Date." group by tpc.ProductID) ";
		if(in_array("report_price_check_list_view_all", $MenuList)){
			$sql2 .=" AND vpm.AtributeValue<>0 ";
		} else {$sql2 .=" AND vpm.AtributeValue=".$UserAccountID." ";}
		$query2 = $this->db->query($sql2);
		$row2 	= $query2->row();
		$Notyet=$row2->Notyet;

		$sql3 = "SELECT COUNT(vp6.ProductID) AS Product FROM vw_product_list_popup6 vp6
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID = vp6.ProductID
				WHERE vp6.stock>0 AND vp6.isActive=1 ";
		if(in_array("report_price_check_list_view_all", $MenuList)){
			$sql3 .=" AND vpm.AtributeValue<>0 ";
		} else {$sql3 .=" AND vpm.AtributeValue=".$UserAccountID." ";}
		$query3 = $this->db->query($sql3);
		$row3 	= $query3->row();
		$Product=$row3->Product;

		$Total=$Notyet/$Product;
		$Persen= (1-$Total)*100;
		$show['persen']=array(number_format($Persen));

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};

	    return $show;
	}

// ro======================================================================
	function report_ro_outstanding_po()
	{
		$sql = "SELECT * from vw_ro_list2  WHERE ROStatus<>2 and qty>qtypo ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ROID' => $row->ROID,
		  			'SOID' => $row->SOID,
		  			'RODate' => $row->RODate,
					'LastUpdate' => $row->ModifiedDate,
					'fullname' => $row->fullname,
					'RONote' => $row->RONote,
		  			'qty' => $row->qty,
		  			'qtypo' => $row->qtypo,
		  			'totaldor' => $row->totaldor,
		  			'ROStatus' => $row->ROStatus
				);
		};
	    return $show;
	}
	function report_ro_outstanding_dor()
	{
		$sql = "SELECT * from vw_ro_list2 WHERE ROStatus<>2 and qtypo>totaldor ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ROID' => $row->ROID,
		  			'SOID' => $row->SOID,
		  			'RODate' => $row->RODate,
					'LastUpdate' => $row->ModifiedDate,
					'fullname' => $row->fullname,
					'RONote' => $row->RONote,
		  			'qty' => $row->qty,
		  			'qtypo' => $row->qtypo,
		  			'totaldor' => $row->totaldor,
		  			'ROStatus' => $row->ROStatus
				);
		};
	    return $show;
	}

// po======================================================================
	function report_po_general()
	{
		$show   = array();
		$show['info_filter'] = "";
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');
		$supplier= $this->input->get_post('supplier');
		$POID= $this->input->get_post('poid');
		if (isset($_REQUEST['poid']) && $_REQUEST['poid'] != '') {
			$sqlDate = " WHERE pl.POID=".$POID;
		} else if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sqlDate = " WHERE (pl.PODate between '".$Date."' AND '".$Date2."') ";
		} else {
			$sqlDate = " WHERE MONTH(pl.PODate)=MONTH(CURRENT_DATE()) AND YEAR(pl.PODate)=YEAR(CURRENT_DATE()) ";
		}
		if (isset($_REQUEST['supplier']) && $_REQUEST['supplier'] != '0') {
			$sqlSupplier = " AND vs1.SupplierID=".$supplier;
		} else {
			$sqlSupplier = "";
		}

		$sql = "SELECT pl.*, vs1.Company2, vs1.SupplierID from vw_po_list4 pl
				LEFT JOIN vw_supplier1 vs1 ON vs1.SupplierID =pl.SupplierID ".$sqlDate.$sqlSupplier;
		$query 	= $this->db->query($sql);
		// echo $sql;
		foreach ($query->result() as $row) {
			$show['main'][] = array(
					'POID' => $row->POID,
					'SOID' => $row->ROID,
					'ROID' => $row->ROID,
					'PODate' => $row->PODate,
					'ShippingDate' => $row->ShippingDate,
					'Employee' => $row->Employee,
					'PONote' => $row->PONote,
					'POStatus' => $row->POStatus,
					'isApprove' => $row->isApprove,
					'PendingDOR' => $row->PendingDOR,
					'PendingDO' => $row->PendingDO,
					'Company2' => $row->Company2,
				);
		};

		$sql = "SELECT vs1.Company2, vs1.SupplierID FROM vw_supplier1 vs1";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['supplier'][] = array(
	  			'Company2' => $row2->Company2,
	  			'SupplierID' => $row2->SupplierID,
			);
		};
		return $show;
	}
	function report_po_outstanding_do()
	{
		$sql = "SELECT pm.*, vem.fullname as employee, vsup.fullname as supplier, vsup.Company, 
				COALESCE(SUM(pr.RawQty), 0) as qty, COALESCE(SUM(pr.RawSent), 0) as qtysent, 
				COALESCE(SUM(pr.RawQty), 0) - COALESCE(SUM(pr.RawSent), 0) as totalsent,
				GROUP_CONCAT( DISTINCT pr.stockReady ORDER BY pr.stockReady SEPARATOR ',') AS stockReady
				FROM tb_po_main pm 
				LEFT JOIN vw_user_account vem ON (pm.ModifiedBy = vem.UserAccountID)
				LEFT JOIN vw_supplier1 vsup ON (pm.SupplierID = vsup.SupplierID) ";

		if (isset($_REQUEST['WarehouseID'])) {
			$sql .= "LEFT JOIN ( 
						SELECT pr.POID AS POID, pr.ProductID AS ProductID, pr.RawID AS RawID, 
						pr.RawQty AS RawQty, pr.RawSent AS RawSent, pr.RawSent AS RawSent2, ps.stock AS stock,

						IF ( ( ps.stock >= ( pr.RawQty - pr.RawSent ) ), 'Ready', 'NotReady' ) AS stockReady
						FROM ( tb_po_raw pr
						LEFT JOIN (
							SELECT psm.ProductID AS ProductID, sum(psm.Quantity) AS stock
							FROM tb_product_stock_main psm
							WHERE psm.WarehouseID IN (" . implode(',', array_map('intval', $_REQUEST['WarehouseID'])) . ")
							GROUP BY psm.ProductID
						) ps ON ( ( pr.RawID = ps.ProductID ) ) )
					) pr ON (pm.POID = pr.POID) ";
		} else {
			$sql .= "LEFT JOIN vw_po_raw3 pr ON (pm.POID = pr.POID) ";
		}
		$sql .= "where pm.POStatus <> 2 and pm.isApprove=1 GROUP BY pm.POID 
				HAVING totalsent > 0";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			if ($row->qty > 0) {
			  	$show[] = array(
		  			'ROID' => $row->ROID,
		  			'POID' => $row->POID,
		  			'PODate' => $row->PODate,
					'ShippingDate' => $row->ShippingDate,
					'supplier' => $row->supplier.", ".$row->Company,
					'employee' => $row->employee,
					'qty' => $row->qty,
					'qtysent' => $row->qtysent,
					'stockReady' => $row->stockReady,
					'POStatus' => $row->POStatus,
					'DaysFromOrderDate' => ""
				);
			}
		};
	    return $show;
	}
	function report_po_outstanding_dor()
	{
		$show   = array();
		$sql = "SELECT pl.*, tsc.CategoryName, tsm.SODate, count(n.NoteDateTime) as note from vw_po_list2 pl
				LEFT JOIN tb_note n ON (n.NoteType='PO' AND n.NoteReff=pl.POID) 
				LEFT JOIN tb_so_main tsm ON pl.SOID=tsm.SOID
				LEFT JOIN tb_so_category tsc ON tsc.CategoryID=tsm.SOCategory
				where totalqty>totaldor and POStatus != 2 and POStatus != 1 and isApprove=1
				GROUP BY pl.POID ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'POID' => $row->POID,
		  			'ROID' => $row->ROID,
		  			'CategoryName' => $row->CategoryName,
		  			'SODate' => $row->SODate,
		  			'PODate' => $row->PODate,
					'ShippingDate' => $row->ShippingDate,
					'supplier' => $row->Company,
					'employee' => $row->employee,
		  			'TotalPrice' => $row->TotalPrice,
		  			'PONote' => $row->PONote,
		  			'POStatus' => $row->POStatus,
		  			'isApprove' => $row->isApprove,
		  			'POExpiredDate' => $row->POExpiredDate,
		  			'qty' => $row->totalqty,
		  			'qtydor' => $row->totaldor,
		  			'note' => $row->note,
	  				// 'rawsent' => $row->totaldo
				);
		};
	    return $show;
	}
	function query_report_po_outstanding_dor()
	{
		$sql = "SELECT COUNT(t1.POID) AS CountPO, 
				SUM(CASE WHEN t1.RawOutstanding>1 THEN 1 ELSE 0 END) AS RAW_not_sent,
				SUM(CASE WHEN t1.ShippingDate <= CURDATE() THEN 1 ELSE 0 END) AS PO_late
				FROM (
				SELECT pl.*, coalesce(t2.RawOutstanding,0) as RawOutstanding 
				from vw_po_list3 pl 
				left join ( 
				SELECT POID, COALESCE(SUM(RawQty), 0) - COALESCE(SUM(RawSent2), 0) as RawOutstanding, 
				COALESCE(SUM(RawSent2), 0) as RawSent2 FROM vw_po_raw3 GROUP BY POID 
				) t2 on pl.POID=t2.POID 
				where totalqty>totaldor and POStatus != 2 and POStatus != 1 and isApprove=1 GROUP BY pl.POID
				) t1";
	    return $sql;
		$this->log_user->log_query($this->last_query);
	}
	function report_po_dor_general()
	{
		$this->db->trans_start();
		$show 	= array();
		$show['info_filter'] = "";
		$sql 	= "SELECT pm.*, pl.*, pm.totaldor, GROUP_CONCAT(dd.DistributionID SEPARATOR ', ') AS DistributionID
					from vw_po_product_dor_price_main pm 
					left join vw_po_list2 pl on (pm.DORReff = pl.POID)
					LEFT JOIN tb_bank_distribution_detail dd ON dd.ReffType='DOR' AND dd.ReffNo=pm.DORID 
					WHERE pm.ProductPriceTotal>0 ";

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) &&  $_REQUEST['input2'] != "" ) {
			$sql .= "AND DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['input1']." <> ".$_REQUEST['input2']."<br>";
		}  

		if ( isset($_REQUEST['distribution']) ) {
			if ($_REQUEST['distribution'] == 'NotInDIstribution') {
				$sql .= " and dd.DistributionID is NULL ";
				$show['info_filter'] .= "status payment : in Distribution<br>";
			} elseif ($_REQUEST['distribution'] == 'InDIstribution') {
				$sql .= " and dd.DistributionID is not NULL ";
				$show['info_filter'] .= "status payment : in Distribution<br>";
			}
		} else {
			$sql .= " and dd.DistributionID is NULL ";
		}

		$sql .= "GROUP BY pm.DORID ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$Supplier 	= explode(";", $row->SupplierNote);
			// $ProductPriceTotal = $row->ProductPriceTotal + ($row->ProductPriceTotal * ($row->TaxRate/100));
		  	$show['main'][] = array(
					'DORID' => $row->DORID,
					'POID' => $row->POID,
					'ROID' => $row->ROID,
					'Supplier' => $Supplier[0],
					'DORDoc' => $row->DORDoc,
					'DORDate' => $row->DORDate,
					'DORNote' => $row->DORNote,
					'totaldor' => $row->totaldor,
					'ProductPriceTotal' => $row->ProductPriceTotal,
					'DistributionID' => $row->DistributionID,
				);
		};

	    return $show;
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function report_po_dor_product()
	{
		$this->db->trans_start();
		$show = array();
		$show['info_filter'] = "";
		$sql 	= "SELECT dd.*, dm.DORDate, dm.DORType, dm.DORReff, pm.ProductCode, pom.SupplierNote
					FROM tb_dor_main dm
					LEFT JOIN tb_dor_detail dd ON dd.DORID=dm.DORID
					LEFT JOIN tb_product_main pm ON dd.ProductID=pm.ProductID 
					LEFT JOIN tb_po_main pom ON dm.DORReff=pom.POID ";

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) &&  $_REQUEST['input2'] != "" ) {
			$sql .= "WHERE DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
			$show['info_filter'] .= "Filter Date : ".$_REQUEST['input1']." <> ".$_REQUEST['input2']."<br>";
		} else {
			$sql .= "where MONTH(DORDate)=MONTH(CURRENT_DATE()) AND YEAR(DORDate)=YEAR(CURRENT_DATE()) ";
		}
		$sql .= "and dm.DORType='PO' order BY dd.DORID ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$SupplierNote = explode(";", $row->SupplierNote);
		  	$show['main'][] = array(
					'DORID' => $row->DORID,
					'POID' => $row->DORReff,
					'ProductID' => $row->ProductID,
					'ProductCode' => $row->ProductCode,
					'DORDate' => $row->DORDate,
					'ProductQty' => $row->ProductQty,
					'SupplierNote' => $SupplierNote[1],
				);
		};
	    return $show;
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function po_note()
	{
		$this->db->trans_start();

		$show = array();
		$ponote = $this->input->post('ponote');
		$poid	= $this->input->post('poid'); 

		$data = array(
			'NoteType' => 'PO',
			'NoteReff' => $poid,
			'NoteDateTime' => date('Y-m-d H:i:s'),
			'NoteBy' => $this->session->userdata('UserAccountID'),
			'NoteText' => $ponote
		);
		$this->db->insert('tb_note', $data);
		$this->last_query .= "//".$this->db->last_query();
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// ========================================================================
	function get_percent($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			$percent 	= $num1/100;
			$result 	= $num2/$percent; 
		} elseif ($num2 < 0) {
			$num2 *= -1;
			$percent 	= $num1/100;
			$result 	= $num2/$percent;
			$result 	*= -1;;
		}
		return number_format($result,2);
	}
	function get_min_percent($num1, $num2)
	{
		$result  = 0;
		$percent = ($num1/100)*$num2;
		$result  = $num1 - $percent; 
		return $result;
		$this->log_user->log_query($this->last_query);
	}
	function history_so()
	{
		$this->db->trans_start();

		$show = array();
		$SOID = $this->input->get_post('id');
		// $show = array_merge($show, $this->history_detail_ro("SO", $SOID, "-") );
		$show['transaction'] = $this->history_detail_ro("SO", $SOID, "-");
		$show['transaction2'] = $this->history_detail_do("SO", $SOID, "-");
		$show['transaction3'] = $this->history_detail_po2("SO", $SOID, "-");
		$show['note'] = $this->history_detail_note("SO", $SOID, "-");
		$show['payment'] = $this->history_detail_payment("SO", $SOID);
		// echo json_encode($show);
		return $show;
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function history_po()
	{
		$this->db->trans_start();

		$show = array();
		$POID = $this->input->get_post('poid');
		$show['note'] = $this->history_detail_note("PO", $POID, "-");
		return $show;
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function history_detail_ro($type, $id, $spacing, $result = array())
	{
		$sql 	= "SELECT rm.ROID, rm.ModifiedDate, rm.RONote, em.fullname FROM tb_ro_main rm
					LEFT JOIN vw_user_account em ON rm.ModifiedBy=em.UserAccountID
					WHERE rm.SOID=".$id;
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$result[] = array(
					'type' => "RO",
					'id' => $row->ROID,
					'note' => $row->RONote,
		  			'date' => $row->ModifiedDate,
		  			'fullname' => $row->fullname,
		  			'spacing' => $spacing.">"
				);
		      	$result = $this->history_detail_po("RO", $row->ROID, "&nbsp;&nbsp;&nbsp;".$spacing, $result);
			};
		}
		return $result;
	}
	function history_detail_po2($type, $id, $spacing, $result = array())
	{
		$sql 	= "SELECT pm.POID, pm.ModifiedDate, pm.PONote, em.fullname FROM tb_po_main pm
					LEFT JOIN vw_user_account em ON pm.ModifiedBy=em.UserAccountID
					WHERE pm.SOID=".$id;
					// echo $sql;
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$result[] = array(
					'type' => "PO",
					'id' => $row->POID,
					'note' => $row->PONote,
					'date' => $row->ModifiedDate,
					'fullname' => $row->fullname,
					'spacing' => $spacing.">"
				);
			};
		}
		return $result;
	}
	function history_detail_po($type, $id, $spacing, $result = array())
	{
		$sql 	= "SELECT pm.POID, pm.POCreate, pm.PONote, em.fullname FROM tb_po_main pm
					LEFT JOIN vw_user_account em ON pm.ModifiedBy=em.UserAccountID
					WHERE pm.ROID=".$id;
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$result[] = array(
					'type' => "PO",
					'id' => $row->POID,
					'note' => $row->PONote,
		  			'date' => $row->POCreate,
		  			'fullname' => $row->fullname,
		  			'spacing' => $spacing.">"
				);
		      	$result = $this->history_detail_dor("PO", $row->POID, "&nbsp;&nbsp;&nbsp;".$spacing, $result);
			};
		}
		return $result;
	}
	function history_detail_dor($type, $id, $spacing, $result = array())
	{
		$sql 	= "SELECT dm.DORID, dm.DORInput, em.fullname FROM tb_dor_main dm
					LEFT JOIN vw_user_account em ON dm.DORBy=em.UserAccountID
					WHERE dm.DORType='".$type."' AND dm.DORReff=".$id;
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$result[] = array(
					'type' => "DOR",
					'id' => $row->DORID,
					'note' => "",
		  			'date' => $row->DORInput,
		  			'fullname' => $row->fullname,
		  			'spacing' => $spacing.">"
				);
			};
		}
		return $result;
	}
	function history_detail_do($type, $id, $spacing, $result = array())
	{
		$sql 	= "SELECT dm.DOID, dm.DOInput, em.fullname FROM tb_do_main dm
					LEFT JOIN vw_user_account em ON dm.DOBy=em.UserAccountID
					WHERE dm.DOType='".$type."' AND dm.DOReff=".$id;
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$result[] = array(
					'type' => "DO",
					'id' => $row->DOID,
					'note' => "",
		  			'date' => $row->DOInput,
		  			'fullname' => $row->fullname,
		  			'spacing' => $spacing.">"
				);
			};
		}
		return $result;
	}
	function history_detail_note($type, $id, $spacing, $result = array())
	{
		$sql 	= "SELECT n.*, em.fullname FROM tb_note n
					LEFT JOIN vw_user_account em ON n.NoteBy=em.UserAccountID
					WHERE n.NoteType='".$type."' AND n.NoteReff=".$id;
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$result[] = array(
					'NoteDateTime' => $row->NoteDateTime,
		  			'NoteBy' => $row->fullname,
		  			'NoteText' => $row->NoteText
				);
			};
		}
		return $result;
	}
	function history_detail_payment($type, $id, $result = array())
	{
		$result = array();
		if ($type == 'SO') {
			$sql 	= "SELECT cda.AllocationDate, cda.AllocationAmount, cd.TransferDate
						FROM tb_customer_deposit_allocation cda
						LEFT JOIN vw_deposit_transfer_date cd ON cd.DepositID=cda.DepositID
						WHERE cda.SOID=".$id;
			$query 	= $this->db->query($sql);
			$rowcount = $query->num_rows();
			if ($rowcount > 0) {
					foreach ($query->result() as $row) {
						if ($row->AllocationAmount > 0) {
							$result[] = array(
								'PaymentDate' => $row->AllocationDate,
					  			'PaymentAmount' => $row->AllocationAmount,
					  			'TransferDate' => $row->TransferDate
							);
						}
					};
			}
			$sql 	= "SELECT cda.PaymentDate, cda.PaymentAmount, cd.TransferDate
						FROM tb_customer_payment cda
						LEFT JOIN vw_deposit_transfer_date cd ON cd.DepositID=cda.DepositID
						WHERE cda.SOID=".$id;
			$query 	= $this->db->query($sql);
			$rowcount = $query->num_rows();
			if ($rowcount > 0) {
				foreach ($query->result() as $row) {
					if ($row->PaymentAmount > 0) {
						$result[] = array(
							'PaymentDate' => $row->PaymentDate,
				  			'PaymentAmount' => $row->PaymentAmount,
				  			'TransferDate' => $row->TransferDate
						);
					}
				};
			}
		}
		return $result;
	}
	function full_category($id = 0, $name = "")
	{
		$sql 	= "select ProductCategoryName, ProductCategoryParent from tb_product_category where ProductCategoryID = ".$id."";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$name = $row->ProductCategoryName.$name;
				if ($row->ProductCategoryParent != 0 ) {
					$name = "-".$name;
		      		$name = $this->full_category($row->ProductCategoryParent, $name);
				}

			};
		}
		return $name;
	}
	function full_brand($id = 0, $name = "")
	{
		$sql 	= "select ProductBrandName, ProductBrandParent from tb_product_brand where ProductBrandID = ".$id."";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$name = $row->ProductBrandName.$name;
				if ($row->ProductBrandParent != 0 ) {
					$name = "-".$name;
		      		$name = $this->full_brand($row->ProductBrandParent, $name);
				}

			};
		}
		return $name;
	}
	// function get_sales_child($SalesID)
	// {
	// 	if ($SalesID[0] != 0) {
	// 		$sqlS 	= "SELECT SalesID FROM tb_sales_executive WHERE SalesParent in (" . implode(',', array_map('intval', $SalesID)) . ") ";
	// 		$query 	= $this->db->query($sqlS);
	// 		foreach ($query->result() as $row) {
	// 			array_push($SalesID, $row->SalesID);
	// 		};
	// 	}
	// 	return $SalesID;
	// }
	function get_sales_child($SalesID)
	{
		if ($SalesID[0] != 0) {
			$sqlS 	= "SELECT SalesID FROM tb_sales_executive WHERE SalesParent in (" . implode(',', array_map('intval', $SalesID)) . ") AND SalesID not in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$query 	= $this->db->query($sqlS);
			foreach ($query->result() as $row) {
				array_push($SalesID, $row->SalesID);
		      	$SalesID2 = $this->get_sales_child( array($row->SalesID) );
		      	unset($SalesID2[0]);
		      	if (!empty($SalesID2)) {
			      	foreach ($SalesID2 as $key => $value) {
						array_push($SalesID, $value);
			      	}
		      	}
			};
		}
		return $SalesID;
	}
	function contact_list_detail()
    {
		$show = array();
        $id  = $this->input->get_post('a');

        // query get data utama
		$sql = "select c.*, r.* from vw_contact2 c ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "where ContactID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		$gender	= $row->Gender=="M" ? "Male" : "Female";

		// query get data alamat
		$sql3 = "select ca.*, cas.*, capr.*, cac.*, cad.*, capo.* from tb_contact_address ca ";
		$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "where ca.ContactID = '".$id."' order by ca.isBilling DESC, ca.DetailType ";
		// echo $sql3;
		$query3 = $this->db->query($sql3);
		$alamat = "";
		foreach ($query3->result() as $row3) {
			$billing = $row3->isBilling==0 ? "" : "(Billing address)";
		  	$alamat .= "<b>".$row3->DetailType.$billing."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID."<br><br>";
		  	$alamat .= '<a href="'.base_url().'general/contact_print?id='.$row3->OrderID.'" target="_blink" class="btn btn-xs btn-primary" Title="'.$row3->OrderID.'">Print Label</a>
		  				';
		  	$alamat .= "<br><br>";
		};

		// query get data phone email
		$sql4 = "select cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$id."'";
		$query4 = $this->db->query($sql4);
		$phone = "";
		$email = "";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email") {
				$email .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			} else if ($row4->DetailName == "phone") {
				$phone .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			}
		};

		// query get data contact person
		$sql5 = "SELECT cp.*, c.Company2, c2.phone, c3.email FROM tb_contact_person cp
				LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
				LEFT JOIN vw_contact_phone c2 ON (cp.ContactPersonID=c2.ContactID)
				LEFT JOIN vw_contact_email c3 ON (cp.ContactPersonID=c3.ContactID)
				WHERE cp.ContactID='".$id."' and cp.ContactPersonID <>''";
		$query5 = $this->db->query($sql5);
		$contact_person = "";
		foreach ($query5->result() as $row5) {
			$contact_person .= "-> ".$row5->ContactPersonID." | ".$row5->Company2." | ".$row5->ContactPersonType." | ".$row5->phone." | ".$row5->email."<br>";
		};

	  	$show = array(
		  	'id' => $id,
		  	'ContactID' => $row->ContactID,
			'fullname' => $row->Company2,
			'ShopName' => $row->ShopName,
			'gender' => $gender,
			'religion' => $row->ReligionName,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'BirthDate' => $row->BirthDate,
			'Phone' => $phone,
			'Email' => $email,
			'address' => $alamat,
			'contact_person' => $contact_person,
			'isEmployee' => $row->isEmployee,
			'isCustomer' => $row->isCustomer,
			'isSales' => $row->isSales,
			'isSupplier' => $row->isSupplier,
			'isExpedition' => $row->isExpedition,
			'isCompany' => $row->isCompany
		);

		if ($row->isEmployee == "1") {
			$sql5 	= "select EmployeeID from tb_employee_main where ContactID = '".$id."' ";
			$query5	= $this->db->query($sql5);
			$row5 	= $query5->row();
			$show['EmployeeID'] = $row5->EmployeeID;
		}
	    return $show;
	}
	function report_marketing_activity()
	{
		$show   = array();
		$show['info_filter'] = "";
		$bulan=date('Y-m');
		$ActivityDate = $this->input->get_post('filterstart');
		$ActivityDate2= $this->input->get_post('filterend');

		$sql = "SELECT t1.*, vse.SalesName FROM ( SELECT SalesID, DATE_FORMAT(ActivityDate, '%Y-%m') as Month, ActivityDate,
					SUM(IF (ActivityType = 'Customer Follow Up (CFU)',1,0)) AS CFU,
					SUM(IF (ActivityType = 'Customer Visit (CV)',1,0)) AS CV,
					COUNT(DISTINCT CASE WHEN ActivityType='Customer Follow Up (CFU)' then ActivityReffNo END) as CustomerCFU,
					COUNT(DISTINCT CASE WHEN ActivityType='Customer Visit (CV)' then ActivityReffNo END) as CustomerCV,
					COUNT(CASE WHEN ActivityType='Customer Follow Up (CFU)' and isApprove='1' then isApprove END) as CFUApprove,
					COUNT(CASE WHEN ActivityType='Customer Follow Up (CFU)' and isApprove='0' then isApprove END) as CFUNotApprove,
					COUNT(CASE WHEN ActivityType='Customer Follow Up (CFU)' and isApprove='2' then isApprove END) as CFUReject,
					COUNT(CASE WHEN ActivityType='Customer Visit (CV)' and isApprove='1' then isApprove END) as CVApprove,
					COUNT(CASE WHEN ActivityType='Customer Visit (CV)' and isApprove='0' then isApprove END) as CVNotApprove,
					COUNT(CASE WHEN ActivityType='Customer Visit (CV)' and isApprove='2' then isApprove END) as CVReject
				FROM tb_marketing_activity ";
			if ($ActivityDate && $ActivityDate2 != "") {
			$ActivityDate = date_create($this->input->get_post('filterstart'));
			$ActivityDate2 = date_create($this->input->get_post('filterend'));
			$ActivityDate = date_format($ActivityDate, "Y-m-d");
			$ActivityDate2 = date_format($ActivityDate2, "Y-m-t");

			$sql .= "where (ActivityDate between '".$ActivityDate."' AND '".$ActivityDate2."') ";
			
			} else {

			$sql .= "where ActivityDate like '%".$bulan."%' ";

			}

			$sql .= "GROUP BY SalesID
				) t1
				LEFT JOIN vw_sales_executive2 vse On vse.SalesID=t1.SalesID ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("marketing_activity_linked", $MenuList)) {
        	$this->load->model('model_report');
			$SalesID = $this->model_report->get_sales_child($SalesID);
			$sql .= "Where t1.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("marketing_activity_all", $MenuList)) {
			$sql .= "Where t1.SalesID<>'' ";
		}
			$sql .= "order by t1.SalesID desc limit ".$this->limit_result;
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function marketing_activity_print()
	{
		$show   = array();
		$SalesID 	= $this->input->get_post('SalesID');
		$CategoryID = $this->input->get_post('CategoryID');
		$Month 	= $this->input->get_post('Month');

		$sql 	= "SELECT tma.SalesID, DATE_FORMAT(tma.ActivityDate,'%M %Y') As Month, vse.Company2 as Sales, vc3.CityID , vc3.CityName, COALESCE(CFU.TotalCFU,0) as TotalCFU, COALESCE(CV.TotalCV,0) as TotalCV from tb_marketing_activity tma
					LEFT JOIN vw_sales_executive3_active vse ON vse.SalesID=tma.SalesID
					LEFT JOIN vw_customer3 vc3 ON vc3.CustomerID=tma.ActivityReffNo 
					LEFT JOIN (
					SELECT SalesID, COUNT(vc3.CityName) as TotalCFU, vc3.CityID from tb_marketing_activity tma
					LEFT JOIN vw_customer3 vc3 ON vc3.CustomerID=tma.ActivityReffNo
					where tma.ActivityType='Customer Follow Up (CFU)' and isApprove = 1 and tma.ActivityDate like '%".$Month."%' and tma.SalesID =".$SalesID."
					GROUP BY vc3.CityID
					) CFU ON CFU.CityID = vc3.CityID
					LEFT JOIN (
					SELECT SalesID, COUNT(vc3.CityName) as TotalCV, vc3.CityID from tb_marketing_activity tma
					LEFT JOIN vw_customer3 vc3 ON vc3.CustomerID=tma.ActivityReffNo
					where tma.ActivityType='Customer Visit (CV)' and isApprove = 1 and tma.ActivityDate like '%".$Month."%' and tma.SalesID=".$SalesID."
					GROUP BY vc3.CityID
					) CV ON CV.CityID = vc3.CityID
					where tma.SalesID =".$SalesID." and tma.ActivityDate like '%".$Month."%' and isApprove = 1
					GROUP BY vc3.CityID";
					// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$sql2 = "SELECT maf.SalesID, mac.FeeCFU, mac.FeeCV, mab.CFUUp, mab.CVUp
				FROM tb_marketing_activity_fee maf 
				LEFT JOIN tb_marketing_activity_category mac ON mac.ID = maf.CategoryID
				LEFT JOIN tb_marketing_activity_bonus mab ON mab.CategoryID = maf.CategoryID
				WHERE maf.SalesID=".$SalesID;
				// echo $sql2;
			$query2 = $this->db->query($sql2);
			$row2 	= $query2->row();
			$CFUUp   = $row2->CFUUp;
			$CVUp   = $row2->CVUp;
			$CV   = $row2->FeeCV;
			$CFU   = $row2->FeeCFU;

			// if($SalesID ==12){ 
			// $CVUp=56667*0.5;
			// $CFUUp=0*0.5;
			// $CFU=0;
			// $CV=56667;	
			// } else if ($SalesID ==189 || $SalesID ==244 || $SalesID ==167) {	
			// $CFUUp=8733*0.5;
			// $CVUp=17467*0.5;	
			// $CFU=8733; 
			// $CV=17467;
			// } else if ($SalesID ==186) {	
			// $CFUUp=8271*0.5;
			// $CVUp=16542*0.5;	
			// $CFU=8271; 
			// $CV=16542;
			// } else {	
			// $CFUUp=8915*0.5;
			// $CVUp=16542*0.5;	
			// $CFU=8915; 
			// $CV=17829;
			// }
			$Total=0;
		  	$show['detail'][] = array(
		  		'SalesID' => $row->SalesID,
				'Sales' => $row->Sales,
				'Month' => $row->Month,
				'CityID' => $row->CityID,
				'CityName' => $row->CityName,
				'TotalCFU' => $row->TotalCFU,
				'TotalCV' => $row->TotalCV,
				'CFU' => $CFU,
				'CV' => $CV,
				'CFUUp' => $CFUUp,
				'CVUp' => $CVUp,
				'SUBTOTAL1' => $CFU*$row->TotalCFU,
				'SUBTOTAL2' => $CV*$row->TotalCV,
				'TOTAL' => ($CFU*$row->TotalCFU)+($CV*$row->TotalCV),

			);	
			
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function fill_brand_code($id = 0, $brand_tree_array = array())
	{
		$sql 	= "select ProductBrandID, ProductBrandName, ProductBrandCode, ProductBrandParent from tb_product_brand where ProductBrandID = ".$id."";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$brand_tree_array[] = array(
					'ProductBrandID' => $row->ProductBrandID,
					'ProductBrandName' => $row->ProductBrandName,
					'ProductBrandCode' => $row->ProductBrandCode
				);
				if ($row->ProductBrandParent != 0 ) {
		      		$brand_tree_array = $this->fill_brand_code($row->ProductBrandParent, $brand_tree_array);
				}
			};
		}
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function fill_category_code($id = 0, $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryID, ProductCategoryName, ProductCategoryCode, ProductCategoryParent, ProductNameFormula, ProductCodeFormula from tb_product_category where ProductCategoryID = ".$id."";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$category_tree_array[] = array(
					'ProductCategoryID' => $row->ProductCategoryID,
					'ProductCategoryName' => $row->ProductCategoryName,
					'ProductCategoryCode' => $row->ProductCategoryCode,
					'ProductNameFormula' => $row->ProductNameFormula,
					'ProductCodeFormula' => $row->ProductCodeFormula
				);
				if ($row->ProductCategoryParent != 0 ) {
		      		$category_tree_array = $this->fill_category_code($row->ProductCategoryParent, $category_tree_array);
				}
			};
		}
		return $category_tree_array;
		$this->log_user->log_query($this->last_query);
	}
}
?>