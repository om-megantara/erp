<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_development extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }
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
    function report_customer_city()
	{
		$show   = array();
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');
		
		$sql = "SELECT COALESCE(sum(t1.CFU1),0) as CFUMonth,COALESCE (sum(t1.CV1),0) as CVMonth, 
					COALESCE(sum(t2.CFU1),0) as CFUYear,COALESCE (sum(t2.CV1),0) as CVYear, 
					Count(vc.CustomerID) AS TotalCustomer, vc.CityID, vc.CityName, COALESCE (Count(tdp.CustomerID), 0) AS display, 
					tcity.INVDate, tcity.Last
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
					SELECT
						sm.CustomerID
					FROM
						tb_so_main sm
					WHERE
						sm.SOCategory = 4
					AND sm.SOStatus = 1
					GROUP BY
						sm.CustomerID
				) tdp ON tdp.CustomerID = vc.CustomerID
				LEFT JOIN (
					SELECT ib.CityID, MAX(ib.INVDate) As INVDate, DATEDIFF(NOW(),max(ib.INVDate)) as Last 
					FROM vw_invoice_balance ib 
					GROUP BY ib.CityID
				) tcity ON tcity.CityID = vc.CityID
				WHERE vc.CityID!=0 "; 


		if (in_array("perbaikan_report_customer_city_view_all", $MenuList)) {
			$sql .= "";
		} else {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "and ( vc.CustomerID IN (
						SELECT CustomerID FROM vw_customer_sales2 
						WHERE SalesID IN (" . implode(',', array_map('intval', $SalesID)) . ") 
					) )";
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
		$sql 	= "SELECT v5.CustomerID, v5.SalesID, v5.Sales, v5.ContactID, v5.Company2, v5.isActive,
		 			v5.CustomercategoryName, v5.phone, v5.Address, v5.City as CityName, 
		 			v5.CityID, COALESCE (tl.total, 0) as total, tl.INVDate, tl.Last, COALESCE (tdp.display, 0) AS display,
		 			ma.datecfu as CFU, ma.lastcfu, cv.datecv as CV, cv.lastcv, 
		 			COALESCE (bl.InvoiceLama,0) as total2, 
		 			COALESCE (tl.total,0)+COALESCE (bl.InvoiceLama,0) as Omzet, COALESCE (tct. STATUS, 0) AS target 
					FROM vw_customer5 v5 
					LEFT JOIN (
						SELECT ib.CustomerID, MAX(ib.INVDate) As INVDate, sum(ib.INVTotal) as Total, DATEDIFF(NOW(),max(ib.INVDate)) as Last 
						FROM vw_invoice_balance ib 
						GROUP BY ib.CustomerID
					) tl ON tl.CustomerID=v5.CustomerID 
					LEFT JOIN ( 
						select max(ActivityDate) as datecfu, DATEDIFF(NOW(), max(ActivityDate)) as lastcfu, ActivityReffNo 
						from tb_marketing_activity 
						where ActivityType like 'Customer Follow Up (CFU)' 
						GROUP BY ActivityReffNo
					) ma ON ma.ActivityReffNo=v5.CustomerID 
					LEFT JOIN ( 
						select max(ActivityDate) as datecv, DATEDIFF(NOW(), max(ActivityDate)) as lastcv, ActivityReffNo 
						from tb_marketing_activity 
						where ActivityType like 'Customer Visit (CV)' 
						GROUP BY ActivityReffNo 
					) cv ON cv.ActivityReffNo=v5.CustomerID 
					LEFT JOIN tb_invoice_bo_lama bl ON v5.CustomerID=bl.CustomerID 
					LEFT JOIN tb_customer_target tct ON v5.CustomerID = tct.CustomerID
					LEFT JOIN (
						SELECT
							sm.CustomerID,
							SUM(sd.ProductQty) AS display
						FROM
							tb_so_main sm
						LEFT JOIN tb_so_detail sd ON sd.SOID = sm.SOID
						WHERE
							sm.SOCategory = 4
						AND sm.SOStatus = 1
						GROUP BY
							sm.CustomerID
					) tdp ON tdp.CustomerID = v5.CustomerID
					WHERE v5.CityID = '$CityID' ";
					
		$SalesID = $this->get_sales_child($SalesID);
		if ( $SalesID[0] != '0'){
			if($SalesID[0] == '233'){
				$sql .= " ";
			} else {
			$sql .= "and ( v5.CustomerID IN ( SELECT CustomerID FROM vw_customer_sales2	WHERE SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ) )";
			}
		}
		else
		{
			$sql .= " ";
		}		
		$sql .="order by v5.City asc, Omzet desc";
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
					'INVDate' => $row3->INVDate,
					'Last' => $row3->Last,
					'Category' => $row3->CustomercategoryName,
					'Phone' => $row3->phone,
					'CityName' => $row3->CityName,
					'CFU' => $row3->CFU,
					'lastcfu' => $row3->lastcfu,
					'CV' => $row3->CV,
					'lastcv' => $row3->lastcv,
					'Address' => $row3->Address,
					'CityID' => $row3->CityID,
				);


		};

	    return $show;
	}
	function report_product_kpi()
	{
		$show = array();
		// $show['info_filter'] = "";
		$INVDateStart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$INVDateEnd = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sqlINVDate = "WHERE (im.INVDate between '".$INVDateStart."' AND '".$INVDateEnd."') ";
		} else { 
			$sqlINVDate = "";
		}

		$sql = "
			SELECT pm.ProductID, pm.ProductName, pm.ProductPriceHPP, COALESCE (tvp.top,0) as top, COALESCE (top-pm.ProductPriceHPP,0) as cprofit, COALESCE (Round((top-pm.ProductPriceHPP)/pm.ProductPriceHPP*100,2),0) as cpersen, Round(tid.AProfit/tid.ACost*100,2) as apersen, tid.QTYSold, tsd.QTYSold2, tid.tertinggi, tid.terendah, tid.APrice, tid.ACost, tid.totalpenjualan, tid.totalHPP, tid.AProfit, tid.Profit, pm.InputDate, 
			@umur:= DATEDIFF(Now(), pm.InputDate) AS umur,
			@AQTYSold := Round( COALESCE(tid.QTYSold / @umur, 0), 2) AS AQTYSold,
			@AQTYSold2 := Round( COALESCE(tsd.QTYSold2 / @umur, 0), 2) AS AQTYSold2,
			COALESCE (stock, 0) AS Stok, 
			Round(COALESCE ((stock / @AQTYSold),0),2) AS DStokLeft,
			pm.ProductCategoryName, pm.ProductBrandName, tad.AtributeValue as Origin
			FROM vw_product_list_popup6 pm
			LEFT JOIN (
				SELECT vpp.productid, min(vpp.PricePT1Discount) as top FROM vw_product_promo_list_active_with_price vpp 
				GROUP BY ProductID
			) tvp ON tvp.ProductID=pm.ProductID
			LEFT JOIN  
			(
			SELECT id.ProductID, COALESCE(sum(id.ProductQty), 0) AS QTYSold, COALESCE (max(id.PriceAmount), 0) AS tertinggi, 
			COALESCE (min(id.PriceAmount), 0) AS terendah,
			Round( COALESCE (Avg(id.PriceAmount), 0), 2 ) AS APrice,
			Round( COALESCE (AVG(id.ProductHPP), 0), 2 ) AS ACost,
			COALESCE (sum(id.PriceTotal), 0) AS totalpenjualan,
			COALESCE ( (ProductHPP * sum(id.ProductQty) ), 0 ) AS totalhpp,
			Round(COALESCE( (Avg(id.PriceAmount) - AVG(id.ProductHPP) ), 0), 2) AS AProfit,
			COALESCE ( (sum(id.PriceTotal) - (ProductHPP*sum(id.ProductQty)) ), 0) AS Profit
			FROM tb_invoice_detail id
			WHERE id.INVID IN (
			SELECT im.INVID FROM tb_invoice_main im ".$sqlINVDate."
			) 
			GROUP BY id.ProductID 
			) tid on pm.ProductID=tid.ProductID
			LEFT JOIN (SELECT * FROM tb_product_atribute_detail WHERE ProductAtributeID = '20' GROUP BY ProductID) tad on tad.ProductID=pm.ProductID
			LEFT JOIN (SELECT ProductID, sum(ProductQty) as Qtysold2  FROM `tb_so_detail` GROUP BY ProductID) tsd ON tsd.ProductID = pm.ProductID			
		";
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {
			$sql .= "where tad.AtributeValue like '".$_REQUEST['origin']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		$sql.=" ORDER BY QTYSold DESC";

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {

		  	$show[] = array(
	  			'ProductID' => $row->ProductID,
	  			'ProductName' => $row->ProductName,
	  			'ProductPriceHPP' => $row->ProductPriceHPP,
	  			'top' => $row->top,
	  			'cprofit' => $row->cprofit,
	  			'cpersen' => $row->cpersen,
	  			'apersen' => $row->apersen,
	  			'ProductCategoryName' => $row->ProductCategoryName,
	  			'ProductBrandName' => $row->ProductBrandName,
	  			'Origin' => $row->Origin,
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
	  			'DStokLeft' => $row->DStokLeft,
	  			'INVDateStart' => $INVDateStart,
	  			'INVDateEnd' => $INVDateEnd,
			);
		};
	    return $show;
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
		$this->log_user->log_query($this->last_query);
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
	function report_so_global()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT sl.*, count(n.NoteDateTime) as note, COALESCE(sr.ROID,0) as ROID, COALESCE(sr.POID,0) as POID 
				FROM vw_so_list5 sl
				LEFT JOIN tb_note n ON (n.NoteType='SO' AND n.NoteReff=sl.SOID)
				LEFT JOIN vw_so_ro_group sr ON sl.SOID=sr.SOID ";
				
		if (in_array("report_so_sec", $MenuList)) {
			$SalesID = $this->get_sales_child($SalesID);
			$sql .= "where ( SECID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$sql .= "or SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
		} elseif (in_array("report_so_linked", $MenuList)) {
			$sql .= "where SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("report_so_all", $MenuList)) {
			$sql .= "where SalesID<>'' ";
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
		} else {
			$sql .= "GROUP BY sl.SOID order by sl.SOID desc limit ".$this->limit_result." ";
		}
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
	function so_complaint_add()
	{
		$CustomerID = $this->input->get_post('CustomerID'); 
		$SOID = $this->input->get_post('SOID'); 

		$sql 	= "SELECT vc2.*, vsl.SOID, vsl.SalesID, vsl.salesname as sales, tdm.DOID FROM vw_customer2 vc2 LEFT JOIN vw_so_list3 vsl on vc2.CustomerID=vsl.CustomerID LEFT JOIN (SELECT DOID, DOReff FROM `tb_do_main` WHERE `DOType` LIKE '%SO%') tdm ON tdm.DOReff=vsl.SOID where vc2.CustomerID=".$CustomerID." and vsl.SOID=".$SOID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0]; 
		
		$sql 	= "select max(Month) as month from tb_customer_complaint";
		$query  	= $this->db->query($sql);
		$row 		= $query->row();
		$show['month'] = $row->month;
		$Month = date('Y-m');

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
	function so_complaint_add_act()
	{
		$this->db->trans_start();
		$Code = $this->input->get_post('code'); 
		$No = $this->input->get_post('no');
		$CustomerID = $this->input->get_post('customerid');
		$SalesID = $this->input->get_post('salesid'); 
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
					'OpenDate' => $datetime,
					'CloseDate' => '0000-00-00 00:00:00',
					'isApprove' => '0',
					'No' => $No,
					'Month' => $Month,
					'ComplaintLink' => $ComplaintLink,

				);

		$this->db->insert('tb_customer_complaint', $data);
		$this->last_query .= "//".$this->db->last_query();

   		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='so_complaint' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		if ($Actor3 != 0) {
			$data_approval = array(
		        'ComplaintID' => $Code,
	        	'isComplete' => "0",
	        	'Status' => "OnProgress",
			);
			$this->db->insert('tb_approval_so_complaint', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {

			$data_approval = array(
		        'ComplaintID' => $Code,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
			);
			$this->db->insert('tb_approval_so_complaint', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	} 
	function get_percent($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			$percent 	= $num1/100;
			$result 	= $num2/$percent; 
		}
		return number_format($result,2);
	}
	function list_complaint()
	{
		$show   = array();

		$sql = "SELECT cc.*, cm.Company2 as customer, em.Company2 as sales, CityName  
				FROM tb_customer_complaint cc 
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=cc.SalesID) 
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID=cc.CustomerID) 
				order by cc.complaintID desc limit ".$this->limit_result;

		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function list_complaint_delete()
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
	function marketing_activity_report()
	{
		$show   = array();
		$show['info_filter'] = "";
		$bulan=date('Y-m');
		$sql = "SELECT t1.*, vse.SalesName FROM ( SELECT SalesID, InputDate,
					SUM(IF (ActivityType = 'Customer Follow Up (CFU)',1,0)) AS CFU,
					SUM(IF (ActivityType = 'Customer Visit (CV)',1,0)) AS CV,
					COUNT(DISTINCT CASE WHEN ActivityType='Customer Follow Up (CFU)' then ActivityReffNo END) as CustomerCFU,
					COUNT(DISTINCT CASE WHEN ActivityType='Customer Visit (CV)' then ActivityReffNo END) as CustomerCV,
					COUNT(CASE WHEN ActivityType='Customer Follow Up (CFU)' and isApprove='1' then isApprove END) as CFUApprove,
					COUNT(CASE WHEN ActivityType='Customer Follow Up (CFU)' and isApprove='0' then isApprove END) as CFUNotApprove,
					COUNT(CASE WHEN ActivityType='Customer Visit (CV)' and isApprove='1' then isApprove END) as CVApprove,
					COUNT(CASE WHEN ActivityType='Customer Visit (CV)' and isApprove='0' then isApprove END) as CVNotApprove
				FROM tb_marketing_activity
				GROUP BY SalesID
				) t1
				LEFT JOIN vw_sales_executive2 vse On vse.SalesID=t1.SalesID where t1.InputDate like '%".$bulan."%' ";

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("marketing_activity_linked", $MenuList)) {
        	$this->load->model('model_report');
			$SalesID = $this->model_report->get_sales_child($SalesID);
			$sql .= "and t1.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ";
		} elseif (in_array("marketing_activity_all", $MenuList)) {
			$sql .= "and t1.SalesID<>'' ";
		}
			$sql .= "order by t1.SalesID desc limit ".$this->limit_result;
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function list_project()
	{
		$show   = array();

		$sql = "SELECT	tp.*, cm.Company2 AS customer, vc.CityName as City
				FROM	tb_project tp
				LEFT JOIN vw_city vc ON (vc.CityID = tp.CityID)
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID = tp.CustomerID)
				ORDER BY	tp.ProjectID DESC LIMIT ".$this->limit_result;
		// echo $sql;		
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function project_so_detail()
	{
		$show   = array();

		$sql = "SELECT * FROM tb_project_so";
		// echo $sql;		
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function project_add()
	{
		$CustomerID = ""; 
		$sql 	= "SELECT * FROM vw_customer2 order by ContactID desc";
		$query 	= $this->db->query($sql);
		$show = $query->result_array()[0];  

		$sql 	= "SELECT CityID, CityName FROM vw_city";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['citylist'][] = array(
				'CityID' => $row->CityID,
				'CityName' => $row->CityName,
			);
		};
		$sql 	= "select max(Month) as month from tb_project";
		$query  	= $this->db->query($sql);
		$row 		= $query->row();
		$show['month'] = $row->month;
		$Month = date('Y-m');

		if ($show['month']==$Month){
			$sql 		= "select max(No) as no from tb_project where month like '".$Month."'";
			$query  	= $this->db->query($sql);
			$row 		= $query->row();
			$show['no'] = $row->no;
		} else {
			$show['no'] = 0;
		}

	    return $show;
	}
	function project_add_act()
	{
		$this->db->trans_start();
		$ProjectID = $this->input->get_post('code'); 
		$CustomerID = $this->input->get_post('customer'); 
		$ProjectName = $this->input->get_post('projectname'); 
		$CityID = $this->input->get_post('cityid');
		$ProjectInput = $this->input->get_post('date');
		$CustomerDrawing = $this->input->get_post('technical');
		$CustomerDrawingLink = $this->input->get_post('technicallink');
		$CustomerDrawingDate = $this->input->get_post('technicaldate');
		$Letter = $this->input->get_post('letter');
		$LetterLink = $this->input->get_post('letterlink');
		$LetterDate = $this->input->get_post('letterdate');
		$Floor = $this->input->get_post('floor');
		$FloorLink = $this->input->get_post('floorlink');
		$FloorDate = $this->input->get_post('floordate');
		$Sample = $this->input->get_post('sample');
		$SampleLink = $this->input->get_post('samplelink');
		$SampleDate = $this->input->get_post('sampledate');
		$OurTechnical = $this->input->get_post('ourtechnical');
		$OurTechnicalLink = $this->input->get_post('ourtechnicallink');
		$OurTechnicalDate = $this->input->get_post('ourtechnicaldate');
		$Note = $this->input->get_post('note');
		$No = $this->input->get_post('no');
		$SOID = $this->input->get_post('soid');

		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'ProjectID' => $ProjectID,
					'CustomerID' => $CustomerID,
					'ProjectName' => $ProjectName,
					'CityID' => $CityID,
					'ProjectInput' => $ProjectInput,
					'CustomerDrawing' => $CustomerDrawing,
					'CustomerDrawingLink' => $CustomerDrawingLink,
					'CustomerDrawingDate' => $CustomerDrawingDate,
					'Letter' => $Letter,
					'LetterLink' => $LetterLink,
					'LetterDate' => $LetterDate,
					'Floor' => $Floor,
					'FloorLink' => $FloorLink,
					'FloorDate' => $FloorDate,
					'Sample' => $Sample,
					'SampleLink' => $SampleLink,
					'SampleDate' => $SampleDate,
					'OurTechnical' => $OurTechnical,
					'OurTechnicalLink' => $OurTechnicalLink,
					'OurTechnicalDate' => $OurTechnicalDate,
					'Note' => $Note, 
					'No' => $No, 
					'ProjectClosed' => $ProjectClosed,
					'Status' => 0,
					'Month' => $Month,
				);
		$this->db->insert('tb_project', $data);

		$this->db->trans_complete();
	} 
	function project_edit()
	{
		$ProjectID = $this->input->get_post('ProjectID'); 
		$sql 	= "SELECT tp.*, vc.Company2 as Customer, vci.CityName FROM tb_project tp
				LEFT JOIN vw_customer3 vc ON vc.CustomerID=tp.CustomerID
				LEFT JOIN vw_city vci ON vci.CityID=tp.CityID 
				WHERE tp.ProjectID ='".$ProjectID."'" ;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];  
		// echo $sql;

	    return $show;
	}
	function project_edit_act()
	{
		$this->db->trans_start();
		$ProjectID = $this->input->get_post('code'); 
		$ProjectClose = $this->input->get_post('ProjectClose');
		$CustomerDrawing = $this->input->get_post('technical');
		$CustomerDrawingLink = $this->input->get_post('technicallink');
		$CustomerDrawingDate = $this->input->get_post('technicaldate');
		$Letter = $this->input->get_post('letter');
		$LetterLink = $this->input->get_post('letterlink');
		$LetterDate = $this->input->get_post('letterdate');
		$Floor = $this->input->get_post('floor');
		$FloorLink = $this->input->get_post('floorlink');
		$FloorDate = $this->input->get_post('floordate');
		$Sample = $this->input->get_post('sample');
		$SampleLink = $this->input->get_post('samplelink');
		$SampleDate = $this->input->get_post('sampledate');
		$OurTechnical = $this->input->get_post('ourtechnical');
		$OurTechnicalLink = $this->input->get_post('ourtechnicallink');
		$OurTechnicalDate = $this->input->get_post('ourtechnicaldate');
		$Note = $this->input->get_post('note');
		if ($ProjectClose==1){
		$date = date('Y-m-d');
		}
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'CustomerDrawing' => $CustomerDrawing,
					'CustomerDrawingLink' => $CustomerDrawingLink,
					'CustomerDrawingDate' => $CustomerDrawingDate,
					'Letter' => $Letter,
					'LetterLink' => $LetterLink,
					'LetterDate' => $LetterDate,
					'Floor' => $Floor,
					'FloorLink' => $FloorLink,
					'FloorDate' => $FloorDate,
					'Sample' => $Sample,
					'SampleLink' => $SampleLink,
					'SampleDate' => $SampleDate,
					'OurTechnical' => $OurTechnical,
					'OurTechnicalLink' => $OurTechnicalLink,
					'OurTechnicalDate' => $OurTechnicalDate,
					'ProjectClosed' => $date,
					'Status' => $ProjectClose,
					'Note' => $Note, 
				);
		// $this->db->set($data);
		$this->db->where('ProjectID', $ProjectID);
		$this->db->update('tb_project', $data);

		$this->db->trans_complete();
	} 
	function sales_order_list()
	{
		$SalesID = array( $this->session->userdata('SalesID') );
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT sl.*, coalesce(t1.countSO,0) as countSO from vw_so_list5 sl
				LEFT JOIN (
				SELECT im.SOID, COUNT(im.SOID) AS countSO FROM tb_invoice_main im GROUP BY im.SOID
				) t1 ON sl.SOID=t1.SOID ";

		if (isset($_REQUEST['status']) && $_REQUEST['status'] == 2) {
			$sql .= "where sl.SOConfirm1!=".$_REQUEST['status']." ";
		} elseif (isset($_REQUEST['status']) && $_REQUEST['status'] != 2) { 
			$sql .= "where sl.SOConfirm1=".$_REQUEST['status']." ";
		} else { 
			if (in_array("perbaikan_sales_order_list_all", $MenuList)) {
				$sql .= "";
			} else {
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "where sl.SalesID IN (" . implode(',', array_map('intval', $SalesID)) . ") ";
			} 
			$sql .= " order by sl.SOID desc limit ".$this->limit_result." ";
		}

		if (isset($_REQUEST['type']) && $_REQUEST['type'] != 'all') {
			$sql .= "and sl.SOType='".$_REQUEST['type']."' ";
		} 

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and sl.SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
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
						break;
					case 'ProductName':
						$sql .= "sl.SOID in (SELECT DISTINCT SOID FROM tb_so_detail WHERE ProductName like '%".$atributevalue[$i]."%') ";
						break;
					case 'Company':
						$sql .= "sl.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					case 'Sales':
						$sql .= "sl.SalesID in (SELECT SalesID FROM vw_sales_executive2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					case 'Category':
						$sql .= "sl.SOCategory in (SELECT CategoryID FROM tb_so_category WHERE CategoryName like '%".$atributevalue[$i]."%') ";
						break;
					default:
						$sql .= "sl.".$atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
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
				'SOType' => $row->SOType,
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
				'TotalDeposit' => $row->TotalDeposit,
				'TotalPayment' => $row->TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding' => $row->totaldo-$row->qty,
				'INVCategory' => $row->INVCategory,
				'countSO' => $row->countSO,
			);
			$show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_add()
	{
		$sql 	= "select SOShipDate, SODepositStandard, SODepositCustom from tb_site_config where id=1";
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$show['SODepositStandard'] = $row->SODepositStandard;
		$show['SODepositCustom'] = $row->SODepositCustom;
		$show['SOShipDate'] = $row->SOShipDate;


		$show['shop'] = array();
		$sql 	= "SELECT * from tb_shop_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['shop'][] = array(
		  			'ShopID' => $row->ShopID, 
					'ShopName' => $row->ShopName, 
				);
		};
		$show['project'] = array();
	    $sql 	= "SELECT tp.ProjectID, vc.Company2 from tb_project tp
	    			LEFT JOIN vw_customer3 vc ON vc.CustomerID = tp.CustomerID where Status=0 or Status IS NULL ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['project'][] = array(
		  			'ProjectID' => $row->ProjectID, 
		  			'Company2' => $row->Company2, 
				);
		};
	    return $show;
	}
	function sales_order_add_act()
	{
		$this->db->trans_start();

		$customer 	= $this->input->post('customer');
		$address 	= $this->input->post('address');
		$contactid 	= $this->input->post('contactid');
		$billing 	= $this->input->post('billing');
		$shipping 	= $this->input->post('shipping');
		$npwp 		= $this->input->post('npwp');
		$paymentterm 	= $this->input->post('paymentterm');
		$creditlimit 	= $this->input->post('creditlimit');
		$creditavailable= $this->input->post('creditavailable');
		$regionid 		= $this->input->post('regionid');
		$secid 	= $this->input->post('secid');
		$sales 	= $this->input->post('sales');
		$projectid 	= "0";
		$socategory = $this->input->post('socategory');
		$sotype = "standard";
		$invcategory = "1";
		$minimumdp 	= $this->input->post('minimumdp');
		$sodate 	= $this->input->post('sodate');
		$shop 	= "0";
		$shipdate 	= $this->input->post('shipdate');
		$paymentmethod 	= $this->input->post('paymentmethod');
		$sopaymentterm 	= $this->input->post('sopaymentterm');
		$expeditionid 	= $this->input->post('expeditionid');
		$expeditionprice 	= $this->input->post('expeditionprice');
		$expeditionweight 	= $this->input->post('expeditionweight');
		$expedition 	= $this->input->post('expedition');
		$term 			= $this->input->post('term');
		$note 			= $this->input->post('note');
		$permit 		= $this->input->post('permit');

		$ProductID 		= $this->input->post('ProductID');
		$ProductName 	= $this->input->post('ProductName');
		$ProductQty 	= $this->input->post('ProductQty');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$PricelistID 	= $this->input->post('PricelistID');
		$PricelistName 	= $this->input->post('PricelistName');
		$PricePercent 	= $this->input->post('PricePercent');
		$PT1Percent 	= $this->input->post('PT1Percent');
		$PT2Percent 	= $this->input->post('PT2Percent');
		$PT1Price = $this->input->post('PT1Price');
		$PT2Price = $this->input->post('PT2Price');
		$PriceAmount 	= $this->input->post('PriceAmount');
		$ProductWeight 	= $this->input->post('ProductWeight');
		$FreightCharge 	= $this->input->post('FreightCharge');
		$linetotal 		= $this->input->post('linetotal');

		$fcmethod 		= $this->input->post('fcmethod');
		$fcsuggestion 	= $this->input->post('fcsuggestion');
		$fcamount 		= $this->input->post('fcamount');
		$sototalbefore 	= $this->input->post('sototalbefore');
		$taxrate 		= $this->input->post('taxrate');
		$taxamount 		= $this->input->post('taxamount');
		$sototal 		= $this->input->post('sototal');

		$DueDate1 = $this->input->post('DueDate1');
		$DueDate2 = $this->input->post('DueDate2');
		$DueDateNote = $this->input->post('DueDateNote');

		$datamain = array(
			'CustomerID' => $customer,
			'SalesID' => $sales,
			'BillingAddress' => str_replace(array('\n', '\r'), ' ', $billing),
			'ShipAddress' => str_replace(array('\n', '\r'), ' ', $shipping),
			'RegionID' => $regionid,
			'SECID' => $secid,
			'NPWP' => $npwp,
			'PaymentWay' => $paymentmethod,
			'PaymentTerm' => $sopaymentterm,
			'SOCategory' => $socategory,
			'SOType' => $sotype,
			'INVCategory' => $invcategory,
			'PaymentDeposit' => $minimumdp,
			'SODate' => $sodate,
			'ShopID' => $shop,
			'SOShipDate' => $shipdate,
			'SOTerm' => str_replace(array('\n', '\r'), ' ', $term),
			'SONote' => str_replace(array('\n', '\r'), ' ', $note),
			'ExpeditionID' => $expeditionid,
			'ExpeditionPrice' => $expeditionprice,
			'ExpeditionWeight' => $expeditionweight,
			'FreightCharge' => $fcamount,
			'SOTotalBefore' => $sototalbefore,
			'TaxRate' => $taxrate,
			'TaxAmount' => $taxamount,
			'SOTotal' => $sototal, 
			'PermitNote' => $permit, 
			'InputDate' => date('Y-m-d H:i:s'),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_so_main', $datamain);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(SOID) as SOID from tb_so_main ";
		$getSOID 	= $this->db->query($sql);
		$row 		= $getSOID->row();
		$SOID 		= $row->SOID;

		$datamain2 = array(
			'SOID' => $SOID,
			'SOShipDateNote' => $DueDateNote,
			// 'SOShipDateFinal' => $shipdate,
			'SOShipDate1Need' => "0",
			'SOShipDate2Need' => "0",
		);
		if ($DueDate1 == 0 and $DueDate2 == 0) {
			$datamain2['SOShipDateFinal'] = $shipdate;
		}
		$this->db->insert('tb_so_main2', $datamain2);
		$this->last_query .= "//".$this->db->last_query();

		for ($i=0; $i < count($ProductID);$i++) { 
			$sql 		= "select ProductPriceHPP, ProductMultiplier from tb_product_main where ProductID=".$ProductID[$i];
			$getDetail 	= $this->db->query($sql);
			$row 		= $getDetail->row();
			$ProductHPP = $row->ProductPriceHPP;
			$ProductMultiplier = $row->ProductMultiplier;

   			$datadetail = array(
				'SOID' => $SOID,
				'ProductID' => $ProductID[$i],
				'ProductName' => $ProductName[$i],
				'ProductQty' => $ProductQty[$i],
				'ProductMultiplier' => $ProductMultiplier,
				'ProductHPP' => $ProductHPP,
				'ProductPriceDefault' => $ProductPriceDefault[$i],
				'ProductWeight' => $ProductWeight[$i],
				'PriceID' => $PricelistID[$i],
				'PriceName' => $PricelistName[$i],
				'PT1Percent' => $PT1Percent[$i],
				'PT1Price' => $PT1Price[$i],
				'PT2Percent' => $PT2Percent[$i],
				'PT2Price' => $PT2Price[$i],
				'PricePercent' => $PricePercent[$i],
				'PriceAmount' => $PriceAmount[$i],
				'FreightCharge' => $FreightCharge[$i],
				'PriceTotal' => $linetotal[$i],
				'Pending' => $ProductQty[$i],
			);
			$this->db->insert('tb_so_detail', $datadetail);
			$this->last_query .= "//".$this->db->last_query();
   		};

   		if ($projectid!='0') {
   			$dataproject = array(
				'ProjectID' => $projectid,
				'SOID' => $SOID,
			);		
	   		$this->db->insert('tb_project_so', $dataproject);
			$this->last_query .= "//".$this->db->last_query();
   		}
   		// echo ($this->last_query);
   		// $this->sales_order_approval_submission($SOID, $socategory, $invcategory, $paymentterm, $sopaymentterm, "add", $creditavailable, $sototal, $paymentmethod, $customer);
   		$this->SOShipDate_history($SOID, $shipdate, 'formSO');

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function SOShipDate_history($SOID, $SOShipDate, $source)
	{
		$sql 		= "select SOShipDate from tb_so_due_date where SOID=".$SOID." order by CreatedDate desc limit 1 ";
		$getRow 	= $this->db->query($sql);
		$row 		= $getRow->row();
		if (empty($row) or $SOShipDate != $row->SOShipDate ) {
			$data = array(
				'SOID' => $SOID,
				'SOShipDate' => $SOShipDate,
				'SourceType' => $source,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'CreatedBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_so_due_date', $data);
			$this->last_query .= "//".$this->db->last_query();
		}
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
	function perbaikan_report_product_price_active()
	{
		$show = array();
		// $show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$Category = $this->input->get_post('category');

		$sql = "
			SELECT pm.ProductID, pm.ProductName, 
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault, COALESCE (tvp.PT1Discount,0) as PT1Discount, COALESCE (tvp.PT2Discount,0) as PT2Discount, COALESCE (tvp.Price,0) as Price, COALESCE (tvp.top,0) as top, COALESCE (tvp.cbd,0) as cbd, ast.StateName, pm.ProductMultiplier, pm.ProductPriceHPP
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
				SELECT vpp.productid, min(vpp.Price) as Price, min(vpp.PricePT1Discount) as top, min(vpp.PricePT2Discount) as cbd, vpp.PT1Discount, vpp.PT2Discount 
				FROM vw_product_promo_list_active_with_price_consumer vpp 
				GROUP BY ProductID
			) tvp ON tvp.ProductID=pm.ProductID
			LEFT JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry  
		";
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "WHERE pm.ProductID like '".$_REQUEST['productid']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="WHERE psm.stock !=0 ";}
		if (isset($_REQUEST['origin']) && $_REQUEST['origin'] != '') {
			$sql .= "AND pm.ProductCountry = '".$_REQUEST['origin']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['category']) && $_REQUEST['category'] != '') {
			$sql .= "AND pm.ProductCategoryID = '".$_REQUEST['category']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql .= "AND tad.AtributeValue like '".$_REQUEST['source']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		$sql.=" ORDER BY pm.ProductID ASC ";

		$sql2 	= "select PV from tb_site_config ";
		$getrow = $this->db->query($sql2);
		$row2	= $getrow->row();
		$PV 	= $row2->PV;

		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			if ($row->Price==0){
				$Price= $row->ProductPriceDefault;
			} else {
				$Price= $row->Price;
			}
			if ($row->top==0){
				$top= $row->ProductPriceDefault;
			} else {
				$top= $row->top;
			}
			if ($row->cbd==0){
				$cbd= $row->ProductPriceDefault;
				$HPP=$row->ProductPriceHPP;
			} else {
				$cbd= $row->cbd;
			}
			$ProductMultiplier 	= $row->ProductMultiplier;
			$PVTOP = ($top-$row->ProductPriceHPP)/$PV;
			$PVCBD = ($cbd-$row->ProductPriceHPP)/$PV;

		  	$show[] = array(
	  			'ProductID' => $row->ProductID,
	  			'ProductName' => $row->ProductName,
	  			'ProductCategoryName' => $row->ProductCategoryName,
	  			'ProductBrandName' => $row->ProductBrandName,
	  			'Price' => $Price,
	  			'ProductPriceDefault' => $row->ProductPriceDefault,
	  			'PT1Discount' => $row->PT1Discount,
	  			'PT2Discount' => $row->PT2Discount,
	  			'Stock' => $row->Stock,
	  			'CBD' => $cbd,
	  			'TOP' => $top,
	  			'StateName' => $row->StateName,
	  			'PVTOP' => $PVTOP,
	  			'PVCBD' => $PVCBD,

			);
		};

	    return $show;
	}
	function search_customer_city()
	{
		$q = $this->input->get('q');
		
		if (strlen($q) > 2) {

			$hasil  = $this->db->query ('select CustomerID, Company2, CityName from vw_customer3 where Company2 like "%'.$q.'%" and isActive=1');
	        if ($hasil->num_rows()){ 
	        	$data = array();
	            foreach ($hasil->result() as $row) {
	                $data[] = array(
	                    'text' => $row->Company2.' ('.$row->CityName.')',
	                    'id' => $row->CustomerID
	                    ); }
	            echo json_encode($data);
	        } 
		}      
		$this->log_user->log_query($this->last_query);
	}
	function search_customer_city_sales()
	{
		$q = $this->input->get('q');
		
		if (strlen($q) > 2) {
			$this->load->model('model_report');
			$SalesID = $this->session->userdata('SalesID');
			if ($SalesID==0){
				$Sales="";
			} else {
				$Sales= " and vc3.SalesID = ".$SalesID;
			}

			$sql= 'select vc3.CustomerID, vc3.Company2, vc3.City, vc3.SalesID from vw_customer5 vc3 where vc3.Company2 like "%'.$q.'%" and vc3.isActive=1 '.$Sales;
			$hasil  = $this->db->query ($sql);
			// echo $sql;
	        if ($hasil->num_rows()){ 
	        	$data = array();
	            foreach ($hasil->result() as $row) {
	            	$SalesID = $row->SalesID;
	                $data[] = array(
	                    'text' => $row->Company2.' ('.$row->City.')',
	                    'id' => $row->CustomerID
	                    ); }
	            echo json_encode($data);
	        } 
		}      
		$this->log_user->log_query($this->last_query);
	}
	function get_product_price()
	{
    	$data = array();
		$message = $this->input->post('message');
		$pricecategory 	= $this->input->post('pricecategory');
		$pricelist 	= $this->input->post('pricelist');
		$paymentmethod = $this->input->post('paymentmethod');
		$ProductID 	= $message['tdid'];

		// get PV 
		$sql2 	= "select PV from tb_site_config ";
		$getrow = $this->db->query($sql2);
		$row2	= $getrow->row();
		$PV 	= $row2->PV;

		$sql 	= "SELECT ProductPriceHPP, ProductPriceDefault, COALESCE(pa.AtributeValue,'STD') AS ProductType
					FROM tb_product_main pm
					LEFT JOIN tb_product_atribute_detail pa ON pm.ProductID=pa.ProductID AND pa.ProductAtributeID=16
					WHERE pm.ProductID=".$ProductID;
		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();
		
    	$data['ProductID'] = $ProductID;
    	$data['ProductName'] = $message['tdname'];
    	$data['ProductPriceHPP'] = $row->ProductPriceHPP;
    	$data['ProductPriceDefault'] = $row->ProductPriceDefault;
    	$data['ProductType'] = ($row->ProductType == "CSTM") ? "custom" : "standard";

    	$sql 	= "SELECT AtributeValue FROM tb_product_atribute_detail WHERE ProductAtributeID=2 and ProductID=".$ProductID;
		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();
    	$data['ProductWeight'] = ($row->AtributeValue == 0) ? 1 : $row->AtributeValue;

		// get price value
		if (isset($pricelist)) {
			$sql 	= "SELECT pld.PricelistID, pld.PT1Discount, pld.PT2Discount, pld.Promo, plm.PricelistName, pcm.PromoDefault
						FROM tb_price_list_detail pld 
						LEFT JOIN tb_price_list_main plm ON (pld.PricelistID = plm.PricelistID) 
						LEFT JOIN tb_price_category_detail pcd ON (pcd.PricelistID = pld.PricelistID)
						LEFT JOIN tb_price_category_main pcm ON (pcd.PricecategoryID = pcm.PricecategoryID)
						WHERE 
						plm.PricelistID in (select PricelistID from vw_price_list_active) and 
						plm.isActive=1 and pld.PricelistID in(".implode(',', array_map('intval', $pricelist)).") AND pld.ProductID=".$ProductID." 
						ORDER BY PromoDefault DESC, Promo DESC, PT1Discount DESC LIMIT 1";
			$hasil2 = $this->db->query($sql);
			$row 	= $hasil2->row();
		}

        if ( isset($hasil2) and $hasil2->num_rows()){ 
        	$data['Promocategory'] = $row->PromoDefault;
        	$data['PricelistID'] = $row->PricelistID;
        	$data['PricelistName'] = $row->PricelistName;
        	$data['Promo'] = $row->Promo;
        	$data['PT1Percent'] = $row->PT1Discount;
        	$data['PT2Percent'] = $row->PT2Discount;
        } else {
        	$data['Promocategory'] = 0;
        	$data['PricelistID'] = 0;
        	$data['PricelistName'] = "";
        	$data['Promo'] = 0;
        	$data['PT1Percent'] = 0;
        	$data['PT2Percent'] = 0;
        }
        
        $data['ProductPriceDefault'] = $data['ProductPriceDefault'] - ( ($data['ProductPriceDefault']/100)*$data['Promocategory'] );
        $data['ProductPriceDefault2'] = $data['ProductPriceDefault'] - ( ($data['ProductPriceDefault']/100)*$data['Promocategory'] );
    	$Promo = $data['ProductPriceDefault'] - ( ($data['ProductPriceDefault']/100)*$data['Promo'] );
    	$pricePT1 = $Promo - ( ($Promo/100)*$data['PT1Percent'] );
    	$pricePT2 = $Promo - ( ($Promo/100)*$data['PT2Percent'] );
    	$PVTotal = ($data['ProductPriceDefault2']-$data['ProductPriceHPP'])/$PV;
		if ($PVTotal>0) {
			$PVTotal = number_format($PVTotal,2);
		} else {
			$PVTotal = "0";
		}
		$data['PV'] = $PVTotal;
        
        $data['PT1Price'] = $pricePT1;
        $data['PT2Price'] = $pricePT2;
        if ($paymentmethod == "TOP") {
        	$data['PriceAmount'] = $pricePT1;
        } else {
        	$data['PriceAmount'] = $pricePT2;
        }

        echo json_encode($data);
		$this->log_user->log_query($this->last_query);
	}
	function get_product_promo()
	{
    	$data 		= array();
		$ProductID 	= $this->input->post('ProductID');
		$ProductQty	= $this->input->post('ProductQty');
		$pricelist 	= $this->input->post('pricelist');
		$promovol 	= $this->input->post('promovol');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$paymentmethod 	= $this->input->post('paymentmethod');

		// get price endUser
		$sql 	= "SELECT ProductPriceDefault FROM tb_product_main WHERE ProductID= ".$ProductID;
		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();
		$ProductPriceDefault = $row->ProductPriceDefault;

		// get PV 
		$sql2 	= "select PV from tb_site_config ";
		$getrow = $this->db->query($sql2);
		$row2	= $getrow->row();
		$PV 	= $row2->PV;

		// cek promo volume
		$sql 	= "SELECT pvd.*, pvm.PromoVolName, pcm.PromoDefault,
					@PriceCategory := ".$ProductPriceDefault." - (".$ProductPriceDefault."*(pcm.PromoDefault/100)) AS PriceCategory,
					@PricePromo := @PriceCategory - (@PriceCategory*(pvd.Promo/100)) AS PricePromo,
					@PricePT1 := @PricePromo - (@PricePromo*(pvd.PT1Discount/100)) AS PricePT1,
					@PricePT2 := @PricePromo - (@PricePromo*(pvd.PT2Discount/100)) AS PricePT2
					FROM tb_price_promo_vol_detail pvd
					LEFT JOIN tb_price_promo_vol_main pvm ON (pvd.PromoVolID=pvm.PromoVolID) 
					LEFT JOIN tb_price_category_main pcm ON (pvm.PricecategoryID=pcm.PricecategoryID) 
					WHERE 
					pvm.PromoVolID in (select PromoVolID from vw_price_promo_vol_active) and 
					pvm.isActive=1 and pvd.PromoVolID in (".implode(',', array_map('intval', $promovol)).")
					AND pvd.ProductID = ".$ProductID."
					AND pvd.ProductQty <= ".$ProductQty."
					ORDER BY PricePT1 ASC LIMIT 1";

		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();
		if (!empty($row)) {	
			$data['PriceID'] = $row->PromoVolID;
			$data['PriceName'] = $row->PromoVolName;
        	$data['PromoDefault'] = $row->PromoDefault;
			$data['PV'] = "2";
        	$data['Promo'] = $row->Promo;
        	$data['PT1Percent'] = $row->PT1Discount;
        	$data['PT2Percent'] = $row->PT2Discount;
		} else {
			$sql 	= "SELECT pld.PricelistID, pld.PT1Discount, pld.Promo, pld.PT2Discount, plm.PricelistName, plm.PromoDefault,
						@PriceCategory := ".$ProductPriceDefault." - (".$ProductPriceDefault."*(plm.PromoDefault/100)) AS PriceCategory,
						@PricePromo := @PriceCategory - (@PriceCategory*(pld.Promo/100)) AS PricePromo,
						@PricePT1 := @PricePromo - (@PricePromo*(pld.PT1Discount/100)) AS PricePT1,
						@PricePT2 := @PricePromo - (@PricePromo*(pld.PT2Discount/100)) AS PricePT2
						FROM tb_price_list_detail pld 
						LEFT JOIN (
						SELECT plm.*, pcm.PromoDefault FROM tb_price_list_main plm
						LEFT JOIN tb_price_category_detail pcd ON plm.PricelistID=pcd.PricelistID
						LEFT JOIN tb_price_category_main pcm ON pcd.PricecategoryID=pcm.PricecategoryID
						) AS plm ON pld.PricelistID=plm.PricelistID
		 				WHERE 
						plm.PricelistID in (select PricelistID from vw_price_list_active) and 
						plm.isActive=1 and pld.PricelistID in(".implode(',', array_map('intval', $pricelist)).") 
		 				AND pld.ProductID=".$ProductID." ORDER BY PricePT1 ASC LIMIT 1";
			$hasil2 = $this->db->query($sql);
			// echo $sql;
			$row 	= $hasil2->row();
			if (!empty($row)) {
				$data['PriceID'] = $row->PricelistID;
				$data['PriceName'] = $row->PricelistName;
        		$data['PromoDefault'] = $row->PromoDefault;
				$data['PV'] = "1";
        		$data['Promo'] = $row->Promo;
	        	$data['PT1Percent'] = $row->PT1Discount;
	        	$data['PT2Percent'] = $row->PT2Discount;
			} else {
				$data['PriceID'] = "0";
				$data['PriceName'] = "";
				$data['PV'] = "0";
        		$data['PromoDefault'] = 0;
        		$data['Promo'] = 0;
	        	$data['PT1Percent'] = 0;
	        	$data['PT2Percent'] = 0;
			}
		}

        $ProductPriceDefault = $ProductPriceDefault - ( ($ProductPriceDefault/100)*$data['PromoDefault'] );
        $price = $ProductPriceDefault - ( ($ProductPriceDefault/100)*$data['Promo'] );
        $PT1Price = $price - ( ($price/100)*$data['PT1Percent'] );
    	$PT2Price = $price - ( ($price/100)*$data['PT2Percent'] );

        if ($paymentmethod == "TOP") {
        	$pricefinal = $PT1Price;
        } else {
        	$pricefinal = $PT2Price;
        }
        $data['ProductPriceDefault'] = round($ProductPriceDefault,2);
        $data['PT1Price'] = round($PT1Price,2);
        $data['PT2Price'] = round($PT2Price,2);
        $data['PriceAmount'] = round($pricefinal,2);
        echo json_encode($data);
		$this->log_user->log_query($this->last_query);
	}
