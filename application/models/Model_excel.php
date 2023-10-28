<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_excel extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }

    function excel_supplier($data)
    {
        foreach ($data as $key => $value) {
        	$data_contact = array(
		        'NameFirst' => $value['namefirst'],
				'NameMid'	=> $value['namemid'],
				'NameLast' 	=> $value['namelast'],
				'Company' 	=> $value['company'],
				'Gender' 	=> $value['gender'],
				'ReligionID' => $value['religion'],
				'NoKTP' => $value['noktp'],
				'NPWP' => $value['npwp'],
				'isSupplier'=> "1", 
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);

			$this->db->insert('tb_contact', $data_contact);

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

			for ($i=1; $i < 3; $i++) { 
	   			$data_contact_address = array(
			        'ContactID' => $ContactID,
			        'DetailType' => "business address",
			        'DetailValue' => is_null($value['address'.$i])? "0" : $value['address'.$i],
			        'StateID' => "1",
			        'ProvinceID' => "0",
			        'CityID' => "0",
			        'DistrictsID' => "0",
			        'PosID' => "0"
				);
				$this->db->insert('tb_contact_address', $data_contact_address);
	   		};
	   		for ($i=1; $i < 4; $i++) { 
	   			$data_contact_phone = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "phone",
			        'DetailValue' => is_null($value['phone'.$i])? "0" : $value['phone'.$i] 
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
	   		};
	   		for ($i=1; $i < 3; $i++) { 
	   			$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => is_null($value['email'.$i])? ".com" : $value['email'.$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
	   		};

			$data_supplier = array(
		        'ContactID' => $ContactID,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
		        'isActive' => "1"
			);
			$this->db->insert('tb_supplier_main', $data_supplier);
        }
    }
    function excel_customer($data)
    {
    	foreach ($data as $key => $value) {
        	$data_contact = array(
		        'NameFirst' => $value['namefirst'],
				'NameMid'	=> $value['namemid'],
				'NameLast' 	=> $value['namelast'],
				'Company' 	=> $value['company'],
				'Gender' 	=> $value['gender'],
				'ReligionID' => $value['religion'],
				'NoKTP' => $value['noktp'],
				'NPWP' => $value['npwp'],
				'isCustomer'=> "1",
				'isCompany'=> "1", 
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_contact', $data_contact);

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

			for ($i=1; $i < 3; $i++) { 
				if ( !is_null($value['address'.$i]) ) {
		   			$data_contact_address = array(
				        'ContactID' => $ContactID,
				        'DetailType' => "business address",
				        'DetailValue' => $value['address'.$i],
				        'StateID' => "1",
				        'ProvinceID' => "0",
				        'CityID' => "0",
				        'DistrictsID' => "0",
				        'PosID' => "0"
					);
					$this->db->insert('tb_contact_address', $data_contact_address);
				}
	   		};
	   		for ($i=1; $i < 4; $i++) { 
	   			$data_contact_phone = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "phone",
			        'DetailValue' => (is_null($value['phone'.$i])) ? ' ' : $value['phone'.$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
	   		};
	   		for ($i=1; $i < 3; $i++) { 
	   			$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => (is_null($value['email'.$i])) ? ' ' : $value['email'.$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
	   		};

	   		$data_customer = array(
		        'CustomerID' => $value['CustomerID'],
		        'ContactID' => $ContactID,
		        'CustomercategoryID' => 1,
		        'RegionID' => "1",
		        'CreditLimit' => $value['creditlimit'], //diisi default
		        'PaymentTerm' => $value['paymentterm'], //diisi default
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
		        'isActive' => "1"
			);
			$this->db->insert('tb_customer_main', $data_customer);

	  //  		$sql 		= "select max(CustomerID) as CustomerID from tb_customer_main ";
			// $getCustomerID = $this->db->query($sql);
			// $row 		= $getCustomerID->row();
			// $CustomerID = $row->CustomerID;
			$CustomerID = $value['CustomerID'];

   			// $data_customer_sales = array(
		        // 'CustomerID' => $CustomerID,
		        // 'DetailType' => "sales",
		        // 'DetailValue' => '209'
			// );
			// $this->db->insert('tb_customer_detail', $data_customer_sales);

			$data_customer_price = array(
				'CustomerID' => $CustomerID,
				'DetailType' => "price",
				'DetailValue' => ""
			);
			$this->db->insert('tb_customer_detail', $data_customer_price);
			// $data_contact_person = array(
		        // 'ContactID' => $ContactID,
		        // 'ContactPersonName' => $value['cpname'],
			// 	'ContactPersonJob' => $value['cpjob'],
			// 	'ContactPersonPhone' => $value['cpphone'],
			// 	'ContactPersonEmail' => $value['cpemail'],
			// 	'ContactPersonAddress' => $value['cpaddress']
			// );
			// $this->db->insert('tb_contact_person', $data_contact_person);
        }
    }
    function excel_employee($data)
    {
    	$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

    	foreach ($data as $key => $value) {
        	$data_contact = array(
		        'NameFirst' => $value['namefirst'],
				'NameMid'	=> $value['namemid'],
				'NameLast' 	=> $value['namelast'],
				'Company' 	=> $value['company'],
				'Gender' 	=> $value['gender'],
				'ReligionID' => $value['religion'],
				'NoKTP' => $value['noktp'],
				'NPWP' => $value['npwp'],
				'isEmployee'=> "1", 
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_contact', $data_contact);

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

			for ($i=1; $i < 3; $i++) { 
	   			$data_contact_address = array(
			        'ContactID' => $ContactID,
			        'DetailType' => "Home address",
			        'DetailValue' => $value['address'.$i],
			        'StateID' => "1",
			        'ProvinceID' => "0",
			        'CityID' => "0",
			        'DistrictsID' => "0",
			        'PosID' => "0"
				);
				$this->db->insert('tb_contact_address', $data_contact_address);
	   		};
	   		for ($i=1; $i < 4; $i++) { 
	   			$data_contact_phone = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "phone",
			        'DetailValue' => $value['phone'.$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
	   		};
	   		for ($i=1; $i < 3; $i++) { 
	   			$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $value['email'.$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
	   		};

	   		// insert data employee
	   		$data_employee = array(
		        'ContactID' => $ContactID,
		        'BirthDate' => $value['BirthDate'],
		        'JoinDate' => $value['JoinDate'],
		        'EmploymentID' => $value['EmploymentID'],
		        'StartDate' => $value['StartDate'],
		        'EndDate' => $value['EndDate'],
		        'LocID' => '1',
		        'Email' => $value['Email11'],
		        'MaritalStatus' => $value['MaritalStatus'],
		        'NIP' => $value['NIP'],
		        'BioID' => $value['BioID'],
		        'CreatedDate' => date("Y-m-d H:i:s"),
		        'CreatedBy' => $this->session->userdata('UserAccountID'),
		        'isActive' => "1",
		        'LastUpdate' => date("Y-m-d H:i:s")
			);
			$this->db->insert('tb_employee_main', $data_employee);

			// get last employee inserted
			$sql 		= "select max(EmployeeID) as EmployeeID from tb_employee_main ";
			$getEmployeeID = $this->db->query($sql);
			$row 		= $getEmployeeID->row();
			$EmployeeID = $row->EmployeeID;

			// insert employee job
			$data_job = array(
		        'LevelID' => '2',
		        'EmployeeID' => $EmployeeID,
		        'StartDate' => date("Y-m-d")
			);
			$this->db->insert('tb_job_title', $data_job);

			// insert employee family
			$data_family = array(
		        'EmployeeID' => $EmployeeID,
		        'empFamilyName' => $value['empFamilyName'],
		        'empFamilySex' => $value['empFamilySex'],
		        'empFamilyJob' => $value['empFamilyJob'],
		        'empFamilyStatus' => $value['empFamilyStatus'],
		        'empFamilyAddress' => $value['empFamilyAddress'],
		        'empFamilyPhone' => $value['empFamilyPhone'],
		        'empFamilyEmail' => $value['empFamilyEmail']
			);
			$this->db->insert('tb_employee_family', $data_family);
        }

        $this->db->trans_complete();
	    // return $this->db->trans_status(); # Completing transaction
		/*Optional*/
		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		    return FALSE;
		} 
		else {
		    # Everything is Perfect. 
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return TRUE;
		}
    }
    function excel_expedition($data)
    {
    	$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

    	foreach ($data as $key => $value) {
        	$data_contact = array(
		        'NameFirst' => $value['Company'],
				'Company' 	=> $value['Company'],
				'Gender' 	=> 'M',
				'ReligionID' => '1', 
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_contact', $data_contact);

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

	   			$data_contact_address = array(
			        'ContactID' => $ContactID,
			        'DetailType' => "Office address",
			        'DetailValue' => $value['Address'],
			        'StateID' => "1",
			        'ProvinceID' => "0",
			        'CityID' => "0",
			        'DistrictsID' => "0",
			        'PosID' => "0"
				);
				$this->db->insert('tb_contact_address', $data_contact_address);

	   			$data_contact_phone = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "phone"
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);

	   			$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => ""
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);

	   		// insert data employee
	   		$data_expedition = array(
		        'ContactID' => $ContactID,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_expedition', $data_expedition);
        }

        $this->db->trans_complete();
	    // return $this->db->trans_status(); # Completing transaction
		/*Optional*/
		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		    return FALSE;
		} 
		else {
		    # Everything is Perfect. 
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return TRUE;
		}
    }
    function excel_fc($data)
    {
    	$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

    	foreach ($data as $key => $value) {
			$data = array(
				'FCPrice' 	=> $value['FCPrice'],
				'FCWeight' 	=> $value['FCWeight']
			);
			$this->db->where('CityID', $value['CityID']);
			$this->db->update('tb_mkt_city', $data);
        }

        $this->db->trans_complete();
	    // return $this->db->trans_status(); # Completing transaction
		/*Optional*/
		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		    return FALSE;
		} 
		else {
		    # Everything is Perfect. 
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return TRUE;
		}
    }
    function excel_product($data)
    {
    	$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

    	foreach ($data as $key => $value) {
			$data = array(
				'ProductID' => $value['ProductID'], 
				'ProductName' => $value['Name'], 
				'ProductCode' => $value['Code'], 
				'ProductStatusID' => 1,
				'ProductCategoryID' => $value['Category'], 
				'ProductBrandID' => $value['Brand'], 
				'ProductAtributSetID' => 5, 
				'ProductPriceDefault' => is_null($value['Price'])? 0 : $value['Price'],
				'ProductPriceHPP'	=> is_null($value['HPP'])? 0 : $value['HPP'],
				'ProductMultiplier'	=> is_null($value['Multiplier'])? 0 : $value['Multiplier'],
				'ProductPricePercent'	=> 0,
				'Stockable' => 1, 
				'MaxStock' => 1, 
				'MinStock' => 1, 
				'forSale' => 1, 
				'isActive' => 1,
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_product_main', $data);
			// $this->last_query .= "//".$this->db->last_query();

			// $sql 			= "select max(ProductID) as ProductID from tb_product_main ";
			// $getProductID 	= $this->db->query($sql);
			// $row 			= $getProductID->row();
			// $ProductID 		= $row->ProductID;
			$ProductID 		= $value['ProductID'];

			// door
				$data = array(
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 1,
				                'AtributeValue' => $value['Netto']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 2,
				                'AtributeValue' => $value['Bruto']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 3,
				                'AtributeValue' => $value['Thickness']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 4,
				                'AtributeValue' => $value['Width']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 5,
				                'AtributeValue' => $value['Height']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 6,
				                'AtributeValue' => $value['Design']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 7,
				                'AtributeValue' => $value['Core']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 8,
				                'AtributeValue' => $value['Color']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 9,
				                'AtributeValue' => $value['Species']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 10,
				                'AtributeValue' => $value['Open']
				        ),
				        array(
				                'ProductID' => $ProductID,
				                'ProductAtributeID' => 12,
				                'AtributeValue' => $value['Grain']
				        )
				);
			// =======================
    		// print_r($data);
			$this->db->insert_batch('tb_product_atribute_detail', $data);
        }

        $this->db->trans_complete();
	    // return $this->db->trans_status(); # Completing transaction
		/*Optional*/
		if ($this->db->trans_status() === FALSE) {
		    # Something went wrong.
		    $this->db->trans_rollback();
		    return FALSE;
		} 
		else {
		    # Everything is Perfect. 
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return TRUE;
		}
    }
    function excel_se($data)
    {
        $data_all = array();
        foreach ($data as $key => $value) {
        	$data_contact = array(
		        'NameFirst' => $value['namefirst'],
				'NameMid'	=> $value['namemid'],
				'NameLast' 	=> $value['namelast'],
				'Gender' 	=> $value['gender'],
				'ReligionID' => $value['religion'],
				'isSales'=> "1", 
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);

			$this->db->insert('tb_contact', $data_contact);

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

   			$data_contact_address = array(
		        'ContactID' => $ContactID,
		        'DetailType' => "business address",
		        'DetailValue' => is_null($value['address'])? "0" : $value['address'], 
		        'StateID' => "1",
		        'ProvinceID' => "0",
		        'CityID' => "0",
		        'DistrictsID' => "0",
		        'PosID' => "0"
			);
			$this->db->insert('tb_contact_address', $data_contact_address);

   			$data_contact_phone = array(
		        'ContactID' => $ContactID,
		        'DetailName' => "phone",
		        'DetailValue' => is_null($value['phone'])? "0" : $value['phone']
			);
			$this->db->insert('tb_contact_detail', $data_contact_phone);

   			$data_contact_email = array(
		        'ContactID' => $ContactID,
		        'DetailName' => "email",
		        'DetailValue' => is_null($value['email'])? "0" : $value['email']
			);
			$this->db->insert('tb_contact_detail', $data_contact_email);

			$data_sales = array(
				'SalesID' => $value['SalesID'],
		        'ContactID' => $ContactID,
				'EmployeeID' => $value['EmployeeID'],
				'SalesParent' => 0,
				'isActive' => $value['active'],
				'InsertDate' => date("Y-m-d H:i:s"),
				'InsertBy' => $this->session->userdata('UserAccountID')
			);
            // array_push($data_all, $data_sales);
			$this->db->insert('tb_sales_executive', $data_sales);
        }
        // echo json_encode($data_all);
    }
    function excel_inv_main_paid($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datamain = array(
				'INVID' => $value['INVID'],
				'DOID' => $value['DOID'],
				'SOID' => $value['SOID'],
				'CustomerID' => $value['CustomerID'],
				'SalesID' => $value['SalesID'],
				'SECID' => $value['SECID'],
				'RegionID' => $value['RegionID'],
				'BillingAddress' => $value['BillingAddress'],
				'ShipAddress' => $value['ShipAddress'],
				'TaxAddress' => $value['TaxAddress'],
				'NPWP' => is_null($value['NPWP'])? "0" : $value['NPWP'],
				'FakturNumber' => $value['FakturNumber'],
				'PaymentWay' => $value['PaymentWay'],
				'PaymentTerm' => $value['PaymentTerm'],
				'INVCategory' => 1,
				'INVDate' => $value['INVDate'],
				'INVTerm' => $value['INVTerm'],
				'INVNote' => $value['INVNote'],
				'TaxRate' => $value['TaxRate'],
				'FCInclude' => $value['FCInclude'],
				'FCTax' => $value['FCTax'],
				'FCExclude' => $value['FCExclude'],
				'FCTotal' => $value['FCTotal'],
				'FCRetur' => $value['FCRetur'],
				'PriceBeforeTax' => $value['PriceBeforeTax'],
				'PriceTax' => $value['PriceTax'],
				'PriceTotal' => $value['PriceTotal'],
				'INVTotal' => $value['INVTotal'],
				'INVInput' => $value['INVDate'],
				'INVBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_invoice_main', $datamain);
			// $this->last_query .= "//".$this->db->last_query();

            if ($value['paymentdate']!="1900-01-00") {
		        $this->load->model('model_finance');
				$BankTransactionID = $this->model_finance->bank_transaction_add_import_inv($value['INVID'], $value['paymentdate'], $value['INVTotal']); 
				$this->model_finance->confirmation_deposit_distribution_act_import_inv($value['SOID'], $value['INVID'], $value['CustomerID'], $BankTransactionID, $value['paymentdate'], $value['INVTotal']); 
				$datamain['BankTransactionID'] = $BankTransactionID;
	            array_push($data_all, $datamain);
	        }
        }
        // echo json_encode($data_all);

		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_inv_main_unpaid($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datamain = array(
				'INVID' => $value['INVID'],
				'DOID' => $value['DOID'],
				'SOID' => $value['SOID'],
				'CustomerID' => $value['CustomerID'],
				'SalesID' => $value['SalesID'],
				'SECID' => $value['SECID'],
				'RegionID' => $value['RegionID'],
				'BillingAddress' => $value['BillingAddress'],
				'ShipAddress' => $value['ShipAddress'],
				'TaxAddress' => $value['TaxAddress'],
				'NPWP' => is_null($value['NPWP'])? "0" : $value['NPWP'],
				'FakturNumber' => $value['FakturNumber'],
				'PaymentWay' => $value['PaymentWay'],
				'PaymentTerm' => $value['PaymentTerm'],
				'INVCategory' => 1,
				'INVDate' => $value['INVDate'],
				'INVTerm' => $value['INVTerm'],
				'INVNote' => $value['INVNote'],
				'TaxRate' => $value['TaxRate'],
				'FCInclude' => $value['FCInclude'],
				'FCTax' => $value['FCTax'],
				'FCExclude' => $value['FCExclude'],
				'FCTotal' => $value['FCTotal'],
				'FCRetur' => $value['FCRetur'],
				'PriceBeforeTax' => $value['PriceBeforeTax'],
				'PriceTax' => $value['PriceTax'],
				'PriceTotal' => $value['PriceTotal'],
				'INVTotal' => $value['INVTotal'],
				'INVInput' => $value['INVDate'],
				'INVBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_invoice_main', $datamain);
			// $this->last_query .= "//".$this->db->last_query();

            if ($value['paymentdate']!="1900-01-00") {
		        $this->load->model('model_finance');
				$BankTransactionID = $this->model_finance->bank_transaction_add_import_inv($value['INVID'], $value['paymentdate'], $value['paymentamount']); 
				$this->model_finance->confirmation_deposit_distribution_act_import_inv($value['SOID'], $value['INVID'], $value['CustomerID'], $BankTransactionID, $value['paymentdate'], $value['paymentamount']); 
				$datamain['BankTransactionID'] = $BankTransactionID;
	        }
            array_push($data_all, $datamain);
        }
        echo json_encode($data_all);

		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_inv_detail_paid($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datadetail = array(
				'INVID' => $value['INVID'],
				'ProductID' => $value['ProductID'],
				'ProductName' => $value['ProductName'],
				'ProductQty' => $value['ProductQty'],
				'ProductMultiplier' => $value['ProductMultiplier'],
				'ProductHPP' => $value['ProductHPP'],
				'ProductPriceDefault' => $value['ProductPriceDefault'],
				'ProductWeight' => $value['ProductWeight'],
				'PromoPercent' => $value['PromoPercent'],
				'PTPercent' => $value['PTPercent'],
				'PriceAmount' => $value['PriceAmount'],
				'FreightCharge' => $value['FreightCharge'],
				'PriceTotal' => $value['PriceTotal'],
				'PV' => $value['PV'],
			);
			$this->db->insert('tb_invoice_detail', $datadetail);
			// $this->last_query .= "//".$this->db->last_query();

            array_push($data_all, $datadetail);
        }
        // echo json_encode($data_all);

		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }

    function excel_ro_main($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datadetail = array(
        		'ROID' => $value['ROID'],
	            'SOID' => $value['SOID'],
	            'RONote' => $value['RONote'],
	            'RODate' => $value['RODate'],
	            'ROInput' => $value['ROInput'],
	            'ROBy' => $value['ROBy'],
	            'ROStatus' => $value['ROStatus']
			);
			$this->db->insert('tb_ro_main', $datadetail);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_ro_product($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datadetail = array(
        		'ROID' => $value['ROID'],
                'ProductID' => $value['ProductID'],
                'ProductQty' => $value['ProductQty']
			);
			$this->db->insert('tb_ro_product', $datadetail);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_ro_raw($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datadetail = array(
                'ROID' => $value['ROID'],
		        'ProductID' => $value['ProductID'],
		        'RawID' => $value['RawID'],
		        'RawQty' => $value['RawQty']
			);
			$this->db->insert('tb_ro_raw', $datadetail);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }

	function excel_po_main($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$data = array(
	    		'POID' => $value['POID'],
	            'ROID' => $value['ROID'],
	            'SupplierID' => $value['SupplierID'],
	            'SupplierNote' => $value['SupplierNote'],
	            'BillingTo' => $value['BillingTo'],
	            'PODate' => $value['PODate'],
	            'PONote' => $value['PONote'],
	            'ShippingTo' => $value['ShippingTo'],
	            'ShippingMethod' => $value['ShippingMethod'],
	            'ShippingDate' => $value['ShippingDate'],
	            'PaymentTerm' => $value['PaymentTerm'],
	            'TaxRate' => $value['TaxRate'],
	            'DownPayment' => $value['DownPayment'],
	            'TaxAmount' => $value['TaxAmount'],
	            'PriceBefore' => $value['PriceBefore'],
	            'TotalPrice' => $value['TotalPrice'],
	            'POCreate' => $value['POCreate'],
	            'POBy' => $value['POBy'],
	            'POStatus' => $value['POStatus']
			);
			$this->db->insert('tb_po_main', $data);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_po_product($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
			$data_product = array(
   				'POID' => $value['POID'],
				'ProductID' => $value['ProductID'],
				'ProductQty' => $value['ProductQty'],
				'ProductPrice' => $value['ProductPrice'],
				'ProductDisc' => $value['ProductDisc'],
				'ProductPriceTotal' => $value['ProductPriceTotal']
			);
			$this->db->insert('tb_po_product', $data_product);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_po_raw($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
			$data_raw = array(
		        'POID' => $value['POID'],
		        'ProductID' => $value['ProductID'],
		        'RawID' => $value['RawID'],
		        'RawQty' => $value['RawQty']
			);
			$this->db->insert('tb_po_raw', $data_raw);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }

    function excel_so_main($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datamain = array(
				'SOID' =>  $value['SOID'],
				'CustomerID' =>  $value['CustomerID'],
				'SalesID' =>  $value['SalesID'],
				'BillingAddress' =>  $value['BillingAddress'],
				'ShipAddress' =>  $value['ShipAddress'],
				'TaxAddress' =>  $value['TaxAddress'],
				'RegionID' =>  $value['RegionID'],
				'SECID' =>  $value['SECID'],
				'NPWP' =>  $value['NPWP'],
				'PaymentWay' =>  $value['PaymentWay'],
				'PaymentTerm' =>  $value['PaymentTerm'],
				'SOCategory' => 1,
				'INVCategory' => 1,
				'SODate' =>  $value['SODate'],
				'SOShipDate' =>  $value['SOShipDate'],
				'SOTerm' =>  $value['SOTerm'],
				'SONote' =>  $value['SONote'],
				'ExpeditionID' =>  $value['ExpeditionID'],
				'FreightCharge' =>  $value['FreightCharge'],
				'SOTotalBefore' =>  $value['SOTotalBefore'],
				'TaxRate' =>  $value['TaxRate'],
				'TaxAmount' =>  $value['TaxAmount'],
				'SOTotal' =>  $value['SOTotal'],
				'SOInput' =>  $value['SOInput'],
				'SOBy' =>  $value['SOBy'],
				'SOConfirm1' => 1,
				'SOStatus' => 1
			);
			$this->db->insert('tb_so_main', $datamain);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
    function excel_so_detail($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datadetail = array(
				'SOID' => $value['SOID'],
				'ProductID' => $value['ProductID'],
				'ProductName' => $value['ProductName'],
				'ProductQty' => $value['ProductQty'],
				'ProductMultiplier' => $value['ProductMultiplier'],
				'ProductHPP' => $value['ProductHPP'],
				'ProductPriceDefault' => $value['ProductPriceDefault'],
				'ProductWeight' => $value['ProductWeight'],
				'PT1Percent' => $value['PT1Percent'],
				'PT1Price' => $value['PT1Price'],
				'PT2Percent' => $value['PT2Percent'],
				'PT2Price' => $value['PT2Price'],
				'PricePercent' => $value['PricePercent'],
				'PriceAmount' => $value['PriceAmount'],
				'FreightCharge' => $value['FreightCharge'],
				'PriceTotal' => $value['PriceTotal']
			);
			$this->db->insert('tb_so_detail', $datadetail);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }

    function excel_do_main($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$data = array(
				'DOID' => $value['DOID'],
				'DOType' => 'SO',
				'DOReff' => $value['DOReff'],
				'WarehouseID' => 2,
				'DODate' => $value['DODate'],
				'DONote' => $value['DONote'],
				'DOBy' => $value['DOBy'],
				'DOInput' => $value['DOInput'],
				'DOStatus' => $value['DOStatus']
			);
			$this->db->insert('tb_do_main', $data);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
	function excel_do_detail($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	$data_product = array(
   				'DOID' => $value['DOID'],
				'WarehouseID' => 2,
				'ProductID' => $value['ProductID'],
				'ProductQty' => $value['ProductQty']
			);
			$this->db->insert('tb_do_detail', $data_product);
        	$this->load->model('model_transaction');
			$this->model_transaction->stock_min($value['ProductID'], $value['ProductQty'], 2, "DO".$value['DOID']);
			$this->model_transaction->stock_add($value['ProductID'], $value['ProductQty'], 2, "DO".$value['DOID']." Adjustment", $EXPDate);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }

    function excel_kw2($data)
    {
    	$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

    	foreach ($data as $key => $value) {
			$sql	= "INSERT INTO tb_product_main 
						(ProductName, ProductCode, ProductDescription, ProductSupplier, ProductStatusID, ProductCategoryID, ProductBrandID, 
						ProductAtributSetID, ProductPriceHPP, ProductPricePercent, ProductPriceDefault, ProductMultiplier, ProductImage, 
						ProductDoc, Stockable, MaxStock, MinStock, forSale, isActive, InputDate, InputBy )
						SELECT 
						ProductName, ProductCode, ProductDescription, ProductSupplier, 2, ProductCategoryID, ProductBrandID, 
						ProductAtributSetID, ProductPriceHPP, ProductPricePercent, ProductPriceDefault, ProductMultiplier, ProductImage, 
						'oldDesc=".$value['ProductName'].", KW1=".$value['ProductID2'].", stok=".$value['Qty']."', Stockable, MaxStock, MinStock, 0, isActive, '".date("Y-m-d H:i:s")."', ".$this->session->userdata('UserAccountID')."
						FROM tb_product_main WHERE ProductID=".$value['ProductID2'];
    		$this->db->query($sql);

			$sql 			= "select max(ProductID) as ProductID from tb_product_main ";
			$getProductID 	= $this->db->query($sql);
			$row 			= $getProductID->row();
			$ProductID 		= $row->ProductID;
			// echo $ProductID."<br>";

    		$sql	= "INSERT INTO tb_product_stock_main 
						(ProductID, WarehouseID, Quantity, LastUpdate)
						values (".$ProductID.", 2, 0, '".date("Y-m-d H:i:s")."')";
    		$this->db->query($sql);
    		
			$sql	= "INSERT INTO tb_product_atribute_detail 
						(ProductID, ProductAtributeID, AtributeValue)
						SELECT 
						".$ProductID.", ProductAtributeID, AtributeValue
						FROM tb_product_atribute_detail WHERE ProductID=".$value['ProductID2'];
    		$this->db->query($sql);

        }

        $this->db->trans_complete();
	    // return $this->db->trans_status(); # Completing transaction
		/*Optional*/
		// if ($this->db->trans_status() === FALSE) {
		//     # Something went wrong.
		//     $this->db->trans_rollback();
		//     return FALSE;
		// } 
		// else {
		//     # Everything is Perfect. 
		//     # Committing data to the database.
		//     $this->db->trans_commit();
		//     return TRUE;
		// }
    }

    
    function excel_dp_free($data)
    {
		$this->db->trans_start();
        $data_all = array();
        foreach ($data as $key => $value) {
        	// $datamain = array(
			// 	'CustomerID' => $value['CustomerID'],
			// 	'Company' => $value['Company'],
			// 	'BankTransactionAmount' => $value['BankTransactionAmount']
			// );

	        $this->load->model('model_finance');
			$BankTransactionID = $this->model_finance->bank_transaction_add_import_dp_free($value['CustomerID'], $value['Company'], $value['BankTransactionAmount']); 
			$this->model_finance->confirmation_deposit_distribution_act_import_dp_free($value['CustomerID'], $BankTransactionID, $value['BankTransactionAmount']); 
			// $datamain['BankTransactionID'] = $BankTransactionID;
            array_push($data_all, $BankTransactionID);
        }
        echo json_encode($data_all);

		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }

    function excel_asset_detail($data)
    {
		$this->db->trans_start();
        foreach ($data as $key => $value) {
        	$datamain = array(
        		/*
        		'AssetID' 		 =>  $value['AssetID'],
				 'EmployeeID'	 =>  $value['EmployeeID'],
				 'DateIn'		 =>  $value['DateIn'],
				 'DateOut' 		 =>  $value['DateOut'],
				 'Note'          =>  $value['Note'],
        		*/
				 'AssetID' 		 =>  $value['AssetID'],
				 'EmployeeID'	 =>  $value['EmployeeID'],
				 'DateIn'		 =>  $value['DateIn'],
				 'DateOut' 		 =>  $value['DateOut'],
				 'StatusIn'		 =>  $value['StatusIn'],
				 /*'Note'          =>  $value['Note'],	*/
			);
			$this->db->insert('tb_asset_detail', $datamain);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
	function excel_asset_main($data)
    {
		$this->db->trans_start();
		 
        $data_all = array();
        foreach ($data as $key => $value) {
        	$datamain = array(
				 'AssetID' 		 					=>  $value['AssetID'],
				 'AssetName' 		 				=>  $value['AssetName'],
				 'ModelNumber' 		 				=>  $value['ModelNumber'],
				 'SerialNumber'				 		=>  $value['SerialNumber'],
				 'AssetColor' 		 				=>  $value['AssetColor'],
				 'AssetType' 		 			    =>  $value['AssetType'],
				 'AssetCategory' 		 			=>  $value['AssetCategory'],
				 'AssetCondition' 		 			=>  $value['AssetCondition'],
				 'AssetSpesification' 		 		=>  $value['AssetSpesification'],
				 'AssetNote' 		 				=>  $value['AssetNote'],
				 'DateIn' 		 					=>  $value['DateIn'],
				 'Price' 		 					=>  $value['Price'], 
				'InputDate' 						=> date("Y-m-d H:i:s"),
				'InputBy' 							=> $this->session->userdata('UserAccountID'),
				'ModifiedDate' 						=> date("Y-m-d H:i:s"),
				'ModifiedBy' 						=> $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_asset_main', $datamain);
        }
		$this->db->trans_complete();
	    // return $this->db->trans_status();
    }
  

    function delete_duplicate()
    {
		$show   = array();
		$sql 	= "SELECT COUNT(CustomerID) as jum, CustomerID, DetailValue
					FROM tb_customer_detail
					WHERE DetailType='sales'
					GROUP BY CustomerID, DetailValue
					HAVING jum>1
					ORDER BY jum desc, CustomerID ASC";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$query = $this->db->query("delete from tb_customer_detail where CustomerID=".$row->CustomerID." and DetailType='sales' and DetailValue=".$row->DetailValue."");

			if ($query) {
			} else {
			    echo "Query failed!";
			}

			$query = $this->db->query("insert into tb_customer_detail (CustomerID, DetailType, DetailValue) values (".$row->CustomerID.",'sales',".$row->DetailValue.")");

			if ($query) {
			} else {
			    echo "Query2 failed!";
			}

			$show[]	= get_object_vars($row);
		};


		// $sql 	= "SELECT COUNT(ContactID) as jum, ContactID, DetailValue
		// 			FROM tb_contact_detail
		// 			WHERE DetailName='email'
		// 			GROUP BY ContactID, DetailValue
		// 			HAVING jum>1
		// 			ORDER BY jum desc, ContactID ASC";
		// $query 	= $this->db->query($sql);
		// foreach ($query->result() as $row) {
		// 	$query = $this->db->query("delete from tb_contact_detail where ContactID=".$row->ContactID." and DetailName='email' and DetailValue='".$row->DetailValue."'");
		// 	if ($query) {
		// 	} else {
		// 	    echo "Query failed!";
		// 	}

		// 	$query = $this->db->query("insert into tb_contact_detail (ContactID, DetailName, DetailValue) values (".$row->ContactID.",'email','".$row->DetailValue."')");
		// 	if ($query) {
		// 	} else {
		// 	    echo "Query2 failed!";
		// 	}

		// 	$show[]	= get_object_vars($row);
		// };

		echo json_encode($show);
    }
}
?>