<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_master3 extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }
	function get_full_category($parent = 0, $fullparent = '', $category_tree_array = array())
	{
		$sql 	= "SELECT COUNT(pc.ProductCategoryID) as num_child, pc.ProductCategoryID, pc.ProductCategoryName
					FROM tb_product_category pc
					LEFT JOIN tb_product_category pc2 ON pc.ProductCategoryID=pc2.ProductCategoryParent
					WHERE pc.ProductCategoryParent=".$parent." GROUP BY pc.ProductCategoryID order by pc.ProductCategoryName";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$category_tree_array[$row->ProductCategoryID] = array(
					'ProductCategoryID' => $row->ProductCategoryID,
					'ProductCategoryName' => $fullparent.$row->ProductCategoryName,
					'num_child' => $row->num_child
				);
		      	$category_tree_array = $this->get_full_category($row->ProductCategoryID, $fullparent.$row->ProductCategoryName.'-', $category_tree_array);
			};
		}
		return $category_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function get_full_brand($parent = 0, $fullparent = '', $brand_tree_array = array())
	{
		$sql = "SELECT COUNT(pc.ProductBrandID) as num_child, pc.ProductBrandID, pc.ProductBrandName
				FROM tb_product_brand pc
				LEFT JOIN tb_product_brand pc2 ON pc.ProductBrandID=pc2.ProductBrandParent
				WHERE pc.ProductBrandParent=".$parent." GROUP BY pc.ProductBrandID order by pc.ProductBrandName";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$brand_tree_array[$row->ProductBrandID] = array(
					'ProductBrandID' => $row->ProductBrandID,
					'ProductBrandName' => $fullparent.$row->ProductBrandName,
					'num_child' => $row->num_child
				);
		      	$brand_tree_array = $this->get_full_brand($row->ProductBrandID, $fullparent.$row->ProductBrandName.'-', $brand_tree_array);
			};
		}
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}    
// price_list================================================================
	function price_list()
	{
		$sql	= "SELECT plm.*, pcd.*, pcm.*, COUNT(pld.PricelistID) as numberP FROM tb_price_list_main plm 
					LEFT JOIN tb_price_category_detail pcd ON (plm.PricelistID=pcd.PricelistID) 
					LEFT JOIN tb_price_category_main pcm ON (pcm.PricecategoryID=pcd.PricecategoryID)
					LEFT JOIN tb_price_list_detail pld ON (plm.PricelistID=pld.PricelistID)
					GROUP BY plm.PricelistID";
		$show   = array();
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PricelistID' => $row->PricelistID,
		  			'PricelistName' => $row->PricelistName,
		  			'PricelistNote' => $row->PricelistNote,
		  			'PricecategoryName' => $row->PricecategoryName,
					'DateStart' => $row->DateStart,
					'DateEnd' => $row->DateEnd,
					'isActive' => $row->isActive,
					'numberP' => $row->numberP,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function price_list_cu($val)
    {
		$show = array();
		if ($val == "new") { //jika data contact baru
			$show['pricelist'] = array(
				'PricelistID' => "",
			  	'PricelistName' => "",
				'DateStart' => "",
				'DateEnd'	=> "",
				'PricelistNote' => "",
				'isActive' => "1",

				'PromoPercent' => "0",
				'PT1Percent' => "0",
				'PT2Percent' => "0",
			);
		} else { // jika data pricelist exist
			$sql 	= "SELECT plm.*, COALESCE(fp.PromoPercent,0) as PromoPercent, COALESCE(fp.PT1Percent,0) as PT1Percent, 
						COALESCE(fp.PT2Percent,0) as PT2Percent  
						FROM tb_price_list_main plm 
						LEFT JOIN tb_price_list_filter_percent fp ON plm.PricelistID=fp.PricelistID
						where plm.PricelistID = '".$val."'";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			if (empty($row)) {
				redirect(base_url());
			} else {
				$sql3 	= "SELECT PricecategoryID FROM tb_price_category_detail pcd where pcd.PricelistID = '".$val."'";
				$query3 = $this->db->query($sql3);
				$row3 	= $query3->row();
				
				$show['pricelist'] = array(
				  	'PricelistID' => $val,
					'PricelistName' => "$row->PricelistName",
					'DateStart' => "$row->DateStart",
					'DateEnd' => "$row->DateEnd",
					'PricelistNote' => "$row->PricelistNote",
					'isActive' => "$row->isActive",
					'PricecategoryID' => "$row3->PricecategoryID",

					'PromoPercent' => $row->PromoPercent,
					'PT1Percent' => $row->PT1Percent,
					'PT2Percent' => $row->PT2Percent,
				);
			
				$sql2 = "select * from tb_price_list_detail pld ";
				$sql2 .= "left join tb_price_list_main plm on(plm.PricelistID = pld.PricelistID) ";
				$sql2 .= "left join tb_product_main p on(p.ProductID = pld.ProductID) ";
				$sql2 .= "where pld.PricelistID = '".$val."' order by pld.ProductID";
				$query2 = $this->db->query($sql2);
				foreach ($query2->result() as $row2) {
					$show['pricelistd'][] = array(
						'PricelistID' => $row2->PricelistID,
						'ProductID' => $row2->ProductID,
						'Promo' => $row2->Promo,
						'PT1Discount' => $row2->PT1Discount,
						'PT2Discount' => $row2->PT2Discount,
						'ProductName' => $row2->ProductName,
						'status' => "old",
					);
				};

				$sql2 = "select * from tb_price_list_detail_approval pld ";
				$sql2 .= "left join tb_price_list_main plm on(plm.PricelistID = pld.PricelistID) ";
				$sql2 .= "left join tb_product_main p on(p.ProductID = pld.ProductID) ";
				$sql2 .= "where pld.PricelistID = '".$val."' and isApprove is null order by pld.ProductID";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$show['pricelistd'][] = array(
							'PricelistID' => $row2->PricelistID,
							'ProductID' => $row2->ProductID,
							'Promo' => $row2->Promo,
							'PT1Discount' => $row2->PT1Discount,
							'PT2Discount' => $row2->PT2Discount,
							'ProductName' => $row2->ProductName,
							'status' => "new",
						);
					};
				} else {
					$show['pricelistd'][] = array(
						'PricelistID' => "",
						'ProductID' => "",
						'Promo' => "",
						'PT1Discount' => "",
						'PT2Discount' => "",
						'ProductName' => "",
						'status' => "old",
					);
				}
				$show['pricelistd2'] = json_encode( $show['pricelistd'] );


				$sql2 = "select * from tb_price_list_brand_category pld where pld.PricelistID = '".$val."'";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				if (!empty($result)) {
					foreach ($query2->result() as $row2) {
						$show['pricelistBC'][] = array(
							'PricelistID' => $row2->PricelistID,
							'ProductCategoryID' => $row2->ProductCategoryID,
							'ProductBrandID' => $row2->ProductBrandID,
						);
					};
				} else {
					$show['pricelistBC'][] = array(
						'PricelistID' => "",
						'ProductCategoryID' => "",
						'ProductBrandID' => "",
					);
				}
				$show['pricelistBC2'] = json_encode( $show['pricelistBC'] );
			}
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function manage_api_product_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		// print_r($this->input->post());
		$PricelistID	= $this->input->post('pricelistid'); 
		$pname 			= $this->input->post('pname'); 
		$pnote 			= $this->input->post('pnote'); 
		$pstart 		= $this->input->post('pstart'); 
		$pend			= $this->input->post('pend'); 
		$isActive		= $this->input->post('isActive'); 
		$product 		= $this->input->post('product'); 
		$status 		= $this->input->post('status'); 
		$promo 			= $this->input->post('promo');
		$top 			= $this->input->post('top');
		$cbd 			= $this->input->post('cbd');
		$pricecategory	= $this->input->post('pricecategory');
        $datetimenow	= date("Y-m-d H:i:s");

		$Category	= $this->input->post('CategoryID');
		$Brand	= $this->input->post('BrandID');
		$promo_filter	= $this->input->post('promo_filter');
		$TOP_filter	= $this->input->post('TOP_filter');
		$CBD_filter	= $this->input->post('CBD_filter');

		$noteApproval = "";
		$errorCount = 0;

		$pl_main = array(
			'PricelistName'	=> $pname,
			'PricelistNote' => $pnote,
			'DateStart' => $pstart,
			'DateEnd' => $pend,
			'isActive' => $isActive,
		);

		// get actor 3 approval
		$sql 		= "select Actor3 from tb_approval_actor where ApprovalCode='product_price_list' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		if ($PricelistID != "") { //jika data pricelist baru

			// compare main ------------------------------------
				$sqlMain 	= "SELECT plm.*, COALESCE(fp.PromoPercent,0) as PromoPercent, COALESCE(fp.PT1Percent,0) as PT1Percent, 
						COALESCE(fp.PT2Percent,0) as PT2Percent  
						FROM tb_price_list_main plm 
						LEFT JOIN tb_price_list_filter_percent fp ON plm.PricelistID=fp.PricelistID
						where plm.PricelistID = '".$PricelistID."'";
				$query3 = $this->db->query($sqlMain);
				$rowM 	= $query3->row();
				$data1M = array(
				  	'PricelistID' => $PricelistID,
					'PricelistName' => $rowM->PricelistName,
					'DateStart' => $rowM->DateStart,
					'DateEnd' => $rowM->DateEnd,
					'PricelistNote' => $rowM->PricelistNote,
					'isActive' => $rowM->isActive,

					'PromoPercent' => $rowM->PromoPercent,
					'PT1Percent' => $rowM->PT1Percent,
					'PT2Percent' => $rowM->PT2Percent,
				);
				if 	(!(
						$data1M['PricelistName'] === $pl_main['PricelistName'] && 
				    	$data1M['DateStart'] === $pl_main['DateStart'] && 
				    	$data1M['DateEnd'] === $pl_main['DateEnd'] && 
				    	$data1M['isActive'] === $pl_main['isActive'] && 
				    	$data1M['PricelistNote'] === $pl_main['PricelistNote']
					)) {
					$errorCount += 1;
				}
			// -----------------------------------------------------------

			// compare qty percent ------------------------------------
				// from post
				$p_f_p = array(
					'PromoPercent' => $promo_filter,
					'PT1Percent' => $TOP_filter,
					'PT2Percent' => $CBD_filter,
				);

				$data1FP = array();
				$sql2 = "select * from tb_price_list_filter_percent pld where pld.PricelistID = '".$PricelistID."'";
				$query2 = $this->db->query($sql2);
				$result = $query2->result();
				foreach ($query2->result() as $row2) {
					$data1FP = array(
						'PromoPercent' => $row2->PromoPercent,
						'PT1Percent' => $row2->PT1Percent,
						'PT2Percent' => $row2->PT2Percent,
					);
				};

				if 	(!(
				    	$data1FP['PromoPercent'] === $p_f_p['PromoPercent']  && 
				    	$data1FP['PT1Percent'] === $p_f_p['PT1Percent']  && 
				    	$data1FP['PT2Percent'] === $p_f_p['PT2Percent'] 
					)) {
					$errorCount += 1;
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
				$sql2 = "select * from tb_price_list_brand_category pld where pld.PricelistID = '".$PricelistID."'";
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


		if ($PricelistID == "") { //jika data pricelist baru
			$this->db->insert('tb_price_list_main', $pl_main);
			$this->last_query .= "//".$this->db->last_query();

			$sql 			= "select max(PricelistID) as PricelistID, PricelistName from tb_price_list_main ";
			$getPricelistID = $this->db->query($sql);
			$row 			= $getPricelistID->row();
			$PricelistID 	= $row->PricelistID;
			$PricelistName 	= $row->PricelistName;

			// ------------------------------------------------------------
			$p_f_p = array(
				'PricelistID' => $PricelistID,
				'PromoPercent' => 0,
				'PT1Percent' => 0,
				'PT2Percent' => 0,
			);
			$this->db->insert('tb_price_list_filter_percent', $p_f_p);
			$this->last_query .= "//".$this->db->last_query();
			// ------------------------------------------------------------

			// ------------------------------------------------------------
			$noteApproval .= "tambahan ".count($Category)." filter BrandCategory <br>";
			// if ($Actor3 != 0) {
				$data_approval = array(
			        'PricelistID' => $PricelistID,
			        'isComplete' => "0",
			        'Status' => "OnProgress",
			        // 'Title' => "Add Product to '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			        'Title' => "Edit '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			        'Note' => $noteApproval,
				);
			// } else {
			// 	$data_approval = array(
			//         'PricelistID' => $PricelistID,
			//         'isComplete' => "1",
			//         'Status' => "Approved",
			//         // 'Title' => "Add Product to '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			//         'Title' => "Edit '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			//         'Note' => $noteApproval,
			// 	);
			// }
			$this->db->insert('tb_approval_price_list', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$sql 			= "select max(ApprovalID) as ApprovalID from tb_approval_price_list ";
			$getApprovalID  = $this->db->query($sql);
			$row 			= $getApprovalID->row();
			$ApprovalID 	= $row->ApprovalID;

			// insert approval detail ---------------------------------------
			$pl_main = array(
				'ApprovalID' => $ApprovalID,
		        'PricelistID' => $PricelistID,
				'PricelistName'	=> $pname,
				'PricelistNote' => $pnote,
				'DateStart' => $pstart,
				'DateEnd' => $pend,
				'isActive' => $isActive,
			);
			$this->db->insert('tb_price_list_approval_main', $pl_main);
			$this->last_query .= "//".$this->db->last_query();

			for ($i=0; $i < count($Category);$i++) { 
				$p_b_c = array(
					'ApprovalID' => $ApprovalID,
					'PricelistID' => $PricelistID,
					'ProductCategoryID' => $Category[$i],
					'ProductBrandID' => $Brand[$i]
				);
				$this->db->insert('tb_price_list_approval_brand_category', $p_b_c);
				$this->last_query .= "//".$this->db->last_query();
			};

			$p_f_p = array(
				'ApprovalID' => $ApprovalID,
				'PricelistID' => $PricelistID,
				'PromoPercent' => $promo_filter,
				'PT1Percent' => $TOP_filter,
				'PT2Percent' => $CBD_filter,
			);
			$this->db->insert('tb_price_list_approval_filter_percent', $p_f_p);
			$this->last_query .= "//".$this->db->last_query();
			// ------------------------------------------------------------

			if (in_array("new", $status)) {
				for ($i=0; $i < count($product);$i++) { 
					$data_p_detail = array(
						'PricelistID' => $PricelistID,
						'ProductID' => $product[$i],
						'Promo' => $promo[$i],
						'PT1Discount' => $top[$i],
						'PT2Discount' => $cbd[$i],
						'DateInput' => $datetimenow,
						'DateApproval' => $datetimenow,
						'ApprovalID' => $ApprovalID,
					);
					$this->db->insert('tb_price_list_detail_approval', $data_p_detail);
					$this->last_query .= "//".$this->db->last_query();
				};
			}

		} else { // jika data pricelist exist
			// $this->db->where('PricelistID', $PricelistID);
			// $this->db->update('tb_price_list_main', $pl_main);
			// $this->last_query .= "//".$this->db->last_query();

			// $this->db->set('isApprove', "0");
			// $this->db->where('isApprove', null);
			// $this->db->where('PricelistID', $PricelistID);
			// $this->db->update('tb_price_list_detail_approval');

			$this->db->set('isComplete', 1);
			$this->db->set('Status', "Rejected");
			$this->db->where('PricelistID', $PricelistID);
			$this->db->where('isComplete', 0);
			$this->db->update('tb_approval_price_list');
			$this->last_query .= "//".$this->db->last_query();

			if ($errorCount > 0) {

			// if (in_array("new", $status)) {
			// 	if ($Actor3 != 0) {
					$data_approval = array(
				        'PricelistID' => $PricelistID,
				        'isComplete' => "0",
				        'Status' => "OnProgress",
				        'Title' => "Edit '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
				        'Note' => $noteApproval,
					);
			// 	} else {
			// 		$data_approval = array(
			// 	        'PricelistID' => $PricelistID,
			// 	        'isComplete' => "1",
			// 	        'Status' => "Approved",
			//         	'Title' => "Add Product to '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			// 		);
			// 	}
				$this->db->insert('tb_approval_price_list', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
				
				$sql 			= "select max(ApprovalID) as ApprovalID from tb_approval_price_list ";
				$getApprovalID  = $this->db->query($sql);
				$row 			= $getApprovalID->row();
				$ApprovalID 	= $row->ApprovalID;
			// }

				// insert approval detail ---------------------------------------
				$pl_main = array(
					'ApprovalID' => $ApprovalID,
			        'PricelistID' => $PricelistID,
					'PricelistName'	=> $pname,
					'PricelistNote' => $pnote,
					'DateStart' => $pstart,
					'DateEnd' => $pend,
					'isActive' => $isActive,
				);
				$this->db->insert('tb_price_list_approval_main', $pl_main);
				$this->last_query .= "//".$this->db->last_query();

				for ($i=0; $i < count($Category);$i++) { 
					$p_b_c = array(
						'ApprovalID' => $ApprovalID,
						'PricelistID' => $PricelistID,
						'ProductCategoryID' => $Category[$i],
						'ProductBrandID' => $Brand[$i]
					);
					$this->db->insert('tb_price_list_approval_brand_category', $p_b_c);
					$this->last_query .= "//".$this->db->last_query();
				};

				$p_f_p = array(
					'ApprovalID' => $ApprovalID,
					'PricelistID' => $PricelistID,
					'PromoPercent' => $promo_filter,
					'PT1Percent' => $TOP_filter,
					'PT2Percent' => $CBD_filter,
				);
				$this->db->insert('tb_price_list_approval_filter_percent', $p_f_p);
				$this->last_query .= "//".$this->db->last_query();
				// ------------------------------------------------------------

			}
			
			// $this->db->where('PricelistID', $PricelistID);
			// $this->db->delete('tb_price_list_detail');
			for ($i=0; $i < count($product);$i++) { 
				if ($status[$i] == "old") {
					// $data_p_detail = array(
					// 	'PricelistID' => $PricelistID,
					// 	'ProductID' => $product[$i],
					// 	'Promo' => $promo[$i],
					// 	'PT1Discount' => $top[$i],
					// 	'PT2Discount' => $cbd[$i]
					// );
					// $this->db->insert('tb_price_list_detail', $data_p_detail);
					// $this->last_query .= "//".$this->db->last_query();
				} else {
					$this->db->where('ProductID', $product[$i]);
					$this->db->where('PricelistID', $PricelistID);
					$this->db->delete('tb_price_list_detail');
					
					$this->db->where('ProductID', $product[$i]);
					$this->db->where('PricelistID', $PricelistID);
					$this->db->delete('tb_price_list_detail_approval');
							
					$data_p_detail = array(
						'PricelistID' => $PricelistID,
						'ProductID' => $product[$i],
						'Promo' => $promo[$i],
						'PT1Discount' => $top[$i],
						'PT2Discount' => $cbd[$i],
						'DateInput' => $datetimenow,
						'DateApproval' => $datetimenow,
						'ApprovalID' => $ApprovalID,
					);
					$this->db->insert('tb_price_list_detail_approval', $data_p_detail);
					$this->last_query .= "//".$this->db->last_query();
				}
			};

			// if (in_array("new", $status)) {
			// 	if ($Actor3 == 0) {
			// 		$this->db->set('isApprove', 1);
			// 		$this->db->set('ApprovalBy', $this->session->userdata('UserAccountID'));
			// 		$this->db->where('PricelistID', $PricelistID);
			// 		$this->db->where('ApprovalID', $ApprovalID);
			// 		$this->db->update('tb_price_list_detail_approval');
			// 		$this->last_query .= "//".$this->db->last_query();
					
		 //        	$this->load->model('model_approval');
			// 		$this->model_approval->approve_price_list_implementation($PricelistID, $ApprovalID);
			// 	}
			// }

		}
			
			// $this->db->where('PricelistID', $PricelistID);
			// $this->db->delete('tb_price_list_filter_percent');
			// $p_f_p = array(
			// 	'PricelistID' => $PricelistID,
			// 	'PromoPercent' => $promo_filter,
			// 	'PT1Percent' => $TOP_filter,
			// 	'PT2Percent' => $CBD_filter,
			// );
			// $this->db->insert('tb_price_list_approval_filter_percent', $p_f_p);
			// $this->last_query .= "//".$this->db->last_query();
			// // ------------------------------------------------------------

		if ($Actor3 == 0 && isset($ApprovalID)) {
			$this->db->set('isComplete', '1');
			$this->db->set('Status', 'Approved');
			$this->db->set('isApprove', 1);
			$this->db->set('ApprovalBy', $this->session->userdata('UserAccountID'));
			$this->db->where('PricelistID', $PricelistID);
			$this->db->where('ApprovalID', $ApprovalID);
			$this->db->update('tb_price_list_detail_approval');
			$this->last_query .= "//".$this->db->last_query();
			
        	$this->load->model('model_approval');
			$this->model_approval->approve_price_list_implementation($PricelistID, $ApprovalID);
		}

		// update priceCtaegory -----------------------------------------
		$this->db->where('PricelistID', $PricelistID);
		$this->db->delete('tb_price_category_detail');
		$pc_detail = array(
			'PricecategoryID' => $pricecategory,
			'PricelistID' => $PricelistID
		);
		$this->db->insert('tb_price_category_detail', $pc_detail);
		$this->last_query .= "//".$this->db->last_query();
		// ------------------------------------------------------------

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function price_list_detail()
    {
		$show   = array();
		$id 	= $this->input->get('a'); 

		$sql = "SELECT plm.*, pcm.PricecategoryName, pcm.PromoDefault
				FROM tb_price_list_main plm
				LEFT JOIN tb_price_category_detail pcd ON plm.PricelistID=pcd.PricelistID
				LEFT JOIN tb_price_category_main pcm ON pcd.PricecategoryID=pcm.PricecategoryID
				WHERE plm.PricelistID='".$id."' ";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['main'] = array(
		  	'PricelistID' => $row->PricelistID,
			'PricelistName' => $row->PricelistName,
			'DateStart' => $row->DateStart,
			'DateEnd' => $row->DateEnd,
			'PricelistNote' => $row->PricelistNote,
			'PricecategoryName' => $row->PricecategoryName,
			'PromoDefault' => $row->PromoDefault
		);
		
		$sql = "SELECT * FROM tb_price_list_filter_percent WHERE PricelistID='".$id."' ";
		$query 	= $this->db->query($sql);
		$row1 	= $query->row();
		if (empty($row1)) {
			$show['percent'] = array(
			  	'PricelistID' => "",
				'PromoPercent' => "",
				'PT1Percent' => "",
				'PT2Percent' => "",
			);
		} else {
			$show['percent'] = array(
			  	'PricelistID' => $row1->PricelistID,
				'PromoPercent' => $row1->PromoPercent,
				'PT1Percent' => $row1->PT1Percent,
				'PT2Percent' => $row1->PT2Percent,
			);
		}

		$sql2 = "SELECT bc.*, c.ProductCategoryName, b.ProductBrandName
				FROM tb_price_list_brand_category bc
				LEFT JOIN tb_product_category c ON bc.ProductCategoryID=c.ProductCategoryID
				LEFT JOIN tb_product_brand b ON bc.ProductBrandID=b.ProductBrandID
				WHERE bc.PricelistID='".$id."'";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			$show['brandcategory'][] = array(
				'PricelistID' => $row2->PricelistID,
				'ProductCategoryID' => $row2->ProductCategoryID,
				'ProductBrandID' => $row2->ProductBrandID,
				'ProductCategoryName' => $row2->ProductCategoryName,
				'ProductBrandName' => $row2->ProductBrandName,
			);
		};

		$sql2 = "select * from tb_price_list_detail pld ";
		$sql2 .= "left join tb_price_list_main plm on(plm.PricelistID = pld.PricelistID) ";
		$sql2 .= "left join tb_product_main p on(p.ProductID = pld.ProductID) ";
		$sql2 .= "where pld.PricelistID = '".$id."' order by pld.ProductID";
		$query2 	= $this->db->query($sql2);
		if (empty($query2)) {
			$show['pricelistd'][] = array(
				'PricelistID' => "",
				'ProductID' => "",
				'Promo' => "",
				'PT1Discount' => "",
				'PT2Discount' => "",
				'ProductCode' => "",
				'ProductPriceDefault' => 0,
				'ProductPricePT1' => 0,
				'ProductPricePT2' => 0
			);
		} else {
			foreach ($query2->result() as $row3) {
				$PriceAfterCategory = $this->get_min_percent($row3->ProductPriceDefault, $row->PromoDefault);
				$ProductPricePromo = $this->get_min_percent($PriceAfterCategory, $row3->Promo);
				$ProductPricePT1 = $this->get_min_percent($ProductPricePromo, $row3->PT1Discount);
				$ProductPricePT2 = $this->get_min_percent($ProductPricePromo, $row3->PT2Discount);

				$show['pricelistd'][] = array(
					'PricelistID' => $row3->PricelistID,
					'ProductID' => $row3->ProductID,
					'Promo' => $row3->Promo,
					'PT1Discount' => $row3->PT1Discount,
					'PT2Discount' => $row3->PT2Discount,
					'ProductCode' => $row3->ProductCode,
					'ProductPriceDefault' => $PriceAfterCategory,
					'ProductPricePT1' => $ProductPricePT1,
					'ProductPricePT2' => $ProductPricePT2
				);
			};
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function cek_product_pricelist()
	{
		$show = array();
		$ProductID 	= $this->input->get_post('ProductID');
		$sql 	= "SELECT pld.PricelistID, plm.PricelistName FROM tb_price_list_detail pld
					LEFT JOIN tb_price_list_main plm ON pld.PricelistID=plm.PricelistID
					WHERE pld.ProductID='".$ProductID."'";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  		'PricelistID' => $row->PricelistID,
				'PricelistName' => $row->PricelistName
			);
		};
	    echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function update_product_price_by_filter()
	{
		$this->db->trans_start();
		$pricelistid	= $this->input->get('pricelistid');
		$where_brand_category = '';
		$show   = array();
		$deleted_row = 0;
		$inserted_row = 0;
		$massage = "";

		$sql = "SELECT * FROM tb_price_list_filter_percent where PricelistID=".$pricelistid;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$listPercent = array(
				'PricelistID' => $row->PricelistID,
				'PromoPercent' => $row->PromoPercent,
				'PT1Percent' => $row->PT1Percent,
				'PT2Percent' => $row->PT2Percent, 
			);
		}; 

		$sql = "SELECT * FROM tb_price_list_brand_category where PricelistID=".$pricelistid;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$where_brand_category .= '( ProductCategoryID ='.$row->ProductCategoryID.' and ProductBrandID='.$row->ProductBrandID.') or ';
		}; 
		$where_brand_category = ($where_brand_category != '') ? substr($where_brand_category, 0, -3): '' ;

		$sql = "SELECT ProductID, ProductCategoryID, ProductBrandID
				FROM tb_product_main 
				WHERE ProductID not in (
				SELECT ProductID FROM tb_price_list_detail WHERE PricelistID=".$pricelistid."
				) and ".$where_brand_category;
		if ($where_brand_category != '') {
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				// $this->db->where('ProductID', $row->ProductID);
				// $this->db->where('PricelistID', $pricelistid);
				// $this->db->delete('tb_price_list_detail');
				// $this->last_query .= "//".$this->db->last_query();
				// $deleted_row += $this->db->affected_rows(); 
	 
				$data_p_detail = array(
					'PricelistID' => $pricelistid,
					'ProductID' => $row->ProductID,
					'Promo' => $listPercent['PromoPercent'],
					'PT1Discount' => $listPercent['PT1Percent'],
					'PT2Discount' => $listPercent['PT2Percent'],
				);
				$this->db->insert('tb_price_list_detail', $data_p_detail);
				$this->last_query .= "//".$this->db->last_query();
				$inserted_row += $this->db->affected_rows();
			}; 
		}
 
		$massage .= $deleted_row." Product telah dihapus,\n";
		$massage .= $inserted_row." Product ditambahkan ke PriceList";
		echo json_encode($massage);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	