//------Fajar Stock Check---------------------------------------------------------
	function stock_check_list()
	{
		$filterstart = isset($_REQUEST['filterstart']) ? date('Y-m-01', strtotime($_REQUEST['filterstart'])) : date('d-m-Y');
		$filterend = isset($_REQUEST['filterend']) ? date('Y-m-t', strtotime($_REQUEST['filterend'])) : date('d-m-Y');
		$sql = "SELECT psa.*, em.fullname FROM tb_product_stock_check psa
				LEFT JOIN vw_user_account em ON (psa.CheckBy=em.UserAccountID)
				";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= " Where CheckDate between '".$filterstart." 00:00:00' and '".$filterend." 23:59:59' ";
		} else {$sql .= " Where MONTH(CheckDate)=MONTH(CURRENT_DATE()) AND YEAR(CheckDate)=YEAR(CURRENT_DATE()) ";}
		$sql.=" order by psa.CheckID desc";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'CheckID' => $row->CheckID,
				'OpnameID' => $row->OpnameID,
				'CheckDate' => $row->CheckDate,
				'CheckNote' => $row->CheckNote,
				'CheckInput' => $row->CheckInput,
				'CheckBy' => $row->CheckBy,
				'isApprove' => $row->isApprove,
				'AdjustmentID' => $row->AdjustmentID,
				'fullname' => $row->fullname
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

	function stock_check_add_act()
	{
		$this->db->trans_start();
		$CheckID = $this->input->post('checkid');
		$note = $this->input->post('note');
		$ProductID = $this->input->post('productid');
		$WarehouseID = $this->input->post('warehouseid');
		$OpnameQty = $this->input->post('opnameqty');
		$adjustment = $this->input->post('adjustment');
		$diff = $this->input->post('diff');
		$note2 = $this->input->post('note2');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$datamain = array(
			'CheckID'=>$CheckID,
			'OpnameID' => 0,
			'CheckDate' => $date,
			'CheckNote' => $note,
			'CheckInput' => $datetime,
			'CheckBy' => $this->session->userdata('UserAccountID'),
			'isApprove'=>0
		);
		if ($CheckID != "") {
			$this->db->where('CheckID', $CheckID);
			$this->db->update('tb_product_stock_check', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('CheckID', $CheckID);
			$this->db->delete('tb_product_stock_check_detail');
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$this->db->insert('tb_product_stock_check', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select max(CheckID) as CheckID from tb_product_stock_check ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$CheckID = $row->CheckID;
		}

		for ($i=0; $i < count($ProductID);$i++) {
			$sq = "SELECT a.ProductID, coalesce(b.Quantity, 0) AS Quantity
					FROM tb_product_main a
					LEFT JOIN tb_product_stock_main b on a.ProductID=b.ProductID and b.WarehouseID= ".$WarehouseID[$i].
					" WHERE a.ProductID = ".$ProductID[$i];
			$getrow = $this->db->query($sq);
			$row 	= $getrow->row();

			if (empty($row->Quantity)){
				$Qty=0;
				} else {
					$Qty=$row->Quantity;
			}

			$diff=$OpnameQty[$i]-$Qty;
			if ($diff !=0) {
				$sts =0;
			} else {
				$sts=1;
			}

			$datadetail = array(
				'CheckID' => $CheckID,
				'ProductID' => $ProductID[$i],
				'WarehouseID' => $WarehouseID[$i],
				'OpnameQty' => $Qty,//$OpnameQty[$i],
				'ProductQty' => $diff,
				'Note' => $note2[$i],
				'isApprove'=>$sts
			);
			$this->db->insert('tb_product_stock_check_detail', $datadetail);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

	function stock_check_edit()
	{
		$CheckID = $this->input->get_post('id');
		$show   = array();

		$sql = "SELECT sa.* FROM tb_product_stock_check sa where CheckID=".$CheckID;
		$query 	= $this->db->query($sql);
		$rowmain= $query->row();
		$show['main'] = get_object_vars($rowmain);

		$sql = "SELECT sad.*, pm.ProductCode, coalesce(sm.Quantity,0) as Quantity
				FROM tb_product_stock_check_detail sad
				LEFT JOIN tb_product_stock_check sa ON (sad.CheckID=sa.CheckID)
				LEFT JOIN tb_product_stock_main sm ON (sm.ProductID=sad.ProductID AND sm.WarehouseID=sad.WarehouseID)
				LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
				where sad.CheckID=".$CheckID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
				'ProductID' => $row->ProductID,
				'WarehouseID' => $row->WarehouseID,
				'Quantity' => $row->Quantity,
				// 'OpnameQty' => $row->ProductQty-$row->OpnameQty,
				'OpnameQty' => $row->OpnameQty+$row->ProductQty,
				'ProductQty' => $row->ProductQty,
				'Note' => $row->Note,
				'ProductCode' => $row->ProductCode
			);
			$show['main']['WarehouseID'] = $row->WarehouseID;
		};
		$show['detail2'] = json_encode($show['detail']);
	    return $show;
	}

	function stock_check_detail()
	{
		$CheckID = $this->input->get_post('id');
		$sql 	= "select OpnameID from tb_product_stock_check where CheckID=".$CheckID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$OpnameID 	= $row->OpnameID;
		if ($OpnameID != '0') {
			$sql = "SELECT sad.*, pm.ProductCode, wm.WarehouseName, sod.Quantity AS QtyOpname
					FROM tb_product_stock_check_detail sad
					LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
					LEFT JOIN tb_warehouse_main wm ON (sad.WarehouseID=wm.WarehouseID)
					LEFT JOIN tb_product_stock_check sa ON sad.CheckID=sa.CheckID
					LEFT JOIN tb_product_stock_main sod ON sa.ProductID=sod.ProductID AND sad.ProductID=sod.ProductID
					where sad.Check=".$Check;
			$query 	= $this->db->query($sql);
			$show   = array();
			foreach ($query->result() as $row) {
				$show[] = array(
					'ProductID' => $row->ProductID,
					'WarehouseID' => $row->WarehouseID,
					'OpnameQty' => $row->QtyOpname,
					'ProductQty' => $row->ProductQty,
					'Note' => $row->Note,
					'WarehouseName' => $row->WarehouseName,
					'ProductCode' => $row->ProductCode,
					'isApprove' => $row->isApprove,
				);
			};
		} else {
			$sql = "SELECT sad.*, pm.ProductCode, wm.WarehouseName
					FROM tb_product_stock_check_detail sad
					LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
					LEFT JOIN tb_warehouse_main wm ON (sad.WarehouseID=wm.WarehouseID)
					where sad.CheckID=".$CheckID;
			$query 	= $this->db->query($sql);
			$show   = array();
			foreach ($query->result() as $row) {
				$show[] = array(
					'ProductID' => $row->ProductID,
					'WarehouseID' => $row->WarehouseID,
					'OpnameQty' => $row->OpnameQty,
					'ProductQty' => $row->ProductQty,
					'Note' => $row->Note,
					'WarehouseName' => $row->WarehouseName,
					'ProductCode' => $row->ProductCode,
					'isApprove' => $row->isApprove,
				);
			};
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

	function stock_check_cancel()
	{
		$this->db->trans_start();

		$CheckID = $this->input->post('CheckID');

		$sql 	= "SELECT ApprovalID FROM tb_approval_stock_adjustment a
		LEFT JOIN tb_product_stock_check b on a.AdjustmentID=b.AdjustmentID
		WHERE b.CheckID = ".$CheckID;

		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();

		if (empty($row)) {
			$this->db->where('CheckID', $CheckID);
			$this->db->delete('tb_product_stock_check');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('CheckID', $CheckID);
			$this->db->delete('tb_product_stock_check_detail');
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

	function stock_check_approval_submission()
	{
		$this->db->trans_start();
		$CheckID=$this->input->post('CheckID');

		//Masukkan ke Tabel tb_product_stock_check_detail
		$sql2 	= "SELECT * from tb_product_stock_check_detail WHERE isApprove = 0 AND CheckID= ".$CheckID;
		$query = $this->db->query($sql2);
		$row 	= $query->row();
		if (empty($row)){
			$this->db->set('isApprove',1);
			$this->db->where('CheckID',$CheckID);
			$this->db->update('tb_product_stock_check');
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$sql1 	= "SELECT * from tb_product_stock_check WHERE CheckID= ".$CheckID;
			$getrow = $this->db->query($sql1);
			$row 	= $getrow->row();
			$datamain = array(
				'OpnameID' => '0',
				'AdjustmentDate' => $row->CheckDate,
				'AdjustmentNote' => $row->CheckNote." (Stock Check ".$CheckID.")",
				'AdjustmentInput' => $row->CheckInput,
				'AdjustmentBy' => $this->session->userdata('UserAccountID')
			);

			//Masukkan ke Tabel tb_product_stock_adjustment
			$this->db->insert('tb_product_stock_adjustment', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select max(AdjustmentID) as AdjustmentID from tb_product_stock_adjustment ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$AdjustmentID 	= $row->AdjustmentID;

			$this->db->set('AdjustmentID',$AdjustmentID);
			$syarat=array(
				'isApprove'=>0,
				'CheckID'=>$CheckID
			);
			$this->db->where($syarat);
			$this->db->update('tb_product_stock_check');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('AdjustmentID',$AdjustmentID);
			$this->db->where($syarat);
			$this->db->update('tb_product_stock_check_detail');
			$this->last_query .= "//".$this->db->last_query();

			foreach ($query->result() as $row2) {
				$datamain2 = array(
					'AdjustmentID' => $AdjustmentID,
					'ProductID' => $row2->ProductID,
					'WarehouseID' => $row2->WarehouseID,
					'OpnameQty' => $row2->OpnameQty,//-$row2->ProductQty,
					'ProductQty' => $row2->ProductQty,
					'Note' => $row2->Note." (AdjusmentID".$AdjustmentID.")",
					'isApprove' => 1//$row2->isApprove
				);
				$this->db->insert('tb_product_stock_adjustment_detail', $datamain2);
				$this->last_query .= "//".$this->db->last_query();
			}

			//masukkan ke proses approval
			$this->db->where('ProductQty', 0);
			$this->db->delete('tb_product_stock_adjustment_detail');
			$this->last_query .= "//".$this->db->last_query();

			// get actor 3 approval
			$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='stock_adjustment' ";
			$getActor3 	= $this->db->query($sql);
			$row 		= $getActor3->row();
			$Actor3 	= $row->Actor3;

			$sql 	= "select * from tb_approval_stock_adjustment where AdjustmentID=".$AdjustmentID;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			if (empty($row)) {
				if ($Actor3 != 0) {
					$data_approval = array(
						'AdjustmentID' => $AdjustmentID,
						'Title' => "Approval for Stock Adjusment ".$AdjustmentID." (Stock Check ".$CheckID.")",
						'isComplete' => 0,
						'Status' => "OnProgress"
					);
					$this->db->insert('tb_approval_stock_adjustment', $data_approval);
					$this->last_query .= "//".$this->db->last_query();
				} else {
					$data_approval = array(
						'AdjustmentID' => $AdjustmentID,
						'Title' => "Approval for Stock Adjusment ".$AdjustmentID." (Stock Check ".$CheckID.")",
						'isComplete' => 1,
						'Status' => "Approved"
					);
					$this->db->insert('tb_approval_stock_adjustment', $data_approval);
					$this->last_query .= "//".$this->db->last_query();

					$this->db->set('isApprove', $this->session->userdata('UserAccountID'));
					$this->db->where('AdjustmentID', $AdjustmentID);
					$this->db->update('tb_product_stock_adjustment_detail');
					$this->last_query .= "//".$this->db->last_query();

					$this->db->set('isApprove', 1);
					$this->db->where('AdjustmentID', $AdjustmentID);
					$this->db->update('tb_product_stock_adjustment');
					$this->last_query .= "//".$this->db->last_query();

					$this->load->model('model_approval');
					$this->model_approval->approve_stock_adjustment_implementation($AdjustmentID);
				}
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

	public function product_stock_rekap_history()
	{
		$show   = array();
		$sql 	= "SELECT
					b.ProductID, a.ProductName, a.ProductCode, c.WarehouseID,
					c.Quantity as ResultQty, sum(b.Quantity) as Quantity
				FROM
					tb_product_main a, tb_product_stock_main c
				LEFT JOIN vw_product_stock_history2 b on c.ProductID=b.ProductID
				WHERE a.ProductID = c.ProductID and b.WarehouseID = c.WarehouseID
				GROUP BY c.ProductID, c.WarehouseID";//GROUP BY c.ProductID";//
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][] = array(
				'ProductID' => $row->ProductID,
				'ProductCode' => $row->ProductCode,
				'ProductName' => $row->ProductName,
				'WarehouseID' => $row->WarehouseID,
				'Quantity' => $row->Quantity,
				'ResultQty' => $row->ResultQty
			);
		};
		return $show;
	}

	function report_sab_hystory()
	{
		$ProductID 	= 3504;//$this->input->get_post('product');
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

		$sql = "SELECT *, concat_ws( '-', srd.srcType, srd.srcReff, srd.Company) AS Reff FROM vw_product_stock_history2 sh
				LEFT JOIN vw_stock_reff_dest srd ON sh.NoReff = CONVERT(concat(srd.type, srd.ID) USING latin1)
				WHERE sh.ProductID=".$ProductID." ORDER BY sh.CreatedDate, sh.HistoryID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
				'HistoryID' => $row->HistoryID,
				'NoReff' => $row->NoReff,
				'Reff' => $row->Reff,
				'WarehouseName' => $row->WarehouseName,
				'Quantity' => $row->Quantity,
				'QuantityAfter' => $row->QuantityAfter,
				'CreatedDate' => $row->CreatedDate,
				'fullname' => $row->fullname
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function report_stock_adjustment_balance()
	{
		$show   = array();

		$show['info_filter'] = "";
		$ProductID = $this->input->get_post('productid');
		$ProductName = $this->input->get_post('productname');

		$sql = "
			SELECT pm.ProductID,pm.ProductName,pm.ProductCode, COALESCE(b.Sab,0) as Sab, LastCheck, COALESCE(DCheck,0) as DCheck, LastAdjust, COALESCE(DAdjust,0) as DAdjust, COALESCE(sum(psm.Quantity),0) as Quantity,
			vps.AtributeValue AS Shop, vpo.ProductAtributeValueName AS SourceAgent, pm.forSale,
			vpm.ProductAtributeValueName AS ProductManager
			FROM tb_product_main pm
			LEFT JOIN vw_product_sab b on pm.ProductID=b.ProductID
			LEFT JOIN tb_product_stock_main psm on psm.ProductID= pm.ProductID
			LEFT JOIN vw_product_shop vps ON vps.ProductID = pm.ProductID
			LEFT JOIN vw_product_origin vpo ON vpo.ProductID=pm.ProductID
			LEFT JOIN vw_product_manager vpm ON vpm.ProductID=pm.ProductID
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
		echo $main->ProductID;
	}
	function get_report_stock_adjustment_detail()
	{
		$id = $this->input->get('a');
		$sql1 = "
			SELECT
				a.ProductID,
				a.ProductName,
				a.ProductCode,
				COALESCE(b.Sab,0) as Sab,
				b.CheckDate,
				b.WarehouseID,
				b.WarehouseName,
				COALESCE(b.Quantity,0) as Quantity
			FROM tb_product_main a
			LEFT JOIN vw_product_sab_detail b on a.ProductID=b.ProductID
			where a.ProductID=".$id."
			GROUP BY b.WarehouseID
		";
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
		$sql = "
			SELECT
				a.ProductID,
				a.ProductName,
				a.ProductCode,
				COALESCE(b.Sab,0) as Sab,
				b.CheckDate,
				b.WarehouseID,
				b.WarehouseName,
				COALESCE(b.Quantity,0) as Quantity
			FROM tb_product_main a
			LEFT JOIN vw_product_sab_detail b on a.ProductID=b.ProductID
			where a.isActive=1 and a.ProductID= $id and b.ProductID is not null order by b.WarehouseID, b.CheckDate"
		;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][]= array(
				//''=>'',
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
		// $this->log_user->log_query($this->last_query);
	}

	function sop_list()
	{
		$show   = array();
		$show['info_filter'] = "";
		$sql="SELECT sop.*, jd.DivisiName, CONCAT_WS(c.NameMid, c.NameFirst, c.NameLast) as FullName
			FROM tb_sop sop
			LEFT JOIN tb_job_divisi jd on sop.DivisiID=jd.DivisiID
			LEFT JOIN tb_employee_main em on em.EmployeeID=sop.InputBy
			LEFT JOIN tb_contact c on em.ContactID=c.ContactID
			";
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function sop_list_add()
	{
		$EmployeeID = $this->session->userdata('UserAccountID');

		$show   = array();
		$sql="SELECT em.EmployeeID, CONCAT_WS(c.NameMid, c.NameFirst, c.NameLast) as FullName
			from tb_employee_main em
			LEFT JOIN tb_user_account ua on em.ContactID=ua.ContactID
			LEFT JOIN tb_contact c on em.ContactID=c.ContactID
			WHERE ua.UserAccountID= ".$EmployeeID
			;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['user']= array(
				'EmployeeID' => $row->EmployeeID,
				'FullName' => $row->FullName,
				// 'DivisiCode' => $row->DivisiCode
			);
		}

		$sql 	= "SELECT DivisiID,DivisiName,DivisiCode FROM tb_job_divisi";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['dept'][]= array(
				'DivisiID' => $row->DivisiID,
				'DivisiName' => $row->DivisiName,
				'DivisiCode' => $row->DivisiCode
			);
		}
		// echo json_encode($show);
	    return $show;
	}

	function sop_list_add_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$EmployeeID = $this->session->userdata('EmployeeID');
		$DivisiID = $this->input->get_post('departement');
		$No = $this->input->get_post('no');
		$Code = $this->input->get_post('codeid');
		$Subject = $this->input->get_post('subject');
		$Label = $this->input->get_post('label');
		$Link = $this->input->get_post('link');
		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;

		if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
			$filesnames = $_FILES['label']['name'];
            $target_dir = "assets/PDF_SOP/";
            $target_file = $target_dir . $filesnames;
            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
				$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
				$data_file['File'] = $label;
            }
            rename("assets/PDF_SOP/".$filesnames, "assets/PDF_SOP/".$Code.".PDF");// . pathinfo($code, PATHINFO_BASENAME));
			$filesnames=$Code.".PDF";
        }
		$data= array(
					'SopID'=>'',
					'SopCode' => $Code,
					'DivisiID' => $DivisiID,
					'Subject' => $Subject,
					'InputBy'=>$EmployeeID,
					'UploadDate'=>$date,
					'UpdateDate'=>'',
					'FilePDF' => $filesnames,
					'Link' => $Link,
					'No'=>$No
				);
		$this->db->insert('tb_sop', $data);
		$this->last_query .= "//".$this->db->last_query();
		$sqlmax="SELECT max(SopID) as SopID FROM tb_sop";
		$query3 	= $this->db->query($sqlmax);
		$row=$query3->row();
		$SopID= $row->SopID;
		$EmployeeIDArr = array();
		$sql3 	= "SELECT sop.SopID,sop.DivisiID,tjl.EmployeeID
					From tb_sop sop
					LEFT JOIN tb_job_level tjl on sop.DivisiID=tjl.DivisiID
					where tjl.EmployeeID<>0 and tjl.DivisiID=".$DivisiID ." and sop.SopID=".$SopID;
		$query3 	= $this->db->query($sql3);
		$query3->result();
		$row3=$query3->result();
		foreach ($query3->result() as $row3) {
			// array_push($EmployeeIDArr, $row3->EmployeeID);
			$SopIDArr=array($SopID);
			$EmployeeIDArr[]=$row3->EmployeeID;
		}
		$this->load->model('model_notification');
		$this->model_notification->insert_notif('notif_sop', 'New SOP', 'SopID', $SopIDArr, 'replace', $EmployeeIDArr);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function sop_list_edit()
	{
		$SopID = $this->input->get_post('id');
		$show   = array();
		$sql="SELECT sop.*, jd.DivisiName, CONCAT_WS(c.NameMid, c.NameFirst, c.NameLast) as FullName
			FROM tb_sop sop
			LEFT JOIN tb_job_divisi jd on sop.DivisiID=jd.DivisiID
			LEFT JOIN tb_employee_main em on em.EmployeeID=sop.InputBy
			LEFT JOIN tb_contact c on em.ContactID=c.ContactID
			WHERE sop.SopID= ".$SopID
			;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		$show['isi'][] = array(
					'SopID'=>$row->SopID,
					'SopCode' => $row->SopCode,
					'DivisiID' => $row->DivisiID,
					'Subject' => $row->Subject,
					'InputBy'=>$row->InputBy,
					'UploadDate'=>$row->UploadDate,
					'UpdateDate'=>'',
					'FilePDF' => $row->FilePDF,
					'Link' => $row->Link,
					'No'=>$row->No,
					'DivisiName' => $row->DivisiName,
					'FullName' => $row->FullName,
				);
		}
		// $show   = array();
		$sql 	= "SELECT DivisiID,DivisiName,DivisiCode FROM tb_job_divisi";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['dept'][]= array(
				'DivisiID' => $row->DivisiID,
				'DivisiName' => $row->DivisiName,
				'DivisiCode' => $row->DivisiCode
			);
		}
		// echo json_encode($show);
		// $show   = $query->result_array();
	    return $show;
	}
	function sop_list_edit_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$id = $this->input->get_post('id');
		$InputBy = $this->session->userdata('EmployeeID');
		$DivisiID = $this->input->get_post('departement');
		$No = $this->input->get_post('no');
		$Code = $this->input->get_post('codeid');
		$Subject = $this->input->get_post('subject');
		$Label = $this->input->get_post('label');
		$Label2 = $this->input->get_post('label2');
		$Link = $this->input->get_post('link');
		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values

		$limit = 1000000;
		if(isset($_FILES['label']['name'])){
			unlink("assets/PDF_SOP/".$Label2);
			if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
				$filesnames = $_FILES['label']['name'];
	            $target_dir = "assets/PDF_SOP/";
	            $target_file = $target_dir . $filesnames;
	            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
					$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['File'] = $label;
	            }
	            rename("assets/PDF_SOP/".$filesnames, "assets/PDF_SOP/".$Code."-up.PDF");// . pathinfo($code, PATHINFO_BASENAME));
				$filesnames=$Code."-up.PDF";
	        }
	    }else{
				$filesnames=$Label2;
	        }
		$sql="SELECT SopID FROM tb_sop WHERE SopID=$id";
		$query 	= $this->db->query($sql);
		if(!empty($query->row())){
			$data= array(
					'SopID'=> $id,
					'SopCode' => $Code,
					'DivisiID' => $DivisiID,
					'Subject' => $Subject,
					'InputBy'=>$InputBy,
					'UpdateDate'=>$date,
					'FilePDF' => $filesnames,
					'Link' => $Link,
					'No'=>$No
				);
			$this->db->where('SopID', $id);
			$this->db->update('tb_sop', $data);
			$this->last_query .= "//".$this->db->last_query();
		}

		$sql3 	= "SELECT sop.SopID,sop.DivisiID,tjl.EmployeeID
					From tb_sop sop
					LEFT JOIN tb_job_level tjl on sop.DivisiID=tjl.DivisiID
					where tjl.EmployeeID<>0 and tjl.DivisiID=".$DivisiID ." and sop.SopID=".$id;
		$query3 	= $this->db->query($sql3);
		$query3->result();
		$row3=$query3->result();
		$SopID=$id;
		foreach ($query3->result() as $row3) {
			// array_push($EmployeeIDArr, $row3->EmployeeID);
			$SopIDArr=array($SopID);
			$EmployeeIDArr[]=$row3->EmployeeID;
		}
		$this->load->model('model_notification');
		$this->model_notification->insert_notif('notif_sop', 'New SOP', 'SopID', $SopIDArr, 'replace', $EmployeeIDArr);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

	function sop_list_cancel()
	{
		$this->db->trans_start();

		$SopID = $this->input->post('SopID');
		$this->db->where('SopID', $SopID);
		$this->db->delete('tb_sop');
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function get_code()
	{
		$kode = $this->input->get_post('code');
		$sql = "SELECT
					jd.DivisiCode, COALESCE(max(sop.No),0)+1 as No
				FROM
					tb_job_divisi jd
				LEFT JOIN tb_sop sop on sop.DivisiID=jd.DivisiID
				WHERE
					jd.DivisiID = ".$kode;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			if (($row->No)<10){
				$No="00".$row->No;
			}elseif(($row->No)<100){
				$No="0".$row->No;
			}else{
				$No=$row->No;
			}
			$DivisiCode=str_replace("/", ".SOP.", $row->DivisiCode).".".$No;
			$show= array(
				'no'=>$No,
				'codeid' => $DivisiCode
			);
		};
		$show = array_reverse($show);
		echo json_encode($show);

		$this->log_user->log_query($this->last_query);
		return $show;
	}
}
?>