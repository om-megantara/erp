<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_finance2 extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

//bank_transaction============================================================
	function bank_transaction()
	{
		$sql = "SELECT * FROM tb_bank_transaction tbm ";
		$sql .= "LEFT JOIN tb_bank_main bm ON bm.BankID = tbm.BankID ";
		$sql .= "WHERE MONTH(BankTransactionDate) = MONTH(CURRENT_DATE()) AND YEAR(BankTransactionDate) = YEAR(CURRENT_DATE())";
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'BankTransactionID' => $row->BankTransactionID,
		  			'BankName' => $row->BankName,
		  			'BankTransactionDate' => $row->BankTransactionDate,
					'BankTransactionType' => $row->BankTransactionType,
					'BankTransactionNote' => $row->BankTransactionNote,
		  			'BankTransactionAmount' => $row->BankTransactionAmount,
		  			'BankTransactionBalance' => $row->BankTransactionBalance
				);
		};
	    return $show;
	}
	function bank_transaction_add()
	{
		$bank = $this->input->post('bank'); 
		$bmdate = $this->input->post('bmdate');
		$bmnote = $this->input->post('bmnote'); 
		$bmtype = $this->input->post('bmtype');
		$bmamount = $this->input->post('bmamount'); 
		

		$sql 			= "select BankBalance from tb_bank_main where BankID='".$bank."'";
		$getbalance 	= $this->db->query($sql);
		$row 			= $getbalance->row();
		if($bmtype=='credit'){
			$balancenext	= $row->BankBalance+$bmamount;}
		elseif($bmtype=='debit'){
			$balancenext	= $row->BankBalance-$bmamount;}
		
		$sqlmax			= "select * from tb_bank_transaction order by BankTransactionID desc limit 0,1";
		$getBankTransactionID 	= $this->db->query($sqlmax);
		$rowmax 			= $getBankTransactionID->row();
		$bmID 	= $rowmax->BankTransactionID+1;
		
		if (empty($rowmax) || ($bmdate>$rowmax->BankTransactionDate && $getBankTransactionID->num_rows() == 1)) {
			$bank_update = array(
				'BankBalance' => $balancenext,
				'LastTransactionID'	=> $bmID
			);
			$this->db->where('BankID', $bank);
			$this->db->update('tb_bank_main', $bank_update);

			$bmdata = array(
				'BankID' 	=> $bank,
				'BankTransactionDate'	=> $bmdate,
				'BankTransactionType'	=> $bmtype,
				'BankTransactionAmount'	=> $bmamount,
				'BankTransactionBalance'	=> $balancenext,
				'BankBranch'	=> '0',
				'BankTransactionNote'	=> $bmnote,
				'InsertBy'	=> $this->session->userdata('UserAccountID')
			);
			$this->db->insert('tb_bank_transaction', $bmdata);
		} elseif ($getBankTransactionID->num_rows() > 1) {
			foreach ($getBankTransactionID->result() as $row) {
			  	$show['btdetail'][] = array(
			  			'BankTransactionDate' => $row->BankTransactionDate, 
						'BankTransactionAmount' => $row->BankTransactionAmount,
						'BankTransactionBalance' => $row->BankTransactionBalance
					);
				
			};
		}
	}
	function transaction_setasdesposit()
	{
		$data 	= $this->input->get_post('data');
		$sql 	= "UPDATE tb_bank_transaction set IsDeposit = 1 WHERE BankTransactionID in (". implode(',', $data) .")";
		$query 	= $this->db->query($sql);
	}
	function confirmation_deposit()
	{
		$sql = "SELECT tbm.*, bm.*, cm.ContactID, c.fullname FROM tb_bank_transaction tbm ";
		$sql .= "LEFT JOIN tb_bank_main bm ON bm.BankID = tbm.BankID ";
		$sql .= "LEFT JOIN tb_customer_main cm ON tbm.DepositCustomer = cm.CustomerID ";
		$sql .= "LEFT JOIN vw_contact2 c ON cm.ContactID = c.ContactID ";
		if (isset($_REQUEST['filterstart']) && $_REQUEST['filterstart'] != "" && $_REQUEST['filterend'] != "" ) {
			$sql .= "where BankTransactionDate between '".$_REQUEST['filterstart']." 00:00:00' and '".$_REQUEST['filterend']." 23:59:59' and IsDeposit=1";
		} else {
			$sql .= "WHERE MONTH(BankTransactionDate) = MONTH(CURRENT_DATE()) AND YEAR(BankTransactionDate) = YEAR(CURRENT_DATE()) and IsDeposit=1";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show   = array();
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'BankTransactionID' => $row->BankTransactionID,
		  			'BankName' => $row->BankName,
		  			'BankTransactionDate' => $row->BankTransactionDate,
					'BankTransactionNote' => $row->BankTransactionNote,
		  			'BankTransactionAmount' => $row->BankTransactionAmount,
		  			'BankTransactionBalance' => $row->BankTransactionBalance,
		  			'fullname' => $row->fullname
				);
		};
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
	    return $show;
	}
	function confirmation_deposit_distribution_act()
	{
		// print_r($this->input->post());
		$id 			= $this->input->post('id');
		$date 			= $this->input->post('date');
		$amount 		= $this->input->post('amount');
		$getcustomer 	= $this->input->post('getcustomer');
		$distribution 	= $this->input->post('distribution');
		$distributionamount = $this->input->post('distributionamount');
		$datetimenow	= date("Y-m-d H:i:s");

		$bank_update = array(
			'DepositDate' => $datetimenow,
			'DepositCustomer' => $getcustomer,
		);
		$this->db->where('BankTransactionID', $id);
		$this->db->update('tb_bank_transaction', $bank_update);

		$sql_free 	= "SELECT * FROM tb_customer_deposit WHERE CustomerID = ".$getcustomer." AND DepositType = 'free'";
		$getrow	= $this->db->query($sql_free);
		$row 	= $getrow->row();
		if (empty($row)) {
			$data_customer_deposit_free = array(
		        'CustomerID' => $getcustomer,
		        'DepositAmount' => 0,
		        'DepositType' => "free",
		        'SourceDate' => "2000-01-01"
			);
			$this->db->insert('tb_customer_deposit', $data_customer_deposit_free);
		}

		for ($i=0; $i < count($distribution);$i++) { 
			if ($distribution[$i] == "free") {
				$getrow2= $this->db->query($sql_free);
				$row2 	= $getrow2->row();
				$amounttotal = $row2->DepositAmount + $distributionamount[$i];
				if ($row2->SourceDate > $date) {
				 	$date = $row2->SourceDate;
				 } 

				$data_customer_deposit_free = array(
			        'DepositAmount' => $amounttotal,
		        	'SourceType' => "BT ".$id,
		        	'SourceDate' => $date,
			        'InsertDate' => $datetimenow,
					'InsertBy' => $this->session->userdata('UserAccountID')
				);
				$this->db->where('CustomerID', $getcustomer);
				$this->db->where('DepositType', "free");
				$this->db->update('tb_customer_deposit', $data_customer_deposit_free);
			}

			$data_customer_deposit_log = array(
		        'CustomerID' => $getcustomer,
		        'DepositAmount' => $distributionamount[$i],
		        'DepositType' => $distribution[$i],
		        'SourceAmount' => $amount,
		        'SourceType' => "BT ".$id,
				'InsertBy' => $this->session->userdata('UserAccountID'),
		        'InsertDate' => $datetimenow
			);
			$this->db->insert('tb_customer_deposit_log', $data_customer_deposit_log);
   		};
	}
//================================================================================================
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
		echo json_encode($show);
	}
	function get_customer_free()
	{
		$id 	= $this->input->get_post('id');
		$sql 	= "SELECT * FROM tb_customer_deposit where CustomerID = '".$id."' and DepositType = 'free'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {	
			echo json_encode($row->DepositAmount);
		} else { 
			echo json_encode("0.00");
		}
	}

}
?>