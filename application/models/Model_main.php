<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_main extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
    }
    
// user=====================================================================
	function change_password()
	{
		$id  = $this->input->get('id'); 
		$old = $this->input->get('old'); 
		$new = $this->input->get('new'); 
		$old = md5($old).sha1($old);
		$new = md5($new).sha1($new);
		$result = "";

		$sql 	= "SELECT * from tb_user_account where UserAccountID = '".$id."' and Password = '".$old."'"; //query cek jika password lama cocok
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			$data = array(
				'Password'=> $new,
			);
			$this->db->where('UserAccountID', $id);
			$this->db->update('tb_user_account', $data);
			$result = "SUKSES Ganti password berhasil ..., akan logout dalam 3 detik!";
		} else {
			$result = "GAGAL Password lama tidak cocok!";
		}
		echo json_encode($result);
	}
	function cek_approval_update_customer_category()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'customer_category'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		}
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_customer_category where ".$key." is null and isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_so()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'approve_so'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_so where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_stock_adjustment()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'stock_adjustment'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_stock_adjustment where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_mutation_product()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'mutation_product'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_mutation_product where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_dor_invr()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'dor_invr'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_dor_invr where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_price_list()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'product_price_list'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_price_list where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approve_price_recommendation()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'price_recommendation'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_price_recommendation where isComplete = '0'";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_promo_volume()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'product_promo_volume'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_promo_volume where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_po()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'purchase_order'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_po where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_po_expired()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'purchase_order_expired'";
		$query 	= $this->db->query($sql);	
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_approval_po_expired where isComplete = '0'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_approval_marketing_activity()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();
		$status = 0;

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'marketing_activity'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 

		$cek_non_id = $this->cek_actor_non_id($actor);
		// echo $cek_non_id['status'];
		$status += $cek_non_id['status'];
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$status += 1;
		}
		if ($status > 0) {
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * FROM tb_approval_marketing_activity a
						LEFT JOIN tb_marketing_activity ma ON a.ActivityID=ma.ActivityID
						where isComplete = '0' ";
			$sql 	.= $cek_non_id['sql'];
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->ApprovalID;
			};
		}
		return count($show);
	}
	function cek_update_price_list()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$MenuList = $this->session->userdata('MenuList');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_notification_actor WHERE ApprovalCode = 'update_price_list'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3,
			);
		}
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_update_price_list tup
						LEFT JOIN tb_notification_update_price_list tau ON tau.ActivityID= tup.ActivityID
						 ";
			if (in_array("update_price_list_recommendation", $MenuList)) {
				$sql .= "WHERE tup.From = 'Recommendation' AND tau.Actor2ID is null";
			} else {
				$sql .="WHERE tup.isComplete = '0' ";
			}
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
				$show[] = $row->ActivityID;
			};
		}
		return count($show);
	}
	function cek_notif_price()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');
		$show = array();

		$sql 	= "SELECT * FROM tb_notif_action tna
				LEFT JOIN tb_notif_note tnn ON tna.NoteID=tnn.NoteID where tna.NotifDateAction=0 AND tnn.NotifID=3 AND tna.NotifUserAccountID=".$UserAccountID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = $row->NoteID;
		};
		return count($show);
	}
	function cek_update_stock()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');
		$show = array();

		$sql 	= "SELECT * FROM tb_notif_action tna
				LEFT JOIN tb_notif_note tnn ON tna.NoteID=tnn.NoteID where tna.NotifDateAction=0 AND tnn.NotifID=1 AND tna.NotifUserAccountID=".$UserAccountID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = $row->NoteID;
		};
		return count($show);
	}
	function cek_update_ready_for_sale()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');
		$show = array();

		$sql 	= "SELECT * FROM tb_notif_action tna
				LEFT JOIN tb_notif_note tnn ON tna.NoteID=tnn.NoteID where tna.NotifDateAction=0 AND tnn.NotifID=2 AND tna.NotifUserAccountID=".$UserAccountID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = $row->NoteID;
		};
		return count($show);
	}
	function cek_notif_minmax()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');
		$show = array();

		$sql 	= "SELECT * FROM tb_notif_action tna
				LEFT JOIN tb_notif_note tnn ON tna.NoteID=tnn.NoteID
				where tna.NotifDateAction=0 AND tnn.NotifID=4 AND tna.NotifUserAccountID=".$UserAccountID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = $row->NoteID;
		};
		return count($show);
	}
	function cek_notif_sop()
	{
		$EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();
		$UserAccountID = $this->session->userdata('UserAccountID');
		$MenuList = $this->session->userdata('MenuList');
		$show = array();

		$sql 	= "SELECT * FROM tb_notif_action tna
				LEFT JOIN tb_notif_note tnn ON tna.NoteID=tnn.NoteID
				LEFT JOIN vw_user_account vua on vua.EmployeeID=tna.NotifUserAccountID
				where tna.NotifDateAction=0 AND tnn.NotifID=5 AND vua.UserAccountID=".$UserAccountID;
		$query 	= $this->db->query($sql);
		foreach ($query->result() as $row) {
			$show[] = $row->NoteID;
		};
		return count($show);
	}
	function cek_update_mp()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_notification_actor where ApprovalCode = 'update_mp'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1,
				'Actor2' => $row->Actor2,
				'Actor3' => $row->Actor3,
				'Actor4' => $row->Actor4,
				'Actor5' => $row->Actor5,
				'Actor6' => $row->Actor6,
				'Actor7' => $row->Actor7,
				'Actor8' => $row->Actor8,
			); 
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_update_link where isComplete = '0'";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$show[] = $row->ActivityID;
			};
		}
		return count($show);
	}
	function cek_online_order()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
		$show = array();
		$actor = array();

		$sql 	= "SELECT * FROM tb_approval_actor where ApprovalCode = 'online_order'";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		if (!empty($row)) {
			$actor = array(
				'Actor1' => $row->Actor1, 
				'Actor2' => $row->Actor2, 
				'Actor3' => $row->Actor3 
			);
		} 
		if (in_array($EmployeeID, $actor)) { //jika user termasuk dari actor approval
			$key 	= array_search($EmployeeID, $actor);
			$sql 	= "SELECT * from tb_online_order where Status = '0'";
			$query 	= $this->db->query($sql);
			foreach ($query->result() as $row) {
				$show[] = $row->OLOID;
			};
		}
		return count($show);
	}

	// cek based not ID
	function cek_actor_non_id($actor)
	{
		$result['status'] = 0 ;
		$result['sql'] = "";

		if (in_array('SEC', $actor)) {
			$SalesID = array( $this->session->userdata('SalesID') );

			$this->load->model('model_report');
			$SalesChild = $this->model_report->get_sales_child($SalesID);
			if (count($SalesChild) > 1) {
				$result['status'] = 1 ;
				$result['sql'] = "and ( SalesID in (" . implode(',', array_map('intval', $SalesChild)) . "))";
			}
		}
		return $result; 
	}

