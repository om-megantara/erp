<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth {

	function cek() 
	{
		$this->ci =& get_instance();

		$status = $this->ci->session->userdata('login_status');
		if (!empty($status)){
			$ForceLogOut_cek = $this->ForceLogOut_cek(); 
			if ($ForceLogOut_cek==0) {

			} else { 
				$cookie_value = $_SERVER['HTTP_REFERER'];
				$cookie_name = "referrer_value";
				setcookie($cookie_name, $cookie_value, time() + 86400, "/"); // 86400 = 1 day
				redirect(base_url('login'));
			}
		} else { 
			$cookie_value = $_SERVER['HTTP_REFERER'];
			$cookie_name = "referrer_value";
			setcookie($cookie_name, $cookie_value, time() + 86400, "/"); // 86400 = 1 day
			redirect(base_url('login'));
		}; 
	}

	function cek2($val) 
	{
		$this->ci =& get_instance();
		$status = $this->ci->session->userdata('MenuList');
		if (!empty($status)){
			if (in_array($val, $status)) {

			} else (redirect(base_url('main')));
		} else (redirect(base_url('main')));
	}

	function cek3()
	{
		$this->ci =& get_instance();
		$parts = parse_url( $_SERVER['HTTP_REFERER'] );
		if (isset($parts)) {
			if ( in_array( $parts['host'], array('ahz.anghauz.net','acz.anghauz.net', 'localhost', '192.168.88.249', '192.168.88.246') ) )
			{
					// $parts = parse_url( $_SERVER['HTTP_REFERER'] );
			  //       echo json_encode($parts);
			} 
			else ( redirect(base_url('main')) );
		}
	}

	function cek4($type)
	{
		$this->ci =& get_instance();
		if ($type == 'post') {
			$num = count( $this->ci->input->post() );
		} elseif ($type == 'get') {
			$num = count( $this->ci->input->get() );
		}

		if ( $num > 0 )	{
			// echo $num;
		} else ( redirect(base_url('main')) );
	}

	function cek5($val) 
	{
		$this->ci =& get_instance();
		$status = $this->ci->session->userdata('MenuList');
		if (!empty($status)){
			if (in_array($val, $status)) {
				return true;
			} else {
				return false;
			}
		} 
	}

	function ForceLogOut_cek(){
		$this->ci =& get_instance();
		$this->ci->load->model('model_main');
		$status = $this->ci->model_main->ForceLogOut_cek();
		return $status;
	}

}
?>