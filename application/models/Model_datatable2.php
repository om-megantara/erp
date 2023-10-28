<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_datatable2 extends CI_Model {

	var $table = ''; //nama tabel dari database
	var $column_select = ''; //field yang ada di table user
	var $column_order = array(); //field yang ada di table user
	var $column_search = array(); //field yang diizin untuk pencarian 
	var $order = array(); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

// where ==========================================================
	public function filter_contact()
	{
		// nothing
	}
	public function filter_customer()
	{
		if (!$this->auth->cek5('customer_list_all')) {
			$SalesID = array( $this->session->userdata('SalesID') );
			if ($SalesID[0] != '0') {
		        $this->load->model('Model_report');
				$SalesID = $this->Model_report->get_sales_child($SalesID);
				$subQuery = "( select * from (select CustomerID from tb_customer_detail where DetailType='sales' and DetailValue in (" . implode(',', array_map('intval', $SalesID)) . ") ) as subQuery) ";
				$this->db->where("CustomerID in ".$subQuery);
			}
		}
	}
	public function filter_product()
	{
		if($this->input->post('name'))
		{
			$this->db->like('ProductName', $this->input->post('name'));
		}
		if($this->input->post('code'))
		{
			$this->db->like('ProductCode', $this->input->post('code'));
		}
		if($this->input->post('description'))
		{
			$this->db->like('ProductDescription', $this->input->post('description'));
		}
		if($this->input->post('category'))
		{
			$this->db->like('ProductCategoryName', $this->input->post('category'));
		}
		if($this->input->post('brand'))
		{
			$this->db->like('ProductBrandName', $this->input->post('brand'));
		}
	}
	public function filter_product2()
	{
		if($this->input->post('atributeid'))
		{
			$atributeid = $this->input->post('atributeid');
			$atributevalue = $this->input->post('atributevalue');
			$atributeConn = $this->input->post('atributeConn');

			$subQuery = "(select ProductID from vw_product_atribute where ";
			for ($i = 0; $i < count($atributeid); $i++) {
				if ($atributeid[$i] != 'ProductID') {
					$subQuery .= "AtributeID like '%".$atributeid[$i].':'.$atributevalue[$i]."%' ".$atributeConn[$i]." ";
				} else {
					$subQuery .= "ProductID =".$atributevalue[$i]." ".$atributeConn[$i]." ";
				}
			}
			$subQuery = substr($subQuery, 0, -4);
			$subQuery .= ")";
			$this->db->where("t1.ProductID in ($subQuery)", NULL, FALSE);
			// $this->db->where($this->table.".ProductID in ($subQuery)", NULL, FALSE);
			// $this->db->where($this->table.".ProductID in ".$subQuery);
		}
		if($this->input->post('category') && $this->input->post('category') != '0')
		{
	        $this->load->model('model_master');
        	$category_full_child = $this->model_master->get_full_category_child_id($this->input->post('category'));
			$category = implode(',', array_map('intval', $category_full_child));
			$this->db->where_in('ProductCategoryID', $category_full_child);
		}
		if($this->input->post('brand') && $this->input->post('brand') != '0')
		{
			$this->load->model('model_master');
        	$brand_full_child = $this->model_master->get_full_brand_child_id($this->input->post('brand'));
			$brand = implode(',', array_map('intval', $brand_full_child));
			$this->db->where_in('ProductBrandID', $brand_full_child);
		}
		if($this->input->post('stockAll'))
		{
			if ($this->input->post('stockAll') == 1) {
				$this->db->where('stock <>', 0);
			} else if ($this->input->post('stockAll') == 2) {
				$this->db->where('stock = 0');
			} else if ($this->input->post('stockAll') == 'UM') {
				$this->db->where('stock < MinStock');
			} 
		}
		if($this->input->post('stockW'))
		{
			if ($this->input->post('stockW') == 1) {
				$this->db->where('Quantity <>', 0);
			}
		}
		if($this->input->post('stockReady'))
		{
			if ($this->input->post('stockReady') == 1) {
				$this->db->where('ReadyStock <>', 0);
			}
		}
		if($this->input->post('stock'))
		{
			if ($this->input->post('stock') == 'STA-NZ') {
				$this->db->where('stockAll <>', 0);
			} else if ($this->input->post('stock') == 'STW-NZ') {
				$this->db->where('stockWarehouse <>', 0);
			} else if ($this->input->post('stock') == 'STR-NZ') {
				$this->db->where('stockReady <>', 0);
			} else if ($this->input->post('stock') == 'STA-Z') {
				$this->db->where('stockAll =', 0);
			}
		}
		if($this->input->post('hpp_zero'))
		{
			$this->db->where('ProductPriceHPP =', 0);
		}
		if($this->input->post('forSale'))
		{
			if ($this->input->post('forSale') != 2) {
				$this->db->where('forSale =', $this->input->post('forSale') );
			}
		}
		if($this->input->post('price'))
		{
			if ($this->input->post('price') == 'Z') {
				$this->db->where('ProductPriceDefault =', 0);
			} else if ($this->input->post('price') == 'NZ') {
				$this->db->where('ProductPriceDefault <>', 0);
			}  
		}
		if($this->input->post('rosugestion'))
		{
			if ($this->input->post('rosugestion') == 'Z') {
				$this->db->where('rosugestion =', 0);
			} else if ($this->input->post('rosugestion') == 'NZ') {
				$this->db->where('rosugestion <>', 0);
			} else if ($this->input->post('rosugestion') == 'NZMN') {
				$this->db->where('minrosugestion <>', 0);
			} else if ($this->input->post('rosugestion') == 'NZMX') {
				$this->db->where('maxrosugestion <>', 0);
			}  
		}
		if($this->input->post('intransaction'))
		{
			$ProductID = array();
			if ($this->input->post('intransaction') == '3') {
				$sql3 = "SELECT dd.ProductID FROM tb_do_detail dd
						LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
						WHERE dm.DODate > NOW()- INTERVAL 3 MONTH 
						and dd.ProductQty>0 and  dm.DOType<>'MUTATION' 
						GROUP BY dd.ProductID";
				$query 	= $this->db->query($sql3);
				foreach ($query->result_array() as $row)
				{
				        $ProductID[] = $row['ProductID']; 
				}
				$this->db->where_in('ProductID', $ProductID);
			} else if ($this->input->post('intransaction') == '6') {
				$sql3 = "SELECT dd.ProductID FROM tb_do_detail dd
						LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
						WHERE dm.DODate > NOW()- INTERVAL 6 MONTH 
						and dd.ProductQty>0 and  dm.DOType<>'MUTATION' 
						GROUP BY dd.ProductID";
				$query 	= $this->db->query($sql3);
				foreach ($query->result_array() as $row)
				{
				        $ProductID[] = $row['ProductID']; 
				}
				$this->db->where_in('ProductID', $ProductID);
			} else if ($this->input->post('intransaction') == '9') {
				$sql3 = "SELECT dd.ProductID FROM tb_do_detail dd
						LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
						WHERE dm.DODate > NOW()- INTERVAL 9 MONTH 
						and dd.ProductQty>0 and  dm.DOType<>'MUTATION' 
						GROUP BY dd.ProductID";
				$query 	= $this->db->query($sql3);
				foreach ($query->result_array() as $row)
				{
				        $ProductID[] = $row['ProductID']; 
				}
				$this->db->where_in('ProductID', $ProductID);
			} else if ($this->input->post('intransaction') == '12') {
				$sql3 = "SELECT dd.ProductID FROM tb_do_detail dd
						LEFT JOIN tb_do_main dm ON dd.DOID=dm.DOID 
						WHERE dm.DODate > NOW()- INTERVAL 12 MONTH 
						and dd.ProductQty>0 and  dm.DOType<>'MUTATION' 
						GROUP BY dd.ProductID";
				$query 	= $this->db->query($sql3);
				foreach ($query->result_array() as $row)
				{
				        $ProductID[] = $row['ProductID']; 
				}
				$this->db->where_in('ProductID', $ProductID);
			}  
		}
		if($this->input->post('custom_filter'))
		{
			$ProductID = array();
			if ($this->input->post('custom_filter') == 'SSP') {
				$sql3 = "SELECT ProductID FROM `vw_product_atribute` WHERE `Atribute` LIKE '%Custom: STD%'";
				// echo $sql3;
				$query 	= $this->db->query($sql3);
				foreach ($query->result_array() as $row)
				{
				        $ProductID[] = $row['ProductID']; 
				}
				$this->db->where_in('ProductID', $ProductID);
			}  
		}
	} 
	public function filter_slowmoving()
	{
		$this->filter_product2();

		$sql 	= "select SlowMovingMply from tb_site_config where id=1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$conn 	= 'stock > (avrg*'.$row->SlowMovingMply.')';
		$this->db->where($conn);
	}
	public function customer_deposit()
	{
		if($this->input->post('atributeid'))
		{
			$atributeid = $this->input->post('atributeid');
			$atributevalue = $this->input->post('atributevalue');
			$atributeConn = $this->input->post('atributeConn');
			
			for ($i = 0; $i < count($atributeid); $i++) {
				$conn = ($atributeConn[$i] == 'higher') ? '>' : '<' ;
				$this->db->where($atributeid[$i].$conn.$atributevalue[$i], NULL, FALSE);
			}
		} 
	}
	public function nothing()
	{
		// nothing
	}


// join ===========================================================
	public function stock_warehouse()
	{	
		$postWarehouse = (isset($_POST['warehouse']) ? $_POST['warehouse']:0);
		$sql 	= "select WarehouseID from tb_warehouse_main where WarehouseClass=1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		$WarehouseID = (($postWarehouse!=0)? $postWarehouse:$row->WarehouseID);
		$whereOn = 't1.ProductID = t2.ProductID';

		$tbJoin = "SELECT ProductID, Quantity, Quantity as stockWarehouse 
					FROM tb_product_stock_main sm
					WHERE sm.WarehouseID = ".$WarehouseID."
					UNION ALL
					SELECT pm.ProductID, 0 as Quantity, 0 as stockWarehouse 
					FROM tb_product_main pm 
					left join tb_product_stock_main sm on pm.ProductID=sm.ProductID and sm.WarehouseID = ".$WarehouseID."
					WHERE sm.Quantity IS NULL";
		$this->db->join('('.$tbJoin.') t2', $whereOn, 'left');
	}
	public function slowmoving()
	{	
		$whereOn = $this->table.'.ProductID = vw_product_so_avrg_3month_each.ProductID';
		$this->db->join('vw_product_so_avrg_3month_each', $whereOn, 'left');
	}
	public function nothing_join()
	{
		# code...
	}


// ----------------------------------------------------------------
	private function _get_datatables_query()
	{
		if ($this->column_select != '') {
			$this->db->select($this->column_select);
		}
		$this->db->from($this->table);

		$join = (isset($_POST['join'])? $_POST['join']:"nothing_join");
		$this->{$join}(); //join

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		// condition based page
		$page = (isset($_POST['page'])? $_POST['page']:"nothing");
		$this->{$page}();
		// --------------------------

		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		// echo $this->db->last_query();
	}
	public function get_datatables($data_dt)
	{	
		$this->table = $data_dt['table']." as t1";
		// $this->table = $data_dt['table'];

		if (isset($data_dt['column_select'])) {
			$this->column_select = implode(",", $data_dt['column_select']);
		}

		$this->column_order = array_merge($this->column_order, $data_dt['column_order']);
		$this->column_search = array_merge($this->column_search, $data_dt['column_search']);
		$this->order = array_merge($this->order, $data_dt['order']);

		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		// menampilkan query untuk datatable
		// echo $this->db->get_compiled_select();
		$query = $this->db->get();
		return $query->result();
	}
	public function count_filtered()
	{
		$this->{$this->input->post('page')}();
		$this->_get_datatables_query();
		// echo $this->db->last_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}
