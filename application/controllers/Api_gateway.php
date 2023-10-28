<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Methods: POST, OPTIONS");

class api_gateway extends CI_Controller {
	public function __construct()
    {
	    parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('model_api_gateway'); 
	}

	public function index()
	{
        echo "Under Development!";
	}
	public function get_product_category()
	{
        $result = $this->model_api_gateway->get_product_category();
        echo json_encode($result);
	}
	public function get_product_list()
	{
        $result = $this->model_api_gateway->get_product_list();
        echo json_encode($result);
	}
	public function get_price_list()
	{
        $result = $this->model_api_gateway->get_price_list();
        echo json_encode($result);
	}
	public function get_product_detail()
	{
        $result = $this->model_api_gateway->get_product_detail();
        echo json_encode($result);
	}
}