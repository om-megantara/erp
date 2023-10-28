<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_master extends CI_Model {
	public function __construct()
	{
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
	}
  
// contact===================================================================
	function contact_list()
	{
		$sql = "select * from vw_contact1 ";
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'fullname' => $row->fullname,
					'Company' => $row->Company,
					'Email' => $row->email,
					'Phone' => $row->phone,
					'isEmployee' => $row->isEmployee,
					'isCustomer' => $row->isCustomer,
					'isSales' => $row->isSales,
					'isSupplier' => $row->isSupplier
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
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
		  	$alamat .= "<b>".$row3->DetailType.$billing."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID;
		  	$alamat .= '<a href="'.base_url().'general/contact_print?id='.$row3->OrderID.'" target="_blink" class="btn btn-xs btn-primary">Print Label</a>
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
	function contact_cu($val)
	{
		$show = array();
		if ($val == "new") { //jika data contact baru
			$show['personal'] = array(
			  	'ContactID' => "",
			  	'NameFirst' => "",
			  	'NameMid' => "",
			  	'NameLast' => "",
			  	'Company' => "",
			  	'Prefix' => "",
			  	'ShopName' => "",
				'gender' => "M",
				'BirthDate' => "",
				'religion' => "1",
				'KTP' => "",
				'NPWP' => "",
				'isCompany' => "0"
			);
			$show['alamat'][] = array(
			  	'DetailType' => "",
			  	'DetailValue' => "",
			  	'isBilling' => 0,
			  	'StateID' => "1",
			  	'StateName' => "INDONESIA",
			  	'ProvinceID' => "0",
			  	'ProvinceName' => "",
			  	'CityID' => "0",
			  	'CityName' => "",
			  	'DistrictsID' => "0",
			  	'DistrictsName' => "",
			  	'PosName' => "0"
			);
			$show['email'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);
			$show['phone'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);

		} else { // jika data contact exist
			$sql = "select c.*, r.* from tb_contact c ";
			$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
			$sql .= "where c.ContactID = '".$val."'";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();
			if (empty($row)) {
				redirect(base_url());
			} else {
				$show['personal'] = array(
				  	'ContactID' => $val,
				  	'NameFirst' => $row->NameFirst,
				  	'NameMid' => $row->NameMid,
				  	'NameLast' => $row->NameLast,
				  	'Company' => $row->Company,
				  	'Prefix' => $row->Prefix,
					'BirthDate' => $row->BirthDate,
				  	'ShopName' => $row->ShopName,
					'gender' => $row->Gender,
					'religion' => $row->ReligionID,
					'KTP' => $row->NoKTP,
					'NPWP' => $row->NPWP,
					'isCompany' => ($row->isCompany == "" ? "0" : $row->isCompany)
				);

				$sql3 = "select ca.*, cas.StateID,  cas.StateName, capr.ProvinceID, capr.ProvinceName, cac.CityID, cac.CityName, cad.DistrictsID, cad.DistrictsName, capo.PosName from tb_contact_address ca ";
				$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
				$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
				$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
				$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
				$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
				$sql3 .= "where ca.ContactID = '".$val."' order by ca.isBilling DESC, ca.DetailType ";
				$query3 = $this->db->query($sql3);
				foreach ($query3->result() as $row3) {
				  	$show['alamat'][] = array(
					  	'DetailType' => $row3->DetailType,
					  	'DetailValue' => $row3->DetailValue,
					  	'isBilling' => $row3->isBilling,
					  	'StateID' => $row3->StateID,
					  	'StateName' => $row3->StateName,
					  	'ProvinceID' => $row3->ProvinceID,
					  	'ProvinceName' => $row3->ProvinceName,
					  	'CityID' => $row3->CityID,
					  	'CityName' => $row3->CityName,
					  	'DistrictsID' => $row3->DistrictsID,
					  	'DistrictsName' => $row3->DistrictsName,
					  	'PosName' => $row3->PosID
					);
				};

				$sql4 = "select cd.* from tb_contact_detail cd ";
				$sql4 .= "where cd.ContactID = '".$val."'";
				$query4 = $this->db->query($sql4);
				$phone = "";
				$email = "";
				foreach ($query4->result() as $row4) {
					if ($row4->DetailName == "email") {
						$show['email'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					} else {
						$show['phone'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					}
				};

				if ($row->isCompany == "1") {
					$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
							LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
							WHERE cp.ContactID='".$val."' and cp.ContactPersonID <>''";
					$query5 = $this->db->query($sql5);
					foreach ($query5->result() as $row5) {
				  		$show['cperson'][] = array(
						  	'ContactPersonID' => $row5->ContactPersonID,
						  	'Company2' => $row5->Company2,
							'ContactPersonType' => $row5->ContactPersonType
						);
					};
				}
			}

		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function contact_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 

		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$company 	= $this->input->post('company'); 
		$shop 		= $this->input->post('shop'); 
		$gender 	= $this->input->post('gender'); 
		$Prefix 	= $this->input->post('Prefix'); 
		$BirthDate 	= $this->input->post('BirthDate'); 
		$religion 	= $this->input->post('religion');
		$noktp 		= $this->input->post('noktp'); 
		$npwp 		= $this->input->post('npwp'); 
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
		$phoneT		= $this->input->post('phoneT'); 
		$email 		= $this->input->post('email');
		$emailT		= $this->input->post('emailT');

		$contactpid = $this->input->post('contactpid');
		$contactptype = $this->input->post('contactptype');

		$data_contact = array(
	        'NameFirst' => $firstname,
			'NameMid'	=> $middlename,
			'NameLast' 	=> $lastname,
			'Company' 	=> $company,
			'Prefix' 	=> $Prefix,
			'BirthDate' => $BirthDate,
			'ShopName' 	=> $shop,
			'Gender' 	=> $gender,
			'ReligionID' => $religion,
			'NoKTP' => $noktp,
			'NPWP' => $npwp,
			'isCompany' => $isCompany, 
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		// print_r($data_contact);
		if ($ContactID == "") { //jika data contact baru
			$this->db->insert('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};
			if ($isCompany == "1") {
				for ($i=0; $i < count($contactpid);$i++) {
					$data_contact_person = array(
				        'ContactID' => $ContactID,
				        'ContactPersonID' => $contactpid[$i],
						'ContactPersonType' => $contactptype[$i]
					);
					$this->db->insert('tb_contact_person', $data_contact_person);
					$this->last_query .= "//".$this->db->last_query();
				};
			}

		} else { // jika data contact exist
			unset($data_contact["InputDate"]); 
			unset($data_contact["InputBy"]); 
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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};
			if ($isCompany == "1") {
				if(isset($contactpid)){
					for ($i=0; $i < count($contactpid);$i++) {
						$data_contact_person = array(
					        'ContactID' => $ContactID,
					        'ContactPersonID' => $contactpid[$i],
							'ContactPersonType' => $contactptype[$i]
						);
						$this->db->insert('tb_contact_person', $data_contact_person);
						$this->last_query .= "//".$this->db->last_query();
					};
				}
			}
		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	
// sales=====================================================================
	function sales_list()
	{
		$sql 	= "SELECT * from vw_sales_executive";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$Status  = $row->isActive=="1" ? "Active" : "NonActive" ;
		  	$show[$row->SalesID] = array(
		  			'SalesID' => $row->SalesID, 
					'ContactID' => $row->ContactID, 
					'EmployeeID' => $row->EmployeeID, 
					'Company' => $row->Company2, 
					'status' => $Status, 
					'phone' => $row->phone, 
					'Address' => $row->Address,
					'SalesParent' => $row->SalesParent,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_list2()
	{
		$sql 	= "SELECT * from vw_sales_executive where isActive=1";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$Status  = $row->isActive=="1" ? "Active" : "NonActive" ;
		  	$show[$row->SalesID] = array(
		  			'SalesID' => $row->SalesID, 
					'ContactID' => $row->ContactID, 
					'EmployeeID' => $row->EmployeeID, 
					'Company' => $row->Company2, 
					'status' => $Status, 
					'phone' => $row->phone, 
					'Address' => $row->Address,
					'SalesParent' => $row->SalesParent,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_set($val)
	{
		$this->db->set('isSales', 1);
		$this->db->where('ContactID', $val);
		$this->db->update('tb_contact');
		$this->last_query .= "//".$this->db->last_query();

		$sql = "select EmployeeID from tb_employee_main where ContactID=".$val;
		$getContactID = $this->db->query($sql);
		$row = $getContactID->row();
		if (!empty($row)) {
			$EmployeeID	= $row->EmployeeID;
		} else {
			$EmployeeID = 0;
		}

		$data_sales = array(
			'ContactID' => $val,
			'EmployeeID' => $EmployeeID,
			'SalesParent' => 0,
			'isActive' => 1,
			'InsertDate' => date("Y-m-d H:i:s"),
	        'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_sales_executive', $data_sales);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
	}
	function sales_list_detail()
	{
		$show = array();
        $id  = $this->input->get_post('a');

        // query get data utama
		$sql = "select c.*, r.*, s.* from vw_contact2 c ";
		$sql .= "LEFT JOIN tb_sales_executive s ON c.ContactID = s.ContactID ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "where c.ContactID = '".$id."'";
		$sql .= "and c.isSales = 1 ";
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
		$query3 = $this->db->query($sql3);
		// $row2 	= $query2->row();	
		// echo $sql3 ."<br>";
		$alamat = "";
		foreach ($query3->result() as $row3) {
			$billing = $row3->isBilling==0 ? "" : "(Billing address)";
		  	$alamat .= "<b>".$row3->DetailType.$billing."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID."<br><br>";
		};

		// query get data phone email
		$sql4 = "SELECT cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$id."'";
		$query4 = $this->db->query($sql4);
		// $row2 	= $query2->row();	
		// echo $sql4 ."<br>";
		$phone = "";
		$email = "";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email") {
				$email .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			} else {
				$phone .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			}
		};

		// query get data contact person
		$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
				LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
				WHERE cp.ContactID='".$id."' and cp.ContactPersonID <>''";
		$query5 = $this->db->query($sql5);
		$contact_person = "";
		foreach ($query5->result() as $row5) {
			$contact_person .= $row5->ContactPersonID." // ".$row5->Company2." // ".$row5->ContactPersonType."<br>";
		};

	  	$show = array(
		  	'id' => $id,
		  	'ContactID' => $row->ContactID,
			'isCompany' => $row->isCompany,
			'fullname' => $row->fullname,
			'Company2' => $row->Company2,
			'gender' => $gender,
			'BirthDate' => $row->BirthDate,
			'religion' => $row->ReligionName,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'ShopName' => $row->ShopName,
			'Phone' => $phone,
			'Email' => $email,
			'address' => $alamat,
			'isSupplier' => $row->isSupplier,
			'contact_person' => $contact_person
		);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_cu($val)
	{
		$show = array(); 
		$sql = "SELECT c.*, r.*, e.*, se.Company2 as secname from tb_contact c ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "left join tb_sales_executive e on (c.ContactID = e.ContactID) ";
		$sql .= "left join vw_sales_executive2 se on (se.SalesID = e.SalesParent) ";
		$sql .= "where c.ContactID = '".$val."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		if (empty($row)) {
			redirect(base_url());
		} else {
			// echo $sql ."<br>";
			// print_r($row);
			$show['personal'] = array(
			  	'ContactID' => $val,
			  	'SalesID' => $row->SalesID,
			  	'NameFirst' => $row->NameFirst,
			  	'NameMid' => $row->NameMid,
			  	'NameLast' => $row->NameLast,
			  	'Company' => $row->Company,
			  	'ShopName' => $row->ShopName,
			  	'Prefix' => $row->Prefix,
				'BirthDate' => $row->BirthDate,
				'gender' => $row->Gender,
				'religion' => $row->ReligionID,
				'KTP' => $row->NoKTP,
				'NPWP' => $row->NPWP,
			  	'SalesParent' => $row->SalesParent,
			  	'isActive' => $row->isActive,
			  	'secname' => $row->secname,
				'isCompany' => ($row->isCompany == "" ? "0" : $row->isCompany)
			);

			$sql3 = "select ca.*, cas.StateID,  cas.StateName, capr.ProvinceID, capr.ProvinceName, cac.CityID, cac.CityName, cad.DistrictsID, cad.DistrictsName, capo.PosName from tb_contact_address ca ";
			$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
			$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
			$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
			$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
			$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
			$sql3 .= "where ca.ContactID = '".$val."' order by ca.isBilling DESC, ca.DetailType ";
			$query3 = $this->db->query($sql3);
			// $row2 	= $query2->row();	
			// echo $sql3 ."<br>";
			foreach ($query3->result() as $row3) {
			  	$show['alamat'][] = array(
				  	'DetailType' => $row3->DetailType,
				  	'DetailValue' => $row3->DetailValue,
				  	'isBilling' => $row3->isBilling,
				  	'StateID' => $row3->StateID,
				  	'StateName' => $row3->StateName,
				  	'ProvinceID' => $row3->ProvinceID,
				  	'ProvinceName' => $row3->ProvinceName,
				  	'CityID' => $row3->CityID,
				  	'CityName' => $row3->CityName,
				  	'DistrictsID' => $row3->DistrictsID,
				  	'DistrictsName' => $row3->DistrictsName,
				  	'PosName' => $row3->PosID
				);
			};

			$sql4 = "select cd.* from tb_contact_detail cd ";
			$sql4 .= "where cd.ContactID = '".$val."'";
			$query4 = $this->db->query($sql4);
			// $row2 	= $query2->row();	
			// echo $sql4 ."<br>";
			$phone = "";
			$email = "";
			foreach ($query4->result() as $row4) {
				if ($row4->DetailName == "email") {
					$show['email'][] = array(
					  	'DetailValue' => $row4->DetailValue,
					  	'DetailTitle' => $row4->DetailTitle
					);
				} else {
					$show['phone'][] = array(
					  	'DetailValue' => $row4->DetailValue,
					  	'DetailTitle' => $row4->DetailTitle
					);
				}
			};

			if ($row->isCompany == "1") {
				$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
						LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
						WHERE cp.ContactID='".$val."' and cp.ContactPersonID <>''";
				$query5 = $this->db->query($sql5);
				foreach ($query5->result() as $row5) {
			  		$show['cperson'][] = array(
					  	'ContactPersonID' => $row5->ContactPersonID,
					  	'Company2' => $row5->Company2,
						'ContactPersonType' => $row5->ContactPersonType
					);
				};
			}
		}

		// print_r($show['personal']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function sales_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 
		$SalesID	= $this->input->post('salesid');

		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$company 	= $this->input->post('company'); 
		$shop 		= $this->input->post('shop'); 
		$gender 	= $this->input->post('gender'); 
		$Prefix 	= $this->input->post('Prefix'); 
		$BirthDate 	= $this->input->post('BirthDate'); 
		$religion 	= $this->input->post('religion');
		$noktp 		= $this->input->post('noktp'); 
		$npwp 		= $this->input->post('npwp'); 
		$sec 		= $this->input->post('sec'); 
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
		$phoneT		= $this->input->post('phoneT'); 
		$email 		= $this->input->post('email');
		$emailT		= $this->input->post('emailT');
		$status		= $this->input->post('status');

		$contactpid = $this->input->post('contactpid');
		$contactptype = $this->input->post('contactptype');

		$data_contact = array(
	        'NameFirst' => $firstname,
			'NameMid'	=> $middlename,
			'NameLast' 	=> $lastname,
			'Company' 	=> $company,
			'ShopName' 	=> $shop,
			'Gender' 	=> $gender,
			'Prefix' 	=> $Prefix,
			'BirthDate' => $BirthDate,
			'ReligionID' => $religion,
			'NoKTP' => $noktp,
			'NPWP' => $npwp,
			'isCompany' => $isCompany,
			'isSales'=> "1",
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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};
			if ($isCompany == "1") {
				for ($i=0; $i < count($contactpid);$i++) {
					$data_contact_person = array(
				        'ContactID' => $ContactID,
				        'ContactPersonID' => $contactpid[$i],
						'ContactPersonType' => $contactptype[$i]
					);
					$this->db->insert('tb_contact_person', $data_contact_person);
					$this->last_query .= "//".$this->db->last_query();
				};
			}

		$data_sales = array(
			'SalesParent' => $sec,
			'isActive' => $status,
		);
		$this->db->where('SalesID', $SalesID);
		$this->db->update('tb_sales_executive', $data_sales);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

// Expedition================================================================
	function expedition_list()
	{
		$sql 	= "SELECT * from vw_expedition1";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'ExpeditionID' => $row->ExpeditionID, 
					'ContactID' => $row->ContactID, 
					'Company' => $row->Company2, 
					'phone' => $row->phone, 
					'Address' => $row->Address
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function expedition_list_detail()
	{
		$show = array();
        $id  = $this->input->get_post('a');
					
        // query get data utama
		$sql = "select c.*, r.*, s.* from vw_contact2 c ";
		$sql .= "LEFT JOIN tb_expedition s ON c.ContactID = s.ContactID ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "where c.ContactID = ".$id;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		$gender		= $row->Gender=="M" ? "Male" : "Female";

		// query get data alamat
		$sql3 = "select ca.*, cas.*, capr.*, cac.*, cad.*, capo.* from tb_contact_address ca ";
		$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "where ca.ContactID = '".$id."' order by ca.isBilling DESC, ca.DetailType ";
		$query3 = $this->db->query($sql3);
		// $row2 	= $query2->row();	
		// echo $sql3 ."<br>";
		$alamat = "";
		foreach ($query3->result() as $row3) {
			$billing = $row3->isBilling==0 ? "" : "(Billing address)";
		  	$alamat .= "<b>".$row3->DetailType.$billing."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID."<br><br>";
		};

		// query get data phone email
		$sql4 = "select cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$id."'";
		$query4 = $this->db->query($sql4);
		// $row2 	= $query2->row();	
		// echo $sql4 ."<br>";
		$phone = "";
		$email = "";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email") {
				$email .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			} else {
				$phone .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			}
		};

		// query get data contact person
		$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
				LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
				WHERE cp.ContactID='".$id."' and cp.ContactPersonID <>''";
		$query5 = $this->db->query($sql5);
		$contact_person = "";
		foreach ($query5->result() as $row5) {
			$contact_person .= $row5->ContactPersonID." // ".$row5->Company2." // ".$row5->ContactPersonType."<br>";
		};

	  	$show = array(
		  	'id' => $id,
			'ContactID' => $row->ContactID,
			'ExpeditionID' => $row->ExpeditionID,
			'isCompany' => $row->isCompany,
			'fullname' => $row->Company2,
			'ShopName' => $row->ShopName,
			'gender' => $gender,
			'religion' => $row->ReligionName,
			'BirthDate' => $row->BirthDate,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'Phone' => $phone,
			'Email' => $email,
			'address' => $alamat,
			'contact_person' => $contact_person
		);

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function expedition_set($val)
	{
		$this->db->set('isExpedition', 1);
		$this->db->where('ContactID', $val);
		$this->db->update('tb_contact');
		$this->last_query .= "//".$this->db->last_query();

		$data_expedition = array(
	        'ContactID' => $val,
	        'LastUpdate' => date("Y-m-d H:i:s"),
	        'LastUpdateBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_expedition', $data_expedition);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
	}
	function expedition_cu($val)
	{
		$show = array();
		if ($val == "new") { //jika data contact baru
			$show['personal'] = array(
			  	'ContactID' => "",
			  	'ExpeditionID' => "",
			  	'NameFirst' => "",
			  	'NameMid' => "",
			  	'NameLast' => "",
			  	'Company' => "",
			  	'ShopName' => "",
				'gender' => "M",
				'religion' => "1",
				'KTP' => "",
				'NPWP' => "",
				'isCompany' => "0"
			);
			$show['alamat'][] = array(
			  	'DetailType' => "",
			  	'DetailValue' => "",
			  	'isBilling' => 0,
			  	'StateID' => "1",
			  	'StateName' => "INDONESIA",
			  	'ProvinceID' => "0",
			  	'ProvinceName' => "",
			  	'CityID' => "0",
			  	'CityName' => "",
			  	'DistrictsID' => "0",
			  	'DistrictsName' => "",
			  	'PosName' => "0"
			);
			$show['email'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);
			$show['phone'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);

		} else { // jika data contact exist
			$sql = "select c.*, r.*, e.* from tb_contact c ";
			$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
			$sql .= "left join tb_expedition e on (c.ContactID = e.ContactID) ";
			$sql .= "where c.ContactID = '".$val."'";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			if (empty($row)) {
				redirect(base_url());
			} else {
				// echo $sql ."<br>";
				// print_r($row);
				$show['personal'] = array(
				  	'ContactID' => $val,
				  	'ExpeditionID' => $row->ExpeditionID,
				  	'NameFirst' => $row->NameFirst,
				  	'NameMid' => $row->NameMid,
				  	'NameLast' => $row->NameLast,
				  	'Company' => $row->Company,
				  	'ShopName' => $row->ShopName,
				  	'Prefix' => $row->Prefix,
					'BirthDate' => $row->BirthDate,
					'gender' => $row->Gender,
					'religion' => $row->ReligionID,
					'KTP' => $row->NoKTP,
					'NPWP' => $row->NPWP,
					'isCompany' => ($row->isCompany == "" ? "0" : $row->isCompany)
				);

				$sql3 = "select ca.*, cas.StateID,  cas.StateName, capr.ProvinceID, capr.ProvinceName, cac.CityID, cac.CityName, cad.DistrictsID, cad.DistrictsName, capo.PosName from tb_contact_address ca ";
				$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
				$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
				$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
				$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
				$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
				$sql3 .= "where ca.ContactID = '".$val."' order by ca.isBilling DESC, ca.DetailType ";
				$query3 = $this->db->query($sql3);
				// $row2 	= $query2->row();	
				// echo $sql3 ."<br>";
				foreach ($query3->result() as $row3) {
				  	$show['alamat'][] = array(
					  	'DetailType' => $row3->DetailType,
					  	'DetailValue' => $row3->DetailValue,
					  	'isBilling' => $row3->isBilling,
					  	'StateID' => $row3->StateID,
					  	'StateName' => $row3->StateName,
					  	'ProvinceID' => $row3->ProvinceID,
					  	'ProvinceName' => $row3->ProvinceName,
					  	'CityID' => $row3->CityID,
					  	'CityName' => $row3->CityName,
					  	'DistrictsID' => $row3->DistrictsID,
					  	'DistrictsName' => $row3->DistrictsName,
					  	'PosName' => $row3->PosID
					);
				};

				$sql4 = "select cd.* from tb_contact_detail cd ";
				$sql4 .= "where cd.ContactID = '".$val."'";
				$query4 = $this->db->query($sql4);
				// $row2 	= $query2->row();	
				// echo $sql4 ."<br>";
				$phone = "";
				$email = "";
				foreach ($query4->result() as $row4) {
					if ($row4->DetailName == "email") {
						$show['email'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					} else {
						$show['phone'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					}
				};

				if ($row->isCompany == "1") {
					$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
							LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
							WHERE cp.ContactID='".$val."' and cp.ContactPersonID <>''";
					$query5 = $this->db->query($sql5);
					foreach ($query5->result() as $row5) {
				  		$show['cperson'][] = array(
						  	'ContactPersonID' => $row5->ContactPersonID,
						  	'Company2' => $row5->Company2,
							'ContactPersonType' => $row5->ContactPersonType
						);
					};
				}
			}
		}
		// print_r($show['personal']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function expedition_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 
		$ExpeditionID = $this->input->post('expeditionid');

		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$company 	= $this->input->post('company'); 
		$shop 		= $this->input->post('shop'); 
		$gender 	= $this->input->post('gender'); 
		$religion 	= $this->input->post('religion');
		$noktp 		= $this->input->post('noktp'); 
		$npwp 		= $this->input->post('npwp'); 
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
		$phoneT		= $this->input->post('phoneT'); 
		$email 		= $this->input->post('email');
		$emailT		= $this->input->post('emailT');

		$contactpid = $this->input->post('contactpid');
		$contactptype = $this->input->post('contactptype');

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
			'isCompany' => $isCompany,
			'isSupplier'=> "1", 
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);

		if ($ContactID == "") { //jika data contact baru
			$this->db->insert('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};

			$data_expedition = array(
		        'ContactID' => $ContactID,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_expedition', $data_expedition);
			$this->last_query .= "//".$this->db->last_query();

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

		} else { // jika data contact exist
			unset($data_contact["InputDate"]); 
			unset($data_contact["InputBy"]);
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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};
			if ($isCompany == "1") {
				for ($i=0; $i < count($contactpid);$i++) {
					$data_contact_person = array(
				        'ContactID' => $ContactID,
				        'ContactPersonID' => $contactpid[$i],
						'ContactPersonType' => $contactptype[$i]
					);
					$this->db->insert('tb_contact_person', $data_contact_person);
					$this->last_query .= "//".$this->db->last_query();
				};
			}

			$data_expedition = array(
		        'ContactID' => $ContactID,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID')
			);
			if ($ExpeditionID == "") { // jika data supplier baru
				$this->db->insert('tb_expedition', $data_expedition);
				$this->last_query .= "//".$this->db->last_query();
			} else {	// jika data supplier exist
				$this->db->where('ExpeditionID', $ExpeditionID);
				$this->db->update('tb_expedition', $data_expedition);
				$this->last_query .= "//".$this->db->last_query();
			}

		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	
// supplier==================================================================
	function supplier_list()
	{
		$sql = "select * FROM vw_supplier";
		$query 	= $this->db->query($sql);
		$show = array();
		foreach ($query->result() as $row) {
			$status  = $row->isActive=="1" ? "Active" : "NonActive" ;
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'SupplierID' => $row->SupplierID,
		  			'fullname' => $row->Company2,
		  			'Company' => $row->Company,
					'Phone' => $row->phone,
					'Address' => $row->Address,
					'isSupplier' => $row->isSupplier,
					'isActive' => $row->isActive,
					'status' => $status
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function supplier_list_detail()
	{
		$show = array();
        $id  = $this->input->get_post('a');

        // query get data utama
		$sql = "select c.*, r.*, s.* from vw_contact2 c ";
		$sql .= "LEFT JOIN tb_supplier_main s ON c.ContactID = s.ContactID ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "where c.ContactID = '".$id."'";
		$sql .= "and c.isSupplier = 1 ";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		$gender		= $row->Gender=="M" ? "Male" : "Female";

		// query get data alamat
		$sql3 = "select ca.*, cas.*, capr.*, cac.*, cad.*, capo.* from tb_contact_address ca ";
		$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "where ca.ContactID = '".$id."' order by ca.isBilling DESC, ca.DetailType ";
		$query3 = $this->db->query($sql3);
		// $row2 	= $query2->row();	
		// echo $sql3 ."<br>";
		$alamat = "";
		foreach ($query3->result() as $row3) {
			$billing = $row3->isBilling==0 ? "" : "(Billing address)";
		  	$alamat .= "<b>".$row3->DetailType.$billing."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID."<br><br>";
		};

		// query get data phone email
		$sql4 = "select cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$id."'";
		$query4 = $this->db->query($sql4);
		// $row2 	= $query2->row();	
		// echo $sql4 ."<br>";
		$phone = "";
		$email = "";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email") {
				$email .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			} else {
				$phone .= $row4->DetailValue." (".$row4->DetailTitle.") "."<br>";
			}
		};

		// query get data contact person
		$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
				LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
				WHERE cp.ContactID='".$id."' and cp.ContactPersonID <>''";
		$query5 = $this->db->query($sql5);
		$contact_person = "";
		foreach ($query5->result() as $row5) {
			$contact_person .= $row5->ContactPersonID." // ".$row5->Company2." // ".$row5->ContactPersonType."<br>";
		};

	  	$show = array(
		  	'id' => $id,
		  	'ContactID' => $row->ContactID,
		  	'SupplierID' => $row->SupplierID,
			'isCompany' => $row->isCompany,
			'fullname' => $row->fullname,
			'Company2' => $row->Company2,
			'gender' => $gender,
			'BirthDate' => $row->BirthDate,
			'religion' => $row->ReligionName,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'ShopName' => $row->ShopName,
			'Phone' => $phone,
			'Email' => $email,
			'address' => $alamat,
			'isSupplier' => $row->isSupplier,
			'contact_person' => $contact_person
		);

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function supplier_set($val)
	{
		$this->db->set('isSupplier', 1);
		$this->db->where('ContactID', $val);
		$this->db->update('tb_contact');
		$this->last_query .= "//".$this->db->last_query();

		$data_supplier = array(
	        'ContactID' => $val,
	        'LastUpdate' => date("Y-m-d H:i:s"),
	        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
			'SupplierPayTerm'	=> 0,
			'isActive' => 1
		);
		$this->db->insert('tb_supplier_main', $data_supplier);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
	}
	function supplier_list_detail2()
	{
		$show = array();
        $SupplierID = $this->input->get_post('SupplierID');
        $SupplierID = explode('_', $SupplierID);

        // query get data utama
		$sql = "select c.*, r.*, s.* from tb_contact c ";
		$sql .= "LEFT JOIN tb_supplier_main s ON c.ContactID = s.ContactID ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "where s.SupplierID = '".$SupplierID[0]."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		// echo $sql ."<br>";
		// print_r($row2);
		$ContactID 	= $row->ContactID;
		$show['SupplierPayTerm'] = $row->SupplierPayTerm;
		$show['SupplierShipTerm'] = $row->SupplierShipTerm;
		$show['ContactID'] = $ContactID;

		// query get data alamat
		$sql3 = "select ca.*, cas.*, capr.*, cac.*, cad.*, capo.* from tb_contact_address ca ";
		$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "where ca.ContactID = '".$ContactID."' and ca.isBilling=1";
		$query3 = $this->db->query($sql3);
		// $row2 	= $query2->row();	
		// echo $sql3 ."<br>";
		foreach ($query3->result() as $row3) {
		  	$show['alamatTitle'] = $row3->DetailType;
		  	$show['alamat'] = $row3->DetailValue.", ".$row3->CityName.", ".$row3->ProvinceName.", ".$row3->StateName;
		};

		// query get data phone email
		$sql4 = "select cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$ContactID."'";
		$query4 = $this->db->query($sql4);
		// $row2 	= $query2->row();	
		// echo $sql4 ."<br>";
		$show['email'] = "";
		$show['phone'] = "";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email" and $row4->DetailValue != "" ) {
				$show['email'] .= $row4->DetailValue.", ";
			} elseif ($row4->DetailName == "phone" and $row4->DetailValue != "") {
				$show['phone'] .= $row4->DetailValue.", ";
			}
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function supplier_cu($val)
	{
		$show = array();
		if ($val == "new") { //jika data contact baru
			$show['personal'] = array(
			  	'ContactID' => "",
			  	'SupplierID' => "",
			  	'NameFirst' => "",
			  	'NameMid' => "",
			  	'NameLast' => "",
			  	'Company' => "",
				'gender' => "M",
				'religion' => "1",
				'KTP' => "",
				'NPWP' => "",
				'status' => "1",
				'SupplierShipTerm'=> "0",
				'SupplierPayTerm'=> "0",
				'isCompany' => "0"
			);
			$show['alamat'][] = array(
			  	'DetailType' => "",
			  	'DetailValue' => "",
			  	'isBilling' => 0,
			  	'StateID' => "1",
			  	'StateName' => "INDONESIA",
			  	'ProvinceID' => "0",
			  	'ProvinceName' => "",
			  	'CityID' => "0",
			  	'CityName' => "",
			  	'DistrictsID' => "0",
			  	'DistrictsName' => "",
			  	'PosName' => "0"
			);
			$show['email'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);
			$show['phone'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);

		} else { // jika data contact exist
			$sql = "select c.*, r.*, s.* from tb_contact c ";
			$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
			$sql .= "left join tb_supplier_main s on (c.ContactID = s.ContactID) ";
			$sql .= "where c.ContactID = '".$val."'";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			if (empty($row)) {
				redirect(base_url());
			} else {
				// echo $sql ."<br>";
				// print_r($row);
				$show['personal'] = array(
				  	'ContactID' => $val,
				  	'SupplierID' => $row->SupplierID,
				  	'Prefix' => $row->Prefix,
				  	'NameFirst' => $row->NameFirst,
				  	'NameMid' => $row->NameMid,
				  	'NameLast' => $row->NameLast,
				  	'Company' => $row->Company,
				  	'ShopName' => $row->ShopName,
					'gender' => $row->Gender,
					'BirthDate' => $row->BirthDate,
					'religion' => $row->ReligionID,
					'KTP' => $row->NoKTP,
					'NPWP' => $row->NPWP,
					'status' => $row->isActive,
					'SupplierShipTerm'=> $row->SupplierShipTerm,
					'SupplierPayTerm'=> $row->SupplierPayTerm,
					'isCompany' => ($row->isCompany == "" ? "0" : $row->isCompany)
				);

				$sql3 = "select ca.*, cas.StateID,  cas.StateName, capr.ProvinceID, capr.ProvinceName, cac.CityID, cac.CityName, cad.DistrictsID, cad.DistrictsName, capo.PosName from tb_contact_address ca ";
				$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
				$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
				$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
				$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
				$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
				$sql3 .= "where ca.ContactID = '".$val."' order by ca.isBilling DESC, ca.DetailType ";
				$query3 = $this->db->query($sql3);
				// $row2 	= $query2->row();	
				// echo $sql3 ."<br>";
				foreach ($query3->result() as $row3) {
				  	$show['alamat'][] = array(
					  	'DetailType' => $row3->DetailType,
					  	'DetailValue' => $row3->DetailValue,
					  	'isBilling' => $row3->isBilling,
					  	'StateID' => $row3->StateID,
					  	'StateName' => $row3->StateName,
					  	'ProvinceID' => $row3->ProvinceID,
					  	'ProvinceName' => $row3->ProvinceName,
					  	'CityID' => $row3->CityID,
					  	'CityName' => $row3->CityName,
					  	'DistrictsID' => $row3->DistrictsID,
					  	'DistrictsName' => $row3->DistrictsName,
					  	'PosName' => $row3->PosID
					);
				};

				$sql4 = "select cd.* from tb_contact_detail cd ";
				$sql4 .= "where cd.ContactID = '".$val."'";
				$query4 = $this->db->query($sql4);
				// $row2 	= $query2->row();	
				// echo $sql4 ."<br>";
				$phone = "";
				$email = "";
				foreach ($query4->result() as $row4) {
					if ($row4->DetailName == "email") {
						$show['email'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					} else {
						$show['phone'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					}
				};

				if ($row->isCompany == "1") {
					$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
							LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
							WHERE cp.ContactID='".$val."' and cp.ContactPersonID <>''";
					$query5 = $this->db->query($sql5);
					foreach ($query5->result() as $row5) {
				  		$show['cperson'][] = array(
						  	'ContactPersonID' => $row5->ContactPersonID,
						  	'Company2' => $row5->Company2,
							'ContactPersonType' => $row5->ContactPersonType
						);
					};
				}
			}
		
		}
		// print_r($show['personal']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function supplier_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 
		$SupplierID	= $this->input->post('supplierid');

		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$company 	= $this->input->post('company'); 
		$shop 		= $this->input->post('shop'); 
		$gender 	= $this->input->post('gender'); 
		$Prefix 	= $this->input->post('Prefix'); 
		$BirthDate 	= $this->input->post('BirthDate'); 
		$religion 	= $this->input->post('religion');
		$noktp 		= $this->input->post('noktp'); 
		$npwp 		= $this->input->post('npwp'); 
		$payment	= $this->input->post('payment'); 
		$shipping	= $this->input->post('shipping'); 
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
		$phoneT		= $this->input->post('phoneT'); 
		$email 		= $this->input->post('email');
		$emailT		= $this->input->post('emailT');
		$status		= $this->input->post('status');

		$contactpid = $this->input->post('contactpid');
		$contactptype = $this->input->post('contactptype');

		$data_contact = array(
	        'NameFirst' => $firstname,
			'NameMid'	=> $middlename,
			'NameLast' 	=> $lastname,
			'Company' 	=> $company,
			'ShopName' 	=> $shop,
			'Gender' 	=> $gender,
			'Prefix' 	=> $Prefix,
			'BirthDate' => $BirthDate,
			'ReligionID' => $religion,
			'NoKTP' => $noktp,
			'NPWP' => $npwp,
			'isCompany' => $isCompany,
			'isSupplier'=> "1", 
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);

		if ($ContactID == "") { //jika data contact baru
			$this->db->insert('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};

			$data_supplier = array(
		        'ContactID' => $ContactID,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
				'SupplierShipTerm' => $shipping,
				'SupplierPayTerm' => $payment,
		        'isActive' => "1"
			);
			$this->db->insert('tb_supplier_main', $data_supplier);
			$this->last_query .= "//".$this->db->last_query();

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

		} else { // jika data contact exist
			unset($data_contact["InputDate"]); 
			unset($data_contact["InputBy"]);
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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};
			if ($isCompany == "1") {
				for ($i=0; $i < count($contactpid);$i++) {
					$data_contact_person = array(
				        'ContactID' => $ContactID,
				        'ContactPersonID' => $contactpid[$i],
						'ContactPersonType' => $contactptype[$i]
					);
					$this->db->insert('tb_contact_person', $data_contact_person);
					$this->last_query .= "//".$this->db->last_query();
				};
			}

			$data_supplier = array(
		        'ContactID' => $ContactID,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
				'SupplierShipTerm' => $shipping,
				'SupplierPayTerm' => $payment,
				'isActive' => $status
			);
			if ($SupplierID == "") { // jika data supplier baru
				$this->db->insert('tb_supplier_main', $data_supplier);
				$this->last_query .= "//".$this->db->last_query();
			} else {	// jika data supplier exist
				$this->db->where('SupplierID', $SupplierID);
				$this->db->update('tb_supplier_main', $data_supplier);
				$this->last_query .= "//".$this->db->last_query();
			}

		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

// customer==================================================================
	function customer_list()
	{
		$sql = "select * from vw_customer1 ";
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$status  = $row->isActive=="1" ? "Active" : "NonActive" ;
		  	$show[] = array(
		  			'ContactID' => $row->ContactID,
		  			'CustomerID' => $row->CustomerID,
		  			'fullname' => $row->fullname,
					'Company' => $row->Company,
					'Email' => $row->email,
					'Phone' => $row->phone,
					'CustomercategoryName' => $row->CustomercategoryName,
					'isSupplier' => $row->isSupplier,
					'sales' => $row->sales,
					'status' => $status
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function customer_list_detail()
	{
		$show = array();
        $id  = $this->input->get_post('a');

        // query data utama
		$sql = "SELECT c.*, r.*, cm.*, cc.* FROM vw_contact2 c ";
		$sql .= "LEFT JOIN tb_customer_main cm ON c.ContactID = cm.ContactID ";
		$sql .= "LEFT JOIN tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "LEFT JOIN tb_customer_category cc ON cm.CustomercategoryID = cc.CustomercategoryID ";
		$sql .= "WHERE cm.ContactID = '".$id."' ";
		$sql .= "AND c.isCustomer = 1 ";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	
		$gender		= $row->Gender=="M" ? "Male" : "Female";
		// get data sales
		$sql2 = "SELECT cd.*, em.Company2 FROM tb_customer_detail cd ";
		$sql2 .= "LEFT JOIN vw_sales_executive2 em ON cd.DetailValue = em.SalesID ";
		$sql2 .= "WHERE cd.DetailType = 'sales' ";
		$sql2 .= "AND cd.CustomerID = '".$row->CustomerID."' ";
		$query2 = $this->db->query($sql2);
		$sales = "";
		$salesID = array();
		foreach ($query2->result() as $row2) {
		  	$sales .= $row2->Company2."<br>";
		  	array_push($salesID, $row2->DetailValue);
		};

		// get data alamat
		$sql3 = "SELECT ca.*, cas.*, capr.*, cac.*, cad.*, capo.* FROM tb_contact_address ca ";
		$sql3 .= "LEFT JOIN tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "LEFT JOIN tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "LEFT JOIN vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "LEFT JOIN tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "LEFT JOIN tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "WHERE ca.ContactID = '".$id."' order by ca.isBilling DESC, ca.DetailType ";
		$query3 = $this->db->query($sql3);
		$alamat = "";
		foreach ($query3->result() as $row3) {
			$billing = $row3->isBilling==0 ? "" : "(Billing address)";
		  	$alamat .= "<b>".$row3->DetailType.$billing."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID."<br><br>";
		};

		// get data alamat dan telepon
		$sql4 = "SELECT cd.* FROM tb_contact_detail cd ";
		$sql4 .= "WHERE cd.ContactID = '".$id."'";
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
		
		// get data Price
		$sql5 = "SELECT cd.*, pm.* FROM tb_customer_detail cd ";
		$sql5 .= "LEFT JOIN tb_price_category_main pm ON cd.DetailValue = pm.PricecategoryID ";
		$sql5 .= "WHERE cd.DetailType = 'price' ";
		$sql5 .= "AND cd.CustomerID = '".$row->CustomerID."' ";
		$query5 = $this->db->query($sql5);
		$price = "";
		foreach ($query5->result() as $row5) {
		  	$price .= $row5->PricecategoryName."<br>";
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
			$contact_person .=  "-> ".$row5->ContactPersonID." | ".$row5->Company2." | ".$row5->ContactPersonType." | ".$row5->phone." | ".$row5->email."<br>";
		};

	  	$show = array(
		  	'id' => $id,
		  	'ContactID' => $row->ContactID,
		  	'CustomerID' => $row->CustomerID,
			'isCompany' => $row->isCompany,
			'fullname' => $row->Company2,
			'gender' => $gender,
			'BirthDate' => $row->BirthDate,
			'religion' => $row->ReligionName,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'Company' => $row->Company,
			'ShopName' => $row->ShopName,
			'Phone' => $phone,
			'Email' => $email,
			'address' => $alamat,
			'sales' => $sales,
			'CustomercategoryName' => $row->CustomercategoryName,
			'isCustomer' => $row->isCustomer,
			'PaymentTerm' => $row->PaymentTerm,
			'CreditLimit' => $row->CreditLimit,
			'contact_person' => $contact_person,
			'price' => $price,
			'CustomerPVMultiplier' => $row->CustomerPVMultiplier,
			'SEPVMultiplier' => $row->SEPVMultiplier,
		);

		$this->load->model('model_transaction');
		$solate = $this->model_transaction->get_so_outstanding($row->CustomerID);
		if (!empty($solate)) {
			$show['solate'] = $solate;
		} else {
			$solatest = $this->model_transaction->get_so_latest($row->CustomerID);
			if (!empty($solatest)) {
				$show['solatest'] = $solatest;
			} 
		}
		$invlate = $this->model_transaction->get_inv_outstanding($row->CustomerID);
		if (!empty($invlate)) {
			$show['invlate'] = $invlate;
		}

		$this->load->model('model_finance');
		$deposit = $this->model_finance->get_customer_deposit_summary2($row->CustomerID);
		if (!empty($deposit)) {
			$show['deposit'] = $deposit;
		}

		$this->load->model('model_report');
		$donotinv = $this->model_report->report_do_not_inv_per_customer($row->CustomerID);
		if (!empty($donotinv)) {
			$show['donotinv'] = $donotinv;
		}

		$sql5 = "SELECT * FROM tb_contact_file WHERE ContactID='".$id."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
		  	$show['file'][] = array(
			  	'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function customer_cu($val)
	{
		$show = array();
		$sql 		= "SELECT CustomerCreditLimit, CustomerPaymentTerm, CustomerPVMultiplier, SEPVMultiplier from tb_site_config ";
		$getQuery 	= $this->db->query($sql);
		$row 		= $getQuery->row();
		$CustomerCreditLimit 	= $row->CustomerCreditLimit;
		$CustomerPVMultiplier 	= $row->CustomerPVMultiplier;
		$SEPVMultiplier 	= $row->SEPVMultiplier;
		$CustomerPaymentTerm 	= $row->CustomerPaymentTerm;

		if ($val == "new") { // jika data contact baru
			$show['personal'] = array(
			  	'ContactID' => "",
			  	'CustomerID' => "",
			  	'Prefix' => "",
			  	'NameFirst' => "",
			  	'NameMid' => "",
			  	'NameLast' => "",
			  	'Company' => "",
			  	'ShopName' => "",
				'BirthDate' => "",
				'gender' => "M",
				'religion' => "1",
				'CustomercategoryID' => "1",
				'KTP' => "",
				'NPWP' => "",
				'creditlimit' => $CustomerCreditLimit,
				'customerpv' => $CustomerPVMultiplier,
				'sepv' => $SEPVMultiplier,
				'paymentterm' => $CustomerPaymentTerm,
				'status' => "1",
				'target' => "0",
				'isCompany' => "0"
			);
			$show['alamat'][] = array(
			  	'DetailType' => "",
			  	'DetailValue' => "",
			  	'isBilling' => 0,
			  	'StateID' => "1",
			  	'StateName' => "INDONESIA",
			  	'ProvinceID' => "",
			  	'ProvinceName' => "",
			  	'CityID' => "",
			  	'CityName' => "",
			  	'DistrictsID' => "",
			  	'DistrictsName' => "",
			  	'PosName' => ""
			);
			$show['email'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);
			$show['phone'][] = array(
			  	'DetailValue' => "",
			  	'DetailTitle' => ""
			);
			$show['sales'][] = array(
			  	'salesID' => "",
			  	'salesName' => ""
			);
			$show['price'][] = array(
			  	'PricecategoryID' => "",
			  	'PricecategoryName' => ""
			);

		} else { // jika edit atau data contact exist
			$sql = "SELECT c.*, r.*, cm.* ,coalesce(tct.Status,0) as target from tb_contact c ";
			$sql .= "LEFT JOIN tb_religion r on (c.ReligionID = r.ReligionID) ";
			$sql .= "LEFT JOIN tb_customer_main cm on (c.ContactID = cm.ContactID) ";
			$sql .= "LEFT JOIN tb_customer_category cc on (cm.CustomercategoryID = cc.CustomercategoryID) ";
			$sql .= "LEFT JOIN tb_customer_target tct ON (tct.CustomerID = cm.CustomerID)";
			$sql .= "where c.ContactID = '".$val."'";
			// echo $sql;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();

			if (empty($row)) {
				redirect(base_url());
			} else {
				// echo $sql ."<br>";
				// print_r($row);

				$show['personal'] = array(
				  	'ContactID' => $val,
				  	'CustomerID' => $row->CustomerID,
				  	'NameFirst' => $row->NameFirst,
				  	'NameMid' => $row->NameMid,
				  	'NameLast' => $row->NameLast,
				  	'Company' => $row->Company,
				  	'Prefix' => $row->Prefix,
				  	'ShopName' => $row->ShopName,
					'gender' => $row->Gender,
					'BirthDate' => $row->BirthDate,
					'religion' => $row->ReligionID,
					'KTP' => $row->NoKTP,
					'NPWP' => $row->NPWP,
					'creditlimit' => $row->CreditLimit != "" ? $row->CreditLimit : $CustomerCreditLimit,
					'customerpv' => $row->CustomerPVMultiplier != "" ? $row->CustomerPVMultiplier : $CustomerPVMultiplier,
					'sepv' => $row->SEPVMultiplier != "" ? $row->SEPVMultiplier : $SEPVMultiplier,
					'paymentterm' => $row->PaymentTerm != "" ? $row->PaymentTerm : $CustomerPaymentTerm,
					'CustomercategoryID' => $row->CustomercategoryID != "" ? $row->CustomercategoryID : "1",
					'CustomerNote' => $row->CustomerNote,
					'status' => $row->isActive,
					'target' => $row->target,
					'isCompany' => ($row->isCompany == "" ? "0" : $row->isCompany)
				);

				$sql3 = "SELECT ca.*, cas.StateID,  cas.StateName, capr.ProvinceID, capr.ProvinceName, cac.CityID, cac.CityName, cad.DistrictsID, cad.DistrictsName, capo.PosName from tb_contact_address ca ";
				$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
				$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
				$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
				$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
				$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
				$sql3 .= "where ca.ContactID = '".$val."' order by ca.isBilling DESC, ca.DetailType ";
				$query3 = $this->db->query($sql3);
				// $row2 	= $query2->row();	
				// echo $sql3 ."<br>";
				foreach ($query3->result() as $row3) {
				  	$show['alamat'][] = array(
					  	'DetailType' => $row3->DetailType,
					  	'DetailValue' => $row3->DetailValue,
					  	'isBilling' => $row3->isBilling,
					  	'StateID' => $row3->StateID,
					  	'StateName' => $row3->StateName,
					  	'ProvinceID' => $row3->ProvinceID,
					  	'ProvinceName' => $row3->ProvinceName,
					  	'CityID' => $row3->CityID,
					  	'CityName' => $row3->CityName,
					  	'DistrictsID' => $row3->DistrictsID,
					  	'DistrictsName' => $row3->DistrictsName,
					  	'PosName' => $row3->PosID
					);
				};

				$sql4 = "SELECT cd.* from tb_contact_detail cd ";
				$sql4 .= "where cd.ContactID = '".$val."'";
				$query4 = $this->db->query($sql4);
				// $row2 	= $query2->row();	
				// echo $sql4 ."<br>";
				$phone = "";
				$email = "";
				foreach ($query4->result() as $row4) {
					if ($row4->DetailName == "email") {
						$show['email'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					} else {
						$show['phone'][] = array(
						  	'DetailValue' => $row4->DetailValue,
						  	'DetailTitle' => $row4->DetailTitle
						);
					}
				};
				if ($row->isCompany == "1") {
					$sql5 = "SELECT cp.*, c.Company2 FROM tb_contact_person cp
							LEFT JOIN vw_contact2 c ON (cp.ContactPersonID=c.ContactID)
							WHERE cp.ContactID='".$val."' and cp.ContactPersonID <>''";
					$query5 = $this->db->query($sql5);
					foreach ($query5->result() as $row5) {
				  		$show['cperson'][] = array(
						  	'ContactPersonID' => $row5->ContactPersonID,
						  	'Company2' => $row5->Company2,
							'ContactPersonType' => $row5->ContactPersonType
						);
					};
				}

				$sql5 = "SELECT * FROM tb_contact_file WHERE ContactID='".$val."'";
				$query5 = $this->db->query($sql5);
				foreach ($query5->result() as $row5) {
			  		$show['file'][] = array(
					  	'ContactID' => $row5->ContactID,
					  	'FileType' => $row5->FileType,
						'FileName' => $row5->FileName
					);
				};

				if ($row->CustomerID != "") { // jika data customer exist
					$sql2 = "SELECT cd.*, c.Company2 from tb_customer_detail cd ";
					$sql2 .= "left join vw_sales_executive2 c on (cd.DetailValue = c.SalesID) ";
					$sql2 .= "where cd.CustomerID = '".$row->CustomerID."' ";
					$sql2 .= "and cd.DetailType = 'sales'";
					$query2 = $this->db->query($sql2);
					// $row2 	= $query2->row();	
					// echo $sql2;
					foreach ($query2->result() as $row4) {
						if ($row4->DetailType == "sales") {
							$show['sales'][] = array(
							  	'salesID' => $row4->DetailValue,
							  	'salesName' => $row4->Company2
							);
						}
					};

					$sql2 = "SELECT cd.*, p.* from tb_customer_detail cd ";
					$sql2 .= "left join tb_price_category_main p on (cd.DetailValue = p.PricecategoryID) ";
					$sql2 .= "where cd.CustomerID = '".$row->CustomerID."' ";
					$sql2 .= "and cd.DetailType = 'price'";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() == 0) {
						$show['price'][] = array(
						  	'PricecategoryID' => "",
						  	'PricecategoryName' => ""
						);
					} else {
						foreach ($query2->result() as $row4) {
							if ($row4->DetailType == "price") {
								$show['price'][] = array(
								  	'PricecategoryID' => $row4->DetailValue,
								  	'PricecategoryName' => $row4->PricecategoryName
								);
							}
						};
					}
				} else {
					$show['sales'][] = array(
					  	'salesID' => "",
					  	'salesName' => ""
					);
					$show['price'][] = array(
					  	'PricecategoryID' => "",
					  	'PricecategoryName' => ""
					);
				}
			
			}
		}
		// print_r($show['personal']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function customer_cu_act()
	{
		$this->db->trans_start();

		// get price category endUser
		$sql = "SELECT PricecategoryID FROM tb_price_category_main WHERE PricecategoryName LIKE '%End User%' ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$enduser[] = $row->PricecategoryID;
		};

		$sql 		= "SELECT CustomerCreditLimit, CustomerPaymentTerm, CustomerPVMultiplier, SEPVMultiplier FROM tb_site_config ";
		$getQuery 	= $this->db->query($sql);
		$row 		= $getQuery->row();
		$CustomerCreditLimitDef = $row->CustomerCreditLimit;
		$CustomerPVMultiplierDef = $row->CustomerPVMultiplier;
		$SEPVMultiplierDef = $row->SEPVMultiplier;
		$CustomerPaymentTermDef	= $row->CustomerPaymentTerm;

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 
		$CustomerID	= $this->input->post('customerid');

		$Prefix 	= $this->input->post('Prefix'); 
		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$company 	= $this->input->post('company'); 
		$shop 		= $this->input->post('shop'); 
		$gender 	= $this->input->post('gender'); 
		$BirthDate 	= $this->input->post('BirthDate'); 
		$religion 	= $this->input->post('religion');
		$noktp 		= $this->input->post('noktp'); 
		$npwp 		= $this->input->post('npwp'); 
		$creditlimit 	= $this->input->post('creditlimit');
		$creditlimitold = $this->input->post('creditlimitold');
		$customerpv 	= $this->input->post('customerpv');
		$customerpvold = $this->input->post('customerpvold');
		$sepv 	= $this->input->post('sepv');
		$sepvold = $this->input->post('sepvold');
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
		$phoneT		= $this->input->post('phoneT'); 
		$email 		= $this->input->post('email');
		$emailT		= $this->input->post('emailT');
		$sales 		= $this->input->post('sales');
		$price 		= $this->input->post('price');
		$price_text = $this->input->post('price_text');
		$status		= $this->input->post('status');
		$target		= $this->input->post('target');
		$fileN = $this->input->post('fileN'); 
		$fileT = $this->input->post('fileT');
		$fileTold = $this->input->post('fileTold');
		$fileNold = $this->input->post('fileNold');

		$contactpid = $this->input->post('contactpid');
		$contactptype = $this->input->post('contactptype');
		$datetime = date('Y-m-d H:i:s');
		
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
			'Prefix' 	=> $Prefix,
			'NameFirst' => $firstname,
			'NameMid'	=> $middlename,
			'NameLast' 	=> $lastname,
			'Company' 	=> $company,
			'ShopName' 	=> $shop,
			'BirthDate' => $BirthDate,
			'Gender' 	=> $gender,
			'ReligionID' => $religion,
			'NoKTP' => $noktp,
			'NPWP' => $npwp,
			'isCustomer'=> "1",
			'isCompany' => $isCompany,
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);

		if ($ContactID == "") { // jika data contact baru
			$this->db->insert('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "SELECT max(ContactID) as ContactID FROM tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
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
		        'CreditLimit' => $CustomerCreditLimitDef, //diisi default
		        'PaymentTerm' => $CustomerPaymentTermDef, //diisi default
		        'CustomerPVMultiplier' => $CustomerPVMultiplierDef, //diisi default
		        'SEPVMultiplier' => $SEPVMultiplierDef, //diisi default
		        'InsertDate' => date("Y-m-d H:i:s"),
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
		        'isActive' => "1"
			);
			$this->db->insert('tb_customer_main', $data_customer);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "SELECT max(CustomerID) as CustomerID from tb_customer_main ";
			$getCustomerID = $this->db->query($sql);
			$row 		= $getCustomerID->row();
			$CustomerID = $row->CustomerID;

			if ($creditlimit >= $CustomerCreditLimitDef) { //jika berubah dari posisi default 5juta
				$creditlimit2 = number_format($creditlimit,2,",",".");
				$data_approval = array(
					'CustomerID' => $CustomerID,
					'isComplete' => "0",
					'Status' => "OnProgress",
					'Keterangan' => "Change Credit Limit Menjadi Rp.".$creditlimit2." by ".$this->session->userdata('UserName'),
					'ApprovalQuery' => "UPDATE tb_customer_main SET CreditLimit='".$creditlimit."' where CustomerID='".$CustomerID."'"
				);
				$this->db->insert('tb_approval_customer_category', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
			if ($customerpv != $CustomerPVMultiplierDef || $sepv != $SEPVMultiplierDef ) { //jika CustomerPV Mp OR SE PV Berubah
				$customerpv2 = $customerpv;
				$sepv2 = $sepv;
				$data_approval = array(
					'CustomerID' => $CustomerID,
					'isComplete' => "0",
					'Status' => "OnProgress",
					'Keterangan' => "Change Customer PV Multiplier ".$customerpv2." AND SE PV Multiplier ".$sepv2." by ".$this->session->userdata('UserName'),
					'ApprovalQuery' => "UPDATE tb_customer_main SET CustomerPVMultiplier='".$customerpv2."', SEPVMultiplier='".$sepv2."' where CustomerID='".$CustomerID."'"
				);
				$this->db->insert('tb_approval_customer_category', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
				$sql 		= "SELECT max(ApprovalID) as ApprovalID from tb_approval_customer_category ";
				$getApprovalID = $this->db->query($sql);
				$row 		= $getApprovalID->row();
				$ApprovalID = $row->ApprovalID;

				$data =array(
					'id' => $ApprovalID,
					'CustomerID' => $CustomerID,
					'CustomerPVMultiplier' => $customerpv,
					'SEPVMultiplier' => $sepv,
					'InputDate' => $datetime,
					'InputBy' => $this->session->userdata('UserAccountID'),
					'isComplete' => '0',
					'Status' => 'Pending',
				);
				$this->db->insert('tb_customer_pv', $data);
				$this->last_query .= "//".$this->db->last_query();
			}
			if ($paymentterm >= $CustomerPaymentTermDef) { //jika berubah dari posisi default 30hari
				$data_approval = array(
					'CustomerID' => $CustomerID,
					'isComplete' => "0",
					'Status' => "OnProgress",
					'Keterangan' => "Change Payment Term Day Menjadi ".$paymentterm." by ".$this->session->userdata('UserName'),
					'ApprovalQuery' => "UPDATE tb_customer_main SET PaymentTerm='".$paymentterm."' where CustomerID='".$CustomerID."'"
				);
				$this->db->insert('tb_approval_customer_category', $data_approval);
				$this->last_query .= "//".$this->db->last_query();
			}
			for ($i=0; $i < count($sales);$i++) {
				$data_customer_sales = array(
					'CustomerID' => $CustomerID,
					'DetailType' => "sales",
					'DetailValue' => $sales[$i]
				);
				$this->db->insert('tb_customer_detail', $data_customer_sales);
				$this->last_query .= "//".$this->db->last_query();
			};

			for ($i=0; $i < count($price);$i++) {
				if ($price[$i] == "" || in_array($price[$i], $enduser)) { // jika pilihan price kosong
					$data_customer_price = array(
						'CustomerID' => $CustomerID,
						'DetailType' => "price",
						'DetailValue' => $price[$i]
					);
					$this->db->insert('tb_customer_detail', $data_customer_price);
					$this->last_query .= "//".$this->db->last_query();
				} else { // jika pilihan price tidak kosong
					$data_approval = array(
				        'CustomerID' => $CustomerID,
				        'isComplete' => "0",
				        'Status' => "OnProgress",
				        'Keterangan' => "Add 'price category : ".$price[$i]."-".$price_text[$i]."'"." by ".$this->session->userdata('UserName'),
				        'ApprovalQuery' => "INSERT INTO tb_customer_detail (CustomerID, DetailType, DetailValue) VALUES ('".$CustomerID."','price','".$price[$i]."')"
					);
					$this->db->insert('tb_approval_customer_category', $data_approval);
					$this->last_query .= "//".$this->db->last_query();
				}
			};

		} else { // jika data contact exist
			unset($data_contact["InputDate"]); 
			unset($data_contact["InputBy"]);
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
			        'DetailValue' => $phone[$i],
			        'DetailTitle' => $phoneT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_phone);
				$this->last_query .= "//".$this->db->last_query();
			};
			for ($i=0; $i < count($email);$i++) {
				$data_contact_email = array(
			        'ContactID' => $ContactID,
			        'DetailName' => "email",
			        'DetailValue' => $email[$i],
			        'DetailTitle' => $emailT[$i]
				);
				$this->db->insert('tb_contact_detail', $data_contact_email);
				$this->last_query .= "//".$this->db->last_query();
			};
			if ($isCompany == "1") {
				if (isset($contactpid)) {
					for ($i=0; $i < count($contactpid);$i++) {
						$data_contact_person = array(
					        'ContactID' => $ContactID,
					        'ContactPersonID' => $contactpid[$i],
							'ContactPersonType' => $contactptype[$i]
						);
						$this->db->insert('tb_contact_person', $data_contact_person);
						$this->last_query .= "//".$this->db->last_query();
					};
				}
			}

			$data_customer = array(
		        'ContactID' => $ContactID,
		        'CustomercategoryID' => $CustomercategoryID,
		        'RegionID' => "1",
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID'),
				'isActive' => $status
			); 

			// get actor 3 approval
			$sql 		= "SELECT Actor3 FROM tb_approval_actor WHERE ApprovalCode='customer_category' ";
			$getActor3 	= $this->db->query($sql);
			$row 		= $getActor3->row();
			$Actor3 	= $row->Actor3;

			if ($CustomerID == "") { //jika data customer baru
				$data_customer['CreditLimit'] = "0";
				$data_customer['CustomerPVMultiplier'] = "0";
				$data_customer['SEPVMultiplier'] = "1";
				$data_customer['PaymentTerm'] = "0";
				$data_customer['InsertDate'] = date("Y-m-d H:i:s");
				$this->db->insert('tb_customer_main', $data_customer);
				$this->last_query .= "//".$this->db->last_query();
				
				$sql 		= "SELECT max(CustomerID) as CustomerID FROM tb_customer_main ";
				$getCustomerID = $this->db->query($sql);
				$row 		= $getCustomerID->row();
				$CustomerID = $row->CustomerID;

				if ($creditlimit > $CustomerCreditLimitDef) { //jika berubah dari posisi default 5juta
					$this->approval_submission_credit_limit($CustomerID, $creditlimit, $Actor3);
				} else { $data_customer['CreditLimit'] = $creditlimit; }
				if ($customerpv > $CustomerPVMultiplierDef || $sepv < $SEPVMultiplierDef) { //jika berubah Customer PV
					$this->approval_submission_customer_pv($CustomerID, $customerpv, $sepv, $Actor3);
					$sql 		= "SELECT max(ApprovalID) as ApprovalID from tb_approval_customer_category ";
					$getApprovalID = $this->db->query($sql);
					$row 		= $getApprovalID->row();
					$ApprovalID = $row->ApprovalID;
						$data =array(
						'id' => $ApprovalID,
						'CustomerID' => $CustomerID,
						'CustomerPVMultiplier' => $customerpv,
						'SEPVMultiplier' => $sepv,
						'InputDate' => $datetime,
						'InputBy' => $this->session->userdata('UserAccountID'),
						'isComplete' => '0',
						'Status' => 'Pending',
					);
					$this->db->insert('tb_customer_pv', $data);
					$this->last_query .= "//".$this->db->last_query();
				} else { $data_customer['CustomerPVMultiplier'] = $customerpv; $data_customer['SEPVMultiplier'] = $sepv; }
				if ($paymentterm > $CustomerPaymentTermDef) { //jika berubah dari posisi default 30hari
					$this->approval_submission_payment_term($CustomerID, $paymentterm, $Actor3);
				} else { $data_customer['PaymentTerm'] = $paymentterm; } 
				$this->db->where('CustomerID', $CustomerID);
				$this->db->update('tb_customer_main', $data_customer);
				
				for ($i=0; $i < count($sales);$i++) {
					$data_customer_sales = array(
				        'CustomerID' => $CustomerID,
				        'DetailType' => "sales",
				        'DetailValue' => $sales[$i]
					);
					$this->db->insert('tb_customer_detail', $data_customer_sales);
					$this->last_query .= "//".$this->db->last_query();
				};

				for ($i=0; $i < count($price);$i++) {
					if ($price[$i] == "" || in_array($price[$i], $enduser)) { // jika pilihan price kosong
						$data_customer_price = array(
							'CustomerID' => $CustomerID,
							'DetailType' => "price",
							'DetailValue' => $price[$i]
						);
						$this->db->insert('tb_customer_detail', $data_customer_price);
						$this->last_query .= "//".$this->db->last_query();
					} else { // jika pilihan price tidak kosong
						$this->approval_submission_price_category($CustomerID, $price[$i], $price_text[$i], $Actor3);
					}
				};

				$data_target = array(
			        'CustomerID' => $CustomerID,
			        'Date' => date("Y-m-d"),
			        'Status' => $target
				);
				$this->db->insert('tb_customer_target', $data_target);
				$this->last_query .= "//".$this->db->last_query();

			} else { //jika data customer exist
				if ($creditlimit != $creditlimitold and $creditlimit > $CustomerCreditLimitDef) { //jika berubah dari posisi sebelumnya
					$this->approval_submission_credit_limit($CustomerID, $creditlimit, $Actor3);
				} else { $data_customer['CreditLimit'] = $creditlimit; } //jika tidak berubah
				if ($customerpv != $CustomerPVMultiplierDef || $sepv != $SEPVMultiplierDef) { //jika berubah dari posisi sebelumnya
					$this->approval_submission_customer_pv($CustomerID, $customerpv, $sepv, $Actor3);
					$sql 		= "SELECT max(ApprovalID) as ApprovalID from tb_approval_customer_category ";
					$getApprovalID = $this->db->query($sql);
					$row 		= $getApprovalID->row();
					$ApprovalID = $row->ApprovalID;
					$data =array(
						'id' => $ApprovalID,
						'CustomerID' => $CustomerID,
						'CustomerPVMultiplier' => $customerpv,
						'SEPVMultiplier' => $sepv,
						'InputDate' => $datetime,
						'InputBy' => $this->session->userdata('UserAccountID'),
						'isComplete' => '0',
						'Status' => 'Pending',
					);
					$this->db->insert('tb_customer_pv', $data);
					$this->last_query .= "//".$this->db->last_query();
				} else { $data_customer['CustomerPVMultiplier'] = $customerpv; } //jika tidak berubah

				if ($paymentterm != $paymenttermold and $paymentterm > $CustomerPaymentTermDef) { //jika berubah dari posisi sebelumnya
					$this->approval_submission_payment_term($CustomerID, $paymentterm, $Actor3);
				} else { $data_customer['PaymentTerm'] = $paymentterm; } //jika tidak berubah

				$price_old = array();
				$sql_price 	 = "SELECT * FROM tb_customer_detail where CustomerID = '".$CustomerID."' and DetailType = 'price'"; //get previous price
				$query_price = $this->db->query($sql_price);	
				foreach ($query_price->result() as $row_price) {
				  	$price_old[] = $row_price->DetailValue ;
				};

				$this->db->where('CustomerID', $CustomerID);
				$this->db->update('tb_customer_main', $data_customer);
				$this->last_query .= "//".$this->db->last_query();

				$this->db->where('CustomerID', $CustomerID);
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
				// print_r($price);
				for ($i=0; $i < count($price);$i++) {
					if (in_array($price[$i], $price_old) || $price[$i] == "" || in_array($price[$i], $enduser)) { //jika price bukan tambah baru atau pilihan price kosong
						$data_customer_price = array(
					        'CustomerID' => $CustomerID,
					        'DetailType' => "price",
					        'DetailValue' => $price[$i]
						);
						$this->db->insert('tb_customer_detail', $data_customer_price);
						$this->last_query .= "//".$this->db->last_query();
					} else { // jika price adalah tambah baru
						$this->approval_submission_price_category($CustomerID, $price[$i], $price_text[$i], $Actor3);
					}
				};
				$data_target = array(
			        'Date' => date("Y-m-d"),
			        'Status' => $target
				);
				$this->db->where('CustomerID', $CustomerID);
				$this->db->update('tb_customer_target', $data_target);
				$this->last_query .= "//".$this->db->last_query();

			}
			$sql5 = "SELECT * FROM tb_contact_file WHERE ContactID='".$ContactID."'";
			$query5 = $this->db->query($sql5);
			foreach ($query5->result() as $row5) {
				if (!in_array($row5->FileType, $fileTold)) {
					$this->db->where('ContactID', $row5->ContactID);
					$this->db->where('FileType', $row5->FileType);
					$this->db->delete('tb_contact_file');
					$this->last_query .= "//".$this->db->last_query();

					$this->load->helper("file");
					$path = './assets/ContactFile/'.$row5->FileName ;
					unlink($path); 
				}
			};

			$dataFile = array();
			for ($i=0; $i < count($fileT);$i++) {
			    if ($_FILES['fileN']['name'][$i] != "") {
			    	$path_parts = pathinfo($_FILES["fileN"]["name"][$i]);
					$extension = $path_parts['extension'];
		            $target_dir = "assets/ContactFile/";
		            $target_name = $ContactID.'-'.$fileT[$i];
	            	$target_file = $target_dir.$target_name.'.'.$extension;
		            if (move_uploaded_file($_FILES["fileN"]["tmp_name"][$i], $target_file)) {
						$dataFile[] = array(
					        'ContactID' => $ContactID,
					        'FileType' => $fileT[$i],
							'FileName' => $target_name.'.'.$extension
						);	
		            }
		        }
			};
			if (count($dataFile)>0) {
				$this->db->insert_batch('tb_contact_file', $dataFile);
			}
		
		}
		$this->history_customer_sales($sales, $CustomerID);
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function customer_pv_cu($val)
	{
		$show	= array();

		$sql	= "SELECT CustomerID, Company2, CustomerPVMultiplier FROM vw_customer5 WHERE ContactID=".$val;
		// echo $sql;
		$query	= $this->db->query($sql);
		$show   = $query->result_array()[0];

		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function customer_pv_cu_act()
	{
		$this->db->trans_start();
		$CustomerID = $this->input->get_post('customerid');
		$CustomerPV = $this->input->get_post('customerpv');
		$SEPV = $this->input->get_post('sepv');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data_customerpv = array(
			'CustomerID' => $CustomerID,
			'CustomerPVMultiplier' => $CustomerPV,
			'SEPVMultiplier' => $SEPV,
			'LastUpdate' => $datetime,
			'LastUpdateBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->where('CustomerID', $CustomerID);
		$this->db->update('tb_customer_main', $data_customerpv);
		$this->last_query .= "//".$this->db->last_query();

		$data =array(
			'CustomerID' => $CustomerID,
			'CustomerPVMultiplier' => $CustomerPV,
			'SEPVMultiplier' => $SEPV,
			'InputDate' => $datetime,
			'InputBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_customer_pv', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		// echo $this->last_query;
		$this->db->trans_complete();
	}
	function history_customer_sales($sales, $CustomerID)
	{
		$sql 	= "select SalesID from tb_history_customer_sales where CustomerID=".$CustomerID." and DateEnd is null";
		$query 	= $this->db->query($sql);
		if ($query->num_rows()<=0) {
	        for ($i=0; $i < count($sales);$i++) {
	   			$data_customer_sales = array(
			        'CustomerID' => $CustomerID,
			        'SalesID' => $sales[$i],
	        		'DateStart' => date("Y-m-d")
				);
				$this->db->insert('tb_history_customer_sales', $data_customer_sales);
				$this->last_query .= "//".$this->db->last_query();
			};
	    } else {
   			foreach ($query->result() as $row) {
			  	$result[] = $row->SalesID;
			};

   			// update history sales lama
   			$result2 = array_diff($result, $sales);
   			foreach ($result2 as $key => $row) {
				$this->db->set('DateEnd', date("Y-m-d"));
				$this->db->where('CustomerID', $CustomerID);
				$this->db->where('SalesID', $row);
				$this->db->where('DateEnd is NULL', NULL, FALSE);
				$this->db->update('tb_history_customer_sales');
				$this->last_query .= "//".$this->db->last_query();
			};

   			// update history sales baru
   			$result2 = array_diff($sales, $result);
   			foreach ($result2 as $key => $row) {
	   			$data_customer_sales = array(
			        'CustomerID' => $CustomerID,
			        'SalesID' => $row,
	        		'DateStart' => date("Y-m-d")
				);
				$this->db->insert('tb_history_customer_sales', $data_customer_sales);
				$this->last_query .= "//".$this->db->last_query();
			};
	    }
		$this->log_user->log_query($this->last_query);
	}
	function approval_submission_credit_limit($CustomerID, $creditlimit, $Actor3)
	{
		$this->db->trans_start();
		$query = "update tb_customer_main set CreditLimit='".$creditlimit."' where CustomerID='".$CustomerID."'";
		if ($Actor3 != 0) {
			$data_approval = array(
		        'CustomerID' => $CustomerID,
	        	'isComplete' => "0",
	        	'Status' => "OnProgress",
		        'Keterangan' => "Change Credit Limit Menjadi Rp.".number_format($creditlimit)." by ".$this->session->userdata('UserName'),
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
		        'CustomerID' => $CustomerID,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
		        'Keterangan' => "Change Credit Limit Menjadi Rp.".number_format($creditlimit)." by ".$this->session->userdata('UserName'),
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->query($query);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function approval_submission_customer_pv($CustomerID, $customerpv, $sepv, $Actor3)
	{
		$this->db->trans_start();
		$query = "UPDATE tb_customer_main set CustomerPVMultiplier='".$customerpv."', SEPVMultiplier='".$sepv."'  where CustomerID='".$CustomerID."'";
		if ($Actor3 != 0) {
			$data_approval = array(
				'CustomerID' => $CustomerID,
				'isComplete' => "0",
				'Status' => "OnProgress",
				'Keterangan' => "Change Customer PV Multiplier to ".$customerpv." AND SE PV Multiplier to ".$sepv." by ".$this->session->userdata('UserName'),
				'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
				'CustomerID' => $CustomerID,
				'isComplete' => "1",
				'Status' => "Approved",
				'Keterangan' => "Change Customer PV Multiplier to ".$customerpv." AND SE PV Multiplier to ".$sepv." by ".$this->session->userdata('UserName'),
				'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function approval_submission_payment_term($CustomerID, $paymentterm, $Actor3)
	{
		$this->db->trans_start();
		$query = "update tb_customer_main set PaymentTerm='".$paymentterm."' where CustomerID='".$CustomerID."'";
		if ($Actor3 != 0) {
			$data_approval = array(
		        'CustomerID' => $CustomerID,
	        	'isComplete' => "0",
	        	'Status' => "OnProgress",
		        'Keterangan' => "Change Payment Term Day Menjadi ".$paymentterm." by ".$this->session->userdata('UserName'),
		        'ApprovalQuery' => $query
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
		        'CustomerID' => $CustomerID,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
		        'Keterangan' => "Change Payment Term Day Menjadi ".$paymentterm." by ".$this->session->userdata('UserName'),
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->query($query);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function approval_submission_price_category($CustomerID, $priceID, $priceName, $Actor3)
	{
		$this->db->trans_start();
		$query = "insert into tb_customer_detail (CustomerID, DetailType, DetailValue) VALUES ('".$CustomerID."','price','".$priceID."')";
		if ($Actor3 != 0) {
			$data_approval = array(
		        'CustomerID' => $CustomerID,
		        'isComplete' => "0",
		        'Status' => "OnProgress",
		        'Keterangan' => "Add 'price category : ".$priceID."-".$priceName."'"." by ".$this->session->userdata('UserName'),
		        'ApprovalQuery' => $query
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
		        'CustomerID' => $CustomerID,
	        	'isComplete' => "1",
	        	'Status' => "Approved",
		        'Keterangan' => "Add 'price category : ".$priceID."-".$priceName."'"." by ".$this->session->userdata('UserName'),
		        'ApprovalQuery' => $query,
			);
			$this->db->insert('tb_approval_customer_category', $data_approval);
			$this->last_query .= "//".$this->db->last_query();

			$this->db->query($query);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

// product===================================================================
	function product_list()
	{
		$sql 	= "SELECT * FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID 
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID 
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID 
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID 
					GROUP BY pm.ProductID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'ProductID' => $row->ProductID, 
					'ProductName' => $row->ProductName, 
					'ProductCode' => $row->ProductCode, 
					'ProductStatusName' => $row->ProductStatusName, 
					'ProductCategoryID' => $row->ProductCategoryID, 
					'ProductCategoryName' => $row->ProductCategoryName, 
					'ProductBrandID' => $row->ProductBrandID, 
					'ProductBrandName' => $row->ProductBrandName, 
					'ProductAtributSetName' => $row->ProductAtributeSetName, 
					'ProductPriceDefault' => $row->ProductPriceDefault, 
					'ProductImage' => $row->ProductImage, 
					'ProductDoc' => $row->ProductDoc, 
					'ProductCodeBar' => $row->ProductCodeBar, 
					'forSale' => ($row->forSale == "" ? "1" : $row->forSale), 
					'Stockable' => ($row->Stockable == "" ? "1" : $row->Stockable), 
					'MaxStock' => $row->MaxStock, 
					'MinStock' => $row->MinStock, 
					'isActive' => ($row->isActive == "" ? "1" : $row->isActive),
				);
		};
		$show['fullbrand'] = $this->get_full_brand();
		$show['fullcategory'] = $this->get_full_category();
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_list2()
	{
		$sql 	= "SELECT * FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID 
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID 
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID 
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID 
					GROUP BY pm.ProductID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'ProductID' => $row->ProductID, 
					'ProductName' => $row->ProductName, 
					'ProductCode' => $row->ProductCode, 
					'ProductStatusName' => $row->ProductStatusName, 
					'ProductCategoryID' => $row->ProductCategoryID, 
					'ProductCategoryName' => $row->ProductCategoryName, 
					'ProductBrandID' => $row->ProductBrandID, 
					'ProductBrandName' => $row->ProductBrandName, 
					'ProductAtributSetName' => $row->ProductAtributeSetName, 
					'ProductPriceDefault' => $row->ProductPriceDefault, 
					'ProductImage' => $row->ProductImage, 
					'ProductDoc' => $row->ProductDoc, 
					'forSale' => ($row->forSale == "" ? "1" : $row->forSale), 
					'Stockable' => ($row->Stockable == "" ? "1" : $row->Stockable), 
					'MaxStock' => $row->MaxStock, 
					'MinStock' => $row->MinStock, 
					'isActive' => ($row->isActive == "" ? "1" : $row->isActive),
				);
		};
		$show['fullbrand'] = $this->get_full_brand();
		$show['fullcategory'] = $this->get_full_category();
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_detail($id)
	{
		$sql 	= "SELECT pm.*,pb.*,pas.*,ps.*, coalesce(pst.stock,0) as stockAll FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID 
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID 
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID 
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID 
					left JOIN vw_product_stock pst ON pst.ProductID=pm.ProductID 
					where pm.ProductID = '".$id."'
					GROUP BY pm.ProductID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show = array(
		  			'ProductID' => $row->ProductID, 
					'ProductName' => $row->ProductName, 
					'ProductCode' => $row->ProductCode, 
					'ProductDescription' => $row->ProductDescription, 
					'ProductStatusID' => $row->ProductStatusID, 
					'ProductCategoryID' => $row->ProductCategoryID, 
					'ProductBrandID' => $row->ProductBrandID, 
					'ProductAtributeSetID' => $row->ProductAtributeSetID, 
					'ProductPriceDefault' => $row->ProductPriceDefault, 
					'ProductMultiplier' => $row->ProductMultiplier, 
					'ProductCountry' => $row->ProductCountry, 
					'ProductCodeBar' => $row->ProductCodeBar, 
					'Stockable' => ($row->Stockable == "" ? "1" : $row->Stockable), 
					'MaxStock' => $row->MaxStock, 
					'MinStock' => $row->MinStock, 
					'forSale' => ($row->forSale == "" ? "1" : $row->forSale), 
					'isActive' => $row->isActive,
					'ProductPriceHPP' => $row->ProductPriceHPP,
					'ProductPricePersentage' => $row->ProductPricePercent,
					'ProductSupplier'	=> $row->ProductSupplier,
					'stockAll' => $row->stockAll,
				);
		};

		$sql2 	= "SELECT * FROM tb_product_atribute_detail where ProductID = '".$id."'";
		$query2 = $this->db->query($sql2);
		if ($query2->num_rows() != 0 ) {
			foreach ($query2->result() as $row) {
			  	$show['detail'][] = array(
			  			'ProductAtributeID' => $row->ProductAtributeID, 
						'AtributeValue' => $row->AtributeValue
					);
			};
			$show['detail2'] = json_encode($show['detail']);
		}
		// echo json_encode($show['detail']);
		$sql3 	= "SELECT prm.*, pm.ProductName FROM	tb_product_raw_material prm 
					LEFT JOIN tb_product_main pm ON prm.RawMaterialID = pm.ProductID where prm.ProductID = '".$id."'";
		$query3 = $this->db->query($sql3);
		if ($query3->num_rows() != 0 ) {
			foreach ($query3->result() as $row) {
			  	$show['raw'][] = array(
			  			'RawMaterialID' => $row->RawMaterialID, 
						'ProductName' => $row->ProductName
					);
			};
			$show['raw2'] = json_encode( $show['raw'] );
		}

		$sql5 = "SELECT * FROM tb_product_file WHERE ProductID='".$id."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
	  		$show['file'][] = array(
			  	'ProductID' => $row5->ProductID,
			  	'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_add_act()
	{
		$this->db->trans_start();

		// print_r($this->input->post());
		$stockable = $this->input->post('stockable');
		// -------------------------------------------------
		$productid = $this->input->post('productid'); 
		$productname = $this->input->post('productname'); 
		$productcode = $this->input->post('productcode'); 
		$productdescription = $this->input->post('productdescription'); 
		$productbrand = $this->input->post('productbrand'); 
		$productcategory = $this->input->post('productcategory'); 
		$statusquality = $this->input->post('statusquality'); 
		$productatributeset = $this->input->post('productatributeset'); 
		$price 	= $this->input->post('price'); 
		$persen	= $this->input->post('persen'); 
		$hpp	= $this->input->post('hpp'); 
		$multiplier	= $this->input->post('multiplier'); 
		$stockable 	= isset($stockable) ? "1" : "0"; 
		$max 	= $this->input->post('max'); 
		$min 	= $this->input->post('min'); 
		$country= $this->input->post('country'); 
		$productcodebar = $this->input->post('productcodebar'); 
		$forsale = $this->input->post('forsale'); 
		$productsuppliername = $this->input->post('productsuppliername'); 
		$active = $this->input->post('active'); 
		$atributeid = $this->input->post('atributeid'); 
		$atributetype = $this->input->post('atributetype'); 
		$atributevalue = $this->input->post('atributevalue'); 
		$raw = $this->input->post('raw'); 

		$fileN = $this->input->post('fileN'); 
		$fileT = $this->input->post('fileT');
		$fileTold = $this->input->post('fileTold');
		$fileNold = $this->input->post('fileNold');

		// $productimage = "";
		// $productdoc = "";

		// if ($_FILES['image']['name'] != "") {
		// 	$productimage = $productcode.".jpg";
        //     $target_dir = "tool/product/";
        //     $target_file = $target_dir . $productimage;
        //     if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        //         // echo "The file ". basename( $_FILES["santri_foto"]["name"]). " has been uploaded.";
        //     } else {
        //         // echo "Sorry, there was an error uploading your file.";
        //     }
        // }
        // if ($_FILES['pdf']['name'] != "") {
		// 	$productdoc = $productcode.".pdf";
        //     $target_dir = "tool/product/";
        //     $target_file = $target_dir . $productdoc;
        //     if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
        //         // echo "The file ". basename( $_FILES["santri_foto"]["name"]). " has been uploaded.";
        //     } else {
        //         // echo "Sorry, there was an error uploading your file.";
        //     }
        // }

		$data = array(
			'ProductName' => $productname, 
			'ProductCode' => $productcode, 
			'ProductDescription' => $productdescription, 
			'ProductStatusID' => $statusquality, 
			'ProductCategoryID' => $productcategory, 
			'ProductBrandID' => $productbrand, 
			'ProductAtributSetID' => $productatributeset, 
			'ProductPriceDefault' => $price,
			// 'ProductPriceHPP'	=> $hpp,
			// 'ProductPricePercent'	=> $persen,
			'ProductMultiplier'	=> $multiplier,
			'ProductSupplier' => $productsuppliername,
			'ProductCountry' => $country,
			'ProductCodeBar' => $productcodebar,
			// 'ProductImage' => $productimage, 
			// 'ProductDoc' => $productdoc, 
			'Stockable' => $stockable, 
			'MaxStock' => $max, 
			'MinStock' => $min, 
			'forSale' => $forsale, 
			'isActive' => $active,
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		if ($productid != "") {
			$data['ProductID'] = $productid; 
		}
		if ($this->auth->cek5('manage_product_hpp')) {
			$data['ProductPriceHPP'] = $hpp; 
			$data['ProductPricePercent'] = $persen; 
		}
		$this->db->insert('tb_product_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		
		if ($productid != "") {
			$ProductID = $productid; 
		} else {
			$sql 			= "select max(ProductID) as ProductID from tb_product_main ";
			$getProductID 	= $this->db->query($sql);
			$row 			= $getProductID->row();
			$ProductID 		= $row->ProductID;
		}

		for ($i=0; $i < count($atributeid);$i++) {
			$data_atribute = array(
				'ProductID' => $ProductID,
				'ProductAtributeID' => $atributeid[$i],
				'AtributeValue' => $atributevalue[$i]
			);
			$this->db->insert('tb_product_atribute_detail', $data_atribute);
			$this->last_query .= "//".$this->db->last_query();
		};
		if (isset($raw)){
			for ($i=0; $i < count($raw);$i++) {
			$data_raw = array(
				'ProductID' => $ProductID,
				'RawMaterialID' => $raw[$i],
			);
			$this->db->insert('tb_product_raw_material', $data_raw);
			$this->last_query .= "//".$this->db->last_query();
			};
		}

		$sql 			= "select WarehouseID from tb_warehouse_main where WarehouseClass=1 ";
		$getWarehouseID = $this->db->query($sql);
		$row 			= $getWarehouseID->row();
		$WarehouseID 	= $row->WarehouseID;

		$data_stock = array(
			'ProductID' => $ProductID,
			'WarehouseID' => $WarehouseID,
			'Quantity' => 0,
			'LastUpdate' => date("Y-m-d H:i:s")
		);
		$this->db->insert('tb_product_stock_main', $data_stock);
		$this->last_query .= "//".$this->db->last_query();
		
		if ($this->auth->cek5('manage_product_hpp')) {
			$this->product_price_history($ProductID, $hpp, $persen, $price, $multiplier);
		} else {
			$this->product_price_history($ProductID, 0, 0, $price, $multiplier);
		}
		$this->filter_auto_insert_product_promo($ProductID, $productbrand, $productcategory);

		$sql5 = "SELECT * FROM tb_product_file WHERE ProductID='".$ProductID."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			if (!in_array($row5->FileType, $fileTold)) {
				$this->db->where('ProductID', $row5->ProductID);
				$this->db->where('FileType', $row5->FileType);
				$this->db->delete('tb_product_file');
				$this->last_query .= "//".$this->db->last_query();

				$this->load->helper("file");
				$path = './assets/ProductFile/'.$row5->FileName ;
				unlink($path); 
			}
		};

		$dataFile = array();
		for ($i=0; $i < count($fileT);$i++) {
		    if ($_FILES['fileN']['name'][$i] != "") {
		    	$path_parts = pathinfo($_FILES["fileN"]["name"][$i]);
				$extension = $path_parts['extension'];
	            $target_dir = "assets/ProductFile/";
	            $target_name = $ProductID.'-'.$fileT[$i];
            	$target_file = $target_dir.$target_name.'.'.$extension;
	            if (move_uploaded_file($_FILES["fileN"]["tmp_name"][$i], $target_file)) {
					$dataFile[] = array(
				        'ProductID' => $ProductID,
				        'FileType' => $fileT[$i],
						'FileName' => $target_name.'.'.$extension
					);	
	            }
	        }
   		};
   		if (count($dataFile)>0) {
			$this->db->insert_batch('tb_product_file', $dataFile);
   		}

		$ProductIDArr = array($ProductID);
		$ProductArr[$ProductID] = array(
	        'ProductID' => $ProductID,
	        'MinStock' => $min,
	        'MaxStock' => $max
		);
   		$this->load->model('model_transaction');
		$this->model_transaction->product_minmax_history($ProductIDArr, $ProductArr);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function product_edit_act()
	{
		$this->db->trans_start();

		$stockable = $this->input->post('stockable');
		// -----------------------------------------------
		$productid = $this->input->post('productid'); 
		$productname = $this->input->post('productname'); 
		$productcode = $this->input->post('productcode'); 
		$productdescription = $this->input->post('productdescription'); 
		$productbrand = $this->input->post('productbrand'); 
		$productcategory = $this->input->post('productcategory'); 
		$statusquality = $this->input->post('statusquality'); 
		$productatributeset = $this->input->post('productatributeset'); 
		$price 	= $this->input->post('price'); 
		$persen	= $this->input->post('persen'); 
		$hpp	= $this->input->post('hpp');
		$multiplier	= $this->input->post('multiplier'); 
		$stockable 	= isset($stockable) ? "1" : "0"; 
		$max 	= $this->input->post('max'); 
		$min 	= $this->input->post('min'); 
		$country= $this->input->post('country'); 
		$productcodebar = $this->input->post('productcodebar'); 
		$forsale = $this->input->post('forsale'); 
		$productsuppliername = $this->input->post('productsuppliername'); 
		$active = $this->input->post('active'); 
		$atributeid = $this->input->post('atributeid'); 
		$atributetype = $this->input->post('atributetype'); 
		$atributevalue = $this->input->post('atributevalue'); 
		$raw = $this->input->post('raw'); 

		$fileN = $this->input->post('fileN'); 
		$fileT = $this->input->post('fileT');
		$fileTold = $this->input->post('fileTold');
		$fileNold = $this->input->post('fileNold');

		$sql = "SELECT tpm.ProductPriceDefault, tpm.forsale
				FROM tb_product_main tpm
				where tpm.ProductID=".$productid;
		$query 	= $this->db->query($sql);
		$row = $query->row();
		$ProductPriceOld = $row->ProductPriceDefault;
		$ForSaleOld = $row->forsale;
		// echo $ProductPriceDefault = $ProductPriceDefault.".00";

		$data = array(
			'ProductName' => $productname, 
			'ProductCode' => $productcode, 
			'ProductDescription' => $productdescription, 
			'ProductStatusID' => $statusquality, 
			'ProductCategoryID' => $productcategory, 
			'ProductBrandID' => $productbrand, 
			'ProductAtributSetID' => $productatributeset, 
			'ProductPriceDefault' => $price, 
			'ProductMultiplier'	=> $multiplier,
			'ProductCountry' => $country,
			'ProductCodeBar' => $productcodebar,
			'Stockable' => $stockable, 
			'MaxStock' => $max, 
			'MinStock' => $min, 
			'forSale' => $forsale, 
			// 'ProductPriceHPP'	=> $hpp,
			// 'ProductPricePercent' => $persen,
			'ProductSupplier' => $productsuppliername,
			'isActive' => $active, 
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID')
		);

		if ($this->auth->cek5('manage_product_hpp')) {
			$data['ProductPriceHPP'] = $hpp; 
			$data['ProductPricePercent'] = $persen; 
		}

		$productimage = "";
		$productdoc = "";

		$vowels = array("/", "|", ":", "*", "?", "<", ">");
		$filename = str_replace($vowels, "", $productcode);

		// if ($_FILES['image']['name'] != "") {
		// 	$productimage = $filename.".jpg";
		// 	$data['ProductImage'] = $productimage;
        //     $target_dir = "tool/product/";
        //     $target_file = $target_dir . $productimage;
        //     if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        //         // echo "The file ". basename( $_FILES["santri_foto"]["name"]). " has been uploaded.";
        //     } else {
        //         // echo "Sorry, there was an error uploading your file.";
        //     }
        // }
        // if ($_FILES['pdf']['name'] != "") {
			// $productdoc = $filename.".pdf";
			// $data['ProductDoc'] = $productdoc;
            // $target_dir = "tool/product/";
            // $target_file = $target_dir . $productdoc;
            // if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
            //     // echo "The file ". basename( $_FILES["santri_foto"]["name"]). " has been uploaded.";
            // } else {
            //     // echo "Sorry, there was an error uploading your file.";
            // }
        // }

		
		// for auto journal
		$sql = "SELECT ProductPriceHPP FROM tb_product_main WHERE ProductID=".$productid;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$ProductPriceHPPOld = $row->ProductPriceHPP;

		if ($ProductPriceHPPOld != $hpp) {
			$ProductID[$productid] 	= $productid;
			$ValueArr[$productid] 	= $hpp - $ProductPriceHPPOld;
			$this->load->model('model_acc');
			$this->model_acc->auto_journal_hpp_changes($ProductID, $ValueArr);
		}
		// --------------------------------

		$this->db->where('ProductID', $productid);
		$this->db->update('tb_product_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('ProductID', $productid);
		$this->db->delete('tb_product_atribute_detail');
		$this->last_query .= "//".$this->db->last_query();
		$ProductID 		= $productid;
		$ProductManager = 0;
		for ($i=0; $i < count($atributeid);$i++) {
			$ProductManager= ($atributetype[$i]=="ProductManager") ? $atributevalue[$i] : 0 ;
   			$data_atribute = array(
		        'ProductID' => $ProductID,
		        'ProductAtributeID' => $atributeid[$i],
		        'AtributeValue' => $atributevalue[$i]
			);
			$this->db->insert('tb_product_atribute_detail', $data_atribute);
			$this->last_query .= "//".$this->db->last_query();
   		};
		if ($ProductPriceOld!=$price) {
			$ProductIDArr = array($productid);
			$this->info_update_price_list($ProductIDArr, 'Edit Preset');
			//notif
			$this->load->model('model_notification');
			$this->model_notification->insert_notif('notif_price', 'Change Price Default', 'ProductID', $ProductIDArr);
		}
		if ($ForSaleOld!=$forsale) {
			if ($forsale==1) {
			$ProductIDArr = array($productid);
			$ProductManagerArr = array($ProductManager);
			$this->load->model('model_notification');
			$this->model_notification->insert_notif('update_ready_for_sale', 'Ready For Sale', 'ProductID', $ProductIDArr , 'add', $ProductManagerArr);
			}
		}

		$this->db->where('ProductID', $productid);
		$this->db->delete('tb_product_raw_material');
		$this->last_query .= "//".$this->db->last_query();
		if (isset($raw)) {
			for ($i=0; $i < count($raw);$i++) {
				$data_raw = array(
			        'ProductID' => $ProductID,
			        'RawMaterialID' => $raw[$i],
				);
				$this->db->insert('tb_product_raw_material', $data_raw);
				$this->last_query .= "//".$this->db->last_query();
			};
		}

		if ($this->auth->cek5('manage_product_hpp')) {
			$this->product_price_history($ProductID, $hpp, $persen, $price, $multiplier);
		} else {
			// $this->product_price_history($ProductID, 0, 0, $price, $multiplier);
		}
		$this->filter_auto_insert_product_promo($ProductID, $productbrand, $productcategory);

		$sql5 = "SELECT * FROM tb_product_file WHERE ProductID='".$ProductID."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
			if (isset($fileTold)) {
				if (!in_array($row5->FileType, $fileTold)) {
					$this->db->where('ProductID', $row5->ProductID);
					$this->db->where('FileType', $row5->FileType);
					$this->db->delete('tb_product_file');
					$this->last_query .= "//".$this->db->last_query();

					$this->load->helper("file");
					$path = './assets/ProductFile/'.$row5->FileName ;
					if (file_exists($path)) {
						unlink($path); 
					}
				}
			} else {
				$this->db->where('ProductID', $row5->ProductID);
				$this->db->delete('tb_product_file');
				$this->last_query .= "//".$this->db->last_query();
				
				$this->load->helper("file");
				$path = './assets/ProductFile/'.$row5->FileName ;
				if (file_exists($path)) {
					unlink($path); 
				}
			}
		};

		$dataFile = array();
	    for ($i=0; $i < count($fileT);$i++) {
		    if ($_FILES['fileN']['name'][$i] != "") {
		    	$path_parts = pathinfo($_FILES["fileN"]["name"][$i]);
				$extension = $path_parts['extension'];
	            $target_dir = "assets/ProductFile/";
	            $target_name = $ProductID.'-'.$fileT[$i];
            	$target_file = $target_dir.$target_name.'.'.$extension;
	            if (move_uploaded_file($_FILES["fileN"]["tmp_name"][$i], $target_file)) {
					$dataFile[] = array(
				        'ProductID' => $ProductID,
				        'FileType' => $fileT[$i],
						'FileName' => $target_name.'.'.$extension
					);	
	            }
	        }
		};
		if (count($dataFile)>0) {
			$this->db->insert_batch('tb_product_file', $dataFile);
		}

		$ProductIDArr = array($ProductID);
		$ProductArr[$ProductID] = array(
	        'ProductID' => $ProductID,
	        'MinStock' => $min,
	        'MaxStock' => $max
		);
		$this->load->model('model_transaction');
		$this->model_transaction->product_minmax_history($ProductIDArr, $ProductArr);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function get_product_detail()
	{
		$id = $this->input->get('a'); 
		$sql 	= "SELECT * FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID 
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID 
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID 
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID 
					left JOIN tb_address_state ast ON ast.StateID=pm.ProductCountry  
					where pm.ProductID = '".$id."'
					GROUP BY pm.ProductID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$isActive 	= ($row->isActive!="0" ? "Yes" : "No");
			$forSale 	= ($row->forSale!="0" ? "Yes" : "No");
			$Stockable 	= ($row->Stockable!="0" ? "Yes" : "No");
		  	$show = array(
	  			'ProductID' => $row->ProductID, 
				'ProductName' => $row->ProductName, 
				'ProductCode' => $row->ProductCode, 
				'ProductSupplier' => $row->ProductSupplier, 
				'ProductDescription' => $row->ProductDescription, 
				'ProductStatusName' => $row->ProductStatusName, 
				'ProductCategoryID' => $row->ProductCategoryID, 
				'ProductBrandID' => $row->ProductBrandID, 
				'ProductAtributeSetName' => $row->ProductAtributeSetName, 
				'ProductPriceDefault' => $row->ProductPriceDefault, 
				'CountryName' => $row->StateName, 
				'ProductCodeBar' => $row->ProductCodeBar, 
				'Stockable' => $Stockable, 
				'MaxStock' => $row->MaxStock, 
				'MinStock' => $row->MinStock, 
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

		$sql2 	= "SELECT pad.*, pa.ProductAtributeName, IFNULL(vpo.ProductAtributeValueName,pad.AtributeValue) AS AtributeName FROM tb_product_atribute_detail pad
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

		$sql3 	= "SELECT * FROM tb_product_raw_material prm
					LEFT JOIN tb_product_main pm ON prm.RawMaterialID = pm.ProductID
					WHERE prm.ProductID = '".$id."'";
		$query3 = $this->db->query($sql3);
		if ($query3->num_rows() != 0 ) {
			foreach ($query3->result() as $row3) {
			  	$show['rawmaterial'][] = array(
		  			'ProductID' => $row3->ProductID, 
					'ProductName' => $row3->ProductName
				);
			};
		}

		$sql5 = "SELECT * FROM tb_product_file WHERE ProductID='".$id."'";
		$query5 = $this->db->query($sql5);
		foreach ($query5->result() as $row5) {
	  		$show['file'][] = array(
			  	'ProductID' => $row5->ProductID,
			  	'FileType' => $row5->FileType,
				'FileName' => $row5->FileName
			);
		};
		
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function get_product_detail_batch($id)
	{
		$sql = "SELECT * FROM tb_product_main pm 
					left join tb_product_category pc on pc.ProductCategoryID=pm.ProductCategoryID 
					left JOIN tb_product_brand pb ON pb.ProductBrandID=pm.ProductBrandID 
					left JOIN tb_product_atribute_set pas ON pas.ProductAtributeSetID=pm.ProductAtributSetID 
					left JOIN tb_product_status ps ON ps.ProductStatusID=pm.ProductStatusID 
					where pm.ProductID in (".$id.")
					ORDER BY pm.ProductID desc ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
	  			'ProductID' => $row->ProductID, 
				'ProductName' => $row->ProductName, 
				'ProductCode' => $row->ProductCode, 
				'ProductSupplier' => $row->ProductSupplier,
				'ProductDescription' => $row->ProductDescription, 
				'ProductStatusID' => $row->ProductStatusID, 
				'ProductStatusName' => $row->ProductStatusName, 
				'ProductCategoryID' => $row->ProductCategoryID, 
				'ProductBrandID' => $row->ProductBrandID, 
				'ProductAtributeSetID' => $row->ProductAtributeSetID, 
				'ProductPriceDefault' => $row->ProductPriceDefault, 
				'Stockable' => ($row->Stockable == "" ? "1" : $row->Stockable), 
				'MaxStock' => $row->MaxStock, 
				'MinStock' => $row->MinStock, 
				'forSale' => ($row->forSale == "" ? "1" : $row->forSale), 
				'isActive' => $row->isActive
			);
		};
		$show['main2'] = json_encode($show['main']);

		$sql2 = "SELECT * FROM tb_product_atribute_detail WHERE ProductID in (".$id.")";
		$query2 	= $this->db->query($sql2);
		foreach ($query2->result() as $row) {
		  	$show['atribute'][$row->ProductID][$row->ProductAtributeID] = $row->AtributeValue;
		};
		$show['atribute2'] = json_encode($show['atribute']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function get_product_detail_batch2($id)
	{
		$sql = "SELECT * FROM tb_product_main pm where pm.ProductID in (".$id.") ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
				'ProductID' => $row->ProductID,
				'ProductName' => $row->ProductName,
				'ProductCode' => $row->ProductCode,
				'ProductDescription' => $row->ProductDescription,
				'ProductSupplier' => $row->ProductSupplier,
				'ProductStatusID' => $row->ProductStatusID,
				'ProductCategoryID' => $row->ProductCategoryID,
				'ProductBrandID' => $row->ProductBrandID,
				'ProductAtributSetID' => $row->ProductAtributSetID,
				'ProductPricePurchase' => $row->ProductPricePurchase,
				'ProductPriceHPP' => $row->ProductPriceHPP,
				'ProductPricePercent' => $row->ProductPricePercent,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductMultiplier' => $row->ProductMultiplier,
				'ProductImage' => $row->ProductImage,
				'ProductDoc' => $row->ProductDoc,
				'Stockable' => ($row->Stockable == "" ? "0" : $row->Stockable), 
				'MaxStock' => $row->MaxStock,
				'MinStock' => $row->MinStock,
				'forSale' => ($row->forSale == "" ? "0" : $row->forSale), 
				'isActive' => ($row->isActive == "" ? "0" : $row->isActive)
			);
		};
		// echo json_encode($show['main']);
		// $show['main2'] = json_encode($show['main']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function get_product_detail_batch_shop($id)
	{
		$show   = array();
		$sql = "SELECT ProductID, ProductName FROM tb_product_main pm where pm.ProductID in (".$id.")
					ORDER BY pm.ProductID desc ";
		$query 	= $this->db->query($sql);
		$show['product'] = $query->result_array();

		$sql = "SELECT * FROM tb_shop_main";
		$query 	= $this->db->query($sql);
		$show['shop_main'] = $query->result_array();

		$sql = "SELECT * FROM tb_shop_product where ProductID in (".$id.") ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['shop_detail'][$row->ShopID][$row->ProductID] = $row->LinkText;
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function product_cu_batch_formula_act()
	{
		$this->db->trans_start();

		// print_r($this->input->post()); 
		$productid 		= $this->input->post('productid'); 
		$productname 	= $this->input->post('productname'); 
		$productcode 	= $this->input->post('productcode'); 
		$productsupplier 	= $this->input->post('productsupplier'); 
		$productdescription = $this->input->post('productdescription'); 
		$productbrand 		= $this->input->post('productbrand'); 
		// $productcategory 	= $this->input->post('productcategory'); 
		$statusquality 		= $this->input->post('statusquality'); 
		$productatributeset = $this->input->post('productatributeset'); 
		$atributeid = $this->input->post('atributeid'); 
		$atributetype 	= $this->input->post('atributetype'); 
		$atributevalue 	= $this->input->post('atributevalue'); 
		for ($i=0; $i < count($productid); $i++) {
			$data = array(
				'ProductName' => $productname[$i], 
				'ProductCode' => $productcode[$i],
				'ProductSupplier' => $productsupplier[$i],
				'ProductBrandID' => $productbrand,
				// 'ProductCategoryID' => $productcategory,
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			if (empty($_POST['opsi'])) {
				$data['ProductDescription'] = $productdescription[$i];
				$data['ProductStatusID'] = $statusquality[$i];
				$data['ProductAtributSetID'] = $productatributeset;
			}
			$this->db->where('ProductID', $productid[$i]);
			$this->db->update('tb_product_main', $data);
			$this->last_query .= "//".$this->db->last_query();
		}

		if (empty($_POST['opsi'])) {
			foreach ($productid as $key => $value) {
				$this->db->where('ProductID', $value);
				$this->db->delete('tb_product_atribute_detail');
				$this->last_query .= "//".$this->db->last_query();
				$ProductID 		= $value;
				$atributeid_cur	= $atributeid[$ProductID];
				$atributevalue_cur	= $atributevalue[$ProductID];

				for ($i=0; $i < count($atributeid_cur);$i++) {
					$data_atribute = array(
				        'ProductID' => $ProductID,
				        'ProductAtributeID' => $atributeid_cur[$i],
				        'AtributeValue' => $atributevalue_cur[$i]
					);
					$this->db->insert('tb_product_atribute_detail', $data_atribute);
					$this->last_query .= "//".$this->db->last_query();
				};
			}
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function product_cu_batch_edit_act()
	{
		$this->db->trans_start();

		$productid = $this->input->post('productid');
		$productcode = $this->input->post('productcode');
		$productdescription = $this->input->post('productdescription');
		$productsupplier = $this->input->post('productsupplier');
		$purchase = $this->input->post('purchase');
		$hpp = $this->input->post('hpp');
		$persen = $this->input->post('persen');
		$price = $this->input->post('price');
		$multiplier = $this->input->post('multiplier');
		$forsale = $this->input->post('forsale');
		$isactive = $this->input->post('isactive');
		$datamain = array();

		$sql5 = "SELECT tpm.ProductID, tpm.ProductPriceDefault, tpm.ProductPriceHPP, tpm.forSale, vpm.ProductAtributeValueName as ProductManager FROM tb_product_main tpm
				LEFT JOIN vw_product_manager vpm ON vpm.ProductID= tpm.ProductID
				WHERE tpm.ProductID in (". implode(',', array_map('intval', $productid)) .")";
		$query 	= $this->db->query($sql5);
		$listPrice 	= array();
		$listSale 	= array();
		$listManager   	= array();
		$listHPP   	= array();
		$listProduct= array();
		$diffHPP	= array();
		foreach ($query->result() as $row) {
			$listPrice[$row->ProductID] = $row->ProductPriceDefault;
			$listSale[$row->ProductID] = $row->forSale;
			$listManager[$row->ProductID] = $row->ProductManager;
			$listHPP[$row->ProductID] = $row->ProductPriceHPP;
		}

		for ($i=0; $i < count($productid); $i++) {
			$data = array(
				'ProductID' => $productid[$i],
				'ProductDescription' => $productdescription[$i],
				'ProductSupplier' => $productsupplier[$i],
				// 'ProductPriceHPP' => $hpp[$i],
				// 'ProductPricePercent' => $persen[$i],
				'ProductPriceDefault' => $price[$i],
				'ProductMultiplier' => $multiplier[$i],
				'forSale' => $forsale[$i],
				'isActive' => $isactive[$i],
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			if ($this->auth->cek5('manage_product_hpp')) {
				$data['ProductPriceHPP'] = $hpp[$i]; 
				$data['ProductPricePercent'] = $persen[$i]; 
				$this->product_price_history($productid[$i], $hpp[$i], $persen[$i], $price[$i], $multiplier[$i]);
			} else {
				$this->product_price_history($productid[$i], 0, 0, $price[$i], $multiplier[$i]);
			}
			if ($this->auth->cek5('manage_product_purchase')) {
				$data['ProductPricePurchase'] = $purchase[$i]; 
			}
			array_push($datamain, $data);

			if ($listPrice[$productid[$i]] != $price[$i]) {
				$ProductIDArr = array($productid[$i]);
				$this->info_update_price_list($ProductIDArr, 'Filter');
				$this->load->model('model_notification');
				$this->model_notification->insert_notif('notif_price', 'Change Price Default', 'ProductID', $ProductIDArr);
			}

			$ProductManager = 0;
			if ($listSale[$productid[$i]]!=$forsale[$i]) {
				if ($forsale[$i]==1) {
					$ProductIDArr = array($productid[$i]);
					$ProductManagerArr = array($listManager[$productid[$i]]);
					$this->load->model('model_notification');
					$this->model_notification->insert_notif('update_ready_for_sale', 'Ready For Sale', 'ProductID', $ProductIDArr , 'add', $ProductManagerArr);
				}
			}

			if ($listHPP[$productid[$i]] != $hpp[$i]) {
				$listProduct[$productid[$i]] = $productid[$i];
				$diffHPP[$productid[$i]] = $hpp[$i] - $listHPP[$productid[$i]];
			}
		}
		$this->db->update_batch('tb_product_main', $datamain, 'ProductID'); 
		$this->last_query .= "//".$this->db->last_query();
		// echo $this->last_query;
		// for auto journal
		if (!empty($listProduct)) {
			$this->load->model('model_acc');
			$this->model_acc->auto_journal_hpp_changes($listProduct, $diffHPP);
		}
		// -------------------------
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function product_cu_batch_shop_act()
	{
		$this->db->trans_start();
		$ProductID = $this->input->post('productid');
        $datetimenow = date("Y-m-d H:i:s");

		$sql = "SELECT ShopID FROM tb_shop_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result_array() as $row) {
			$ShopID = $this->input->post('shop_'.$row['ShopID']);
			$ShopIDStatus = $this->input->post('shop_'.$row['ShopID'].'_status');
			for ($i=0; $i < count($ProductID);$i++) {
				if ($ShopID[$i] == 0 && $ShopIDStatus[$i] == 'old') {
					$this->db->where('ShopID', $row['ShopID']);
					$this->db->where('ProductID', $ProductID[$i]);
					$this->db->delete('tb_shop_product');
					$this->last_query .= "//".$this->db->last_query();
				}
				if ($ShopID[$i] == 1 && $ShopIDStatus[$i] == 'new') {
					$data_product = array(
						'ShopID' => $row['ShopID'],
						'ProductID' => $ProductID[$i],
						'InputDate' => $datetimenow,
					);
					$this->db->insert('tb_shop_product', $data_product);
					$this->last_query .= "//".$this->db->last_query();
				}
			};
		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function cek_product_code()
	{
		$show = array();
		$productcode = $this->input->get_post('productcode');
		$sql 	= "SELECT ProductID, ProductCode FROM tb_product_main WHERE ProductCode='".$productcode."'";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  		'ProductID' => $row->ProductID,
				'ProductCode' => $row->ProductCode
			);
		};
	    echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function product_price_history($ProductID, $ProductPriceHPP, $ProductPricePercent, $ProductPriceDefault, $ProductMultiplier)
	{
		$this->db->trans_start();
		$datetimenow = date("Y-m-d H:i:s"); 

		$sql = "INSERT INTO tb_product_price_history ( PriceHistoryDate, PriceHistoryBy, 
				ProductID, ProductPriceHPP, ProductPricePercent, 
				ProductPriceDefault, ProductMultiplier)
				SELECT * FROM ( SELECT 
				'".$datetimenow."' AS PriceHistoryDate,
				'".$this->session->userdata('UserAccountID')."' AS PriceHistoryBy,
				'".$ProductID."' AS ProductID,
				'".$ProductPriceHPP."' AS ProductPriceHPP,
				'".$ProductPricePercent."' AS ProductPricePercent,
				'".$ProductPriceDefault."' AS ProductPriceDefault,
				'".$ProductMultiplier."' AS ProductMultiplier 
			) AS tmp
				WHERE NOT EXISTS (
				    SELECT ProductID FROM vw_price_history_last WHERE 
				ProductID = '".$ProductID."' and
				ProductPriceHPP = '".$ProductPriceHPP."' and
				ProductPricePercent = '".$ProductPricePercent."' and
				ProductPriceDefault = '".$ProductPriceDefault."' and
				ProductMultiplier = '".$ProductMultiplier."' 
				) LIMIT 1";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->trans_complete();
	}
	function get_product_price_history()
	{
		$id = $this->input->get('a'); 
		$sql 	= "SELECT pph.*, em.fullname FROM tb_product_price_history pph
					LEFT JOIN vw_user_account em ON pph.PriceHistoryBy=em.UserAccountID
					WHERE ProductID='".$id."' ORDER BY PriceHistoryID DESC ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			if (!$this->auth->cek5('manage_product_hpp')) {
				$row->ProductPriceHPP = 0;
				$row->ProductPricePercent = 0;
			} 

		  	$show[] = array(
				'PriceHistoryDate' => $row->PriceHistoryDate,
				'PriceHistoryBy' => $row->fullname,
				'ProductID' => $row->ProductID,
				'ProductPriceHPP' => $row->ProductPriceHPP,
				'ProductPricePercent' => $row->ProductPricePercent,
				'ProductPriceDefault' => $row->ProductPriceDefault,
				'ProductMultiplier' => $row->ProductMultiplier
			);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function CopyProductACZ()
	{
		$this->db->trans_start(); 

		$this->db->empty_table('acz_bo.tb_product_main');
		$query = $this->db->get('tb_product_main');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_main',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_atribute');
		$query = $this->db->get('tb_product_atribute');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_atribute',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_atribute_detail');
		$query = $this->db->get('tb_product_atribute_detail');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_atribute_detail',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_atribute_set');
		$query = $this->db->get('tb_product_atribute_set');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_atribute_set',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_atribute_set_detail');
		$query = $this->db->get('tb_product_atribute_set_detail');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_atribute_set_detail',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_atribute_value');
		$query = $this->db->get('tb_product_atribute_value');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_atribute_value',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_brand');
		$query = $this->db->get('tb_product_brand');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_brand',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_category');
		$query = $this->db->get('tb_product_category');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_category',$row);
		}

		$this->db->empty_table('acz_bo.tb_product_raw_material');
		$query = $this->db->get('tb_product_raw_material');
		foreach ($query->result() as $row) {
		      $this->db->insert('acz_bo.tb_product_raw_material',$row);
		}
		
		// sleep(5);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
 			echo json_encode('Copy Failed!');
		} else {
 			echo json_encode('Copy Success!');
		}
	}
	function import_stock_online($list)
	{
		$this->db->empty_table('tb_mo');
		foreach ($list as $key => $value) {
			$data[] = array(
		                'ID_MO' => $value['mo_id'],
		                'ProductName' => $value['mo_name'],
		                'ID_BO' => $value['bo_id'],
					);
		}

		$this->db->insert_batch('tb_mo', $data);
	}
	function export_stock_online()
	{
		$show   = array();
		$sql 	= "SELECT m1.*, coalesce(p1.stock,0) as stock, p2.ProductName as ProductName2  FROM tb_mo m1
					left join vw_product_stock p1 on m1.ID_BO = p1.ProductID
					left join tb_product_main p2 on m1.ID_BO = p2.ProductID";
		$query 	= $this->db->query($sql); 
		foreach ($query->result_array() as $key => $value) {
			$result[] = array(
				'mo_id' => $value['ID_MO'],
				'mo_name' => $value['ProductName'],
				'bo_id' => $value['ID_BO'],
				'bo_name' => $value['ProductName2'],
				'bo_stock' => $value['stock'],
			);
		}
		// echo json_encode($result);
	    return $result;
	}
	// ------------------------------------------------------------------------
	function filter_auto_insert_product_promo($ProductID, $ProductBrandID, $ProductCategoryID)
	{
		$sql = "SELECT * FROM vw_auto_price_list_brand_category where ProductBrandID=".$ProductBrandID." and ProductCategoryID=".$ProductCategoryID;
		$show   = array();
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$data_p_detail = array(
				'PricelistID' => $row->PricelistID,
				'ProductID' => $ProductID,
				'Promo' => $row->PromoPercent,
				'PT1Discount' => $row->PT1Percent,
				'PT2Discount' => $row->PT2Percent,
			);
			$this->db->insert('tb_price_list_detail', $data_p_detail);
			$this->last_query .= "//".$this->db->last_query();
		};
		$this->delete_duplicate_row_price_list();

		$sql = "SELECT * FROM vw_auto_promo_vol_brand_category where ProductBrandID=".$ProductBrandID." and ProductCategoryID=".$ProductCategoryID;
		$show   = array();
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$data_p_detail = array(
				'PromoVolID' => $row->PromoVolID,
				'ProductID' => $ProductID,
				'ProductQty' => $row->ProductQty,
				'Promo' => $row->PromoPercent,
				'PT1Discount' => $row->PT1Percent,
				'PT2Discount' => $row->PT2Percent,
			);
			$this->db->insert('tb_price_promo_vol_detail', $data_p_detail);
			$this->last_query .= "//".$this->db->last_query();
		};
		$this->delete_duplicate_row_promo_volume();

		$ProductIDArr = array($ProductID);
		$this->product_promo_history($ProductIDArr);
	}
	function price_recommendation_add()
	{
		$ProductID = $this->input->get_post('ProductID');
		$sql 	= "SELECT pm.ProductID, pm.ProductName, pm.ProductPriceDefault, tvp.cbd, tpc.Link1, tpc.Link2, tpc.Note, tpc.Screenshot
					FROM vw_product_list_popup2_active3 pm
					LEFT JOIN (
						SELECT vpp.ProductID, min(vpp.PricePT2Discount) as cbd
						FROM vw_product_promo_list_active_with_price_no_vol vpp
						GROUP BY vpp.ProductID
					) tvp ON tvp.ProductID=pm.ProductID
					LEFT JOIN (
						SELECT ProductID, CheckDate, Link1, Link2, Note, Screenshot
						FROM vw_price_recommendation_last
						WHERE ProductID=".$ProductID."
					) tpc ON tpc.ProductID=pm.ProductID
					WHERE pm.ProductID=".$ProductID;
			// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];
		return $show;
	}
	function price_recommendation_add_act()
	{
		$this->db->trans_start();

		$ProductID = $this->input->get_post('productid');
		$CurrentPrice = $this->input->get_post('currentprice');
		$PriceRec = $this->input->get_post('pricerec');
		$Note = $this->input->get_post('note');
		$LinkTokped = $this->input->get_post('link1');
		$LinkShopee = $this->input->get_post('link2');
		$Screenshot = $this->input->get_post('Screen');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
			'InputDate' => $datetime,
			'ProductID' => $ProductID,
			'CurrentPrice' => $CurrentPrice,
			'PriceRec' => $PriceRec,
			'Note' => $Note,
			'Screenshot' => $Screenshot,
			'isApprove' => '0',
			'InputBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_price_recommendation', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "SELECT max(RecID) as RecID from tb_price_recommendation ";
		$getRecID 	= $this->db->query($sql);
		$row 		= $getRecID->row();
		$RecID 		= $row->RecID;

		// get actor 3 approval
		$sql 		= "SELECT Actor3 from tb_approval_actor where ApprovalCode='price_recommendation' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		if ($Actor3 != 0) {
			$data_approval = array(
				'RecID' => $RecID,
				'isComplete' => "0",
				'Status' => "OnProgress",
			);
			$this->db->insert('tb_approval_price_recommendation', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
				'RecID' => $RecID,
				'isComplete' => "1",
				'Status' => "Approved",
			);
			$this->db->insert('tb_approval_price_recommendation', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function price_recommendation_edit()
	{
		$RecID = $this->input->get_post('RecID');
		$sql 	= "SELECT tpr.*, tpm.ProductName, vua.fullname, vpr.Link1, vpr.Link2
					FROM tb_price_recommendation tpr
					LEFT JOIN tb_product_main tpm ON tpm.ProductID=tpr.ProductID
					LEFT JOIN vw_price_recommendation_last vpr ON vpr.ProductID=tpr.ProductID
					LEFT JOIN vw_user_account vua ON vua.UserAccountID=tpr.InputBy
					WHERE tpr.RecID=".$RecID;
					// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];
	    return $show;
	}
	function price_recommendation_edit_act()
	{
		$this->db->trans_start();
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');

		// get actor 3 approval
		$sql 		= "SELECT Actor3 from tb_approval_actor where ApprovalCode='price_recommendation' ";
		$getActor3 	= $this->db->query($sql);
		$row 		= $getActor3->row();
		$Actor3 	= $row->Actor3;

		$RecID = $this->input->get_post('recid');

		$this->db->set('isApprove', 2);
		$this->db->where('RecID', $RecID);
		$this->db->update('tb_price_recommendation');
		$this->last_query .= "//".$this->db->last_query();

		$data_rejected = array(
			'Actor1' => $datetime,
			'Actor1ID' => $Actor3,
			'Actor2' => $datetime,
			'Actor2ID' => $Actor3,
			'Actor3' => $datetime,
			'Actor3ID' => $Actor3,
			'isComplete' => '2',
			'Status' => 'Rejected Edit',
		);
		$this->db->where('RecID', $RecID);
		$this->db->update('tb_approval_price_recommendation', $data_rejected);
		$this->last_query .= "//".$this->db->last_query();

		$ProductID = $this->input->get_post('productid');
		$CurrentPrice = $this->input->get_post('currentprice');
		$PriceRec = $this->input->get_post('pricerec');
		$PriceRecEdit = $this->input->get_post('pricerecedit');
		$Note = $this->input->get_post('note');
		$CompetitorLink = $this->input->get_post('link');
		$Screenshot = $this->input->get_post('label');

		$data = array(
			'InputDate' => $datetime,
			'ProductID' => $ProductID,
			'CurrentPrice' => $CurrentPrice,
			'PriceRec' => $PriceRecEdit,
			'Note' => $Note,
			'CompetitorLink' => $CompetitorLink,
			'Screenshot' => $Screenshot,
			'isApprove' => '0',
			'InputBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_price_recommendation', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "SELECT max(RecID) as RecID from tb_price_recommendation ";
		$getRecID 	= $this->db->query($sql);
		$row 		= $getRecID->row();
		$RecID2		= $row->RecID;

		if ($Actor3 != 0) {
			$data_approval = array(
				'RecID' => $RecID2,
				'isComplete' => "0",
				'Status' => "OnProgress",
			);
			$this->db->insert('tb_approval_price_recommendation', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		} else {
			$data_approval = array(
				'RecID' => $RecID2,
				'isComplete' => "1",
				'Status' => "Approved",
			);
			$this->db->insert('tb_approval_price_recommendation', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function price_check_add()
	{
		$dir=$this->session->userdata('UserAccountID');
		if (is_dir('assets/Price_Check_tmp/'.$dir)==0){
				$dir=mkdir('assets/Price_Check_tmp/'.$dir, 0777, true);
			}
		$ProductID = $this->input->get_post('ProductID');
		$sql 	= "SELECT pm.ProductID, pm.ProductName, tpa.AtributeValue, tpc.CheckDate
					FROM tb_product_main pm
					LEFT JOIN tb_product_atribute_detail tpa ON tpa.ProductID=pm.ProductID
					LEFT JOIN tb_price_check tpc ON tpc.ProductID=pm.ProductID
					WHERE tpa.ProductAtributeID=6 AND pm.ProductID=".$ProductID;
					// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0];
		$file = (isset($_POST["file"])) ? $_POST["file"] : '';
		if ($file) {
			$data = base64_decode(str_replace('data:image/png;base64,', '', $file));
			// $name = $ProductID."-".time() . '.png';
			$name = $ProductID."-".time() . '.jpg';
			file_put_contents($name, $data);
			// die;
			$source_file = $name;
			$this->ss_filename=$name;

			$destination_path = 'assets/Price_Check_tmp/'.$dir."/";
			if (copy($source_file, $destination_path . pathinfo($source_file, PATHINFO_BASENAME))){
				unlink($source_file);
			}
			echo base_url().$destination_path.$this->ss_filename;
			die;
		}
		return $show;
	}
	function price_check_add_act($val)
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$ProductID = $this->input->post('ProductID');
		$LinkTokped = $this->input->post('Link1');
		$LinkShopee = $this->input->post('Link2');
		$Note = $this->input->post('Note');
		$Screenshot = $this->input->post('Screen');

		// $noext=explode(".",$Screenshot);
		// $noext=$noext[0];

		$source_file='assets/Price_Check_tmp/'.$UserAccountID."/".$Screenshot;
		$destination_path = 'assets/Price_Check/';
		// $image = imagecreatefrompng($source_file);
		// imagejpeg($image, $destination_path.$noext.'.JPG', 70);
		if (copy($source_file, $destination_path . pathinfo($source_file, PATHINFO_BASENAME))){
			$files    =glob('assets/Price_Check_tmp/'.$UserAccountID."/*");
			foreach ($files as $file) {
			    if (is_file($file))
			    unlink($file); // hapus semua file
			}
			// unlink($destination_path.$noext.".PNG");
		}
		// $Screenshot=$noext.".JPG";
		$datetime = date('Y-m-d H:i:s');

		if ($val == "approve") {
			$data = array(
				'CheckDate' => $datetime,
				'ProductID' => $ProductID,
				'InputBy' => $UserAccountID,
				'Link1' => $LinkTokped,
				'Link2' => $LinkShopee,
				'Note' => $Note,
				'Screenshot' => $Screenshot,
			);
			$this->db->insert('tb_price_check', $data);
			$this->last_query .= "//".$this->db->last_query();
		} elseif ($val == "edit") {
			$data = array(
				'CheckDate' => $datetime,
				'ProductID' => $ProductID,
				'InputBy' => $UserAccountID,
				'Link1' => $LinkTokped,
				'Link2' => $LinkShopee,
				'Note' => $Note,
				'Screenshot' => $Screenshot,
			);
			$this->db->insert('tb_price_check', $data);
			$this->last_query .= "//".$this->db->last_query();
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}


// atribute==================================================================
	function productatribute_list()
	{
		$sql 	= "SELECT * FROM tb_product_atribute";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductAtributeID' => $row->ProductAtributeID,
		  			'ProductAtributeName' => $row->ProductAtributeName,
		  			'ProductAtributeType' => $row->ProductAtributeType
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function productatribute_add()
	{
		$this->db->trans_start();

		$name = $this->input->post('name'); 
		$type = $this->input->post('type');
		$namevalue = $this->input->post('namevalue');
		$codevalue = $this->input->post('codevalue');

		$data = array(
	        'ProductAtributeName' 	=> $name,
			'ProductAtributeType'	=> $type
		);
		$this->db->insert('tb_product_atribute', $data);
		$this->last_query .= "//".$this->db->last_query();
		
		if ($type == "list") {
			$sql 			= "select max(ProductAtributeID) as AtributeID from tb_product_atribute ";
			$getAtributeID 	= $this->db->query($sql);
			$row 			= $getAtributeID->row();
			$AtributeID 	= $row->AtributeID;
			for ($i=0; $i < count($namevalue);$i++) { 
	   			$data_atribute = array(
			        'ProductAtributeID' => $AtributeID,
			        'ProductAtributeValueName' => $namevalue[$i],
			        'ProductAtributeValueCode' => $codevalue[$i]
				);
				$this->db->insert('tb_product_atribute_value', $data_atribute);
				$this->last_query .= "//".$this->db->last_query();
	   		};
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function productatribute_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id');
		$namevalue = $this->input->post('namevalue');
		$codevalue = $this->input->post('codevalue');
		$namevalueOld = $this->input->post('namevalueOld');
		$codevalueOld = $this->input->post('codevalueOld');

		$this->db->where('ProductAtributeID', $id);
		$this->db->delete('tb_product_atribute_value');
		$this->last_query .= "//".$this->db->last_query();
		for ($i=0; $i < count($namevalue);$i++) { 
   			$data_atribute = array(
		        'ProductAtributeID' => $id,
		        'ProductAtributeValueName' => $namevalue[$i],
		        'ProductAtributeValueCode' => $codevalue[$i]
			);
			$this->db->insert('tb_product_atribute_value', $data_atribute);
			$this->last_query .= "//".$this->db->last_query();

			if ($codevalueOld[$i] != 'new_item') {
				if ($codevalue[$i] != $codevalueOld[$i]) {
					$this->db->set('AtributeValue', $codevalue[$i]);
					$this->db->where('AtributeValue', $codevalueOld[$i]);
					$this->db->where('ProductAtributeID', $id);
					$this->db->update('tb_product_atribute_detail');
					$this->last_query .= "//".$this->db->last_query();
				}
			}
   		};
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function cek_duplicate_atribute_code()
	{
		$show = array();
		$sql 	= "SELECT pa.ProductAtributeName, pav.ProductAtributeValueName, pav.ProductAtributeValueCode
					FROM tb_product_atribute_value pav LEFT JOIN tb_product_atribute pa ON (pav.ProductAtributeID=pa.ProductAtributeID)
					WHERE ProductAtributeValueCode in (
					SELECT ProductAtributeValueCode	FROM tb_product_atribute_value pav
					WHERE ProductAtributeValueCode <> '' GROUP BY ProductAtributeValueCode
					HAVING COUNT(ProductAtributeID)>1 )";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  		'ProductAtributeName' => $row->ProductAtributeName,
				'ProductAtributeValueName' => $row->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row->ProductAtributeValueCode
			);
		};
	    echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function cek_used_atribute_code()
	{
		$show = array();
		$code 	= $this->input->get_post('code');
		$sql 	= "SELECT pa.ProductAtributeName, pav.ProductAtributeValueName, pav.ProductAtributeValueCode
					FROM tb_product_atribute_value pav
					LEFT JOIN tb_product_atribute pa ON (pav.ProductAtributeID=pa.ProductAtributeID)
					WHERE ProductAtributeValueCode ='".$code."'";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  		'ProductAtributeName' => $row->ProductAtributeName,
				'ProductAtributeValueName' => $row->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row->ProductAtributeValueCode
			);
		};
	    echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}

// atributeset===============================================================
	function productatributeset_list()
	{
		$sql = "SELECT * FROM ( ";
		$sql .= "SELECT t1.*, GROUP_CONCAT(t2.ProductAtributeID) as detailid ";
		$sql .= "FROM tb_product_atribute_set t1 ";
		$sql .= "LEFT JOIN tb_product_atribute_set_detail t2 ON t1.ProductAtributeSetID = t2.ProductAtributeSetID ";
		$sql .= "GROUP BY t1.ProductAtributeSetID ) as A ";
		$sql .= "JOIN ( ";
		$sql .= "SELECT t1.ProductAtributeSetID, GROUP_CONCAT(t2.ProductAtributeName) as detailname ";
		$sql .= "FROM tb_product_atribute_set_detail t1 ";
		$sql .= "LEFT JOIN tb_product_atribute t2 ON	t1.ProductAtributeID = t2.ProductAtributeID ";
		$sql .= "GROUP BY t1.ProductAtributeSetID ) as B ";
		$sql .= "ON A.ProductAtributeSetID = B.ProductAtributeSetID ";

		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductAtributeSetID' => $row->ProductAtributeSetID,
		  			'ProductAtributeSetName' => $row->ProductAtributeSetName,
		  			'detailname' => $row->detailname
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function productatributeset_add()
	{
		$this->db->trans_start();

		$name = $this->input->post('name'); 
		$atribute = $this->input->post('atribute');

		$data = array(
	        'ProductAtributeSetName' 	=> $name
		);
		$this->db->insert('tb_product_atribute_set', $data);
		$this->last_query .= "//".$this->db->last_query();
		
		$sql 			= "select max(ProductAtributeSetID) as AtributeSetID from tb_product_atribute_set ";
		$getAtributeSetID 	= $this->db->query($sql);
		$row 			= $getAtributeSetID->row();
		$AtributeSetID 	= $row->AtributeSetID;
		for ($i=0; $i < count($atribute);$i++) { 
   			$data_atribute = array(
		        'ProductAtributeSetID' => $AtributeSetID,
		        'ProductAtributeID' => $atribute[$i]
			);
			$this->db->insert('tb_product_atribute_set_detail', $data_atribute);
			$this->last_query .= "//".$this->db->last_query();
   		};
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function productatributeset_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id');
		$atribute2 = $this->input->post('atribute2');

		$this->db->where('ProductAtributeSetID', $id);
		$this->db->delete('tb_product_atribute_set_detail');
		$this->last_query .= "//".$this->db->last_query();

		for ($i=0; $i < count($atribute2);$i++) { 
			$data_atribute = array(
		        'ProductAtributeSetID' => $id,
		        'ProductAtributeID' => $atribute2[$i]
			);
			$this->db->insert('tb_product_atribute_set_detail', $data_atribute);
			$this->last_query .= "//".$this->db->last_query();
   		};
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

// category==================================================================
	function productcategory_list($parent = 0, $spacing = '', $category_tree_array = array())
	{
		$sql 	= "SELECT pc1.*, pc2.ProductCategoryName as parentname, pa.ProductAtributeSetName FROM tb_product_category pc1 
				LEFT JOIN tb_product_category pc2 on pc1.ProductCategoryParent=pc2.ProductCategoryID 
				LEFT JOIN tb_product_atribute_set pa ON pc1.ProductAtributeSetID = pa.ProductAtributeSetID 
				where pc1.ProductCategoryParent = ".$parent." ORDER by pc1.ProductCategoryName";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$category_tree_array[] = array(
					'ProductCategoryID' => $row->ProductCategoryID,
		  			'ProductCategoryName' => $spacing.$row->ProductCategoryName,
		  			'ProductCategoryCode' => $row->ProductCategoryCode,
		  			'ProductCategoryParent' => $row->parentname,
		  			'ProductNameFormula' => $row->ProductNameFormula,
		  			'ProductCodeFormula' => $row->ProductCodeFormula,
		  			'ProductAtributeSetName' => $row->ProductAtributeSetName,
		  			'ProductCategoryDescription' => $row->ProductCategoryDescription
				);
		      	$category_tree_array = $this->productcategory_list($row->ProductCategoryID, $spacing.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $category_tree_array);
			};
		}
		return $category_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function productcategory_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$parent = $this->input->post('parent'); 
		$code 	= $this->input->post('code'); 
		$description = $this->input->post('description'); 
		$productatributeset 	= $this->input->post('productatributeset'); 


		$data = array(
	        'ProductCategoryName' 	=> $name,
			'ProductCategoryParent' => $parent,
			'ProductCategoryCode' 	=> $code,
			'ProductCategoryDescription' 	=> $description,
			'ProductAtributeSetID' 	=> $productatributeset
		);
		$this->db->insert('tb_product_category', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function productcategory_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$name 	= $this->input->post('name2'); 
		$parent = $this->input->post('parent2'); 
		$code 	= $this->input->post('code2'); 
		$description = $this->input->post('description2'); 
		$productatributeset2	= $this->input->post('productatributeset2'); 
		$data = array(
	        'ProductCategoryName' 	=> $name,
			'ProductCategoryParent' => $parent,
			'ProductCategoryCode' 	=> $code,
			'ProductAtributeSetID' 	=> $productatributeset2,
			'ProductCategoryDescription' 	=> $description
		);
		$this->db->where('ProductCategoryID', $id);
		$this->db->update('tb_product_category', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function get_category_formula($id)
	{
		$sql 	= "SELECT * FROM tb_product_category where ProductCategoryID = ".$id."";
		$query 	= $this->db->query($sql);
		$show   = array();
		$ProductAtributeSetID = "";
		foreach ($query->result() as $row) {
		  	$show['main'] = array(
		  			'ProductCategoryID' => $row->ProductCategoryID,
		  			'ProductCategoryName' => $row->ProductCategoryName,
		  			'ProductNameFormula' => $row->ProductNameFormula,
		  			'ProductCodeFormula' => $row->ProductCodeFormula,
		  			'ProductAtributeSetID' => $row->ProductAtributeSetID
				);
			$ProductAtributeSetID = $row->ProductAtributeSetID;
		};

		$category = array();
		$category2 = $this->fill_category_code($id,$category);
		$no = 0;
		foreach ($category2 as $row => $list) {
			$no++;
			$show['contentformula'][] = "category".$no;
		}

		$brand = array();
		$brand2 = $this->fill_parent_brand(0, "", "1", $brand);
		$no = 0;
		$lengthbrand = 0;
		foreach ($brand2 as $row => $list) {
			$lengthbrand = ($lengthbrand <= strlen($list['count']) ? strlen($list['count']) : $lengthbrand);
		}
		for ($i=0; $i < $lengthbrand; $i++) { 
			$no++;
			$show['contentformula'][] = "brand".$no;
		}
		$show['contentformula'][] = "description"; // add option KW
		$show['contentformula'][] = "statusquality"; // add option KW

		$sql2 	= "SELECT pasd.*, pa.* FROM tb_product_atribute_set_detail pasd ";
		$sql2 	.= "LEFT JOIN tb_product_atribute pa on pasd.ProductAtributeID = pa.ProductAtributeID ";
		$sql2 	.= "WHERE pasd.ProductAtributeSetID = '".$ProductAtributeSetID."'";
		$query2	= $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
		  	$show['contentformula'][] = $row2->ProductAtributeName;
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function productnamingformula_act()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$codeformula = $this->input->post('codeformula'); 
		$nameformula = $this->input->post('nameformula'); 
		$data = array(
	        'ProductCodeFormula' => $codeformula,
			'ProductNameFormula' => $nameformula
		);
		$this->db->where('ProductCategoryID', $id);
		$this->db->update('tb_product_category', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}

// pricecategory=============================================================
	function productpricecategory_list()
	{
		$sql	= "SELECT * from tb_price_category_main";
		$show   = array();
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PricecategoryID' => $row->PricecategoryID,
					'PricecategoryName' => $row->PricecategoryName,
					'PromoDefault' => $row->PromoDefault,
					'PricecategoryNote' => $row->PricecategoryNote
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function productpricecategory_add()
	{
		$this->db->trans_start();

		$pcname = $this->input->post('pcname'); 
		$promo = $this->input->post('promo'); 
		$pcnote = $this->input->post('pcnote'); 

		$data_pc = array(
	        'PricecategoryName' => $pcname,
	        'PromoDefault' => $promo,
			'PricecategoryNote' => $pcnote
		);
		$this->db->insert('tb_price_category_main', $data_pc);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function productpricecategory_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id');
		$pcnote = $this->input->post('pcnote2'); 
		$promo = $this->input->post('promo2'); 
		$pcname = $this->input->post('pcname2'); 

		$data_pc = array(
			'PricecategoryName' => $pcname,
	        'PromoDefault' => $promo,
			'PricecategoryNote' => $pcnote
		);
		$this->db->where('PricecategoryID', $id);
		$this->db->update('tb_price_category_main', $data_pc);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function price_category_detail()
	{
		$show = array();
        $id  = $this->input->get_post('a');
        // query get data utama
		$sql = "SELECT * FROM tb_price_category_detail pcd 
				LEFT JOIN tb_price_list_main plm ON pcd.PricelistID = plm.PricelistID
				WHERE pcd.PricecategoryID = '".$id."'";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PricelistID' => $row->PricelistID,
		  			'PricelistName' => $row->PricelistName,
		  			'PricelistNote' => $row->PricelistNote,
					'DateStart' => $row->DateStart,
					'DateEnd' => $row->DateEnd,
					'type' => "price"
				);
		};

		$sql = "SELECT * FROM tb_price_promo_vol_main  
				WHERE PricecategoryID = '".$id."'";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PricelistID' => $row->PromoVolID,
		  			'PricelistName' => $row->PromoVolName,
		  			'PricelistNote' => $row->PromoVolNote,
					'DateStart' => $row->DateStart,
					'DateEnd' => $row->DateEnd,
					'type' => "promovol"
				);
		};
		
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

// price_list================================================================
	function price_list()
	{
		$sql	= "SELECT plm.*, pcd.*, pcm.*, COUNT(pld.PricelistID) as numberP, COALESCE(vap.isComplete,0) as isComplete FROM tb_price_list_main plm 
					LEFT JOIN tb_price_category_detail pcd ON (plm.PricelistID=pcd.PricelistID) 
					LEFT JOIN tb_price_category_main pcm ON (pcm.PricecategoryID=pcd.PricecategoryID)
					LEFT JOIN tb_price_list_detail pld ON (plm.PricelistID=pld.PricelistID)
					LEFT JOIN vw_approval_price_list_max_full vap ON vap.PricelistID =plm.PricelistID
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
					'isComplete' => $row->isComplete,
					'numberP' => $row->numberP,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function price_list_cu($val)
	{
		$show = array();
		$show['pricelist'] = array();
		$show['pricelistd'] = array();
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
						'ProductPrice' => $row2->ProductPriceDefault,
						'status' => "old",
					);
				};

				$sql2 = "select * from tb_price_list_detail_approval pld 
						left join tb_price_list_main plm on(plm.PricelistID = pld.PricelistID) 
						left join tb_product_main p on(p.ProductID = pld.ProductID) 
						where pld.PricelistID = '".$val."' and isApprove is null order by pld.ProductID";
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
							'ProductPrice' => $row2->ProductPriceDefault,
							'status' => "new",
						);
					};
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
	function price_list_cu_act()
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
						// $data1M['PricelistName'] === $pl_main['PricelistName'] && 
				    	$data1M['DateStart'] === $pl_main['DateStart'] && 
				    	$data1M['DateEnd'] === $pl_main['DateEnd'] && 
				    	$data1M['isActive'] === $pl_main['isActive'] 
				    	// $data1M['PricelistNote'] === $pl_main['PricelistNote']
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
				if (!empty($data1FP)) {
					if 	(!(
					    	$data1FP['PromoPercent'] === $p_f_p['PromoPercent']  && 
					    	$data1FP['PT1Percent'] === $p_f_p['PT1Percent']  && 
					    	$data1FP['PT2Percent'] === $p_f_p['PT2Percent'] 
						)) {
						$errorCount += 1;
					}
				}
			// -----------------------------------------------------------

			// compare BrandCategory ------------------------------------
				// from post
				$p_b_c = array();
				if (isset($Category)) {
					for ($i=0; $i < count($Category);$i++) { 
						$p_b_c[] = array(
							'ProductCategoryID' => $Category[$i],
							'ProductBrandID' => $Brand[$i]
						);
					};
				}

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

			$sql 			= "select PricelistID, PricelistName from tb_price_list_main order by PricelistID desc limit 1 ";
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
				$data_approval = array(
			        'PricelistID' => $PricelistID,
			        'isComplete' => "0",
			        'Status' => "OnProgress",
			        // 'Title' => "Add Product to '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			        'Title' => "Edit '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			        'Note' => $noteApproval,
				); 
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

			$this->db->set('isComplete', 1);
			$this->db->set('Status', "Rejected");
			$this->db->where('PricelistID', $PricelistID);
			$this->db->where('isComplete', 0);
			$this->db->update('tb_approval_price_list');
			$this->last_query .= "//".$this->db->last_query();
				
			if ($errorCount > 0) {
 
				$data_approval = array(
			        'PricelistID' => $PricelistID,
			        'isComplete' => "0",
			        'Status' => "OnProgress",
			        'Title' => "Edit '".$pname."' by ".$this->session->userdata('UserName').", tgl ".$datetimenow,
			        'Note' => $noteApproval,
				); 
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

				if (isset($Category)) {
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
				}

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
			
			// $this->db->where_not_in('ProductID', $product);
			$this->db->where('PricelistID', $PricelistID);
			$this->db->delete('tb_price_list_detail');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('PricelistID', $PricelistID);
			$this->db->where('isApprove IS NULL');
			$this->db->delete('tb_price_list_detail_approval');
			$this->last_query .= "//".$this->db->last_query();

			for ($i=0; $i < count($product);$i++) { 

				if ($status[$i] == "old") {
					$data_p_detail = array(
						'PricelistID' => $PricelistID,
						'ProductID' => $product[$i],
						'Promo' => $promo[$i],
						'PT1Discount' => $top[$i],
						'PT2Discount' => $cbd[$i]
					);
					$this->db->insert('tb_price_list_detail', $data_p_detail);
					$this->last_query .= "//".$this->db->last_query();
				} else {
					// $this->db->where('ProductID', $product[$i]);
					// $this->db->where('PricelistID', $PricelistID);
					// $this->db->delete('tb_price_list_detail');
					// $this->last_query .= "//".$this->db->last_query();

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
 
		}
			 
		if ($Actor3 == 0 && isset($ApprovalID)) {
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
		// echo $this->last_query;
		$this->product_promo_history($product);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
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
		$ProductIDArr = array(); 

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

		$this->db->where('Promo', $listPercent['PromoPercent']);
		$this->db->where('PT1Discount', $listPercent['PT1Percent']);
		$this->db->where('PT2Discount', $listPercent['PT2Percent']);
		$this->db->where('PricelistID', $pricelistid);
		$this->db->delete('tb_price_list_detail');
		$this->last_query .= "//".$this->db->last_query();
		$deleted_row = $this->db->affected_rows();

		$sql = "SELECT * FROM tb_price_list_brand_category where PricelistID=".$pricelistid;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
        	$category_full_child = $this->get_full_category_child_id($row->ProductCategoryID);
        	$brand_full_child = $this->get_full_brand_child_id($row->ProductBrandID);

			$where_brand_category .= "( ProductCategoryID IN (". implode(',', array_map('intval', $category_full_child)) .") and ProductBrandID IN (". implode(',', array_map('intval', $brand_full_child)) .") ) or ";
		}; 
		$where_brand_category = ($where_brand_category != '') ? substr($where_brand_category, 0, -3): '' ;

		$sql = "SELECT ProductID, ProductCategoryID, ProductBrandID
				FROM tb_product_main 
				WHERE isActive=1 AND ProductID not in (
					SELECT ProductID FROM tb_price_list_detail WHERE PricelistID=".$pricelistid."
				) ";
		if ($where_brand_category != '') {
			$sql .= "and ".$where_brand_category;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
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

	   			$ProductIDArr[] = $row->ProductID; 
			}; 
		}
		if (!empty($ProductIDArr)) {
			$this->info_update_price_list($ProductIDArr, 'Filter');
			$this->product_promo_history($ProductIDArr);
			$this->load->model('model_notification');
			$this->model_notification->insert_notif('notif_price', 'Change Price Default', 'ProductID', $ProductIDArr);
		}

		$this->delete_duplicate_row_price_list($pricelistid);
 
		$massage .= $deleted_row." Product telah dihapus,\n";
		$massage .= $inserted_row." Product ditambahkan ke PriceList";
		echo json_encode($massage);

		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function clear_price_list()
	{
		$this->db->trans_start();
		$pricelistid	= $this->input->get('pricelistid');
		$deleted_row = 0;
		$massage = "";

		$this->db->where('PricelistID', $pricelistid);
		$this->db->delete('tb_price_list_detail');
		$this->last_query .= "//".$this->db->last_query();
		$deleted_row += $this->db->affected_rows();  

		$massage .= $deleted_row." Product telah dihapus";
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		echo json_encode($massage);
	}
	function delete_duplicate_row_price_list($PricelistID=0)
	{
		$this->db->trans_start(); 
		$sql = "DELETE FROM tb_price_list_detail
				WHERE OrderID NOT IN (
					SELECT OrderID
					FROM (
						SELECT MIN(OrderID) AS OrderID
						FROM tb_price_list_detail 
						GROUP BY PricelistID, ProductID, Promo, PT1Discount, PT2Discount
					) t1
				)";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function delete_duplicate_row_promo_volume($PromoVolID=0)
	{
		$this->db->trans_start(); 
		$sql = "DELETE FROM tb_price_promo_vol_detail
				WHERE OrderID NOT IN (
					SELECT OrderID
					FROM (
							SELECT MIN(OrderID) AS OrderID
							FROM tb_price_promo_vol_detail 
							GROUP BY PromoVolID, ProductID, ProductQty, Promo, PT1Discount, PT2Discount
					) t1
				)";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function info_update_price_list($ProductID, $noteFrom)
	{
		$this->db->trans_start();
		$sql = "SELECT ProductID, max(DATE(InputDate)) as InputDate 
				FROM vw_product_promo_history_last 
				where ProductID in (" . implode(',', array_map('intval', $ProductID)) . ")
				group by ProductID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$result = $query->result();
		if (!empty($result)) {
			foreach ($query->result() as $row) {
				if ($noteFrom == 'Filter') {

					if ($row->InputDate == date("Y-m-d")) {
						$data = array(
							'Actor3' => '668',
							'Date' => date("Y-m-d"),
							'ProductID' => $row->ProductID,
							'isComplete' => 0,
							'Note' => 'Promo',
							'Status' => 'Pending',
							'From' => $noteFrom,
						);
						$this->db->insert('tb_update_price_list', $data);
						$this->last_query .= "//".$this->db->last_query();

						$sql 		= "SELECT max(ActivityID) as ActivityID FROM tb_update_price_list ";
						$getActivityID = $this->db->query($sql);
						$row 		= $getActivityID->row();
						$ActivityID 	= $row->ActivityID;
						$data_approval = array(
							'ActivityID' => $ActivityID,
							'isComplete' => 0,
							'Status' => 'OnProgress',
						);
						$this->db->insert('tb_notification_update_price_list', $data_approval);
						$this->last_query .= "//".$this->db->last_query();
					}
				} else {
					$data = array(
						'Actor3' => '668',
						'Date' => date("Y-m-d"),
						'ProductID' => $row->ProductID,
						'isComplete' => 0,
						'Note' => 'Selain Filter',
						'Status' => 'Pending',
						'From' => $noteFrom,
					);
					$this->db->insert('tb_update_price_list', $data);
					$this->last_query .= "//".$this->db->last_query();

					$sql 		= "SELECT max(ActivityID) as ActivityID FROM tb_update_price_list ";
					$getActivityID = $this->db->query($sql);
					$row 		= $getActivityID->row();
					$ActivityID 	= $row->ActivityID;
					$data_approval = array(
						'ActivityID' => $ActivityID,
						'isComplete' => 0,
						'Status' => 'OnProgress',
					);
					$this->db->insert('tb_notification_update_price_list', $data_approval);
					$this->last_query .= "//".$this->db->last_query();
				}
			}
		} else {
			$data = array(
				'Actor3' => '668',
				'Date' => date("Y-m-d"),
				'ProductID' => $ProductID[0],
				'isComplete' => 0,
				'Note' => 'Tanpa Promo',
				'Status' => 'Pending',
				'From' => $noteFrom,
			);
			$this->db->insert('tb_update_price_list', $data);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "SELECT max(ActivityID) as ActivityID FROM tb_update_price_list ";
			$getActivityID = $this->db->query($sql);
			$row 		= $getActivityID->row();
			$ActivityID 	= $row->ActivityID;
			$data_approval = array(
				'ActivityID' => $ActivityID,
				'isComplete' => 0,
				'Status' => 'OnProgress',
			);
			$this->db->insert('tb_notification_update_price_list', $data_approval);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->delete_duplicate_info_price_list();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function delete_duplicate_info_price_list()
	{
		$this->db->trans_start(); 
		$sql = "UPDATE tb_update_price_list
				SET isComplete=1, Status='Updated'
				WHERE ActivityID NOT IN (
					SELECT ActivityID
					FROM (
						SELECT MAX(ActivityID) AS ActivityID
						FROM tb_update_price_list
						WHERE isComplete=0
						GROUP BY ProductID
					) t1
				) AND isComplete=0";
		// echo $sql;
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$sql = "UPDATE tb_notification_update_price_list
				SET isComplete=1, Status='Updated'
				WHERE ActivityID NOT IN (
					SELECT ActivityID
					FROM (
						SELECT MAX(ActivityID) AS ActivityID
						FROM tb_update_price_list
						WHERE isComplete=0
						GROUP BY ProductID
					) t1
				) AND isComplete=0";
		// echo $sql;
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function product_promo_history($ProductID)
	{
		$this->db->trans_start();
		$datetimenow = date("Y-m-d H:i:s"); 
		$UserAccountID = $this->session->userdata('UserAccountID');
		if (!empty($ProductID)) {
			$sql = "INSERT INTO tb_product_promo_history 
					(PromoID,PromoName,PromoCategoryID,PromoCategoryName,ProductID,ProductQty,PromoCategoryPercent,Promo,PT1Discount,PT2Discount,InputDate,InputBy)

					SELECT PricelistID, PricelistName, PricecategoryID, PricecategoryName,ProductID, ProductQty, PromoCategory, Promo, PT1Discount, PT2Discount, '".$datetimenow."', ".$UserAccountID."
					FROM (
						SELECT ppl.*, pph.HistoryID 
						FROM vw_product_promo_list_active_with_price ppl
						LEFT JOIN vw_product_promo_history_last pph ON
						pph.PromoID = ppl.PricelistID AND
						pph.PromoName = ppl.PricelistName AND
						pph.PromoCategoryID = ppl.PricecategoryID AND
						pph.PromoCategoryName = ppl.PricecategoryName AND
						pph.ProductID = ppl.ProductID AND
						pph.ProductQty = ppl.ProductQty AND
						pph.PromoCategoryPercent = ppl.PromoCategory AND
						pph.Promo = ppl.Promo AND
						pph.PT1Discount = ppl.PT1Discount AND
						pph.PT2Discount = ppl.PT2Discount 
						WHERE ppl.ProductID IN (" . implode(',', array_map('intval', $ProductID)) . ") 
						AND pph.HistoryID IS NULL
					) t1";
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();

			$sql = "UPDATE tb_product_promo_history SET isActive=0, NonActiveDate='".$datetimenow."'
					WHERE HistoryID IN (
						SELECT t1.HistoryID 
						FROM (
							SELECT pph.HistoryID 
							FROM vw_product_promo_history_last pph
							LEFT JOIN vw_product_promo_list_active_with_price ppl ON
							pph.PromoID = ppl.PricelistID AND
							pph.PromoName = ppl.PricelistName AND
							pph.PromoCategoryID = ppl.PricecategoryID AND
							pph.PromoCategoryName = ppl.PricecategoryName AND
							pph.ProductID = ppl.ProductID AND
							pph.ProductQty = ppl.ProductQty AND
							pph.PromoCategoryPercent = ppl.PromoCategory AND
							pph.Promo = ppl.Promo AND
							pph.PT1Discount = ppl.PT1Discount AND
							pph.PT2Discount = ppl.PT2Discount 
							WHERE pph.ProductID IN (" . implode(',', array_map('intval', $ProductID)) . ") 
							AND ppl.PricelistID IS NULL
						) t1
					)";
			$this->db->query($sql);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->db->trans_complete();
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
	}

// penalty_list===============================================================
	function penalty_list()
	{
		$sql	= "SELECT * FROM tb_penalty_main";
		$show   = array();
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PenaltyID' => $row->PenaltyID,
		  			'PenaltyName' => $row->PenaltyName,
		  			'PenaltyType' => $row->PenaltyType,
		  			'Quantity' => $row->Quantity,
					'PenaltyCategory' => $row->PenaltyCategory,
					'Note' => $row->Note,
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function penalty_add_act()
	{
		$this->db->trans_start();
		$PenaltyName = $this->input->get_post('name');
		$PenaltyType = $this->input->get_post('type');
		$Quantity = $this->input->get_post('quantity');
		$Category = $this->input->get_post('category');
		$Note = $this->input->get_post('note');

		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'PenaltyName' => $PenaltyName,
					'PenaltyType' => $PenaltyType,
					'Quantity' => $Quantity,
					'PenaltyCategory' => $Category,
					'Note' => $Note,
				);
		$this->db->insert('tb_penalty_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);

		$this->db->trans_complete();
	}
	function penalty_edit()
	{
		$PenaltyID = $this->input->get_post('PenaltyID'); 
		$sql 	= "SELECT * FROM tb_penalty_main WHERE PenaltyID=".$PenaltyID;
					// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array()[0]; 

	    return $show;
	}
	function penalty_edit_act()
	{
		$this->db->trans_start();
		$PenaltyID = $this->input->get_post('id');
		$PenaltyName = $this->input->get_post('name');
		$PenaltyType = $this->input->get_post('type');
		$Quantity = $this->input->get_post('quantity');
		$Category = $this->input->get_post('category');
		$Note = $this->input->get_post('note');

		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
			'PenaltyName' => $PenaltyName,
			'PenaltyType' => $PenaltyType,
			'Quantity' => $Quantity,
			'PenaltyCategory' => $Category,
			'Note' => $Note,
		);
		$this->db->where('PenaltyID', $PenaltyID);
		$this->db->update('tb_penalty_main', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		// echo $this->last_query;
		$this->db->trans_complete();
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
		// if (in_array("print_without_header", $MenuList)){
			$sql 	= "SELECT CompanyID,DivisiID,DivisiName,DivisiCode FROM tb_job_divisi";
		// }
		// else{
		// 	$sql 	= "SELECT DivisiID,DivisiName,DivisiCode FROM tb_job_divisi where CompanyID=1";
		// }
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['dept'][]= array(
				'DivisiID' => $row->DivisiID,
				'CompanyID'=>$row->CompanyID,
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
		$DivisiID = $this->input->get_post('divisiidx');
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
					'DivisiID' => implode(",",$DivisiID),
					'Subject' => $Subject,
					'InputBy'=>$EmployeeID,
					'UploadDate'=>$date,
					'UpdateDate'=>'',
					'FilePDF' => $filesnames,
					'Link' => $Link,
					'No'=>$No
				);
		echo json_encode($data);
		$this->db->insert('tb_sop', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sqlmax="SELECT max(SopID) as SopID FROM tb_sop";
		$query3 	= $this->db->query($sqlmax);
		$row=$query3->row();
		$SopID= $row->SopID;
		$EmployeeIDArr = array();
		// $sqlt="Where tjl.DivisiID in ($DivisiID)";
		$sql3 	= "SELECT sop.SopID,sop.DivisiID,tjl.EmployeeID
					From tb_sop sop
					LEFT JOIN tb_job_level tjl on sop.DivisiID=tjl.DivisiID
					where tjl.EmployeeID<>0 and tjl.DivisiID in (".implode(",",$DivisiID) .") and sop.SopID=".$SopID;
		$query3 	= $this->db->query($sql3);
		$query3->result();
		$row3=$query3->result();
		$a = 200;
		foreach ($query3->result() as $row3) {
			// array_push($EmployeeIDArr, $row3->EmployeeID);
			$SopIDArr=array($SopID);
			$EmployeeIDArr[]=$row3->EmployeeID;
		}
		$this->load->model('model_notification');
		$this->model_notification->insert_notif('notif_sop', 'New SOP', 'SopID', $SopIDArr, 'replace', $EmployeeIDArr);

		$this->last_query .= "//".$this->db->last_query();
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
		$DivisiIDp=$show['isi'][0]['DivisiID'];
		// $DivisiIDp=explode(",",$show['isi'][0]['DivisiID']);
	    // $jDivisiID=count($DivisiIDp);
		// echo $show['isi'][0]['DivisiID'];
	    $sql 	= "SELECT CompanyID,DivisiID,DivisiName,DivisiCode FROM tb_job_divisi where DivisiID in (".$show['isi'][0]['DivisiID'].")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['deptp'][]= array(
				'DivisiIDp' => $row->DivisiID,
				'CompanyIDp'=>$row->CompanyID,
				'DivisiNamep' => $row->DivisiName,
				'DivisiCodep' => $row->DivisiCode
			);
		}
		// $DivisiIDp=$show['deptp'][0]['DivisiIDp'];
	     // echo $DivisiIDp;
		$sql 	= "SELECT tjd.DivisiID,sop.DivisiIDp,tjd.CompanyID,tjd.DivisiName,tjd.DivisiCode
				FROM tb_job_divisi tjd
				LEFT JOIN (
				SELECT tjd.DivisiID as DivisiIDp
					FROM tb_job_divisi tjd
					where tjd.DivisiID in (".$DivisiIDp.")) sop on tjd.DivisiID=sop.DivisiIDp";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['dept'][]= array(
				'DivisiID' => $row->DivisiID,
				'DivisiIDp' => $row->DivisiIDp,
				'CompanyID'=>$row->CompanyID,
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
		$DivisiID = $this->input->get_post('divisiidx');
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
		if(!empty($_FILES['label']['name'])){
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
					'DivisiID' => implode(",",$DivisiID),
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
					where tjl.EmployeeID<>0 and tjl.DivisiID in (".implode(",",$DivisiID) .") and sop.SopID=".$id;
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
		$idc = $this->input->get_post('idc');
		$show=array();
		if(!empty($kode)){
		$jumkode=count(explode(',',$kode));
		if ($jumkode==1){
			$sql 		= "select max(No) as no from tb_sop where DivisiID = "."'".$kode."'";
			$query  	= $this->db->query($sql);
			$row 		= $query->row();
			if (!empty($row)){
				$No= $row->no;
			}else{
				$No= 0;
			}

			$sql 		= "select DivisiCode from tb_job_divisi where DivisiID = "."'".$kode."'";
			$query  	= $this->db->query($sql);
			$row 		= $query->row();
			if (!empty($row)){
				$DivisiCode = $row->DivisiCode;
			}else{
				$DivisiCode = '';
			}

			$show= array(
					'no'=>$No,
					'codeid' => str_replace("/", ".SOP.", $DivisiCode).".".str_pad($No+1, 3,'0',STR_PAD_LEFT)
				);
		}else{
			$sql 		= "select max(No) as no from tb_sop where SopCode like '%SOP.MTX%'";
			$query  	= $this->db->query($sql);
			$row 		= $query->row();
			if (!empty($row)){
				$No= $row->no;
			}else{
				$No= 0;
			}

			if ($idc='1'){
				$DivisiCode='AHZ-ID.SOP.MTX.';
			}elseif($idc='2'){
				$DivisiCode='AOT-ID.SOP.MTX.';
			}elseif($idc='3'){
				$DivisiCode='ALD-ID.SOP.MTX.';
			}else{
				$DivisiCode='ACZ-ID.SOP.MTX.';
			}
			$show= array(
				'no'=>$No,
				'codeid' => $DivisiCode.str_pad($No+1, 3,'0',STR_PAD_LEFT)
			);
		}}
		$show = array_reverse($show);
		echo json_encode($show);

		$this->log_user->log_query($this->last_query);
		return $show;
	}
// ==========================================================================
	function fill_customercategory()
	{
		$sql 	= "select * from tb_customer_category";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'CustomercategoryID' => $row->CustomercategoryID,
				'CustomercategoryName' => $row->CustomercategoryName
			);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function search_expedition()
	{
		$q = $this->input->get('q');
		if (strlen($q) > 2) {
			$hasil  = $this->db->query ('select ExpeditionID, Company2 from vw_expedition1 where Company2 like "%'.$q.'%" ');
	        if ($hasil->num_rows()){ 
	        	$data = array();
	            foreach ($hasil->result() as $row) {
	                $data[] = array(
	                    'text' => $row->Company2,
	                    'id' => $row->ExpeditionID
	                    ); 
            	}
	            echo json_encode($data);
	        } 
		}      
		$this->log_user->log_query($this->last_query);
	}
	function search_contact()
	{
		$q = $this->input->get('q[term]');
		$contact = $this->input->get('contact');
		if (strlen($q) > 2) {
			if ($contact == 'company') {
				$hasil  = $this->db->query ('select * from tb_job_company where CompanyName like "%'.$q.'%" ');
		        if ($hasil->num_rows()){
		        	$data = array();
		            foreach ($hasil->result() as $row) {
		                $data[] = array(
		                    'text' => $row->CompanyName,
		                    'id' => $row->CompanyID
		                    ); }
		            echo json_encode($data);
		        }
			} elseif ($contact == 'isEmployee') {
				$hasil  = $this->db->query ('select ContactID, fullname from vw_contact2 where fullname like "%'.$q.'%" and '.$contact.'=1 ');
		        if ($hasil->num_rows()){
		        	$data = array();
		            foreach ($hasil->result() as $row) {
		                $data[] = array(
		                    'text' => $row->fullname,
		                    'id' => $row->ContactID
		                    ); }
		            echo json_encode($data);
		        }
			} elseif ($contact == 'all') {
				$hasil  = $this->db->query ('select ContactID, Company2 from vw_contact2 where Company2 like "%'.$q.'%"');
		        if ($hasil->num_rows()){
		        	$data = array();
		            foreach ($hasil->result() as $row) {
		                $data[] = array(
		                    'text' => $row->ContactID.' - '.$row->Company2,
		                    'id' => $row->ContactID
		                    ); }
		            echo json_encode($data);
		        }
			} elseif ($contact == 'isPersonal') {
				$hasil  = $this->db->query ('select ContactID, Company2 from vw_contact2 where Company2 like "%'.$q.'%" and isCompany=0');
		        if ($hasil->num_rows()){
		        	$data = array();
		            foreach ($hasil->result() as $row) {
		                $data[] = array(
		                    'text' => $row->ContactID.' - '.$row->Company2,
		                    'id' => $row->ContactID
		                    ); }
		            echo json_encode($data);
		        }
			} else {
				$hasil  = $this->db->query ('select ContactID, Company2 from vw_contact2 where Company2 like "%'.$q.'%" and '.$contact.'=1 ');
		        if ($hasil->num_rows()){
		        	$data = array();
		            foreach ($hasil->result() as $row) {
		                $data[] = array(
		                    'text' => $row->Company2,
		                    'id' => $row->ContactID
		                    ); }
		            echo json_encode($data);
		        }
			}
		}
		$this->log_user->log_query($this->last_query);
	}
	function search_customer()
	{
		$q = $this->input->get('q');
		if (strlen($q) > 3) {
			$hasil  = $this->db->query ('select CustomerID, Company2 from vw_customer2 where Company2 like "%'.$q.'%" ');
	        if ($hasil->num_rows()){
	        	$data = array();
	            foreach ($hasil->result() as $row) {
	                $data[] = array(
	                    'text' => $row->Company2,
	                    'id' => $row->CustomerID
	                    ); }
	            echo json_encode($data);
	        }
		}
		$this->log_user->log_query($this->last_query);
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
				$Sales= " and vc3.SalesID like '%".$SalesID."%'";
			}

			$sql= 'SELECT vc3.CustomerID, vc3.Company2, vc3.City, vc3.SalesID from vw_customer5 vc3 where vc3.Company2 like "%'.$q.'%" and vc3.isActive=1 '.$Sales;
			$hasil  = $this->db->query ($sql);
			// echo $sql;
			if ($hasil->num_rows()){
				$data = array();
				foreach ($hasil->result() as $row) {
					$SalesID = $row->SalesID;
					$data[] = array(
						'text' => $row->Company2.' ('.$row->City.')',
						'id' => $row->CustomerID,
						'SalesID' => $row->SalesID,
						); }
				echo json_encode($data);
			}
		}
		$this->log_user->log_query($this->last_query);
	}
	// function search_customer_by_sales()
	// {
	// 	$q = $this->input->get('q');
	// 	if (strlen($q) > 3) {
	// 		$sql = 'select CustomerID, Company2 from vw_customer2 where Company2 like "%'.$q.'%" ';
	// 		$hasil  = $this->db->query($sql);
	//         if ($hasil->num_rows()){ 
	//         	$data = array();
	//             foreach ($hasil->result() as $row) {
	//                 $data[] = array(
	//                     'text' => $row->Company2,
	//                     'id' => $row->CustomerID
	//                     ); }
	//             echo json_encode($data);
	//         } 
	// 	}      
	// }
	function get_customer_address()
	{
    	$data 		= array();
    	$type 		= $this->input->get('type');
		$CustomerID = $this->input->get('CustomerID');
		$sql 		= 'select ca.*, ac.ExpeditionID, ac.FCPrice, ac.FCWeight, vex.Company from vw_contact_address ca 
						left join tb_customer_main c on (ca.ContactID = c.ContactID) 
						LEFT JOIN vw_city ac ON (ca.CityID = ac.CityID)
						LEFT JOIN vw_expedition1 vex ON (ac.ExpeditionID = vex.ExpeditionID)
						where c.CustomerID='.$CustomerID;
		// echo $sql;
		$hasil  	= $this->db->query($sql);
        if ($hasil->num_rows()){
        	$addressid = 0;
        	$cekAllCity = "1";

        	$data['shipping'][$addressid] = array(
                'addressid' => $addressid,
                'DetailType' => "",
                'CityID' => 0,
                'ExpeditionID' => 0,
                'FCPrice' => 0,
                'FCWeight' => 0,
                'ExpeditionName' => 0,
                'DetailValue' => ""
            ); 
    		$addressid += 1;

            foreach ($hasil->result() as $row) {
            	$StateName 		= (is_null($row->StateName))? "" : ", ".$row->StateName;
            	$ProvinceName 	= (is_null($row->ProvinceName))? "" : ", ".$row->ProvinceName;
            	$CityName 		= (is_null($row->CityName))? "" : ", ".$row->CityName;
            	$DistrictsName 	= (is_null($row->DistrictsName))? "" : ", ".$row->DistrictsName;
            	$PosName 		= (is_null($row->PosName))? "" : ", ".$row->PosName;
        		if ($row->CityID == "0") $cekAllCity = "0" ;
            	if ($row->isBilling == "1" ) {
            		$data['billing'] = array(
	                    'DetailType' => $row->DetailType,
	                    'CityID' => $row->CityID,
	                    'DetailValue' => $row->DetailValue
	                );
	                $data['CityID'] = $row->CityID;
            	}
                $data['shipping'][$addressid] = array(
                    'addressid' => $addressid,
                    'DetailType' => $row->DetailType,
                    'CityID' => $row->CityID,
                    'ExpeditionID' => $row->ExpeditionID,
                    'FCPrice' => $row->FCPrice,
                    'FCWeight' => $row->FCWeight,
                    'ExpeditionName' => $row->Company,
                    'DetailValue' => $row->DetailValue
                ); 
                $data['ContactID'] = $row->ContactID;
        		$addressid += 1;
            }
        }
        $data['cekAllCity'] = $cekAllCity;
        if (isset($data['CityID']) and $data['CityID'] != '0') {
        	if (isset($type) and $type == "so") {
				$sql 	= "SELECT ac.*, rm.RegionCode, rm.RegionID, vem.Company2, vem.SalesID, vex.Company, vex.ExpeditionID
							FROM vw_city ac
							LEFT JOIN tb_region_main rm ON (ac.RegionID = rm.RegionID)
							LEFT JOIN vw_sales_executive2 vem ON (rm.SEC = vem.SalesID)
							LEFT JOIN vw_expedition1 vex ON (ac.ExpeditionID = vex.ExpeditionID)
							WHERE ac.CityID = ".$data['CityID'];
				$query 	= $this->db->query($sql);
				$row 	= $query->row();

				$data['SECID'] 		= $row->SalesID;
				$data['SECName'] 	= $row->Company2;
				$data['RegionID'] 	= $row->RegionID;
				$data['RegionCode'] = $row->RegionCode;

				$sql 	= "SELECT NPWP, PaymentTerm, CreditLimit FROM vw_customer2 WHERE CustomerID=".$CustomerID;
				$query 	= $this->db->query($sql);
				$row 	= $query->row();
				$data['NPWP'] = ($row->NPWP == "")? "0" : $row->NPWP;
				$data['PaymentTerm'] = $row->PaymentTerm;
				$data['CreditLimit'] = $row->CreditLimit;
				// $data['creditavailable'] = 0;
				$this->load->model('model_finance', 'finance');
				$debt = $this->finance->get_customer_debt($CustomerID);
				$data['creditavailable'] = $row->CreditLimit - $debt;

				// get sales and price category
				$sql2 = "select cd.*, vem.SalesID, vem.Company2 from tb_customer_detail cd ";
				$sql2 .= "LEFT JOIN vw_sales_executive2 vem ON cd.DetailValue = vem.SalesID ";
				$sql2 .= "where cd.DetailType in ('sales','price') ";
				$sql2 .= "and cd.CustomerID = '".$CustomerID."' ";
				$query2 = $this->db->query($sql2);
				foreach ($query2->result() as $row2) {
					if ($row2->DetailType == 'sales') {
						$data['sales'][] = array(
		                    'SalesID' => $row2->SalesID,
		                    'SalesName' => $row2->Company2
		                );
					} elseif ($row2->DetailType == 'price') {
						$data['price'][] = $row2->DetailValue;
					}
				};

				// get pricelist
				if (array_key_exists("price", $data)) {
					
					$sql2 = "select * from tb_price_category_main where PricecategoryID  in (". implode(',', array_map('intval', $data['price'])).")";
					$query2 = $this->db->query($sql2);
					foreach ($query2->result() as $row2) {
						$data['pricecategory'][] = $row2->PricecategoryID;
						$data['pricename'][] = array(
		                    'Type' => "PriceCategory",
		                    'PricecategoryID' => $row2->PricecategoryID,
		                    'PricecategoryName' => $row2->PricecategoryName
		                );
					};

					$sql2 = "SELECT pcd.*, plm.*
							FROM tb_price_category_detail pcd
							LEFT JOIN tb_price_list_main plm ON (pcd.PricelistID = plm.PricelistID) 
							where pcd.PricecategoryID in (". implode(',', array_map('intval', $data['price'])) .") 
							AND plm.isActive=1 AND plm.DateEnd >= CURDATE() ";
					$query2 = $this->db->query($sql2);
					$result = $query2->result();
					if (!empty($result)) {
						foreach ($query2->result() as $row2) {
							$data['pricelist'][] = $row2->PricelistID;

							$data['pricename'][] = array(
			                    'Type' => "PromoPiece",
			                    'PricecategoryID' => $row2->PricelistID,
			                    'PricecategoryName' => $row2->PricelistName
			                );
						};
					} else {
						$data['pricelist'][] = "0";
					}

					$sql2 = "SELECT PromoVolID, PromoVolName FROM	tb_price_promo_vol_main
							WHERE isActive=1 and PricecategoryID IN (". implode(',', array_map('intval', $data['price'])) .") 
							AND DateEnd >= CURDATE()";
					$query2 = $this->db->query($sql2);
					$result = $query2->result();
					if (!empty($result)) {
						foreach ($query2->result() as $row2) {
							$data['promovolume'][] = $row2->PromoVolID;

							$data['pricename'][] = array(
			                    'Type' => "PromoVolume",
			                    'PricecategoryID' => $row2->PromoVolID,
			                    'PricecategoryName' => $row2->PromoVolName
			                );
						};
					} else {
						$data['promovolume'][] = "0";
					}
				}

				// get invoice late
        		$this->load->model('model_transaction');
				$inv_late = $this->model_transaction->get_inv_late($CustomerID);
        		if (count($inv_late) > 0) {
					$data['inv_late'] = $inv_late;
        		}

			}
        }
        echo json_encode($data);
		$this->log_user->log_query($this->last_query);
	}
	function fill_sales()
	{
		$sql 	= "SELECT SalesID, Company2 FROM vw_sales_executive2 jl where isActive=1 order by Company2";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'SalesID' => $row->SalesID,
				'SalesName' => $row->Company2
			);
		};
		
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
		$this->log_user->log_query($this->last_query);
	}
	function fill_price()
	{
		$sql 	= "select * from tb_price_category_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'PricecategoryID' => $row->PricecategoryID,
				'PromoDefault' => $row->PromoDefault,
				'PricecategoryName' => $row->PricecategoryName
			);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_atribute()
	{
		$sql 	= "SELECT * FROM tb_product_atribute";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductAtributeID' => $row->ProductAtributeID,
		  			'ProductAtributeName' => $row->ProductAtributeName,
		  			'ProductAtributeType' => $row->ProductAtributeType
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_atribute_list()
	{
		$sql 	= "SELECT * FROM tb_product_atribute order by ProductAtributeName";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductAtributeID' => $row->ProductAtributeID,
		  			'ProductAtributeName' => $row->ProductAtributeName,
		  			'ProductAtributeType' => $row->ProductAtributeType
				);
		};
		return $show;
		$this->log_user->log_query($this->last_query);
	}
	function get_atribute_detail()
	{
		$id = $this->input->get('id'); 
		$this->db->simple_query('SET SESSION group_concat_max_len=15000');
		$sql 	= "SELECT pa.*, GROUP_CONCAT( pav.ProductAtributeValueName ) AS valuename, 
					GROUP_CONCAT( pav.ProductAtributeValueCode ) AS valuecode FROM tb_product_atribute pa 
					LEFT JOIN tb_product_atribute_value pav ON pa.ProductAtributeID = pav.ProductAtributeID 
					WHERE pa.ProductAtributeID=".$id."
					GROUP BY pa.ProductAtributeID ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show = array(
		  			'ProductAtributeID' => $row->ProductAtributeID,
		  			'ProductAtributeName' => $row->ProductAtributeName,
		  			'ProductAtributeType' => $row->ProductAtributeType,
		  			'valuename' => $row->valuename,
		  			'valuecode' => $row->valuecode
				);
		};
		$show = array_reverse($show);
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_atribute_set()
	{
		$sql 	= "SELECT * FROM tb_product_atribute_set";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductAtributeSetID' => $row->ProductAtributeSetID,
		  			'ProductAtributeSetName' => $row->ProductAtributeSetName
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_pricelist()
	{
		$sql 	= "SELECT * FROM tb_price_list_main";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'PricelistID' => $row->PricelistID,
		  			'PricelistName' => $row->PricelistName
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_parent_brand($parent = 0, $spacing = '', $count = '1', $brand_tree_array = array())
	{
		$sql 	= "select ProductBrandID, ProductBrandName from tb_product_brand where ProductBrandParent = ".$parent." ORDER by ProductBrandName";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$brand_tree_array[] = array(
					'ProductBrandID' => $row->ProductBrandID,
					'ProductBrandName' => $spacing.$row->ProductBrandName,
					'count' => $count
				);
		      	$brand_tree_array = $this->fill_parent_brand($row->ProductBrandID, $spacing.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $count.'1', $brand_tree_array);
			};
		}
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function fill_parent_category($parent = 0, $spacing = '', $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryID, ProductCategoryName from tb_product_category where ProductCategoryParent = ".$parent." ORDER by ProductCategoryName";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$category_tree_array[] = array(
					'ProductCategoryID' => $row->ProductCategoryID,
					'ProductCategoryName' => $spacing.' '.$row->ProductCategoryName
				);
		      	$category_tree_array = $this->fill_parent_category($row->ProductCategoryID, $spacing.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $category_tree_array);
			};
		}
		return $category_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function get_category_detail()
	{
		$id 	= $this->input->post('id'); 
		$sql 	= "SELECT * FROM tb_product_category where ProductCategoryID = ".$id."";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductCategoryID' => $row->ProductCategoryID,
		  			'ProductCategoryName' => $row->ProductCategoryName,
		  			'ProductCategoryCode' => $row->ProductCategoryCode,
		  			'ProductCategoryParent' => $row->ProductCategoryParent,
		  			'ProductAtributeSetID' => $row->ProductAtributeSetID,
		  			'ProductCategoryDescription' => $row->ProductCategoryDescription
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_atribute_value()
	{
		$id 	= $this->input->post('id'); 
		$sql2 	= "SELECT * FROM tb_product_atribute_value where ProductAtributeID = ".$id." order by ProductAtributeValueName";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
		  	$show[] = array(
	  			'ProductAtributeValueName' => $row->ProductAtributeValueName,
	  			'ProductAtributeValueCode' => $row->ProductAtributeValueCode
			);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_atribute_set_value()
	{
		$id 	= $this->input->post('id'); 
		$sql2 	= "SELECT * FROM tb_product_atribute_set_detail where ProductAtributeSetID = ".$id."";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
		  	$show[] = $row->ProductAtributeID;
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_product_set_value()
	{
		$id 	= $this->input->post('id'); 
		$sql2 	= "SELECT * FROM tb_price_list_detail where PricelistID = ".$id."";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
			$show[] = $row->PricelistID;
				
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_pricelist_set_value()
	{
		$id 	= $this->input->post('id'); 
		$sql2 	= "SELECT * FROM tb_price_category_detail where PricecategoryID = ".$id."";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row) {
		  	$show[] = $row->PricelistID;
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_statusquality()
	{
		$sql 	= "SELECT * FROM tb_product_status";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductStatusID' => $row->ProductStatusID,
		  			'ProductStatusName' => $row->ProductStatusName
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_full_category($parent = 0, $fullparent = '', $category_tree_array = array())
	{
		$sql 	= "SELECT COUNT(pc.ProductCategoryID) as num_child, pc.ProductCategoryID, pc.ProductCategoryName
					FROM tb_product_category pc
					LEFT JOIN tb_product_category pc2 ON pc.ProductCategoryID=pc2.ProductCategoryParent
					WHERE pc.ProductCategoryParent=".$parent." GROUP BY pc.ProductCategoryID order by pc.ProductCategoryName";
		// echo $sql;			
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
	function get_full_category_child_id($parent, $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryID from tb_product_category where ProductCategoryParent = ".$parent." ORDER by ProductCategoryID";
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
		$this->log_user->log_query($this->last_query);
	}
	function get_full_category_parent_id($ProductCategoryID, $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryParent from tb_product_category where ProductCategoryID = ".$ProductCategoryID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			if ($row->ProductCategoryParent != '0') {
				$category_tree_array[] = $row->ProductCategoryParent;
		      	$category_tree_array = $this->get_full_category_parent_id($row->ProductCategoryParent, $category_tree_array);
			}
		}
		$category_tree_array[] = $ProductCategoryID;
		return $category_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function ajax_product_category_list_jstree($parent = 0, $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryID, ProductCategoryName, ProductCategoryCode from tb_product_category where ProductCategoryParent = ".$parent." ORDER by ProductCategoryID";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
		        $cekParent = '<button type="button" class="btn btn-primary btn-xs cekParent cekParentC" title="Show Parent" category="'.$row->ProductCategoryID.'"><i class="fa fa-fw fa-users"></i></button>';
		        if ($this->auth->cek5('accounting')) {
		        	$cekValue = '<button type="button" class="btn btn-primary btn-xs cekValue" title="Show Inventory Value" category="'.$row->ProductCategoryID.'"><i class="fa fa-fw fa-dollar"></i></button>';
		        } else {
		        	$cekValue = '';
		        }
	        	$spanD = '';

				$category_tree_array[] = array(
					'id' => $row->ProductCategoryID,
					'text' => $row->ProductCategoryName." (".$row->ProductCategoryCode.")".$spanD,
					'qty' => 0,
					'value' => 0,
					'children' => $this->ajax_product_category_list_jstree($row->ProductCategoryID),
				);
			}
		}
		return $category_tree_array;
	}
	function ajax_product_category_list_jstree_table()
	{
		$category_tree_array   = array();
		$sql 	= "select ProductCategoryID, ProductCategoryName, ProductCategoryCode, ProductCategoryParent from tb_product_category ORDER by ProductCategoryName";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$allChild = $this->get_full_category_child_id($row->ProductCategoryID);
			$sql 	= "SELECT COUNT(ProductID) AS totalProductType, SUM(stock) AS totalStock, SUM(totalValueStock) AS totalValueStock
						FROM vw_product_list_popup8 WHERE ProductCategoryID in (".implode(',',$allChild).")";
			$getrow = $this->db->query($sql);
			$row2 	= $getrow->row();
			$totalProductType = $row2->totalProductType;
			$totalStock = $row2->totalStock;
			$totalValueStock = $row2->totalValueStock;
        	$GoToList = '<button type="button" class="btn btn-primary btn-xs GoToListC" title="Show List Product" category="'.$row->ProductCategoryID.'"><i class="fa fa-fw fa-file-text-o"></i></button>';

			$category_tree_array[] = array(
				'id' => $row->ProductCategoryID,
				'parent' =>  ($row->ProductCategoryParent == 0) ? '#' : $row->ProductCategoryParent ,
				'text' => $row->ProductCategoryName." (".$row->ProductCategoryCode.")",
				
				// 'qtyProduct' => (double)$totalProductType,
				// 'qtyStock' => (double)$totalStock,
				// 'value' => (double)$totalValueStock,
				'data' => array(
					'qtyProduct' => (double)$totalProductType,
					'qtyStock' => (double)$totalStock,
					'value' => (double)$totalValueStock,
					'GoToList' => $GoToList,
				),
			);
		}

		return $category_tree_array;
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
	function get_category_parent_main($ProductCategoryParent = 0, $ProductCategoryNameP = '', $category_tree_array = array())
	{
		$sql 	= "select ProductCategoryID, ProductCategoryName, ProductCategoryCode, ProductCategoryParent from tb_product_category where ProductCategoryParent = ".$ProductCategoryParent."";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				if ($row->ProductCategoryParent == 0) {
					$ProductCategoryName = $row->ProductCategoryName;
				} else {
					$ProductCategoryName = $ProductCategoryNameP;
				}
				$category_tree_array[$row->ProductCategoryID] = array(
					'ProductCategoryID' => $row->ProductCategoryID,
					'ProductCategoryName' => $ProductCategoryName,
					'ProductCategoryParent' => $row->ProductCategoryParent
				);
	      		$category_tree_array = $this->get_category_parent_main($row->ProductCategoryID, $ProductCategoryName, $category_tree_array);
			};
		}
		return $category_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function get_category_code()
	{
		$id = $this->input->get('id'); 
		$code = array();
		$show = $this->fill_category_code($id,$code);
		$show = array_reverse($show);
		$result_code = "";
		foreach($show as $result) {
		    $result_code .= $result['ProductCategoryCode'].'-';
		}
		$result_code = substr($result_code, 0, -1);
		echo json_encode($result_code);
		$this->log_user->log_query($this->last_query);
	}
	function get_category_name()
	{
		$id = $this->input->get('id'); 
		$code = array();
		$show = $this->fill_category_code($id,$code);
		$show = array_reverse($show);
		$result_code = "";
		foreach($show as $result) {
		    $result_code .= $result['ProductCategoryName'].'-';
		}
		$result_code = substr($result_code, 0, -1);
		echo json_encode($result_code);
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
	function get_full_brand_child_id($parent, $brand_tree_array = array())
	{
		$sql 	= "select ProductBrandID from tb_product_brand where ProductBrandParent = ".$parent." ORDER by ProductBrandID";
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$brand_tree_array[] = $row->ProductBrandID;
		      	$brand_tree_array = $this->get_full_brand_child_id($row->ProductBrandID, $brand_tree_array);
			};
		}
		$brand_tree_array[] = $parent;
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function get_full_brand_parent_id($ProductBrandID, $brand_tree_array = array())
	{
		$sql 	= "select ProductBrandParent from tb_product_brand where ProductBrandID = ".$ProductBrandID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			if ($row->ProductBrandParent != '0') {
				$brand_tree_array[] = $row->ProductBrandParent;
		      	$brand_tree_array = $this->get_full_brand_parent_id($row->ProductBrandParent, $brand_tree_array);
			}
		}
		$brand_tree_array[] = $ProductBrandID;
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function ajax_product_brand_list_jstree($parent = 0, $brand_tree_array = array())
	{
		$show   = array();
		$sql 	= "select ProductBrandID, ProductBrandName, ProductBrandCode from tb_product_brand where ProductBrandParent = ".$parent." ORDER by ProductBrandID";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
		        $cekParent = '<button type="button" class="btn btn-primary btn-xs cekParent cekParentB" title="Show Parent" brand="'.$row->ProductBrandID.'"><i class="fa fa-fw fa-users"></i></button>';
	        	$spanD = '';
				$brand_tree_array[] = array(
					'id' => $row->ProductBrandID,
					'text' => $row->ProductBrandName." (".$row->ProductBrandCode.")".$spanD ,
					'children' => $this->ajax_product_brand_list_jstree($row->ProductBrandID),
				);
			}
		}
		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function ajax_product_brand_list_jstree_table()
	{
		$brand_tree_array   = array();
		$sql 	= "select ProductBrandID, ProductBrandName, ProductBrandCode, ProductBrandParent from tb_product_brand ORDER by ProductBrandName";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$allChild = $this->get_full_brand_child_id($row->ProductBrandID);
			$sql 	= "SELECT COUNT(ProductID) AS totalProductType, SUM(stock) AS totalStock, SUM(totalValueStock) AS totalValueStock
						FROM vw_product_list_popup8 WHERE ProductBrandID in (".implode(',',$allChild).")";
			$getrow = $this->db->query($sql);
			$row2 	= $getrow->row();
			$totalProductType = $row2->totalProductType;
			$totalStock = $row2->totalStock;
			$totalValueStock = $row2->totalValueStock;
        	$GoToList = '<button type="button" class="btn btn-primary btn-xs GoToListB" title="Show List Product" brand="'.$row->ProductBrandID.'"><i class="fa fa-fw fa-file-text-o"></i></button>';

			$brand_tree_array[] = array(
				'id' => $row->ProductBrandID,
				'parent' =>  ($row->ProductBrandParent == 0) ? '#' : $row->ProductBrandParent ,
				'text' => $row->ProductBrandName." (".$row->ProductBrandCode.")",
				
				// 'qtyProduct' => (double)$totalProductType,
				// 'qtyStock' => (double)$totalStock,
				// 'value' => (double)$totalValueStock,
				'data' => array(
					'qtyProduct' => (double)$totalProductType,
					'qtyStock' => (double)$totalStock,
					'value' => (double)$totalValueStock,
					'GoToList' => $GoToList,
				),
			);
		}

		return $brand_tree_array;
		$this->log_user->log_query($this->last_query);
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
	function get_brand_code()
	{
		$id = $this->input->get('id'); 
		$code = array();
		$show = $this->fill_brand_code($id,$code);
		$show = array_reverse($show);
		$result_code = "";
		foreach($show as $result) {
		    $result_code .= $result['ProductBrandCode'].'-';
		}
		$result_code = substr($result_code, 0, -1);
		echo json_encode($result_code);
		$this->log_user->log_query($this->last_query);
	}
	function get_brand_name()
	{
		$id = $this->input->get('id'); 
		$code = array();
		$show = $this->fill_brand_code($id,$code);
		$show = array_reverse($show);
		$result_code = "";
		foreach($show as $result) {
		    $result_code .= $result['ProductBrandName'].'-';
		}
		$result_code = substr($result_code, 0, -1);
		echo json_encode($result_code);
		$this->log_user->log_query($this->last_query);
	}
	function get_atribute_set_detail()
	{
		$id = $this->input->get('id'); 
		$this->db->simple_query('SET SESSION group_concat_max_len=15000');
		$sql 	= "SELECT * FROM ( SELECT * FROM tb_product_atribute_set_detail where ProductAtributeSetID = '".$id."') AS A JOIN (   
					SELECT pa.*, GROUP_CONCAT( pav.ProductAtributeValueName order by pav.ProductAtributeValueName asc ) AS valuename,
					GROUP_CONCAT( pav.ProductAtributeValueCode order by pav.ProductAtributeValueName asc ) AS valuecode 
					FROM tb_product_atribute pa 
					LEFT JOIN ( SELECT * from tb_product_atribute_value ORDER BY ProductAtributeValueName ) pav ON pa.ProductAtributeID = pav.ProductAtributeID 
					GROUP BY pa.ProductAtributeID ) 
					AS B ON A.ProductAtributeID = B.ProductAtributeID order by ProductAtributeType asc, A.ProductAtributeID desc";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductAtributeID' => $row->ProductAtributeID,
		  			'ProductAtributeName' => $row->ProductAtributeName,
		  			'ProductAtributeType' => $row->ProductAtributeType,
		  			'valuename' => $row->valuename,
		  			'valuecode' => $row->valuecode
				);
		};
		$show = array_reverse($show);
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_product_list()
	{
		$sql 	= "SELECT ProductID, ProductName, ProductCode FROM tb_product_main";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductID' => $row->ProductID,
		  			'ProductName' => $row->ProductName,
					'ProductCode' => $row->ProductCode
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_product_price_list()
	{
		$sql 	= "SELECT * FROM tb_product_main p join tb_price_list_detail pld on pld.ProductID=p.ProductID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'ProductID' => $row->ProductID,
		  			'ProductName' => $row->ProductName,
					'ProductCode' => $row->ProductCode,
					'PT1Discount'  => $row->PT1Discount,
					'PT2Discount'  => $row->PT2Discount
				);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_category_aribute_set()
	{
		$id = $this->input->get('id'); 
		$sql 	= "SELECT ProductAtributeSetID, ProductCodeFormula, ProductNameFormula FROM tb_product_category where ProductCategoryID = '".$id."'";
		$query 	= $this->db->query($sql);

		// $result_CodeFormula = "";
		// $result_NameFormula = "";
		// $arr1 		= array();
		// $category 	= $this->fill_category_code($id, $arr1);
		// foreach($category as $result) {
		//     if ($result_CodeFormula == "") {
		//     	$result_CodeFormula = $result['ProductCodeFormula'];
		//     }
		//     if ($result_NameFormula == "") {
		//     	$result_NameFormula = $result['ProductNameFormula'];
		//     }
		// }

		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = $row->ProductAtributeSetID;
		  	// $show[] = $result_CodeFormula;
		  	// $show[] = $result_NameFormula;
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_category_name_code()
	{
		$id = $this->input->get('id'); 
		$sql 	= "SELECT ProductCodeFormula, ProductNameFormula FROM tb_product_category where ProductCategoryID = '".$id."'";
		$query 	= $this->db->query($sql);

		$result_CodeFormula = "";
		$result_NameFormula = "";
		$arr1 		= array();
		$category 	= $this->fill_category_code($id, $arr1);
		foreach($category as $result) {
		    if ($result_CodeFormula == "") {
		    	$result_CodeFormula = $result['ProductCodeFormula'];
		    }
		    if ($result_NameFormula == "") {
		    	$result_NameFormula = $result['ProductNameFormula'];
		    }
		}

		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = $result_CodeFormula;
		  	$show[] = $result_NameFormula;
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function generatenamecode($data)
	{
		if ($data != "single") {
			$productid 		= $data['productid']; 
			$codeformula 	= $data['codeformula']; 
			$nameformula 	= $data['nameformula']; 
			$categorycode	= $data['categorycode']; 
			$categoryname 	= $data['categoryname']; 
			$brandcode 		= $data['brandcode']; 
			$brandname 		= $data['brandname']; 
			$atributename 	= $data['atributename']; 
			$atributecode 	= $data['atributecode']; 
			$atributetype 	= $data['atributetype']; 
			$statusquality 	= $data['statusquality']; 
			$productdescription = $data['productdescription']; 
		} else {
			$productid 		= $this->input->post('productid'); 
			$codeformula 	= $this->input->post('codeformula'); 
			$nameformula 	= $this->input->post('nameformula'); 
			$categorycode	= $this->input->post('categorycode'); 
			$categoryname 	= $this->input->post('categoryname'); 
			$brandcode 		= $this->input->post('brandcode'); 
			$brandname 		= $this->input->post('brandname'); 
			$atributename 	= $this->input->post('atributename'); 
			$atributecode 	= $this->input->post('atributecode'); 
			$atributetype 	= $this->input->post('atributetype'); 
			$statusquality 	= $this->input->post('statusquality'); 
			$productdescription = $this->input->post('productdescription'); 
		}
		$categorycodearr = explode("-", $categorycode);
		$categorynamearr = explode("-", $categoryname);
		$brandcodearr = explode("-", $brandcode);
		$brandnamearr = explode("-", $brandname);
		for ($i=0; $i < count($categorycodearr);$i++) {
			$x = $i+1;
			$codeformula = str_replace("category".$x, $categorycodearr[$i], $codeformula);
			$nameformula = str_replace("category".$x, $categorynamearr[$i], $nameformula);
		};

		$brand = array();
		$brand2 = $this->fill_parent_brand(0, "", "1", $brand);
		$lengthbrand = 0;
		foreach ($brand2 as $row => $list) {
			$lengthbrand = ($lengthbrand <= strlen($list['count']) ? strlen($list['count']) : $lengthbrand);
		}
		for ($i=0; $i < $lengthbrand; $i++) {
			$x = $i+1;
			if (array_key_exists($i, $brandcodearr)) {
				$codeformula = str_replace("brand".$x, $brandcodearr[$i], $codeformula);
				$nameformula = str_replace("brand".$x, $brandnamearr[$i], $nameformula);
			} else {
				$start = "brand".$x;
				// echo strpos($codeformula, $start);
				if (strpos($codeformula, $start) !== false) {
					$pos1 = strpos($codeformula, $start);
					$codeformula = substr_replace($codeformula,"",$pos1+strlen($start),1);
				}
				if (strpos($nameformula, $start) !== false) {
					$pos1 = strpos($nameformula, $start);
					$nameformula = substr_replace($nameformula,"",$pos1+strlen($start),1);
				}
				$codeformula = str_replace("brand".$x, "", $codeformula);
				$nameformula = str_replace("brand".$x, "", $nameformula);
			}
		};

		$codeformula = str_replace("statusquality", $statusquality, $codeformula);
		$nameformula = str_replace("statusquality", $statusquality, $nameformula);

		$codeformula = str_replace("description", $productdescription, $codeformula);
		$nameformula = str_replace("description", $productdescription, $nameformula);

		for ($i=2; $i < count($atributename);$i++) {
			// if(empty($atributecode[$i])) $atributecode[$i]='xxx';
			if (empty($atributename[$i]) or $atributename[$i] == " ") {
				$atributename[$i]='xxx';
			}
			if (empty($atributecode[$i]) or $atributecode[$i] == " ") {
				$atributecode[$i]='xxx';
			}
			$codeformula = str_replace($atributetype[$i], $atributecode[$i], $codeformula);
			$nameformula = str_replace($atributetype[$i], $atributename[$i], $nameformula);
			// $codeformula = str_replace('xxx-', '', $codeformula_);
			$vowels = array("xxx ", "xxx,", "xxx.", "xxx-", "xxxX", "xxx");
			$nameformula = str_replace($vowels, '', $nameformula);
			$codeformula = str_replace($vowels, '', $codeformula);
		};

		$nameformula = substr($nameformula, 0, -1);
		$codeformula = substr($codeformula, 0, -1);

		if ($data != "single") {
			$show   = array($codeformula, $nameformula, $productid);
			return($show);
		} else {
			$show   = array($codeformula, $nameformula);
			echo json_encode($show);
		}
		$this->log_user->log_query($this->last_query);
	}
	function generatenamecodebatch()
	{
		$result = array();
		// print_r($this->input->post('data_all'));
		foreach ($this->input->post('data_all') as $key => $value) {
			$result2 = $this->generatenamecode($value);
			$result[$result2[2]] = $result2;
		}
		echo json_encode($result);
		$this->log_user->log_query($this->last_query);
	}
	function fill_city()
	{
		$sql 	= "select * from vw_city";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$show[] = array(
				'CityID' => $row->CityID,
				'CityName' => $row->CityName
			);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function fill_customer()
	{
		$sql 	= "select * from tb_customer_main cm join tb_contact c on c.ContactID=cm.ContactID";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'CustomerID' => $row->CustomerID,
				'Company' => $row->Company,
				'ContactID' => $row->ContactID
			);
		};
		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
	}
	function get_min_percent($num1, $num2)
	{
		$result  = 0;
		$percent = ($num1/100)*$num2;
		$result  = $num1 - $percent; 
		return $result;
		$this->log_user->log_query($this->last_query);
	}
	function contact_label()
	{
		$id = $this->input->get('id');
		// form DO
		$doid = $this->input->get('doid');
		$company = $this->input->get('company');
		$shipname = $this->input->get('shipname');
		$address = $this->input->get('address');
		if (isset($id)) {
			$sql = "SELECT c.ContactID, c.Company, ca.DetailType as NameFirst, ac.CityName, concat(ca.DetailValue, ', ',ac.CityName, ', ',p.ProvinceName,', ',s.StateName,', ', ifnull(`pos`.`PosName`, '')) as address, cd.DetailValue as phone 
					FROM tb_contact_address ca
					LEFT JOIN tb_contact c on c.ContactID=ca.ContactID
					LEFT JOIN tb_contact_detail cd on c.ContactID=cd.ContactID
					LEFT JOIN vw_city ac ON (ca.CityID = ac.CityID)
					LEFT JOIN tb_address_province p ON (ca.ProvinceID = p.ProvinceID)
					LEFT JOIN tb_address_state s ON (ca.StateID = s.StateID)
					LEFT JOIN tb_address_pos pos ON (ca.PosID = pos.PosID)
					WHERE ca.OrderID = '".$id."' and cd.DetailName='phone'";
					// echo $sql;
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			$show['ContactID']	= $row->ContactID;
			$show['Company']	= $row->Company;
			$show['address']	= $row->address;
			$show['phone']	= $row->phone;
			$show['NameFirst']	= $row->NameFirst;
			$show['CityName']	= $row->CityName;
		} elseif (isset($doid)) {
			$show['ContactID']	= 'DO-'.$doid;
			$show['Company']	= urldecode($company);
			$show['address']	= urldecode($address);
			$show['phone']		= '';
			$show['NameFirst']	= urldecode($shipname);
			$show['CityName']	= '';
		}
		return $show;
	}
}

?>