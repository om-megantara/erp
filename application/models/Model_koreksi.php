<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_koreksi extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
		date_default_timezone_set("Asia/Jakarta");
    }
    function customer_cu_act()
	{
		$this->db->trans_start();

		// get price category end user
		// $sql = "select PricecategoryID from tb_price_category_main where PricecategoryName like '%End User%' ";
		// $query 	= $this->db->query($sql);
		// foreach ($query->result() as $row) {
		//   	$enduser[] = $row->PricecategoryID;
		// };

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 
		$CustomerID	= $this->input->post('customerid');

		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$company 	= $this->input->post('company'); 
		$shop 		= $this->input->post('shop'); 
		$gender 	= $this->input->post('gender'); 
		$religion 	= $this->input->post('religion');
		$noktp 		= $this->input->post('noktp'); 
		$npwp 		= $this->input->post('npwp'); 
		$creditlimit 	= $this->input->post('creditlimit'); 
		$creditlimitold = $this->input->post('creditlimitold'); 
		$paymentterm 	= $this->input->post('paymentterm'); 
		$paymenttermold = $this->input->post('paymenttermold'); 
		$CustomercategoryID	= $this->input->post('customercategory'); 
		$isCompany 	= $this->input->post('isCompany'); 

		$titlealamat= $this->input->post('titlealamat'); 
		$alamat 	= $this->input->post('alamat'); 
		$billing 	= $this->input->post('billing'); 
		$state 		= $this->input->post('state'); 
		$province 	= $this->input->post('province'); 
		$city 		= $this->input->post('city'); 
		$districts 	= $this->input->post('districts'); 
		$pos 		= $this->input->post('pos'); 
		$phone 		= $this->input->post('phone'); 
		$email 		= $this->input->post('email');
		$sales 		= $this->input->post('sales');
		$price 		= $this->input->post('price');
		$price_text = $this->input->post('price_text');
		$status		= $this->input->post('status');

		$cpname 	= $this->input->post('cpname');
		$cpjob 		= $this->input->post('cpjob');
		$cpphone 	= $this->input->post('cpphone');
		$cpemail 	= $this->input->post('cpemail');
		$cpaddress 	= $this->input->post('cpaddress');
		
		$creditlimit = (int)$creditlimit;
		$paymentterm = (int)$paymentterm;

		// set rejected previous approval
		if ($CustomerID != ""){
			$this->db->set('isComplete', 1);
			$this->db->set('Status', 'Rejected');
			$this->db->where('CustomerID', $CustomerID);
			$this->db->where('isComplete', 0);
			$this->db->update('tb_approval_customer_category');
		}

		$data_contact = array(
	        'NameFirst' => $firstname,
			'NameMid'	=> $middlename,
			'NameLast' 	=> $lastname,
			'Company' 	=> $company,
			'ShopName' 	=> $shop,
			'Gender' 	=> $gender,
			'ReligionID' => $religion,
			'NoKTP' => $noktp,
			'NPWP' => $npwp,
			'isCustomer'=> "1",
			'isCompany' => $isCompany,
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);

			$this->db->where('ContactID', $ContactID);
			$this->db->update('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('ContactID', $ContactID);
			$this->db->delete('tb_contact_address');
			$this->db->where('ContactID', $ContactID);
			$this->db->delete('tb_contact_detail');
			$this->db->where('ContactID', $ContactID);
			$this->db->delete('tb_contact_person');

			for ($i=0; $i < count($alamat);$i++) { 
	   			$data_contact_address = array(
			        'ContactID' => $ContactID,
			        'DetailType' => $titlealamat[$i],
			        'DetailValue' => $alamat[$i],
			        'isBilling' => $billing[$i],
			        'StateID' => $state[$i],
			        'ProvinceID' => $province[$i],
			        'CityID' => $city[$i],
			        'DistrictsID' => $districts[$i],
			        'PosID' => $pos[$i]
				);
				$this->db->insert('tb_contact_address', $data_contact_address);
				$this->last_query .= "//".$this->db->last_query();
	   		};
	   		for ($i=0; $i < count($phone);$i++) { 
	   			$data_contact_phone = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "phone",
			        'DetailValue' => $phone[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
	   		};
	   		for ($i=0; $i < count($email);$i++) { 
	   			$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
	   		};
	   		if ($isCompany == "1") {
		   		for ($i=0; $i < count($cpname);$i++) { 
		   			$data_contact_person = array(
				        'ContactID' => $ContactID,
				        'ContactPersonName' => $cpname[$i],
						'ContactPersonJob' => $cpjob[$i],
						'ContactPersonPhone' => $cpphone[$i],
						'ContactPersonEmail' => $cpemail[$i],
						'ContactPersonAddress' => $cpaddress[$i]
					);
					$this->db->insert('tb_contact_person', $data_contact_person);
					$this->last_query .= "//".$this->db->last_query();
		   		};
	   		}

	   		$data_customer = array(
		        'ContactID' => $ContactID,
		        'CustomercategoryID' => $CustomercategoryID,
		        'RegionID' => "1",
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
				'isActive' => $status
			);

			$this->db->where('CustomerID', $CustomerID);
			$this->db->update('tb_customer_main', $data_customer);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('CustomerID', $CustomerID);
			$this->db->where('DetailType', "sales");
			$this->db->delete('tb_customer_detail');

			for ($i=0; $i < count($sales);$i++) { 
	   			$data_customer_sales = array(
			        'CustomerID' => $CustomerID,
			        'DetailType' => "sales",
			        'DetailValue' => $sales[$i]
				);
				$this->db->insert('tb_customer_detail', $data_customer_sales);
				$this->last_query .= "//".$this->db->last_query();
			};
		
        $this->load->model('model_master');
		$this->model_master->history_customer_sales($sales, $CustomerID);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function customer_list()
	{
		$sql = "SELECT c.ContactID, c.Company2, cm.CustomerID, ca.DetailValue2 as alamat, cs.Sales
				FROM `tb_customer_main` `cm`
				INNER JOIN `vw_contact2` `c` ON ( `cm`.`ContactID` = `c`.`ContactID` )
				LEFT JOIN `vw_customer_sales` `cs` ON ( `cs`.`CustomerID` = `cm`.`CustomerID` )
				LEFT JOIN  vw_contact_address ca ON ( `c`.`ContactID` = ca.ContactID )
				LEFT JOIN vw_city ac ON (ac.CityID=ca.CityID)
				WHERE c.ContactID IN (
				SELECT ContactID FROM tb_contact_detail WHERE DetailName='phone' and DetailValue=''
				) 
				GROUP BY c.ContactID";
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'CustomerID' => $row->CustomerID,
		  			'fullname' => $row->Company2,
					'Company' => $row->Company2,
					'alamat' => $row->alamat,
					'Sales' => $row->Sales
				);
		};
	    return $show;
	}
	function customer_list_city_miss()
	{
		$sql = "SELECT c.ContactID, c.Company2, cm.CustomerID, ca.DetailValue2 as alamat, cs.Sales
				FROM `tb_customer_main` `cm`
				INNER JOIN `vw_contact2` `c` ON ( `cm`.`ContactID` = `c`.`ContactID` )
				LEFT JOIN `vw_customer_sales` `cs` ON ( `cs`.`CustomerID` = `cm`.`CustomerID` )
				LEFT JOIN  vw_contact_address ca ON ( `c`.`ContactID` = ca.ContactID )
				WHERE c.ContactID IN (
				SELECT ContactID FROM vw_contact_address ca WHERE CityID = 0
				)
				GROUP BY c.ContactID";
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'CustomerID' => $row->CustomerID,
		  			'fullname' => $row->Company2,
					'Company' => $row->Company2,
					'alamat' => $row->alamat,
					'Sales' => $row->Sales
				);
		};
	    return $show;
	}
	function customer_list_se_miss_barat()
	{
		$sql = "SELECT c.ContactID, c.Company2, cm.CustomerID, ca.DetailValue2 as alamat, cs.Sales
				FROM `tb_customer_main` `cm`
				INNER JOIN `vw_contact2` `c` ON ( `cm`.`ContactID` = `c`.`ContactID` )
				LEFT JOIN `vw_customer_sales` `cs` ON ( `cs`.`CustomerID` = `cm`.`CustomerID` )
				LEFT JOIN  vw_contact_address ca ON ( `c`.`ContactID` = ca.ContactID )
				LEFT JOIN vw_city ac ON (ac.CityID=ca.CityID)
				WHERE cm.CustomerID IN (
				SELECT CustomerID FROM tb_customer_detail WHERE DetailType='sales' and DetailValue=209
				) 
				AND ac.RegionID=3
				GROUP BY c.ContactID";
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'CustomerID' => $row->CustomerID,
		  			'fullname' => $row->Company2,
					'Company' => $row->Company2,
					'alamat' => $row->alamat,
					'Sales' => $row->Sales
				);
		};
	    return $show;
	}
	function customer_list_se_miss_timur()
	{
		$sql = "SELECT c.ContactID, c.Company2, cm.CustomerID, ca.DetailValue2 as alamat, cs.Sales
				FROM `tb_customer_main` `cm`
				INNER JOIN `vw_contact2` `c` ON ( `cm`.`ContactID` = `c`.`ContactID` )
				LEFT JOIN `vw_customer_sales` `cs` ON ( `cs`.`CustomerID` = `cm`.`CustomerID` )
				LEFT JOIN  vw_contact_address ca ON ( `c`.`ContactID` = ca.ContactID )
				LEFT JOIN vw_city ac ON (ac.CityID=ca.CityID)
				WHERE cm.CustomerID IN (
				SELECT CustomerID FROM tb_customer_detail WHERE DetailType='sales' and DetailValue=209
				) 
				AND ac.RegionID=2
				GROUP BY c.ContactID";
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'CustomerID' => $row->CustomerID,
		  			'fullname' => $row->Company2,
					'Company' => $row->Company2,
					'alamat' => $row->alamat,
					'Sales' => $row->Sales
				);
		};
	    return $show;
	}


	function customer_list_miss_cp()
	{
		$sql = "SELECT cm.ContactID, cm.CustomerID, c.Company2, COALESCE(t1.CountCP,0) AS CountCP, cs.Sales
				FROM tb_customer_main cm
				LEFT JOIN vw_contact2 c ON cm.ContactID=c.ContactID
				LEFT JOIN (
				SELECT ContactID, COUNT(ContactPersonID) AS CountCP
				FROM tb_contact_person cp GROUP BY ContactID
				) t1 ON cm.ContactID=t1.ContactID
				LEFT JOIN vw_customer_sales cs ON cm.ContactID=cs.ContactID
				WHERE cm.isActive=1
				HAVING CountCP<1";
		$query 	= $this->db->query($sql);
		// echo $sql;
		$show	= array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'CustomerID' => $row->CustomerID,
					'Company' => $row->Company2,
					'CountCP' => $row->CountCP,
					'Sales' => $row->Sales
				);
		};
	    return $show;
	}
	function customer_list_miss_cp_se()
	{
		$sql = "SELECT cd.DetailValue, COUNT(cd.CustomerID) AS CountCustomer, se.Company2 AS Sales
				FROM tb_customer_detail cd
				LEFT JOIN vw_sales_executive2 se ON cd.DetailValue=se.SalesID
				WHERE cd.DetailType='sales' AND cd.CustomerID IN (

				SELECT t2.CustomerID FROM (
				SELECT cm.CustomerID, COALESCE(t1.CountCP,0) AS CountCP
				FROM tb_customer_main cm
				LEFT JOIN (
				SELECT ContactID, COUNT(ContactPersonID) AS CountCP
				FROM tb_contact_person cp GROUP BY ContactID
				) t1 ON cm.ContactID=t1.ContactID 
				WHERE cm.isActive=1
				HAVING CountCP<1
				) t2

				)
				GROUP BY cd.DetailValue
				HAVING Sales<>'' ";
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'Sales' => $row->Sales,
		  			'CountCustomer' => $row->CountCustomer,
				);
		};
	    return $show;
	}
	function product_list()
	{
		$EmployeeID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');

		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpf.FileName , tpm.ProductDescription, vpo.AtributeValue, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vps.AtributeValue as Shop, vpm.ProductAtributeValueName as ProductManager
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN tb_product_file tpf ON tpf.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				WHERE tpf.FileName is Null AND tpm.isActive =1 ";
				if (in_array("koreksi_produk_view_all", $MenuList)) {
					$sql .= " ";
				} else {
					$sql .= " AND vpm.AtributeValue=".$EmployeeID;
				}
		$sql .=" GROUP BY tpm.ProductID ";
		$sql .= " UNION
				SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpf.FileName , tpm.ProductDescription, vpo.AtributeValue, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vps.AtributeValue as Shop, vpm.ProductAtributeValueName as ProductManager
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN tb_product_file tpf ON tpf.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				WHERE LENGTH(ProductDescription)<1 AND tpm.isActive =1 ";
				if (in_array("koreksi_produk_view_all", $MenuList)) {
					$sql .= " ";
				} else {
					$sql .= " AND vpm.AtributeValue=".$EmployeeID;
				}
		$sql .=" GROUP BY tpm.ProductID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductDescription' => $row->ProductDescription,
				'AtributeValue' => $row->AtributeValue,
				'SourceAgent' => $row->SourceAgent,
				'StateName' => $row->StateName,
				'FileName' => $row->FileName,
				'ProductManager' => $row->ProductManager,
				'Shop' => $row->Shop,
				);
		};
	    return $show;
	}
	function product_manager_list()
	{
		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.forSale, tpm.ProductDescription, vpo.AtributeValue, vps.stock, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName AS ProductManager, vpp.ProductAtributeValueName AS PShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_stock vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vpp ON vpp.ProductID=tpm.ProductID
				WHERE tpm.isActive =1 AND vps.stock >0
				GROUP BY tpm.ProductID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'forSale' => $row->forSale,
				'ProductDescription' => $row->ProductDescription,
				'PShop' => $row->PShop,
				'SourceAgent' => $row->SourceAgent,
				'ProductManager' => $row->ProductManager,
				'stock' => $row->stock,
				);
		};
	    return $show;
	}
	function product_list_acz()
	{
		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='ACZ' AND tpm.isActive =1 AND ps.CountShop is Null ";
		$sql .=" UNION ";
		$sql .="SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='ACZ' AND tpm.isActive =1 AND ps.CountShop <4";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductDescription' => $row->ProductDescription,
				'SourceAgent' => $row->SourceAgent,
				'StateName' => $row->StateName,
				'ProductManager' => $row->ProductManager,
				'Shop' => $row->Shop,
				'CountShop' => $row->CountShop,
				);
		};
	    return $show;
	}
	function product_list_cvn()
	{
		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='CVN' AND tpm.isActive =1 AND ps.CountShop is Null ";
		$sql .=" UNION ";
		$sql .="SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='CVN' AND tpm.isActive =1 AND ps.CountShop <4";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductDescription' => $row->ProductDescription,
				'SourceAgent' => $row->SourceAgent,
				'StateName' => $row->StateName,
				'ProductManager' => $row->ProductManager,
				'Shop' => $row->Shop,
				'CountShop' => $row->CountShop,
				);
		};
	    return $show;
	}
	function product_list_angz()
	{
		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='ANGZ' AND tpm.isActive =1 AND ps.CountShop is Null ";
		$sql .=" UNION ";
		$sql .="SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='ANGZ' AND tpm.isActive =1 AND ps.CountShop <4";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductDescription' => $row->ProductDescription,
				'SourceAgent' => $row->SourceAgent,
				'StateName' => $row->StateName,
				'ProductManager' => $row->ProductManager,
				'Shop' => $row->Shop,
				'CountShop' => $row->CountShop,
				);
		};
	    return $show;
	}
	function product_list_ati()
	{
		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='ATI' AND tpm.isActive =1 AND ps.CountShop is Null ";
		$sql .=" UNION ";
		$sql .="SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='ATI' AND tpm.isActive =1 AND ps.CountShop <4";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductDescription' => $row->ProductDescription,
				'SourceAgent' => $row->SourceAgent,
				'StateName' => $row->StateName,
				'ProductManager' => $row->ProductManager,
				'Shop' => $row->Shop,
				'CountShop' => $row->CountShop,
				);
		};
	    return $show;
	}
	function product_list_ago()
	{
		$sql = "SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='AGO' AND tpm.isActive =1 AND ps.CountShop is Null ";
		$sql .=" UNION ";
		$sql .="SELECT tpm.ProductID, tpm.ProductName, tpm.ProductImage, tpm.ProductDescription, vps.ProductAtributeValueName as Shop, tas.StateName, vpo.ProductAtributeValueName AS SourceAgent, vpm.ProductAtributeValueName as ProductManager, COALESCE ( ps.CountShop, 0 ) AS CountShop
				FROM tb_product_main tpm
				LEFT JOIN vw_product_origin vpo ON vpo.ProductID =tpm.ProductID
				LEFT JOIN tb_address_state tas ON tas.StateID =tpm.ProductCountry
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop vps ON vps.ProductID=tpm.ProductID
				LEFT JOIN vw_product_shop_assignment ps ON
				tpm.ProductID = ps.ProductID
				WHERE vps.AtributeValue='AGO' AND tpm.isActive =1 AND ps.CountShop <4";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show	= array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductDescription' => $row->ProductDescription,
				'SourceAgent' => $row->SourceAgent,
				'StateName' => $row->StateName,
				'ProductManager' => $row->ProductManager,
				'Shop' => $row->Shop,
				'CountShop' => $row->CountShop,
				);
		};
	    return $show;
	}
}

?>