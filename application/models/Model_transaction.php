<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_transaction extends CI_Model {
	public function __construct()
	{
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
	}

//request order ============================================================
	function request_order_list()
	{
		$sql = "SELECT * from vw_ro_list2 ";
		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] != "3") {
			$sql .= "WHERE ROStatus = '".$_REQUEST['status']."' ";
		} else { 
			$sql .= "WHERE ROStatus != '3' ";
		}

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && $_REQUEST['input2'] != "" ) {
			$sql .= "and ModifiedDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'RAWID':
						$sql .= "ROID in (SELECT DISTINCT ROID FROM tb_ro_raw WHERE RawID = '".$atributevalue[$i]."') ";
						break;
					case 'ProductID':
						$sql .= "ROID in (SELECT DISTINCT ROID FROM tb_ro_product WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					default:
						$sql .= "ROID in (SELECT ROID FROM tb_ro_main WHERE ".$atributeid[$i]." like '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		$sql .= "GROUP BY ROID order by ROID desc limit ".$this->limit_result." ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ROID' => $row->ROID,
		  			'SOID' => $row->SOID,
		  			'RODate' => ($row->ROScheduleDate == '') ? $row->RODate : $row->ROScheduleDate,
					'ModifiedDate' => $row->ModifiedDate,
					'fullname' => $row->fullname,
					'RONote' => $row->RONote,
		  			'qty' => $row->qty,
		  			'qtypo' => $row->qtypo,
		  			'totaldor' => $row->totaldor,
		  			'ROStatus' => $row->ROStatus
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function request_order_add_act()
	{
		$this->db->trans_start();

		$createdate 	= $this->input->post('createdate'); 
		$scheduledate 	= $this->input->post('scheduledate'); 
		$note 	= $this->input->post('note');
		$so 	= $this->input->post('so');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');

		$rawproductid = $this->input->post('rawproductid'); 
		$rawid 	= $this->input->post('rawid'); 
		$rawqty = $this->input->post('rawqty'); 

		$data = array(
			'SOID' => $so,
			'RONote' => $note,
			'RODate' => $createdate,
			'ROScheduleDate' => $scheduledate, 
			'InputDate' => date('Y-m-d H:i:s'),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_ro_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(ROID) as ROID from tb_ro_main ";
		$getROID 	= $this->db->query($sql);
		$row 		= $getROID->row();
		$ROID 		= $row->ROID;

		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
		        'ROID' => $ROID,
		        'ProductID' => $productid[$i],
		        'ProductQty' => $productqty[$i],
		        'Pending' => $productqty[$i],
			);
			$this->db->insert('tb_ro_product', $data_product);
			$this->last_query .= "//".$this->db->last_query();
   		};
   		for ($i=0; $i < count($rawproductid);$i++) { 
   			$data_raw = array(
		        'ROID' => $ROID,
		        'ProductID' => $rawproductid[$i],
		        'RawID' => $rawid[$i],
		        'RawQty' => $rawqty[$i],
		        'Pending' => $rawqty[$i],
			);
			$this->db->insert('tb_ro_raw', $data_raw);
			$this->last_query .= "//".$this->db->last_query();
   		};
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function request_order_edit_act()
	{
		$this->db->trans_start();

		$createdate 	= $this->input->post('createdate'); 
		$scheduledate 	= $this->input->post('scheduledate'); 
		$note 	= $this->input->post('note');
		$ROID 	= $this->input->post('ro'); 
		$so 	= $this->input->post('so'); 

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');

		$rawproductid = $this->input->post('rawproductid'); 
		$rawid 	= $this->input->post('rawid'); 
		$rawqty = $this->input->post('rawqty'); 

		$data = array(
			'SOID' => $so,
			'RONote' => $note,
			'RODate' => $createdate,
			'ROScheduleDate' => $scheduledate, 
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->where('ROID', $ROID);
		$this->db->update('tb_ro_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('ROID', $ROID);
		$this->db->delete('tb_ro_product');
		$this->last_query .= "//".$this->db->last_query();
		
		$this->db->where('ROID', $ROID);
		$this->db->delete('tb_ro_raw');
		$this->last_query .= "//".$this->db->last_query();

		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
		        'ROID' => $ROID,
		        'ProductID' => $productid[$i],
		        'ProductQty' => $productqty[$i]
			);
			$this->db->insert('tb_ro_product', $data_product);
			$this->last_query .= "//".$this->db->last_query();
   		};
   		for ($i=0; $i < count($rawproductid);$i++) { 
   			$data_raw = array(
		        'ROID' => $ROID,
		        'ProductID' => $rawproductid[$i],
		        'RawID' => $rawid[$i],
		        'RawQty' => $rawqty[$i]
			);
			$this->db->insert('tb_ro_raw', $data_raw);
			$this->last_query .= "//".$this->db->last_query();
   		};
		$this->update_pending_ro($ROID);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function request_order_detail()
	{
		$ROID 	= $this->input->get_post('ro');
		$sql 	= "SELECT * from vw_ro_list2 where ROID = ".$ROID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		// if ($row->ROStatus != 2 and $row->qty > $row->qtypo) {
		if ($row->ROStatus != 2) {
			$show['main'] = array(
	  			'ROID' => $row->ROID,
	  			'SOID' => $row->SOID,
	  			'RODate' => $row->RODate,
	  			'ROScheduleDate' => $row->ROScheduleDate,
				'RONote' => $row->RONote
			);
			$sql 	= "SELECT rp.*, plp.ProductCode, plp.ProductSupplier, plp.ProductPriceHPP, plp.stock 
						from tb_ro_product rp 
						left join vw_product_list_popup2_gdg_utama plp on rp.ProductID = plp.ProductID 
						where ROID = ".$ROID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductSupplier' => $row2->ProductSupplier,
		  			'ProductQty' => $row2->ProductQty,
		  			'ProductPO' => $row2->ProductPO,
		  			'ProductPriceHPP' => $row2->ProductPriceHPP,
					'stock' => $row2->stock
				);
			};
			$show['product2'] = json_encode($show['product']);

			$sql 	= "SELECT rr.*, plp.ProductCode, plp.stock, coalesce(t1.RawPO,0) as RawPO from tb_ro_raw rr 
						left join vw_product_list_popup2_gdg_utama plp on rr.RawID = plp.ProductID 
						left join (
							SELECT pm.ROID, pr.ProductID, pr.RawID, SUM(pr.RawQty) as RawPO
							FROM tb_po_main pm
							LEFT JOIN tb_po_raw pr ON pm.POID=pr.POID
							WHERE pm.ROID=".$ROID." AND pm.POStatus<>2 GROUP BY pr.ProductID, pr.RawID
						) t1 on rr.ProductID=t1.ProductID and rr.RawID=t1.RawID
						where rr.ROID = ".$ROID." order by rr.ProductID";
			$query	= $this->db->query($sql);
			if ($query->num_rows()) {
				foreach ($query->result() as $row3) {
				  	$show['raw'][] = array(
			  			'ProductID' => $row3->ProductID,
			  			'RawID' => $row3->RawID,
			  			'ProductCode' => $row3->ProductCode,
			  			'RawQty' => $row3->RawQty,
						'stock' => $row3->stock,
						'RawPO' => $row3->RawPO,
					);
				};
				$show['raw2'] = json_encode($show['raw']);
			}
		} else {
        	redirect(base_url('transaction/purchase_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function request_order_sugestion()
	{
		$ProductID 	= $this->input->get_post('ro_sugestion_val'); 
		$ProductQty	= $this->input->get_post('ro_sugestion_qty'); 
		$show   = array();
		if ($ProductID != '') {
			$sql 	= "SELECT ProductID, ProductCode, Stockable, stock 
						from vw_product_list_popup8 
						where ProductID in (".$ProductID.") order by ProductID asc";
			$query	= $this->db->query($sql);
			$show['ro_sugestion_val'] = $ProductID; 
			$show['product'] = $query->result_array(); 
			$show['product2'] = json_encode($show['product']);

			$ProductQtyArr = explode(',', $ProductQty);
			for ($i=0; $i < count($ProductQtyArr); $i++) { 
				$result = explode('-', $ProductQtyArr[$i]);
				$show['productqty'][$result[0]] = $result[1];
			}
			$show['productqty2'] = json_encode($show['productqty']);
		} 
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function request_order_cancel()
	{
		$this->db->trans_start();

		$cancelnote = $this->input->post('cancelnote');
		$ROID 		= $this->input->post('roid'); 

		$sql 	= "SELECT SUM(ProductPO) as ProductPO FROM tb_ro_product WHERE ROID = ".$ROID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();

		if ($row->ProductPO == 0 ) {
			$data = array(
				'ROCancelNote' => $cancelnote,
				'ROCancelDate' => date('Y-m-d H:i:s'),
				'ROStatus' => "2"
			);
			$this->db->where('ROID', $ROID);
			$this->db->update('tb_ro_main', $data);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function request_order_detail_full()
	{
		$ROID 	= $this->input->get_post('roid');
		$show   = array();

		$sql 	= "SELECT rp.*, plp.ProductCode, plp.ProductSupplier, plp.ProductPriceHPP, plp.stock 
					from tb_ro_product rp 
					left join vw_product_list_popup2 plp on rp.ProductID = plp.ProductID 
					where ROID = ".$ROID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			$show['product'][] = array(
				'ProductID' => $row2->ProductID,
				'ProductCode' => $row2->ProductCode,
				'ProductSupplier' => $row2->ProductSupplier,
				'ProductQty' => $row2->ProductQty,
				'ProductPO' => $row2->ProductPO,
				'ProductPriceHPP' => $row2->ProductPriceHPP,
				'stock' => $row2->stock
			);

			$sql 	= "SELECT rm.ROID, rp.ProductID, pm.POID, pm.PODate, pm.ShippingDate, pp.ProductID, pp.ProductQty, pp.DORQty
					from tb_ro_product rp
					LEFT JOIN tb_ro_main rm ON (rp.ROID = rm.ROID)
					LEFT JOIN tb_po_main pm ON (rm.ROID = pm.ROID)
					LEFT JOIN tb_po_product pp ON (pm.POID = pp.POID)
					WHERE rp.ProductID = ".$row2->ProductID." AND rp.ROID = ".$ROID." and pm.POStatus != 2 and pp.ProductID = ".$row2->ProductID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row3) {
				$show['po'][$row2->ProductID][] = array(
					'POID' => $row3->POID,
					'PODate' => $row3->PODate,
					'ShippingDate' => $row3->ShippingDate,
					'ProductQty' => $row3->ProductQty,
					'DORQty' => $row3->DORQty
				);
				$sql 	= "SELECT pp.POID, dm.DORID, dm.DORDate, dd.ProductID, dd.ProductQty
							FROM tb_po_product pp
							LEFT JOIN tb_po_main pm ON (pp.POID = pm.POID)
							LEFT JOIN tb_dor_main dm ON (pm.POID = dm.DORReff)
							LEFT JOIN tb_dor_detail dd ON (dm.DORID = dd.DORID)
							WHERE pp.ProductID = ".$row2->ProductID." AND pp.POID = ".$row3->POID." AND dm.DORType = 'PO' AND dd.ProductID = pp.ProductID";
				$query	= $this->db->query($sql);
				foreach ($query->result() as $row4) {
					$show['dor'][$row2->ProductID][] = array(
						'POID' => $row4->POID,
						'DORID' => $row4->DORID,
						'DORDate' => $row4->DORDate,
						'ProductQty' => $row4->ProductQty
					);
				};
			};
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function request_order_detail_raw_full()
	{
		$ROID 	= $this->input->get_post('roid');
		$show   = array();

		$sql 	= "SELECT rr.ROID, rr.ProductID, rr.RawID, rr.RawQty, plp.ProductCode AS RawName, plp2.ProductCode AS ProductParent, plp.stock, plp.stock-ps.pending as stockReady
					FROM tb_ro_raw rr
					LEFT JOIN tb_ro_main rm ON (rr.ROID = rm.ROID)
					LEFT JOIN vw_product_list_popup2 plp ON (rr.RawID = plp.ProductID)
					LEFT JOIN tb_product_main plp2 ON (rr.ProductID = plp2.ProductID)
					LEFT JOIN vw_stock_pending_so_raw ps ON (rr.ProductID = ps.ProductID)
					WHERE rr.ROID =".$ROID." order by rr.ROID, rr.ProductID";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			$show['parent'][$row2->ProductID][] = $row2->RawID;
			$show['product'][] = array(
				'RawID' => $row2->RawID,
				'ProductID' => $row2->ProductID,
				'RawName' => $row2->RawName,
				'ProductParent' => $row2->ProductParent,
				'RawQty' => $row2->RawQty,
				'stock' => $row2->stock,
				'stockReady' => $row2->stockReady
			);

			$sql 	= "SELECT rr.ROID, rr.ProductID, rr.RawID, rr.RawQty, pm.POID, pm.PODate, pr.RawQty as qtypo, pr.RawSent 
						FROM tb_ro_raw rr
						LEFT JOIN tb_ro_main rm ON (rr.ROID = rm.ROID)
						LEFT JOIN tb_po_main pm ON (rm.ROID = pm.ROID)
						LEFT JOIN tb_po_raw pr ON (pm.POID = pr.POID)
						WHERE rr.ProductID = pr.ProductID
						AND rr.RawID = pr.RawID
						AND rm.ROID = ".$ROID."
						AND pm.POStatus != 2
						AND rr.RawID =".$row2->RawID."
						AND rr.ProductID =".$row2->ProductID;
			$query	= $this->db->query($sql);
			// echo $sql;
			foreach ($query->result() as $row3) {
			  	$show['po'][$row2->ProductID][$row2->RawID][] = array(
		  			'POID' => $row3->POID,
		  			'PODate' => $row3->PODate,
		  			'qtypo' => $row3->qtypo,
		  			'RawSent' => $row3->RawSent
				);
			};
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function request_order_print()
	{
		$ROID 	= $this->input->get_post('ro');
		$sql 	= "SELECT * from tb_ro_main where ROID = ".$ROID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		// if ($row->ROStatus != 2 and $row->qty > $row->qtypo) {
		if ($row->ROStatus != 2) {
			$show['main'] = array(
	  			'ROID' => $row->ROID,
	  			'SOID' => $row->SOID,
	  			'RODate' => $row->RODate,
				'RONote' => $row->RONote
			);
			$sql 	= "SELECT rp.*, plp.ProductCode, plp.ProductSupplier, plp.ProductPriceHPP, plp.stock 
						from tb_ro_product rp 
						left join vw_product_list_popup2 plp on rp.ProductID = plp.ProductID 
						where ROID = ".$ROID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductSupplier' => $row2->ProductSupplier,
		  			'ProductQty' => $row2->ProductQty,
		  			'ProductPO' => $row2->ProductPO,
		  			'ProductPriceHPP' => $row2->ProductPriceHPP,
					'stock' => $row2->stock
				);
			};

			$sql 	= "SELECT rr.*, plp.ProductCode, plp.stock from tb_ro_raw rr ";
			$sql 	.= "left join vw_product_list_popup2 plp on rr.RawID = plp.ProductID ";
			$sql 	.= "where ROID = ".$ROID." order by rr.ProductID";
			$query	= $this->db->query($sql);
			if ($query->num_rows()) {
				foreach ($query->result() as $row3) {
				  	$show['raw'][$row3->ProductID][] = array(
			  			'ProductID' => $row3->ProductID,
			  			'RawID' => $row3->RawID,
			  			'ProductCode' => $row3->ProductCode,
			  			'RawQty' => $row3->RawQty,
						'stock' => $row3->stock
					);
				};
			}
		} else {
        	redirect(base_url('transaction/purchase_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

//purchase order ===========================================================
	function request_to_purchase()
	{
		$sql = "SELECT rl.*, IF( COUNT(pr.ROID) > 0, 
				GROUP_CONCAT( DISTINCT pr.stockReady ORDER BY pr.stockReady SEPARATOR ','), 'Ready') AS stockReady
				from vw_ro_list2 rl ";
		if (isset($_REQUEST['WarehouseID'])) {
			$sql .= "LEFT JOIN ( 
						SELECT rr.ROID AS ROID, rr.ProductID AS ProductID,
						rr.RawID AS RawID, rr.RawQty AS RawQty,
						COALESCE (rrp.total, 0) AS totalPO, ps.stock AS stock,
						(rr.RawQty - COALESCE(rrp.total, 0)) AS Pending,
						IF (((ps.stock - sp.pending) >= (rr.RawQty - COALESCE (rrp.total, 0))),'Ready','NotReady'
						) AS stockReady
						FROM (((tb_ro_raw rr
						LEFT JOIN vw_ro_raw_po rrp ON (((rr.ROID = rrp.ROID) 
						AND (rr.ProductID = rrp.ProductID) AND (rr.RawID = rrp.RawID))))
						LEFT JOIN (
							SELECT psm.ProductID AS ProductID, sum(psm.Quantity) AS stock
							FROM tb_product_stock_main psm
							WHERE psm.WarehouseID IN (" . implode(',', array_map('intval', $_REQUEST['WarehouseID'])) . ")
							GROUP BY psm.ProductID
						) ps ON ((rr.RawID = ps.ProductID)))
						LEFT JOIN vw_stock_pending_so_raw sp ON ((rr.RawID = sp.ProductID)))
						HAVING (Pending > 0) 
				) pr ON (rl.ROID = pr.ROID) ";
		} else {
			$sql .= "LEFT JOIN vw_ro_raw3 pr ON (rl.ROID = pr.ROID) ";
		}
		$sql .= "WHERE ROStatus<>2 and qty>qtypo GROUP BY rl.ROID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ROID' => $row->ROID,
		  			'SOID' => $row->SOID,
		  			'RODate' => ($row->ROScheduleDate == '') ? $row->RODate : $row->ROScheduleDate,
					'ModifiedDate' => $row->ModifiedDate,
					'fullname' => $row->fullname,
					'RONote' => $row->RONote,
		  			'qty' => $row->qty,
		  			'qtypo' => $row->qtypo,
		  			'stockReady' => $row->stockReady,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function query_request_to_purchase()
	{
		$sql = "SELECT COUNT(t1.ROID) AS CountRO, 
				SUM(CASE WHEN t1.stockReady = 'Ready' THEN 1 ELSE 0 END) AS RAW_Ready_all,
				SUM(CASE WHEN t1.stockReady = 'NotReady,Ready' THEN 1 ELSE 0 END) AS RAW_Ready_Partial
				FROM (

				SELECT rl.*, 
				IF( COUNT(pr.ROID) > 0, GROUP_CONCAT( DISTINCT pr.stockReady ORDER BY pr.stockReady SEPARATOR ','), 'Ready') AS stockReady
				from vw_ro_list3 rl 
				LEFT JOIN vw_ro_raw3 pr ON (rl.ROID = pr.ROID) 
				WHERE ROStatus<>2 and qty>qtypo GROUP BY rl.ROID
				) t1";

	    return $sql;
		$this->log_user->log_query($this->last_query);
	}
	function request_to_purchase_detail()
	{
		$ROID 	= $this->input->get_post('ro');
		$sql 	= "SELECT * from tb_ro_main where ROID = ".$ROID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		// if ($row->ROStatus != 2 and $row->qty > $row->qtypo) {
		if ($row->ROStatus != 2) {
			$show['main'] = array(
	  			'ROID' => $row->ROID,
	  			'SOID' => $row->SOID,
	  			'RODate' => $row->RODate,
				'RONote' => $row->RONote
			);
			$sql 	= "SELECT rp.*, plp.ProductCode, plp.ProductSupplier, plp.ProductPriceHPP, plp.ProductPricePurchase, plp.stock, plp.Stockable 
						from tb_ro_product rp 
						left join vw_product_list_popup2_gdg_utama plp on rp.ProductID = plp.ProductID 
						where ROID = ".$ROID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
				if ($row2->ProductPO != $row2->ProductQty) {
				  	$show['product'][] = array(
			  			'ProductID' => $row2->ProductID,
			  			'ProductCode' => $row2->ProductCode,
			  			'ProductSupplier' => $row2->ProductSupplier,
			  			'ProductQty' => $row2->ProductQty,
			  			'ProductPO' => $row2->ProductPO,
			  			'ProductPriceHPP' => $row2->ProductPriceHPP,
			  			'ProductPricePurchase' => $row2->ProductPricePurchase, 
						'stock' => $row2->stock,
						'Stockable' => $row2->Stockable,
					);
				}
			};
			$show['product2'] = json_encode($show['product']);

			$sql 	= "SELECT rr.*, plp.ProductCode, plp.stock, ps.stock as stockAll, COALESCE(spr.pending,0) as pending 
						from tb_ro_raw rr  
						left join vw_product_list_popup2_gdg_utama plp on rr.RawID = plp.ProductID 
						left join vw_product_stock ps on rr.RawID = ps.ProductID 
						left join vw_stock_pending_so_raw spr on rr.RawID = spr.ProductID 
						where ROID = ".$ROID." order by rr.ProductID";
			$query	= $this->db->query($sql);
			if ($query->num_rows()) {
				foreach ($query->result() as $row3) {
				  	$show['raw'][] = array(
			  			'ProductID' => $row3->ProductID,
			  			'RawID' => $row3->RawID,
			  			'ProductCode' => $row3->ProductCode,
			  			'RawQty' => $row3->RawQty,
						'stock' => $row3->stock,
						'stockAll' => $row3->stockAll,
						'pending' => $row3->pending
					);
				};
				$show['raw2'] = json_encode($show['raw']);
			}
		} else {
        	redirect(base_url('transaction/purchase_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function purchase_order_add_act()
	{
		$this->db->trans_start();

		$ro = $this->input->post('ro');
		$so = (isset($_REQUEST['so'])) ? $this->input->post('so') : 0 ;

		$supplier 	= $this->input->post('supplier'); 
		$supplier 	= explode("_", $supplier);
		$SupplierID	= $supplier[0]; 
		$suppliercompany= $supplier[2]; 
		$suppliername	= $supplier[1]; 
		$supplierphone 	= $this->input->post('supplierphone'); 
		$supplieremail 	= $this->input->post('supplieremail'); 
		$supplieraddress= $this->input->post('supplieraddress'); 
		$SupplierNote 	= $suppliercompany.";".$suppliername.";".$supplieraddress.";".$supplierphone.";".$supplieremail;

		$billingto 	= $this->input->post('billingto'); 
		$scheduledate 	= $this->input->post('scheduledate'); 
		$note 		= $this->input->post('note');
		$shippingto = $this->input->post('shippingto');
		$shippingalt = $this->input->post('shippingalt');
		$shippingdate 	= $this->input->post('shippingdate');
		$paymentterm 	= $this->input->post('paymentterm');
		$potype 	= $this->input->post('potype');
		$currency 	= $this->input->post('currency');
		$currencyex = $this->input->post('currencyex');
		$attachment = $this->input->post('attachment');
		$taxpercent	= $this->input->post('taxpercent');
		$taxresult	= $this->input->post('taxresult');
		// $downpayment	= $this->input->post('downpayment');
		$pricebefore	= $this->input->post('pricebefore');
		$totalprice		= $this->input->post('totalprice');

		$taxresult2		= $this->input->post('taxresult2');
		$pricebefore2	= $this->input->post('pricebefore2');
		$totalprice2	= $this->input->post('totalprice2');

		$productid 	= $this->input->post('productid');
		$productcodesupplier 	= $this->input->post('productcodesupplier');
		$productqtypurchase 	= $this->input->post('productqtypurchase');
		$productqty 	= $this->input->post('productqty');
		$productqtydone = $this->input->post('productqtydone');
		$productprice 	= $this->input->post('productprice');
		// $productdisc 	= $this->input->post('productdisc');
		$productpricetotal 	= $this->input->post('productpricetotal');

		$productprice2 	= $this->input->post('productprice2');
		$productpricetotal2 	= $this->input->post('productpricetotal2');

		$rawid 			= $this->input->post('rawid');
		$rawproductid 	= $this->input->post('rawproductid');
		$rawqtyuse 		= $this->input->post('rawqtyuse');

		$data = array(
			'ROID' => $ro,
			'SOID' => $so,
			'SupplierID' => $SupplierID,
			'SupplierNote' => $SupplierNote,
			'BillingTo' => $billingto,
			'PODate' => $scheduledate,
			'PONote' => $note,
			'ShippingTo' => $shippingto,
			'ShippingDate' => $shippingdate,
			'ShippingAlt' => $shippingalt,
			'POType' => $potype,
			'POCurrency' => $currency,
			'POCurrencyEx' => $currencyex,
			'PaymentTerm' => $paymentterm,
			'TaxRate' => $taxpercent,
			'TaxAmount' => $taxresult,
			// 'DownPayment' => $downpayment,
			'PriceBefore' => $pricebefore,
			'TotalPrice' => $totalprice,

			'TaxAmount2' => $taxresult2,
			'PriceBefore2' => $pricebefore2,
			'TotalPrice2' => $totalprice2,
 
			'InputDate' => date('Y-m-d H:i:s'),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_po_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(POID) as POID from tb_po_main ";
		$getPOID 	= $this->db->query($sql);
		$row 		= $getPOID->row();
		$POID 		= $row->POID;

		// insert file
		set_time_limit(0);
		ini_set('upload_max_filesize', '500M');
		ini_set('post_max_size', '500M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		// $limit = 210000;
		if ($_FILES['attachment']['name'] != "") { //copy file ke server
            $target_dir = "tool/po/";
            $target_file = $target_dir . $POID ."_". $_FILES['attachment']['name'];
            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
				// $attachment = file_get_contents($target_file); //convert ke blob
				$data_file['POAttachment'] = $POID ."_". $_FILES['attachment']['name'];
            }
        }
        if (isset($data_file)) {
        	$this->db->where('POID', $POID);
			$this->db->update('tb_po_main', $data_file);
			$this->last_query .= "//".$this->db->last_query();
        }

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'POID' => $POID,
					'ProductID' => $productid[$i],
					'ProductSupplierCode' => $productcodesupplier[$i],
					'ProductQty' => $productqtypurchase[$i],
					'Pending' => $productqtypurchase[$i],
					'ProductPrice' => $productprice[$i],
					// 'ProductDisc' => $productdisc[$i],
					'ProductPriceTotal' => $productpricetotal[$i],

					'ProductPrice2' => $productprice2[$i],
					'ProductPriceTotal2' => $productpricetotal2[$i]
				);
				$this->db->insert('tb_po_product', $data_product);
				$this->last_query .= "//".$this->db->last_query();

				if ($productcodesupplier[$i] != "") {
					$this->db->set('ProductSupplier', $productcodesupplier[$i]);
					$this->db->where('ProductID', $productid[$i]);
					$this->db->update('tb_product_main');
					$this->last_query .= "//".$this->db->last_query();
				}
	   		};
		}
		if (isset($rawproductid)) {
			for ($i=0; $i < count($rawproductid);$i++) { 
	   			$data_raw = array(
			        'POID' => $POID,
			        'ProductID' => $rawproductid[$i],
			        'RawID' => $rawid[$i],
			        'RawQty' => $rawqtyuse[$i],
			        'Pending' => $rawqtyuse[$i]
				);
				$this->db->insert('tb_po_raw', $data_raw);
				$this->last_query .= "//".$this->db->last_query();
	   		};

			$sql = "UPDATE tb_po_raw t, tb_product_main pm
					SET t.ProductHPP = pm.ProductPriceHPP
					WHERE t.RawID = pm.ProductID AND t.POID=".$POID;
			$this->db->query($sql);
		}
		// if (isset($productqtypurchase)) {
		// 	for ($i=0; $i < count($productqtypurchase);$i++) { 
		// 		$productqtyreal = $productqtydone[$i] + $productqtypurchase[$i];
		// 		$this->db->set('ProductPO', $productqtyreal);
		// 		$this->db->where('ROID', $ro);
		// 		$this->db->where('ProductID', $productid[$i]);
		// 		$this->db->update('tb_ro_product');
		// $this->last_query .= "//".$this->db->last_query();
	 //   		};
		// }
		$this->update_pending_ro($ro);
		$this->update_status_ro($ro);
		$this->approval_submission_po($POID, $suppliercompany);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_edit()
	{
		$this->db->trans_start();

		$POID 	= $this->input->get_post('po');
		// cek DOR - BK
		$sql 	= "SELECT bdd.DistributionID
					FROM tb_bank_distribution_detail bdd
					WHERE bdd.ReffType='DOR' AND bdd.ReffNo in (
					SELECT dm.DORID FROM tb_dor_main dm WHERE dm.DORType='PO' AND dm.DORReff=".$POID."
					)";
		$getrow	= $this->db->query($sql);
		$rowBK 	= $getrow->row();

		// if PO not BK
		// if (empty($rowBK)) {
			$sql 	= "SELECT pm.*, wm.*, jc.*, SUM(pp.DORQty) as DORQty, COALESCE(SUM(pr.RawSent), 0) as RawSent
						FROM tb_po_main pm
						LEFT JOIN tb_warehouse_main wm ON (	pm.ShippingTo = wm.WarehouseID )
						LEFT JOIN tb_job_company jc ON (pm.BillingTo = jc.CompanyID)
						LEFT JOIN tb_po_product pp ON (pm.POID = pp.POID)
						LEFT JOIN tb_po_raw pr ON (pm.POID = pr.POID)
						WHERE pm.POID = ".$POID;
			$getrow	= $this->db->query($sql);
			$row 	= $getrow->row();
			$show   = array();
			// if PO not Cancel
			if ($row->POStatus != 2) {
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
		  			'PONote' => $row->PONote,
		  			'ShippingDate' => $row->ShippingDate,
		  			'ShippingAlt' => $row->ShippingAlt,
		  			'POType' => $row->POType,
		  			'POCurrency' => $row->POCurrency,
		  			'POCurrencyEx' => $row->POCurrencyEx,
		  			'ShippingAlt' => $row->ShippingAlt,
		  			'PaymentTerm' => $row->PaymentTerm,
		  			'TaxRate' => $row->TaxRate,
		  			'TaxAmount' => $row->TaxAmount,
		  			// 'DownPayment' => $row->DownPayment,
		  			'PriceBefore' => $row->PriceBefore,
		  			'TotalPrice' => $row->TotalPrice,

		  			'TaxAmount2' => $row->TaxAmount2,
		  			'PriceBefore2' => $row->PriceBefore2,
		  			'TotalPrice2' => $row->TotalPrice2,

		  			'CompanyID' => $row->CompanyID,
		  			'CompanyName' => $row->CompanyName,
		  			'WarehouseID' => $row->WarehouseID,
		  			'WarehouseName' => $row->WarehouseName,
		  			'WarehouseAddress' => $row->WarehouseAddress,
		  			'DORQty' => $row->DORQty,
				);
				$sql 	= "SELECT pp.*, plp.ProductCode, plp.ProductPriceHPP, rp.ProductQty as QtyOrder, 
							rp.ProductPO as QtyPurchased, COALESCE(prp.RawSent2,0) as RawSent2, plp.Stockable FROM vw_po_product2 pp
							LEFT JOIN vw_product_list_popup2_gdg_utama plp ON pp.ProductID = plp.ProductID
							LEFT JOIN tb_po_main pm ON pp.POID = pm.POID
							LEFT JOIN tb_ro_product rp ON pm.ROID = rp.ROID AND pp.ProductID = rp.ProductID
							LEFT JOIN vw_po_raw_parent2 prp ON pp.POID = prp.POID AND prp.ProductID = pp.ProductID
							WHERE pp.POID =".$POID;
				$query	= $this->db->query($sql);
				foreach ($query->result() as $row2) {

					// jika ROID = 0
					$QtyOrder = ($row->ROID <1 ? $row2->ProductQty : $row2->QtyOrder);
					$QtyPurchased = ($row->ROID <1 ? $row2->DORQty : $row2->QtyPurchased-$row2->ProductQty);

				  	$show['product'][] = array(
			  			'ProductID' => $row2->ProductID,
			  			'ProductCode' => $row2->ProductCode,
			  			'ProductSupplierCode' => $row2->ProductSupplierCode,
			  			'QtyOrder' => $QtyOrder,
			  			'QtyPurchased' => $QtyPurchased,
			  			'ProductQty' => $row2->ProductQty,
			  			'ProductPrice' => $row2->ProductPrice,
			  			'ProductDisc' => $row2->ProductDisc,
			  			'ProductPriceTotal' => $row2->ProductPriceTotal,

			  			'ProductPrice2' => $row2->ProductPrice2,
			  			'ProductPriceTotal2' => $row2->ProductPriceTotal2,

			  			'ProductPriceHPP' => $row2->ProductPriceHPP,
						'DORQty' => $row2->totaldor,
						'RawSent2' => $row2->RawSent2,
						'Stockable' => $row2->Stockable,
					);
				};
				$show['product2'] = json_encode($show['product']);
				// echo($show['product2']);

				$sql 	= "SELECT pr.*, plp.ProductCode, plp.ProductSupplier, plp.Stock as stockUtama, 
							ps.stock as stockAll, rr.RawQty as QtyOrder
							FROM tb_po_raw pr
							LEFT JOIN tb_po_main pm ON pr.POID = pm.POID
							LEFT JOIN vw_product_list_popup2_gdg_utama plp ON pr.RawID = plp.ProductID
							left join vw_product_stock ps on pr.RawID = ps.ProductID 
							LEFT JOIN tb_ro_raw rr ON pm.ROID = rr.ROID
							AND pr.ProductID = rr.ProductID
							AND pr.RawID = rr.RawID
							WHERE pr.POID =".$POID;
				$query	= $this->db->query($sql);
				if ($query->num_rows()) {
					$QtyOrder = ($row->ROID <1 ? $row2->ProductQty : $row2->QtyOrder);
					foreach ($query->result() as $row2) {
					  	$show['raw'][] = array(
				  			'ProductID' => $row2->ProductID,
				  			'RawID' => $row2->RawID,
				  			'ProductCode' => $row2->ProductCode,
				  			'ProductSupplier' => $row2->ProductSupplier,
				  			'Stock' => $row2->stockUtama,
				  			'stockAll' => $row2->stockAll,
				  			'RawQty' => $row2->RawQty,
							'QtyOrder' => $QtyOrder,
							'RawSent2' => $row2->RawSent,
						);
					};
					$show['raw2'] = json_encode($show['raw']);
				}

			} else {
	        	redirect(base_url('transaction/purchase_order_list'));
			}
		// } else {
        	// redirect(base_url('transaction/purchase_order_list'));
		// }

	    return $show;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_edit_act()
	{
		$this->db->trans_start();

		$POID 		= $this->input->post('po'); 
		$ro 		= $this->input->post('ro'); 

		$supplier 	= $this->input->post('supplier'); 
		$supplier 	= explode("_", $supplier);
		$SupplierID	= $supplier[0]; 
		$suppliercompany= $supplier[2]; 
		$suppliername	= $supplier[1]; 
		$supplierphone 	= $this->input->post('supplierphone'); 
		$supplieremail 	= $this->input->post('supplieremail'); 
		$supplieraddress = $this->input->post('supplieraddress'); 
		$SupplierNote 	= $suppliercompany.";".$suppliername.";".$supplieraddress.";".$supplierphone.";".$supplieremail;

		// $billingto 	= $this->input->post('billingto'); 
		$scheduledate 	= $this->input->post('scheduledate'); 
		$note 		= $this->input->post('note');
		$shippingto = $this->input->post('shippingto');
		$shippingdate 	= $this->input->post('shippingdate');
		$shippingalt 	= $this->input->post('shippingalt');
		$paymentterm 	= $this->input->post('paymentterm');
		$potype 	= $this->input->post('potype');
		$currency 	= $this->input->post('currency');
		$currencyex	= $this->input->post('currencyex');
		$attachment = $this->input->post('attachment');
		$taxpercent	= $this->input->post('taxpercent');
		$taxresult	= $this->input->post('taxresult');
		// $downpayment	= $this->input->post('downpayment');
		$pricebefore	= $this->input->post('pricebefore');
		$totalprice		= $this->input->post('totalprice');

		$taxresult2	= $this->input->post('taxresult2');
		$pricebefore2	= $this->input->post('pricebefore2');
		$totalprice2	= $this->input->post('totalprice2');

		$productid 	= $this->input->post('productid');
		$productcodesupplier 	= $this->input->post('productcodesupplier');
		$productqtypurchase 	= $this->input->post('productqtypurchase');
		$productqty 	= $this->input->post('productqty');
		$productqtydone = $this->input->post('productqtydone');
		$productprice 	= $this->input->post('productprice');
		// $productdisc 	= $this->input->post('productdisc');
		$productpricetotal 	= $this->input->post('productpricetotal');

		$productprice2 	= $this->input->post('productprice2');
		$productpricetotal2 	= $this->input->post('productpricetotal2');

		$rawid 			= $this->input->post('rawid');
		$rawproductid 	= $this->input->post('rawproductid');
		$rawqtyuse 		= $this->input->post('rawqtyuse');

		// compare main
		$noteApproval = "";
		$sql 	= "SELECT pm.* FROM tb_po_main pm WHERE pm.POID = ".$POID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$noteApproval .= ($rowmain->ShippingDate != $shippingdate) ? "- 'Shipping Date' berubah<br>":"" ;
		$noteApproval .= ($rowmain->PONote != $note) ? "- 'PO Note' berubah<br>":"" ;
		$noteApproval .= ($rowmain->ShippingTo != $shippingto) ? "- 'Shipping To' berubah<br>":"" ;
		$noteApproval .= ($rowmain->ShippingAlt != $shippingalt) ? "- 'Shipping To' berubah<br>":"" ;
		$noteApproval .= ($rowmain->POCurrency != $currency) ? "- 'PO Currency' berubah<br>":"" ;
		$noteApproval .= ($rowmain->POCurrencyEx != $currencyex) ? "- 'Currency Exchange' berubah, nilai Sebelumnya ".number_format($rowmain->POCurrencyEx,2)."<br>":"" ;
		// ---------------------------------------------------

		$data = array(
			'SupplierID' => $SupplierID,
			'SupplierNote' => $SupplierNote,
			// 'BillingTo' => $billingto,
			// 'PODate' => $scheduledate,
			'PONote' => $note,
			'ShippingTo' => $shippingto,
			'ShippingDate' => $shippingdate,
			'ShippingAlt' => $shippingalt,
			'POType' => $potype,
			'POCurrency' => $currency,
			'POCurrencyEx' => $currencyex,
			'PaymentTerm' => $paymentterm,
			'TaxRate' => $taxpercent,
			'TaxAmount' => $taxresult,
			// 'DownPayment' => $downpayment,
			'PriceBefore' => $pricebefore,
			'TotalPrice' => $totalprice,

			'TaxAmount2' => $taxresult2,
			'PriceBefore2' => $pricebefore2,
			'TotalPrice2' => $totalprice2, 

			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->where('POID', $POID);
		$this->db->update('tb_po_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		// insert file
			set_time_limit(0);
			ini_set('upload_max_filesize', '500M');
			ini_set('post_max_size', '500M');
			ini_set('max_input_time', 4000); // Play with the values
			ini_set('max_execution_time', 4000); // Play with the values
			// $limit = 210000;
			if ($_FILES['attachment']['name'] != "") { //copy file ke server
	            $target_dir = "tool/po/";
	            $target_file = $target_dir . $POID ."_". $_FILES['attachment']['name'];
	            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
					// $attachment = file_get_contents($target_file); //convert ke blob
					$data_file['POAttachment'] = $POID ."_". $_FILES['attachment']['name'];
	            }
	        }
	        if (isset($data_file)) {
	        	$this->db->where('POID', $POID);
				$this->db->update('tb_po_main', $data_file);
				$this->last_query .= "//".$this->db->last_query();
	        }
        // --------------------------------------------------

	    // compare detail
		$sql 	= "SELECT * FROM tb_po_product WHERE POID = ".$POID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $rowD) {
		  	$rowDetail[$rowD->ProductID] = array(
	  			'ProductID' => $rowD->ProductID,
	  			'ProductQty' => $rowD->ProductQty,
	  			'ProductPrice' => $rowD->ProductPrice,
	  			'ProductPriceTotal' => $rowD->ProductPriceTotal,
			);
		}
        // --------------------------------------------------

		$this->db->where('POID', $POID);
		$this->db->delete('tb_po_product');
		$this->last_query .= "//".$this->db->last_query();
		

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'POID' => $POID,
					'ProductID' => $productid[$i],
					'ProductSupplierCode' => $productcodesupplier[$i],
					'ProductQty' => $productqtypurchase[$i],
					'ProductPrice' => $productprice[$i],
					// 'ProductDisc' => $productdisc[$i],
					'ProductPriceTotal' => $productpricetotal[$i],

					'ProductPrice2' => $productprice2[$i],
					'ProductPriceTotal2' => $productpricetotal2[$i]
				);
				$this->db->insert('tb_po_product', $data_product);
				$this->last_query .= "//".$this->db->last_query();

				if (isset($rowDetail[$productid[$i]])) {
					$noteApproval .= ($rowDetail[$productid[$i]]['ProductQty'] != $productqtypurchase[$i]) ? "-- ProductID:".$productid[$i]." Quantity berubah, nilai Sebelumnya ".number_format($rowDetail[$productid[$i]]['ProductQty'],2)."<br>":"" ;
					$noteApproval .= ($rowDetail[$productid[$i]]['ProductPrice'] != $productprice[$i]) ? "-- ProductID:".$productid[$i]." Harga Satuan berubah, nilai Sebelumnya ".number_format($rowDetail[$productid[$i]]['ProductPrice'],2)."<br>":"" ;
				}
	   		};
		}
		if (isset($rawproductid)) {
			for ($i=0; $i < count($rawproductid);$i++) { 
				$this->db->set('RawQty', $rawqtyuse[$i]);
				$this->db->where('POID', $POID);
				$this->db->where('ProductID', $rawproductid[$i]);
				$this->db->where('RawID', $rawid[$i]);
				$this->db->update('tb_po_raw');
				$this->last_query .= "//".$this->db->last_query();
	   		};
	   		
			$this->db->where_not_in('ProductID', $productid);
			$this->db->where('POID', $POID);
			$this->db->delete('tb_po_raw');
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->update_pending_ro($ro);
		$this->update_status_ro($ro);
		$this->update_pending_product_po($POID);
		$this->update_pending_raw_po($POID);
		$this->approval_submission_po($POID, $suppliercompany, $noteApproval);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_list()
	{
		$show   = array();
		$sql = "SELECT p.*, p.RawQty-p.RawSent as RawOutstanding from vw_po_list2 p 
				left join (
					SELECT POID, COALESCE(SUM(RawQty), 0) - COALESCE(SUM(RawSent2), 0) as RawOutstanding, COALESCE(SUM(RawSent2), 0) as RawSent2
					FROM vw_po_raw3 GROUP BY POID
				) t2 on p.POID=t2.POID ";

		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] != "3") {
			$sql .= "WHERE POStatus = '".$_REQUEST['status']."' ";
		} else if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] == "3") {
			$sql .= "WHERE POStatus != 3 ";
		} else { 
			$sql .= "WHERE totalqty<>totaldor and POStatus != 2 and POStatus != 1 ";
		}

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) &&  $_REQUEST['input2'] != "" ) {
			$sql .= "and PODate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'POID':
						$sql .= "p.POID like '%".$atributevalue[$i]."%' ";
						break;
					case 'RAWID':
						$sql .= "p.POID in (SELECT DISTINCT POID FROM tb_po_raw WHERE RawID = '".$atributevalue[$i]."') ";
						break;
					case 'ProductID':
						$sql .= "p.POID in (SELECT DISTINCT POID FROM tb_po_product WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'Company':
						$sql .= "SupplierID in (SELECT SupplierID FROM vw_supplier1 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					default:
						$sql .= $atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'POID' => $row->POID,
		  			'ROID' => $row->ROID,
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
		  			'RawOutstanding' => $row->RawOutstanding,
		  			'RawSent2' => $row->RawSent,
	  				// 'rawsent' => $row->totaldo
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function purchase_order_print()
	{
		$this->db->trans_start();

		$show   = array();
		$POID 	= $this->input->get_post('po');
		$sql 	= "SELECT pm.*, em.fullname 
					from tb_po_main pm 
					left join vw_user_account em on (pm.POBy = em.UserAccountID) 
					where POID = ".$POID;
		$getrow	= $this->db->query($sql);
		$rowpo 	= $getrow->row();
		$show['po'] = $rowpo;

		$sql 	= "SELECT * from tb_job_company where CompanyID = ".$rowpo->BillingTo;
		$getrow	= $this->db->query($sql);
		$show['company'] = $getrow->row();


		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowpo->ShippingTo;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT pp.*, pm.ProductName from tb_po_product pp left join tb_product_main pm on (pp.ProductID = pm.ProductID) where POID = ".$rowpo->POID;
		// echo $sql;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['product'][] = array(
	  			'ProductID' => $row->ProductID,
	  			'ProductName' => $row->ProductName,
	  			'ProductSupplierCode' => $row->ProductSupplierCode,
	  			'ProductQty' => $row->ProductQty,
				'ProductDisc' => $row->ProductDisc,
				'ProductPrice' => $row->ProductPrice,
				'ProductPriceTotal' => $row->ProductPriceTotal,
				'ProductPrice2' => $row->ProductPrice2,
				'ProductPriceTotal2' => $row->ProductPriceTotal2
			);
		  	$sqlraw	= "SELECT pr.*, pm.ProductName from tb_po_raw pr left join tb_product_main pm on (pr.RawID = pm.ProductID) where pr.POID = ".$rowpo->POID." and pr.ProductID = ".$row->ProductID;
			$queryraw	= $this->db->query($sqlraw);
			foreach ($queryraw->result() as $rowraw) {
			  	$show['raw'][$row->ProductID][] = array(
		  			'ProductName' => $rowraw->ProductName,
		  			'RawQty' => $rowraw->RawQty
				);
			};
		};

		if ($rowpo->isApprove != 1) {
        	redirect(base_url('transaction/purchase_order_list'));
		}

	    return $show;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_dor()
	{
		$this->db->trans_start();

		$POID 	= $this->input->get_post('po');
		$sql 	= "SELECT pm.*, pl.*, GROUP_CONCAT(dd.DistributionID SEPARATOR ', ') AS DistributionID
					from vw_po_product_dor_price_main pm 
					left join vw_po_list2 pl on (pm.DORReff = pl.POID)
					LEFT JOIN tb_bank_distribution_detail dd ON dd.ReffType='DOR' AND dd.ReffNo=pm.DORID ";

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) &&  $_REQUEST['input2'] != "" ) {
			$sql .= "WHERE DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		} else {
			$sql .= "WHERE dd.DistributionID is NULL and pm.ProductPriceTotal>0 ";
		}
		$sql .= "GROUP BY pm.DORID ";

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$Supplier 	= explode(";", $row->SupplierNote);
			// $ProductPriceTotal = $row->ProductPriceTotal + ($row->ProductPriceTotal * ($row->TaxRate/100));
		  	$show[] = array(
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
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_cancel()
	{
		$this->db->trans_start();

		$cancelnote = $this->input->post('cancelnote');
		$POID 		= $this->input->post('poid'); 

		// cek PO - DOR
		$sql 	= "SELECT pp.POID, SUM(pp.DORQty) AS DORQty, pr.RawSent
					FROM tb_po_product pp
					LEFT JOIN ( SELECT 	POID, COALESCE(SUM(RawSent),0) AS RawSent FROM tb_po_raw ) as pr ON (pp.POID = pr.POID)
					WHERE pp.POID =".$POID;
		$getrow	= $this->db->query($sql);
		$rowDOR 	= $getrow->row();

		if ($rowDOR->DORQty == 0 and $rowDOR->RawSent == 0) {
			$data = array(
				'POCancelNote' => $cancelnote,
				'POCancelDate' => date('Y-m-d H:i:s'),
				'POStatus' => "2"
			);
			$this->db->where('POID', $POID);
			$this->db->update('tb_po_main', $data);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "SELECT pp.POID, pp.ProductID, pm.ROID, pp.ProductQty AS qtypo, rp.ProductPO AS qtyro
						FROM tb_po_product pp
						LEFT JOIN tb_po_main pm ON (pp.POID = pm.POID)
						LEFT JOIN (SELECT rp.ROID,rp.ProductID, rp.total as ProductPO FROM vw_ro_product rp) as rp ON (pm.ROID = rp.ROID and pp.ProductID = rp.ProductID )
						WHERE pp.POID = ". $POID;
			$query 	= $this->db->query($sql);
			$show   = array();
			$ROID 	= "";
			foreach ($query->result() as $row) {
			  	$qtyresult = $row->qtyro - $row->qtypo;
				$this->db->set('ProductPO', $qtyresult);
				$this->db->where('ROID', $row->ROID);
				$this->db->where('ProductID', $row->ProductID);
				$this->db->update('tb_ro_product');
				$this->last_query .= "//".$this->db->last_query();
				$ROID 	= $row->ROID;
			};
			$this->update_pending_ro($ROID);
			$this->update_status_ro($ROID);
		}

		$this->db->set('isComplete', 1);
		$this->db->set('Status', "Rejected");
		$this->db->where('POID', $POID);
		$this->db->where('isComplete', 0);
		$this->db->update('tb_approval_po');
		$this->last_query .= "//".$this->db->last_query();

		$this->update_pending_product_po($POID);
		$this->update_pending_raw_po($POID);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_expired()
	{
		$this->db->trans_start();

		$note = $this->input->post('note');
		$POID = $this->input->post('poid'); 

		$sql 	= "SELECT ROID, SupplierNote FROM tb_po_main WHERE POID =".$POID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$ROID 	= $row->ROID; 
		$supplier = explode(';', $row->SupplierNote)[0]; 

		$data = array(
			'POExpiredNote' => $note,
			'POStatus' => "1"
		);
		$this->db->where('POID', $POID);
		$this->db->update('tb_po_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='purchase_order_expired' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		$query = "update tb_po_main set POExpiredDate='".date('Y-m-d H:i:s')."' where POID='".$POID."'";
		if ($Actor3 != 0) {
			$data_approval = array(
		        'POID' => $POID,
	        	'isComplete' => "0",
	        	'Status' => "OnProgress",
		        'Title' => "PO ".$POID." : ".$supplier,
		        'Note' => "PO Expired Note : ".$note,
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_po_expired', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
		        'POID' => $POID,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
		        'Title' => "PO ".$POID." : ".$supplier,
		        'Note' => "PO Expired Note : ".$note,
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_po', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->query($query);
			$this->last_query .= "//".$this->db->last_query();

			$this->update_pending_ro($ROID);
			$this->update_status_ro($ROID);
			$this->update_pending_product_po($POID);
			$this->update_pending_raw_po($POID);
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function purchase_order_detail_full()
	{
		$POID 	= $this->input->get_post('poid');
		$show['POID'] = $POID;

		$sql 	= "SELECT pp.*, plp.ProductCode, plp.ProductName, plp.ProductSupplier, plp.ProductPriceHPP, plp.stock from tb_po_product pp ";
		$sql 	.= "left join vw_product_list_popup2 plp on pp.ProductID = plp.ProductID ";
		$sql 	.= "where POID = ".$POID;
		// echo $sql;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['product'][] = array(
				'ProductID' => $row2->ProductID,
				'ProductCode' => $row2->ProductCode,
				'ProductName' => $row2->ProductName,
				'ProductQty' => $row2->ProductQty
			);
			$sql 	= "SELECT pp.POID, dm.DORID, dm.DORDate, dd.ProductID, dd.ProductQty
						FROM tb_po_product pp
						LEFT JOIN tb_po_main pm ON (pp.POID = pm.POID)
						LEFT JOIN tb_dor_main dm ON (pm.POID = dm.DORReff)
						LEFT JOIN tb_dor_detail dd ON (dm.DORID = dd.DORID)
						WHERE pp.ProductID = ".$row2->ProductID." AND pp.POID = ".$POID." AND dm.DORType = 'PO' AND dd.ProductID = pp.ProductID";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row4) {
			  	$show['dor'][$row2->ProductID][] = array(
		  			'DORID' => $row4->DORID,
		  			'DORDate' => $row4->DORDate,
		  			'ProductQty' => $row4->ProductQty
				);
			};
		};

		$sql = "SELECT * FROM tb_so_file
				WHERE SOID IN (
				SELECT rm.SOID FROM tb_po_main pm
				LEFT JOIN tb_ro_main rm ON pm.ROID=rm.ROID
				WHERE pm.POID=".$POID."
				)";
		$query5	= $this->db->query($sql);
		foreach ($query5->result() as $row5) {
	  		$show['SOfile'][] = array(
			  	'SOFileID' => $row5->SOFileID,
			  	'SOID' => $row5->SOID,
			  	'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function purchase_order_detail_raw_full()
	{
		$POID 	= $this->input->get_post('poid');
		$show 	= array();
		$sql 	= "SELECT pr.*, plp.ProductCode as rawname, plp2.ProductCode as productname, pr.RawSent from tb_po_raw pr ";
		$sql 	.= "left join vw_product_list_popup2 plp on pr.RawID = plp.ProductID ";
		$sql 	.= "left join vw_product_list_popup2 plp2 on pr.ProductID = plp2.ProductID ";
		$sql 	.= "where pr.POID = ".$POID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['raw'][] = array(
	  			'RawID' => $row2->RawID,
	  			'ProductID' => $row2->ProductID,
	  			'RawName' => $row2->rawname,
	  			'ParentName' => $row2->productname,
	  			'RawQty' => $row2->RawQty,
	  			'RawSent' => $row2->RawSent
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function approval_submission_po($POID, $supplier, $note = "")
	{
		$this->db->trans_start();

   		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='purchase_order' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		$this->db->set('isApprove', 0);
		$this->db->where('POID', $POID);
		$this->db->update('tb_po_main');
		$this->last_query .= "//".$this->db->last_query();

		$this->db->set('isComplete', 1);
		$this->db->set('Status', "Rejected");
		$this->db->where('POID', $POID);
		$this->db->where('isComplete', 0);
		$this->db->update('tb_approval_po');
		$this->last_query .= "//".$this->db->last_query();

		$query = "update tb_po_main set isApprove='1' where POID='".$POID."'";
		if ($Actor3 != 0) {
			$data_approval = array(
		        'POID' => $POID,
	        	'isComplete' => "0",
	        	'Status' => "OnProgress",
		        'Title' => "PO ".$POID." : ".$supplier,
		        'Note' => $note,
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_po', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
		        'POID' => $POID,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
		        'Title' => "PO ".$POID." : ".$supplier,
		        'Note' => $note,
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_po', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->query($query);
			$this->last_query .= "//".$this->db->last_query();

			$this->update_status_po($POID);
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	} 
	function cekAmount_DOR()
	{
		$ReffTypeMain = $this->input->get_post('ReffTypeMain');
		$ReffNoMain = $this->input->get_post('ReffNoMain');

		$sql 	= "SELECT ProductPriceTotal FROM vw_po_product_dor_price_main WHERE isApprove=1 and DORID=".$ReffNoMain." limit 1";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		if (!empty($row)) {
			$ProductPriceTotal = $row->ProductPriceTotal;
		} else {
			$ProductPriceTotal = 0;
		}
		echo json_encode($ProductPriceTotal);
	}
	function update_po_shipping_date($POID,$DODate)
	{
		$this->db->trans_start();
		$sql = "SELECT POID, COALESCE(SUM(RawQty), 0) - COALESCE(SUM(RawSent2), 0) as RawOutstanding 
				FROM vw_po_raw where POID='".$POID."' GROUP BY POID ";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$RawOutstanding = $row->RawOutstanding;

		if ($RawOutstanding <=0) {
			$sql = "SELECT DATEDIFF(ShippingDate,PODate) as ShippingDays FROM tb_po_main WHERE POID=".$POID; 
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			$ShippingDays 	= $row->ShippingDays;

			$NewShippingDays = date('Y-m-d', strtotime($DODate. ' + '.$ShippingDays.' days'));
			$this->db->set('ShippingDate', $NewShippingDays);
			$this->db->where('POID', $POID);
			$this->db->update('tb_po_main'); 
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function update_status_po($po)
	{
		$this->db->trans_start();

		$sql 	= "SELECT pm.POID, pm.POStatus, pm.isApprove, t1.Pending1, coalesce(t2.Pending2,0) as Pending2 FROM tb_po_main pm
					LEFT JOIN (
						SELECT pp.POID, SUM(pp.Pending) AS Pending1 FROM tb_po_product pp WHERE pp.POID=".$po." GROUP BY pp.POID
					) t1 ON pm.POID = t1.POID
					LEFT JOIN (
						SELECT pr.POID, SUM(pr.Pending) AS Pending2 FROM tb_po_raw pr WHERE pr.POID=".$po." GROUP BY pr.POID
					) t2 ON pm.POID = t2.POID
					WHERE pm.POID=".$po;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		if ($row->isApprove == 1) {
			if ($row->Pending1 == 0 && $row->Pending2 == 0) {
				$this->db->set('POStatus', 1);
			} else {
				$this->db->set('POStatus', 0);
			}
			$this->db->where('POID', $po);
			$this->db->update('tb_po_main');
			$this->last_query .= "//".$this->db->last_query();

			if ($row->Pending1 == 0 && $row->Pending2 == 0) {
				// for auto journal
				$sql = "SELECT coalesce(SUM(pr.RawSent*pr.ProductHPP),0) AS RAWAmount
						FROM tb_po_raw pr where pr.POID=".$po;
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$RAWAmount = $row->RAWAmount;
				if ($RAWAmount > 0) {
					$this->load->model('model_acc');
					$this->model_acc->auto_journal_po_complete($po, $RAWAmount);
				}
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

//delivery order received ==================================================
	function delivery_order_received_list_po()
	{
		$sql = "SELECT dm.*, wm.*, 
				vem.fullname as employee, 
				vsup.fullname as supplier, 
				vsup.Company FROM tb_dor_main dm ";
		$sql .= "LEFT JOIN vw_user_account vem ON (dm.DORBy = vem.UserAccountID) ";
		$sql .= "LEFT JOIN tb_po_main pm ON (dm.DORReff = pm.POID and dm.DORType='PO') ";
		$sql .= "LEFT JOIN vw_supplier1 vsup ON (pm.SupplierID = vsup.SupplierID) ";
		$sql .= "LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) where dm.DORType = 'PO' ";

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'DORID':
						$sql .= "dm.DORID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORReff':
						$sql .= "dm.DORReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORType':
						$sql .= "dm.DORType like '%".$atributevalue[$i]."%' ";
						break;
					case 'ProductID':
						$sql .= "dm.DORID in (SELECT DISTINCT DORID FROM tb_dor_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'DORDoc':
						$sql .= "dm.DORDoc like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'Company':
						$sql .= "dm.DORReff in (SELECT POID FROM tb_po_main pm
								LEFT JOIN vw_supplier1 s1 ON pm.SupplierID=s1.SupplierID
								WHERE s1.Company2 LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (empty($_POST)) {
			$sql .= "and MONTH(dm.DORDate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DORDate) = YEAR(CURRENT_DATE()) ";
		}
		$sql .= "GROUP BY dm.DORID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		// echo $sql;
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'DORID' => $row->DORID,
		  			'DORReff' => $row->DORType." ".$row->DORReff,
		  			'from' => $row->supplier.", ".$row->Company,
		  			'to' => $row->WarehouseName,
		  			'employee' => $row->employee,
					'DORDoc' => $row->DORDoc,
		  			'DORDate' => $row->DORDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_list_mutation()
	{
		$sql = "SELECT dm.*, pm.*, wm.WarehouseName as wmfrom, wm2.WarehouseName as wmto, vem.fullname as employee
				FROM tb_dor_main dm
				LEFT JOIN vw_user_account vem ON (dm.DORBy = vem.UserAccountID)
				LEFT JOIN tb_product_mutation pm ON (dm.DORReff = pm.MutationID and dm.DORType='MUTATION')
				LEFT JOIN tb_warehouse_main wm ON (pm.WarehouseFrom = wm.WarehouseID)
				LEFT JOIN tb_warehouse_main wm2 ON (dm.WarehouseID = wm2.WarehouseID) where dm.DORType = 'MUTATION' ";

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'DORID':
						$sql .= "dm.DORID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORReff':
						$sql .= "dm.DORReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORType':
						$sql .= "dm.DORType like '%".$atributevalue[$i]."%' ";
						break;
					case 'ProductID':
						$sql .= "dm.DORID in (SELECT DISTINCT DORID FROM tb_dor_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'DORDoc':
						$sql .= "dm.DORDoc like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'Company':
						$sql .= "dm.DORReff in (SELECT MutationID FROM tb_product_mutation pm
								LEFT JOIN tb_warehouse_main s1 ON pm.WarehouseFrom=s1.WarehouseID
								WHERE s1.WarehouseName LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (empty($_POST)) {
			$sql .= "and MONTH(dm.DORDate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DORDate) = YEAR(CURRENT_DATE()) ";
		}
		$sql 	.= "GROUP BY dm.DORID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'DORID' => $row->DORID,
		  			'DORReff' => $row->DORType." ".$row->DORReff,
		  			'from' => $row->wmfrom,
		  			'to' => $row->wmto,
		  			'employee' => $row->employee,
					'DORDoc' => $row->DORDoc,
		  			'DORDate' => $row->DORDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_list_do()
	{
		$sql = "SELECT dm.*, sm.BillingAddress, wm2.WarehouseName AS wmto,	vem.fullname AS employee
				FROM tb_dor_main dm
				LEFT JOIN vw_user_account vem ON (dm.DORBy = vem.UserAccountID)
				LEFT JOIN tb_do_main dm2 ON (dm.DORReff = dm2.DOID and dm.DORType='DO')
				LEFT JOIN tb_so_main sm ON (dm2.DOReff = sm.SOID and dm2.DOType='SO')
				LEFT JOIN tb_warehouse_main wm2 ON (dm.WarehouseID = wm2.WarehouseID)
				WHERE	dm.DORType = 'DO' ";
		
		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'DORID':
						$sql .= "dm.DORID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORReff':
						$sql .= "dm.DORReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORType':
						$sql .= "dm.DORType like '%".$atributevalue[$i]."%' ";
						break;
					case 'ProductID':
						$sql .= "dm.DORID in (SELECT DISTINCT DORID FROM tb_dor_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'DORDoc':
						$sql .= "dm.DORDoc like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'Company':
						$sql .= "dm.DORReff in (SELECT DOID FROM tb_do_main dm
								LEFT JOIN tb_warehouse_main s1 ON dm.WarehouseID=s1.WarehouseID
								WHERE s1.WarehouseName LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (empty($_POST)) {
			$sql .= "and MONTH(dm.DORDate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DORDate) = YEAR(CURRENT_DATE()) ";
		}

		$sql 	.= "GROUP BY dm.DORID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$from = explode(";", $row->BillingAddress);
		  	$show[] = array(
		  			'DORID' => $row->DORID,
		  			'DORReff' => $row->DORType." ".$row->DORReff,
		  			'from' => $from[0],
		  			'to' => $row->wmto,
		  			'employee' => $row->employee,
					'DORDoc' => $row->DORDoc,
		  			'DORDate' => $row->DORDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_list_inv()
	{
		$sql = "SELECT dm.*, im.BillingAddress, wm2.WarehouseName AS wmto,	vem.fullname AS employee
				FROM tb_dor_main dm
				LEFT JOIN vw_user_account vem ON (dm.DORBy = vem.UserAccountID)
				LEFT JOIN tb_invoice_main im ON (dm.DORReff = im.INVID and dm.DORType='INV')
				LEFT JOIN tb_warehouse_main wm2 ON (dm.WarehouseID = wm2.WarehouseID)
				WHERE dm.DORType = 'INV' ";
		
		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DORDate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'DORID':
						$sql .= "dm.DORID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORReff':
						$sql .= "dm.DORReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DORType':
						$sql .= "dm.DORType like '%".$atributevalue[$i]."%' ";
						break;
					case 'ProductID':
						$sql .= "dm.DORID in (SELECT DISTINCT DORID FROM tb_dor_detail WHERE ProductID = '".$atributevalue[$i]."') ";
						break;
					case 'DORDoc':
						$sql .= "dm.DORDoc like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'Company':
						$sql .= "dm.DORReff in (SELECT DOID FROM tb_do_main dm
								LEFT JOIN tb_warehouse_main s1 ON dm.WarehouseID=s1.WarehouseID
								WHERE s1.WarehouseName LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		if (empty($_POST)) {
			$sql .= "and MONTH(dm.DORDate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DORDate) = YEAR(CURRENT_DATE()) ";
		}

		$sql 	.= "GROUP BY dm.DORID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$from = explode(";", $row->BillingAddress);
		  	$show[] = array(
		  			'DORID' => $row->DORID,
		  			'DORReff' => $row->DORType." ".$row->DORReff,
		  			'from' => $from[0],
		  			'to' => $row->wmto,
		  			'employee' => $row->employee,
					'DORDoc' => $row->DORDoc,
		  			'DORDate' => $row->DORDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function purchase_to_dor()
	{
		$sql = "SELECT pm.*, 
				vem.fullname as employee, 
				vsup.fullname as supplier, 
				vsup.Company, ";
		$sql .= "SUM(pp.ProductQty) as qty, SUM(pp.DORQty) as qtydor FROM tb_po_main pm ";
		$sql .= "LEFT JOIN vw_user_account vem ON (pm.ModifiedBy = vem.UserAccountID) ";
		$sql .= "LEFT JOIN vw_supplier1 vsup ON (pm.SupplierID = vsup.SupplierID) ";
		$sql .= "LEFT JOIN tb_po_product pp ON (pm.POID = pp.POID) ";
		$sql .= "WHERE pm.isApprove=1 and pm.POStatus = 0 ";
		$sql .= "GROUP BY pm.POID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'POID' => $row->POID,
		  			'PODate' => $row->PODate,
					'ShippingDate' => $row->ShippingDate,
					'supplier' => $row->supplier.", ".$row->Company,
					'employee' => $row->employee,
					'PONote' => $row->PONote,
					'qty' => $row->qty,
					'POStatus' => $row->POStatus
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function mutation_to_dor()
	{
		$sql = "SELECT pm.*, vem.fullname, wm1.WarehouseName as wmfrom, wm2.WarehouseName as wmto, pmd.StatusOut
				FROM tb_product_mutation pm
				LEFT JOIN vw_user_account vem ON (pm.MutationBy = vem.UserAccountID)
				LEFT JOIN tb_warehouse_main wm1 ON (pm.WarehouseFrom = wm1.WarehouseID)
				LEFT JOIN tb_warehouse_main wm2 ON (pm.WarehouseTo = wm2.WarehouseID) 
				LEFT JOIN (select MutationID, StatusOut from tb_product_mutation_detail group by MutationID) as pmd on (pm.MutationID = pmd.MutationID) 
				WHERE pm.MutationStatus =0 and pmd.StatusOut=1 ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'MutationID' => $row->MutationID,
		  			'from' => $row->wmfrom,
					'to' => $row->wmto,
					'fullname' => $row->fullname,
		  			'MutationDate' => $row->MutationDate,
		  			'MutationInput' => $row->MutationInput,
		  			'MutationStatus' => $row->MutationStatus
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function po_to_dor_detail()
	{
		$POID 	= $this->input->get_post('po');
		$sql 	= "SELECT pm.*, wm.* from tb_po_main pm 
					left join tb_warehouse_main wm on (pm.ShippingTo=wm.WarehouseID) 
					where pm.isApprove=1 and pm.POID = ".$POID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->POStatus == 0) {
			$supplier = explode(";", $row->SupplierNote);
			$show['main'] = array(
	  			'DORType' => "PO",
	  			'DORReff' => $row->POID,
	  			'DORFrom' => "Supplier",
	  			'suppliername' => $supplier[0],
	  			'supplieraddr' => $supplier[2],
	  			'supplierphone' => $supplier[3],
	  			'to' => "ANGHAUZ INDONESIA",
	  			'WarehouseID' => $row->WarehouseID,
	  			'WarehouseName' => $row->WarehouseName,
	  			'WarehouseAddress' => $row->WarehouseAddress
			);
			$sql 	= "SELECT pp.*, plp.ProductCode, plp.ProductSupplier, 
						COALESCE(pr.RawQty,0) AS RawQty, COALESCE(pr.RawSent,0) AS RawSent, Stockable 
						from tb_po_product pp 
						left join vw_product_list_popup2 plp on pp.ProductID = plp.ProductID 
						LEFT JOIN (
							SELECT ProductID, SUM(RawQty) AS RawQty, SUM(RawSent) AS RawSent
							FROM tb_po_raw WHERE POID =".$POID." GROUP BY ProductID
						) pr ON pr.ProductID=pp.ProductID
						where POID =".$POID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductSupplier' => $row2->ProductSupplier,
		  			'ProductQty' => $row2->ProductQty,
					'DORQty' => $row2->DORQty,
					'RawQty' => $row2->RawQty,
					'RawSent' => $row2->RawSent,
					'Stockable' => $row2->Stockable
				);
			};
			$show['product2'] = json_encode($show['product']);
			// print_r($show['product']);
		} else {
        	redirect(base_url('transaction/delivery_order_received_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function do_to_dor_detail()
	{
		$DOID 	= $this->input->get_post('doid');

		$sql 	= "SELECT INVID	FROM tb_invoice_main WHERE DOID = ".$DOID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$sql 	= "SELECT dm.*, sm.SOID, sm.ShipAddress, sm.BillingAddress FROM tb_do_main dm
						LEFT JOIN tb_so_main sm ON (dm.DOReff=sm.SOID) 
						where DOID = ".$DOID;
			$getrow	= $this->db->query($sql);
			$row 	= $getrow->row();
			$show   = array();
			$ShipAddress = explode(";", $row->ShipAddress);
			$show['main'] = array(
	  			'DORType' => "DO",
	  			'DORReff' => $row->DOID,
	  			'SOID' => $row->SOID,
	  			'DORFrom' => $ShipAddress[0]."<br>".$ShipAddress[2]
			);
			$show['warehouse'] = $this->warehouse_list();

			$sql 	= "SELECT dd.*, plp.ProductCode, drpd.totaldor
						FROM tb_do_detail dd
						LEFT JOIN vw_product_list_popup2 plp ON (dd.ProductID = plp.ProductID)
						LEFT JOIN vw_do_reff_product_detail drpd ON (drpd.DOID = dd.DOID and drpd.ProductID = dd.ProductID)
						WHERE dd.DOID =".$DOID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductQty' => $row2->ProductQty,
					'DORQty' => $row2->totaldor
				);
			};
			$show['product2'] = json_encode($show['product']);
			// print_r($show['product']);
		    return $show;
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
		$this->log_user->log_query($this->last_query);
	}
	function inv_to_dor_detail()
	{
		$INVID 	= $this->input->get_post('invid');

		$sql 	= "SELECT *	FROM tb_invoice_main WHERE INVID = ".$INVID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$show   = array();
			$ShipAddress = explode(";", $row->ShipAddress);
			$show['main'] = array(
	  			'DORType' => "INV",
	  			'DORReff' => $row->INVID,
	  			'DORFrom' => $ShipAddress[0]."<br>".$ShipAddress[2]
			);
			$show['warehouse'] = $this->warehouse_list();

			$sql 	= "SELECT id.*, plp.ProductCode, coalesce(drpd.totaldor,0) as totaldor FROM tb_invoice_detail id
						LEFT JOIN vw_product_list_popup2 plp ON (id.ProductID = plp.ProductID) 
						LEFT JOIN vw_dor_reff_product drpd ON (drpd.DORType='INV' and drpd.DORReff = id.INVID and drpd.ProductID = id.ProductID) 
						WHERE id.INVID=".$row->INVID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductQty' => $row2->ProductQty,
					'DORQty' => $row2->totaldor
				);
			};
			$show['product2'] = json_encode($show['product']);
			// print_r($show['product']);
		    return $show;
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
		$this->log_user->log_query($this->last_query);
	}
	function mutation_to_dor_detail()
	{
		$MutationID	= $this->input->get_post('mutationid');
		$sql 	= "SELECT pm.*, vem.fullname, wm1.WarehouseName as wmfrom, wm2.WarehouseName as wmto
					FROM tb_product_mutation pm
					LEFT JOIN vw_user_account vem ON (pm.MutationBy = vem.UserAccountID)
					LEFT JOIN tb_warehouse_main wm1 ON (pm.WarehouseFrom = wm1.WarehouseID)
					LEFT JOIN tb_warehouse_main wm2 ON (pm.WarehouseTo = wm2.WarehouseID) 
					WHERE pm.MutationID = ".$MutationID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->MutationStatus == 0) {
			$show['main'] = array(
	  			'DORType' => "MUTATION",
	  			'DORReff' => $row->MutationID,
	  			'DORFrom' => "ANGHAUZ INDONESIA",
	  			'from' => $row->WarehouseFrom,
	  			'to' => $row->WarehouseTo,
	  			'note' => $row->MutationNote
			);
			$sql 	= "SELECT pm.*, plp.ProductCode, plp.stock from tb_product_mutation_detail pm ";
			$sql 	.= "left join vw_product_list_popup2 plp on pm.ProductID = plp.ProductID ";
			$sql 	.= "where MutationID = ".$MutationID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductQty' => $row2->ProductQty,
					'stock' => $row2->stock
				);
			};
			$show['product2'] = json_encode($show['product']);

			$sql 	= "SELECT * from tb_warehouse_main";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row3) {
			  	$show['warehouse'][] = array(
		  			'WarehouseID' => $row3->WarehouseID,
		  			'WarehouseName' => $row3->WarehouseName
				);
			};
		} else {
        	redirect(base_url('transaction/delivery_order_received_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_add_act_po()
	{
		$this->db->trans_start();

		$DORType	= $this->input->post('type');
		$DORReff	= $this->input->post('reff');
		$DORDoc		= $this->input->post('doc');
		$DORDate	= $this->input->post('date');
		$EXPDate	= $this->input->post('expdate');
		$DORNote	= $this->input->post('note');
		$DORBy		= $this->session->userdata('UserAccountID');
		$DORInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$productqtyreceived = $this->input->post('productqtyreceived');
		$stockable = $this->input->post('stockable');
		$data = array(
			'DORType' => $DORType,
			'DORReff' => $DORReff,
			'DORDoc' => $DORDoc,	
			'WarehouseID' => $WarehouseID,	
			'DORDate' => $DORDate,
			'DORNote' => $DORNote,
			'DORBy' => $DORBy,	
			'DORInput' => $DORInput
		);
		$this->db->insert('tb_dor_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		$sql 		= "select max(DORID) as DORID from tb_dor_main ";
		$getDORID 	= $this->db->query($sql);
		$row 		= $getDORID->row();
		$DORID 		= $row->DORID;

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'DORID' => $DORID,
					'DORType' => $DORType,
					'DORReff' => $DORReff,
					'WarehouseID' => $WarehouseID,
					'ProductID' => $productid[$i],
					'ProductQty' => $productqty[$i],
				);
				$this->db->insert('tb_dor_detail', $data_product);
				$this->last_query .= "//".$this->db->last_query();
	   		};
			for ($i=0; $i < count($productqty);$i++) { 
				if ($stockable[$i] == 1) {
					$this->stock_add($productid[$i], $productqty[$i], $WarehouseID, "DOR".$DORID, $EXPDate[$i]);
					$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], $EXPDate[$i], "DOR",$DORID);
				}
	   		};
		}

		// auto journal ------------------- 
			$sql 		= "SELECT t1.ProductPriceTotal, pm.TaxRate
							FROM (
								SELECT pp.POID, SUM(dd.ProductQty*pp.ProductPrice) AS ProductPriceTotal
								FROM tb_dor_detail dd
								LEFT JOIN tb_dor_main dm ON dm.DORID=dd.DORID
								LEFT JOIN tb_po_product pp ON dm.DORReff=pp.POID AND dd.ProductID=pp.ProductID
								WHERE dd.DORID=".$DORID."
							) t1 
							LEFT JOIN tb_po_main pm ON pm.POID=t1.POID";
			$getDORID 	= $this->db->query($sql);
			$row 		= $getDORID->row();
			$TaxRate = $row->TaxRate;
			$ProductPriceTotal = $row->ProductPriceTotal + ($row->ProductPriceTotal*($TaxRate/100));

			$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityIn*pm.ProductPriceHPP),0) AS DORValue
					FROM tb_product_stock_in so
					LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
					WHERE so.NoReff = 'DOR".$DORID."'
					GROUP BY so.NoReff";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$DORValue = (count($row) >0 ) ? $row->DORValue : 0 ;

			$this->load->model('model_acc');
			$this->model_acc->auto_journal_dor_po($DORID, $WarehouseID, $DORReff, $ProductPriceTotal, $TaxRate, $DORValue);
		// -------------------------------------

		$this->update_pending_product_po($DORReff);
		$this->update_status_po($DORReff);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// echo $this->last_query;
	}
	function delivery_order_received_add_act_do()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$DORType	= $this->input->post('type');
		$DORReff	= $this->input->post('reff');
		$DORDoc		= $this->input->post('doc');
		$DORDate	= $this->input->post('date');
		$DORNote	= $this->input->post('note');
		$returfc	= $this->input->post('returfc');
		$DORBy		= $this->session->userdata('UserAccountID');
		$DORInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$productqtyreceived = $this->input->post('productqtyreceived');
		$data = array(
			'DORType' => $DORType,
			'DORReff' => $DORReff,
			'DORDoc' => $DORDoc,	
			'WarehouseID' => $WarehouseID,	
			'DORDate' => $DORDate,
			'DORNote' => $DORNote,
			'DORBy' => $DORBy,	
			'DORInput' => $DORInput
		);
		$this->db->insert('tb_dor_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DORID) as DORID from tb_dor_main ";
		$getDORID 	= $this->db->query($sql);
		$row 		= $getDORID->row();
		$DORID 		= $row->DORID;

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'DORID' => $DORID,
					'DORType' => $DORType,
					'DORReff' => $DORReff,
					'WarehouseID' => $WarehouseID,
					'ProductID' => $productid[$i],
					'ProductQty' => $productqty[$i],
				);
				$this->db->insert('tb_dor_detail', $data_product);
				$this->last_query .= "//".$this->db->last_query();
				$this->stock_add($productid[$i], $productqty[$i], $WarehouseID, "DOR".$DORID, $EXPDate[$i]);
					$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], $EXPDate[$i], "DOR",$DORID);

	   		};
		}

		$sql 	= "select INVID, DOID from tb_invoice_main where DOID=".$DORReff;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
		 	$returfc = ($returfc == null) ? 0 : $returfc ;
			$this->invoice_update($row->INVID, $row->DOID, $returfc);
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function delivery_order_received_add_act_inv($data = array())
	{
		$this->db->trans_start();

		$DORType	= (empty($data)) ? $this->input->post('type') : $data['DORType'] ;
		$DORReff	= (empty($data)) ? $this->input->post('reff') : $data['DORReff'] ;
		$DORDoc		= (empty($data)) ? $this->input->post('doc') : $data['DORDoc'] ;
		$DORDate	= (empty($data)) ? $this->input->post('date') : $data['DORDate'] ;
		$DORNote	= (empty($data)) ? $this->input->post('note') : $data['DORNote'] ;
		$DORBy		= $this->session->userdata('UserAccountID');
		$DORInput	= date('Y-m-d H:i:s');
		$WarehouseID= (empty($data)) ? $this->input->post('warehouse') : $data['WarehouseID'] ;

		$productid 	= (empty($data)) ? $this->input->post('productid') : $data['productid'] ;
		$productqty = (empty($data)) ? $this->input->post('productqty') : $data['productqty'] ;
		$productqtyreceived = (empty($data)) ? $this->input->post('productqtyreceived') : 0 ;
		$data = array(
			'DORType' => $DORType,
			'DORReff' => $DORReff,
			'DORDoc' => $DORDoc,	
			'WarehouseID' => $WarehouseID,	
			'DORDate' => $DORDate,
			'DORNote' => $DORNote,
			'DORBy' => $DORBy,	
			'DORInput' => $DORInput
		);
		$this->db->insert('tb_dor_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DORID) as DORID from tb_dor_main ";
		$getDORID 	= $this->db->query($sql);
		$row 		= $getDORID->row();
		$DORID 		= $row->DORID;

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'DORID' => $DORID,
					'DORType' => $DORType,
					'DORReff' => $DORReff,
					'WarehouseID' => $WarehouseID,
					'ProductID' => $productid[$i],
					'ProductQty' => $productqty[$i],
				);
				$this->db->insert('tb_dor_detail', $data_product);
				$this->last_query .= "//".$this->db->last_query();
				$this->stock_add($productid[$i], $productqty[$i], $WarehouseID, "DOR".$DORID, 0);
				$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], 0, "DOR",$DORID);

	   		};
		}

		// auto journal ------------------------------
			$sql 	= "SELECT sum(id.ProductHPP*dd.ProductQty) AS DORAmount
					FROM tb_dor_main t1 
					LEFT JOIN tb_dor_detail dd ON dd.DORID=t1.DORID
					LEFT JOIN tb_invoice_detail id ON t1.DORReff=id.INVID AND dd.ProductID=id.ProductID
					WHERE t1.DORID=".$DORID;
			$get 	= $this->db->query($sql);
			$row 	= $get->row();
			$DORAmount 	= $row->DORAmount;

			$sql = "SELECT SUM(t1.ProductQty*pm.ProductPriceHPP) AS DORAmount
					FROM tb_dor_detail t1 
					LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
					WHERE t1.DORID=".$DORID;
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$DORValue = $row->DORAmount;

			$this->load->model('model_acc');
			$this->model_acc->auto_journal_dor_inv($DORID, $WarehouseID, $DORAmount, $DORValue);
		// --------------------------------------------

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function delivery_order_received_add_act_mutation()
	{
		$this->db->trans_start();
		$DORType	= $this->input->post('type');
		$DORReff	= $this->input->post('reff');
		$DORDoc		= $this->input->post('doc');
		$DORDate	= $this->input->post('date');
		// $EXPDate	= $this->input->post('expdate');
		$DORNote	= $this->input->post('note');
		$DORBy		= $this->session->userdata('UserAccountID');
		$DORInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse2');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$data = array(
			'DORType' => $DORType,
			'DORReff' => $DORReff,
			'DORDoc' => $DORDoc,	
			'WarehouseID' => $WarehouseID,	
			'DORDate' => $DORDate,
			'DORNote' => $DORNote,
			'DORBy' => $DORBy,	
			'DORInput' => $DORInput
		);
		$this->db->insert('tb_dor_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DORID) as DORID from tb_dor_main ";
		$getDORID 	= $this->db->query($sql);
		$row 		= $getDORID->row();
		$DORID 		= $row->DORID;

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'DORID' => $DORID,
					'DORType' => $DORType,
					'DORReff' => $DORReff,
					'WarehouseID' => $WarehouseID,
					'ProductID' => $productid[$i],
					'ProductQty' => $productqty[$i],
				);
				$this->db->insert('tb_dor_detail', $data_product);
				$this->last_query .= "//".$this->db->last_query();

				$this->stock_add($productid[$i], $productqty[$i], $WarehouseID, "DOR".$DORID, 0);
				$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], 0, "DOR",$DORID);

	   		};
		}
		$this->db->set('MutationStatus', 1);
		$this->db->where('MutationID', $DORReff);
		$this->db->update('tb_product_mutation');
		$this->last_query .= "//".$this->db->last_query();

		$this->update_pending_mutation($DORReff);

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_dor_mutation($DORID, $WarehouseID, $DORReff);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function delivery_order_received_print_po()
	{
		$show   = array();
		$DORID 	= $this->input->get_post('dor');
		$sql 	= "SELECT drm.*, em.fullname, pm.BillingTo, pm.ShippingTo, pm.SupplierNote, pm.TaxRate 
					from tb_dor_main drm 
					left join tb_po_main pm on (drm.DORReff = pm.POID) 
					left join vw_user_account em on (drm.DORBy = em.UserAccountID) 
					where DORID = ".$DORID;
		$getrow	= $this->db->query($sql);
		$rowdor 	= $getrow->row();
		$show['dor'] = $rowdor;

		$sql 	= "SELECT * from tb_job_company where CompanyID = ".$rowdor->BillingTo;
		$getrow	= $this->db->query($sql);
		$show['company'] = $getrow->row();


		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdor->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT dd.ProductID, pm.ProductCode, dd.ProductQty AS qtyreceive, pp.ProductQty AS qtyorder, pp.ProductPrice, 
					COALESCE(dd2.ProductQty,0) AS qtyreceived FROM tb_dor_detail dd
					LEFT JOIN tb_dor_main dm ON (dd.DORID = dm.DORID)
					LEFT JOIN tb_po_product pp ON (dm.DORReff = pp.POID)
					LEFT JOIN tb_product_main pm ON (dd.ProductID = pm.ProductID)

					LEFT JOIN (
					SELECT dm.DORType, dm.DORReff, dd.ProductID, SUM(dd.ProductQty) AS ProductQty
					FROM tb_dor_detail dd
					LEFT JOIN tb_dor_main dm ON (dd.DORID = dm.DORID)
					WHERE dm.DORType='PO' AND dm.DORReff=".$rowdor->DORReff." AND dm.DORID<".$DORID."
					GROUP BY dd.ProductID
					) AS dd2 ON dd.ProductID=dd2.ProductID

					WHERE dd.DORID = ".$DORID."
					AND dd.ProductID = pp.ProductID";

		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['product'][] = array(
		  		'ProductID' => $row->ProductID,
		  		'ProductCode' => $row->ProductCode,
		  		'ProductPrice' => $row->ProductPrice,
	  			'qtyreceived' => $row->qtyreceived,
	  			'qtyorder' => $row->qtyorder,
	  			'qtyreceive' => $row->qtyreceive	  			
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_print_do()
	{
		$show   = array();
		$DORID 	= $this->input->get_post('dor');
		$sql 	= "SELECT dm.*, sm.SOID, sm.ShipAddress, vem.fullname AS employee
				FROM tb_dor_main dm
				LEFT JOIN vw_user_account vem ON (dm.DORBy = vem.UserAccountID)
				LEFT JOIN tb_do_main dm2 ON (dm.DORReff = dm2.DOID)
				LEFT JOIN tb_so_main sm ON (dm2.DOReff = sm.SOID)
				WHERE DORID = ".$DORID;
		$getrow	= $this->db->query($sql);
		$rowdor 	= $getrow->row();
		$show['dor'] = $rowdor;

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdor->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT dd.ProductID, pm.ProductCode, dd.ProductQty AS qtyreceive from tb_dor_detail dd 
					LEFT JOIN tb_product_main pm ON (dd.ProductID = pm.ProductID) where dd.DORID = ".$DORID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['product'][] = array(
		  		'ProductID' => $row->ProductID,
		  		'ProductCode' => $row->ProductCode,
	  			'qtyreceive' => $row->qtyreceive	  			
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_print_inv()
	{
		$show   = array();
		$DORID 	= $this->input->get_post('dor');
		$sql 	= "SELECT dm.*, im.INVID, im.ShipAddress, vem.fullname AS employee
				FROM tb_dor_main dm
				LEFT JOIN vw_user_account vem ON (dm.DORBy = vem.UserAccountID)
				LEFT JOIN tb_invoice_main im ON (dm.DORReff = im.INVID)
				WHERE DORID = ".$DORID;
		$getrow	= $this->db->query($sql);
		$rowdor 	= $getrow->row();
		$show['dor'] = $rowdor;

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdor->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT dd.ProductID, pm.ProductCode, dd.ProductQty AS qtyreceive from tb_dor_detail dd 
					LEFT JOIN tb_product_main pm ON (dd.ProductID = pm.ProductID) where dd.DORID = ".$DORID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['product'][] = array(
		  		'ProductID' => $row->ProductID,
		  		'ProductCode' => $row->ProductCode,
	  			'qtyreceive' => $row->qtyreceive	  			
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_received_print_mutation()
	{
		$show   = array();
		$DORID 	= $this->input->get_post('dor');
		$sql 	= "SELECT drm.*, em.fullname, pm.* 
					from tb_dor_main drm 
					LEFT JOIN tb_product_mutation pm ON (drm.DORReff = pm.MutationID) 
					left join vw_user_account em on (drm.DORBy = em.UserAccountID) 
					where DORID = ".$DORID;
		$getrow	= $this->db->query($sql);
		$rowdor = $getrow->row();
		$show['dor'] = $rowdor;

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdor->WarehouseFrom;
		$getrow	= $this->db->query($sql);
		$show['warehouse1'] = $getrow->row();
		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdor->WarehouseTo;
		$getrow	= $this->db->query($sql);
		$show['warehouse2'] = $getrow->row();

		$sql 	= "SELECT dd.*, plp.ProductCode
					FROM tb_dor_detail dd
					LEFT JOIN vw_product_list_popup2 plp ON (dd.ProductID = plp.ProductID)
					WHERE dd.DORID=".$DORID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['product'][] = array(
		  		'ProductID' => $row->ProductID,
		  		'ProductCode' => $row->ProductCode,
	  			'qtyreceive' => $row->ProductQty	  			
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	// ---------------------------------------------------
	function cek_dor_approval()
	{
		$result = FALSE;
        if ($_REQUEST['type'] == "PO") {
			$result = FALSE;
        } else if ($_REQUEST['type'] == "MUTATION") {
			$result = FALSE;
        } else if ($_REQUEST['type'] == "INV") {
			$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='dor_invr' ";
			$getActor3 	= $this->db->query($sql);
			$row 		= $getActor3->row();
			$Actor3 	= $row->Actor3;
			if ($Actor3 != 0) {
				$result = TRUE;
			}
        }
        return $result;
	}
	function cek_dor_approval_not_complete()
	{
		$result = FALSE;
        if (isset($_REQUEST['po'])) {
			$DORType 	= "PO";
			$DORReff 	= $this->input->get_post('po');
        } else if (isset($_REQUEST['mutationid'])) {
			$DORType 	= "MUTATION";
			$DORReff	= $this->input->get_post('mutationid');
        } else if (isset($_REQUEST['invid'])) {
			$DORType 	= "INV";
			$DORReff 	= $this->input->get_post('invid');
        }
		$sql 	= "select count(DORID) as DORID from tb_dor_approval_main 
					where DORType='".$DORType."' and DORReff='".$DORReff."' and DORStatus=0 ";
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$DORID 	= $row->DORID;
		if ($DORID > 0) {
			$result = TRUE;
		}
        return $result;
	}
	function delivery_order_received_approval()
	{
		$this->db->trans_start();

		$DORType	= $this->input->post('type');
		$DORReff	= $this->input->post('reff');
		$DORDoc		= $this->input->post('doc');
		$DORDate	= $this->input->post('date');
		$DORNote	= $this->input->post('note');
		$DORBy		= $this->session->userdata('UserAccountID');
		$DORInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$productqtyreceived = $this->input->post('productqtyreceived');
		$data = array(
			'DORType' => $DORType,
			'DORReff' => $DORReff,
			'DORDoc' => $DORDoc,	
			'WarehouseID' => $WarehouseID,	
			'DORDate' => $DORDate,
			'DORNote' => $DORNote,
			'DORStatus' => 0,
			'DORBy' => $DORBy,	
			'DORInput' => $DORInput
		);
		$this->db->insert('tb_dor_approval_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DORID) as DORID from tb_dor_approval_main ";
		$getDORID 	= $this->db->query($sql);
		$row 		= $getDORID->row();
		$DORID 		= $row->DORID;

		if (isset($productid)) {
			for ($i=0; $i < count($productid);$i++) { 
	   			$data_product = array(
	   				'DORID' => $DORID,
					'DORType' => $DORType,
					'DORReff' => $DORReff,
					'WarehouseID' => $WarehouseID,
					'ProductID' => $productid[$i],
					'ProductQty' => $productqty[$i],
				);
				$this->db->insert('tb_dor_approval_detail', $data_product);
				$this->last_query .= "//".$this->db->last_query();
	   		};
		}

		// ------------------------------------------
		if ($DORType == "INV") {
			$table = 'tb_approval_dor_invr';
		}
		$data_approval = array(
	        'DORID' => $DORID,
        	'isComplete' => "0",
        	'Status' => "OnProgress",
	        'Title' => "DOR from : ".$DORType." ".$DORReff,
	        'Note' => $DORNote,
		);
		$this->db->insert($table, $data_approval);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function approval_dor_implementation($DORID, $DORType, $ApprovalID)
	{
		$this->db->trans_start();

		$data = array();
		if ($DORType == 'INV') {
			$sql 	= "SELECT * FROM tb_dor_approval_main t1 
						WHERE DORStatus=1 and t1.DORID=".$DORID;
			$query 	= $this->db->query($sql);
			$row	= $query->row();
			if (!empty($row)) {
				$data['DORType'] = $row->DORType;
				$data['DORReff'] = $row->DORReff;
				$data['WarehouseID'] = $row->WarehouseID;
				$data['DORDoc'] = $row->DORDoc;
				$data['DORDate'] = $row->DORDate;
				$data['DORNote'] = $row->DORNote;

				$data['productid'] = array();
				$data['productqtyreceived'] = array();
				$data['productqty'] = array();

				$sql 	= "SELECT dd.*, id.ProductQty as INVQty
							FROM tb_dor_approval_detail dd
							LEFT JOIN tb_invoice_detail id ON id.INVID=dd.DORReff AND dd.ProductID=id.ProductID 
							WHERE dd.DORID=".$DORID;
				$query 	= $this->db->query($sql);
				foreach ($query->result() as $row) {
					array_push($data['productid'], $row->ProductID);
					array_push($data['productqty'], $row->ProductQty);
				}
				$this->delivery_order_received_add_act_inv($data);
			}
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

//delivery order ===========================================================
	function delivery_order_list_po()
	{
		$sql = "SELECT dm.*, pm.*, wm.*, vem.fullname as employee, 
				vsup.fullname as supplier, vsup.Company, dd2.DOQty 
				FROM tb_do_main dm 
				LEFT JOIN (
					SELECT dd.DOID, SUM(dd.ProductQty) AS DOQty
					FROM tb_do_detail dd GROUP BY dd.DOID
				) dd2 ON (dd2.DOID=dm.DOID) 
				LEFT JOIN vw_user_account vem ON (dm.DOBy = vem.UserAccountID) 
				LEFT JOIN tb_po_main pm ON (dm.DOReff = pm.POID) 
				LEFT JOIN vw_supplier1 vsup ON (pm.SupplierID = vsup.SupplierID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) ";

		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] != "3") {
			$sql .= "WHERE dm.DOStatus = '".$_REQUEST['status']."' ";
		} else if (isset($_REQUEST['status']) && $_REQUEST['status'] == "3") {
			$sql .= "WHERE dm.DOStatus != '3' ";
		} else {
			$sql .= "WHERE dm.DOStatus = '0' ";
		}

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DODate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
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
						break;
					case 'DONote':
						$sql .= "dm.DONote like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'DOID':
						$sql .= "dm.DOID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DOReff':
						$sql .= "dm.DOReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DOType':
						$sql .= "dm.DOType like '%".$atributevalue[$i]."%' ";
						break;
					case 'Company':
						$sql .= "dm.DOReff in (SELECT POID FROM tb_po_main pm
								LEFT JOIN vw_supplier1 s1 ON pm.SupplierID=s1.SupplierID
								WHERE s1.Company2 LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		// if (empty($_POST)) {
		// 	$sql .= "and MONTH(dm.DODate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DODate) = YEAR(CURRENT_DATE()) ";
		// }
		$sql .= "and DOType = 'RAW PO' GROUP BY dm.DOID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'DOID' => $row->DOID,
		  			'type' => $row->DOType,
		  			'Reff' => $row->DOType." ".$row->DOReff,
		  			'ReffOnly' => $row->DOReff,
		  			'Company' => $row->supplier.", ".$row->Company,
		  			'CompanyOnly' => $row->Company,
					'ShipName' => "",
					'WarehouseName' => $row->WarehouseName,
		  			'DODate' => $row->DODate,
		  			'DONote' => $row->DONote,
		  			'DOStatus' => $row->DOStatus,
		  			'Employee' => $row->employee,
		  			'DOQty' => $row->DOQty,
					'ShipAddress' => "",
					'CategoryName' => "",
					'Label' => "",
					'DaysFromOrderDate' => ""
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_list_so()
	{
		$sql = "SELECT dm.*, wm.WarehouseName, sm.PaymentWay, sc.CategoryName,  
				vem.fullname as employee, vcus.Company2, fp.PaymentAmount, sm.ShipAddress, 
				sc.CategoryName, DATEDIFF(sysdate(),sm.SODate) AS DaysFromOrderDate, dd2.DOQty, sm2.Label 
				FROM tb_do_main dm 
				LEFT JOIN (
					SELECT dd.DOID, SUM(dd.ProductQty) AS DOQty
					FROM tb_do_detail dd GROUP BY dd.DOID
				) dd2 ON (dd2.DOID=dm.DOID) 
				LEFT JOIN vw_user_account vem ON (dm.DOBy = vem.UserAccountID) 
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID) 
				LEFT JOIN tb_so_main2 sm2 ON (dm.DOReff = sm2.SOID) 
				LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID) 
				LEFT JOIN vw_contact2 vcus ON (cm.ContactID = vcus.ContactID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
				LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
				LEFT JOIN tb_fc_payment fp ON (dm.DOID=fp.DOID) ";

		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] != "3") {
			$sql .= "WHERE dm.DOStatus = '".$_REQUEST['status']."' ";
		} else if (isset($_REQUEST['status']) && $_REQUEST['status'] == "3") {
			$sql .= "WHERE dm.DOStatus != '3' ";
		} else {
			$sql .= "WHERE dm.DOStatus = '0' ";
		}

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DODate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
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
						break;
					case 'DONote':
						$sql .= "dm.DONote like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'DOID':
						$sql .= "dm.DOID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DOReff':
						$sql .= "dm.DOReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DOType':
						$sql .= "dm.DOType like '%".$atributevalue[$i]."%' ";
						break;
					case 'Company':
						$sql .= "dm.DOReff in (SELECT SOID FROM tb_so_main sm
								LEFT JOIN vw_customer2 s1 ON sm.CustomerID=s1.CustomerID
								WHERE s1.Company2 LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		// if (empty($_POST)) {
		// 	$sql .= "and MONTH(dm.DODate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DODate) = YEAR(CURRENT_DATE()) ";
		// }
		$sql .= "and DOType = 'SO' GROUP BY dm.DOID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$ShipAddress = explode(";",$row->ShipAddress);
		  	$show[] = array(
		  			'DOID' => $row->DOID,
		  			'type' => $row->DOType,
		  			'Reff' => $row->DOType." ".$row->DOReff." ".$row->CategoryName,
		  			'ReffOnly' => $row->DOReff,
		  			'Company' => $row->PaymentWay.' - '.$row->Company2,
		  			'CompanyOnly' => $row->Company2,
					'WarehouseName' => $row->WarehouseName,
		  			'DODate' => $row->DODate,
		  			'DONote' => $row->DONote,
		  			'DOStatus' => $row->DOStatus,
		  			'Employee' => $row->employee,
		  			'DOQty' => $row->DOQty,
		  			'PaymentAmount' => $row->PaymentAmount,
					'ShipName' => $ShipAddress[1],
					'ShipAddress' => $ShipAddress[2],
					'CategoryName' => $row->CategoryName,
					'Label' => $row->Label,
					'DaysFromOrderDate' => $row->DaysFromOrderDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_list_mutation()
	{
		$sql = "SELECT dm.*, vem.fullname as employee, fp.PaymentAmount, wm.WarehouseName, dd2.DOQty
				FROM tb_do_main dm
				LEFT JOIN (
					SELECT dd.DOID, SUM(dd.ProductQty) AS DOQty
					FROM tb_do_detail dd GROUP BY dd.DOID
				) dd2 ON (dd2.DOID=dm.DOID) 
				LEFT JOIN vw_user_account vem ON (dm.DOBy = vem.UserAccountID)
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
				LEFT JOIN tb_fc_payment fp ON (dm.DOID=fp.DOID) ";

		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] != "3") {
			$sql .= "WHERE dm.DOStatus = '".$_REQUEST['status']."' ";
		} else if (isset($_REQUEST['status']) && $_REQUEST['status'] == "3") {
			$sql .= "WHERE dm.DOStatus != '3' ";
		} else {
			$sql .= "WHERE dm.DOStatus = '0' ";
		}

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && isset($_REQUEST['input2']) && $_REQUEST['input2'] != "" ) {
			$sql .= "and dm.DODate between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
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
						break;
					case 'DONote':
						$sql .= "dm.DONote like '%".$atributevalue[$i]."%' ";
						break;
					case 'Warehouse':
						$sql .= "dm.WarehouseID in (SELECT WarehouseID FROM tb_warehouse_main WHERE WarehouseName like '%".$atributevalue[$i]."%') ";
						break;
					case 'DOID':
						$sql .= "dm.DOID like '%".$atributevalue[$i]."%' ";
						break;
					case 'DOReff':
						$sql .= "dm.DOReff like '%".$atributevalue[$i]."%' ";
						break;
					case 'DOType':
						$sql .= "dm.DOType like '%".$atributevalue[$i]."%' ";
						break;
					case 'Company':
						$sql .= "dm.DOReff in (SELECT MutationID FROM tb_product_mutation pm
								LEFT JOIN tb_warehouse_main s1 ON pm.WarehouseTo=s1.WarehouseID
								WHERE s1.WarehouseName LIKE '%".$atributevalue[$i]."%') ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}

		// if (empty($_POST)) {
		// 	$sql .= "and MONTH(dm.DODate) = MONTH(CURRENT_DATE()) AND YEAR(dm.DODate) = YEAR(CURRENT_DATE()) ";
		// }
		$sql .= "and DOType = 'MUTATION' GROUP BY dm.DOID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'DOID' => $row->DOID,
		  			'type' => $row->DOType,
		  			'ReffOnly' => $row->DOReff,
		  			'Reff' => $row->DOType." ".$row->DOReff,
		  			'Company' => "ANGHAUZ INDONESIA",
		  			'CompanyOnly' => "ANGHAUZ INDONESIA",
		  			'ShipName' => "ANGHAUZ INDONESIA",
					'WarehouseName' => $row->WarehouseName,
		  			'DODate' => $row->DODate,
		  			'DONote' => $row->DONote,
		  			'DOStatus' => $row->DOStatus,
		  			'Employee' => $row->employee,
		  			'DOQty' => $row->DOQty,
		  			'PaymentAmount' => $row->PaymentAmount,
					'ShipAddress' => "",
					'CategoryName' => "",
					'Label' => "",
					'DaysFromOrderDate' => ""
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function purchase_to_do()
	{
		$sql = "SELECT pm.*, vem.fullname as employee, vsup.fullname as supplier, vsup.Company, 
				COALESCE(SUM(pr.RawQty), 0) as qty, COALESCE(SUM(pr.RawSent), 0) as qtysent, 
				COALESCE(SUM(pr.RawQty), 0) - COALESCE(SUM(pr.RawSent), 0) as totalsent,
				GROUP_CONCAT( DISTINCT pr.stockReady ORDER BY pr.stockReady SEPARATOR ',') AS stockReady ";

		if (isset($_REQUEST['WarehouseID'])) {
			$sql .= "FROM ( 
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
					) pr ";
		} else {
			$sql .= "FROM vw_po_raw3 pr ";
		}
		$sql .= "LEFT JOIN tb_po_main pm ON (pm.POID = pr.POID)   
				LEFT JOIN vw_user_account vem ON (pm.ModifiedBy = vem.UserAccountID)
				LEFT JOIN vw_supplier1 vsup ON (pm.SupplierID = vsup.SupplierID) 
				where pm.POStatus <> 2 and pm.isApprove=1 GROUP BY pm.POID 
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
		$this->log_user->log_query($this->last_query);
	}
	function mutation_to_do()
	{
		$sql = "SELECT pm.*, vem.fullname, wm1.WarehouseName as wmfrom, wm2.WarehouseName as wmto, pmd.StatusOut
				FROM tb_product_mutation pm
				LEFT JOIN vw_user_account vem ON (pm.MutationBy = vem.UserAccountID)
				LEFT JOIN tb_warehouse_main wm1 ON (pm.WarehouseFrom = wm1.WarehouseID)
				LEFT JOIN tb_warehouse_main wm2 ON (pm.WarehouseTo = wm2.WarehouseID) 
				LEFT JOIN (select MutationID, StatusOut from tb_product_mutation_detail group by MutationID) as pmd on (pm.MutationID = pmd.MutationID) 
				WHERE pm.MutationStatus=0 and pm.MutationApprove=1 and pmd.StatusOut=0 ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'MutationID' => $row->MutationID,
		  			'from' => $row->wmfrom,
					'to' => $row->wmto,
					'fullname' => $row->fullname,
		  			'MutationDate' => $row->MutationDate,
		  			'MutationInput' => $row->MutationInput,
		  			'MutationStatus' => $row->MutationStatus,
					'DaysFromOrderDate' => ""
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function so_to_do()
	{
		$sql 	= "SELECT sl.*, DATEDIFF(sysdate(), sl.SODate) AS DaysFromOrderDate, 
					GROUP_CONCAT( DISTINCT sdd.stockReady ORDER BY sdd.stockReady SEPARATOR ',') AS stockReady
					FROM vw_so_list5 sl ";
		if (isset($_REQUEST['WarehouseID'])) {
			$sql .= "LEFT JOIN ( 
						SELECT sd.SOID AS SOID, sd.SalesOrderDetailID AS SalesOrderDetailID, sd.ProductID AS ProductID, 
						sd.ProductName AS ProductName, sd.ProductQty AS ProductQty, sd.ProductWeight AS ProductWeight,
						( sd.ProductQty - sd.Pending ) AS totaldo, 0 AS totaldor, sd.Pending AS pending, 
						( sd.ProductWeight * ( sd.ProductQty - sd.Pending ) ) AS totalweight,
						sm.SOConfirm1 AS SOConfirm1, sm.SOConfirm2 AS SOConfirm2, sm.SOStatus AS SOStatus, ps.stock AS stock,
						IF ( ( (sm.SOStatus = 1) AND ( ps.stock >= sd.Pending ) ), 'Ready', 'NotReady' ) AS stockReady
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
		$sql .= "WHERE (sl.totaldo < sl.qty)
					AND sl.SOStatus = 1
					AND sl.SOConfirm1 = 1
					AND sl.SOConfirm2 = 1
					GROUP BY sl.SOID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$shipping = explode(";", $row->ShipAddress );
			$customer = $shipping[0];
			$address  = $shipping[2];
			$PaymentPerc = $this->get_percent_floor($row->SOTotal, $row->TotalDeposit+$row->TotalPayment);
		  	$show[] = array(
		  			'SOID' => $row->SOID,
		  			'customer' => $customer,
					'address' => $address,
					'SONote' => $row->SONote,
					'PaymentWay' => $row->PaymentWay,
					'PaymentPerc' => $PaymentPerc,
					'shipdate' => $row->SOShipDate,
					'TotalDeposit' => $row->TotalDeposit+$row->TotalPayment,
					'SOTotal' => $row->SOTotal,
		  			'qty' => $row->qty,
		  			'totaldo' => $row->totaldo,
		  			'stockReady' => $row->stockReady,
					'DaysFromOrderDate' => $row->DaysFromOrderDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function so_to_do_detail()
	{
		$SOID 	= $this->input->get_post('so');
		$sql 	= "SELECT * from vw_so_list5 where SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->SOConfirm1 == 1 && $row->SOConfirm2 == 1) {
			if ($row->TotalDeposit == "CBD" && $row->TotalDeposit+$row->TotalPayment < $row->SOTotal) {
	        	redirect(base_url('transaction/delivery_order_list'));
			} 
			$show['main'] = get_object_vars($row);
			$show['main2'] = json_encode($show['main']);
			$show['warehouse'] = $this->warehouse_list();

			// get product
			$sql = "SELECT sd.*, sd.ProductQty-sd.Pending AS totaldo, 
					0 AS totaldor, sps.pending as pendingDO, 
					sdp.Type as PriorityType, sdp.ID as PriorityID, sdp.Pending as PriorityQty, pm.Stockable 
					FROM tb_so_detail sd  
					LEFT JOIN vw_stock_pending_so_raw sps ON sd.ProductID=sps.ProductID 
					LEFT JOIN tb_product_main pm ON sd.ProductID=pm.ProductID 
					LEFT JOIN (
					SELECT dp.* FROM vw_do_priority dp 
					INNER JOIN (

					SELECT dp2.ProductID, MIN(dp2.Date) AS Date FROM vw_do_priority dp2 GROUP BY dp2.ProductID
					) dp3 ON dp.ProductID=dp3.ProductID AND dp.Date=dp3.Date
					group by dp.ProductID order by dp.ProductID, dp.dateInput 

					) sdp ON sd.ProductID=sdp.ProductID 
					WHERE sd.SOID =".$SOID;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['product'][] = array(
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					// 'totaldo' => $row->totaldo - $row->totaldor
					'totaldo' => $row->totaldo,
					'pendingDO' => $row->pendingDO,
					'PriorityType' => $row->PriorityType,
					'PriorityID' => $row->PriorityID,
					'PriorityQty' => $row->PriorityQty,
					'Stockable' => $row->Stockable,
				);
			};
			$show['product2'] = json_encode($show['product']);
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function po_to_do_detail()
	{
		$POID 	= $this->input->get_post('po');
		$sql 	= "SELECT pm.* from tb_po_main pm where pm.isApprove=1 and pm.POID = ".$POID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->POStatus <> 2) {
			$supplier = explode(";", $row->SupplierNote);
			$show['main'] = array(
	  			'DOType' => "RAW PO",
	  			'DOReff' => $row->POID,
	  			'DOFrom' => "ANGHAUZ INDONESIA",
	  			'to' => "SUPPLIER",
	  			'suppliername' => $supplier[0],
	  			'supplieraddr' => $supplier[2],
	  			'supplierphone' => $supplier[3],
			);
			$sql 	= "SELECT pr.*, plp.ProductCode, plp.ProductSupplier, drp.totaldor, vpr.RawSent2 from tb_po_raw pr ";
			$sql 	.= "LEFT JOIN vw_po_raw vpr ON pr.POID=vpr.POID AND pr.ProductID=vpr.ProductID AND pr.RawID=vpr.RawID ";
			$sql 	.= "left join vw_product_list_popup2 plp on pr.RawID = plp.ProductID ";
			$sql 	.= "LEFT JOIN vw_dor_reff_product drp ON (drp.DORType='PO' AND drp.DORReff=".$POID." AND drp.ProductID=pr.ProductID) ";
			$sql 	.= "where pr.POID = ".$POID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductParent' => $row2->ProductID,
		  			'totaldor' => $row2->totaldor,
		  			'ProductID' => $row2->RawID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductSupplier' => $row2->ProductSupplier,
		  			'ProductQty' => $row2->RawQty,
					'QtySent' => $row2->RawSent2
				);
			};
			$show['product2'] = json_encode($show['product']);

			$sql 	= "SELECT * from tb_warehouse_main";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row3) {
			  	$show['warehouse'][] = array(
		  			'WarehouseID' => $row3->WarehouseID,
		  			'WarehouseName' => $row3->WarehouseName
				);
			};
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function mutation_to_do_detail()
	{
		$MutationID	= $this->input->get_post('mutationid');
		$sql 	= "SELECT pm.*, vem.fullname, wm1.WarehouseName as wmfrom, wm2.WarehouseName as wmto
					FROM tb_product_mutation pm
					LEFT JOIN vw_user_account vem ON (pm.MutationBy = vem.UserAccountID)
					LEFT JOIN tb_warehouse_main wm1 ON (pm.WarehouseFrom = wm1.WarehouseID)
					LEFT JOIN tb_warehouse_main wm2 ON (pm.WarehouseTo = wm2.WarehouseID) 
					WHERE pm.MutationID = ".$MutationID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->MutationStatus == 0) {
			$show['main'] = array(
	  			'DOType' => "MUTATION",
	  			'DOReff' => $row->MutationID,
	  			'DOFrom' => "ANGHAUZ INDONESIA",
	  			'from' => $row->WarehouseFrom,
	  			'to' => $row->WarehouseTo,
	  			'note' => $row->MutationNote,
			);
			$sql 	= "SELECT pm.*, plp.ProductCode, plp.stock from tb_product_mutation_detail pm ";
			$sql 	.= "left join vw_product_list_popup2 plp on pm.ProductID = plp.ProductID ";
			$sql 	.= "where MutationID = ".$MutationID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductQty' => $row2->ProductQty,
					'stock' => $row2->stock
				);
			};
			$show['product2'] = json_encode($show['product']);
			$show['warehouse'] = $this->warehouse_list();
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_add_act_po()
	{
		$this->db->trans_begin();

		$DOType	= $this->input->post('type');
		$DOReff	= $this->input->post('reff');
		$DODate	= $this->input->post('date');
		$DONote	= $this->input->post('note');
		$DOBy	= $this->session->userdata('UserAccountID');
		$DOInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$productparent = $this->input->post('productparent');
		$productqtysent = $this->input->post('productqtysent');

		$sql = "UPDATE tb_po_raw t, tb_product_main pm
				SET t.ProductHPP = pm.ProductPriceHPP
				WHERE t.ProductHPP=0 AND t.RawID = pm.ProductID AND t.POID=".$DOReff;
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$data = array(
			'DOType' => $DOType,
			'DOReff' => $DOReff,
			'WarehouseID' => $WarehouseID,	
			'DODate' => $DODate,
			'DONote' => $DONote,
			'DOBy' => $DOBy,
			'DOInput' => $DOInput,
			'DOStatus' => 0
		);
		$this->db->insert('tb_do_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DOID) as DOID from tb_do_main ";
		$getDOID 	= $this->db->query($sql);
		$row 		= $getDOID->row();
		$DOID 		= $row->DOID;

		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
   				'DOID' => $DOID,
				'DOType' => $DOType,
				'DOReff' => $DOReff,	
				'DODate' => $DODate,
				'WarehouseID' => $WarehouseID,
				'ProductID' => $productid[$i],
				'ProductQty' => $productqty[$i],
				'ProductParent' => $productparent[$i],
			);
			$this->db->insert('tb_do_detail', $data_product);
			$this->last_query .= "//".$this->db->last_query();
   		};

   		$qtyLast = 0;
		for ($i=0; $i < count($productqty);$i++) { 
			$qtynow = $this->stock_min($productid[$i], $productqty[$i], $WarehouseID, "DO".$DOID, $productparent[$i]);
			$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], 0, "DO",$DOID);
			$qtyLast = ($qtyLast < $qtynow) ? $qtyLast : $qtynow ;
   		};
		// $this->update_po_shipping_date($DOReff,$DODate);
		$this->update_pending_raw_po($DOReff);

		// for auto journal
		$sql = "SELECT SUM(t1.ProductQty*pr.ProductHPP) AS RAWAmount
				FROM tb_do_detail t1 
				LEFT JOIN tb_po_raw pr ON t1.DOReff=pr.POID AND t1.ProductID=pr.RAWID AND t1.ProductParent=pr.ProductID
				WHERE t1.DOID=".$DOID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$RAWAmount = $row->RAWAmount;

		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmount = $row->DOAmount;

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_do($DOID, 'po', $DOReff, $WarehouseID, 'add', $DOAmount, $DODate.date(" H:i:s"), $RAWAmount);
		// ------------------------------------

		$this->log_user->log_query($this->last_query);
		// echo $this->last_query;
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} elseif ($qtyLast < 0) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	function delivery_order_add_act_mutation()
	{
		$this->db->trans_begin();

		$DOType	= $this->input->post('type');
		$DOReff	= $this->input->post('reff');
		$DODate	= $this->input->post('date');
		$DONote	= $this->input->post('note');
		$DOBy	= $this->session->userdata('UserAccountID');
		$DOInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse');

		$productid 	= $this->input->post('productid');
		$productqtyorder = $this->input->post('productqtyorder');
		$data = array(
			'DOType' => $DOType,
			'DOReff' => $DOReff,
			'WarehouseID' => $WarehouseID,	
			'DODate' => $DODate,
			'DONote' => $DONote,
			'DOBy' => $DOBy,
			'DOInput' => $DOInput,
			'DOStatus' => 1
		);
		$this->db->insert('tb_do_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DOID) as DOID from tb_do_main ";
		$getDOID 	= $this->db->query($sql);
		$row 		= $getDOID->row();
		$DOID 		= $row->DOID;
		
		$qtyLast = 0;
		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
   				'DOID' => $DOID,
				'DOType' => $DOType,
				'DOReff' => $DOReff,	
				'DODate' => $DODate,
				'WarehouseID' => $WarehouseID,
				'ProductID' => $productid[$i],
				'ProductQty' => $productqtyorder[$i]
			);
			$this->db->insert('tb_do_detail', $data_product);
			$this->last_query .= "//".$this->db->last_query();

			$qtynow = $this->stock_min($productid[$i], $productqtyorder[$i], $WarehouseID, "DO".$DOID);
			$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], 0, "DO",$DOID);
			$qtyLast = ($qtyLast < $qtynow) ? $qtyLast : $qtynow ;
   		};
   		$this->db->set('StatusOut', 1);
		$this->db->where('MutationID', $DOReff);
		$this->db->update('tb_product_mutation_detail');
		$this->last_query .= "//".$this->db->last_query();
		
		$this->update_pending_mutation($DOReff);

		// for auto journal
		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmount = $row->DOAmount;
		$this->load->model('model_acc');
		$this->model_acc->auto_journal_do($DOID, 'mutation', $DOReff, $WarehouseID, 'add', $DOAmount, $DODate.date(" H:i:s"));
		// --------------------------------

		$this->log_user->log_query($this->last_query);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} elseif ($qtyLast < 0) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	function delivery_order_add_act_so()
	{
		$this->db->trans_begin();

		// echo json_encode($this->input->post());
		$DOType	= $this->input->post('type');
		$DOReff	= $this->input->post('reff');
		$DODate	= $this->input->post('date');
		$DONote	= $this->input->post('note');
		$DOBy	= $this->session->userdata('UserAccountID');
		$DOInput	= date('Y-m-d H:i:s');
		$WarehouseID= $this->input->post('warehouse');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$data = array(
			'DOType' => $DOType,
			'DOReff' => $DOReff,
			'WarehouseID' => $WarehouseID,	
			'DODate' => $DODate,
			'DONote' => $DONote,
			'DOBy' => $DOBy,
			'DOInput' => $DOInput,
			'DOStatus' => 0
		);
		$this->db->insert('tb_do_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DOID) as DOID from tb_do_main ";
		$getDOID 	= $this->db->query($sql);
		$row 		= $getDOID->row();
		$DOID 		= $row->DOID;

		$qtyLast = 0;
		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
   				'DOID' => $DOID,
				'DOType' => $DOType,
				'DOReff' => $DOReff,	
				'DODate' => $DODate,
				'WarehouseID' => $WarehouseID,
				'ProductID' => $productid[$i],
				'ProductQty' => $productqty[$i]
			);
			$this->db->insert('tb_do_detail', $data_product);
			$this->last_query .= "//".$this->db->last_query();
			$qtynow = $this->stock_min($productid[$i], $productqty[$i], $WarehouseID, "DO".$DOID);
			$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], 0, "DO",$DOID);
			//disini 
			$qtyLast = ($qtyLast < $qtynow) ? $qtyLast : $qtynow ;
   		};
		$this->update_pending_so($DOReff);

   		// for auto journal
		$sql = "SELECT SUM(t1.ProductQty*sd.ProductHPP) AS SOAmount
				FROM (
					SELECT dd.*, dm.DOReff AS SOID FROM tb_do_main dm
					LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
					WHERE dm.DOID=".$DOID."
				) t1 
				LEFT JOIN tb_so_detail sd 
					ON t1.SOID=sd.SOID AND t1.SalesOrderDetailID=sd.SalesOrderDetailID AND t1.ProductID=sd.ProductID";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$SOAmount = $row->SOAmount;

		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmount = $row->DOAmount;
		$this->load->model('model_acc');
		$this->model_acc->auto_journal_do($DOID, 'so', $DOReff, $WarehouseID, 'add', $DOAmount, $DODate.date(" H:i:s"), $SOAmount);
		// --------------------------------

		$this->log_user->log_query($this->last_query);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} elseif ($qtyLast < 0) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	function do_so_edit_detail()
	{
		$DOID 	= $this->input->get_post('do');
		$sql 	= "SELECT dm.*, sm.BillingAddress, sm.ShipAddress, sm.SOCategory from tb_do_main dm 
					LEFT JOIN tb_so_main sm ON (dm.DOReff=sm.SOID) where DOID =".$DOID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->DOStatus == 0 and $row->DOType == "SO") {
			$show['main'] = get_object_vars($row);
			$show['main2'] = json_encode($show['main']);
			$show['warehouse'] = $this->warehouse_list();

			// get product
			$sql 	= "SELECT dd.*, dm.DOReff, sd.ProductName, sd.ProductQty as SOQty, sd.Pending as SOPending, dd.SalesOrderDetailID, sd.SOID
						FROM tb_do_detail dd 
						LEFT JOIN tb_do_main dm ON (dd.DOID=dm.DOID) 
						LEFT JOIN tb_so_detail sd ON (dm.DOReff=sd.SOID and dd.ProductID=sd.ProductID and dd.SalesOrderDetailID=sd.SalesOrderDetailID) 
						WHERE dd.DOID=".$DOID;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['product'][] = array(
					'ProductID' => $row->ProductID,
					'SalesOrderDetailID' => $row->SalesOrderDetailID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					// 'totaldo' => $row->totaldo - $row->totaldor
					'SOQty' => $row->SOQty,
					'SOPending' => $row->SOPending,
				);
			};
			// echo json_encode($show['product']);
			$show['product2'] = json_encode($show['product']);
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function do_po_edit_detail()
	{
		$DOID 	= $this->input->get_post('do');
		$sql 	= "SELECT dm.*, pm.*, wm.* from tb_do_main dm 
					LEFT JOIN tb_po_main pm ON (dm.DOReff=pm.POID) 
					LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
					where DOID =".$DOID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->DOStatus == 0 and $row->DOType == "RAW PO") {
			$supplier = explode(";", $row->SupplierNote);
			$show['main'] = array(
	  			'DOID' => $row->DOID,
	  			'DODate' => $row->DODate,
	  			'DOType' => "RAW PO",
	  			'DOReff' => $row->POID,
	  			'DOFrom' => "ANGHAUZ INDONESIA",
	  			'to' => "SUPPLIER",
	  			'suppliername' => $supplier[0],
	  			'supplieraddr' => $supplier[2],
	  			'supplierphone' => $supplier[3],
	  			'WarehouseID' => $row->WarehouseID,
	  			'WarehouseName' => $row->WarehouseName,
			);
			$show['main2'] = json_encode($show['main']);

			// get product
			$sql 	= "SELECT dd.*, dm.DOReff, pm.ProductCode, vpr.RawSent2, vpr.RawQty FROM tb_do_detail dd 
						LEFT JOIN tb_product_main pm ON (dd.ProductID=pm.ProductID) 
						LEFT JOIN tb_do_main dm ON (dd.DOID=dm.DOID) 
						LEFT JOIN vw_po_raw vpr ON (dm.DOReff=vpr.POID AND dd.ProductID=vpr.RAWID AND dd.ProductParent=vpr.ProductID) 
						WHERE dd.DOID=".$DOID;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['product'][] = array(
		  			'ProductParent' => $row->ProductParent,
		  			'ProductID' => $row->ProductID,
		  			'ProductCode' => $row->ProductCode,
		  			'ProductQty' => $row->ProductQty,
					'RawQty' => $row->RawQty,
					'QtySent' => $row->RawSent2
				);
			};
			// echo json_encode($show['product']);
			$show['product2'] = json_encode($show['product']);
		} else {
        	redirect(base_url('transaction/delivery_order_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_edit_act_so()
	{
		$this->db->trans_begin();

		// echo json_encode($this->input->post());
		$DOID	= $this->input->post('do');
		$DONote	= $this->input->post('note');
		$WarehouseID= $this->input->post('warehouse');
		$DOType	= $this->input->post('type');
		$DOReff	= $this->input->post('reff');
		$DOBy	= $this->session->userdata('UserAccountID');
		$DOInput= date('Y-m-d H:i:s');

		$productid 	= $this->input->post('productid');
		$salesorderdetailid = $this->input->post('salesorderdetailid');
		$productqty = $this->input->post('productqty');
		$productqtysent = $this->input->post('productqtysent');
		$newdo = $this->input->post('newdo');

   		// for auto journal
		$sql = "SELECT SUM(t1.ProductQty*sd.ProductHPP) AS SOAmount
				FROM (
					SELECT dd.*, dm.DOReff AS SOID FROM tb_do_main dm
					LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
					WHERE dm.DOID=".$DOID."
				) t1 
				LEFT JOIN tb_so_detail sd 
					ON t1.SOID=sd.SOID AND t1.SalesOrderDetailID=sd.SalesOrderDetailID AND t1.ProductID=sd.ProductID";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$SOAmountOld = $row->SOAmount;

		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmountOld = $row->DOAmount;
		// -------------------------------------

		$data = array(
			'DONote' => $DONote
		);
		$this->db->where('DOID', $DOID);
		$this->db->update('tb_do_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$qtyLast = 0;
		for ($i=0; $i < count($productid);$i++) { 
			$this->db->set('ProductQty', $productqty[$i]);
			$this->db->where('DOID', $DOID);
			$this->db->where('ProductID', $productid[$i]);
			$this->db->where('SalesOrderDetailID', $salesorderdetailid[$i]);
			$this->db->update('tb_do_detail');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityOut', $productqty[$i]);
			$this->db->where('NoReff', "DO".$DOID);
			$this->db->where('ProductID', $productid[$i]);
			$this->db->where('SalesOrderDetailID', $salesorderdetailid[$i]);
			$this->db->update('tb_product_stock_out');
			$this->last_query .= "//".$this->db->last_query();
			
			$qtynow = $this->stock_history_arrange($productid[$i], $productqty[$i], $productqtysent[$i], $WarehouseID, "DO", $DOID, 0, $salesorderdetailid[$i]);
			$qtyLast = ($qtyLast < $qtynow) ? $qtyLast : $qtynow ;
   		};

   		// for auto journal
		$sql = "SELECT SUM(t1.ProductQty*sd.ProductHPP) AS SOAmount
				FROM (
					SELECT dd.*, dm.DOReff AS SOID FROM tb_do_main dm
					LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
					WHERE dm.DOID=".$DOID."
				) t1 
				LEFT JOIN tb_so_detail sd 
					ON t1.SOID=sd.SOID AND t1.SalesOrderDetailID=sd.SalesOrderDetailID AND t1.ProductID=sd.ProductID";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$SOAmountNew = $row->SOAmount;
		$SOAmount = $SOAmountNew - $SOAmountOld;

		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmountNew = $row->DOAmount;
		$DOAmount = $DOAmountNew - $DOAmountOld;

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_do($DOID, 'so', $DOReff, $WarehouseID, 'edit', $DOAmount, date("Y-m-d H:i:s"), $SOAmount);
		// -------------------------------------

   		if (isset($newdo)) {

			$data = array(
				'DOType' => $DOType,
				'DOReff' => $DOReff,
				'WarehouseID' => $WarehouseID,	
				'DODate' => date('Y-m-d'),
				'DONote' => 'Sisa edit DO '.$DOID,
				'DOBy' => $DOBy,
				'DOInput' => $DOInput,
				'DOStatus' => 0
			);
			$this->db->insert('tb_do_main', $data);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(DOID) as DOID from tb_do_main ";
			$getDOID 	= $this->db->query($sql);
			$row 		= $getDOID->row();
			$DOID 		= $row->DOID;

			for ($i=0; $i < count($productid);$i++) { 
				$qtynew = $productqtysent[$i] - $productqty[$i];
	   			$data_product = array(
	   				'DOID' => $DOID,
					'DOType' => $DOType,
					'DOReff' => $DOReff,	
					'DODate' => date('Y-m-d'),
					'WarehouseID' => $WarehouseID,
					'ProductID' => $productid[$i],
					'SalesOrderDetailID' => $salesorderdetailid[$i],
					'ProductQty' => $qtynew
				);
				$this->db->insert('tb_do_detail', $data_product);
				$this->last_query .= "//".$this->db->last_query();
				$this->stock_min($productid[$i], $qtynew, $WarehouseID, "DO".$DOID, $salesorderdetailid[$i]);
				$this->stock_location($WarehouseID, $productid[$i], $productqty[$i], 0, "DO",$DOID);
	   		};

	   		// for auto journal
			$sql = "SELECT SUM(t1.ProductQty*sd.ProductHPP) AS SOAmount
					FROM (
						SELECT dd.*, dm.DOReff AS SOID FROM tb_do_main dm
						LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
						WHERE dm.DOID=".$DOID."
					) t1 
					LEFT JOIN tb_so_detail sd 
						ON t1.SOID=sd.SOID AND t1.SalesOrderDetailID=sd.SalesOrderDetailID AND t1.ProductID=sd.ProductID";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$SOAmount = $row->SOAmount;

			$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$DOAmount = $row->DOAmount;

			$this->load->model('model_acc');
			$this->model_acc->auto_journal_do($DOID, 'so', $DOReff, $WarehouseID, 'edit', $DOAmount, date("Y-m-d H:i:s"), $SOAmount);
			// -------------------------------------
   		}
		$this->update_pending_so($DOReff);

		$this->log_user->log_query($this->last_query);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} elseif ($qtyLast < 0) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	function delivery_order_edit_act_po()
	{
		$this->db->trans_begin();

		$POID	= $this->input->post('reff');
		$DOID	= $this->input->post('do');
		$DONote	= $this->input->post('note');
		$WarehouseID= $this->input->post('warehouse');
		$DOBy	= $this->session->userdata('UserAccountID');
		$DOInput	= date('Y-m-d H:i:s');

		$productid 	= $this->input->post('productid');
		$productqty = $this->input->post('productqty');
		$productparent = $this->input->post('productparent');
		$productqtyold = $this->input->post('productqtyold');
		$data = array(
			'DONote' => $DONote,
			'DOBy' => $DOBy,
			'DOInput' => $DOInput,
			'DOStatus' => 0
		);
		$this->db->where('DOID', $DOID);
		$this->db->update('tb_do_main', $data);
		$this->last_query .= "//".$this->db->last_query();


		// for auto journal
		$sql = "SELECT SUM(t1.ProductQty*pr.ProductHPP) AS RAWAmount
				FROM (
					SELECT dd.*, dm.DOReff AS POID FROM tb_do_main dm
					LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
					WHERE dm.DOID=".$DOID."
				) t1 
				LEFT JOIN tb_po_raw pr 
					ON t1.POID=pr.POID AND t1.ProductID=pr.RAWID";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$RAWAmountOld = $row->RAWAmount;

		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmountOld = $row->DOAmount;
		// -------------------------------------

		$qtyLast = 0;
		for ($i=0; $i < count($productid);$i++) { 
			if ($productqty[$i] != $productqtyold[$i]) {
				$this->db->set('ProductQty', $productqty[$i]);
				$this->db->where('DOID', $DOID);
				$this->db->where('ProductID', $productid[$i]);
				$this->db->where('ProductParent', $productparent[$i]);
				$this->db->update('tb_do_detail');
				$this->last_query .= "//".$this->db->last_query();

				$this->db->set('QuantityOut', $productqty[$i]);
				$this->db->where('NoReff', "DO".$DOID);
				$this->db->where('ProductID', $productid[$i]);
				$this->db->where('SalesOrderDetailID', $productparent[$i]);
				$this->db->update('tb_product_stock_out');
				$this->last_query .= "//".$this->db->last_query();
				
				// $this->stock_history_arrange($productid[$i], $productqty[$i], $productqtyold[$i], $WarehouseID, "DO", $DOID, 0, $productparent[$i]);
				$qtynow = $this->stock_history_arrange($productid[$i], $productqty[$i], $productqtyold[$i], $WarehouseID, "DO", $DOID, 0, $productparent[$i]);
				$qtyLast = ($qtyLast < $qtynow) ? $qtyLast : $qtynow ;
			}
   		};

		// $this->update_po_shipping_date($DOReff,$DODate);
		$this->update_pending_raw_po($POID);

		// for auto journal
		$sql = "SELECT SUM(t1.ProductQty*pr.ProductHPP) AS RAWAmount
				FROM (
					SELECT dd.*, dm.DOReff AS POID FROM tb_do_main dm
					LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
					WHERE dm.DOID=".$DOID."
				) t1 
				LEFT JOIN tb_po_raw pr 
					ON t1.POID=pr.POID AND t1.ProductID=pr.RAWID";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$RAWAmountNew = $row->RAWAmount;
		$RAWAmount = $RAWAmountNew - $RAWAmountOld;

		$sql = "SELECT so.NoReff, COALESCE(SUM(so.QuantityOut*pm.ProductPriceHPP),0) AS DOAmount
				FROM tb_product_stock_out so
				LEFT JOIN tb_product_main pm ON so.ProductID=pm.ProductID
				WHERE so.NoReff = 'DO".$DOID."'
				GROUP BY so.NoReff";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DOAmountNew = $row->DOAmount;
		$DOAmount = $DOAmountNew - $DOAmountOld;

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_do($DOID, 'po', $POID, $WarehouseID, 'edit', $DOAmount, date("Y-m-d H:i:s"), $RAWAmount);

		$this->log_user->log_query($this->last_query);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} elseif ($qtyLast < 0) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	function delivery_order_raw_print()
	{

		$show   = array();
		$DOID 	= $this->input->get_post('do');

		$sql = "SELECT dm.*, em.fullname, pm.BillingTo, pm.ShippingTo, pm.SupplierNote, pm.ROID 
				FROM tb_do_main dm
				LEFT JOIN tb_po_main pm ON (dm.DOReff = pm.POID)
				LEFT JOIN vw_user_account em ON (dm.DOBy = em.UserAccountID) 
				WHERE dm.DOID =  ".$DOID;
		$getrow	= $this->db->query($sql);
		$rowdo 	= $getrow->row();
		$show['do'] = $rowdo;

		$sql 	= "SELECT * from tb_job_company where CompanyID = ".$rowdo->BillingTo;
		$getrow	= $this->db->query($sql);
		$show['company'] = $getrow->row();

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdo->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT * FROM (
		SELECT dod.DOID, dod.ProductID, dod.ProductParent, pm2.ProductName AS productNameRaw, dod.ProductQty AS QtySend
		FROM tb_do_detail dod
		LEFT JOIN tb_do_main dm ON (dod.DOID = dm.DOID)
		LEFT JOIN tb_product_main pm2 ON (dod.ProductID = pm2.ProductID)
		WHERE dod.DOID = ".$DOID."
		) as A JOIN (
		SELECT dm.DOID, pm.POID, pr.ProductID as ProductParent, pr.RawID, pm2.ProductName AS productNameParent, pr.RawQty AS QtyRequested, pr.RawSent AS QtySent
		FROM tb_do_main dm
		LEFT JOIN tb_po_main pm ON (dm.DOReff = pm.POID)
		LEFT JOIN tb_po_raw pr ON (pr.POID = pm.POID)
		LEFT JOIN tb_product_main pm2 ON (pm2.ProductID = pr.ProductID)
		WHERE dm.DOID = ".$DOID."
		) AS B 
		ON A.ProductParent = B.ProductParent AND A.ProductID = B.RawID";
		// echo $sql;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $rowdo) {
		  	$show['product'][] = array(
		  		'ProductID' => $rowdo->ProductID,
		  		'ProductParent' => $rowdo->ProductParent,
		  		'productNameRaw' => $rowdo->productNameRaw,
		  		'productNameParent' => $rowdo->productNameParent,
		  		'QtyRequested' => $rowdo->QtyRequested,
	  			'QtySent' => $rowdo->QtySent,
	  			'QtySend' => $rowdo->QtySend
			);
		};

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function delivery_order_so_print()
	{
		$show   = array();
		$DOID 	= $this->input->get_post('do');

		$sql = "SELECT dm.*, em.Company2 as fullname, sm.BillingAddress, sm.ShipAddress, sm.SOID, sm.SODate, sm.SONote, 
				sc.CategoryName as SOCategory, sm.CustomerID, sm.PaymentTerm, wm.WarehouseName FROM tb_do_main dm
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID)
				LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID)
				LEFT JOIN vw_sales_executive2 em ON (sm.SalesID = em.SalesID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) WHERE dm.DOID =  ".$DOID;
		$getrow	= $this->db->query($sql);
		$rowdo 	= $getrow->row();
		$show['do'] = $rowdo;

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdo->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT drp.*, sd.ProductName, sd.ProductQty as QtyPurchased, 
					(COALESCE(tb_sent.ProductQty,0) - COALESCE(tb_sent.totaldor,0)) as qtysent
					FROM vw_do_reff_product_detail drp 
					LEFT JOIN tb_so_detail sd ON 
						(sd.ProductID=drp.ProductID and sd.SOID=drp.DOReff and drp.SalesOrderDetailID=sd.SalesOrderDetailID)
					LEFT JOIN (
						SELECT reff, ProductID, SUM(ProductQty) as ProductQty, SUM(totaldor) as totaldor
						FROM vw_do_reff_product_detail WHERE DOID<".$rowdo->DOID." and DOType='SO' and DOReff=".$rowdo->SOID." 
						GROUP BY reff, ProductID
					) tb_sent on (tb_sent.ProductID=drp.ProductID)
					WHERE drp.DOID=".$rowdo->DOID;

		$query	= $this->db->query($sql);
		foreach ($query->result() as $rowdo) {
		  	$show['product'][] = array(
		  		'ProductID' => $rowdo->ProductID,
		  		'ProductName' => $rowdo->ProductName,
		  		'QtyPurchased' => $rowdo->QtyPurchased,
	  			'QtySent' => $rowdo->qtysent,
	  			'QtySend' => $rowdo->ProductQty
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);		
	}
	function delivery_order_so_print2()
	{
		$show   = array();
		$DOID 	= $this->input->get_post('do');

		$sql = "SELECT dm.*, em.Company2 as fullname, sm.BillingAddress, sm.ShipAddress, sm.SOID, sm.SODate, sm.SONote, 
				sc.CategoryName as SOCategory, sm.CustomerID, sm.PaymentTerm, wm.WarehouseName FROM tb_do_main dm
				LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID)
				LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID)
				LEFT JOIN vw_sales_executive2 em ON (sm.SalesID = em.SalesID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) WHERE dm.DOID =  ".$DOID;
		$getrow	= $this->db->query($sql);
		$rowdo 	= $getrow->row();
		$show['do'] = $rowdo;

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdo->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT drp.*, sd.ProductName, sd.ProductQty as QtyPurchased, 
					(COALESCE(tb_sent.ProductQty,0)) as qtysent
					FROM vw_do_reff_product_detail2 drp 
					LEFT JOIN tb_so_detail sd ON 
						(sd.ProductID=drp.ProductID and sd.SOID=drp.DOReff and drp.SalesOrderDetailID=sd.SalesOrderDetailID)
					LEFT JOIN (
						SELECT reff, ProductID, SUM(ProductQty) as ProductQty 
						FROM vw_do_reff_product_detail2 
						WHERE DOID<".$rowdo->DOID." and DOType='SO' and DOReff=".$rowdo->SOID." 
						GROUP BY reff, ProductID
					) tb_sent on (tb_sent.ProductID=drp.ProductID)
					WHERE drp.DOID=".$rowdo->DOID;

		$query	= $this->db->query($sql);
		foreach ($query->result() as $rowdo) {
		  	$show['product'][] = array(
		  		'ProductID' => $rowdo->ProductID,
		  		'ProductName' => $rowdo->ProductName,
		  		'QtyPurchased' => $rowdo->QtyPurchased,
	  			'QtySent' => $rowdo->qtysent,
	  			'QtySend' => $rowdo->ProductQty
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);		
	}
	function delivery_order_mutation_print()
	{

		$show   = array();
		$DOID 	= $this->input->get_post('do');

		$sql = "SELECT dm.*, em.fullname, pm.*, wm.WarehouseName 
				FROM tb_do_main dm
				LEFT JOIN vw_user_account em ON (dm.DOBy = em.UserAccountID)
				LEFT JOIN tb_product_mutation pm ON (dm.DOReff = pm.MutationID) 
				LEFT JOIN tb_warehouse_main wm ON (dm.WarehouseID = wm.WarehouseID) 
				WHERE dm.DOID =".$DOID;

		$getrow	= $this->db->query($sql);
		$rowdo 	= $getrow->row();
		$show['do'] = $rowdo;

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdo->WarehouseID;
		$getrow	= $this->db->query($sql);
		$show['warehouse'] = $getrow->row();

		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdo->WarehouseFrom;
		$getrow	= $this->db->query($sql);
		$show['warehouse1'] = $getrow->row();
		$sql 	= "SELECT * from tb_warehouse_main where WarehouseID = ".$rowdo->WarehouseTo;
		$getrow	= $this->db->query($sql);
		$show['warehouse2'] = $getrow->row();

		$sql 	= "SELECT dd.*, plp.ProductCode
					FROM tb_do_detail dd
					LEFT JOIN vw_product_list_popup2 plp ON (dd.ProductID = plp.ProductID)
					WHERE dd.DOID=".$DOID;

		$query	= $this->db->query($sql);
		foreach ($query->result() as $rowdo) {
		  	$show['product'][] = array(
		  		'ProductID' => $rowdo->ProductID,
		  		'ProductCode' => $rowdo->ProductCode,
	  			'ProductQty' => $rowdo->ProductQty
			);
		};

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function complete_do()
	{
		$this->db->trans_start();

		$DOID 	= $this->input->get_post('do');
		$this->db->set('DOStatus', 1);
		$this->db->where('DOID', $DOID);
		$this->db->update('tb_do_main');
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "select DOType, DOReff from tb_do_main where DOID=".$DOID;
		$getrow = $this->db->query($sql);
		$row	= $getrow->row();
		if ($row->DOType == 'SO') {
	   		// for auto journal
	   		$sql 	= "select SOCategory from tb_so_main where SOID=".$row->DOReff;
			$getrow = $this->db->query($sql);
			$row	= $getrow->row();
			$SOCategory = $row->SOCategory;
			if (!in_array($SOCategory, array(1,2,7))) {
				$sql = "SELECT SUM(t1.ProductQty*sd.ProductHPP) AS SOAmount
						FROM (
							SELECT dd.*, dm.DOReff AS SOID FROM tb_do_main dm
							LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
							WHERE dm.DOID=".$DOID."
						) t1 
						LEFT JOIN tb_so_detail sd 
							ON t1.SOID=sd.SOID AND t1.SalesOrderDetailID=sd.SalesOrderDetailID AND t1.ProductID=sd.ProductID";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$SOAmount = $row->SOAmount;
				$this->load->model('model_acc');
				$this->model_acc->auto_journal_do_complete($DOID, 'Complete DO', $SOAmount, $SOCategory);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function do_fc_add()
	{
		$show   = array();
		$DOID 	= $this->input->get_post('do');
		$type 	= $this->input->get_post('type');
		$sql 	= "select DOID from tb_fc_payment where DOID =".$DOID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		if (empty($row)) {	
			if ($type == "SO") {
				$sql = "SELECT dm.*, sm.BillingAddress, sm.ShipAddress, sm.SOID, sm.SODate, 
						sm.CustomerID, sm.PaymentTerm, sm.FreightCharge FROM tb_do_main dm
						LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID) WHERE dm.DOID =  ".$DOID;
				$getrow	= $this->db->query($sql);
				$rowdo 	= $getrow->row();
				$show['do'] = (array) $rowdo;
				$company = explode(";", $show['do']['BillingAddress']);
				$show['do']['company'] = $company[0];

				$sql = " SELECT SUM(FreightCharge) AS FreightCharge FROM tb_so_detail WHERE SOID=".$rowdo->SOID;
				$getrow	= $this->db->query($sql);
				$rowfc 	= $getrow->row();
				if ($rowdo->FreightCharge > 0) {
					$show['FCMain'] = $rowdo->FreightCharge;
				} else {
					$show['FCMain'] = $rowfc->FreightCharge;
				}

				$sql = " SELECT SUM(PaymentAmount) AS PaymentAmount
						FROM tb_fc_payment fp WHERE fp.DOID IN
						(SELECT DOID FROM tb_do_main WHERE DOType='SO' AND DOReff=".$rowdo->SOID.")";
				$getrow	= $this->db->query($sql);
				$rowfp 	= $getrow->row();
				$show['PaymentAmount'] = $show['FCMain'] - $rowfp->PaymentAmount;

			} elseif ($type == "MUTATION") {
				$sql = "SELECT dm.*, pm.MutationFC as FCMain, wm.WarehouseName as company FROM tb_do_main dm
						LEFT JOIN tb_product_mutation pm ON (dm.DOReff = pm.MutationID) 
						LEFT JOIN tb_warehouse_main wm ON (pm.WarehouseTo = wm.WareHouseID) 
						WHERE dm.DOID = ".$DOID;
				$getrow	= $this->db->query($sql);
				$rowdo 	= $getrow->row();
				$show['do'] = (array) $rowdo;
				$show['FCMain'] = $rowdo->FCMain;

				$sql = " SELECT SUM(PaymentAmount) AS PaymentAmount
						FROM tb_fc_payment fp WHERE fp.DOID IN
						(SELECT DOID FROM tb_do_main WHERE DOType='MUTATION' AND DOReff=".$rowdo->DOReff.")";
				$getrow	= $this->db->query($sql);
				$rowfp 	= $getrow->row();
				$show['PaymentAmount'] = $show['FCMain'] - $rowfp->PaymentAmount;
			}

		} else {
        	redirect(base_url('transaction/do_fc_report?do='.$DOID));
		}
	    return $show;
	}
	function do_fc_add_act()
	{
		$this->db->trans_start();
		$DOID	= $this->input->post('DOID');
		$ExpeditionID	= $this->input->post('ExpeditionID');
		$ExpeditionName	= $this->input->post('ExpeditionName');
		$ExpeditionReff	= $this->input->post('ExpeditionReff');
		$PaymentAmount	= $this->input->post('PaymentAmount');
		$PaymentDate	= $this->input->post('PaymentDate');
		$data = array(
			'DOID' => $DOID,
			'ExpeditionID' => $ExpeditionID,
			'ExpeditionName' => $ExpeditionName,
			'ExpeditionReff' => $ExpeditionReff,
			'PaymentDate' => $PaymentDate,
			'PaymentAmount' => $PaymentAmount,
			'InputDate' => date('Y-m-d H:i:s'),
			'InputBy' => $this->session->userdata('UserAccountID')

		);
		$this->db->insert('tb_fc_payment', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "select DOType, DOReff from tb_do_main where DOID=".$DOID;
		$getrow = $this->db->query($sql);
		$row	= $getrow->row();
		$DOType	= $row->DOType;
		$DOReff	= $row->DOReff;
		$this->load->model('model_acc');
		$this->model_acc->auto_journal_do_fc($DOID, $DOType, $DOReff, $PaymentAmount);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function do_fc_report()
	{
		$show   = array();
		$DOID 	= $this->input->get_post('do');

		$sql = "SELECT DOType FROM tb_do_main WHERE DOID =  ".$DOID;
		$getrow	= $this->db->query($sql);
		$rowdo 	= $getrow->row();
		$type 	= $rowdo->DOType;
		$show['type'] = $type;
		
		if ($type == "SO") {
			$sql 	= "SELECT dm.*, sm.*, vs.Company, vem2.Company2 as salesname, sc.CategoryName from 
						tb_do_main dm 
						LEFT JOIN tb_so_main sm ON (dm.DOReff = sm.SOID)
						LEFT JOIN vw_customer2 vs ON (sm.CustomerID = vs.CustomerID)
						LEFT JOIN vw_sales_executive2 vem2 ON (sm.SalesID = vem2.SalesID) 
						LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
						where dm.DOID = ".$DOID;
			$getrow	= $this->db->query($sql);
			$rowso 	= $getrow->row();
			$show['somain'] = $rowso;

			$sql 	= "SELECT * from tb_so_detail where SOID = ".$rowso->SOID;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['sodetail'][] = array(
			  		'SOID' => $row->SOID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					'ProductWeight' => $row->ProductWeight,
					'FreightCharge' => $row->FreightCharge,
				);
			};

			$sql 	= "SELECT fp.*, SUM(dsd.ProductQty) AS ProductQty, SUM(totalweight) AS totalweight FROM tb_fc_payment fp 
						LEFT JOIN tb_do_main dm ON (fp.DOID=dm.DOID)
						LEFT JOIN vw_do_so_detail dsd ON (fp.DOID=dsd.DOID)  
						WHERE dm.DOType='SO' AND dm.DOReff= ".$rowso->SOID." GROUP BY fp.DOID order by fp.InputDate";
						
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['payment'][] = array(
			  		'DOID' => $row->DOID,
					'ExpeditionName' => $row->ExpeditionName,
					'ExpeditionReff' => $row->ExpeditionReff,
					'PaymentAmount' => $row->PaymentAmount,
					'PaymentDate' => $row->PaymentDate,
					'ProductQty' => $row->ProductQty,
					'totalweight' => $row->totalweight
				);
			};
		} elseif ($type == "MUTATION") {
			$sql 	= "SELECT dm.*, pm.*, vem.fullname, w1.WarehouseName as WarehouseFrom, w2.WarehouseName as WarehouseTo 
						from tb_do_main dm 
						LEFT JOIN tb_product_mutation pm ON (dm.DOReff = pm.MutationID) 
						LEFT JOIN vw_user_account vem ON (pm.MutationBy = vem.UserAccountID)  
						LEFT JOIN tb_warehouse_main w1 ON (pm.WarehouseFrom = w1.WarehouseID)  
						LEFT JOIN tb_warehouse_main w2 ON (pm.WarehouseTo = w2.WarehouseID)  
						where dm.DOID =".$DOID;
			$getrow	= $this->db->query($sql);
			$rowdo 	= $getrow->row();
			$show['domain'] = $rowdo;

			$sql 	= "SELECT md.*, pm.ProductName, pm.Weight from tb_product_mutation_detail md
						LEFT JOIN vw_product_list_popup7 pm ON (md.ProductID = pm.ProductID) 
						where MutationID = ".$rowdo->MutationID;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['dodetail'][] = array(
			  		'MutationID' => $row->MutationID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					'Weight' => $row->Weight,
				);
			};

			$sql 	= "SELECT fp.*, SUM(md.ProductQty) AS ProductQty FROM tb_fc_payment fp 
						LEFT JOIN tb_do_main dm ON (fp.DOID=dm.DOID) 
						LEFT JOIN tb_product_mutation_detail md ON (dm.DOReff=md.MutationID) 
						WHERE dm.DOType='MUTATION' AND dm.DOReff=".$rowdo->MutationID." GROUP BY fp.DOID order by fp.InputDate ";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['payment'][] = array(
			  		'DOID' => $row->DOID,
					'ExpeditionName' => $row->ExpeditionName,
					'ExpeditionReff' => $row->ExpeditionReff,
					'PaymentAmount' => $row->PaymentAmount,
					'PaymentDate' => $row->PaymentDate,
					'ProductQty' => $row->ProductQty
				);
			};
		}
	    return $show;
	}
	function cekAmount_DO_FC()
	{
		$ReffTypeMain = $this->input->get_post('ReffTypeMain');
		$ReffNoMain = $this->input->get_post('ReffNoMain');

		$sql 	= "SELECT PaymentAmount FROM tb_fc_payment WHERE DOID=".$ReffNoMain." limit 1";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$PaymentAmount = (!empty($row)) ? $row->PaymentAmount : 0 ;
		echo json_encode($PaymentAmount);
	}
	function complete_do_batch()
	{
		$this->db->trans_start();

		$DOIDArr = $this->input->get_post('data');
		$this->db->set('DOStatus', 1);
		$this->db->where_in('DOID', $DOIDArr);
		$this->db->update('tb_do_main');
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "select DOID, DOType, DOReff from tb_do_main 
					where DOType='SO' and DOID in (". implode(',', array_map('intval', $DOIDArr)) .")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			// for auto journal
	   		$sql 	= "select SOCategory from tb_so_main where SOID=".$row->DOReff;
			$getrow = $this->db->query($sql);
			$row2	= $getrow->row();
			$SOCategory = $row2->SOCategory;
			if (!in_array($SOCategory, array(1,2,7))) {
				$sql = "SELECT SUM(t1.ProductQty*sd.ProductHPP) AS SOAmount
						FROM (
							SELECT dd.*, dm.DOReff AS SOID FROM tb_do_main dm
							LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
							WHERE dm.DOID=".$row->DOID."
						) t1 
						LEFT JOIN tb_so_detail sd 
							ON t1.SOID=sd.SOID AND t1.SalesOrderDetailID=sd.SalesOrderDetailID AND t1.ProductID=sd.ProductID";
				$getrow = $this->db->query($sql);
				$row3 	= $getrow->row();
				$SOAmount = $row3->SOAmount;
				$this->load->model('model_acc');
				$this->model_acc->auto_journal_do_complete($row->DOID, 'Complete DO', $SOAmount, $SOCategory);
			}
		}

		$query = $this->db->query('SELECT * FROM tb_do_main 
				where DOStatus=1 and DOID in ('. implode(',', array_map('intval', $DOIDArr)) .')');
		echo json_encode($query->num_rows());

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

//Stock ====================================================================
	function stock_add($productid, $productqty, $warehouse, $reff, $EXPDate)
	{
		$this->db->trans_start();
		$sql 	= "SELECT Stockable from tb_product_main where ProductID=".$productid;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if ($row->Stockable == 1) {

			$sql 	= "SELECT Quantity from tb_product_stock_main where ProductID=".$productid." and WarehouseID=".$warehouse;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			if (empty($row)) {
				$data_stock = array(
	   				'ProductID' => $productid,
					'WarehouseID' => $warehouse,
					'Quantity' => 0,
					'LastUpdate' => date("Y-m-d H:i:s")
				);
				$this->db->insert('tb_product_stock_main', $data_stock);
				$this->last_query .= "//".$this->db->last_query();

				$sql 	= "SELECT Quantity from tb_product_stock_main where ProductID=".$productid." and WarehouseID=".$warehouse;
				$query 	= $this->db->query($sql);
				$row 	= $query->row();
			}

			$sql3 	= "SELECT ProductID, AtributeValue AS UserAccountID FROM vw_product_manager vpm
					where ProductID=".$productid." ";
				// echo $sql3;
			$query3 	= $this->db->query($sql3);
			$row3 	= $query3->row();
			if(!empty($row3)){
				$PM=$row3->UserAccountID;
				$PMArr= array($PM);
				$ProductIDArr = array($productid);
				$this->load->model('model_notification');
				$this->model_notification->insert_notif('update_stock', 'Add DOR Stock', 'ProductID', $ProductIDArr, 'add', $PMArr);
			}
			$qtynow 	= $row->Quantity + $productqty;
			$data_stock_in = array(
				'ProductID' => $productid,
				'WarehouseID' => $warehouse,
				'Quantityin' => $productqty,
				'QuantityStock' => $qtynow,
				'ExpDate' => $EXPDate,
				'CreatedBy' => $this->session->userdata('UserAccountID'),
				'CreatedDate' => date("Y-m-d H:i:s"),
				'NoReff' => $reff,
			);
			$this->db->insert('tb_product_stock_in', $data_stock_in);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('Quantity', $qtynow);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_main');
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function stock_min($productid, $productqty, $warehouse, $reff, $SalesOrderDetailID=0)
	{
		$this->db->trans_start();
		$sql 	= "SELECT Stockable, MinStock, MaxStock from tb_product_main where ProductID=".$productid;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$MinStock=$row->MinStock;
		$MaxStock=$row->MaxStock;
		if ($row->Stockable == 1) {

			$sql 	= "SELECT Quantity from tb_product_stock_main where ProductID=".$productid." and WarehouseID=".$warehouse;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			if (empty($row)) {
				$data_stock = array(
	   				'ProductID' => $productid,
					'WarehouseID' => $warehouse,
					'Quantity' => 0,
					'LastUpdate' => date("Y-m-d H:i:s")
				);
				$this->db->insert('tb_product_stock_main', $data_stock);
				$this->last_query .= "//".$this->db->last_query();

				$sql 	= "SELECT Quantity from tb_product_stock_main where ProductID=".$productid." and WarehouseID=".$warehouse;
				$query 	= $this->db->query($sql);	
				$row 	= $query->row();
			}

			$sql2 	= "SELECT SUM(Quantity) as Quantity from tb_product_stock_main where ProductID=".$productid;
			$query2 	= $this->db->query($sql2);
			$row2 	= $query2->row();
			$Quantity=$row2->Quantity;
			if(!empty($row2)){
				$qtynow2 	= $row2->Quantity - $productqty;
				if($qtynow2<=1){

					$sql3 	= "SELECT ProductID, AtributeValue AS UserAccountID FROM vw_product_manager vpm
					where ProductID=".$productid." ";
						// echo $sql3;
					$query3 	= $this->db->query($sql3);
					$row3 	= $query3->row();
					if(!empty($row3)){
						$PM=$row3->UserAccountID;
						$PMArr= array($PM);
						$ProductIDArr = array($productid);
						$this->load->model('model_notification');
						$this->model_notification->insert_notif('update_stock', 'Add DO', 'ProductID', $ProductIDArr, 'add', $PMArr);
					}
				}
			}

			$qtynow 	= $row->Quantity - $productqty;
			$data_stock_out = array(
				'ProductID' => $productid,
				'WarehouseID' => $warehouse,
				'QuantityOut' => $productqty,
				'QuantityStock' => $qtynow,
				'CreatedBy' => $this->session->userdata('UserAccountID'),
				'CreatedDate' => date("Y-m-d H:i:s"),
				'NoReff' => $reff,
				'SalesOrderDetailID' => $SalesOrderDetailID,
			);
			$this->db->insert('tb_product_stock_out', $data_stock_out);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('Quantity', $qtynow);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_main');
			$this->last_query .= "//".$this->db->last_query();

			if($qtynow<=$MinStock){
				$sql3 	= "SELECT ProductID, UserAccountID from vw_product_origin vpo
				left join tb_source_agent tsa ON tsa.AtributeValue=vpo.AtributeValue where ProductID=".$productid." ";
				// echo $sql3;
				$query3 	= $this->db->query($sql3);
				$row3 	= $query3->row();
				if(!empty($row3)){
					$SoureAgent=$row3->UserAccountID;
					$SourceAgentArr= array($SoureAgent);
					$ProductIDArr = array($productid);
					$this->load->model('model_notification');
					$this->model_notification->insert_notif('notif_minmax', 'Stock Under Min', 'ProductID', $ProductIDArr, 'replace', $SourceAgentArr );
				}
			}
			// echo $this->last_query;
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		return $qtynow;
	    // return $this->db->trans_status();
	}
	function stock_location($warehouse, $productid, $ProductQty, $EXPDate, $reff, $reffno)
	{
		$this->db->trans_start();
		if ($reff='DO'){
			$sql 	= "SELECT StockLocationID, QtyAllocation
						from vw_product_stock_location
						where ProductID=".$productid." and QtyAllocation>0
						order by StockLocationID ASC";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			
			foreach ($query->result() as $row) {
				$StockLocationID = $row->StockLocationID;
				$QtyAllocation = $row->QtyAllocation;
				if($ProductQty>0){
					if($ProductQty>=$QtyAllocation){
						$DOQty = $QtyAllocation;
						$ProductQty -= $QtyAllocation;
					} else {
						$DOQty = $ProductQty;
						$ProductQty = 0;
					}
					$data_sa = array(
						'StockLocationID' => $StockLocationID,
						'ReffType' => $reff,
						'ReffNo' => $reffno,
						'Quantity' => $DOQty,
					);
					$this->db->insert('tb_product_stock_allocation', $data_sa);
					$this->last_query .= "//".$this->db->last_query();
				}
			}
		} else {
			$data_sl = array(
				'WarehouseID' => $warehouse,
				'ProductID' => $productid,
				'Quantity' => $ProductQty,
				'ExpDate' => $EXPDate,
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_product_stock_location', $data_sl);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "SELECT max(StockLocationID) as StockLocationID from tb_product_stock_location ";
			$getID 	= $this->db->query($sql);
			$row 	= $getID->row();
			$StockLocationID = $row->StockLocationID;

			$data_sa = array(
				'StockLocationID' => $StockLocationID,
				'ReffType' => $reff,
				'ReffNo' => $reffno,
				'Quantity' => $ProductQty,
			);
			$this->db->insert('tb_product_stock_allocation', $data_sa);
			$this->last_query .= "//".$this->db->last_query();
		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function stock_history_arrange($productid, $productqty, $productqtyold, $warehouse, $type, $reff, $HistoryID=0,  $SalesOrderDetailID=0)
	{
		$this->db->trans_start();
		
		$sql = "select * from tb_product_stock_main where WarehouseID='".$warehouse."' and ProductID='".$productid."'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (empty($row)) {
				$data_stock = array(
	   				'ProductID' => $productid,
					'WarehouseID' => $warehouse,
					'Quantity' => 0,
					'LastUpdate' => date("Y-m-d H:i:s")
				);
				$this->db->insert('tb_product_stock_main', $data_stock);
				$this->last_query .= "//".$this->db->last_query();
		}

		$QtyDiff = $productqty - $productqtyold;

		if ($type == "DO") {
			$sql = "select CreatedDate from tb_product_stock_out where NoReff='".$type.$reff."' ";

			// for consignment only
			if ($SalesOrderDetailID !=0) {
				$sql = "select CreatedDate, StockOutID from tb_product_stock_out where NoReff='".$type.$reff."' and SalesOrderDetailID=".$SalesOrderDetailID;
			}
			// -----------------------
			$getDate 	= $this->db->query($sql);
			$row 		= $getDate->row();
			$Date 		= $row->CreatedDate;

			$this->db->set('QuantityStock', 'QuantityStock -'. $QtyDiff .'',false);
			if ($HistoryID !=0) {
				$this->db->where('StockOutID >=', $HistoryID);
			} else if ($SalesOrderDetailID !=0) {
				$this->db->where('StockOutID >=', $row->StockOutID);
			} else {
				$this->db->where('CreatedDate >=', $Date);
			}
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_out');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityStock', 'QuantityStock -'. $QtyDiff .'',false);
			$this->db->where('CreatedDate >=', $Date);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_in');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('Quantity', 'Quantity -'.$QtyDiff.'',false);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_main');
			$this->last_query .= "//".$this->db->last_query();

			$data = array(
				'ArrangeDate' => date("Y-m-d H:i:s"),
				'ReffType' => 'DO',
				'ReffID' => $reff,
				'ProductID' => $productid,
				'QtyOld' => $productqtyold,
				'QtyNew' => $productqty
			);
			$this->db->insert('tb_stock_history_arrange', $data);
			$this->last_query .= "//".$this->db->last_query();

			$sql = "select Quantity from tb_product_stock_main where WarehouseID='".$warehouse."' and ProductID='".$productid."'";
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			$LastQty = $row->Quantity;
		} elseif ($type == "DOR") {
			$sql 		= "select CreatedDate from tb_product_stock_in where NoReff='".$type.$reff."'";
			$getDate 	= $this->db->query($sql);
			$row 		= $getDate->row();
			$Date 		= $row->CreatedDate;

			$this->db->set('QuantityStock', 'QuantityStock +'. $QtyDiff .'',false);
			$this->db->where('CreatedDate >=', $Date);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_out');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityStock', 'QuantityStock +'. $QtyDiff .'',false);
			if ($HistoryID !=0) {
				$this->db->where('StockInID >=', $HistoryID);
			} else {
				$this->db->where('CreatedDate >=', $Date);
			}
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_in');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('Quantity', 'Quantity +'.$QtyDiff.'',false);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_main');
			$this->last_query .= "//".$this->db->last_query();

			$data = array(
				'ArrangeDate' => date("Y-m-d H:i:s"),
				'ReffType' => 'DOR',
				'ReffID' => $reff,
				'ProductID' => $productid,
				'QtyOld' => $productqtyold,
				'QtyNew' => $productqty
			);
			$this->db->insert('tb_stock_history_arrange', $data);
			$this->last_query .= "//".$this->db->last_query();
			
			$sql = "select Quantity from tb_product_stock_main where WarehouseID='".$warehouse."' and ProductID='".$productid."'";
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			$LastQty = $row->Quantity;
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		return $LastQty;

	    // return $this->db->trans_status();
	}
	function stock_adjustment($productid, $productqty, $warehouse, $reff, $type, $date)
	{
		$this->db->trans_start();
		$sql 	= "select ProductID from tb_product_stock_main 
					where ProductID=".$productid." and WarehouseID=".$warehouse."";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (empty($row)) {
			$data_stock_main = array(
				'ProductID' => $productid,
				'WarehouseID' => $warehouse,
				'Quantity' => 0,
				'LastUpdate' => date('Y-m-d H:i:s')
			);
			$this->db->insert('tb_product_stock_main', $data_stock_main);
			$this->last_query .= "//".$this->db->last_query();
		}

		$dateOld = date( 'Y-m-d H:i:s', strtotime($date) );
		$sql 	= "select * from vw_product_stock_history2 
					where ProductID=".$productid." and WarehouseID=".$warehouse."
					and CreatedDate<'".$date." 23:59:59' ORDER BY CreatedDate DESC LIMIT 1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$main 	= get_object_vars($row);
			$dt 	= new DateTime($main['CreatedDate']);
			$dateNew = $dt->format('Y-m-d H:i:s');
			if ( $dateNew < $dateOld) {
				$dateNew = $dateOld;
			}
			$dateNew = strtotime($dateNew);
			$dateNew = date('Y-m-d H:i:s', strtotime('+1 minutes', $dateNew));
			$QtyBefore = $main['QuantityAfter'];
		} else {
			$dateNew = strtotime($dateOld);
			$dateNew = date('Y-m-d H:i:s', strtotime('+1 minutes', $dateNew));
			$QtyBefore = 0;
		}

		if ($type == "add") {
			$qtynow = $QtyBefore + $productqty;
			$data_stock = array(
				'ProductID' => $productid,
				'WarehouseID' => $warehouse,
				'Quantityin' => $productqty,
				'QuantityStock' => $qtynow,
				'CreatedBy' => $this->session->userdata('UserAccountID'),
				'CreatedDate' => $dateNew,
				'NoReff' => "Adjustment".$reff
			);
			$this->db->insert('tb_product_stock_in', $data_stock);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityStock', 'QuantityStock +'. $productqty .'',false);
			$this->db->where('CreatedDate >', $dateNew);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_out');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityStock', 'QuantityStock +'. $productqty .'',false);
			$this->db->where('CreatedDate >', $dateNew);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_in');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('Quantity', 'Quantity +'.$productqty.'',false);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_main');
			$this->last_query .= "//".$this->db->last_query();

		} elseif ($type == "min") {
			$qtynow = $QtyBefore - $productqty;
			$data_stock = array(
				'ProductID' => $productid,
				'WarehouseID' => $warehouse,
				'QuantityOut' => $productqty,
				'QuantityStock' => $qtynow,
				'CreatedBy' => $this->session->userdata('UserAccountID'),
				'CreatedDate' => $dateNew,
				'NoReff' => "Adjustment".$reff
			);
			$this->db->insert('tb_product_stock_out', $data_stock);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityStock', 'QuantityStock -'. $productqty .'',false);
			$this->db->where('CreatedDate >', $dateNew);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_out');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('QuantityStock', 'QuantityStock -'. $productqty .'',false);
			$this->db->where('CreatedDate >', $dateNew);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_in');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->set('Quantity', 'Quantity -'.$productqty.'',false);
			$this->db->where('ProductID', $productid);
			$this->db->where('WarehouseID', $warehouse);
			$this->db->update('tb_product_stock_main');
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
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
	function product_stock_detail()
	{
		$ProductID 	= $this->input->get_post('product');

		$sql 		= "select MinStock, MaxStock from tb_product_main where ProductID =".$ProductID;
		$getrow 	= $this->db->query($sql);
		$row 		= $getrow->row();
		$MinStock 	= $row->MinStock;
		$MaxStock 	= $row->MaxStock;

		$sql 		= "select stock from vw_product_list_popup2 where ProductID =".$ProductID;
		$getrow 	= $this->db->query($sql);
		$row 		= $getrow->row();
		$stock 		= $row->stock;

		$sopending	= 0;

		$sql 		= "SELECT COALESCE(SUM(RawQty),0) as RawQty, COALESCE(SUM(RawSent),0) as RawSent FROM tb_po_raw WHERE RawID = ".$ProductID;
		$getrow 	= $this->db->query($sql);
		$row 		= $getrow->row();
		$rawpending	= $row->RawQty - $row->RawSent;

		$qtyready	= $stock - ($sopending + $rawpending);

		$sql 		= "SELECT COALESCE(SUM(ProductQty),0) as ProductQty FROM tb_product_mutation_detail WHERE ProductID = ".$ProductID;
		$getrow 	= $this->db->query($sql);
		$row 		= $getrow->row();
		$mutationpending	= $row->ProductQty;

		$sql 		= "SELECT COALESCE(SUM(ProductQty),0) as ProductQty, COALESCE(SUM(ProductPO),0) as ProductPO FROM tb_ro_product WHERE ProductID = ".$ProductID;
		$getrow 	= $this->db->query($sql);
		$row 		= $getrow->row();
		$ropending	= $row->ProductQty - $row->ProductPO;

		$sql 		= "SELECT COALESCE(SUM(ProductQty),0) as ProductQty, COALESCE(SUM(DORQty),0) as DORQty FROM tb_po_product WHERE ProductID = ".$ProductID;
		$getrow 	= $this->db->query($sql);
		$row 		= $getrow->row();
		$popending	= $row->ProductQty - $row->DORQty;

		$QtyNet 	= $qtyready + $ropending + $popending;

		$productrequest = 0;
		$rosuggestion	= 0;

		$show = array(
  			'MinStock' => $MinStock,
  			'MaxStock' => $MaxStock,
  			'stock' => $stock,
  			'sopending' => $sopending,
  			'rawpending' => $rawpending,
  			'qtyready' => $qtyready,
  			'mutationpending' => $mutationpending,
  			'ropending' => $ropending,
  			'popending' => $popending,
  			'QtyNet' => $QtyNet,
  			'rosuggestion' => $rosuggestion,
  			'productrequest' => $productrequest
		);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function get_stock()
	{
		$ProductID 	= $this->input->get_post('product');
		$WarehouseID= $this->input->get_post('warehouse');

		$sql = "SELECT pm.ProductID, IFNULL(psm.Quantity, '0') AS stock
				FROM tb_product_main pm
				LEFT JOIN tb_product_stock_main psm ON pm.ProductID = psm.ProductID AND WarehouseID = ".$WarehouseID."
				WHERE pm.ProductID IN (".implode(',',$ProductID).")";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[$row->ProductID] = array(
	  			'ProductID' => $row->ProductID,
	  			'stock' => $row->stock
			);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function product_stock_pending_so()
	{
		$show 	= array();
		$ProductID = $this->input->get_post('product');
		$show['ProductID'] = $ProductID;
		$arrSOID= "";
		$sql 	= "SELECT sd.SOID, sm.* FROM tb_so_detail sd
				LEFT JOIN vw_so_list5 sm ON (sd.SOID=sm.SOID)
				WHERE sd.ProductID=".$ProductID." AND sm.SOStatus=1 
					AND sm.SOConfirm1=1 AND sm.SOConfirm2=1 
					AND sm.totaldo < sm.qty 
				order by sd.SOID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrSOID .= $row->SOID."," ;
			$totalPayment = 100 - ($row->TotalOutstanding/($row->SOTotal/100));

			$status = 'NotReady';
			if ($row->PaymentWay=='CBD' and $totalPayment>=100) {
				$status = 'Ready';
			}
			if ($row->PaymentWay=='TOP') {
				$status = 'Ready';
			}

		  	$show['main'][$row->SOID] = array(
		  		'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'Company' => $row->Company,
				'salesname' => $row->salesname,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'CategoryName' => $row->CategoryName,
				'PaymentWay' => $row->PaymentWay,
				'totalPayment' => $totalPayment,
				'status' => $status,
				// 'outstanding' => $row->totaldo-$row->qty
			);
		};

		$arrSOID = substr($arrSOID, 0, -1);
		$sql 	= "SELECT sd.*, sd.ProductQty-sd.Pending AS totaldo 
					FROM tb_so_detail sd
					WHERE sd.SOID in (".$arrSOID.")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['detail'][$row2->SOID][] = array(
				'ProductID' => $row2->ProductID,
				'ProductName' => $row2->ProductName,
				'ProductQty' => $row2->ProductQty,
				'totaldo' => $row2->totaldo
			);

			if ($ProductID == $row2->ProductID) {
				$show['main'][$row2->SOID]['outstanding'] = $row2->ProductQty - $row2->totaldo;
			}

			$sql = "SELECT dm.DOID, dm.DODate, dd.ProductQty FROM tb_do_detail dd
					LEFT JOIN tb_do_main dm ON (dd.DOID=dm.DOID)
					WHERE dm.DOType='SO' AND dm.DOReff=".$row2->SOID." and dd.ProductID=".$row2->ProductID;
			$query2 = $this->db->query($sql);
			foreach ($query2->result() as $row3) {
				$show['do'][$row2->SOID][$row2->ProductID][] = array(
					'DOID' => $row3->DOID,
		  			'DODate' => $row3->DODate,
		  			'ProductQty' => $row3->ProductQty
				);
			};
		};
		return $show;
	}
	function product_stock_pending_so_pending_non_confirm()
	{
		$show 	= array();
		$ProductID = $this->input->get_post('product');
		$show['ProductID'] = $ProductID;
		$arrSOID= "";
		$sql 	= "SELECT sd.SOID, sm.* FROM tb_so_detail sd
				LEFT JOIN vw_so_list5 sm ON (sd.SOID=sm.SOID)
				WHERE sd.ProductID=".$ProductID." AND sm.SOStatus=1 AND sm.SOConfirm2<>1 AND sm.totaldo < sm.qty";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrSOID .= $row->SOID."," ;
		  	$show['main'][$row->SOID] = array(
		  		'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'Company' => $row->Company,
				'salesname' => $row->salesname,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				// 'outstanding' => $row->totaldo-$row->qty
			);
		};

		$arrSOID = substr($arrSOID, 0, -1);
		$sql 	= "SELECT sd.*, sd.ProductQty-sd.Pending AS totaldo 
					FROM tb_so_detail sd
					WHERE sd.SOID in (".$arrSOID.")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['detail'][$row2->SOID][] = array(
				'ProductID' => $row2->ProductID,
				'ProductName' => $row2->ProductName,
				'ProductQty' => $row2->ProductQty,
				'totaldo' => $row2->totaldo
			);

			if ($ProductID == $row2->ProductID) {
				$show['main'][$row2->SOID]['outstanding'] = $row2->ProductQty - $row2->totaldo;
			}

			$sql = "SELECT dm.DOID, dm.DODate, dd.ProductQty FROM tb_do_detail dd
					LEFT JOIN tb_do_main dm ON (dd.DOID=dm.DOID)
					WHERE dm.DOType='SO' AND dm.DOReff=".$row2->SOID." and dd.ProductID=".$row2->ProductID;
			$query2 = $this->db->query($sql);
			foreach ($query2->result() as $row3) {
				$show['do'][$row2->SOID][$row2->ProductID][] = array(
					'DOID' => $row3->DOID,
		  			'DODate' => $row3->DODate,
		  			'ProductQty' => $row3->ProductQty
				);
			};
		};
		return $show;
	}
	function product_stock_pending_so_raw()
	{
		$show 	= array();
		$ProductID = $this->input->get_post('product');
		$show['ProductID'] = $ProductID;

		$arrPOID= "";
		$sql 	= "SELECT pr.POID, pm.* FROM vw_po_raw pr 
					LEFT JOIN tb_po_main pm ON (pr.POID=pm.POID)
					WHERE pr.RawID=".$ProductID." AND pr.RawQty<>RawSent2 AND pm.POStatus!=2 group by pr.POID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrPOID .= $row->POID."," ;
		  	$show['po']['main'][] = array(
		  		'POID' => $row->POID,
				'PODate' => $row->PODate,
				'ShippingDate' => $row->ShippingDate,
				'PONote' => $row->PONote
			);
		};

		$arrPOID = substr($arrPOID, 0, -1);
		if ($arrPOID != '') {
			$sql 	= "SELECT pr.*, plp.ProductCode as rawname, plp2.ProductCode as productname from vw_po_raw pr ";
			$sql 	.= "left join vw_product_list_popup2 plp on pr.RawID = plp.ProductID ";
			$sql 	.= "left join vw_product_list_popup2 plp2 on pr.ProductID = plp2.ProductID ";
			$sql 	.= "where POID in (".$arrPOID.")";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['po']['raw'][$row2->POID][] = array(
		  			'RawID' => $row2->RawID,
		  			'ProductID' => $row2->ProductID,
		  			'RawName' => $row2->rawname,
		  			'ParentName' => $row2->productname,
		  			'RawQty' => $row2->RawQty,
		  			'RawSent' => $row2->RawSent2
				);
			};
		}

		// ======================================================================================================

		$arrSOID= "";
		$sql 	= "SELECT sd.SOID, sm.* FROM tb_so_detail sd
				LEFT JOIN vw_so_list5 sm ON (sd.SOID=sm.SOID)
				WHERE sd.ProductID=".$ProductID." AND sm.SOStatus=1 AND sm.SOConfirm1=1 AND sm.SOConfirm2=1 AND sm.totaldo < sm.qty 
				order by sd.SOID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrSOID .= $row->SOID."," ;
		  	$show['so']['main'][$row->SOID] = array(
		  		'SOID' => $row->SOID,
				'SODate' => $row->SODate,
				'Company' => $row->Company,
				'salesname' => $row->salesname,
				'totaldo' => $row->totaldo,
				'qty' => $row->qty,
				'outstanding' => $row->totaldo-$row->qty
			);
		};

		$arrSOID = substr($arrSOID, 0, -1);
		$sql 	= "SELECT sd.*, sd.ProductQty-sd.Pending AS totaldo 
					FROM tb_so_detail sd
					WHERE sd.SOID in (".$arrSOID.")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['so']['detail'][$row2->SOID][] = array(
				'ProductID' => $row2->ProductID,
				'ProductName' => $row2->ProductName,
				'ProductQty' => $row2->ProductQty,
				'totaldo' => $row2->totaldo
			);

			if ($ProductID == $row2->ProductID) {
				$show['so']['main'][$row2->SOID]['outstanding'] = $row2->Pending;
			}

			$sql = "SELECT dm.DOID, dm.DODate, dd.ProductQty FROM tb_do_detail dd
					LEFT JOIN tb_do_main dm ON (dd.DOID=dm.DOID)
					WHERE dm.DOType='SO' AND dm.DOReff=".$row2->SOID." and dd.ProductID=".$row2->ProductID;
			$query2 = $this->db->query($sql);
			foreach ($query2->result() as $row3) {
				$show['so']['do'][$row2->SOID][$row2->ProductID][] = array(
					'DOID' => $row3->DOID,
		  			'DODate' => $row3->DODate,
		  			'ProductQty' => $row3->ProductQty
				);
			};
		};
		return $show;
	}
	function product_stock_pending_raw()
	{
		$show 	= array();
		$ProductID = $this->input->get_post('product');
		$show['ProductID'] = $ProductID;
		$arrPOID= "";
		$sql 	= "SELECT pr.POID, pm.* FROM vw_po_raw pr 
					LEFT JOIN tb_po_main pm ON (pr.POID=pm.POID)
					WHERE pr.RawID=".$ProductID." AND pr.RawQty<>RawSent2 AND pm.POStatus!=2
					group by pr.POID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrPOID .= $row->POID."," ;
		  	$show['po']['main'][] = array(
		  		'POID' => $row->POID,
				'PODate' => $row->PODate,
				'ShippingDate' => $row->ShippingDate,
				'PONote' => $row->PONote
			);
		};

		if ( $arrPOID != '' ) {
			$arrPOID = substr($arrPOID, 0, -1);
			$sql 	= "SELECT pr.*, plp.ProductCode as rawname, plp2.ProductCode as productname from vw_po_raw pr 
						left join vw_product_list_popup2 plp on pr.RawID = plp.ProductID 
						left join vw_product_list_popup2 plp2 on pr.ProductID = plp2.ProductID 
						where POID in (".$arrPOID.")";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['po']['raw'][$row2->POID][] = array(
		  			'RawID' => $row2->RawID,
		  			'ProductID' => $row2->ProductID,
		  			'RawName' => $row2->rawname,
		  			'ParentName' => $row2->productname,
		  			'RawQty' => $row2->RawQty,
		  			'RawSent' => $row2->RawSent2
				);
			};
		}


		$arrROID= "";
		$sql 	= "SELECT rr.*, @total:=COALESCE(rp.total,0) AS total, rm.RODate, rm.RONote
					FROM tb_ro_main rm 
					LEFT JOIN tb_ro_raw rr ON rm.ROID=rr.ROID
					LEFT JOIN vw_ro_raw_po2 rp ON rr.ROID=rp.ROID AND rr.ProductID=rp.ProductID AND rr.RawID=rp.RawID
					WHERE rr.RawID=".$ProductID." and rm.ROStatus<>2  
					group by rm.ROID HAVING rr.RawQty <> total";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrROID .= $row->ROID."," ;
		  	$show['ro']['main'][] = array(
		  		'ROID' => $row->ROID,
				'RODate' => $row->RODate,
				'RONote' => $row->RONote
			);
		};
		if ( $arrROID != '' ) {
			$arrROID = substr($arrROID, 0, -1);
			$sql 	= "SELECT rr.*, @total:=COALESCE(rp.total,0) AS total, rm.RODate, rm.RONote
						FROM tb_ro_main rm 
						LEFT JOIN tb_ro_raw rr ON rm.ROID=rr.ROID
						LEFT JOIN vw_ro_raw_po2 rp ON rr.ROID=rp.ROID AND rr.ProductID=rp.ProductID AND rr.RawID=rp.RawID
						WHERE rr.RawID=".$ProductID." and rm.ROStatus<>2  HAVING rr.RawQty <> total ";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['ro']['raw'][$row2->ROID][] = array(
		  			'RawID' => $row2->RawID,
		  			'ProductID' => $row2->ProductID,
		  			'RawQty' => $row2->RawQty,
		  			'total' => $row2->total
				);
			};
		}
		return $show;
	}
	function product_stock_pending_ro()
	{
		$show 	= array();
		$ProductID = $this->input->get_post('product');
		$show['ProductID'] = $ProductID;
		$arrROID= "";
		$sql 	= "SELECT rp.ROID, rp.ProductID, rl.RODate, rl.qty, rl.qtypo FROM tb_ro_product rp
					LEFT JOIN vw_ro_list rl ON (rp.ROID=rl.ROID)
					WHERE rp.ProductID=".$ProductID." AND rl.ROStatus=0 AND rl.qty>rl.qtypo";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$arrROID .= $row->ROID."," ;
		  	$show['main'][$row->ROID] = array(
		  		'ROID' => $row->ROID,
				'RODate' => $row->RODate,
				'Outstanding' => 0
			);
		};

		$arrROID = substr($arrROID, 0, -1);
		$sql 	= "SELECT rp.*, plp.ProductCode from vw_ro_product rp 
					left join vw_product_list_popup2 plp on rp.ProductID = plp.ProductID 
					where ROID in (".$arrROID.") and rp.ProductQty>total";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['product'][$row2->ROID][] = array(
	  			'ProductID' => $row2->ProductID,
	  			'ProductCode' => $row2->ProductCode,
	  			'ProductQty' => $row2->ProductQty,
	  			'ProductPO' => $row2->ProductQty-$row2->total,
			);

			if ($ProductID == $row2->ProductID) {
				$show['main'][$row2->ROID]['Outstanding'] = $row2->ProductQty - $row2->total;
			}  

			$sql 	= "SELECT rm.ROID, rp.ProductID, pm.POID, pm.PODate, pm.ShippingDate, pp.ProductID, pp.ProductQty, pp.DORQty
					from tb_ro_product rp
					LEFT JOIN tb_ro_main rm ON (rp.ROID = rm.ROID)
					LEFT JOIN tb_po_main pm ON (rm.ROID = pm.ROID)
					LEFT JOIN tb_po_product pp ON (pm.POID = pp.POID)
					WHERE rp.ProductID = ".$row2->ProductID." AND rp.ROID = ".$row2->ROID." and pm.POStatus != 2 and pp.ProductID = ".$row2->ProductID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row3) {
			  	$show['po'][$row2->ROID][$row2->ProductID][] = array(
		  			'POID' => $row3->POID,
		  			'PODate' => $row3->PODate,
		  			'ShippingDate' => $row3->ShippingDate,
		  			'ProductQty' => $row3->ProductQty
				);
			};
		};
		return $show;
	}
	function product_stock_pending_po()
	{
		$show 	= array();
		$ProductID = $this->input->get_post('product');
		$show['ProductID'] = $ProductID;
		$arrPOID= "";
		$sql 	= "SELECT pp.POID, pm.PODate, pm.ShippingDate, pm.PONote, COALESCE (pp.pending,0) AS totaldor
				FROM tb_po_product pp
				LEFT JOIN tb_po_main pm ON (pp.POID=pm.POID)
				WHERE pp.ProductID=".$ProductID." AND pm.POStatus=0 AND Pending !=0";
		$query 	= $this->db->query($sql);
		// echo $sql;
		foreach ($query->result() as $row) {
			$arrPOID .= $row->POID."," ;
			$show['main'][$row->POID] = array(
				'POID' => $row->POID,
				'PODate' => $row->PODate,
				'ShippingDate' => $row->ShippingDate,
				'PONote' => $row->PONote,
				'totaldor' => $row->totaldor,
				// 'Outstanding' => $row->qty-$row->totaldor
			);
		};

		$arrPOID = substr($arrPOID, 0, -1);
		$sql 	= "SELECT pp.POID, pp.ProductID, plp.ProductCode , pp.ProductQty, COALESCE (pp.pending,0) AS totaldor
					FROM tb_po_product pp
					LEFT JOIN tb_product_main plp on pp.ProductID = plp.ProductID
					WHERE pp.POID in (".$arrPOID.")";
		// echo $sql;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
			$show['product'][$row2->POID][] = array(
				'ProductID' => $row2->ProductID,
				'ProductCode' => $row2->ProductCode,
				'ProductQty' => $row2->ProductQty,
				'totaldor' => $row2->totaldor
			);

			if ($ProductID == $row2->ProductID) {
				$show['main'][$row2->POID]['Outstanding'] = $row2->ProductQty - $row2->totaldor;
			}

			$sql 	= "SELECT pp.POID, dm.DORID, dm.DORDate, dd.ProductID, dd.ProductQty
						FROM tb_po_product pp
						LEFT JOIN tb_po_main pm ON (pp.POID = pm.POID)
						LEFT JOIN tb_dor_main dm ON (pm.POID = dm.DORReff)
						LEFT JOIN tb_dor_detail dd ON (dm.DORID = dd.DORID)
						WHERE pp.ProductID = ".$row2->ProductID." AND pp.POID = ".$row2->POID." AND dm.DORType = 'PO' AND dd.ProductID = pp.ProductID";
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row4) {
				$show['dor'][$row2->POID][$row2->ProductID][] = array(
					'DORID' => $row4->DORID,
					'DORDate' => $row4->DORDate,
					'ProductQty' => $row4->ProductQty
				);
			};
		};
		return $show;
	}
	function get_product_detail_minmax()
	{
		$show   = array();
		$ProductID = $this->input->get_post('data');
		$ProductIDNew = "";
		$sql = "SELECT ProductID, ProductCode, MaxStock, MinStock FROM tb_product_main 
				WHERE Stockable=1 and ProductID in (".$ProductID.")";
				// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][$row->ProductID] = array(
				'ProductID' => $row->ProductID, 
				'ProductCode' => $row->ProductCode, 
				'MaxStock' => $row->MaxStock, 
				'MinStock' => $row->MinStock
			);
			$ProductIDNew.= $row->ProductID.",";
		};
		$ProductIDNew = substr($ProductIDNew,0,-1);
		// 3bln
		$sql3 = "SELECT dm.DOType, dd.ProductID, SUM(dd.ProductQty) AS ProductQty, 
				CEILING(SUM(dd.ProductQty)/3) AS avrg  
				FROM tb_do_detail dd
				LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
				WHERE dm.DODate > NOW()- INTERVAL 3 MONTH 
				and dd.ProductID in (".$ProductIDNew.")
				and  dm.DOType<>'MUTATION' 
				GROUP BY dd.ProductID, dm.DOType";
		$query 	= $this->db->query($sql3);
		foreach ($query->result() as $row) {
		  	$show['detail'][$row->ProductID]['3bln'][] = array(
				'DOType' => $row->DOType, 
				'ProductQty' => $row->ProductQty, 
				'avrg' => $row->avrg
			);
		};
		// 6bln
		$sql6 = "SELECT dm.DOType, dd.ProductID, SUM(dd.ProductQty) AS ProductQty, 
				CEILING(SUM(dd.ProductQty)/6) AS avrg  
				FROM tb_do_detail dd
				LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
				WHERE dm.DODate > NOW()- INTERVAL 6 MONTH 
				and dd.ProductID in (".$ProductIDNew.")
				and  dm.DOType<>'MUTATION' 
				GROUP BY dd.ProductID, dm.DOType";
		$query 	= $this->db->query($sql6);
		foreach ($query->result() as $row) {
		  	$show['detail'][$row->ProductID]['6bln'][] = array(
				'DOType' => $row->DOType, 
				'ProductQty' => $row->ProductQty, 
				'avrg' => $row->avrg
			);
		};
		// 9bln
		$sql9 = "SELECT dm.DOType, dd.ProductID, SUM(dd.ProductQty) AS ProductQty, 
				CEILING(SUM(dd.ProductQty)/9) AS avrg  
				FROM tb_do_detail dd
				LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
				WHERE dm.DODate > NOW()- INTERVAL 9 MONTH 
				and dd.ProductID in (".$ProductIDNew.")
				and  dm.DOType<>'MUTATION' 
				GROUP BY dd.ProductID, dm.DOType";
		$query 	= $this->db->query($sql9);
		foreach ($query->result() as $row) {
		  	$show['detail'][$row->ProductID]['9bln'][] = array(
				'DOType' => $row->DOType, 
				'ProductQty' => $row->ProductQty, 
				'avrg' => $row->avrg
			);
		};
		// 12bln
		$sql12 = "SELECT dm.DOType, dd.ProductID, SUM(dd.ProductQty) AS ProductQty, 
				CEILING(SUM(dd.ProductQty)/12) AS avrg  
				FROM tb_do_detail dd
				LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
				WHERE dm.DODate > NOW()- INTERVAL 12 MONTH 
				and dd.ProductID in (".$ProductIDNew.")
				and  dm.DOType<>'MUTATION' 
				GROUP BY dd.ProductID, dm.DOType";
		$query 	= $this->db->query($sql12);
		foreach ($query->result() as $row) {
		  	$show['detail'][$row->ProductID]['12bln'][] = array(
				'DOType' => $row->DOType, 
				'ProductQty' => $row->ProductQty, 
				'avrg' => $row->avrg
			);
		};

		$sql 	= "select * from tb_site_config ";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['main']['StockMin'] = $row->StockMin;
		$show['main']['StockMax'] = $row->StockMax;

		return $show;
	}
	function product_minmax_act()
	{
		$this->db->trans_start();
		$ProductArr = array();

		$productid 	= $this->input->post('productid'); 
		$min 	= $this->input->post('min');
		$max 	= $this->input->post('max'); 
		for ($i=0; $i < count($productid);$i++) { 
   			$data_product[] = array(
		        'ProductID' => $productid[$i],
		        'MinStock' => $min[$i],
		        'MaxStock' => $max[$i]
			);

			$ProductArr[$productid[$i]] = array(
		        'ProductID' => $productid[$i],
		        'MinStock' => $min[$i],
		        'MaxStock' => $max[$i]
			); 
   		};
		$this->db->update_batch('tb_product_main', $data_product, 'ProductID');
		$this->last_query .= "//".$this->db->last_query();

		$this->product_minmax_history($productid, $ProductArr);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function product_minmax_history($ProductID, $ProductArr)
	{
		$this->db->trans_start();
		$data_product_history = array();

		if (!empty($ProductArr)) {
			$sql 	= "SELECT * FROM vw_product_minmax_history_last 
						WHERE ProductID IN (" . implode(',', array_map('intval', $ProductID)) . ")";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				if 	(!(
				    	$ProductArr[$row->ProductID]['ProductID'] === $row->ProductID  && 
				    	$ProductArr[$row->ProductID]['MinStock'] === $row->MinStock  && 
				    	$ProductArr[$row->ProductID]['MaxStock'] === $row->MaxStock  
					)) {
					
					$data_product_history[] = array(
				        'ProductID' => $row->ProductID,
				        'MinStock' => $ProductArr[$row->ProductID]['MinStock'],
				        'MaxStock' => $ProductArr[$row->ProductID]['MaxStock'],
				        'InputDate' => date("Y-m-d H:i:s"),
				        'InputBy' => $this->session->userdata('UserAccountID'),
					);
				}
			};

			if (!empty($data_product)) {
				$this->db->insert_batch('tb_product_minmax_history', $data_product);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

//mutation =================================================================
	function product_mutation_list()
	{
		$sql = "SELECT pm.*, vem.fullname, wm1.WarehouseName as wmfrom, wm2.WarehouseName as wmto, m1.DOQty 
				FROM tb_product_mutation pm
				LEFT JOIN vw_user_account vem ON (pm.MutationBy = vem.UserAccountID)
				LEFT JOIN tb_warehouse_main wm1 ON (pm.WarehouseFrom = wm1.WarehouseID)
				LEFT JOIN tb_warehouse_main wm2 ON (pm.WarehouseTo = wm2.WarehouseID) 
				LEFT JOIN (
					SELECT md.MutationID, SUM(md.DOQty) AS DOQty
					FROM tb_product_mutation_detail md 
					GROUP BY md.MutationID
				) m1 on m1.MutationID=pm.MutationID ";
		if (isset($_REQUEST['status']) && $_REQUEST['status'] != "" && $_REQUEST['status'] != "3") {
			$sql .= "WHERE pm.MutationStatus = '".$_REQUEST['status']."' ";
		} else { 
			$sql .= "WHERE pm.MutationStatus != '3' ";
		}

		if (isset($_REQUEST['input1']) && $_REQUEST['input1'] != "" && $_REQUEST['input2'] != "" ) {
			$sql .= "and pm.MutationInput between '".$_REQUEST['input1']." 00:00:00' and '".$_REQUEST['input2']." 23:59:59' ";
		} else { 
			$sql .= "and MONTH(pm.MutationInput) = MONTH(CURRENT_DATE()) AND YEAR(pm.MutationInput) = YEAR(CURRENT_DATE()) ";
		}

		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != "" ) {
			$sql .= "AND pm.MutationID in (SELECT DISTINCT MutationID FROM tb_product_mutation_detail WHERE ProductID = '".$_REQUEST['productid']."') ";
		}

		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'MutationID' => $row->MutationID,
		  			'DOQty' => $row->DOQty,
		  			'from' => $row->wmfrom,
					'to' => $row->wmto,
					'fullname' => $row->fullname,
		  			'MutationFC' => $row->MutationFC,
		  			'MutationDate' => $row->MutationDate,
		  			'MutationInput' => $row->MutationInput,
		  			'MutationStatus' => $row->MutationStatus
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_mutation_add_act()
	{
		$this->db->trans_start();

		$scheduledate 	= $this->input->post('scheduledate'); 
		$note 			= $this->input->post('note');
		$freightcharge 	= $this->input->post('freightcharge');
		$warehousefrom 	= $this->input->post('warehousefrom');
		$warehouseto 	= $this->input->post('warehouseto');
		$productid 		= $this->input->post('productid');
		$productqty 	= $this->input->post('productqty');

		$data = array(
			'WarehouseFrom' => $warehousefrom,
			'WarehouseTo' => $warehouseto,
			'MutationDate' => $scheduledate,
			'MutationFC' => $freightcharge,
			'MutationInput' => date('Y-m-d H:i:s'),
			'MutationBy' => $this->session->userdata('UserAccountID'),
			'MutationNote' => $note,
			'MutationStatus' => 0
		);
		$this->db->insert('tb_product_mutation', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "select max(MutationID) as MutationID from tb_product_mutation ";
		$getID 	= $this->db->query($sql);
		$row 	= $getID->row();
		$MutationID = $row->MutationID;

		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
		        'MutationID' => $MutationID,
		        'ProductID' => $productid[$i],
		        'ProductQty' => $productqty[$i]
			);
			$this->db->insert('tb_product_mutation_detail', $data_product);
			$this->last_query .= "//".$this->db->last_query();
   		};
		$this->log_user->log_query($this->last_query);

		$this->product_mutation_approval_submission($MutationID);

		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function product_mutation_cancel()
	{
		$this->db->trans_start();

		$cancelnote = $this->input->post('cancelnote');
		$mutationid = $this->input->post('mutationid'); 

		$sql 	= "SELECT MutationStatus FROM tb_product_mutation WHERE MutationID = ".$mutationid;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();

		if ($row->MutationStatus == 0 ) {
			$data = array(
				'MutationCancelNote' => $cancelnote,
				'MutationCancelDate' => date('Y-m-d H:i:s'),
				'MutationStatus' => "2"
			);
			$this->db->where('MutationID', $mutationid);
			$this->db->update('tb_product_mutation', $data);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function mutation_detail()
	{
		$MutationID	= $this->input->get_post('mutationid');
		$sql 	= "SELECT * from tb_product_mutation where MutationID = ".$MutationID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$show   = array();
		if ($row->MutationStatus == 0) {
			$show['main'] = array(
	  			'MutationID' => $row->MutationID,
	  			'MutationDate' => $row->MutationDate,
	  			'WarehouseFrom' => $row->WarehouseFrom,
	  			'WarehouseTo' => $row->WarehouseTo,
				'MutationNote' => $row->MutationNote,
				'MutationFC' => $row->MutationFC
			);
			$sql 	= "SELECT pm.*, plp.ProductCode, plp.stock from tb_product_mutation_detail pm ";
			$sql 	.= "left join vw_product_list_popup2 plp on pm.ProductID = plp.ProductID ";
			$sql 	.= "where MutationID = ".$MutationID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['product'][] = array(
		  			'ProductID' => $row2->ProductID,
		  			'ProductCode' => $row2->ProductCode,
		  			'ProductQty' => $row2->ProductQty,
					'stock' => $row2->stock
				);
			};
			$show['product2'] = json_encode($show['product']);
		} else {
        	redirect(base_url('transaction/product_mutation_list'));
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_mutation_edit_act()
	{
		$this->db->trans_start();

		$MutationID 	= $this->input->post('mutationid'); 
		$scheduledate 	= $this->input->post('scheduledate'); 
		$freightcharge 	= $this->input->post('freightcharge');
		$note 			= $this->input->post('note');
		$warehousefrom 	= $this->input->post('warehousefrom');
		$warehouseto 	= $this->input->post('warehouseto');
		$productid 		= $this->input->post('productid');
		$productqty 	= $this->input->post('productqty'); 

		$data = array(
			'WarehouseFrom' => $warehousefrom,
			'WarehouseTo' => $warehouseto,
			'MutationFC' => $freightcharge,
			'MutationDate' => $scheduledate,
			'MutationInput' => date('Y-m-d H:i:s'),
			'MutationBy' => $this->session->userdata('UserAccountID'),
			'MutationNote' => $note
		);
		$this->db->where('MutationID', $MutationID);
		$this->db->update('tb_product_mutation', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('MutationID', $MutationID);
		$this->db->delete('tb_product_mutation_detail');
		
		for ($i=0; $i < count($productid);$i++) { 
   			$data_product = array(
		        'MutationID' => $MutationID,
		        'ProductID' => $productid[$i],
		        'ProductQty' => $productqty[$i]
			);
			$this->db->insert('tb_product_mutation_detail', $data_product);
			$this->last_query .= "//".$this->db->last_query();
   		};
		$this->log_user->log_query($this->last_query);

		$this->product_mutation_approval_submission($MutationID);

		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function product_mutation_detail_full()
	{
		
		$MutationID = $this->input->get_post('mutationid');
		$show   = array();

		$sql 	= "SELECT pm.*, plp.ProductCode, GROUP_CONCAT(dm.DOID) AS DOID, GROUP_CONCAT(drm.DORID) AS DORID
					FROM tb_product_mutation_detail pm
					LEFT JOIN vw_product_list_popup2 plp ON pm.ProductID = plp.ProductID
					LEFT JOIN tb_dor_main drm ON (pm.MutationID = drm.DORReff and drm.DORType = 'MUTATION')
					LEFT JOIN tb_do_main dm ON (pm.MutationID = dm.DOReff and dm.DOType = 'MUTATION')
					WHERE MutationID = ".$MutationID." GROUP BY pm.ProductID";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row2) {
		  	$show['product'][] = array(
	  			'ProductID' => $row2->ProductID,
	  			'ProductCode' => $row2->ProductCode,
	  			'ProductQty' => $row2->ProductQty,
	  			'DORID' => $row2->DORID,
	  			'DOID' => $row2->DOID
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_mutation_approval_submission($MutationID)
	{
		$this->db->trans_start();

		$datamain = array(
			'MutationApprove' => 0
		);
		$this->db->where('MutationID', $MutationID);
		$this->db->update('tb_product_mutation', $datamain);
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "select ApprovalID from tb_approval_mutation_product where isComplete=0 and MutationID=".$MutationID." LIMIT 1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$ApprovalID = $row->ApprovalID;
		} else {
			$ApprovalID = 0;
		}

		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='mutation_product' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		$query = "update tb_product_mutation set MutationApprove='1' where MutationID='".$MutationID."'";
		if ($Actor3 != 0) {
			$data_approval = array(
				'MutationID' => $MutationID,
				'Title' => "Approval untuk Mutation ID ".$SOID,
				'Actor1' => null,
				'Actor1ID' => null,
				'Actor2' => null,
				'Actor2ID' => null,
				'Actor3' => null,
				'Actor3ID' => null,
				'ApprovalQuery' => $query,
				'isComplete' => 0,
				'Status' => "OnProgress"
			);
		} else {
			$data_approval = array(
				'MutationID' => $MutationID,
				'Title' => "Approval untuk Mutation ID ".$SOID,
				'Actor1' => null,
				'Actor1ID' => null,
				'Actor2' => null,
				'Actor2ID' => null,
				'Actor3' => null,
				'Actor3ID' => null,
				'ApprovalQuery' => $query,
				'isComplete' => 1,
				'Status' => "Approved"
			);
			
			$this->db->query($query);
			$this->last_query .= "//".$this->db->last_query();
		}

		if ($ApprovalID != 0 ) {
			$this->db->where('ApprovalID', $ApprovalID);
			$this->db->update('tb_approval_mutation_product', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$this->db->insert('tb_approval_mutation_product', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

//sales order ==============================================================
	function get_product_price()
	{
    	$data = array();
		$message = $this->input->post('message');
		$pricecategory 	= $this->input->post('pricecategory');
		$pricelist 	= $this->input->post('pricelist');
		$paymentmethod = $this->input->post('paymentmethod');
		$ProductID 	= $message['tdid'];

		// get PV 
		$sql2 	= "SELECT PV from tb_site_config ";
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
		$sql 	= "SELECT ProductPriceHPP, ProductPriceDefault FROM tb_product_main WHERE ProductID= ".$ProductID;
		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();
		$ProductPriceDefault = $row->ProductPriceDefault;
    	$data['ProductPriceHPP'] = $row->ProductPriceHPP;
		
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
        		$data['Promo'] = $row->Promo;
	        	$data['PT1Percent'] = $row->PT1Discount;
	        	$data['PT2Percent'] = $row->PT2Discount;
			} else {
				$data['PriceID'] = "0";
				$data['PriceName'] = "";
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

    	$PVTotal = ($price-$data['ProductPriceHPP'])/$PV;
		if ($PVTotal>0) {
			$PVTotal = number_format($PVTotal,2);
		} else {
			$PVTotal = "0";
		}
		$data['PV'] = $PVTotal;

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
	function get_product_price_pv()
	{
		$data = array();
		$message = $this->input->post('message');
		$pricecategory 	= $this->input->post('pricecategory');
		$pricelist 	= $this->input->post('pricelist');
		$paymentmethod = $this->input->post('paymentmethod');
		$CustomerID 	= $this->input->post('CustomerID');

		$ProductID 	= $message['tdid'];

		// get PV
		$sql2 	= "SELECT PV FROM tb_site_config ";
		$getrow = $this->db->query($sql2);
		$row2	= $getrow->row();
		$PV 	= $row2->PV;

		// get CustomerPVMp and SEPVMp
		$sql3 	= "SELECT CustomerPVMultiplier, SEPVMultiplier FROM tb_customer_main tcm
					WHERE tcm.CustomerID=".$CustomerID;
		$grow = $this->db->query($sql3);
		$row3	= $grow->row();
		$CustomerPVMultiplier = $row3->CustomerPVMultiplier;
		$data['CustomerPVMultiplier'] = $row3->CustomerPVMultiplier;
		$data['SEPVMultiplier'] = $row3->SEPVMultiplier;


		$sql 	= "SELECT ProductPriceHPP, ProductPriceDefault, ProductMultiplier, COALESCE(pa.AtributeValue,'STD') AS ProductType
					FROM tb_product_main pm
					LEFT JOIN tb_product_atribute_detail pa ON pm.ProductID=pa.ProductID AND pa.ProductAtributeID=16
					WHERE pm.ProductID=".$ProductID;
		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();

		$data['ProductID'] = $ProductID;
		$data['ProductName'] = $message['tdname'];
		if($row->ProductPriceHPP>$row->ProductPriceDefault){
			$data['ProductPriceHPP'] = $row->ProductPriceDefault;
		} else {
			$data['ProductPriceHPP'] = $row->ProductPriceHPP;
		}
		$data['ProductPriceDefault'] = $row->ProductPriceDefault;
		$data['ProductMultiplier'] = $row->ProductMultiplier;
		$data['ProductType'] = ($row->ProductType == "CSTM") ? "custom" : "standard";

		$sql2 	= "SELECT AtributeValue FROM tb_product_atribute_detail WHERE ProductAtributeID=2 and ProductID=".$ProductID;
		$hasil2 	= $this->db->query($sql2);
		$row2 	= $hasil2->row();
		$data['ProductWeight'] = ($row2->AtributeValue == 0) ? 1 : $row2->AtributeValue;

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
			$hasil3 = $this->db->query($sql);
			$row3	= $hasil3->row();
		}

		if ( isset($hasil3) and $hasil3->num_rows()){
			$data['Promocategory'] = $row3->PromoDefault;
			$data['PricelistID'] = $row3->PricelistID;
			$data['PricelistName'] = $row3->PricelistName;
			$data['Promo'] = $row3->Promo;
			$data['PT1Percent'] = $row3->PT1Discount;
			$data['PT2Percent'] = $row3->PT2Discount;
		} else {
			$data['Promocategory'] = 0;
			$data['PricelistID'] = 0;
			$data['PricelistName'] = "";
			$data['Promo'] = 0;
			$data['PT1Percent'] = 0;
			$data['PT2Percent'] = 0;
		}

		$PVTotal = ($data['ProductPriceDefault']-$data['ProductPriceHPP'])/$PV;
		$PVTotal = $PVTotal*$CustomerPVMultiplier*1000;
		if ($PVTotal>0) {
			$PVTotal = $PVTotal;
		} else {
			$PVTotal = "0";
		}
		$data['PV'] = $PV;
		$data['PVTotal'] = $PVTotal;

		$data['ProductPriceDefault2'] = $row->ProductPriceDefault - ( ($data['ProductPriceDefault']/100)*$data['Promocategory'] );

		$data['ProductPriceDefault'] = $data['ProductPriceDefault'] - ( ($data['ProductPriceDefault']/100)*$data['Promocategory'] );
		
		$Promo = $row->ProductPriceDefault - ( ($row->ProductPriceDefault/100)*$data['Promo'] );

		$pricePT1 = $Promo - ( ($Promo/100)*$data['PT1Percent'] );
		$pricePT2 = $Promo - ( ($Promo/100)*$data['PT2Percent'] );

		// $data['CustomerID'] = $CustomerID;
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
	function get_product_promo_pv()
	{
		$data 		= array();
		$ProductID 	= $this->input->post('ProductID');
		$CustomerID = $this->input->post('CustomerID');
		$ProductQty	= $this->input->post('ProductQty');
		$pricelist 	= $this->input->post('pricelist');
		$promovol 	= $this->input->post('promovol');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$paymentmethod 	= $this->input->post('paymentmethod');

		// get price endUser
		$sql 	= "SELECT ProductPriceHPP, ProductPriceDefault FROM tb_product_main WHERE ProductID= ".$ProductID;
		$hasil 	= $this->db->query($sql);
		$row 	= $hasil->row();
		$ProductPriceDefault = $row->ProductPriceDefault;
		$data['ProductPriceHPP'] = $row->ProductPriceHPP;

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
				$data['Promo'] = $row->Promo;
				$data['PT1Percent'] = $row->PT1Discount;
				$data['PT2Percent'] = $row->PT2Discount;
			} else {
				$data['PriceID'] = "0";
				$data['PriceName'] = "";
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
	function sales_order_add()
	{
		$sql 	= "SELECT SOShipDate, SODepositStandard, SODepositCustom, SODepositProject, MPfee
					from tb_site_config where id=1";
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$show['SODepositStandard'] = $row->SODepositStandard;
		$show['SODepositCustom'] = $row->SODepositCustom;
		$show['SODepositProject'] = $row->SODepositProject;
		$show['SOShipDate'] = $row->SOShipDate;
		$show['MPfee'] = $row->MPfee;


		$show['shop'] = array();
		$sql 	= "SELECT * from tb_shop_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['shop'][] = array(
		  			'ShopID' => $row->ShopID, 
					'ShopName' => $row->ShopName, 
				);
		};
		$show['mp'] = array();
		$sql 	= "SELECT * from tb_mp";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['mp'][] = array(
					'MPID' => $row->MPID,
					'MarketPlace' => $row->MarketPlace,
				);
		};
		$show['ekspedisi'] = array();
		$sql 	= "SELECT * from vw_expedition_online";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['ekspedisi'][] = array(
					'ExpeditionID' => $row->ExpeditionID,
					'Company' => $row->Company,
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
		$show['category'] = array();
	    $sql 	= "SELECT sc.* from tb_so_category sc";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['category'][] = array(
		  			'CategoryID' => $row->CategoryID, 
		  			'CategoryName' => $row->CategoryName, 
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
		$projectid 	= $this->input->post('projectid');
		$socategory = $this->input->post('socategory');
		$sotype = $this->input->post('sotype');
		$invcategory = $this->input->post('invcategory');
		$minimumdp 	= $this->input->post('minimumdp');
		$sodate 	= $this->input->post('sodate');
		$shop 	= $this->input->post('shop');
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
			'SOShipDate1Need' => $DueDate1,
			'SOShipDate2Need' => $DueDate2,
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
   		
   		// $this->sales_order_approval_submission($SOID, $socategory, $invcategory, $paymentterm, $sopaymentterm, "add", $creditavailable, $sototal, $paymentmethod, $customer);
   		$this->SOShipDate_history($SOID, $shipdate, 'formSO');

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function sales_order_offline_add_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);

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
		$SEPVMp		= $this->input->post('SEPVMp');
		$projectid 	= "0";
		$socategory = $this->input->post('socategory');
		$sotype = "standard";
		$invcategory = "1";
		$minimumdp 	= $this->input->post('minimumdp');
		$sodate 	= $this->input->post('sodate');
		$invmp 	= $this->input->post('invmp');
		$pono 	= $this->input->post('pono');
		$mp 	= $this->input->post('mp');
		$resi 	= $this->input->post('resi');
		$ekspedisi 	= $this->input->post('ekspedisi');
		$label 	= $this->input->post('label');
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
		$PVSO		= $this->input->post('PV2');
		$PVSOTotal		= $this->input->post('PVTotal');

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
		// echo ($this->last_query);
		$sql 		= "SELECT max(SOID) as SOID from tb_so_main ";
		$getSOID 	= $this->db->query($sql);
		$row 		= $getSOID->row();
		$SOID 		= $row->SOID;
		//get SEPV Multiplier
		$sql3 	= "SELECT SEPVMultiplier
					FROM tb_customer_main tcm
					WHERE tcm.CustomerID=".$customer;
		$grow = $this->db->query($sql3);
		$row3	= $grow->row();
		$SEPVMultiplier = $row3->SEPVMultiplier;

		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;

		if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
			$filesnames = $_FILES['label']['name'];
            $target_dir = "assets/PDFLabel/";
            $target_file = $target_dir . $filesnames;
            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
				$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
				$data_file['File'] = $label;
            }
        }

		$datamain2 = array(
			'SOID' => $SOID,
			'SOShipDateNote' => $DueDateNote,
			// 'SOShipDateFinal' => $shipdate,
			'INVMP' => $invmp,
			'PONumber' => $pono,
			'MPID' => $mp,
			'ResiNo' => $resi,
			'ExpeditionID' => $ekspedisi,
			'Label' => $filesnames,
			'SOShipDate1Need' => "0",
			'SOShipDate2Need' => "0",
			'SEPVMp' => $SEPVMultiplier,
		);
		if ($DueDate1 == 0 and $DueDate2 == 0) {
			$datamain2['SOShipDateFinal'] = $shipdate;
		}
		$this->db->insert('tb_so_main2', $datamain2);
		$this->last_query .= "//".$this->db->last_query();

		for ($i=0; $i < count($ProductID);$i++) {
			$sql 		= "SELECT ProductPriceHPP, ProductMultiplier from tb_product_main where ProductID=".$ProductID[$i];
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
				'PT1Price' => $PT1Price[$i]-$PVSO[$i],
				'PT2Percent' => $PT2Percent[$i],
				'PT2Price' => $PT2Price[$i]-$PVSO[$i],
				'PricePercent' => $PricePercent[$i],
				'PriceAmount' => $PriceAmount[$i]-$PVSO[$i],
				'FreightCharge' => $FreightCharge[$i],
				'PriceTotal' => $linetotal[$i],
				'Pending' => $ProductQty[$i],
				'PVSO' => $PVSO[$i],
				'PVSOTotal' => $PVSOTotal[$i],
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
	function sales_order_online_add_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);

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
		$invmp 	= $this->input->post('invmp');
		$pono 	= $this->input->post('pono');
		$mp 	= $this->input->post('mp');
		$resi 	= $this->input->post('resi');
		$ekspedisi 	= $this->input->post('ekspedisi');
		$label 	= $this->input->post('label');
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
		// echo ($this->last_query);
		$sql 		= "select max(SOID) as SOID from tb_so_main ";
		$getSOID 	= $this->db->query($sql);
		$row 		= $getSOID->row();
		$SOID 		= $row->SOID;

		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;

		if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
			$filesnames = $_FILES['label']['name'];
            $target_dir = "assets/PDFLabel/";
            $target_file = $target_dir . $filesnames;
            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
				$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
				$data_file['File'] = $label;
            }
        }

		$datamain2 = array(
			'SOID' => $SOID,
			'SOShipDateNote' => $DueDateNote,
			// 'SOShipDateFinal' => $shipdate,
			'INVMP' => $invmp,
			'PONumber' => $pono,
			'MPID' => $mp,
			'ResiNo' => $resi,
			'ExpeditionID' => $ekspedisi,
			'Label' => $filesnames,
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
	function sales_order_edit()
	{
		$show   = array();
		$SOID 	= $this->input->get_post('so');
		$sql 	= "SELECT sm.*, vs.Company, cm.PaymentTerm as PaymentTerm2, cm.CreditLimit, 
					vem1.Company2 as secname, vem2.Company2 as salesname, sc.CategoryName, 
					tsm.INVMP, tsm.MPID, tsm.ResiNo, tsm.PONumber, tsm.Label, tsm.ExpeditionID,
					vsb.TotalDeposit, vsb.TotalPayment,	 
					COALESCE(SUM(vsdo.totaldo),0) as totaldo from tb_so_main sm 
					LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID)
					LEFT JOIN vw_contact2 vs ON (cm.ContactID = vs.ContactID)
					LEFT JOIN vw_sales_executive2 vem1 ON (sm.SECID = vem1.SalesID)
					LEFT JOIN vw_sales_executive2 vem2 ON (sm.SalesID = vem2.SalesID) 
					LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID) 
					LEFT JOIN tb_so_main2 tsm ON (sm.SOID = tsm.SOID)
					LEFT JOIN vw_so_balance vsb ON (sm.SOID = vsb.SOID) 
					LEFT JOIN vw_so_do2 vsdo ON (sm.SOID = vsdo.SOID) where sm.SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();
		$show['so'] = get_object_vars($rowso);
		$CustomerID = $rowso->CustomerID;

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
	    			LEFT JOIN tb_project_so tps ON tps.ProjectID = tp.ProjectID
	    			LEFT JOIN vw_customer3 vc ON vc.CustomerID = tp.CustomerID where SOID= ".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['project'][] = array(
		  			'ProjectID' => $row->ProjectID, 
		  			'Company2' => $row->Company2, 
				);
		};
		$show['mp'] = array();
		$sql 	= "SELECT * from tb_mp";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['mp'][] = array(
					'MPID' => $row->MPID,
					'MarketPlace' => $row->MarketPlace,
				);
		};
		$show['ekspedisi'] = array();
		$sql 	= "SELECT * from vw_expedition_online";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['ekspedisi'][] = array(
					'ExpeditionID' => $row->ExpeditionID,
					'Company' => $row->Company,
				);
		};

		$show['category'] = array();
	    $sql 	= "SELECT sc.* from tb_so_category sc";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['category'][] = array(
		  			'CategoryID' => $row->CategoryID, 
		  			'CategoryName' => $row->CategoryName, 
				);
		};

		$sql 	= "select * from tb_so_main2 where SOID=".$SOID;
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		if (!empty($row)) {
			$show['so']['SOShipDateNote'] = $row->SOShipDateNote;
			$show['so']['SOShipDate1Need'] = $row->SOShipDate1Need;
			$show['so']['SOShipDate2Need'] = $row->SOShipDate2Need;
			$show['so']['SOShipDate3Need'] = $row->SOShipDate3Need;
		} else {
			$show['so']['SOShipDateNote'] = '';
			$show['so']['SOShipDate1Need'] = 0;
			$show['so']['SOShipDate2Need'] = 0;
			$show['so']['SOShipDate3Need'] = 0;
		}

		$show['so']['CreditLimit'] = $show['so']['CreditLimit'];
		$this->load->model('model_finance', 'finance');
		$debt = $this->finance->get_customer_debt2($CustomerID,$SOID);
		$show['so']['creditavailable'] = $rowso->CreditLimit - $debt;
		if ($show['so']['PaymentWay'] == "TOP" && $show['so']['SOConfirm1']==1) {
			$show['so']['creditavailable'] += $show['so']['TotalDeposit'] ;
		}
		$show['so']['PermitNote'] = preg_replace("/\r\n|\r|\n/",'. ', $show['so']['PermitNote']);

		$sql 	= "select SODepositStandard, SODepositCustom, SODepositProject from tb_site_config where id=1";
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$show['so']['SODepositStandard'] = $row->SODepositStandard;
		$show['so']['SODepositCustom'] = $row->SODepositCustom;
		$show['so']['SODepositProject'] = $row->SODepositProject;

		// get product
		$sql 	= "SELECT sd.*, sd.ProductQty-sd.Pending AS totaldo,
					COALESCE(pa.AtributeValue,'STD') AS ProductType FROM tb_so_detail sd
					LEFT JOIN tb_product_atribute_detail pa ON sd.ProductID=pa.ProductID AND pa.ProductAtributeID=16
					WHERE sd.SOID =".$SOID;

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
				'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductType' => ($row->ProductType == "CSTM") ? "custom" : "standard",
				'ProductWeight' => $row->ProductWeight,
				'PriceID' => $row->PriceID,
				'PriceName' => $row->PriceName,
				'PT1Percent' => $row->PT1Percent,
				'PT1Price' => $row->PT1Price,
				'PT2Percent' => $row->PT2Percent,
				'PT2Price' => $row->PT2Price,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal,
				'totaldo' => $row->totaldo
			);
		};
		// print_r($show['detail']);

		// get shipping
		$shipping 	= explode(";", $rowso->ShipAddress);
		$addressid 	= 0;
		$show['shipping'][$addressid] = array(
		  'addressid' => $addressid,
		  'DetailType' => $shipping[1],
		  'DetailValue' => $shipping[2],
		  'ExpeditionID' => $rowso->ExpeditionID,
		  'FCPrice' => $rowso->ExpeditionPrice,
		  'FCWeight' => $rowso->ExpeditionWeight
        );
		$sql 	= "SELECT vca.*, ac.FCPrice, ac.FCWeight, vex.ExpeditionID
					FROM vw_contact_address vca
					LEFT JOIN tb_customer_main cm ON (vca.ContactID = cm.ContactID)
					LEFT JOIN vw_city ac ON (vca.CityID = ac.CityID)
					LEFT JOIN vw_expedition1 vex ON (ac.ExpeditionID = vex.ExpeditionID)
					WHERE cm.CustomerID=".$CustomerID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$addressid += 1;
			$StateName 		= (is_null($row->StateName))? "" : ", ".$row->StateName;
			$ProvinceName 	= (is_null($row->ProvinceName))? "" : ", ".$row->ProvinceName;
			$CityName 		= (is_null($row->CityName))? "" : ", ".$row->CityName;
			$DistrictsName 	= (is_null($row->DistrictsName))? "" : ", ".$row->DistrictsName;
			$PosName 		= (is_null($row->PosName))? "" : ", ".$row->PosName;
			$show['shipping'][$addressid] = array(
		      'addressid' => $addressid,
		      'DetailType' => $row->DetailType,
		      'DetailValue' => $row->DetailValue." ".$DistrictsName.$CityName.$ProvinceName.$StateName.$PosName,
		      'ExpeditionID' => $row->ExpeditionID,
		      'FCPrice' => $row->FCPrice,
		      'FCWeight' => $row->FCWeight
		  );
		};

		// get sales and price category
		$show['sales'][] = array(
		  'SalesID' => $rowso->SalesID,
		  'SalesName' => $rowso->salesname
        );
		$sql2 = "select cd.*, vem.SalesID, vem.Company2 from tb_customer_detail cd ";
		$sql2 .= "LEFT JOIN vw_sales_executive2 vem ON cd.DetailValue = vem.SalesID ";
		$sql2 .= "where cd.DetailType in ('sales','price') ";
		$sql2 .= "and cd.CustomerID = '".$CustomerID."' ";
		$show['price'][] = 0;
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			if ($row2->DetailType == 'sales') {
				$show['sales'][] = array(
				'SalesID' => $row2->SalesID,
				'SalesName' => $row2->Company2
		      );
			} elseif ($row2->DetailType == 'price') {
				$show['price'][] = $row2->DetailValue;
			}
		};

		$sql2 = "select * from tb_price_category_main where PricecategoryID  in (". implode(',', array_map('intval', $show['price'])).")";
		$query2 = $this->db->query($sql2);
		$show['pricename'] = array();
		foreach ($query2->result() as $row2) {
			$show['pricecategory'][] = $row2->PricecategoryID;
			$show['pricename'][] = array(
			  'Type' => "Price Category",
			  'PricecategoryID' => $row2->PricecategoryID,
			  'PricecategoryName' => $row2->PricecategoryName
	        );
		};

		// get pricelist
		if (array_key_exists("price", $show)) {
			$sql2 = "SELECT pcd.*, plm.*
					FROM tb_price_category_detail pcd
					LEFT JOIN tb_price_list_main plm ON (pcd.PricelistID = plm.PricelistID) 
					where 
					plm.PricelistID in (select PricelistID from vw_price_list_active) and 
					pcd.PricecategoryID in (". implode(',', array_map('intval', $show['price'])) .") 
					AND plm.DateEnd >= CURDATE() ";
			$query2 = $this->db->query($sql2);
			$result = $query2->result();
			if (!empty($result)) {
				foreach ($query2->result() as $row2) {
					$show['pricelist'][] = $row2->PricelistID;
					$show['pricename'][] = array(
					    'Type' => "PriceList",
					    'PricecategoryID' => $row2->PricelistID,
					    'PricecategoryName' => $row2->PricelistName
					);
				};
			} else {
				$show['pricelist'][] = "0";
			}

			$sql2 = "SELECT PromoVolID, PromoVolName FROM tb_price_promo_vol_main
					WHERE  
					PromoVolID in (select PromoVolID from vw_price_promo_vol_active) and 
					PricecategoryID IN (". implode(',', array_map('intval', $show['price'])) .") 
					AND DateEnd >= CURDATE()";
			$query2 = $this->db->query($sql2);
			$result = $query2->result();
			if (!empty($result)) {
				foreach ($query2->result() as $row2) {
					$show['promovolume'][] = $row2->PromoVolID;
					$show['pricename'][] = array(
					    'Type' => "PromoVolume",
					    'PricecategoryID' => $row2->PromoVolID,
					    'PricecategoryName' => $row2->PromoVolName
					);
				};
			} else {
				$show['promovolume'][] = "0";
			}
		}

		// get invoice late
		$inv_late = $this->get_inv_late($CustomerID);
		if (count($inv_late) > 0) {
			$show['inv_late'] = $inv_late;
		} else {
			$show['inv_late']['false'] = "";
		}
		// print_r($show['inv_late']);

		$show['inv_late2'] = json_encode($show['inv_late']);
		$show['so2']		= json_encode($show['so']);
		$show['detail2'] 	= json_encode($show['detail']);
		$show['shipping2'] 	= json_encode($show['shipping']);
		$show['sales2'] 	= json_encode($show['sales']);
		$show['price2'] 	= json_encode($show['price']);
		$show['pricecategory2'] = json_encode($show['pricecategory']);
		$show['pricelist2'] = json_encode($show['pricelist']);
		$show['pricename2'] = json_encode($show['pricename']);
		$show['promovolume2'] = json_encode($show['promovolume']);

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_edit_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$SOID 		= $this->input->post('soid');
		$CustomerID = $this->input->post('CustomerID');
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
		$projectid 	= $this->input->post('projectid');
		$pono 	= $this->input->post('pono');
		$INVMP2	= $this->input->post('invmp2');
		$INVMP 	= $this->input->post('invmp');
		$MPID 	= $this->input->post('mp');
		$ResiNo2 	= $this->input->post('resi2');
		$ResiNo 	= $this->input->post('resi');
		$ExpeditionID 	= $this->input->post('ekspedisi');
		$invcategory = $this->input->post('invcategory');
		$label2 = $this->input->post('label2');
		$label = $this->input->post('label');
		$filesnames = $this->input->post('label');
		$sodate 	= $this->input->post('sodate');
		$shop 	= $this->input->post('shop');
		$shipdate 	= $this->input->post('shipdate');
		$paymentmethod 	= $this->input->post('paymentmethod');
		$sopaymentterm 	= $this->input->post('sopaymentterm');
		$sotype = $this->input->post('sotype');
		$minimumdp = $this->input->post('minimumdp');
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
		$totaldo 		= $this->input->post('totaldo');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$PricelistID 	= $this->input->post('PricelistID');
		$PricelistName 	= $this->input->post('PricelistName');
		$PricePercent 	= $this->input->post('PricePercent');
		$PT1Percent 	= $this->input->post('PT1Percent');
		$PT2Percent 	= $this->input->post('PT2Percent');
		$PT1Price 	= $this->input->post('PT1Price');
		$PT2Price 	= $this->input->post('PT2Price');
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
		$sototalOld 	= $this->input->post('sototalOld');
		$do = 0;

		$DueDate1 = ($this->input->post('DueDate1')) ? $this->input->post('DueDate1') : 0;
		$DueDate2 = ($this->input->post('DueDate2')) ? $this->input->post('DueDate2') : 0;
		$DueDateNote = $this->input->post('DueDateNote');

		// cek jika ada perubahan
   		$errorCount = 0;
   		$sql 	= "SELECT * from tb_so_main where SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();

		if ( 
			($rowso->PaymentDeposit != $minimumdp && $rowso->SOConfirm1 == 1) || 
			($rowso->PaymentDeposit != $minimumdp && $rowso->SOConfirm1 == 0) || 
			($rowso->PaymentDeposit == $minimumdp && $rowso->SOConfirm1 == 0) 
		) {
			// cek dp
			$sql 	= "select SODepositStandard, SODepositCustom, SODepositProject from tb_site_config where id=1";
			$getRow = $this->db->query($sql);
			$row 	= $getRow->row();
			$SODepositStandard = $row->SODepositStandard;
			$SODepositCustom = $row->SODepositCustom;
			$SODepositProject = $row->SODepositProject;
			if ($rowso->SOType == "standard" && $rowso->PaymentDeposit < $SODepositStandard) {
	   			$errorCount += 1;
			} 
			if ($rowso->SOType == "custom" && $rowso->PaymentDeposit < $SODepositCustom) {
	   			$errorCount += 1;
			}
			if ($rowso->SOType == "project" && $rowso->PaymentDeposit < $SODepositProject) {
	   			$errorCount += 1;
			}
		}

		if ($rowso->INVCategory != $invcategory) {
   			$errorCount += 1;
		}
		if ($rowso->PaymentWay != $paymentmethod) {
   			$errorCount += 1;
		}
		if ($rowso->PaymentTerm != $sopaymentterm) {
   			$errorCount += 1;
		}
		// if ($rowso->SOTotal != $sototal) {
   			// $errorCount += 1;
		// }
		if ($rowso->SOConfirm1 != 1) {
   			$errorCount += 1;
		}
		$sql 	= "SELECT sd.* FROM tb_so_detail sd WHERE sd.SOID =".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$detail[$row->ProductID] = array(
		  		'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductWeight' => $row->ProductWeight,
				'PriceID' => $row->PriceID,
				'PriceName' => $row->PriceName,
				'PT1Percent' => $row->PT1Percent,
				'PT1Price' => $row->PT1Price,
				'PT2Percent' => $row->PT2Percent,
				'PT2Price' => $row->PT2Price,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal,
			);
		};
		// -----------------------------------------------------------------------

		$datamain = array(
			'SalesID' => $sales,
			'BillingAddress' => str_replace(array('\n', '\r'), ' ', $billing),
			'ShipAddress' => str_replace(array('\n', '\r'), ' ', $shipping),
			'PaymentWay' => $paymentmethod,
			'PaymentTerm' => $sopaymentterm,
			'SOType' => $sotype,
			'SODate' => $sodate,
			'ShopID' => $shop,
			'SOShipDate' => $shipdate,
			'INVCategory' => $invcategory,
			'PaymentDeposit' => $minimumdp,
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
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID')
		);
		if ($this->input->post('socategory')) {
			$datamain['SOCategory'] = $this->input->post('socategory');
		}
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main', $datamain);
		$this->last_query .= "//".$this->db->last_query();

		//------------------------------------------------------------------------------
		$sql 	= "select count(ProjectID) as project from tb_project_so where SOID=".$SOID;
		$query  = $this->db->query($sql);
		$row 	= $query->row();
		$show['project'] = $row->project;

		if($show['project']==0){

			if ($projectid!='0') {
   			$dataproject = array(
				'ProjectID' => $projectid,
				'SOID' => $SOID,
			);		
			$this->db->insert('tb_project_so', $dataproject);
			$this->last_query .= "//".$this->db->last_query();
   			}

		} else {	

			$this->db->set('ProjectID', $projectid);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_project_so');
			$this->last_query .= "//".$this->db->last_query();
		}

		// ----------------------------------------------------------------------------- 
		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;
		if($label==""){
			if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
				$filesnames = $_FILES['label']['name'];
	            $target_dir = "assets/PDFLabel/";
	            $target_file = $target_dir . $filesnames;
	            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
					$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['File'] = $label;
	            }
	        }
		}
		if($INVMP==""){
			$INVMPInput=$INVMP2;
		} else {
			$INVMPInput=$INVMP;
		}
		if($ResiNo==""){
			$ResiNoInput=$ResiNo2;
		} else {
			$ResiNoInput=$ResiNo;
		}
		if($label==""){
			$filesnamesInput=$label2;
		} else {
			$filesnamesInput=$filesnames;
		}
		$datamain2 = array(
			'SOShipDateNote' => $DueDateNote,
			'SOShipDate1Need' => $DueDate1,
			'SOShipDate2Need' => $DueDate2,
			'PONumber' => $pono,
			'INVMP' => $INVMPInput,
			'MPID' => $MPID,
			'ResiNo' => $ResiNoInput,
			'ExpeditionID' => $ExpeditionID,
			'label' => $filesnamesInput,
		);
		if ($DueDate1 == 0 and $DueDate2 == 0) {
			$datamain2['SOShipDateFinal'] = $shipdate;
			$datamain2['SOShipDate1'] = null;
			$datamain2['SOShipDate2'] = null;
			$datamain2['SOShipDate1Created'] = null;
			$datamain2['SOShipDate2Created'] = null;
			$datamain2['SOShipDate1By'] = null;
			$datamain2['SOShipDate2By'] = null;
		} else {
			$datamain2['SOShipDateFinal'] = null;
		}

		$this->db->where('SOID', $SOID);
		$q = $this->db->get('tb_so_main2');
		if ( $q->num_rows() > 0 )  {
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main2',$datamain2);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$this->db->set('SOID', $SOID);
			$this->db->insert('tb_so_main2',$datamain2);
			$this->last_query .= "//".$this->db->last_query();
		}
		// --------------------------------------------------------------------------------

		$this->db->where('SOID', $SOID);
		$this->db->delete('tb_so_detail');
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
				'PriceTotal' => $linetotal[$i]
			);
			$this->db->insert('tb_so_detail', $datadetail);
			$this->last_query .= "//".$this->db->last_query();

			// $this->db->where('SOID', $SOID);
			// $this->db->where('ProductID', $ProductID[$i]);
			// $this->db->update('tb_so_detail', $datadetail);
			// $this->last_query .= "//".$this->db->last_query();
			$do += $totaldo[$i];

			// cek jika ada perubahan
			// print_r( $detail[$ProductID[$i]] ) ;
			if (isset($detail[$ProductID[$i]])) {
				if ($PriceAmount[$i] != $detail[$ProductID[$i]]['PriceAmount']) {
					$errorCount += 1;
				}
				if ($linetotal[$i] != $detail[$ProductID[$i]]['PriceTotal']) {
					$errorCount += 1;
				}
			}
			// -------------------------------------------
		};
		// echo $do;

		if ($errorCount > 0) {
			if ($do == 0) {
				if ($rowso->SOStatus == 1) {
					$sql 		= "select SOCategory from tb_so_main where SOID=".$SOID;
					$getDetail 	= $this->db->query($sql);
					$row 		= $getDetail->row();
					$socategory = $row->SOCategory;
					// echo $sototal.'-'.$sototalOld;
					$this->sales_order_approval_submission($SOID, $socategory, $invcategory, $paymentterm, $sopaymentterm, "edit", $creditavailable, $sototal, $paymentmethod, $CustomerID);
				}
			}
		} else {
			$this->db->set('SOConfirm1', 1);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main');
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select ApprovalID from tb_approval_so where isComplete=0 and SOID=".$SOID." LIMIT 1";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			if (!empty($row)) {
				$ApprovalID = $row->ApprovalID;
				$data_approval = array(
					'SOID' => $SOID,
					'Title' => "SO ".$SOID,
					'Actor1' => null,
					'Actor1ID' => null,
					'Actor2' => null,
					'Actor2ID' => null,
					'Actor3' => null,
					'Actor3ID' => null,
					'Note' => $note,
					'ApprovalQuery' => "update tb_so_main set SOConfirm1='1' where SOID='".$SOID."'",
					'isComplete' => 1,
					'Status' => "Approved"
				);
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		// echo $this->last_query;
		$this->SOShipDate_history($SOID, $shipdate, 'formSO');
		$this->update_SOConfirm2($SOID, 'formSO');
		$this->update_pending_so($SOID);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function sales_order_offline_edit()
	{
		$show   = array();
		$SOID 	= $this->input->get_post('so');
		$sql 	= "SELECT sm.*, vs.Company, cm.PaymentTerm as PaymentTerm2, cm.CreditLimit,
					vem1.Company2 as secname, vem2.Company2 as salesname, sc.CategoryName, tsm.PONumber, veo.Company as Expedition, tmp.MarketPlace,  tsm.MPID, tsm.INVMP, tsm.ResiNo,
					vsb.TotalDeposit, vsb.TotalPayment,
					COALESCE(SUM(vsdo.totaldo),0) as totaldo from tb_so_main sm
					LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID)
					LEFT JOIN vw_contact2 vs ON (cm.ContactID = vs.ContactID)
					LEFT JOIN vw_sales_executive2 vem1 ON (sm.SECID = vem1.SalesID)
					LEFT JOIN vw_sales_executive2 vem2 ON (sm.SalesID = vem2.SalesID) 
					LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID)
					LEFT JOIN tb_so_main2 tsm ON (sm.SOID = tsm.SOID)
					LEFT JOIN tb_mp tmp ON (tmp.MPID = tsm.MPID)
					LEFT JOIN vw_expedition_online veo ON (veo.ExpeditionID = tsm.ExpeditionID)
					LEFT JOIN vw_so_balance vsb ON (sm.SOID = vsb.SOID)
					LEFT JOIN vw_so_do2 vsdo ON (sm.SOID = vsdo.SOID) where sm.SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();
		$show['so'] = get_object_vars($rowso);
		$CustomerID = $rowso->CustomerID;

		$show['shop'] = array();
		$sql 	= "SELECT * from tb_shop_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['shop'][] = array(
					'ShopID' => $row->ShopID,
					'ShopName' => $row->ShopName,
				);
		};
		$show['mp'] = array();
		$sql 	= "SELECT * from tb_mp";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['mp'][] = array(
					'MPID' => $row->MPID,
					'MarketPlace' => $row->MarketPlace,
				);
		};
		$show['ekspedisi'] = array();
		$sql 	= "SELECT * from vw_expedition_online";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['ekspedisi'][] = array(
					'ExpeditionID' => $row->ExpeditionID,
					'Company' => $row->Company,
				);
		};

		$show['category'] = array();
		$sql 	= "SELECT sc.* from tb_so_category sc";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['category'][] = array(
					'CategoryID' => $row->CategoryID,
					'CategoryName' => $row->CategoryName,
				);
		};

		$sql 	= "SELECT * from tb_so_main2 where SOID=".$SOID;
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$SEPVMp = $row->SEPVMp;

		if (!empty($row)) {
			$show['so']['SOShipDateNote'] = $row->SOShipDateNote;
			$show['so']['SOShipDate1Need'] = $row->SOShipDate1Need;
			$show['so']['SOShipDate2Need'] = $row->SOShipDate2Need;
			$show['so']['SOShipDate3Need'] = $row->SOShipDate3Need;
		} else {
			$show['so']['SOShipDateNote'] = '';
			$show['so']['SOShipDate1Need'] = 0;
			$show['so']['SOShipDate2Need'] = 0;
			$show['so']['SOShipDate3Need'] = 0;
		}

		$show['so']['CreditLimit'] = $show['so']['CreditLimit'];
		$this->load->model('model_finance', 'finance');
		$debt = $this->finance->get_customer_debt2($CustomerID,$SOID);
		$show['so']['creditavailable'] = $rowso->CreditLimit - $debt;
		if ($show['so']['PaymentWay'] == "TOP" && $show['so']['SOConfirm1']==1) {
			$show['so']['creditavailable'] += $show['so']['TotalDeposit'] ;
		}
		$show['so']['PermitNote'] = preg_replace("/\r\n|\r|\n/",'. ', $show['so']['PermitNote']);

		$sql 	= "SELECT SODepositStandard, SODepositCustom, SODepositProject from tb_site_config where id=1";
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$show['so']['SODepositStandard'] = $row->SODepositStandard;
		$show['so']['SODepositCustom'] = $row->SODepositCustom;
		$show['so']['SODepositProject'] = $row->SODepositProject;

		// get PV 
		$sql3 	= "SELECT PV from tb_site_config ";
		$getrow = $this->db->query($sql3);
		$row3	= $getrow->row();
		$PV 	= $row3->PV;

		// get product
		$sql 	= "SELECT sd.*, sd.ProductQty-sd.Pending AS totaldo, 
					COALESCE(pa.AtributeValue,'STD') AS ProductType FROM tb_so_detail sd
					LEFT JOIN tb_product_atribute_detail pa ON sd.ProductID=pa.ProductID AND pa.ProductAtributeID=16
					WHERE sd.SOID =".$SOID;

		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
				'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductType' => ($row->ProductType == "CSTM") ? "custom" : "standard",
				'ProductWeight' => $row->ProductWeight,
				'PriceID' => $row->PriceID,
				'PriceName' => $row->PriceName,
				'PT1Percent' => $row->PT1Percent,
				'PT1Price' => $row->PT1Price,
				'PT2Percent' => $row->PT2Percent,
				'PT2Price' => $row->PT2Price,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal,
				'totaldo' => $row->totaldo,
				'PVSO' => $row->PVSO,
				'PVSOTotal' => $row->PVSOTotal,
				'PV' => $PV,
				'SEPVMultiplier' => $SEPVMp,
			);
		};
		// print_r($show['detail']);

		// get shipping
		$shipping 	= explode(";", $rowso->ShipAddress);
		$addressid 	= 0;
		$show['shipping'][$addressid] = array(
			'addressid' => $addressid,
			'DetailType' => $shipping[1],
			'DetailValue' => $shipping[2],
			'ExpeditionID' => $rowso->ExpeditionID,
			'FCPrice' => $rowso->ExpeditionPrice,
			'FCWeight' => $rowso->ExpeditionWeight
        ); 
		$sql 	= "SELECT vca.*, ac.FCPrice, ac.FCWeight, vex.ExpeditionID
					FROM vw_contact_address vca
					LEFT JOIN tb_customer_main cm ON (vca.ContactID = cm.ContactID)
					LEFT JOIN vw_city ac ON (vca.CityID = ac.CityID)
					LEFT JOIN vw_expedition1 vex ON (ac.ExpeditionID = vex.ExpeditionID)
					WHERE cm.CustomerID=".$CustomerID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
    		$addressid += 1;
    		$StateName 		= (is_null($row->StateName))? "" : ", ".$row->StateName;
        	$ProvinceName 	= (is_null($row->ProvinceName))? "" : ", ".$row->ProvinceName;
        	$CityName 		= (is_null($row->CityName))? "" : ", ".$row->CityName;
        	$DistrictsName 	= (is_null($row->DistrictsName))? "" : ", ".$row->DistrictsName;
        	$PosName 		= (is_null($row->PosName))? "" : ", ".$row->PosName;
		  	$show['shipping'][$addressid] = array(
		      'addressid' => $addressid,
		      'DetailType' => $row->DetailType,
		      'DetailValue' => $row->DetailValue." ".$DistrictsName.$CityName.$ProvinceName.$StateName.$PosName,
		      'ExpeditionID' => $row->ExpeditionID,
		      'FCPrice' => $row->FCPrice,
		      'FCWeight' => $row->FCWeight
		  ); 
		};

		// get sales and price category
		$show['sales'][] = array(
		  'SalesID' => $rowso->SalesID,
		  'SalesName' => $rowso->salesname
        );
		$sql2 = "SELECT cd.*, vem.SalesID, vem.Company2 FROM tb_customer_detail cd ";
		$sql2 .= "LEFT JOIN vw_sales_executive2 vem ON cd.DetailValue = vem.SalesID ";
		$sql2 .= "WHERE cd.DetailType in ('sales','price') ";
		$sql2 .= "and cd.CustomerID = '".$CustomerID."' ";
		$show['price'][] = 0;
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			if ($row2->DetailType == 'sales') {
				$show['sales'][] = array(
				'SalesID' => $row2->SalesID,
				'SalesName' => $row2->Company2
		      );
			} elseif ($row2->DetailType == 'price') {
				$show['price'][] = $row2->DetailValue;
			}
		};

		$sql2 = "SELECT * FROM tb_price_category_main WHERE PricecategoryID  in (". implode(',', array_map('intval', $show['price'])).")";
		$query2 = $this->db->query($sql2);
		$show['pricename'] = array();
		foreach ($query2->result() as $row2) {
			$show['pricecategory'][] = $row2->PricecategoryID;
			$show['pricename'][] = array(
			  'Type' => "Price Category",
			  'PricecategoryID' => $row2->PricecategoryID,
			  'PricecategoryName' => $row2->PricecategoryName
	        );
		};

		// get pricelist
		if (array_key_exists("price", $show)) {
			$sql2 = "SELECT pcd.*, plm.*
					FROM tb_price_category_detail pcd
					LEFT JOIN tb_price_list_main plm ON (pcd.PricelistID = plm.PricelistID) 
					WHERE 
					plm.PricelistID in (select PricelistID from vw_price_list_active) and 
					pcd.PricecategoryID in (". implode(',', array_map('intval', $show['price'])) .") 
					AND plm.DateEnd >= CURDATE() ";
			$query2 = $this->db->query($sql2);
			$result = $query2->result();
			if (!empty($result)) {
				foreach ($query2->result() as $row2) {
					$show['pricelist'][] = $row2->PricelistID;
					$show['pricename'][] = array(
					    'Type' => "PriceList",
					    'PricecategoryID' => $row2->PricelistID,
					    'PricecategoryName' => $row2->PricelistName
					);
				};
			} else {
				$show['pricelist'][] = "0";
			}

			$sql2 = "SELECT PromoVolID, PromoVolName FROM tb_price_promo_vol_main
					WHERE  
					PromoVolID in (select PromoVolID from vw_price_promo_vol_active) and 
					PricecategoryID IN (". implode(',', array_map('intval', $show['price'])) .") 
					AND DateEnd >= CURDATE()";
			$query2 = $this->db->query($sql2);
			$result = $query2->result();
			if (!empty($result)) {
				foreach ($query2->result() as $row2) {
					$show['promovolume'][] = $row2->PromoVolID;
					$show['pricename'][] = array(
					    'Type' => "PromoVolume",
					    'PricecategoryID' => $row2->PromoVolID,
					    'PricecategoryName' => $row2->PromoVolName
					);
				};
			} else {
				$show['promovolume'][] = "0";
			}
		}

		// get invoice late
		$inv_late = $this->get_inv_late($CustomerID);
		if (count($inv_late) > 0) {
			$show['inv_late'] = $inv_late;
		} else {
			$show['inv_late']['false'] = "";
		}
		// print_r($show['inv_late']);

		$show['inv_late2'] = json_encode($show['inv_late']);
		$show['so2']		= json_encode($show['so']);
		$show['detail2'] 	= json_encode($show['detail']);
		$show['shipping2'] 	= json_encode($show['shipping']);
		$show['sales2'] 	= json_encode($show['sales']);
		$show['price2'] 	= json_encode($show['price']);
		$show['pricecategory2'] = json_encode($show['pricecategory']);
		$show['pricelist2'] = json_encode($show['pricelist']);
		$show['pricename2'] = json_encode($show['pricename']);
		$show['promovolume2'] = json_encode($show['promovolume']);

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_offline_edit_act()
	{
		$this->db->trans_start();
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);

		$SOID 		= $this->input->post('soid');
		$CustomerID = $this->input->post('CustomerID');
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
		$pono 	= $this->input->post('pono');
		$INVMP 	= $this->input->post('invmp');
		$MPID 	= $this->input->post('mp');
		$ResiNo 	= $this->input->post('resi');
		$ExpeditionID 	= $this->input->post('ekspedisi');
		$invcategory = $this->input->post('invcategory');
		$label = $this->input->post('label');
		$sodate 	= $this->input->post('sodate');
		$shop 	= $this->input->post('shop');
		$shipdate 	= $this->input->post('shipdate');
		$paymentmethod 	= $this->input->post('paymentmethod');
		$sopaymentterm 	= $this->input->post('sopaymentterm');
		$sotype = $this->input->post('sotype');
		$minimumdp = $this->input->post('minimumdp');
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
		$totaldo 		= $this->input->post('totaldo');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$PricelistID 	= $this->input->post('PricelistID');
		$PricelistName 	= $this->input->post('PricelistName');
		$PricePercent 	= $this->input->post('PricePercent');
		$PT1Percent 	= $this->input->post('PT1Percent');
		$PT2Percent 	= $this->input->post('PT2Percent');
		$PT1Price 	= $this->input->post('PT1Price');
		$PT2Price 	= $this->input->post('PT2Price');
		$PriceAmount 	= $this->input->post('PriceAmount');
		$ProductWeight 	= $this->input->post('ProductWeight');
		$FreightCharge 	= $this->input->post('FreightCharge');
		$PVSO		= $this->input->post('PV2');
		$PVSOTotal		= $this->input->post('PVTotal');
		$linetotal 		= $this->input->post('linetotal');

		$fcmethod 		= $this->input->post('fcmethod');
		$fcsuggestion 	= $this->input->post('fcsuggestion');
		$fcamount 		= $this->input->post('fcamount');
		$sototalbefore 	= $this->input->post('sototalbefore');
		$taxrate 		= $this->input->post('taxrate');
		$taxamount 		= $this->input->post('taxamount');
		$sototal 		= $this->input->post('sototal');
		$sototalOld 	= $this->input->post('sototalOld');
		$do = 0;

		$DueDate1 = ($this->input->post('DueDate1')) ? $this->input->post('DueDate1') : 0;
		$DueDate2 = ($this->input->post('DueDate2')) ? $this->input->post('DueDate2') : 0;
		$DueDateNote = $this->input->post('DueDateNote');

		// cek jika ada perubahan
   		$errorCount = 0;
   		$sql 	= "SELECT * from tb_so_main where SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();

		if ( 
			($rowso->PaymentDeposit != $minimumdp && $rowso->SOConfirm1 == 1) || 
			($rowso->PaymentDeposit != $minimumdp && $rowso->SOConfirm1 == 0) || 
			($rowso->PaymentDeposit == $minimumdp && $rowso->SOConfirm1 == 0) 
		) {
			// cek dp
			$sql 	= "select SODepositStandard, SODepositCustom, SODepositProject from tb_site_config where id=1";
			$getRow = $this->db->query($sql);
			$row 	= $getRow->row();
			$SODepositStandard = $row->SODepositStandard;
			$SODepositCustom = $row->SODepositCustom;
			$SODepositProject = $row->SODepositProject;
			if ($rowso->SOType == "standard" && $rowso->PaymentDeposit < $SODepositStandard) {
	   			$errorCount += 1;
			} 
			if ($rowso->SOType == "custom" && $rowso->PaymentDeposit < $SODepositCustom) {
	   			$errorCount += 1;
			}
			if ($rowso->SOType == "project" && $rowso->PaymentDeposit < $SODepositProject) {
	   			$errorCount += 1;
			}
		}

		if ($rowso->INVCategory != $invcategory) {
   			$errorCount += 1;
		}
		if ($rowso->PaymentWay != $paymentmethod) {
   			$errorCount += 1;
		}
		if ($rowso->PaymentTerm != $sopaymentterm) {
   			$errorCount += 1;
		}
		// if ($rowso->SOTotal != $sototal) {
   			// $errorCount += 1;
		// }
		if ($rowso->SOConfirm1 != 1) {
   			$errorCount += 1;
		}
		$sql 	= "SELECT sd.* FROM tb_so_detail sd WHERE sd.SOID =".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$detail[$row->ProductID] = array(
		  		'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductWeight' => $row->ProductWeight,
				'PriceID' => $row->PriceID,
				'PriceName' => $row->PriceName,
				'PT1Percent' => $row->PT1Percent,
				'PT1Price' => $row->PT1Price,
				'PT2Percent' => $row->PT2Percent,
				'PT2Price' => $row->PT2Price,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal,
			);
		};
		// -----------------------------------------------------------------------

		$datamain = array(
			'SalesID' => $sales,
			'BillingAddress' => str_replace(array('\n', '\r'), ' ', $billing),
			'ShipAddress' => str_replace(array('\n', '\r'), ' ', $shipping),
			'PaymentWay' => $paymentmethod,
			'PaymentTerm' => $sopaymentterm,
			'SOType' => $sotype,
			'SODate' => $sodate,
			'ShopID' => $shop,
			'SOShipDate' => $shipdate,
			'INVCategory' => $invcategory,
			'PaymentDeposit' => $minimumdp,
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
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'ModifiedBy' => $this->session->userdata('UserAccountID')
		);
		if ($this->input->post('socategory')) {
			$datamain['SOCategory'] = $this->input->post('socategory');
		}
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main', $datamain);
		$this->last_query .= "//".$this->db->last_query();

		// ----------------------------------------------------------------------------- 
		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;

		if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
			$filesnames = $_FILES['label']['name'];
            $target_dir = "assets/PDFLabel/";
            $target_file = $target_dir . $filesnames;
            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
				$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
				$data_file['File'] = $label;
            }
        }
		$datamain2 = array(
			'SOShipDateNote' => $DueDateNote,
			'SOShipDate1Need' => $DueDate1,
			'SOShipDate2Need' => $DueDate2,
			'PONumber' => $pono,
			'INVMP' => $INVMP,
			'MPID' => $MPID,
			'ResiNo' => $ResiNo,
			'ExpeditionID' => $ExpeditionID,
			'label' => $filesnames,

		);
		if ($DueDate1 == 0 and $DueDate2 == 0) {
			$datamain2['SOShipDateFinal'] = $shipdate;
			$datamain2['SOShipDate1'] = null;
			$datamain2['SOShipDate2'] = null;
			$datamain2['SOShipDate1Created'] = null;
			$datamain2['SOShipDate2Created'] = null;
			$datamain2['SOShipDate1By'] = null;
			$datamain2['SOShipDate2By'] = null;
		} else {
			$datamain2['SOShipDateFinal'] = null;
		}

		$this->db->where('SOID', $SOID);
		$q = $this->db->get('tb_so_main2');
		if ( $q->num_rows() > 0 )  {
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main2',$datamain2);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$this->db->set('SOID', $SOID);
			$this->db->insert('tb_so_main2',$datamain2);
			$this->last_query .= "//".$this->db->last_query();
		}
		// --------------------------------------------------------------------------------

		$this->db->where('SOID', $SOID);
		$this->db->delete('tb_so_detail');
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
				'PVSO' => $PVSO[$i],
				'PVSOTotal' => $PVSOTotal[$i],
				'PriceTotal' => $linetotal[$i]
			);
			$this->db->insert('tb_so_detail', $datadetail);
			$this->last_query .= "//".$this->db->last_query();

			// $this->db->where('SOID', $SOID);
			// $this->db->where('ProductID', $ProductID[$i]);
			// $this->db->update('tb_so_detail', $datadetail);
			// $this->last_query .= "//".$this->db->last_query();
			$do += $totaldo[$i];

			// cek jika ada perubahan
			// print_r( $detail[$ProductID[$i]] ) ;
			if (isset($detail[$ProductID[$i]])) {
				if ($PriceAmount[$i] != $detail[$ProductID[$i]]['PriceAmount']) {
		   			$errorCount += 1;
				}
				if ($linetotal[$i] != $detail[$ProductID[$i]]['PriceTotal']) {
		   			$errorCount += 1;
				}
			}
			// -------------------------------------------
   		};
   		// echo $do;

   		if ($errorCount > 0) {
	   		if ($do == 0) {
	   			if ($rowso->SOStatus == 1) {
		   			$sql 		= "select SOCategory from tb_so_main where SOID=".$SOID;
					$getDetail 	= $this->db->query($sql);
					$row 		= $getDetail->row();
					$socategory = $row->SOCategory;
					// echo $sototal.'-'.$sototalOld;
		   			$this->sales_order_approval_submission($SOID, $socategory, $invcategory, $paymentterm, $sopaymentterm, "edit", $creditavailable, $sototal, $paymentmethod, $CustomerID);
		   		}
	   		}
   		} else {
			$this->db->set('SOConfirm1', 1);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main');
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select ApprovalID from tb_approval_so where isComplete=0 and SOID=".$SOID." LIMIT 1";
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (!empty($row)) {
				$ApprovalID = $row->ApprovalID;
				$data_approval = array(
					'SOID' => $SOID,
					'Title' => "SO ".$SOID,
					'Actor1' => null,
					'Actor1ID' => null,
					'Actor2' => null,
					'Actor2ID' => null,
					'Actor3' => null,
					'Actor3ID' => null,
			        'Note' => $note,
					'ApprovalQuery' => "update tb_so_main set SOConfirm1='1' where SOID='".$SOID."'",
					'isComplete' => 1,
					'Status' => "Approved"
				);
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			} 
   		}
   		// echo $this->last_query;
   		$this->SOShipDate_history($SOID, $shipdate, 'formSO');
		$this->update_SOConfirm2($SOID, 'formSO');
		$this->update_pending_so($SOID);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function sales_order_list()
	{
		$this->load->model('model_report');
		$MenuList = $this->session->userdata('MenuList');
		$SalesID = array( $this->session->userdata('SalesID') );
		$SalesID = $this->model_report->get_sales_child($SalesID);
		$sql = " SELECT sl.*, tsm2.INVMP, coalesce(t1.countSO,0) as countSO FROM vw_so_list5 sl
				LEFT JOIN (
					SELECT im.SOID, COUNT(im.SOID) AS countSO FROM tb_invoice_main im GROUP BY im.SOID
				) t1 ON sl.SOID=t1.SOID 
				LEFT JOIN tb_so_main2 tsm2 ON tsm2.SOID=sl.SOID ";
		if (in_array("sales_order_view_all", $MenuList)){
			$sql .= "WHERE SalesID <> 0 ";
		}
		else
		{
			$sql .= "WHERE ( SalesID in (" . implode(',', array_map('intval', $SalesID)) . ") ) ";
		}
		if (isset($_REQUEST['status']) && $_REQUEST['status'] == 2) {
			$sql .= "AND sl.SOConfirm1!=".$_REQUEST['status']." ";
		} elseif (isset($_REQUEST['status']) && $_REQUEST['status'] != 2) { 
			$sql .= "AND sl.SOConfirm1=".$_REQUEST['status']." ";
		} else { 
			// $sql .= "where sl.SOID in (51414,51413,51412,51411,51410,51409,51408,51407,51406,51405,51404,51403,51402,51401,51400,51399,51398,51397,51396,51395,51394,51393) ";
			$sql .= "ORDER BY sl.SOID DESC LIMIT ".$this->limit_result." ";
		}

		if (isset($_REQUEST['type']) && $_REQUEST['type'] != 'all') {
			$sql .= "AND sl.SOType='".$_REQUEST['type']."' ";
		} 

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "AND sl.SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "AND (";
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
				'INVMP' => $row->INVMP,
				'countSO' => $row->countSO,
			);
			$show['PermitNote'][$row->SOID] = $row->PermitNote;
			// $show['PermitNote2'] = json_encode($show['PermitNote']);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_cancel()
	{
		$this->db->trans_start();

		$note = $this->input->post('note');
		$SOID = $this->input->post('soid'); 

		$sql 	= "SELECT TotalPayment FROM vw_so_balance WHERE SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();

		$sql2 	= "SELECT COALESCE(totaldo,0) as totaldo FROM vw_so_do2 WHERE SOID = ".$SOID;
		$getrow2= $this->db->query($sql2);
		$row2 	= $getrow2->row();

		if (!empty($row2)) {
			$result = $row2->totaldo;
		} else {
			$result = 0;
		}

		if ($row->TotalPayment == 0 and $result == 0) {
			$data = array(
				'SOStatus' => 0,
				'SOConfirm1' => 0,
				'SOConfirm2' => 0,
				'CancelNote' => $note,
				'CancelDate' => date('Y-m-d H:i:s'),
				'CancelBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main', $data);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('SOID', $SOID);
			$this->db->delete('tb_customer_deposit_allocation');
			$this->last_query .= "//".$this->db->last_query();

			// hapus approval
			$sql 	= "select ApprovalID from tb_approval_so where isComplete=0 and SOID=".$SOID." LIMIT 1";
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (!empty($row)) {
				$ApprovalID = $row->ApprovalID;
			} else {
				$ApprovalID = 0;
			}
			$data_approval = array(
				'SOID' => $SOID,
				'isComplete' => 1,
				'Status' => "SO Cancel"
			);
			if ($ApprovalID != 0 ) {
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function sales_order_permit_note()
	{
		$this->db->trans_start();

		$note = $this->input->post('note');
		$SOID = $this->input->post('soid'); 

		$data = array(
			'PermitNote' => $note
		);
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function get_sales_order_permit_note()
	{
		$SOID = $this->input->get_post('soid');
		$sql  = "select PermitNote from tb_so_main where SOID=".$SOID;
		$query= $this->db->query($sql);
		$row  = $query->row();
		$show['PermitNote'] = $row->PermitNote;

		if (!empty($show['PermitNote'])){
			$sql  = "SELECT aso.ApprovalID, aso.SOID, aso.Actor1, aso.Actor2, aso.Actor3,
				em1.fullname as fullname1, em2.fullname as fullname2, em3.fullname as fullname3
				FROM tb_approval_so aso
				LEFT JOIN vw_user_account em1 ON (em1.UserAccountID=aso.Actor1ID)
				LEFT JOIN vw_user_account em2 ON (em2.UserAccountID=aso.Actor2ID)
				LEFT JOIN vw_user_account em3 ON (em3.UserAccountID=aso.Actor3ID)
				WHERE aso.SOID=".$SOID." ORDER BY aso.ApprovalID DESC LIMIT 1";

			$query= $this->db->query($sql);
			$row  = $query->row();
			// echo $sql;
			$show['approval_status'] = $row->fullname1.": ".$row->Actor1." || ".$row->fullname2.": ".$row->Actor2." || ".$row->fullname3.": ".$row->Actor3;
		}
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_tax_note()
	{
		$this->db->trans_start();

		$SOID = $this->input->post('soid');
		$name = $this->input->post('name');
		$npwp = $this->input->post('npwp');
		$note = $this->input->post('note');

		$data = array(
			'TaxAddress' => $name.";Tax Address;".$note,
			'NPWP' => $npwp
		);
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function get_sales_order_tax_note()
	{
		$SOID = $this->input->get_post('soid');
		$sql  = "select NPWP, BillingAddress, TaxAddress from tb_so_main where SOID=".$SOID;
		$query= $this->db->query($sql);
		$row  = $query->row();
		$show['NPWP'] = $row->NPWP;
		$show['BillingAddress'] = explode(";", $row->BillingAddress);
		$show['TaxAddress'] = explode(";", $row->TaxAddress);
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_print()
	{
		$show   = array();
		$SOID 	= $this->input->get_post('so');
		$sql 	= "SELECT sm.*, vs.Company, vem1.Company2 as secname, vem2.Company2 as salesname, sc.CategoryName,
					vsb.DPMinimumPercent, vsb.DPMinimumAmount, vsb.TotalDeposit, vsb.TotalPayment, vem3.fullname as admin, 
					sm2.ResiNo
					FROM tb_so_main sm 
					LEFT JOIN tb_so_main2 sm2 ON (sm.SOID = sm2.SOID)
					LEFT JOIN tb_customer_main cm ON (sm.CustomerID = cm.CustomerID)
					LEFT JOIN tb_contact vs ON (cm.ContactID = vs.ContactID)
					LEFT JOIN vw_sales_executive2 vem1 ON (sm.SECID = vem1.SalesID)
					LEFT JOIN vw_sales_executive2 vem2 ON (sm.SalesID = vem2.SalesID)
					LEFT JOIN vw_user_account vem3 ON (sm.SOBy = vem3.UserAccountID)
					LEFT JOIN tb_so_category sc ON (sm.SOCategory = sc.CategoryID)
					LEFT JOIN vw_so_balance vsb ON (sm.SOID = vsb.SOID) where sm.SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();
		$show['so'] = (array) $rowso;

		$sql 	= "SELECT * from tb_so_detail where SOID = ".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
				'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
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
				'PVSO' => $row->PVSO
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function get_so_detail()
	{
		$show   = array();
		$SOID 	= $this->input->get_post('id');
		$sql 	= "SELECT sm.SOID, sm.PaymentDeposit, sb.TotalDeposit, sb.TotalPayment, sb.SOTotal, sm.SOShipDate, SONote FROM tb_so_main sm
					LEFT JOIN vw_so_balance sb ON (sm.SOID=sb.SOID) 
					where sm.SOID = ".$SOID;
		$getrow	= $this->db->query($sql);
		$rowso 	= $getrow->row();
		$percentResult = $this->get_percent2($rowso->PaymentDeposit, $rowso->SOTotal);
		if ($percentResult <= $rowso->TotalDeposit+$rowso->TotalPayment) {
			
		} else {
			$show['result'] = "Deposit kurang dari ".$percentResult." (".$rowso->PaymentDeposit." %)";
		}

		$show['SOShipDate'] = $rowso->SOShipDate;
		$show['SONote'] = $rowso->SONote;
		$sql = "SELECT sd.*, plp.ProductCode, plp.stock FROM tb_so_detail sd
				LEFT JOIN vw_product_list_popup2 plp ON (sd.ProductID=plp.ProductID) 
				where SOID = ".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['detail'][] = array(
				'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'ProductQty' => $row->ProductQty,
				'stock' => $row->stock,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductWeight' => $row->ProductWeight,
				'PriceID' => $row->PriceID,
				'PT1Percent' => $row->PT1Percent,
				'PT1Price' => $row->PT1Price,
				'PT2Percent' => $row->PT2Percent,
				'PT2Price' => $row->PT2Price,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal
			);
		};
	    echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function sales_order_approval_submission($SOID, $socategory, $invcategory, $paymentterm, $sopaymentterm, $type, $creditavailable, $sototal, $paymentmethod, $CustomerID)
	{
		$this->db->trans_start();

		$countError = 0;
		$note = "";
		$datamain = array (
			'SOConfirm1' => 0,
			'SOConfirm2' => 0,
		);
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main', $datamain);
		$this->last_query .= "//".$this->db->last_query();

		$inv_late = $this->get_inv_late($CustomerID);
		if (count($inv_late) > 0) {
			$countError += 1;
			$note .= "There is ".count($inv_late)." Invoice late.//";
		}
		if ($socategory!=1 and $socategory!=7) {
			$countError += 1;
			$note .= "'SO Category' not Sales. //";
		}
		if ($invcategory!=1) {
			$countError += 1;
			$note .= "SO Pembayaran by Persentase. //";
		}

		// cek dp
		$sql 	= "select SODepositStandard, SODepositCustom, SODepositProject from tb_site_config where id=1";
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$SODepositStandard = $row->SODepositStandard;
		$SODepositCustom = $row->SODepositCustom;
		$SODepositProject = $row->SODepositProject;

		$sql 	= "select SOType, PaymentDeposit from tb_so_main where SOID=".$SOID;
		$getRow = $this->db->query($sql);
		$row 	= $getRow->row();
		$SOType = $row->SOType;
		$PaymentDeposit = $row->PaymentDeposit;

		if ($SOType == "standard" && $PaymentDeposit < $SODepositStandard) {
			$countError += 1;
			$note .= "DP minimum lebih kecil dari ketentuan. //";
		} 
		if ($SOType == "custom" && $PaymentDeposit < $SODepositCustom) {
			$countError += 1;
			$note .= "DP minimum lebih kecil dari ketentuan. //";
		}
		if ($SOType == "project" && $PaymentDeposit < $SODepositProject) {
			$countError += 1;
			$note .= "DP minimum lebih kecil dari ketentuan. //";
		}
		// ================================

		if ($sopaymentterm!="0") {
			if ($sopaymentterm>$paymentterm) {
				$countError += 1;
				$note .= "'Payment Term SO' exceed 'Payment Term Customer' = ".$sopaymentterm." / ".$paymentterm.". //";
			}
			if ($sototal>$creditavailable) {
				$countError += 1;
				$note .= "'SO Total Payment Due' exceed 'Credit Limit Customer' = ".number_format($sototal)." / ".number_format($creditavailable).". //";
			}
		}

		$noteP = "";
		$sql 	= "SELECT * from tb_so_detail where SOID = ".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$NormalPrice = $row->PT1Price;
			if ($paymentmethod == "CBD") { $NormalPrice = $row->PT2Price; }

			if ($row->PriceAmount < $NormalPrice) {
				$countError += 1;
				$noteP .= $row->ProductID.", ";
			}
		};
		if ($noteP != "") {
			$note .= "Product Price (".substr($noteP, 0, -2).") is not the same as the previous price. //";
		}

		$sql 	= "select ApprovalID from tb_approval_so where isComplete=0 and SOID=".$SOID." LIMIT 1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$ApprovalID = $row->ApprovalID;
		} else {
			$ApprovalID = 0;
		}

   		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='approve_so' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		if ($countError > 0 && $Actor3 != 0) {
			$data_approval = array(
				'SOID' => $SOID,
				'Title' => "SO".$SOID,
				'Actor1' => null,
				'Actor1ID' => null,
				'Actor2' => null,
				'Actor2ID' => null,
				'Actor3' => null,
				'Actor3ID' => null,
				'Note' => $note,
				'ApprovalQuery' => "update tb_so_main set SOConfirm1='1' where SOID='".$SOID."'",
				'isComplete' => 0,
				'Status' => "OnProgress"
			);
			if ($ApprovalID != 0) {
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			} else {
				$this->db->insert('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
		} else {
			$datamain = array(
				'SOConfirm1' => 1
			);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$data_approval = array(
				'SOID' => $SOID,
				'Title' => "Approval untuk SO ".$SOID,
				'Actor1' => null,
				'Actor1ID' => null,
				'Actor2' => null,
				'Actor2ID' => null,
				'Actor3' => null,
				'Actor3ID' => null,
				'Note' => $note,
				'ApprovalQuery' => "update tb_so_main set SOConfirm1='1' where SOID='".$SOID."'",
				'isComplete' => 1,
				'Status' => "Approved"
			);
			if ($ApprovalID != 0 ) {
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			} else {
				$this->db->insert('tb_approval_so', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
		}
		
		$this->update_SOConfirm2($SOID, 'approval');
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function update_SOConfirm2($SOID, $source)
	{
		$sql 		= "select * from vw_so_balance where SOID=".$SOID;
		$getRow 	= $this->db->query($sql);
		$row 		= $getRow->row();
		$SOType 	= $row->SOType;
		$SODate 	= $row->SODate;
		$SOShipDate = $row->SOShipDate;
		$SOConfirm1 = $row->SOConfirm1;
		$SOConfirm2 = $row->SOConfirm2;
		$SOTotal 	= $row->SOTotal;
		$DPMinimumAmount= $row->DPMinimumAmount;
		$TotalDeposit 	= $row->TotalDeposit;
		$TotalPayment 	= $row->TotalPayment;
		$TotalOutstanding 	= $row->TotalOutstanding;
			
		// DP------------------------------
		$sql 		= "select SODPDeviation from tb_site_config where id=1";
		$getRow 	= $this->db->query($sql);
		$rowDP 		= $getRow->row();
		$SODPDeviation = $rowDP->SODPDeviation;
		if (($TotalDeposit+$TotalPayment) >= $DPMinimumAmount ) {
			$DPStatus = 1;
		} else {
			$TotalDP = ($TotalDeposit+$TotalPayment);
			$deviation = $DPMinimumAmount - $TotalDP;
			if ($deviation <= ($SODPDeviation*($SOTotal/100)) ) {
				$DPStatus = 1;
			} else {
				$DPStatus = 2;
			}
		}

		if ($SOConfirm1 == 1 && $SOConfirm2 == 0 && $DPStatus == 1 ) {
			$sql 		= "SELECT t2.DepositID, MAX(t2.TransferDate) as TransferDate
							FROM (
							SELECT cd.AllocationID, cd.DepositID, td.TransferDate
							FROM tb_customer_deposit_allocation cd
							LEFT JOIN vw_deposit_transfer_date td ON cd.DepositID=td.DepositID
							WHERE cd.SOID=".$SOID."
							) t2";
			$getRow 	= $this->db->query($sql);
			$row2 		= $getRow->row();
			$TransferDate = $row2->TransferDate;
			
			$dateResult = $SOShipDate;
			// if ($SOType == 'custom') {
			if ($DPMinimumAmount > 0 and $source != 'approval') {
			// if ($source != 'approval') {
				// update SO ShipDate
				$date1 = new DateTime($SODate);
				$date2 = new DateTime($SOShipDate);
				$interval = $date1->diff($date2);
				if ($TransferDate > $SODate) {
					$date = date("Y-m-d H:i:s", strtotime($TransferDate));
				} else {
					$date = date("Y-m-d H:i:s", strtotime($SODate));
				}
				$dateResult = date("Y-m-d", strtotime("+".$interval->days." days", strtotime($date)) );
				$this->SOShipDate_history($SOID, $dateResult, $source);
				$this->db->set('SOShipDate',$dateResult);
			}

			$this->db->set('SOConfirm2',1);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main');
			$this->last_query .= "//".$this->db->last_query();

		}
		$this->log_user->log_query($this->last_query);
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
	function complete_deposit_under()
	{
		$this->db->trans_start();
		$SOID = $this->input->post('SOID');
		$show   = array();

		$sql 	= "select SOID, CustomerID, SOTotal, TotalDeposit from vw_so_list5 where SOID=".$SOID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$CustomerID = $row->CustomerID;
		$SOID = $row->SOID;
		$TotalOutstanding = $row->SOTotal - $row->TotalDeposit;
		$show['SOID'] = $SOID;
		$show['CustomerID'] = $CustomerID;
		$show['TotalOutstanding'] = $TotalOutstanding;

		$sql = "select DepositID, CustomerID, TotalBalance from vw_deposit_balance where TotalBalance>0 and CustomerID=".$CustomerID;
		$getrow = $this->db->query($sql);
		$countDepositFree = $getrow->num_rows();

		if ($TotalOutstanding<100 && $countDepositFree<1) {
			$show['result'] = "succes";

			$sql = "SELECT BankTransactionID, BankTransactionDate
						FROM tb_bank_transaction order by BankTransactionDate desc, BankTransactionID desc limit 1";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$BankTransactionID = $row->BankTransactionID+1;
			$BankTransactionDate = $row->BankTransactionDate;
			$show['BankTransactionID'] = $BankTransactionID;
			$show['BankTransactionDate'] = $BankTransactionDate;
			
			$this->load->model('model_finance');
			$this->model_finance->bank_transaction_add_under2($SOID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
			$this->model_finance->confirmation_deposit_allocation_act_under($SOID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
		} else {
			$show['result'] = "fail";
		}
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function get_inv_late($CustomerID)
	{
		$sql 		= "select INVLatePayment from tb_site_config where id=1";
		$getINVLate = $this->db->query($sql);
		$row 		= $getINVLate->row();
		$INVLate 	= $row->INVLatePayment;

		$inv_late   = array();
		$sql2 = "select * from vw_invoice_late where CustomerID=".$CustomerID." and date_diff>=".$INVLate;
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			$inv_late[] = array(
				'INVID' => $row2->INVID,
				'date_diff' => $row2->date_diff,
				'TotalOutstanding' => number_format($row2->TotalOutstanding,2)
			);
		};
		return $inv_late;
	}
	function get_so_outstanding($CustomerID)
	{
		$solate = array();
		$sql 	= "SELECT * FROM vw_so_balance vsb 
					WHERE CustomerID=".$CustomerID." AND TotalOutstanding>0 AND TotalOutstanding>100 
					AND SOConfirm1=1 AND PaymentWay='TOP' AND vsb.SOID NOT IN (
						SELECT sm.SOID FROM tb_do_main dm 
						LEFT JOIN tb_so_main sm ON dm.DOType='SO' AND dm.DOReff=sm.SOID
						LEFT JOIN vw_so_do2 sd ON sm.SOID=sd.SOID
						WHERE dm.DOStatus=1 AND sm.SOCategory NOT in (1,2,7) AND sd.Pending=0 AND sm.CustomerID=".$CustomerID."
					) 
					order by SOID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$SOTotal = number_format($row->SOTotal,2);
			$TotalDeposit = number_format($row->TotalDeposit,2);
			$TotalPayment = number_format($row->TotalPayment,2);
			$TotalOutstanding = number_format($row->TotalOutstanding,2);

			$TotalDepositPerc = $this->get_percent($row->SOTotal, $row->TotalDeposit);
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $row->TotalPayment);
			
			$solate[] = array(
				'SOID' => $row->SOID,
				'PaymentWay' => $row->PaymentWay,
				'SOTotal' => $SOTotal,
				'TotalDeposit' => $TotalDeposit,
				'TotalPayment' => $TotalPayment,
				'TotalDepositPerc' => $TotalDepositPerc,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'TotalOutstanding' => $TotalOutstanding
			);
		}
		return $solate;
	}
	function sales_order_goApproval()
	{
		$this->db->trans_start();
		$SOID 	= $this->input->post('SOID');
		$show   = array();

		$sql 	= "SELECT sd.SOID, SUM(sd.PriceTotal) AS PriceTotal, sm.SOTotalBefore
					FROM tb_so_detail sd 
					LEFT JOIN tb_so_main sm ON sm.SOID=sd.SOID
					WHERE sd.SOID = ".$SOID." 
					GROUP BY sd.SOID";
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$PriceTotal = $row->PriceTotal ;
		$SOTotalBefore = $row->SOTotalBefore ;
		if ($PriceTotal != $SOTotalBefore) {
			$show['note'] = "Harga Total Tidak Sesuai, silahkan di edit terlebih dahulu !";
			$show['result'] = "error";
		} else {
			$sql 	= "SELECT * from tb_so_main where SOID = ".$SOID;
			$getrow	= $this->db->query($sql);
			$rowso 	= $getrow->row();

			$CustomerID 	= $rowso->CustomerID ;
			$SOCategory 	= $rowso->SOCategory ;
			$INVCategory 	= $rowso->INVCategory ;
			$SOPaymentTerm 	= $rowso->PaymentTerm ;
			$SOTotal 	= $rowso->SOTotal ;
			$PaymentWay = $rowso->PaymentWay ;
			$SOStatus = $rowso->SOStatus ;

			if ($SOStatus == 2) {
				$sql 	= "SELECT * from tb_customer_main where CustomerID=".$CustomerID;
				$getrow	= $this->db->query($sql);
				$rowC 	= $getrow->row();
				$PaymentTerm = $rowC->PaymentTerm ;
				$CreditLimit = $rowC->CreditLimit ;

				$this->load->model('model_finance', 'finance');
				$debt = $this->finance->get_customer_debt2($CustomerID,$SOID);
				$creditavailable = $CreditLimit - $debt;

				$this->sales_order_approval_submission($SOID, $SOCategory, $INVCategory, $PaymentTerm, $SOPaymentTerm, "add", $creditavailable, $SOTotal, $PaymentWay, $CustomerID);

				$datamain = array(
					// 'SODate' => date('Y-m-d'),
					'SOStatus' => 1,
				);
				$this->db->where('SOID', $SOID);
				$this->db->update('tb_so_main', $datamain);
				$this->last_query .= "//".$this->db->last_query();
			}

			$sql 	= "SELECT Note from tb_approval_so where SOID=".$SOID." and isComplete=0 order by ApprovalID desc limit 1 ";
			$getrow	= $this->db->query($sql);
			$rowA 	= $getrow->row();
			if (!empty($rowA)) {
				$show['note'] = str_replace("// ", "<br>", $rowA->Note);
			} else {
				$show['note'] = "SO ".$SOID." sudah Confirm1";
			}
			$show['result'] = "success";
		}


		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();

		echo json_encode($show);
	}
	function get_so_latest($CustomerID)
	{
		$solate = array();
		$sql 	= "SELECT * FROM vw_so_balance vsb WHERE CustomerID=".$CustomerID." order by SOID desc limit 5";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$SOTotal = number_format($row->SOTotal,2); 
			$TotalBalance = $row->TotalPayment + $row->TotalDeposit + $row->ReturAmount;
			$TotalPayment = number_format($TotalBalance,2); 
			$TotalPaymentPerc = $this->get_percent($row->SOTotal, $TotalBalance);
			
			$solate[] = array(
		  		'SOID' => $row->SOID,
		  		'SODate' => $row->SODate,
				'PaymentWay' => $row->PaymentWay,
				'SOTotal' => $SOTotal,
				'TotalPayment' => $TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
			);
		}
		return $solate;
	}
	function check_so_confirm2($SOID)
	{
		$sql 	= "SELECT sm.SOConfirm1, sm.SOConfirm2, sm.SOStatus
					FROM tb_so_main sm WHERE sm.SOID = ".$SOID."";
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		if ($row->SOConfirm1 == 1 && $row->SOConfirm2 == 1 && $row->SOStatus == 1) {
			return true;
		} else {
			return false;
		}
	}
	// -------------------------------------------------------------
	function sales_order_due_date()
	{
		$sql = "SELECT sm2.*, sm.SOID, sm.SODate,  
				em1.fullname AS userDate1, em2.fullname AS userDate2, em3.fullname AS userDate3
				from tb_so_main2 sm2 
				left join tb_so_main sm on sm2.SOID=sm.SOID 
				LEFT JOIN vw_user_account em1 ON sm2.SOShipDate1By=em1.UserAccountID
				LEFT JOIN vw_user_account em2 ON sm2.SOShipDate2By=em2.UserAccountID
				LEFT JOIN vw_user_account em3 ON sm2.SOShipDate3By=em3.UserAccountID
				where sm.SOStatus<>0 and (sm2.SOShipDate1Need=1 or sm2.SOShipDate2Need=1 or sm2.SOShipDate3Need=1) ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && isset($_REQUEST['filterend']) &&  $_REQUEST['filterend'] != "" ) {
			$sql .= "and sm.SODate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "order by sm.SOID desc limit ".$this->limit_result." ";
			// $sql .= "order by sm.SOID asc";
		}

		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  		'SOID' => $row->SOID,
		  		'SODate' => $row->SODate,
				'SOShipDateFinal' => ($row->SOShipDateFinal != '0000-00-00') ? $row->SOShipDateFinal : '' ,
				'SOShipDate1Need' => $row->SOShipDate1Need,
				'SOShipDate2Need' => $row->SOShipDate2Need,
				'SOShipDate3Need' => $row->SOShipDate3Need,
				'SOShipDate1' => ($row->SOShipDate1 != '0000-00-00') ? $row->SOShipDate1 : '' ,
				'SOShipDate2' => ($row->SOShipDate2 != '0000-00-00') ? $row->SOShipDate2 : '' ,
				'SOShipDate3' => ($row->SOShipDate3 != '0000-00-00') ? $row->SOShipDate3 : '' ,
				'userDate1' => $row->userDate1,
				'userDate2' => $row->userDate2,
				'userDate3' => $row->userDate3,
			);
		};
	    return $show;
	}
	function sales_order_due_date_detail()
	{
		$show   = array();
		$SOID 	= $this->input->post('SOID');
		$sql 	= "SELECT sd.*, pa.Atribute, (pr.stockReady-pr.sopendingNonConfirm) AS stockReady 
					FROM tb_so_detail sd 
					LEFT JOIN vw_product_atribute pa ON sd.ProductID=pa.ProductID 
					LEFT JOIN vw_stock_product_ready pr ON sd.ProductID=pr.ProductID
					WHERE sd.SOID =".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		  		'SOID' => $row->SOID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'stockReady' => $row->stockReady,
				'Atribute' => $row->Atribute,
			);

			$sql 	= "SELECT rm.*, pr.ProductName, pa.Atribute, (pr.stockReady-pr.sopendingNonConfirm-pr.pendingRawConfirm-pr.pendingRawNonConfirm) AS stockReady 
						FROM tb_product_raw_material rm 
						LEFT JOIN vw_stock_product_ready2 pr ON pr.ProductID=rm.RawMaterialID
						LEFT JOIN vw_product_atribute pa ON pa.ProductID=rm.RawMaterialID 
						WHERE rm.ProductID =".$row->ProductID;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
			  	$show['detailraw'][$row->ProductID][] = array(
					'ProductID' => $row->ProductID,
					'RawMaterialID' => $row2->RawMaterialID,
					'ProductName' => $row2->ProductName,
					'stockReady' => $row2->stockReady,
					'Atribute' => $row2->Atribute,
				);
			};

		};

		$sql = "SELECT sm2.*, sm.SOID, 
				em1.fullname AS userDate1, em2.fullname AS userDate2, em3.fullname AS userDate3
				from tb_so_main2 sm2 
				left join tb_so_main sm on sm2.SOID=sm.SOID 
				LEFT JOIN vw_user_account em1 ON sm2.SOShipDate1By=em1.UserAccountID
				LEFT JOIN vw_user_account em2 ON sm2.SOShipDate2By=em2.UserAccountID
				LEFT JOIN vw_user_account em3 ON sm2.SOShipDate3By=em3.UserAccountID
				where sm.SOID=".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'] = array(
				'SOID' => $row->SOID,
				'EmployeeID' => $this->session->userdata('UserAccountID'),
				'SOShipDateFinal' => $row->SOShipDateFinal,
				'SOShipDate1Need' => $row->SOShipDate1Need,
				'SOShipDate2Need' => $row->SOShipDate2Need,
				'SOShipDate3Need' => $row->SOShipDate3Need,
				'SOShipDate1Created' => $row->SOShipDate1Created,
				'SOShipDate2Created' => $row->SOShipDate2Created,
				'SOShipDate3Created' => $row->SOShipDate3Created,
				'SOShipDateFinalCreated' => $row->SOShipDateFinalCreated,
				'SOShipDate1' => $row->SOShipDate1,
				'SOShipDate2' => $row->SOShipDate2,
				'SOShipDate3' => $row->SOShipDate3,
				'userDate1' => $row->userDate1,
				'userDate2' => $row->userDate2,
				'userDate3' => $row->userDate3,
			);
		};
	    return $show;
	}
	function sales_order_due_date_detail_act()
	{
		$this->db->trans_start();

		$SOID 	= $this->input->post('soid');
		$data 	= $this->input->post('data');
		$user 	= $this->input->post('user');
		$date 	= ($this->input->post('date') != '') ? $this->input->post('date') : NULL ;

		$datamain2 = array(
			$data => $date,
			$data.'Created' => date('Y-m-d H:i:s'),
			$data.'by' => $user,
		);
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main2',$datamain2);
		$this->last_query .= "//".$this->db->last_query();
		// echo $this->db->last_query();

		if ($data == 'SOShipDateFinal' and $date != '') {
			$this->db->set('SOShipDate', $date);
			$this->db->where('SOID', $SOID);
			$this->db->update('tb_so_main');
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	// -------------------------------------------------------------
	function sales_order_file_attach()
	{
		$show = array();
		$SOID = $this->input->get('soid');
		$show['SOID'] = $SOID;

		$sql5 = "SELECT * FROM tb_so_file WHERE SOID='".$SOID."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			$show['file'][] = array(
				'SOFileID' => $row5->SOFileID,
				'SOID' => $row5->SOID,
				'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};

		$sql2  = "select INVMP, Label from tb_so_main2 where SOID=".$SOID;
		$query2= $this->db->query($sql2);
		$row2  = $query2->row();
		$show['INVMP'] = $row2->INVMP;
		$show['Label'] = $row2->Label;

		return $show;
	}
	function sales_order_file_attach_act()
	{
		$this->db->trans_start();

		$SOID = $this->input->post('soid'); 
		$fileN = $this->input->post('fileN'); 
		$fileT = $this->input->post('fileT');
		$SOFileID = $this->input->post('SOFileID');
		$fileTold = $this->input->post('fileTold');
		$fileNold = $this->input->post('fileNold');
		$invmp = $this->input->post('invmp'); 
		$label = $this->input->post('label'); 

		$sql5 = "SELECT * FROM tb_so_file WHERE SOID='".$SOID."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			if (!in_array($row5->SOFileID, $SOFileID)) {
				$this->db->where('SOFileID', $row5->SOFileID);
				$this->db->delete('tb_so_file');
				$this->last_query .= "//".$this->db->last_query();

				$this->load->helper("file");
				$path = './tool/so/'.$SOID.'/'.$row5->FileName ;
				unlink($path); 
			}
		};


		$dataFile = array();
		for ($i=0; $i < count($fileT);$i++) { 
			if ($_FILES['fileN']['name'][$i] != "") {

				// create dir
				if (!is_dir('tool/so/'.$SOID)) {
					mkdir('tool/so/' . $SOID, 0777, TRUE);
				}
				// ------------------------------------------------

				$path_parts = pathinfo($_FILES["fileN"]["name"][$i]);
				$extension = $path_parts['extension'];
				$target_dir = "tool/so/".$SOID."/";
				// $target_name = $SOID.'-'.$fileT[$i];
				$target_name = $_FILES["fileN"]["name"][$i];
				// $target_file = $target_dir.$target_name.'.'.$extension;
				$target_file = $target_dir.$target_name;
				if (move_uploaded_file($_FILES["fileN"]["tmp_name"][$i], $target_file)) {
					$dataFile[] = array(
						'SOID' => $SOID,
						'FileType' => $fileT[$i],
						'FileName' => $target_name,
					);	
				}
			}
   		};
   		if (count($dataFile)>0) {
			$this->db->insert_batch('tb_so_file', $dataFile);
   		}

		$this->last_query .= "//".$this->db->last_query();
		set_time_limit(0);
		ini_set('upload_max_filesize', '1000M');
		ini_set('post_max_size', '1000M');
		ini_set('max_input_time', 4000); // Play with the values
		ini_set('max_execution_time', 4000); // Play with the values
		$limit = 1000000;

		if ($_FILES['label']['name'] != "" && $_FILES['label']['size'] < $limit) {  //copy file ke server
			$filesnames = $_FILES['label']['name'];
            $target_dir = "assets/PDFLabel/";
            $target_file = $target_dir . $filesnames;
            if (move_uploaded_file($_FILES["label"]["tmp_name"], $target_file)) {
				$label = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
				$data_file['File'] = $label;
            }
        }

   		$data = array(
			'INVMP' => $invmp,
			'Label' => $filesnames,
		);
		$this->db->where('SOID', $SOID);
		$this->db->update('tb_so_main2', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	// -------------------------------------------------------------
	function sales_order_upload_act($data_main, $data_detail, $inv_ol, $product_ol, $inv_product_duplicate)
	{
		$this->db->trans_start();
	    $customer 	= $this->input->post('customer');
		$contactid 	= $this->input->post('contactid');
	    $sales 		= $this->input->post('sales');
		$billing 	= $this->input->post('billing');
		$shop 		= $this->input->post('shop');
		$creditlimit 	= $this->input->post('creditlimit');
		$creditavailable= $this->input->post('creditavailable');
		$regionid 		= $this->input->post('regionid');
		$secid 			= $this->input->post('secid');
		$paymentterm 	= $this->input->post('paymentterm');
		$npwp 		= $this->input->post('npwp');
		$pricelist 	= $this->input->post('pricelist');
		$promovolume = $this->input->post('promovolume');
		$mplace = $this->input->post('mplace');
		$mpfee = $this->input->post('mpfee');

		$SOID_all = array();

		$sql 	= 'SELECT pm.ProductID FROM tb_product_main pm 
					WHERE pm.ProductID in ("'.implode('","', array_map('strval', $product_ol)).'")';
		$hasil2 = $this->db->query($sql); 
		if ( count($product_ol) != count($hasil2->result_array()) ) {
			$product_ol_ready = array();
			foreach ($hasil2->result_array() as $key => $value) {
				$product_ol_ready[] = $value['ProductID'];
			}
			$product_ol_miss = '"'.implode('","', array_map('strval', array_diff($product_ol, $product_ol_ready) )).'"';
			$newdata['error_info'] = "upload excel gagal, Product ID berikut tidak ada dalam database : ".$product_ol_miss." ";
			$this->session->set_userdata($newdata);
		} elseif ( count($inv_product_duplicate) > 0 ) {
			$product_duplicate = '"'.implode('","', $inv_product_duplicate ).'"';
			$newdata['error_info'] = "upload excel gagal, INV berikut terdapat ProductID kembar : ".$product_duplicate." ";
			$this->session->set_userdata($newdata);
		} else {
			$sql 	= 'SELECT sm.INVMP FROM tb_so_main2 sm 
						WHERE sm.INVMP in ("'.implode('","', array_map('strval', $inv_ol)).'")';
			$hasil2 = $this->db->query($sql); 
			$inv_ol_local = array();
			foreach ($hasil2->result_array() as $key => $value) {
				$inv_ol_local[] = $value['INVMP'];
			}
			$inv_ol_ready = array_diff($inv_ol, $inv_ol_local);

			foreach ($data_main as $key => $value_main) {
				if (in_array($value_main['INVMP'], $inv_ol_ready)) {
					$datamain = array(
						'CustomerID' => $customer,
						'SalesID' => $sales,
						'BillingAddress' => str_replace(array("\n", "\r"), ' ', $billing),
						'ShipAddress' => str_replace(array("\n", "\r"), ' ', $value_main['ShipAddress']),
						'RegionID' => $regionid,
						'SECID' => $secid,
						'NPWP' => $npwp,
						'PaymentWay' => 'TOP',
						'PaymentTerm' => $paymentterm,
						'SOCategory' => 1,
						'SOType' => 'standard',
						'INVCategory' => 1,
						'PaymentDeposit' => 0,
						'SODate' => $value_main['SODate'],
						'ShopID' => $shop,
						'SOShipDate' => $value_main['SOShipDate'],
						'SOTerm' => '',
						'SONote' => str_replace(array("\n", "\r"), ' ', $value_main['SONote']),
						'ExpeditionID' => 1,
						'ExpeditionPrice' => 0,
						'ExpeditionWeight' => 0,
						'FreightCharge' => 0,
						'SOTotalBefore' => $value_main['SOTotalBefore'],
						'TaxRate' => 0,
						'TaxAmount' => 0,
						'SOTotal' => $value_main['SOTotalBefore'], 
						'PermitNote' => '', 
						'InputDate' => date('Y-m-d H:i:s'),
						'InputBy' => $this->session->userdata('UserAccountID'),
						'ModifiedDate' => date('Y-m-d H:i:s'),
						'ModifiedBy' => $this->session->userdata('UserAccountID'),
					);
					$this->db->insert('tb_so_main', $datamain);
					$this->last_query .= "//".$this->db->last_query();

					$sql 		= "select max(SOID) as SOID from tb_so_main ";
					$getSOID 	= $this->db->query($sql);
					$row 		= $getSOID->row();
					$SOID 		= $row->SOID;

					$datamain2 = array(
						'SOID' => $SOID,
						'INVMP' => $value_main['INVMP'], 
						'MPfee' => $mpfee, 
						'SOShipDateFinal' => $value_main['SOShipDate'],
					);
					$this->db->insert('tb_so_main2', $datamain2);
					$this->last_query .= "//".$this->db->last_query();

					$SalesOrderDetailID = 0;
					foreach ($data_detail[$value_main['Count']] as $key => $value_detail) {
						// cek promo 
						$sql 	= "SELECT pm.ProductID, pm.ProductName, pm.ProductPriceDefault, pm.ProductPriceHPP, 
									pm.ProductMultiplier, pvd.*, 
									pvm.PromoVolName, pcm.PromoDefault,
									@PriceCategory := pm.ProductPriceDefault - (pm.ProductPriceDefault*(pcm.PromoDefault/100)) AS PriceCategory,
									@PricePromo := @PriceCategory - (@PriceCategory*(pvd.Promo/100)) AS PricePromo,
									@PricePT1 := @PricePromo - (@PricePromo*(pvd.PT1Discount/100)) AS PricePT1,
									@PricePT2 := @PricePromo - (@PricePromo*(pvd.PT2Discount/100)) AS PricePT2
									FROM tb_product_main pm
									LEFT JOIN tb_price_promo_vol_detail pvd ON pm.ProductID=pvd.ProductID
									LEFT JOIN tb_price_promo_vol_main pvm ON (pvd.PromoVolID=pvm.PromoVolID) 
									LEFT JOIN tb_price_category_main pcm ON (pvm.PricecategoryID=pcm.PricecategoryID) 
									WHERE pm.ProductID = ".$value_detail['ProductID']."
									AND pvm.PromoVolID in (select PromoVolID from vw_price_promo_vol_active) 
									and pvm.isActive=1 and pvd.PromoVolID in (".$promovolume.") 
									AND pvd.ProductQty <= ".$value_detail['ProductQty']."
									ORDER BY PricePT1 ASC LIMIT 1";
						$hasil 	= $this->db->query($sql);
						$row 	= $hasil->row();
						if (!empty($row)) {
							$ProductName = $row->ProductName;
			    			$ProductPriceDefault = $row->ProductPriceDefault - ( ($row->ProductPriceDefault/100)*$row->PromoDefault );
							$ProductHPP = $row->ProductPriceHPP;
							$ProductMultiplier = $row->ProductMultiplier;
							$PriceID = $row->PromoVolID;
							$PriceName = $row->PromoVolName;

							$PricePercent = $row->Promo;
							$PT1Percent = $row->PT1Discount;
							$PT1Price = $row->PricePT1;
							$PT2Percent = $row->PT2Discount;
							$PT2Price = $row->PricePT2;
						} else {
							$sql 	= "SELECT pm.ProductID, pm.ProductName, pm.ProductPriceDefault, pm.ProductPriceHPP, 
										pm.ProductMultiplier, pld.PricelistID, pld.PT1Discount, pld.Promo, pld.PT2Discount, 
										plm.PricelistName, plm.PromoDefault,
										@PriceCategory := pm.ProductPriceDefault - (pm.ProductPriceDefault*(plm.PromoDefault/100)) AS PriceCategory,
										@PricePromo := @PriceCategory - (@PriceCategory*(pld.Promo/100)) AS PricePromo,
										@PricePT1 := @PricePromo - (@PricePromo*(pld.PT1Discount/100)) AS PricePT1,
										@PricePT2 := @PricePromo - (@PricePromo*(pld.PT2Discount/100)) AS PricePT2
										FROM tb_product_main pm
										LEFT JOIN tb_price_list_detail pld ON pm.ProductID=pld.ProductID
										LEFT JOIN (
											SELECT plm.*, pcm.PromoDefault FROM tb_price_list_main plm
											LEFT JOIN tb_price_category_detail pcd ON plm.PricelistID=pcd.PricelistID
											LEFT JOIN tb_price_category_main pcm ON pcd.PricecategoryID=pcm.PricecategoryID
										) AS plm ON pld.PricelistID=plm.PricelistID
						 				WHERE pm.ProductID=".$value_detail['ProductID']." 
										AND plm.PricelistID in (select PricelistID from vw_price_list_active) 
										and plm.isActive=1 and pld.PricelistID in(".$pricelist.") 
						 				ORDER BY PricePT1 ASC LIMIT 1";
							$hasil2 = $this->db->query($sql);
							$row 	= $hasil2->row();
							if (!empty($row)) {
								$ProductName = $row->ProductName;
				    			$ProductPriceDefault = $row->ProductPriceDefault - ( ($row->ProductPriceDefault/100)*$row->PromoDefault );
								$ProductHPP = $row->ProductPriceHPP;
								$ProductMultiplier = $row->ProductMultiplier;
								$PriceID = $row->PricelistID;
								$PriceName = $row->PricelistName;

								$PricePercent = $row->Promo;
								$PT1Percent = $row->PT1Discount;
								$PT1Price = $row->PricePT1;
								$PT2Percent = $row->PT2Discount;
								$PT2Price = $row->PricePT2;
							} else {
								$sql 	= "SELECT pm.ProductID, pm.ProductName, pm.ProductPriceDefault, 
											pm.ProductPriceHPP, pm.ProductMultiplier
											FROM tb_product_main pm WHERE pm.ProductID=".$value_detail['ProductID'];
								$hasil2 = $this->db->query($sql);
								$row 	= $hasil2->row();
								$ProductName = $row->ProductName;
				    			$ProductPriceDefault = $row->ProductPriceDefault;
								$ProductHPP = $row->ProductPriceHPP;
								$ProductMultiplier = $row->ProductMultiplier;
								$PriceID = 0;
								$PriceName = "";
								$PricePercent = 0;
								$PT1Percent = 0;
								$PT1Price = 0;
								$PT2Percent = 0;
								$PT2Price = 0;
							}
						}

						$PriceAmount = $value_detail['PriceAmount'];
						$PricePercent = ($ProductPriceDefault!=$PriceAmount) ? ($ProductPriceDefault-$PriceAmount)/($ProductPriceDefault/100) : 0;

			   			$datadetail = array(
							'SOID' => $SOID,
							// 'SalesOrderDetailID' => $SalesOrderDetailID++,
							'ProductID' => $value_detail['ProductID'],
							'ProductName' => $ProductName,
							'ProductQty' => $value_detail['ProductQty'],
							'ProductMultiplier' => $ProductMultiplier,
							'ProductHPP' => $ProductHPP,
							'ProductPriceDefault' => $ProductPriceDefault,
							'ProductWeight' => 1,
							'PriceID' => 0,
							'PriceName' => "",
							'PT1Percent' => 0,
							'PT1Price' => $ProductPriceDefault,
							'PT2Percent' => 0,
							'PT2Price' => $ProductPriceDefault,
							'PricePercent' => $PricePercent,
							'PriceAmount' => $value_detail['PriceAmount'],
							'FreightCharge' => 0,
							'PriceTotal' => $value_detail['PriceTotal'],
							'Pending' => $value_detail['ProductQty'],
						);
						$this->db->insert('tb_so_detail', $datadetail);
						$this->last_query .= "//".$this->db->last_query();
			   		};
			   		$this->SOShipDate_history($SOID, $value_main['SOShipDate'], 'formSO');

			   		$sql = "UPDATE tb_so_main t1, 
							(SELECT sd.SOID, SUM(sd.PriceTotal) AS PriceTotal 
							FROM tb_so_detail sd WHERE sd.SOID=".$SOID.") t2
							SET t1.SOTotalBefore=t2.PriceTotal, t1.SOTotal=t2.PriceTotal
							WHERE t1.SOID=t2.SOID AND t1.SOID=".$SOID." ";
					$this->db->query($sql);
			   	}
			}
		} 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

//invoice ==================================================================
	function do_to_inv()
	{
		$sql = "SELECT dm.*, sm.SOID, sm.BillingAddress, sc.CategoryName, em.Company2, 
				sm.PaymentWay, SUM(drd.ProductQty) AS DOQty FROM tb_do_main dm 
				LEFT JOIN tb_so_main sm ON (sm.SOID=dm.DOReff) 
				LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory) 
				LEFT JOIN vw_sales_executive2 em ON (sm.SalesID=em.SalesID) 
				LEFT JOIN vw_do_return_dor drd ON (dm.DOID=drd.DOID)
				WHERE dm.DOType='SO' and dm.DOStatus=1 and sm.INVCategory=1 and sm.SOCategory  NOT IN (3, 4, 5, 6) 
				AND dm.DOID not in (SELECT DISTINCT DOID FROM tb_invoice_main)
				GROUP BY dm.DOID HAVING DOQty>0";
		$query 	= $this->db->query($sql);
		// echo $sql;
		$show   = array();
		foreach ($query->result() as $row) {
			$BillingAddress = explode(";", $row->BillingAddress);
		  	$show[] = array(
		  			'DOID' => $row->DOID,
		  			'SOID' => $row->SOID,
					'Customer' => $BillingAddress[0],
					'Sales' => $row->Company2,
					'Date' => $row->DODate,
					'PaymentWay' => $row->PaymentWay,
		  			'CategoryName' => $row->CategoryName
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function so_to_inv()
	{
		$sql = "SELECT sm.SOID, sm.SODate, sm.BillingAddress, em.Company2, sc.CategoryName, sm.PaymentWay, 
				COALESCE(SUM(sip.Percent),0) AS Percent, COALESCE(SUM(sip.Amount),0) AS Amount
				FROM tb_so_main sm
				LEFT JOIN tb_so_inv_percent sip ON (sm.SOID=sip.SOID)
				LEFT JOIN vw_sales_executive2 em ON (sm.SalesID=em.SalesID)
				LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory)
				WHERE sm.INVCategory=2 
				AND sm.SOStatus = 1
				AND sm.SOConfirm1 = 1
				AND sm.SOConfirm2 = 1 
				GROUP BY SOID HAVING Percent<100";
				// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$BillingAddress = explode(";", $row->BillingAddress);
		  	$show[] = array(
		  			'DOID' => '~',
		  			'SOID' => $row->SOID,
					'Customer' => $BillingAddress[0],
					'Sales' => $row->Company2,
					'Date' => $row->SODate,
					'PaymentWay' => $row->PaymentWay,
		  			'CategoryName' => $row->CategoryName
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function do_to_inv_detail()
	{
		$DOID 	= $this->input->get_post('do');
		$FakturTax = $this->get_last_faktur_number_tax();

		$sql 	= "select INVID, DOID from tb_invoice_main where DOID=".$DOID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (empty($row)) {

			$sql 	= "SELECT dm.*, sm.*, sc.CategoryName, em.Company2 as fullname
						FROM tb_do_main dm
						LEFT JOIN tb_so_main sm ON (sm.SOID=dm.DOReff)
						LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory)
						LEFT JOIN vw_sales_executive2 em ON (sm.SalesID=em.SalesID)
						WHERE dm.DOID=".$DOID;
			$getrow	= $this->db->query($sql);
			$rowmain= $getrow->row();
			$show['main'] = get_object_vars($rowmain);

			$PriceBefore = 0;
			$TotalFreightCharge = 0;
			$TotalWeightSO = 0;
			$TotalWeightDelivered = 0;
			$TotalQtySO = 0;
			$TotalQtyDelivered = 0;
			$sql 	= "SELECT drpd.DOID, drpd.reff, drpd.ProductQty-drpd.totaldor as qtydelivered, sd.*
						FROM vw_do_reff_product_detail drpd
						LEFT JOIN tb_so_detail sd ON (sd.SOID=drpd.DOReff and drpd.ProductID=sd.ProductID and drpd.SalesOrderDetailID=sd.SalesOrderDetailID)
						WHERE drpd.DOID=".$DOID;
			// echo $sql;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$linetotal = $row->PriceAmount * $row->qtydelivered;
				$PriceBefore += $linetotal;

				$FreightCharge = 0;
				if ($rowmain->FreightCharge == 0) { //fc include
					if ($row->FreightCharge > 0) {
						$FreightCharge += ($row->FreightCharge/$row->ProductQty)*$row->qtydelivered;
					}
				}
				$TotalFreightCharge += $FreightCharge;
				$TotalWeightSO += $row->ProductWeight*$row->ProductQty;
				$TotalWeightDelivered += $row->ProductWeight*$row->qtydelivered;
				$TotalQtyDelivered += $row->qtydelivered;

			  	$show['detail'][] = array(
			  		'DOID' => $row->DOID,
			  		'reff' => $row->reff,
			  		'qtydelivered' => $row->qtydelivered,
			  		'SOID' => $row->SOID,
					'SalesOrderDetailID' => $row->SalesOrderDetailID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductMultiplier' => $row->ProductMultiplier,
					'ProductHPP' => $row->ProductHPP,
					'ProductWeight' => $row->ProductWeight,
					'ProductPriceDefault' => $row->ProductPriceDefault,
					'PT1Percent' => $row->PT1Percent,
					'PT2Percent' => $row->PT2Percent,
					'PricePercent' => $row->PricePercent,
					'PriceAmount' => $row->PriceAmount,
					'linetotal' => $linetotal,
					'FreightCharge' => $FreightCharge,
				);
			};

			$show['main']['FakturID'] = $FakturTax[0];
			$show['main']['FakturNumberParent'] = $FakturTax[1];
			$show['main']['FakturNumber'] =  $FakturTax[2];
			$show['main']['PriceBefore'] = $PriceBefore;
			$show['main']['TaxPrice'] = ($PriceBefore/100)*$rowmain->TaxRate;
			$show['main']['TotalPrice'] = $show['main']['PriceBefore']+$show['main']['TaxPrice'];

			$sql 	= "SELECT sd.SOID, SUM( sd.ProductWeight*sd.ProductQty ) AS totalweight,
						SUM(sd.ProductQty) AS TotalQtySO
						FROM tb_so_detail sd WHERE sd.SOID=".$rowmain->SOID;
			$getrow	= $this->db->query($sql);
			$rowfc	= $getrow->row();

			$FCExclude = 0;
			if ($rowmain->FreightCharge > 0) { //fc exclude
				if ($rowmain->FCDivision == 1) {
					$FCExclude = ($rowmain->FreightCharge/$rowfc->totalweight)*$TotalWeightDelivered;
				} elseif ($rowmain->FCDivision == 2) {
					$FCExclude = ($rowmain->FreightCharge/$rowfc->TotalQtySO)*$TotalQtyDelivered;
				}
			}

			$show['main']['FCInclude'] = $TotalFreightCharge;
			$show['main']['TaxFC'] = ($TotalFreightCharge/100)*$rowmain->TaxRate;
			$show['main']['FCExclude'] = $FCExclude;
			$show['main']['TotalFC'] = $show['main']['FCInclude']+$show['main']['TaxFC']+$show['main']['FCExclude'];

			$show['main']['TotalInvoice'] = $show['main']['TotalPrice']+$show['main']['TotalFC'];

			// echo json_encode($show);
		    return $show;
		} else {
			redirect(base_url('transaction/invoice_list'));
		}
		$this->log_user->log_query($this->last_query);
	}
	function so_to_inv_detail()
	{
		$SOID 	= $this->input->get_post('so');
		$FakturTax = $this->get_last_faktur_number_tax();

		$sql 	= "SELECT sm.*, sc.CategoryName, em.Company2 as fullname
					FROM tb_so_main sm 
					LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory)
					LEFT JOIN vw_sales_executive2 em ON (sm.SalesID=em.SalesID)
					WHERE sm.SOID=".$SOID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$show['main'] = get_object_vars($rowmain);
		$show['main']['FCInclude'] = 0;

		$sql 	= "SELECT * from tb_so_detail sd WHERE SOID=".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		  		'SOID' => $row->SOID,
				'SalesOrderDetailID' => $row->SalesOrderDetailID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductWeight' => $row->ProductWeight,
		  		'qtydelivered' => $row->ProductQty,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'PT1Percent' => $row->PT1Percent,
				'PT2Percent' => $row->PT2Percent,
				'PricePercent' => $row->PricePercent,
				'PriceAmount' => $row->PriceAmount,
				'linetotal' => $row->PriceTotal,
				'FreightCharge' => $row->FreightCharge,
			);
			$show['main']['FCInclude'] += $row->FreightCharge;
		};

		$show['main']['FakturID'] = $FakturTax[0];
		$show['main']['FakturNumberParent'] = $FakturTax[1];
		$show['main']['FakturNumber'] =  $FakturTax[2];
		$show['main']['TaxFC'] = ($show['main']['FCInclude']/100)*$rowmain->TaxRate;
		$show['main']['TotalFC'] = $show['main']['FCInclude']+$show['main']['TaxFC']+$show['main']['FreightCharge'];
		$show['main']['TotalInvoice'] = $show['main']['SOTotal']+$show['main']['TotalFC'];

		$sql = "SELECT COALESCE(SUM(Percent),0) AS Percent, COALESCE(SUM(Amount),0) AS Amount
				FROM tb_so_inv_percent WHERE SOID=".$SOID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$main 	= get_object_vars($rowmain);
		$show['main']['paidpercent'] = $main['Percent'];
		$show['main']['paidamount'] = $main['Amount'];

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_add_act()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$SOID = $this->input->post('SOID');
		$DOID = $this->input->post('DOID');
		$date = $this->input->post('date');
		$faktur = $this->input->post('faktur');
		$ProductID 		= $this->input->post('ProductID');
		$SalesOrderDetailID = $this->input->post('SalesOrderDetailID');
		$ProductName 	= $this->input->post('ProductName');
		$qtydelivered 	= $this->input->post('qtydelivered');
		$ProductMultiplier = $this->input->post('ProductMultiplier');
		$ProductHPP = $this->input->post('ProductHPP');
		$ProductWeight = $this->input->post('ProductWeight');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$PricePercent 	= $this->input->post('PricePercent');
		$PTPercent 		= $this->input->post('PTPercent');
		$PriceAmount 	= $this->input->post('PriceAmount');
		$linetotal 		= $this->input->post('linetotal');
		$FreightCharge 	= $this->input->post('FreightCharge');
		$FCInclude 		= $this->input->post('FCInclude');
		$TaxFC 		= $this->input->post('TaxFC');
		$FCExclude 	= $this->input->post('FCExclude');
		$TotalFC 	= $this->input->post('TotalFC');
		$PriceBefore = $this->input->post('PriceBefore');
		$TaxPrice 	= $this->input->post('TaxPrice');
		$TotalPrice = $this->input->post('TotalPrice');
		$TotalInvoice = $this->input->post('TotalInvoice');
		$paymentPercent = $this->input->post('paymentPercent');
		$paymentAmount = $this->input->post('paymentAmount');
		$datetime = date('Y-m-d H:i:s');
		$FakturID = $this->input->post('FakturID');
		$FakturNumber = $this->input->post('FakturNumber');
		$FakturNumberParent = $this->input->post('FakturNumberParent');

		if (isset($DOID)) {
			$sql 	= "select DOID from tb_invoice_main where DOID = '".$DOID."'";
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (empty($row)) {	

				$sql 	= "SELECT dm.*, sm.*, sm2.SEPVMp FROM tb_do_main dm
							LEFT JOIN tb_so_main sm ON (sm.SOID=dm.DOReff)
							LEFT JOIN tb_so_main2 sm2 ON (sm.SOID=sm2.SOID)
							WHERE dm.DOID=".$DOID;
				$getrow	= $this->db->query($sql);
				$rowmain= $getrow->row();
				$CustomerID 	= $rowmain->CustomerID;
				$SalesID 	= $rowmain->SalesID;
				$SEPVMp 	= $rowmain->SEPVMp;
				$main 	= get_object_vars($rowmain);
				$TaxAddress = ($main['TaxAddress']!="" ? $main['TaxAddress'] : $main['BillingAddress']);

				$datamain = array(
					'DOID' => $DOID,
					'SOID' => $SOID,
					'CustomerID' => $main['CustomerID'],
					'SalesID' => $main['SalesID'],
					'SECID' => $main['SECID'],
					'RegionID' => $main['RegionID'],
					'BillingAddress' => $main['BillingAddress'],
					'ShipAddress' => $main['ShipAddress'],
					'TaxAddress' => $TaxAddress ,
					'NPWP' => ($main['NPWP'] == null) ? '0' : $main['NPWP'],
					'FakturNumberParent' => $FakturID,
					'FakturNumber' => $FakturNumber,
					'PaymentWay' => $main['PaymentWay'],
					'PaymentTerm' => $main['PaymentTerm'],
					'INVCategory' => $main['INVCategory'],
					'INVDate' => $date,
					'INVTerm' => $main['SOTerm'],
					'INVNote' => $main['SONote'],
					'TaxRate' => $main['TaxRate'],
					'FCInclude' => $FCInclude,
					'FCTax' => $TaxFC,
					'FCExclude' => $FCExclude,
					'FCTotal' => $TotalFC,
					'PriceBeforeTax' => $PriceBefore,
					'PriceTax' => $TaxPrice,
					'PriceTotal' => $TotalPrice,
					'INVTotal' => $TotalInvoice,
					'INVInput' => $datetime,
					'INVBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->insert('tb_invoice_main', $datamain);
				$this->last_query .= "//".$this->db->last_query();

				$sql 	= "SELECT max(INVID) as INVID from tb_invoice_main ";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$INVID 	= $row->INVID;

				$sql 	= "SELECT PV from tb_site_config ";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$PV 	= $row->PV;

				$DOAmount = 0;
				for ($i=0; $i < count($ProductID);$i++) { 
					if ($qtydelivered[$i] >0) {
						$datadetail = array(
							'INVID' => $INVID,
							'SalesOrderDetailID' => $SalesOrderDetailID[$i],
							'ProductID' => $ProductID[$i],
							'ProductName' => $ProductName[$i],
							'ProductQty' => $qtydelivered[$i],
							'ProductMultiplier' => $ProductMultiplier[$i],
							'ProductHPP' => $ProductHPP[$i],
							'ProductPriceDefault' => $ProductPriceDefault[$i],
							'ProductWeight' => $ProductWeight[$i],
							'PromoPercent' => $PricePercent[$i],
							'PTPercent' => $PTPercent[$i],
							'PriceAmount' => $PriceAmount[$i],
							'FreightCharge' => $FreightCharge[$i],
							'PriceTotal' => $linetotal[$i],
							'PV' => (($PriceAmount[$i]-$ProductHPP[$i])/$PV)*$SEPVMp
						);
						$this->db->insert('tb_invoice_detail', $datadetail);
						$this->last_query .= "//".$this->db->last_query();

						$DOAmount += $ProductHPP[$i]*$qtydelivered[$i];
					}
				}

				// ----------------------------------------------
				$FCAmount = $FCInclude + $FCExclude;
				$this->load->model('model_acc');
				$this->model_acc->auto_journal_inv($INVID, $DOID, $TotalInvoice, $TaxPrice, $FCAmount, $DOAmount);
			}

		} else {
			$sql 	= "SELECT sm.*, sm2.SEPVMp FROM tb_so_main sm
						LEFT JOIN tb_so_main2 sm2 ON (sm.SOID=sm2.SOID)
						WHERE sm.SOID=".$SOID;
			$getrow	= $this->db->query($sql);
			$rowmain= $getrow->row();
			$CustomerID 	= $rowmain->CustomerID;
			$SalesID 	= $rowmain->SalesID;
			$SEPVMp 	= $rowmain->SEPVMp;
			$main 	= get_object_vars($rowmain);
			$TaxAddress = ($main['TaxAddress']!="" ? $main['TaxAddress'] : $main['BillingAddress']);

			$datamain = array(
				'DOID' => '0',
				'SOID' => $SOID,
				'CustomerID' => $main['CustomerID'],
				'SalesID' => $main['SalesID'],
				'SECID' => $main['SECID'],
				'RegionID' => $main['RegionID'],
				'BillingAddress' => $main['BillingAddress'],
				'ShipAddress' => $main['ShipAddress'],
				'TaxAddress' => $TaxAddress ,
				'NPWP' => $main['NPWP'],
				'FakturNumberParent' => $FakturID,
				'FakturNumber' => $FakturNumber,
				'PaymentWay' => $main['PaymentWay'],
				'PaymentTerm' => $main['PaymentTerm'],
				'INVCategory' => $main['INVCategory'],
				'INVDate' => $date,
				'INVTerm' => $main['SOTerm'],
				'INVNote' => $main['SONote'],
				'TaxRate' => $main['TaxRate'],
				'FCInclude' => $FCInclude,
				'FCTax' => $TaxFC,
				'FCExclude' => $FCExclude,
				'FCTotal' => $TotalFC,
				'PriceBeforeTax' => $PriceBefore,
				'PriceTax' => $TaxPrice,
				'PriceTotal' => $TotalPrice,
				'INVTotal' => $paymentAmount,
				'INVInput' => $datetime,
				'INVBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_invoice_main', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select max(INVID) as INVID from tb_invoice_main ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$INVID 	= $row->INVID;

			$sql 	= "SELECT PV from tb_site_config ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$PV 	= $row->PV;

			for ($i=0; $i < count($ProductID);$i++) { 
				if ($qtydelivered[$i] >0) {
					$datadetail = array(
						'INVID' => $INVID,
						'ProductID' => $ProductID[$i],
						'ProductName' => $ProductName[$i],
						'ProductQty' => $qtydelivered[$i],
						'ProductMultiplier' => $ProductMultiplier[$i],
						'ProductHPP' => $ProductHPP[$i],
						'ProductPriceDefault' => $ProductPriceDefault[$i],
						'ProductWeight' => $ProductWeight[$i],
						'PromoPercent' => $PricePercent[$i],
						'PTPercent' => $PTPercent[$i],
						'PriceAmount' => $PriceAmount[$i],
						'FreightCharge' => $FreightCharge[$i],
						'PriceTotal' => $linetotal[$i],
						'PV' => (($PriceAmount[$i]-$ProductHPP[$i])/$PV)*$SEPVMp
					);
					$this->db->insert('tb_invoice_detail', $datadetail);
					$this->last_query .= "//".$this->db->last_query();
				}
			}

			$data = array(
				'SOID' => $SOID,
				'INVID' => $INVID,
				'Percent' => $paymentPercent,
				'Amount' => $paymentAmount
			);
			$this->db->insert('tb_so_inv_percent', $data);
			$this->last_query .= "//".$this->db->last_query();

			$TotalInvoice = $paymentAmount;
		}

		$this->load->model('model_finance');
		$this->model_finance->invoice_payment_auto($INVID, $date, $SOID, $TotalInvoice); 

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function invoice_add_act_batch()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$DOIDArr = $this->input->post('data');
		$DOIDArr2 = array();
		$sql 	= "SELECT * 
					FROM (
						SELECT dd.DOID, dd.DOReff, SUM( dd.ProductQty ) AS DOQty
						FROM tb_do_detail dd
						WHERE dd.DOID IN (". implode(',', array_map('intval', $DOIDArr)) .") 
						GROUP BY dd.DOID
					) t1
					LEFT JOIN (
						SELECT sd.SOID, SUM( sd.ProductQty ) AS SOQty, 
						SUM( sd.FreightCharge ) AS FCInclude, SUM( sd.PriceTotal ) AS PriceTotal
						FROM tb_so_detail sd
						WHERE sd.SOID IN (
							SELECT dm.DOReff FROM tb_do_main dm 
							WHERE dm.DOID IN (". implode(',', array_map('intval', $DOIDArr)) .")
						)	GROUP BY sd.SOID
					) t2 ON t1.DOReff= t2.SOID";
		$query 	= $this->db->query($sql);	
		foreach ($query->result() as $row) {
			if ($row->DOQty == $row->SOQty) {
				$DOID = $row->DOID;
				$SOID = $row->SOID;

				$sql 	= "select DOID from tb_invoice_main where DOID = '".$DOID."'";
				$query 	= $this->db->query($sql);	
				$row2 	= $query->row();
				if (empty($row2)) {	
					$sql 	= "SELECT sm.*, sm2.SEPVMp 
								FROM tb_so_main sm
								LEFT JOIN tb_so_main2 sm2 ON (sm.SOID=sm2.SOID)
								WHERE sm.SOID=".$SOID;
					$getrow	= $this->db->query($sql);
					$rowmain= $getrow->row();

					$FakturTax = $this->get_last_faktur_number_tax();
					$FakturID = $FakturTax[0];
					$FakturNumberParent = $FakturTax[1];
					$FakturNumber =  $FakturTax[2];

					$FCInclude = $row->FCInclude;
					$FCTax = $FCInclude * ($rowmain->TaxRate/100);
					$PriceBeforeTax = $row->PriceTotal - $row->FCInclude;
					$PriceTax = $PriceBeforeTax * ($rowmain->TaxRate/100);

					$datamain = array(
						'DOID' => $DOID,
						'SOID' => $SOID,
						'CustomerID' => $rowmain->CustomerID,
						'SalesID' => $rowmain->SalesID,
						'SECID' => $rowmain->SECID,
						'RegionID' => $rowmain->RegionID,
						'BillingAddress' => $rowmain->BillingAddress,
						'ShipAddress' => $rowmain->ShipAddress,
						'TaxAddress' => $rowmain->TaxAddress ,
						'NPWP' => $rowmain->NPWP,
						'FakturNumberParent' => $FakturID,
						'FakturNumber' => $FakturNumber,
						'PaymentWay' => $rowmain->PaymentWay,
						'PaymentTerm' => $rowmain->PaymentTerm,
						'INVCategory' => $rowmain->INVCategory,
						'INVDate' => date('Y-m-d'),
						'INVTerm' => $rowmain->SOTerm,
						'INVNote' => $rowmain->SONote,
						'TaxRate' => $rowmain->TaxRate,
						'FCInclude' => $FCInclude,
						'FCTax' => $FCTax,
						'FCExclude' => $rowmain->FreightCharge,
						'FCTotal' => $rowmain->FreightCharge + $FCTax + $FCInclude,
						'PriceBeforeTax' => $PriceBeforeTax,
						'PriceTax' => $PriceTax,
						'PriceTotal' => $PriceBeforeTax + $PriceTax,
						'INVTotal' => $PriceBeforeTax + $PriceTax + $rowmain->FreightCharge + $FCTax + $FCInclude,
						'INVInput' => date('Y-m-d H:i:s'),
						'INVBy' => $this->session->userdata('UserAccountID')
					);
					$this->db->insert('tb_invoice_main', $datamain);
					$this->last_query .= "//".$this->db->last_query();

					$sql 	= "SELECT max(INVID) as INVID from tb_invoice_main ";
					$getrow = $this->db->query($sql);
					$row 	= $getrow->row();
					$INVID 	= $row->INVID;

					$sql 	= "SELECT PV from tb_site_config ";
					$getrow = $this->db->query($sql);
					$row 	= $getrow->row();
					$PV 	= $row->PV;

					$DOAmount = 0;
					$datadetail = array();
					$sql 	= "SELECT * FROM tb_so_detail WHERE SOID=".$SOID;
					$query3 = $this->db->query($sql);	
					foreach ($query3->result() as $row3) {
						$PTPercent = ($rowmain->PaymentWay == 'TOP') ? $row3->PT1Percent : $row3->PT2Percent;
						$datadetail[] = array(
							'INVID' => $INVID,
							'SalesOrderDetailID' => $row3->SalesOrderDetailID,
							'ProductID' => $row3->ProductID,
							'ProductName' => $row3->ProductName,
							'ProductQty' => $row3->ProductQty,
							'ProductMultiplier' => $row3->ProductMultiplier,
							'ProductHPP' => $row3->ProductHPP,
							'ProductPriceDefault' => $row3->ProductPriceDefault,
							'ProductWeight' => $row3->ProductWeight,
							'PromoPercent' => $row3->PricePercent,
							'PTPercent' => $PTPercent,
							'PriceAmount' => $row3->PriceAmount,
							'FreightCharge' => $row3->FreightCharge,
							'PriceTotal' => $row3->PriceAmount * $row3->ProductQty,
							'PV' => (($row3->PriceAmount-$row3->ProductHPP)/$PV)*$rowmain->SEPVMp
						);
						$DOAmount += $row3->ProductHPP*$row3->ProductQty;
					}
					$this->db->insert_batch('tb_invoice_detail', $datadetail);
					$this->last_query .= "//".$this->db->last_query();

					// ----------------------------------------------
					$FCAmount = $FCInclude + $rowmain->FreightCharge;
					$this->load->model('model_acc');
					$this->model_acc->auto_journal_inv($INVID, $DOID, $datamain['INVTotal'], $datamain['PriceTax']+$datamain['FCTax'], $FCAmount, $DOAmount);
					
					$this->load->model('model_finance');
					$this->model_finance->invoice_payment_auto($INVID, $datamain['INVDate'], $SOID, $datamain['INVTotal']); 
				}
			}
		}
		$query = $this->db->query('SELECT INVID FROM tb_invoice_main 
				where DOID in ('. implode(',', array_map('intval', $DOIDArr)) .')');
		echo json_encode($query->num_rows());

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function invoice_update($INVID, $DOID, $returfc)
	{
		$this->db->trans_start();

		$sql 	= "SELECT dm.*, sm.*, sm2.SEPVMp, sc.CategoryName, em.Company2 as fullname
					FROM tb_do_main dm
					LEFT JOIN tb_so_main sm ON (sm.SOID=dm.DOReff)
					LEFT JOIN tb_so_main2 sm2 ON (sm.SOID=sm2.SOID)
					LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory)
					LEFT JOIN vw_sales_executive2 em ON (sm.SalesID=em.SalesID)
					WHERE dm.DOID=".$DOID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$SEPVMp = $rowmain->SEPVMp;
		$main 	= get_object_vars($rowmain);

		$PriceBefore = 0;
		$TotalFreightCharge = 0;
		$TotalWeightSO = 0;
		$TotalWeightDO = 0;
		$TotalWeightDelivered = 0;
		$sql 	= "SELECT drpd.DOID, drpd.reff, drpd.ProductQty as totaldo, drpd.ProductQty-drpd.totaldor as qtydelivered, sd.*
					FROM vw_do_reff_product_detail drpd
					LEFT JOIN tb_so_detail sd ON (sd.SOID=drpd.DOReff and drpd.ProductID=sd.ProductID)
					WHERE drpd.DOID=".$DOID;
		$query 	= $this->db->query($sql);

		$this->db->where('INVID', $INVID);
		$this->db->delete('tb_invoice_detail');
		$this->last_query .= "//".$this->db->last_query();

		$sql	= "SELECT PV from tb_site_config ";
		$getrow = $this->db->query($sql);
		$row	= $getrow->row();
		$PV	= $row->PV;

		foreach ($query->result() as $row) {
			$linetotal = $row->PriceAmount * $row->qtydelivered;
			$PriceBefore += $linetotal;

			$FreightCharge = 0;
			if ($rowmain->FreightCharge == 0) { //fc include
				if ($row->FreightCharge > 0) {
					if ($returfc > 0) {
						$FreightCharge += ($row->FreightCharge/$row->ProductQty)*$row->qtydelivered;
					} else {
						$FreightCharge += ($row->FreightCharge/$row->ProductQty)*$row->totaldo;
					}
				}
			}
			$TotalFreightCharge += $FreightCharge;
			$TotalWeightSO += $row->ProductWeight*$row->ProductQty;
			$TotalWeightDelivered += $row->ProductWeight*$row->qtydelivered;
			$TotalWeightDO += $row->ProductWeight*$row->totaldo;

			$datadetail = array(
				'INVID' => $INVID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->qtydelivered,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductWeight' => $row->ProductWeight,
				'PromoPercent' => $row->PricePercent,
				'PTPercent' => $row->PTPercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $FreightCharge,
				'PriceTotal' => $linetotal,
				'PV' => (($row->PriceAmount - $row->ProductHPP)/$PV)*$SEPVMp
			);
			$this->db->insert('tb_invoice_detail', $datadetail);
			$this->last_query .= "//".$this->db->last_query();
		};

		$FCExclude = 0;
		if ($rowmain->FreightCharge > 0) { //fc include
			if ($returfc > 0) {
				$FCExclude = ($rowmain->FreightCharge/$TotalWeightSO)*$TotalWeightDelivered;
			} else {
				$FCExclude = ($rowmain->FreightCharge/$TotalWeightSO)*$TotalWeightDO;
			}
		}

		$TaxPrice 	= ($PriceBefore/100)*$rowmain->TaxRate;
		$TotalPrice = $PriceBefore+$TaxPrice;
		$FCInclude 	= $TotalFreightCharge;
		$TaxFC 		= ($TotalFreightCharge/100)*$rowmain->TaxRate;
		$FCExclude 	= $FCExclude;
		$TotalFC 	= $FCInclude+$TaxFC+$FCExclude;
		$TotalInvoice = $TotalPrice+$TotalFC;

		$datamain = array(
			'TaxRate' => $main['TaxRate'],
			'FCInclude' => $FCInclude,
			'FCTax' => $TaxFC,
			'FCExclude' => $FCExclude,
			'FCTotal' => $TotalFC,
			'FCRetur' => $returfc,
			'PriceBeforeTax' => $PriceBefore,
			'PriceTax' => $TaxPrice,
			'PriceTotal' => $TotalPrice,
			'INVTotal' => $TotalInvoice,
		);
		$this->db->where('INVID', $INVID);
		$this->db->update('tb_invoice_main', $datamain);
		$this->last_query .= "//".$this->db->last_query();

		$this->load->model('model_finance');
		$this->model_finance->invoice_payment_return($INVID); //insert or update to db
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function invoice_list_do()
	{
		$sql = "SELECT * FROM vw_invoice_list2 im WHERE im.INVCategory=1 ";

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
		$query 	= $this->db->query($sql);
		$show   = array();
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
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_list_so()
	{
		$sql = "SELECT im.*, cum.Company2 as customer, em.Company2 as sales, ib.TotalPayment
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) ";
		$sql .= "WHERE im.INVCategory=2 ";

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
		$query 	= $this->db->query($sql);
		$show   = array();
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
		$this->log_user->log_query($this->last_query);
	}
	function invoice_list_do_unpaid()
	{
		$sql = "SELECT im.*, cum.Company as customer, em.Company2 as sales, ib.TotalPayment,
				SUM(drd.dordProductQty) as totaldor FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) 
				LEFT JOIN vw_do_return_dor drd ON (im.DOID=drd.DOID) 
				WHERE im.INVCategory=1 and ib.TotalPayment<im.INVTotal ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVInput between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "GROUP BY im.INVID order by im.INVID desc";
		}
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
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
				'totaldor' => $row->totaldor
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_list_so_unpaid()
	{
		$sql = "SELECT im.*, cum.Company as customer, em.Company2 as sales, ib.TotalPayment
				FROM tb_invoice_main im 
				LEFT JOIN tb_customer_main cm ON (cm.CustomerID=im.CustomerID)
				LEFT JOIN vw_contact2 cum ON (cum.ContactID=cm.ContactID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN vw_invoice_balance ib ON (ib.INVID = im.INVID) ";
		$sql .= "WHERE im.INVCategory=2 ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and im.INVInput between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else { 
			$sql .= "";
		}
		
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = 0;
			$datediff = 0;
			if ($TotalPaymentPerc < 100) {
				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));

				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
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
		$this->log_user->log_query($this->last_query);
	}
	function print_invoice()
	{
		$INVID = $this->input->get_post('id');

		$sql 	= "SELECT INVCategory FROM tb_invoice_main WHERE INVID=".$INVID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$INVCategory = $row->INVCategory;

		$show['main'] = $this->invoice_main($INVID, $INVCategory);
		if ($show['main']['INVDate'] > '2019-10-01') {
			$show['detail'] = $this->invoice_detail2($INVID, $INVCategory);
		} else {
			$show['detail'] = $this->invoice_detail($INVID, $INVCategory);
		}

		$show['main']['INVCategory'] = $INVCategory;

		if ($INVCategory == 2) {
			$sql 	= "select * from tb_so_inv_percent where INVID=".$INVID;
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			if (!empty($row)) {
				$show['main']['INVNote'] .= '<br>Total Payment Due adalah '.$row->Percent.'% dari total Invoice';
				$show['main']['paymentPercent'] = $row->Percent;
				$show['main']['paymentAmount'] = $row->Amount;
			} else {
				$show['main']['INVNote'] .= '<br>Total Payment Due adalah 100% dari total Invoice';
				$show['main']['paymentPercent'] = '100';
				$show['main']['paymentAmount'] = $show['main']['INVTotal'];
			}
		}

		$sql 	= "SELECT tib.PaymentAmount, tsd.INVMP from tb_invoice_balance tib
					LEFT JOIN tb_invoice_main tim ON tim.INVID=tib.INVID
					LEFT JOIN tb_so_main tsm ON tsm.SOID=tim.SOID
					LEFT JOIN tb_so_main2 tsd ON tsm.SOID=tsd.SOID
					 WHERE tib.INVID=".$show['main']['INVID'];
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['main']['TotalPaid'] = $row->PaymentAmount;
		$show['main']['INVMP'] = $row->INVMP;
		// echo json_encode($show['detail']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function print_freight_charge()
	{
		$INVID = $this->input->get_post('id');
		$sql 	= "select INVCategory from tb_invoice_main where INVID=".$INVID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$INVCategory = $row->INVCategory;

		$show['main'] = $this->invoice_main($INVID, $INVCategory);
		if ($show['main']['INVDate'] > '2019-10-01') {
			$show['detail'] = $this->invoice_detail2($INVID, $INVCategory);
		} else {
			$show['detail'] = $this->invoice_detail($INVID, $INVCategory);
		}

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function print_faktur()
	{
		$INVID = $this->input->get_post('id');
		$sql 	= "select INVCategory from tb_invoice_main where INVID=".$INVID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$INVCategory = $row->INVCategory;

		$show['main'] = $this->invoice_main($INVID, $INVCategory);
		if ($show['main']['INVDate'] > '2019-10-01') {
			$show['detail'] = $this->invoice_detail2($INVID, $INVCategory);
		} else {
			$show['detail'] = $this->invoice_detail($INVID, $INVCategory);
		}

		$sql 	= "select FakturParent from tb_faktur_number where FakturID='".$show['main']['FakturNumberParent']."'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$show['FakturParent'] = $row->FakturParent;
		} else {
			$show['FakturParent'] = 1;
		}

		// echo json_encode($show['detail']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_main($INVID, $INVCategory)
	{
		if ($INVCategory == 1) {
			$sql = "SELECT im.*, dm.DODate, sm.SODate, sc.CategoryName, em.Company2 as sales, 
					c.phone, c.Company2,cs.fullname FROM tb_invoice_main im
					LEFT JOIN tb_do_main dm ON (dm.DOID=im.DOID)
					LEFT JOIN tb_so_main sm ON (sm.SOID=im.SOID)
					LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory)
					LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
					LEFT JOIN tb_customer_main cus ON (cus.CustomerID=im.CustomerID) 
					LEFT JOIN vw_contact1 c ON (c.ContactID=cus.ContactID) 
					LEFT JOIN vw_customer3 cs ON (cs.CustomerID=im.CustomerID)
					WHERE im.INVID=".$INVID;
			$getrow	= $this->db->query($sql);
			$rowmain= $getrow->row();
			$main 	= get_object_vars($rowmain);
		} elseif ($INVCategory == 2) {
			$sql = "SELECT im.*, sm.SODate, sc.CategoryName, em.Company2 as sales, sip.Percent, sip.Amount, 
					c.phone, c.Company2,cs.fullname FROM tb_invoice_main im
					LEFT JOIN tb_so_main sm ON (sm.SOID=im.SOID) 
					LEFT JOIN tb_so_category sc ON (sc.CategoryID=sm.SOCategory) 
					LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
					LEFT JOIN tb_so_inv_percent sip ON (sip.INVID=im.INVID)
					LEFT JOIN tb_customer_main cus ON (cus.CustomerID=im.CustomerID) 
					LEFT JOIN vw_contact1 c ON (c.ContactID=cus.ContactID) 
					LEFT JOIN vw_customer3 cs ON (cs.CustomerID=im.CustomerID)
					WHERE im.INVID=".$INVID;
			$getrow	= $this->db->query($sql);
			$rowmain= $getrow->row();
			$main 	= get_object_vars($rowmain);
			$main['DODate'] = 0;
		}

		$due_date = 0;
		$datediff = 0;
		$due_date = date('Y-m-d', strtotime("+".$main['PaymentTerm']." days", strtotime($main['INVDate'])));

		$now = time();
		$your_date = strtotime($due_date);
		$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
		$main['due_date'] = $due_date;
		$main['datediff'] = $datediff;

		return $main;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_detail($INVID, $INVCategory)
	{
		if ($INVCategory == 1) {
			$sql = "SELECT id.*, drd.DOID, drd.ProductID, COALESCE(drd.ProductQty,id.ProductQty) AS doProductQty, 
					COALESCE(drd.dordProductQty,0) as dorProductQty
					FROM tb_invoice_detail id 
					LEFT JOIN tb_invoice_main im ON (im.INVID=id.INVID) 
					LEFT JOIN vw_do_return_dor2 drd ON (drd.DOID=im.DOID AND id.ProductID=drd.ProductID and id.SalesOrderDetailID=drd.SalesOrderDetailID)
					WHERE id.INVID=".$INVID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$detail[] = array(
					'INVID' => $row->INVID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					'ProductMultiplier' => $row->ProductMultiplier,
					'ProductHPP' => $row->ProductHPP,
					'ProductPriceDefault' => $row->ProductPriceDefault,
					'ProductWeight' => $row->ProductWeight,
					'PromoPercent' => $row->PromoPercent,
					'PTPercent' => $row->PTPercent,
					'PriceAmount' => $row->PriceAmount,
					'FreightCharge' => $row->FreightCharge,
					'PriceTotal' => $row->PriceTotal,
					'doProductQty' => $row->doProductQty,
					'dorProductQty' => $row->dorProductQty,
				);
			};

		} elseif ($INVCategory == 2) {
			$sql = "SELECT id.* FROM tb_invoice_detail id WHERE id.INVID=".$INVID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$detail[] = array(
					'INVID' => $row->INVID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					'ProductMultiplier' => $row->ProductMultiplier,
					'ProductHPP' => $row->ProductHPP,
					'ProductPriceDefault' => $row->ProductPriceDefault,
					'ProductWeight' => $row->ProductWeight,
					'PromoPercent' => $row->PromoPercent,
					'PTPercent' => $row->PTPercent,
					'PriceAmount' => $row->PriceAmount,
					'FreightCharge' => $row->FreightCharge,
					'PriceTotal' => $row->PriceTotal,
				);
			};
		}

		return $detail;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_detail2($INVID, $INVCategory)
	{
		if ($INVCategory == 1) {
			$sql = "SELECT id.* FROM tb_invoice_detail id
					LEFT JOIN tb_invoice_main im ON (im.INVID=id.INVID)
					WHERE id.INVID=".$INVID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$detail[] = array(
					'INVID' => $row->INVID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					'ProductMultiplier' => $row->ProductMultiplier,
					'ProductHPP' => $row->ProductHPP,
					'ProductPriceDefault' => $row->ProductPriceDefault,
					'ProductWeight' => $row->ProductWeight,
					'PromoPercent' => $row->PromoPercent,
					'PTPercent' => $row->PTPercent,
					'PriceAmount' => $row->PriceAmount,
					'FreightCharge' => $row->FreightCharge,
					'PriceTotal' => $row->PriceTotal,
					'doProductQty' => $row->ProductQty,
					'dorProductQty' => 0,
				);
			};

		} elseif ($INVCategory == 2) {
			$sql = "SELECT id.* FROM tb_invoice_detail id WHERE id.INVID=".$INVID;
			$query	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$detail[] = array(
					'INVID' => $row->INVID,
					'ProductID' => $row->ProductID,
					'ProductName' => $row->ProductName,
					'ProductQty' => $row->ProductQty,
					'ProductMultiplier' => $row->ProductMultiplier,
					'ProductHPP' => $row->ProductHPP,
					'ProductPriceDefault' => $row->ProductPriceDefault,
					'ProductWeight' => $row->ProductWeight,
					'PromoPercent' => $row->PromoPercent,
					'PTPercent' => $row->PTPercent,
					'PriceAmount' => $row->PriceAmount,
					'FreightCharge' => $row->FreightCharge,
					'PriceTotal' => $row->PriceTotal,
				);
			};
		}

		return $detail;
		$this->log_user->log_query($this->last_query);
	}
	function do_history()
	{
		$DOID = $this->input->get_post('id');
		$sql 	= "SELECT dd.*, plp.ProductCode, wm.WarehouseName FROM tb_do_detail dd
				LEFT JOIN vw_product_list_popup2 plp ON (dd.ProductID=plp.ProductID) 
				LEFT JOIN tb_warehouse_main wm ON (dd.WareHouseID=wm.WarehouseID)
				WHERE DOID=".$DOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		      'ProductID' => $row->ProductID,
		    'ProductCode' => $row->ProductCode,
		    'ProductQty' => $row->ProductQty,
		    'WarehouseName' => $row->WarehouseName
			);
		}

		$sql 	= "SELECT dm.DORID, dd.*, plp.ProductCode, wm.WarehouseName
				FROM tb_dor_main dm
				LEFT JOIN tb_dor_detail dd ON (dm.DORID=dd.DORID)
				LEFT JOIN vw_product_list_popup2 plp ON (dd.ProductID=plp.ProductID) 
				LEFT JOIN tb_warehouse_main wm ON (dd.WareHouseID=wm.WarehouseID)
				WHERE dm.DORType='DO' and dm.DORReff=".$DOID." order by dd.ProductID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		    'DORID' => $row->DORID,
		    'ProductID' => $row->ProductID,
		    'ProductCode' => $row->ProductCode,
		    'ProductQty' => $row->ProductQty,
		    'WarehouseName' => $row->WarehouseName
			);
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function complete_payment_under()
	{
		$this->db->trans_start();
		$INVID = $this->input->post('INVID');
		$show   = array();

		$sql 	= "select SOID, CustomerID, TotalOutstanding from vw_invoice_balance where INVID=".$INVID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$CustomerID = $row->CustomerID;
		$SOID = $row->SOID;
		$TotalOutstanding = $row->TotalOutstanding;
		$show['SOID'] = $SOID;
		$show['CustomerID'] = $CustomerID;
		$show['TotalOutstanding'] = $TotalOutstanding;

		$sql 	= "select DepositID, CustomerID, TotalBalance from vw_deposit_balance where TotalBalance>0 and CustomerID=".$CustomerID;
		$getrow = $this->db->query($sql);
		$countDepositFree = $getrow->num_rows();

		if ($TotalOutstanding<100 && $countDepositFree<1) {
			$show['result'] = "succes";
			$sql 	= "SELECT cp.DepositID, cd.SourceReff, bt.BankTransactionDate
						FROM tb_customer_payment cp
						LEFT JOIN tb_customer_deposit cd ON cp.DepositID=cd.DepositID
						LEFT JOIN tb_bank_transaction bt ON cd.SourceReff=bt.BankTransactionID
						WHERE cp.INVID=".$INVID." ORDER BY bt.BankTransactionDate DESC LIMIT 1";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$DepositID = $row->DepositID;

			$sql 	= "SELECT MAX(BankTransactionID) AS BankTransactionID, MAX(BankTransactionDate) AS BankTransactionDate
						FROM tb_bank_transaction WHERE DATE(BankTransactionDate)='".date("Y-m-d", strtotime($row->BankTransactionDate))."'";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$BankTransactionID = $row->BankTransactionID+1;
			$BankTransactionDate = $row->BankTransactionDate;

			$show['DepositID'] = $DepositID;
			$show['BankTransactionID'] = $BankTransactionID;
			$show['BankTransactionDate'] = $BankTransactionDate;

	        $this->load->model('model_finance');
			$this->model_finance->bank_transaction_add_under($INVID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
			$this->model_finance->confirmation_deposit_distribution_act_under($SOID, $INVID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
		} else {
			$show['result'] = "fail";
		}
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function get_inv_outstanding($CustomerID)
	{
		$invlate = array();
		$sql 	= "SELECT * FROM vw_invoice_balance vsb WHERE CustomerID=".$CustomerID." AND TotalOutstanding>0 order by INVID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$INVTotal = number_format($row->INVTotal,2);
			$TotalPayment = number_format($row->TotalPayment,2);
			$TotalOutstanding = number_format($row->TotalOutstanding,2);
			$TotalPaymentPerc = $this->get_percent($row->INVTotal, $row->TotalPayment);

			$due_date = date('Y-m-d', strtotime($row->due_date));
			$now = time();
			$your_date = strtotime($due_date);
			$datediff = round( ($your_date - $now) / (60 * 60 * 24) );
			$datediff = $datediff * -1;
			
			$invlate[] = array(
		  		'INVID' => $row->INVID,
		  		'SOID' => $row->SOID,
				'INVDate' => $row->INVDate,
				'PaymentTerm' => $row->PaymentTerm,
				'due_date' => $row->due_date,
				'late_date' => $datediff,
				'INVTotal' => $INVTotal,
				'TotalPayment' => $TotalPayment,
				'TotalPaymentPerc' => $TotalPaymentPerc,
				'TotalOutstanding' => $TotalOutstanding
			);
		}
		return $invlate;
	}
	function get_last_faktur_number_tax()
	{

		$sql 	= "select INVID, INVInput, FakturNumber, FakturNumberParent from tb_invoice_main order by INVID desc limit 1 ";
		$getrow = $this->db->query($sql);
		$row2 	= $getrow->row();
		if (!empty($row2)) {

			$sql 	= "select FakturID, FakturParent, FakturDate, FakturNumberMin, FakturNumberMax from tb_faktur_number where FakturID=".$row2->FakturNumberParent."";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			if (!empty($row)) {
				$FakturID = $row->FakturID;
				$FakturParent = $row->FakturParent;
				$FakturDate = $row->FakturDate;
				$FakturNumberMin = $row->FakturNumberMin;
				$FakturNumberMax = $row->FakturNumberMax;

				if ($row2->FakturNumber+1 > $FakturNumberMax) {
					$sql 	= "select FakturID, FakturParent, FakturDate, FakturNumberMin, FakturNumberMax from tb_faktur_number order by FakturID desc limit 1 ";
					$getrow = $this->db->query($sql);
					$row 	= $getrow->row();
					$FakturID = $row->FakturID;
					$FakturParent = $row->FakturParent;
					$FakturDate = $row->FakturDate;
					$FakturNumberMin = $row->FakturNumberMin;
					$FakturNumberMax = $row->FakturNumberMax;

					if ($row2->FakturNumberParent != $FakturParent) {
						$FakturNumber = $FakturNumberMin;
					} else {
						if ($row2->FakturNumber+1 > $FakturNumberMax) {
							$FakturNumber = 0;
						} else {
							$FakturNumber = $row2->FakturNumber+1;
						}
					}
				} else {
					if (!empty($row2)) {
						if ($row2->FakturNumber+1 > $FakturNumberMax) {
							$FakturNumber = 0;
						} else {
							$FakturNumber = $row2->FakturNumber+1;
						}
					} else {
						$FakturNumber = $FakturNumberMin;
					}
				}
			} else {
				$FakturID = 1;
				$FakturParent = 1;
				$FakturNumber = 1;
			}
		} else {
			$FakturID = 1;
			$FakturParent = 1;
			$FakturNumber = 1;
		}

		return array($FakturID, $FakturParent, $FakturNumber);
	}

//invoice retur=============================================================
	function detail_to_invoice_retur()
	{
		$sql = "SELECT dm.*, im.*, se.Company2 as sales, c.Company2 as customer
				FROM vw_dor_qty dm
				LEFT JOIN tb_invoice_main im ON dm.DORReff=im.INVID AND dm.DORType='INV'
				LEFT JOIN vw_sales_executive2 se ON im.SalesID=se.SalesID
				LEFT JOIN vw_customer3 c ON im.CustomerID=c.CustomerID
				WHERE dm.DORType='INV' AND dm.DORID not IN (
					SELECT DORID FROM tb_invoice_retur_main
				) and DORQty>0";
		$query 	= $this->db->query($sql);
		// echo $sql;
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'DORID' => $row->DORID,
		  			'INVID' => $row->INVID,
					'Customer' => $row->customer,
					'Sales' => $row->sales,
					'Date' => $row->DORDate,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function dor_to_inv_retur_detail()
	{
		$DORID 	= $this->input->get_post('dor');

		$sql 	= "SELECT dm.*, im.*, se.Company2 as sales, CONCAT(fn.FakturParent,im.FakturNumber) as FakturNumber 
					FROM tb_dor_main dm
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
		$sql 	= "SELECT dd.DORID, dd.ProductQty as qtyreceived, id.* FROM tb_dor_detail dd
					LEFT JOIN tb_dor_main dm ON dd.DORID=dm.DORID
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

		// echo json_encode($show);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_retur_add_act()
	{
		$this->db->trans_start();

		$DORID = $this->input->post('DORID');
		$INVID = $this->input->post('INVID');
		$FakturNumber = $this->input->post('FakturNumber');
		$date = $this->input->post('date');
		$fc = $this->input->post('fc');
		$note = $this->input->post('note');
		$ProductID 		= $this->input->post('ProductID');
		$ProductName 	= $this->input->post('ProductName');
		$qtyreceived 	= $this->input->post('qtyreceived');
		$ProductMultiplier = $this->input->post('ProductMultiplier');
		$ProductHPP = $this->input->post('ProductHPP');
		$ProductWeight = $this->input->post('ProductWeight');
		$ProductPriceDefault = $this->input->post('ProductPriceDefault');
		$PromoPercent 	= $this->input->post('PromoPercent');
		$PTPercent 		= $this->input->post('PTPercent');
		$PriceAmount 	= $this->input->post('PriceAmount');
		$linetotal 		= $this->input->post('linetotal');
		$FreightCharge 	= $this->input->post('FreightCharge');
		$FCInclude 		= $this->input->post('FCInclude');
		$TaxFC 		= $this->input->post('TaxFC');
		$FCExclude 	= $this->input->post('FCExclude');
		$TotalFC 	= $this->input->post('TotalFC');
		$PriceBefore = $this->input->post('PriceBefore');
		$TaxPrice 	= $this->input->post('TaxPrice');
		$TotalPrice = $this->input->post('TotalPrice');
		$TotalInvoiceRetur = $this->input->post('TotalInvoiceRetur');
		$datetime = date('Y-m-d H:i:s');

		$sql 	= "SELECT DORID from tb_invoice_retur_main where DORID = '".$DORID."'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (empty($row)) {

			// jika fc tidak di retur
			if (!isset($fc)) { 
				$FCInclude 	= 0;
				$TaxFC 		= 0;
				$FCExclude 	= 0;
				$TotalFC 	= 0;
			}

			$sql 	= "SELECT dm.*, im.*, sm2.SEPVMp FROM tb_dor_main dm
					LEFT JOIN tb_invoice_main im ON (im.INVID=dm.DORReff and dm.DORType='INV')
					LEFT JOIN tb_so_main sm ON (sm.SOID=im.SOID)
					LEFT JOIN tb_so_main2 sm2 ON (sm2.SOID=im.SOID)
					WHERE dm.DORID=".$DORID;
			$getrow	= $this->db->query($sql);
			$rowmain= $getrow->row();
			$SEPVMp = $rowmain->SEPVMp;
			$main 	= get_object_vars($rowmain);

			$datamain = array(
				'DORID' => $DORID,
				'INVID' => $INVID,
				'CustomerID' => $main['CustomerID'],
				'SalesID' => $main['SalesID'],
				'SECID' => $main['SECID'],
				'BillingAddress' => $main['BillingAddress'],
				'ShipAddress' => $main['ShipAddress'],
				'TaxAddress' => $main['TaxAddress'],
				'NPWP' => ($main['NPWP'] == null) ? '0' : $main['NPWP'],
				'FakturNumber' => $FakturNumber,
				'INVRDate' => $date,
				'INVRNote' => $note,
				'TaxRate' => $main['TaxRate'],
				'FCInclude' => $FCInclude,
				'FCTax' => $TaxFC,
				'FCExclude' => $FCExclude,
				'FCTotal' => $TotalFC,
				'PriceBeforeTax' => $PriceBefore,
				'PriceTax' => $TaxPrice,
				'PriceTotal' => $TotalPrice,
				'INVRTotal' => $TotalInvoiceRetur,
				'INVRInput' => $datetime,
				'INVRBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_invoice_retur_main', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "SELECT max(INVRID) as INVRID from tb_invoice_retur_main ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$INVRID = $row->INVRID;

			$sql 	= "SELECT PV from tb_site_config ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$PV 	= $row->PV;

			$DORAmount = 0;
			for ($i=0; $i < count($ProductID);$i++) { 
				if ($qtyreceived[$i] >0) {
					// jika fc tidak di retur
					if (!isset($fc)) { 
						$FreightCharge[$i] = 0;
					}

					$datadetail = array(
						'INVRID' => $INVRID,
						'ProductID' => $ProductID[$i],
						'ProductName' => $ProductName[$i],
						'ProductQty' => $qtyreceived[$i],
						'ProductMultiplier' => $ProductMultiplier[$i],
						'ProductHPP' => $ProductHPP[$i],
						'ProductPriceDefault' => $ProductPriceDefault[$i],
						'ProductWeight' => $ProductWeight[$i],
						'PromoPercent' => $PromoPercent[$i],
						'PTPercent' => $PTPercent[$i],
						'PriceAmount' => $PriceAmount[$i],
						'FreightCharge' => $FreightCharge[$i],
						'PriceTotal' => $linetotal[$i],
						'PV' => (($PriceAmount[$i]-$ProductHPP[$i])/$PV)*$SEPVMp
					);
					$this->db->insert('tb_invoice_retur_detail', $datadetail);
					$this->last_query .= "//".$this->db->last_query();

					$DORAmount += $ProductHPP[$i]*$qtyreceived[$i];
				}
			}
		}

        $this->load->model('model_finance');
		$this->model_finance->customer_deposit_add_from_retur($INVRID, $main['CustomerID'], $TotalInvoiceRetur); 

		// ----------------------------------------------
		$FCAmount = $FCInclude + $FCExclude;
		$this->load->model('model_acc');
		$this->model_acc->auto_journal_invr($INVRID, $DORID, $TotalInvoiceRetur, $TaxPrice, $FCAmount, $DORAmount);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function invoice_retur_list()
	{
		$sql = "SELECT im.*, se.Company2 as sales, c.Company2 as customer
				FROM tb_invoice_retur_main im 
				LEFT JOIN vw_sales_executive2 se ON im.SalesID=se.SalesID
				LEFT JOIN vw_customer3 c ON im.CustomerID=c.CustomerID ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "where im.INVRDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
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
			$sql .= "GROUP BY im.INVRID ";
		} else { 
			$sql .= "GROUP BY im.INVRID order by im.INVRID desc limit ".$this->limit_result." ";
		}
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'INVRID' => $row->INVRID,
				'INVID' => $row->INVID,
				'DORID' => $row->DORID,
				'customer' => $row->customer,
				'sales' => $row->sales,
				'INVRDate' => $row->INVRDate,
				'INVRNote' => $row->INVRNote,
				'PriceTotal' => $row->PriceTotal,
				'FCTotal' => $row->FCTotal,
				'INVRTotal' => $row->INVRTotal,
				'FakturNumber' => $row->FakturNumber,
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function print_invoice_retur()
	{
		$INVRID = $this->input->get_post('id');
		$show['main'] = $this->invoice_retur_main($INVRID);
		$show['detail'] = $this->invoice_retur_detail($INVRID);

		// echo json_encode($show['detail']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function print_faktur_retur()
	{
		$INVRID = $this->input->get_post('id');

		$show['main'] = $this->invoice_retur_main($INVRID);
		$show['detail'] = $this->invoice_retur_detail($INVRID);

		$show['FakturParent'] = "";
		// echo json_encode($show['detail']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_retur_main($INVRID)
	{
		$sql = "SELECT im.*, dm.*, em.Company2 as sales, w.WarehouseName, w.WarehouseAddress, 
				c.phone, c.Company2 as customer, im2.INVDate FROM tb_invoice_retur_main im
				LEFT JOIN tb_dor_main dm ON (dm.DORID=im.DORID)
				LEFT JOIN tb_invoice_main im2 ON (im.INVID=im2.INVID)
				LEFT JOIN vw_sales_executive2 em ON (em.SalesID=im.SalesID) 
				LEFT JOIN tb_customer_main cus ON (cus.CustomerID=im.CustomerID) 
				LEFT JOIN vw_contact1 c ON (c.ContactID=cus.ContactID) 
				LEFT JOIN tb_warehouse_main w ON (dm.WarehouseID=w.WarehouseID) 
				WHERE im.INVRID=".$INVRID;
		$getrow	= $this->db->query($sql);
		$rowmain= $getrow->row();
		$main 	= get_object_vars($rowmain);
		return $main;
		$this->log_user->log_query($this->last_query);
	}
	function invoice_retur_detail($INVRID)
	{
		$sql = "SELECT id.* FROM tb_invoice_retur_detail id WHERE id.INVRID=".$INVRID;
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$detail[] = array(
				'INVRID' => $row->INVRID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductQty' => $row->ProductQty,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductHPP' => $row->ProductHPP,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductWeight' => $row->ProductWeight,
				'PromoPercent' => $row->PromoPercent,
				'PTPercent' => $row->PTPercent,
				'PriceAmount' => $row->PriceAmount,
				'FreightCharge' => $row->FreightCharge,
				'PriceTotal' => $row->PriceTotal,
				'PV' => $row->PV
			);
		};

		return $detail;
		$this->log_user->log_query($this->last_query);
	}

//stock opname =============================================================
	function product_stock_opname_list()
	{
		$filterstart = isset($_REQUEST['filterstart']) ? date('Y-m-01', strtotime($_REQUEST['filterstart'])) : date('d-m-Y');
		$filterend = isset($_REQUEST['filterend']) ? date('Y-m-t', strtotime($_REQUEST['filterend'])) : date('d-m-Y');

		$sql = "SELECT so.*, em.fullname, wm.WarehouseName FROM tb_product_stock_opname so 
				LEFT JOIN vw_user_account em ON (so.OpnameBy=em.UserAccountID)
				LEFT JOIN tb_warehouse_main wm ON (so.WarehouseID=wm.WarehouseID)";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= " Where OpnameDate between '".$filterstart." 00:00:00' and '".$filterend." 23:59:59' ";
		} else {$sql .= " Where MONTH(OpnameDate)=MONTH(CURRENT_DATE()) AND YEAR(OpnameDate)=YEAR(CURRENT_DATE()) ";}	
				// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'OpnameID' => $row->OpnameID,
				'WarehouseName' => $row->WarehouseName,
				'OpnameDate' => $row->OpnameDate,
				'OpnameNote' => $row->OpnameNote,
				'OpnameInput' => $row->OpnameInput,
				'OpnameBy' => $row->fullname
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_stock_opname_add()
	{
		$this->db->trans_start();

		$date = $this->input->post('dateopname');
		$note = $this->input->post('noteopname');
		$warehouse = $this->input->post('warehouse');
		$date2 = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$sql 	= "SELECT pso.OpnameID, COALESCE(psa.AdjustmentID,0) as AdjustmentID, 
					COALESCE(psa.isApprove,1) as isApprove FROM tb_product_stock_opname pso 
					LEFT JOIN tb_product_stock_adjustment psa ON (psa.OpnameID=pso.OpnameID) 
					WHERE WarehouseID=".$warehouse." ORDER BY pso.OpnameID desc limit 1";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$OpnameID = $row->OpnameID;
		$isApprove = $row->isApprove;

		// jika ada opname sebelumnya dengan adjustment yg belum selesai
		if (!empty($row) && $isApprove == 1 || empty($row)) {
			// echo "string";
			$datamain = array(
				'WarehouseID' => $warehouse,
				'OpnameDate' => $date,
				'OpnameNote' => $note,
				'OpnameInput' => $datetime,
				'OpnameBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_product_stock_opname', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select max(OpnameID) as OpnameID from tb_product_stock_opname ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$OpnameID = $row->OpnameID;

			if ($date < $date2) {
				$sql = "SELECT psm.*, COALESCE(SUM(QtyIn),0) AS QtyIn, COALESCE(SUM(QtyOut),0) as QtyOut, 
						psm.Quantity-(COALESCE(SUM(QtyIn),0)-COALESCE(SUM(QtyOut),0)) as QtyOld, pm.ProductPriceHPP 
						FROM tb_product_stock_main psm
						LEFT JOIN vw_stock_flow_daily sfd ON (psm.ProductID=sfd.ProductID and psm.WarehouseID=sfd.WarehouseID)
						LEFT JOIN tb_product_main pm ON (pm.ProductID=psm.ProductID)
						WHERE sfd.DateReff > '".$date."'
						AND psm.WarehouseID=".$warehouse." 
						GROUP BY psm.ProductID, psm.WarehouseID";
			} else {
				$sql = "SELECT psm.*, psm.Quantity as QtyOld, pm.ProductPriceHPP 
						FROM tb_product_stock_main psm
						LEFT JOIN tb_product_main pm ON (pm.ProductID=psm.ProductID)
						WHERE psm.WarehouseID=".$warehouse." 
						GROUP BY psm.ProductID, psm.WarehouseID";
			}
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$detail[] = array(
					'OpnameID' => $OpnameID,
					'ProductID' => $row->ProductID,
					'WarehouseID' => $row->WarehouseID,
					'Quantity' => $row->QtyOld,
					'ProductPriceHPP' => $row->ProductPriceHPP
				);
			};
			$this->db->insert_batch('tb_product_stock_opname_detail', $detail);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function product_stock_opname_detail()
	{
		$OpnameID = $this->input->get_post('id');
		$show   = array();
		$sql = "SELECT so.*, em.fullname, wm.WarehouseName FROM tb_product_stock_opname so 
				LEFT JOIN vw_user_account em ON (so.OpnameBy=em.UserAccountID)
				LEFT JOIN tb_warehouse_main wm ON (so.WarehouseID=wm.WarehouseID)
				where OpnameID=".$OpnameID;
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'] = array(
				'OpnameID' => $row->OpnameID,
				'WarehouseName' => $row->WarehouseName,
				'OpnameDate' => $row->OpnameDate,
				'OpnameNote' => $row->OpnameNote,
				'OpnameInput' => $row->OpnameInput,
				'OpnameBy' => $row->fullname
			);
		};

        $this->load->model('model_master');
        $categoryFull = $this->model_master->get_full_category(); //select from db
        $brandFull = $this->model_master->get_full_brand(); //select from db

		$sql = "SELECT sod.*, pm.ProductCode, pm.ProductName, wm.WarehouseName, plp.ProductCategoryID, plp.ProductCategoryName,
				plp.ProductBrandID, plp.ProductBrandName, psad.OpnameQty, COALESCE(psad.ProductQty,0) as AdjustQty, COALESCE(pad.AtributeValue,'STD') as ProductSTD
				FROM tb_product_stock_opname_detail sod
				LEFT JOIN tb_product_main pm ON (sod.ProductID=pm.ProductID)
				LEFT JOIN tb_warehouse_main wm ON (sod.WarehouseID=wm.WarehouseID)
				LEFT JOIN vw_product_list_popup2 plp ON (sod.ProductID = plp.ProductID)
				LEFT JOIN tb_product_stock_adjustment psa ON (sod.OpnameID = psa.OpnameID)
				LEFT JOIN tb_product_stock_adjustment_detail psad ON (psa.AdjustmentID = psad.AdjustmentID and sod.ProductID=psad.ProductID and psad.isApprove!=0)
				LEFT JOIN (select ProductID, AtributeValue from tb_product_atribute_detail where ProductAtributeID=16 ) pad ON (sod.ProductID = pad.ProductID)
				where sod.OpnameID=".$OpnameID." order by Quantity=0, ProductID asc";
			// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
				'OpnameID' => $row->OpnameID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'WarehouseID' => $row->WarehouseID,
				'Quantity' => $row->Quantity,
				'ProductPriceHPP' => $row->ProductPriceHPP,
				'WarehouseName' => $row->WarehouseName,
				'ProductCode' => $row->ProductCode,
				'ProductCategoryName' => $categoryFull[$row->ProductCategoryID]['ProductCategoryName'],
				'ProductBrandName' => $brandFull[$row->ProductBrandID]['ProductBrandName'],
				'AdjustQty' => $row->AdjustQty,
				'ProductSTD' => $row->ProductSTD
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_stock_opname_detail2()
	{
		$OpnameID = $this->input->get_post('id');
		$show   = array();
		$sql = "SELECT so.*, em.fullname, wm.WarehouseName FROM tb_product_stock_opname so 
				LEFT JOIN vw_user_account em ON (so.OpnameBy=em.UserAccountID)
				LEFT JOIN tb_warehouse_main wm ON (so.WarehouseID=wm.WarehouseID)
				where OpnameID=".$OpnameID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'] = array(
				'OpnameID' => $row->OpnameID,
				'WarehouseName' => $row->WarehouseName,
				'OpnameDate' => $row->OpnameDate,
				'OpnameNote' => $row->OpnameNote,
				'OpnameInput' => $row->OpnameInput,
				'OpnameBy' => $row->fullname
			);
			$WarehouseID = $row->WarehouseID;
		};

        $this->load->model('model_master');
        $categoryFull = $this->model_master->get_full_category(); //select from db
        $brandFull = $this->model_master->get_full_brand(); //select from db

		// $sql = "SELECT t1.ProductID, t1.ProductCode, t1.ProductCategoryID, t1.ProductBrandID, 
		// 		t2.OpnameID, t2.WarehouseID, COALESCE(t2.Quantity,0) as Quantity 
		// 		FROM tb_product_main t1
		// 		LEFT JOIN (
		// 		SELECT sod.*, wm.WarehouseName, psad.OpnameQty, COALESCE(psad.ProductQty,0) as AdjustQty
		// 		FROM tb_product_stock_opname_detail sod 
		// 		LEFT JOIN tb_warehouse_main wm ON (sod.WarehouseID=wm.WarehouseID)
		// 		LEFT JOIN tb_product_stock_adjustment psa ON (sod.OpnameID = psa.OpnameID)
		// 		LEFT JOIN tb_product_stock_adjustment_detail psad ON (psa.AdjustmentID = psad.AdjustmentID and sod.ProductID=psad.ProductID)
		// 		where sod.OpnameID=".$OpnameID." order by Quantity=0, ProductID asc
		// 		) t2 ON t1.ProductID=t2.ProductID where t1.isActive=1";

		$sql = "SELECT pm.ProductID, pm.ProductCode, pm.ProductCategoryID, pm.ProductBrandID,
				sod.OpnameID, wm.WarehouseName, COALESCE(sod.Quantity,0) as Quantity
				FROM tb_product_stock_opname_detail sod
				LEFT JOIN tb_product_main pm ON (sod.ProductID=pm.ProductID)
				LEFT JOIN tb_warehouse_main wm ON (sod.WarehouseID=wm.WarehouseID)
				LEFT JOIN tb_product_stock_adjustment psa ON (sod.OpnameID = psa.OpnameID)
				LEFT JOIN tb_product_stock_adjustment_detail psad ON (psa.AdjustmentID = psad.AdjustmentID and sod.ProductID=psad.ProductID and psad.isApprove!=0)
				where sod.OpnameID=".$OpnameID." AND pm.isActive=1

				UNION ALL

				SELECT pm.ProductID, pm.ProductCode, pm.ProductCategoryID, pm.ProductBrandID,
				NULL, NULL, 0 FROM tb_product_main pm 
				WHERE pm.ProductID NOT IN (SELECT sod.ProductID FROM tb_product_stock_opname_detail sod WHERE sod.OpnameID=".$OpnameID.")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
				'OpnameID' => $row->OpnameID,
				'WarehouseID' => $WarehouseID,
				'ProductID' => $row->ProductID,
				'ProductCode' => $row->ProductCode,
				'Quantity' => $row->Quantity,
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

//stock adjustment =========================================================
	function stock_adjustment_add_act()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$AdjustmentID = $this->input->post('adjustmentid');
		$OpnameID = $this->input->post('opnameid');
		$date = $this->input->post('date');
		$note = $this->input->post('note');
		$ProductID = $this->input->post('productid');
		$WarehouseID = $this->input->post('warehouseid');
		$adjustment = $this->input->post('adjustment');
		$diff = $this->input->post('diff');
		$note2 = $this->input->post('note2');
		$datetime = date('Y-m-d H:i:s');

		$datamain = array(
			'OpnameID' => $OpnameID,
			'AdjustmentDate' => $date,
			'AdjustmentNote' => $note,
			'AdjustmentInput' => $datetime,
			'AdjustmentBy' => $this->session->userdata('UserAccountID')
		);
		if ($AdjustmentID != "") {
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->update('tb_product_stock_adjustment', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->delete('tb_product_stock_adjustment_detail');
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$this->db->insert('tb_product_stock_adjustment', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select max(AdjustmentID) as AdjustmentID from tb_product_stock_adjustment ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$AdjustmentID 	= $row->AdjustmentID;
		}

		for ($i=0; $i < count($ProductID);$i++) {
			// if ($adjustment[$i] != 0 ) {
				$datadetail = array(
					'AdjustmentID' => $AdjustmentID,
					'ProductID' => $ProductID[$i],
					'WarehouseID' => $WarehouseID[$i],
					'OpnameQty' => $adjustment[$i],
					'ProductQty' => $diff[$i],
					'Note' => $note2[$i]
				);
				$this->db->insert('tb_product_stock_adjustment_detail', $datadetail);
				$this->last_query .= "//".$this->db->last_query();
			 // } 
		}

		// add if product not in stock opname
		$sql = "SELECT sd.ProductID, sd.WarehouseID, pm.ProductPriceHPP FROM tb_product_stock_adjustment_detail sd
				LEFT JOIN tb_product_main pm ON (pm.ProductID=sd.ProductID)
				where sd.AdjustmentID=".$AdjustmentID." and sd.ProductID not in (
				select ProductID from tb_product_stock_opname_detail where OpnameID=".$OpnameID."
				)";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			foreach ($query->result() as $row) {
			  	$detail[] = array(
					'OpnameID' => $OpnameID,
					'ProductID' => $row->ProductID,
					'WarehouseID' => $row->WarehouseID,
					'Quantity' => 0,
					'ProductPriceHPP' => $row->ProductPriceHPP
				);
			};
			$this->db->insert_batch('tb_product_stock_opname_detail', $detail);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function stock_adjustment_edit()
	{
		$this->db->trans_start();

		$AdjustmentID = $this->input->get_post('id');
		$show   = array();

		$sql = "SELECT sa.*, so.WarehouseID FROM tb_product_stock_adjustment sa 
				LEFT JOIN tb_product_stock_opname so ON (so.OpnameID=sa.OpnameID)
				where AdjustmentID=".$AdjustmentID;
		$query 	= $this->db->query($sql);
		$rowmain= $query->row();
		$show['main'] = get_object_vars($rowmain);

		$sql = "SELECT sad.*, pm.ProductCode, sod.Quantity
				FROM tb_product_stock_adjustment_detail sad 
				LEFT JOIN tb_product_stock_adjustment sa ON (sad.AdjustmentID=sa.AdjustmentID)
				LEFT JOIN tb_product_stock_opname_detail sod ON (sod.OpnameID=sa.OpnameID AND sod.ProductID=sad.ProductID)
				LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
				where sad.AdjustmentID=".$AdjustmentID;
				// where sad.AdjustmentID=".$AdjustmentID." order by sod.Quantity=0, sad.ProductID asc";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
				'ProductID' => $row->ProductID,
				'WarehouseID' => $row->WarehouseID,
				'Quantity' => $row->Quantity,
				'OpnameQty' => $row->OpnameQty,
				'ProductQty' => $row->ProductQty,
				'Note' => $row->Note,
				'ProductCode' => $row->ProductCode
			);
		};
		$show['detail2'] = json_encode($show['detail']);
	    return $show;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

	function stock_adjustment_add_non_opname_act()
	{
		$this->db->trans_start();
		$AdjustmentID = $this->input->post('adjustmentid');
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
			'OpnameID' => 0,
			'AdjustmentDate' => $date,
			'AdjustmentNote' => $note,
			'AdjustmentInput' => $datetime,
			'AdjustmentBy' => $this->session->userdata('UserAccountID')
		);
		if ($AdjustmentID != "") {
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->update('tb_product_stock_adjustment', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->delete('tb_product_stock_adjustment_detail');
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$this->db->insert('tb_product_stock_adjustment', $datamain);
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "select max(AdjustmentID) as AdjustmentID from tb_product_stock_adjustment ";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$AdjustmentID 	= $row->AdjustmentID;
		}

		for ($i=0; $i < count($ProductID);$i++) {
			// if ($adjustment[$i] != 0 ) {
				$datadetail = array(
					'AdjustmentID' => $AdjustmentID,
					'ProductID' => $ProductID[$i],
					'WarehouseID' => $WarehouseID[$i],
					'OpnameQty' => $OpnameQty[$i],
					'ProductQty' => $diff[$i],
					'Note' => $note2[$i]
				);
				$this->db->insert('tb_product_stock_adjustment_detail', $datadetail);
				$this->last_query .= "//".$this->db->last_query();
			 // } 
		}
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

	function stock_adjustment_edit_non_opname()
	{
		$AdjustmentID = $this->input->get_post('id');
		$show   = array();

		$sql = "SELECT sa.* FROM tb_product_stock_adjustment sa where AdjustmentID=".$AdjustmentID;
		$query 	= $this->db->query($sql);
		$rowmain= $query->row();
		$show['main'] = get_object_vars($rowmain);

		$sql = "SELECT sad.*, pm.ProductCode, coalesce(sm.Quantity,0) as Quantity 
				FROM tb_product_stock_adjustment_detail sad 
				LEFT JOIN tb_product_stock_adjustment sa ON (sad.AdjustmentID=sa.AdjustmentID)
				LEFT JOIN tb_product_stock_main sm ON (sm.ProductID=sad.ProductID AND sm.WarehouseID=sad.WarehouseID)
				LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
				where sad.AdjustmentID=".$AdjustmentID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
				'ProductID' => $row->ProductID,
				'WarehouseID' => $row->WarehouseID,
				'Quantity' => $row->Quantity,
				'OpnameQty' => $row->OpnameQty,
				'ProductQty' => $row->ProductQty,
				'Note' => $row->Note,
				'ProductCode' => $row->ProductCode
			);
			$show['main']['WarehouseID'] = $row->WarehouseID;
		};
		$show['detail2'] = json_encode($show['detail']);
	    return $show;
	} 

	function stock_adjustment_list()
	{
		$filterstart = isset($_REQUEST['filterstart']) ? date('Y-m-01', strtotime($_REQUEST['filterstart'])) : date('d-m-Y');
		$filterend = isset($_REQUEST['filterend']) ? date('Y-m-t', strtotime($_REQUEST['filterend'])) : date('d-m-Y');
		$sql = "SELECT psa.*, em.fullname, asd.ApprovalID FROM tb_product_stock_adjustment psa
				LEFT JOIN vw_user_account em ON (psa.AdjustmentBy=em.UserAccountID)
				LEFT JOIN tb_approval_stock_adjustment asd ON (psa.AdjustmentID=asd.AdjustmentID)
				";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= " Where AdjustmentDate between '".$filterstart." 00:00:00' and '".$filterend." 23:59:59' ";
		} else {$sql .= " Where MONTH(AdjustmentDate)=MONTH(CURRENT_DATE()) AND YEAR(AdjustmentDate)=YEAR(CURRENT_DATE()) ";}		
		$sql.=" order by psa.AdjustmentID desc";	
				// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
				'AdjustmentID' => $row->AdjustmentID,
				'OpnameID' => $row->OpnameID,
				'AdjustmentDate' => $row->AdjustmentDate,
				'AdjustmentNote' => $row->AdjustmentNote,
				'AdjustmentInput' => $row->AdjustmentInput,
				'AdjustmentBy' => $row->AdjustmentBy,
				'isApprove' => $row->isApprove,
				// 'StockCheck' => $row->StockCheck,
				'ApprovalID' => $row->ApprovalID,
				'fullname' => $row->fullname
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

	function stock_adjustment_detail()
	{
		$AdjustmentID = $this->input->get_post('id');

		$sql 	= "select OpnameID from tb_product_stock_adjustment where AdjustmentID=".$AdjustmentID;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$OpnameID 	= $row->OpnameID;

		if ($OpnameID != '0') {
			$sql = "SELECT sad.*, pm.ProductCode, wm.WarehouseName, sod.Quantity AS QtyOpname 
					FROM tb_product_stock_adjustment_detail sad
					LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
					LEFT JOIN tb_warehouse_main wm ON (sad.WarehouseID=wm.WarehouseID)
					LEFT JOIN tb_product_stock_adjustment sa ON sad.AdjustmentID=sa.AdjustmentID
					LEFT JOIN tb_product_stock_opname_detail sod ON sa.OpnameID=sod.OpnameID AND sad.ProductID=sod.ProductID
					where sad.AdjustmentID=".$AdjustmentID;
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
					FROM tb_product_stock_adjustment_detail sad
					LEFT JOIN tb_product_main pm ON (sad.ProductID=pm.ProductID)
					LEFT JOIN tb_warehouse_main wm ON (sad.WarehouseID=wm.WarehouseID)
					where sad.AdjustmentID=".$AdjustmentID;
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

	function stock_adjustment_approval_submission()
	{
		$this->db->trans_start();
		
		$AdjustmentID = $this->input->get_post('AdjustmentID');

		$this->db->where('AdjustmentID', $AdjustmentID);
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
					'Title' => "Approval for Stock Adjustment ".$AdjustmentID,
					'isComplete' => 0,
					'Status' => "OnProgress"
				);
				$this->db->insert('tb_approval_stock_adjustment', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			} else {
				$data_approval = array(
					'AdjustmentID' => $AdjustmentID,
					'Title' => "Approval for Stock Adjustment ".$AdjustmentID,
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
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

	function stock_adjustment_cancel()
	{
		$this->db->trans_start();

		$AdjustmentID = $this->input->post('AdjustmentID'); 

		$sql 	= "SELECT ApprovalID FROM tb_approval_stock_adjustment WHERE AdjustmentID = ".$AdjustmentID;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();

		if (empty($row)) {
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->delete('tb_product_stock_adjustment');
			$this->last_query .= "//".$this->db->last_query();
			
			$this->db->where('AdjustmentID', $AdjustmentID);
			$this->db->delete('tb_product_stock_adjustment_detail');
			$this->last_query .= "//".$this->db->last_query();
		} 

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

//stock check ==============================================================

//adjust_stock_history =====================================================
	function adjust_stock_history_act()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$type	= $this->input->post('type');
		$reff	= $this->input->post('reff');
		$product= $this->input->post('product');
		$parent = $this->input->post('parent');
		$history= $this->input->post('history');
		$qtyNew	= $this->input->post('qty');
		
		if ($type == "DOR") {
			$sql 	= "select * from tb_product_stock_in where NoReff='".$type.$reff."' and ProductID=".$product." and StockInID=".$history;
			$getDate = $this->db->query($sql);
			$row 	= $getDate->row();
			if (!empty($row)) {
				$StockInID = $row->StockInID;
				$Date = $row->CreatedDate;
				$WarehouseID = $row->WarehouseID;
				$qtyOld = $row->QuantityIn;
				$QuantityStock = $row->QuantityStock;

				$this->db->set('ProductQty', $qtyNew);
				$this->db->where('ProductID', $product);
				$this->db->where('DORID', $reff);
				$this->db->update('tb_dor_detail');
				$this->last_query .= "//".$this->db->last_query();

				$this->db->set('QuantityIn', $qtyNew);
				$this->db->where('StockInID', $StockInID);
				// $this->db->where('NoReff', "DOR".$reff);
				// $this->db->where('ProductID', $product);
				$this->db->update('tb_product_stock_in');
				$this->last_query .= "//".$this->db->last_query();
				
				$this->stock_history_arrange($product, $qtyNew, $qtyOld, $WarehouseID, "DOR", $reff, $StockInID);
			}
			
		} elseif ($type == "DO") {
			$sql 	= "select * from tb_product_stock_out where NoReff='".$type.$reff."' and ProductID=".$product." and StockOutID=".$history;
			$getDate = $this->db->query($sql);
			$row 	= $getDate->row();
			if (!empty($row)) {
				$StockOutID = $row->StockOutID;
				$Date = $row->CreatedDate;
				$WarehouseID = $row->WarehouseID;
				$qtyOld = $row->QuantityOut;
				$QuantityStock = $row->QuantityStock;

				$this->db->set('ProductQty', $qtyNew);
				$this->db->where('ProductID', $product);
				if ($parent != '') {
					$this->db->where('ProductParent', $parent);
				}
				$this->db->where('DOID', $reff);
				$this->db->update('tb_do_detail');
				$this->last_query .= "//".$this->db->last_query();

				$this->db->set('QuantityOut', $qtyNew);
				$this->db->where('StockOutID', $StockOutID);
				// $this->db->where('NoReff', "DO".$reff);
				// $this->db->where('ProductID', $product);
				$this->db->update('tb_product_stock_out');
				$this->last_query .= "//".$this->db->last_query();
				
				$this->stock_history_arrange($product, $qtyNew, $qtyOld, $WarehouseID, "DO", $reff, $StockOutID);
			}
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function cek_value()
	{
		$type	= $this->input->get_post('type');
		$reff	= $this->input->get_post('reff');
		if ($type == 'DO_HPP') {
			$sql = "SELECT SUM(t1.ProductQty*pm.ProductPriceHPP) AS DOAmount
					FROM tb_do_detail t1 
					LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
					WHERE t1.DOID=".$reff;
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$Amount = $row->DOAmount;
		} elseif ($type == 'DO_stock') {
			$sql = "SELECT SUM(t1.QuantityOut*pm.ProductPriceHPP) AS DOAmount
					FROM tb_product_stock_out t1 
					LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
					WHERE t1.NoReff='DO".$reff."'";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$Amount = $row->DOAmount;
		} elseif ($type == 'DOR_HPP') {
			$sql = "SELECT SUM(t1.ProductQty*pm.ProductPriceHPP) AS DORAmount
					FROM tb_dor_detail t1 
					LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
					WHERE t1.DORID=".$reff;
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$Amount = $row->DORAmount;
		} elseif ($type == 'DOR_stock') {
			$sql = "SELECT SUM(t1.QuantityIn*pm.ProductPriceHPP) AS DORAmount
					FROM tb_product_stock_in t1 
					LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
					WHERE t1.NoReff='DOR".$reff."'";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$Amount = $row->DORAmount;
		} elseif ($type == 'Adjustment') {
			$sql = "SELECT SUM(t1.ProductQty*pm.ProductPriceHPP) AS Amount
					FROM tb_product_stock_adjustment_detail t1 
					LEFT JOIN tb_product_main pm ON t1.ProductID=pm.ProductID 
					WHERE t1.AdjustmentID=".$reff;
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$Amount = $row->Amount;
		} elseif ($type == 'RAWPO') {
			$sql = "SELECT SUM(RawQty*ProductHPP) AS Amount
					FROM tb_po_raw t1 
					WHERE t1.POID=".$reff;
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$Amount = $row->Amount;
		}
		echo json_encode($Amount);
	}
	
//update pending ===========================================================
	function update_status_ro($ro)
	{
		$this->db->trans_start();

		// $sql = "SELECT * FROM vw_ro_product WHERE ROID=".$ro." and total>0";
		$sql = "SELECT rm.ROID, rm.ROStatus, t1.ProductQty, COALESCE(t2.total,0) AS total
				FROM tb_ro_main rm
				LEFT JOIN (
				SELECT rp.ROID, SUM(rp.ProductQty) AS ProductQty
				FROM tb_ro_product rp 
				GROUP BY rp.ROID
				) t1 ON t1.ROID = rm.ROID
				LEFT JOIN (
				SELECT rpp.ROID, SUM(rpp.total) AS total
				FROM vw_ro_product_po rpp
				GROUP BY rpp.ROID
				) t2 ON t2.ROID=rm.ROID
				WHERE rm.ROID=".$ro;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		// if (empty($row)) {
		if ($row->ProductQty > $row->total) {
			$this->db->set('ROStatus', 0);
		} else {
			$this->db->set('ROStatus', 1);
		}
		$this->db->where('ROID', $ro);
		$this->db->update('tb_ro_main');
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function update_pending_so($SOID)
	{
		$sql = "SELECT sd.*, ( sd.ProductQty - COALESCE(t1.totaldo,0) ) AS Pending
				FROM tb_so_detail sd
				LEFT JOIN (
				SELECT drpd.DOReff, drpd.ProductID, drpd.SalesOrderDetailID,
				SUM(drpd.ProductQty) AS totaldo
				FROM vw_do_reff_product_detail2 drpd
				WHERE drpd.DOType='SO' AND drpd.DOReff=".$SOID."
				GROUP BY drpd.ProductID, drpd.SalesOrderDetailID
				) as t1 ON sd.SOID=t1.DOReff AND sd.ProductID=t1.ProductID AND sd.SalesOrderDetailID=t1.SalesOrderDetailID 
				WHERE sd.SOID=".$SOID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$this->db->set('Pending', $row->Pending);
			$this->db->where('SOID', $row->SOID);
			$this->db->where('ProductID', $row->ProductID);
			$this->db->where('SalesOrderDetailID', $row->SalesOrderDetailID);
			$this->db->update('tb_so_detail');
			$this->last_query .= "//".$this->db->last_query();
		};
	}
	function update_pending_product_po($POID)
	{
		$this->db->trans_start();

		$sql = "SELECT pp.POID, pp.ProductID, pp.ProductQty, COALESCE(t1.DORQty,0) AS DORQty
				FROM tb_po_product pp
				LEFT JOIN (
				SELECT GROUP_CONCAT(dm.DORID) AS DORID, dm.DORReff, dd.ProductID, SUM(dd.ProductQty) AS DORQty
				FROM tb_dor_main dm LEFT JOIN tb_dor_detail dd ON dm.DORID=dd.DORID
				WHERE dm.DORType='PO' AND dm.DORReff=".$POID." GROUP BY dm.DORReff, dd.ProductID
				) t1 ON pp.POID=t1.DORReff AND pp.ProductID=t1.ProductID
				WHERE pp.POID=".$POID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$this->db->set('DORQty', $row->DORQty);
			$this->db->set('Pending', $row->ProductQty - $row->DORQty);
			$this->db->where('POID', $row->POID);
			$this->db->where('ProductID', $row->ProductID);
			$this->db->update('tb_po_product');
			$this->last_query .= "//".$this->db->last_query();
		};

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function update_pending_raw_po($POID)
	{
		$sql = "SELECT p.*,  COALESCE(t1.totaldo,0) AS totaldo
				FROM tb_po_raw p
				LEFT JOIN (

				SELECT GROUP_CONCAT(dm.DOID) AS DOID, dm.DOType, dm.DOReff, dd.ProductID, dd.ProductParent, SUM(dd.ProductQty) AS totaldo
				FROM tb_do_main dm LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
				WHERE dm.DOType='RAW PO' AND dm.DOReff=".$POID." GROUP BY dm.DOReff, dd.ProductParent, dd.ProductID

				) t1 ON p.POID=t1.DOReff AND p.ProductID=t1.ProductParent AND p.RawID=t1.ProductID
				WHERE p.POID=".$POID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$this->db->set('RawSent', $row->totaldo);
			$this->db->set('Pending', $row->RawQty - $row->totaldo);
			$this->db->where('POID', $row->POID);
			$this->db->where('ProductID', $row->ProductID);
			$this->db->where('RawID', $row->RawID);
			$this->db->update('tb_po_raw');
			$this->last_query .= "//".$this->db->last_query();
		};
	}
	function update_pending_ro($ROID)
	{
		$sql = "SELECT rp.ROID, rp.ProductID, rp.ProductQty, COALESCE(t1.ProductQty,0) AS ProductPO
				FROM tb_ro_product rp
				LEFT JOIN (
				SELECT GROUP_CONCAT(pm.POID) AS POID, pm.ROID, pp.ProductID, SUM(pp.ProductQty) AS ProductQty FROM tb_po_main pm
				LEFT JOIN tb_po_product pp ON pp.POID=pm.POID WHERE pm.POStatus<>2 AND pm.ROID=".$ROID." GROUP BY pm.ROID, pp.ProductID 
				) t1 ON rp.ROID=t1.ROID AND rp.ProductID=t1.ProductID
				WHERE rp.ROID=".$ROID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$pending = ($row->ProductQty - $row->ProductPO < 0) ? 0 : $row->ProductQty - $row->ProductPO ;
			$this->db->set('ProductPO', $row->ProductPO);
			$this->db->set('Pending', $pending);
			$this->db->where('ROID', $row->ROID);
			$this->db->where('ProductID', $row->ProductID);
			$this->db->update('tb_ro_product');
			$this->last_query .= "//".$this->db->last_query();
		};

		$sql = "SELECT rr.ROID, rr.ProductID, rr.RawID, rr.RawQty, COALESCE(t1.RawQty,0) AS RawPO
				FROM tb_ro_raw rr
				LEFT JOIN (
					SELECT GROUP_CONCAT(pm.POID) AS POID, pm.ROID, pr.ProductID, 
					pr.RawID, SUM(pr.RawQty) AS RawQty 
					FROM tb_po_main pm
					LEFT JOIN tb_po_raw pr ON pr.POID=pm.POID 
					WHERE pm.POStatus<>2 and pm.ROID=".$ROID."
					GROUP BY pm.ROID, pr.ProductID, pr.RawID
				) t1 ON rr.ROID=t1.ROID AND rr.ProductID=t1.ProductID AND rr.RawID=t1.RawID
				WHERE rr.ROID=".$ROID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$pending = ($row->RawQty - $row->RawPO < 0) ? 0 : $row->RawQty - $row->RawPO ;
			$this->db->set('Pending', $pending);
			$this->db->where('ROID', $row->ROID);
			$this->db->where('ProductID', $row->ProductID);
			$this->db->where('RawID', $row->RawID);
			$this->db->update('tb_ro_raw');
			$this->last_query .= "//".$this->db->last_query();
		};
	}
	function update_pending_mutation($MutationID)
	{
		$sql = "SELECT md.MutationID, md.ProductID, md.ProductQty, COALESCE(t2.DOQty,0) AS DOQty, COALESCE(t1.DORQty,0) AS DORQty
				FROM tb_product_mutation_detail md
				LEFT JOIN (
				SELECT GROUP_CONCAT(dm.DORID) AS DORID, dm.DORReff, dd.ProductID, SUM(dd.ProductQty) AS DORQty
				FROM tb_dor_main dm LEFT JOIN tb_dor_detail dd ON dm.DORID=dd.DORID
				WHERE dm.DORType='MUTATION' AND dm.DORReff=".$MutationID." GROUP BY dm.DORReff, dd.ProductID
				) t1 ON md.MutationID=t1.DORReff AND md.ProductID=t1.ProductID

				LEFT JOIN (
				SELECT GROUP_CONCAT(dm.DOID) AS DOID, dm.DOType, dm.DOReff, dd.ProductID, SUM(dd.ProductQty) AS DOQty
				FROM tb_do_main dm LEFT JOIN tb_do_detail dd ON dm.DOID=dd.DOID
				WHERE dm.DOType='MUTATION' AND dm.DOReff=".$MutationID." GROUP BY dm.DOReff, dd.ProductID
				) t2 ON md.MutationID=t2.DOReff AND md.ProductID=t2.ProductID
				WHERE md.MutationID=".$MutationID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$this->db->set('DOQty', $row->DOQty);
			$this->db->set('DORQty', $row->DORQty);
			$this->db->where('MutationID', $row->MutationID);
			$this->db->where('ProductID', $row->ProductID);
			$this->db->update('tb_product_mutation_detail');
			$this->last_query .= "//".$this->db->last_query();
		};
	}

// =========================================================================
	function get_percent($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			$percent 	= $num1/100;
			$result 	= $num2/$percent; 
		}
		return number_format( $result, 2);
		$this->log_user->log_query($this->last_query);
	}
	function get_percent2($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			$result = $num2 * ($num1/100) ; 
		}
		return $result;
		$this->log_user->log_query($this->last_query);
	}
	function get_percent_floor($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			$percent 	= $num1/100;
			$result 	= $num2/$percent; 
		}
		return number_format($result);
		$this->log_user->log_query($this->last_query);
	}
	function warehouse_list()
	{
		$sql 	= "SELECT * from tb_warehouse_main order by WarehouseClass desc";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row3) {
		  	$warehouse[] = array(
	  			'WarehouseID' => $row3->WarehouseID,
	  			'WarehouseName' => $row3->WarehouseName
			);
		};
		return $warehouse;
		$this->log_user->log_query($this->last_query);
	}
	function get_opname_detail()
	{
		$WarehouseID = $this->input->get_post('id');
		$show   = array();

		$sql 	= "SELECT pso.OpnameID, psa.AdjustmentID FROM tb_product_stock_opname pso
					LEFT JOIN tb_product_stock_adjustment psa ON (psa.OpnameID=pso.OpnameID)
					WHERE WarehouseID=".$WarehouseID." ORDER BY pso.OpnameID desc limit 1";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		if (!empty($row)) {
			$OpnameID = $row->OpnameID;
			$AdjustmentID = $row->AdjustmentID;
			if ($AdjustmentID == "") {
				$show['OpnameID'] = $OpnameID;
				// $sql = "SELECT psod.*, pm.ProductCode FROM tb_product_stock_opname_detail psod
				// 		LEFT JOIN tb_product_main pm ON (psod.ProductID=pm.ProductID)
				// 		WHERE OpnameID =".$OpnameID." order by psod.Quantity=0, psod.ProductID asc ";
				// $query 	= $this->db->query($sql);
				// foreach ($query->result() as $row) {
				//   	$show['detail'][] = array(
				// 		'OpnameID' => $row->OpnameID,
				// 		'ProductID' => $row->ProductID,
				// 		'WarehouseID' => $row->WarehouseID,
				// 		'Quantity' => $row->Quantity,
				// 		'ProductCode' => $row->ProductCode
				// 	);
				// };
			} else {
				$show['error'] = "Tidak ada Stock Opname Baru (tanpa Adjustment).";
			}
		} else {
			$show['error'] = "Tidak ada Stock Opname Baru.";
		}
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function cek_stock_all()
	{
		$ProductID = $this->input->get_post('ProductID');
		$sql = "SELECT wm.WarehouseName, psm.Quantity FROM tb_product_stock_main psm
				LEFT JOIN tb_warehouse_main wm ON psm.WarehouseID = wm.WarehouseID
				WHERE psm.ProductID=".$ProductID;
		$query 	= $this->db->query($sql);
		$show	= $query->result_array();
		echo json_encode($show);
	}


}
?>