<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Welcome extends CI_Controller {


	public function index()
	{
		$userdata = null;
		if( ! logged_in( $this, $userdata, null) )
		{
			return;
		}
		
		$data[ 'userdata' ] = $userdata;
		$this->load->view('welcome_message', $data);
	}
	
	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */