<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_master_data extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
    }
    
// customer ==============================================================
    function customer_list()
	{
		$sql 	= "select * from tb_customer_main";
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function customer_add()
	{
		$this->db->trans_start();

		$CustomerID	= $this->input->post('CustomerID');
		$CustomerName	= $this->input->post('CustomerName');
		$CustomerPhone	= $this->input->post('CustomerPhone');
		$CustomerEmail	= $this->input->post('CustomerEmail');
		$CustomerBirthDate	= $this->input->post('CustomerBirthDate');
		$CustomerAddress	= $this->input->post('CustomerAddress'); 

		$data = array(
			'CustomerID' => $CustomerID,
			'CustomerName' => $CustomerName,
			'CustomerPhone' => $CustomerPhone,
			'CustomerEmail' => $CustomerEmail,
			'CustomerBirthDate' => $CustomerBirthDate,
			'CustomerAddress' => $CustomerAddress, 
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_customer_main', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function customer_edit()
	{
		$this->db->trans_start();

		$CustomerID	= $this->input->post('CustomerID');
		$CustomerName	= $this->input->post('CustomerName');
		$CustomerPhone	= $this->input->post('CustomerPhone');
		$CustomerEmail	= $this->input->post('CustomerEmail');
		$CustomerBirthDate	= $this->input->post('CustomerBirthDate');
		$CustomerAddress	= $this->input->post('CustomerAddress'); 

		$data = array(
			'CustomerName' => $CustomerName,
			'CustomerPhone' => $CustomerPhone,
			'CustomerEmail' => $CustomerEmail,
			'CustomerAddress' => $CustomerAddress, 
			'CustomerBirthDate' => $CustomerBirthDate,
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->where('CustomerID', $CustomerID);
		$this->db->update('tb_customer_main', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function get_customer_detail()
	{
		$CustomerID	= $this->input->post('CustomerID'); 
		$sql 	= "select * from tb_customer_main where CustomerID=".$CustomerID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    echo json_encode($show[0]);
	} 
	function search_customer()
	{
		$q = $this->input->get('q');
		if (strlen($q) > 1) {
			$hasil  = $this->db->query ('select * from tb_customer_main where CustomerName like "%'.$q.'%" ');
	        if ($hasil->num_rows()){ 
	        	$data = array();
	            foreach ($hasil->result() as $row) {
	                $data[] = array(
	                    'text' => $row->CustomerName,
	                    'id' => $row->CustomerID
                    ); 
            	}
	            echo json_encode($data);
	        } 
		}      
	}

// treatment ==============================================================
    function treatment_list()
	{
		$sql 	= "select * from tb_treatment_main";
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function treatment_add()
	{
		$this->db->trans_start();

		$TreatmentID	= $this->input->post('TreatmentID');
		$TreatmentName	= $this->input->post('TreatmentName');
		$TreatmentPrice	= $this->input->post('TreatmentPrice');
		$TreatmentNote	= $this->input->post('TreatmentNote'); 

		$data = array(
			'TreatmentID' => $TreatmentID,
			'TreatmentName' => $TreatmentName,
			'TreatmentPrice' => $TreatmentPrice,
			'TreatmentNote' => $TreatmentNote,  
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_treatment_main', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function treatment_edit()
	{
		$this->db->trans_start();

		$TreatmentID	= $this->input->post('TreatmentID');
		$TreatmentName	= $this->input->post('TreatmentName');
		$TreatmentPrice	= $this->input->post('TreatmentPrice');
		$TreatmentNote	= $this->input->post('TreatmentNote');

		$data = array(
			'TreatmentName' => $TreatmentName,
			'TreatmentPrice' => $TreatmentPrice,
			'TreatmentNote' => $TreatmentNote,  
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->where('TreatmentID', $TreatmentID);
		$this->db->update('tb_treatment_main', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function get_treatment_detail()
	{
		$TreatmentID	= $this->input->post('TreatmentID'); 
		$sql 	= "select * from tb_treatment_main where TreatmentID=".$TreatmentID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    echo json_encode($show[0]);
	} 
	function search_treatment()
	{
		$q = $this->input->get('q');
		if (strlen($q) > 1) {
			$hasil  = $this->db->query ('select * from tb_treatment_main where TreatmentName like "%'.$q.'%" ');
	        if ($hasil->num_rows()){ 
	        	$data = array();
	            foreach ($hasil->result() as $row) {
	                $data[] = array(
	                    'text' => $row->TreatmentName,
	                    'id' => $row->TreatmentID
                    ); 
            	}
	            echo json_encode($data);
	        } 
		}      
	}
 
// product ==============================================================
    function product_list()
	{
		$sql 	= "select * from tb_product_main";
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function product_add()
	{
		$this->db->trans_start();

		$ProductID	= $this->input->post('ProductID');
		$ProductName	= $this->input->post('ProductName');
		$ProductPrice	= $this->input->post('ProductPrice');
		$ProductNote	= $this->input->post('ProductNote'); 

		$data = array(
			'ProductID' => $ProductID,
			'ProductName' => $ProductName,
			'ProductPrice' => $ProductPrice,
			'ProductNote' => $ProductNote,  
			'InputDate' => date("Y-m-d H:i:s"),
			'InputBy' => $this->session->userdata('UserAccountID'),
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->insert('tb_product_main', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function product_edit()
	{
		$this->db->trans_start();

		$ProductID	= $this->input->post('ProductID');
		$ProductName	= $this->input->post('ProductName');
		$ProductPrice	= $this->input->post('ProductPrice');
		$ProductNote	= $this->input->post('ProductNote');

		$data = array(
			'ProductName' => $ProductName,
			'ProductPrice' => $ProductPrice,
			'ProductNote' => $ProductNote,  
			'ModifiedDate' => date("Y-m-d H:i:s"),
			'ModifiedBy' => $this->session->userdata('UserAccountID'),
		);
		$this->db->where('ProductID', $ProductID);
		$this->db->update('tb_product_main', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function get_product_detail()
	{
		$ProductID	= $this->input->post('ProductID'); 
		$sql 	= "select * from tb_product_main where ProductID=".$ProductID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    echo json_encode($show[0]);
	}
}
?>