<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_instructor_report extends CI_Controller {


	public function index()
	{		
		$userdata = null;
		if( ! logged_in( $this, $userdata, array( 'write', 'admin') ) )
		{
			return;
		}
		
		$this->load->helper('url');		
		$this->load->helper('lambs');
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$this->performGet(  );
		}
		else {
			$this->performPost( $userdata );
		}
		

	}
	
	function performPost( $userdata )
	{		
		$date = $_POST[ 'date' ];
		
		if ( $date == 'yyyy-mm-dd' )
		{
			$data[ 'userdata' ] = $userdata;
			$this->load->view( 'welcome_message', $data );
			return;
		}
		
		if ( count( $_POST ) < 3 )
		{
			$this->showForm($date, 1, null, null );
			return;
		}	
		
		$instructor = $_POST[ "instructor" ];
		$course     = $_POST[ "course" ];
		$section    = $_POST[ "section" ];
		if ( isset($_POST[ 'mysubmit' ])  ) 
		{
			foreach($_POST as $key=>$value){
				if ( $key != 'id' && $key != 'mysubmit' ){
					$data[ $key ] = $value;
				}
			}
			$this->updateDb( $data );
			$this->showForm(  $_POST['date'], $section, $instructor, null );
			return;
		}
		
			
		if ( $_POST[ 'instructor' ] == EMPTY_SELECT_OPTION )
		{
			$this->showForm(  $_POST['date'], $section, null, null );
			return;
		}
		
		if ( $_POST[ 'course' ] == EMPTY_SELECT_OPTION )
		{
			$this->showForm(  $_POST['date'],$section, $instructor, null );
			return;
		}
		
		$this->showForm(  $_POST['date'],$section, $instructor, $course );
		
	}
	
	/**
	 * 
	 * @param unknown_type $data
	 */
	function updateDb( $data )
	{
		
		// get all instructor info
		$query = $this->db->get('instructor');
		$instructors[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION;
		foreach ($query->result() as $row)
		{
			$instuctorMap[ $row->First_Name.' '.$row->Last_Name ] = $row->id;
		}
		$instuctorMap[ null ] = "Unknown";
		$instuctorMap[ 0 ] = "Unknown";
		
		$query = $this->db->get('student');
		foreach ( $query->result() as $row)
		{
			$id = $row->id;
			
			// Check for required variables
			if (    strlen( $data[ "date" ] ) > 0
					#&& strlen( $data[ "timeIn_$id" ] ) > 0
					#&& strlen( $data[ "timeOut_$id" ] ) > 0
					&& strlen( $data[ "totalTime_$id" ] ) > 0
					&& strlen( $data[ "courseAllowEmpty_$id"] ) > 0
					&& strlen( $data[ "classNumber_$id"] ) > 0
					&& ( strpos( $data['instructor'], EMPTY_SELECT_OPTION ) === false ) )
			{
		
				// get the data to store
		
				$tempDbData[ 'Student_Id' ]  =$id;
				$tempDbData[ 'Date' ]      = $data[ "date" ];
				$tempDbData[ 'Section_Number' ]      = $data[ "section" ];
				$tempDbData[ 'Time_In' ]    = $data[ "timeIn_$id" ];
				$tempDbData[ 'Time_Out' ]   = $data[ "timeOut_$id" ];
				$tempDbData[ 'Total_Time' ] = $data[ "totalTime_$id" ];
				$tempDbData[ 'Instructor_Id' ] = $data['instructor'];
				if ( $data[ "courseAllowEmpty_$id" ] == EMPTY_SELECT_OPTION )
				{
					$tempDbData[ 'Course_Code' ]   = $data['course'];
				}
				else
				{
					$tempDbData[ 'Course_Code' ]   = $data[ "courseAllowEmpty_$id" ];
				}
				$tempDbData[ 'Class_Number' ]   = $data[ "classNumber_$id" ];
				$tempDbData[ 'Total_Time' ] = $this->roundTime($tempDbData[ 'Total_Time' ]);
		
				// set the where clause.
		
				$where[ 'Student_Id' ]     = $tempDbData[ 'Student_Id' ];
				$where[ 'Date' ]           = $tempDbData[ 'Date' ];
				$where[ 'Section_Number' ] = $tempDbData[ "Section_Number" ];
		//		$where[ 'Course_Code' ]    = $tempDbData[ 'Course_Code' ];
				$where[ 'Instructor_Id' ]  = $tempDbData[ 'Instructor_Id' ];
		
				// see if it exits.
		
				$result = $this->db->get_where(	'timeReport',  $where );
		
				if ( $result->num_rows() > 0 ) // perform database update
				{
					if ( $tempDbData[ 'Class_Number' ] == 0 ){
						$this->db->delete( 'timeReport',$where );
					}
					else 
					{
						$this->db->update(	'timeReport', $tempDbData, $where );
					}						
				}
				else
				{
					$this->db->insert(	'timeReport', $tempDbData );
				}
		
			}
		
		} // end if where we test for require variables
		
		// $this->showForm( $_POST['date'], null, null );
	}
	
	/**
	 * Round UP to nearest .5 hour
	 * 
	 * @param unknown_type $oldTime
	 * @return the rounded time
	 */
	function roundTime( $oldTime )
	{
		// ** Mangage the total time field **
		// 1st turn into a single decimal point
		$tempValue = (int) ($oldTime * 10);
		$newTime = $tempValue / 10;
		// now roung up to nearest 30 minutes
		if ( ($newTime * 10) % 5 != 0) // check for time ending in a .5 increment, if so do nothing
		{
			if ( $newTime * 10 % 5 > 5 ){
				$newTime =  + round( $newTime * 5 / 5 ); //round up to next .0 hour
			}
			else {
				$addCount = 5 - $newTime * 10 % 5; //round up to next .5 hour
				$newTime = $newTime + $addCount / 10;
			}
		}
		
		return $newTime;
	}
	
	/**
	 * 
	 * @param unknown_type $date
	 * @param unknown_type $section
	 * @param unknown_type $instructor may be null
	 * @param unknown_type $course may be null
	 */
	function showForm( $date, $section, $instructor, $course )
	{
			// get all student info			
		$query = $this->db->get('student');			
		$data[ 'date' ]       = $date;
		$data[ 'section' ]    = $section;
		$data[ 'students' ]   = $query;
		$data[ 'instructor' ] = $instructor;
		$data[ 'course' ]     = $course;
		
			// get all instructor info
		$query = $this->db->get('instructor');
		$instructors[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION;
		foreach ($query->result() as $row)
		{
			$instructors [ $row->id ] = $row->First_Name.' '.$row->Last_Name;
			$instuctorMap[ $row->id ] = $row->First_Name.' '.$row->Last_Name;
		}
		
		$data[ 'instructors' ] = $instructors;
		
			// get all course info
		$query = $this->db->get('course');
		$courses[ EMPTY_SELECT_OPTION ] = EMPTY_SELECT_OPTION; // TBD can we gaurantee this will always be the default?
		foreach ($query->result() as $row)
		{
			$courses [ $row->Course_Code ] = $row->Course_Code;
		}	
		$data[ 'courses' ] = $courses;
		
		$date[ 'date' ] = $date;
		
		// get existing time for student on this date.
		$existingTime = array();
		foreach ( $data[ 'students' ]->result() as $row ) 
		{		
			$where[ 'Student_Id' ] = $row->id;
			$where[ 'Date' ] = $date;
			$where[ 'Section_Number' ] = $section;
			
			if ( is_null( $instructor ) )
			{
				$where[ 'Instructor_Id' ] = null; // this will give an empty form
			}
			else {
				$where[ 'Instructor_Id' ] =  $instructor;
			}
			
			$query = $this->db->get_where( 'timeReport', $where );
			
			/**
			 * Problem is here if a student this handles the db having two courses for a student on this date, but the for only
			 * handles one!! FIXED WITH SECTION ???
			 */
			if ( $query->num_rows() > 0 )
			{
				$existingTime[ $row->id ] = $query->row_array();
			}
		}
		$data[ 'existingTime' ] = $existingTime;
		
		
		$this->load->view( 'daily_instructor_report_view', $data );
	}
	
	function performGet()
	{
		$url = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url['query'], $params);
		$course = EMPTY_SELECT_OPTION;
		
		$date       = $params[ 'date' ];
		$instructor = $params[ 'instructor' ];
		$section = $params[ 'section' ];
		
	//	$course      = $params[ 'course' ];

	//	if ( !is_null($date) && !is_null($instructor) && !is_null($course) )
	//	if ( !is_null($date) && !is_null($instructor) )
	///	{
			$this->showForm($date, $section, $instructor, $course );
//		return;
	//	}
	//	else {
	//		$this->load->view( 'daily_instructor_report_view', $data );
	//	}
	}
	
}