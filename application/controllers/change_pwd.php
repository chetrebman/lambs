<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Change_pwd extends CI_Controller {


	public function index()
	{	
		// 0d107d09f5bbe40cade3de5c71e9e9b7  letmein
		
		$userdata = null;
		if( ! logged_in( $this, $userdata, array('write', 'admin') ) )
		{
			return;
		}
		
		$data['userdata'] = $userdata;
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			$this->load->view('change_pwd_view', $data );
			return;
		}
		
		
		
		$where[ 'username' ] = $_POST['username'];
		$query = $this->db->get_where( 'users', $where );
		$userDbData = $query->row_array();
		
		$md5Password = $userDbData[ 'password' ];
		$old_pwd =  $_POST['oldPwd'];
		
		$old_pwd_md5 = $str = MD5($old_pwd);
		if ( strcmp( $md5Password, $old_pwd_md5) != 0 )
		{
			$data[ 'error_msg' ] = "Incorect OLD password";
			$this->load->view('change_pwd_view', $data);
			return;
		}
		
		$new_pwd_1    =  $_POST['newPwd_1'];
		$new_pwd_2    =  $_POST['newPwd_2'];
		
		if ( strcmp( $new_pwd_1, $new_pwd_2 ) != 0 )
		{
			$data[ 'error_msg' ] ="Passwords do not match!";
			$this->load->view('change_pwd_view', $data);
			return;
		}
	
		$ID = $userDbData['id'];
		unset( $userDbData['id']);
		$userDbData[ 'password' ] = MD5( $new_pwd_1 ); 
		$this->db->update('users', $userDbData, "id = ".$ID);

		$this->load->view('welcome_message', $data );
	}
	
	
}
