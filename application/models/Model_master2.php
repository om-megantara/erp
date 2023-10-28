<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_master2 extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }

// warehouse===========================================================
	function warehouse_list()
	{
		$sql 	= "SELECT * FROM tb_warehouse_main order by WarehouseClass desc";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'WarehouseID' => $row->WarehouseID,
		  			'WarehouseName' => $row->WarehouseName,
		  			'WarehouseAddress' => $row->WarehouseAddress,
		  			'WarehousePhone' => $row->WarehousePhone
				);
		};
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
	}
	function warehouse_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$address = $this->input->post('address'); 
		$phone 	= $this->input->post('phone');

		$data = array(
	        'WarehouseName' 	=> $name,
			'WarehouseAddress'	=> $address,
			'WarehousePhone' => $phone
		);
		$this->db->insert('tb_warehouse_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function warehouse_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$address = $this->input->post('address2'); 
		$phone 	= $this->input->post('phone2'); 
		$name 	= $this->input->post('name2'); 

		$data = array(
			'WarehouseAddress'=> $address,
			'WarehousePhone'  => $phone,
			'WarehouseName' 	=> $name
		);

		$this->db->where('WarehouseID', $id);
		$this->db->update('tb_warehouse_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// city================================================================
	function city_list()
	{
		$sql 	= "SELECT ac.*, ap.ProvinceName, c.fullname as expedisi, ast.StateName, trm.RegionCode FROM vw_city ac 
					LEFT JOIN tb_address_province ap ON (ac.ProvinceID = ap.ProvinceID)
					LEFT JOIN tb_address_state ast ON (ap.StateID = ast.StateID)
					LEFT JOIN tb_expedition e ON (ac.ExpeditionID = e.ExpeditionID)
					LEFT JOIN tb_region_main trm ON (ac.RegionID = trm.RegionID)
					LEFT JOIN vw_contact1 c ON (e.ContactID = c.ContactID)  ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$show[] = array(
					'CityID' => $row->CityID,
					'CityName' => $row->CityName,
					'CityAbbreviation' => $row->CityAbbreviation,
					'ProvinceName' => $row->ProvinceName,
					'StateName' => $row->StateName,
					'Expedisi' => $row->expedisi,
					'FCPrice' => $row->FCPrice,
					'FCWeight' => $row->FCWeight,
					'RegionCode' => $row->RegionCode,
				);
		};
		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function city_detail()
	{
		$show = array();
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
			$sql 	= "SELECT * from vw_city where CityID =".$_REQUEST['id'];
			$query 	= $this->db->query($sql);
			$show   = array();
			foreach ($query->result() as $row) {
			  	$show = array(
					'CityID' => $row->CityID,
					'CityName' => $row->CityName,
					'CityAbbreviation' => $row->CityAbbreviation,
					'ExpeditionID' => $row->ExpeditionID,
					'FCPrice' => $row->FCPrice,
					'FCWeight' => $row->FCWeight,
				);
			};
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function city_cu_act()
	{
		$this->db->trans_start();

		$CityID 		= $this->input->post('cityid'); 
		$CityName 		= $this->input->post('cityname'); 
		$CityAbbreviation = $this->input->post('cityabbreviation'); 
		$ExpeditionID 	= $this->input->post('expedition'); 
		$FCPrice 		= $this->input->post('price');
		$FCWeight 		= $this->input->post('weight');

		$data = array(
	        'CityName' => $CityName,
	        'CityAbbreviation' => $CityAbbreviation,
	        'ExpeditionID' => $ExpeditionID,
	        'FCPrice' => $FCPrice,
	        'FCWeight' => $FCWeight,
		);
		$this->db->where('CityID', $CityID);
		$this->db->update('tb_address_city', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// region==============================================================
	function region_list()
	{
		$sql 	= "SELECT rm.*, vem.Company2
					FROM tb_region_main rm
					LEFT JOIN vw_sales_executive2 vem ON (rm.SEC = vem.SalesID)";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'RegionID' => $row->RegionID,
		  			'RegionName' => $row->RegionName,
		  			'RegionCode' => $row->RegionCode,
		  			'SEC' => $row->SEC,
		  			'fullname' => $row->Company2
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function region_detail()
    {
		$show = array();

		$sql 	= "SELECT * from vw_sales_executive2 where isActive=1";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['sales'][] = array(
				'SalesID' => $row->SalesID,
				'fullname' => $row->Company2
			);
		};
		
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != "") {
			$sql 	= "SELECT * from tb_region_main where RegionID =".$_REQUEST['id'];
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$RegionID = $row->RegionID;
			  	$show['main'] = array(
					'RegionID' => $row->RegionID,
					'RegionName' => $row->RegionName,
					'RegionCode' => $row->RegionCode,
					'SEC' => $row->SEC
				);
			};
			
			$sql 	= "SELECT ac.*, ap.ProvinceName, ast.StateName
						FROM vw_city ac 
						LEFT JOIN tb_address_province ap ON (ac.ProvinceID = ap.ProvinceID)
						LEFT JOIN tb_address_state ast ON (ap.StateID = ast.StateID) where RegionID=".$RegionID;
			$query 	= $this->db->query($sql);
			if ($query->num_rows()) {
				foreach ($query->result() as $row) {
				  	$show['city'][] = array(
				  			'CityID' => $row->CityID,
				  			'CityName' => $row->CityName,
				  			'CityAbbreviation' => $row->CityAbbreviation,
				  			'ProvinceName' => $row->ProvinceName,
				  			'StateName' => $row->StateName
						);
				};
				$show['city2'] = json_encode($show['city']);
			}

			
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function region_cu_act()
	{
		$this->db->trans_start();

		$RegionID 	= $this->input->post('regionid'); 
		$RegionName = $this->input->post('regionname'); 
		$RegionCode = $this->input->post('regioncode'); 
		$SEC 		= $this->input->post('sec'); 
		$CityID 	= $this->input->post('cityid'); 

		if (isset($RegionID)) {
			$data = array(
		        'RegionName' => $RegionName,
		        'RegionCode' => $RegionCode,
		        'SEC' => $SEC
			);
			$this->db->where('RegionID', $RegionID);
			$this->db->update('tb_region_main', $data);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data = array(
		        'RegionName' => $RegionName,
		        'RegionCode' => $RegionCode,
		        'SEC' => $SEC
			);
			$this->db->insert('tb_region_main', $data);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(RegionID) as RegionID from tb_region_main ";
			$getRegionID= $this->db->query($sql);
			$row 		= $getRegionID->row();
			$RegionID 	= $row->RegionID;
		}
		
		if (isset($CityID)) {
			$CityID2 	= array_unique($CityID);
			// set RegionID 1 untuk CityID lama
			$this->db->set('RegionID', 1);
			$this->db->where('RegionID', $RegionID);
			$this->db->update('tb_mkt_city');
			$this->last_query .= "//".$this->db->last_query();

			// set RegionID untuk CityID baru
			$this->db->set('RegionID', $RegionID);
			$this->db->where_in('CityID', $CityID2);
			$this->db->update('tb_mkt_city');
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->history_city_region($CityID2, $RegionID);
		$this->history_region_sec($SEC, $RegionID);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function history_region_sec($SEC, $RegionID)
	{
		$this->db->trans_start();

		$sql 	= "select SECID from tb_history_region_sec where RegionID=".$RegionID." and DateEnd is null";
		$query 	= $this->db->query($sql);
		if ($query->num_rows()<=0) {
   			$data = array(
		        'RegionID' => $RegionID,
		        'SECID' => $SEC,
        		'DateStart' => date("Y-m-d")
			);
			$this->db->insert('tb_history_region_sec', $data);
			$this->last_query .= "//".$this->db->last_query();
	    } else {
			$row 	= $query->row();
			$SECID 	= $row->SECID;

			if ($SEC != $SECID) {
	   			// update history SEC lama
				$this->db->set('DateEnd', date("Y-m-d"));
				$this->db->where('RegionID', $RegionID);
				$this->db->where('SECID', $SECID);
				$this->db->where('DateEnd is NULL', NULL, FALSE);
				$this->db->update('tb_history_region_sec');
				$this->last_query .= "//".$this->db->last_query();

	   			// update history SEC baru
	   			$data = array(
			        'RegionID' => $RegionID,
			        'SECID' => $SEC,
	        		'DateStart' => date("Y-m-d")
				);
				$this->db->insert('tb_history_region_sec', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
	    }
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function history_city_region($CityID, $RegionID)
	{
		$this->db->trans_start();

		$sql 	= "select CityID from tb_history_city_region where RegionID=".$RegionID." and DateEnd is null";
		$query 	= $this->db->query($sql);
		if ($query->num_rows()<=0) {
			foreach ($CityID as $key => $value) {
				$data[] = array(
			        'RegionID' => $RegionID,
			        'CityID' => $value,
	        		'DateStart' => date("Y-m-d")
				);
			};
			$this->db->insert_batch('tb_history_city_region', $data);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			foreach ($query->result() as $row) {
			  	$result[] = $row->CityID;
			};

   			// update history city lama
			$result2 = array_diff($result, $CityID);
   			foreach ($result2 as $key => $row) {
   				// set datend di history untuk CityID lama dengan region sama
				$this->db->set('DateEnd', date("Y-m-d"));
				$this->db->where('RegionID', $RegionID);
				$this->db->where('CityID', $row);
				$this->db->where('DateEnd is NULL', NULL, FALSE);
				$this->db->update('tb_history_city_region');
				$this->last_query .= "//".$this->db->last_query();
				// set RegionID 1 di history untuk CityID lama dengan region sama
				$data[] = array(
			        'RegionID' => 1,
			        'CityID' => $row,
	        		'DateStart' => date("Y-m-d")
				);
			};
			if (!empty($data)) {
				$this->db->insert_batch('tb_history_city_region', $data);
				$this->last_query .= "//".$this->db->last_query();
			}

   			// update history city baru
   			$result2 = array_diff($CityID, $result);
   			// set deteend untuk CityID baru di history lama dengan region beda
			$this->db->set('DateEnd', date("Y-m-d"));
			$this->db->where('RegionID !=', $RegionID);
			$this->db->where_in('CityID', $CityID);
			$this->db->where('DateEnd is NULL', NULL, FALSE);
			$this->db->update('tb_history_city_region');
			$this->last_query .= "//".$this->db->last_query();
			// input history baru
   			foreach ($result2 as $key => $row) {
	   			$data[] = array(
			        'RegionID' => $RegionID,
			        'CityID' => $row,
	        		'DateStart' => date("Y-m-d")
				);
			};
			if (!empty($data)) {
				$this->db->insert_batch('tb_history_city_region', $data);
				$this->last_query .= "//".$this->db->last_query();
			}

		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// promo volume========================================================
	function promo_volume_list()
	{
		$sql	= "SELECT pv.*, pc.PricecategoryName, coalesce(t1.CountID,0) as CountID, coalesce(t1.CountAll,0) as CountAll , COALESCE(vap.isComplete,0) as isComplete
					FROM tb_price_promo_vol_main pv
					LEFT JOIN tb_price_category_main pc ON (pv.PricecategoryID = pc.PricecategoryID)
					LEFT JOIN vw_approval_promo_volume_max_full vap ON vap.PromoVolID =pv.PromoVolID
					LEFT JOIN (
					SELECT PromoVolID, COUNT(DISTINCT ProductID) AS CountID, COUNT(ProductID) AS CountAll 
					FROM tb_price_promo_vol_detail GROUP BY PromoVolID
					) t1 ON t1.PromoVolID = pv.PromoVolID ";
		$show   = array();
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PromoVolID' => $row->PromoVolID,
		  			'PromoVolName' => $row->PromoVolName,
		  			'PromoVolNote' => $row->PromoVolNote,
		  			'PricecategoryName' => $row->PricecategoryName,
					'DateStart' => $row->DateStart,
					'DateEnd' => $row->DateEnd,
					'isActive' => $row->isActive,
					'isComplete' => $row->isComplete,
					'CountID' => $row->CountID,
					'CountAll' => $row->CountAll,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function promo_volume_cu($val)
    {
		$show = array();
		$show['promolist'] = array();
		$show['promod'] = array();
		if ($val == "new") { //jika data contact baru
			$show['promolist'] = array(
				'PromoVolID' => "",
			  	'PromoVolName' => "",
				'DateStart' => "",
				'DateEnd'	=> "",
				'PromoVolNote' => "",
				'isActive' => "1"
			);
		} else { // jika data promolist exist
			$sql 	= "select * from tb_price_promo_vol_main where PromoVolID = ".$val;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			if (empty($row)) {
				redirect(base_url());
			} else {
				$show['promolist'] = array(
				  	'PromoVolID' => $val,
					'PromoVolName' => $row->PromoVolName,
					'DateStart' => $row->DateStart,
					'DateEnd' => $row->DateEnd,
					'PromoVolNote' => $row->PromoVolNote,
					'PricecategoryID' => $row->PricecategoryID,
					'isActive' => $row->isActive,
				);
			
				$sql3 	= "SELECT pvd.*, pm.ProductName, pm.ProductCode, pm.ProductPriceDefault 
							FROM tb_price_promo_vol_detail pvd
							LEFT JOIN tb_product_main pm ON (pvd.ProductID = pm.ProductID)
							WHERE pvd.PromoVolID=".$val." order by pm.ProductID, pvd.ProductQty";
				$query3 = $this->db->query($sql3);
				foreach ($query3->result() as $row2) {
					$show['promod'][] = array(
						'ProductID' => $row2->ProductID,
						'ProductName' => $row2->ProductName,
						'ProductCode' => $row2->ProductCode,
						'ProductQty' => $row2->ProductQty,
						'ProductPrice' => $row2->ProductPriceDefault,
						'Promo' => $row2->Promo,
						'PT1Discount' => $row2->PT1Discount,
						'PT2Discount' => $row2->PT2Discount,
						'status' => "old",
					);
				};

				$sql2 = "SELECT pvd.*, pm.ProductName, pm.ProductCode, pm.ProductPriceDefault 
							FROM tb_price_promo_vol_detail_approval pvd
							LEFT JOIN tb_product_main pm ON (pvd.ProductID = pm.ProductID)
							WHERE pvd.PromoVolID=".$val." and isApprove is null order by pm.ProductID, pvd.ProductQty";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$show['promod'][] = array(
							'ProductID' => $row2->ProductID,
							'ProductName' => $row2->ProductName,
							'ProductCode' => $row2->ProductCode,
							'ProductQty' => $row2->ProductQty,
							'ProductPrice' => $row2->ProductPriceDefault,
							'Promo' => $row2->Promo,
							'PT1Discount' => $row2->PT1Discount,
							'PT2Discount' => $row2->PT2Discount,
							'status' => "new",
						);
					};
				} 
				$show['promod2'] = json_encode($show['promod']);

				$sql2 = "select * from tb_price_promo_vol_brand_category pld where pld.PromoVolID = '".$val."'";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$show['promoBC'][] = array(
							'PromoVolID' => $row2->PromoVolID,
							'ProductCategoryID' => $row2->ProductCategoryID,
							'ProductBrandID' => $row2->ProductBrandID,
						);
					};
				} else {
					$show['promoBC'][] = array(
						'PromoVolID' => "",
						'ProductCategoryID' => "",
						'ProductBrandID' => "",
					);
				}
				$show['promoBC2'] = json_encode( $show['promoBC'] );

				$sql2 = "select * from tb_price_promo_vol_filter_percent pld where pld.PromoVolID = '".$val."'";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$show['promoQP'][] = array(
							'PromoVolID' => $row2->PromoVolID,
							'ProductQty' => $row2->ProductQty,
							'PromoPercent' => $row2->PromoPercent,
							'PT1Percent' => $row2->PT1Percent,
							'PT2Percent' => $row2->PT2Percent,
						);
					};
				} else {
					$show['promoQP'][] = array(
							'PromoVolID' => "",
							'ProductQty' => "1",
							'PromoPercent' => "0",
							'PT1Percent' => "0",
							'PT2Percent' => "0",
					);
				}
				$show['promoQP2'] = json_encode( $show['promoQP'] );
			}
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function promo_volume_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		$PromoVolID	= $this->input->post('promovolid'); 
		$pname 		= $this->input->post('pname'); 
		$pnote 		= $this->input->post('pnote'); 
		$pstart 	= $this->input->post('pstart'); 
		$pend		= $this->input->post('pend'); 
		$isActive	= $this->input->post('isActive'); 
		$product 	= $this->input->post('product'); 
		$qty		= $this->input->post('qty'); 
		$status 	= $this->input->post('status'); 
		$promo 		= $this->input->post('promo');
		$top 		= $this->input->post('top');
		$cbd 		= $this->input->post('cbd');
		$pricecategory	= $this->input->post('pricecategory');
        $datetimenow	= date("Y-m-d H:i:s");

		$Category	= $this->input->post('CategoryID');
		$Brand	= $this->input->post('BrandID');
		$qty_filter	= $this->input->post('qty_filter');
		$promo_filter = $this->input->post('promo_filter');
		$TOP_filter	= $this->input->post('TOP_filter');
		$CBD_filter	= $this->input->post('CBD_filter');

		$noteApproval = "";
		$errorCount = 0;

		$pl_main = array(
			'PromoVolName'	=> $pname,
			'PromoVolNote' => $pnote,
			'DateStart' => $pstart,
			'DateEnd' => $pend,
			'isActive' => $isActive,
			'PricecategoryID' => $pricecategory,
		);

		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='product_promo_volume' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		if ($PromoVolID != "") { //jika data pricelist baru

			// compare main ------------------------------------
				$sqlMain 	= "select * from tb_price_promo_vol_main where PromoVolID = ".$PromoVolID; 
				$query3 = $this->db->query($sqlMain);
				$rowM 	= $query3->row();
				$data1M = array(
				  	'PromoVolID' => $PromoVolID,
					'PromoVolName' => $rowM->PromoVolName,
					'DateStart' => $rowM->DateStart,
					'DateEnd' => $rowM->DateEnd,
					'PromoVolNote' => $rowM->PromoVolNote,
					'PricecategoryID' => $rowM->PricecategoryID,
					'isActive' => $rowM->isActive, 
				);

				if 	(!(
						$data1M['PromoVolName'] === $pl_main['PromoVolName'] && 
				    	$data1M['DateStart'] === $pl_main['DateStart'] && 
				    	$data1M['DateEnd'] === $pl_main['DateEnd'] && 
				    	$data1M['isActive'] === $pl_main['isActive'] && 
				    	$data1M['PromoVolNote'] === $pl_main['PromoVolNote'] && 
				    	$data1M['PricecategoryID'] === $pl_main['PricecategoryID']
					)) {
					$errorCount += 1;
				}
			// -----------------------------------------------------------


			// compare qty percent ------------------------------------
				// from post
				$p_f_p = array();
				if (isset($qty_filter)) {
					for ($i=0; $i < count($qty_filter);$i++) {
						$p_f_p[] = array(
							'ProductQty' => $qty_filter[$i],
							'PromoPercent' => $promo_filter[$i],
							'PT1Percent' => $TOP_filter[$i],
							'PT2Percent' => $CBD_filter[$i],
						);
					}; 
				}

				$data1FP = array();
				$sql2 = "select * from tb_price_promo_vol_filter_percent pld where pld.PromoVolID = '".$PromoVolID."'";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$data1FP[] = array(
							'ProductQty' => $row2->ProductQty,
							'PromoPercent' => $row2->PromoPercent,
							'PT1Percent' => $row2->PT1Percent,
							'PT2Percent' => $row2->PT2Percent,
						);
					};
				}  

				if (count($data1FP) != count($p_f_p)) {
					$errorCount += 1;
				} else {
					for ($i=0; $i < count($p_f_p); $i++) { 
						if 	(!(
								$data1FP[$i]['ProductQty'] === $p_f_p[$i]['ProductQty'] && 
						    	$data1FP[$i]['PromoPercent'] === $p_f_p[$i]['PromoPercent']  && 
						    	$data1FP[$i]['PT1Percent'] === $p_f_p[$i]['PT1Percent']  && 
						    	$data1FP[$i]['PT2Percent'] === $p_f_p[$i]['PT2Percent'] 
							)) {
							$errorCount += 1;
						}
					}
				}
			// -----------------------------------------------------------
				
			// compare BrandCategory ------------------------------------
				// from post
				$p_b_c = array();
				for ($i=0; $i < count($Category);$i++) { 
					$p_b_c[] = array(
						'ProductCategoryID' => $Category[$i],
						'ProductBrandID' => $Brand[$i]
					);
				};

				// from db
				$data1BC = array();
				$sql2 = "select * from tb_price_promo_vol_brand_category pld where pld.PromoVolID = '".$PromoVolID."'";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$data1BC[] = array(
							'ProductCategoryID' => $row2->ProductCategoryID,
							'ProductBrandID' => $row2->ProductBrandID,
						);
					};
				}  

				if (count($data1BC) != count($p_b_c)) {
					$errorCount += 1;
				} else {
					for ($i=0; $i < count($p_b_c); $i++) { 
						if 	(!(
								$data1BC[$i]['ProductCategoryID'] === $p_b_c[$i]['ProductCategoryID'] && 
						    	$data1BC[$i]['ProductBrandID'] === $p_b_c[$i]['ProductBrandID'] 
							)) {
							$errorCount += 1;
						}
					}
				}
			// -----------------------------------------------------------
				
			// new product in list ------------------------------------
				if (in_array("new", $status)) {
					$errorCount += 1;
				}
		}
		
		if ($PromoVolID == "") { //jika data pricelist baru
			$this->db->insert('tb_price_promo_vol_main', $pl_main);
			$this->last_query .= "//".$this->db->last_query();

			$sql 			= "select PromoVolID, PromoVolName from tb_price_promo_vol_main order by PromoVolID desc limit 1 ";
			$getPromoVolID = $this->db->query($sql);
			$row 			= $getPromoVolID->row();
			$PromoVolID 	= $row->PromoVolID;
			$PromoVolName 	= $row->PromoVolName;

			// if ($Actor3 != 0) {
				$data_approval = array(
			        'PromoVolID' => $PromoVolID,
			        'isComplete' => "0",
			        'Status' => "OnProgress",
			        'Title' => "edit '".$PromoVolName."' oleh ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			        'Note' => $noteApproval,
				);
			// } else {
			// 	$data_approval = array(
			//         'PromoVolID' => $PromoVolID,
			//         'isComplete' => "1",
			//         'Status' => "Approved",
			//         'Title' => "edit '".$PromoVolName."' oleh ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			//         'Note' => $noteApproval,
			// 	);
			// }
			$this->db->insert('tb_approval_promo_volume', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$sql 			= "select max(ApprovalID) as ApprovalID from tb_approval_promo_volume ";
			$getApprovalID  = $this->db->query($sql);
			$row 			= $getApprovalID->row();
			$ApprovalID 	= $row->ApprovalID;

			// insert approval detail ---------------------------------------
			$pl_main = array(
				'ApprovalID' => $ApprovalID,
		        'PromoVolID' => $PromoVolID,
				'PromoVolName'	=> $pname,
				'PromoVolNote' => $pnote,
				'DateStart' => $pstart,
				'DateEnd' => $pend,
				'isActive' => $isActive,
				'PricecategoryID' => $pricecategory,
			); 
			$this->db->insert('tb_price_promo_vol_approval_main', $pl_main);
			$this->last_query .= "//".$this->db->last_query();
		
			for ($i=0; $i < count($Category);$i++) { 
				$p_b_c = array(
					'ApprovalID' => $ApprovalID,
					'PromoVolID' => $PromoVolID,
					'ProductCategoryID' => $Category[$i],
					'ProductBrandID' => $Brand[$i]
				);
				$this->db->insert('tb_price_promo_vol_approval_brand_category', $p_b_c);
				$this->last_query .= "//".$this->db->last_query();
			};

			for ($i=0; $i < count($qty_filter);$i++) {
				$p_f_p = array(
					'ApprovalID' => $ApprovalID,
					'PromoVolID' => $PromoVolID,
					'ProductQty' => $qty_filter[$i],
					'PromoPercent' => $promo_filter[$i],
					'PT1Percent' => $TOP_filter[$i],
					'PT2Percent' => $CBD_filter[$i],
				);
				$this->db->insert('tb_price_promo_vol_appoval_filter_percent', $p_f_p);
				$this->last_query .= "//".$this->db->last_query();
			}; 
			// ------------------------------------------------------------

		} else { // jika data exist
			// $this->db->where('PromoVolID', $PromoVolID);
			// $this->db->update('tb_price_promo_vol_main', $pl_main);
			// $this->last_query .= "//".$this->db->last_query();

			$sql5 			= "select PromoVolName from tb_price_promo_vol_main where PromoVolID =".$PromoVolID;
			$getPromoVolID = $this->db->query($sql5);
			$row 			= $getPromoVolID->row();
			$PromoVolName 	= $row->PromoVolName;

			$this->db->set('isApprove', "1");
			$this->db->where('isApprove', null);
			$this->db->where('PromoVolID', $PromoVolID);
			$this->db->update('tb_price_promo_vol_detail_approval');

			$this->db->set('isComplete', 1);
			$this->db->set('Status', "Rejected");
			$this->db->where('PromoVolID', $PromoVolID);
			$this->db->where('isComplete', 0);
			$this->db->update('tb_approval_promo_volume');
			$this->last_query .= "//".$this->db->last_query();

			if ($errorCount > 0) {
			// if (in_array("new", $status)) {
			// 	if ($Actor3 != 0) {
					$data_approval = array(
				        'PromoVolID' => $PromoVolID,
				        'isComplete' => "0",
				        'Status' => "OnProgress",
				        'Title' => "edit '".$PromoVolName."' oleh ".$this->session->userdata('UserName').", tgl ".$datetimenow,
				        'Note' => $noteApproval,
					);
				// } else {
				// 	$data_approval = array(
				//         'PromoVolID' => $PromoVolID,
				//         'isComplete' => "1",
				//         'Status' => "Approved",
		  //       		'Title' => "tambah Product ke '".$pname."' oleh ".$this->session->userdata('UserName').", tgl ".$datetimenow,
				// 	);
				// }
				$this->db->insert('tb_approval_promo_volume', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
				
				$sql 			= "select max(ApprovalID) as ApprovalID from tb_approval_promo_volume ";
				$getApprovalID  = $this->db->query($sql);
				$row 			= $getApprovalID->row();
				$ApprovalID 	= $row->ApprovalID;
			// }
			
				// insert approval detail ---------------------------------------
				$pl_main = array(
					'ApprovalID' => $ApprovalID,
			        'PromoVolID' => $PromoVolID,
					'PromoVolName'	=> $pname,
					'PromoVolNote' => $pnote,
					'DateStart' => $pstart,
					'DateEnd' => $pend,
					'isActive' => $isActive,
					'PricecategoryID' => $pricecategory,
				); 
				$this->db->insert('tb_price_promo_vol_approval_main', $pl_main);
				$this->last_query .= "//".$this->db->last_query();
			
				for ($i=0; $i < count($Category);$i++) { 
					$p_b_c = array(
						'ApprovalID' => $ApprovalID,
						'PromoVolID' => $PromoVolID,
						'ProductCategoryID' => $Category[$i],
						'ProductBrandID' => $Brand[$i]
					);
					$this->db->insert('tb_price_promo_vol_approval_brand_category', $p_b_c);
					$this->last_query .= "//".$this->db->last_query();
				};

				for ($i=0; $i < count($qty_filter);$i++) {
					$p_f_p = array(
						'ApprovalID' => $ApprovalID,
						'PromoVolID' => $PromoVolID,
						'ProductQty' => $qty_filter[$i],
						'PromoPercent' => $promo_filter[$i],
						'PT1Percent' => $TOP_filter[$i],
						'PT2Percent' => $CBD_filter[$i],
					);
					$this->db->insert('tb_price_promo_vol_appoval_filter_percent', $p_f_p);
					$this->last_query .= "//".$this->db->last_query();
				}; 
				// ------------------------------------------------------------
			}

		}

		$this->db->where('PromoVolID', $PromoVolID);
		$this->db->delete('tb_price_promo_vol_detail');
		for ($i=0; $i < count($product);$i++) { 
			if ($status[$i] == "old") {
				$data_old[] = array(
					'PromoVolID' => $PromoVolID,
					'ProductID' => $product[$i],
					'ProductQty' => $qty[$i],
					'Promo' => $promo[$i],
					'PT1Discount' => $top[$i],
					'PT2Discount' => $cbd[$i]
				);
			} else {
				$data_new[] = array(
					'PromoVolID' => $PromoVolID,
					'ProductID' => $product[$i],
					'ProductQty' => $qty[$i],
					'Promo' => $promo[$i],
					'PT1Discount' => $top[$i],
					'PT2Discount' => $cbd[$i],
					'DateInput' => $datetimenow,
					'DateApproval' => $datetimenow,
					'ApprovalID' => $ApprovalID,
				);
			}
		};
		if (isset($data_old)) {
			$this->db->insert_batch('tb_price_promo_vol_detail', $data_old);
			$this->last_query .= "//".$this->db->last_query();
		}

		if (isset($data_new)) {
			$this->db->insert_batch('tb_price_promo_vol_detail_approval', $data_new);
			$this->last_query .= "//".$this->db->last_query();
		}

		// if (in_array("new", $status)) {
			if ($Actor3 == 0 && isset($ApprovalID)) {
				$this->db->set('isApprove', 1);
				$this->db->set('ApprovalBy', $this->session->userdata('UserAccountID'));
				$this->db->where('PromoVolID', $PromoVolID);
				$this->db->where('ApprovalID', $ApprovalID);
				$this->db->update('tb_price_promo_vol_detail_approval');
				$this->last_query .= "//".$this->db->last_query();
				
	        	$this->load->model('model_approval');
				$this->model_approval->approve_promo_volume_implementation($PromoVolID, $ApprovalID);
			}
		// }

		if (!empty($product)) {
        	$this->load->model('model_master');
			$this->model_master->product_promo_history($product);
		}
		
		// -----------------------------------------------------------
		// $this->db->where('PromoVolID', $PromoVolID);
		// $this->db->delete('tb_price_promo_vol_brand_category');
		// for ($i=0; $i < count($Category);$i++) { 
		// 	$p_b_c = array(
		// 		'PromoVolID' => $PromoVolID,
		// 		'ProductCategoryID' => $Category[$i],
		// 		'ProductBrandID' => $Brand[$i]
		// 	);
		// 	$this->db->insert('tb_price_promo_vol_brand_category', $p_b_c);
		// 	$this->last_query .= "//".$this->db->last_query();
		// };

		// $this->db->where('PromoVolID', $PromoVolID);
		// $this->db->delete('tb_price_promo_vol_filter_percent');
		// for ($i=0; $i < count($qty_filter);$i++) {
		// 	$p_f_p = array(
		// 		'PromoVolID' => $PromoVolID,
		// 		'ProductQty' => $qty_filter[$i],
		// 		'PromoPercent' => $promo_filter[$i],
		// 		'PT1Percent' => $TOP_filter[$i],
		// 		'PT2Percent' => $CBD_filter[$i],
		// 	);
		// 	$this->db->insert('tb_price_promo_vol_filter_percent', $p_f_p);
		// 	$this->last_query .= "//".$this->db->last_query();
		// };
		// ------------------------------------------------------------

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function promo_volume_detail()
    {
		$show   = array();
		$id 	= $this->input->get('a'); 
		
		$sql 	= "SELECT pv.*, pc.PricecategoryName, pc.PromoDefault FROM tb_price_promo_vol_main pv
					LEFT JOIN tb_price_category_main pc ON (pv.PricecategoryID = pc.PricecategoryID) 
					Where PromoVolID=".$id;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['promo'] = array(
			  	'PromoVolID' => $row->PromoVolID,
	  			'PromoVolName' => $row->PromoVolName,
	  			'PromoVolNote' => $row->PromoVolNote,
	  			'PricecategoryName' => $row->PricecategoryName,
	  			'PromoDefault' => $row->PromoDefault,
				'DateStart' => $row->DateStart,
				'DateEnd' => $row->DateEnd
			);
		
		$sql3 	= "SELECT pvd.*, pm.ProductName, pm.ProductCode, pm.ProductPriceDefault FROM tb_price_promo_vol_detail pvd
					LEFT JOIN tb_product_main pm ON (pvd.ProductID = pm.ProductID)
					WHERE pvd.PromoVolID=".$id." order by pm.ProductID, pvd.ProductQty";
		$query3 = $this->db->query($sql3);
		$result = $query3->result();
		if (empty($result)) {
			$show['promod'] = array();
		}
		foreach ($query3->result() as $row2) {
			$PriceAfterCategory = $this->get_min_percent($row2->ProductPriceDefault, $row->PromoDefault);
			$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row2->Promo);
			$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row2->PT1Discount);
			$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row2->PT2Discount);
			$show['promod'][] = array(
				'ProductID' => $row2->ProductID,
				'ProductName' => $row2->ProductName,
				'ProductCode' => $row2->ProductCode,
				'ProductQty' => $row2->ProductQty,
				'Promo' => $row2->Promo,
				'PT1Discount' => $row2->PT1Discount,
				'PT2Discount' => $row2->PT2Discount,
				'ProductPriceDefault' => $PriceAfterCategory,
				'ProductPricePT1' => $ProductPricePT1,
				'ProductPricePT2' => $ProductPricePT2
			);
		};

		$sql2 = "select * from tb_price_promo_vol_brand_category pld 
				LEFT JOIN tb_product_category c ON pld.ProductCategoryID=c.ProductCategoryID
				LEFT JOIN tb_product_brand b ON pld.ProductBrandID=b.ProductBrandID
				where pld.PromoVolID = '".$id."'";
		$query2 = $this->db->query($sql2);
		$result = $query2->result();
		if (!empty($result)) {
			foreach ($query2->result() as $row2) {
				$show['brandcategory'][] = array(
					'PromoVolID' => $row2->PromoVolID,
					'ProductCategoryID' => $row2->ProductCategoryID,
					'ProductBrandID' => $row2->ProductBrandID,
					'ProductCategoryName' => $row2->ProductCategoryName,
					'ProductBrandName' => $row2->ProductBrandName,
				);
			};
		} 

		$sql2 = "select * from tb_price_promo_vol_filter_percent pld where pld.PromoVolID = '".$id."'";
		$query2 = $this->db->query($sql2);
		$result = $query2->result();
		if (!empty($result)) {
			foreach ($query2->result() as $row2) {
				$show['percent'][] = array(
					'PromoVolID' => $row2->PromoVolID,
					'ProductQty' => $row2->ProductQty,
					'PromoPercent' => $row2->PromoPercent,
					'PT1Percent' => $row2->PT1Percent,
					'PT2Percent' => $row2->PT2Percent,
				);
			};
		} else {
			$show['percent'][] = array(
					'PromoVolID' => "",
					'ProductQty' => "",
					'PromoPercent' => "",
					'PT1Percent' => "",
					'PT2Percent' => "",
			);
		}

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function cek_product_promovol()
	{
		$show = array();
		$ProductID 	= $this->input->get_post('ProductID');
		$sql 	= "SELECT pld.PromoVolID, plm.PromoVolName FROM tb_price_promo_vol_detail pld
					LEFT JOIN tb_price_promo_vol_main plm ON pld.PromoVolID=plm.PromoVolID
					WHERE pld.ProductID='".$ProductID."' GROUP BY pld.PromoVolID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  		'PromoVolID' => $row->PromoVolID,
				'PromoVolName' => $row->PromoVolName
			);
		};
	    echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function clear_promo_volume()
	{
		$this->db->trans_start();
		$PromoVolID	= $this->input->get('promovolid');
		$deleted_row = 0;
		$massage = "";

		$this->db->where('PromoVolID', $PromoVolID);
		$this->db->delete('tb_price_promo_vol_detail');
		$this->last_query .= "//".$this->db->last_query();
		$deleted_row += $this->db->affected_rows();  

		$massage .= $deleted_row." Product telah dihapus";
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		echo json_encode($massage);
	}
	function update_product_promovol_by_filter()
	{
		$this->db->trans_start();
		$PromoVolID	= $this->input->get('promovolid');
		$where_brand_category = '';
		$show   = array();
		$deleted_row = 0;
		$inserted_row = 0;
		$ProductIDArr = array(); 

		$sql = "SELECT * FROM tb_price_promo_vol_filter_percent where PromoVolID=".$PromoVolID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$listPercent[] = array(
				'PromoVolID' => $row->PromoVolID,
				'ProductQty' => $row->ProductQty,
				'PromoPercent' => $row->PromoPercent,
				'PT1Percent' => $row->PT1Percent,
				'PT2Percent' => $row->PT2Percent,
			);
		}; 

		$this->db->where('ProductQty', $listPercent['ProductQty']);
		$this->db->where('Promo', $listPercent['PromoPercent']);
		$this->db->where('PT1Discount', $listPercent['PT1Percent']);
		$this->db->where('PT2Discount', $listPercent['PT2Percent']);
		$this->db->where('PromoVolID', $PromoVolID);
		$this->db->delete('tb_price_promo_vol_detail');
		$this->last_query .= "//".$this->db->last_query();
		$deleted_row += $this->db->affected_rows(); 

		$sql = "SELECT * FROM tb_price_promo_vol_brand_category where PromoVolID=".$PromoVolID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$where_brand_category .= '( ProductCategoryID ='.$row->ProductCategoryID.' and ProductBrandID='.$row->ProductBrandID.') or ';
		}; 
		$where_brand_category = ($where_brand_category != '') ? substr($where_brand_category, 0, -3): '' ;


		$sql = "SELECT ProductID, ProductCategoryID, ProductBrandID
				FROM tb_product_main WHERE ".$where_brand_category;
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
 
 			foreach ($listPercent as $key => $value) {
				$data_product[] = array(
					'PromoVolID' => $PromoVolID,
					'ProductID' => $row->ProductID,
					'ProductQty' => $value['ProductQty'],
					'Promo' => $value['PromoPercent'],
					'PT1Discount' => $value['PT1Percent'],
					'PT2Discount' => $value['PT2Percent']
				);
	   			$ProductIDArr[] = $row->ProductID; 
 			} 
		}; 

		if (isset($data_product)) {
			$inserted_row = count($data_product);
			$this->db->insert_batch('tb_price_promo_vol_detail', $data_product);
			$this->last_query .= "//".$this->db->last_query();
		} 

		if (!empty($ProductIDArr)) {
        	$this->load->model('model_master');
			$this->model_master->product_promo_history($ProductIDArr);
		}

		$massage = $deleted_row." Product telah dihapus,\n";
		$massage .= $inserted_row." Product ditambahkan ke PromoVolume";
		echo json_encode($massage);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// ====================================================================
	function get_min_percent($num1, $num2)
	{
		$result  = 0;
		$percent = ($num1/100)*$num2;
		$result  = $num1 - $percent; 
		return $result;
		$this->log_user->log_query($this->last_query);
	}

