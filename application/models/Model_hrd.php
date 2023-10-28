<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_hrd extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }

// manage company =====================================================================
	function company_list()
	{
		$sql 	= "SELECT * FROM tb_job_company";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'CompanyID' => $row->CompanyID,
		  			'CompanyName' => $row->CompanyName,
		  			'CompanyAddress' => $row->CompanyAddress,
		  			'CompanyPhone' => $row->CompanyPhone,
		  			'CompanyFax' => $row->CompanyFax,
		  			'CompanyCode' => $row->CompanyCode
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function company_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$address = $this->input->post('address'); 
		$phone 	= $this->input->post('phone'); 
		$fax 	= $this->input->post('fax'); 
		$code 	= $this->input->post('code'); 

		$data = array(
	        'CompanyName' 	=> $name,
			'CompanyAddress'	=> $address,
			'CompanyPhone' => $phone,
			'CompanyFax' 	=> $fax,
			'CompanyCode' 	=> $code
		);
		$this->db->insert('tb_job_company', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function company_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$address = $this->input->post('address2'); 
		$phone 	= $this->input->post('phone2'); 
		$fax 	= $this->input->post('fax2'); 

		$data = array(
			'CompanyAddress'=> $address,
			'CompanyPhone'  => $phone,
			'CompanyFax' 	=> $fax
		);

		$this->db->where('CompanyID', $id);
		$this->db->update('tb_job_company', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// manage division =====================================================================
	function division_list()
	{
		$sql = "SELECT dv.*, cp.CompanyName FROM tb_job_divisi dv ";
		$sql .= "left join tb_job_company cp on(dv.CompanyID = cp.CompanyID) ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$DivisiStatus = $row->DivisiStatus=="1" ? "Aktif" : "NonAktif" ;
		  	$show[] = array(
		  			'DivisiID' => $row->DivisiID,
		  			'DivisiName' => $row->DivisiName,
		  			'CompanyID' => $row->CompanyID,
		  			'CompanyName' => $row->CompanyName,
		  			'DivisiCode' => $row->DivisiCode,
		  			'DivisiNote' => $row->DivisiNote,
		  			'DivisiStatus' => $DivisiStatus
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function division_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$note = $this->input->post('note'); 
		$companyid = $this->input->post('companyid'); 
		$code 	= $this->input->post('code'); 

		$data = array(
	        'DivisiName' 	=> $name,
			'CompanyID' => $companyid,
			'DivisiCode' => $code,
			'DivisiNote' 	=> $note,
			'DivisiStatus' 	=> "1"
		);
		$this->db->insert('tb_job_divisi', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function division_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$name 	= $this->input->post('name2'); 
		$note 	= $this->input->post('note2'); 
		$status = $this->input->post('status'); 

		$data = array(
	        'DivisiName' 	=> $name,
			'DivisiNote' 	=> $note,
			'DivisiStatus' 	=> $status
		);
		// print_r($data);
		$this->db->where('DivisiID', $id);
		$this->db->update('tb_job_divisi', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}

// manage job =====================================================================
	function job_list($parent = 0, $spacing = '', $tree_array = array())
	{
		$sql = "select j.*, dv.DivisiName, cp.CompanyName, vem.fullname, vem.ResignDate from tb_job_level j  
				left join tb_job_divisi dv on(j.DivisiID = dv.DivisiID)  
				left join tb_job_company cp on(dv.CompanyID = cp.CompanyID)  
				LEFT JOIN vw_employee2 vem ON (j.EmployeeID = vem.EmployeeID)
				where LevelParent=".$parent." GROUP BY j.LevelID order by cp.CompanyName asc, dv.DivisiName asc, j.LevelName asc ";
				// echo $sql;
		$show   = array();
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$LevelStatus = $row->LevelStatus=="1" ? "Aktif" : "NonAktif" ;
				$ResignDate = $row->ResignDate!="" ? "(Resign)" : "" ;
			  	$tree_array[] = array(
			  			'LevelID' => $row->LevelID,
			  			'LevelName' => $row->LevelName,
			  			'DivisiName' => $row->DivisiName,
			  			'CompanyName' => $row->CompanyName,
			  			'LevelCode' => $spacing."  ".$row->LevelCode,
			  			'LevelStatus' => $LevelStatus,
			  			'EmployeeID' => $row->EmployeeID,
			  			'Employee' => $row->fullname.' '.$ResignDate,
			  			'LevelParent' => $row->LevelParent
					);
		      	$tree_array = $this->job_list($row->LevelID, $spacing.'--', $tree_array);
			};
		}
		return $tree_array;
		$this->log_user->log_query($this->last_query);
	}
	function job_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$divisi = $this->input->post('divisi'); 
		$company = $this->input->post('company'); 
		$code 	= $this->input->post('code'); 
		$parent 	= $this->input->post('parent'); 

		$data = array(
	        'LevelName' 	=> $name,
			'DivisiID' => $divisi,
			'CompanyID' => $company,
			'LevelCode' => $code,
			'LevelStatus' => "1",
			'LevelParent' => $parent
		);
		$this->db->insert('tb_job_level', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function job_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$status = $this->input->post('status'); 
		$parent = $this->input->post('parent2'); 
		$employee2 	= $this->input->post('employee2'); 
		$datenow 	= date("Y-m-d H:i:s"); 

		if ($id != $parent) {
			$data = array(
				'LevelStatus' => $status,
				'EmployeeID' => $employee2,
				'LevelParent' => $parent
			);
			$this->db->where('LevelID', $id);
			$this->db->update('tb_job_level', $data);
			$this->last_query .= "//".$this->db->last_query();


			$data_job = array(
		        'EndDate' => $datenow
			);
			$this->db->where('LevelID',$id);
			$this->db->where('EndDate',null);
			$this->db->update('tb_job_title',$data_job);
			$this->last_query .= "//".$this->db->last_query();


			$data_job2 = array(
		        'LevelID' => $id,
		        'EmployeeID' => $employee2,
		        'StartDate' => $datenow
			);
			$this->db->insert('tb_job_title', $data_job2);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function job_history()
	{
		$show 	= array();
        $id  	= $this->input->get_post('id');
		$sql 	= "SELECT jl.*, vem.fullname, jl2.LevelName as levelparent
					FROM tb_job_level jl
					LEFT JOIN vw_employee2 vem ON (jl.EmployeeID = vem.EmployeeID)
					LEFT JOIN tb_job_level jl2 ON (jl.LevelParent = jl2.LevelID) 
					WHERE jl.LevelID =".$id;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['main'] = array(
		  			'LevelID' => $row->LevelID,
		  			'LevelName' => $row->LevelName,
		  			'LevelCode' => $row->LevelCode,
					'Employee' => $row->fullname,
					'levelparent'	=> $row->levelparent
				);
		};

		$sql 	= "SELECT jt.*, vem.fullname
					FROM tb_job_title jt
					LEFT JOIN vw_employee2 vem ON (jt.EmployeeID = vem.EmployeeID)
					WHERE jt.LevelID = ".$id;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		  			'StartDate' => $row->StartDate,
		  			'EndDate' => $row->EndDate,
		  			'fullname' => $row->fullname
				);
		};

	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	
// manage asset ======================================================================
	function asset_list()
	{
		$sql = "select * from vw_asset_main ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'AssetID' => $row->AssetID,
		  			'AssetName' => $row->AssetName,
					'DateIn' => $row->DateIn,
					'Price'	=> $row->Price,
		  			'Fullname' => $row->fullname
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function asset_list_detail()
    {
		$show = array();
        $id  = $this->input->get_post('a');

        // query get data utama
		$sql = "select am.*, ad.*, em.*, ad.DateIn as DateInD from tb_asset_main am ";
		$sql .= "left join vw_asset_detail_last ad on(am.AssetID = ad.AssetID) ";
		$sql .= "left join vw_employee2 em on(ad.EmployeeID = em.EmployeeID) ";
		$sql .= " where am.AssetID = '".$id."' and ( ad.DateOut = '0000-00-00' or ad.DateOut is null)";
		$query 	= $this->db->query($sql);
		//echo $sql;
		$row 	= $query->row();	
	  	$show = array(
		  	'AssetID' => $id,
			'ContactID' => "$row->ContactID",
			'AssetDetailID' => "$row->AssetDetailID",
			'AssetName' => strtoupper("$row->AssetName"),
			'ModelNumber' => "$row->ModelNumber",
			'SerialNumber' => "$row->SerialNumber",
			'assetcolour' => "$row->AssetColor",
			'AssetType' => "$row->AssetType",
			'assetcategory' => "$row->AssetCategory",
			'DateIn' => "$row->DateIn",
			'Price' => "$row->Price",
			'assetcondition' => "$row->AssetCondition",
			'AssetSpecification' => "$row->AssetSpesification",
			'AssetNote' => "$row->AssetNote",
			'employeename' => "$row->fullname",
			'DateInD' => "$row->DateInD",
			'DateOut' => "$row->DateOut",
			'statusin' => "$row->StatusIn",
			'statusout' => "$row->StatusOut",
			'notedetail' => "$row->Note"
		);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function asset_cu($val)
	{
		$show = array();
		if ($val == "new") { //jika data contact baru
			$show['personal'] = array(
			  	'ContactID' => "",
				'AssetID' => "",
			  	'AssetName' => "",
			  	'ModelNumber' => "",
			  	'SerialNumber' => "",
			  	'assetcolour' => "Blue",
				'AssetType' => "",
				'assetcategory' => "Inventaris",
				'DateIn' => "",
				'Price' => "",
			  	'assetcondition' => "",
			  	'AssetSpecification' => "",
			  	'AssetNote' => "",
				'AssetDetailID' => "",
			  	'employeename' => "",
			  	'DateInD' => "",
			  	'DateOut' => "",
			  	'statusin' => "",
			  	'statusout' => "",
			  	'notedetail' => "",
			);
			
			$show['employeename'][] = array(
					  	'AssetDetailID' => "",
						'AssetID' => "",
						'EmployeeID' => "",
						'DateInD' => "",
						'DateOut' => "",
						'StatusIn' => "",
						'StatusOut' => "",
						'Note' => "",
						'Fullname'	=> ""
					);

		} else { // jika data asset exist
			$sql = "select am.*, ad.*, c.*, ad.DateIn as DateInD from tb_asset_main am ";
			$sql .= "left join tb_asset_detail ad on(am.AssetID = ad.AssetID) ";
			$sql .= "left join tb_employee_main em on(ad.EmployeeID = em.EmployeeID) ";
			$sql .= "left join vw_contact2 c on(em.ContactID = c.ContactID)";
			$sql .= " where am.AssetID = '".$val."' and (ad.DateOut = '0000-00-00' or ad.DateOut is null)";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			if (empty($row)) {
				redirect(base_url());
			} else {
				$show['personal'] = array(
				  	'AssetID' => $val,
					'ContactID' => "$row->ContactID",
					'AssetDetailID' => "$row->AssetDetailID",
					'AssetName' => "$row->AssetName",
					'ModelNumber' => "$row->ModelNumber",
					'SerialNumber' => "$row->SerialNumber",
					'assetcolour' => "$row->AssetColor",
					'AssetType' => "$row->AssetType",
					'assetcategory' => "$row->AssetCategory",
					'DateIn' => "$row->DateIn",
					'Price' => "$row->Price",
					'assetcondition' => "$row->AssetCondition",
					'AssetSpecification' => "$row->AssetSpesification",
					'AssetNote' => "$row->AssetNote",
					'employeename' => "$row->fullname",
					'DateInD' => "$row->DateInD",
					'DateOut' => "$row->DateOut",
					'statusin' => "$row->StatusIn",
					'statusout' => "$row->StatusOut",
					'notedetail' => "$row->Note"
				);
			
			
			if ($row->EmployeeID != "") {
				$sql = "select am.*, ad.*, c.*, ad.DateIn as DateInD from tb_asset_main am ";
				$sql .= "left join tb_asset_detail ad on(am.AssetID = ad.AssetID) ";
				$sql .= "left join tb_employee_main em on(ad.EmployeeID = em.EmployeeID) ";
				$sql .= "left join vw_contact2 c on(em.ContactID = c.ContactID)";
				$sql .= "where am.AssetID = '".$val."' and ad.EmployeeID = '".$row->EmployeeID."' and (ad.DateOut = '0000-00-00' or ad.DateOut is null)";
				$query2 	= $this->db->query($sql);
				foreach ($query2->result() as $row2) {
						//if ($row4->DetailType == "sales") {
							$show['employeename'][] = array(
								'AssetDetailID' => $row2->AssetDetailID,
							  	'AssetID' => $row2->AssetID,
							  	'EmployeeID' => $row2->EmployeeID,
								'DateInD' => $row2->DateIn,
								'DateOut' => $row2->DateOut,
								'StatusIn' => $row2->StatusIn,
								'StatusOut' => $row2->StatusOut,
								'Note' => $row2->Note,
								'Fullname'	=> $row2->fullname
							);
						//}
					};
			} else{
				$show['employeename'][] = array(
					  	'AssetDetailID' => "",
						'AssetID' => "",
						'EmployeeID' => "",
						'DateIn' => "",
						'DateOut' => "",
						'StatusIn' => "",
						'StatusOut' => "",
						'Note' => ""
					);
			}
		}
		}
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function asset_cu_act()
	{
		$this->db->trans_start();

		date_default_timezone_set("Asia/Jakarta");
		$contactid 	= $this->input->post('contactid'); 
		$assetid 	= $this->input->post('assetid'); 
		$assetdetailid 	= $this->input->post('assetdetailid'); 
		$assetname 	= $this->input->post('assetname'); 
		$modelnumber= $this->input->post('modelnumber'); 
		$serialnumber = $this->input->post('serialnumber'); 
		$assetcolour 	= $this->input->post('assetcolour'); 
		$assettype 	= $this->input->post('assettype'); 
		$assetcategory 	= $this->input->post('assetcategory');
		$datein 		= $this->input->post('datein'); 
		$price 		= $this->input->post('price'); 

		$assetcondition= $this->input->post('assetcondition'); 
		$assetspecification 	= $this->input->post('assetspecification'); 
		$assetnote 		= $this->input->post('assetnote'); 
		$employeename 	= $this->input->post('employeename'); 
		$dateind 		= $this->input->post('dateind'); 
		$dateout 	= $this->input->post('dateout'); 
		$statusin 		= $this->input->post('statusin'); 
		$statusout 		= $this->input->post('statusout'); 
		$notedetail 		= $this->input->post('notedetail');

		$data_asset = array(
			'AssetName'	=> $assetname,
			'ModelNumber' 	=> $modelnumber,
			'SerialNumber' 	=> $serialnumber,
			'AssetColor' 	=> $assetcolour,
			'AssetType' => $assettype,
			'AssetCategory' => $assetcategory,
			'DateIn' => $datein,
	        'Price' => $price,
	        'AssetCondition' => $assetcondition,
			'AssetSpesification' => $assetspecification,
	        'AssetNote' => $assetnote,
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		
		$data_asset_detail = array(
				'EmployeeID'	=> $employeename[0],
				'DateIn' 	=> $dateind,
				'DateOut' 	=> $dateout,
				'StatusIn' 	=> $statusin,
				'StatusOut' => "$statusout",
				'Note' => $notedetail
			);

		if ($assetid == "") { //jika data contact baru
			$data_asset['InputDate'] = date("Y-m-d H:i:s");
			$data_asset['InputBy'] = $this->session->userdata('UserAccountID');
			$this->db->insert('tb_asset_main', $data_asset);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(AssetID) as AssetID from tb_asset_main ";
			$getAssetID = $this->db->query($sql);
			$row 		= $getAssetID->row();
			$AssetID 	= $row->AssetID;
			
			$data_asset_detail = array(
				'AssetID' => $AssetID,
				'EmployeeID'	=> $employeename[0],
				'DateIn' 	=> $dateind,
				'DateOut' 	=> $dateout,
				'StatusIn' 	=> $statusin,
				'StatusOut' => "$statusout",
				'Note' => $notedetail
			);
			if($employeename!=""){
				$this->db->insert('tb_asset_detail', $data_asset_detail);
				$this->last_query .= "//".$this->db->last_query();
			}

		} else { // jika data contact exist
			$this->db->where('AssetID', $assetid);
			$this->db->update('tb_asset_main', $data_asset);
			$this->last_query .= "//".$this->db->last_query();
			
			$this->db->where('AssetDetailID', $assetdetailid);
			$this->db->update('tb_asset_detail', $data_asset_detail);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function asset_assignment($val)
	{
		$sql = "select am.*, ad.*, c.*, ad.DateIn as DateInD from tb_asset_main am ";
		$sql .= "left join tb_asset_detail ad on(am.AssetID = ad.AssetID) ";
		$sql .= "left join tb_employee_main em on(ad.EmployeeID = em.EmployeeID) ";
		$sql .= "left join vw_contact2 c on(em.ContactID = c.ContactID)";
		$sql .= " where am.AssetID = '".$val."'";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['assign'][] = array(
		  			'AssetDetailID' => $row->AssetDetailID,
		  			'AssetID' => $row->AssetID,
		  			'AssetName' => ucfirst($row->AssetName),
					'EmployeeID'=> $row->EmployeeID,
					'DateIn'	=> $row->DateIn,
		  			'StatusIn' => $row->StatusIn,
					'StatusOut'=> $row->StatusOut,
					'DateOut'   => $row->DateOut,
					'DateInD'  => $row->DateInD,
					'Note'	   => $row->Note,
		  			'Fullname' => $row->fullname
				);
			
			$show[] = array(
						'AssetID' => "",
						'AssetName' => "",
						'EmployeeID' => "",
						'Fullname' => ""
					);
		};
		
		$sql2 = "SELECT * FROM tb_asset_main";
		$sql2 .= " where AssetID = '".$val."'";
		$query2 	= $this->db->query($sql2);
		$row2 	= $query2->row();
		
		$show["assetnya"] = array(
		  	'AssetID' => "$row2->AssetID",
			'AssetName' => "$row2->AssetName"
		);
		
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function asset_assignment_add()
	{
		$this->db->trans_start();

		$asset 	= $this->input->post('assetid'); 
		$dateind = $this->input->post('dateind');
		$statusin = $this->input->post('statusin');
		$employeename = $this->input->post('employeename');
		$note = $this->input->post('note');
		
		$data = array(
	        'AssetID' 	=> $asset,
			'DateIn' => $dateind,
			'StatusIn' => $statusin,
			'EmployeeID' => $employeename[0],
			'Note' 	=> $note
		);
		
		$data_detail_out = array(
			'DateOut' => $dateind,
			'StatusOut' => $statusin,
			'note' => $note
		);
		
		
		$sql 		= "select AssetID, AssetDetailID from tb_asset_detail where AssetID='$asset' order by AssetDetailID desc limit 0,1 ";
		$getAssetID = $this->db->query($sql);
		$row 		= $getAssetID->row();
		$AssetDetailID 	= $row->AssetDetailID;
		
		if($AssetDetailID==""){
			$this->db->insert('tb_asset_detail', $data);
			$this->last_query .= "//".$this->db->last_query();
		}else{
			$this->db->where('AssetDetailID', $AssetDetailID);
			$this->db->update('tb_asset_detail', $data_detail_out);
			$this->last_query .= "//".$this->db->last_query();

			
			$this->db->insert('tb_asset_detail', $data);
			$this->last_query .= "//".$this->db->last_query();
		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function asset_assignment_history()
	{
		$sql = "select am.*, ad.*, c.*, ad.DateIn as DateInD from tb_asset_main am ";
		$sql .= "left join tb_asset_detail ad on(am.AssetID = ad.AssetID) ";
		$sql .= "left join tb_employee_main em on(ad.EmployeeID = em.EmployeeID) ";
		$sql .= "left join vw_contact2 c on(em.ContactID = c.ContactID)";
		
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['assign'][] = array(
		  			'AssetID' => $row->AssetID,
		  			'AssetName' => ucfirst($row->AssetName),
					'EmployeeID'=> $row->EmployeeID,
					'DateIn'	=> $row->DateIn,
		  			'StatusIn' => $row->StatusIn,
					'StatusOut'=> $row->StatusOut,
					'DateOut'   => $row->DateOut,
					'DateInD'  => $row->DateInD,
		  			'Fullname' => $row->fullname
				);
			
			$show[] = array(
						'AssetID' => "",
						'AssetName' => "",
						'EmployeeID' => "",
						'Fullname' => ""
					);
		};
		
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function asset_transfer_print()
    {
		$show = array();
        $AssetDetailID  = $this->input->get('id');

		$sql = "select ad.*, em.fullname, ej.LevelName from tb_asset_detail ad 
				LEFT JOIN vw_employee2 em ON em.EmployeeID=ad.EmployeeID
				LEFT JOIN vw_employee_job ej ON ej.EmployeeID=ad.EmployeeID
				where ad.AssetDetailID = '".$AssetDetailID."'";
		$query 	= $this->db->query($sql);
		$rowd2 	= $query->row();
		$show['detail2'] = $rowd2;

		$sql = "select ad.*, em.fullname, ej.LevelName from tb_asset_detail ad 
				LEFT JOIN vw_employee2 em ON em.EmployeeID=ad.EmployeeID
				LEFT JOIN vw_employee_job ej ON ej.EmployeeID=ad.EmployeeID
				where ad.AssetID = '".$rowd2->AssetID."' and AssetDetailID<'".$AssetDetailID."' 
				ORDER BY AssetDetailID desc LIMIT 1";
		$query 	= $this->db->query($sql);
		$rowd1 	= $query->row();
		$show['detail1'] = $rowd1;

		$sql = "select am.* from tb_asset_main am where am.AssetID = '".$rowd2->AssetID."'";
		$query 	= $this->db->query($sql);
		$rowmain 	= $query->row();
		$show['main'] = $rowmain;

		// echo json_encode($show['detail1']);
	    return $show;
		$this->log_user->log_query($this->last_query);
	}

// manage office =====================================================================
	function office_list()
	{
		$sql = "select o.*, cp.CompanyName from tb_job_office_location o ";
		$sql .= "left join tb_job_company cp on(o.CompanyID = cp.CompanyID) ";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			$LocStatus = $row->LocStatus=="1" ? "Aktif" : "NonAktif" ;
		  	$show[] = array(
		  			'LocID' => $row->LocID,
		  			'LocName' => $row->LocName,
		  			'CompanyID' => $row->CompanyID,
		  			'CompanyName' => $row->CompanyName,
		  			'LocNote' => $row->LocNote,
		  			'LocCode' => $row->LocCode,
		  			'LocStatus' => $LocStatus
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function office_add()
	{
		$this->db->trans_start();

		$name 	= $this->input->post('name'); 
		$note 	= $this->input->post('note'); 
		$companyid = $this->input->post('companyid'); 
		$code 	= $this->input->post('code'); 

		$data = array(
	        'LocName' 	=> $name,
			'LocNote' => $note,
			'CompanyID' => $companyid,
			'LocCode' => $code,
			'LocStatus' 	=> "1"
		);
		$this->db->insert('tb_job_office_location', $data);
		$this->last_query .= "//".$this->db->last_query();
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function office_edit()
	{
		$this->db->trans_start();

		$id 	= $this->input->post('id'); 
		$name 	= $this->input->post('name2'); 
		$note 	= $this->input->post('note2'); 
		$status = $this->input->post('status'); 

		$data = array(
	        'LocName' => $name,
			'LocNote' => $note,
			'LocStatus' => $status
		);
		print_r($data);
		$this->db->where('LocID', $id);
		$this->db->update('tb_job_office_location', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	
// tasklist======================================================================
	function task_list()
	{
		$show   = array();
		$emp = $this->session->userdata('UserAccountID');

		$sql2 		= "select LevelID from tb_job_level where EmployeeID='$emp' ";
		$getLevelID = $this->db->query($sql2);
		$row2 		= $getLevelID->row();
		if (empty($row2)) {
			$LevelID 	= "";
		}else{
			$LevelID	= $row2->LevelID;
		}

		$sql	= "SELECT t.TaskID as TaskID, t.TaskName, t.TaskDescription, t.TaskCreatedDate, t.TaskStatusID, t.TaskDueDate, t.*, t.TaskCloseDate, t.TaskProgress, t.LevelID, ";
		$sql	.= "GROUP_CONCAT(DISTINCT tas.LevelTaskAssignedToID) AS LevelTaskAssignedToID, GROUP_CONCAT(DISTINCT tac.LevelTaskCcID) AS LevelTaskCcID, tp.TaskPriorityName, ts.TaskStatusName, ";
		$sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName, ";
		$sql	.= "(SELECT jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=t.LevelID) AS LevelName2, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName2, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName2 FROM tb_task t ";
		$sql	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
		$sql	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
		$sql	.= "LEFT JOIN tb_job_title js ON js.LevelID=t.LevelID ";
		$sql	.= "LEFT JOIN tb_task_assigned tas ON tas.TaskID=t.TaskID ";
		$sql	.= "LEFT JOIN tb_task_cc tac ON tac.TaskID=t.TaskID ";
		$sql	.= "WHERE t.TaskStatusID='1' AND (t.LevelID='$LevelID' or tas.LevelTaskAssignedToID='$LevelID' or tac.LevelTaskCcID='$LevelID')";
		// $sql	.= "WHERE t.TaskStatusID='1' ";
		$sql	.= "GROUP BY t.TaskID";

		$query 	= $this->db->query($sql);
		
		foreach ($query->result() as $row) {
			if($row->LevelID==$LevelID or $LevelID=='1') 
				{ 
					$display= "inline-block";
				}else{
					$display= "none";
				}
		  	$show['open'][] = array(
		  			'TaskID' => $row->TaskID,
		  			'TaskName' => $row->TaskName,
					'LevelID' => $row->LevelID,
					'LevelName' => $row->LevelName,
					'LevelName2' => $row->LevelName2,
					'TaskDescription' => $row->TaskDescription,
					'TaskCreatedDate' => $row->TaskCreatedDate,
					'TaskDueDate' => $row->TaskDueDate,
					'TaskCloseDate' => $row->TaskCloseDate,
					'TaskProgress' => $row->TaskProgress,
					'TaskStatusID' => $row->TaskStatusID,
					'TaskPriorityID' => $row->TaskPriorityID,
					'TaskPriorityName' => $row->TaskPriorityName,
					'TaskStatusName' => $row->TaskStatusName,
					'LevelAssignedName' => $row->LevelAssignedName,
					'LevelAssignedName2' => $row->LevelAssignedName2,
					'LevelCcName' => $row->LevelCcName,
					'LevelCcName2' => $row->LevelCcName2,
					'DisplayEdit' => $display
				);
		};
		
		$sql3	= "SELECT t.TaskID as TaskID, t.TaskName, t.TaskDescription, t.TaskCreatedDate, t.TaskStatusID, t.*, t.TaskDueDate, t.TaskCloseDate, t.TaskProgress, t.LevelID, ";
		$sql3	.= "GROUP_CONCAT(DISTINCT tas.LevelTaskAssignedToID) AS LevelTaskAssignedToID, GROUP_CONCAT(DISTINCT tac.LevelTaskCcID) AS LevelTaskCcID, tp.TaskPriorityName, ts.TaskStatusName, ";
		$sql3	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
		$sql3	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName, ";
		$sql3	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName, ";
		$sql3	.= "(SELECT jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=t.LevelID) AS LevelName2, ";
		$sql3	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName2, ";
		$sql3	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName2 FROM tb_task t ";
		$sql3	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
		$sql3	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
		$sql3	.= "LEFT JOIN tb_job_title js ON js.LevelID=t.LevelID ";
		$sql3	.= "LEFT JOIN tb_task_assigned tas ON tas.TaskID=t.TaskID ";
		$sql3	.= "LEFT JOIN tb_task_cc tac ON tac.TaskID=t.TaskID ";
		$sql3	.= "WHERE t.TaskStatusID='2' AND (t.LevelID='$LevelID' or tas.LevelTaskAssignedToID='$LevelID' or tac.LevelTaskCcID='$LevelID')";
		// $sql3	.= "WHERE t.TaskStatusID='2' ";
		$sql3	.= "GROUP BY t.TaskID";
		
		$query3 	= $this->db->query($sql3);
		
		foreach ($query3->result() as $row3) {
			if($row3->LevelID==$LevelID or $LevelID=='1') 
				{ 
					$display= "inline-block";
				}else{
					$display= "none";
				}
		  	$show['close'][] = array(
		  			'TaskID' => $row3->TaskID,
		  			'TaskName' => $row3->TaskName,
					'LevelID' => $row3->LevelID,
					'LevelName' => $row3->LevelName,
					'LevelName2' => $row3->LevelName2,
					'TaskDescription' => $row3->TaskDescription,
					'TaskCreatedDate' => $row3->TaskCreatedDate,
					'TaskDueDate' => $row3->TaskDueDate,
					'TaskCloseDate' => $row3->TaskCloseDate,
					'TaskProgress' => $row3->TaskProgress,
					'TaskStatusID' => $row3->TaskStatusID,
					'TaskPriorityID' => $row3->TaskPriorityID,
					'TaskPriorityName' => $row3->TaskPriorityName,
					'TaskStatusName' => $row3->TaskStatusName,
					'LevelAssignedName' => $row3->LevelAssignedName,
					'LevelAssignedName2' => $row3->LevelAssignedName2,
					'LevelCcName' => $row3->LevelCcName,
					'LevelCcName2' => $row3->LevelCcName2,
					'DisplayEdit' => $display
				);
		};
	    return $show;
	}
	function task_cu($val)
	{
		$show = array();
		if ($val == "new") { //jika data contact baru
			$show['task'] = array(
			  	'TaskID' => "",
				'TaskName' => "",
			  	'LevelID' => "",
			  	'LevelName' => "",
			  	'TaskDescription' => "",
			  	'LevelTaskAssignedToID' => "",
				'LevelTaskCcID' => "",
				'TaskStatusID' => "",
				'TaskPriorityID' => "",
			  	'TaskCreatedDate' => date('Y-m-d H:i:s'),
			  	'TaskDueDate' => "",
			  	'TaskCloseDate' => "",
				'TaskProgress' => "",
			  	'TaskStatusName' => "",
			  	'TaskPriorityName' => "",
				'Displaycls'	=> "none"
			);
		} else { // jika data task exist			
			// $sql	= "SELECT *,t.LevelID as LevelID,t.TaskDescription as TaskDescription, ";
			// $sql	.= "(SELECT concat(c.NameFirst,' ',c.NameMid,' ',c.NameLast) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
			// $sql	.= "(SELECT concat(c.NameFirst,' ',c.NameMid,' ',c.NameLast) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelTaskAssignedToID) AS LevelAssignedName, ";
			// $sql	.= "(SELECT concat(c.NameFirst,' ',c.NameMid,' ',c.NameLast) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelTaskCcID) AS LevelCcName FROM tb_task t ";
			// $sql	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
			// $sql	.= "LEFT JOIN tb_task_comment tc ON tc.TaskID=t.TaskID ";
			// $sql	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
			// $sql 	.= "WHERE t.TaskID = '".$val."'";
			
			$sql	= "SELECT t.TaskID as TaskID, t.TaskName, t.TaskDescription, t.TaskCreatedDate, t.*, t.TaskStatusID, t.TaskDueDate, t.TaskCloseDate, t.TaskProgress, t.LevelID, ";
			$sql	.= "GROUP_CONCAT(DISTINCT tas.LevelTaskAssignedToID) AS LevelTaskAssignedToID, GROUP_CONCAT(DISTINCT tac.LevelTaskCcID) AS LevelTaskCcID, tp.TaskPriorityName, ts.TaskStatusName, ";
			$sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
			$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName, ";
			$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName, ";
			$sql	.= "(SELECT jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=t.LevelID) AS LevelName2, ";
			$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName2, ";
			$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName2 FROM tb_task t ";
			$sql	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
			$sql	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
			$sql	.= "LEFT JOIN tb_job_title js ON js.LevelID=t.LevelID ";
			$sql	.= "LEFT JOIN tb_task_assigned tas ON tas.TaskID=t.TaskID ";
			$sql	.= "LEFT JOIN tb_task_cc tac ON tac.TaskID=t.TaskID ";
			$sql 	.= "WHERE t.TaskID = '".$val."'";
			$sql	.= "GROUP BY t.TaskID";
			$query 	= $this->db->query($sql);
			$row 	= $query->row();	
			if (empty($row)) {
				redirect(base_url());
			} else {
				$show['task'] = array(
					'TaskID' => $val,
					'TaskName' => $row->TaskName,
					'LevelID' => $row->LevelID,
					'LevelName' => $row->LevelName,
					'TaskDescription' => $row->TaskDescription,
					'LevelTaskAssignedToID' => $row->LevelTaskAssignedToID,
					'LevelTaskCcID' => $row->LevelTaskCcID,
					'TaskStatusID' => $row->TaskStatusID,
					'TaskPriorityID' => $row->TaskPriorityID,
					'TaskCreatedDate' => $row->TaskCreatedDate,
					'TaskDueDate' => $row->TaskDueDate,
					'TaskCloseDate' => $row->TaskCloseDate,
					'TaskProgress' => $row->TaskProgress,
					'TaskStatusName' => $row->TaskStatusName,
					'TaskPriorityName' => $row->TaskPriorityName,
					'Displaycls'	=> "none"
				);
			}
		}
	    return $show;
	}
	function task_cu_act()
	{
		date_default_timezone_set("Asia/Jakarta");
		$taskid	= $this->input->post('taskid'); 
		$name 			= $this->input->post('name'); 
		$taskdescription 			= $this->input->post('taskdescription'); 
		$createdate 		= $this->input->post('createdate'); 
		$duedate			= $this->input->post('duedate'); 
		$closedate 		= $this->input->post('closedate'); 
		$taskgiver 			= $this->input->post('taskgiver');
		$taskassigned	= $this->input->post('taskassigned');
		$taskcc			= $this->input->post('taskcc'); 
		$taskpriority 		= $this->input->post('taskpriority'); 
		$taskstatus 			= $this->input->post('taskstatus');
		$taskprogress	= $this->input->post('taskprogress');

		$task = array(
			'TaskName'	=> $name,
			'TaskDescription' => $taskdescription,
			'TaskCreatedDate' => $createdate,
			'TaskDueDate' => $duedate,
			// 'TaskCloseDate'	=> $closedate,
			'LevelID' => $taskgiver,
			// 'LevelTaskAssignedToID' => $taskassigned,
			// 'LevelTaskCcID' => $taskcc,
			'TaskPriorityID'	=> $taskpriority,
			'TaskStatusID' => $taskstatus,
			'TaskProgress' => $taskprogress
		);

		if ($taskid == "") { //jika data pricelist baru
			$this->db->insert('tb_task', $task);
			$sql 			= "select max(TaskID) as TaskID from tb_task ";
			$getTaskID 	= $this->db->query($sql);
			$row 			= $getTaskID->row();
			$TaskID 	= $row->TaskID;
			for ($i=0; $i < count($taskassigned);$i++) { 
	   			$data_task_assigned = array(
			        'TaskID' => $TaskID,
			        'LevelTaskAssignedToID' => $taskassigned[$i]
				);
				$this->db->insert('tb_task_assigned', $data_task_assigned);
	   		};
			
			for ($i=0; $i < count($taskcc);$i++) { 
	   			$data_task_cc = array(
			        'TaskID' => $TaskID,
			        'LevelTaskCcID' => $taskcc[$i]
				);
				$this->db->insert('tb_task_cc', $data_task_cc);
	   		};
			
		} else { // jika data contact exist
			$this->db->where('TaskID', $taskid);
			$this->db->delete('tb_task_assigned');
			
			$this->db->where('TaskID', $taskid);
			$this->db->delete('tb_task_cc');

			for ($i=0; $i < count($taskassigned);$i++) { 
	   			$data_task_assigned = array(
			        'TaskID' => $taskid,
			        'LevelTaskAssignedToID' => $taskassigned[$i]
				);
				$this->db->insert('tb_task_assigned', $data_task_assigned);
	   		};
			
			for ($i=0; $i < count($taskcc);$i++) { 
	   			$data_task_cc = array(
			        'TaskID' => $taskid,
			        'LevelTaskCcID' => $taskcc[$i]
				);
				$this->db->insert('tb_task_cc', $data_task_cc);
	   		};
			// $this->db->where('TaskID', $taskid);
			// $this->db->update('tb_task', $task);
		}
	}
	function task_list_detail()
    {
		$show   = array();
		$id 	= $this->input->get('a'); 
		
		// $sql	= "SELECT *,t.LevelID as LevelID,t.TaskDescription as TaskDescription, ";
		// $sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
		// $sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelTaskAssignedToID) AS LevelAssignedName, ";
		// $sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelTaskCcID) AS LevelCcName FROM tb_task t ";
		// $sql	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
		// $sql	.= "LEFT JOIN tb_task_comment tc ON tc.TaskID=t.TaskID ";
		// $sql	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
		
		$sql	= "SELECT *,t.TaskID as TaskID, t.TaskName, t.TaskDescription, t.TaskCreatedDate, t.TaskStatusID, t.TaskDueDate, t.*, t.TaskCloseDate, t.TaskProgress, t.LevelID, ";
		$sql	.= "GROUP_CONCAT(DISTINCT tas.LevelTaskAssignedToID) AS LevelTaskAssignedToID, GROUP_CONCAT(DISTINCT tac.LevelTaskCcID) AS LevelTaskCcID, tp.TaskPriorityName, ts.TaskStatusName, ";
		$sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName, ";
		$sql	.= "(SELECT jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=t.LevelID) AS LevelName2, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName2, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName2 FROM tb_task t ";
		$sql	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
		$sql	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
		$sql	.= "LEFT JOIN tb_job_title js ON js.LevelID=t.LevelID ";
		$sql	.= "LEFT JOIN tb_task_assigned tas ON tas.TaskID=t.TaskID ";
		$sql	.= "LEFT JOIN tb_task_cc tac ON tac.TaskID=t.TaskID ";
		
		$sql 	.= " WHERE t.TaskID = '".$id."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['task'] = array(
			  	'TaskID' => $row->TaskID,
		  			'TaskName' => $row->TaskName,
					'LevelID' => $row->LevelID,
					'LevelName' => $row->LevelName,
					'LevelName2' => $row->LevelName2,
					'TaskDescription' => $row->TaskDescription,
					'TaskCreatedDate' => $row->TaskCreatedDate,
					'TaskDueDate' => $row->TaskDueDate,
					'TaskCloseDate' => $row->TaskCloseDate,
					'TaskProgress' => $row->TaskProgress,
					'TaskStatusID' => $row->TaskStatusID,
					'TaskPriorityID' => $row->TaskPriorityID,
					'TaskPriorityName' => $row->TaskPriorityName,
					'TaskStatusName' => $row->TaskStatusName,
					'LevelAssignedName' => $row->LevelAssignedName,
					'LevelAssignedName2' => $row->LevelAssignedName2,
					'LevelCcName' => $row->LevelCcName,
					'LevelCcName2' => $row->LevelCcName2
			);
	    return $show;
	}
	function task_list_comment($val)
	{
		$show = array();
		$emp = $this->session->userdata('UserAccountID');

		$sql2 		= "SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) AS NameNow, jb.LevelID FROM tb_employee_main em left join tb_contact c on c.ContactID=em.ContactID left join tb_job_level jb on jb.EmployeeID=em.EmployeeID WHERE em.EmployeeID='".$emp."'";
		$getEmployeeID = $this->db->query($sql2);
		$row2 		= $getEmployeeID->row();
		

		$sql4 		= "select LevelID from tb_job_level where EmployeeID='$emp' ";
		$getLevelID = $this->db->query($sql4);
		$row4 		= $getLevelID->row();
		if (empty($row4)) {
			$LevelID 	= "";
		}else{
			$LevelID	= $row4->LevelID;
		}
		
		// $show = array();			
		$sql	= "SELECT *,t.LevelID as LevelID,t.TaskDescription as TaskDescription, ";
		$sql	.= "(SELECT concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,'')) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=t.LevelID) AS LevelName, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT GROUP_CONCAT(concat(IFNULL(c.NameFirst,''),' ',IFNULL(c.NameMid,''),' ',IFNULL(c.NameLast,''))) FROM tb_job_level jb left join tb_employee_main em on em.EmployeeID=jb.EmployeeID left join tb_contact c on c.ContactID=em.ContactID WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName, ";
		$sql	.= "(SELECT jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=t.LevelID) AS LevelName2, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tas.LevelTaskAssignedToID)) AS LevelAssignedName2, ";
		$sql	.= "GROUP_CONCAT(DISTINCT(SELECT  jb.LevelName FROM tb_job_level jb WHERE jb.LevelID=tac.LevelTaskCcID)) AS LevelCcName2 FROM tb_task t ";
		$sql	.= "LEFT JOIN tb_task_priority tp ON tp.TaskPriorityID=t.TaskPriorityID ";
		$sql	.= "LEFT JOIN tb_task_status ts ON ts.TaskStatusID=t.TaskStatusID ";
		$sql	.= "LEFT JOIN tb_job_title js ON js.LevelID=t.LevelID ";
		$sql	.= "LEFT JOIN tb_task_assigned tas ON tas.TaskID=t.TaskID ";
		$sql	.= "LEFT JOIN tb_task_cc tac ON tac.TaskID=t.TaskID ";
		$sql 	.= "WHERE t.TaskID = '".$val."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		
		if(($LevelID==$row->LevelID or $LevelID=='1') and $row->TaskStatusID=='1') 
		{ 
			$display= "inline-block";
		}else{
			$display= "none";
		}
		
		if($row->TaskStatusID=='1') 
		{ 
			$displayc= "none";
			$displayo= "none";
		}else{
			$displayc= "inline-block";
			$displayo= "inline-block";
		}
		
		$show['task'] = array(
			'TaskID' => $val,
			'JobLevelID'	=> $row2->LevelID,
			'TaskName' => $row->TaskName,
			'LevelID' => $row->LevelID,
			'LevelName' => $row->LevelName,
			'LevelAssignedName' => $row->LevelAssignedName,
			'LevelCcName' => $row->LevelCcName,
			'TaskDescription' => $row->TaskDescription,
			'LevelTaskAssignedToID' => $row->LevelTaskAssignedToID,
			'LevelTaskCcID' => $row->LevelTaskCcID,
			'TaskStatusID' => $row->TaskStatusID,
			'TaskPriorityID' => $row->TaskPriorityID,
			'TaskCreatedDate' => $row->TaskCreatedDate,
			'TaskDueDate' => $row->TaskDueDate,
			'TaskCloseDate' => $row->TaskCloseDate,
			'TaskProgress' => $row->TaskProgress,
			'DisplayDone'	=> $display,
			'Displaycls'	=> $displayc,
			'Displayo'		=> $displayo
		);
		

					
		$sql3	= "SELECT tc.* ";
		$sql3	.= "FROM tb_task_comment tc ";
		$sql3	.= "LEFT JOIN tb_task t ON t.TaskID=tc.TaskID ";
		$sql3 	.= "WHERE t.TaskID = '".$val."' order by tc.TaskCommentID Desc";
		$query3 = $this->db->query($sql3);
		$result = $query3->row();
		if (empty($result)) {
			$show['comment'][] = array(
				'TaskCommentDescription' => "",
				'NameNow'	=> "",
				'TaskCommentDate'	=>""
			);
		}else{
			foreach ($query3->result() as $row3) {
				$show['comment'][] = array(
					'TaskCommentDescription' => $row3->TaskCommentDescription,
					'NameNow'	=> $row2->NameNow,
					'TaskCommentDate'	=>$row3->TaskCommentDate
				);
			}
		}
		
	    return $show;
	}
	function task_comment_act()
	{
		date_default_timezone_set("Asia/Jakarta");
		$taskid	= $this->input->post('taskid'); 
		$levelid 			= $this->input->post('levelid');
		$comment			= $this->input->post('comment'); 

		$task_comment = array(
			'TaskCommentDescription' => $comment,
			'TaskCommentDate' => date('Y-m-d H:i:s'),
			'EmployeeID'	=> $this->session->userdata('UserAccountID'),
			'LevelID' => $levelid,
			'TaskID'	=> $taskid
		);
		$this->db->insert('tb_task_comment', $task_comment);
	}
	function task_done()
	{
		date_default_timezone_set("Asia/Jakarta");
		$taskid	= $this->input->get('idt'); 
		$data = array(
			'TaskStatusID'=> '2'
		);

		$this->db->where('TaskID', $taskid);
		$this->db->update('tb_task', $data);
	}
	function task_on()
	{
		date_default_timezone_set("Asia/Jakarta");
		$taskid	= $this->input->get('idt'); 
		$data = array(
			'TaskStatusID'=> '1'
		);

		$this->db->where('TaskID', $taskid);
		$this->db->update('tb_task', $data);
	}

// =====================================================================
	function search_company()
	{
        $term   = $this->input->get('term');
		$sql 	= "select * from tb_job_company where ";
		$sql 	.= "CompanyName like '%".$term."%' ";
        $hasil  = $this->db->query($sql);
        if ($hasil->num_rows())
        { $data = array();
            foreach ($hasil->result() as $row) {
                $data[] = array(
                    'value' => $row->CompanyName,
                    'CompanyName' => $row->CompanyName,
                    'CompanyID' => $row->CompanyID,
                    'CompanyCode' => $row->CompanyCode
                    ); }
            echo json_encode($data);
        }
	}
	function get_company_code()
	{
        $term   = $this->input->get('data');
		$sql 	= "select * from tb_job_company where ";
		$sql 	.= "CompanyName = '".$term."' ";
        $hasil  = $this->db->query($sql);
        if ($hasil->num_rows())
        { $data = array();
            foreach ($hasil->result() as $row) {
                $data = array(
			        'CompanyID' => $row->CompanyID,
			        'CompanyName' => $row->CompanyName,
			        'CompanyCode' => $row->CompanyCode
			    ); 
            }
            echo json_encode($data);
        }
	}
	function fill_divisi()
	{
        $term   = $this->input->get('data');
		$sql 	= "SELECT * FROM tb_job_divisi where CompanyID = '".$term."' and DivisiStatus = 1";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'DivisiName' => $row->DivisiName,
				'DivisiID' => $row->DivisiID
			);
		};
		echo json_encode($show);
	}
	function get_divisi_code()
	{
        $term   = $this->input->get('data');
		$sql 	= "select * from tb_job_divisi where ";
		$sql 	.= "DivisiID = '".$term."' ";
        $hasil  = $this->db->query($sql);
        if ($hasil->num_rows())
        { $data = array();
            foreach ($hasil->result() as $row) {
                $data = array(
			        'DivisiID' => $row->DivisiID,
			        'DivisiName' => $row->DivisiName,
			        'DivisiCode' => $row->DivisiCode
			    ); 
            }
            echo json_encode($data);
        }
	}
	function fill_asset()
	{
		$sql 	= "SELECT * FROM tb_asset_main";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'AssetName' => strtoupper($row->AssetName),
				'AssetID' => $row->AssetID
			);
		};
		echo json_encode($show);
	}
	function fill_employee()
	{
		$sql 	= "SELECT EmployeeID, fullname FROM vw_employee2 where isActive=1 group by EmployeeID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'EmployeeID' => $row->EmployeeID,
				'EmployeeName' => $row->fullname
			);
		};
		if ($this->input->is_ajax_request()) {
			echo json_encode($show);
		} else {
			return $show;
		}
	}
	function fill_taskpriority()
	{
		$sql 	= "select * from tb_task_priority";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'TaskPriorityID' => $row->TaskPriorityID,
				'TaskPriorityName' => $row->TaskPriorityName
			);
		};
		echo json_encode($show);
	}
	function fill_tasklevel()
	{
		$sql 	= "select * from tb_job_level jb join tb_employee_main em on em.EmployeeID=jb.EmployeeID";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'LevelID' => $row->LevelID,
				'LevelName' => $row->LevelName,
				'Email'	=> $row->Email
			);
		};
		echo json_encode($show);
	}
	function fill_taskstatus()
	{
		$sql 	= "select * from tb_task_status";
		$result = "";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'TaskStatusID' => $row->TaskStatusID,
				'TaskStatusName' => $row->TaskStatusName
			);
		};
		echo json_encode($show);
	}
	function divisi_list_current()
	{
		$DivisiID 	= implode(',', $this->session->userdata('DivisiID'));
		$sql 	= "SELECT * FROM tb_job_divisi where DivisiID in (".$DivisiID.")";
		$query 	= $this->db->query($sql);
		$show	= $query->result_array();
		return $show;
	}
}
?>