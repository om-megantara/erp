<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{
		$this->session->sess_destroy();

		if( isset($_COOKIE['referrer_value']) and strpos( $_COOKIE['referrer_value'], "=" ) == true) {
    		setcookie('referrer_value', null, -1, '/');
		}
		$this->load->view('login');


	}
	public function cek()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		//$password = md5($password).sha1($password);
		$password = $password;
		$sql = "";

		//cek username, password, active employee dan active userAccount
		$sql 	= "select ua.* from vw_user_account ua  
					where ua.UserName = '".$username."' 
					and  ua.Password = '".$password."' 
					and ua.isActive = 1 ";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		if (!empty($row)) {	
		// ----------------------------------------------------
			// get data user
			$sql 	= "select ua.*, mp.MenuID, c.isEmployee, c.isSales from vw_user_account ua
						left join tb_menu_personal mp on (ua.UserAccountID = mp.UserAccountID)  
						left join tb_contact c on (ua.ContactID = c.ContactID)  
						WHERE ua.UserAccountID = '".$row->UserAccountID."'";
			$query2 = $this->db->query($sql); 
			$row2 	= $query2->row();
			$fullname 	= $row2->fullname;
			// ----------------------------------------------------

			// get hakAkses user
			$menu   = $row2->MenuID.",";
			$sql 	= "select * from tb_menu_group where UsergroupID in (".$row->UsergroupID.") ";
			$query3 = $this->db->query($sql);
			foreach ($query3->result() as $row3) {
				$menu .= $row3->UsergroupMenu.",";
			};
			$menu = str_replace(' ', '', $menu);
			$menu2 	= explode(",", $menu);
			$menu 	= implode("','", $menu2);

			$sql 	= "select * from tb_menu_list where MenuID in ('".$menu."')";
			$query4 = $this->db->query($sql);
			$menu_list = array();
			foreach ($query4->result() as $row4) {
				$menu_list[] = $row4->MenuName;
			};
			// ----------------------------------------------------
			
			// get siteConfig
			$sql 	= "select * from tb_site_config where id = '1'";
			$query5 = $this->db->query($sql);
			$row5 	= $query5->row();
			// ----------------------------------------------------

			// get EMployee
			$opts=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);  
			$imagedata 	= file_get_contents(base_url()."tool/profil.png", false, stream_context_create($opts));

			$DivisiID = array();
			if ($row2->isEmployee == 1) {
				$sql 	= "select em.EmployeeID, em.fProfile, em.JoinDate, ej.LevelCode
							from tb_employee_main em
							left join vw_employee_job ej on em.EmployeeID = ej.EmployeeID
							where ContactID =".$row2->ContactID;
				$query6 = $this->db->query($sql);
				$row6 	= $query6->row();
				$EmployeeID = $row6->EmployeeID;
				$JoinDate = $row6->JoinDate;
				$LevelCode = $row6->LevelCode;
				$fProfile = $row6->fProfile;

					// get DivisiID
					$sql 	= "SELECT DivisiID 
								FROM tb_job_level jl 
								WHERE EmployeeID=".$EmployeeID;
					$query6 = $this->db->query($sql);
					foreach ($query6->result() as $row6) {
						$DivisiID[] = $row6->DivisiID;
					};
			} else {
				$EmployeeID = 0;
				$JoinDate = "";
				$LevelCode = "";
				$fProfile = $imagedata;
			}
			// ----------------------------------------------------

			// get Sales
			if ($row2->isSales == 1) {
				$sql 	= "select SalesID from tb_sales_executive where ContactID =".$row2->ContactID;
				$query7 = $this->db->query($sql);
				$row7 	= $query7->row();
				$SalesID = $row7->SalesID;
			} else {
				$SalesID = 0;
			}
			// ----------------------------------------------------

			
			// hasil pengambilan data di daftarkan kedalam session
			$newdata = array(
				'UserAccountID' => $row2->UserAccountID,
				'ContactID' => $row2->ContactID,
				'EmployeeID' => $EmployeeID,
				'SalesID' => $SalesID,
				'UserName' => $fullname,

				'CreatedDate' => $JoinDate,
				'JobTitleCode' => $LevelCode,
				'DivisiID' => $DivisiID,
				'MenuList' => $menu_list,
				'image' => $fProfile,
				'login_status' => "1",
				'error_info' => "",

				'ReportPaging'  => $row5->ReportPaging,
				'ReportPagingDefault' => $row5->ReportPagingDefault,
				'ReportResult' => $row5->ReportResult,
				
	  			'TitleMenuMini' => $row5->TitleMenuMini,
	  			'TitleMenuFull' => $row5->TitleMenuFull,
	  			'MainTitle' => $row5->MainTitle,
	  			'MainWarning' => $row5->MainWarning,
	  			'MainInfo' => $row5->MainInfo,
	  			// 'HeaderFaktur1' => $row5->HeaderFaktur1
		   	);
			$this->session->set_userdata($newdata);
			// ----------------------------------------------------

			// setting cookies jika timeout logout
			if(isset($_COOKIE['referrer_value']) and $_COOKIE['referrer_value']!=="" and substr($_COOKIE['referrer_value'], -5) != "login") {
				redirect($_COOKIE['referrer_value']);
			} else {
				redirect(base_url('main'));
			}
			// ----------------------------------------------------

		}
		else { 
			$this->session->sess_destroy(); 
			redirect(base_url(''));
		}
	}
	public function logout()
	{
		$this->session->sess_destroy(); 
		redirect(base_url('login'));
	}
	public function logAs()
	{
	    date_default_timezone_set('Asia/Jakarta');
        // cek login
	    $this->load->library('Auth');
	    $this->auth->cek();
        // cek hak akses
	    $this->auth->cek2('menu_app_administration');
	    // save log
	    $this->log_user->log_page();
	    
		$UserAccountID = $this->input->get('id'); 
		$sql 	= "select ua.* from tb_user_account ua 
					where ua.UserAccountID = ".$UserAccountID." and ua.isActive = 1";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		if (!empty($row)) {	
			// get data user
			$sql 	= "select ua.*, mp.MenuID, c.isEmployee, c.isSales from vw_user_account ua
						left join tb_menu_personal mp on (ua.UserAccountID = mp.UserAccountID)  
						left join tb_contact c on (ua.ContactID = c.ContactID)  
						WHERE ua.UserAccountID = '".$UserAccountID."'";
			$query2 = $this->db->query($sql); 
			$row2 	= $query2->row();
			$fullname 	= $row2->fullname;
			// ----------------------------------------------------

			// get hakAkses user
			$menu   = $row2->MenuID.",";
			$sql 	= "select * from tb_menu_group where UsergroupID in (".$row->UsergroupID.") ";
			$query3 = $this->db->query($sql);
			foreach ($query3->result() as $row3) {
				$menu .= $row3->UsergroupMenu.",";
			};
			$menu = str_replace(' ', '', $menu);
			$menu2 	= explode(",", $menu);
			$menu 	= implode("','", $menu2);

			$sql 	= "select * from tb_menu_list where MenuID in ('".$menu."')";
			$query4 = $this->db->query($sql);
			$menu_list = array();
			foreach ($query4->result() as $row4) {
				$menu_list[] = $row4->MenuName;
			};
			// ----------------------------------------------------
			
			// get siteConfig
			$sql 	= "select * from tb_site_config where id = '1'";
			$query5 = $this->db->query($sql);
			$row5 	= $query5->row();
			// ----------------------------------------------------
			 
			// get EMployee
			$opts=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);  
			$imagedata 	= file_get_contents(base_url()."tool/profil.png", false, stream_context_create($opts));

			$DivisiID = array();
			if ($row2->isEmployee == 1) {
				$sql 	= "select em.EmployeeID, em.fProfile, em.JoinDate, ej.LevelCode
							from tb_employee_main em
							left join vw_employee_job ej on em.EmployeeID = ej.EmployeeID
							where ContactID =".$row2->ContactID;
				$query6 = $this->db->query($sql);
				$row6 	= $query6->row();
				$EmployeeID = $row6->EmployeeID;
				$JoinDate = $row6->JoinDate;
				$LevelCode = $row6->LevelCode;
				$fProfile = $row6->fProfile;

					// get DivisiID
					$sql 	= "SELECT DivisiID 
								FROM tb_job_level jl 
								WHERE EmployeeID=".$EmployeeID;
					$query6 = $this->db->query($sql);
					foreach ($query6->result() as $row6) {
						$DivisiID[] = $row6->DivisiID;
					};
			} else {
				$EmployeeID = 0;
				$JoinDate = "";
				$LevelCode = "";
				$fProfile = $imagedata;
			}
			// ----------------------------------------------------

			// get Sales
			if ($row2->isSales == 1) {
				$sql 	= "select SalesID from tb_sales_executive where ContactID =".$row2->ContactID;
				$query7 = $this->db->query($sql);
				$row7 	= $query7->row();
				$SalesID = $row7->SalesID;
			} else {
				$SalesID = 0;
			}
			// ----------------------------------------------------
			
			
			// hasil pengambilan data di daftarkan kedalam session
			$newdata = array(
				'UserAccountID' => $row2->UserAccountID,
				'ContactID' => $row2->ContactID,
				'EmployeeID' => $EmployeeID,
				'SalesID' => $SalesID,
				'UserName' => $fullname,

				'CreatedDate' => $JoinDate,
				'JobTitleCode' => $LevelCode,
				'DivisiID' => $DivisiID,
				'MenuList' => $menu_list,
				'image' => $fProfile,
				'login_status' => "1",
				'error_info' => "",

				'ReportPaging'  => $row5->ReportPaging,
				'ReportPagingDefault' => $row5->ReportPagingDefault,
				'ReportResult' => $row5->ReportResult,
				
	  			'TitleMenuMini' => $row5->TitleMenuMini,
	  			'TitleMenuFull' => $row5->TitleMenuFull,
	  			'MainTitle' => $row5->MainTitle,
	  			'MainWarning' => $row5->MainWarning,
	  			'MainInfo' => $row5->MainInfo,
	  			// 'HeaderFaktur1' => $row5->HeaderFaktur1
		   	);
			$this->session->set_userdata($newdata);
			// ----------------------------------------------------
		}
		redirect(base_url('main'));
	}

	public function send_email()
	{
		$email_dest = $this->input->post('email');
		$sql 	= "SELECT * FROM vw_user_account ua 
					WHERE ua.Email = '".$email_dest."'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		if (!empty($row)) {
			$str = explode("@",$email_dest);
			$str = explode(".",$str[0]);
			$new = $str[0].date("d").date("H").date("s");
			$new2 = md5($new).sha1($new); //password baru
			$data = array(
				'Password'=> $new2,
			);
			$this->db->where('UserAccountID', $row->UserAccountID);
			$this->db->update('tb_user_account', $data); //update password baru

			$config = Array(
			    'protocol' => 'smtp',
			    'smtp_host' => 'smtp.angzdna.net',
			    'smtp_port' => 587,
			    'smtp_user' => 'bo.system.angzdna.net',
			    'smtp_pass' => 'systemboanghauz',
			    'mailtype'  => 'html', 
			    'charset'   => 'iso-8859-1'
			);
			$this->load->library('email', $config);

			$this->email->from('bo.system@angzdna.net', 'Anghauz Backoffice System');
			$this->email->to($email_dest);
			$list = array('abdul.basith@angzdna.net', 'andhika.septiono@angzdna.net');
			$this->email->cc($list);
			$this->email->subject('Request New Password');
			$this->email->message('New Password has Requested for Account : '.$row->Username.'<br> Here your New Password : '.$new);

			$this->email->send(); //kirim email
			echo json_encode("success"); //kirim pesan sukses
		} else {
			echo json_encode("fail"); //kirim pesan gagal
		}
	}

	public function upload()
	{
		$opts=array(
		    "ssl"=>array(
		        "verify_peer"=>false,
		        "verify_peer_name"=>false,
		    ),
		);  
		$files = glob('assets/foto/*'); 
		for ($i=0; $i < count($files) ; $i++) { 
			$file 			= explode("/", $files[$i]);
		  	$target_file 	= "assets/foto/" . $file[2];
		  	$foto 			= addslashes(file_get_contents($target_file), false, stream_context_create($opts));
		  	$namefile 		= explode(".", $file[2]);
		  	echo $namefile[0]."<br>";

			$strsql = "update tb_employee_main set fProfile='".$foto."' where BioID='".$namefile[0]."'";

			$this->db->query($strsql);
			$this->db->affected_rows();
		}
	}
}