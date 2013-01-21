<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_all extends CI_Controller {


	public function index()
	{	
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
		
		$query = $this->db->get('course');	
		$data[ 'course' ] = $query;
		
		$this->load->view( 'course_all_view', $data );
	}
}
