<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_approval extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->last_query = "";
		$ReportResult = $this->session->userdata('ReportResult');
		$this->limit_result = isset($ReportResult) ? $ReportResult : 100;
	}

// upgrade_customer ==================================================
	function upgrade_customer_list()
	{
		$sql 	= "SELECT * FROM tb_approval_actor WHERE ApprovalCode = 'customer_category'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);
		$bulan=date('Y-m');
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');

		$sql = "SELECT c.Company2, acc.*, c.ContactID ";
		$sql .= "FROM tb_approval_customer_category acc ";
		$sql .= "LEFT JOIN tb_customer_main cm on (acc.CustomerID = cm.CustomerID) ";
		$sql .= "LEFT JOIN vw_contact2 c on (c.ContactID = cm.ContactID) ";
		if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sql .= "WHERE (acc.Actor1 between '".$Date."' AND '".$Date2."') ";
		} else {
		$sql .= "WHERE acc.isComplete = 0 ";
		}
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'ContactID' => $row->ContactID,
					'fullname' => $row->Company2,
					'Keterangan' => $row->Keterangan,
					'Actor1' => $row->Actor1,
					'Actor2' => $row->Actor2,
					'Actor3' => $row->Actor3,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		// echo $sql;
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function upgrade_customer_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$id 	= $this->input->post('id');
		$user 	= $this->input->post('user');

		$sql 	= "SELECT * FROM tb_approval_customer_category WHERE ApprovalID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;
		$CustomerID 	= $row->CustomerID;

		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$query = $row->ApprovalQuery;
					$hasil = $this->db->query($query);
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ApprovalID', $id);
				$this->db->update('tb_approval_customer_category', $data);
				$this->last_query .= "//".$this->db->last_query();

				$data_pv = array(
					'isComplete' => '1',
					'Status' => 'Approved',
				);
				$this->db->where('id', $id);
				$this->db->update('tb_customer_pv', $data_pv);
				$this->last_query .= "//".$this->db->last_query();
			}
		} else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('ApprovalID', $id);
				$this->db->update('tb_approval_customer_category', $data);
				$this->last_query .= "//".$this->db->last_query();

				$data_pv = array(
					'isComplete' => '2',
					'Status' => 'Rejected',
				);
				$this->db->where('id', $id);
				$this->db->update('tb_customer_pv', $data_pv);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function approved_upgrade_customer($CustomerID, $creditlimit, $Actor3)
	{
		$this->db->trans_start();
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// approve_so=========================================================
	function approve_so_list()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "approve_so");
		$show['actor'] = $user;
		$Date = $this->input->get_post('filterstart');
		$Date2= $this->input->get_post('filterend');
		$sql 	= "select aso.*, sm.BillingAddress FROM tb_approval_so aso
					left join tb_so_main sm on (aso.SOID=sm.SOID) ";
		if ($Date && $Date2 != "") {
			$Date = date_create($this->input->get_post('filterstart'));
			$Date2 = date_create($this->input->get_post('filterend'));
			$Date = date_format($Date, "Y-m-d");
			$Date2 = date_format($Date2, "Y-m-t");

			$sql .= "WHERE (aso.Actor1 between '".$Date."' AND '".$Date2."') ";
		} else {
		$sql.="where isComplete=0 order by ApprovalID asc";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$Customer = explode(';', $row->BillingAddress);
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'SOID' => $row->SOID,
					'Customer' => $Customer[0],
					'Title' => $row->Title,
					'Note' => $row->Note,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'ApprovalQuery' => $row->ApprovalQuery,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function approve_so_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$SOID 	= $this->input->post('SOID');
		$id 	= $this->input->post('id');
		$user 	= $this->get_actor($EmployeeID, "tb_approval_actor", "approve_so");

		$sql 	= "select * from tb_approval_so where ApprovalID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$query = $row->ApprovalQuery;
					$hasil = $this->db->query($query);
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ApprovalID', $id);
				$this->db->update('tb_approval_so', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		} else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('ApprovalID', $id);
				$this->db->update('tb_approval_so', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}

		$this->load->model('model_transaction');
		$this->model_transaction->update_SOConfirm2($SOID, 'approval');

		$this->log_user->log_query($this->last_query);
		echo json_encode($data);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function sales_order_detail()
	{
		$SOID 	= $this->input->get('so');
		$show['id'] = $this->input->get('id');

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "approve_so");
		$status		= $this->get_actor_approval($user, "tb_approval_so", $show['id']);
		$show['actor'] = $status;

		$sql	= "SELECT sm.*, vs.Company2 as Company, cm.PaymentTerm as PaymentTerm2, cm.CreditLimit, cm.CustomerPVMultiplier AS CustomerPVMp,
					vem1.Company2 as secname, vem2.Company2 as salesname, sc.CategoryName,
					vsb.TotalDeposit, vsb.TotalPayment, sm2.INVMP, sm2.ResiNo, mp.MarketPlace FROM tb_so_main sm
					LEFT JOIN tb_so_main2 sm2 ON (sm.SOID = sm2.SOID)
					LEFT JOIN tb_mp mp ON (mp.MPID = sm2.MPID)
					LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID)
					LEFT JOIN vw_contact2 vs ON (cm.ContactID = vs.ContactID)
					LEFT JOIN vw_sales_executive2 vem1 ON (sm.SECID = vem1.SalesID)
					LEFT JOIN vw_sales_executive2 vem2 ON (sm.SalesID = vem2.SalesID)
					LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID)
					LEFT JOIN vw_so_balance vsb ON (sm.SOID = vsb.SOID) WHERE sm.SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();
		$show['so'] = get_object_vars($rowso);
		$CustomerID = $rowso->CustomerID;

		$show['so']['CreditLimit'] = number_format($show['so']['CreditLimit']);
		$this->load->model('model_finance', 'finance');
		$debt = $this->finance->get_customer_debt($CustomerID);
		$show['so']['creditavailable'] = $rowso->CreditLimit;
		// if ($show['so']['PaymentWay'] == "TOP" && $debt > 0) {
			$show['so']['creditavailable'] -= $debt ;
		// }

		$sql 	= "SELECT Note FROM tb_approval_so WHERE SOID=".$SOID." ORDER BY ApprovalID Desc LIMIT 1";
		$query 	= $this->db->query($sql);
		$rownote 	= $query->row();
		$show['so']['SystemNote'] = $rownote->Note ;

		// get product
		$sql 	= "SELECT sd.*, MAX(COALESCE(ppl.ProductQty,0)) AS plQTy, MAX(COALESCE(ppl.Promo,0)) AS plPromo, pm.ProductPriceDefault as PriceEndUser,
					MAX(COALESCE(ppl.PT1Discount,0)) AS plPT1Discount, MAX(COALESCE(ppl.PT2Discount,0)) AS plPT2Discount,
					COALESCE(ppl.PromoCategory,0) AS PromoCategory
					FROM tb_so_detail sd
					LEFT JOIN tb_product_main pm ON (pm.ProductID = sd.ProductID)
					LEFT JOIN vw_product_promo_list ppl ON
					sd.PriceID=ppl.PricelistID AND sd.PriceName=ppl.PricelistName AND
					sd.ProductID=ppl.ProductID AND sd.ProductQty>=ppl.ProductQty
					WHERE sd.SOID=".$SOID." GROUP BY sd.ProductID";
		// echo $sql;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$PriceCategory = $this->get_min_percent($row->PriceEndUser, $row->PromoCategory);
			$PriceCategoryP =$this->get_min_percent($PriceCategory, $row->plPromo);
			$PriceplPT1Discount =$this->get_min_percent($PriceCategoryP, $row->plPT1Discount);
			$PriceplPT2Discount =$this->get_min_percent($PriceCategoryP, $row->plPT2Discount);
			$show['detail'][] = array(
				'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'PriceEndUser' => $row->PriceEndUser,
				'ProductWeight' => $row->ProductWeight,
				'PriceID' => $row->PriceID,
				'PT1Percent' => $row->PT1Percent,
				'PT1Price' => $row->PT1Price,
				'PT2Percent' => $row->PT2Percent,
				'PT2Price' => $row->PT2Price,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal,
				'PVSO' => $row->PVSO,
				'PriceName' => $row->PriceName,
				'PromoCategory' => $row->PromoCategory,
				'plPromo' => $row->plPromo,
				'plPT1Discount' => $row->plPT1Discount,
				'plPT2Discount' => $row->plPT2Discount,
				'PriceCategory' => $PriceCategory,
				'PriceplPT1Discount' => $PriceplPT1Discount,
				'PriceplPT2Discount' => $PriceplPT2Discount,
			);
		};

		$this->load->model('model_transaction');
		$solate = $this->model_transaction->get_so_outstanding($CustomerID);
		if (!empty($solate)) {
			$show['solate'] = $solate;
		}

		$this->load->model('model_transaction');
		$invlate = $this->model_transaction->get_inv_outstanding($CustomerID);
		if (!empty($invlate)) {
			$show['invlate'] = $invlate;
		}

		return $show;
	}

