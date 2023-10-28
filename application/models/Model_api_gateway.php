<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_api_gateway extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_product_category($parent = 0, $fullparent = '', $category_tree_array = array())
	{
		$sql 	= "SELECT pc.ProductCategoryID, pc.ProductCategoryName, pc.ProductCategoryParent 
					FROM tb_product_category pc
					WHERE pc.ProductCategoryParent=".$parent." GROUP BY pc.ProductCategoryID order by pc.ProductCategoryName";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$ProductCategoryChild = array_unique($this->get_full_category_child_id($row->ProductCategoryID));
				$sql 	= "SELECT count(ProductID) as countProduct
							FROM tb_product_main
							WHERE ProductCategoryID in (" . implode(',', array_map('intval', $ProductCategoryChild)) . ") ";
				$query 	= $this->db->query($sql);	
				$row2 	= $query->row();
				$countProduct = $row2->countProduct;

				$category_tree_array[$row->ProductCategoryID] = array(
					'CategoryID' => $row->ProductCategoryID,
					'CategoryName' => $row->ProductCategoryName,
					'CategoryParent' => $row->ProductCategoryParent,
					// 'CategoryChild' => array_unique($this->get_full_category_child_id($row->ProductCategoryID)),
					'CategoryProduct' => $countProduct,
				);
		      	$category_tree_array = $this->get_product_category($row->ProductCategoryID, $fullparent.$row->ProductCategoryName.'-', $category_tree_array);
			};
		}
		return $category_tree_array;
	}
	function get_full_category_child_id($parent, $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryID from tb_product_category 
					where ProductCategoryParent = ".$parent." ORDER by ProductCategoryID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$category_tree_array[] = $row->ProductCategoryID;
		      	$category_tree_array = $this->get_full_category_child_id($row->ProductCategoryID, $category_tree_array);
			}
		}
		$category_tree_array[] = $parent;
		return $category_tree_array;
	}
	function get_product_list()
	{
		//LIMIT 1880,20
		$show   = array();
		$sql 	= "SELECT *, GROUP_CONCAT(FileName SEPARATOR ';' ) AS ProductImage
				FROM (
					SELECT pm.ProductID, pm.ProductName, pm.ProductCategoryID, pm.forSale,pm.ProductPriceDefault, pf.FileName
					FROM tb_product_main pm
					LEFT JOIN tb_product_file pf ON pm.ProductID = pf.ProductID
					ORDER BY pm.ProductID
				) t1 GROUP BY t1.ProductID";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		foreach ($query->result() as $row) {
			$result = explode(";", $row->ProductImage);
			if (empty($result[0])){
					$result[0]="No_Image.jpg";
				}else{
					$result[0]=$result[0];
				}
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryID' => $row->ProductCategoryID,
				'forSale' => $row->forSale,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductImage1' => (array_key_exists(0, $result)) ?  base_url().'assets/ProductFile/'.$result[0] : '' ,
				'ProductImage2' => (array_key_exists(1, $result)) ?  base_url().'assets/ProductFile/'.$result[1] : '' ,
			);
		};
		return $show;
	}
	function get_price_list()
	{
		$show = array();
		$ProductID = $this->input->get_post('id');
		$ProductID = str_replace("'", "", htmlspecialchars($ProductID, ENT_QUOTES));
		$ProductName = $this->input->get_post('product');
		$ProductName = str_replace("'", "", htmlspecialchars($ProductName, ENT_QUOTES));
		$Category = $this->input->get_post('category');
		$Category = str_replace("'", "", htmlspecialchars($Category, ENT_QUOTES));
		$Brand = $this->input->get_post('brand');
		$Brand = str_replace("'", "", htmlspecialchars($Brand, ENT_QUOTES));
		$Expiry = $this->input->get_post('exp');
		$Expiry = str_replace("'", "", htmlspecialchars($Expiry, ENT_QUOTES));
		$origin=$this->input->get_post('origin');
		$origin = str_replace("'", "", htmlspecialchars($origin, ENT_QUOTES));

		$sql = "
			SELECT pm.ProductID, pm.ProductName, tpsi.EXPDate,
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault, tvp.cbd, ast.StateName, pm.ProductMultiplier, pm.ProductPriceHPP,pm.ProductCategoryID
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
		if (isset($ProductID) && $ProductID != '') {
			$sql .= "WHERE pm.ProductID like '%".$ProductID."' AND pm.forSale=1 ";
			// $show['info_filter'] .= "Product ID : ".$_REQUEST['productid']."<br>";
		} else if (isset($ProductName) && $ProductName != '') {
			$sql .= "WHERE pm.ProductName like '%".$ProductName."%' AND pm.forSale=1 ";
			// $show['info_filter'] .= "Product Name : ".$_REQUEST['productname']."<br>";
		} else {$sql .="WHERE psm.stock >0 AND pm.forSale=1 ";}
		if (isset($origin) && $origin != '') {
			$sql .= "AND pm.ProductCountry = '".$origin."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($Category) && $Category != '') {
			$sql .= "AND pm.ProductCategoryID = '".$Category."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$_REQUEST['origin']."<br>";
		} else {$sql .="";}
		if (isset($Brand) && $Brand != '') {
			$sql .= "AND pm.ProductBrandID  = '".$Brand."'";
		} else {$sql .="";}
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql1 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 AND ProductAtributeValueCode='".$_REQUEST['source']."'";
			// echo $sql1;
			$query1 = $this->db->query($sql1);
			$row1 	= $query1->row();
			$Origin=$row1->ProductAtributeValueName;
			$sql .= "AND tad.AtributeValue like '".$_REQUEST['source']."' ";
			// $show['info_filter'] .= "Source Of Origin : ".$Origin."<br>";
		} else {$sql .="";}
		if (isset($Expiry) && $Expiry != '') {
			$sql .= "AND tpsi.EXPDate is Not Null ";
			// $show['info_filter'] .= "Expiry : Not Null"."<br>";
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

			$show['produk'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCategoryID' => $row->ProductCategoryID,
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

		$sql6 = "SELECT pm.ProductID, pm.ProductName,
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault,pm.ProductCategoryID
			FROM tb_product_main pm
			LEFT JOIN vw_product_stock psm ON pm.ProductID = psm.ProductID
			LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
			LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
			LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
			LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent
			group by pm.ProductCategoryID
		";
		$query6 = $this->db->query($sql6);
		foreach ($query6->result() as $row6) {
			$show['kategori'][] = array(
				'ProductCategoryID' => $row6->ProductCategoryID,
				'ProductCategoryName' => $row6->ProductCategoryName,
			);
		};

		$sql7="
			SELECT pm.ProductID, pm.ProductName,
			COALESCE (psm.stock, 0) AS Stock,
			concat_ws('-', pb2.ProductBrandName, pb.ProductBrandName) AS ProductBrandName,
			concat_ws('-', pc2.ProductCategoryName, pc.ProductCategoryName) AS ProductCategoryName, pm.ProductPriceDefault,pm.ProductBrandID
			FROM tb_product_main pm
			LEFT JOIN vw_product_stock psm ON pm.ProductID = psm.ProductID
			LEFT JOIN tb_product_category pc ON pc.ProductCategoryID = pm.ProductCategoryID
			LEFT JOIN tb_product_category pc2 ON pc2.ProductCategoryID = pc.ProductCategoryParent
			LEFT JOIN tb_product_brand pb ON pb.ProductBrandID = pm.ProductBrandID
			LEFT JOIN tb_product_brand pb2 ON pb2.ProductBrandID = pb.ProductBrandParent

			group by pm.ProductBrandID

		";
		$query7 = $this->db->query($sql7);
		foreach ($query7->result() as $row7) {
			$show['brand'][] = array(
				'ProductBrandID' => $row7->ProductBrandID,
				'ProductBrandName' => $row7->ProductBrandName,
			);
		};

		return $show;
	}
	function get_product_detail()
	{
		$id = $this->input->get('id'); 
		$id = str_replace("'", "", htmlspecialchars($id, ENT_QUOTES));
		$sql 	= "
				SELECT *
				FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID
					left JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry
					left JOIN vw_product_origin vpo ON vpo.ProductID=pm.ProductID
					LEFT JOIN tb_product_file pf ON pf.ProductID=pm.ProductID
					LEFT JOIN tb_product_stock_in psi ON psi.ProductID=pm.ProductID
					where pm.ProductID = '".$id."'
					GROUP BY pm.ProductID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$isActive 	= ($row->isActive!="0" ? "Yes" : "No");
			$forSale 	= ($row->forSale!="0" ? "Yes" : "No");
			$Stockable 	= ($row->Stockable!="0" ? "Yes" : "No");
			$result1 = explode(";", $row->ProductImage);
			if (empty($result1[0])){
					$result1[0]="No_Image.jpg";
				}else{
					$result1[0]=$result1[0];
				}
			$show ['detail']= array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'ProductSupplier' => $row->ProductSupplier,
				'ProductDescription' => $row->ProductDescription,
				'ProductStatusName' => $row->ProductStatusName,
				'ProductCategoryID' => $row->ProductCategoryID,
				'ProductCategoryName' => $row->ProductCategoryName,
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
				'EXPDate' => $row->EXPDate,
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
				'FileName' => base_url().'assets/ProductFile/'.$row5->FileName
			);
		};
		
	    return $show;
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