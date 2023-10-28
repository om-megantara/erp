<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_employee extends CI_Model {
	public function __construct()
	{
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
	}
// =====================================================================
	function content_profile($id)
	{
		$show = array();

		$sql = "select c.*, r.*, es.*, jo.*, em.*, jc.* from tb_employee_main em ";
		$sql .= "left join vw_contact2 c on (em.ContactID = c.ContactID) ";
		$sql .= "left join tb_religion r on (c.ReligionID = r.ReligionID) ";
		$sql .= "left join tb_job_office_location jo on (em.LocID = jo.LocID) ";
		$sql .= "left join tb_job_company jc on (jo.CompanyID = jc.CompanyID) ";
		$sql .= "left join tb_employment_status es on (em.EmploymentID = es.EmploymentID) ";
		$sql .= "where em.EmployeeID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		$fullname 	= $row->fullname;
		$gender		= $row->Gender=="M" ? "Male" : "Female";
		$date 		= new DateTime($row->BirthDate);
		$now 		= new DateTime();
		$interval 	= $now->diff($date);
		$age 		= $interval->y;
		$EmpStatus  = $row->isActive=="1" ? "Active - " : "Resign - " ;
		$EmpStatus  .= $row->EmploymentName."//".$row->StartDate." <> ".$row->EndDate ;
		$Marital 	= $row->MaritalStatus=="1" ? "Married" : "Single" ;
		$Company 	= $row->CompanyName."//".$row->LocCode;

		// mengisi job title
		$sql2 = "select jt.*, jl.*, jd.* from tb_job_title jt ";
		$sql2 .= "left join tb_job_level jl on (jt.LevelID = jl.LevelID) ";
		$sql2 .= "left join tb_job_divisi jd on (jl.DivisiID = jd.DivisiID) ";
		$sql2 .= "where jt.EmployeeID = '".$id."' order by StartDate";
		$query2 = $this->db->query($sql2);

		$JobTitleCode = "";
		$Department = "";
		foreach ($query2->result() as $row2) {
			$JobTitleCode .= $row2->LevelName." / ".$row2->StartDate." <> ".$row2->EndDate."<br>";
			$Department = $row2->DivisiName;
		};

		// mengisi alamat
		$sql3 = "select ca.*, cas.*, capr.*, cac.*, cad.*, capo.* from tb_contact_address ca ";
		$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "where ca.ContactID = '".$row->ContactID."'";
		$query3 = $this->db->query($sql3);

		$alamat = "";
		foreach ($query3->result() as $row3) {
			$alamat .= "<b>".$row3->DetailType."</b><br>".$row3->DetailValue."<br>".$row3->DistrictsName.", ".$row3->CityName.", ".$row3->ProvinceName."<br>".$row3->StateName.", ".$row3->PosID."<br>";
		};

		// mengisi telepon dan email
		$sql4 = "select cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$row->ContactID."'";
		$query4 = $this->db->query($sql4);
		$phone = "";
		$email = $row->Email."<br>";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email") {
				$email .= $row4->DetailValue."<br>";
			} else {
				$phone .= $row4->DetailValue."<br>";
			}
		};

		$sql5 	= "select * from tb_employee_family where EmployeeID = '".$id."'";
		$query5 = $this->db->query($sql5);
		$row5 	= $query5->row();	

		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);
		$imagedata 	= file_get_contents(base_url()."tool/profil.png", false, stream_context_create($opts));
		if ($row->fProfile == null || $row->fProfile == "") {
			$fProfile = $imagedata;
		} else {
			$fProfile = $row->fProfile;
		}
		$show = array(
			'id' => $id,
			'image' => $fProfile,
			'fullname' => $fullname,
			'Birthday' => $row->BirthDate,
			'gender' => $gender,
			'age' => $age,
			'religion' => $row->ReligionName,
			'NIP' => $row->NIP,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'BIOID' => $row->BioID,
			'Status' => $EmpStatus,
			'JoinDate' => $row->JoinDate,
			'maritalstatus' => $Marital,
			'Company' => $Company,
			'Phone' => $phone,
			'Email' => $email,
			'homeaddress' => $alamat,
			'JobTitleCode' => $JobTitleCode==NULL ? "" : $JobTitleCode,
			'Department' => $Department==NULL ? "" : $Department,

	        'FamilyName' => $row5->empFamilyName,
		    'FamilySex' => $row5->empFamilySex=="M" ? "Male" : "Female",
	        'FamilyJob' => $row5->empFamilyJob,
	        'FamilyStatus' => $row5->empFamilyStatus,
	        'FamilyAddress' => $row5->empFamilyAddress,
	        'FamilyPhone' => $row5->empFamilyPhone,
	        'FamilyEmail' => $row5->empFamilyEmail,

			'cv' => $row->fCV==NULL ? "KOSONG" : "ADA",
			'appraisal' => $row->fAppraisal==NULL ? "KOSONG" : "ADA",
			'ijazah' => $row->fIjazah==NULL ? "KOSONG" : "ADA",
			'ktp' => $row->fKtp==NULL ? "KOSONG" : "ADA",
			'ksk' => $row->fKsk==NULL ? "KOSONG" : "ADA",
			'skck' => $row->fSkck==NULL ? "KOSONG" : "ADA",
			'domisili' => $row->fDomisili==NULL ? "KOSONG" : "ADA",
			'referensi' => $row->fReferensi==NULL ? "KOSONG" : "ADA"

		);
		
		$sql6 = "select am.*, ad.*, c.*, ad.DateIn as DateInD from tb_asset_main am ";
		$sql6 .= "left join tb_asset_detail ad on(am.AssetID = ad.AssetID) ";
		$sql6 .= "left join tb_employee_main em on(ad.EmployeeID = em.EmployeeID) ";
		$sql6 .= "left join tb_contact c on(em.ContactID = c.ContactID)";
		$sql6 .= " where ad.EmployeeID = '".$id."' and ( ad.DateOut = '0000-00-00' or ad.DateOut is null)";
		$query6 	= $this->db->query($sql6);
		$row6 	= $query6->row();
		
		if (empty($row6)) {
				$show['asset'][] = array(
					'AssetID' => "",
					'AssetName' => "",
					'StatusIn' => "",
					'DateInD' => "",
					'Price'	=> "",
					'assetcondition' => ""
				);
		}else{
			foreach ($query6->result() as $row6) {
				$show['asset'][] = array(
					'AssetID' => $row6->AssetID,
					'AssetName' => $row6->AssetName,
					'StatusIn' => $row6->StatusIn,
					'DateInD' => $row6->DateIn,
					'Price'	=> $row6->Price,
					'assetcondition' => $row6->AssetCondition
				);
			};
		}
		$sql7 = "SELECT tep.Date, tep.Quantity, tep.Nominal, tep.Note as Note, tpm.PenaltyName, tpm.Note as notepenalty 
				FROM tb_employee_penalty tep 
				LEFT JOIN vw_user_account ve2 ON tep.EmployeeID=ve2.UserAccountID 
				LEFT JOIN tb_penalty_main tpm ON tep.PenaltyID=tpm.PenaltyID
				WHERE tep.EmployeeID = ".$id;
		// echo $sql7;	
		$query7 = $this->db->query($sql7);
		$row7 	= $query7->row();


		if (empty($row7)) {
			$show['penalty'][] = array(
					'Date' => "",
					'PenaltyName' => "",
					'Quantity' => "",
					'Nominal' => "",
					'Note' => "",
				);
		} else {
			foreach ($query7->result() as $row7) {
				$show['penalty'][] = array(
					'Date' => $row7->Date,
					'PenaltyName' => $row7->PenaltyName,
					'Quantity' => $row7->Quantity,
					'Nominal' => $row7->Nominal,
					'Note' => $row7->Note,
				);
			};
		}

		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function employee_all()
	{
		$sql = "select * FROM tb_job_divisi order by CompanyID, DivisiID";
		$query 	= $this->db->query($sql);
		$show['divisi'] = $query->result_array();

		$sql = "select c.fullname, jo.LocCode, em.isActive, em.fProfile, ej.LevelName, ej.DivisiID 
				FROM tb_employee_main em  
				LEFT JOIN vw_contact2 c on (c.ContactID = em.ContactID)  
				left join tb_job_level ej on (em.EmployeeID = ej.EmployeeID)  
				LEFT JOIN tb_job_office_location jo on (jo.LocID = em.LocID)  
				WHERE em.EndDate is NULL or em.EndDate ='0000-00-00' and em.isActive = 1 order by LevelName ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['employee'][$row->DivisiID][] = array(
					'image' => $row->fProfile,
					'fullname' => $row->fullname,
					'LevelCode' => $row->LevelName,
					'LocCode' => $row->LocCode
				);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function employee_all2()
	{
		$sql = "select em.*, jo.LocCode, em.isActive, em.fProfile, ej.LevelName ";
		$sql .= "FROM vw_employee3 em ";
		$sql .= "left join vw_employee_job ej on (em.EmployeeID = ej.EmployeeID) ";
		$sql .= "LEFT JOIN tb_job_office_location jo on (jo.LocID = em.LocID) ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
					'image' => $row->fProfile,
					'fullname' => $row->fullname,
					'LevelCode' => $row->LevelName,
					'LocCode' => $row->LocCode
				);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function employee_list()
	{
		$sql = "select em.ContactID, em.EmployeeID, em.NIP, em.BIOID, c.fullname, 
				jo.LocCode, em.isActive, ej.LevelName, ej.LevelCode  
				FROM tb_employee_main em  
				LEFT JOIN vw_contact2 c on (c.ContactID = em.ContactID)  
				left join vw_employee_job ej on (em.EmployeeID = ej.EmployeeID)  
				LEFT JOIN tb_job_office_location jo on (jo.LocID = em.LocID) ";
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$isActive 	= $row->isActive=="1" ? "Active" : "Resign" ;

			$show[] = array(
					'ContactID' => $row->ContactID,
					'EmployeeID' => $row->EmployeeID,
					'nip' => $row->NIP,
					'BIOID' => $row->BIOID,
					'fullname' => $row->fullname,
					'LevelCode' => $row->LevelCode,
					'LocCode' => $row->LocCode,
					'status' => $isActive
				);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function employee_add_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");

		$firstname 	= $this->input->post('firstname'); 
		$middlename	= $this->input->post('middlename'); 
		$lastname 	= $this->input->post('lastname'); 
		$gender 	= $this->input->post('gender'); 
		$religion 	= $this->input->post('religion'); 
		$npwp	 	= $this->input->post('npwp'); 
		
		$titlealamat= $this->input->post('titlealamat'); 
		$alamat 	= $this->input->post('alamat'); 
		$state 		= $this->input->post('state'); 
		$province 	= $this->input->post('province'); 
		$city 		= $this->input->post('city'); 
		$districts 	= $this->input->post('districts'); 
		$pos 		= $this->input->post('pos'); 
		$phone 		= $this->input->post('phone'); 
		$email 		= $this->input->post('email'); 
		
		$familyname 	= $this->input->post('familyname'); 
		$familyjob 		= $this->input->post('familyjob'); 
		$familystatus 	= $this->input->post('familystatus'); 
		$familysex 		= $this->input->post('familysex'); 
		$familyalamat 	= $this->input->post('familyalamat'); 
		$familyphone 	= $this->input->post('familyphone'); 
		$familyemail 	= $this->input->post('familyemail'); 
		
		$birthdate 	= $this->input->post('birthdate'); 
		$joindate 	= $this->input->post('joindate'); 
		$employment = $this->input->post('employment'); 
		$dateemployment	= explode(" - ", $this->input->post('dateemployment')); 
		$officelocation = $this->input->post('officelocation'); 
		$emailemployee 	= $this->input->post('emailemployee'); 
		$maritalstatus 	= $this->input->post('maritalstatus'); 
		$noktp 	= $this->input->post('noktp'); 
		$nip 	= $this->input->post('nip'); 
		$bioid 	= $this->input->post('bioid'); 
		$jobtitle 	= $this->input->post('jobtitle'); 

		// proses upload foto profil
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);  
		if ($_FILES['pp']['name'] != "") {
            $target_dir = "tool/pp/";
            $target_file = $target_dir . $_FILES['pp']['name'];
            if (move_uploaded_file($_FILES["pp"]["tmp_name"], $target_file)) {
				$pp = file_get_contents($target_file, false, stream_context_create($opts));
            } else {
				$pp = file_get_contents(base_url()."tool/profil.png", false, stream_context_create($opts));
            }
        } else {
			$pp = file_get_contents(base_url()."tool/profil.png", false, stream_context_create($opts));
        }

        // insert data contact
		$data_contact = array(
	        'NameFirst' => $firstname,
			'NameMid'	=> $middlename,
			'NameLast' 	=> $lastname,
			'Gender' 	=> $gender,
			'ReligionID' 	=> $religion,
			'NPWP' 	=> $npwp,
	        'NoKTP' => $noktp,
			'isEmployee' 	=> "1", 
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_contact', $data_contact);
		$this->last_query .= "//".$this->db->last_query();
		
		// get last contact inserted
		$sql 		= "select max(ContactID) as ContactID from tb_contact ";
		$getContactID = $this->db->query($sql);
		$row 		= $getContactID->row();
		$ContactID 	= $row->ContactID;

   		// insert address
   		for ($i=0; $i < count($alamat);$i++) { 
   			$data_contact_address = array(
		        'ContactID' => $ContactID,
		        'DetailType' => $titlealamat[$i],
		        'DetailValue' => $alamat[$i],
		        'StateID' => $state[$i],
		        'ProvinceID' => $province[$i],
		        'CityID' => $city[$i],
		        'DistrictsID' => $districts[$i],
		        'PosID' => $pos[$i]
			);
			$this->db->insert('tb_contact_address', $data_contact_address);
			$this->last_query .= "//".$this->db->last_query();
   		};
   		// insert phone
   		for ($i=0; $i < count($phone);$i++) { 
   			$data_contact_phone = array(
		        'ContactID' => $ContactID,
		        'DetailName' => "phone",
		        'DetailValue' => $phone[$i]
			);
			$this->db->insert('tb_contact_detail', $data_contact_phone);
			$this->last_query .= "//".$this->db->last_query();
   		};
   		// insert email
   		for ($i=0; $i < count($email);$i++) { 
   			$data_contact_email = array(
		        'ContactID' => $ContactID,
		        'DetailName' => "email",
		        'DetailValue' => $email[$i]
			);
			$this->db->insert('tb_contact_detail', $data_contact_email);
			$this->last_query .= "//".$this->db->last_query();
   		};

   		// insert data employee
   		$data_employee = array(
	        'ContactID' => $ContactID,
	        'BirthDate' => $birthdate,
	        'JoinDate' => $joindate,
	        'EmploymentID' => $employment,
	        'StartDate' => $dateemployment[0],
	        'LocID' => $officelocation,
	        'Email' => $emailemployee,
	        'MaritalStatus' => $maritalstatus,
	        'NIP' => $nip,
	        'BioID' => $bioid,
	        'CreatedDate' => date("Y-m-d H:i:s"),
	        'CreatedBy' => $this->session->userdata('UserAccountID'),
	        'isActive' => "1",
	        'LastUpdate' => date("Y-m-d H:i:s"),
	        'fProfile' => $pp
		);
		$this->db->insert('tb_employee_main', $data_employee);
		$this->last_query .= "//".$this->db->last_query();

		// get last employee inserted
		$sql 		= "select max(EmployeeID) as EmployeeID from tb_employee_main ";
		$getEmployeeID = $this->db->query($sql);
		$row 		= $getEmployeeID->row();
		$EmployeeID = $row->EmployeeID;

		// insert employee job
		$data_job = array(
	        'LevelID' => $jobtitle,
	        'EmployeeID' => $EmployeeID,
	        'StartDate' => date("Y-m-d")
		);
		$this->db->insert('tb_job_title', $data_job);
		$this->last_query .= "//".$this->db->last_query();

		$data_job_level = array(
	        'EmployeeID' => $EmployeeID
		);
		$this->db->where('LevelID', $jobtitle);
		$this->db->update('tb_job_level', $data_job_level);
		$this->last_query .= "//".$this->db->last_query();

		// insert employee family
		$data_family = array(
	        'EmployeeID' => $EmployeeID,
	        'empFamilyName' => $familyname,
	        'empFamilySex' => $familysex,
	        'empFamilyJob' => $familyjob,
	        'empFamilyStatus' => $familystatus,
	        'empFamilyAddress' => $familyalamat,
	        'empFamilyPhone' => $familyphone,
	        'empFamilyEmail' => $familyemail
		);
		$this->db->insert('tb_employee_family', $data_family);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function employee_edit($id)
	{
    	$this->log_user->log_query($this->last_query);

		$show = array();

		$sql = "select c.*, r.*, es.*, jo.*, jc.*, em.* from tb_employee_main em 
				left join tb_contact c on (em.ContactID = c.ContactID) 
				left join tb_religion r on (c.ReligionID = r.ReligionID) 
				left join tb_job_office_location jo on (em.LocID = jo.LocID) 
				left join tb_job_company jc on (jo.CompanyID = jc.CompanyID) 
				left join tb_employment_status es on (em.EmploymentID = es.EmploymentID) 
				where em.EmployeeID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();	

		// get employee data
		$show['personal'] = array(
			'ContactID' => $row->ContactID,
			'EmployeeID' => $row->EmployeeID,
			'NameFirst' => $row->NameFirst,
			'NameMid' => $row->NameMid,
			'NameLast' => $row->NameLast,
			'BirthDate' => $row->BirthDate,
			'gender' => $row->Gender,
			'religion' => $row->ReligionID,
			'maritalstatus' => $row->MaritalStatus,
			'NIP' => $row->NIP,
			'KTP' => $row->NoKTP,
			'NPWP' => $row->NPWP,
			'BIOID' => $row->BioID,
			'GroupTimeID' => $row->GroupTimeID,
			'JoinDate' => $row->JoinDate,
			'ResignDate' => $row->ResignDate,
			'EmploymentID' => $row->EmploymentID,
			'EmploymentDate' => $row->StartDate." - ".$row->EndDate,
			'LocID' => $row->LocID,
			'Email' => $row->Email
		);

		// get employee family
		$sql2 = "select * from tb_employee_family where EmployeeID = '".$id."'";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			$show['family'] = array(
				'FamilyID' => $row2->empFamilyID,
		        'FamilyName' => $row2->empFamilyName,
		        'FamilySex' => $row2->empFamilySex,
		        'FamilyJob' => $row2->empFamilyJob,
		        'FamilyStatus' => $row2->empFamilyStatus,
		        'FamilyAddress' => $row2->empFamilyAddress,
		        'FamilyPhone' => $row2->empFamilyPhone,
		        'FamilyEmail' => $row2->empFamilyEmail
			);
		};

		// get employee address
		$sql3 = "select ca.*, cas.StateID,  cas.StateName, capr.ProvinceID, capr.ProvinceName, cac.CityID, cac.CityName, cad.DistrictsID, cad.DistrictsName, capo.PosName from tb_contact_address ca ";
		$sql3 .= "left join tb_address_state cas on (ca.StateID = cas.StateID) ";
		$sql3 .= "left join tb_address_province capr on (ca.ProvinceID = capr.ProvinceID) ";
		$sql3 .= "left join vw_city cac on (ca.CityID = cac.CityID) ";
		$sql3 .= "left join tb_address_districts cad on (ca.DistrictsID = cad.DistrictsID) ";
		$sql3 .= "left join tb_address_pos capo on (ca.PosID = capo.PosID) ";
		$sql3 .= "where ca.ContactID = '".$row->ContactID."'";
		// echo $sql3;
		$query3 = $this->db->query($sql3);
		foreach ($query3->result() as $row3) {
			$show['alamat'][] = array(
				'DetailType' => $row3->DetailType,
				'DetailValue' => $row3->DetailValue,
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

		// get phone and email
		$sql4 = "select cd.* from tb_contact_detail cd ";
		$sql4 .= "where cd.ContactID = '".$row->ContactID."'";
		$query4 = $this->db->query($sql4);
		$phone = "";
		$email = "";
		foreach ($query4->result() as $row4) {
			if ($row4->DetailName == "email") {
				$show['email'][] = array(
				  	'DetailValue' => $row4->DetailValue
				);
			} else {
				$show['phone'][] = array(
				  	'DetailValue' => $row4->DetailValue
				);
			}
		};

		// get employee job
		// $sql5 = "select jt.*, jl.* from tb_job_title jt ";
		// $sql5 .= "left join tb_job_level jl on (jt.LevelID = jl.LevelID) ";
		// $sql5 .= "where jt.EmployeeID = '".$id."' order by StartDate";
		// $query5 = $this->db->query($sql5);
		// $job = "";
		// foreach ($query5->result() as $row5) {
		// 	$job .= $row5->LevelName."&nbsp;&nbsp;&nbsp;&nbsp;".$row5->LevelCode." = ".$row5->StartDate." <> ".$row5->EndDate."<br>";
		//   	$show['job'] = array( 'job' => $job, 'LastDate' => $row5->StartDate );
		// };
		$this->log_user->log_query($this->last_query);
	    return $show;
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function employee_edit_act($val)
	{
		$this->log_user->log_query($this->last_query);
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);   

		date_default_timezone_set("Asia/Jakarta");
		$ContactID 	= $this->input->post('contactid'); 
		$EmployeeID	= $this->input->post('employeeid');

		if ($val == "personal") {
			$firstname 	= $this->input->post('firstname'); 
			$middlename	= $this->input->post('middlename'); 
			$lastname 	= $this->input->post('lastname'); 
			$gender 	= $this->input->post('gender'); 
			$religion 	= $this->input->post('religion');

			$birthdate 	= $this->input->post('birthdate'); 
			$joindate 	= $this->input->post('joindate'); 
			$employment = $this->input->post('employment'); 
			$dateemployment	= explode(" - ", $this->input->post('dateemployment')); 
			$officelocation = $this->input->post('officelocation'); 
			$emailemployee 	= $this->input->post('emailemployee'); 
			$maritalstatus 	= $this->input->post('maritalstatus'); 
			$noktp 	= $this->input->post('noktp'); 
			$npwp 	= $this->input->post('npwp'); 
			$nip 	= $this->input->post('nip'); 
			$bioid 	= $this->input->post('bioid'); 
			$AttendanceGroupTime 	= $this->input->post('AttendanceGroupTime'); 

			$data_contact = array(
		        'NameFirst' => $firstname,
				'NameMid'	=> $middlename,
				'NameLast' 	=> $lastname,
				'Gender' 	=> $gender,
				'ReligionID' => $religion,
				'NoKTP' => $noktp,
				'NPWP' => $npwp,
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->where('ContactID', $ContactID);
			$this->db->update('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();

			$data_employee = array(
		        'BirthDate' => $birthdate,
		        'JoinDate' => $joindate,
		        'EmploymentID' => $employment,
		        'StartDate' => $dateemployment[0],
		        'EndDate' => $dateemployment[1],
		        'LocID' => $officelocation,
		        'Email' => $emailemployee,
		        'MaritalStatus' => $maritalstatus,
		        'NIP' => $nip,
		        'BioID' => $bioid,
		        'GroupTimeID' => $AttendanceGroupTime,
		        'LastUpdate' => date("Y-m-d H:i:s"),
		        'LastUpdateBy' => $this->session->userdata('UserAccountID')

			);
			$this->db->where('EmployeeID', $EmployeeID);
			$this->db->update('tb_employee_main', $data_employee);
			$this->last_query .= "//".$this->db->last_query();

		} else if ($val == "address") {
			// delete data lama
			$this->db->where('ContactID', $ContactID);
			$this->db->delete('tb_contact_address');
			$this->last_query .= "//".$this->db->last_query();
			$this->db->where('ContactID', $ContactID);
			$this->db->delete('tb_contact_detail');
			$this->last_query .= "//".$this->db->last_query();

			$titlealamat 	= $this->input->post('titlealamat'); 
			$alamat 	= $this->input->post('alamat'); 
			$state 		= $this->input->post('state'); 
			$province 	= $this->input->post('province'); 
			$city 		= $this->input->post('city'); 
			$districts 	= $this->input->post('districts'); 
			$pos 		= $this->input->post('pos'); 
			$phone 		= $this->input->post('phone'); 
			$email 		= $this->input->post('email');

			// insert data alamat baru
			for ($i=0; $i < count($alamat);$i++) { 
	   			$data_contact_address = array(
			        'ContactID' => $ContactID,
			        'DetailType' => $titlealamat[$i],
			        'DetailValue' => $alamat[$i],
			        'StateID' => $state[$i],
			        'ProvinceID' => $province[$i],
			        'CityID' => $city[$i],
			        'DistrictsID' => $districts[$i],
			        'PosID' => $pos[$i]
				);
				$this->db->insert('tb_contact_address', $data_contact_address);
				$this->last_query .= "//".$this->db->last_query();
	   		};

			// insert data phone dan email baru
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

		} else if ($val == "file") {
			// insert file
			set_time_limit(0);
			ini_set('upload_max_filesize', '500M');
			ini_set('post_max_size', '500M');
			ini_set('max_input_time', 4000); // Play with the values
			ini_set('max_execution_time', 4000); // Play with the values
			$limit = 500000;
			if ($_FILES['pp']['name'] != "" && $_FILES['pp']['size'] < $limit) { //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['pp']['name'];

				// if ( ! $this->upload->do_upload('pp')){    
			 //      $error = $this->upload->display_errors();
			 //      echo $error;
			 //    }
				// $pp = file_get_contents($target_file); //convert ke blob
				// $data_file['fProfile'] = $pp;

	            if (move_uploaded_file($_FILES["pp"]["tmp_name"], $target_file)) {
					$pp = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fProfile'] = $pp;
	            }
	        }
	        if ($_FILES['cv']['name'] != "" && $_FILES['cv']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['cv']['name'];
	            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
					$cv = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fCV'] = $cv;
	            }
	        }
	        if ($_FILES['appraisal']['name'] != "" && $_FILES['appraisal']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['appraisal']['name'];
	            if (move_uploaded_file($_FILES["appraisal"]["tmp_name"], $target_file)) {
					$appraisal = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fAppraisal'] = $appraisal;
	            }
	        }
	        if ($_FILES['ijazah']['name'] != "" && $_FILES['ijazah']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['ijazah']['name'];
	            if (move_uploaded_file($_FILES["ijazah"]["tmp_name"], $target_file)) {
					$ijazah = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fIjazah'] = $ijazah;
	            }
	        }
	        if ($_FILES['ktp']['name'] != "" && $_FILES['ktp']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['ktp']['name'];
	            if (move_uploaded_file($_FILES["ktp"]["tmp_name"], $target_file)) {
					$ktp = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fKtp'] = $ktp;
	            }
	        }
	        if ($_FILES['ksk']['name'] != "" && $_FILES['ksk']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['ksk']['name'];
	            if (move_uploaded_file($_FILES["ksk"]["tmp_name"], $target_file)) {
					$ksk = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fKsk'] = $ksk;
	            }
	        }
	        if ($_FILES['skck']['name'] != "" && $_FILES['skck']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['skck']['name'];
	            if (move_uploaded_file($_FILES["skck"]["tmp_name"], $target_file)) {
					$skck = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fSkck'] = $skck;
	            }
	        }
	        if ($_FILES['domisili']['name'] != "" && $_FILES['domisili']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['domisili']['name'];
	            if (move_uploaded_file($_FILES["domisili"]["tmp_name"], $target_file)) {
					$domisili = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fDomisili'] = $domisili;
	            }
	        }
	        if ($_FILES['referensi']['name'] != "" && $_FILES['referensi']['size'] < $limit) {  //copy file ke server
	            $target_dir = "tool/pp/";
	            $target_file = $target_dir . $_FILES['referensi']['name'];
	            if (move_uploaded_file($_FILES["referensi"]["tmp_name"], $target_file)) {
					$referensi = file_get_contents($target_file, false, stream_context_create($opts)); //convert ke blob
					$data_file['fReferensi'] = $referensi;
	            }
	        }

	        if (isset($data_file)) {
	        	$this->db->where('EmployeeID', $EmployeeID);
				$this->db->update('tb_employee_main', $data_file);
				$this->last_query .= "//".$this->db->last_query();
	        }
	        array_map('unlink', glob("tool/pp/*"));

		} else if ($val == "family") {
			// hapus data lama
			$this->db->where('EmployeeID', $EmployeeID);
			$this->db->delete('tb_employee_family');
			$this->last_query .= "//".$this->db->last_query();

			// insert data baru
			$familyname 	= $this->input->post('familyname'); 
			$familyjob 		= $this->input->post('familyjob'); 
			$familystatus 	= $this->input->post('familystatus'); 
			$familysex 		= $this->input->post('familysex'); 
			$familyalamat 	= $this->input->post('familyalamat'); 
			$familyphone 	= $this->input->post('familyphone'); 
			$familyemail 	= $this->input->post('familyemail'); 
			$data_family = array(
		        'EmployeeID' => $EmployeeID,
		        'empFamilyName' => $familyname,
		        'empFamilySex' => $familysex,
		        'empFamilyJob' => $familyjob,
		        'empFamilyStatus' => $familystatus,
		        'empFamilyAddress' => $familyalamat,
		        'empFamilyPhone' => $familyphone,
		        'empFamilyEmail' => $familyemail
			);
			$this->db->insert('tb_employee_family', $data_family);
			$this->last_query .= "//".$this->db->last_query();

		} else if ($val == "jobtitle") {
			// update data job employee
			$datejob2	= $this->input->post('datejob2'); 
			$datejob	= $this->input->post('datejob'); 
			$jobtitle 	= $this->input->post('jobtitle'); 

			$data_job = array(
		        'EndDate' => $datejob
			);
			$this->db->where('EmployeeID',$EmployeeID);
			$this->db->where('StartDate',$datejob2);
			$this->db->update('tb_job_title',$data_job);
			$this->last_query .= "//".$this->db->last_query();

			$data_job2 = array(
		        'LevelID' => $jobtitle,
		        'EmployeeID' => $EmployeeID,
		        'StartDate' => $datejob
			);
			$this->db->insert('tb_job_title', $data_job2);
			$this->last_query .= "//".$this->db->last_query();
			
		} else if ($val == "resign") {
			// update data resign
			$resigndate	= $this->input->post('resigndate'); 
			$data_employee = array(
		        'ResignDate' => $resigndate,
		        'EndDate' => $resigndate,
		        'isActive' => "0",
			);
			$this->db->where('EmployeeID',$EmployeeID);
			$this->db->update('tb_employee_main',$data_employee);
			$this->last_query .= "//".$this->db->last_query();

		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function employee_view_file($val)
	{
		$isi 	= explode("_", $val); 
		$id 	= $isi[0]; 
		$file 	= $isi[1]; 

		$sql = "select * from tb_employee_main where EmployeeID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();

		if ($file == "cv") {
			$content = $row->fCV;
		} else if ($file == "appraisal") {
			$content = $row->fAppraisal;
		} else if ($file == "ijazah") {
			$content = $row->fIjazah;
		} else if ($file == "ktp") {
			$content = $row->fKtp;
		} else if ($file == "ksk") {
			$content = $row->fKsk;
		} else if ($file == "skck") {
			$content = $row->fSkck;
		} else if ($file == "domisili") {
			$content = $row->fDomisili;
		} else if ($file == "referensi") {
			$content = $row->fReferensi;
		}

		header('Content-type: application/pdf');
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		header("Content-Disposition: inline;filename='document.pdf'");
		header("Content-length: ".strlen($content));
		echo $content;
		exit();
		$this->log_user->log_query($this->last_query);
	}
	function employee_import_excel($data)
	{
		$this->db->trans_start();
		date_default_timezone_set("Asia/Jakarta");
		foreach ($data as $key => $list) { 
			// insert data contact
			$data_contact = array(
				'NameFirst' => empty($list['NameFirst'])? '' : $list['NameFirst'],
				'NameMid' => empty($list['NameMid'])? '' : $list['NameMid'],
				'NameLast' => empty($list['NameLast'])? '' : $list['NameLast'],
				'Gender' => empty($list['Gender'])? '' : $list['Gender'],
				'ReligionID' => empty($list['ReligionID'])? '' : $list['ReligionID'],
				'NPWP' => empty($list['NPWP'])? '' : $list['NPWP'],
				'NoKTP' => empty($list['NoKTP'])? '' : $list['NoKTP'],
				'isEmployee' 	=> "1", 
				'InputDate' => date("Y-m-d H:i:s"),
				'InputBy' => $this->session->userdata('UserAccountID'),
				'ModifiedDate' => date("Y-m-d H:i:s"),
				'ModifiedBy' => $this->session->userdata('UserAccountID'),
			);
			$this->db->insert('tb_contact', $data_contact);
			$this->last_query .= "//".$this->db->last_query();
			
			// get last contact inserted
			$sql 		= "select max(ContactID) as ContactID from tb_contact ";
			$getContactID = $this->db->query($sql);
			$row 		= $getContactID->row();
			$ContactID 	= $row->ContactID;

			// insert address
			$data_contact_address = array(
				'ContactID' => $ContactID,
				'DetailType' => empty($list['DetailType'])? '' : $list['DetailType'],
				'DetailValue' => empty($list['DetailValue'])? '' : $list['DetailValue'],
				'StateID' => empty($list['StateID'])? '' : $list['StateID'],
				'ProvinceID' => empty($list['ProvinceID'])? '' : $list['ProvinceID'],
				'CityID' => empty($list['CityID'])? '' : $list['CityID'],
				'DistrictsID' => empty($list['DistrictsID'])? '' : $list['DistrictsID'],
				'PosID' => empty($list['PosID'])? '' : $list['PosID'],
			);
			$this->db->insert('tb_contact_address', $data_contact_address);
			$this->last_query .= "//".$this->db->last_query();

			// insert phone
			$data_contact_phone = array(
				'ContactID' => $ContactID,
				'DetailName' => empty($list['DetailNamePhone'])? '' : $list['DetailNamePhone'],
				'DetailValue' => empty($list['DetailValuePhone'])? '' : $list['DetailValuePhone'],
			);
			$this->db->insert('tb_contact_detail', $data_contact_phone);
			$this->last_query .= "//".$this->db->last_query();
			// insert email
			$data_contact_email = array(
				'ContactID' => $ContactID,
				'DetailName' => empty($list['DetailNameEmail'])? '' : $list['DetailNameEmail'],
				'DetailValue' => empty($list['DetailValueEmail'])? '' : $list['DetailValueEmail'],
			);
			$this->db->insert('tb_contact_detail', $data_contact_email);
			$this->last_query .= "//".$this->db->last_query();

			// insert data employee
			$data_employee = array(
				'ContactID' => $ContactID,
				'BirthDate' => empty($list['BirthDate'])? '' : $list['BirthDate'],
				'JoinDate' => empty($list['JoinDate'])? '' : $list['JoinDate'],
				'EmploymentID' => empty($list['EmploymentID'])? '' : $list['EmploymentID'],
				'StartDate' => empty($list['StartDate'])? '' : $list['StartDate'],
				'LocID' => empty($list['LocID'])? '' : $list['LocID'],
				'Email' => empty($list['Email'])? '' : $list['Email'],
				'MaritalStatus' => empty($list['MaritalStatus'])? '' : $list['MaritalStatus'],
				'NIP' => empty($list['NIP'])? '' : $list['NIP'],
				'BioID' => empty($list['BioID'])? '' : $list['BioID'],
				'CreatedDate' => date("Y-m-d H:i:s"),
				'CreatedBy' => $this->session->userdata('UserAccountID'),
				'isActive' => "1",
				'LastUpdate' => date("Y-m-d H:i:s"),
			);
			$this->db->insert('tb_employee_main', $data_employee);
			$this->last_query .= "//".$this->db->last_query();

			// get last employee inserted
			$sql 		= "select max(EmployeeID) as EmployeeID from tb_employee_main ";
			$getEmployeeID = $this->db->query($sql);
			$row 		= $getEmployeeID->row();
			$EmployeeID = $row->EmployeeID;
 
			// insert employee family
			$data_family = array(
				'EmployeeID' => $EmployeeID,
				'empFamilyName' => empty($list['empFamilyName'])? '' : $list['empFamilyName'],
				'empFamilySex' => empty($list['empFamilySex'])? '' : $list['empFamilySex'],
				'empFamilyJob' => empty($list['empFamilyJob'])? '' : $list['empFamilyJob'],
				'empFamilyStatus' => empty($list['empFamilyStatus'])? '' : $list['empFamilyStatus'],
				'empFamilyAddress' => empty($list['empFamilyAddress'])? '' : $list['empFamilyAddress'],
				'empFamilyPhone' => empty($list['empFamilyPhone'])? '' : $list['empFamilyPhone'],
				'empFamilyEmail' => empty($list['empFamilyEmail'])? '' : $list['empFamilyEmail'],
			);
			$this->db->insert('tb_employee_family', $data_family);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function employee_list_active()
	{
		$sql = "SELECT em.ContactID, em.EmployeeID, em.NIP, em.BIOID, c.fullname,
				jo.LocCode, em.isActive, ej.LevelName, ej.LevelCode
				FROM tb_employee_main em
				LEFT JOIN vw_contact2 c on (c.ContactID = em.ContactID)
				left join vw_employee_job ej on (em.EmployeeID = ej.EmployeeID)
				LEFT JOIN tb_job_office_location jo on (jo.LocID = em.LocID) 
				Where em.isActive=1 ";
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$isActive 	= $row->isActive=="1" ? "Active" : "Resign" ;

			$show[] = array(
					'ContactID' => $row->ContactID,
					'EmployeeID' => $row->EmployeeID,
					'nip' => $row->NIP,
					'BIOID' => $row->BIOID,
					'fullname' => $row->fullname,
					'LevelCode' => $row->LevelCode,
					'LocCode' => $row->LocCode,
					'status' => $isActive
				);
		};
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function employee_penalty_list()
	{
		$show   = array();
		$show['info_filter'] = "";
		$EmployeeID = $this->session->userdata('EmployeeID');
		$MenuList = $this->session->userdata('MenuList');

		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('d-m-Y');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('d-m-Y');

		$sql = "SELECT tep.EmployeeID, fullname, em.NIP, ej.LevelName, MIN(tpm.PenaltyID) AS PenaltyID, Max(tpm.Note) AS Note,
				COUNT(tep.EmployeeID) as penalty, SUM(tep.Nominal) AS Nominal
				FROM tb_employee_penalty tep
				LEFT JOIN tb_penalty_main tpm ON tep.PenaltyID = tpm.PenaltyID
				LEFT JOIN tb_employee_main em ON tep.EmployeeID=em.EmployeeID
				LEFT JOIN vw_employee_job ej ON em.EmployeeID = ej.EmployeeID
				LEFT JOIN vw_user_account ve2 ON tep.EmployeeID=ve2.UserAccountID ";
		if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "") {
			$sql .= " WHERE (Date between '".$datestart."' AND '".$dateend."') ";
			$show['info_filter'] .= "Filter Date : ".$datestart." <> ".$dateend."<br>";
		} else {
			$sql .= " WHERE MONTH(Date)=MONTH(CURRENT_DATE()) AND YEAR(Date)=YEAR(CURRENT_DATE()) ";
		}
		if (in_array("report_employee_penalty_view_all", $MenuList)) {
			$sql .= " ";
		} else {
			$sql .= " AND tep.EmployeeID =".$EmployeeID;
		}
		$sql .= " Group by tep.EmployeeID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main'][] = array(
				'EmployeeID' => $row->EmployeeID,
				'PenaltyID' => $row->PenaltyID,
				'NIP' => $row->NIP,
				'fullname' => $row->fullname,
				'LevelName' => $row->LevelName,
				'penalty' => $row->penalty,
				'Nominal' => $row->Nominal,
				'Note' => $row->Note,
				'datestart' => $datestart,
				'dateend' => $dateend,
			);
		};
		return $show;
	}
	function employee_penalty_detail()
	{
		$show   = array();
		$EmployeeID = $_REQUEST['id'];
		$datestart = isset($_REQUEST['datestart']) ? date('Y-m-01', strtotime($_REQUEST['datestart'])) : date('Y-m-01');
		$dateend = isset($_REQUEST['dateend']) ? date('Y-m-t', strtotime($_REQUEST['dateend'])) : date('Y-m-d');

		$sql = "SELECT tep.EmployeeID, tep.Nominal, tep.PenaltyOrderID , tep.Quantity as Poin , tpm.Quantity , tep.Date, tpm.PenaltyName, tpm.PenaltyType, tep.Punisher, tep.Link, tep.Note, ve2.fullname, tpm.Note as Potongan		 
				FROM tb_employee_penalty tep
				LEFT JOIN tb_penalty_main tpm ON tep.PenaltyID =tpm.PenaltyID
				LEFT JOIN vw_user_account ve2 ON ve2.UserAccountID=tep.Punisher
				WHERE (Date between '".$datestart."' AND '".$dateend."')
				AND tep.EmployeeID = ".$EmployeeID."
				";
		// echo $sql;		
		$query 	= $this->db->query($sql);
		$show 	= $query->result_array();
		return $show;
	}
	function employee_penalty($id)
	{
		$show = array();
		$show['id'] = $id;
		$sql = "SELECT EmployeeID, fullname FROM vw_employee2 WHERE EmployeeID = ".$id;
		// echo $sql;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			
			$show[] = array(
					'fullname' => $row->fullname,
					'EmployeeID' => $row->EmployeeID,
				);
		};
		$sql4 = "SELECT Quantity FROM tb_penalty_main WHERE PenaltyType = 'pnt'";
		$query4 = $this->db->query($sql4);
		$row 	= $query4->row();
		$point = $row->Quantity;

		$sql2 = "SELECT PenaltyID, PenaltyName, Note, (Quantity*".$point.") as Nominal FROM tb_penalty_main where PenaltyType like 'adm'";
		// echo $sql2;
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			$show['penalty'][] = array(
				'PenaltyID' => $row2->PenaltyID,
				'PenaltyName' => $row2->PenaltyName,
				'Nominal' => $row2->Nominal,
				'Note' => $row2->Note,
			);
		};
		$sql3 = "SELECT EmployeeID, fullname FROM vw_employee2 where isActive=1 AND EmployeeID!=1 ";
		$query3 = $this->db->query($sql3);
		foreach ($query3->result() as $row3) {
			$show['employee'][] = array(
				'fullname' => $row3->fullname,
				'EmployeeID' => $row3->EmployeeID,
			);
		};
		$sql 	= "SELECT max(No) as no FROM tb_employee_penalty WHERE  EmployeeID=".$id;
		$query	= $this->db->query($sql);
		$row 		= $query->row();
		if(!empty($row->no)){
			$show['no'] = $row->no;
			$show['EmployeeID'] = $id;
		} else {
			$show['no'] = 0;
			$show['EmployeeID'] = $id;
		}
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function employee_penalty_act()
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Employee = $this->input->get_post('Employee');
		$Date = $this->input->get_post('date');
		$Code = $this->input->get_post('code');
		$No = $this->input->get_post('no');
		$PenaltyType = $this->input->get_post('type');
		$Nominal = $this->input->get_post('nominal');
		$Note = $this->input->get_post('note');

		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
			'No' => $No,
			'PenaltyOrderID' => $Code,
			'EmployeeID' => $Employee,
			'PenaltyID' => $PenaltyType,
			'Date' => $Date,
			'Nominal' => $Nominal,
			'Quantity' => '1',
			'Punisher' => $EmployeeID,
			'Note' => $Note,
			'Month' => $Month,
		);
		$this->db->insert('tb_employee_penalty', $data);

		$this->db->trans_complete();
	}	
	function employee_penalty_point($id)
	{
		$show = array();
		$show['id'] = $id;
		$sql = "SELECT EmployeeID, fullname FROM vw_employee2 WHERE EmployeeID = ".$id;
		// echo $sql;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			
			$show[] = array(
					'fullname' => $row->fullname,
					'EmployeeID' => $row->EmployeeID,
				);
		};

		$sql2 = "SELECT PenaltyID, PenaltyName, Note FROM tb_penalty_main where PenaltyType like 'pnt'";
		$query2 = $this->db->query($sql2);
		foreach ($query2->result() as $row2) {
			$show['penalty'][] = array(
				'PenaltyID' => $row2->PenaltyID,
				'PenaltyName' => $row2->PenaltyName,
				'Note' => $row2->Note,
			);
		};
		$sql3 = "SELECT EmployeeID, fullname FROM vw_employee2 where isActive=1 AND EmployeeID!=1 ";
		$query3 = $this->db->query($sql3);
		foreach ($query3->result() as $row3) {
			$show['employee'][] = array(
				'fullname' => $row3->fullname,
				'EmployeeID' => $row3->EmployeeID,
			);
		};
		$sql 		= "SELECT max(No) as no FROM tb_employee_penalty WHERE  EmployeeID=".$id;
		$query	= $this->db->query($sql);
		$row 	= $query->row();
		if(!empty($row->no)){
			$show['no'] = $row->no;
			$show['EmployeeID'] = $id;
		} else {
			$show['EmployeeID'] = $id;
			$show['no'] = 0;
		}
		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function employee_penalty_point_act()
	{
		$this->db->trans_start();
		$EmployeeID = $this->session->userdata('EmployeeID');
		$Employee = $this->input->get_post('Employee'); 
		$Quantity = $this->input->get_post('quantity');
		$Date = $this->input->get_post('date'); 
		$Code = $this->input->get_post('code');
		$No = $this->input->get_post('no');
		$Nominal = $this->input->get_post('nominal'); 
		$Note = $this->input->get_post('note');

		$date = date('Y-m-d');
		$Month = date('Y-m');
		$datetime = date('Y-m-d H:i:s');

		$data = array(
					'No' => $No,
					'PenaltyOrderID' => $Code,
					'EmployeeID' => $Employee,
					'PenaltyID' => '7',
					'Date' => $Date,
					'Nominal' => $Nominal,
					'Quantity' => $Quantity,
					'Punisher' => $EmployeeID,
					'Note' => $Note,
					'Month' => $Month,
				);
		$this->db->insert('tb_employee_penalty', $data);

		$this->db->trans_complete();
	}
	function employee_overtime()
	{
		$show   = array();
		$show['info_filter'] = "";
		$OTDate = $this->input->get_post('filterstart');
		$OTDate2= $this->input->get_post('filterend');

		if ($OTDate && $OTDate2 != "") {
			$OTDate = date_create($this->input->get_post('filterstart'));
			$OTDate2 = date_create($this->input->get_post('filterend'));
			$OTDate = date_format($OTDate, "Y-m-d");
			$OTDate2 = date_format($OTDate2, "Y-m-t");

			$sqlOTDate = "WHERE (teo.OverTimeDate between '".$OTDate."' AND '".$OTDate2."') ";
		} else {
			$sqlOTDate = "WHERE MONTH(OverTimeDate)=MONTH(CURRENT_DATE()) AND YEAR(OverTimeDate)=YEAR(CURRENT_DATE()) ";
		}

		$sql = "SELECT teo.OTID, teo.EmployeeID,teo.OverTimeDate, teo.TimeStart, teo.TimeEnd, teo.Job, teo.Qty, ve4.fullname, teo.isApprove
				FROM tb_employee_overtime teo
				LEFT JOIN vw_employee4 ve4 ON ve4.EmployeeID=teo.EmployeeID
				".$sqlOTDate;

		$EmployeeID = array( $this->session->userdata('UserAccountID') );
		$MenuList = $this->session->userdata('MenuList');

		if (in_array("employee_overtime", $MenuList)) {
			$sql .= " ";
		} elseif (in_array("employee_overtime_all", $MenuList)) {
			$sql .= " ";
		}
			$sql .= "order by OTID Asc ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function employee_overtime_add()
	{
		$UserAccountID = $this->session->userdata('UserAccountID');
		$sql 	= "SELECT vua.EmployeeID, vua.fullname, tjl.DivisiID,
						tjl.LevelCode,
						tjl.LevelParent 
					FROM vw_user_account vua 
					LEFT JOIN vw_employee4 ve4 on ve4.EmployeeID=vua.EmployeeID
					LEFT JOIN tb_job_level tjl on tjl.EmployeeID=vua.EmployeeID
					WHERE UserAccountID=".$UserAccountID;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		// foreach ($query->result() as $row) {
			$show['employees'] = array(
				'EmployeeID' => $row->EmployeeID,
				'fullname' => $row->fullname,
				'LevelCode' => $row->LevelCode,
				'LevelParent' => $row->LevelParent
			);
		// };
		$sql 	= "SELECT
						ve.EmployeeID,
						ve.fullname,
						tjl.DivisiID,
						tjl.LevelCode,
						tjl.LevelParent
					FROM
						vw_employee4 ve
					LEFT JOIN tb_job_level tjl on ve.EmployeeID=tjl.EmployeeID
					WHERE
						isActive = 1
					AND ve.EmployeeID NOT IN (1, 14, 61)
					AND tjl.LevelID not in (1,3)
					GROUP BY ve.EmployeeID
					";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['employee'][] = array(
				'EmployeeID' => $row->EmployeeID,
				'fullname' => $row->fullname,
				'LevelCode' => $row->LevelCode,
				'LevelParent' => $row->LevelParent
			);
		};
		// echo json_encode($show);
	    return $show;
	}
	function employee_overtime_add_act()
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$EmployeeID = $this->input->get_post('employee');
		$OverTimeDate = $this->input->get_post('date');
		$TimeStart = $this->input->get_post('time1');
		$TimeEnd = $this->input->get_post('time2');
		$Job = $this->input->get_post('job');
		$Volume = $this->input->get_post('volume');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');
		$otdate=explode(" ", $TimeStart);
		$data = array(
			'EmployeeID' => $EmployeeID,
			'OverTimeDate' => $otdate[0],
			'TimeStart' => $TimeStart,
			'TimeEnd' => $TimeEnd,
			'Job' => $Job,
			'Qty' => $Volume,
			'InputDate' => $datetime,
			'InputBy' => $this->session->userdata('UserAccountID'),
		);
		// echo json_encode($data);
		$this->db->insert('tb_employee_overtime', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql="SELECT max(OTID) as OTID from tb_employee_overtime";
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();

		$OTID=$row->OTID;
		// $SOID 	= $this->input->post('SOID');
		$show   = array();
		// $this->employee_overtime_submission($SOID);
		// $sql 	= "SELECT sd.SOID, SUM(sd.PriceTotal) AS PriceTotal, sm.SOTotalBefore
		// 			FROM tb_so_detail sd
		// 			LEFT JOIN tb_so_main sm ON sm.SOID=sd.SOID
		// 			WHERE sd.SOID = ".$SOID."
		// 			GROUP BY sd.SOID";
		// $getrow	= $this->db->query($sql);
		// $row 	= $getrow->row();
		// $PriceTotal = $row->PriceTotal ;
		// $SOTotalBefore = $row->SOTotalBefore ;
		// if ($PriceTotal != $SOTotalBefore) {
		// 	$show['note'] = "Harga Total Tidak Sesuai, silahkan di edit terlebih dahulu !";
		// 	$show['result'] = "error";
		// } else {
		// 	$sql 	= "SELECT * from tb_so_main where SOID = ".$SOID;
		// 	$getrow	= $this->db->query($sql);
		// 	$rowso 	= $getrow->row();

		// 	$CustomerID 	= $rowso->CustomerID ;
		// 	$SOCategory 	= $rowso->SOCategory ;
		// 	$INVCategory 	= $rowso->INVCategory ;
		// 	$SOPaymentTerm 	= $rowso->PaymentTerm ;
		// 	$SOTotal 	= $rowso->SOTotal ;
		// 	$PaymentWay = $rowso->PaymentWay ;
		// 	$SOStatus = $rowso->SOStatus ;

		// 	if ($SOStatus == 2) {
		// 		$sql 	= "SELECT * from tb_customer_main where CustomerID=".$CustomerID;
		// 		$getrow	= $this->db->query($sql);
		// 		$rowC 	= $getrow->row();
		// 		$PaymentTerm = $rowC->PaymentTerm ;
		// 		$CreditLimit = $rowC->CreditLimit ;

		// 		$this->load->model('model_finance', 'finance');
		// 		$debt = $this->finance->get_customer_debt2($CustomerID,$SOID);
		// 		$creditavailable = $CreditLimit - $debt;

		// 		$this->sales_order_approval_submission($SOID, $SOCategory, $INVCategory, $PaymentTerm, $SOPaymentTerm, "add", $creditavailable, $SOTotal, $PaymentWay, $CustomerID);
				$this->approve_employee_overtime_implementation($OTID);

		// 		$datamain = array(
		// 			// 'SODate' => date('Y-m-d'),
		// 			'SOStatus' => 1,
		// 		);
		// 		$this->db->where('SOID', $SOID);
		// 		$this->db->update('tb_so_main', $datamain);
		// 		$this->last_query .= "//".$this->db->last_query();
		// 	}
		// echo $OTID;
		// echo json_encode($show);


		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function employee_overtime_edit()
	{
		$OTID = $this->input->get_post('OTID');
		$sql 	= "SELECT *,vetjl.EmployeeID,
						vetjl.fullname,
						vetjl.DivisiID,
						vetjl.LevelCode,
						vetjl.LevelParent 
					FROM tb_employee_overtime teo
					LEFT JOIN (SELECT ve.EmployeeID, ve.fullname, tjl.DivisiID, tjl.LevelCode, tjl.LevelParent
		 			FROM
		 				vw_employee4 ve
		 			LEFT JOIN tb_job_level tjl on ve.EmployeeID=tjl.EmployeeID
		 			WHERE
		 				isActive = 1 
		 			AND ve.EmployeeID NOT IN (1, 14, 61)
		 			AND tjl.LevelID not in (1,3)) vetjl on vetjl.EmployeeID=teo.EmployeeID
					Where teo.OTID=$OTID
					GROUP BY teo.EmployeeID";

		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
		
		// echo json_encode($show);

		$sql 	= "SELECT
						ve.EmployeeID,
						ve.fullname,
						tjl.DivisiID,
						tjl.LevelCode,
						tjl.LevelParent
					FROM
						vw_employee4 ve
					LEFT JOIN tb_job_level tjl on ve.EmployeeID=tjl.EmployeeID
					WHERE
						isActive = 1
					AND ve.EmployeeID NOT IN (1, 14, 61)
					AND tjl.LevelID not in (1,3)
					GROUP BY ve.EmployeeID
					";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['employee'][] = array(
				'EmployeeID' => $row->EmployeeID,
				'fullname' => $row->fullname,
				'LevelCode' => $row->LevelCode,
				'LevelParent' => $row->LevelParent
			);
		};
	    return $show;
	}
	function employee_overtime_edit_act()
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$OTID = $this->input->get_post('OTID');
		$EmployeeID = $this->input->get_post('employee');
		$OverTimeDate = $this->input->get_post('date');
		$TimeStart = $this->input->get_post('time1');
		$TimeEnd = $this->input->get_post('time2');
		$Job = $this->input->get_post('job');
		$Volume = $this->input->get_post('volume');
		$date = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');
		$otdate=explode(" ", $TimeStart);
		$data = array(
			'EmployeeID' => $EmployeeID,
			'OverTimeDate' => $otdate[0],
			'TimeStart' => $TimeStart,
			'TimeEnd' => $TimeEnd,
			'Job' => $Job,
			'Qty' => $Volume,
			'InputDate' => $datetime,
			'InputBy' => $this->session->userdata('UserAccountID'),
		);
		echo json_encode($data);
		$this->db->where('OTID', $OTID);
		$this->db->update('tb_employee_overtime', $data);
		$this->last_query .= "//".$this->db->last_query();

		// $sql 		= "SELECT max(OTID) as OTID from tb_employee_overtime ";
		// $getOTID 	= $this->db->query($sql);
		// $row 		= $getOTID->row();
		// $OTID 		= $row->OTID;

		// // get actor approval
		// $sql 		= "SELECT NotifUserAccountID from tb_notif_main tnm
		// 			LEFT JOIN tb_notif_user tnu ON tnm.NotifID=tnu.NotifID
		// 			where NotifName='overtime' AND NotifUserAccountID=".$UserAccountID;
		// $getUser 	= $this->db->query($sql);
		// $row 		= $getUser->row();
		// if(empty($row->NotifUserAccountID)){
		// 	$sql3 	= "SELECT EmployeeID, PIC from tb_employee_overtime_list teol ";
		// 		$query3 	= $this->db->query($sql3);
		// 		$row3 	= $query3->row();
		// 		$PIC=$row3->PIC;
		// 		$EmployeeID=$row3->EmployeeID;
		// 		$PICArr= array($PIC);
		// 		$EmployeeIDArr = array($EmployeeID);
		// 		$this->load->model('model_notification');
		// 		$this->model_notification->insert_notif('overtime', 'Overtime', 'EmployeeID', $EmployeeIDArr, 'replace', $PICArr );
		// } else {

		// }
		//Ke Approval

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function employee_overtime_cancel()
	{
		$this->db->trans_start();
		$OTID = $this->input->post('OTID');
		$this->db->where('OTID', $OTID);
		$this->db->delete('tb_employee_overtime');
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	// function get_total_overtime($ID)
	// {
	// 	$sql 	= "SELECT
	// 				SEC_TO_TIME( SUM(time_to_sec(teo.TimeEnd-teo.TimeStart)))
	// 				As timeSum
	// 				FROM
	// 				tb_employee_overtime teo
	// 				WHERE EmployeeID=672 ";
	// 				echo "dfsdf";
	// 	$query 	= $this->db->query($sql);
	// 	$show   = $query->result_array();
	// }
	function get_quantity()
	{
		$quantity = $this->input->get_post('quantity');
		$sql = "SELECT Quantity FROM tb_penalty_main WHERE PenaltyType like 'pnt' ";
		// echo $sql;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$Nominal=$row->Quantity;
			$Total=$Nominal*$quantity;
			$show= array(
					'Quantity' => $Total,
				);
		};
		$show = array_reverse($show);
		echo json_encode($show);

		$this->log_user->log_query($this->last_query);
		return $show;
	}
	function get_poin()
	{
		$poin = $this->input->get_post('poin');
		$sql = "SELECT (Quantity*20000) as Nominal FROM tb_penalty_main WHERE PenaltyID =".$poin;
		// echo $sql;
		$query 	= $this->db->query($sql);

		foreach ($query->result() as $row) {
			$Nominal=$row->Nominal;
			$show= array(
				'Nominal' => $Nominal,
			);
		};
		$show = array_reverse($show);
		echo json_encode($show);

		$this->log_user->log_query($this->last_query);
		return $show;
	}
	
// =====================================================================
	function employee_attendance_excel($data)
	{
		$this->db->trans_start();

		$this->db->insert_batch('tb_employee_attendance_record', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql = "DELETE FROM tb_employee_attendance_record
				WHERE OrderID NOT IN (
					SELECT OrderID FROM (
						SELECT MIN(OrderID) AS OrderID
						FROM tb_employee_attendance_record
						GROUP BY BioID, MachineID, AttendanceName, AttendanceTime
					) t1
				)";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$date_now = date("Y-m-d H:i:s");
		$this->db->where('AttendanceTime >', $date_now);
		$this->db->delete('tb_employee_attendance_record');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function employee_attendance_record()
	{
		$this->db->trans_start();

		$show = array();
		$show['info_filter'] = "";
		$post = count($this->input->post());
		if ($post > 0) {
			$EmployeeID	= $this->input->post('employee'); 
			$datestart	= $this->input->post('datestart'); 
			$dateend 	= $this->input->post('dateend');
			$show['EmployeeID'] = $EmployeeID;

			$sql = "SELECT em.fullname, em.EmployeeID, ar.BioID, 
					GROUP_CONCAT(DISTINCT DATE(ar.AttendanceTime)) AS AttendanceDate,
					GROUP_CONCAT(DISTINCT TIME(ar.AttendanceTime) ORDER BY ar.AttendanceTime SEPARATOR ' , ' ) AS AttendanceTime
					FROM vw_employee4 em
					LEFT JOIN tb_employee_attendance_record ar ON em.BioID = ar.BioID
					WHERE em.EmployeeID = '".$EmployeeID."' ";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && isset($_REQUEST['dateend']) &&  $_REQUEST['dateend'] != "" ) {
				$sql .= "and ar.AttendanceTime between '".$_REQUEST['datestart']." 00:00:00' and '".$_REQUEST['dateend']." 23:59:59' ";
				$show['info_filter'] .= "Filter Date : ".$_REQUEST['datestart']." // ".$_REQUEST['dateend']."<br>";
			}
 
			$sql .= "GROUP BY DATE(ar.AttendanceTime) ORDER BY DATE(ar.AttendanceTime)";

			$sql_final 	= "SELECT d.*,t1.*, eat.*, aa.AttendanceNote FROM tb_date d
							LEFT JOIN (".$sql.") t1 ON t1.AttendanceDate = d.DateReff
							LEFT JOIN tb_employee_attendance_adjust aa ON '".$EmployeeID."'=aa.EmployeeID AND d.DateReff=aa.AttendanceDate
							LEFT JOIN tb_employee_attendance_time eat ON aa.TimeID=eat.TimeID
							WHERE d.DateReff between '".$_REQUEST['datestart']." 00:00:00' and '".$_REQUEST['dateend']."' 
							ORDER BY d.DateReff";
			// echo $sql_final;
			$query = $this->db->query($sql_final);
			if (!empty($query->result_array())) {
				$show['main'] = $query->result_array();
			}

			$sql = "SELECT fullname FROM vw_employee4 where EmployeeID=".$EmployeeID;
			$query = $this->db->query($sql);
			$row 	= $query->row();
			$show['info_filter'] .= "Employee Name : ".$row->fullname."<br>";

			$sql = "SELECT * FROM tb_employee_attendance_time 
					where GroupTimeID in (
						select GroupTimeID from tb_employee_main where EmployeeID=".$EmployeeID."
					) and isActive=1 order by TimeOrder";
			$query = $this->db->query($sql);
			$show['time'] = $query->result_array();
		}

		// get gorup time
		$sql = "SELECT * FROM tb_employee_attendance_group ag
				LEFT JOIN tb_employee_attendance_time eat ON ag.GroupTimeID=eat.GroupTimeID
				where eat.isActive=1
				ORDER BY ag.GroupTimeID, eat.TimeOrder";
		$query = $this->db->query($sql);
		$show['groupTime'] = $query->result_array();

		return $show;
		$this->db->trans_complete();
	}
	function employee_attendance_adjust()
	{
		$this->db->trans_start();

		$EmployeeID	= $this->input->post('EmployeeID'); 
		$AttendanceDate	= $this->input->post('AttendanceDate'); 
		$time	= $this->input->post('time'); 
		$note	= $this->input->post('note'); 

		for ($i=0; $i < count($AttendanceDate);$i++) {
			$data[] = array(
				'EmployeeID' => $EmployeeID,
				'AttendanceDate' => $AttendanceDate[$i],
				'AttendanceNote' => $note[$i], 
				'TimeID' => $time[$i], 
			);
		}
		$this->db->insert_batch('tb_employee_attendance_adjust', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql = "DELETE FROM tb_employee_attendance_adjust
				WHERE OrderID NOT IN (
					SELECT OrderID FROM (
						SELECT MAX(OrderID) AS OrderID
						FROM tb_employee_attendance_adjust
						GROUP BY EmployeeID, AttendanceDate 
					) t1
				)";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function employee_attendance_personal($id)
	{
		$this->db->trans_start();

		$show = array();
		$show['info_filter'] = "";
		$show['EmployeeID'] = $id;
		$post = count($this->input->post());
		if ($post > 0) {
			$EmployeeID	= $id; 
			$datestart	= $this->input->post('datestart'); 
			$dateend 	= $this->input->post('dateend');  

			$sql = "SELECT em.fullname, em.EmployeeID, ar.BioID, 
					GROUP_CONCAT(DISTINCT DATE(ar.AttendanceTime)) AS AttendanceDate,
					GROUP_CONCAT(DISTINCT TIME(ar.AttendanceTime) ORDER BY ar.AttendanceTime SEPARATOR ' , ' ) AS AttendanceTime 
					FROM vw_employee4 em
					LEFT JOIN tb_employee_attendance_record ar ON em.BioID = ar.BioID
					WHERE em.EmployeeID = '".$EmployeeID."' ";

			if (isset($_REQUEST['datestart']) && $_REQUEST['datestart'] != "" && isset($_REQUEST['dateend']) &&  $_REQUEST['dateend'] != "" ) {
				$sql .= "and ar.AttendanceTime between '".$_REQUEST['datestart']." 00:00:00' and '".$_REQUEST['dateend']." 23:59:59' ";
				$show['info_filter'] .= "Filter Date : ".$_REQUEST['datestart']." // ".$_REQUEST['dateend']."<br>";
			}
 
			$sql .= "GROUP BY DATE(ar.AttendanceTime) ORDER BY DATE(ar.AttendanceTime)";

			$sql_final 	= "SELECT d.*,t1.*, eat.*, aa.AttendanceNote FROM tb_date d
							LEFT JOIN (".$sql.") t1 ON t1.AttendanceDate = d.DateReff
							LEFT JOIN tb_employee_attendance_adjust aa ON '".$EmployeeID."'=aa.EmployeeID AND d.DateReff=aa.AttendanceDate
							LEFT JOIN tb_employee_attendance_time eat ON aa.TimeID=eat.TimeID
							WHERE d.DateReff between '".$_REQUEST['datestart']." 00:00:00' and '".$_REQUEST['dateend']."' 
							ORDER BY d.DateReff";
			// echo $sql_final;
			$query = $this->db->query($sql_final);
			if (!empty($query->result_array())) {
				$show['main'] = $query->result_array();
				// $show['info_filter'] .= "Employee Name : ".$show['main'][0]['fullname']."<br>";
			}

			$sql = "SELECT * FROM tb_employee_attendance_time 
					where GroupTimeID in (
						select GroupTimeID from tb_employee_main where EmployeeID=".$EmployeeID."
					) order by GroupTimeID limit 1";
			$query = $this->db->query($sql);
			$row 	= $query->row();
			$show['time'] = (array) $row;
		}

		return $show;
		$this->db->trans_complete();
	}

// ===================================================================
	function fill_employee()
	{
		$sql = "SELECT EmployeeID, ContactID, fullname FROM vw_employee2";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'EmployeeID' => $row->EmployeeID,
				'ContactID' => $row->ContactID,
				'EmployeeName' => $row->fullname,
				'Fullname' => $row->fullname
			);
		};
		$this->log_user->log_query($this->last_query);
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
	}
	function fill_employee_active()
	{
		$sql = "SELECT EmployeeID, ContactID, fullname FROM vw_employee2 where isActive=1 ORDER BY fullname";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'EmployeeID' => $row->EmployeeID,
				'ContactID' => $row->ContactID,
				'EmployeeName' => $row->fullname,
				'Fullname' => $row->fullname
			);
		};
		$this->log_user->log_query($this->last_query);
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
	}
	function fill_attendance_group()
	{
		$sql = "SELECT * FROM tb_employee_attendance_group";
		$query 	= $this->db->query($sql);
		$show 	= $query->result_array();
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
	}
	function fill_religion()
	{
		$sql 	= "select * from tb_religion";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'ReligionID' => $row->ReligionID,
				'ReligionName' => $row->ReligionName
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_state()
	{
		$sql 	= "SELECT * FROM tb_address_state order by StateName asc";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'StateID' => $row->StateID,
				'StateName' => $row->StateName
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_province()
	{
		$StateID  = $this->input->get_post('StateID');
		$sql 	= "SELECT * FROM tb_address_province where StateID = '".$StateID."' ";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'ProvinceName' => $row->ProvinceName,
				'ProvinceID' => $row->ProvinceID
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_city()
	{
		$ProvinceID  = $this->input->get_post('ProvinceID');
		$sql 	= "SELECT * FROM vw_city where ProvinceID = '".$ProvinceID."' ";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'CityName' => $row->CityName,
				'CityID' => $row->CityID
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_districts()
	{
		$CityID  = $this->input->get_post('CityID');
		$sql 	= "SELECT * FROM tb_address_districts where CityID = '".$CityID."' ";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['dis'][] = array(
				'DistrictsName' => $row->DistrictsName,
				'DistrictsID' => $row->DistrictsID
			);
		};

		$sql 	= "SELECT * FROM tb_address_pos where DistrictsID in ";
		$sql 	.="(select DistrictsID from tb_address_districts where CityID = '".$CityID."') group by PosName ";
		$result = ""; 
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['pos'][] = array(
				'PosName' => $row->PosName,
				'PosID' => $row->PosID
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_pos()
	{
		$DistrictsID  = $this->input->get_post('DistrictsID');
		$sql 	= "SELECT * FROM tb_address_pos where DistrictsID = '".$DistrictsID."' group by PosName ";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'PosName' => $row->PosName,
				'PosID' => $row->PosID
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_employment()
	{
		$sql 	= "SELECT * FROM tb_employment_status ";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'EmploymentName' => $row->EmploymentName,
				'EmploymentID' => $row->EmploymentID
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_officelocation()
	{
		$sql 	= "SELECT * FROM tb_job_office_location ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'LocID' => $row->LocID,
				'LocCode' => $row->LocCode
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_jobtitle()
	{
		$show	= array();
		$sql 	= "SELECT * FROM tb_job_level where (EmployeeID is null or EmployeeID=0) and LevelStatus=1";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'LevelID' => $row->LevelID,
				'LevelCode' => $row->LevelCode,
				'LevelName' => $row->LevelName
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function approve_employee_overtime_implementation($val)
	{
		$this->db->trans_start();
		$OTID=$val;

		$sql 	= "SELECT * FROM tb_employee_overtime WHERE OTID=".$val;
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$Job = $row->Job;
		$Qty = $row->Qty;
		$InputBy = $row->InputBy;
		$EmployeeID = $row->EmployeeID;

		$data_approval = array(
						'OTID' => $OTID,
						'Title' => "Approval for Employee Overtime ".$OTID,
						'Note'=>$Job,
						'isComplete' => 0,
						'Status' => ""
					);

		$this->db->insert('tb_approval_overtime', $data_approval);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}
?>