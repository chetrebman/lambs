<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instructor_all extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
		
		$query = $this->db->get('instructor');
		
		$data[ 'instructor' ] = $query;
		
		$this->load->view( 'instructor_all_view', $data );
	}
}
