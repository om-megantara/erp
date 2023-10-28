<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_acc extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }

// faktur_inv=======================================================================
    function acc_faktur_inv()
    {
		$show   = array();
        $sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				WHERE im.FakturNumber<>0 ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= " ORDER by im.INVID desc limit ".$this->limit_result."";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'INVID' => $row->INVID,
				'CustomerID' => $row->CustomerID,
				'SalesID' => $row->SalesID,
				'SECID' => $row->SECID,
				'RegionID' => $row->RegionID,
				'BillingAddress' => $row->BillingAddress,
				'ShipAddress' => $row->ShipAddress,
				'TaxAddress' => $row->TaxAddress,
				'NPWP' => $row->NPWP,
				'FakturNumber' => $row->FakturNumber,
				'FCTax' => $row->FCTax,
				'FCInclude' => $row->FCInclude,
				'PriceTax' => $row->PriceTax,
				'PriceTotal' => $row->PriceTotal,
				'INVTotal' => $row->INVTotal,
				'FCExclude' => $row->FCExclude,
				'INVCategory' => $row->INVCategory,
				'INVDate' => $row->INVDate,
				'INVInput' => $row->INVInput,
				'INVBy' => $row->INVBy,
				'customer' => $row->customer,
				'sales' => $row->sales
			);
		};
	    return $show;
    }
    function acc_faktur_inv_retur()
    {
        $sql = "SELECT * FROM vw_invoice_retur_list ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'INVRID' => $row->INVRID,
				'INVID' => $row->INVID,
				'DORID' => $row->DORID,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'NPWP' => $row->NPWP,
				'INVRDate' => $row->INVRDate,
				'INVRNote' => $row->INVRNote,
				'PriceTax' => $row->PriceTax,
				'FCTax' => $row->FCTax,
				'FCExclude' => $row->FCExclude,
				'INVRTotal' => $row->INVRTotal,
				'FakturNumber' => $row->FakturNumber,
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
    }
    function setFakturRetur()
    {
        $this->db->trans_start();

        $INVRID = $this->input->post('invrid');
        // $FakturNumber = $this->input->post('FakturNumber'); 
        $FakturNote = $this->input->post('FakturNote'); 

        // $this->db->set('FakturNumber', $FakturNumber);
        $this->db->set('INVRNote', $FakturNote);
        $this->db->where('INVRID', $INVRID);
        $this->db->update('tb_invoice_retur_main');
        $this->last_query .= "//".$this->db->last_query();
        $this->log_user->log_query($this->last_query);
        $this->db->trans_complete();
	    // return $this->db->trans_status();
    }

// acc_stock_value==================================================================
    function total_stock_value()
    {
    	$sql 	= "SELECT SUM(totalValueStock) as totalValueStock FROM vw_product_list_popup8";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$totalValueStock = $row->totalValueStock;
	    return $totalValueStock;
    }

// acc_account======================================================================
    function acc_account_add()
    {
		$this->db->trans_start();
		$Aname = $this->input->post('Aname');
		$Acode = $this->input->post('Acode');
		$Atype = $this->input->post('Atype');
		$Apotition = $this->input->post('Apotition');
		$company = $this->input->post('company');
		$Aparent = $this->input->post('Aparent');

		$data = array(
			'CompanyID' => $company,
			'AccountCode' => $Acode,
			'AccountName' => $Aname,
			'AccountType' => $Atype,
			'AccountPosition' => $Apotition,
			'AccountParent' => $Aparent,
			'CreatedDate' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('tb_acc_account_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function acc_account_edit()
    {
		$this->db->trans_start();
		$Aid = $this->input->post('Aid');
		$Aname = $this->input->post('Aname');
		$Acode = $this->input->post('Acode');
		$Atype = $this->input->post('Atype');
		$Apotition = $this->input->post('Apotition');
		$company = $this->input->post('company');
		$Aparent = $this->input->post('Aparent');

		if ($Aid != $Aparent) {
			$data = array(
				'CompanyID' => $company,
				'AccountCode' => $Acode,
				'AccountName' => $Aname,
				'AccountType' => $Atype,
				'AccountPosition' => $Apotition,
				'AccountParent' => $Aparent,
			);
			$this->db->where('AccountID', $Aid);
			$this->db->update('tb_acc_account_main', $data);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function acc_account_delete()
    {
		$this->db->trans_start();
		$AccountID = $this->input->get('AccountID');

		$this->db->where('AccountID', $AccountID);
		$this->db->delete('tb_acc_account_main'); 
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		if ($this->db->trans_status() !== FALSE) {
			echo json_encode('success');
		} else {
			echo json_encode('fail');
		}
    }
    function acc_account_detail()
    { 
		$AccountID = $this->input->get('AccountID');
    	$sql = "SELECT * FROM tb_acc_account_main WHERE AccountID=".$AccountID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$main 	= (array) get_object_vars($rowmain);

		if ($this->input->is_ajax_request()) {
			echo json_encode($main);
		} else {
			return $main;
		}
    }
    function acc_account_assignment()
    {
    	$sql = "SELECT wm.WarehouseID, wm.WarehouseName, am.AccountID, am.AccountCode, 
    					am.AccountName, am.AccountAmount, t1.StockValue as RealAmount 
    			FROM tb_warehouse_main wm 
    			left join (
	    			SELECT sm.WarehouseID, SUM(sm.Quantity*pm.ProductPriceHPP) AS StockValue
					FROM tb_product_stock_main sm
					LEFT JOIN tb_product_main pm ON sm.ProductID=pm.ProductID
					GROUP BY sm.WarehouseID
				) t1 on wm.WarehouseID=t1.WarehouseID
    			left join tb_acc_account_main am on am.ReffType='WarehouseID' and am.ReffNo=wm.WarehouseID ORDER BY WarehouseID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['warehouse'][] = array(
				'ReffType' => 'WarehouseID',
				'ReffNo' => $row->WarehouseID,
				'ReffName' => $row->WarehouseName,
				'AccountID' => $row->AccountID,
				'AccountName' => $row->AccountCode.' - '.$row->AccountName,
				'AccountAmount' => $row->AccountAmount,
				'RealAmount' => $row->RealAmount,
			);
		};

		$sql = "SELECT bm.BankID, bm.BankName, am.AccountID, am.AccountCode, 
						am.AccountName, am.AccountAmount, bm.BankBalance as RealAmount
				FROM tb_bank_main bm 
    			left join tb_acc_account_main am on am.ReffType='BankID' and am.ReffNo=bm.BankID ORDER BY BankID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['bank'][] = array(
				'ReffType' => 'BankID',
				'ReffNo' => $row->BankID,
				'ReffName' => $row->BankName,
				'AccountID' => $row->AccountID,
				'AccountName' => $row->AccountCode.' - '.$row->AccountName,
				'AccountAmount' => $row->AccountAmount,
				'RealAmount' => $row->RealAmount,
			);
		};

		// other-------------------------------------------------------------------------
			$assignment_other = array(
								'WarehouseMutation',
								'PurchasingDeposit',
								'DOnotINV',
								'DOnotINVReturn',
								'DOnotINVFree',
								'FreightChargeExpedition',
								'FreightChargeSales',
								'TAXInput',
								'TAXOutput',
								'DOR_INVR',
								'CustomerDeposit',
								'INVunpaid',
								'PurchaseDebt',
								'ValueAdjustment',
								'HPP',
								'Sales');
			foreach ($assignment_other as $key => $list) {
				$sqlSub = '';
				switch ($list) {
					// case 'WarehouseMutation':
					// 	$sqlSub = "SELECT SUM(t1.Qty*pmn.ProductPriceHPP) AS RealAmount
					// 				FROM (
					// 					SELECT pmd.ProductID, (pmd.DOQty-pmd.DORQty) AS Qty
					// 					FROM tb_product_mutation pm
					// 					LEFT JOIN tb_product_mutation_detail pmd ON ( pm.MutationID = pmd.MutationID ) 
					// 					WHERE pm.MutationStatus = 0 AND pmd.StatusOut = 1 
					// 					HAVING Qty>0
					// 				) t1
					// 				LEFT JOIN tb_product_main pmn ON t1.ProductID=pmn.ProductID";
					// 	break;
					// case 'PurchasingDeposit':
					// 	$sqlSub = "SELECT SUM(t1.ProductQty*pm.ProductPriceHPP) AS RealAmount
					// 				FROM (
					// 					SELECT dd.ProductID, dd.ProductQty FROM tb_do_main dm
					// 					LEFT JOIN tb_do_detail dd ON (dm.DOID = dd.DOID)
					// 					WHERE dm.DOType='RAW PO' AND dm.DOReff NOT IN (
					// 						SELECT POID FROM tb_po_product pp WHERE pp.pending=0
					// 					)
					// 				) t1
					// 				LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID";
					// 	break;
					// case 'DOnotINV':
					// 	$sqlSub = "SELECT SUM(dd.PriceAmountReal) AS RealAmount
					// 				FROM (
					// 					SELECT d.DOID, d.DOReff, d.ProductQty, d.PriceAmountReal FROM vw_do_so_detail_price d 
					// 					WHERE d.ProductQty > 0 AND d.PriceAmountReal>0 and d.DOID NOT IN ( SELECT im.DOID FROM tb_invoice_main im )
					// 				) dd";
					// 	break;
					// case 'FreightChargeExpedition':
					// 	$sqlSub = "SELECT SUM(PaymentAmount) AS RealAmount
					// 				FROM tb_fc_payment fp
					// 				WHERE fp.DOID NOT IN (
					// 					SELECT bdd.ReffNo FROM tb_bank_distribution_detail bdd WHERE bdd.ReffType='DO'
					// 				)";
					// 	break;
					// case 'CustomerDeposit':
					// 	$sqlSub = "SELECT SUM(t1.RealAmount) AS RealAmount
					// 				FROM (
					// 					SELECT SUM(BankTransactionAmount) AS RealAmount
					// 					FROM tb_bank_transaction WHERE IsDeposit=1 AND DepositCustomer IS NULL
					// 					UNION ALL
					// 					SELECT SUM(TotalBalance) AS RealAmount
					// 					FROM vw_deposit_balance2
					// 				) t1";
					// 	break;
					// case 'INVunpaid':
					// 	$sqlSub = "SELECT  SUM(t3.CountUnpaid) AS RealAmount FROM ( 
					// 				( 
					// 				SELECT SUM(t1.INVTotal) - SUM(t1.TotalPayment) AS CountUnpaid 
					// 								FROM (
					// 								SELECT im.*, ib.TotalPayment, ib.due_date FROM tb_invoice_main im   
					// 								LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID)  
					// 								WHERE im.INVCategory=1 and ib.TotalPayment < im.INVTotal) t1
					// 				) UNION ALL (
					// 				SELECT SUM(t2.INVTotal) - SUM(t2.TotalPayment) AS CountUnpaid 
					// 								FROM ( SELECT im.*, ib.TotalPayment, ib.due_date 
					// 								FROM tb_invoice_main im 
					// 								LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
					// 								WHERE im.INVCategory=2 and ib.TotalPayment < im.INVTotal ) t2 
					// 				)
					// 				) t3";
					// 	break;
					// case 'PurchaseDebt':
					// 	$sqlSub = "SELECT SUM(pdp.ProductPriceTotal) AS RealAmount 
					// 				FROM vw_po_product_dor_price_main_non_zero pdp
					// 				WHERE pdp.DORID NOT IN (
					// 					SELECT bdd.ReffNo FROM tb_bank_distribution_detail bdd 
					// 					LEFT JOIN tb_bank_distribution_main bdm ON bdd.DistributionID=bdm.DistributionID
					// 					WHERE ReffType='DOR' AND bdm.BankTransactionID<>0
					// 				) ";
					// 	break;
					// case 'DOR_INVR':
					// 	$sqlSub = "SELECT SUM(t2.RealAmount) AS RealAmount
					// 				FROM (
					// 					SELECT t1.DORReff, dd.*, id.ProductHPP*dd.ProductQty AS RealAmount
					// 					FROM ( 
					// 						SELECT dm.DORID, dm.DORReff FROM tb_dor_main dm 
					// 						WHERE dm.DORType='INV' AND dm.DORID not IN (
					// 							SELECT DORID FROM tb_invoice_retur_main
					// 						)
					// 					) t1 
					// 					LEFT JOIN tb_dor_detail dd ON dd.DORID=t1.DORID
					// 					LEFT JOIN tb_invoice_detail id ON t1.DORReff=id.INVID AND dd.ProductID=id.ProductID
					// 				) t2 ";
					// 	break;
					default:
						$RealAmount = 0;
						break;
				}
				if ($sqlSub != '') {
					$query 	= $this->db->query($sqlSub);
					$RealAmount = $query->result_array()[0]['RealAmount'];
				} else {
					$RealAmount = 0;
				}

				$sql = "SELECT ReffType, am.ReffNo, am.AccountID, am.AccountCode, am.AccountName, am.AccountAmount FROM tb_acc_account_main am where am.ReffType='".$list."'";
				$query 	= $this->db->query($sql);
				$result = $query->result();
				if (!empty($result)) {
					foreach ($query->result() as $row) {
						$show['other'][] = array(
							'ReffType' => $row->ReffType,
							'ReffNo' => $row->ReffNo,
							'ReffName' => $list,
							'AccountID' => $row->AccountID,
							'AccountName' => $row->AccountCode.' - '.$row->AccountName,
							'AccountAmount' => $row->AccountAmount,
							'RealAmount' => $RealAmount,
						);
					};
				} else {
					$show['other'][] = array(
						'ReffType' => $list,
						'ReffNo' => 0,
						'ReffName' => $list,
						'AccountID' => null,
						'AccountName' => null,
						'AccountAmount' => 0,
						'RealAmount' => $RealAmount,
					);
				}
			}

		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
    }
    function acc_account_assignment_add()
    {
		$this->db->trans_start();
		$ReffType = $this->input->post('ReffType');
		$ReffNo = $this->input->post('ReffNo');
		$AccountID = $this->input->post('AccountID');

		// RESET----------------------------------------
		$this->db->set('ReffType', null);
		$this->db->set('ReffNo', 0);
		$this->db->update('tb_acc_account_main');


		for ($i=0; $i < count($AccountID);$i++) { 
			if ($AccountID[$i] != '0') {
	   			$data = array(
			        'ReffType' => $ReffType[$i],
			        'ReffNo' => $ReffNo[$i],
				);
				$this->db->where('AccountID', $AccountID[$i]);
				$this->db->update('tb_acc_account_main', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
   		};

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function cek_real_amount()
    {
		$reff = $this->input->get_post('reff');
		$filterdate = $this->input->get_post('filterdate');
		$Month = 0;
		if ($filterdate != "") {
			$Month = date("m", strtotime($filterdate));
		}
		$sqlSub = '';
		switch ($reff) {
			case 'WarehouseMutation':
				$sqlSub = "SELECT COALESCE(SUM(t1.Qty*pmn.ProductPriceHPP),0) AS RealAmount
							FROM (
								SELECT pmd.ProductID, (pmd.DOQty-pmd.DORQty) AS Qty
								FROM tb_product_mutation pm
								LEFT JOIN tb_product_mutation_detail pmd ON ( pm.MutationID = pmd.MutationID ) 
								WHERE pm.MutationStatus = 0 AND pmd.StatusOut = 1 
								HAVING Qty>0
							) t1
							LEFT JOIN tb_product_main pmn ON t1.ProductID=pmn.ProductID";
				break;
			case 'PurchasingDeposit':
				$sqlSub = "SELECT SUM(pr.RawSent*ProductHPP) AS RealAmount
							FROM tb_po_raw pr
							WHERE pr.POID IN (
								SELECT pm.POID FROM tb_po_main pm WHERE pm.POStatus=0
							)";
				break;
			case 'DOnotINV':
				$sqlSub = "SELECT COALESCE(SUM(dd.ProductHPP),0) AS RealAmount
							FROM (
								SELECT d.DOID, d.DOReff, d.ProductQty, d.ProductHPP FROM vw_do_so_detail_price d 
								WHERE d.ProductQty > 0 AND d.ProductHPP>0 and d.DOID NOT IN ( SELECT im.DOID FROM tb_invoice_main im )
							) dd";
				break;
			case 'DOnotINVReturn':
				$sqlSub = "SELECT COALESCE(SUM(dd.ProductHPP*dd.ProductQty),0) AS RealAmount
							FROM (
								SELECT d.DOID, d.DOReff, d.ProductQty, sd.ProductHPP 
								FROM tb_do_detail d
								LEFT JOIN tb_so_detail sd ON d.DOReff=sd.SOID AND d.ProductID=sd.ProductID AND d.SalesOrderDetailID=sd.SalesOrderDetailID 
								WHERE d.DOID in (
									SELECT dm.DOID FROM tb_do_main dm 
									WHERE dm.DOStatus=1 AND dm.DOType='SO' AND dm.DOReff IN (
										SELECT SOID FROM tb_so_main sm WHERE sm.SOCategory IN (4,6)
									)
								) AND d.ProductQty > 0 AND sd.ProductHPP>0 
								AND d.DOID NOT IN ( SELECT im.DOID FROM tb_invoice_main im )
							) dd";
				break;
			case 'DOnotINVFree':
				$sqlMonth = ($Month != 0) ? " AND MONTH(DODate)=".$Month : "" ;
				$sqlSub = "SELECT COALESCE(SUM(dd.ProductHPP*dd.ProductQty),0) AS RealAmount
							FROM (
								SELECT d.DOID, d.DOReff, d.ProductQty, sd.ProductHPP 
								FROM tb_do_detail d
								LEFT JOIN tb_so_detail sd ON d.DOReff=sd.SOID AND d.ProductID=sd.ProductID AND d.SalesOrderDetailID=sd.SalesOrderDetailID 
								WHERE d.DOID in (
									SELECT dm.DOID FROM tb_do_main dm 
									WHERE dm.DOStatus=1 AND YEAR(DODate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
									AND dm.DOType='SO' AND dm.DOReff IN (
										SELECT SOID FROM tb_so_main sm WHERE sm.SOCategory IN (3,5)
									)
								) AND d.ProductQty > 0 AND sd.ProductHPP>0 
								AND d.DOID NOT IN ( SELECT im.DOID FROM tb_invoice_main im )
							) dd";
				break;
			case 'FreightChargeExpedition':
				// total FC payment dalam satu tahun atau bulan
				// dikurangi FC payment yg ditransfer dalam masa tersebut
				$sqlMonth = ($Month != 0) ? " AND MONTH(dm.DODate)=".$Month : "" ;
				$sqlMonth2 = ($Month != 0) ? " AND MONTH(bt.BankTransactionDate)=".$Month : "" ;
				$sqlSub = "SELECT COALESCE(SUM(PaymentAmount),0) AS RealAmount 
							FROM tb_fc_payment fp 
							LEFT JOIN tb_do_main dm ON fp.DOID = dm.DOID 
							WHERE YEAR(dm.DODate)=YEAR(CURRENT_DATE()) ".$sqlMonth." AND fp.DOID NOT IN ( 
								SELECT bdd.ReffNo 
								FROM tb_bank_distribution_detail bdd 
								LEFT JOIN tb_bank_distribution_main bdm ON bdd.DistributionID=bdm.DistributionID 
								LEFT JOIN tb_bank_transaction bt ON bdm.BankTransactionID=bt.BankTransactionID
								WHERE bdd.ReffType='DO' AND bdm.BankTransactionID<>0 
								AND YEAR(bt.BankTransactionDate)=YEAR(CURRENT_DATE()) ".$sqlMonth2." 
							)";
				break;
			case 'FreightChargeSales':
				// total FC exclude dalam satu tahun atau bulan
				// dikurangi FC payment dalam masa tersebut
				$sqlMonth = ($Month != 0) ? " AND MONTH(im.INVDate)=".$Month : "" ;
				$sqlMonth2 = ($Month != 0) ? " AND MONTH(fp.PaymentDate)=".$Month : "" ;
				$sqlSub = "SELECT SUM(RealAmount) AS RealAmount
							FROM (
								SELECT SUM(im.FCExclude) AS RealAmount 
								FROM tb_invoice_main im 
								WHERE YEAR(im.INVDate) = YEAR(CURRENT_DATE()) ".$sqlMonth." 
								UNION ALL
								SELECT SUM(fp.PaymentAmount) *-1 AS RealAmount
								FROM tb_fc_payment fp
								WHERE YEAR(fp.PaymentDate) = YEAR(CURRENT_DATE()) ".$sqlMonth2." 
							) t1";
				break;
			case 'TAXInput':
				// total DOR from PO dalam satu tahun atau bulan 
				$sqlMonth = ($Month != 0) ? " AND MONTH(dm.DORDate)=".$Month : "" ;
				$sqlSub = "SELECT SUM(t1.ProductPriceTotal*(pm.TaxRate/100)) AS RealAmount
							FROM (
								SELECT pp.POID, SUM(dd.ProductQty*pp.ProductPrice) AS ProductPriceTotal
								FROM tb_dor_detail dd
								LEFT JOIN tb_dor_main dm ON dm.DORID=dd.DORID
								LEFT JOIN tb_po_product pp ON dm.DORReff=pp.POID AND dd.ProductID=pp.ProductID
								WHERE YEAR(dm.DORDate)=YEAR(CURRENT_DATE())  ".$sqlMonth." AND dd.DORType='PO'
								GROUP BY dd.DORReff
								HAVING ProductPriceTotal>0
							) t1 
							LEFT JOIN tb_po_main pm ON pm.POID=t1.POID
							WHERE pm.TaxRate>0 ";
				break;
			case 'TAXOutput':
				// total ppn INV dalam satu tahun atau bulan
				// dikurangi ppn INV retur dalam masa tersebut
				$sqlMonth = ($Month != 0) ? " AND MONTH(im.INVDate)=".$Month : "" ;
				$sqlMonth2 = ($Month != 0) ? " AND MONTH(im.INVRDate)=".$Month : "" ;
				$sqlSub = "SELECT SUM(RealAmount) AS RealAmount
							FROM (
								SELECT SUM(im.FCTax+im.PriceTax) AS RealAmount
								FROM tb_invoice_main im
								WHERE im.INVCategory=1 AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
								UNION ALL
								SELECT SUM(im.FCTax+im.PriceTax) *-1 AS RealAmount
								FROM tb_invoice_retur_main im
								WHERE YEAR(im.INVRDate)=YEAR(CURRENT_DATE()) ".$sqlMonth2." 
								UNION ALL
								SELECT SUM(im.INVTotal/11) AS RealAmount
								FROM tb_invoice_main im
								WHERE im.INVCategory=2 AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
							) t1 ";
				break;
			case 'DOR_INVR':
				$sqlMonth = ($Month != 0) ? " AND MONTH(dm.DORDate)=".$Month : "" ;
				$sqlSub = "SELECT COALESCE(SUM(t2.RealAmount),0) AS RealAmount
							FROM (
								SELECT dd.*, id.ProductHPP*dd.ProductQty AS RealAmount
								FROM ( 
									SELECT dm.DORID, dm.DORReff FROM tb_dor_main dm 
									WHERE dm.DORType='INV' AND dm.DORID not IN (
										SELECT DORID FROM tb_invoice_retur_main
									) AND YEAR(dm.DORDate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
								) t1 
								LEFT JOIN tb_dor_detail dd ON dd.DORID=t1.DORID
								LEFT JOIN tb_invoice_detail id ON t1.DORReff=id.INVID AND dd.ProductID=id.ProductID
							) t2 ";
				break;
			case 'CustomerDeposit': 
				$sqlSub = "SELECT COALESCE(SUM(t1.RealAmount),0) AS RealAmount
							FROM (
								SELECT SUM(BankTransactionAmount) AS RealAmount
								FROM tb_bank_transaction WHERE IsDeposit=1 AND DepositCustomer IS NULL
								UNION ALL
								SELECT SUM(TotalBalance+TotalAllocation) AS RealAmount
								FROM vw_deposit_balance2
							) t1";
				break;
			case 'INVunpaid':
				$sqlSub = "SELECT COALESCE(SUM(t3.CountUnpaid),0) AS RealAmount FROM ( 
								( 
									SELECT SUM(t1.INVTotal) - SUM(t1.TotalPayment) AS CountUnpaid 
									FROM (
									SELECT im.*, ib.TotalPayment, ib.due_date FROM tb_invoice_main im   
									LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID)  
									WHERE im.INVCategory=1 and ib.TotalPayment < im.INVTotal) t1
								) UNION ALL (
									SELECT SUM(t2.INVTotal) - SUM(t2.TotalPayment) AS CountUnpaid 
									FROM ( SELECT im.*, ib.TotalPayment, ib.due_date 
									FROM tb_invoice_main im 
									LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
									WHERE im.INVCategory=2 and ib.TotalPayment < im.INVTotal ) t2 
								)
							) t3";
				break;
			case 'PurchaseDebt':
				$sqlSub = "SELECT COALESCE(SUM(pdp.ProductPriceTotal),0) AS RealAmount 
							FROM vw_po_product_dor_price_main_non_zero pdp
							WHERE pdp.DORID NOT IN (
								SELECT bdd.ReffNo FROM tb_bank_distribution_detail bdd 
								LEFT JOIN tb_bank_distribution_main bdm ON bdd.DistributionID=bdm.DistributionID
								WHERE ReffType='DOR' AND bdm.BankTransactionID<>0
							) ";
				break;
			case 'HPP':
				// total HPP (hpp product * qty) INV dalam satu tahun atau bulan
				// dikurangi total HPP INV Retur
				$sqlMonth = ($Month != 0) ? " AND MONTH(im.INVDate)=".$Month : "" ;
				$sqlMonth2 = ($Month != 0) ? " AND MONTH(im.INVRDate)=".$Month : "" ;
				$sqlSub = "SELECT SUM(RealAmount) AS RealAmount
							FROM (
								SELECT SUM(id.ProductHPP * id.ProductQty) AS RealAmount
								FROM tb_invoice_main im
								LEFT JOIN tb_invoice_detail id ON im.INVID=id.INVID
								WHERE YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
								UNION ALL
								SELECT SUM(id.ProductHPP * id.ProductQty) *-1 AS RealAmount
								FROM tb_invoice_retur_main im
								LEFT JOIN tb_invoice_retur_detail id ON im.INVRID=id.INVRID
								WHERE YEAR(im.INVRDate)=YEAR(CURRENT_DATE()) ".$sqlMonth2." 
							) t1 ";
				break;
			case 'Sales':
				// total harga jual ((harga product * qty)+FC include) INV dalam satu tahun atau bulan
				// dikurangi harga jual INV Retur
				$sqlMonth = ($Month != 0) ? " AND MONTH(im.INVDate)=".$Month : "" ;
				$sqlMonth2 = ($Month != 0) ? " AND MONTH(im.INVRDate)=".$Month : "" ;
				$sqlSub = "SELECT SUM(RealAmount) AS RealAmount
							FROM (
								SELECT SUM(im.PriceBeforeTax+im.FCInclude) AS RealAmount
								FROM tb_invoice_main im
								WHERE im.INVCategory=1 AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
								UNION ALL
								SELECT SUM(im.PriceBeforeTax+im.FCInclude) *-1 AS RealAmount
								FROM tb_invoice_retur_main im
								WHERE YEAR(im.INVRDate)=YEAR(CURRENT_DATE()) ".$sqlMonth2." 
								UNION ALL
								SELECT SUM(im.INVTotal/1.1) AS RealAmount
								FROM tb_invoice_main im
								WHERE im.INVCategory=2 AND YEAR(im.INVDate)=YEAR(CURRENT_DATE()) ".$sqlMonth." 
							) t1";
				break;
			default:
				$RealAmount = 0;
				break;
		}
		// echo $sqlSub;
		if ($sqlSub != '') {
			$query 	= $this->db->query($sqlSub);
			$RealAmount = $query->result_array()[0]['RealAmount'];
		} else {
			$RealAmount = 0;
		}
		echo json_encode(number_format($RealAmount,2));
    }

// acc_jurnal=======================================================================
    function acc_journal_add()
    {
		$this->db->trans_start();
		$DateJournal = $this->input->post('DateJournal');
		$Note = $this->input->post('Note');
		$Amount = $this->input->post('Amount');
		$Account = $this->input->post('Account');
		$Type = $this->input->post('Type');
 
 		for ($i=0; $i < count($Account); $i++) { 
			$Jdata = array(
				'AccountID' => $Account[$i],
				'JournalDate' => $DateJournal,
				'JournalNote' => $Note,
				'JournalType' => $Type[$i],
				'JournalAmount' => $Amount[$i],
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => date("Y-m-d H:i:s"),
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($Account[$i], $DateJournal);
 		}


		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	} 
	function acc_journal_list()
	{
		$show   = array();
		$AccountFilter = $this->input->post('AccountFilter');
		$sqlAccountFilter = (isset($AccountFilter) && $AccountFilter != 0) ? "AND aj.AccountID=".$AccountFilter." " : " " ;

		$atributeid = $this->input->post('atributeid');
		$atributevalue = $this->input->post('atributevalue');
		$atributeConn = $this->input->post('atributeConn');
		if (isset($atributeid)) {
			$subQuery = "AND (";
			for ($i = 0; $i < count($atributeid); $i++) {
				switch ($atributeid[$i]) {
					case 'JournalID':
						$subQuery .= "aj.JournalID like '%".$atributevalue[$i]."%' ".$atributeConn[$i]." ";
						break;
					case 'ReffNo':
						$subQuery .= "aj.ReffNo like '%".$atributevalue[$i]."%' ".$atributeConn[$i]." ";
						break;
					case 'SpecificDate':
						$subQuery .= "aj.JournalDate = '".$atributevalue[$i]."' ".$atributeConn[$i]." ";
						break;
					case 'Note':
						$subQuery .= "aj.JournalNote like '%".$atributevalue[$i]."%' ".$atributeConn[$i]." ";
						break;
					case 'Amount':
						$subQuery .= "aj.JournalAmount = ".$atributevalue[$i]." ".$atributeConn[$i]." ";
						break;
					case 'SQL':
						$result = str_replace(',', '","', $atributevalue[$i]);
						$result = str_replace('(', '("', $result);
						$result = str_replace(')', '")', $result);
						$subQuery .= $result." ".$atributeConn[$i]." ";
						break;
					default:
						break;
				} 
			}
			$subQuery = substr($subQuery, 0, -4);
			$subQuery .= ") ";
		} else {
			$subQuery = "";
		}

        $sql = "SELECT aj.*, CONCAT_WS('-', acm.AccountType, acm.AccountCode, acm.AccountName) AS AccountName, 
        		acm.AccountType, em.fullname
				FROM tb_acc_journal aj
				LEFT JOIN tb_acc_account_main acm ON aj.AccountID=acm.AccountID
				LEFT JOIN vw_user_account em ON aj.JournalBy=em.UserAccountID 
				WHERE JournalID IS NOT NULL ";
		$sql .= $subQuery;

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "AND aj.JournalDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} 
		if (isset($_REQUEST['AccountFilter'])) {
			$sql .= $sqlAccountFilter;
		} else { 
			$sql .= "AND (aj.JournalDate >= DATE(NOW()))  ";
		}
		$sql .= "order by JournalDate asc, JournalID asc";
		$query 	= $this->db->query($sql);
		$show	= $query->result_array();
	    return $show;
	}
	function acc_journal_edit()
	{
		$JournalID = $this->input->get('JournalID');
    	$sql = "SELECT * FROM tb_acc_journal WHERE JournalID=".$JournalID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$main 	= (array) get_object_vars($rowmain);

		if ($this->input->is_ajax_request()) {
			echo json_encode($main);
		} else {
			return $main;
		}
	}
	function acc_journal_edit_act()
	{
		$this->db->trans_start();

		$JournalID = $this->input->post('JournalID');
		$JournalDate = $this->input->post('DateJournal');
		$Note = $this->input->post('Note');
		$Amount = $this->input->post('Amount');
		$AccountID = $this->input->post('AccountName');
		$JournalType = $this->input->post('JournalType');

		$sql 	= "SELECT JournalID, AccountID, JournalDate FROM tb_acc_journal WHERE JournalID=".$JournalID."";
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$AccountIDOld = $row->AccountID;
		$JournalDateOld = $row->JournalDate;

			$d1 = new DateTime($JournalDate) ;
			$d2 = new DateTime($JournalDateOld) ;

			$data = array(
				'JournalID' => $JournalID,
				'AccountID' => $AccountID,
				'JournalDate' => $JournalDate,
				'JournalType' => $JournalType,
				'JournalNote' => $Note,
				'JournalAmount' => $Amount,
				'JournalBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->where('JournalID', $JournalID);
			$this->db->update('tb_acc_journal', $data);
			$this->last_query .= "//".$this->db->last_query();

			if ($AccountID == $AccountIDOld) {
				if ($d1 < $d2) {
					$this->arrange_journal_balance($AccountID, $JournalDate);
				} else {
					$this->arrange_journal_balance($AccountID, $JournalDateOld);
				}
			} else { 
				$this->arrange_journal_balance($AccountIDOld, $JournalDateOld);
				$this->arrange_journal_balance($AccountID, $JournalDate);
			}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function acc_journal_recalculate()
	{
		$this->db->trans_start();
		$DateCalculate = $this->input->post('DateCalculate').' 00:00:01';
		$AccountCalculate = $this->input->post('AccountCalculate'); 
		if ($AccountCalculate != 0) {
			$this->arrange_journal_balance($AccountCalculate, $DateCalculate);
		} else {
			$sql 	= "select AccountID from tb_acc_account_main";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$this->arrange_journal_balance($row->AccountID, $DateCalculate);
			};
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function arrange_journal_balance($AccountID, $JournalDate)
	{
		$this->db->trans_start();

		$sql 	= "SELECT JournalBalance, JournalDate FROM tb_acc_journal WHERE AccountID=".$AccountID." order by JournalDate desc, JournalID desc limit 1";
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		if (!empty($row)) {

			$balancenext = 0;
			$sql 	= "SELECT JournalBalance, JournalDate FROM tb_acc_journal WHERE AccountID=".$AccountID." and JournalDate<'".$JournalDate."' order by JournalDate desc, JournalID desc limit 1";
			$getrow	= $this->db->query($sql);
			$row 	= $getrow->row();
			$balancenext = (empty($row)) ? 0 : $row->JournalBalance ;

			$sql = "UPDATE tb_acc_journal r, (
						SELECT t2.JournalID, t2.JournalAmount, t2.JournalBalance, 
							@BalanceResult := (
								IF(t2.JournalType='debit', @BalanceResult+t2.JournalAmount, @BalanceResult-t2.JournalAmount)
							) AS JournalBalanceResult
						FROM ( 
							SELECT t1.* FROM tb_acc_journal t1
							WHERE t1.JournalDate>='".$JournalDate."' AND t1.AccountID = ".$AccountID." 
							ORDER BY t1.JournalDate asc, t1.JournalID asc
						) t2
						JOIN (SELECT @BalanceResult:=".$balancenext."
						) r 
					) r1
					SET r.JournalBalance = r1.JournalBalanceResult
					WHERE r.JournalID = r1.JournalID";
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();

			$sql = "UPDATE tb_acc_account_main t, 
					(SELECT bt.AccountID, bt.JournalBalance
					FROM tb_acc_journal bt WHERE bt.AccountID=".$AccountID." 
					ORDER BY bt.JournalDate DESC, bt.JournalID desc LIMIT 1) t1
					SET t.AccountAmount = t1.JournalBalance
					WHERE t.AccountID = t1.AccountID";
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$sql = "UPDATE tb_acc_account_main t
					SET t.AccountAmount = 0
					WHERE t.AccountID = ".$AccountID;
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();
		}
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function journal_opposite()
	{
        $sql = "SELECT aj.*, CONCAT_WS('-',acm.AccountCode, acm.AccountName) AS AccountName, em.fullname
				FROM tb_acc_journal aj
				LEFT JOIN tb_acc_account_main acm ON aj.AccountID=acm.AccountID
				LEFT JOIN vw_user_account em ON aj.JournalBy=em.UserAccountID 
				WHERE aj.ReffType='distribution' AND aj.JournalID NOT IN (
					SELECT aj2.ReffNo FROM tb_acc_journal aj2 WHERE ReffType='journal'
				) AND aj.ReffNo NOT IN (
					SELECT t1.ReffNo FROM (
						SELECT aj3.ReffNo, COUNT(aj3.ReffNo) AS cReff FROM tb_acc_journal aj3 
						WHERE aj3.ReffType='distribution' GROUP BY aj3.ReffNo HAVING cReff>1
					) t1
				)
				order by JournalDate asc, JournalID asc";
		$query 	= $this->db->query($sql);
		$show   = $query->result_array(); 
	    return $show;
	}
	function journal_opposite_add()
	{
		$this->db->trans_start();
		// echo json_encode($this->input->post());
		$JournalID = $this->input->post('JournalID');
		$DateJournal = $this->input->post('DateJournal');
		$Note = $this->input->post('Note');
		$Type = $this->input->post('Type');
		$Amount = $this->input->post('Amount');
		$Account = $this->input->post('Account');

		$sql 	= "select * from tb_acc_account_main where ReffType='".$ReffType."'";
 
		for ($i=0; $i < count($Account);$i++) {
			$Jdata = array(
				'AccountID' => $Account[$i],
				'ReffType' => 'journal',
				'ReffNo' => $JournalID,
				'JournalDate' => $DateJournal,
				'JournalNote' => $Note,
				'JournalType' => $Type[$i],
				'JournalAmount' => $Amount[$i],
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => date("Y-m-d H:i:s"),
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();
			
			$this->arrange_journal_balance($Account[$i], $DateJournal);
   		}; 
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function journal_delete()
	{
		$this->db->trans_start();
		$JournalID = $this->input->get_post('JournalID');

		$sql 	= "select * from tb_acc_journal where JournalID=".$JournalID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$AccountID = $row->AccountID;
		$JournalID = $row->JournalID;
		$JournalDate = $row->JournalDate;
		$JournalAmount = ($row->JournalAmount == 'debit') ? $row->JournalAmount*-1 : $row->JournalAmount;
		$JournalBalance = $row->JournalBalance;

		$this->db->where('JournalID', $JournalID);
		$this->db->delete('tb_acc_journal');
		$this->last_query .= "//".$this->db->last_query();

		$this->arrange_journal_balance($AccountID, $JournalDate); 
		echo json_encode("success");
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

	// auto journal ----------------------------------
	function cek_account($ReffType, $ReffNo=0)
	{
		$show   = array();
		$sql 	= "select * from tb_acc_account_main where ReffType='".$ReffType."' ";
		if ($ReffNo != 0) {
			$sql .= " and ReffNo=".$ReffNo;
		}
		$query 	= $this->db->query($sql);
		$show	= $query->result_array();
		if (count($show)>0) {
	   		return $show[0];
		} else {
	   		return $show;
		}
	}
	function auto_journal_distribution_transaction($DistributionID, $BankID, $JournalDate, $JournalNote, $JournalType, $JournalAmount)
	{
		$this->db->trans_start();

		$result = $this->cek_account('BankID', $BankID);
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];

			for ($i=0; $i < count($DistributionID); $i++) { 
				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'distribution',
					'ReffNo' => $DistributionID[$i],
					'JournalDate' => $JournalDate[$i],
					'JournalNote' => $JournalNote[$i],
					'JournalType' => $JournalType[$i],
					'JournalAmount' => $JournalAmount[$i],
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => date("Y-m-d H:i:s"),
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();
		  	}

			$sql 		= "select JournalID, JournalDate from tb_acc_journal 
							where ReffType='distribution' and ReffNo in (". implode(',', $DistributionID) .") 
							order by JournalDate asc, JournalID asc limit 1";
			$getJournalIDOld = $this->db->query($sql);
			$row 			= $getJournalIDOld->row();
			$JournalIDOld 	= $row->JournalID;
			$JournalDateOld = $row->JournalDate;
			$this->arrange_journal_balance($AccountID, $JournalDateOld);
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_delete_transaction($DistributionID, $BankID)
	{
		$this->db->trans_start();

		$result = $this->cek_account('BankID', $BankID);
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];

			$sql 		= "select JournalID, JournalDate from tb_acc_journal 
							where ReffType='distribution' and ReffNo in (". implode(',', $DistributionID) .") 
							order by JournalDate asc, JournalID asc limit 1";
			$getJournalIDOld = $this->db->query($sql);
			$row 			= $getJournalIDOld->row();
			if (!empty($row)) {
				$JournalIDOld 	= $row->JournalID;
				$JournalDateOld = $row->JournalDate;

				$sql = "delete from tb_acc_journal 
						where ReffType='journal' and ReffNo in ( 
							select JournalID from (
								select JournalID from tb_acc_journal 
								where ReffType='distribution' and ReffNo in (". implode(',', $DistributionID) .")
							) t1
						)";
				$this->db->query($sql);
				$this->last_query .= "//".$this->db->last_query();

				$this->db->where('ReffType', 'distribution');
				$this->db->where_in('ReffNo', $DistributionID);
				$this->db->delete('tb_acc_journal');
				$this->last_query .= "//".$this->db->last_query();
		   
				$this->arrange_journal_balance($AccountID, $JournalDateOld);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_do($DOID, $type, $id, $WarehouseID, $note, $DOAmount, $DODate, $oppositeAmount=null)
	{
		$this->db->trans_start();
		$ReffType = 'DO';
		$ReffNo = $DOID;
		$JournalDate = $DODate;
		$JournalBy = $this->session->userdata('UserAccountID');
		$InputDate = date("Y-m-d H:i:s");


		$JournalType = ($DOAmount > 0) ? 'credit' : 'debit' ;
		$JournalAmount = abs($DOAmount);
		$result = $this->cek_account('WarehouseID', $WarehouseID);
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$AccountAmount = $result['AccountAmount'];

			if ($JournalAmount != 0) {
				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => $ReffType,
					'ReffNo' => $ReffNo,
					'JournalDate' => $JournalDate,
					'JournalNote' => $note.' DO '.$type.' '.$id,
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $JournalBy,
					'InputDate' => $InputDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		// journal opposite --------------------------------------
		switch ($type) {
			case 'mutation':
				$result = $this->cek_account('WarehouseMutation');
				break;
			case 'po':
				$result = $this->cek_account('PurchasingDeposit');
				break;
			case 'so':
				$result = $this->cek_account('DOnotINV');
				break;
			default:
				$result = array();
				break;
		}
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = ($JournalType == 'debit') ? 'credit' : 'debit' ;
			if (is_null($oppositeAmount)) {
				$oppositeAmount = $DOAmount;
			}
			$JournalAmount = abs($oppositeAmount);

			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => $ReffType,
				'ReffNo' => $ReffNo,
				'JournalDate' => $JournalDate,
				'JournalNote' => $note.' DO '.$type.' '.$id,
				'JournalType' => $JournalType,
				'JournalAmount' => $JournalAmount,
				'JournalBalance' => 0,
				'JournalBy' => $JournalBy,
				'InputDate' => $InputDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);

			// journal deviation -------------------------------------
			if ($oppositeAmount != $DOAmount) {
				$JournalAmount = abs($DOAmount - $oppositeAmount);
				if ($JournalType == 'debit') {
					// kirim barang
					$JournalType = ($DOAmount < $oppositeAmount) ? 'debit' : 'credit' ;
				} else {
					// barang kembali
					$JournalType = ($DOAmount < $oppositeAmount) ? 'credit' : 'debit' ;
				}
				$result = $this->cek_account('ValueAdjustment');
				if (array_key_exists('AccountID', $result)) {
					$AccountID = $result['AccountID'];
					$Jdata = array(
						'AccountID' => $AccountID,
						'ReffType' => $ReffType,
						'ReffNo' => $ReffNo,
						'JournalDate' => $JournalDate,
						'JournalNote' => 'Stock ValueAdjustment '.$note.' DO '.$type.' '.$id,
						'JournalType' => $JournalType,
						'JournalAmount' => $JournalAmount,
						'JournalBalance' => 0,
						'JournalBy' => $JournalBy,
						'InputDate' => $InputDate,
					);
					$this->db->insert('tb_acc_journal', $Jdata);
					$this->last_query .= "//".$this->db->last_query();

					$this->arrange_journal_balance($AccountID, $JournalDate);
				}
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_hpp_changes($ProductID, $Value)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");
		$JournalBy = $this->session->userdata('UserAccountID');
		$InputDate = date("Y-m-d H:i:s");

		$deviationAmount = 0;
		$listWarehouse = array();
		$listValue = array();

		$sql = "select psm.* from tb_product_stock_main psm 
				where psm.ProductID in (". implode(',', $ProductID) .") and psm.Quantity>0
    			ORDER BY WarehouseID ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			if (array_key_exists($row->WarehouseID, $listWarehouse)) {
				$listValue[$row->WarehouseID] += $row->Quantity * $Value[$row->ProductID];
			} else {
				$listWarehouse[$row->WarehouseID] = $row->WarehouseID;
				$listValue[$row->WarehouseID] = $row->Quantity * $Value[$row->ProductID];
			}
		}

    	foreach ($listWarehouse as $key => $valWarehouse) {
    		$result = $this->cek_account('WarehouseID', $valWarehouse);
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$AccountAmount = $result['AccountAmount'];
				$JournalType = ($listValue[$valWarehouse] < 0 ) ? 'credit' : 'debit' ;
				$JournalAmount = abs($listValue[$valWarehouse]);
				$deviationAmount += $listValue[$valWarehouse];

				$Jdata = array(
					'AccountID' => $AccountID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'Stock ValueAdjustment - HPP Changed',
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $JournalBy,
					'InputDate' => $InputDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		};

		// WarehouseMutation ----------------
		$sql = "SELECT SUM(t1.Qty*pmn.ProductPriceHPP) AS RealAmount
				FROM (
					SELECT pmd.ProductID, (pmd.DOQty-pmd.DORQty) AS Qty
					FROM tb_product_mutation pm
					LEFT JOIN tb_product_mutation_detail pmd ON ( pm.MutationID = pmd.MutationID ) 
					WHERE pm.MutationStatus = 0 AND pmd.StatusOut = 1  
					HAVING Qty>0
				) t1
				LEFT JOIN tb_product_main pmn ON t1.ProductID=pmn.ProductID";
		$query 	= $this->db->query($sql);
		$RealAmount = $query->result_array()[0]['RealAmount'];

		$result = $this->cek_account('WarehouseMutation');
		if (array_key_exists('AccountID', $result) && isset($RealAmount)) {
			$AccountID = $result['AccountID'];
			$AccountAmount = $result['AccountAmount'];

			if ($AccountAmount != $RealAmount) {
				if ($AccountAmount < $RealAmount) {
					$JournalAmount = $RealAmount - $AccountAmount;
					$JournalType = 'debit';
				} elseif ($AccountAmount > $RealAmount) {
					$JournalAmount = $AccountAmount - $RealAmount;
					$JournalType = 'credit';
				} 
				$deviationAmount += $JournalAmount;

				$Jdata = array(
					'AccountID' => $AccountID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'Stock ValueAdjustment - HPP Changed',
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $JournalBy,
					'InputDate' => $InputDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($row->AccountID, $JournalDate);
			}
		}

		// ValueAdjustment -------------------------------
		if ($deviationAmount != 0) {
			$result = $this->cek_account('ValueAdjustment');
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$AccountAmount = $result['AccountAmount'];
				$JournalType = ($deviationAmount > 0) ? 'debit' : 'credit' ;
				$JournalAmount = abs($deviationAmount);

				$Jdata = array(
					'AccountID' => $AccountID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'Stock ValueAdjustment - HPP Changed',
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $JournalBy,
					'InputDate' => $InputDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_stock_adjustment($AdjustmentID, $WarehouseID)
	{
		$this->db->trans_start();
		$deviationAmount = 0;
		$sql = "SELECT wm.WarehouseID, wm.WarehouseName, am.AccountID, am.AccountCode, 
    					am.AccountName, am.AccountAmount, t1.StockValue as RealAmount 
    			FROM tb_warehouse_main wm 
    			left join (
	    			SELECT sm.WarehouseID, SUM(sm.Quantity*pm.ProductPriceHPP) AS StockValue
					FROM tb_product_stock_main sm
					LEFT JOIN tb_product_main pm ON sm.ProductID=pm.ProductID
					GROUP BY sm.WarehouseID
				) t1 on wm.WarehouseID=t1.WarehouseID
    			left join tb_acc_account_main am on am.ReffType='WarehouseID' and am.ReffNo=wm.WarehouseID 
    			where wm.WarehouseID = ".$WarehouseID." ORDER BY WarehouseID ";
		// $query 	= $this->db->query($sql);

		$sql = "SELECT SUM(t1.ProductQty*pm.ProductPriceHPP) AS Amount
				FROM tb_product_stock_adjustment_detail t1 
				LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
				WHERE t1.AdjustmentID=".$AdjustmentID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$Amount = $row->Amount;

		$result = $this->cek_account('WarehouseID', $WarehouseID);
		if ($Amount != 0 && array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalAmount = abs($Amount);
			$deviationAmount += $Amount;
			$JournalType = ($Amount > 0) ? 'debit' : 'credit' ;

			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'adjustment',
				'ReffNo' => $AdjustmentID,
				'JournalDate' => date("Y-m-d H:i:s"),
				'JournalNote' => 'Adjustment Stock',
				'JournalType' => $JournalType,
				'JournalAmount' => $JournalAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => date("Y-m-d H:i:s"),
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, date("Y-m-d H:i:s"));
		}

		$result = $this->cek_account('ValueAdjustment');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = ($deviationAmount > 0) ? 'debit' : 'credit' ;
			$deviationAmount = abs($deviationAmount);
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'adjustment',
				'ReffNo' => $AdjustmentID,
				'JournalDate' => date("Y-m-d H:i:s"),
				'JournalNote' => 'Adjustment Stock',
				'JournalType' => $JournalType,
				'JournalAmount' => $deviationAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_insert_customer_deposit($BankTransactionID)
	{
		$this->db->trans_start();

		$result = $this->cek_account('CustomerDeposit');

		$DistributionID = array();
		$JournalDate = array();
		$sql = "SELECT aj.* FROM tb_acc_journal aj
				WHERE aj.ReffType='distribution' AND aj.ReffNo IN (
					SELECT dm.DistributionID FROM tb_bank_distribution_main dm 
					WHERE dm.BankTransactionID IN (". implode(',', $BankTransactionID) .")
				) AND aj.JournalID NOT IN (
					SELECT aj2.ReffNo FROM tb_acc_journal aj2
					WHERE aj2.ReffType='journal' AND aj2.ReffNo IN (
						SELECT aj3.JournalID FROM tb_acc_journal aj3
						WHERE aj3.ReffType='distribution' AND aj3.ReffNo IN (
							SELECT dm.DistributionID FROM tb_bank_distribution_main dm 
							WHERE dm.BankTransactionID IN (". implode(',', $BankTransactionID) .")
						)
					)
				) ";

		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];

			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$DistributionID[] = $row->ReffNo;
				$JournalDate[] = $row->JournalDate;
				$JournalType = 'debit';

		  		$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'journal',
					'ReffNo' => $row->JournalID,
					'JournalDate' => $row->JournalDate,
					'JournalNote' => $row->JournalNote,
					'JournalType' => $JournalType,
					'JournalAmount' => $row->JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => date("Y-m-d H:i:s"),
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();
		  	}
		};

	  	if (count($JournalDate)>0) {

			usort($JournalDate, function($a, $b) {
			    $dateTimestamp1 = strtotime($a);
			    $dateTimestamp2 = strtotime($b);

			    return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
			});

			$this->arrange_journal_balance($AccountID, $JournalDate[0]);
	  	}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		return $DistributionID;
	}
	function auto_journal_cancel_customer_deposit($BankTransactionID)
	{ 
		$this->db->trans_start();

		$sql = "SELECT AccountID FROM tb_acc_account_main where ReffType='BankID' and ReffNo in (
					SELECT BankID FROM tb_bank_distribution_main dm
					LEFT JOIN tb_bank_distribution_type dt ON dm.DistributionTypeID=dt.DistributionTypeID
					WHERE dm.BankTransactionID IN (". implode(',', $BankTransactionID) .")
				)";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if ($query->num_rows()>0) {
			$sql = "SELECT MIN(aj3.JournalDate) AS JournalDate, aj3.AccountID FROM tb_acc_journal aj3
					WHERE aj3.ReffType='distribution' AND aj3.ReffNo IN (
						SELECT dm.DistributionID FROM tb_bank_distribution_main dm 
						WHERE dm.BankTransactionID IN (". implode(',', $BankTransactionID) .")
					)  ";
			$query = $this->db->query($sql);
			$row 	= $query->row();
			$AccountID	= $row->AccountID;
			$JournalDate = $row->JournalDate;
			if ($AccountID != '') {

				$sql = "DELETE FROM tb_acc_journal
						WHERE ReffType='journal' AND ReffNo IN (
							SELECT t.JournalID FROM (
								SELECT aj3.JournalID FROM tb_acc_journal aj3
								WHERE aj3.ReffType='distribution' AND aj3.ReffNo IN (
									SELECT dm.DistributionID FROM tb_bank_distribution_main dm 
									WHERE dm.BankTransactionID IN (". implode(',', $BankTransactionID) .")
								) 
							) AS t
						)";
				$this->db->query($sql);
				$this->last_query .= "//".$this->db->last_query();
				
				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function auto_journal_insert_customer_payment($INVID, $PaymentAmount)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");
		if ($PaymentAmount != 0) {
			$result = $this->cek_account('CustomerDeposit');
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$JournalType = 'credit';
		  		$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'INV',
					'ReffNo' => $INVID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'pembayaran INV '.$INVID,
					'JournalType' => $JournalType,
					'JournalAmount' => $PaymentAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => date("Y-m-d H:i:s"),
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate[0]);
		  	};
	 
			$result = $this->cek_account('INVunpaid');
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$JournalType = 'credit';
		  		$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'INV',
					'ReffNo' => $INVID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'pembayaran INV '.$INVID,
					'JournalType' => $JournalType,
					'JournalAmount' => $PaymentAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => date("Y-m-d H:i:s"),
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate[0]);
		  	};
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_cancel_customer_payment($INVID, $ReturAmount)
	{ 
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");
		
		$result = $this->cek_account('CustomerDeposit');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
	  		$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INV',
				'ReffNo' => $INVID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'pembayaran INV '.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $ReturAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => date("Y-m-d H:i:s"),
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate[0]);
	  	};
 
		$result = $this->cek_account('INVunpaid');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
	  		$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INV',
				'ReffNo' => $INVID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'pembayaran INV '.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $ReturAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => date("Y-m-d H:i:s"),
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate[0]);
	  	};

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_po_complete($POID, $RAWAmount=0)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");

		$result = $this->cek_account('PurchasingDeposit');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'PO',
				'ReffNo' => $POID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'Complete PO '.$POID,
				'JournalType' => 'credit',
				'JournalAmount' => $RAWAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}

		$result = $this->cek_account('ValueAdjustment');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'PO',
				'ReffNo' => $POID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'Complete PO '.$POID,
				'JournalType' => 'credit',
				'JournalAmount' => $RAWAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_do_complete($DOID, $note, $Amount, $SOCategory)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");

		if ($Amount > 0) {
			$result = $this->cek_account('DOnotINV');
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$JournalAmount = $Amount;
				$JournalType = 'credit';
				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DO',
					'ReffNo' => $DOID,
					'JournalDate' => $JournalDate,
					'JournalNote' => $note,
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
			
			if ( in_array($SOCategory, array(4,6)) ) {
				$result = $this->cek_account('DOnotINVReturn');
				if (array_key_exists('AccountID', $result)) {
					$AccountID = $result['AccountID'];
					$JournalType = 'debit';
					$Jdata = array(
						'AccountID' => $AccountID,
						'ReffType' => 'DO',
						'ReffNo' => $DOID,
						'JournalDate' => $JournalDate,
						'JournalNote' => $note,
						'JournalType' => $JournalType,
						'JournalAmount' => $JournalAmount,
						'JournalBalance' => 0,
						'JournalBy' => $this->session->userdata('UserAccountID'),
						'InputDate' => $JournalDate,
					);
					$this->db->insert('tb_acc_journal', $Jdata);
					$this->last_query .= "//".$this->db->last_query();

					$this->arrange_journal_balance($AccountID, $JournalDate);
				}
			} elseif ( in_array($SOCategory, array(3,5)) ) {
				$result = $this->cek_account('DOnotINVFree');
				if (array_key_exists('AccountID', $result)) {
					$AccountID = $result['AccountID'];
					$JournalType = 'debit';
					$Jdata = array(
						'AccountID' => $AccountID,
						'ReffType' => 'DO',
						'ReffNo' => $DOID,
						'JournalDate' => $JournalDate,
						'JournalNote' => $note,
						'JournalType' => $JournalType,
						'JournalAmount' => $JournalAmount,
						'JournalBalance' => 0,
						'JournalBy' => $this->session->userdata('UserAccountID'),
						'InputDate' => $JournalDate,
					);
					$this->db->insert('tb_acc_journal', $Jdata);
					$this->last_query .= "//".$this->db->last_query();

					$this->arrange_journal_balance($AccountID, $JournalDate);
				}
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_do_fc($DOID, $ReffType, $ReffNo, $Amount)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");
 
		$result = $this->cek_account('FreightChargeExpedition');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalAmount = $Amount;
			$JournalType = 'debit';

			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DO',
				'ReffNo' => $DOID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'FC '.$ReffType.' '.$ReffNo,
				'JournalType' => $JournalType,
				'JournalAmount' => $JournalAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}

		$result = $this->cek_account('FreightChargeSales');
		if (array_key_exists('AccountID', $result)) {
			if ($ReffType == 'SO') {
				$AccountID = $result['AccountID'];
				$JournalAmount = $Amount;
				$JournalType = 'credit';

				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DO',
					'ReffNo' => $DOID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'FC '.$ReffType.' '.$ReffNo,
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_dor_mutation($DORID, $WarehouseID, $MutationID)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");
		$JournalAmount = 0;

		$result = $this->cek_account('WarehouseMutation');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$AccountAmount = $result['AccountAmount'];

			$sql = "SELECT SUM(t1.Qty*pmn.ProductPriceHPP) AS RealAmount
					FROM (
						SELECT pmd.ProductID, (pmd.DOQty-pmd.DORQty) AS Qty
						FROM tb_product_mutation pm
						LEFT JOIN tb_product_mutation_detail pmd ON ( pm.MutationID = pmd.MutationID ) 
						WHERE pm.MutationStatus = 0 AND pmd.StatusOut = 1 
						HAVING Qty>0
					) t1
					LEFT JOIN tb_product_main pmn ON t1.ProductID=pmn.ProductID";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$RealAmount = $row->RealAmount;

			if ($AccountAmount != $RealAmount) {
				$JournalType = 'credit';
				$JournalAmount = $AccountAmount - $RealAmount;

				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DOR',
					'ReffNo' => $DORID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'DOR Mutation '.$MutationID,
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$result = $this->cek_account('WarehouseID', $WarehouseID);
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];

			if ($JournalAmount != 0) {
				$JournalType = 'debit';
				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DOR',
					'ReffNo' => $DORID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'DOR Mutation '.$MutationID,
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_dor_po($DORID, $WarehouseID, $POID, $DORAmount=0, $TaxPercent=0, $WarehouseAmount=0)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s"); 
		$TaxAmount = 0;

		$result = $this->cek_account('WarehouseID', $WarehouseID);
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';

			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DOR',
				'ReffNo' => $DORID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'DOR PO '.$POID,
				'JournalType' => $JournalType,
				'JournalAmount' => $WarehouseAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}

		$result = $this->cek_account('PurchaseDebt');
		if (array_key_exists('AccountID', $result)) {
			if ($DORAmount > 0) {
				$AccountID = $result['AccountID'];
				$JournalType = 'debit';

				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DOR',
					'ReffNo' => $DORID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'DOR PO '.$POID,
					'JournalType' => $JournalType,
					'JournalAmount' => $DORAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$result = $this->cek_account('TAXInput');
		if (array_key_exists('AccountID', $result)) {
			if ($TaxPercent > 0 && $DORAmount > 0) {
				$AccountID = $result['AccountID'];
				$JournalType = 'debit';
				$TaxAmount = ($DORAmount/(100+$TaxPercent))*$TaxPercent;

				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DOR',
					'ReffNo' => $DORID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'TAX Input - DOR PO '.$POID,
					'JournalType' => $JournalType,
					'JournalAmount' => $TaxAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$result = $this->cek_account('ValueAdjustment');
		if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$JournalAmount = $WarehouseAmount - ($DORAmount - $TaxAmount);
				$JournalType = ($JournalAmount<0) ? 'credit' : 'debit' ;
				$JournalAmount = abs($JournalAmount);

				if ($JournalAmount != 0) {
					$Jdata = array(
						'AccountID' => $AccountID,
						'ReffType' => 'DOR',
						'ReffNo' => $DORID,
						'JournalDate' => $JournalDate,
						'JournalNote' => 'ValueAdjustment - DOR PO '.$POID,
						'JournalType' => $JournalType,
						'JournalAmount' => $JournalAmount,
						'JournalBalance' => 0,
						'JournalBy' => $this->session->userdata('UserAccountID'),
						'InputDate' => $JournalDate,
					);
					$this->db->insert('tb_acc_journal', $Jdata);
					$this->last_query .= "//".$this->db->last_query();

					$this->arrange_journal_balance($AccountID, $JournalDate);
				}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_dor_inv($DORID, $WarehouseID, $DORAmount, $WarehouseAmount=0)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");

		$result = $this->cek_account('WarehouseID', $WarehouseID);
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID']; 
			$JournalType = 'debit';
			$JournalAmount = $WarehouseAmount;

			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DOR',
				'ReffNo' => $DORID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'DOR Retur INV '.$DORID,
				'JournalType' => $JournalType,
				'JournalAmount' => $JournalAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}

		$result = $this->cek_account('DOR_INVR');
		if (array_key_exists('AccountID', $result)) {
			if ($DORAmount > 0) {
				$AccountID = $result['AccountID'];
				$AccountAmount = $result['AccountAmount'];
				$JournalType = 'debit';

				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DOR',
					'ReffNo' => $DORID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'DOR Retur INV '.$DORID,
					'JournalType' => $JournalType,
					'JournalAmount' => $DORAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		// journal deviation -------------------------------------
		if ($JournalAmount != $DORAmount) {
			$deviationAmount = abs($DORAmount - $JournalAmount);
			if ($DORAmount < $JournalAmount) {
				$JournalType = ($DORAmount < $JournalAmount) ? 'debit' : 'credit' ;
			} 

			$result = $this->cek_account('ValueAdjustment');
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];

				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'DOR',
					'ReffNo' => $DORID,
					'JournalDate' => date("Y-m-d H:i:s"),
					'JournalNote' => 'Stock ValueAdjustment DOR Retur INV '.$DORID,
					'JournalType' => $JournalType,
					'JournalAmount' => $deviationAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_invr($INVRID, $DORID, $INVRAMount, $TaxAmount, $FCAmount, $DORAmount)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");

		$result = $this->cek_account('CustomerDeposit');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INVR',
				'ReffNo' => $INVRID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INVR '.$INVRID,
				'JournalType' => $JournalType,
				'JournalAmount' => $INVRAMount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('TAXOutput');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'credit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INVR',
				'ReffNo' => $INVRID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input TAX INVR '.$INVRID,
				'JournalType' => $JournalType,
				'JournalAmount' => $TaxAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('FreightChargeSales');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'credit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INVR',
				'ReffNo' => $INVRID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input FC INVR '.$INVRID,
				'JournalType' => $JournalType,
				'JournalAmount' => $FCAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('Sales');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
			$ProfitAmount = $INVRAMount - $TaxAmount - $FCAmount;
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INV',
				'ReffNo' => $INVID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INV'.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $ProfitAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		} 


		$result = $this->cek_account('DOR_INVR');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'credit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DORID',
				'ReffNo' => $DORID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INVR '.$INVRID,
				'JournalType' => $JournalType,
				'JournalAmount' => $DORAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('HPP');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'credit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DO',
				'ReffNo' => $DOID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INVR '.$INVRID,
				'JournalType' => $JournalType,
				'JournalAmount' => $DORAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_inv($INVID, $DOID, $INVAMount, $TaxAmount, $FCAmount, $DOAmount)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");

		$result = $this->cek_account('INVunpaid');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INV',
				'ReffNo' => $INVID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INV'.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $INVAMount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('TAXOutput');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INV',
				'ReffNo' => $INVID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input TAX INV'.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $TaxAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('FreightChargeSales');
		if (array_key_exists('AccountID', $result)) {
			if ($FCAmount > 0) {
				$AccountID = $result['AccountID'];
				$JournalType = 'debit';
				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'INV',
					'ReffNo' => $INVID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'input FC INV'.$INVID,
					'JournalType' => $JournalType,
					'JournalAmount' => $FCAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}
		$result = $this->cek_account('Sales');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
			$ProfitAmount = $INVAMount - $TaxAmount - $FCAmount;
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'INV',
				'ReffNo' => $INVID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INV'.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $ProfitAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}


		$result = $this->cek_account('DOnotINV');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'credit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DO',
				'ReffNo' => $DOID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INV'.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $DOAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
		$result = $this->cek_account('HPP');
		if (array_key_exists('AccountID', $result)) {
			$AccountID = $result['AccountID'];
			$JournalType = 'debit';
			$Jdata = array(
				'AccountID' => $AccountID,
				'ReffType' => 'DO',
				'ReffNo' => $DOID,
				'JournalDate' => $JournalDate,
				'JournalNote' => 'input INV'.$INVID,
				'JournalType' => $JournalType,
				'JournalAmount' => $DOAmount,
				'JournalBalance' => 0,
				'JournalBy' => $this->session->userdata('UserAccountID'),
				'InputDate' => $JournalDate,
			);
			$this->db->insert('tb_acc_journal', $Jdata);
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_journal_balance($AccountID, $JournalDate);
		}
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function auto_journal_retur_deposit($CustomerName, $ReturID, $DistributionID, $Amount)
	{
		$this->db->trans_start();
		$JournalDate = date("Y-m-d H:i:s");

		if ($Amount > 0) {
			$result = $this->cek_account('CustomerDeposit');
			if (array_key_exists('AccountID', $result)) {
				$AccountID = $result['AccountID'];
				$JournalAmount = $Amount;
				$JournalType = 'credit';
				$Jdata = array(
					'AccountID' => $AccountID,
					'ReffType' => 'distribution',
					'ReffNo' => $DistributionID,
					'JournalDate' => $JournalDate,
					'JournalNote' => 'Retur '.$ReturID.' :'.$CustomerName,
					'JournalType' => $JournalType,
					'JournalAmount' => $JournalAmount,
					'JournalBalance' => 0,
					'JournalBy' => $this->session->userdata('UserAccountID'),
					'InputDate' => $JournalDate,
				);
				$this->db->insert('tb_acc_journal', $Jdata);
				$this->last_query .= "//".$this->db->last_query();

				$this->arrange_journal_balance($AccountID, $JournalDate);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

// report===========================================================================
	function report_balance($parent = 0, $spacing = 1, $account_tree_array = array())
	{
		$sql 	= "select AccountID, AccountCode, AccountName, AccountParent, AccountType, AccountAmount from tb_acc_account_main where AccountParent = ".$parent." ORDER by AccountID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$allChild = $this->get_full_account_child_id($row->AccountID);
				$DateFilter = isset($_REQUEST['datestart']) ? date('Y-m-t', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
				// $sql = "SELECT t11.AccountID, SUM(t12.JournalBalance) AS AccountAmount
				// 		FROM tb_acc_account_main t11
				// 		LEFT JOIN (
				// 			SELECT t1.AccountID, t1.JournalBalance, t1.JournalDate
				// 			FROM tb_acc_journal t1
				// 			JOIN (
				// 				SELECT MAX(JournalDate) AS JournalDate, AccountID FROM tb_acc_journal 
				// 				WHERE JournalDate<='".$DateFilter." 23:59:59' 
				// 				AND AccountID in (".implode(',',$allChild).") GROUP BY AccountID
				// 			) t2 on t1.AccountID=t2.AccountID AND t1.JournalDate=t2.JournalDate
				// 		) t12 ON t11.AccountID=t12.AccountID
				// 		where t11.AccountID in (".implode(',',$allChild).")";
				// $getrow = $this->db->query($sql);
				// $row2 	= $getrow->row();
				// $AccountAmount2 = $row2->AccountAmount;

				// $sql = "SELECT t11.AccountID, t12.JournalBalance AS AccountAmount
				// 		FROM tb_acc_account_main t11
				// 		LEFT JOIN (
				// 			SELECT t1.AccountID, t1.JournalBalance, t1.JournalDate
				// 			FROM tb_acc_journal t1
				// 			JOIN (
				// 				SELECT MAX(JournalDate) AS JournalDate, AccountID FROM tb_acc_journal 
				// 				WHERE JournalDate<='".$DateFilter." 23:59:59' 
				// 				AND AccountID=".$row->AccountID." GROUP BY AccountID
				// 			) t2 on t1.AccountID=t2.AccountID AND t1.JournalDate=t2.JournalDate
				// 		) t12 ON t11.AccountID=t12.AccountID
				// 		where t11.AccountID=".$row->AccountID."";
				// $getrow = $this->db->query($sql);
				// $row3 	= $getrow->row();
				// $AccountAmount3 = $row3->AccountAmount;

				$sql = "SELECT t11.AccountID, 
						SUM( if(t11.AccountType='credit', t11.AccountAmount*(-1), t11.AccountAmount) ) AS AccountAmount
						FROM tb_acc_account_main t11 
						where t11.AccountID in (".implode(',',$allChild).")";
				$getrow = $this->db->query($sql);
				$row4 	= $getrow->row();
				$AccountAmount4 = $row4->AccountAmount;
				if ($AccountAmount4 != 0 or $row->AccountParent == 0) {
					$account_tree_array[] = array(
						'AccountID' => $row->AccountID, 
						'AccountCode' => $row->AccountCode, 
						'AccountName' => $row->AccountName, 
						'AccountAmount' => $row->AccountAmount, 
						'AccountType' => $row->AccountType, 
						// 'AccountAmount2' => $AccountAmount2, 
						// 'AccountAmount3' => $AccountAmount3, 
						'AccountAmount4' => $AccountAmount4, 
						'ChildCount' => count($allChild),
						'Spacing' => $spacing,
					);
		      		$account_tree_array = $this->report_balance($row->AccountID, $spacing+1, $account_tree_array);
			    }
			}
		}
		return $account_tree_array;
	}
	function report_formula()
	{
		$show   = array();
        $sql = "SELECT * FROM tb_acc_report_main ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'ReportID' => $row->ReportID,
				'ReportName' => $row->ReportName, 
				'ReportType' => $row->ReportType, 
			);
		};
	    return $show;
	}
	function report_formula_add_act()
	{
		$this->db->trans_start();
		$FormulaName = $this->input->post('FormulaName');
		$AccountList = $this->input->post('AccountList');
		$AccountID = $this->input->post('AccountID');
		$atributeConn = $this->input->post('atributeConn');
		$AccountName = $this->input->post('AccountName');

		$this->db->set('ReportName', $FormulaName);
		$this->db->insert('tb_acc_report_main');
		$this->log_user->log_query($this->last_query);

		$sql 		= "select max(ReportID) as ReportID from tb_acc_report_main ";
		$getReportID = $this->db->query($sql);
		$row 		= $getReportID->row();
		$ReportID 	= $row->ReportID;

   		for ($i=0; $i < count($AccountID);$i++) { 
   			$data_formula = array(
				'ReportID' => $ReportID,
				'OrderNo' => $i,
				'AccountID' => $AccountID[$i],
				'AccountType' => $atributeConn[$i],
				'Note' => $AccountName[$i], 
			);
			$this->db->insert('tb_acc_report_detail', $data_formula);
			$this->last_query .= "//".$this->db->last_query();
   		};

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function report_formula_edit()
	{
		$ReportID = $this->input->get('report');
		$sql 	= "SELECT rd.*, am.AccountCode, am.AccountName from tb_acc_report_detail rd
					left join tb_acc_account_main am on am.AccountID = rd.AccountID
					where ReportID = ".$ReportID." order by OrderNo";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			$Note = ($row2->AccountID == 0) ? $row2->Note : $row2->AccountCode.' - '.$row2->AccountName ;
			  	$detail[] = array( 
					'ReportID' => $row2->ReportID,
					'OrderNo' => $row2->OrderNo,
					'AccountID' => $row2->AccountID,
					'AccountCode' => $row2->AccountCode,
					'AccountType' => $row2->AccountType,
					'Note' => $Note,
				);
		};
		$show['detail'] = $detail;
		$show['detail2'] =  json_encode($detail);

    	$sql = "SELECT * FROM tb_acc_report_main WHERE ReportID=".$ReportID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$show['main'] = (array) get_object_vars($rowmain);

		return $show;
	}
	function report_formula_edit_act()
	{
		$this->db->trans_start();
		$ReportID = $this->input->post('ReportID');
		$FormulaName = $this->input->post('FormulaName');
		$FormulaType = $this->input->post('FormulaType');
		$AccountList = $this->input->post('AccountList');
		$AccountID = $this->input->post('AccountID');
		$atributeConn = $this->input->post('atributeConn');
		$AccountName = $this->input->post('AccountName');

		$this->db->set('ReportName', $FormulaName);
		$this->db->set('ReportType', $FormulaType);
		$this->db->where('ReportID', $ReportID);
		$this->db->update('tb_acc_report_main');
		$this->log_user->log_query($this->last_query);

		$this->db->where('ReportID', $ReportID);
		$this->db->delete('tb_acc_report_detail');
		
   		for ($i=0; $i < count($AccountID);$i++) { 
   			$data_formula = array(
				'ReportID' => $ReportID,
				'OrderNo' => $i,
				'AccountID' => $AccountID[$i],
				'AccountType' => $atributeConn[$i],
				'Note' => $AccountName[$i], 
			);
			$this->db->insert('tb_acc_report_detail', $data_formula);
			$this->last_query .= "//".$this->db->last_query();
   		};

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function report_formula_detail()
	{
		$ReportID = $this->input->get('report');
		$ReportDate = $this->input->get('ReportDate');
		$ReportDate = ( isset($ReportDate) ) ? $ReportDate." 23:59:59" : date("Y-m-d H:i:s");
		$show = array();
		$detail = array();

    	$sql = "SELECT * FROM tb_acc_report_main WHERE ReportID=".$ReportID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$show['main'] = (array) get_object_vars($rowmain);

		$sql 	= "SELECT * from tb_acc_report_detail where ReportID = ".$ReportID." order by OrderNo";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			if ($row2->AccountID == 0) {
			  	$detail[] = array(
					'OrderNo' => $row2->OrderNo,
					'AccountID' => $row2->AccountID,
					'AccountType' => $row2->AccountType,
					'AccountAmount' => 0,
					'Level' => 'parent',
					'Note' => $row2->Note, 
				);
			} else { 
				$sql 	= "SELECT AccountType from tb_acc_account_main where AccountID = ".$row2->AccountID;
				$query	= $this->db->query($sql);
				$row3 	= $query->row();
	      		$detail = $this->report_formula_detail_tree($row2->AccountID, $detail, $spacing = 1, $row2->OrderNo, $row2->AccountType, $row3->AccountType, $ReportDate, $show['main']['ReportType']);
			}
		};
		$show['detail'] = $detail;
		$show['detail2'] =  json_encode($show['detail']);

		return $show;
	}
	function report_formula_detail_tree($parent=0, $account_tree_array=array(), $spacing, $OrderNo, $AccountType='', $AccountParentType, $ReportDate, $ReportType)
	{ 
		$sqlP 	= ($AccountType != '') ? 'AccountID = '.$parent : 'AccountParent = '.$parent ;
		$Level 	= ($AccountType != '') ? 'parent' : 'child' ;
		$mply 	= ($AccountParentType == 'credit') ? -1 : 1 ;
		$sql 	= "select AccountID, AccountCode, AccountName, AccountParent, AccountType, AccountAmount 
					from tb_acc_account_main 
					where ".$sqlP." 
					ORDER by AccountID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$allChild = $this->get_full_account_child_id($row->AccountID);
				if ($ReportType == "kumulatif") {
					$sql = "SELECT t11.AccountID, 
							SUM( COALESCE( IF(t11.AccountType='credit',t3.JournalBalance*-1,t3.JournalBalance) *".$mply.",0) ) AS AccountAmount
							FROM tb_acc_account_main t11 
							LEFT JOIN (
								SELECT aj3.AccountID, aj3.JournalBalance
								FROM (
									SELECT MAX(aj2.JournalID) AS JournalID, t1.AccountID
									FROM (
										SELECT aj1.AccountID, MAX(aj1.JournalDate) AS JournalDate
										FROM tb_acc_journal aj1 WHERE aj1.JournalDate<='".$ReportDate."' GROUP BY aj1.AccountID
									) t1
									LEFT JOIN tb_acc_journal aj2 ON aj2.AccountID=t1.AccountID AND aj2.JournalDate=t1.JournalDate
									GROUP BY t1.AccountID ORDER BY t1.AccountID
								) t2
								LEFT JOIN tb_acc_journal aj3 ON t2.AccountID=aj3.AccountID AND t2.JournalID=aj3.JournalID
								ORDER BY aj3.AccountID
							) t3 ON t11.AccountID=t3.AccountID
							where t11.AccountID in (".implode(',',$allChild).")";
				} else {
					$FirstDate = date('Y-m-01 00:00:00', strtotime($ReportDate));
					$sql = "SELECT t11.AccountID, 
							SUM(
								( COALESCE( IF ( t11.AccountType = 'credit', t3.JournalBalance *-1, t3.JournalBalance ) *".$mply.",0) ) -
								( COALESCE( IF ( t11.AccountType = 'credit', t6.JournalBalance *-1, t6.JournalBalance ) *".$mply.",0) ) 
							) AS AccountAmount
							FROM tb_acc_account_main t11 
							LEFT JOIN (
								SELECT aj3.AccountID, aj3.JournalBalance
								FROM (
									SELECT MAX(aj2.JournalID) AS JournalID, t1.AccountID
									FROM (
										SELECT aj1.AccountID, MAX(aj1.JournalDate) AS JournalDate
										FROM tb_acc_journal aj1 WHERE aj1.JournalDate<='".$ReportDate."' GROUP BY aj1.AccountID
									) t1
									LEFT JOIN tb_acc_journal aj2 ON aj2.AccountID=t1.AccountID AND aj2.JournalDate=t1.JournalDate
									GROUP BY t1.AccountID ORDER BY t1.AccountID
								) t2
								LEFT JOIN tb_acc_journal aj3 ON t2.AccountID=aj3.AccountID AND t2.JournalID=aj3.JournalID
								ORDER BY aj3.AccountID
							) t3 ON t11.AccountID=t3.AccountID
							LEFT JOIN (
							SELECT aj6.AccountID, aj6.JournalBalance
							FROM (
								SELECT MAX(aj5.JournalID) AS JournalID, t4.AccountID
								FROM (
									SELECT aj4.AccountID, MAX(aj4.JournalDate) AS JournalDate
									FROM tb_acc_journal aj4 WHERE aj4.JournalDate<='".$FirstDate."' GROUP BY aj4.AccountID
								) t4
								LEFT JOIN tb_acc_journal aj5 ON aj5.AccountID=t4.AccountID AND aj5.JournalDate=t4.JournalDate
								GROUP BY t4.AccountID ORDER BY t4.AccountID
							) t5
							LEFT JOIN tb_acc_journal aj6 ON t5.AccountID=aj6.AccountID AND t5.JournalID=aj6.JournalID
							ORDER BY aj6.AccountID
						) t6 ON t11.AccountID=t6.AccountID
							where t11.AccountID in (".implode(',',$allChild).")";
				}
				$getrow = $this->db->query($sql);
				$row4 	= $getrow->row();
				$AccountAmount = $row4->AccountAmount;
				if ($AccountAmount != 0 or $AccountType != '') {
					$AccountType = ($AccountType != '') ? $AccountType : $row->AccountType ;
					$account_tree_array[] = array(
						'OrderNo' => $OrderNo,
						'AccountID' => $row->AccountCode,
						'AccountType' => $AccountType,
						'AccountAmount' => $AccountAmount, 
						'Level' => $Level,
						'Note' => $row->AccountName, 
						'ChildCount' => count($allChild),
						'Spacing' => $spacing,
					);
		      		$account_tree_array = $this->report_formula_detail_tree($row->AccountID, $account_tree_array, $spacing+1, $OrderNo, '', $AccountParentType, $ReportDate, $ReportType);
			    }
			}
		}
		return $account_tree_array;
	}
	function report_result_detail()
	{
		$ReportID = $this->input->get('ReportID');
		$ReportDate = $this->input->get('ReportDate');
    	$sql = "SELECT * FROM tb_acc_report_main WHERE ReportID=".$ReportID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$show['main'] = (array) get_object_vars($rowmain);

		$sql 	= "SELECT * from tb_acc_report_detail where ReportID = ".$ReportID." order by OrderNo";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$AccountAmount2 = 0;
			$AccountAmount3 = 0;
			if ($row->AccountID > 0) {
				$allChild = $this->get_full_account_child_id($row->AccountID);
				$ReportDate = isset($_REQUEST['ReportDate']) ? date('Y-m-t', strtotime($_REQUEST['ReportDate'])) : date('d-m-Y');
				$sql = "SELECT t11.AccountID, coalesce(SUM(t12.JournalBalance),0) AS AccountAmount
						FROM tb_acc_account_main t11
						LEFT JOIN (
						SELECT t1.AccountID, t1.JournalBalance, t1.JournalDate
						FROM tb_acc_journal t1
						JOIN (
						SELECT MAX(JournalDate) AS JournalDate, AccountID FROM tb_acc_journal 
						WHERE JournalDate<='".$ReportDate." 23:59:59' AND AccountID in (".implode(',',$allChild).") GROUP BY AccountID
						) t2 on t1.AccountID=t2.AccountID AND t1.JournalDate=t2.JournalDate
						) t12 ON t11.AccountID=t12.AccountID
						where t11.AccountID in (".implode(',',$allChild).")";
				$getrow = $this->db->query($sql);
				$row2 	= $getrow->row();
				$AccountAmount2 = $row2->AccountAmount;

				$sql = "SELECT t11.AccountID, coalesce(t12.JournalBalance,0) AS AccountAmount
						FROM tb_acc_account_main t11
						LEFT JOIN (
						SELECT t1.AccountID, t1.JournalBalance, t1.JournalDate
						FROM tb_acc_journal t1
						JOIN (
						SELECT MAX(JournalDate) AS JournalDate, AccountID FROM tb_acc_journal 
						WHERE JournalDate<='".$ReportDate." 23:59:59' AND AccountID=".$row->AccountID." GROUP BY AccountID
						) t2 on t1.AccountID=t2.AccountID AND t1.JournalDate=t2.JournalDate
						) t12 ON t11.AccountID=t12.AccountID
						where t11.AccountID=".$row->AccountID."";
				$getrow = $this->db->query($sql);
				$row3 	= $getrow->row();
				$AccountAmount3 = $row3->AccountAmount;
			}

		  	$show['detail'][] = array(
				'ReportID' => $row->ReportID,
				'OrderNo' => $row->OrderNo,
				'AccountID' => $row->AccountID,
				'AccountType' => $row->AccountType,
				'AccountAmount2' => $AccountAmount2,
				'AccountAmount3' => $AccountAmount3,
				'Note' => $row->Note, 
			);
		};
		return $show;
	}

// =================================================================================
    function count_DP()
    {
    	$sql 	= "SELECT SUM(TotalAllocation) as TotalAllocation, SUM(TotalBalance) as TotalBalance FROM vw_deposit_balance";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$TotalDP = $row->TotalAllocation+$row->TotalBalance;
	    return $TotalDP;
    }
    function count_payment()
    {
    	$sql 	= "SELECT SUM(PaymentAmount) as PaymentAmount FROM tb_customer_payment ";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "WHERE PaymentDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "WHERE MONTH(PaymentDate) = MONTH(CURRENT_DATE()) AND YEAR(PaymentDate) = YEAR(CURRENT_DATE()) ";
		}
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$TotalP = $row->PaymentAmount;
	    return $TotalP;
    }
    function acc_dp_payment_deposit()
    {
    	$sql = "SELECT cda.DepositID, cd.DepositAmount, CONCAT('SO ',cda.SOID) as reff, cda.AllocationAmount, cda.AllocationDate, c.Company2, em.fullname
				FROM tb_customer_deposit_allocation cda
				LEFT JOIN tb_customer_deposit cd ON (cda.DepositID=cd.DepositID)
				LEFT JOIN tb_so_main sm ON (sm.SOID=cda.SOID)
				LEFT JOIN tb_customer_main cm ON (sm.CustomerID=cm.CustomerID)
				LEFT JOIN vw_contact2 c ON (c.ContactID=cm.ContactID)
				LEFT JOIN vw_user_account em ON (cda.AllocationBy=em.UserAccountID) ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "WHERE cda.AllocationDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "ORDER BY cda.AllocationDate limit ".$this->limit_result."";
		}
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'DepositID' => $row->DepositID,
				'Company2' => $row->Company2,
				'DepositAmount' => $row->DepositAmount,
				'fullname' => $row->fullname,
				'Amount' => $row->AllocationAmount,
				'reff' => $row->reff,
				'Date' => $row->AllocationDate
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
    }
    function acc_dp_payment_payment()
    {
    	$sql = "SELECT cp.DepositID, cd.DepositAmount, CONCAT('INV ',cp.INVID) as reff, cp.PaymentAmount, cp.PaymentDate, c.Company2, em.fullname
				FROM tb_customer_payment cp
				LEFT JOIN tb_customer_deposit cd ON (cp.DepositID=cd.DepositID)
				LEFT JOIN tb_invoice_main im ON (im.INVID=cp.INVID)
				LEFT JOIN tb_customer_main cm ON (im.CustomerID=cm.CustomerID)
				LEFT JOIN vw_contact2 c ON (c.ContactID=cm.ContactID)
				LEFT JOIN vw_user_account em ON (cp.PaymentBy=em.UserAccountID) ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "WHERE cp.PaymentDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "WHERE MONTH(cp.PaymentDate) = MONTH(CURRENT_DATE()) AND YEAR(cp.PaymentDate) = YEAR(CURRENT_DATE()) ";
		}
			$sql .= "ORDER BY cp.PaymentDate";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'DepositID' => $row->DepositID,
				'Company2' => $row->Company2,
				'DepositAmount' => $row->DepositAmount,
				'fullname' => $row->fullname,
				'Amount' => $row->PaymentAmount,
				'reff' => $row->reff,
				'Date' => $row->PaymentDate
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
    }
    function fill_account_no_jurnal()
    {
    	$show = array();
		$sql = "SELECT AccountID, AccountCode, AccountName FROM tb_acc_account_main 
				where AccountID not in 
				(select AccountID from tb_acc_journal)  
				order by AccountCode ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'AccountID' => $row->AccountID,
				'AccountCode' => $row->AccountCode,
				'AccountName' => $row->AccountName,
			);
		};
		$this->log_user->log_query($this->last_query);
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
    }
    function fill_account_no_child()
    {
    	$show = array();
		$sql = "SELECT AccountID, AccountCode, AccountName FROM tb_acc_account_main 
				where AccountID not in 
				(select AccountParent from tb_acc_account_main) 
				order by AccountCode";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'AccountID' => $row->AccountID,
				'AccountCode' => $row->AccountCode,
				'AccountName' => $row->AccountName,
			);
		};
		$this->log_user->log_query($this->last_query);
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
    }
    function fill_account_no_child_no_jurnal()
    {
    	$show = array();
		$sql = "SELECT AccountID, AccountCode, AccountName FROM tb_acc_account_main 
				where AccountID not in 
				(select AccountParent from tb_acc_account_main) 
				and AccountID not in 
				(select AccountID from tb_acc_journal)
				order by AccountCode";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'AccountID' => $row->AccountID,
				'AccountCode' => $row->AccountCode,
				'AccountName' => $row->AccountName,
			);
		};
		$this->log_user->log_query($this->last_query);
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
    }
	function fill_account($parent = 0, $space='', $account_tree_array = array())
	{
		$sql 	= "select AccountID, AccountName, AccountCode from tb_acc_account_main where AccountParent = ".$parent." ORDER by AccountID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$account_tree_array[] = array(
					'AccountID' => $row->AccountID,
					'AccountName' => $row->AccountName,
					'AccountCode' => $row->AccountCode,
					'AccountName2' => $space.$row->AccountName,
				);
		      	$account_tree_array = $this->fill_account($row->AccountID, $space.'-', $account_tree_array);
			};
		}
		return $account_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function get_full_account_child_id($parent, $account_tree_array = array())
	{
		$sql 	= "select AccountID from tb_acc_account_main where AccountParent = ".$parent." ORDER by AccountID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$account_tree_array[] = $row->AccountID;
		      	$account_tree_array = $this->get_full_account_child_id($row->AccountID, $account_tree_array);
			}
		}
		$account_tree_array[] = $parent;
		return $account_tree_array;
		$this->log_user->log_query($this->last_query);
	}
    function ajax_account_list_jstree_table()
    {
		$account_tree_array   = array();
		$sql 	= "select AccountID, AccountCode, AccountName, AccountParent, AccountPosition, AccountType from tb_acc_account_main ORDER by AccountCode";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$allChild = $this->get_full_account_child_id($row->AccountID);
			$sql 	= "SELECT SUM( if(acm.AccountType='credit', acm.AccountAmount*(-1), acm.AccountAmount) ) AS AccountAmount 
						FROM tb_acc_account_main acm 
						WHERE acm.AccountID in (".implode(',',$allChild).")";
			$getrow = $this->db->query($sql);
			$row2 	= $getrow->row();
			$AccountAmount = $row2->AccountAmount;
			$tool 	= '<button type="button" class="btn btn-success btn-xs EditAccount" title="EDIT" accountid="'.$row->AccountID.'" data-toggle="modal" data-target="#EditModal"><i class="fa fa-fw fa-edit"></i></button>';
			$tool 	.= '<button type="button" class="btn btn-danger btn-xs DeleteAccount" title="DELETE" accountid="'.$row->AccountID.'" ><i class="fa fa-fw fa-trash"></i></button>';

			if ( ($AccountAmount != 0) or (count($allChild)>1) ) {
				$tool = '';
			}
			$account_tree_array[] = array(
				'id' => $row->AccountID,
				'parent' => ($row->AccountParent == 0) ? '#' : $row->AccountParent ,
				'text' => $row->AccountName,
				'data' => array(
					'AccountCode' => $row->AccountCode,
					'AccountAmount' => number_format((double)$AccountAmount,2),
					'AccountPosition' => $row->AccountPosition,
					'AccountType' => $row->AccountType,
					'tool' => $tool,
				),
			);
		}

		return $account_tree_array;
		$this->log_user->log_query($this->last_query);
    }

}
?>