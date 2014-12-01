<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_all extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, null ) )
		{
			return;
		}
		
		//12-1-4
		$statusSelect = "1";
		$query = $this->db->get('status');
		foreach ($query->result() as $row)
		{
			$statusMap[ $row->id ] = $row->studentStatus;
		}

		//12-1-14
		$data[ 'statusMap' ]    = $statusMap;
		$data[ 'statusSelect' ] = $statusSelect;
		
		// get all course codes ie AM, BP, AP etc
		$query = $this->db->get('course');	
		foreach ($query->result() as $row)
		{
			$courseCodes[] = $row->Course_Code;
		}
		$data[ 'courseCodes' ] = $courseCodes;
		
		// 12-1-14
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			return $this->performPost( $data );
		}

		// get all students
		$this->db->order_by("last_name");
		$query = $this->db->get('student');
		$data[ 'students' ] = $query;
			
		$this->load->view( 'student_all_view', $data );
	}
	
		// 12-1-14
	/**
	 * This is called when a user changes the student status select list.
	 * 
	 * test git hub
	 * 
	 * @param unknown $data
	 */
	function performPost( $data )
	{
		$statusSelect = $_POST[ 'status' ];
		
		$data[ 'statusSelect' ] = $statusSelect;
		
		// get all students

		$this->db->where( "status", $statusSelect );
		$this->db->order_by("last_name");
		$query = $this->db->get('student');
		$data[ 'students' ] = $query;
		
		$this->load->view( 'student_all_view', $data );
	}
}