// brand=====================================================================
	function brand_list($parent = 0, $spacing = '', $brand_tree_array = array())
	{
		$sql 	= "SELECT pb1.*, pb2.ProductBrandName as parentname FROM tb_product_brand pb1 LEFT JOIN tb_product_brand pb2 on pb1.ProductBrandParent=pb2.ProductBrandID where pb1.ProductBrandParent = ".$parent." ORDER by pb1.ProductBrandName";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$brand_tree_array[] = array(
					'ProductBrandID' => $row->ProductBrandID,
		  			'ProductBrandName' => $spacing.$row->ProductBrandName,
		  			'ProductBrandCode' => $row->ProductBrandCode,
		  			'ProductBrandParent' => $row->parentname,
		  			'ProductBrandDescription' => $row->ProductBrandDescription
				);
		      	$brand_tree_array = $this->brand_list($row->ProductBrandID, $spacing.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $brand_tree_array);
			};
		}
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function brand_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$parent = $this->input->post('parent'); 
		$code 	= $this->input->post('code'); 
		$description = $this->input->post('description'); 

		$data = array(
	        'ProductBrandName' 	=> $name,
			'ProductBrandParent' => $parent,
			'ProductBrandCode' 	=> $code,
			'ProductBrandDescription' 	=> $description
		);
		$this->db->insert('tb_product_brand', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function brand_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$name 	= $this->input->post('name2'); 
		$code 	= $this->input->post('code2'); 
		$description = $this->input->post('description2'); 

		$data = array(
	        'ProductBrandName' 	=> $name,
			'ProductBrandCode' 	=> $code,
			'ProductBrandDescription' 	=> $description
		);
		$this->db->where('ProductBrandID', $id);
		$this->db->update('tb_product_brand', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	

}

?>