// shop===================================================================
	function shop_list()
	{
		$sql	= "SELECT s.*, se.SalesName as SalesName FROM tb_shop_main s
					LEFT JOIN vw_sales_executive2 se ON (s.SalesID = se.SalesID) ";

		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ShopID' => $row->ShopID,
	  			'ShopName' => $row->ShopName,
	  			'ShopLink' => $row->ShopLink,
	  			'ShopNote' => $row->ShopNote,
	  			'SalesName' => $row->SalesName,
			);
		};
	    return $show;
	}
	function shop_cu($val)
    {
		$show = array();
		$show['product'] = array() ;
		if ($val == "new") { 
			$show['main'] = array(
				'ShopID' => "",
			  	'ShopName' => "",
			  	'ShopLink' => "",
				'ShopNote' => "",
				'SalesID'	=> "",
				'SalesName' => "",
			);
		} else { 
			$sql	= "SELECT s.*, se.SalesName as SalesName FROM tb_shop_main s
						LEFT JOIN vw_sales_executive2 se ON (s.SalesID = se.SalesID)
						where ShopID=".$val;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			$show['main'] = array(
				'ShopID' => $row->ShopID,
			  	'ShopName' => $row->ShopName,
			  	'ShopLink' => $row->ShopLink,
				'ShopNote' => $row->ShopNote,
				'SalesID'	=> $row->SalesID,
				'SalesName' => $row->SalesName,
			);

			$sql3 	= "SELECT sp.*, pm.ProductName, pm.ProductCode FROM tb_shop_product sp 
						LEFT JOIN tb_product_main pm ON (sp.ProductID = pm.ProductID)
						WHERE sp.ShopID=".$val." order by sp.ProductID ";
			$query3 = $this->db->query($sql3);
			foreach ($query3->result() as $row2) {
				$show['product'][] = array(
					'ProductID' => $row2->ProductID,
					'ProductName' => $row2->ProductName,
					'ProductCode' => $row2->ProductCode,
					'LinkText' => $row2->LinkText,
				);
			};
			$show['product2'] = json_encode($show['product']);
		    return $show;
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function shop_cu_act()
	{
		$this->db->trans_start();

		$ShopID = $this->input->post('shopid');
		$ShopName = $this->input->post('shopname');
		$ShopLink = $this->input->post('shoplink');
		$ShopNote = $this->input->post('shopnote');
		$SalesID = $this->input->post('sales');
		$ProductID = $this->input->post('productid');
        $datetimenow = date("Y-m-d H:i:s");

		$data_main = array(
			'ShopName' => $ShopName,
			'ShopLink' => $ShopLink,
			'ShopNote' => $ShopNote,
			'SalesID' => $SalesID,
		);
 
		if ($ShopID == "") { //jika data pricelist baru
			$this->db->insert('tb_shop_main', $data_main);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(ShopID) as ShopID from tb_shop_main ";
			$getResult 	= $this->db->query($sql);
			$row 		= $getResult->row();
			$ShopID 	= $row->ShopID;

		} else { // jika data exist
			$this->db->where('ShopID', $ShopID);
			$this->db->update('tb_shop_main', $data_main);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where_not_in('ProductID', $ProductID);
			$this->db->delete('tb_shop_product');
			$this->last_query .= "//".$this->db->last_query();

			$sql 	= "SELECT ProductID FROM tb_shop_product sp WHERE sp.ShopID=".$ShopID;
			$query 	= $this->db->query($sql);
			$ProductID2 = array();
			foreach ($query->result_array() as $row) {
				$ProductID2[] = $row['ProductID'];
			};
			$ProductID = array_diff($ProductID, $ProductID2);
			$ProductID = array_values($ProductID);
		}

		if (!empty($ProductID)) {
			for ($i=0; $i < count($ProductID);$i++) { 
				$data_product[] = array(
					'ShopID' => $ShopID,
					'ProductID' => $ProductID[$i],
					'InputDate' => $datetimenow,
				);
			};
			$this->db->insert_batch('tb_shop_product', $data_product);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	} 
	function shop_update_link($val)
    {
		$show = array(); 
		$sql	= "SELECT s.*, se.SalesName as SalesName FROM tb_shop_main s
					LEFT JOIN vw_sales_executive2 se ON (s.SalesID = se.SalesID)
					where ShopID=".$val;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		$show['main'] = array(
			'ShopID' => $row->ShopID,
		  	'ShopName' => $row->ShopName,
		  	'ShopLink' => $row->ShopLink,
			'ShopNote' => $row->ShopNote,
			'SalesID'	=> $row->SalesID,
			'SalesName' => $row->SalesName,
		);
	    
	    $show['product'] = array();
		if ( ($this->auth->cek5('shop_cu')) || $row->SalesID == $this->session->userdata('SalesID') ) {
			$sql3 	= "SELECT sp.*, pm.ProductName, pm.ProductCode FROM tb_shop_product sp 
						LEFT JOIN tb_product_main pm ON (sp.ProductID = pm.ProductID)
						WHERE sp.ShopID=".$val." order by sp.ProductID ";
			$query3 = $this->db->query($sql3);
			foreach ($query3->result() as $row2) {
				$show['product'][] = array(
					'ProductID' => $row2->ProductID,
					'ProductName' => $row2->ProductName,
					'ProductCode' => $row2->ProductCode,
					'LinkText' => $row2->LinkText,
				);
			};
			$show['product2'] = json_encode($show['product']);
		    return $show;
		} else {
        	redirect(base_url('master/shop_list'));
		}
	}
	function shop_update_link_act()
	{
		$this->db->trans_start();
		$ShopID = $this->input->post('shopid');
		$ProductID = $this->input->post('productid');
		$LinkText = $this->input->post('linktext');
        $datetimenow = date("Y-m-d H:i:s");

		$this->db->set('LinkText', $LinkText);
		$this->db->set('LinkDate', $datetimenow);
		$this->db->where('ProductID', $ProductID);
		$this->db->where('ShopID', $ShopID);
		$this->db->update('tb_shop_product');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
		if ($this->db->trans_status() === FALSE) {
			echo json_encode("ERROR");
		} else {
			echo json_encode("SUCCESS");
		}
	}
	function shop_detail()
    {
		$show = array(); 
		$ShopID = $this->input->get_post('shopid'); 
		$sql	= "SELECT s.*, se.SalesName as SalesName FROM tb_shop_main s
					LEFT JOIN vw_sales_executive2 se ON (s.SalesID = se.SalesID)
					where ShopID=".$ShopID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		$show['main'] = array(
			'ShopID' => $row->ShopID,
		  	'ShopName' => $row->ShopName,
		  	'ShopLink' => $row->ShopLink,
			'ShopNote' => $row->ShopNote,
			'SalesID'	=> $row->SalesID,
			'SalesName' => $row->SalesName,
		);

		$sql3 	= "SELECT sp.*, pm.ProductName, pm.ProductCode FROM tb_shop_product sp 
					LEFT JOIN tb_product_main pm ON (sp.ProductID = pm.ProductID)
					WHERE sp.ShopID=".$ShopID." order by sp.ProductID ";
		$query3 = $this->db->query($sql3);
		$show['product'] = $query3->result_array();
		$show['product2'] = json_encode($show['product']);
	    return $show;
	}
	function product_link_list()
	{
		$sql	= "SELECT tpm.ProductID, tpm.ProductName, tsm.ShopID, tsm.ShopName, tsp.OrderID, tsp.LinkText, tsp.CheckDate FROM tb_product_main tpm
					LEFT JOIN tb_shop_product tsp ON tpm.ProductID=tsp.ProductID
					LEFT JOIN tb_shop_main tsm ON tsm.ShopID=tsp.ShopID
					ORDER BY tpm.ProductID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'OrderID' => $row->OrderID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ShopName' => $row->ShopName,
				'LinkText' => $row->LinkText,
				'CheckDate' => $row->CheckDate,
			);
		};
	    return $show;
	}
	function product_link_list_act($val)
	{
		$this->db->trans_start();

		$OrderID = $this->input->post('OrderID');

		$sql 	= "SELECT * FROM tb_shop_product WHERE OrderID = ".$OrderID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		$datetimenow = date("Y-m-d H:i:s");
		if ($val == "approve") {
			$this->db->set('UpdateBy', $this->session->userdata('UserAccountID'));
			$this->db->set('CheckDate', $datetimenow);
			$this->db->where('OrderID', $OrderID);
			$this->db->update('tb_shop_product');
			$this->last_query .= "//".$this->db->last_query();

		} else if ($val == "reject") {
			$data = array(
				'Actor3' => '668',
				'ProductID' => $row->ProductID,
				'OrderID' => $OrderID,
				'ShopID' => $row->ShopID,
				'Date' => date("Y-m-d"),
				'isComplete' => 0,
				'Status' => 'Pending',
			);
			$this->db->insert('tb_update_link', $data);
			$this->last_query .= "//".$this->db->last_query();
			// echo $this->last_query;
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function product_link_reject()
	{
        $OrderID = $this->input->get_post('OrderID');
		$sql	= "SELECT tpm.ProductID, tpm.ProductName, tsm.ShopID, tsm.ShopName, tsp.OrderID, tsp.LinkText, tsp.CheckDate FROM tb_product_main tpm
					LEFT JOIN tb_shop_product tsp ON tpm.ProductID=tsp.ProductID
					LEFT JOIN tb_shop_main tsm ON tsm.ShopID=tsp.ShopID
					WHERE tsp.OrderID=".$OrderID;
		$sql 	.= " ORDER BY tpm.ProductID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show   = array();

		foreach ($query->result() as $row) {
			$show[] = array(
				'OrderID' => $row->OrderID,
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ShopName' => $row->ShopName,
				'LinkText' => $row->LinkText,
				'CheckDate' => $row->CheckDate,
			);
		};
	    return $show;
	}
	function product_link_reject_act()
	{
		$this->db->trans_start();
		$OrderID = $this->input->post('orderid');
		$Note = $this->input->post('note');

		$sql 	= "SELECT * FROM tb_shop_product WHERE OrderID = ".$OrderID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$data = array(
			'Actor3' => '668',
			'ProductID' => $row->ProductID,
			'OrderID' => $OrderID,
			'ShopID' => $row->ShopID,
			'Date' => date("Y-m-d"),
			'isComplete' => 0,
			'Note' => $Note,
			'Status' => 'Pending',
		);
		$this->db->insert('tb_update_link', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
}

?>