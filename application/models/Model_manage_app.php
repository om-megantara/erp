<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_manage_app extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->last_query = "";
    }
    
// manage_app ==============================================================
    function account_user()
	{
		$sql 	= "select * from tb_account_user";
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    return $show;
	}
	function account_user_add_act()
	{
		$this->db->trans_start();

		$name	= $this->input->post('name');
		$email	= $this->input->post('email');
		$login	= $this->input->post('login');
		$password	= $this->input->post('password');
		$menu	= $this->input->post('menu');
		$menu_full = implode(',', $menu);
 
		$data = array(
			'UserFullName' => $name,
			'UserName' => $login,
			'UserPass' => md5($password),
			'UserEmail' => $email,
			'UserMenu' => $menu_full,
		);
		$this->db->insert('tb_account_user', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
		
	} 
	function account_user_edit_act()
	{
		$this->db->trans_start();

		$userid	= $this->input->post('userid');
		$name	= $this->input->post('name');
		$email	= $this->input->post('email');
		$login	= $this->input->post('login');
		$password	= $this->input->post('password');
		$status	= $this->input->post('status');
		$menu	= $this->input->post('menu');
		$menu_full = implode(',', $menu);
 
		$data = array(
			'UserFullName' => $name,
			'UserName' => $login,
			'UserEmail' => $email,
			'UserMenu' => $menu_full,
			'isActive' => $status,
		);
		if ($password != '') {
			$data['UserPass'] = md5($password);
		}

		$this->db->where('UserID', $userid);
		$this->db->update('tb_account_user', $data);
		$this->last_query .= "//".$this->db->last_query();
 
	    $this->log_user->log_query($this->last_query);
	    $this->db->trans_complete();
	} 
	function get_account_user_detail()
	{
		$this->db->trans_start();

		$UserID	= $this->input->post('userid'); 
		$sql 	= "select * from tb_account_user where UserID=".$UserID;
		$query 	= $this->db->query($sql);
		$show   = $query->result_array();
	    echo json_encode($show[0]);
	} 

// -------------------------------------------------------------------------
	function menu_list($parent=0, $menu_tree_array = array(), $level=0)
	{
		$sql 	= "select * from tb_menu_main where MenuParent='".$parent."' ORDER by MenuID";
		$query 	= $this->db->query($sql);
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			foreach ($query->result() as $row) {
				$menu_tree_array[] = array( 
					'MenuID' => $row->MenuID,
					'MenuParent' => $row->MenuParent,
					'MenuCode' => $row->MenuCode,
					'MenuNote' => $row->MenuNote,
					'Menulevel' => $level,
				);
		      	$menu_tree_array = $this->menu_list($row->MenuID, $menu_tree_array, $level+1);
			};
		}
		return $menu_tree_array;
	}
}
?>