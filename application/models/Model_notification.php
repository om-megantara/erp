<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_notification extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->last_query = "";
		$ReportResult = $this->session->userdata('ReportResult');
		$this->limit_result = isset($ReportResult) ? $ReportResult : 100;
	}
	function update_price_list()
	{
		$MenuList = $this->session->userdata('MenuList');
		$sql 	= "SELECT * FROM tb_notification_actor where ApprovalCode = 'update_price_list'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);

		$sql = "SELECT tup.*, aup.*, tpm.ProductName, tpm.ProductPriceDefault FROM tb_update_price_list tup
		LEFT JOIN tb_notification_update_price_list aup ON aup.ActivityID=tup.ActivityID
		LEFT JOIN tb_product_main tpm ON tpm.ProductID=tup.ProductID  ";

		if (in_array("update_price_list_recommendation", $MenuList)) {
			$sql .= "WHERE Actor2ID is Null AND tup.From = 'Recommendation' ORDER by tup.Date ASC";
		} else {
			$sql .="WHERE tup.isComplete=0 ORDER by tup.Date ASC";
		}
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
		return $show;
	}
	function update_price_list_act($val)
	{
		$this->db->trans_start();

		$UserAccountID = $this->session->userdata('UserAccountID');
		$ActivityID = $this->input->post('ActivityID');
		$user	= $this->input->post('user');

		$sql	= "SELECT * FROM tb_notification_update_price_list WHERE ActivityID = '".$ActivityID."'";
		// echo $sql;
		$query	= $this->db->query($sql);
		$row	= $query->row();

		$Approval1	= $row->Actor1;
		$Approval2	= $row->Actor2;
		$Approval3	= $row->Actor3;

		
		if ($val == "approve") {
			switch ($user) {
				case 'Actor1':
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $UserAccountID;
					break;
				case 'Actor2':
					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $UserAccountID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $UserAccountID;
					break;
				case 'Actor3':

					if ($Approval1 == "") {
						$data['Actor1'] = date("Y-m-d H:i:s");
						$data['Actor1ID'] = $UserAccountID;
					}
					$data[$user] = date("Y-m-d H:i:s");
					$data[$user.'ID'] = $UserAccountID;
					$data['isComplete'] = "1";
					$data['Status'] = "Approved";

					$this->db->set('isComplete', '1');
					$this->db->set('Status', 'Approved');
					$this->db->where('ActivityID', $ActivityID);
					$this->db->update('tb_update_price_list');
					$this->last_query .= "//".$this->db->last_query();
					break;
			}
					
			if (!empty($data)){
				$this->db->where('ActivityID',$ActivityID);
				$this->db->update('tb_notification_update_price_list',$data);
				$this->last_query .= "//".$this->db->last_query();
			}

		}
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function update_stock()
	{
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');

		$sql = "SELECT *, COALESCE ( ppo.pending, 0 ) AS popending, vpm.ProductAtributeValueName as ProductManager 
		FROM tb_notif_note tnn
		LEFT JOIN tb_notif_action tna ON tnn.NoteID=tna.NoteID
		LEFT JOIN tb_product_main tpm ON tpm.ProductID=tnn.NoteReff
		LEFT JOIN vw_product_stock vps ON tpm.ProductID=vps.ProductID
		LEFT JOIN vw_stock_pending_po2 ppo ON ppo.ProductID=tpm.ProductID
		LEFT JOIN vw_product_manager vpm ON vpm.ProductID=tpm.ProductID
		LEFT JOIN vw_product_origin vpo ON vpo.ProductID=tpm.ProductID
		WHERE tna.NotifDateAction=0 AND tnn.NotifID=1 ";
		if(in_array("notif_price_all", $MenuList)){
			$sql .=" GROUP BY tnn.NoteID ";
		} else {
			$sql .=" AND tna.NotifUserAccountID=".$UserAccountID;
		}
		if (isset($_REQUEST['productid']) && $_REQUEST['productid'] != '') {
			$sql .= "AND tpm.ProductID like '".$_REQUEST['productid']."' ";
		} else if (isset($_REQUEST['productname']) && $_REQUEST['productname'] != '') {
			$sql .= "AND tpm.ProductName like '%".$_REQUEST['productname']."%' ";
		} else { $sql .= ""; }
		if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') {
			$sql .= "AND vpo.AtributeValue like '".$_REQUEST['source']."' ";
		} else {$sql .="";}
		$sql .= " order by tnn.NoteID asc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();

		$sql4 = "SELECT * FROM tb_product_atribute_value WHERE ProductAtributeID=20 ORDER BY ProductAtributeValueCode ASC ";
		$query4 = $this->db->query($sql4);
		foreach ($query4->result() as $row4) {
			$show['agent'][] = array(
				'ProductAtributeValueName' => $row4->ProductAtributeValueName,
				'ProductAtributeValueCode' => $row4->ProductAtributeValueCode,
			);
		};
		return $show;
	}
	function update_stock_act($val)
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$NoteID = $this->input->post('NoteID');
		if ($val == "approve") {
			$this->db->set('NotifDateAction', date("Y-m-d H:i:s"));
			$this->db->where('NoteID', $NoteID);
			$this->db->where('NotifUserAccountID', $UserAccountID);
			$this->db->update('tb_notif_action');
			$this->last_query .= "//".$this->db->last_query();

		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function notif_price()
	{
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');

		$sql = "SELECT * FROM tb_notif_note tnn
		LEFT JOIN tb_notif_action tna ON tnn.NoteID=tna.NoteID
		LEFT JOIN tb_product_main tpm ON tpm.ProductID=tnn.NoteReff
		LEFT JOIN vw_product_stock vps ON tpm.ProductID=vps.ProductID
		WHERE tna.NotifDateAction=0 AND tnn.NotifID=3 ";
		if(in_array("notif_price_all", $MenuList)){
			$sql .=" GROUP BY tnn.NoteID ";
		} else {
			$sql .=" AND tna.NotifUserAccountID=".$UserAccountID;
		}
		$sql .= " order by tnn.NoteID asc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();

		return $show;
	}
	function notif_price_act($val)
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$NoteID = $this->input->post('NoteID');
		if ($val == "approve") {
			$this->db->set('NotifDateAction', date("Y-m-d H:i:s"));
			$this->db->where('NoteID', $NoteID);
			$this->db->where('NotifUserAccountID', $UserAccountID);
			$this->db->update('tb_notif_action');
			$this->last_query .= "//".$this->db->last_query();

		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function update_ready_for_sale()
	{
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');

		$sql = "SELECT * FROM tb_notif_note tnn
		LEFT JOIN tb_notif_action tna ON tnn.NoteID=tna.NoteID
		LEFT JOIN tb_product_main tpm ON tpm.ProductID=tnn.NoteReff
		LEFT JOIN vw_product_stock vps ON tpm.ProductID=vps.ProductID
		WHERE tna.NotifDateAction=0 AND tnn.NotifID=2 ";
		if(in_array("update_ready_for_sale_all", $MenuList)){
			$sql .=" GROUP BY tnn.NoteID ";
		} else {
			$sql .=" AND tna.NotifUserAccountID=".$UserAccountID;
		}
		$sql .= " order by tnn.NoteID asc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();

		return $show;
	}
	function update_ready_for_sale_act($val)
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$NoteID = $this->input->post('NoteID');
		if ($val == "approve") {
			$this->db->set('NotifDateAction', date("Y-m-d H:i:s"));
			$this->db->where('NoteID', $NoteID);
			$this->db->where('NotifUserAccountID', $UserAccountID);
			$this->db->update('tb_notif_action');
			$this->last_query .= "//".$this->db->last_query();

		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function notif_minmax()
	{
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');

		$sql = "SELECT tnn.*, tpm.ProductName, tpm.MinStock, tpm.MaxStock, vps.stock, (MaxStock-stock) AS ROS, COALESCE ( ppo.pending, 0 ) AS popending , vpo.ProductAtributeValueName AS SourceAgent FROM tb_notif_note tnn
		LEFT JOIN tb_notif_action tna ON tnn.NoteID=tna.NoteID
		LEFT JOIN tb_product_main tpm ON tpm.ProductID=tnn.NoteReff
		LEFT JOIN vw_product_stock vps ON tpm.ProductID=vps.ProductID
		LEFT JOIN vw_stock_pending_po2 ppo ON ppo.ProductID=tpm.ProductID
		LEFT JOIN vw_product_origin vpo ON vpo.ProductID=tpm.ProductID
		WHERE tna.NotifDateAction=0 AND tnn.NotifID=4 ";
		if(in_array("notif_minmax_all", $MenuList)){
			$sql .=" GROUP BY tnn.NoteID ";
		} else {
			$sql .=" AND tna.NotifUserAccountID='".$UserAccountID."' GROUP BY NoteID";
		}
		$sql .= " order by tnn.NoteID asc";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();

		return $show;
	}
	function notif_minmax_act($val)
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$NoteID = $this->input->post('NoteID');
		if ($val == "approve") {
			$this->db->set('NotifDateAction', date("Y-m-d H:i:s"));
			$this->db->where('NoteID', $NoteID);
			$this->db->where('NotifUserAccountID', $UserAccountID);
			$this->db->update('tb_notif_action');
			$this->last_query .= "//".$this->db->last_query();

		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function notif_sop()
	{
		$MenuList = $this->session->userdata('MenuList');
		$UserAccountID = $this->session->userdata('UserAccountID');

		$sql = "SELECT tnn.*,sop.SopCode,sop.Subject,sop.FilePDF,sop.Link,vua.EmployeeID
			FROM tb_notif_note tnn
			LEFT JOIN tb_notif_action tna ON tnn.NoteID=tna.NoteID
			LEFT JOIN tb_sop sop ON sop.SopID=tnn.NoteReff
			LEFT JOIN vw_user_account vua on vua.EmployeeID=tna.NotifUserAccountID
			WHERE tna.NotifDateAction=0 AND tnn.NotifID=5 ";
			if(in_array("notif_minmax_all", $MenuList)){
				$sql .=" GROUP BY tnn.NoteID ";
			} else {
				$sql .=" AND vua.UserAccountID='".$UserAccountID."' GROUP BY NoteID";
			}
		$sql .= " order by tnn.NoteID asc";
		 // echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();

		return $show;
	}
	function notif_sop_act($val)
	{
		$this->db->trans_start();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$sql="SELECT EmployeeID FROM vw_user_account";
		$query	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$EmployeeID=$row->EmployeeID;
		}
		$UserAccountID=$EmployeeID;
		$NoteID = $this->input->post('NoteID');
		if ($val == "approve") {
			$this->db->set('NotifDateAction', date("Y-m-d H:i:s"));
			$this->db->where('NoteID', $NoteID);
			$this->db->where('NotifUserAccountID', $UserAccountID);
			$this->db->update('tb_notif_action');
			$this->last_query .= "//".$this->db->last_query();

		}
		// echo $this->last_query;
		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}
	function update_mp()
	{
		$sql 	= "select * FROM tb_approval_actor where ApprovalCode = 'update_mp'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$show['actor'] = array(
			'Actor1' => $row->Actor1,
			'Actor2' => $row->Actor2,
			'Actor3' => $row->Actor3
		);

		$sql = "SELECT tul.*, tpm.ProductName, tsp.LinkText, tsm.ShopName FROM tb_update_link tul
		LEFT JOIN tb_product_main tpm ON tpm.ProductID=tul.ProductID
		LEFT JOIN tb_shop_product tsp ON tsp.OrderID=tul.OrderID
		LEFT JOIN tb_shop_main tsm ON tsm.ShopID=tsp.ShopID  WHERE isComplete=0 ORDER BY ProductID";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$show['list'] 	= $query->result_array();
		return $show;
	}
	function update_mp_act($val)
	{
		$this->db->trans_start();

		$ActivityID = $this->input->post('ActivityID');
		if ($val == "approve") {
			$this->db->set('isComplete', '1');
			$this->db->set('Status', 'Approved');
			$this->db->where('ActivityID', $ActivityID);
			$this->db->update('tb_update_link');
			$this->last_query .= "//".$this->db->last_query();

		}

		$this->log_user->log_query($this->last_query);
		$this->db->trans_complete();
		// return $this->db->trans_status();
	}

// ===================================================================
	function insert_notif($NotifName, $NoteDetail, $NoteType, $NoteReff, $NotifUserType= 'add', $NotifUserList = array(0))
	{
		$this->db->trans_start();
		$NotifUserAccountID=array();
		//select notif name
		$sql = "SELECT NotifID, NotifName FROM tb_notif_main WHERE NotifName='".$NotifName."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$NotifID = $row->NotifID;

		$sql3 = "SELECT NotifUserAccountID
				FROM tb_notif_user WHERE NotifID=".$NotifID;
		$query3 	= $this->db->query($sql3);
		foreach ($query3->result() as $row3) {
			$NotifUserAccountID[]=$row3->NotifUserAccountID;
		}
		if($NotifUserType == 'add'){
			$NotifUserAccountID = array_merge($NotifUserAccountID, $NotifUserList);
		} else {
			$NotifUserAccountID = array_merge($NotifUserList);
		}

		for ($i=0; $i < count($NoteReff);$i++) {
			$data_note = array(
				'NotifID' => $NotifID,
				'NoteDate' => date("Y-m-d H:i:s"),
				'NoteDetail' => $NoteDetail,
				'NoteType' => $NoteType,
				'NoteReff' => $NoteReff[$i],
			);
			$this->db->insert('tb_notif_note', $data_note);
			$this->last_query .= "//".$this->db->last_query();

			$sql2 = "SELECT MAX(NoteID) AS NoteID
				FROM tb_notif_note ";
			$query2	= $this->db->query($sql2);
			$row2 	= $query2->row();
			$NoteID = $row2->NoteID;

			foreach ($NotifUserAccountID as $key => $value) {
				if($value!=0){
					$data_notif = array(
						'NoteID' => $NoteID,
						'NotifID' => $NotifID,
						'NotifUserAccountID' => $value,
						'NotifDateAction' => '0',
					);
					$this->db->insert('tb_notif_action', $data_notif);
					$this->last_query .= "//".$this->db->last_query();
				}
			}
		}
		// echo $this->last_query;
		$this->delete_notif($NotifID);
		$this->db->trans_complete();
	}
	function delete_notif($NotifID)
	{
		$this->db->trans_start();
		$sql = "UPDATE tb_notif_action
				SET NotifDateAction=1
				WHERE NoteID NOT IN (
					SELECT NoteID
					FROM (
						SELECT MAX(tnn.NoteID) AS NoteID
						FROM tb_notif_note tnn
						LEFT JOIN tb_notif_action tna ON tna.NoteID=tnn.NoteID
						WHERE tna.NotifDateAction=0 AND tna.NotifID=".$NotifID."
						GROUP BY tnn.NoteReff
					) t1
				) AND NotifDateAction=0 AND NotifID=".$NotifID;
		// echo $sql;
		$this->db->query($sql);
		$this->last_query .= "//".$this->db->last_query();
		$this->db->trans_complete();
	}
	function get_actor($EmployeeID, $tb_approval, $ApprovalCode)
	{
		$sql 	= "SELECT * FROM ".$tb_approval." where ApprovalCode ='".$ApprovalCode."'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		// $actor = array(
		// 	'Actor1' => $row->Actor1,
		// 	'Actor2' => $row->Actor2,
		// 	'Actor3' => $row->Actor3
		// );
		// $key = array_search($EmployeeID, $actor);
		$key = "";
		if ($row->Actor1 == $EmployeeID) { $key = 'Actor1';}
		if ($row->Actor2 == $EmployeeID) { $key = 'Actor2';}
		if ($row->Actor3 == $EmployeeID) { $key = 'Actor3';} 
		$this->log_user->log_query($this->last_query);
		return $key;
	}
	function get_actor_notification($EmployeeID, $tb_approval, $ApprovalCode)
	{
		$sql 	= "SELECT * FROM ".$tb_approval." where ApprovalCode ='".$ApprovalCode."'";
		// echo $sql;
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		// $actor = array(
		// 	'Actor1' => $row->Actor1,
		// 	'Actor2' => $row->Actor2,
		// 	'Actor3' => $row->Actor3
		// );
		// $key = array_search($EmployeeID, $actor);
		$key = "";
		if ($row->Actor1 == $EmployeeID) { $key = 'Actor1';}
		if ($row->Actor2 == $EmployeeID) { $key = 'Actor2';}
		if ($row->Actor3 == $EmployeeID) { $key = 'Actor3';}
		if ($row->Actor4 == $EmployeeID) { $key = 'Actor4';}
		if ($row->Actor5 == $EmployeeID) { $key = 'Actor5';}
		if ($row->Actor6 == $EmployeeID) { $key = 'Actor6';}
		if ($row->Actor7 == $EmployeeID) { $key = 'Actor7';}
		if ($row->Actor8 == $EmployeeID) { $key = 'Actor8';}
		if ($row->Actor9 == $EmployeeID) { $key = 'Actor9';}
		$this->log_user->log_query($this->last_query);
		return $key;
	}
	function get_actor_approval($actor, $tb_approval, $ApprovalID)
	{
		$sql 	= "select ".$actor." as actor FROM ".$tb_approval." where ApprovalID ='".$ApprovalID."'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		$this->log_user->log_query($this->last_query);
		return $row->actor;
	}
	function get_percent($num1, $num2)
	{
		$result = 0;
		if ($num2 > 0) {
			if ($num1 > 0) {
				$result = $num2 * ($num1/100);
			} else {
				$result = $num2;
			}
		}
		return $result;
		$this->log_user->log_query($this->last_query);
	}
	function get_min_percent($num1, $num2)
	{
		$result = 0;
		$percent = ($num1/100)*$num2;
		$result = $num1 - $percent;
		return $result;
		$this->log_user->log_query($this->last_query);
	}
	function get_sales_child($SalesID)
	{
		if ($SalesID[0] != 0) {
			$sqlS 	= "SELECT SalesID FROM tb_sales_executive WHERE SalesParent in (" . implode(',', array_map('intval', $SalesID)) . ") AND SalesID not in (" . implode(',', array_map('intval', $SalesID)) . ") ";
			$query 	= $this->db->query($sqlS);
			foreach ($query->result() as $row) {
				array_push($SalesID, $row->SalesID);
				$SalesID2 = $this->get_sales_child( array($row->SalesID) );
				unset($SalesID2[0]);
				if (!empty($SalesID2)) {
					foreach ($SalesID2 as $key => $value) {
						array_push($SalesID, $value);
					}
				}
			};
		}
		return $SalesID;
	}

}
?>