<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_user {

	function log_page() 
	{
		$this->ci =& get_instance();
		$DateTime = date("Y-m-d H:i:s");
	    $page = base_url(uri_string());
		if (substr($page, -5) == '/main') {
			$this->ci->session->set_userdata('LoginTime', $DateTime);
		}

		$UserAccountID = $this->ci->session->userdata('UserAccountID');
		$LoginTime = $this->ci->session->userdata('LoginTime');

		if ($this->ci->session->has_userdata('LoginTime')) {
			$data = array(
		        'UserAccountID' => $UserAccountID,
		        'DateTime' => $DateTime,
		        'Page' => $page,
		        'LoginTime' => $LoginTime,
			);
			$url 	= explode('/', $data['Page']);
			$dont 	= array('checkAlive','stillAlive','userlive','home_dashboard');
			$result = array_intersect($dont, $url);
			if ( empty($result) )	{
				$this->ci->db->insert('tb_history_user_page', $data);
			};
		} else {
			redirect(base_url('main'));
		}
	}

	function log_query($query)
	{
		$this->ci =& get_instance();
		if ($query != "") {
			$UserAccountID = $this->ci->session->userdata('UserAccountID');
			$DateTime = date("Y-m-d H:i:s");
			$data = array(
		        'UserAccountID' => $UserAccountID,
		        'DateTime' => $DateTime,
		        'Query' => $query
			);
			$this->ci->db->insert('tb_history_user_query', $data);
		}
	}

}
?>