// DD ----------------------------------------------------------------------
	function cek_setDD1()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
	    $MenuList = $this->session->userdata('MenuList');
		$show = array();
		$actor = array();

	    if ($this->auth->cek5('sales_order_due_date_user1')) {
			$sql 	= "SELECT sm2.SOID from tb_so_main2 sm2
						left join tb_so_main sm on sm2.SOID=sm.SOID 
						where SOShipDate1Need=1 and ( SOShipDate1 is NULL or SOShipDate1='0000-00-00') 
						and sm.SOStatus <>0";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->SOID;
			};
		}
		return count($show);
	}
	function cek_setDD2()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
	    $MenuList = $this->session->userdata('MenuList');
		$show = array();
		$actor = array();

	    if ($this->auth->cek5('sales_order_due_date_user2')) {
			$sql 	= "SELECT sm2.SOID from tb_so_main2 sm2
						left join tb_so_main sm on sm2.SOID=sm.SOID 
						where SOShipDate2Need=1 and ( SOShipDate2 is NULL or SOShipDate2='0000-00-00') 
						and sm.SOStatus <>0";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->SOID;
			};
		}
		return count($show);
	}
	function cek_setDD3()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
	    $MenuList = $this->session->userdata('MenuList');
		$show = array();
		$actor = array();

	    if ($this->auth->cek5('sales_order_due_date_user3')) {
			$sql 	= "SELECT sm2.SOID from tb_so_main2 sm2
						left join tb_so_main sm on sm2.SOID=sm.SOID 
						where SOShipDate3Need=1 and ( SOShipDate3 is NULL or SOShipDate3='0000-00-00') 
						and sm.SOStatus <>0";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->SOID;
			};
		}
		return count($show);
	}
	function cek_setDDFinal()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
	    $MenuList = $this->session->userdata('MenuList');
		$show = array();
		$actor = array();

	    if ($this->auth->cek5('sales_order_due_date_final')) { 
			$sql 	= "SELECT * from tb_so_main2 where SOID IN (SELECT SOID FROM tb_so_main WHERE SOStatus<>0) AND SOShipDateFinal is NULL or SOShipDateFinal='0000-00-00'";
			$query 	= $this->db->query($sql);	
			foreach ($query->result() as $row) {
			  	$show[] = $row->SOID;
			};
		}
		return count($show);
	}