// approve_adjustment=================================================
	function approve_stock_adjustment()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "stock_adjustment");
		$show['actor'] = $user;

		$sql 	= "select * FROM tb_approval_stock_adjustment where isComplete=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'AdjustmentID' => $row->AdjustmentID,
					'Title' => $row->Title,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function approve_stock_adjustment_detail()
	{
		$show = array();
		$AdjustmentID = $this->input->get_post('adjustment');
		$show['id'] = $this->input->get('id');

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "stock_adjustment");
		$status		= $this->get_actor_approval($user, "tb_approval_stock_adjustment", $show['id']);
		$show['actor'] = $status;

		$sql = "SELECT pso.*, psa.*, em.fullname as emAdjustment, em2.fullname as emOpname
				FROM tb_product_stock_adjustment psa
				LEFT JOIN tb_product_stock_opname pso ON (psa.OpnameID=pso.OpnameID)
				LEFT JOIN vw_user_account em ON (psa.AdjustmentBy=em.UserAccountID)
				LEFT JOIN vw_user_account em2 ON (pso.OpnameBy =em2.UserAccountID)
				WHERE psa.AdjustmentID=".$AdjustmentID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'] = array(
				'AdjustmentID' => $row->AdjustmentID,
				'AdjustmentDate' => $row->AdjustmentDate,
				'AdjustmentNote' => $row->AdjustmentNote,
				'AdjustmentBy' => $row->emAdjustment,
				'OpnameID' => $row->OpnameID,
				'OpnameDate' => $row->OpnameDate,
				'OpnameNote' => $row->OpnameNote,
				'OpnameBy' => $row->emOpname
			);
			$OpnameID = $row->OpnameID;
		};

		if ($OpnameID != '0') {
			$sql = "SELECT sad.*, pm.ProductCode, wm.WarehouseName, sod.Quantity AS QtyOpname
					FROM tb_product_stock_adjustment_detail sad
					LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
					LEFT JOIN tb_warehouse_main wm ON (sad.WarehouseID=wm.WarehouseID)
					LEFT JOIN tb_product_stock_adjustment sa ON sad.AdjustmentID=sa.AdjustmentID
					LEFT JOIN tb_product_stock_opname_detail sod ON sa.OpnameID=sod.OpnameID AND sad.ProductID=sod.ProductID
					where sad.AdjustmentID=".$AdjustmentID."";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$show['detail'][] = array(
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
					FROM tb_product_stock_adjustment_detail sad
					LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
					LEFT JOIN tb_warehouse_main wm ON (sad.WarehouseID=wm.WarehouseID)
					LEFT JOIN tb_product_stock_adjustment sa ON sad.AdjustmentID=sa.AdjustmentID
					where sad.AdjustmentID=".$AdjustmentID."";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$show['detail'][] = array(
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
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function approve_stock_adjustment_act()
	{
		set_time_limit(3600);
		$this->db->trans_start();

		$AdjustmentID = $this->input->post('AdjustmentID');
		$ProductID = $this->input->post('ProductID');
		// echo json_encode($this->input->post());

		$this->db->set('isApprove', 0);
		$this->db->where('AdjustmentID', $AdjustmentID);
		$this->db->update('tb_product_stock_adjustment_detail');
		$this->last_query .= "//".$this->db->last_query();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "stock_adjustment");

		$sql 	= "select * from tb_approval_stock_adjustment where AdjustmentID =".$AdjustmentID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$ApprovalID	= $row->ApprovalID;
		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;

		switch ($user) {
			case 'Actor1':
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				break;
			case 'Actor2':
				if ($Approval1 == "") {
					$data['Actor1'] = date("Y-m-d H:i:s");
					$data['Actor1ID'] = $EmployeeID;
				}
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				break;
			case 'Actor3':
				if ($Approval1 == "") {
					$data['Actor1'] = date("Y-m-d H:i:s");
					$data['Actor1ID'] = $EmployeeID;
				}
				if ($Approval2 == "") {
					$data['Actor2'] = date("Y-m-d H:i:s");
					$data['Actor2ID'] = $EmployeeID;
				}
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				$data['isComplete'] = "1";
				$data['Status'] = "Approved";

				break;
		}
		if (!empty($data)) {
			$this->db->where('ApprovalID', $ApprovalID);
			$this->db->update('tb_approval_stock_adjustment', $data);
			$this->last_query .= "//".$this->db->last_query();

			if (isset($ProductID)) {
				$this->db->set('isApprove', $EmployeeID);
				$this->db->where('AdjustmentID', $AdjustmentID);
				$this->db->where_in('ProductID', $ProductID);
				$this->db->update('tb_product_stock_adjustment_detail');
				$this->last_query .= "//".$this->db->last_query();

			} else {
				$data['isComplete'] = "1";
				$data['Status'] = "Approved";
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_approval_stock_adjustment', $data);
				$this->last_query .= "//".$this->db->last_query();
				
				$this->db->set('isApprove', 1);
				$this->db->where('AdjustmentID', $AdjustmentID);
				$this->db->update('tb_product_stock_adjustment');
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		if ($user == "Actor3") {
			$this->db->set('isApprove', 1);
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->update('tb_product_stock_adjustment');
			$this->last_query .= "//".$this->db->last_query();
			
			$this->db->set('isApprove', 1);
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->update('tb_product_stock_check');
			$this->last_query .= "//".$this->db->last_query();

			$this->approve_stock_adjustment_implementation($AdjustmentID);
		}
		$this->update_stock_check_approve($AdjustmentID);
		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function approve_stock_adjustment_implementation($val)
	{
		$this->db->trans_start();

		$sql 	= "SELECT pso.OpnameDate, psa.OpnameID FROM tb_product_stock_adjustment psa
					LEFT JOIN tb_product_stock_opname pso ON (psa.OpnameID=pso.OpnameID)
					WHERE psa.AdjustmentID=".$val;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$OpnameID = $row->OpnameID;
		$OpnameDate = $row->OpnameDate;
		$WarehouseID = 0;
		if ($OpnameID != 0) {
			$sql 	= "select ProductID, WarehouseID, ProductQty FROM tb_product_stock_adjustment_detail
						where isApprove>1 and AdjustmentID=".$val;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				if ($row->ProductQty >0) {
					$type = 'add';
					$NewQty = $row->ProductQty;
				} elseif ($row->ProductQty <0) {
					$type = 'min';
					$NewQty = $row->ProductQty * (-1);
				}
				$this->load->model('model_transaction', 'transaction');
				$this->transaction->stock_adjustment($row->ProductID, $NewQty, $row->WarehouseID, $val, $type, $OpnameDate);

				$WarehouseID = $row->WarehouseID;
			};
		} else {
			$currentDate = date('Y-m-d H:i:s');
			$sql 	= "select ProductID, WarehouseID, ProductQty FROM tb_product_stock_adjustment_detail
						where isApprove>1 and AdjustmentID=".$val;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				if ($row->ProductQty >0) {
					$type = 'add';
					$NewQty = $row->ProductQty;
				} elseif ($row->ProductQty <0) {
					$type = 'min';
					$NewQty = $row->ProductQty * (-1);
				}
				$this->load->model('model_transaction', 'transaction');
				$this->transaction->stock_adjustment($row->ProductID, $NewQty, $row->WarehouseID, $val, $type, $currentDate);

				$WarehouseID = $row->WarehouseID;
			};
		}

		if (!empty($row)) {
			$this->load->model('model_acc');
			$this->model_acc->auto_journal_stock_adjustment($val, $WarehouseID);
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function update_stock_check_approve($AdjustmentID)
	{
		$this->db->trans_start();
		$sql 	="SELECT isApprove from tb_product_stock_adjustment where AdjustmentID=".$AdjustmentID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if ($row->isApprove==1){
			$this->db->set('isApprove', 1);
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->update('tb_product_stock_check');
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "UPDATE tb_product_stock_check_detail
					SET isApprove = 1
					WHERE	AdjustmentID = ".$AdjustmentID."
					AND ProductID IN (
						SELECT ProductID
						from tb_product_stock_adjustment_detail
						where isApprove <> 0 and AdjustmentID=".$AdjustmentID."
					)";
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "UPDATE tb_product_stock_check_detail
					SET isApprove = 2
					WHERE	AdjustmentID = ".$AdjustmentID."
					AND ProductID IN (
						SELECT ProductID
						from tb_product_stock_adjustment_detail
						where isApprove = 0 and AdjustmentID=".$AdjustmentID."
					)";
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();

	}

// approve_mutation_product===========================================
	function approve_mutation_product()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "mutation_product");
		$show['actor'] = $user;

		$sql 	= "select * FROM tb_approval_mutation_product where isComplete=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'MutationID' => $row->MutationID,
					'Title' => $row->Title,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function mutation_detail()
	{
		$show = array();
		$MutationID = $this->input->get('mutation');
		$show['id'] = $this->input->get('id');

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "mutation_product");
		$status		= $this->get_actor_approval($user, "tb_approval_mutation_product", $show['id']);
		$show['actor'] = $status;

		$sql 	= "SELECT pm.*, wm1.WarehouseName as wFrom, wm2.WarehouseName as wTo
					FROM tb_product_mutation pm
					LEFT JOIN tb_warehouse_main wm1 ON pm.WarehouseFrom=wm1.WarehouseID
					LEFT JOIN tb_warehouse_main wm2 ON pm.WarehouseTo=wm2.WarehouseID
					WHERE MutationID=".$MutationID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show['main'] = array(
			'MutationID' => $row->MutationID,
			'MutationDate' => $row->MutationDate,
			'WarehouseFrom' => $row->WarehouseFrom,
			'WarehouseTo' => $row->WarehouseTo,
			'MutationNote' => $row->MutationNote,
			'MutationFC' => $row->MutationFC,
			'wFrom' => $row->wFrom,
			'wTo' => $row->wTo
		);
		$sql 	= "SELECT pm.*, plp.ProductCode, coalesce(sm1.Quantity,0) AS stock1, coalesce(sm2.Quantity,0) AS stock2
					FROM tb_product_mutation_detail pm
					LEFT JOIN vw_product_list_popup2 plp on pm.ProductID = plp.ProductID
					LEFT JOIN tb_product_stock_main sm1 ON pm.ProductID=sm1.ProductID AND sm1.WarehouseID=".$row->WarehouseFrom."
					LEFT JOIN tb_product_stock_main sm2 ON pm.ProductID=sm2.ProductID AND sm2.WarehouseID=".$row->WarehouseTo."
					WHERE MutationID=".$MutationID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			$show['detail'][] = array(
				'ProductID' => $row2->ProductID,
				'ProductCode' => $row2->ProductCode,
				'ProductQty' => $row2->ProductQty,
				'stock1' => $row2->stock1,
				'stock2' => $row2->stock2,
			);
		};

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function approve_mutation_product_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$SOID 	= $this->input->post('SOID');
		$id 	= $this->input->post('id');
		$user 	= $this->get_actor($EmployeeID, "tb_approval_actor", "mutation_product");

		$sql 	= "select * from tb_approval_mutation_product where ApprovalID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$query = $row->ApprovalQuery;
					$hasil = $this->db->query ($query);
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ApprovalID', $id);
				$this->db->update('tb_approval_mutation_product', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		} else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('ApprovalID', $id);
				$this->db->update('tb_approval_mutation_product', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		echo json_encode($data);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// approve_dor_invr===========================================
	function approve_dor_invr()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "dor_invr");
		$show['actor'] = $user;

		$sql 	= "select * FROM tb_approval_dor_invr where isComplete=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'DORID' => $row->DORID,
					'Title' => $row->Title,
					'Note' => $row->Note,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function dor_invr_detail()
	{
		$show = array();
		$DORID = $this->input->get('DORID');
		$show['DORID'] = $this->input->get('DORID');
		$show['id'] = $this->input->get('id');

		$sql	= "SELECT pm.* FROM tb_approval_dor_invr pm WHERE pm.ApprovalID = ".$show['id'];
		$getrow	= $this->db->query($sql);
		$row	= $getrow->row();
		$show['approval'] = (array) $row;

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user		= $this->get_actor($EmployeeID, "tb_approval_actor", "dor_invr");
		$status		= $this->get_actor_approval($user, "tb_approval_dor_invr", $show['id']);
		$show['actor'] = $status;

		$sql 	= "SELECT dm.*, im.*, se.Company2 as sales, CONCAT(fn.FakturParent,im.FakturNumber) as FakturNumber 
					FROM tb_dor_approval_main dm
					LEFT JOIN tb_invoice_main im ON (im.INVID=dm.DORReff and dm.DORType='INV')
					LEFT JOIN vw_sales_executive2 se ON (im.SalesID=se.SalesID)
					LEFT JOIN tb_faktur_number fn ON im.FakturNumberParent=fn.FakturID	
					WHERE dm.DORID=".$DORID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$show['main'] = get_object_vars($rowmain);

		$PriceBefore = 0;
		$TotalFreightCharge = 0;
		$TotalWeightINV = 0;
		$TotalWeightReceived = 0;
		$sql 	= "SELECT dd.DORID, dd.ProductQty as qtyreceived, id.* FROM tb_dor_approval_detail dd
					LEFT JOIN tb_dor_approval_main dm ON dd.DORID=dm.DORID
					LEFT JOIN tb_invoice_main im ON dm.DORReff=im.INVID AND dm.DORType='INV'
					LEFT JOIN tb_invoice_detail id ON id.INVID=im.INVID AND dd.ProductID=id.ProductID
					WHERE dd.DORID=".$DORID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$linetotal = $row->PriceAmount * $row->qtyreceived;
			$PriceBefore += $linetotal;

			$FreightCharge = 0;
			if ($rowmain->FCExclude == 0) { //fc include
				if ($row->FreightCharge > 0) {
					$FreightCharge += ($row->FreightCharge/$row->ProductQty)*$row->qtyreceived;
				}
			}
			$TotalFreightCharge += $FreightCharge;
			$TotalWeightINV += $row->ProductWeight*$row->ProductQty;
			$TotalWeightReceived += $row->ProductWeight*$row->qtyreceived;

		  	$show['detail'][] = array(
		  		'DORID' => $row->DORID,
		  		'qtyreceived' => $row->qtyreceived,
		  		'INVID' => $row->INVID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductQty' => $row->ProductQty,
				'ProductHPP' => $row->ProductHPP,
				'ProductWeight' => $row->ProductWeight,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'PromoPercent' => $row->PromoPercent,
				'PTPercent' => $row->PTPercent,
				'PriceAmount' => $row->PriceAmount,
				'linetotal' => $linetotal,
				'FreightCharge' => $FreightCharge
			);
		};

		$show['main']['PriceBefore'] = $PriceBefore;
		$show['main']['TaxPrice'] = ($PriceBefore/100)*$rowmain->TaxRate;
		$show['main']['TotalPrice'] = $show['main']['PriceBefore']+$show['main']['TaxPrice'];

		$sql 	= "SELECT id.INVID, SUM( id.ProductWeight*id.ProductQty ) AS totalweight
					FROM tb_invoice_detail id WHERE id.INVID=".$rowmain->INVID;
		$getrow	= $this->db->query($sql);
		$rowfc	= $getrow->row();

		$FCExclude = 0;
		if ($rowmain->FCExclude > 0) { //fc exclude
			$FCExclude = ($rowmain->FCExclude/$rowfc->totalweight)*$TotalWeightReceived;
		}

		$show['main']['FCInclude'] = $TotalFreightCharge;
		$show['main']['TaxFC'] = ($TotalFreightCharge/100)*$rowmain->TaxRate;
		$show['main']['FCExclude'] = $FCExclude;
		$show['main']['TotalFC'] = $show['main']['FCInclude']+$show['main']['TaxFC']+$show['main']['FCExclude'];

		$show['main']['TotalInvoiceRetur'] = $show['main']['TotalPrice']+$show['main']['TotalFC'];

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function approve_dor_invr_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$DORID	= $this->input->post('DORID');
		$id 	= $this->input->post('id');
		$user	= $this->get_actor($EmployeeID, "tb_approval_actor", "dor_invr");

		$sql	= "SELECT * FROM tb_approval_dor_invr WHERE ApprovalID = '".$id."'";
		$query	= $this->db->query($sql);
		$row	= $query->row();
		$Approval1	= $row->Actor1;
		$Approval2	= $row->Actor2;
		$Approval3	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";
					
					$this->db->set('DORStatus', 1);
					$this->db->where('DORID', $DORID);
					$this->db->update('tb_dor_approval_main');
					$this->last_query .= "//".$this->db->last_query();
			}
			if (!empty($data)) {
				$this->db->where('ApprovalID',$id);
				$this->db->update('tb_approval_dor_invr',$data);
				$this->last_query .= "//".$this->db->last_query();

			}
		}
		else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('ApprovalID',$id);
				$this->db->update('tb_approval_dor_invr',$data);
				$this->last_query .= "//".$this->db->last_query();

				$this->db->set('DORStatus', 2);
				$this->db->where('DORID', $DORID);
				$this->db->update('tb_dor_approval_main');
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		
		$this->load->model('model_transaction');
		$this->model_transaction->approval_dor_implementation($DORID, 'INV', $id);
		
		$this->log_user->log_query($this->last_query);
		echo json_encode($data);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// approve_price_list===========================================
	function approve_price_list()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user		= $this->get_actor($EmployeeID, "tb_approval_actor", "product_price_list");
		$show['actor'] = $user;

		$sql	= "select * FROM tb_approval_price_list where isComplete=0";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'PricelistID' => $row->PricelistID,
					'Title' => $row->Title,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function price_list_detail()
	{
		$show = array();
		$PricelistID = $this->input->get('pricelist');
		$show['PricelistID'] = $this->input->get('pricelist');
		$show['id'] = $this->input->get('id');
		$ApprovalID = $this->input->get('id');

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user		= $this->get_actor($EmployeeID, "tb_approval_actor", "product_price_list");
		$status		= $this->get_actor_approval($user, "tb_approval_price_list", $show['id']);
		$show['actor'] = $status;

		// --------------------------------------------------------------------------------
			$sql 	= "SELECT plm.*, pcm.PricecategoryName, pcm.PromoDefault
						FROM tb_price_list_main plm
						LEFT JOIN tb_price_category_detail pcd ON plm.PricelistID = pcd.PricelistID
						LEFT JOIN tb_price_category_main pcm ON pcm.PricecategoryID = pcd.PricecategoryID
						WHERE plm.PricelistID = '".$PricelistID."'";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$show['main'] = array(
				'PricelistID' => $PricelistID,
				'PricelistName' => $row->PricelistName,
				'DateStart' => $row->DateStart,
				'DateEnd' => $row->DateEnd,
				'PricelistNote' => $row->PricelistNote,
				'PricecategoryName' => $row->PricecategoryName,
				'PromoDefault' => $row->PromoDefault
			);

			// $sql3 	= "select PricelistID from tb_price_list_detail pld ";
			// $sql3 	.= " where pld.PricelistID = '".$PricelistID."' limit 0,1";
			// $query3 = $this->db->query($sql3);
			// $row3 	= $query3->row();
			
			$sql2 = "SELECT * FROM tb_price_list_detail_approval pld
					LEFT JOIN tb_price_list_main plm on (plm.PricelistID = pld.PricelistID)
					LEFT JOIN tb_product_main p on(p.ProductID = pld.ProductID)
					WHERE pld.PricelistID='".$PricelistID."' AND ApprovalID='".$show['id']."' order by pld.ProductID";
			$query2 = $this->db->query($sql2);

			foreach ($query2->result() as $row2) {
				$PriceAfterCategory = $this->get_min_percent($row2->ProductPriceDefault, $row->PromoDefault);
				$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row2->Promo);
				$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row2->PT1Discount);
				$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row2->PT2Discount);

				$show['detail'][] = array(
					'isApprove' => $row2->isApprove,
					'PricelistID' => $row2->PricelistID,
					'ProductID' => $row2->ProductID,
					'Promo' => $row2->Promo,
					'PT1Discount' => $row2->PT1Discount,
					'PT2Discount' => $row2->PT2Discount,
					'ProductCode' => $row2->ProductCode,
					'ProductPriceDefault' => $row2->ProductPriceDefault,
					'PriceAfterCategory' => $PriceAfterCategory,
					'ProductPricePT1' => $ProductPricePT1,
					'ProductPricePT2' => $ProductPricePT2
				);
			};

		// --------------------------------------------------------------------------------
			$sql = "SELECT plm.*, pcm.PricecategoryName, pcm.PromoDefault
					FROM tb_price_list_main plm
					LEFT JOIN tb_price_category_detail pcd ON plm.PricelistID=pcd.PricelistID
					LEFT JOIN tb_price_category_main pcm ON pcd.PricecategoryID=pcm.PricecategoryID
					WHERE plm.PricelistID='".$PricelistID."' ";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$show['list1']['main'] = array(
				'PricelistID' => $PricelistID,
				'PricelistName' => $row->PricelistName,
				'DateStart' => $row->DateStart,
				'DateEnd' => $row->DateEnd,
				'PricelistNote' => $row->PricelistNote,
				'PricecategoryName' => $row->PricecategoryName,
				'PromoDefault' => $row->PromoDefault,
				'isActive' => ($row->isActive==1) ? 'Active' : 'NotActive' ,
			);

			$sql = "SELECT * FROM tb_price_list_filter_percent WHERE PricelistID='".$PricelistID."' ";
			$query	= $this->db->query($sql);
			$row1	= $query->row();
			$show['list1']['percent'] = array(
				'PricelistID' => $PricelistID,
				'PromoPercent' => (isset($row1->PromoPercent)) ? $row1->PromoPercent : 0,
				'PT1Percent' => (isset($row1->PT1Percent)) ? $row1->PT1Percent : 0,
				'PT2Percent' => (isset($row1->PT2Percent)) ? $row1->PT2Percent : 0,
			);

			$sql2 = "SELECT bc.*, c.ProductCategoryName, b.ProductBrandName
					FROM tb_price_list_brand_category bc
					LEFT JOIN tb_product_category c ON bc.ProductCategoryID=c.ProductCategoryID
					LEFT JOIN tb_product_brand b ON bc.ProductBrandID=b.ProductBrandID
					WHERE bc.PricelistID='".$PricelistID."'";
			$query2 = $this->db->query($sql2);
			foreach ($query2->result() as $row2) {
				$show['list1']['brandcategory'][] = array(
					'PricelistID' => $row2->PricelistID,
					'ProductCategoryID' => $row2->ProductCategoryID,
					'ProductBrandID' => $row2->ProductBrandID,
					'ProductCategoryName' => $row2->ProductCategoryName,
					'ProductBrandName' => $row2->ProductBrandName,
				);
			};

		// --------------------------------------------------------------------------------
			$sql = "SELECT plm.*, pcm.PricecategoryName, pcm.PromoDefault
					FROM tb_price_list_approval_main plm
					LEFT JOIN tb_price_category_detail pcd ON plm.PricelistID=pcd.PricelistID
					LEFT JOIN tb_price_category_main pcm ON pcd.PricecategoryID=pcm.PricecategoryID
					WHERE plm.ApprovalID='".$ApprovalID."' ";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$show['list2']['main'] = array(
				'PricelistID' => $PricelistID,
				'PricelistName' => $row->PricelistName,
				'DateStart' => $row->DateStart,
				'DateEnd' => $row->DateEnd,
				'PricelistNote' => $row->PricelistNote,
				'PricecategoryName' => $row->PricecategoryName,
				'PromoDefault' => $row->PromoDefault,
				'isActive' => ($row->isActive==1) ? 'Active' : 'NotActive' ,
			);

			$sql = "SELECT * FROM tb_price_list_approval_filter_percent WHERE ApprovalID='".$ApprovalID."' ";
			$query	= $this->db->query($sql);
			$row	= $query->row();
			$show['list2']['percent'] = array(
				'PricelistID' => $PricelistID,
				'PromoPercent' => $row->PromoPercent,
				'PT1Percent' => $row->PT1Percent,
				'PT2Percent' => $row->PT2Percent,
			);

			$sql2 = "SELECT bc.*, c.ProductCategoryName, b.ProductBrandName
					FROM tb_price_list_approval_brand_category bc
					LEFT JOIN tb_product_category c ON bc.ProductCategoryID=c.ProductCategoryID
					LEFT JOIN tb_product_brand b ON bc.ProductBrandID=b.ProductBrandID
					WHERE bc.ApprovalID='".$ApprovalID."'";
			$query2 = $this->db->query($sql2);
			foreach ($query2->result() as $row2) {
				$show['list2']['brandcategory'][] = array(
					'PricelistID' => $row2->PricelistID,
					'ProductCategoryID' => $row2->ProductCategoryID,
					'ProductBrandID' => $row2->ProductBrandID,
					'ProductCategoryName' => $row2->ProductCategoryName,
					'ProductBrandName' => $row2->ProductBrandName,
				);
			};

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function approve_price_list_act()
	{
		$this->db->trans_start();
		$ProductIDArr = array();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$ApprovalID = $this->input->post('ApprovalID');
		$PricelistID = $this->input->post('PricelistID');
		$ProductID	= $this->input->post('ProductID');
		$ProductIDArr[] = $this->input->post('ProductID');
		$action 	= $this->input->post('action');
		$ProductID	= (isset($ProductID) ? $this->input->post('ProductID') : array(0));
		$user		= $this->get_actor($EmployeeID, "tb_approval_actor", "product_price_list");

		$sql	= "select * from tb_approval_price_list where ApprovalID = '".$ApprovalID."'";
		$query	= $this->db->query($sql);
		$row	= $query->row();
		$ApprovalID	= $row->ApprovalID;
		$Approval1	= $row->Actor1;
		$Approval2	= $row->Actor2;
		$Approval3	= $row->Actor3;

		switch ($user) {
			case 'Actor1':
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				break;
			case 'Actor2':
				if ($Approval1 == "") {
					$data['Actor1'] = date("Y-m-d H:i:s");
					$data['Actor1ID'] = $EmployeeID;
				}
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				break;
			case 'Actor3':
				if ($Approval1 == "") {
					$data['Actor1'] = date("Y-m-d H:i:s");
					$data['Actor1ID'] = $EmployeeID;
				}
				if ($Approval2 == "") {
					$data['Actor2'] = date("Y-m-d H:i:s");
					$data['Actor2ID'] = $EmployeeID;
				}
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				$data['isComplete'] = "1";
				$data['Status'] = "Approved";

				break;
		}

		if ($action == 'reject') {
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			$isApprove = 0;
		} else {
			$data['Status'] = "Approved";
			$isApprove = 1;
		}

		if (!empty($data)) {
			$this->db->where('ApprovalID', $ApprovalID);
			$this->db->update('tb_approval_price_list', $data);
			$this->last_query .= "//".$this->db->last_query();

			// $this->db->set('isApprove', $isApprove);
			// $this->db->set('ApprovalBy', $EmployeeID);
			// $this->db->where('PricelistID', $PricelistID);
			// $this->db->where('ApprovalID', $ApprovalID);
			// $this->db->where_not_in('ProductID', $ProductID);
			// $this->db->update('tb_price_list_detail_approval');
			// $this->last_query .= "//".$this->db->last_query();
		}
		if ($user == "Actor3") {
			$this->db->set('isApprove', $isApprove);
			$this->db->set('ApprovalBy', $this->session->userdata('UserAccountID'));
			$this->db->where('PricelistID', $PricelistID);
			$this->db->where('ApprovalID', $ApprovalID);
			// $this->db->where_in('ProductID', $ProductID);
			$this->db->update('tb_price_list_detail_approval');
			$this->last_query .= "//".$this->db->last_query();

			$this->load->model('model_master');
			$this->model_master->info_update_price_list($ProductIDArr, 'Promo Piece');

			$this->load->model('model_notification');
			$this->model_notification->insert_notif('notif_price', 'Change Price Default', 'ProductID', $ProductID);

			$this->approve_price_list_implementation($PricelistID, $ApprovalID);
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function approve_price_list_implementation($PricelistID, $ApprovalID)
	{
		$this->db->trans_start();

		$sql	= "INSERT INTO tb_price_list_detail (PricelistID, ProductID, Promo, PT1Discount, PT2Discount)
					SELECT PricelistID, ProductID, Promo, PT1Discount, PT2Discount FROM tb_price_list_detail_approval
					WHERE ApprovalID=".$ApprovalID." AND isApprove=1";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$ProductIDArr = array();
		$sql = "SELECT ProductID FROM tb_price_list_detail_approval
				WHERE ApprovalID=".$ApprovalID." AND isApprove=1";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$ProductIDArr[] = $row->ProductID;
		};
		if (!empty($ProductIDArr)) {
			$this->load->model('model_master');
			$this->model_master->product_promo_history($ProductIDArr);
		}

		$sql = "UPDATE tb_price_list_main t,
				(SELECT * FROM tb_price_list_approval_main
				WHERE ApprovalID=".$ApprovalID." AND PricelistID=".$PricelistID.") t1
				SET
				t.PricelistName = t1.PricelistName,
				t.PricelistNote = t1.PricelistNote,
				t.DateStart = t1.DateStart,
				t.DateEnd = t1.DateEnd,
				t.isActive = t1.isActive
				WHERE t.PricelistID = ".$PricelistID." ";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "SELECT * FROM tb_price_list_filter_percent WHERE PricelistID='".$PricelistID."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (empty($row)) {
			$data = array(
				'PricelistID' => $PricelistID,
				'PromoPercent' => 0,
				'PT1Percent' => 0,
				'PT2Percent' => 0
			);
			$this->db->insert('tb_price_list_filter_percent', $data);
		}
		$sql = "UPDATE tb_price_list_filter_percent t,
				(SELECT * FROM tb_price_list_approval_filter_percent
				WHERE ApprovalID=".$ApprovalID." AND PricelistID=".$PricelistID.") t1
				SET
				t.PricelistID = t1.PricelistID,
				t.PromoPercent = t1.PromoPercent,
				t.PT1Percent = t1.PT1Percent,
				t.PT2Percent = t1.PT2Percent
				WHERE t.PricelistID = ".$PricelistID." ";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('PricelistID', $PricelistID);
		$this->db->delete('tb_price_list_brand_category');
		$this->last_query .= "//".$this->db->last_query();
		$sql = "INSERT INTO tb_price_list_brand_category (PricelistID, ProductCategoryID, ProductBrandID)
				SELECT PricelistID, ProductCategoryID, ProductBrandID
				FROM tb_price_list_approval_brand_category
				WHERE ApprovalID=".$ApprovalID." AND PricelistID=".$PricelistID."";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	
// Price Recommendation ==================================================
	function approve_price_recommendation()
	{

		$sql 	= "SELECT * FROM tb_approval_actor WHERE ApprovalCode = 'price_recommendation'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);

		$sql = "SELECT apr.*, tpr.*, tpm.ProductName, tpm.ProductPriceHPP, tpm.ProductPriceDefault, tvp.cbd, vua.fullname, vps.stock, vpr.Link1, vpr.Link2
				FROM tb_approval_price_recommendation apr
				LEFT JOIN tb_price_recommendation tpr ON apr.RecID=tpr.RecID
				LEFT JOIN tb_product_main tpm ON tpm.ProductID=tpr.ProductID
				LEFT JOIN vw_product_stock vps ON vps.ProductID=tpr.ProductID
				LEFT JOIN vw_price_recommendation_last vpr ON vpr.ProductID=tpr.ProductID
				LEFT JOIN (
					SELECT vpp.ProductID, min(vpp.PricePT2Discount) as cbd
					FROM vw_product_promo_list_active_with_price_no_vol vpp
					GROUP BY vpp.ProductID
				) tvp ON tvp.ProductID=tpm.ProductID
				LEFT JOIN vw_user_account vua ON vua.UserAccountID=tpr.InputBy
				WHERE tpr.isApprove=0 ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
		return $show;
	}
	function approve_price_recommendation_act($val)
	{
		$this->db->trans_start();
		$ProductIDArr = array();

		$UserAccountID = $this->session->userdata('UserAccountID');
		$RecID = $this->input->post('RecID');
		$PriceRec[] = $this->input->post('PriceRec');
		$ProductID[] = $this->input->post('ProductID');
		$ProductIDArr[] = $this->input->post('ProductID');
		$user	= $this->input->post('user');

		$sql	= "SELECT * FROM tb_approval_price_recommendation WHERE RecID = '".$RecID."'";
		// echo $sql;
		$query	= $this->db->query($sql);
		$row	= $query->row();

		$Approval1	= $row->Actor1;
		$Approval2	= $row->Actor2;
		$Approval3	= $row->Actor3;

		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $UserAccountID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $UserAccountID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $UserAccountID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $UserAccountID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $UserAccountID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $UserAccountID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$this->db->set('isApprove', '1');
					$this->db->where('RecID', $RecID);
					$this->db->update('tb_price_recommendation');
					$this->last_query .= "//".$this->db->last_query();

					$this->load->model('model_master');
					$this->model_master->info_update_price_list($ProductIDArr, 'Recommendation');

					$this->load->model('model_notification');
					$this->model_notification->insert_notif('notif_price', 'Change Price Recommendation', 'ProductID', $ProductID);

					$this->db->set('ProductPriceDefault', $PriceRec['0']);
					$this->db->where('ProductID', $ProductID['0']);
					$this->db->update('tb_product_main');
					$this->last_query .= "//".$this->db->last_query();
					// echo json_encode($ProductID['0']);
					$this->model_master->product_price_history($ProductID['0'], '0', '0', $PriceRec['0'], '0');
					break;
			}
			if (!empty($data)){
				$this->db->where('RecID',$RecID);
				$this->db->update('tb_approval_price_recommendation',$data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $UserAccountID;
			$data['isComplete'] = "2";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('RecID',$RecID);
				$this->db->update('tb_approval_price_recommendation',$data);
				$this->last_query .= "//".$this->db->last_query();

				$this->db->set('isApprove', '2');
				$this->db->where('RecID', $RecID);
				$this->db->update('tb_price_recommendation');
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// approve_promo_volume===========================================
	function approve_promo_volume()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "product_promo_volume");
		$show['actor'] = $user;

		$sql 	= "select * FROM tb_approval_promo_volume where isComplete=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'PromoVolID' => $row->PromoVolID,
					'Title' => $row->Title,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function promo_volume_detail()
	{
		$show = array();
		$PromoVolID = $this->input->get('promovolume');
		$show['PromoVolID'] = $this->input->get('promovolume');
		$show['id'] = $this->input->get('id');
		$ApprovalID = $this->input->get('id');

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "product_promo_volume");
		$status		= $this->get_actor_approval($user, "tb_approval_promo_volume", $show['id']);
		$show['actor'] = $status;

		// --------------------------------------------------------------------------------
			$sql 	= "SELECT pv.*, pc.PricecategoryName, pc.PromoDefault FROM tb_price_promo_vol_main pv
						LEFT JOIN tb_price_category_main pc ON (pv.PricecategoryID = pc.PricecategoryID)
						Where PromoVolID=".$PromoVolID;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$show['list1']['main'] = array(
				'PromoVolID' => $row->PromoVolID,
				'PromoVolName' => $row->PromoVolName,
				'PromoVolNote' => $row->PromoVolNote,
				'PricecategoryName' => $row->PricecategoryName,
				'PromoDefault' => $row->PromoDefault,
				'DateStart' => $row->DateStart,
				'DateEnd' => $row->DateEnd,
				'isActive' => ($row->isActive==1) ? 'Active' : 'NotActive' ,
			);

			$sql3 	= "SELECT pvd.*, pm.ProductName, pm.ProductCode, pm.ProductPriceDefault FROM tb_price_promo_vol_detail_approval pvd
						LEFT JOIN tb_product_main pm ON (pvd.ProductID = pm.ProductID)
						WHERE pvd.PromoVolID=".$PromoVolID." AND ApprovalID='".$show['id']."' order by pm.ProductID, pvd.ProductQty";
			$query3 = $this->db->query($sql3);
			$result = $query3->result();
			if (empty($result)) {
				$show['detail'] = array();
			}
			foreach ($query3->result() as $row2) {
				$PriceAfterCategory = $this->get_min_percent($row2->ProductPriceDefault, $row->PromoDefault);
				$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row2->Promo);
				$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row2->PT1Discount);
				$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row2->PT2Discount);
				$show['detail'][] = array(
					'isApprove' => $row2->isApprove,
					'ProductID' => $row2->ProductID,
					'ProductName' => $row2->ProductName,
					'ProductCode' => $row2->ProductCode,
					'ProductQty' => $row2->ProductQty,
					'Promo' => $row2->Promo,
					'PT1Discount' => $row2->PT1Discount,
					'PT2Discount' => $row2->PT2Discount,
					'ProductPriceDefault' => $row2->ProductPriceDefault,
					'PriceAfterCategory' => $PriceAfterCategory,
					'ProductPricePT1' => $ProductPricePT1,
					'ProductPricePT2' => $ProductPricePT2
				);
			};

			$sql = "SELECT * FROM tb_price_promo_vol_filter_percent WHERE PromoVolID='".$PromoVolID."' ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
				$show['list1']['percent'][] = array(
					'PromoVolID' => $row2->PromoVolID,
					'ProductQty' => $row2->ProductQty,
					'PromoPercent' => $row2->PromoPercent,
					'PT1Percent' => $row2->PT1Percent,
					'PT2Percent' => $row2->PT2Percent,
				);
			}

			$sql2 = "SELECT bc.*, c.ProductCategoryName, b.ProductBrandName
					FROM tb_price_promo_vol_brand_category bc
					LEFT JOIN tb_product_category c ON bc.ProductCategoryID=c.ProductCategoryID
					LEFT JOIN tb_product_brand b ON bc.ProductBrandID=b.ProductBrandID
					WHERE bc.PromoVolID='".$PromoVolID."'";
			$query2 = $this->db->query($sql2);
			foreach ($query2->result() as $row2) {
				$show['list1']['brandcategory'][] = array(
					'PromoVolID' => $row2->PromoVolID,
					'ProductCategoryID' => $row2->ProductCategoryID,
					'ProductBrandID' => $row2->ProductBrandID,
					'ProductCategoryName' => $row2->ProductCategoryName,
					'ProductBrandName' => $row2->ProductBrandName,
				);
			};
		// --------------------------------------------------------------------------------
			$sql 	= "SELECT pv.*, pc.PricecategoryName, pc.PromoDefault FROM tb_price_promo_vol_approval_main pv
						LEFT JOIN tb_price_category_main pc ON (pv.PricecategoryID = pc.PricecategoryID)
						Where ApprovalID=".$ApprovalID;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$show['list2']['main'] = array(
				'PromoVolID' => $row->PromoVolID,
				'PromoVolName' => $row->PromoVolName,
				'PromoVolNote' => $row->PromoVolNote,
				'PricecategoryName' => $row->PricecategoryName,
				'PromoDefault' => $row->PromoDefault,
				'DateStart' => $row->DateStart,
				'DateEnd' => $row->DateEnd,
				'isActive' => ($row->isActive==1) ? 'Active' : 'NotActive' ,
			);

			$sql = "SELECT * FROM tb_price_promo_vol_appoval_filter_percent WHERE ApprovalID='".$ApprovalID."' ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
				$show['list2']['percent'][] = array(
					'PromoVolID' => $row2->PromoVolID,
					'ProductQty' => $row2->ProductQty,
					'PromoPercent' => $row2->PromoPercent,
					'PT1Percent' => $row2->PT1Percent,
					'PT2Percent' => $row2->PT2Percent,
				);
			}

			$sql2 = "SELECT bc.*, c.ProductCategoryName, b.ProductBrandName
					FROM tb_price_promo_vol_approval_brand_category bc
					LEFT JOIN tb_product_category c ON bc.ProductCategoryID=c.ProductCategoryID
					LEFT JOIN tb_product_brand b ON bc.ProductBrandID=b.ProductBrandID
					WHERE bc.ApprovalID='".$ApprovalID."'";
			$query2 = $this->db->query($sql2);
			foreach ($query2->result() as $row2) {
				$show['list2']['brandcategory'][] = array(
					'PromoVolID' => $row2->PromoVolID,
					'ProductCategoryID' => $row2->ProductCategoryID,
					'ProductBrandID' => $row2->ProductBrandID,
					'ProductCategoryName' => $row2->ProductCategoryName,
					'ProductBrandName' => $row2->ProductBrandName,
				);
			};

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function approve_promo_volume_act()
	{
		$this->db->trans_start();
		$ProductIDArr = array();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$ApprovalID = $this->input->post('ApprovalID');
		$PromoVolID = $this->input->post('PromoVolID');
		$action 	= $this->input->post('action');
		$ProductID 	= $this->input->post('ProductID');
		$ProductQty = $this->input->post('ProductQty');
		$approve 	= $this->input->post('approve');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "product_promo_volume");
		$ProductIDArr[] = $this->input->post('ProductID');

		$sql 	= "select * from tb_approval_promo_volume where ApprovalID = '".$ApprovalID."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$ApprovalID	= $row->ApprovalID;
		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;

		switch ($user) {
			case 'Actor1':
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				break;
			case 'Actor2':
				if ($Approval1 == "") {
					$data['Actor1'] = date("Y-m-d H:i:s");
					$data['Actor1ID'] = $EmployeeID;
				}
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				break;
			case 'Actor3':
				if ($Approval1 == "") {
					$data['Actor1'] = date("Y-m-d H:i:s");
					$data['Actor1ID'] = $EmployeeID;
				}
				if ($Approval2 == "") {
					$data['Actor2'] = date("Y-m-d H:i:s");
					$data['Actor2ID'] = $EmployeeID;
				}
				$data[$user] = date("Y-m-d H:i:s");
				$data[$user.'ID'] = $EmployeeID;
				$data['isComplete'] = "1";
				$data['Status'] = "Approved";

				break;
		}

		if ($action == 'reject') {
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			$isApprove = 0;
		} else {
			$data['Status'] = "Approved";
			$isApprove = 1;
		}
		
		if (!empty($data)) {
			$this->db->where('ApprovalID', $ApprovalID);
			$this->db->update('tb_approval_promo_volume', $data);
			$this->last_query .= "//".$this->db->last_query();

			// $data_p = array();
			// for ($i=0; $i < count($approve); $i++) {
			// 	if ($approve[$i] == 0) {
			// 		$data_p[] = array(
			// 			'ProductID' => $ProductID[$i],
			// 			'ProductQty' => $ProductQty[$i],
			// 			'PromoVolID' => $PromoVolID,
			// 			'ApprovalID' => $ApprovalID,
			// 			'isApprove' => 0,
			// 			'ApprovalBy' => $EmployeeID,
			// 		);
			// 	}
			// }
			// $this->db->update_batch('tb_price_promo_vol_detail_approval', $data_p, 'ApprovalID, PromoVolID, ProductID, ProductQty');
			// $this->last_query .= "//".$this->db->last_query();

			// for ($i=0; $i < count($approve); $i++) {
			// 	if ($approve[$i] == 0) {
			// 		$this->db->set('isApprove', $isApprove);
			// 		$this->db->set('ApprovalBy', $EmployeeID);
			// 		$this->db->where('PromoVolID', $PromoVolID);
			// 		$this->db->where('ApprovalID', $ApprovalID);
			// 		$this->db->where('ProductID', $ProductID[$i]);
			// 		$this->db->where('ProductQty', $ProductQty[$i]);
			// 		$this->db->update('tb_price_promo_vol_detail_approval');
			// 		$this->last_query .= "//".$this->db->last_query();
			// 	}
			// }
		}

		if ($user == "Actor3") {
			// $data_p = array();
			// for ($i=0; $i < count($approve); $i++) {
			// 	if ($approve[$i] == 1) {
			// 		$data_p[] = array(
			// 			'ProductID' => $ProductID[$i],
			// 			'ProductQty' => $ProductQty[$i],
			// 			'PromoVolID' => $PromoVolID,
			// 			'ApprovalID' => $ApprovalID,
			// 			'isApprove' => 1,
			// 			'ApprovalBy' => $EmployeeID,
			// 		);
			// 	}
			// }
			// $this->db->update_batch('tb_price_promo_vol_detail_approval', $data_p, 'ApprovalID, PromoVolID, ProductID, ProductQty');
			// $this->last_query .= "//".$this->db->last_query();

			$approve = (isset($approve)) ? $approve : array() ;
			for ($i=0; $i < count($approve); $i++) {
				if ($approve[$i] == 1) {
					$this->db->set('isApprove', $isApprove);
					$this->db->set('ApprovalBy', $this->session->userdata('UserAccountID'));
					$this->db->where('PromoVolID', $PromoVolID);
					$this->db->where('ApprovalID', $ApprovalID);
					$this->db->where('ProductID', $ProductID[$i]);
					$this->db->where('ProductQty', $ProductQty[$i]);
					$this->db->update('tb_price_promo_vol_detail_approval');
					$this->last_query .= "//".$this->db->last_query();
				}
			}

			$this->load->model('model_master');
			$this->model_master->info_update_price_list($ProductIDArr, 'Promo Volume');
			
			$this->load->model('model_notification');
			$this->model_notification->insert_notif('notif_price', 'Change Price Default', 'ProductID', $ProductID);

			$this->approve_promo_volume_implementation($PromoVolID,$ApprovalID);
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function approve_promo_volume_implementation($PromoVolID, $ApprovalID)
	{
		$this->db->trans_start();

		$sql	= "INSERT INTO tb_price_promo_vol_detail (PromoVolID, ProductID, ProductQty, Promo, PT1Discount, PT2Discount)
					SELECT PromoVolID, ProductID, ProductQty, Promo, PT1Discount, PT2Discount FROM tb_price_promo_vol_detail_approval
					WHERE ApprovalID=".$ApprovalID." AND isApprove=1";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$ProductIDArr = array();
		$sql = "SELECT PromoVolID, ProductID, ProductQty, Promo, PT1Discount, PT2Discount
				FROM tb_price_promo_vol_detail_approval
				WHERE ApprovalID=".$ApprovalID." AND isApprove=1";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$ProductIDArr[] = $row->ProductID;
		};
		if (!empty($ProductIDArr)) {
			$this->load->model('model_master');
			$this->model_master->product_promo_history($ProductIDArr);
		}

		$sql = "UPDATE tb_price_promo_vol_main t,
				(SELECT * FROM tb_price_promo_vol_approval_main
				WHERE ApprovalID=".$ApprovalID." AND PromoVolID=".$PromoVolID.") t1
				SET
				t.PricecategoryID = t1.PricecategoryID,
				t.PromoVolName = t1.PromoVolName,
				t.PromoVolNote = t1.PromoVolNote,
				t.DateStart = t1.DateStart,
				t.DateEnd = t1.DateEnd,
				t.isActive = t1.isActive
				WHERE t.PromoVolID = ".$PromoVolID." ";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('PromoVolID', $PromoVolID);
		$this->db->delete('tb_price_promo_vol_filter_percent');
		$this->last_query .= "//".$this->db->last_query();
		$sql = "INSERT INTO tb_price_promo_vol_filter_percent (PromoVolID, ProductQty, PromoPercent, PT1Percent, PT2Percent)
				SELECT PromoVolID, ProductQty, PromoPercent, PT1Percent, PT2Percent
				FROM tb_price_promo_vol_appoval_filter_percent
				WHERE ApprovalID=".$ApprovalID." AND PromoVolID=".$PromoVolID."";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('PromoVolID', $PromoVolID);
		$this->db->delete('tb_price_promo_vol_brand_category');
		$this->last_query .= "//".$this->db->last_query();
		$sql = "INSERT INTO tb_price_promo_vol_brand_category (PromoVolID, ProductCategoryID, ProductBrandID)
				SELECT PromoVolID, ProductCategoryID, ProductBrandID
				FROM tb_price_promo_vol_approval_brand_category
				WHERE ApprovalID=".$ApprovalID." AND PromoVolID=".$PromoVolID."";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// approve_po===========================================
	function approve_po()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "purchase_order");
		$show['actor'] = $user;

		$sql 	= "select * FROM tb_approval_po where isComplete=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'POID' => $row->POID,
					'Title' => $row->Title,
					'Note' => $row->Note,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function po_detail()
	{
		$show = array();
		$POID = $this->input->get('POID');
		$show['POID'] = $this->input->get('POID');
		$show['id'] = $this->input->get('id');
		$type = $this->input->get('type');
		$tb_selected = (isset($type) && $type == 'po_expired') ? 'tb_approval_po_expired' : 'tb_approval_po' ;
		$actor_selected = (isset($type) && $type == 'po_expired') ? 'purchase_order_expired' : 'purchase_order' ;

		$sql	= "SELECT pm.* FROM ".$tb_selected." pm WHERE pm.ApprovalID = ".$show['id'];
		$getrow	= $this->db->query($sql);
		$row	= $getrow->row();
		$show['approval'] = (array) $row;

		$EmployeeID = $this->session->userdata('EmployeeID');
		$user		= $this->get_actor($EmployeeID, "tb_approval_actor", $actor_selected);
		$status		= $this->get_actor_approval($user, $tb_selected, $show['id']);
		$show['actor'] = $status;

		$sql	= "SELECT pm.*, wm.*, jc.*, SUM(pp.DORQty) as DORQty, COALESCE(pr.RawSent, 0) as RawSent
					FROM tb_po_main pm
					LEFT JOIN tb_warehouse_main wm ON (	pm.ShippingTo = wm.WarehouseID )
					LEFT JOIN tb_job_company jc ON (pm.BillingTo = jc.CompanyID)
					LEFT JOIN tb_po_product pp ON (pm.POID = pp.POID)
					LEFT JOIN tb_po_raw pr ON (pm.POID = pr.POID)
					WHERE pm.POID = ".$POID;
		$getrow	= $this->db->query($sql);
		$row	= $getrow->row();
		
		$supplier = explode(";", $row->SupplierNote);
		$show['main'] = array(
			'POID' => $row->POID,
			'ROID' => $row->ROID,
			'SupplierID' => $row->SupplierID,
			'suppliername' => $supplier[0],
			'suppliercompany' => $supplier[1],
			'supplieraddr' => $supplier[2],
			'supplierphone' => $supplier[3],
			'supplieremail' => $supplier[4],
			'PODate' => $row->PODate,
			'POLastUpdate' => $row->POLastUpdate,
			'PONote' => $row->PONote,
			'ShippingDate' => $row->ShippingDate,
			'ShippingAlt' => $row->ShippingAlt,
			'POType' => $row->POType,
			'POCurrency' => $row->POCurrency,
			'POCurrencyEx' => $row->POCurrencyEx,
			'ShippingAlt' => $row->ShippingAlt,
			'PaymentTerm' => $row->PaymentTerm,
			'POExpiredNote' => $row->POExpiredNote,
			
			'TaxRate' => $row->TaxRate,
			'TaxAmount' => $row->TaxAmount,
			'PriceBefore' => $row->PriceBefore,
			'TotalPrice' => $row->TotalPrice,

			'TaxAmount2' => $row->TaxAmount2,
			'PriceBefore2' => $row->PriceBefore2,
			'TotalPrice2' => $row->TotalPrice2,

			'CompanyID' => $row->CompanyID,
			'CompanyName' => $row->CompanyName,
			'WarehouseID' => $row->WarehouseID,
			'WarehouseName' => $row->WarehouseName,
			'WarehouseAddress' => $row->WarehouseAddress
		);
		$sql	= "SELECT pp.*, plp.ProductCode, plp.ProductPriceHPP, rp.ProductQty as QtyOrder, rp.total as QtyPurchased
					FROM tb_po_product pp
					LEFT JOIN vw_product_list_popup2 plp ON pp.ProductID = plp.ProductID
					LEFT JOIN tb_po_main pm ON pp.POID = pm.POID
					LEFT JOIN vw_ro_product rp ON pm.ROID = rp.ROID AND pp.ProductID = rp.ProductID
					WHERE pp.POID =".$POID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			$show['product'][] = array(
				'ProductID' => $row2->ProductID,
				'ProductCode' => $row2->ProductCode,
				'ProductSupplierCode' => $row2->ProductSupplierCode,
				'QtyOrder' => $row2->QtyOrder,
				'QtyPurchased' => $row2->QtyPurchased-$row2->ProductQty,
				'ProductQty' => $row2->ProductQty,
				'ProductDisc' => $row2->ProductDisc,
				'ProductPrice' => $row2->ProductPrice,
				'ProductPriceTotal' => $row2->ProductPriceTotal,

				'ProductPrice2' => $row2->ProductPrice2,
				'ProductPriceTotal2' => $row2->ProductPriceTotal2,

				'ProductPriceHPP' => $row2->ProductPriceHPP,
				'Pending' => $row2->Pending,
				'DORQty' => $row2->ProductQty - $row2->Pending
			);
		};

		$sql	= "SELECT pr.*, plp.ProductCode, plp.ProductSupplier, plp.stock, rr.RawQty as QtyOrder
					FROM tb_po_raw pr
					LEFT JOIN tb_po_main pm ON pr.POID = pm.POID
					LEFT JOIN vw_product_list_popup2_gdg_utama plp ON pr.RawID = plp.ProductID
					LEFT JOIN tb_ro_raw rr ON pm.ROID = rr.ROID
					AND pr.ProductID = rr.ProductID
					AND pr.RawID = rr.RawID
					WHERE pr.POID =".$POID;
		$query	= $this->db->query($sql);
		if ($query->num_rows()) {
			foreach ($query->result() as $row3) {
				$show['raw'][$row3->ProductID][] = array(
					'ProductID' => $row3->ProductID,
					'RawID' => $row3->RawID,
					'ProductCode' => $row3->ProductCode,
					'ProductSupplier' => $row3->ProductSupplier,
					'Stock' => $row3->stock,
					'RawQty' => $row3->RawQty,
					'QtyOrder' => $row3->QtyOrder,
					'DOQty' => $row3->RawQty - $row3->Pending
				);
			};
		}
		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function approve_po_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$POID	= $this->input->post('POID');
		$id 	= $this->input->post('id');
		$user	= $this->get_actor($EmployeeID, "tb_approval_actor", "purchase_order");

		$sql	= "SELECT * FROM tb_approval_po WHERE ApprovalID = '".$id."'";
		$query	= $this->db->query($sql);
		$row	= $query->row();
		$Approval1	= $row->Actor1;
		$Approval2	= $row->Actor2;
		$Approval3	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$query = $row->ApprovalQuery;
					$hasil = $this->db->query($query);
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ApprovalID',$id);
				$this->db->update('tb_approval_po',$data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('ApprovalID',$id);
				$this->db->update('tb_approval_po',$data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		
		$this->load->model('model_transaction');
		$this->model_transaction->update_status_po($POID);
		
		$this->log_user->log_query($this->last_query);
		echo json_encode($data);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// approve_po_expired===========================================
	function approve_po_expired()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$user 		= $this->get_actor($EmployeeID, "tb_approval_actor", "purchase_order_expired");
		$show['actor'] = $user;

		$sql 	= "select * FROM tb_approval_po_expired where isComplete=0";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['list'][] = array(
					'ApprovalID' => $row->ApprovalID,
					'POID' => $row->POID,
					'Title' => $row->Title,
					'Note' => $row->Note,
					'Actor1' => $row->Actor1,
					'Actor1ID' => $row->Actor1ID,
					'Actor2' => $row->Actor2,
					'Actor2ID' => $row->Actor2ID,
					'Actor3' => $row->Actor3,
					'Actor3ID' => $row->Actor3ID,
					'isComplete' => $row->isComplete,
					'Status' => $row->Status
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function approve_po_expired_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$POID	= $this->input->post('POID');
		$id 	= $this->input->post('id');
		$user	= $this->get_actor($EmployeeID, "tb_approval_actor", "purchase_order_expired");

		$sql	= "SELECT * FROM tb_approval_po_expired WHERE ApprovalID = '".$id."'";
		$query	= $this->db->query($sql);
		$row	= $query->row();
		$Approval1	= $row->Actor1;
		$Approval2	= $row->Actor2;
		$Approval3	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$query = $row->ApprovalQuery;
					$hasil = $this->db->query($query);
					$this->last_query .= "//".$this->db->last_query();

					// -----------------------------------------------
					$sql 	= "SELECT ROID FROM tb_po_main WHERE POID =".$POID;
					$getrow	= $this->db->query($sql);
					$row 	= $getrow->row();
					$ROID 	= $row->ROID; 

        			$this->load->model('model_transaction');
					$this->model_transaction->update_pending_ro($ROID);
					$this->model_transaction->update_status_ro($ROID);
					$this->model_transaction->update_pending_product_po($POID);
					$this->model_transaction->update_pending_raw_po($POID);
					// ----------------------------------------------

					break;
			}
			if (!empty($data)) {
				$this->db->where('ApprovalID',$id);
				$this->db->update('tb_approval_po_expired',$data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('ApprovalID',$id);
				$this->db->update('tb_approval_po_expired',$data);
				$this->last_query .= "//".$this->db->last_query();
			}
			// ----------------------------------
			$data = array(
				'POExpiredNote' => '',
				'POStatus' => "0"
			);
			$this->db->where('POID', $POID);
			$this->db->update('tb_po_main', $data);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// marketing_activity ==================================================
	function approve_marketing_activity_list()
	{
		$SalesID = array( $this->session->userdata('SalesID'));

		$sql 	= "SELECT *, DATE_FORMAT((NOW() - INTERVAL 1 MONTH), '%Y-%m') AS Month2, 
					DATE_FORMAT((NOW() - INTERVAL 2 MONTH), '%Y-%m') AS Month3,
					DATE_FORMAT((NOW() - INTERVAL 3 MONTH), '%Y-%m') AS Month4
					FROM tb_approval_actor WHERE ApprovalCode = 'marketing_activity'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$Month2 =$row->Month2;
		$Month3 =$row->Month3;
		$Month4 =$row->Month4;
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);
		$sql = "SELECT acc.ApprovalID, acc.Actor1, acc.Actor1ID, acc.Actor2, acc.Actor2ID, acc.Actor3, acc.Actor3ID, ma.*, cm.Company2 as customer, cm.CustomerID as customerid, cm.ContactID,em.Company2 as sales, cm.CityName, cm.CityID, vc2.ShopName, cm.CustomercategoryName, tl.INVDate, COALESCE (bl.InvoiceLama,0) as total2, COALESCE (tl.total, 0) as total, COALESCE (C1.total, 0) as Cuzet1, COALESCE (C2.total, 0) as Cuzet2, COALESCE (C3.total, 0) as Cuzet3, COALESCE (C4.total, 0) as Cuzet4, COALESCE (O1.total, 0) as Omzet1, COALESCE (O2.total, 0) as Omzet2, COALESCE (O3.total, 0) as Omzet3, COALESCE (O4.total, 0) as Omzet4, date_format(A1.ActivityDate,'%Y-%m-%d') as ActivityDateCFU, date_format(A2.ActivityDate,'%Y-%m-%d') as ActivityDateCV, B1.CFU1 AS CFU, B1.CV1 AS CV
				FROM tb_approval_marketing_activity acc
				LEFT JOIN tb_marketing_activity ma ON acc.ActivityID=ma.ActivityID
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=ma.SalesID)
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID=ma.ActivityReffNo)
				LEFT JOIN (
					SELECT ib.CustomerID, MAX(ib.INVDate) As INVDate, sum(ib.INVTotal) as Total, DATEDIFF(NOW(),max(ib.INVDate)) as Last
					FROM vw_invoice_balance ib
					GROUP BY ib.CustomerID
				) tl ON tl.CustomerID=cm.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE MONTH(ib.INVDate) = MONTH(CURRENT_DATE()) AND YEAR(ib.INVDate)=YEAR(CURRENT_DATE())
					GROUP BY ib.CustomerID
				) C1 ON C1.CustomerID=cm.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month2."%'
					GROUP BY ib.CustomerID
				) C2 ON C2.CustomerID=cm.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month3."%'
					GROUP BY ib.CustomerID
				) C3 ON C3.CustomerID=cm.CustomerID
				LEFT JOIN (
					SELECT ib.CustomerID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month4."%'
					GROUP BY ib.CustomerID
				) C4 ON C4.CustomerID=cm.CustomerID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE MONTH(ib.INVDate) = MONTH(CURRENT_DATE()) AND YEAR(ib.INVDate)=YEAR(CURRENT_DATE())
					GROUP BY ib.CityID
				) O1 ON O1.CityID=cm.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month2."%'
					GROUP BY ib.CityID
				) O2 ON O2.CityID=cm.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month3."%'
					GROUP BY ib.CityID
				) O3 ON O3.CityID=cm.CityID
				LEFT JOIN (
					SELECT ib.CityID, SUM( ib.INVTotal ) AS Total
					FROM vw_invoice_balance ib
					WHERE ib.INVDate LIKE '%".$Month4."%'
					GROUP BY ib.CityID
				) O4 ON O4.CityID=cm.CityID
				LEFT JOIN (
					SELECT ActivityReffNo as CustomerID,
					SUM(IF (ActivityType = 'Customer Follow Up (CFU)',1,0)) AS CFU1,
					SUM(IF (ActivityType = 'Customer Visit (CV)',1,0)) AS CV1
					FROM tb_marketing_activity
					WHERE isApprove='1'
					GROUP BY ActivityReffNo
				) B1 ON cm.CustomerID = B1.CustomerID
				LEFT JOIN(
					SELECT ActivityReffNo as CustomerID, max(ActivityDate) AS ActivityDate
					FROM tb_marketing_activity 
					WHERE ActivityType = 'Customer Follow Up (CFU)' AND isApprove='1'
					GROUP BY ActivityReffNo
				) A1 ON cm.CustomerID = A1.CustomerID
				LEFT JOIN(
					SELECT ActivityReffNo as CustomerID, max(ActivityDate) AS ActivityDate
					FROM tb_marketing_activity 
					WHERE ActivityType = 'Customer Visit (CV)' AND isApprove='1'
					GROUP BY ActivityReffNo
				) A2 ON cm.CustomerID = A2.CustomerID
				LEFT JOIN vw_contact2 vc2 ON vc2.ContactID=	cm.ContactID
				LEFT JOIN tb_invoice_bo_lama bl ON cm.CustomerID=bl.CustomerID
				WHERE ma.ActivityReffType='customer' AND ma.isApprove=0 ";

			if ($SalesID[0] !=0){
				$SalesID = $this->get_sales_child($SalesID);
				$sql .= "and ( ma.SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") )";
			}
		$sql.=" ORDER BY cm.CityName asc, ma.ActivityDate Desc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
		return $show;
	}
	function approve_marketing_activity_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$ActivityID = $this->input->post('ActivityID');
		$user 	= $this->input->post('user');

		$sql 	= "select * from tb_approval_marketing_activity where ActivityID = '".$ActivityID."'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";
					
					$this->db->set('isApprove', '1');
					$this->db->where('ActivityID', $ActivityID);
					$this->db->update('tb_marketing_activity');
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ActivityID', $ActivityID);
				$this->db->update('tb_approval_marketing_activity', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		else if ($val == "reject") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "2";
					$data['Status'] = "Rejected";
					
					$this->db->set('isApprove', '2');
					$this->db->where('ActivityID', $ActivityID);
					$this->db->update('tb_marketing_activity');
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ActivityID', $ActivityID);
				$this->db->update('tb_approval_marketing_activity', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function cancel_marketing_activity_list()
	{
		$SalesID = array( $this->session->userdata('SalesID') );
		$Customer = $this->input->get_post('customer');
		$ActivityDate = $this->input->get_post('filterstart');
		$ActivityDate2= $this->input->get_post('filterend');

		$sql 	= "select * FROM tb_approval_actor where ApprovalCode = 'marketing_activity'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);
		if ($ActivityDate && $ActivityDate2 != "") {
			$ActivityDate = date_create($this->input->get_post('filterstart'));
			$ActivityDate2 = date_create($this->input->get_post('filterend'));
			$ActivityDate = date_format($ActivityDate, "Y-m-d");
			$ActivityDate2 = date_format($ActivityDate2, "Y-m-t");

			$sqlINVDate = "AND (ma.ActivityDate between '".$ActivityDate."' AND '".$ActivityDate2."') ";
		} else {
			
			$sqlINVDate = "AND MONTH(ma.ActivityDate)=MONTH(CURRENT_DATE()) AND YEAR(ma.ActivityDate)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT acc.*, ma.*, cm.Company2 as customer, cm.CustomerID as customerid, cm.ContactID,em.Company2 as sales, cm.CityName, cm.CityID, cm.CustomercategoryName
				FROM tb_approval_marketing_activity acc
				LEFT JOIN tb_marketing_activity ma ON acc.ActivityID=ma.ActivityID
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=ma.SalesID)
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID=ma.ActivityReffNo)	
				WHERE ma.ActivityReffType='customer' AND isApprove in (1, 2) ".$sqlINVDate;
		if ($Customer != "") {		
			$sql .= " And cm.Company2 like '%".$Customer."%'";
		}
		$sql .= " order by ma.ActivityID asc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
		return $show;
	}
	function cancel_marketing_activity_act()
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$ActivityID = $this->input->post('ActivityID');
		$user 	= $this->input->post('user');

		$this->db->set('isApprove', '0');
		$this->db->where('ActivityID', $ActivityID);
		$this->db->update('tb_marketing_activity');
		$this->last_query .= "//".$this->db->last_query();

		$this->db->set('isComplete', '0');
		$this->db->set('Status', 'OnProgress');
		$this->db->set('Actor1', NULL);
		$this->db->set('Actor1ID', NULL);
		$this->db->set('Actor2', NULL);
		$this->db->set('Actor2ID', NULL);
		$this->db->set('Actor3', NULL);
		$this->db->set('Actor3ID', NULL);
		$this->db->where('ActivityID', $ActivityID);
		$this->db->update('tb_approval_marketing_activity', $data);
		$this->last_query .= "//".$this->db->last_query();
		// echo ($this->db->last_query());
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// so_complaint ==================================================
	function approve_so_complaint_list()
	{
		$sql 	= "select * FROM tb_approval_actor where ApprovalCode = 'so_complaint'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);

		$sql = "SELECT acc.*, ma.*, cm.Company2 as customer, em.Company2 as sales, CityName
				FROM tb_approval_so_complaint acc
				left join tb_customer_complaint ma ON acc.ComplaintID=ma.ComplaintID
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=ma.SalesID)
				LEFT JOIN vw_customer3 cm ON (cm.CustomerID=ma.CustomerID)
				WHERE ma.isApprove=0 ";
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
		return $show;
	}
	function approve_so_complaint_act($val)
	{
		$this->db->trans_start();

		$EmployeeID = $this->session->userdata('EmployeeID');
		$ComplaintID = $this->input->post('ComplaintID');
		$user 	= $this->input->post('user');

		$sql 	= "select * from tb_approval_so_complaint where ComplaintID = '".$ComplaintID."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";
										
					$this->db->set('isApprove', '1');
					$this->db->set('CloseDate', date("Y-m-d H:i:s"));
					$this->db->where('ComplaintID', $ComplaintID);
					$this->db->update('tb_customer_complaint');
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('ComplaintID', $ComplaintID);
				$this->db->update('tb_approval_so_complaint', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
// employee_overtime ==================================================
	function approve_employee_overtime()
	{
		$show = array();
		$sql 	= "select * FROM tb_approval_actor where ApprovalCode = 'employee_overtime'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);
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
		$sql 	= "SELECT ot.ApprovalID,teo.EmployeeID,tao.OTID, teo.EmployeeID, teo.OverTimeDate, teo.TimeStart, teo.TimeEnd, teo.Job, teo.Qty, ve4.fullname,
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
					"AND tao.isComplete=0";
					// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
	    return $show;
	}
	function approve_employee_overtime_act($val)
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$OTID = $this->input->post('OTID');
		$user 	= $this->input->post('user');

		$sql 	= "select * from tb_approval_overtime where OTID = '".$OTID."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		$Approval1 	= $row->Actor1;
		$Approval2 	= $row->Actor2;
		$Approval3 	= $row->Actor3;
		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					break;
				case 'Actor3':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $EmployeeID;
					}
					if ($Approval2 == "") {
						$data['Actor2'] = date("Y-m-d H:i:s");
						$data['Actor2ID'] = $EmployeeID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $EmployeeID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";
										
					$this->db->set('isApprove', '1');
					// $this->db->set('CloseDate', date("Y-m-d H:i:s"));
					$this->db->where('OTID', $OTID);
					$this->db->update('tb_employee_overtime');
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
			if (!empty($data)) {
				$this->db->where('OTID', $OTID);
				$this->db->update('tb_approval_overtime', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}else if ($val == "reject") {
			$data[$user] = date("Y-m-d H:i:s");
			$data[$user.'ID'] = $EmployeeID;
			$data['isComplete'] = "1";
			$data['Status'] = "Rejected";
			if (!empty($data)) {
				$this->db->where('OTID', $OTID);
				$this->db->update('tb_approval_overtime', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
// ===================================================================
	function get_actor($EmployeeID, $tb_approval, $ApprovalCode)
	{
		$sql 	= "SELECT * FROM ".$tb_approval." where ApprovalCode ='".$ApprovalCode."'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		// $actor = array(
		// 	'Actor1' => $row->Actor1,
		// 	'Actor2' => $row->Actor2,
		// 	'Actor3' => $row->Actor3
		// );
		// $key = array_search($EmployeeID, $actor);
		$key = "";
		if ($row->Actor1 == $EmployeeID) { $key = 'Actor1';}
		if ($row->Actor2 == $EmployeeID) { $key = 'Actor2';}
		if ($row->Actor3 == $EmployeeID) { $key = 'Actor3';}

		$this->log_user->log_query($this->last_query);
		return $key;
	}
	function get_actor_approval($actor, $tb_approval, $ApprovalID)
	{
		$sql 	= "select ".$actor." as actor FROM ".$tb_approval." where ApprovalID ='".$ApprovalID."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$this->log_user->log_query($this->last_query);
		return $row->actor;
	}
	function get_percent($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			if ($num1 > 0) {
				$result = $num2 * ($num1/100);
			} else {
				$result = $num2;
			}
		}
		return $result;
		$this->log_user->log_query($this->last_query);
	}
	function get_min_percent($num1, $num2)
	{
		$result = 0;
		$percent = ($num1/100)*$num2;
		$result = $num1 - $percent;
		return $result;
		$this->log_user->log_query($this->last_query);
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

}
?>