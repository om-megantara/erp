<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_finance extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }

//bank_transaction============================================================
	function bank_transaction()
	{
		$sql = "SELECT tbm.*, bm.*, c.Company2 FROM tb_bank_transaction tbm ";
		$sql .= "LEFT JOIN tb_customer_main cm ON tbm.DepositCustomer = cm.CustomerID ";
		$sql .= "LEFT JOIN vw_contact2 c ON cm.ContactID = c.ContactID ";
		$sql .= "LEFT JOIN tb_bank_main bm ON bm.BankID = tbm.BankID ";

		if (isset($_REQUEST['bank']) && $_REQUEST['bank'] != 0) {
			$sql .= "where tbm.BankID =".$_REQUEST['bank']." ";
		} else {
			$sql .= "where tbm.BankID !=0 ";
		}
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and ( BankTransactionDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' )";
		} else {
			$sql .= "and ( MONTH(BankTransactionDate) = MONTH(CURRENT_DATE()) AND YEAR(BankTransactionDate) = YEAR(CURRENT_DATE()) ) ";
		}

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'Customer':
						$sql .= "DepositCustomer in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					default:
						$sql .= $atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( empty($_POST) ) {
			$sql .= "ORDER BY tbm.BankTransactionID desc limit ".$this->limit_result."";
		}
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show['main'][] = array(
		  			'BankTransactionID' => $row->BankTransactionID,
		  			'BankName' => $row->BankName,
		  			'BankTransactionDate' => $row->BankTransactionDate,
					'BankTransactionNote' => $row->BankTransactionNote,
					'BankTransactionType' => $row->BankTransactionType,
		  			'BankTransactionAmount' => $row->BankTransactionAmount,
		  			'BankTransactionBalance' => $row->BankTransactionBalance,
		  			'DepositCustomer' => $row->DepositCustomer,
		  			'IsDeposit' => $row->IsDeposit,
		  			'fullname' => $row->Company2
				);
		};

		$sql2 	= "SELECT * FROM tb_bank_main";
		$query2 	= $this->db->query($sql2);
		foreach ($query2->result() as $row) {
		  	$show['bank'][] = array(
		  			'BankName' => $row->BankName,
		  			'BankBalance' => $row->BankBalance
				);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function bank_transaction_add()
	{
		$this->db->trans_start();

		$bank 	= $this->input->post('bank'); 
		$bmdate = $this->input->post('bmdate');
		$bmnote = $this->input->post('bmnote'); 
		$bmtype = $this->input->post('bmtype');
		$bmamount = $this->input->post('bmamount'); 
		$year 	= date('y', strtotime($bmdate));
		$month 	= date('m', strtotime($bmdate));
		$day 	= date('d', strtotime($bmdate));
		$hour 	= date('H', strtotime($bmdate));
		$minute = date('i', strtotime($bmdate));
		$second = date('s', strtotime($bmdate));
		$BankTransactionIDNew = $year.$month.$day.$hour.$minute.$second."00";
		$this->insert_transaction($BankTransactionIDNew, $bank, $bmdate, $bmnote, $bmtype, $bmamount);

		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_transaction_add_under($INVID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding)
	{
		$this->db->trans_start();

		$sql 		= "select BankDistributionAddAutoIn, BankDistributionAddAutoOut, bt.BankID from tb_site_config sc 
						left join tb_bank_distribution_type bt on sc.BankDistributionAddAutoIn=bt.DistributionTypeID";
		$getrow 	= $this->db->query($sql);
		$row4 		= $getrow->row();

		$bank 	= $row4->BankID;
		$bmtype = 'debit'; 
		$note = 'auto generate for INV'.$INVID;

		$bmdata = array(
			'BankTransactionID' => $BankTransactionID,
			'BankID' => $bank,
			'BankTransactionDate' => $BankTransactionDate,
			'BankTransactionType' => 'debit',
			'BankTransactionAmount'	=> $TotalOutstanding,
			'BankTransactionBalance' => 0,
			'BankTransactionNote' => $note,
			'BankBranch' => '0',
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		$this->last_query .= "//".$this->db->last_query();

		$bmdata = array(
			'BankTransactionID' => $BankTransactionID+1,
			'BankID' => $bank,
			'BankTransactionDate' => $BankTransactionDate,
			'BankTransactionType' => 'credit',
			'BankTransactionAmount'	=> $TotalOutstanding,
			'BankTransactionBalance' => 0,
			'BankTransactionNote' => $note,
			'BankBranch' => '0',
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		$this->last_query .= "//".$this->db->last_query(); 
		
		$this->arrange_bank_balance($bank, $BankTransactionDate);
 
		$this->bank_distribution_add_auto($row4->BankDistributionAddAutoIn, $TotalOutstanding, $note, 'company',0,'',$BankTransactionID);
		$this->bank_distribution_add_auto($row4->BankDistributionAddAutoOut, $TotalOutstanding, $note, 'company',0,'',$BankTransactionID+1);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_transaction_add_under2($SOID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding)
	{
		$this->db->trans_start();

		$sql 		= "select BankDistributionAddAutoIn, BankDistributionAddAutoOut, bt.BankID from tb_site_config sc 
						left join tb_bank_distribution_type bt on sc.BankDistributionAddAutoIn=bt.DistributionTypeID";
		$getrow 	= $this->db->query($sql);
		$row4 		= $getrow->row();

		$bank 	= $row4->BankID;
		$bmtype = 'debit'; 
		$note = 'auto generate for SO '.$SOID;

		$bmdata = array(
			'BankTransactionID' => $BankTransactionID,
			'BankID' => $bank,
			'BankTransactionDate' => $BankTransactionDate,
			'BankTransactionType' => 'debit',
			'BankTransactionAmount'	=> $TotalOutstanding,
			'BankTransactionBalance' => 0,
			'BankTransactionNote' => $note,
			'BankBranch' => '0',
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		$this->last_query .= "//".$this->db->last_query();

		$bmdata = array(
			'BankTransactionID' => $BankTransactionID+1,
			'BankID' => $bank,
			'BankTransactionDate' => $BankTransactionDate,
			'BankTransactionType' => 'credit',
			'BankTransactionAmount'	=> $TotalOutstanding,
			'BankTransactionBalance' => 0,
			'BankTransactionNote' => $note,
			'BankBranch' => '0',
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		$this->last_query .= "//".$this->db->last_query();

		$this->arrange_bank_balance($bank, $BankTransactionDate);

		$this->bank_distribution_add_auto($row4->BankDistributionAddAutoIn, $TotalOutstanding, $note, 'company',0,'',$BankTransactionID);
		$this->bank_distribution_add_auto($row4->BankDistributionAddAutoOut, $TotalOutstanding, $note, 'company',0,'',$BankTransactionID+1);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_transaction_add_import_inv($INVID, $BankTransactionDate, $BankTransactionAmount)
	{
		$this->db->trans_start();

		$sql 		= "select BankDistributionAddAutoIn, BankDistributionAddAutoOut, bt.BankID from tb_site_config sc 
						left join tb_bank_distribution_type bt on sc.BankDistributionAddAutoIn=bt.DistributionTypeID";
		$getrow 	= $this->db->query($sql);
		$row4 		= $getrow->row();

		$bank 	= $row4->BankID;
		$bmdate = $BankTransactionDate." 00:00:00";
		$bmnote = 'pelunasan INV lama ID '.$INVID; 
		$bmtype = 'debit';
		$bmamount = $BankTransactionAmount; 
		$year 	= date('y', strtotime($bmdate));
		$month 	= date('m', strtotime($bmdate));
		$day 	= date('d', strtotime($bmdate));
		$BankTransactionIDNew = $year.$month.$day;

		$sql 	= "SELECT * FROM tb_bank_transaction WHERE BankTransactionID like '%".$BankTransactionIDNew."%' AND BankID = ".$bank;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		if (!empty($row)) {
			$sql 		= "SELECT * FROM tb_bank_transaction 
							WHERE BankTransactionID like '%".$BankTransactionIDNew."%' 
							AND BankID = ".$bank." ORDER BY BankTransactionID DESC LIMIT 1";
			$getbalance = $this->db->query($sql);
			$row2 		= $getbalance->row();
			$BankTransactionIDNew = $row2->BankTransactionID +1;
			$BankTransactionIDNew2 = $row2->BankTransactionID +1; 
		} else {
			$BankTransactionIDNew = $year.$month.$day."00000000";
			$BankTransactionIDNew2 = $year.$month.$day."00000000"; 
		}

		// echo $balancenext."<br>";
		$bmdata = array(
			'BankTransactionID' => $BankTransactionIDNew,
			'BankID' => $bank,
			'BankTransactionDate' => $bmdate,
			'BankTransactionType' => $bmtype,
			'BankTransactionAmount'	=> $bmamount,
			'BankTransactionBalance' => 0,
			'BankBranch' => '0',
			'BankTransactionNote' => $bmnote,
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		// $this->last_query .= "//".$this->db->last_query();
		 
		$this->arrange_bank_balance($bank, $bmdate);

		$this->db->trans_complete();
		return $BankTransactionIDNew;
	}
	function bank_transaction_add_import_dp_free($CustomerID, $Company, $BankTransactionAmount)
	{
		$this->db->trans_start();

		$sql 		= "select BankDistributionAddAutoIn, BankDistributionAddAutoOut, bt.BankID from tb_site_config sc 
						left join tb_bank_distribution_type bt on sc.BankDistributionAddAutoIn=bt.DistributionTypeID";
		$getrow 	= $this->db->query($sql);
		$row4 		= $getrow->row();

		$bank 	= $row4->BankID;
		$bmdate = "2019-06-01 14:00:00";
		$bmnote = 'Deposit Free '.$CustomerID.' - '.$Company; 
		$bmtype = 'debit';
		$bmamount = $BankTransactionAmount; 
		$year 	= date('y', strtotime($bmdate));
		$month 	= date('m', strtotime($bmdate));
		$day 	= date('d', strtotime($bmdate));
		$BankTransactionIDNew = $year.$month.$day;

		$sql 	= "SELECT * FROM tb_bank_transaction WHERE BankTransactionID like '%".$BankTransactionIDNew."%' AND BankID = ".$bank;
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		if (!empty($row)) {
			$sql 		= "SELECT * FROM tb_bank_transaction WHERE BankTransactionID like '%".$BankTransactionIDNew."%'";
			$sql 		.= " AND BankID = ".$bank." ORDER BY BankTransactionID DESC LIMIT 1";
			$getbalance = $this->db->query($sql);
			$row2 		= $getbalance->row();
			$BankTransactionIDNew = $row2->BankTransactionID +1;
			$BankTransactionIDNew2 = $row2->BankTransactionID +1; 
		} else {
			$BankTransactionIDNew = $year.$month.$day."00000000";
			$BankTransactionIDNew2 = $year.$month.$day."00000000"; 
		}

		// echo $balancenext."<br>";
		$bmdata = array(
			'BankTransactionID' => $BankTransactionIDNew,
			'BankID' => $bank,
			'BankTransactionDate' => $bmdate,
			'BankTransactionType' => $bmtype,
			'BankTransactionAmount'	=> $bmamount,
			'BankTransactionBalance' => 0,
			'BankBranch' => '0',
			'BankTransactionNote' => $bmnote,
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		// $this->last_query .= "//".$this->db->last_query();
		$this->arrange_bank_balance($bank, $bmdate);
		  
		$this->db->trans_complete();
	    // return $this->db->trans_status();
		return $BankTransactionIDNew;
	}
	function excel_transaction($data, $note)
    {
		$this->db->trans_start();

		$filterupload = $this->input->post('filterupload');
		$bank2 	= $this->input->post('bank2');
		
		$year 	= date('y', strtotime($filterupload));
		$month 	= date('m', strtotime($filterupload));
		$day 	= date('d', strtotime($filterupload));
		$hour 	= date('H', strtotime($filterupload));
		$minute = date('i', strtotime($filterupload));
		$second = date('s', strtotime($filterupload));
		$BankTransactionIDNew = $year.$month.$day.$hour.$minute.$second."00";

		$AllBankTransactionID = array();

		$this->db->select('BankTransactionID, BankTransactionNote');
		$this->db->where_in('BankTransactionNote', $note);
		$query = $this->db->get('tb_bank_transaction');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$newdata['error_info'] = "upload excel gagal, transaksi sudah pernah upload dengan note : '".$row->BankTransactionNote."' ";
			$this->session->set_userdata($newdata);
		} else {
			foreach ($data as $key => $value) {
				$BankTransactionIDNew++;
				$dekre = substr($value[3], -2);
				$hapus = array(" DB"," CR",",");
				$dekrenumb = floatval(str_replace($hapus,"",$value[3]));
				$salnumb = floatval(str_replace($hapus,"",$value[4]));
				if($dekre=='DB'){
					$dekreval='credit';
				}elseif($dekre=='CR'){
					$dekreval='debit';
				}
				
				$data_transaction = array(
					'BankTransactionID' => $BankTransactionIDNew,
					'BankID' => $bank2,
					'BankTransactionDate' => $filterupload,
					'BankTransactionType' => $dekreval,
					'BankTransactionAmount'	=> $dekrenumb,
					'BankTransactionBalance' => 0,
					'BankBranch' => $value[2],
					'BankTransactionNote' => $value[1],
					'InsertDate' => date("Y-m-d H:i:s"),
					'InsertBy' => $this->session->userdata('UserAccountID')
				);
				
				$this->db->insert('tb_bank_transaction', $data_transaction);
				$this->last_query .= "//".$this->db->last_query();

		   		$this->db->set('BankTransactionID', $BankTransactionIDNew);
				$this->db->where('DistributionID', $value[5]);
				$this->db->update('tb_bank_distribution_main');

				$AllBankTransactionID[] = $BankTransactionIDNew;
			}   
			$this->arrange_bank_balance($bank2, $filterupload);

			// auto payment-deposit
			$paymentdeposit = $this->input->get_post('paymentdeposit');
			if (isset($paymentdeposit) and count($AllBankTransactionID)>0) {
				if ($paymentdeposit == 'auto_mpinv') {
					$this->excel_auto_payment_deposit_mpinv($AllBankTransactionID);
				} elseif ($paymentdeposit == 'auto_soinv') {
					$this->excel_auto_payment_deposit_soinv($AllBankTransactionID);
				}
			}
		}
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	} 
    function transaction_setasdesposit()
	{
		$this->db->trans_start();
		$data 	= $this->input->get_post('data');
		$this->load->model('model_acc');
		$DistributionIDFree = $this->model_acc->auto_journal_insert_customer_deposit($data);

		if (count($DistributionIDFree) > 0 ) {
			$sql = "UPDATE tb_bank_transaction set IsDeposit = 1 WHERE BankTransactionID in ( 
					select dm.BankTransactionID from tb_bank_distribution_main dm 
					where dm.DistributionID in (". implode(',', $DistributionIDFree) .")
			)";

			$show['TransactionTotal'] = count($data);
			$show['TransactionSuccess'] = count($DistributionIDFree);
			$show['TransactionFail'] = $show['TransactionTotal'] - $show['TransactionSuccess'];
		} else {
			$sql = "UPDATE tb_bank_transaction set IsDeposit = 1 WHERE BankTransactionID in (". implode(',', $data) .")";

			$show['TransactionTotal'] = count($data);
			$show['TransactionSuccess'] = count($data);
			$show['TransactionFail'] = 0;
		}
		$query 	= $this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		echo json_encode($show);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
    function transaction_undodesposit()
	{
		$this->db->trans_start();
		$data 	= $this->input->get_post('data');

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_cancel_customer_deposit($data);
		
		$sql 	= "UPDATE tb_bank_transaction set IsDeposit=null WHERE BankTransactionID in (". implode(',', $data) .") and DepositDate is null";
		$query 	= $this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // echo $this->last_query;
	}
	function transaction_delete()
	{
		$this->db->trans_start();

		$data 	= $this->input->get_post('data');

		$sql 	= "select * from tb_bank_transaction where BankTransactionID in (". implode(',', $data) .") and IsDeposit is not null";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		if (empty($row)) {
			$sql 	= "select BankID, BankTransactionDate from tb_bank_transaction where BankTransactionID=".$data[0];
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$BankID = $row->BankID;
			$BankTransactionDate = $row->BankTransactionDate;

			$this->db->where_in('BankTransactionID', $data);
			$this->db->delete('tb_bank_transaction');
			$this->last_query .= "//".$this->db->last_query();

			$this->arrange_bank_balance($BankID, $BankTransactionDate);

			// for delete journal
			$this->db->select('DistributionID');
			$this->db->from('tb_bank_distribution_main');
			$this->db->where_in('BankTransactionID', $data);
			$query = $this->db->get();
			$DistributionID = array();
			foreach ($query->result() as $row) {
			        $DistributionID[] = $row->DistributionID;
			}
			if (!empty($DistributionID)) {
		    	$this->load->model('model_acc');
		    	$this->model_acc->auto_journal_delete_transaction($DistributionID, $BankID);
		    }
	    	// -----------------------------------------------

			$this->db->set('BankTransactionID', '0');
			$this->db->where_in('BankTransactionID', $data);
			$this->db->update('tb_bank_distribution_main');
			$this->last_query .= "//".$this->db->last_query();
			// echo json_encode($DistributionID);
			echo json_encode("success");
		} else {
			echo json_encode("fail");
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function transaction_recalculate()
	{
		$this->db->trans_start();
		$BankID 	= $this->input->get_post('bank');
		$DateCalculate 	= $this->input->get_post('DateCalculate');
		$this->arrange_bank_balance($BankID, $DateCalculate);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function cekAmountTransaction()
	{
		$BankTransactionID 	= $this->input->post('BankTransactionID'); 
		$sql 	= "SELECT BankTransactionAmount FROM tb_bank_transaction WHERE BankTransactionID=".$BankTransactionID." AND IsDeposit is null";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();

		$BankTransactionAmount = 0;
		if (!empty($row)) {	
			$BankTransactionAmount 	= $row->BankTransactionAmount;
		}
		echo json_encode($BankTransactionAmount);
	}
	function insert_transaction($BankTransactionIDNew, $BankID, $date, $note, $type, $amount )
	{
		$this->db->trans_start();
 
		$bmdata = array(
			'BankTransactionID' => $BankTransactionIDNew,
			'BankID' => $BankID,
			'BankTransactionDate' => $date,
			'BankTransactionType' => $type,
			'BankTransactionAmount'	=> $amount,
			'BankTransactionBalance' => 0,
			'BankBranch' => '0',
			'BankTransactionNote' => $note,
			'InsertDate' => date("Y-m-d H:i:s"),
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_bank_transaction', $bmdata);
		$this->last_query .= "//".$this->db->last_query();
 
		$this->arrange_bank_balance($BankID, $BankTransactionDate);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_transaction_daily_report()
	{
		$BankID = $_REQUEST['bank'];
		$bmdateStart = $_REQUEST['bmdateStart'];
		$bmdateEnd	 = $_REQUEST['bmdateEnd'];
		$addMain = $_REQUEST['addMain'];
		$addDetailAmount = $_REQUEST['addDetailAmount'];
		$show   = array();

		$sql 	= "SELECT bm.*, jc.* FROM tb_bank_main bm 
					LEFT JOIN tb_job_company jc ON bm.CompanyID=jc.CompanyID 
					where BankID=".$BankID;
		$getrow	= $this->db->query($sql);
		$rowmain 	= $getrow->row();
		$show['main'] = (array) $rowmain;
		$show['main']['Date'] = $bmdateStart ." <=> ". $bmdateEnd;

		$sql 		= "SELECT BankTransactionBalance FROM tb_bank_transaction bt 
						WHERE BankID = ".$BankID." and DATE(BankTransactionDate)<'".$bmdateStart."' 
						ORDER BY BankTransactionID desc LIMIT 1";
		$getbalance = $this->db->query($sql);
		$row2 		= $getbalance->row();
		$show['main']['SaldoAwal'] = ( !empty($row2) ? $row2->BankTransactionBalance : 0 );
		$show['main']['addMain'] = $addMain;
		$show['main']['addDetailAmount'] = $addDetailAmount;

		$sql = "SELECT bt.*, dm.DistributionID, dm.DistributionNumber
				FROM tb_bank_transaction bt 
				LEFT JOIN tb_bank_distribution_main dm ON bt.BankTransactionID=dm.BankTransactionID
				WHERE bt.BankID='".$BankID."' and BankTransactionDate between '".$bmdateStart." 00:00:00' and '".$bmdateEnd." 23:59:59'  
				ORDER BY bt.BankTransactionType desc, bt.BankTransactionID";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
	  			'IsDeposit' => $row->IsDeposit,
	  			'BankTransactionID' => $row->BankTransactionID,
	  			'BankTransactionDate' => $row->BankTransactionDate,
	  			'BankTransactionType' => $row->BankTransactionType,
	  			'BankTransactionNote' => $row->BankTransactionNote,
	  			'BankTransactionAmount' => $row->BankTransactionAmount,
	  			'DistributionID' => $row->DistributionID,
	  			'DistributionNumber' => $row->DistributionNumber,
			);
		};
	    return $show;
		// echo json_encode($show);
	}
	function arrange_bank_balance($BankID, $date)
	{
		$this->db->trans_start();

		$balancenext = 0;
		$sql 	= "SELECT BankTransactionBalance, BankTransactionDate 
					FROM tb_bank_transaction 
					WHERE BankID=".$BankID." and BankTransactionDate<'".$date."' 
					order by BankTransactionDate desc, BankTransactionID desc limit 1";
		$getrow	= $this->db->query($sql);
		$row 	= $getrow->row();
		$balancenext = (empty($row)) ? 0 : $row->BankTransactionBalance ;
		
		$sql = "UPDATE tb_bank_transaction r2, (
					SELECT t2.BankTransactionID, t2.BankTransactionAmount, t2.BankTransactionBalance, 
						@BalanceResult := (
							IF(t2.BankTransactionType='debit', @BalanceResult+t2.BankTransactionAmount, @BalanceResult-t2.BankTransactionAmount)
						) AS BankTransactionBalanceResult
					FROM ( 
						SELECT t1.* FROM tb_bank_transaction t1
						WHERE t1.BankTransactionDate>='".$date."' AND t1.BankID = ".$BankID."
						ORDER BY t1.BankTransactionDate asc, t1.BankTransactionID asc
					) t2
					JOIN (SELECT @BalanceResult:=".$balancenext."
					) r 
					
				) r1
				SET r2.BankTransactionBalance = r1.BankTransactionBalanceResult
				WHERE r2.BankTransactionID = r1.BankTransactionID";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$sql = "UPDATE tb_bank_main t, 
				(SELECT BankTransactionID, BankID, BankTransactionBalance
				FROM tb_bank_transaction bt WHERE BankID=".$BankID." 
				ORDER BY BankTransactionID DESC LIMIT 1) t1
				SET t.BankBalance = t1.BankTransactionBalance
				WHERE t.BankID = t1.BankID";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();
 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function excel_auto_payment_deposit_mpinv($AllBankTransactionID)
	{
		$this->db->trans_start();
		$sql = "SELECT t1.*, COALESCE(sm.SOID,0) AS SOID, sm.CustomerID, COALESCE(im.INVID,0) AS INVID
				FROM (
					SELECT bt.BankTransactionID, bt.BankTransactionDate, bt.BankTransactionAmount, 
					substring_index(substring_index(bt.BankTransactionNote, '#', 2), '#', -1) AS INVMP
					FROM tb_bank_transaction bt 
					WHERE bt.BankTransactionID IN (" . implode(',', array_map('intval', $AllBankTransactionID)) . ")
				) AS t1
				LEFT JOIN tb_so_main2 sm2 ON t1.INVMP=sm2.INVMP
				LEFT JOIN tb_so_main sm ON sm2.SOID=sm.SOID 
				LEFT JOIN tb_invoice_main im ON im.SOID=sm.SOID 
				GROUP BY sm.SOID";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			if ($row->INVID != 0) {
				$this->model_finance->confirmation_deposit_distribution_act_under($row->SOID, $row->INVID, $row->CustomerID, $row->BankTransactionID, $row->BankTransactionDate, $row->BankTransactionAmount); 
				$this->cek_inv_outstanding_payment($row->INVID);
			} elseif ($row->SOID != 0) {
				$this->model_finance->confirmation_deposit_allocation_act_under($row->SOID, $row->CustomerID, $row->BankTransactionID, $row->BankTransactionDate, $row->BankTransactionAmount); 
				$this->cek_so_outstanding_deposit($row->SOID);
			}
		};
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	}
	function excel_auto_payment_deposit_soinv($AllBankTransactionID)
	{
		$this->db->trans_start();
		$sql = "(
					SELECT t1.*, COALESCE(sm.SOID,0) AS SOID, sm.CustomerID, 0 AS INVID 
					FROM (
						SELECT bt.BankTransactionID, bt.BankTransactionDate, bt.BankTransactionAmount, 
						substring_index(substring_index(bt.BankTransactionNote, '#', 2), '#', -1) AS Type,
						substring_index(substring_index(bt.BankTransactionNote, '#', 3), '#', -1) AS ID
						FROM tb_bank_transaction bt 
						WHERE bt.BankTransactionID IN (" . implode(',', array_map('intval', $AllBankTransactionID)) . ")
					) AS t1 
					LEFT JOIN tb_so_main sm ON t1.ID=sm.SOID
					WHERE t1.Type = 'SO'
				) UNION (
					SELECT t1.*, im.SOID, im.CustomerID, COALESCE(im.INVID,0) AS INVID
					FROM (
						SELECT bt.BankTransactionID, bt.BankTransactionDate, bt.BankTransactionAmount, 
						substring_index(substring_index(bt.BankTransactionNote, '#', 2), '#', -1) AS Type,
						substring_index(substring_index(bt.BankTransactionNote, '#', 3), '#', -1) AS ID
						FROM tb_bank_transaction bt 
						WHERE bt.BankTransactionID IN (" . implode(',', array_map('intval', $AllBankTransactionID)) . ")
					) AS t1 
					LEFT JOIN tb_invoice_main im ON t1.ID=im.INVID
					WHERE t1.Type = 'INV'
				)";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
			if ($row->Type == 'SO') {
				$this->model_finance->confirmation_deposit_allocation_act_under($row->SOID, $row->CustomerID, $row->BankTransactionID, $row->BankTransactionDate, $row->BankTransactionAmount); 
				$this->cek_so_outstanding_deposit($row->SOID);
			} elseif ($row->Type == 'INV') {
				$this->model_finance->confirmation_deposit_distribution_act_under($row->SOID, $row->INVID, $row->CustomerID, $row->BankTransactionID, $row->BankTransactionDate, $row->BankTransactionAmount); 
				$this->cek_inv_outstanding_payment($row->INVID);
			}
		};
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	}

//confirmation_deposit========================================================
	function confirmation_deposit()
	{
		$sql = "SELECT tbm.*, bm.*, cm.ContactID, cm.CustomerID, c.Company2, cd.DepositID, cd.SourceReff FROM tb_bank_transaction tbm ";
		$sql .= "LEFT JOIN tb_bank_main bm ON bm.BankID = tbm.BankID ";
		$sql .= "LEFT JOIN tb_customer_main cm ON tbm.DepositCustomer = cm.CustomerID ";
		$sql .= "LEFT JOIN vw_contact2 c ON cm.ContactID = c.ContactID ";
		$sql .= "LEFT JOIN tb_customer_deposit cd ON tbm.BankTransactionID=cd.SourceReff and cd.SourceType='BankTransaction' ";
		$sql .= "WHERE IsDeposit=1 ";
		
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and BankTransactionDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} 
		if (isset($_REQUEST['bank']) && $_REQUEST['bank'] != 0) {
			$sql .= "and tbm.BankID =".$_REQUEST['bank']." ";
		} 

		if ( isset($_REQUEST['atributeid']) ) {
			$sql .= "and (";
			$atributeid = $_REQUEST['atributeid'];
			$atributevalue = $_REQUEST['atributevalue'];
			$atributeConn = $_REQUEST['atributeConn'];

			for ($i=0; $i < count($atributeid) ; $i++) { 
				switch ($atributeid[$i]) {
					case 'Customer':
						$sql .= "cm.CustomerID in (SELECT CustomerID FROM vw_customer2 WHERE Company2 like '%".$atributevalue[$i]."%') ";
						break;
					default:
						$sql .= $atributeid[$i]." like '%".$atributevalue[$i]."%' ";
						break;
				}
				$sql .= " ".$atributeConn[$i]." ";
			}
			$sql = substr($sql, 0, -4);
			$sql .= ") ";
		}
		if ( empty($_POST) ) {
			$sql .= "and DepositCustomer is null ";
		}
		// echo $sql;

		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'BankTransactionID' => $row->BankTransactionID,
	  			'SourceReff' => $row->SourceReff,
	  			'BankName' => $row->BankName,
	  			'BankBranch' => $row->BankBranch,
	  			'BankTransactionDate' => $row->BankTransactionDate,
				'BankTransactionNote' => $row->BankTransactionNote,
	  			'BankTransactionAmount' => $row->BankTransactionAmount,
	  			'BankTransactionBalance' => $row->BankTransactionBalance,
	  			'DepositCustomer' => $row->DepositCustomer,
	  			'CustomerID' => $row->CustomerID,
	  			'DepositID' => $row->DepositID,
	  			'fullname' => $row->Company2
			);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function confirmation_deposit_distribution()
	{
		if (isset($_REQUEST['id'])) {
			$BankTransactionID = $_REQUEST['id'];
			$sql = "SELECT tbm.*, bm.* FROM tb_bank_transaction tbm ";
			$sql .= "LEFT JOIN tb_bank_main bm ON bm.BankID = tbm.BankID ";
			$sql .= "where BankTransactionID = '".$BankTransactionID."' and IsDeposit=1 and DepositCustomer is null ";
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (!empty($row)) {	
				$show = array(
		  			'BankTransactionID' => $row->BankTransactionID,
		  			'BankName' => $row->BankName,
		  			'BankTransactionDate' => $row->BankTransactionDate,
					'BankTransactionNote' => $row->BankTransactionNote,
		  			'BankTransactionAmount' => $row->BankTransactionAmount
				);
			} else { redirect(base_url()); }
		} else { redirect(base_url()); }
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function confirmation_deposit_distribution_act()
	{
		$this->db->trans_start();

		// print_r($this->input->post());
		$id 			= $this->input->post('id');
		$customer		= $this->input->post('customer');
		$amount 		= $this->input->post('amount');
		$note 			= $this->input->post('note');
		$distribution 	= $this->input->post('distribution');
		$distributionamount = $this->input->post('distributionamount');
		$datetimenow	= date("Y-m-d H:i:s");

		//cek if isset
		$sql 	= "select DepositCustomer from tb_bank_transaction where DepositCustomer IS NULL and BankTransactionID=".$id;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$bank_update = array(
				'DepositDate' => $datetimenow,
				'DepositCustomer' => $customer,
			);
			$this->db->where('BankTransactionID', $id);
			$this->db->update('tb_bank_transaction', $bank_update);
			$this->last_query .= "//".$this->db->last_query();

			$data_customer_deposit = array(
		        'CustomerID' => $customer,
		        'SourceReff' => $id,
		        'DepositAmount' => $amount,
		        'DepositNote' => $note,
		        'SourceType' => "BankTransaction",
		        'InsertDate' => $datetimenow,
				'InsertBy' => $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_customer_deposit', $data_customer_deposit);
			$this->last_query .= "//".$this->db->last_query();

			$sql 		= "select max(DepositID) as DepositID from tb_customer_deposit ";
			$getDepositID = $this->db->query($sql);
			$row 		= $getDepositID->row();
			$DepositID 	= $row->DepositID;

			for ($i=0; $i < count($distribution);$i++) {
				$type = explode(" ", $distribution[$i]);
				if ($type[0] == "SO") {
					$SOID = $type[1];
					$data_deposit = array(
						'SOID' => $SOID,
						'DepositID' => $DepositID,
						'AllocationAmount' => $distributionamount[$i],
						'AllocationDate' => $datetimenow,
						'AllocationBy' => $this->session->userdata('UserAccountID')
					);
					$this->db->insert('tb_customer_deposit_allocation', $data_deposit);
					$this->last_query .= "//".$this->db->last_query();

					$this->update_approval_so_deposit($SOID);

			        $this->load->model('model_transaction');
					$this->model_transaction->update_SOConfirm2($SOID, 'deposit');
				} elseif ($type[0] == "INV") {
					$all 	= explode("-", $distribution[$i]);
					$INVID 	= explode(" ", $all[0]);
					$SOID 	= explode(" ", $all[1]);
					$data_payment = array(
						'INVID' => $INVID[1],
						'SOID' => $SOID[1],
						'DepositID' => $DepositID,
						'PaymentAmount' => $distributionamount[$i],
						'PaymentDate' => $datetimenow,
						'PaymentBy' => $this->session->userdata('UserAccountID')
					);
					$this->db->insert('tb_customer_payment', $data_payment);
					$this->last_query .= "//".$this->db->last_query();

					$this->insert_customer_payment_transfer_date($INVID[1],$SOID[1],$DepositID,$distributionamount[$i],$datetimenow,$this->session->userdata('UserAccountID'));
					$this->update_invoice_balance($INVID[1]);

					$this->load->model('model_acc');
					$this->model_acc->auto_journal_insert_customer_payment($INVID[1], $distributionamount[$i]);
				}
	   		};
			for ($i=0; $i < count($distribution);$i++) {
				$type = explode(" ", $distribution[$i]);
				if ($type[0] == "SO") {
					$SOID = $type[1];

					$this->cek_so_outstanding_deposit($SOID);
					$this->update_approval_so_deposit($SOID);

			        $this->load->model('model_transaction');
					$this->model_transaction->update_SOConfirm2($SOID, 'deposit');
				} elseif ($type[0] == "INV") {
					$all 	= explode("-", $distribution[$i]);
					$INVID 	= explode(" ", $all[0]);
					$SOID 	= explode(" ", $all[1]);

					$this->cek_inv_outstanding_payment($INVID[1]);
				}
	   		};
		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function confirmation_deposit_distribution_act_under($SOID, $INVID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding)
	{
		$this->db->trans_start();

		$id 			= $BankTransactionID;
		$customer		= $CustomerID;
		$amount 		= $TotalOutstanding;
		$note 			= 'auto generate for INV'.$INVID;
		$datetimenow	= date("Y-m-d H:i:s");

		$bank_update = array(
			'IsDeposit' => 1,
			'DepositDate' => $datetimenow,
			'DepositCustomer' => $customer,
		);
		$this->db->where('BankTransactionID', $id);
		$this->db->update('tb_bank_transaction', $bank_update);
		$this->last_query .= "//".$this->db->last_query();

		$data_customer_deposit = array(
	        'CustomerID' => $customer,
	        'SourceReff' => $id,
	        'DepositAmount' => $amount,
	        'DepositNote' => $note,
	        'SourceType' => "BankTransaction",
	        'InsertDate' => $datetimenow,
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit', $data_customer_deposit);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DepositID) as DepositID from tb_customer_deposit ";
		$getDepositID = $this->db->query($sql);
		$row 		= $getDepositID->row();
		$DepositID 	= $row->DepositID;

		$data_payment = array(
			'INVID' => $INVID,
			'SOID' => $SOID,
			'DepositID' => $DepositID,
			'PaymentAmount' => $TotalOutstanding,
			'PaymentDate' => $datetimenow,
			'PaymentBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_payment', $data_payment);
		$this->last_query .= "//".$this->db->last_query();

		$this->insert_customer_payment_transfer_date($INVID,$SOID,$DepositID,$TotalOutstanding,$datetimenow,$this->session->userdata('UserAccountID'));
		$this->update_invoice_balance($INVID); 

		$this->load->model('model_acc');
		$BankTransactionID = array($id);
		$this->model_acc->auto_journal_insert_customer_deposit($BankTransactionID);
		$this->model_acc->auto_journal_insert_customer_payment($INVID, $TotalOutstanding);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function confirmation_deposit_allocation_act_under($SOID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding)
	{
		$this->db->trans_start();

		$id 			= $BankTransactionID;
		$customer		= $CustomerID;
		$amount 		= $TotalOutstanding;
		$note 			= 'auto generate for SO'.$SOID;
		$datetimenow	= date("Y-m-d H:i:s");

		$bank_update = array(
			'IsDeposit' => 1,
			'DepositDate' => $datetimenow,
			'DepositCustomer' => $customer,
		);
		$this->db->where('BankTransactionID', $id);
		$this->db->update('tb_bank_transaction', $bank_update);
		$this->last_query .= "//".$this->db->last_query();

		$data_customer_deposit = array(
	        'CustomerID' => $customer,
	        'SourceReff' => $id,
	        'DepositAmount' => $amount,
	        'DepositNote' => $note,
	        'SourceType' => "BankTransaction",
	        'InsertDate' => $datetimenow,
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit', $data_customer_deposit);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DepositID) as DepositID from tb_customer_deposit ";
		$getDepositID = $this->db->query($sql);
		$row 		= $getDepositID->row();
		$DepositID 	= $row->DepositID;

		$data_deposit = array(
			'SOID' => $SOID,
			'DepositID' => $DepositID,
			'AllocationAmount' => $TotalOutstanding,
			'AllocationDate' => $datetimenow,
			'AllocationBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit_allocation', $data_deposit);
		$this->last_query .= "//".$this->db->last_query();

        $this->load->model('model_transaction');
		$this->model_transaction->update_SOConfirm2($SOID, 'deposit');

		$this->load->model('model_acc');
		$BankTransactionID = array($id);
		$this->model_acc->auto_journal_insert_customer_deposit($BankTransactionID);
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function confirmation_deposit_distribution_act_import_inv($SOID, $INVID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding)
	{
		$this->db->trans_start();

		$id 			= $BankTransactionID;
		$customer		= $CustomerID;
		$amount 		= $TotalOutstanding;
		$note 			= 'auto generate for import INV lama'.$INVID;
		$datetimenow	= date("Y-m-d H:i:s");

		$bank_update = array(
			'IsDeposit' => 1,
			'DepositDate' => $BankTransactionDate,
			'DepositCustomer' => $customer,
		);
		$this->db->where('BankTransactionID', $id);
		$this->db->update('tb_bank_transaction', $bank_update);
		// $this->last_query .= "//".$this->db->last_query();

		$data_customer_deposit = array(
	        'CustomerID' => $customer,
	        'SourceReff' => $id,
	        'DepositAmount' => $amount,
	        'DepositNote' => $note,
	        'SourceType' => "BankTransaction",
	        'InsertDate' => $BankTransactionDate,
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit', $data_customer_deposit);
		// $this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DepositID) as DepositID from tb_customer_deposit ";
		$getDepositID = $this->db->query($sql);
		$row 		= $getDepositID->row();
		$DepositID 	= $row->DepositID;

		$data_payment = array(
			'INVID' => $INVID,
			'SOID' => $SOID,
			'DepositID' => $DepositID,
			'PaymentAmount' => $TotalOutstanding,
			'PaymentDate' => $BankTransactionDate,
			'PaymentBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_payment', $data_payment);
		// $this->last_query .= "//".$this->db->last_query();
		$this->insert_customer_payment_transfer_date($INVID,$SOID,$DepositID,$TotalOutstanding,$BankTransactionDate,$this->session->userdata('UserAccountID'));
		$this->update_invoice_balance($INVID); 

		// $this->load->model('model_acc');
		// $this->model_acc->auto_journal_insert_customer_payment($INVID, $TotalOutstanding);

		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function confirmation_deposit_distribution_act_import_dp_free($CustomerID, $BankTransactionID, $amount)
	{
		$this->db->trans_start();

		$id 			= $BankTransactionID;
		$customer		= $CustomerID;
		$note 			= 'Import DP free ';
		$datetimenow	= date("Y-m-d H:i:s");

		$bank_update = array(
			'IsDeposit' => 1,
			'DepositDate' => $datetimenow,
			'DepositCustomer' => $customer,
		);
		$this->db->where('BankTransactionID', $id);
		$this->db->update('tb_bank_transaction', $bank_update);
		// $this->last_query .= "//".$this->db->last_query();

		$data_customer_deposit = array(
	        'CustomerID' => $customer,
	        'SourceReff' => $id,
	        'DepositAmount' => $amount,
	        'DepositNote' => $note,
	        'SourceType' => "BankTransaction",
	        'InsertDate' => $datetimenow,
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit', $data_customer_deposit);
		// $this->last_query .= "//".$this->db->last_query();

		// $this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function print_bkbm()
	{
		$BankID = $_REQUEST['bank'];
		$Date = $_REQUEST['bmdate'];
		$show   = array();

		$sql 	= "select * from tb_bank_main bm
					LEFT JOIN tb_job_company c ON bm.CompanyID=c.CompanyID
					where BankID=".$BankID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show['main']['BankName'] = $row->BankName;
			$show['main']['CompanyName'] = $row->CompanyName;
			$show['main']['CompanyAddress'] = $row->CompanyAddress;
		};
		$show['main']['Date'] = $Date;

		$sql = "SELECT bt.BankTransactionID, cd.DepositID, cd.CustomerID, c.Company2, 
				CONCAT('pelunasan INV ',cp.INVID,' - ',bt.BankTransactionNote) AS note,
				bt.BankTransactionDate, cd.DepositAmount,'Payment' AS type, cp.PaymentAmount AS Total
				FROM tb_customer_deposit cd
				LEFT JOIN tb_customer_main cm ON (cd.CustomerID=cm.CustomerID)
				LEFT JOIN vw_contact2 c ON (cm.ContactID=c.ContactID)
				LEFT JOIN tb_bank_transaction bt ON (cd.SourceReff=bt.BankTransactionID and cd.SourceType='BankTransaction')
				LEFT JOIN tb_customer_payment cp ON (cd.DepositID=cp.DepositID)
				LEFT JOIN vw_deposit_balance db ON (cd.DepositID=db.DepositID)
				WHERE DATE(bt.BankTransactionDate)='".$Date."' AND bt.BankID=".$BankID."
				AND cp.PaymentID IS NOT NULL

				UNION ALL 

				SELECT bt.BankTransactionID, db.DepositID, db.CustomerID, c.Company2, 
				CONCAT('Customer Deposit - ',bt.BankTransactionNote) AS note,
				bt.BankTransactionDate, db.DepositAmount,'Deposit' AS type, db.TotalBalance+db.TotalRetur+db.TotalAllocation as Total
				FROM vw_deposit_balance db 
				LEFT JOIN tb_customer_main cm ON (db.CustomerID=cm.CustomerID)
				LEFT JOIN vw_contact2 c ON (cm.ContactID=c.ContactID)
				LEFT JOIN tb_bank_transaction bt ON (db.SourceReff=bt.BankTransactionID and db.SourceType='BankTransaction')
				WHERE DATE(bt.BankTransactionDate)='".$Date."' AND bt.BankID=".$BankID."
				HAVING Total>0

				UNION ALL 

				SELECT BankTransactionID, 0, 0, 'Mr C', BankTransactionNote, BankTransactionDate, BankTransactionAmount, 
				'Deposit' AS type, BankTransactionAmount
				FROM tb_bank_transaction 
				WHERE DATE(BankTransactionDate)='".$Date."' AND BankID=".$BankID."
				AND DepositCustomer IS NULL AND IsDeposit=1

				ORDER BY BankTransactionID";
		$query 	= $this->db->query($sql);
		if ( $query->num_rows() > 0 ) {
			foreach ($query->result() as $row) {
			  	$show['detail'][] = array(
		  			'BankTransactionID' => $row->BankTransactionID,
		  			'CustomerID' => $row->CustomerID,
		  			'Company2' => $row->Company2,
		  			'note' => $row->note,
					'type' => $row->type,
		  			'total' => $row->Total
				);
			};
		} else {
			$show['detail'][] = array(
	  			'BankTransactionID' => 0,
	  			'CustomerID' => 0,
	  			'Company2' => "",
	  			'note' => "",
				'type' => "deposit",
	  			'total' => 0
			);
		}
		$this->log_user->log_query($this->last_query);
	    return $show;
	}

//customer_deposit============================================================
	function customer_deposit_detail()
	{
		$id 	= $this->input->get_post('id');
		$show   = array();

		$sql 		= "select * from vw_customer_deposit where CustomerID=".$id;
		$getDetail 	= $this->db->query($sql);
		$row 		= $getDetail->row();
		$show['main']['CustomerID'] 	= $row->CustomerID;
		$show['main']['Company'] 		= $row->Company;
		$show['main']['TotalDeposit'] 	= $row->DepositUsed;
		$show['main']['TotalAllocation'] = $row->TotalAllocation;
		$show['main']['TotalPayment'] 	= $row->TotalPayment;
		$show['main']['TotalBalance'] 	= $row->TotalBalance;

		$sql 		= "SELECT CustomerID, coalesce(SUM(SOTotal),0) as SOTotal, coalesce(SUM(TotalOutstanding),0) as TotalOutstanding FROM vw_so_balance where CustomerID=".$id." and PaymentWay='TOP' AND SOConfirm1=1";
		$getDetail 	= $this->db->query($sql);
		$row 		= $getDetail->row();
		if (!empty($row)) {
			$show['main']['SOTotal'] = $row->SOTotal;
			$show['main']['TotalOutstanding'] = $row->TotalOutstanding;
		} else {
			$show['main']['SOTotal'] = 0;
			$show['main']['TotalOutstanding'] = 0;
		}

		$sql 		= "SELECT CustomerID, COALESCE(SUM(INVTotal), 0) AS INVTotal, COALESCE(SUM(TotalOutstanding), 0) AS TotalOutstanding FROM vw_invoice_balance WHERE CustomerID =".$id;
		$getDetail 	= $this->db->query($sql);
		$row 		= $getDetail->row();
		if (!empty($row)) {
			$show['main']['INVTotal'] = $row->INVTotal;
			$show['main']['INVTotalOutstanding'] = $row->TotalOutstanding;
		} else {
			$show['main']['INVTotal'] = 0;
			$show['main']['INVTotalOutstanding'] = 0;
		}

		$sql 	= "SELECT cd.*, vem.fullname, vdb.TotalAllocation, vdb.TotalPayment, vdb.TotalRetur, vdb.TotalBalance
					FROM vw_deposit_transfer_date cd
					LEFT JOIN vw_user_account vem ON (cd.InsertBy = vem.UserAccountID)
					LEFT JOIN vw_deposit_balance vdb ON (cd.DepositID = vdb.DepositID)
					WHERE cd.CustomerID =".$id." ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "and TransferDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59'";
		} else {
			$sql .= "order by vdb.TotalBalance desc, DepositID desc limit ".$this->limit_result;
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		  			'DepositID' => $row->DepositID,
		  			'transferdate' => $row->TransferDate,
		  			'InsertDate' => $row->InsertDate,
		  			'SourceType' => $row->SourceType,
		  			'fullname' => $row->fullname,
		  			'DepositAmount' => $row->DepositAmount,
		  			'TotalAllocation' => $row->TotalAllocation,
					'TotalPayment' => $row->TotalPayment,
					'TotalRetur' => $row->TotalRetur,
		  			'TotalBalance' => $row->TotalBalance
				);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function customer_deposit_summary()
	{
		$show = array();
		$sql = "SELECT SUM(TotalDeposit) AS TotalDeposit, SUM(DepositUsed) AS DepositUsed, 
						SUM(TotalBalance) AS TotalBalance FROM vw_customer_deposit ";
		$getDetail 	= $this->db->query($sql);
		$row 		= $getDetail->row();
		$show['TotalDeposit'] = $row->TotalDeposit;
		$show['DepositUsed'] = $row->DepositUsed;
		$show['TotalDebit'] = 0;
		$show['TotalBalance'] = $row->TotalBalance;

		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function customer_deposit_distribution()
	{
		if (isset($_REQUEST['id'])) {
			$show   = array();
			$DepositID = $_REQUEST['id'];
			$sql 	= "SELECT cd.*, vdb.*, vem.fullname, vc.Company2 
						FROM vw_deposit_transfer_date cd
						LEFT JOIN vw_deposit_balance vdb ON (cd.DepositID = vdb.DepositID)
						LEFT JOIN vw_user_account vem ON (cd.InsertBy = vem.UserAccountID)
						LEFT JOIN tb_customer_main cm ON (cd.CustomerID = cm.CustomerID)
						LEFT JOIN vw_contact2 vc ON (cm.ContactID = vc.ContactID)
						WHERE cd.DepositID=".$DepositID;
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (!empty($row)) {	
				// if ($row->TotalBalance > 0) {
					$show['main'] = array(
			  			'DepositID' => $row->DepositID,
			  			'DepositAmount' => $row->DepositAmount,
			  			'TotalBalance' => $row->TotalBalance,
			  			'TransferDate' => $row->TransferDate,
						'InsertDate' => $row->InsertDate,
			  			'InsertBy' => $row->fullname,
			  			'DepositNote' => $row->DepositNote,
			  			'CustomerID' => $row->CustomerID,
			  			'Company' => $row->Company2
					);

					$sql 	= "SELECT cda.*, vem.fullname FROM tb_customer_deposit_allocation cda
								LEFT JOIN vw_user_account vem ON (cda.AllocationBy = vem.UserAccountID)
								WHERE DepositID=".$DepositID;
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'Dst' => "SO ".$row->SOID,
				  			'Amount' => $row->AllocationAmount,
				  			'Date' => $row->AllocationDate,
				  			'By' => $row->fullname
						);
					};

					$sql 	= "SELECT cp.*, vem.fullname FROM tb_customer_payment cp
								LEFT JOIN vw_user_account vem ON (cp.PaymentBy=vem.UserAccountID)
								WHERE	DepositID =".$DepositID;
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'Dst' => "INV ".$row->INVID,
				  			'Amount' => $row->PaymentAmount,
				  			'Date' => $row->PaymentDate,
				  			'By' => $row->fullname
						);
					};

					$sql 	= "SELECT cdr.*, vem.fullname FROM tb_customer_deposit_retur cdr
								LEFT JOIN vw_user_account vem ON (cdr.ReturBy = vem.UserAccountID)
								WHERE DepositID=".$DepositID;
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'Dst' => "Retur ".$row->ReturID,
				  			'Amount' => $row->ReturAmount,
				  			'Date' => $row->ReturDate,
				  			'By' => $row->fullname,
				  			'DistributionID' => $row->DistributionID
						);
					};

				// } else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
			} else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
		} else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function customer_deposit_distribution_act()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$DepositID		= $this->input->post('id');
		$amount 		= $this->input->post('amount');
		$note 			= $this->input->post('note');
		$distribution 	= $this->input->post('distribution');
		$distributionamount = $this->input->post('distributionamount');
		$datetimenow	= date("Y-m-d H:i:s");

		for ($i=0; $i < count($distribution);$i++) {
			$type = explode(" ", $distribution[$i]);
			if ($type[0] == "SO") {
				$SOID = $type[1];
				$data_deposit = array(
					'SOID' => $SOID,
					'DepositID' => $DepositID,
					'AllocationAmount' => $distributionamount[$i],
					'AllocationDate' => $datetimenow,
					'AllocationBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->insert('tb_customer_deposit_allocation', $data_deposit);
				$this->last_query .= "//".$this->db->last_query();

				$this->update_approval_so_deposit($SOID);

		        $this->load->model('model_transaction');
				$this->model_transaction->update_SOConfirm2($SOID, 'deposit');
			} elseif ($type[0] == "INV") {
				$all 	= explode("-", $distribution[$i]);
				$INVID 	= explode(" ", $all[0]);
				$SOID 	= explode(" ", $all[1]);
				$data_payment = array(
					'INVID' => $INVID[1],
					'SOID' => $SOID[1],
					'DepositID' => $DepositID,
					'PaymentAmount' => $distributionamount[$i],
					'PaymentDate' => $datetimenow,
					'PaymentBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->insert('tb_customer_payment', $data_payment);
				$this->last_query .= "//".$this->db->last_query();

				$this->insert_customer_payment_transfer_date($INVID[1],$SOID[1],$DepositID,$distributionamount[$i],$datetimenow,$this->session->userdata('UserAccountID'));
				$this->update_invoice_balance($INVID[1]); 

				$this->load->model('model_acc');
				$this->model_acc->auto_journal_insert_customer_payment($INVID[1], $distributionamount[$i]);
			}
   		};
		for ($i=0; $i < count($distribution);$i++) {
			$type = explode(" ", $distribution[$i]);
			if ($type[0] == "SO") {
				$SOID = $type[1];

				$this->cek_so_outstanding_deposit($SOID);
				$this->update_approval_so_deposit($SOID);

		        $this->load->model('model_transaction');
				$this->model_transaction->update_SOConfirm2($SOID, 'deposit');
			} elseif ($type[0] == "INV") {
				$all 	= explode("-", $distribution[$i]);
				$INVID 	= explode(" ", $all[0]);
				$SOID 	= explode(" ", $all[1]);

				$this->cek_inv_outstanding_payment($INVID[1]);
			}
   		};
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function customer_deposit_retur()
	{
		if (isset($_REQUEST['id'])) {
			$show   = array();
			$DepositID = $_REQUEST['id'];
			$sql 	= "SELECT cd.*, vdb.*, vem.fullname, vc.Company2, vc.ContactID  
						FROM vw_deposit_transfer_date cd
						LEFT JOIN vw_deposit_balance vdb ON (cd.DepositID = vdb.DepositID)
						LEFT JOIN vw_user_account vem ON (cd.InsertBy = vem.UserAccountID)
						LEFT JOIN tb_customer_main cm ON (cd.CustomerID = cm.CustomerID)
						LEFT JOIN vw_contact2 vc ON (cm.ContactID = vc.ContactID)
						WHERE cd.DepositID=".$DepositID;
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (!empty($row)) {	
				// if ($row->TotalBalance > 0) {
					$show['main'] = array(
			  			'DepositID' => $row->DepositID,
			  			'DepositAmount' => $row->DepositAmount,
			  			'TotalBalance' => $row->TotalBalance,
			  			'TransferDate' => $row->TransferDate,
						'InsertDate' => $row->InsertDate,
			  			'InsertBy' => $row->fullname,
			  			'DepositNote' => $row->DepositNote,
			  			'ContactID' => $row->ContactID,
			  			'CustomerID' => $row->CustomerID,
			  			'Company' => $row->Company2
					);

					$sql 	= "SELECT cda.*, vem.fullname FROM tb_customer_deposit_allocation cda
								LEFT JOIN vw_user_account vem ON (cda.AllocationBy = vem.UserAccountID)
								WHERE DepositID=".$DepositID;
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'Dst' => "SO ".$row->SOID,
				  			'Amount' => $row->AllocationAmount,
				  			'Date' => $row->AllocationDate,
				  			'By' => $row->fullname
						);
					};

					$sql 	= "SELECT cp.*, vem.fullname FROM tb_customer_payment cp
								LEFT JOIN vw_user_account vem ON (cp.PaymentBy=vem.UserAccountID)
								WHERE	DepositID =".$DepositID;
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'Dst' => "INV ".$row->INVID,
				  			'Amount' => $row->PaymentAmount,
				  			'Date' => $row->PaymentDate,
				  			'By' => $row->fullname
						);
					};

					$sql 	= "SELECT cdr.*, vem.fullname FROM tb_customer_deposit_retur cdr
								LEFT JOIN vw_user_account vem ON (cdr.ReturBy = vem.UserAccountID)
								WHERE DepositID=".$DepositID;
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'Dst' => "Retur ".$row->ReturID,
				  			'Amount' => $row->ReturAmount,
				  			'Date' => $row->ReturDate,
				  			'By' => $row->fullname
						);
					};
				// } else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
			} else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
		} else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function customer_deposit_retur_act()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$ContactID	= $this->input->post('ContactID');
		$ContactName= $this->input->post('ContactName');
		$DepositID	= $this->input->post('id');
		$amount 	= $this->input->post('amount');
		$note 		= $this->input->post('note');
		$returnote 	= $this->input->post('returnote');
		$returamount= $this->input->post('returamount');
		$type 	= $this->input->post('type');
		$datenow= date("Y-m-d");
		$datetimenow= date("Y-m-d H:i:s");

		// add bank payment
		$sql = "select d.*, b.CompanyID from tb_bank_distribution_type d
				LEFT JOIN tb_bank_main b ON d.BankID=b.BankID 
				where DistributionTypeID='".$type."'";
		$getrow = $this->db->query($sql);
		$row 		= $getrow->row();
		$DistributionTypeCode 	= $row->DistributionTypeCode;
		$DistributionTypeNumber	= $row->DistributionTypeNumber;
		$CompanyID	= $row->CompanyID;
		$DivisiID 	= $this->session->userdata('DivisiID');

		$data = array(
			'DistributionTypeID' => $type,
			'DistributionNumber' => $DistributionTypeCode.$DistributionTypeNumber,
			'CompanyID' => $CompanyID,
			'DistributionDate' => $datenow,
			'DistributionTotal' => $returamount,
			'DistributionNote' => "Pengembalian uang Customer Deposit",
			'DistributionReff' => "retur",
			'ContactType' => "isCustomer",
			'CreatedDate' => $datetimenow,
			'CreatedBy' => $this->session->userdata('UserAccountID'),
			'CreatedDivisi' => $DivisiID[0],
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_bank_distribution_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DistributionID) as DistributionID from tb_bank_distribution_main ";
		$getDistributionID = $this->db->query($sql);
		$row 		= $getDistributionID->row();
		$DistributionID = $row->DistributionID;

		$data = array(
			'DistributionID' => $DistributionID,
			'ContactID' => $ContactID,
			'ContactName' => $ContactName,
			'Note' => "Pengembalian uang Customer Deposit - ".$returnote,
			'Amount' => $returamount,
		);
		$this->db->insert('tb_bank_distribution_detail', $data);
		$this->last_query .= "//".$this->db->last_query();

   		$this->db->set('DistributionTypeNumber', 'DistributionTypeNumber +'. 1 .'',false);
		$this->db->where('DistributionTypeID', $type);
		$this->db->update('tb_bank_distribution_type');
		$this->last_query .= "//".$this->db->last_query();
		// =================================================

		$data_retur = array(
			'DepositID' => $DepositID,
			'ReturAmount' => $returamount,
			'ReturDate' => $datetimenow,
			'DistributionID' => $DistributionID,
			'ReturBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit_retur', $data_retur);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(ReturID) as ReturID from tb_customer_deposit_retur ";
		$getReturID = $this->db->query($sql);
		$row 		= $getReturID->row();
		$ReturID 	= $row->ReturID;

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_retur_deposit($ContactName, $ReturID, $DistributionID, $returamount);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function update_approval_so_deposit($SOID)
	{
		$this->db->trans_start();

		$sql 	= "select * from tb_so_main where SOID=".$SOID;
		$getSO 	= $this->db->query($sql);
		$row 	= $getSO->row();

		$sototal = $row->SOTotal;
		$sopaymentterm = $row->PaymentTerm;
		$paymentmethod = $row->PaymentWay;
		$CustomerID = $row->CustomerID;
		$socategory = $row->SOCategory;

		$sql 	= "select PaymentTerm from tb_customer_main where CustomerID=".$CustomerID;
		$getCust= $this->db->query($sql);
		$row 	= $getCust->row();
		$paymentterm = $row->PaymentTerm;

		$sql 	= "select TotalDeposit from vw_so_deposit where SOID=".$SOID;
		$getDepo= $this->db->query($sql);
		$row 	= $getDepo->row();
		$creditavailable = $row->TotalDeposit;

		$this->load->model('model_transaction', 'transaction');
		// $this->transaction->sales_order_approval_submission($SOID, $socategory, $paymentterm, $sopaymentterm, "edit", $creditavailable, $sototal, $paymentmethod);
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function get_customer_deposit_summary($CustomerID)
	{
		$sql 		= "select * from vw_customer_deposit where CustomerID=".$CustomerID;
		$getDetail 	= $this->db->query($sql);
		$row 		= $getDetail->row();
		$main['CustomerID'] 	= $row->CustomerID;
		$main['Company'] 		= $row->Company;
		$main['TotalDeposit'] 	= $row->DepositUsed;
		$main['TotalAllocation'] = $row->TotalAllocation;
		$main['TotalPayment'] 	= $row->TotalPayment;
		$main['TotalBalance'] 	= $row->TotalBalance;
		return $main;
	}
	function get_customer_deposit_summary2($CustomerID)
	{
		$sql 		= "select * from vw_customer_deposit2 where CustomerID=".$CustomerID;
		$getDetail 	= $this->db->query($sql);
		$row 		= $getDetail->row();
		$main['CustomerID'] 	= $row->CustomerID;
		$main['TotalDeposit'] 	= $row->DepositUsed;
		$main['TotalAllocation'] = $row->TotalAllocation;
		$main['TotalPayment'] 	= $row->TotalPayment;
		$main['TotalBalance'] 	= $row->TotalBalance;
		return $main;
	}
	function retur_deposit_so()
	{
		$show   = array();
		$SOID 	= $_REQUEST['id'];
		$sql 	= "SELECT * FROM vw_so_list5 WHERE SOID=".$SOID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$show['main'] = (array) $row;

		$sql 	= "SELECT * FROM tb_customer_deposit_allocation WHERE SOID=".$SOID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
				'AllocationID' => $row->AllocationID,
				'SOID' => $row->SOID,
				'DepositID' => $row->DepositID,
				'AllocationAmount' => $row->AllocationAmount,
			);
		};

	    return $show;
	}
	function retur_deposit_so_act()
	{
		$this->db->trans_start();

		$SOID	= $this->input->post('id');
		$AllocationID 	= $this->input->post('distribution');
		$distributionamount = $this->input->post('distributionamount');
		$datetimenow	= date("Y-m-d H:i:s");

		for ($i=0; $i < count($AllocationID);$i++) {
			$this->db->set('AllocationAmount', 'AllocationAmount-'.$distributionamount[$i], FALSE);
			$this->db->where('AllocationID', $AllocationID[$i]);
			$this->db->update('tb_customer_deposit_allocation');
			$this->last_query .= "//".$this->db->last_query();
   		};

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function retur_payment_inv()
	{
		$show   = array();
		$INVID 	= $_REQUEST['id'];
		$sql 	= "SELECT * FROM vw_invoice_list2 WHERE INVID=".$INVID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$show['main'] = (array) $row;

		$sql 	= "SELECT * FROM tb_customer_payment WHERE INVID=".$INVID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
				'PaymentID' => $row->PaymentID,
				'INVID' => $row->INVID,
				'DepositID' => $row->DepositID,
				'PaymentAmount' => $row->PaymentAmount,
			);
		};

	    return $show;
	}
	function retur_payment_inv_act()
	{
		$this->db->trans_start();

		// echo json_encode($this->input->post());
		$INVID	= $this->input->post('id');
		$PaymentID 	= $this->input->post('distribution');
		$distributionamount = $this->input->post('distributionamount');
		$datetimenow	= date("Y-m-d H:i:s");

		for ($i=0; $i < count($PaymentID);$i++) {
			$sql = "SELECT PaymentAmount FROM tb_customer_payment
					WHERE PaymentID=".$PaymentID[$i];
			$getrow = $this->db->query($sql);
			$row	= $getrow->row();
			$PaymentAmount	= $row->PaymentAmount;
			$PaymentAmount = $PaymentAmount - $distributionamount[$i];

			$this->db->set('PaymentAmount', $PaymentAmount);
			$this->db->where('PaymentID', $PaymentID[$i]);
			$this->db->update('tb_customer_payment');
			$this->last_query .= "//".$this->db->last_query();

			$this->update_customer_payment_transfer_date($PaymentID[$i], $PaymentAmount);
			$this->update_invoice_balance($INVID); 

			$this->load->model('model_acc');
			$this->model_acc->auto_journal_cancel_customer_payment($INVID, $distributionamount[$i]);
   		};
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function customer_deposit_add_from_retur($INVRID, $CustomerID, $amount)
	{
		$this->db->trans_start();

		// print_r($this->input->post());
		$datetimenow	= date("Y-m-d H:i:s");

		$data_customer_deposit = array(
	        'CustomerID' => $CustomerID,
	        'SourceReff' => $INVRID,
	        'DepositAmount' => $amount,
	        'SourceType' => "InvoiceRetur",
	        'InsertDate' => $datetimenow,
			'InsertBy' => $this->session->userdata('UserAccountID')
		);
		$this->db->insert('tb_customer_deposit', $data_customer_deposit);
		$this->last_query .= "//".$this->db->last_query();
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function customer_deposit_batch_retur()
	{
		$this->db->trans_start();

		$CustomerID	= $this->input->post('data');
		$CompanyID	= $this->input->post('company');
		$DistributionTypeID	= $this->input->post('type');

		$sql = "select ContactID, CustomerName, DepositID, TotalBalance from vw_deposit_balance 
				where CustomerID in (" . implode(',', array_map('intval', $CustomerID)) . ") 
				and TotalBalance>0 order by TotalBalance";
		$query 	= $this->db->query($sql);
		$dataDepositID 	= $query->result_array();

		$sql = "select sum(TotalBalance) as TotalBalance from vw_deposit_balance 
				where CustomerID in (" . implode(',', array_map('intval', $CustomerID)) . ") 
				and TotalBalance>0";
		$query 	= $this->db->query($sql);
		$TotalBalance = $query->result_array()[0]['TotalBalance'];

		$sql = "select d.*, b.CompanyID from tb_bank_distribution_type d
				LEFT JOIN tb_bank_main b ON d.BankID=b.BankID 
				where DistributionTypeID='".$DistributionTypeID."'";
		$getrow = $this->db->query($sql);
		$row 		= $getrow->row();
		$DistributionTypeCode 	= $row->DistributionTypeCode;
		$DistributionTypeNumber	= $row->DistributionTypeNumber;
		$CompanyID	= $row->CompanyID;
		$DivisiID 	= $this->session->userdata('DivisiID');
		$datenow 	= date("Y-m-d");
		$datetimenow= date("Y-m-d H:i:s");

		$data = array(
			'DistributionTypeID' => $DistributionTypeID,
			'DistributionNumber' => $DistributionTypeCode.$DistributionTypeNumber,
			'CompanyID' => $CompanyID,
			'DistributionDate' => $datenow,
			'DistributionTotal' => $TotalBalance,
			'DistributionNote' => "Pengembalian uang Customer Deposit",
			'DistributionReff' => "Batch Retur",
			'ContactType' => "isCustomer",
			'CreatedDate' => $datetimenow,
			'CreatedBy' => $this->session->userdata('UserAccountID'),
			'CreatedDivisi' => $DivisiID[0],
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_bank_distribution_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DistributionID) as DistributionID from tb_bank_distribution_main ";
		$getDistributionID = $this->db->query($sql);
		$row 		= $getDistributionID->row();
		$DistributionID = $row->DistributionID;

		for ($i=0; $i < count($dataDepositID); $i++) { 
			$dataDetail[] = array(
				'DistributionID' => $DistributionID,
				'ContactID' => $dataDepositID[$i]['ContactID'],
				'ContactName' => $dataDepositID[$i]['CustomerName'],
				'Note' => "Pengembalian uang Customer Deposit",
				'Amount' => $dataDepositID[$i]['TotalBalance'],
				'ReffType' => 'DepositID',
				'ReffNo' => $dataDepositID[$i]['DepositID'],
			);

			$data_retur[] = array(
				'DepositID' => $dataDepositID[$i]['DepositID'],
				'ReturAmount' => $dataDepositID[$i]['TotalBalance'],
				'ReturDate' => $datetimenow,
				'DistributionID' => $DistributionID,
				'ReturBy' => $this->session->userdata('UserAccountID')
			);
		}
		$this->db->insert_batch('tb_bank_distribution_detail', $dataDetail);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->insert_batch('tb_customer_deposit_retur', $data_retur);
		$this->last_query .= "//".$this->db->last_query();

   		$this->db->set('DistributionTypeNumber', 'DistributionTypeNumber +'. 1 .'',false);
		$this->db->where('DistributionTypeID', $DistributionTypeID);
		$this->db->update('tb_bank_distribution_type');
		$this->last_query .= "//".$this->db->last_query();

		$this->load->model('model_acc');
		$this->model_acc->auto_journal_retur_deposit('Batch Retur', 0, $DistributionID, $TotalBalance);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();

		echo json_encode(count($dataDepositID));
		// echo json_encode($TotalBalance);
	}

//invoice_payment=============================================================
	function invoice_payment()
	{
		if (isset($_REQUEST['id'])) {
			$show   = array();
			$INVID 	= $_REQUEST['id'];
			$sql 	= "SELECT im.*, ib.TotalPayment, ib.TotalOutstanding, cus.Company2
						FROM tb_invoice_main im 
						LEFT JOIN vw_invoice_balance ib ON (ib.INVID=im.INVID)
						LEFT JOIN tb_customer_main cm ON (im.CustomerID = cm.CustomerID)
						LEFT JOIN vw_contact2 cus ON (cm.ContactID = cus.ContactID)
						WHERE im.INVID=".$INVID;
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			if (!empty($row)) {	

				$due_date = date('Y-m-d', strtotime("+".$row->PaymentTerm." days", strtotime($row->INVDate)));
				$now = time();
				$your_date = strtotime($due_date);
				$datediff = round( ($your_date - $now) / (60 * 60 * 24) );

				// if ($row->TotalOutstanding > 0) {
					$show['main'] = array(
						'INVID' => $row->INVID,
						'DOID' => $row->DOID,
						'SOID' => $row->SOID,
						'CustomerID' => $row->CustomerID,
						'SalesID' => $row->SalesID,
						'SECID' => $row->SECID,
						'PaymentTerm' => $row->PaymentTerm,
						'INVDate' => $row->INVDate,
						'INVTotal' => $row->INVTotal,
						'INVInput' => $row->INVInput,
						'INVBy' => $row->INVBy,
						'TotalPayment' => $row->TotalPayment,
						'TotalOutstanding' => $row->TotalOutstanding,
						'due_date' => $due_date,
						'datediff' => $datediff,
						'Company' => $row->Company2
					);

					$sql = "SELECT cp.*, em.fullname, cd.TransferDate FROM tb_customer_payment cp
							LEFT JOIN vw_user_account em ON (em.UserAccountID=cp.PaymentBy)
							LEFT JOIN vw_deposit_transfer_date cd ON (cd.DepositID=cp.DepositID)
							WHERE INVID=".$INVID." order by cd.TransferDate desc, cp.PaymentID asc";
					$query 	= $this->db->query($sql);	
					$row 	= $query->row();
					foreach ($query->result() as $row) {
					  	$show['detail'][] = array(
				  			'From' => $row->DepositID,
				  			'Amount' => $row->PaymentAmount,
				  			'Transfer' => $row->TransferDate,
				  			'Date' => $row->PaymentDate,
				  			'By' => $row->fullname
						);
					};
				// } else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
			} else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
		} else { redirect( site_url('finance/customer_deposit_detail?id=').$row->CustomerID ); }
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function invoice_payment_act()
	{
		$this->db->trans_start();

		$datetimenow = date("Y-m-d H:i:s");
		$INVID 	= $this->input->post("id");
		$SOID 	= $this->input->post("so");
		$amount = $this->input->post("amount");
		$CustomerID = $this->input->post("CustomerID");
		$AllocationID = $this->input->post("distribution");
		$AllocationAmount2 = $this->input->post("distributionamount");

		for ($i=0; $i < count($AllocationID);$i++) {
			$sql 	= "select DepositID, AllocationAmount from tb_customer_deposit_allocation where AllocationID=".$AllocationID[$i];
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$DepositID = $row->DepositID;
			$AllocationAmount = $row->AllocationAmount;
			if ($AllocationAmount >= $AllocationAmount2[$i]) {
				$resultAllocationAmount = $AllocationAmount - $AllocationAmount2[$i];

				$data_payment = array(
					'INVID' => $INVID,
					'SOID' => $SOID,
					'DepositID' => $DepositID,
					'PaymentAmount' => $AllocationAmount2[$i],
					'PaymentDate' => $datetimenow,
					'PaymentBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->insert('tb_customer_payment', $data_payment);
				$this->last_query .= "//".$this->db->last_query();

				$this->cek_inv_outstanding_payment($INVID);
				$this->insert_customer_payment_transfer_date($INVID,$SOID,$DepositID,$AllocationAmount2[$i],$datetimenow,$this->session->userdata('UserAccountID'));
				$this->update_invoice_balance($INVID); 

				if ($resultAllocationAmount>0) {
					$this->db->set('AllocationAmount', $resultAllocationAmount);
					$this->db->where('AllocationID', $AllocationID[$i]);
					$this->db->update('tb_customer_deposit_allocation');
					$this->last_query .= "//".$this->db->last_query();
				} else {
					$this->db->where('AllocationID', $AllocationID[$i]);
					$this->db->delete('tb_customer_deposit_allocation');
					$this->last_query .= "//".$this->db->last_query();
				}

				$this->load->model('model_acc');
				$this->model_acc->auto_journal_insert_customer_payment($INVID, $AllocationAmount2[$i]);
			}
   		};
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function invoice_payment_return($INVID)
	{
		$data 	= array();
		$sql 	= "SELECT INVTotal, TotalPayment, TotalOutstanding FROM vw_invoice_balance ib WHERE INVID=".$INVID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$TotalOutstanding = $row->TotalOutstanding;
		if ($TotalOutstanding < 0) {
			$sql 	= "SELECT cp.*, cd.TransferDate FROM tb_customer_payment cp 
						LEFT JOIN vw_deposit_transfer_date cd ON (cd.DepositID=cp.DepositID)
						WHERE cp.INVID=".$INVID." ORDER BY TransferDate desc, PaymentID asc";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
				if ($TotalOutstanding < 0) {
					$TotalPayment = (($row2->PaymentAmount + $TotalOutstanding) < 0 ? 0 : $row2->PaymentAmount + $TotalOutstanding);
					$TotalOutstanding = $TotalOutstanding + $row2->PaymentAmount;

					$sql = "SELECT PaymentAmount FROM tb_customer_payment
							WHERE PaymentID=".$row2->PaymentID;
					$this->db->query($sql);
					$row	= $getrow->row();
					$PaymentAmount	= $row->PaymentAmount;

				    $this->db->set('PaymentAmount', $TotalPayment);
					$this->db->where('PaymentID', $row2->PaymentID);
					$this->db->update('tb_customer_payment');
					$this->last_query .= "//".$this->db->last_query();

					$this->update_customer_payment_transfer_date($row2->PaymentID, $TotalPayment);
					$this->update_invoice_balance($INVID); 

					$this->load->model('model_acc');
					$ReturAmount = $PaymentAmount - $TotalPayment;
					$this->model_acc->auto_journal_cancel_customer_payment($INVID, $ReturAmount);
				}
			};
		}
		$this->log_user->log_query($this->last_query);
	}
	function invoice_payment_auto($INVID, $date, $SOID, $TotalInvoice)
	{
		$datetimenow = date("Y-m-d H:i:s");
		$data 	= array();
		$sql 	= "SELECT TotalDeposit FROM vw_so_deposit WHERE SOID=".$SOID;
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$TotalDeposit = $row->TotalDeposit;
			$sql = "SELECT cda.*, cd.TransferDate FROM tb_customer_deposit_allocation cda 
					LEFT JOIN vw_deposit_transfer_date cd ON (cd.DepositID=cda.DepositID)
					WHERE cda.SOID=".$SOID." ORDER BY TransferDate desc, AllocationID asc";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row2) {
				if ($TotalInvoice > 0) {

					$AllocationID = $row2->AllocationID;
					$AllocationAmount = $row2->AllocationAmount;
					$DepositID = $row2->DepositID;
					// echo $TotalInvoice;
					if ($TotalInvoice >= $AllocationAmount) {
						$TotalInvoice -= $AllocationAmount;

						$this->db->where('AllocationID', $AllocationID);
						$this->db->delete('tb_customer_deposit_allocation');
						$this->last_query .= "//".$this->db->last_query();

						$data_payment = array(
							'INVID' => $INVID,
							'SOID' => $SOID,
							'DepositID' => $DepositID,
							'PaymentAmount' => $AllocationAmount,
							'PaymentDate' => $datetimenow,
							'PaymentBy' => $this->session->userdata('UserAccountID')
						);
						$this->db->insert('tb_customer_payment', $data_payment);
						$this->last_query .= "//".$this->db->last_query();

						$this->insert_customer_payment_transfer_date($INVID,$SOID,$DepositID,$AllocationAmount,$datetimenow,$this->session->userdata('UserAccountID'));

						$this->load->model('model_acc');
						$this->model_acc->auto_journal_insert_customer_payment($INVID, $AllocationAmount);
					} else {
						$AllocationAmount -= $TotalInvoice;

						$this->db->set('AllocationAmount', $AllocationAmount);
						$this->db->where('AllocationID', $AllocationID);
						$this->db->update('tb_customer_deposit_allocation');
						$this->last_query .= "//".$this->db->last_query();

						$data_payment = array(
							'INVID' => $INVID,
							'SOID' => $SOID,
							'DepositID' => $DepositID,
							'PaymentAmount' => $TotalInvoice,
							'PaymentDate' => $datetimenow,
							'PaymentBy' => $this->session->userdata('UserAccountID')
						);
						$this->db->insert('tb_customer_payment', $data_payment);
						$this->last_query .= "//".$this->db->last_query();
						
						$this->insert_customer_payment_transfer_date($INVID,$SOID,$DepositID,$TotalInvoice,$datetimenow,$this->session->userdata('UserAccountID'));

						$TotalInvoice = 0;

						$this->load->model('model_acc');
						$this->model_acc->auto_journal_insert_customer_payment($INVID, $TotalInvoice);
					}
				}
			};
			$this->cek_inv_outstanding_payment($INVID);
		}

		$this->update_invoice_balance($INVID); 
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function insert_customer_payment_transfer_date($INVID, $SOID, $DepositID, $PaymentAmount, $PaymentDateTime, $PaymentBy)
	{
		$sql 	= "SELECT cp.*, td.TransferDate FROM tb_customer_payment cp 
					left join vw_deposit_transfer_date td on cp.DepositID=td.DepositID
					where INVID=".$INVID." and SOID=".$SOID." 
					and cp.DepositID=".$DepositID." and PaymentAmount=".$PaymentAmount." 
					and PaymentDate='".$PaymentDateTime."' and PaymentBy=".$PaymentBy." 
					and PaymentBy=".$PaymentBy."";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$data_payment_transfer = array(
							'PaymentID' => $row->PaymentID,
							'INVID' => $INVID,
							'SOID' => $SOID,
							'DepositID' => $DepositID,
							'PaymentAmount' => $PaymentAmount,
							'PaymentDate' => $PaymentDateTime,
							'PaymentBy' => $PaymentBy,
							'TransferDate' => $row->TransferDate,
						);
		$this->db->insert('tb_customer_payment_transfer_date', $data_payment_transfer);
		$this->last_query .= "//".$this->db->last_query();
	}
	function update_customer_payment_transfer_date($PaymentID, $PaymentAmount)
	{
		$this->db->set('PaymentAmount', $PaymentAmount);
		$this->db->where('PaymentID', $PaymentID);
		$this->db->update('tb_customer_payment_transfer_date');
		$this->last_query .= "//".$this->db->last_query();
	}

//bank_distribution===========================================================
	function bank_distribution()
	{
		$sql = "SELECT bdm.*, bdt.DistributionTypeName, jc.CompanyName, em.fullname, bt.BankTransactionDate, jd.DivisiName 
				FROM tb_bank_distribution_main bdm
				LEFT JOIN tb_bank_distribution_type bdt ON (bdm.DistributionTypeID=bdt.DistributionTypeID)
				LEFT JOIN tb_job_company jc ON (bdm.CompanyID=jc.CompanyID)
				LEFT JOIN vw_user_account em ON (bdm.CreatedBy=em.UserAccountID) 
				LEFT JOIN tb_bank_transaction bt ON bdm.BankTransactionID=bt.BankTransactionID 
				LEFT JOIN tb_job_divisi jd ON bdm.CreatedDivisi=jd.DivisiID ";

		$MenuList = $this->session->userdata('MenuList');
		if (in_array("bank_distribution_view_all", $MenuList)) {
			$sql .= "where CreatedDivisi!= '' ";
		} else {
			$DivisiID 	= implode(',', $this->session->userdata('DivisiID'));
			$sql .= "where (CreatedDivisi in (". $DivisiID.") or bdm.CreatedBy=".$this->session->userdata('UserAccountID').") ";
		}

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= " and DistributionDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else {
			$sql .= " and (bdm.BankTransactionID=0) and (bdm.isActive=1) ";
		}
			$sql .= " order by DistributionID ";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
		$this->log_user->log_query($this->last_query);
	    return $show;
	}
	function bank_distribution_add_act()
	{
		$this->db->trans_start();

		// echo json_encode( array_keys($this->input->post()) );
		$divisi = $this->input->post("divisi");
		$company = $this->input->post("company");
		$type = $this->input->post("type");
		$note = $this->input->post("note");
		$transaction = $this->input->post("transaction");
		$contacttype = $this->input->post("contacttype");
		$scheduledate = $this->input->post("scheduledate");
		$amounttotal = $this->input->post("amounttotal");
		$contactid = $this->input->post("contactid");
		$contactname = $this->input->post("contactname");
		$notedetail = $this->input->post("notedetail");
		$amountdetail = $this->input->post("amountdetail");
		$ReffType = $this->input->post("ReffType");
		$ReffNo = $this->input->post("ReffNo");

		$sql 	= "select * from tb_bank_distribution_type where DistributionTypeID='".$type."'";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DistributionTypeCode 	= $row->DistributionTypeCode;
		$DistributionTypeNumber	= $row->DistributionTypeNumber;

		$data = array(
			'DistributionTypeID' => $type,
			'DistributionNumber' => $DistributionTypeCode.$DistributionTypeNumber,
			'CompanyID' => $company,
			'DistributionDate' => $scheduledate,
			'DistributionTotal' => $amounttotal,
			'DistributionNote' => $note,
			'BankTransactionID' => $transaction,
			'ContactType' => $contacttype,
			'CreatedDate' => date("Y-m-d H:i:s"),
			'CreatedBy' => $this->session->userdata('UserAccountID'),
			'CreatedDivisi' => $divisi,
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_bank_distribution_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql 		= "select max(DistributionID) as DistributionID from tb_bank_distribution_main ";
		$getDistributionID = $this->db->query($sql);
		$row 		= $getDistributionID->row();
		$DistributionID 	= $row->DistributionID;

		for ($i=0; $i < count($contactid);$i++) {
			$data = array(
				'DistributionID' => $DistributionID,
				'ContactID' => $contactid[$i],
				'ContactName' => $contactname[$i],
				'Note' => $notedetail[$i],
				'Amount' => $amountdetail[$i],
				'ReffType' => $ReffType[$i],
				'ReffNo' => $ReffNo[$i],
			);
			$this->db->insert('tb_bank_distribution_detail', $data);
			$this->last_query .= "//".$this->db->last_query();
   		};

   		$this->db->set('DistributionTypeNumber', 'DistributionTypeNumber +'. 1 .'',false);
		$this->db->where('DistributionTypeID', $type);
		$this->db->update('tb_bank_distribution_type');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_distribution_edit()
	{
		$this->db->trans_start();
		$show   = array();
		$id 	= $this->input->get_post("id");
		$sql = "SELECT bdm.*, bdt.DistributionTypeName, jc.CompanyName, em.fullname, 
				IFNULL(jd.DivisiName,'PRIVATE ONLY') AS DivisiName 
				FROM tb_bank_distribution_main bdm
				LEFT JOIN tb_bank_distribution_type bdt ON (bdm.DistributionTypeID=bdt.DistributionTypeID)
				LEFT JOIN tb_job_company jc ON (bdm.CompanyID=jc.CompanyID)
				LEFT JOIN vw_user_account em ON (bdm.CreatedBy=em.UserAccountID)
				LEFT JOIN tb_job_divisi jd ON jd.DivisiID=bdm.CreatedDivisi 
				where DistributionID=". $id." and DistributionReff='manual'";
		// echo $sql;
		$getrow	= $this->db->query($sql);
		if (!empty($getrow)) {
			$rowmain = $getrow->row();
			$show['main'] = (array) $rowmain;
			$show['main2'] = json_encode($show['main']);

			$sql 	= "SELECT * FROM tb_bank_distribution_detail where DistributionID=".$id;
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
			  	$show['detail'][] = array(
			  		'DistributionID' => $row->DistributionID,
					'ContactID' => $row->ContactID,
					'ContactName' => $row->ContactName,
					'Note' => $row->Note,
					'Amount' => $row->Amount,
					'ReffType' => $row->ReffType,
					'ReffNo' => $row->ReffNo,
				);
			};
			$show['detail2'] = json_encode($show['detail']);
		    return $show;
		}
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_distribution_edit_act()
	{
		$this->db->trans_start();

		// echo json_encode( $this->input->post());
		$DistributionID = $this->input->post("DistributionID");
		$divisi = $this->input->post("divisi");
		$company = $this->input->post("company");
		$type = $this->input->post("type");
		$note = $this->input->post("note");
		$contacttype = $this->input->post("contacttype");
		$scheduledate = $this->input->post("scheduledate");
		$amounttotal = $this->input->post("amounttotal");
		$contactid = $this->input->post("contactid");
		$contactname = $this->input->post("contactname");
		$notedetail = $this->input->post("notedetail");
		$amountdetail = $this->input->post("amountdetail");
		$ReffType = $this->input->post("ReffType");
		$ReffNo = $this->input->post("ReffNo");

		$data = array(
			'DistributionTypeID' => $type,
			'CompanyID' => $company,
			'DistributionDate' => $scheduledate,
			'DistributionTotal' => $amounttotal,
			'DistributionNote' => $note,
			'ContactType' => $contacttype,
			'CreatedDivisi' => $divisi,
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);

		// cek type distribution
		$sql 	= "select DistributionTypeID from tb_bank_distribution_main where DistributionID='".$DistributionID."'";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();

		$DistributionTypeID = $row->DistributionTypeID;
		if ($type != $DistributionTypeID) {
			$sql 	= "select * from tb_bank_distribution_type where DistributionTypeID='".$type."'";
			$getrow = $this->db->query($sql);
			$row 	= $getrow->row();
			$DistributionTypeCode 	= $row->DistributionTypeCode;
			$DistributionTypeNumber	= $row->DistributionTypeNumber;
			$data['DistributionNumber'] = $DistributionTypeCode.$DistributionTypeNumber;
		}
		// ---------------------------------------------------------------------
		$this->db->where('DistributionID', $DistributionID);
		$this->db->update('tb_bank_distribution_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$this->db->where('DistributionID', $DistributionID);
		$this->db->delete('tb_bank_distribution_detail');
		$this->last_query .= "//".$this->db->last_query();

		for ($i=0; $i < count($contactid);$i++) {
			$data = array(
				'DistributionID' => $DistributionID,
				'ContactID' => $contactid[$i],
				'ContactName' => $contactname[$i],
				'Note' => $notedetail[$i],
				'Amount' => $amountdetail[$i],
				'ReffType' => $ReffType[$i],
				'ReffNo' => $ReffNo[$i],
			);
			$this->db->insert('tb_bank_distribution_detail', $data);
			$this->last_query .= "//".$this->db->last_query();
   		};

   		$this->db->set('DistributionTypeNumber', 'DistributionTypeNumber +'. 1 .'',false);
		$this->db->where('DistributionTypeID', $type);
		$this->db->update('tb_bank_distribution_type');
		$this->last_query .= "//".$this->db->last_query();
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_distribution_delete()
	{
		$this->db->trans_start();

		$DistributionID = $this->input->post("DistributionID");

		$sql 	= "select * from tb_bank_distribution_main where DistributionID='".$DistributionID."' and BankTransactionID=0";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();

		if (!empty($row)) {
			$this->db->where('DistributionID', $DistributionID);
			$this->db->delete('tb_bank_distribution_detail');
			$this->last_query .= "//".$this->db->last_query();

			$this->db->where('DistributionID', $DistributionID);
			$this->db->delete('tb_bank_distribution_main');
			$this->last_query .= "//".$this->db->last_query();

			echo json_encode("success");
		} else {
			echo json_encode("fail");
		}
		
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	}
	function setBankTransactionID()
	{
		$this->db->trans_start();

		// echo json_encode( array_keys($this->input->post()) );
		$DistributionID = $this->input->post("DistributionID");
		$BankTransactionID = $this->input->post("BankTransactionID");
		
		$this->db->set('BankTransactionID', $BankTransactionID);
		$this->db->where('DistributionID', $DistributionID);
		$this->db->update('tb_bank_distribution_main');
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function bank_distribution_print()
	{
		$show   = array();
		$id 	= $this->input->get_post("id");

		$sql = "SELECT bdm.*, bdt.DistributionTypeName, jc.CompanyName, jc.CompanyAddress, em.fullname
				FROM tb_bank_distribution_main bdm
				LEFT JOIN tb_bank_distribution_type bdt ON (bdm.DistributionTypeID=bdt.DistributionTypeID)
				LEFT JOIN tb_job_company jc ON (bdm.CompanyID=jc.CompanyID)
				LEFT JOIN vw_user_account em ON (bdm.CreatedBy=em.UserAccountID) 
				where DistributionID=". $id;
		$getrow	= $this->db->query($sql);
		$rowmain = $getrow->row();
		$show['main'] = (array) $rowmain;

		if ($show['main']['DistributionReff'] == 'retur') {
			$sql = "SELECT ReturID FROM tb_customer_deposit_retur where DistributionID=". $id;
			$getrow	= $this->db->query($sql);
			$row = $getrow->row();
			$show['main']['info'] = "Retur ID ".$row->ReturID;
		}

		$sql 	= "SELECT * FROM tb_bank_distribution_detail where DistributionID=".$id." order by ContactName";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		  		'DistributionID' => $row->DistributionID,
				'ContactName' => $row->ContactName,
				'Note' => $row->Note,
				'Amount' => $row->Amount,
				'ReffType' => $row->ReffType,
				'ReffNo' => $row->ReffNo,
			);
		};
	    return $show;
	}
	function bank_distribution_print_all()
	{
		$show   = array();
		$id 	= $this->input->get_post("data");
		$source	= $this->input->get_post("source");

		if (isset($source)) {
			$sql = "SELECT DistributionID FROM tb_bank_distribution_main WHERE BankTransactionID IN (".$id.")";
			$query 	= $this->db->query($sql);
			$id = '';
			foreach ($query->result() as $row) {
				$id .= $row->DistributionID.',';
			}
			$id = substr($id, 0, -1);
		}

		$sql = "SELECT bdm.*, bdt.DistributionTypeName, jc.CompanyName, jc.CompanyAddress, em.fullname
				FROM tb_bank_distribution_main bdm
				LEFT JOIN tb_bank_distribution_type bdt ON (bdm.DistributionTypeID=bdt.DistributionTypeID)
				LEFT JOIN tb_job_company jc ON (bdm.CompanyID=jc.CompanyID)
				LEFT JOIN vw_user_account em ON (bdm.CreatedBy=em.UserAccountID) 
				where DistributionID in (".$id.")";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show['detail'][] = array(
		  		'DistributionID' => $row->DistributionID,
		  		'DistributionNumber' => $row->DistributionNumber,
		  		'DistributionDate' => $row->DistributionDate,
		  		'DistributionTotal' => $row->DistributionTotal,
		  		'DistributionNote' => $row->DistributionNote,
		  		'fullname' => $row->fullname,
			);
			$show['main']['PrintBy'] = $this->session->userdata('UserName');
			$show['main']['DistributionTypeName'] = $row->DistributionTypeName;
			$show['main']['CompanyName'] = $row->CompanyName;
			$show['main']['CompanyAddress'] = $row->CompanyAddress;
		};

	    return $show;
	}
	function get_distribution_detail()
	{
		$DistributionID = $this->input->get_post('DistributionID');
		$sql 	= "SELECT dm.*, dt.DistributionTypeTransaction, bm.BankID, bm.BankName FROM tb_bank_distribution_main dm
					LEFT JOIN tb_bank_distribution_type dt ON dm.DistributionTypeID=dt.DistributionTypeID
					LEFT JOIN tb_bank_main bm ON dt.BankID=bm.BankID WHERE dm.DistributionID=".$DistributionID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show = array(
				'DistributionID' => $row->DistributionID,
				'BankID' => $row->BankID,
				'BankName' => $row->BankName,
				'DistributionNote' => $row->DistributionNote,
				'DistributionTotal' => $row->DistributionTotal,
				'DistributionTypeTransaction' => $row->DistributionTypeTransaction,
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function inputIntoBankTransaction()
	{
		$this->db->trans_start();

		$distribution 	= $this->input->post('distribution'); 
		$BankID 	= $this->input->post('BankID'); 
		$bmdate = $this->input->post('bmdate');
		$bmnote = $this->input->post('bmnote'); 
		$bmtype = $this->input->post('bmtype');
		$bmamount = $this->input->post('bmamount'); 
		$year 	= date('y', strtotime($bmdate));
		$month 	= date('m', strtotime($bmdate));
		$day 	= date('d', strtotime($bmdate));
		$hour 	= date('H', strtotime($bmdate));
		$minute = date('i', strtotime($bmdate));
		$second = date('s', strtotime($bmdate));
		$BankTransactionIDNew = $year.$month.$day.$hour.$minute.$second."00";
 
		try {
			$proses = $this->insert_transaction($BankTransactionIDNew, $BankID, $bmdate, $bmnote, $bmtype, $bmamount);

			$this->db->set('BankTransactionID', $BankTransactionIDNew);
			$this->db->where('DistributionID', $distribution);
			$this->db->update('tb_bank_distribution_main');
			$this->last_query .= "//".$this->db->last_query();

		} catch (Exception $e) { }

		$DistributionID[] = $distribution;
		$JournalDate[] = $bmdate;
		$JournalNote[] = $bmnote;
		$JournalType[] = $bmtype;
		$JournalAmount[] = $bmamount;
    	$this->load->model('model_acc');
    	$this->model_acc->auto_journal_distribution_transaction($DistributionID, $BankID, $JournalDate, $JournalNote, $JournalType, $JournalAmount);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    return $this->db->trans_status();
	}
	function excel_distribution($data, $note)
	{
		$this->db->trans_start();

        // echo json_encode($note);
		$no = 0;
        $data_all = array();
		$CompanyID = $this->input->post('company');
		$CompanyName = $this->input->post('CompanyName');
		$DistributionTypeID = $this->input->post('type');
		$Date = $this->input->post('filterupload');

		$this->db->select('DistributionID, DistributionNote');
		$this->db->where_in('DistributionNote', $note);
		$query = $this->db->get('tb_bank_distribution_main');

		// for auto journal 
		$JournalDistributionID = array();
		$BankID = 0;
		$JournalDate = array();
		$JournalNote = array();
		$JournalType = array();
		$JournalAmount = array();

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$newdata['error_info'] = "upload excel gagal, transaksi sudah pernah upload dengan note : '".$row->DistributionNote."' ";
			$this->session->set_userdata($newdata);
		
		} else {

			$this->db->select('BankID, DistributionTypeTransaction, DistributionTypeCode, DistributionTypeNumber');
			$this->db->where('DistributionTypeID', $DistributionTypeID);
			$query = $this->db->get('tb_bank_distribution_type');
			$row = $query->row();

			$BankID = $row->BankID;
			$DistributionTypeTransaction = $row->DistributionTypeTransaction;
			$DistributionTypeCode 	= $row->DistributionTypeCode;
			$DistributionTypeNumber	= $row->DistributionTypeNumber;
			$DivisiID 	= $this->session->userdata('DivisiID');

	        foreach ($data as $key => $value) {
				$hapus = array(" DB"," CR");
				$value[3] = str_replace($hapus,"",$value[3]);
				$amount = floatval(str_replace(",","",$value[3]));

				// insert bank distribution
				$data = array(
					'DistributionTypeID' => $DistributionTypeID,
					'DistributionNumber' => $DistributionTypeCode.$DistributionTypeNumber,
					'CompanyID' => $CompanyID,
					'DistributionDate' => $Date,
					'DistributionTotal' => $amount,
					'DistributionNote' => $value[1],
					'ContactType' => 'company',
					'CreatedDate' => date("Y-m-d H:i:s"),
					'CreatedBy' => $this->session->userdata('UserAccountID'),
					'CreatedDivisi' => $DivisiID[0],
					'InputDate' => date("Y-m-d H:i:s"),
					'InputBy' => $this->session->userdata('UserAccountID'),
					'ModifiedDate' => date("Y-m-d H:i:s"),
					'ModifiedBy' => $this->session->userdata('UserAccountID'),
				);
				$this->db->insert('tb_bank_distribution_main', $data);
				$this->last_query .= "//".$this->db->last_query();

				$DistributionTypeNumber++;
				$no++;

				$sql 		= "select max(DistributionID) as DistributionID from tb_bank_distribution_main ";
				$getDistributionID = $this->db->query($sql);
				$row2 		= $getDistributionID->row();
				$DistributionID 	= $row2->DistributionID;
				
				
				$data = array(
					'DistributionID' => $DistributionID,
					'ContactID' => $CompanyID,
					'ContactName' => $CompanyName,
					'Note' => $value[1],
					'Amount' => $amount,
				);
				$this->db->insert('tb_bank_distribution_detail', $data);
				$this->last_query .= "//".$this->db->last_query();


				if ( $row->DistributionTypeTransaction == 'credit' ) {
					$value[3] .= " DB";
				} elseif ( $row->DistributionTypeTransaction == 'debit' ) {
					$value[3] .= " CR";
				}
				$value[] = $DistributionID;
	            array_push($data_all, $value);

				$JournalDistributionID[] = $DistributionID;
				$JournalDate[] = $Date;
				$JournalNote[] = $value[1];
				$JournalType[] = $row->DistributionTypeTransaction;
				$JournalAmount[] = $amount;
			}

	   		$this->db->set('DistributionTypeNumber', 'DistributionTypeNumber +'. $no .'',false);
			$this->db->where('DistributionTypeID', $DistributionTypeID);
			$this->db->update('tb_bank_distribution_type');
			$this->last_query .= "//".$this->db->last_query();

	        // echo json_encode($data_all);
		}

		$this->excel_transaction($data_all, $note);

    	$this->load->model('model_acc');
    	$this->model_acc->auto_journal_distribution_transaction($JournalDistributionID, $BankID, $JournalDate, $JournalNote, $JournalType, $JournalAmount);

	    $this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function cekReffDistribution()
	{
		$ReffTypeMain = $this->input->get_post('ReffTypeMain');
		$ReffNoMain = $this->input->get_post('ReffNoMain');
		$sql 	= "SELECT * FROM tb_bank_distribution_detail where ReffType='".$ReffTypeMain."' and ReffNo=".$ReffNoMain."";
		$query 	= $this->db->query($sql);
		echo json_encode($query->num_rows());
	}
	function bank_distribution_add_auto($DistributionTypeID, $amount, $note, $ContactType, $ContactID=0, $ContactName='',$BankTransactionID)
	{
		$this->db->trans_start();

		$sql = "select jc.CompanyID, jc.CompanyName, bm.BankID, bdt.DistributionTypeTransaction 
				from tb_bank_distribution_type bdt 
				left join tb_bank_main bm on bm.BankID=bdt.BankID 
				left join tb_job_company jc on jc.CompanyID=bdt.BankID 
				where DistributionTypeID='".$DistributionTypeID."'";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$CompanyID = $row->CompanyID;
		$CompanyName = $row->CompanyName;
		$BankID = $row->BankID;
		$DistributionTypeTransaction = $row->DistributionTypeTransaction;
		$Date 	= date("Y-m-d H:i:s");

		$sql 	= "select * from tb_bank_distribution_type where DistributionTypeID='".$DistributionTypeID."'";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$DistributionTypeCode 	= $row->DistributionTypeCode;
		$DistributionTypeNumber	= $row->DistributionTypeNumber;
		$DivisiID 	= $this->session->userdata('DivisiID');

		$data = array(
			'DistributionTypeID' => $DistributionTypeID,
			'DistributionNumber' => $DistributionTypeCode.$DistributionTypeNumber,
			'CompanyID' => $CompanyID,
			'DistributionDate' => $Date,
			'DistributionTotal' => $amount,
			'DistributionNote' => $note,
			'BankTransactionID' => $BankTransactionID,
			'ContactType' => $ContactType,
			'CreatedDate' => $Date,
			'CreatedBy' => $this->session->userdata('UserAccountID'),
			'CreatedDivisi' => $DivisiID[0],
			'InputDate' => $Date,
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => $Date,
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_bank_distribution_main', $data);
		$this->last_query .= "//".$this->db->last_query();

		$sql = "select max(DistributionID) as DistributionID from tb_bank_distribution_main ";
		$getDistributionID = $this->db->query($sql);
		$row = $getDistributionID->row();
		$DistributionID = $row->DistributionID;

		$data = array(
			'DistributionID' => $DistributionID,
			'ContactID' => ($ContactID==0 ? $CompanyID : $ContactID),
			'ContactName' => ($ContactName=='' ? $CompanyName : $ContactName),
			'Note' => $note,
			'Amount' => $amount,
		);
		$this->db->insert('tb_bank_distribution_detail', $data);
		$this->last_query .= "//".$this->db->last_query();

   		$this->db->set('DistributionTypeNumber', 'DistributionTypeNumber +'. 1 .'',false);
		$this->db->where('DistributionTypeID', $DistributionTypeID);
		$this->db->update('tb_bank_distribution_type');
		$this->last_query .= "//".$this->db->last_query();

    	$this->load->model('model_acc');
    	$DistributionIDArr = array($DistributionID);
    	$DateArr = array($Date);
    	$noteArr = array($note);
    	$DistributionTypeTransactionArr = array($DistributionTypeTransaction);
    	$amountArr = array($amount);
    	$this->model_acc->auto_journal_distribution_transaction($DistributionIDArr, $BankID, $DateArr, $noteArr, $DistributionTypeTransactionArr, $amountArr);

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
	    // return $this->db->trans_status();
	}
	function distribution_delete_batch()
	{
		$this->db->trans_start();

		$DistributionID = $this->input->get_post('data');
		$resDistributionID = array();
		$sql 	= "SELECT DistributionID FROM tb_bank_distribution_main WHERE BankTransactionID=0 and DistributionID in (" . implode(',', array_map('intval', $DistributionID)) . ") and DistributionReff='manual'  ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $key => $value) {
			$resDistributionID[] = $value->DistributionID;
		}

		$sql 	= "delete FROM tb_bank_distribution_main WHERE BankTransactionID=0 and DistributionID in (" . implode(',', array_map('intval', $resDistributionID)) . ") and DistributionReff='manual' ";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$sql 	= "delete FROM tb_bank_distribution_detail WHERE DistributionID in (" . implode(',', array_map('intval', $resDistributionID)) . ")";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();

		echo json_encode(count($resDistributionID));
	}
	function distribution_disable_batch()
	{
		$this->db->trans_start();

		$DistributionID = $this->input->get_post('data');
		$resDistributionID = array();
		$sql 	= "SELECT DistributionID FROM tb_bank_distribution_main 
					WHERE BankTransactionID=0 and isActive=1 
					and DistributionID in (" . implode(',', array_map('intval', $DistributionID)) . ") ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $key => $value) {
			$resDistributionID[] = $value->DistributionID;
		}

		$sql 	= "update tb_bank_distribution_main set isActive=0 
					WHERE BankTransactionID=0 
					and DistributionID in (" . implode(',', array_map('intval', $resDistributionID)) . ") ";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();

		echo json_encode(count($resDistributionID));
	}
	function distribution_enable_batch()
	{
		$this->db->trans_start();

		$DistributionID = $this->input->get_post('data');
		$resDistributionID = array();
		$sql 	= "SELECT DistributionID FROM tb_bank_distribution_main 
					WHERE BankTransactionID=0 and isActive=0 
					and DistributionID in (" . implode(',', array_map('intval', $DistributionID)) . ") ";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $key => $value) {
			$resDistributionID[] = $value->DistributionID;
		}

		$sql 	= "update tb_bank_distribution_main set isActive=1 
					WHERE BankTransactionID=0 
					and DistributionID in (" . implode(',', array_map('intval', $resDistributionID)) . ") ";
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();

		echo json_encode(count($resDistributionID));
	}

//customer_retur==============================================================
	function customer_retur()
	{
		$sql = "SELECT cdr.*, cd.CustomerID, cd.TransferDate, cd.DepositAmount, vem.fullname as employee, c.Company2 as Customer
				FROM tb_customer_deposit_retur cdr
				LEFT JOIN vw_deposit_transfer_date cd ON cdr.DepositID=cd.DepositID
				LEFT JOIN vw_user_account vem ON (cdr.ReturBy = vem.UserAccountID)
				LEFT JOIN vw_deposit_balance vdb ON (cd.DepositID = vdb.DepositID)
				LEFT JOIN tb_customer_main cm ON cd.CustomerID=cm.CustomerID
				LEFT JOIN vw_contact2 c ON cm.ContactID=c.ContactID ";

		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= " where ReturDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' ";
		} else {
			$sql .= " order by ReturID desc limit ".$this->limit_result."";
		}
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
	  			'ReturID' => $row->ReturID,
	  			'CustomerID' => $row->CustomerID,
	  			'DistributionID' => $row->DistributionID,
	  			'DepositID' => $row->DepositID,
	  			'Customer' => $row->Customer,
				'TransferDate' => $row->TransferDate,
	  			'ReturDate' => $row->ReturDate,
	  			'DepositAmount' => $row->DepositAmount,
	  			'ReturAmount' => $row->ReturAmount,
	  			'employee' => $row->employee
			);
		};
		$this->log_user->log_query($this->last_query);
	    return $show;
	}

//============================================================================
	function fill_transaction()
	{
		$sql 	= "select * from tb_bank_main";
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'BankID' => $row->BankID,
				'BankName' => $row->BankName
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function fill_bank_distribution_type()
	{
		$CompanyID = $this->input->get_post('CompanyID');
		if ($CompanyID == 0) {
			$sql 	= "SELECT * From tb_job_company where CompanyClass=1";  
			$query 	= $this->db->query($sql);	
			$row 	= $query->row();
			$CompanyID = $row->CompanyID;
		}
		$sql 	= "select bd.* from tb_bank_distribution_type bd
					LEFT JOIN tb_bank_main bm ON bd.BankID=bm.BankID
					WHERE bm.CompanyID=".$CompanyID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = array(
				'DistributionTypeID' => $row->DistributionTypeID,
				'BankID' => $row->BankID,
				'DistributionTypeName' => $row->DistributionTypeName,
				'DistributionTypeCode' => $row->DistributionTypeCode,
				'DistributionTypeNumber' => $row->DistributionTypeNumber
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function get_customer_deposit_dst()
	{
		$show 	= array();
		$CustomerID = $this->input->get_post('CustomerID');
		$sql 	= "SELECT t1.*, t1.ProductQty-COALESCE(t2.INVQty,0) AS Pending
					FROM (
						SELECT sm.SOID, vsf.TotalOutstanding, sd.ProductQty
						FROM tb_so_main sm
						LEFT JOIN vw_so_balance vsf ON (sm.SOID=vsf.SOID)
						LEFT JOIN vw_so_do2 sd ON sd.SOID=sm.SOID
						WHERE sm.CustomerID = ".$CustomerID."
						AND vsf.TotalOutstanding>0 and sm.SOStatus<>0 
						order by sm.SOID
					) t1 
					LEFT JOIN (
						SELECT im.INVID, im.SOID, SUM(id.ProductQty) AS INVQty
						FROM tb_invoice_main im 
						LEFT JOIN tb_invoice_detail id ON im.INVID=id.INVID
						WHERE im.CustomerID = ".$CustomerID."
						GROUP BY im.SOID
					) t2 ON t1.SOID = t2.SOID
					HAVING Pending>0";
		$query 	= $this->db->query($sql);	
		foreach ($query->result() as $row) {
			$show[] = array(
				'SOID' => "SO ".$row->SOID,
				'SOName' => "SO ".$row->SOID."/ ",
				'TotalOutstanding' => number_format($row->TotalOutstanding,2),
				'TotalOutstanding2' => $row->TotalOutstanding
			);
		};

		$sql 	= "SELECT *	FROM vw_invoice_balance2 
					WHERE CustomerID = ".$CustomerID." and TotalOutstanding>0 order by INVID";
		$query 	= $this->db->query($sql);	
		foreach ($query->result() as $row) {
			$show[] = array(
				'SOID' => "INV ".$row->INVID."-SO ".$row->SOID,
				'SOName' => "INV ".$row->INVID."-SO ".$row->SOID."/ ",
				'TotalOutstanding' => number_format($row->TotalOutstanding,2),
				'TotalOutstanding2' => $row->TotalOutstanding
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function get_customer_payment_rsc()
	{
		$show 	= array();
		$SOID 	= $this->input->get_post('SOID');
		$sql 	= "SELECT * FROM tb_customer_deposit_allocation WHERE SOID = ".$SOID;
		$query 	= $this->db->query($sql);	
		foreach ($query->result() as $row) {
			$show[] = array(
				'AllocationID' => $row->AllocationID,
				'DepositID' => $row->DepositID,
				'AllocationAmount' => $row->AllocationAmount,
				'AllocationAmount2' => number_format($row->AllocationAmount,2)
			);
		};
		$this->log_user->log_query($this->last_query);
		echo json_encode($show);
	}
	function get_customer_debt($CustomerID)
	{
		$sql 	= "SELECT COALESCE(SUM(TotalOutstanding),0) as TotalOutstanding FROM vw_so_balance vsb 
					WHERE CustomerID=".$CustomerID." and PaymentWay='TOP' and SOConfirm1=1 
					AND vsb.SOID NOT IN (
						SELECT sm.SOID FROM tb_do_main dm 
						LEFT JOIN tb_so_main sm ON dm.DOType='SO' AND dm.DOReff=sm.SOID
						LEFT JOIN vw_so_do2 sd ON sm.SOID=sd.SOID
						WHERE dm.DOStatus=1 AND sm.SOCategory NOT in (1,2,7) AND sd.Pending=0 AND sm.CustomerID=".$CustomerID."
					) ";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$TotalOutstanding = $row->TotalOutstanding;
		$this->log_user->log_query($this->last_query);
	    return $TotalOutstanding;
	}
	function get_customer_debt2($CustomerID, $SOID)
	{
		$sql 	= "SELECT COALESCE(SUM(TotalOutstanding),0) as TotalOutstanding FROM vw_so_balance vsb 
					WHERE CustomerID=".$CustomerID." and PaymentWay='TOP' and SOConfirm1=1 and SOID<>".$SOID."
					AND vsb.SOID NOT IN (
						SELECT sm.SOID FROM tb_do_main dm 
						LEFT JOIN tb_so_main sm ON dm.DOType='SO' AND dm.DOReff=sm.SOID
						LEFT JOIN vw_so_do2 sd ON sm.SOID=sd.SOID
						WHERE dm.DOStatus=1 AND sm.SOCategory NOT in (1,2,7) AND sd.Pending=0 AND sm.CustomerID=".$CustomerID."
					)";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		$TotalOutstanding = $row->TotalOutstanding;
		$this->log_user->log_query($this->last_query);
	    return $TotalOutstanding;
	}
	function cek_so_outstanding_deposit($SOID)
	{
		$sql = "select SOID, CustomerID, SOTotal, TotalOutstanding from vw_so_balance where SOID=".$SOID;
		$getrow = $this->db->query($sql);
		$row = $getrow->row();
		$SOID = $row->SOID;
		$CustomerID = $row->CustomerID;
		$TotalOutstanding = $row->TotalOutstanding;

		if ($TotalOutstanding <= 100 && $TotalOutstanding > 0) {
			$sql = "select DepositID, CustomerID, TotalBalance 
					from vw_deposit_balance2 
					where TotalBalance>=".$TotalOutstanding." and CustomerID=".$CustomerID." limit 1";
			$getrow = $this->db->query($sql);
			$countDepositFree = $getrow->num_rows();
			$row = $getrow->row();

			if ($countDepositFree > 0) {
				$DepositID = $row->DepositID;
				$data_deposit = array(
					'SOID' => $SOID,
					'DepositID' => $DepositID,
					'AllocationAmount' => $TotalOutstanding,
					'AllocationDate' => date("Y-m-d H:i:s"),
					'AllocationBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->insert('tb_customer_deposit_allocation', $data_deposit);
				$this->last_query .= "//".$this->db->last_query();
			} else {
				$sql = "SELECT BankTransactionID, BankTransactionDate
						FROM tb_bank_transaction order by BankTransactionDate desc, BankTransactionID desc limit 1";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$BankTransactionID = $row->BankTransactionID+1;
				$BankTransactionDate = $row->BankTransactionDate;
				$this->model_finance->bank_transaction_add_under2($SOID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
				$this->model_finance->confirmation_deposit_allocation_act_under($SOID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding);
			}
		}
	}
	function cek_inv_outstanding_payment($INVID)
	{
		$datetimenow	= date("Y-m-d H:i:s");
		$sql = "select SOID, CustomerID, TotalOutstanding, PriceTotal from vw_invoice_balance where INVID=".$INVID;
		$getrow = $this->db->query($sql);
		$row = $getrow->row();
		$SOID = $row->SOID;
		$CustomerID = $row->CustomerID;
		$PriceTotal = $row->PriceTotal;
		$TotalOutstanding = $row->TotalOutstanding;

		// cek MP fee 
		$sql = "SELECT sm.SOID, sm.MPfee, COALESCE(bd.DistributionID,0) AS DistributionID
				FROM tb_so_main2 sm
				LEFT JOIN tb_bank_distribution_detail bd ON sm.SOID=bd.ReffNo AND bd.ReffType='SO'
				WHERE sm.SOID=".$SOID;
		$getrow = $this->db->query($sql);
		$row = $getrow->row();
		$DistributionID = $row->DistributionID;
		$MPfee = $row->MPfee;
		if ($DistributionID == 0 && $MPfee>0 && $TotalOutstanding>0) {
			$MPfee = ($PriceTotal/100) * $MPfee;
			$MPfee = ($TotalOutstanding > $MPfee) ? $MPfee : $TotalOutstanding ;

			if ($TotalOutstanding < ($MPfee + 100)) {
				$TotalOutstanding -= $MPfee;

				$sql 	= "SELECT cp.DepositID, cd.SourceReff, bt.BankTransactionDate
							FROM tb_customer_payment cp
							LEFT JOIN tb_customer_deposit cd ON cp.DepositID=cd.DepositID
							LEFT JOIN tb_bank_transaction bt ON cd.SourceReff=bt.BankTransactionID
							WHERE cp.INVID=".$INVID." ORDER BY bt.BankTransactionDate DESC LIMIT 1";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$DepositID = $row->DepositID;

				$sql 	= "SELECT MAX(BankTransactionID) AS BankTransactionID, MAX(BankTransactionDate) AS BankTransactionDate
							FROM tb_bank_transaction WHERE DATE(BankTransactionDate)='".date("Y-m-d", strtotime($row->BankTransactionDate))."'";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$BankTransactionID = $row->BankTransactionID+1;
				$BankTransactionDate = $row->BankTransactionDate;

				$this->bank_transaction_add_under($INVID, $BankTransactionID, $BankTransactionDate, $MPfee); 
				$this->confirmation_deposit_distribution_act_under($SOID, $INVID, $CustomerID, $BankTransactionID, $BankTransactionDate, $MPfee); 
			}
		}

		// cek outstanding 
		$sql = "select DepositID, CustomerID, TotalBalance 
				from vw_deposit_balance 
				where TotalBalance>=".$TotalOutstanding." and CustomerID=".$CustomerID." limit 1";
		$getrow = $this->db->query($sql);
		$countDepositFree = $getrow->num_rows();
		$row = $getrow->row();

		if ($TotalOutstanding <= 100 && $TotalOutstanding > 0) {
			if ($countDepositFree > 0) {
				$DepositID = $row->DepositID;
				$data_payment = array(
					'INVID' => $INVID,
					'SOID' => $SOID,
					'DepositID' => $DepositID,
					'PaymentAmount' => $TotalOutstanding,
					'PaymentDate' => $datetimenow,
					'PaymentBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->insert('tb_customer_payment', $data_payment);
				$this->last_query .= "//".$this->db->last_query();

				$this->insert_customer_payment_transfer_date($INVID,$SOID,$DepositID,$TotalOutstanding,$datetimenow,$this->session->userdata('UserAccountID'));
				$this->update_invoice_balance($INVID); 

				$this->load->model('model_acc');
				$this->model_acc->auto_journal_insert_customer_payment($INVID, $TotalOutstanding);
			} else {
				$sql 	= "SELECT cp.DepositID, cd.SourceReff, bt.BankTransactionDate
							FROM tb_customer_payment cp
							LEFT JOIN tb_customer_deposit cd ON cp.DepositID=cd.DepositID
							LEFT JOIN tb_bank_transaction bt ON cd.SourceReff=bt.BankTransactionID
							WHERE cp.INVID=".$INVID." ORDER BY bt.BankTransactionDate DESC LIMIT 1";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$DepositID = $row->DepositID;

				$sql 	= "SELECT MAX(BankTransactionID) AS BankTransactionID, MAX(BankTransactionDate) AS BankTransactionDate
							FROM tb_bank_transaction WHERE DATE(BankTransactionDate)='".date("Y-m-d", strtotime($row->BankTransactionDate))."'";
				$getrow = $this->db->query($sql);
				$row 	= $getrow->row();
				$BankTransactionID = $row->BankTransactionID+1;
				$BankTransactionDate = $row->BankTransactionDate;

				$this->bank_transaction_add_under($INVID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
				$this->confirmation_deposit_distribution_act_under($SOID, $INVID, $CustomerID, $BankTransactionID, $BankTransactionDate, $TotalOutstanding); 
			}
		}
	}
	function update_invoice_balance($INVID)
	{
		$sql = "SELECT INVID, INVTotal, PaymentAmount, INVDate, TransferDate, PaymentDate FROM (
				SELECT im.INVID, im.INVTotal, COALESCE(t1.PaymentAmount,0) AS PaymentAmount, 
				im.INVDate, t1.TransferDate, GREATEST(COALESCE(t1.TransferDate,0),im.INVDate) AS PaymentDate
				FROM tb_invoice_main im 
				LEFT JOIN (
				SELECT MAX(td.TransferDate) AS TransferDate, GROUP_CONCAT(td.TransferDate) AS TransferDate2, 
				GROUP_CONCAT(cp.DepositID) AS DepositID, cp.INVID,  SUM(cp.PaymentAmount) AS PaymentAmount
				FROM tb_customer_payment cp
				LEFT JOIN tb_customer_deposit cd ON cp.DepositID=cd.DepositID
				LEFT JOIN vw_deposit_transfer_date td ON cd.DepositID=td.DepositID
				WHERE cp.INVID=".$INVID." GROUP BY cp.INVID
				) t1 ON im.INVID=t1.INVID 
				WHERE im.INVID=".$INVID."
				) t2";
		$getrow = $this->db->query($sql);
		$row 	= $getrow->row();
		$data = array(
			'INVTotal' => $row->INVTotal,
			'PaymentAmount' => $row->PaymentAmount,
			'INVDate' => $row->INVDate,
			'TransferDate' => $row->TransferDate,
			'PaymentDate' => $row->PaymentDate,
		);

		$this->db->where('INVID',$INVID);
		$q = $this->db->get('tb_invoice_balance');

		if ( $q->num_rows() > 0 ) 
		{
		  $this->db->where('INVID',$INVID);
		  $this->db->update('tb_invoice_balance',$data);
		} else {
		  $this->db->set('INVID', $INVID);
		  $this->db->insert('tb_invoice_balance',$data);
		}
		$this->last_query .= "//".$this->db->last_query();
	}

}
?>