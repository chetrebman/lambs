<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_all extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
		
		// get all students
		$query = $this->db->get('student');		
		$data[ 'students' ] = $query;
		
		// get all course codes ie AM, BP, AP etc
		$query = $this->db->get('course');	
		foreach ($query->result() as $row)
		{
			$courseCodes[] = $row->Course_Code;
		}
		$data[ 'courseCodes' ] = $courseCodes;
		
		$this->load->view( 'student_all_view', $data );
	}
}