// shop --------------------------------------------------------------------
	function cek_updateShopProduct()
	{
	    $EmployeeID = $this->session->userdata('EmployeeID');
	    $SalesID = $this->session->userdata('SalesID');
	    $MenuList = $this->session->userdata('MenuList');
		$show = array();
		$actor = array();

	    if ($this->auth->cek5('shop_update_link')) { 
			$sql 	= "SELECT ProductID FROM tb_shop_product p
						WHERE (p.LinkText='' or p.LinkText is null) AND ShopID IN (
						SELECT s.ShopID FROM tb_shop_main s WHERE s.SalesID=".$SalesID.")";
			$query 	= $this->db->query($sql);	
			$show = $query->result_array();
		}
		return count($show);
	}

// summary -----------------------------------------------------------------
	function cek_report_summary()
	{
		$show   = array();
        $this->load->model('model_report');
        $this->load->model('model_transaction');
	    
        if ($this->auth->cek5('summary_so_outstanding_do')) {
		    $query 	= $this->model_report->query_report_so_outstanding_do();
			$getrow	= $this->db->query($query);
			$rowmain= $getrow->row();
			$show['SO_Outstanding_DO'] = get_object_vars($rowmain);
		}

        if ($this->auth->cek5('summary_do_not_inv')) {
		    $query 	= $this->model_report->query_report_do_not_inv();
			$getrow	= $this->db->query($query);
			$rowmain= $getrow->row();
			$show['DO_not_INV'] = get_object_vars($rowmain);
		}

        if ($this->auth->cek5('summary_inv_unpaid')) {
		    $query 	= $this->model_report->query_invoice_unpaid();
			$getrow	= $this->db->query($query);
			$rowmain= $getrow->row();
			$show['INV_unpaid'] = get_object_vars($rowmain);
		}

        if ($this->auth->cek5('summary_ro_outstanding')) {
		    $query 	= $this->model_transaction->query_request_to_purchase();
			$getrow	= $this->db->query($query);
			$rowmain= $getrow->row();
			$show['RO_Outstanding'] = get_object_vars($rowmain);
		}

        if ($this->auth->cek5('summary_po_outstanding')) {
		    $query 	= $this->model_report->query_report_po_outstanding_dor();
			$getrow	= $this->db->query($query);
			$rowmain= $getrow->row();
			$show['PO_Outstanding'] = get_object_vars($rowmain);
		}

		return ($show);
	}
	function summary_so_outstanding_do()
	{
        $this->load->model('model_report');
        $this->load->model('model_transaction');
	    $query 	= $this->model_report->query_report_so_outstanding_do();
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		echo json_encode(get_object_vars($rowmain));
	}
	function summary_do_not_inv()
	{
        $this->load->model('model_report');
        $this->load->model('model_transaction');
	    $query 	= $this->model_report->query_report_do_not_inv();
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		echo json_encode(get_object_vars($rowmain));
	}
	function summary_inv_unpaid()
	{
        $this->load->model('model_report');
        $this->load->model('model_transaction');
	    $query 	= $this->model_report->query_invoice_unpaid();
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		echo json_encode(get_object_vars($rowmain));
	}
	function summary_ro_outstanding()
	{
        $this->load->model('model_report');
        $this->load->model('model_transaction');
	    $query 	= $this->model_transaction->query_request_to_purchase();
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		echo json_encode(get_object_vars($rowmain));
	}
	function summary_po_outstanding()
	{
        $this->load->model('model_report');
        $this->load->model('model_transaction');
	    $query 	= $this->model_report->query_report_po_outstanding_dor();
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		echo json_encode(get_object_vars($rowmain));
	}
	function summary_ro_suggestion()
	{
	    $query 	= 'SELECT COUNT(ProductID) AS CountProduct FROM vw_stock_product_full_active2 WHERE rosugestion>0';
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		$result['CountProduct'] = $rowmain->CountProduct;
		
	    $query 	= 'SELECT COUNT(ProductID) AS CountProduct FROM vw_stock_product_full_active2 WHERE minrosugestion>0';
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		$result['CountProductUnderMin'] = $rowmain->CountProduct;
		echo json_encode($result);
	}
	function summary_so_warehouse()
	{
		$query 	= "SELECT COUNT(t1.SOID) AS CountPutat
				FROM (
					SELECT tsd.SOID, tsd.ProductQty, (tsd.ProductQty - tsd.Pending) AS totaldo 
					FROM tb_so_detail tsd
					LEFT JOIN tb_so_main tsm ON tsm.SOID=tsd.SOID
					LEFT JOIN vw_product_shop vps ON vps.ProductID=tsd.ProductID
					LEFT JOIN tb_product_stock_main tpsm ON tpsm.ProductID =tsd.ProductID
					WHERE SOStatus = 1 and SOConfirm1 = 1 and SOConfirm2 = 1 and vps.Gudang like 'Putat' and Quantity>0
					GROUP BY tsd.SOID
					HAVING totaldo < ProductQty
				) t1";
		$getrow	= $this->db->query($query);
		$rowmain2= $getrow->row();
		$result['CountPutat'] = $rowmain2->CountPutat;

	    $query 	= "SELECT COUNT(t1.SOID) AS CountMargo
				FROM (
					SELECT tsd.SOID, tsd.ProductQty, (tsd.ProductQty - tsd.Pending) AS totaldo 
					FROM tb_so_detail tsd
					LEFT JOIN tb_so_main tsm ON tsm.SOID=tsd.SOID
					LEFT JOIN vw_product_shop vps ON vps.ProductID=tsd.ProductID
					LEFT JOIN tb_product_stock_main tpsm ON tpsm.ProductID =tsd.ProductID
					WHERE SOStatus = 1 and SOConfirm1 = 1 and SOConfirm2 = 1 and vps.Gudang like '%margomulyo%' and Quantity>0
					GROUP BY tsd.SOID
					HAVING totaldo < ProductQty
				) t1";
		$getrow	= $this->db->query($query);
		$rowmain3= $getrow->row();
		$result['CountMargo'] = $rowmain3->CountMargo;

		$this->load->model('model_report');
        $this->load->model('model_transaction');
	    $query 	= $this->model_report->query_report_so_outstanding_do();
		$getrow	= $this->db->query($query);
		$rowmain= $getrow->row();
		$result['CountSO'] = $rowmain->CountSO-$rowmain2->CountPutat-$rowmain3->CountMargo;

		// $result['CountSO'] = ($rowmain->CountSO-$rowmain->CountPutat-$rowmain->CountMargo);

		echo json_encode($result);
	}

