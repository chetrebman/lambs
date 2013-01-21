<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class User_admin extends CI_Controller {


	public function index()
	{	
		// 0d107d09f5bbe40cade3de5c71e9e9b7  letmein
		
		$userdata = null;
		if( ! logged_in( $this, $userdata, array( 'admin' ) ) )
		{
			return;
		}

		$data['userdata'] = $userdata;

		// set roles info
		$all_roles['read'] = "read";
		$all_roles['write'] = "write";
		$all_roles['admin'] = "admin";
		$data['all_roles']=$all_roles;
		
		// get all user info
		$query = $this->db->get( 'users' );
		$data['all_users'] = $query;
		$num_users = $query->num_rows();
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			$this->load->view('user_admin_view', $data );
			return;
		}
		
		if ( isset ($_POST['update_user_submit'] ))
		{
			for ( $count=1; $count<$num_users+1; $count++ )
			{
				$updateData = null;
				$where      = null;
				$updateData[ 'role' ]= $_POST[ "role_$count" ];
				$where['username'] = $_POST[ "username_$count" ];
				if ( isset( $_POST["deleteUser_$count"] ))
				{
					$where = null;
					$where['username'] = $_POST[ "deleteUser_$count" ];
					$this->db->delete('users', $where );
				}
				else {
					$this->db->update('users', $updateData, $where );
				}
				
			}
		}
		

		if ( isset ($_POST['add_user_submit'] ))
		{
			$new_pwd_1    =  $_POST['newPwd_1'];
			$new_pwd_2    =  $_POST['newPwd_2'];
		
			if ( strcmp( $new_pwd_1, $new_pwd_2 ) != 0 )
			{
				$data[ 'error_msg' ] ="Passwords do not match!";
				$this->load->view('user_admin_view', $data);
				return;
			};	

			$insertData = null;
			$insertData[ 'username' ] = $_POST['newUser'];
			$insertData[ 'role' ]     = $_POST['newRole'];
			$insertData[ 'password' ] = MD5($new_pwd_1);
			
			$this->db->insert( 'users', $insertData );
		}
		

		//	$this->load->view('welcome_message', $data );
		$this->load->view('user_admin_view', $data );
	}
	
	
}
