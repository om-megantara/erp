<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class model_project extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
        $ReportResult = $this->session->userdata('ReportResult');
        $this->limit_result = isset($ReportResult) ? $ReportResult : 100;
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