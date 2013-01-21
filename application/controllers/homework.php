<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homework extends CI_Controller {
	
	
	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, array( 'write', 'admin') ) )
		{
			return;
		}
		
		$this->load->helper('url');
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$this->performGet();
		}
		else {
			$this->performPost();
		}
	}
	
	function performPost()
	{
		$this->load->helper('lambs');
		
		foreach($_POST as $key=>$value){
			if ( $key != 'id' && $key != 'mysubmit' ){
				$data[ $key ] = $value;
			}
		}
		
		$insertedNewData = false;
		for ( $i=0; $i<15; $i++ ) 
		{
			if ( strlen( $data[ "points_$i" ] ) > 0 && strlen( $data["homeworkNumber_$i"] ) > 0  && strlen( $data["points_$i"] ) > 0 ) {
				
					// get the data to store
					
				$tempDbData[ 'Student_Id' ] = $data[ 'studentId' ];
				$tempDbData[ 'Date' ]      = $data[ 'date' ];
				$tempDbData[ 'Section_Number' ] = $data[ 'section' ];
				$tempDbData[ 'Course_Code' ]   = $data[ "course_$i" ];
				$tempDbData[ 'Homework_Type' ]   = $data[ "homeworkType_$i" ];
				$tempDbData[ 'Homework_Number' ] = $data[ "homeworkNumber_$i" ];
				$tempDbData[ 'Points' ] = $data[ "points_$i" ];
				$tempDbData[ 'Instructor_Id' ] = $data[ 'instructorId' ];
				
				if ( strpos( $tempDbData[ 'Instructor_Id'] , EMPTY_SELECT_OPTION ) !== false )
				{
					$tempDbData[ 'Instructor_Id'] = UNKNOWN_INSTRUCTOR;
				}
				
					// set the where clause.
					
				$where[ 'Student_Id' ]      = $tempDbData[ 'Student_Id' ];
			//	$where[ 'Date' ]           = $tempDbData[ 'Date' ];
				$where[ 'Course_Code' ]         = $tempDbData[ 'Course_Code' ];
				$where[ 'Homework_Type' ]   = $tempDbData[ 'Homework_Type' ];
				$where[ 'Homework_Number' ] = $tempDbData[ 'Homework_Number' ];
			//	$where[ 'Instructor_Id' ]  = $tempDbData[ 'Instructor_Id' ];
				
					// see if it exits.
					
				$result = $this->db->get_where(	'homeworkReport',  $where );
				
				if ( $result->num_rows() > 0 )
				{
					if ( $tempDbData[ 'Points' ] > 0 )
					{
						$this->db->update(	'homeworkReport', $tempDbData, $where );
					}
					else 
					{
						$this->db->delete( 'homeworkReport', $where );
					}
					
					$insertedNewData = false;
				}
				else 
				{
					if ( $tempDbData[ 'Points' ] > 0 ) 
					{
						$this->db->insert(	'homeworkReport', $tempDbData, $where );
						$insertedNewData = true;
					}
				}
				
			}
		}
		
		if ( $insertedNewData ) {
			//$this->load->view( 'daily_instructor_report_view', null );
			$this->showHomeworkPage( $_POST['studentId'], $_POST['date'], $_POST['section'], $_POST['instructorId'] );
			return;
		}
		
		$this->showHomeworkPage( $_POST['studentId'], $_POST['date'], $_POST['section'], $_POST['instructorId'] );
	} 
	
	function performGet()
	{
		$url = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url['query'], $params);
		
		$studentId    = $params[ 'studentId' ];
		$date         = $params[ 'date' ];
		$section         = $params[ 'section' ];
		$instructorId = $params[ 'instructorId' ];
		
		$this->showHomeworkPage( $studentId, $date, $section, $instructorId );
	}
	
	public function showHomeworkPage( $studentId, $date, $section, $instructorId )
	{	
		$data[ 'date' ]     = $date;
		$data[ 'section' ]  = $section;
		$data[ 'studentId' ]= $studentId;
		$data[ 'instructorId' ] = $instructorId;
		
		$this->load->helper('lambs');
		
			// get current student name
		$query = $this->db->get_where('student', array('id' => $studentId));
		$tempRow = $query->row_array();
		$studentName = $tempRow[ 'First_Name' ]." ".$tempRow[ 'Last_Name' ];
		$data[ 'studentName' ] = $studentName;
		
			// get all student info
			
		$query = $this->db->get('student');
		
		$data[ 'students' ] = $query;
		
		// get all instructor info
		$query = $this->db->get('instructor');
		$instructors[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION;
		foreach ($query->result() as $row)
		{
			if ( $row->id == $instructorId )
			{
				$data[ 'instructorName' ] = $row->First_Name.' '.$row->Last_Name;
			}
		}
		
			// get all course info
			
		$query = $this->db->get('course');
		$courses_allow_empty[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION; 
		foreach ($query->result() as $row)
		{
			$courses_allow_empty [ $row->Course_Code ] = $row->Course_Code;
		//	$courses [ $row->Course_Code ] = $row->Course_Code;
		}
		// $data[ 'course' ] = $courses;
		$data[ 'course' ] = $courses_allow_empty;
		
			// get existing homework for student on this date.
		
		$where[ 'Student_Id' ] = $studentId;
		$where[ 'Date' ] = $date;
		$where[ 'Section_Number' ] = $section;
		$query = $this->db->get_where( 'homeworkReport', $where );
		
		$data[ 'existingHomework' ] = $query->result_array();
		
		$homeworkType[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION;
		$homeworkType[ 'Homework'] = 'Homework';
		$homeworkType[ 'Quiz'] = 'Quiz';
		$homeworkType[ 'Test'] = 'Test';
		$homeworkType[ 'Extra_Credit'] = 'Extra Credit';
		$homeworkType[ 'Written_Final'] = 'Written Final';
		$homeworkType[ 'Practicum_Final'] = 'Practicum Final';
		$homeworkType[ 'Project'] = 'Project';
		
		$data[ 'homeworkType' ] = $homeworkType;
		
		
		$this->load->view( 'homework_view', $data );
	}
}