// main---------------------------------------------------------------------
	function birthday()
	{	
		$show = array();
		$sql = "SELECT fullname, LevelName, BirthDate from vw_employee1 where ResignDate is null AND MONTH(BirthDate)=".date('m')." order by DAY(BirthDate)";
		// echo $sql;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row) {
		  	$show[] = array(
		  			'fullname' => $row->fullname,
					'LevelName' => $row->LevelName,
					'BirthDate' => $row->BirthDate
				);
		};
	    return $show;
		$this->log_user->log_query($this->last_query);
	}
	function ForceLogOut_cek()
	{
		$UserAccountID	= $this->session->userdata('UserAccountID');
		$sql = "SELECT ForceLogOut from tb_user_account where UserAccountID=".$UserAccountID;
		// echo $sql;
		$query = $this->db->query($sql);
		$row = $query->row();
		$ForceLogOut = $row->ForceLogOut;
		
		if ($ForceLogOut == 1) {
			$this->db->set('ForceLogOut', 0);
			$this->db->where('UserAccountID', $UserAccountID);
			$this->db->update('tb_user_account');
		}
	    return $ForceLogOut;
	}


// ---------------------------------------------------------------------------------------------------
	function stillAlive()
	{
		$url 	= $this->input->get_post('url');
		$id 	= $this->session->userdata('UserAccountID');
		$CurrentTime = date("Y-m-d H:i:s");
		$sql 	= "INSERT INTO tb_user_active (UserAccountID, CurrentTime) VALUES('".$id."', '".$CurrentTime."') ON DUPLICATE KEY UPDATE UserAccountID = '".$id."', CurrentTime = '".$CurrentTime."'";
		$query 	= $this->db->query($sql);
	}
	function checkAlive()
	{
		$sql 	= "DELETE FROM tb_user_active WHERE CurrentTime < (NOW() - INTERVAL 30 MINUTE)";
		$query 	= $this->db->query($sql);
	}
	function userlive()
	{
		$sql 	= "SELECT GROUP_CONCAT(fullname SEPARATOR ', ') as fullname FROM vw_user_active order by CurrentTime";
		$query 	= $this->db->query($sql);
		$row 	= $query->row();
		echo json_encode($row->fullname);
	}

// ---------------------------------------------------------------------------------------------------
	function tes()
	{
		$DODate = '2019-12-09';
		$ShippingDays = 7;
		// return date('Y-m-d', strtotime($DODate. ' + '.$ShippingDays.' days'));
	}
	function get_full_category_child_id($parent, $category_tree_array = array())
	{
		$sql 	= "SELECT ProductCategoryID from tb_product_category where ProductCategoryParent = ".$parent." ORDER by ProductCategoryID";
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
}
?>