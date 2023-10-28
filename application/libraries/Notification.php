<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notification {

	function notif_all(){
		$notif = array();
		$total = 0;
		
		$approval_update_customer_category = $this->approval_update_customer_category(); 
		if (!empty($approval_update_customer_category)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_update_customer_category;
		}
		
		$approval_so = $this->approval_so(); 
		if (!empty($approval_so)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_so;
		}
		
		$approval_stock_adjustment = $this->approval_stock_adjustment(); 
		if (!empty($approval_stock_adjustment)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_stock_adjustment;
		}

		$approval_mutation_product = $this->approval_mutation_product(); 
		if (!empty($approval_mutation_product)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_mutation_product;
		}

		$approval_dor_invr = $this->approval_dor_invr(); 
		if (!empty($approval_dor_invr)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_dor_invr;
		}

		$approval_price_list = $this->approval_price_list(); 
		if (!empty($approval_price_list)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_price_list;
		}

		$approve_price_recommendation = $this->approve_price_recommendation();
		if (!empty($approve_price_recommendation)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $approve_price_recommendation;
		}
		
		$approval_promo_volume = $this->approval_promo_volume(); 
		if (!empty($approval_promo_volume)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_promo_volume;
		}

		$approval_po = $this->approval_po(); 
		if (!empty($approval_po)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_po;
		}

		$approval_po_expired = $this->approval_po_expired(); 
		if (!empty($approval_po_expired)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_po_expired;
		}

		$approval_marketing_activity = $this->approval_marketing_activity(); 
		if (!empty($approval_marketing_activity)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $approval_marketing_activity;
		}

		$update_price_list = $this->update_price_list(); 
		if (!empty($update_price_list)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $update_price_list;
		}
		$notif_price = $this->notif_price();
		if (!empty($notif_price)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $notif_price;
		}
		$update_stock = $this->update_stock();
		if (!empty($update_stock)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $update_stock;
		}
		$update_ready_for_sale = $this->update_ready_for_sale();
		if (!empty($update_ready_for_sale)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $update_ready_for_sale;
		}
		$notif_minmax = $this->notif_minmax();
		if (!empty($notif_minmax)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $notif_minmax;
		}
		$notif_sop = $this->notif_sop();
		if (!empty($notif_sop)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $notif_sop;
		}
		$update_mp = $this->update_mp();
		if (!empty($update_mp)) { // jika ada yg harus di approve
			$total += 1 ;
			$notif['content'][] = $update_mp;
		}
		// $online_order = $this->online_order(); 
		if (!empty($online_order)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $online_order;
		}

		$setDD1 = $this->setDD1(); 
		if (!empty($setDD1)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $setDD1;
		} 
		$setDD2 = $this->setDD2(); 
		if (!empty($setDD2)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $setDD2;
		} 
		$setDD3 = $this->setDD3(); 
		if (!empty($setDD3)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $setDD3;
		} 
		$setDDFinal = $this->setDDFinal(); 
		if (!empty($setDDFinal)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $setDDFinal;
		} 

		$updateShopProduct = $this->updateShopProduct(); 
		if (!empty($updateShopProduct)) { // jika ada yg harus di approve 
			$total += 1 ;
			$notif['content'][] = $updateShopProduct;
		} 

		if (empty($notif)) {
			$content['text'] = "<i class='fa fa-circle text-green'></i> Tidak ada Notifikasi baru";
			$content['link'] = "#";
			$notif['content'][] = $content;
		}
		$notif['total'] = $total;
		return $notif;
	}

	function approval_update_customer_category(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_update_customer_category();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval upgrade data customer";
			$content['link'] = "approval/upgrade_customer";
		}		
		return $content;
	}
	function approval_so(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_so();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval SO";
			$content['link'] = "approval/approve_so";
		}		
		return $content;
	}
	function approval_stock_adjustment(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_stock_adjustment();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval Stock Adjustment";
			$content['link'] = "approval/approve_stock_adjustment";
		}		
		return $content;
	}
	function approval_mutation_product(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_mutation_product();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval Mutation Product";
			$content['link'] = "approval/approve_mutation_product";
		}		
		return $content;
	}
	function approval_dor_invr(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_dor_invr();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval DOR INVReturn";
			$content['link'] = "approval/approve_dor_invr";
		}		
		return $content;
	}
	function approval_price_list(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_price_list();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval Price List";
			$content['link'] = "approval/approve_price_list";
		}		
		return $content;
	}

	function approve_price_recommendation(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approve_price_recommendation();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Approval Recommendation Price";
			$content['link'] = "approval/approve_price_recommendation";
		}		
		return $content;
	}
	function approval_promo_volume(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_promo_volume();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval Promo Volume";
			$content['link'] = "approval/approve_promo_volume";
		}		
		return $content;
	}
	function approval_po(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_po();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval PO";
			$content['link'] = "approval/approve_po";
		}		
		return $content;
	}
	function approval_po_expired(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_po_expired();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." approval PO Expired";
			$content['link'] = "approval/approve_po_expired";
		}		
		return $content;
	}
	function approval_marketing_activity(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_approval_marketing_activity();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Marketing Activity Approval";
			$content['link'] = "approval/approve_marketing_activity";
		}		
		return $content;
	}
	
	function update_price_list(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_update_price_list();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Price List Update";
			$content['link'] = "notification2/update_price_list";
		}		
		return $content;
	}
	function notif_price(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_notif_price();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Price Updated";
			$content['link'] = "notification2/notif_price";
		}
		return $content;
	}
	function update_stock(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_update_stock();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Stock Update ";
			$content['link'] = "notification2/update_stock";
		}
		return $content;
	}
	function update_ready_for_sale(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_update_ready_for_sale();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Ready For Sale";
			$content['link'] = "notification2/update_ready_for_sale";
		}
		return $content;
	}
	function notif_minmax(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_notif_minmax();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." MIN MAX UPDATED";
			$content['link'] = "notification2/notif_minmax";
		}
		return $content;
	}
	function notif_sop(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_notif_sop();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." SOP Updated";
			$content['link'] = "notification2/notif_sop";
		}
		return $content;
	}
	function update_mp(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_update_mp();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Market Place Update ";
			$content['link'] = "notification2/update_mp";
		}
		return $content;
	}

	function online_order(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_online_order();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Online Order";
			$content['link'] = "marketing/online_order";
		}
		return $content;
	}

	function setDD1()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_setDD1();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." set DueDate 1";
			$content['link'] = "transaction/sales_order_due_date";
		}		
		return $content;
	}
	function setDD2()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_setDD2();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." set DueDate 2";
			$content['link'] = "transaction/sales_order_due_date";
		}		
		return $content;
	}
	function setDD3()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_setDD3();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." set DueDate 3";
			$content['link'] = "transaction/sales_order_due_date";
		}		
		return $content;
	}
	function setDDFinal()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_setDDFinal();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." set DueDate Final";
			$content['link'] = "transaction/sales_order_due_date";
		}
		return $content;
	}


	function updateShopProduct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$total = $this->ci->model_main->cek_updateShopProduct();
		$content = array();
		if ($total >= 1) {
			$content['text'] = "<i class='fa fa-thumbs-up text-yellow'></i> ".$total." Product dalam SHOP yang belum terUpdate";
			$content['link'] = "master/shop_list";
		}
		return $content;
	}
}
?>